<?php

namespace App\Livewire;

use App\Models\Todo;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class TodoForm extends Component
{
    public $content;

    protected $rules = [
        'content' => ['required', 'string'],
    ];

    public function render()
    {
        return view('livewire.todo-form');
    }

    public function saveTodo()
    {
        $validatedData = $this->validate($this->rules, ['content.required' => 'Tidak Boleh Kosong.']);
        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['slug'] = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10);
        $validatedData['content'] = Crypt::encryptString($validatedData['content']);
        $validatedData['date'] = date('Y-m-d');

        try {
            Todo::create($validatedData);

            $this->content = '';
            $this->dispatch('todoAdded');
        } catch (\Throwable $err) {
            Log::error($err->getMessage());

            $this->dispatch('todoError');
        }
    }
}
