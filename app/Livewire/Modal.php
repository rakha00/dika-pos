<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Modal extends Component
{
    public $isOpen = false;

    // Untuk membuka modal
    public function openModal()
    {
        $this->isOpen = true;
    }

    // Untuk menutup modal
    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.modal');
    }
}
