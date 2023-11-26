<?php

namespace App\Livewire\Note;

use App\Models\Note;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Unlock extends Component
{
    #[Rule(['required'])]
    public $passwordUnlock = '';

    public function render()
    {
        return view('livewire.note.unlock');
    }

    public function unlock($slug)
    {
        $this->validate();
        $note = Note::whereSlug($slug)->first();

        if ($note->user_id == auth()->user()->id) {
            if ($this->passwordUnlock) {
                if (Hash::check($this->passwordUnlock, $note->password)) {
                    try {
                        $note->update(['password' => null]);

                        flash('Catatan Berhasil Dibuka.');

                        return $this->redirectRoute('note.index', navigate: true);
                    } catch (\Throwable $err) {
                        Log::error($err->getMessage());

                        $this->dispatch('nyatetError');
                    }
                } else {
                    flash('Password Yang Anda Masukkan Salah.', 'err');

                    return $this->redirect(url()->previous(), navigate: true);
                }
            }
        } else {
            $this->dispatch('nyatetNotMine');
        }
    }
}
