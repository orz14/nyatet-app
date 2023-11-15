<?php

namespace App\Livewire;

use App\Models\Todo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class HistoryTodoList extends Component
{
    public function render()
    {
        $todos = Todo::whereUserId(auth()->user()->id)->whereDate('created_at', '!=', Carbon::today())->latest()->paginate(20);
        $datas = $todos->groupBy('date');

        return view('livewire.history-todo-list', [
            'datas' => $datas,
            'paginate' => $todos,
        ]);
    }

    public function update($slug)
    {
        $todo = Todo::whereSlug($slug)->first();

        if ($todo->user_id === auth()->user()->id) {
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

    public function destroy($slug)
    {
        $todo = Todo::whereSlug($slug)->first();

        if ($todo->user_id === auth()->user()->id) {
            try {
                $todo->delete();
            } catch (\Throwable $err) {
                Log::error($err->getMessage());

                $this->dispatch('nyatetError');
            }
        } else {
            $this->dispatch('nyatetNotMine');
        }
    }
}
