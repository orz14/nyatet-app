<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Generate;
use App\Http\Controllers\Controller;
use App\Models\LoginLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password as FacadesPassword;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'statusCode' => 422,
                'message' => $validator->errors()
            ], 422);
        }

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'statusCode' => 401,
                'message' => 'These credentials do not match our records.'
            ], 401);
        }

        $token = $this->generateToken($request, $user, $request->remember);

        if (!$token) {
            return response()->json([
                'status' => false,
                'statusCode' => 500,
                'message' => 'Login failed.'
            ], 500);
        }

        return response()->json([
            'status' => true,
            'statusCode' => 200,
            'message' => 'Login successfully.',
            'data' => $user,
            'token_type' => 'Bearer',
            'token' => $token
        ], 200);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'min:5', 'max:20', 'unique:' . User::class],
            'email' => ['required', 'string', 'email', 'indisposable', 'max:255', 'unique:' . User::class],
            'password' => ['required', Password::defaults(), 'confirmed']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'statusCode' => 422,
                'message' => $validator->errors()
            ], 422);
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => 2
            ]);

            event(new Registered($user));

            $token = $this->generateToken($request, $user, $request->remember);

            if (!$token) {
                return response()->json([
                    'status' => false,
                    'statusCode' => 500,
                    'type' => 'login_failed',
                    'message' => 'Login failed.'
                ], 500);
            }

            return response()->json([
                'status' => true,
                'statusCode' => 201,
                'message' => 'Register successfully.',
                'data' => $user,
                'token_type' => 'Bearer',
                'token' => $token
            ], 201);
        } catch (\Exception $err) {
            Log::error($err->getMessage());

            return response()->json([
                'status' => false,
                'statusCode' => 500,
                'type' => 'server_error',
                'message' => '[500] Server Error'
            ], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'indisposable']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'statusCode' => 422,
                'message' => $validator->errors()
            ], 422);
        }

        try {
            $status = FacadesPassword::sendResetLink(
                $request->only('email')
            );

            if ($status == FacadesPassword::RESET_LINK_SENT) {
                return response()->json([
                    'status' => true,
                    'statusCode' => 200,
                    'message' => 'Kami telah mengirimkan tautan pengaturan ulang kata sandi Anda melalui email!'
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'statusCode' => 400,
                    'message' => 'Email tidak terdaftar.'
                ], 400);
            }
        } catch (\Exception $err) {
            Log::error($err->getMessage());

            return response()->json([
                'status' => false,
                'statusCode' => 500,
                'message' => '[500] Server Error'
            ], 500);
        }
    }

    public function newPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => ['required'],
            'email' => ['required', 'email', 'indisposable'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'statusCode' => 422,
                'message' => $validator->errors()
            ], 422);
        }

        try {
            $status = FacadesPassword::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user) use ($request) {
                    $user->forceFill(['password' => Hash::make($request->password)])->save();

                    event(new PasswordReset($user));
                }
            );

            if ($status == FacadesPassword::PASSWORD_RESET) {
                return response()->json([
                    'status' => true,
                    'statusCode' => 200,
                    'message' => 'Password Anda berhasil diubah.'
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'statusCode' => 400,
                    'message' => 'Token tidak valid.'
                ], 400);
            }
        } catch (\Exception $err) {
            Log::error($err->getMessage());

            return response()->json([
                'status' => false,
                'statusCode' => 500,
                'message' => '[500] Server Error'
            ], 500);
        }
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function handleProviderCallback(Request $request, $provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();

        $authUser = $this->findOrCreateUser($user, $provider);

        $token = $this->generateToken($request, $authUser, true);

        if (!$token) {
            return redirect(config('app.frontend_url') . '/auth/callback?status=failed');
        }

        return redirect(config('app.frontend_url') . '/auth/callback?token=' . $token);
    }

    public function findOrCreateUser($user, $provider)
    {
        $field = strtolower($provider) . '_id';
        $authUser = User::where($field, $user->getId())->first();
        if ($authUser) {
            $authUser->update(['avatar' => $user->getAvatar() ?? null]);

            return $authUser;
        }

        if ($user->getEmail() != null) {
            $usermail = User::where('email', $user->getEmail())->first();
            if ($usermail) {
                $usermail->update([
                    $field => $user->getId(),
                    'avatar' => $user->getAvatar() ?? null
                ]);

                return $usermail;
            } else {
                $user = User::create([
                    'name' => $user->getName() ?? 'User',
                    'username' => 'user-' . Generate::randomString(10),
                    'email' => $user->getEmail(),
                    'password' => Hash::make(Generate::randomString(20)),
                    $field => $user->getId(),
                    'avatar' => $user->getAvatar() ?? null,
                    'role_id' => 2,
                ]);

                event(new Registered($user));

                return $user;
            }
        }
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
                'statusCode' => 422,
                'message' => $validator->errors()
            ], 422);
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
                'statusCode' => 422,
                'message' => $validator->errors()
            ], 422);
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
                'message' => 'Akun Berhasil Dihapus.'
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

    private function generateToken($request, $user, $remember = false): string|null
    {
        DB::beginTransaction();
        try {
            $token_name = Generate::randomString(32);
            $expiresAt = $remember ? null : Carbon::now()->addDays(7);
            // $expiresAt = $remember ? null : Carbon::now()->addMinutes(2);
            $token = $user->createToken($token_name, ["*"], $expiresAt)->plainTextToken;

            $ip = $request->header('User-Ip') ?? $request->ip() ?? null;
            $ip_info = Http::get("https://ipinfo.io/$ip/json")->object();

            LoginLog::create([
                'user_id' => $user->id,
                'token_name' => $token_name,
                'ip_address' => $ip,
                'user_agent' => $request->userAgent() ?? null,
                'city' => $ip_info->city ?? null,
                'region' => $ip_info->region ?? null,
                'country' => $ip_info->country ?? null
            ]);

            DB::commit();
            return (string) $token;
        } catch (\Exception $err) {
            DB::rollBack();
            Log::error($err->getMessage());
            return null;
        }
    }
}
