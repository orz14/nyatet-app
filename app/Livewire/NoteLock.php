<?php

namespace App\Livewire;

use App\Models\Note;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class NoteLock extends Component
{
    public $passwordLock;
    public function render()
    {
        return view('livewire.note-lock');
    }

    public function lock($slug)
    {
        $note = Note::whereSlug($slug)->first();
        if ($this->passwordLock) {
            try {
                $note->update(['password' => Hash::make($this->passwordLock)]);

                return $this->redirect('/note', navigate: true);
            } catch (\Throwable $err) {
                Log::error($err->getMessage());

                return $this->redirect('/note', navigate: true);
            }
        }
    }
}
