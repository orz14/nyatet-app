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
                'status' => false,
                'statusCode' => 400,
                'message' => $validator->errors()
            ], 400);
        }

        $user = User::where('username', $request->username)->first();

        if (!$user || !Auth::attempt($request->only('username', 'password')) || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'statusCode' => 401,
                'message' => 'These credentials do not match our records.'
            ], 401);
        }

        return response()->json([
            'status' => true,
            'statusCode' => 200,
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
            'statusCode' => 200,
            'data' => $request->user()
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status'    => true,
            'statusCode' => 200,
            'message'   => 'Logout successfully.',
        ], 200);
    }
}
