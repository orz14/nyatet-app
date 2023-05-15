<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class TodoController extends Controller
{
    public function index()
    {
        $today = date('Y-m-d');
        $datas = Todo::whereUserId(auth()->user()->id)->where('date', $today)->get();

        return view('todo.index', [
            'title' => 'Todo List',
            'datas' => $datas,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'content' => ['required', 'string'],
        ]);
        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['slug'] = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10);
        $validatedData['content'] = Crypt::encryptString($request->content);
        $validatedData['date'] = date('Y-m-d');

        Todo::create($validatedData);
        return back();
    }

    public function update(Todo $todo)
    {
        $todo->update(['is_done' => true]);
        return back();
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        return back();
    }

    public function history()
    {
        $today = date('Y-m-d');
        $datas = Todo::whereUserId(auth()->user()->id)->where('date', '!=', $today)->latest()->paginate(20);

        return view('todo.history', [
            'title' => 'History List',
            'datas' => $datas,
        ]);
    }
}
