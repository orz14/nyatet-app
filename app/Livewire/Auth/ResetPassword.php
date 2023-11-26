<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Rule;
use Livewire\Component;

class ResetPassword extends Component
{
    #[Rule(['required', 'string', 'min:8'])]
    public $password = '';

    #[Rule(['required', 'same:password'])]
    public $password_confirmation = '';

    public function render()
    {
        return view('livewire.auth.reset-password');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
}
