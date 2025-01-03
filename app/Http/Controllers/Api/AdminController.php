<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sanctum\PersonalAccessToken;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
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
}
