<?php

namespace App\Http\Controllers;

class CSRFTokenController extends Controller
{
    public function __invoke()
    {
        return response()->json(['csrf_token' => csrf_token()]);
    }
}
