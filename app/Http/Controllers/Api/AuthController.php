<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

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

        if (!$user || !Hash::check($request->password, $user->password)) {
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

    public function currentUser(Request $request)
    {
        return response()->json([
            'status' => true,
            'statusCode' => 200,
            'data' => $request->user()
        ], 200);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'indisposable', 'max:255', Rule::unique(User::class)->ignore($user->id)]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'statusCode' => 400,
                'message' => $validator->errors()
            ], 400);
        }

        try {
            $user->update($validator->validated());

            return response()->json([
                'status' => true,
                'statusCode' => 200,
                'message' => 'Berhasil Disimpan.'
            ], 200);
        } catch (\Exception $err) {
            Log::error($err->getMessage());

            return response()->json([
                'status' => false,
                'statusCode' => 500,
                'message' => 'Gagal Disimpan.'
            ], 500);
        }
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();
        $validator = Validator::make($request->all(), [
            'current_password' => ['required'],
            'password' => ['required', Password::defaults(), 'confirmed']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'statusCode' => 400,
                'message' => $validator->errors()
            ], 400);
        }

        if (Hash::check($request->current_password, $user->password)) {
            try {
                $user->update(['password' => Hash::make($request->password)]);

                return response()->json([
                    'status' => true,
                    'statusCode' => 200,
                    'message' => 'Berhasil Disimpan.'
                ], 200);
            } catch (\Exception $err) {
                Log::error($err->getMessage());

                return response()->json([
                    'status' => false,
                    'statusCode' => 500,
                    'message' => 'Gagal Disimpan.'
                ], 500);
            }
        } else {
            return response()->json([
                'status' => false,
                'statusCode' => 400,
                'message' => 'The current password is incorrect.'
            ], 400);
        }
    }

    public function destroyUser(Request $request)
    {
        try {
            $user = $request->user();
            $user->tokens()->delete();
            $user->delete();

            return response()->json([
                'status' => true,
                'statusCode' => 200,
                'message' => 'User Berhasil Dihapus.'
            ], 200);
        } catch (\Exception $err) {
            Log::error($err->getMessage());

            return response()->json([
                'status' => false,
                'statusCode' => 500,
                'message' => '[500] Server Error'
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'status'    => true,
                'statusCode' => 200,
                'message'   => 'Logout successfully.',
            ], 200);
        } catch (\Exception $err) {
            Log::error($err->getMessage());

            return response()->json([
                'status' => false,
                'statusCode' => 500,
                'message' => '[500] Server Error'
            ], 500);
        }
    }
}
