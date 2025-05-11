<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use ObjectId\ObjectId;

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
        $logs = DB::table('next_logs')->orderBy('id', 'desc')->get()->map(function ($item) {
            return [
                'timestamp' => $item->created_at,
                'level' => $item->level,
                'content' => json_decode($item->content)
            ];
        });

        if ($logs->count() == 0) {
            return Response::error('Log not found.', null, 404);
        }

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

            try {
                DB::table('next_logs')->insert([
                    'id' => ObjectId::generate(),
                    'level' => $level,
                    'content' => json_encode($request->content),
                    'created_at' => Carbon::parse($request->timestamp)
                ]);

                return Response::success('Log has been stored.', null, 201);
            } catch (\Exception $err) {
                Log::error($err->getMessage());

                return Response::error('[500] Server Error');
            }
        } else {
            return Response::error('Anda Tidak Memiliki Akses.', null, 403);
        }
    }
}
