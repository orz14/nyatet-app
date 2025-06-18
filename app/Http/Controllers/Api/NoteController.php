<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    public function getAllNote()
    {
        $paginate = DB::table('notes')->whereUserId(auth()->user()->id)->orderBy('updated_at', 'desc')->simplePaginate(10, ['slug', 'title', 'created_at', 'updated_at']);
        $data = $paginate->getCollection()->map(function ($item) {
            $item->title = $item->title ? Crypt::decryptString($item->title) : null;
            return $item;
        });

        return Response::success(null, [
            'notes' => $data,
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
            'title' => ['nullable', 'string', 'max:200'],
            'note' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return Response::error($validator->errors(), null, 422);
        }

        try {
            DB::table('notes')->insert([
                'user_id' => auth()->user()->id,
                'slug' => substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10),
                'title' => $request->title ? Crypt::encryptString($request->title) : null,
                'note' => Crypt::encryptString($request->note),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            return Response::success('Catatan Berhasil Ditambahkan.', null, 201);
        } catch (\Exception $err) {
            Log::error($err->getMessage());

            return Response::error('Internal Server Error');
        }
    }

    public function getNote($slug)
    {
        $note = DB::table('notes')->whereSlug($slug)->first(['user_id', 'slug', 'title', 'note', 'password', 'created_at', 'updated_at']);
        if (!$note) {
            return Response::error('Catatan Tidak Ditemukan.', null, 404);
        }

        if ($note->user_id == auth()->user()->id) {
            if (!isset($note->password)) {
                unset($note->user_id, $note->password);
                $note->title = $note->title ? Crypt::decryptString($note->title) : null;
                $note->note = Crypt::decryptString($note->note);

                return Response::success(null, ['data' => $note]);
            } else {
                return Response::error('Akses Ditolak.', null, 403);
            }
        }

        return Response::error('Anda Tidak Memiliki Akses.', null, 403);
    }

    public function update(Request $request, $slug)
    {
        $note = DB::table('notes')->whereSlug($slug)->first(['user_id', 'password']);
        if (!$note) {
            return Response::error('Catatan Tidak Ditemukan.', null, 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => ['nullable', 'string', 'max:200'],
            'note' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return Response::error($validator->errors(), null, 422);
        }

        if ($note->user_id == auth()->user()->id) {
            if (!isset($note->password)) {
                try {
                    DB::table('notes')->whereSlug($slug)->update([
                        'title' => $request->title ? Crypt::encryptString($request->title) : null,
                        'note' => Crypt::encryptString($request->note),
                        'updated_at' => Carbon::now()
                    ]);

                    return Response::success('Catatan Berhasil Disimpan.');
                } catch (\Exception $err) {
                    Log::error($err->getMessage());

                    return Response::error('Internal Server Error');
                }
            } else {
                return Response::error('Akses Ditolak.', null, 403);
            }
        }

        return Response::error('Anda Tidak Memiliki Akses.', null, 403);
    }

    public function destroy($slug)
    {
        $note = DB::table('notes')->whereSlug($slug)->first(['user_id', 'password']);
        if (!$note) {
            return Response::error('Catatan Tidak Ditemukan.', null, 404);
        }

        if ($note->user_id == auth()->user()->id) {
            if (!isset($note->password)) {
                try {
                    DB::table('notes')->whereSlug($slug)->delete();

                    return Response::success('Catatan Berhasil Dihapus.');
                } catch (\Exception $err) {
                    Log::error($err->getMessage());

                    return Response::error('Internal Server Error');
                }
            } else {
                return Response::error('Akses Ditolak.', null, 403);
            }
        }

        return Response::error('Anda Tidak Memiliki Akses.', null, 403);
    }

    public function lock(Request $request, $slug)
    {
        $note = DB::table('notes')->whereSlug($slug)->first(['user_id', 'password']);
        if (!$note) {
            return Response::error('Catatan Tidak Ditemukan.', null, 404);
        }

        $validator = Validator::make($request->all(), [
            'password' => ['required']
        ]);

        if ($validator->fails()) {
            return Response::error($validator->errors(), null, 422);
        }

        if ($note->user_id == auth()->user()->id) {
            if (!isset($note->password)) {
                try {
                    DB::table('notes')->whereSlug($slug)->update([
                        'password' => Hash::make($request->password),
                        'updated_at' => Carbon::now()
                    ]);

                    return Response::success('Catatan Berhasil Dikunci.');
                } catch (\Exception $err) {
                    Log::error($err->getMessage());

                    return Response::error('Internal Server Error');
                }
            } else {
                return Response::error('Catatan Sudah Dikunci.', null, 400);
            }
        }

        return Response::error('Anda Tidak Memiliki Akses.', null, 403);
    }

    public function unlock(Request $request, $slug)
    {
        $note = DB::table('notes')->whereSlug($slug)->first(['user_id', 'password']);
        if (!$note) {
            return Response::error('Catatan Tidak Ditemukan.', null, 404);
        }

        $validator = Validator::make($request->all(), [
            'password' => ['required']
        ]);

        if ($validator->fails()) {
            return Response::error($validator->errors(), null, 422);
        }

        if ($note->user_id == auth()->user()->id) {
            if (isset($note->password)) {
                if (Hash::check($request->password, $note->password)) {
                    try {
                        DB::table('notes')->whereSlug($slug)->update([
                            'password' => null,
                            'updated_at' => Carbon::now()
                        ]);

                        return Response::success('Catatan Berhasil Dibuka.');
                    } catch (\Exception $err) {
                        Log::error($err->getMessage());

                        return Response::error('Internal Server Error');
                    }
                } else {
                    return Response::error('Password Yang Anda Masukkan Salah.', null, 400);
                }
            } else {
                return Response::error('Catatan Tidak Dikunci.', null, 400);
            }
        }

        return Response::error('Anda Tidak Memiliki Akses.', null, 403);
    }
}
