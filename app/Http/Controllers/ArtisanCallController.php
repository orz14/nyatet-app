<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class ArtisanCallController extends Controller
{
    public function dbBackup()
    {
        try {
            Artisan::call('db:backup');
            Log::info('Creating Database Backup Successfully.');

            return to_route('todo.index')->with('status', 'Creating Database Backup Successfully.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return to_route('todo.index')->with('err', '[500] Server Error');
        }
    }

    public function webDown()
    {
        try {
            Artisan::call('down --refresh=60 --secret="orzcode-uhLGp6jO3Q3L2ZFwQdl4dpIdtsXnQHbn5tjCpufAmKzFUFm9PI"');
            Log::info('Application is now in maintenance mode.');

            return redirect('/orzcode-uhLGp6jO3Q3L2ZFwQdl4dpIdtsXnQHbn5tjCpufAmKzFUFm9PI');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return to_route('todo.index')->with('err', '[500] Server Error');
        }
    }

    public function webUp()
    {
        try {
            Artisan::call('up');
            Log::info('Application is now live.');

            return to_route('todo.index')->with('status', 'Application is now live.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return to_route('todo.index')->with('err', '[500] Server Error');
        }
    }

    public function optimize()
    {
        try {
            Artisan::call('optimize:clear');
            Log::info('Clearing cached bootstrap files.');

            return to_route('todo.index')->with('status', 'Clearing cached bootstrap files.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return to_route('todo.index')->with('err', '[500] Server Error');
        }
    }
}
