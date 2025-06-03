<?php

namespace App\Livewire;

use App\Models\Transaction;
use Livewire\Component;

class KitchenOrder extends Component
{
    public $orders;
    public $selectedOrderId;
    public $selectedTransactionId;
    public $isConfirmModalOpen;
    public $isCancelModalOpen;


    public function mount()
    {
        $this->orders = Transaction::whereNotIn('status', ['completed', 'cancelled'])->latest()->get();
    }

    public function completeOrder($orderId)
    {
        $order = Transaction::findOrFail($orderId);
        $order->status = 'completed';
        $order->save();
        $this->orders = Transaction::whereNotIn('status', ['completed', 'cancelled'])->latest()->get();
        $this->isConfirmModalOpen = false;
    }

    public function cancelOrder($orderId)
    {
        $order = Transaction::findOrFail($orderId);
        $order->status = 'cancelled';
        $order->save();
        $this->orders = Transaction::whereNotIn('status', ['completed', 'cancelled'])->latest()->get();
        $this->isCancelModalOpen = false;
    }

    public function showConfirmModal($orderId)
    {
        $this->selectedOrderId = $orderId;
        $this->selectedTransactionId = Transaction::findOrFail($orderId)->transaction_id;
        $this->isConfirmModalOpen = true;

    }
    public function showCancelModal($orderId)
    {
        $this->selectedOrderId = $orderId;
        $this->selectedTransactionId = Transaction::findOrFail($orderId)->transaction_id;
        $this->isCancelModalOpen = true;
    }

    public function hideModal()
    {
        $this->isConfirmModalOpen = false;
        $this->isCancelModalOpen = false;
        $this->selectedOrderId = null;
        $this->selectedTransactionId = null;
    }

    public function render()
    {
        return view('components.kitchen.kitchen-order');
    }
}
