<?php

namespace App\Livewire;

use App\Models\Todo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class TodoList extends Component
{
    public $datas = [];

    public function render()
    {
        $this->datas = Todo::whereUserId(auth()->user()->id)->whereDate('created_at', Carbon::today())->get();

        return view('livewire.todo-list');
    }

    #[On('todoAdded')]
    public function todoAdded()
    {
        $this->datas = Todo::whereUserId(auth()->user()->id)->whereDate('created_at', Carbon::today())->get();
    }

    public function update($slug)
    {
        $todo = Todo::whereSlug($slug)->first();

        if ($todo->user_id === auth()->user()->id) {
            try {
                $todo->update(['is_done' => true]);
            } catch (\Throwable $err) {
                Log::error($err->getMessage());

                $this->dispatch('todoError');
            }
        } else {
            $this->dispatch('todoNotMine');
        }
    }

    public function destroy($slug)
    {
        $todo = Todo::whereSlug($slug)->first();

        if ($todo->user_id === auth()->user()->id) {
            try {
                $todo->delete();
            } catch (\Throwable $err) {
                Log::error($err->getMessage());

                $this->dispatch('todoError');
            }
        } else {
            $this->dispatch('todoNotMine');
        }
    }
}
