<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Profile extends Component
{
    public $name;

    public $username;

    public $email;

    public $current_password;

    public $password;

    public $password_confirmation;

    public function render()
    {
        $this->name = auth()->user()->name;
        $this->username = auth()->user()->username;
        $this->email = auth()->user()->email;

        return view('livewire.profile');
    }

    public function saveProfileInfo(Request $request)
    {
        $validatedData = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'indisposable', 'max:255', Rule::unique(User::class)->ignore(auth()->user()->id)],
        ]);

        try {
            $request->user()->update($validatedData);
            session()->flash('notif', 'profile-updated');
        } catch (\Throwable $err) {
            Log::error($err->getMessage());
            session()->flash('notif', 'profile-not-updated');
        }
    }

    public function savePassword(Request $request)
    {
        $this->validate([
            'current_password' => ['required'],
            'password' => ['required', Password::defaults()],
            'password_confirmation' => ['required', 'same:password'],
        ]);

        if (Hash::check($this->current_password, auth()->user()->password)) {
            try {
                $request->user()->update(['password' => Hash::make($this->password)]);
                $this->current_password = '';
                $this->password = '';
                $this->password_confirmation = '';
                session()->flash('notif', 'password-updated');
            } catch (\Throwable $e) {
                Log::error($e->getMessage());
                session()->flash('notif', 'password-not-updated');
            }
        } else {
            throw ValidationException::withMessages([
                'current_password' => 'The password is incorrect.',
            ]);
        }
    }
}
