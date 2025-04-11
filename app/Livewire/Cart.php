<?php

namespace App\Livewire;

use App\Models\DetailTransaction;
use App\Models\Menu;
use App\Models\Transaction;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;

class Cart extends Component
{
    public $customerName;
    public $orderItems = [];
    public $totalPrice;

    public function mount()
    {
        $this->orderItems;
    }

    #[On('decrement-quantity')]
    public function decrementQuantity(int $itemId)
    {
        $menu = Menu::find($itemId);
        if (!$menu)
            return;

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
    public function incrementQuantity(int $itemId)
    {
        $menu = Menu::find($itemId);
        if (!$menu)
            return;

        // Check if item already exists in cart
        $itemKey = $this->findItemKey($itemId);

        if ($itemKey !== false) {
            // Increment quantity if item exists
            $this->orderItems[$itemKey]['quantity']++;
        } else {
            // Add new item to cart
            $this->orderItems[] = [
                'id' => $menu->id,
                'name' => $menu->name,
                'price' => $menu->price,
                'quantity' => 1,
                'image' => $menu->image,
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
            ]);
        }
    }

    public function render()
    {
        return view('components.order.cart');
    }
}
