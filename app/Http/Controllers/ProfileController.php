<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'title' => 'Profil',
            'user' => $request->user(),
            'modalDeleteAccount' => true,
        ]);
    }
}
