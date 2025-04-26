<?php

namespace App\Livewire;

use App\Models\Transaction;
use Livewire\Component;

class KitchenOrder extends Component
{
    public $orders;

    public function mount()
    {
        $this->orders = Transaction::where('status', '!=', 'completed')->latest()->get();
    }

    public function completeOrder($orderId)
    {
        $order = Transaction::findOrFail($orderId);
        $order->status = 'completed';
        $order->save();
        $this->orders = Transaction::where('status', '!=', 'completed')->latest()->get();
    }

    public function render()
    {
        return view('components.kitchen.kitchen-order');
    }
}
