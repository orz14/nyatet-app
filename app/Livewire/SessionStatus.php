<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class SessionStatus extends Component
{
    public function render()
    {
        return view('livewire.session-status');
    }

    #[On('nyatetError')]
    public function nyatetError()
    {
        session()->flash('toastErr', '[500] Server Error');

        return $this->redirect(url()->previous(), navigate: true);
    }

    #[On('nyatetNotMine')]
    public function nyatetNotMine()
    {
        session()->flash('toastErr', 'Anda Tidak Memiliki Akses.');

        return $this->redirect(url()->previous(), navigate: true);
    }
}
