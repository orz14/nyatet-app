@extends('layouts.app')
@section('hero')
<h1 class="text-2xl font-normal sm:text-3xl md:text-4xl lg:font-light lg:text-6xl">
    {{ __('Tambah Catatan') }}
</h1>
@endsection

@section('content')
<div class="mb-4 bg-white border-4 rounded-none border-teal-400/50 card">
    <div class="card-body">
        <form method="POST" action="{{ route('note.store') }}">
            @csrf
            {{-- Title --}}
            <x-form-input type="text" name="title" ph="Masukkan Judul Catatan" value="{{ old('title') }}" autofocus>{{ __('Title') }}</x-form-input>
            
            {{-- Note --}}
            <x-ckeditor name="note" ph="Masukkan Catatan" value="{!! old('note') !!}">{{ __('Note') }}</x-ckeditor>
            
            <div class="text-right">
                <a href="{{ route('note.index') }}" class="text-white border-none bg-slate-400 btn hover:bg-slate-500">
                    {{ __('Kembali') }}
                </a>
                <button type="submit" class="text-white bg-teal-500 border-none btn hover:bg-teal-600">
                    {{ __('Simpan') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
