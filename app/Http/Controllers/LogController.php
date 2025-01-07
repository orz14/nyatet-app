<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogController extends Controller
{
    public function __invoke(Request $request)
    {
        switch ($request->type) {
            case 'info':
                Log::info($request->message);

                return response()->json([
                    'status' => true,
                    'statusCode' => 200,
                    'message' => 'Log has been stored.',
                ], 200);
                break;

            case 'error':
                Log::error($request->message);

                return response()->json([
                    'status' => true,
                    'statusCode' => 200,
                    'message' => 'Log has been stored.',
                ], 200);
                break;

            default:
                return response()->json([
                    'status' => false,
                    'statusCode' => 400,
                    'message' => 'Invalid type.',
                ], 400);
                break;
        }
    }
}
