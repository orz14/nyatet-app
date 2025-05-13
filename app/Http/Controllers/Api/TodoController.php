<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
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

        return Response::success(null, ['todos' => $data]);
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

        return Response::success(null, [
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
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => ['required', 'string', 'max:200']
        ]);

        if ($validator->fails()) {
            return Response::error($validator->errors(), null, 422);
        }

        try {
            Todo::create([
                'user_id' => auth()->user()->id,
                'slug' => substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10),
                'content' => Crypt::encryptString($request->content),
                'date' => date('Y-m-d')
            ]);

            return Response::success('List Berhasil Ditambahkan.', null, 201);
        } catch (\Exception $err) {
            Log::error($err->getMessage());

            return Response::error('Internal Server Error');
        }
    }

    public function changeStatus($slug)
    {
        $todo = Todo::whereSlug($slug)->first();
        if (!$todo) {
            return Response::error('Todo Tidak Ditemukan.', null, 404);
        }

        if ($todo->user_id == auth()->user()->id) {
            if (!$todo->is_done) {
                try {
                    $todo->update(['is_done' => true]);

                    return Response::success('Todo Berhasil Diperbarui.');
                } catch (\Exception $err) {
                    Log::error($err->getMessage());

                    return Response::error('Internal Server Error');
                }
            } else {
                return Response::error('Todo Sudah Diselesaikan.', null, 400);
            }
        }

        return Response::error('Anda Tidak Memiliki Akses.', null, 403);
    }

    public function getTodo($slug)
    {
        $todo = Todo::whereSlug($slug)->first();
        if (!$todo) {
            return Response::error('Todo Tidak Ditemukan.', null, 404);
        }

        if ($todo->user_id == auth()->user()->id) {
            $todo->content = $todo->decrypt($todo->content);

            return Response::success(null, ['data' => $todo]);
        }

        return Response::error('Anda Tidak Memiliki Akses.', null, 403);
    }

    public function update(Request $request, $slug)
    {
        $todo = Todo::whereSlug($slug)->first();
        if (!$todo) {
            return Response::error('Todo Tidak Ditemukan.', null, 404);
        }

        $validator = Validator::make($request->all(), [
            'todo' => ['required', 'string', 'max:200']
        ]);

        if ($validator->fails()) {
            return Response::error($validator->errors(), null, 422);
        }

        if ($todo->user_id == auth()->user()->id) {
            try {
                $todo->update([
                    'content' => $todo->encrypt($request->todo)
                ]);

                return Response::success('Todo Berhasil Diperbarui.');
            } catch (\Exception $err) {
                Log::error($err->getMessage());

                return Response::error('Internal Server Error');
            }
        }

        return Response::error('Anda Tidak Memiliki Akses.', null, 403);
    }

    public function destroy($slug)
    {
        $todo = Todo::whereSlug($slug)->first();
        if (!$todo) {
            return Response::error('Todo Tidak Ditemukan.', null, 404);
        }

        if ($todo->user_id == auth()->user()->id) {
            try {
                $todo->delete();

                return Response::success('List Berhasil Dihapus.');
            } catch (\Exception $err) {
                Log::error($err->getMessage());

                return Response::error('Internal Server Error');
            }
        }

        return Response::error('Anda Tidak Memiliki Akses.', null, 403);
    }
}
