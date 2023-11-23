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

    public function sessionStatus($msg)
    {
        session()->flash('toastErr', $msg);

        return $this->redirect(url()->previous(), navigate: true);
    }

    #[On('nyatetError')]
    public function nyatetError()
    {
        return $this->sessionStatus('[500] Server Error');
    }

    #[On('nyatetNotMine')]
    public function nyatetNotMine()
    {
        return $this->sessionStatus('Anda Tidak Memiliki Akses.');
    }
}
