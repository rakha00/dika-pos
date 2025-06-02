<?php

namespace App\Livewire;

use App\Models\DetailTransaction;
use App\Models\Transaction;
use Livewire\Component;

class OrderList extends Component
{
    public $orderList;
    public $itemsCount;

    public function mount()
    {
        $this->orderList = Transaction::all();
        $this->itemsCount = [];
        foreach ($this->orderList as $order) {
            $this->itemsCount[$order->id] = DetailTransaction::where('transaction_id', $order->id)->sum('quantity');
        }
    }

    public function render()
    {
        return view('components.dashboard.order-list');
    }
}
