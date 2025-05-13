<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    public function getAllNote()
    {
        $paginate = Note::whereUserId(auth()->user()->id)->orderBy('updated_at', 'desc')->simplePaginate(10);
        $data = $paginate->getCollection()->map(function ($item) {
            $item->title = $item->title ? $item->decrypt($item->title) : null;
            $item->note = 'hidden';

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
            Note::create([
                'user_id' => auth()->user()->id,
                'slug' => substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10),
                'title' => $request->title ? Crypt::encryptString($request->title) : null,
                'note' => Crypt::encryptString($request->note)
            ]);

            return Response::success('Catatan Berhasil Ditambahkan.', null, 201);
        } catch (\Exception $err) {
            Log::error($err->getMessage());

            return Response::error('Internal Server Error');
        }
    }

    public function getNote($slug)
    {
        $note = Note::whereSlug($slug)->first();
        if (!$note) {
            return Response::error('Catatan Tidak Ditemukan.', null, 404);
        }

        if ($note->user_id == auth()->user()->id) {
            if (!isset($note->password)) {
                $note->title = $note->title ? $note->decrypt($note->title) : null;
                $note->note = $note->decrypt($note->note);

                return Response::success(null, ['data' => $note]);
            } else {
                return Response::error('Akses Ditolak.', null, 403);
            }
        }

        return Response::error('Anda Tidak Memiliki Akses.', null, 403);
    }

    public function update(Request $request, $slug)
    {
        $note = Note::whereSlug($slug)->first();
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
                    $note->update([
                        'title' => $request->title ? $note->encrypt($request->title) : null,
                        'note' => $note->encrypt($request->note)
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
        $note = Note::whereSlug($slug)->first();
        if (!$note) {
            return Response::error('Catatan Tidak Ditemukan.', null, 404);
        }

        if ($note->user_id == auth()->user()->id) {
            if (!isset($note->password)) {
                try {
                    $note->delete();

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
        $note = Note::whereSlug($slug)->first();
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
                    $note->update(['password' => Hash::make($request->password)]);

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
        $note = Note::whereSlug($slug)->first();
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
                        $note->update(['password' => null]);

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
