<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class NoteController extends Controller
{
    public function index()
    {
        $datas = Note::whereUserId(auth()->user()->id)->orderBy('updated_at', 'desc')->paginate(20);
        
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
        
        try {
            Note::create($validatedData);
            return to_route('note.index')->with('status', 'Catatan Berhasil Ditambahkan.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return to_route('note.index')->with('err', '[500] Server Error');
        }
    }
    
    public function edit(Note $note)
    {
        if($note->user_id == auth()->user()->id) {
            if(!isset($note->password)) {
                return view('note.edit', [
                    'title' => 'Edit Note',
                    'data' => $note,
                    'ckeditor' => true,
                ]);
            } else {
                return to_route('note.index')->with('err', 'Akses Ditolak.');
            }
        } else {
            return to_route('note.index')->with('err', 'Anda Tidak Memiliki Akses.');
        }
    }
    
    public function update(Request $request, Note $note)
    {
        if($note->user_id == auth()->user()->id) {
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
            
            try {
                $note->update($validatedData);
                return to_route('note.index')->with('status', 'Catatan Berhasil Diedit.');
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                return to_route('note.index')->with('err', '[500] Server Error');
            }
        } else {
            return to_route('note.index')->with('err', 'Anda Tidak Memiliki Akses.');
        }
    }
    
    public function lock(Request $request, Note $note)
    {
        if($note->user_id == auth()->user()->id) {
            if($request->password) {
                try {
                    $note->update(['password' => Hash::make($request->password)]);
                    return back()->with('status', 'Password Berhasil Disimpan.');
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    return back()->with('err', '[500] Server Error');
                }
            }
        } else {
            return to_route('note.index')->with('err', 'Anda Tidak Memiliki Akses.');
        }
    }
    
    public function unlock(Request $request, Note $note)
    {
        if($note->user_id == auth()->user()->id) {
            if($request->password) {
                if(Hash::check($request->password, $note->password)) {
                    try {
                        $note->update(['password' => null]);
                        return back()->with('status', 'Catatan Berhasil Dibuka.');
                    } catch (\Exception $e) {
                        Log::error($e->getMessage());
                        return back()->with('err', '[500] Server Error');
                    }
                } else {
                    return back()->with('err', 'Password Yang Anda Masukkan Salah.');
                }
            }
        } else {
            return to_route('note.index')->with('err', 'Anda Tidak Memiliki Akses.');
        }
    }
    
    public function destroy(Note $note)
    {
        if($note->user_id == auth()->user()->id) {
            try {
                $note->delete();
                return back()->with('status', 'Catatan Berhasil Dihapus.');
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                return back()->with('err', '[500] Server Error');
            }
        } else {
            return to_route('note.index')->with('err', 'Anda Tidak Memiliki Akses.');
        }
    }
}
