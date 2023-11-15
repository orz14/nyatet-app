<?php

namespace App\Livewire;

use App\Models\Note;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class NoteUnlock extends Component
{
    public $passwordUnlock;
    public function render()
    {
        return view('livewire.note-unlock');
    }

    public function unlock($slug)
    {
        $note = Note::whereSlug($slug)->first();

        if ($note->user_id === auth()->user()->id) {
            if ($this->passwordUnlock) {
                if (Hash::check($this->passwordUnlock, $note->password)) {
                    try {
                        $note->update(['password' => null]);

                        return $this->redirect('/note', navigate: true);
                    } catch (\Throwable $err) {
                        Log::error($err->getMessage());

                        $this->dispatch('nyatetError');
                    }
                } else {
                    session()->flash('err', 'Password Yang Anda Masukkan Salah.');
                }
            }
        } else {
            $this->dispatch('nyatetNotMine');
        }
    }
}
