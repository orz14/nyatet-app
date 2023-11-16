<?php

namespace App\Http\Controllers;

class TodoController extends Controller
{
    public function index()
    {
        return view('todo.index', [
            'title' => 'Todo List',
            'modalDelete' => true,
        ]);
    }

    public function history()
    {
        return view('todo.history', [
            'title' => 'History List',
            'modalDelete' => true,
        ]);
    }
}
