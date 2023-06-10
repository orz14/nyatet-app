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
            Artisan::call('down --refresh=60 --secret='.env('MAINTENANCE_SECRET_TOKEN', 'orzcode'));
            Log::info('Application is now in maintenance mode.');

            return redirect('/'.env('MAINTENANCE_SECRET_TOKEN', 'orzcode'));
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

    public function migrate()
    {
        try {
            Artisan::call('migrate');
            Log::info('Creating Migration Table Successfully.');

            return to_route('todo.index')->with('status', 'Creating Migration Table Successfully.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return to_route('todo.index')->with('err', '[500] Server Error');
        }
    }

    public function rollback()
    {
        try {
            Artisan::call('migrate:rollback');
            Log::info('Rolling Back Migrations Successfully.');

            return to_route('todo.index')->with('status', 'Rolling Back Migrations Successfully.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return to_route('todo.index')->with('err', '[500] Server Error');
        }
    }
}
