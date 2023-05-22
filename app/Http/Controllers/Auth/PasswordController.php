<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        if (Hash::check($request->current_password, auth()->user()->password)) {
            try {
                $request->user()->update(['password' => Hash::make($request->password)]);

                return back()->with('notif', 'password-updated');
            } catch (\Exception $e) {
                Log::error($e->getMessage());

                return back()->with('err', '[500] Server Error');
            }
        }

        throw ValidationException::withMessages([
            'current_password' => 'The password is incorrect.',
        ]);
    }
}
