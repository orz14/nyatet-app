<?php

namespace App\Http\Controllers\Api;

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

            $filename = 'orz-db-backup-' . date('dmy', time()) . '.sql';
            $filePath = storage_path('app/backup/' . $filename);
            if (!file_exists($filePath)) {
                return response()->json([
                    'status' => false,
                    'statusCode' => 404,
                    'message' => 'Backup file not found.'
                ], 404);
            }

            return response()
                ->streamDownload(function () use ($filePath) {
                    readfile($filePath);
                }, $filename);
        } catch (\Exception $err) {
            Log::error($err->getMessage());

            return response()->json([
                'status' => false,
                'statusCode' => 500,
                'message' => '[500] Server Error'
            ], 500);
        }
    }

    public function optimizeClear()
    {
        try {
            Artisan::call('optimize:clear');
            Log::info('Clearing cached bootstrap files.');

            return response()->json([
                'status' => true,
                'statusCode' => 200,
                'message' => 'Clearing cached bootstrap files.'
            ], 200);
        } catch (\Exception $err) {
            Log::error($err->getMessage());

            return response()->json([
                'status' => false,
                'statusCode' => 500,
                'message' => '[500] Server Error'
            ], 500);
        }
    }
}
