<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LoginLog;
use App\Models\Sanctum\PersonalAccessToken;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TokenController extends Controller
{
    public function tokenInfo(Request $request)
    {
        $data = $request->user()->currentAccessToken();

        return response()->json([
            'status' => true,
            'statusCode' => 200,
            'data' => ['name' => $data->name]
        ], 200);
    }

    public function clearExpiredToken()
    {
        try {
            PersonalAccessToken::where('expires_at', '<=', Carbon::now())->delete();

            return response()->json([
                'status' => true,
                'statusCode' => 200,
                'message' => 'Token deleted successfully.'
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

        return response()->json([
            'status' => true,
            'statusCode' => 200,
            'logs' => $data
        ], 200);
    }

    public function logoutToken(Request $request, $token_name)
    {
        $token = PersonalAccessToken::whereName($token_name)->first();
        if (!$token) {
            return response()->json([
                'status' => false,
                'statusCode' => 404,
                'message' => 'Token Tidak Ditemukan.'
            ], 404);
        }

        if ($token->tokenable_id == $request->user()->id) {
            try {
                $token->delete();

                return response()->json([
                    'status' => true,
                    'statusCode' => 200,
                    'message' => 'Berhasil Logout.'
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

        return response()->json([
            'status' => false,
            'statusCode' => 403,
            'message' => 'Anda Tidak Memiliki Akses.'
        ], 403);
    }
}
