<?php

namespace App\Http\Controllers;

class CSRFTokenController extends Controller
{
    public function __invoke()
    {
        return response()->json([
            'status' => true,
            'csrf_token' => csrf_token()
        ], 200);
    }
}
