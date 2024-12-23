<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    public function index()
    {
        return view('todo.index', [
            'title' => 'Todo List',
            'modalDelete' => true,
            'modalEdit' => true
        ]);
    }

    public function history()
    {
        return view('todo.history', [
            'title' => 'History List',
            'modalDelete' => true
        ]);
    }

    public function apiIndex()
    {
        $data = Todo::whereUserId(auth()->user()->id)
            ->whereDate('created_at', Carbon::today())
            ->get()
            ->map(function ($item) {
                $item->content = $item->decrypt($item->content);

                return $item;
            });

        if ($data->isEmpty()) {
            return response()->json([
                'status' => false,
                'statusCode' => 204
            ], 204);
        }

        return response()->json([
            'status' => true,
            'statusCode' => 200,
            'todos' => $data
        ], 200);
    }

    public function apiHistory()
    {
        $paginate = Todo::whereUserId(auth()->user()->id)->whereDate('created_at', '!=', Carbon::today())->latest()->simplePaginate(20);
        $data = $paginate->groupBy('date')->map(function ($group) {
            return $group->map(function ($item) {
                $item->content = $item->decrypt($item->content);

                return $item;
            });
        });

        if ($paginate->isEmpty()) {
            return response()->json([
                'status' => false,
                'statusCode' => 204
            ], 204);
        }

        return response()->json([
            'status' => true,
            'statusCode' => 200,
            'todos' => $data,
            'paginate' => [
                'current_page' => $paginate->currentPage(),
                'per_page' => $paginate->perPage(),
                'from' => $paginate->firstItem(),
                'to' => $paginate->lastItem(),
                'path' => $paginate->path(),
                'first_page_url' => $paginate->url(1),
                'next_page_url' => $paginate->nextPageUrl(),
                'prev_page_url' => $paginate->previousPageUrl()
            ]
        ], 200);
    }

    public function apiCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'statusCode' => 400,
                'message' => $validator->errors()
            ], 400);
        }

        try {
            Todo::create([
                'user_id' => auth()->user()->id,
                'slug' => substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10),
                'content' => Crypt::encryptString($request->content),
                'date' => date('Y-m-d')
            ]);

            return response()->json([
                'status' => true,
                'statusCode' => 201,
                'message' => 'List Berhasil Ditambahkan.'
            ], 201);
        } catch (\Exception $err) {
            Log::error($err->getMessage());

            return response()->json([
                'status' => false,
                'statusCode' => 500,
                'message' => '[500] Server Error'
            ], 500);
        }
    }

    public function apiChangeStatus($slug)
    {
        $todo = Todo::whereSlug($slug)->first();
        if (!$todo) {
            return response()->json([
                'status' => false,
                'statusCode' => 404,
                'message' => 'Todo Tidak Ditemukan.'
            ], 404);
        }

        if ($todo->user_id == auth()->user()->id) {
            if (!$todo->is_done) {
                try {
                    $todo->update(['is_done' => true]);

                    return response()->json([
                        'status' => true,
                        'statusCode' => 200,
                        'message' => 'Todo Berhasil Diperbarui.'
                    ], 200);
                } catch (\Exception $err) {
                    Log::error($err->getMessage());

                    return response()->json([
                        'status' => false,
                        'statusCode' => 500,
                        'message' => '[500] Server Error'
                    ], 500);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'statusCode' => 400,
                    'message' => 'Todo Sudah Diselesaikan.'
                ], 400);
            }
        }

        return response()->json([
            'status' => false,
            'statusCode' => 403,
            'message' => 'Anda Tidak Memiliki Akses.'
        ], 403);
    }

    public function apiEdit($slug)
    {
        $todo = Todo::whereSlug($slug)->first();
        if (!$todo) {
            return response()->json([
                'status' => false,
                'statusCode' => 404,
                'message' => 'Todo Tidak Ditemukan.'
            ], 404);
        }

        if ($todo->user_id == auth()->user()->id) {
            $todo->content = $todo->decrypt($todo->content);

            return response()->json([
                'status' => true,
                'statusCode' => 200,
                'data' => $todo
            ], 200);
        }

        return response()->json([
            'status' => false,
            'statusCode' => 403,
            'message' => 'Anda Tidak Memiliki Akses.'
        ], 403);
    }

    public function apiUpdate(Request $request, $slug)
    {
        $todo = Todo::whereSlug($slug)->first();
        if (!$todo) {
            return response()->json([
                'status' => false,
                'statusCode' => 404,
                'message' => 'Todo Tidak Ditemukan.'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'todo' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'statusCode' => 400,
                'message' => $validator->errors()
            ], 400);
        }

        if ($todo->user_id == auth()->user()->id) {
            try {
                $todo->update([
                    'content' => $todo->encrypt($request->todo)
                ]);

                return response()->json([
                    'status' => true,
                    'statusCode' => 200,
                    'message' => 'Todo Berhasil Diperbarui.'
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

        return response()->json([
            'status' => false,
            'statusCode' => 403,
            'message' => 'Anda Tidak Memiliki Akses.'
        ], 403);
    }

    public function apiDestroy($slug)
    {
        $todo = Todo::whereSlug($slug)->first();
        if (!$todo) {
            return response()->json([
                'status' => false,
                'statusCode' => 404,
                'message' => 'Todo Tidak Ditemukan.'
            ], 404);
        }

        if ($todo->user_id == auth()->user()->id) {
            try {
                $todo->delete();

                return response()->json([
                    'status' => true,
                    'statusCode' => 200,
                    'message' => 'List Berhasil Dihapus.'
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

        return response()->json([
            'status' => false,
            'statusCode' => 403,
            'message' => 'Anda Tidak Memiliki Akses.'
        ], 403);
    }
}
