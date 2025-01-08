<?php

namespace App\Http\Controllers\Api;

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

        return response()->json([
            'status' => true,
            'statusCode' => 200,
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
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['nullable', 'string', 'max:200'],
            'note' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'statusCode' => 422,
                'message' => $validator->errors()
            ], 422);
        }

        try {
            Note::create([
                'user_id' => auth()->user()->id,
                'slug' => substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10),
                'title' => $request->title ? Crypt::encryptString($request->title) : null,
                'note' => Crypt::encryptString($request->note)
            ]);

            return response()->json([
                'status' => true,
                'statusCode' => 201,
                'message' => 'Catatan Berhasil Ditambahkan.'
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

    public function getNote($slug)
    {
        $note = Note::whereSlug($slug)->first();
        if (!$note) {
            return response()->json([
                'status' => false,
                'statusCode' => 404,
                'message' => 'Catatan Tidak Ditemukan.'
            ], 404);
        }

        if ($note->user_id == auth()->user()->id) {
            if (!isset($note->password)) {
                $note->title = $note->title ? $note->decrypt($note->title) : null;
                $note->note = $note->decrypt($note->note);

                return response()->json([
                    'status' => true,
                    'statusCode' => 200,
                    'data' => $note
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'statusCode' => 403,
                    'message' => 'Akses Ditolak.'
                ], 403);
            }
        }

        return response()->json([
            'status' => false,
            'statusCode' => 403,
            'message' => 'Anda Tidak Memiliki Akses.'
        ], 403);
    }

    public function update(Request $request, $slug)
    {
        $note = Note::whereSlug($slug)->first();
        if (!$note) {
            return response()->json([
                'status' => false,
                'statusCode' => 404,
                'message' => 'Catatan Tidak Ditemukan.'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => ['nullable', 'string', 'max:200'],
            'note' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'statusCode' => 422,
                'message' => $validator->errors()
            ], 422);
        }

        if ($note->user_id == auth()->user()->id) {
            if (!isset($note->password)) {
                try {
                    $note->update([
                        'title' => $request->title ? $note->encrypt($request->title) : null,
                        'note' => $note->encrypt($request->note)
                    ]);

                    return response()->json([
                        'status' => true,
                        'statusCode' => 200,
                        'message' => 'Catatan Berhasil Disimpan.'
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
                    'statusCode' => 403,
                    'message' => 'Akses Ditolak.'
                ], 403);
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
        $note = Note::whereSlug($slug)->first();
        if (!$note) {
            return response()->json([
                'status' => false,
                'statusCode' => 404,
                'message' => 'Catatan Tidak Ditemukan.'
            ], 404);
        }

        if ($note->user_id == auth()->user()->id) {
            if (!isset($note->password)) {
                try {
                    $note->delete();

                    return response()->json([
                        'status' => true,
                        'statusCode' => 200,
                        'message' => 'Catatan berhasil dihapus.'
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
                    'statusCode' => 403,
                    'message' => 'Akses Ditolak.'
                ], 403);
            }
        }

        return response()->json([
            'status' => false,
            'statusCode' => 403,
            'message' => 'Anda Tidak Memiliki Akses.'
        ], 403);
    }

    public function lock(Request $request, $slug)
    {
        $note = Note::whereSlug($slug)->first();
        if (!$note) {
            return response()->json([
                'status' => false,
                'statusCode' => 404,
                'message' => 'Catatan Tidak Ditemukan.'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'password' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'statusCode' => 422,
                'message' => $validator->errors()
            ], 422);
        }

        if ($note->user_id == auth()->user()->id) {
            if (!isset($note->password)) {
                try {
                    $note->update(['password' => Hash::make($request->password)]);

                    return response()->json([
                        'status' => true,
                        'statusCode' => 200,
                        'message' => 'Catatan Berhasil Dikunci.'
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
                    'message' => 'Catatan Sudah Dikunci.'
                ], 400);
            }
        }

        return response()->json([
            'status' => false,
            'statusCode' => 403,
            'message' => 'Anda Tidak Memiliki Akses.'
        ], 403);
    }

    public function unlock(Request $request, $slug)
    {
        $note = Note::whereSlug($slug)->first();
        if (!$note) {
            return response()->json([
                'status' => false,
                'statusCode' => 404,
                'message' => 'Catatan Tidak Ditemukan.'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'password' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'statusCode' => 422,
                'message' => $validator->errors()
            ], 422);
        }

        if ($note->user_id == auth()->user()->id) {
            if (isset($note->password)) {
                if (Hash::check($request->password, $note->password)) {
                    try {
                        $note->update(['password' => null]);

                        return response()->json([
                            'status' => true,
                            'statusCode' => 200,
                            'message' => 'Catatan Berhasil Dibuka.'
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
                        'message' => 'Password Yang Anda Masukkan Salah.'
                    ], 400);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'statusCode' => 400,
                    'message' => 'Catatan Tidak Dikunci.'
                ], 400);
            }
        }

        return response()->json([
            'status' => false,
            'statusCode' => 403,
            'message' => 'Anda Tidak Memiliki Akses.'
        ], 403);
    }
}
