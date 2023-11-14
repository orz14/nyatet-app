<?php

namespace App\Livewire;

use App\Models\Note;
use Livewire\Component;

class NoteDestroy extends Component
{
    public function render()
    {
        return view('livewire.note-destroy');
    }

    public function destroy($slug)
    {
        $note = Note::whereSlug($slug)->first();
        $note->delete();

        return $this->redirect('/note', navigate: true);
    }
}
