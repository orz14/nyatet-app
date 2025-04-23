<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class ArtisanCallController extends Controller
{
    public function databaseBackup()
    {
        try {
            Artisan::call('db:backup');
            Log::info('Creating Database Backup Successfully.');

            $fileName = 'orz-db-backup-' . date('dmy', time()) . '.sql';
            $filePath = storage_path('app/backup/' . $fileName);
            if (!file_exists($filePath)) {
                return Response::error('Backup file not found.', null, 404);
            }

            return Response::streamDownload($filePath, $fileName);
        } catch (\Exception $err) {
            Log::error($err->getMessage());

            return Response::error('[500] Server Error');
        }
    }

    public function optimizeClear()
    {
        try {
            Artisan::call('optimize:clear');
            Log::info('Clearing cached bootstrap files.');

            return Response::success('Clearing cached bootstrap files.');
        } catch (\Exception $err) {
            Log::error($err->getMessage());

            return Response::error('[500] Server Error');
        }
    }
}
