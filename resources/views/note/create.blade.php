@extends('layouts.app')
@section('hero')
<x-hero-title>{{ __('Tambah Catatan') }}</x-hero-title>
@endsection

@section('content')
<div class="mb-4 bg-white rounded-lg shadow-md card">
    <div class="card-body">
        <form method="POST" action="{{ route('note.store') }}" autocomplete="off">
            @csrf
            {{-- Title --}}
            <x-form-input :name="__('title')" :ph="__('Masukkan Judul Catatan')" :value="old('title')" autofocus>{{ __('Title') }}</x-form-input>
            
            {{-- Note --}}
            <x-ckeditor :name="__('note')" :ph="__('Masukkan Catatan')" :value="old('note')">{{ __('Note') }}</x-ckeditor>
            
            <div class="flex gap-2 sm:justify-end">
                <div class="max-[639px]:w-full">
                    <a href="{{ route('note.index') }}" class="text-white border-none bg-slate-400 btn max-[639px]:btn-block hover:bg-slate-500" role="button" aria-label="Kembali" wire:navigate.hover>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 mr-1 md:w-4 md:h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                        {{ __('Kembali') }}
                    </a>
                </div>
                <div class="max-[639px]:w-full">
                    <button type="submit" class="text-white bg-teal-500 border-none btn max-[639px]:btn-block hover:bg-teal-600" role="button" aria-label="Simpan">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="fill: #fff;transform: ;msFilter:;" class="w-4 h-4 mr-1 md:w-5 md:h-5">
                            <path d="M5 21h14a2 2 0 0 0 2-2V8a1 1 0 0 0-.29-.71l-4-4A1 1 0 0 0 16 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2zm10-2H9v-5h6zM13 7h-2V5h2zM5 5h2v4h8V5h.59L19 8.41V19h-2v-5a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v5H5z"></path>
                        </svg>
                        {{ __('Simpan') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
