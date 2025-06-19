<?php

namespace App\Livewire;

use App\Models\Transaction;
use Carbon\Carbon;
use Livewire\Component;

class Stats extends Component
{
    public $revenueToday;
    public $transactionsToday;
    public $itemsSoldToday;

    public function mount()
    {
        $today = Carbon::today();

        $this->revenueToday = Transaction::whereDate('created_at', $today)
            ->where('status', 'completed')
            ->sum('total_price');

        $this->transactionsToday = Transaction::whereDate('created_at', $today)
            ->where('status', 'completed')
            ->count();

        $this->itemsSoldToday = Transaction::whereDate('created_at', $today)
            ->where('status', 'completed')
            ->withSum('detailTransactions as total_items', 'quantity')
            ->get()
            ->sum('total_items');
    }

    public function render()
    {
        return view('components.dashboard.stats');
    }
}
