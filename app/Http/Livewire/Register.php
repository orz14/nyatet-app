<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Register extends Component
{
    public $name;

    public $username;

    public $email;

    public $password;

    public $password_confirmation;

    public function render()
    {
        return view('livewire.register');
    }

    protected $rules = [
        'name' => ['required', 'string', 'max:255'],
        'username' => ['required', 'string', 'max:20', 'unique:users'],
        'email' => ['required', 'string', 'email', 'indisposable', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8'],
        'password_confirmation' => ['required', 'same:password'],
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
}
