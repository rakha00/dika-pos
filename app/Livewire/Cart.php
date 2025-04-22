<?php

namespace App\Livewire;

use App\Models\DetailTransaction;
use App\Models\Menu;
use App\Models\Transaction;
use Livewire\Attributes\On;
use Livewire\Component;

class Cart extends Component
{
    public $customerName;
    public $orderItems = [];
    public $totalPrice;
    public $selectedOption = [];
    public $currentItemName;
    public $isModalOpen = false;
    public $currentItemId;
    public $customOptions = [];

    public function mount()
    {
        $this->orderItems = [];  // Initialize the orderItems array
        $this->totalPrice = 0;   // Initialize totalPrice
    }

    #[On('decrement-quantity')]
    public function decrementQuantity(int $itemId)
    {
        $menu = Menu::find($itemId);
        if (!$menu) return;

        // Check if item already exists in cart
        $itemKey = $this->findItemKey($itemId);

        if ($itemKey !== false) {
            // If quantity is 1, remove the item
            if ($this->orderItems[$itemKey]['quantity'] <= 1) {
                array_splice($this->orderItems, $itemKey, 1);
            } else {
                // Otherwise decrease quantity
                $this->orderItems[$itemKey]['quantity']--;
            }
        }
    }

    #[On('increment-quantity')]
    public function incrementQuantity(int $itemId, $customOptions = null)
    {
        $menu = Menu::find($itemId);
        if (!$menu) return;

        // Check if item already exists in cart
        $itemKey = $this->findItemKey($itemId);

        if ($itemKey !== false) {
            // Update custom options if provided
            if ($customOptions) {
                $this->orderItems[$itemKey]['customOptions'] = $customOptions;
            }
            $this->orderItems[$itemKey]['quantity']++;
        } else {
            // Add new item to cart with custom options if provided
            $this->orderItems[] = [
                'id' => $menu->id,
                'name' => $menu->name,
                'price' => $menu->price,
                'quantity' => 1,
                'image' => $menu->image,
                'is_customizable' => $menu->is_customizable,
                'customOptions' => $customOptions ?? [], // Add custom options if available
            ];
        }
    }

    private function findItemKey(int $itemId)
    {
        foreach ($this->orderItems as $key => $item) {
            if (isset($item['id']) && $item['id'] == $itemId) {
                return $key;
            }
        }
        return false;
    }

    public function generateTransactionId()
    {
        $today = date('Y-m-d');
        $latestTransaction = Transaction::whereDate('created_at', $today)
            ->latest()
            ->first();

        if ($latestTransaction) {
            $lastId = $latestTransaction->id_transaction;
            $numericPart = (int) substr($lastId, 1);
            $newNumericPart = $numericPart + 1;
        } else {
            $newNumericPart = 1;
        }

        return '#' . str_pad($newNumericPart, 3, '0', STR_PAD_LEFT);
    }

    public function processTransaction()
    {
        $totalPrice = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $this->orderItems)) * 1.1;
        $transaction = Transaction::create([
            'id_user' => auth()->id(),
            'id_transaction' => $this->generateTransactionId(),
            'customer_name' => $this->customerName,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        foreach ($this->orderItems as $item) {
            DetailTransaction::create([
                'id_transaction' => $transaction->id,
                'id_menu' => $item['id'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['price'] * $item['quantity'],
                'custom_options' => json_encode($item['customOptions']), // Simpan semua pilihan custom options
            ]);
        }

        // Clear cart after transaction
        $this->orderItems = [];
        $this->customerName = '';
    }

    public function getCurrentItemNameProperty()
    {
        $item = collect($this->orderItems)->firstWhere('id', $this->currentItemId);
        return $item['name'] ?? 'Menu';
    }

    public function addCustomOptions(int $itemId)
    {
        $itemKey = $this->findItemKey($itemId);

        if ($itemKey !== false) {
            // Hitung tambahan harga dari selectedOption
            $additionalPrice = \App\Models\CustomOptionValue::whereIn('id', $this->selectedOption)->sum('additional_price');

            $basePrice = Menu::find($itemId)->price;
            $newPrice = $basePrice + $additionalPrice;

            // Update custom options dan harga baru
            $this->orderItems[$itemKey]['customOptions'] = $this->selectedOption;
            $this->orderItems[$itemKey]['price'] = $newPrice;
        }

        $this->isModalOpen = false;
    }

    public function showCustomizeModal($itemId)
    {
        $this->isModalOpen = true;
        $this->currentItemId = $itemId;

        $menu = Menu::with('customOptions.customOptionValues')->find($itemId);

        if ($menu && $menu->is_customizable) {
            $this->customOptions = $menu->customOptions;
        }

        // Ambil custom_option_value yang sudah dipilih, jika ada
        $itemKey = $this->findItemKey($itemId);
        if ($itemKey !== false && isset($this->orderItems[$itemKey]['customOptions'])) {
            $this->selectedOption = $this->orderItems[$itemKey]['customOptions'];
        } else {
            $this->selectedOption = [];  // Reset jika tidak ada pilihan
        }
    }


    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->currentItemId = null;
        $this->currentItemName = '';
        $this->selectedOption = '';
    }

    public function render()
    {
        return view('components.order.cart', [
            'orderItems' => $this->orderItems
        ]);
    }
}
