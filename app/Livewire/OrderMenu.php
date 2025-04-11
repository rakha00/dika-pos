<?php

namespace App\Livewire;

use App\Models\Menu;
use Barryvdh\Debugbar\Facades\Debugbar;
use Livewire\Component;

class OrderMenu extends Component
{

    public $menuItems;
    public $selectedCategory = 'makanan';

    public function mount()
    {
        $this->menuItems = Menu::where('kategori', $this->selectedCategory)->get();
    }

    public function updated($selectedCategory)
    {
        $this->menuItems = Menu::where('kategori', $this->$selectedCategory)->get();
    }

    public function render()
    {
        return view('components.dashboard.order-menu');
    }
}
