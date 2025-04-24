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

        $normalizedOptions = is_array($customOptions) ? array_map('strval', $customOptions) : [];
        ksort($normalizedOptions);

        // Kalau menu bisa dicustom dan tidak ada opsi yang dikirim, anggap item baru
        if ($menu->is_customizable && empty($normalizedOptions)) {
            $additionalPrice = 0;
            $this->orderItems[] = [
                'id' => $menu->id,
                'name' => $menu->name,
                'price' => $menu->price + $additionalPrice,
                'quantity' => 1,
                'image' => $menu->image,
                'is_customizable' => $menu->is_customizable,
                'customOptions' => [], // kosong
            ];
            return;
        }

        $itemKey = $this->findItemKey($itemId, $normalizedOptions);

        if ($itemKey !== false) {
            $this->orderItems[$itemKey]['quantity']++;
        } else {
            $additionalPrice = \App\Models\CustomOptionValue::whereIn('id', $normalizedOptions)->sum('additional_price');
            $newPrice = $menu->price + $additionalPrice;

            $this->orderItems[] = [
                'id' => $menu->id,
                'name' => $menu->name,
                'price' => $newPrice,
                'quantity' => 1,
                'image' => $menu->image,
                'is_customizable' => $menu->is_customizable,
                'customOptions' => $normalizedOptions,
            ];
        }
    }

    private function findItemKey(int $itemId, $customOptions = null)
    {
        $normalizedIncoming = is_array($customOptions) ? $customOptions : [];
        ksort($normalizedIncoming);

        foreach ($this->orderItems as $key => $item) {
            $normalizedStored = is_array($item['customOptions']) ? $item['customOptions'] : [];
            ksort($normalizedStored);


            if (
                isset($item['id']) && $item['id'] == $itemId &&
                $normalizedStored == $normalizedIncoming
            ) {
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
        $optionIds = collect($this->selectedOption)->values()->map(fn($id) => (string) $id)->toArray();
        ksort($optionIds);

        $menu = Menu::find($itemId);
        $additionalPrice = \App\Models\CustomOptionValue::whereIn('id', $optionIds)->sum('additional_price');
        $newPrice = $menu->price + $additionalPrice;

        $newItemKey = $this->findItemKey($itemId, $optionIds);

        // Kalau item custom yang sama udah ada, tambahkan quantity-nya
        if ($newItemKey !== false) {
            $this->orderItems[$newItemKey]['quantity']++;

            // Jika yang ditemukan berbeda dengan original item, hapus original
            if ($this->originalItemKey !== null && $this->originalItemKey !== $newItemKey) {
                array_splice($this->orderItems, $this->originalItemKey, 1);
            }
        } else {
            // Kalau original item ada, replace dia dengan custom
            if ($this->originalItemKey !== null && isset($this->orderItems[$this->originalItemKey])) {
                $this->orderItems[$this->originalItemKey] = [
                    'id' => $menu->id,
                    'name' => $menu->name,
                    'price' => $newPrice,
                    'quantity' => 1,
                    'image' => $menu->image,
                    'is_customizable' => $menu->is_customizable,
                    'customOptions' => $optionIds,
                ];
            } else {
                $this->orderItems[] = [
                    'id' => $menu->id,
                    'name' => $menu->name,
                    'price' => $newPrice,
                    'quantity' => 1,
                    'image' => $menu->image,
                    'is_customizable' => $menu->is_customizable,
                    'customOptions' => $optionIds,
                ];
            }
        }

        $this->isModalOpen = false;
        $this->selectedOption = [];
        $this->originalItemKey = null;
    }

    public $originalItemKey;

    public function showCustomizeModal($itemId)
    {
        $this->isModalOpen = true;
        $this->currentItemId = $itemId;

        $menu = Menu::with('customOptions.customOptionValues')->find($itemId);
        if ($menu && $menu->is_customizable) {
            $this->customOptions = $menu->customOptions;
        }

        $this->originalItemKey = $this->findItemKey($itemId); // Simpan itemKey awal
        if ($this->originalItemKey !== false && isset($this->orderItems[$this->originalItemKey]['customOptions'])) {
            $this->selectedOption = $this->orderItems[$this->originalItemKey]['customOptions'];
        } else {
            $this->selectedOption = [];
        }
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->currentItemId = null;
        $this->currentItemName = '';
        $this->selectedOption = '';
        $this->originalItemKey = null;
    }

    public function render()
    {
        return view('components.order.cart', [
            'orderItems' => $this->orderItems
        ]);
    }
}
