<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SessionStatus extends Component
{
    protected $listeners = ['todoError', 'todoNotMine'];

    public function render()
    {
        return view('livewire.session-status');
    }

    public function todoError()
    {
        session()->flash('err', '[500] Server Error');
    }

    public function todoNotMine()
    {
        session()->flash('err', 'Anda Tidak Memiliki Akses.');
    }
}
