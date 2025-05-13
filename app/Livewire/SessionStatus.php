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
        flash(__($msg), 'err');

        return $this->redirect(url()->previous(), navigate: true);
    }

    #[On('nyatetError')]
    public function nyatetError()
    {
        return $this->sessionStatus('Internal Server Error');
    }

    #[On('nyatetNotMine')]
    public function nyatetNotMine()
    {
        return $this->sessionStatus('Anda Tidak Memiliki Akses.');
    }
}
