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

    #[On('todoError')]
    public function todoError()
    {
        session()->flash('err', '[500] Server Error');
    }

    #[On('todoNotMine')]
    public function todoNotMine()
    {
        session()->flash('err', 'Anda Tidak Memiliki Akses.');
    }
}
