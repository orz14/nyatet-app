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
