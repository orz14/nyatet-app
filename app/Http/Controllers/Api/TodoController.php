<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    public function getAllTodo()
    {
        $data = Todo::whereUserId(auth()->user()->id)
            ->whereDate('created_at', Carbon::today())
            ->get()
            ->map(function ($item) {
                $item->content = $item->decrypt($item->content);

                return $item;
            });

        return response()->json([
            'status' => true,
            'statusCode' => 200,
            'todos' => $data
        ], 200);
    }

    public function getAllHistoryTodo()
    {
        $paginate = Todo::whereUserId(auth()->user()->id)->whereDate('created_at', '!=', Carbon::today())->latest()->simplePaginate(20);
        $data = $paginate->groupBy('date')->map(function ($group) {
            return $group->map(function ($item) {
                $item->content = $item->decrypt($item->content);

                return $item;
            });
        });

        return response()->json([
            'status' => true,
            'statusCode' => 200,
            'todos' => $data,
            'pagination' => [
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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => ['required', 'string', 'max:200']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'statusCode' => 422,
                'message' => $validator->errors()
            ], 422);
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

    public function changeStatus($slug)
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

    public function getTodo($slug)
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

    public function update(Request $request, $slug)
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
            'todo' => ['required', 'string', 'max:200']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'statusCode' => 422,
                'message' => $validator->errors()
            ], 422);
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

    public function destroy($slug)
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
