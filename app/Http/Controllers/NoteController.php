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
