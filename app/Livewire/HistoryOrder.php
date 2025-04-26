<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;

class HistoryOrder extends Component
{
    public $transactions;
    public $transaction;
    public $showModal = false;

    public function mount()
    {
        $this->transactions = Transaction::where('user_id', '1')->latest()->get();
    }

    public function showDetail($id)
    {
        $this->transaction = Transaction::find($id);
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
