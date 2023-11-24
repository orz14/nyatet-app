<?php

namespace App\Livewire\Todo;

use App\Models\Todo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    public $datas = [];

    public function render()
    {
        $this->datas = Todo::whereUserId(auth()->user()->id)->whereDate('created_at', Carbon::today())->get();

        return view('livewire.todo.index');
    }

    #[On('todoAdded')]
    public function updateTodo()
    {
    }

    public function update($slug)
    {
        $todo = Todo::whereSlug($slug)->first();

        if ($todo->user_id == auth()->user()->id) {
            try {
                $todo->update(['is_done' => true]);
            } catch (\Throwable $err) {
                Log::error($err->getMessage());

                $this->dispatch('nyatetError');
            }
        } else {
            $this->dispatch('nyatetNotMine');
        }
    }
}
