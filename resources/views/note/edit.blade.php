@extends('layouts.app')
@section('hero')
<x-hero-title>{{ __('Edit Catatan') }}</x-hero-title>
@endsection

@section('content')
<div class="mb-4 bg-white rounded-lg shadow-md card">
    <div class="card-body">
        <form method="POST" action="{{ route('note.update', $data->slug) }}" autocomplete="off">
            @csrf
            @method('PATCH')
            {{-- Title --}}
            <x-form-input type="text" name="title" ph="Masukkan Judul Catatan" value="{{ old('title', isset($data->title) ? $data->decrypt($data->title) : '') }}">{{ __('Title') }}</x-form-input>
            
            {{-- Note --}}
            <x-ckeditor name="note" ph="Masukkan Catatan" value="{!! old('note', $data->decrypt($data->note)) !!}">{{ __('Note') }}</x-ckeditor>
            
            <div class="flex gap-2 sm:justify-end">
                <div class="max-[639px]:w-full">
                    <a href="{{ route('note.index') }}" class="text-white border-none bg-slate-400 btn max-[639px]:btn-block hover:bg-slate-500" wire:navigate.hover>
                        {{ __('Kembali') }}
                    </a>
                </div>
                <div class="max-[639px]:w-full">
                    <button type="submit" class="text-white bg-teal-500 border-none btn max-[639px]:btn-block hover:bg-teal-600">
                        {{ __('Simpan') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
