<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class LogController extends Controller
{
    public function getLog(Request $request)
    {
        $logFile = storage_path('logs/laravel.log');

        if (!File::exists($logFile)) {
            return Response::error('Log file not found.', null, 404);
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
        if (count($paginatedLogs) > 0) {
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
        }

        return Response::success(null, [
            'logs' => $parsedLogs,
            'pagination' => [
                'current_page' => (int) $currentPage,
                'per_page' => $perPage,
                'from' => (count($parsedLogs) > 0) ? ($currentPage - 1) * $perPage + 1 : null,
                'to' => (count($parsedLogs) > 0) ? min($currentPage * $perPage, $totalLogs) : null,
                'path' => $request->url(),
                'first_page_url' => $request->url() . '?page=1',
                'next_page_url' => ($currentPage < $totalPages) ? $request->url() . '?page=' . ($currentPage + 1) : null,
                'prev_page_url' => ($currentPage > 1) ? $request->url() . '?page=' . ($currentPage - 1) : null
            ]
        ]);
    }

    public function store(Request $request)
    {
        $origin = parse_url($request->headers->get('Origin'), PHP_URL_HOST);
        $host = explode(',', env('SANCTUM_STATEFUL_DOMAINS'));

        if (in_array($origin, $host)) {
            switch ($request->type) {
                case 'info':
                    Log::info($request->message);

                    return Response::success('Log has been stored.');
                    break;

                case 'error':
                    Log::error($request->message);

                    return Response::success('Log has been stored.');
                    break;

                default:
                    return Response::error('Invalid type.', null, 400);
                    break;
            }
        } else {
            return Response::error('Anda Tidak Memiliki Akses.', null, 403);
        }
    }
}
