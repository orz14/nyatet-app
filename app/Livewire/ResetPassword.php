<?php

namespace App\Livewire;

use Livewire\Component;

class ResetPassword extends Component
{
    public $password;

    public $password_confirmation;

    public function render()
    {
        return view('livewire.reset-password');
    }

    protected $rules = [
        'password' => ['required', 'string', 'min:8'],
        'password_confirmation' => ['required', 'same:password'],
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
}
