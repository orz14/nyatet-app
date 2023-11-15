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
        session()->flash('err', '[500] Server Error');
    }

    #[On('nyatetNotMine')]
    public function nyatetNotMine()
    {
        session()->flash('err', 'Anda Tidak Memiliki Akses.');
    }
}
