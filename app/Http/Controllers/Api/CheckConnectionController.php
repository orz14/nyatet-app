<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Generate;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckConnectionController extends Controller
{
    public function __invoke(Request $request)
    {
        $get_fingerprint = $request->header('Fingerprint_');
        $get_authorization = $request->header('Authorization');
        if ($get_authorization) {
            $parts = explode(' ', $get_authorization);
            $token = $parts[1];
            $tokenParts = explode('|', $token);
            $accessToken = DB::table('personal_access_tokens')->where('id', $tokenParts[0])->first(['name']);

            if ($accessToken) {
                $log = DB::table('login_logs')->where('token_name', $accessToken->name)->first(['fingerprint']);
                if (!$log || ($log->fingerprint != $get_fingerprint)) {
                    try {
                        DB::table('personal_access_tokens')->where('id', $tokenParts[0])->delete();
                        return Response::error('Fingerprint invalid.', null, 401);
                    } catch (\Exception $err) {
                        Log::error($err->getMessage());
                        return Response::error('[500] Server Error');
                    }
                }
            } else {
                return Response::error('Token invalid.', null, 401);
            }
        }

        $cache_name = "csrf_$get_fingerprint";
        $cachedData = Cache::get($cache_name);

        if ($cachedData) {
            $csrf_token = $cachedData['csrf_token'];
        } else {
            $generate_token = Generate::randomString(32);
            Cache::put($cache_name, [
                'csrf_token' => $generate_token
            ], Carbon::now()->addDays(1));
            $csrf_token = $generate_token;
        }

        try {
            DB::connection()->getPdo();

            return Response::success(null, [
                'csrf_token' => Crypt::encryptString($csrf_token)
            ]);
        } catch (\Exception $err) {
            Log::error($err->getMessage());

            return Response::error('Could not connect to the database.');
        }
    }
}
