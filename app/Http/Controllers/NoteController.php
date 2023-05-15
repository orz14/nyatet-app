<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class NoteController extends Controller
{
    public function index()
    {
        $datas = Note::whereUserId(auth()->user()->id)->orderBy('updated_at', 'desc')->paginate(20);

        return view('note.index', [
            'title' => 'Note',
            'datas' => $datas,
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
        $rules = [
            'note' => ['required', 'string'],
        ];
        if($request->title) {
            $rules['title'] = ['string'];
        }

        $validatedData = $request->validate($rules);
        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['slug'] = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10);
        $validatedData['note'] = Crypt::encryptString($request->note);
        if($request->title) {
            $validatedData['title'] = Crypt::encryptString($request->title);
        } else {
            $validatedData['title'] = null;
        }

        Note::create($validatedData);
        return to_route('note.index');
    }

    public function edit(Note $note)
    {
        return view('note.edit', [
            'title' => 'Edit Note',
            'data' => $note,
            'ckeditor' => true,
        ]);
    }

    public function update(Request $request, Note $note)
    {
        $rules = [
            'note' => ['required', 'string'],
        ];
        if($request->title) {
            $rules['title'] = ['string'];
        }

        $validatedData = $request->validate($rules);
        $validatedData['note'] = Crypt::encryptString($request->note);
        if($request->title) {
            $validatedData['title'] = Crypt::encryptString($request->title);
        } else {
            $validatedData['title'] = null;
        }

        $note->update($validatedData);
        return to_route('note.index');
    }
}
