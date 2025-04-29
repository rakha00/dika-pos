<?php

namespace App\Livewire;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public $transactions;
    
    public function mount()
    {
        $this->transactions = Transaction::with([
            'details.menu',
            'details.detailCustomOptions.customOptionValue.customOptionValues'
        ])
            ->where('id_user', Auth::id())
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('components.order.order-list');
    }
}
