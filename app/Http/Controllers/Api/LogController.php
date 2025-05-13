<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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

    public function nextLogGet()
    {
        $logPath = storage_path('logs/next-log.json');

        if (!file_exists($logPath)) {
            return Response::error('Log not found.', null, 404);
        }

        $content = file_get_contents($logPath);
        $logs = json_decode($content, true);

        return Response::success(null, ['logs' => $logs]);
    }

    public function nextLogStore(Request $request)
    {
        $origin = parse_url($request->headers->get('Origin'), PHP_URL_HOST);
        $host = explode(',', env('SANCTUM_STATEFUL_DOMAINS'));

        if (in_array($origin, $host)) {
            $validator = Validator::make($request->all(), [
                'timestamp' => ['required'],
                'level' => ['required', 'string'],
                'content' => ['required']
            ]);

            if ($validator->fails()) {
                return Response::error($validator->errors(), null, 422);
            }

            $logLevel = ['info', 'warning', 'error'];
            $level = strtolower($request->level);

            if (!in_array($level, $logLevel)) {
                return Response::error('Invalid level.', null, 400);
            }

            $logPath = storage_path('logs/next-log.json');
            $newLog = [
                'timestamp' => Carbon::parse($request->timestamp)->toDateTimeString(),
                'level' => $level,
                'content' => $request->content
            ];

            try {
                if (!file_exists($logPath)) {
                    file_put_contents($logPath, json_encode([$newLog], JSON_PRETTY_PRINT));
                } else {
                    $logs = json_decode(file_get_contents($logPath), true);
                    $logs[] = $newLog;
                    file_put_contents($logPath, json_encode($logs, JSON_PRETTY_PRINT));
                }

                return Response::success('Log has been stored.', null, 201);
            } catch (\Exception $err) {
                Log::error($err->getMessage());

                return Response::error('Internal Server Error');
            }
        } else {
            return Response::error('Anda Tidak Memiliki Akses.', null, 403);
        }
    }

    public function nextLogDestroy()
    {
        try {
            $logPath = storage_path('logs/next-log.json');

            if (file_exists($logPath)) {
                file_put_contents($logPath, json_encode([], JSON_PRETTY_PRINT));
            }

            return Response::success('Log has been cleared.');
        } catch (\Exception $err) {
            Log::error($err->getMessage());

            return Response::error('Internal Server Error');
        }
    }
}
