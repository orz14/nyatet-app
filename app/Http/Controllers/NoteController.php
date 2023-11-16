<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class NoteController extends Controller
{
    public function index()
    {
        $datas = Note::whereUserId(auth()->user()->id)->orderBy('updated_at', 'desc')->paginate(10);

        return view('note.index', [
            'title' => 'Note',
            'datas' => $datas,
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

            return to_route('note.index')->with('toastStatus', 'Catatan Berhasil Ditambahkan.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return to_route('note.index')->with('toastErr', '[500] Server Error');
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
                return to_route('note.index')->with('toastErr', 'Akses Ditolak.');
            }
        } else {
            return to_route('note.index')->with('toastErr', 'Anda Tidak Memiliki Akses.');
        }
    }

    public function update(Request $request, Note $note)
    {
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

                return to_route('note.index')->with('toastStatus', 'Catatan Berhasil Disimpan.');
            } catch (\Exception $e) {
                Log::error($e->getMessage());

                return to_route('note.index')->with('toastErr', '[500] Server Error');
            }
        } else {
            return to_route('note.index')->with('toastErr', 'Anda Tidak Memiliki Akses.');
        }
    }
}
