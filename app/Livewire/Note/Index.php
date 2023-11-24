<?php

namespace App\Livewire\Note;

use App\Models\Note;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        $datas = Note::whereUserId(auth()->user()->id)->orderBy('updated_at', 'desc')->simplePaginate(10);

        return view('livewire.note.index', [
            'datas' => $datas,
        ]);
    }

    public function placeholder(array $params = [])
    {
        return view('livewire.placeholder', $params);
    }
}
