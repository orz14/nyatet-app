<?php

namespace App\Http\Controllers;

class RedirectController extends Controller
{
    public function __invoke($route)
    {
        return redirect()->route($route)->with('reload', true);
    }
}
