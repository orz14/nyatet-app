<?php

namespace App\Livewire\Note;

use App\Models\Note;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Lock extends Component
{
    #[Rule(['required'])]
    public $passwordLock = '';

    public function render()
    {
        return view('livewire.note.lock');
    }

    public function lock($slug)
    {
        $this->validate();
        $note = Note::whereSlug($slug)->first();

        if ($note->user_id == auth()->user()->id) {
            if ($this->passwordLock) {
                try {
                    $note->update(['password' => Hash::make($this->passwordLock)]);

                    flash('Catatan Berhasil Dikunci.');

                    return $this->redirectRoute('note.index', navigate: true);
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
