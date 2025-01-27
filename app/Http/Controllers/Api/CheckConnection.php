<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Generate;
use App\Http\Controllers\Controller;
use App\Models\CsrfSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class CheckConnection extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $ip = $request->ip();

        try {
            $csrf = CsrfSession::where('ip_address', $ip)->first();

            if ($csrf) {
                if ($csrf->usage < 5) {
                    $csrf_token = $csrf->csrf_token;
                } elseif ($csrf->usage >= 5) {
                    $generate_token = Generate::randomString(32);
                    $csrf->update([
                        'csrf_token' => $generate_token,
                        'usage' => 0
                    ]);
                    $csrf_token = $generate_token;
                }
            } else {
                $generate_token = Generate::randomString(32);
                CsrfSession::create([
                    'ip_address' => $ip,
                    'csrf_token' => $generate_token
                ]);
                $csrf_token = $generate_token;
            }

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
