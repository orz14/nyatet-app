<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    public function index()
    {
        return view('note.index', [
            'title' => 'Note',
            'modalDelete' => true,
            'modalLock' => true,
        ]);
    }

    public function create()
    {
        return view('note.create', [
            'title' => 'Add Note',
            'ckeditor' => true,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['nullable', 'string'],
            'note' => ['required', 'string'],
        ]);
        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['slug'] = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10);
        $validatedData['note'] = Crypt::encryptString($validatedData['note']);
        if ($request->title) {
            $validatedData['title'] = Crypt::encryptString($validatedData['title']);
        } else {
            $validatedData['title'] = null;
        }

        try {
            Note::create($validatedData);

            flash('Catatan Berhasil Ditambahkan.');

            return to_route('note.index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            flash('[500] Server Error', 'err');

            return to_route('note.index');
        }
    }

    public function edit(Note $note)
    {
        if ($note->user_id == auth()->user()->id) {
            if (! isset($note->password)) {
                return view('note.edit', [
                    'title' => 'Edit Note',
                    'data' => $note,
                    'ckeditor' => true,
                ]);
            } else {
                flash('Akses Ditolak.', 'err');

                return to_route('note.index');
            }
        } else {
            flash('Anda Tidak Memiliki Akses.', 'err');

            return to_route('note.index');
        }
    }

    public function update(Request $request, Note $note)
    {
        if ($request->isMethod('GET')) {
            return to_route('note.edit', $note->slug);
        } elseif ($request->isMethod('PATCH')) {
            if ($note->user_id == auth()->user()->id) {
                $validatedData = $request->validate([
                    'title' => ['nullable', 'string'],
                    'note' => ['required', 'string'],
                ]);
                $validatedData['note'] = Crypt::encryptString($validatedData['note']);
                if ($request->title) {
                    $validatedData['title'] = Crypt::encryptString($validatedData['title']);
                } else {
                    $validatedData['title'] = null;
                }

                try {
                    $note->update($validatedData);

                    flash('Catatan Berhasil Disimpan.');

                    return to_route('note.index');
                } catch (\Exception $e) {
                    Log::error($e->getMessage());

                    flash('[500] Server Error', 'err');

                    return to_route('note.index');
                }
            } else {
                flash('Anda Tidak Memiliki Akses.', 'err');

                return to_route('note.index');
            }
        }
    }

    public function apiIndex()
    {
        $paginate = Note::whereUserId(auth()->user()->id)->orderBy('updated_at', 'desc')->simplePaginate(10);
        $data = $paginate->getCollection()->map(function ($item) {
            $item->title = $item->title ? $item->decrypt($item->title) : null;
            $item->note = 'hidden';

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
            'notes' => $data,
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
            'title' => ['nullable', 'string'],
            'note' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'statusCode' => 400,
                'message' => $validator->errors()
            ], 400);
        }

        try {
            Note::create([
                'user_id' => auth()->user()->id,
                'slug' => substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10),
                'title' => $request->title ? Crypt::encryptString($request->title): null,
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

    public function apiEdit($slug)
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

    public function apiUpdate(Request $request, $slug)
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
            'title' => ['nullable', 'string'],
            'note' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'statusCode' => 400,
                'message' => $validator->errors()
            ], 400);
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

    public function apiDestroy($slug)
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

    public function apiLock(Request $request, $slug)
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
                'statusCode' => 400,
                'message' => $validator->errors()
            ], 400);
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

    public function apiUnlock(Request $request, $slug)
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
                'statusCode' => 400,
                'message' => $validator->errors()
            ], 400);
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
