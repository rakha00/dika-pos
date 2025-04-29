<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class HistoryOrder extends Component
{
    public $transactions = [];
    public $transaction;
    public $showModal = false;

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
    
    public function showDetail($id)
    {
        $this->transaction = Transaction::with([
            'details.menu',
            'details.detailCustomOptions.customOptionValue.customOption',
        ])->find($id);

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('components.history.history-transaction');
    }
}
