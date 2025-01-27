<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function checkConnection()
    {
        try {
            DB::connection()->getPdo();

            return response()->json([
                'status' => true,
                'statusCode' => 200,
                'csrf_token' => Crypt::encryptString(env('STATIC_CSRF'))
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
