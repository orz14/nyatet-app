<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class LogController extends Controller
{
    public function getLog(Request $request)
    {
        if ($request->user()->role_id != 1) {
            return response()->json([
                'status' => false,
                'statusCode' => 403,
                'message' => 'Anda Tidak Memiliki Akses.'
            ], 403);
        }

        $logFile = storage_path('logs/laravel.log');

        if (!File::exists($logFile)) {
            return response()->json([
                'status' => false,
                'statusCode' => 404,
                'message' => 'Log file not found.',
            ], 404);
        }

        $logs = File::get($logFile);

        $logLines = explode("\n", trim($logs));

        $filteredLogs = array_filter($logLines, function ($line) {
            return str_contains($line, 'local.ERROR') || str_contains($line, 'local.INFO') || str_contains($line, 'production.ERROR') || str_contains($line, 'production.INFO');
        });

        $orderedLogs = array_reverse(array_values($filteredLogs));

        $perPage = 25;
        $currentPage = $request->input('page', 1);
        $totalLogs = count($orderedLogs);
        $totalPages = ceil($totalLogs / $perPage);

        $paginatedLogs = array_slice($orderedLogs, ($currentPage - 1) * $perPage, $perPage);

        $parsedLogs = [];

        foreach ($paginatedLogs as $log) {
            if (preg_match('/\[(.*?)\] (\w+)\.(\w+):/', $log, $matches)) {
                $parsedLogs[] = [
                    'timestamp' => $matches[1],
                    'environment' => $matches[2],
                    'level' => $matches[3],
                    'message' => substr($log, strpos($log, ': ') + 2)
                ];
            }
        }

        return response()->json([
            'status' => true,
            'statusCode' => 200,
            'logs' => $parsedLogs,
            'pagination' => [
                'current_page' => (int) $currentPage,
                'per_page' => $perPage,
                'total_logs' => $totalLogs,
                'total_pages' => $totalPages,
                'has_next_page' => $currentPage < $totalPages,
                'has_previous_page' => $currentPage > 1,
            ],
        ], 200);
    }

    public function store(Request $request)
    {
        switch ($request->type) {
            case 'info':
                Log::info($request->message);

                return response()->json([
                    'status' => true,
                    'statusCode' => 200,
                    'message' => 'Log has been stored.',
                ], 200);
                break;

            case 'error':
                Log::error($request->message);

                return response()->json([
                    'status' => true,
                    'statusCode' => 200,
                    'message' => 'Log has been stored.',
                ], 200);
                break;

            default:
                return response()->json([
                    'status' => false,
                    'statusCode' => 400,
                    'message' => 'Invalid type.',
                ], 400);
                break;
        }
    }
}
