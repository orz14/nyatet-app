<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Rule;
use Livewire\Component;

class Register extends Component
{
    #[Rule(['required', 'string', 'max:255'])]
    public $name = '';

    #[Rule(['required', 'string', 'min:5', 'max:20', 'unique:users'])]
    public $username = '';

    #[Rule(['required', 'string', 'email', 'indisposable', 'max:255', 'unique:users'])]
    public $email = '';

    #[Rule(['required', 'string', 'min:8'])]
    public $password = '';

    #[Rule(['required', 'same:password'])]
    public $password_confirmation = '';

    public function render()
    {
        return view('livewire.auth.register');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
}
