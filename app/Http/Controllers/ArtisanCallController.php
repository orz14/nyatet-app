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

            flash('Creating Database Backup Successfully.');

            return to_route('todo.index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            flash('[500] Server Error', 'err');

            return to_route('todo.index');
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

            flash('[500] Server Error', 'err');

            return to_route('todo.index');
        }
    }

    public function webUp()
    {
        try {
            Artisan::call('up');
            Log::info('Application is now live.');

            flash('Application is now live.');

            return to_route('todo.index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            flash('[500] Server Error', 'err');

            return to_route('todo.index');
        }
    }

    public function optimize()
    {
        try {
            Artisan::call('optimize:clear');
            Log::info('Clearing cached bootstrap files.');

            flash('Clearing cached bootstrap files.');

            return to_route('todo.index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            flash('[500] Server Error', 'err');

            return to_route('todo.index');
        }
    }

    public function migrate()
    {
        try {
            Artisan::call('migrate');
            Log::info('Creating Migration Table Successfully.');

            flash('Creating Migration Table Successfully.');

            return to_route('todo.index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            flash('[500] Server Error', 'err');

            return to_route('todo.index');
        }
    }

    public function rollback()
    {
        try {
            Artisan::call('migrate:rollback');
            Log::info('Rolling Back Migrations Successfully.');

            flash('Rolling Back Migrations Successfully.');

            return to_route('todo.index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            flash('[500] Server Error', 'err');

            return to_route('todo.index');
        }
    }
}
