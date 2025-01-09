<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MobileAppController extends Controller
{
    public function index()
    {
        return view('mobile-app.index', [
            'title' => 'Mobile App'
        ]);
    }

    public function edit()
    {
        return view('mobile-app.edit', [
            'title' => 'Update Mobile App'
        ]);
    }

    public function update()
    {
        return 'mobile-app.update';
    }
}
