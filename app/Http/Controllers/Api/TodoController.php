<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    public function getAllTodo()
    {
        $data = DB::table('todos')->whereUserId(auth()->user()->id)
            ->whereDate('created_at', Carbon::today())
            ->get(['slug', 'content', 'is_done', 'date', 'created_at', 'updated_at'])
            ->map(function ($item) {
                $item->content = Crypt::decryptString($item->content);
                return $item;
            });

        return Response::success(null, ['todos' => $data]);
    }

    public function getAllHistoryTodo()
    {
        $paginate = DB::table('todos')
            ->whereUserId(auth()->user()->id)
            ->whereDate('created_at', '!=', Carbon::today())->latest()
            ->simplePaginate(20, ['slug', 'content', 'is_done', 'date', 'created_at', 'updated_at']);

        $data = $paginate->groupBy('date')->map(function ($group) {
            return $group->map(function ($item) {
                $item->content = Crypt::decryptString($item->content);
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
            DB::table('todos')->insert([
                'user_id' => auth()->user()->id,
                'slug' => substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10),
                'content' => Crypt::encryptString($request->content),
                'date' => date('Y-m-d'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            return Response::success('List Berhasil Ditambahkan.', null, 201);
        } catch (\Exception $err) {
            Log::error($err->getMessage());

            return Response::error('Internal Server Error');
        }
    }

    public function changeStatus($slug)
    {
        $todo = DB::table('todos')->whereSlug($slug)->first(['user_id', 'is_done']);
        if (!$todo) {
            return Response::error('Todo Tidak Ditemukan.', null, 404);
        }

        if ($todo->user_id == auth()->user()->id) {
            if (!$todo->is_done) {
                try {
                    DB::table('todos')->whereSlug($slug)->update([
                        'is_done' => true,
                        'updated_at' => Carbon::now()
                    ]);

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
        $todo = DB::table('todos')->whereSlug($slug)->first(['user_id', 'content']);
        if (!$todo) {
            return Response::error('Todo Tidak Ditemukan.', null, 404);
        }

        if ($todo->user_id == auth()->user()->id) {
            $todo->content = Crypt::decryptString($todo->content);
            unset($todo->user_id);

            return Response::success(null, ['data' => $todo]);
        }

        return Response::error('Anda Tidak Memiliki Akses.', null, 403);
    }

    public function update(Request $request, $slug)
    {
        $todo = DB::table('todos')->whereSlug($slug)->first(['user_id']);
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
                DB::table('todos')->whereSlug($slug)->update([
                    'content' => Crypt::encryptString($request->todo),
                    'updated_at' => Carbon::now()
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
        $todo = DB::table('todos')->whereSlug($slug)->first(['user_id']);
        if (!$todo) {
            return Response::error('Todo Tidak Ditemukan.', null, 404);
        }

        if ($todo->user_id == auth()->user()->id) {
            try {
                DB::table('todos')->whereSlug($slug)->delete();

                return Response::success('List Berhasil Dihapus.');
            } catch (\Exception $err) {
                Log::error($err->getMessage());

                return Response::error('Internal Server Error');
            }
        }

        return Response::error('Anda Tidak Memiliki Akses.', null, 403);
    }
}
