<?php

namespace App\Livewire\Profile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Destroy extends Component
{
    public function render()
    {
        return view('livewire.profile.destroy');
    }

    public function destroyProfile(Request $request)
    {
        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $this->redirect('/login', navigate: true);
    }
}
