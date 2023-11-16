<?php

namespace App\Livewire;

use App\Models\Note;
use App\Models\Todo;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class DataDestroy extends Component
{
    public function render()
    {
        return view('livewire.data-destroy');
    }

    public function noteDestroy($slug)
    {
        $note = Note::whereSlug($slug)->first();

        if ($note->user_id === auth()->user()->id) {
            try {
                $note->delete();

                return $this->redirect(url()->previous(), navigate: true);
            } catch (\Throwable $err) {
                Log::error($err->getMessage());

                $this->dispatch('nyatetError');
            }
        } else {
            $this->dispatch('nyatetNotMine');
        }
    }
    
    public function todoDestroy($slug)
    {
        $todo = Todo::whereSlug($slug)->first();

        if ($todo->user_id === auth()->user()->id) {
            try {
                $todo->delete();

                return $this->redirect(url()->previous(), navigate: true);
            } catch (\Throwable $err) {
                Log::error($err->getMessage());

                $this->dispatch('nyatetError');
            }
        } else {
            $this->dispatch('nyatetNotMine');
        }
    }
}
