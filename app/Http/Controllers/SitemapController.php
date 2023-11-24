<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

class SitemapController extends Controller
{
    public function __invoke()
    {
        $datas = [
            ['url' => url('/')],
            ['url' => url('/login')],
            ['url' => url('/register')],
            ['url' => url('/todo')],
            ['url' => url('/todo/history')],
            ['url' => url('/note')],
            ['url' => url('/profile')],
        ];
        $date = Carbon::now();
        $freq = 'daily';
        $priority = '0.8';

        return response()->view('sitemap.index', compact('datas', 'date', 'freq', 'priority'))
            ->header('Content-Type', 'text/xml');
    }
}
