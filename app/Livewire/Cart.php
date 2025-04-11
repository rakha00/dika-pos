<?php

namespace App\Livewire;

use App\Models\Menu;
use Livewire\Attributes\On;
use Livewire\Component;

class Cart extends Component
{
    public $OrderItems = [];

    public function mount()
    {
        $this->OrderItems;
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
            if ($this->OrderItems[$itemKey]['quantity'] <= 1) {
                array_splice($this->OrderItems, $itemKey, 1);
            } else {
                // Otherwise decrease quantity
                $this->OrderItems[$itemKey]['quantity']--;
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
            $this->OrderItems[$itemKey]['quantity']++;
        } else {
            // Add new item to cart
            $this->OrderItems[] = [
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
        foreach ($this->OrderItems as $key => $item) {
            if (isset($item['id']) && $item['id'] == $itemId) {
                return $key;
            }
        }
        return false;
    }

    public function render()
    {
        return view('components.order.cart');
    }
}
