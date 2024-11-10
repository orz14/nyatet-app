<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string'],
            'password' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => $validator->errors()
            ], $validator->errors()->all()[0]->code);
        }

        $user = User::where('username', $request->username)->first();

        if (!$user || !Auth::attempt($request->only('username', 'password')) || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'These credentials do not match our records.'
            ], 401);
        }

        return response()->json([
            'status' => true,
            'message' => 'Login successfully.',
            'data' => $user,
            'token_type' => 'Bearer',
            'token' => $user->createToken(Str::uuid()->toString())->plainTextToken
        ], 200);
    }

    public function me(Request $request)
    {
        return response()->json([
            'status' => true,
            'data' => $request->user()
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status'    => true,
            'message'   => 'Logout successfully.',
        ], 200);
    }
}
