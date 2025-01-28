<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Generate;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckConnection extends Controller
{
    public function __invoke(Request $request)
    {
        $cache_name = 'csrf_' . str_replace('.', '', $request->ip());
        $cachedData = Cache::get($cache_name);

        if ($cachedData) {
            if ($cachedData['usage'] < 5) {
                $csrf_token = $cachedData['csrf_token'];
            } elseif ($cachedData['usage'] >= 5) {
                $generate_token = Generate::randomString(32);
                $cachedData['csrf_token'] = $generate_token;
                $cachedData['usage'] = 0;
                Cache::put($cache_name, $cachedData, Carbon::now()->addDays(1));
                $csrf_token = $generate_token;
            }
        } else {
            $generate_token = Generate::randomString(32);
            Cache::put($cache_name, [
                'csrf_token' => $generate_token,
                'usage' => 0
            ], Carbon::now()->addDays(1));
            $csrf_token = $generate_token;
        }

        try {
            DB::connection()->getPdo();

            return response()->json([
                'status' => true,
                'statusCode' => 200,
                'csrf_token' => Crypt::encryptString($csrf_token)
            ], 200);
        } catch (\Exception $err) {
            Log::error($err->getMessage());

            return response()->json([
                'status' => false,
                'statusCode' => 500,
                'message' => 'Could not connect to the database.'
            ], 500);
        }
    }
}
