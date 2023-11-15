<?php

namespace App\Livewire;

use App\Models\Note;
use Illuminate\Support\Facades\Log;
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

        if ($note->user_id === auth()->user()->id) {
            try {
                $note->delete();

                return $this->redirect('/note', navigate: true);
            } catch (\Throwable $err) {
                Log::error($err->getMessage());

                $this->dispatch('nyatetError');
            }
        } else {
            $this->dispatch('nyatetNotMine');
        }
    }
}
