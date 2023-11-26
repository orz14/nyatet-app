<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Rule;
use Livewire\Component;

class ForgotPassword extends Component
{
    #[Rule(['required', 'string', 'email', 'indisposable'])]
    public $email = '';

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
}
