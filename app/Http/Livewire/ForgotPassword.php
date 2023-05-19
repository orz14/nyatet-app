<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ForgotPassword extends Component
{
    public $email;

    public function render()
    {
        return view('livewire.forgot-password');
    }

    protected $rules = [
        'email' => ['required', 'email', 'indisposable'],
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
}
