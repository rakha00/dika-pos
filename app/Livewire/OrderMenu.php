<?php

namespace App\Livewire;

use App\Models\Menu;
use Livewire\Attributes\On;
use Livewire\Component;

class OrderMenu extends Component
{

    public $menuItems;
    public $categories;
    public $selectedCategory;
    public $quantities = [];

    public function mount()
    {
        $this->selectedCategory = Menu::distinct('category')->first()->category;
        $this->categories = Menu::distinct('category')->pluck('category')->toArray();
        $this->menuItems = Menu::where('category', $this->selectedCategory)->get();
    }

    public function updatedSelectedCategory()
    {
        $this->menuItems = Menu::where('category', $this->selectedCategory)->get();
    }

    #[On('decrement-quantity')]
    public function decrementQuantity(int $itemId)
    {
        if (isset($this->quantities[$itemId]) && $this->quantities[$itemId] > 0) {
            $this->quantities[$itemId]--;
        }
    }

    #[On('increment-quantity')]
    public function incrementQuantity(int $itemId)
    {
        if (!isset($this->quantities[$itemId])) {
            $this->quantities[$itemId] = 0;
        }
        $this->quantities[$itemId]++;
    }

    public function render()
    {
        return view('components.order.order-menu');
    }
}
