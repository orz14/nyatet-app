<?php

namespace App\Livewire\Todo;

use App\Models\Todo;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Edit extends Component
{
    #[Rule(['required', 'string'])]
    public $editValue = '';

    public function render()
    {
        return view('livewire.todo.edit');
    }

    public function update($slug)
    {
        $this->validate();
        $validatedData['content'] = Crypt::encryptString($this->editValue);
        $todo = Todo::whereSlug($slug)->first();

        if ($todo->user_id == auth()->user()->id) {
            try {
                $todo->update($validatedData);

                flash('Todo Berhasil Diperbarui.');

                return $this->redirectRoute('todo.index', navigate: true);
            } catch (\Throwable $err) {
                Log::error($err->getMessage());

                $this->dispatch('nyatetError');
            }
        } else {
            $this->dispatch('nyatetNotMine');
        }
    }
}
