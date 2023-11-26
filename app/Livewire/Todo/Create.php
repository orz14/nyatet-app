<?php

namespace App\Livewire\Todo;

use App\Models\Todo;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Create extends Component
{
    #[Rule('required', message: 'Tidak Boleh Kosong.')]
    public $content = '';

    public function render()
    {
        return view('livewire.todo.create');
    }

    public function store()
    {
        $this->validate();
        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['slug'] = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10);
        $validatedData['content'] = Crypt::encryptString($this->content);
        $validatedData['date'] = date('Y-m-d');

        try {
            Todo::create($validatedData);

            $this->content = '';
            $this->dispatch('todoAdded');
        } catch (\Throwable $err) {
            Log::error($err->getMessage());

            $this->dispatch('nyatetError');
        }
    }
}
