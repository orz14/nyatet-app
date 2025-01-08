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
        return response()->json([
            'status' => true,
            'statusCode' => 200,
            'data' => $request->user()->currentAccessToken()
        ], 200);
    }

    public function clearExpiredToken(Request $request)
    {
        if ($request->user()->role_id != 1) {
            return response()->json([
                'status' => false,
                'statusCode' => 403,
                'message' => 'Unauthorized',
            ], 403);
        }

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
        $data = LoginLog::with('token')->whereUserId($request->user()->id)->get();

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
