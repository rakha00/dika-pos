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
        $this->orderList = Transaction::withSum('detailTransactions as total_items', 'quantity')
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('components.dashboard.order-list');
    }
}
