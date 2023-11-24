<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class ForgotPassword extends Component
{
    public $email;

    protected $rules = [
        'email' => ['required', 'string', 'email', 'indisposable'],
    ];

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
}
