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

        if ($note->user_id == auth()->user()->id) {
            if ($this->passwordLock) {
                try {
                    $note->update(['password' => Hash::make($this->passwordLock)]);

                    session()->flash('toastStatus', 'Catatan Berhasil Dikunci.');

                    return $this->redirect('/note', navigate: true);
                } catch (\Throwable $err) {
                    Log::error($err->getMessage());

                    $this->dispatch('nyatetError');
                }
            }
        } else {
            $this->dispatch('nyatetNotMine');
        }
    }
}
