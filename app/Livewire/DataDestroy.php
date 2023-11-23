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

    public function destroyItem($data, $msg)
    {
        if ($data->user_id == auth()->user()->id) {
            try {
                $data->delete();

                session()->flash('toastStatus', $msg);

                return $this->redirect(url()->previous(), navigate: true);
            } catch (\Throwable $err) {
                Log::error($err->getMessage());
                $this->dispatch('nyatetError');
            }
        } else {
            $this->dispatch('nyatetNotMine');
        }
    }

    public function noteDestroy($slug)
    {
        $data = Note::whereSlug($slug)->first();
        $this->destroyItem($data, 'Catatan berhasil dihapus.');
    }

    public function todoDestroy($slug)
    {
        $data = Todo::whereSlug($slug)->first();
        $this->destroyItem($data, 'List Berhasil Dihapus.');
    }
}
