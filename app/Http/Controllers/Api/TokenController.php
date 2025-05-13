<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\LoginLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TokenController extends Controller
{
    public function tokenInfo(Request $request)
    {
        $data = $request->user()->currentAccessToken();
        $log = DB::table('login_logs')->where('token_name', $data->name)->first(['fingerprint']);

        return Response::success(null, [
            'data' => [
                'name' => $data->name,
                'fingerprint' => ($log && isset($log->fingerprint)) ? $log->fingerprint : null
            ]
        ]);
    }

    public function clearExpiredToken()
    {
        try {
            DB::table('personal_access_tokens')->where('expires_at', '<=', Carbon::now())->delete();

            return Response::success('Token deleted successfully.');
        } catch (\Exception $err) {
            Log::error($err->getMessage());

            return Response::error('Internal Server Error');
        }
    }

    public function getLoginLog(Request $request)
    {
        $data = LoginLog::with('token')->whereUserId($request->user()->id)->get()->map(function ($item) {
            return [
                'token_name' => $item->token_name,
                'ip_address' => $item->ip_address,
                'user_agent' => $item->user_agent,
                'city' => $item->city,
                'region' => $item->region,
                'country' => $item->country,
                'token' => ['last_used_at' => $item->token->last_used_at]
            ];
        });

        return Response::success(null, ['logs' => $data]);
    }

    public function logoutToken(Request $request, $token_name)
    {
        $token = DB::table('personal_access_tokens')->whereName($token_name)->first(['tokenable_id']);
        if (!$token) {
            return Response::error('Token Tidak Ditemukan.', null, 404);
        }

        if ($token->tokenable_id == $request->user()->id) {
            try {
                DB::table('personal_access_tokens')->whereName($token_name)->delete();

                return Response::success('Berhasil Logout.');
            } catch (\Exception $err) {
                Log::error($err->getMessage());

                return Response::error('Internal Server Error');
            }
        }

        return Response::error('Anda Tidak Memiliki Akses.', null, 403);
    }

    public function clearToken(Request $request)
    {
        $data = $request->user()->currentAccessToken();

        try {
            DB::table('personal_access_tokens')->where('name', '!=', $data->name)->delete();

            return Response::success('Token deleted successfully.');
        } catch (\Exception $err) {
            Log::error($err->getMessage());

            return Response::error('Internal Server Error');
        }
    }

    public function clearPasswordToken()
    {
        try {
            DB::table('password_reset_tokens')
                ->where('created_at', '<', Carbon::now()->subMinutes(60))
                ->delete();

            return Response::success('Token deleted successfully.');
        } catch (\Exception $err) {
            Log::error($err->getMessage());

            return Response::error('Internal Server Error');
        }
    }
}
