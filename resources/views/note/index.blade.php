@extends('layouts.app')
@section('hero')
<h1 class="text-2xl font-normal sm:text-3xl md:text-4xl lg:font-light lg:text-6xl">
    {{ __('Catatan') }}
</h1>

{{-- Session Status --}}
<x-session-status />

<a href="{{ route('note.create') }}" class="text-white bg-teal-500 border-none btn hover:bg-teal-600 mt-7">{{ __('Tambahkan Catatan') }}</a>
@endsection

@section('content')
@if ($datas->count())
@foreach ($datas as $data)
<div class="mb-4 transition-all duration-300 ease-in-out bg-white border-4 rounded-none border-teal-400/50 card hover:border-teal-400">
    <div class="p-4 leading-none card-body">
        <div class="flex items-center justify-between">
            <a href="{{ route('note.edit', $data->slug) }}">
                <div class="font-bold underline">{{ isset($data->title) ? $data->decrypt($data->title) : 'Tanpa Judul' }}</div>
                <div class="text-xs font-bold">{{ \Carbon\Carbon::parse($data->updated_at)->translatedFormat('Y/m/d H:i') }}</div>
            </a>
            <div>
                <form method="POST" action="{{ route('note.destroy', $data->slug) }}" class="block sm:inline-block">
                    @csrf
                    @method('DELETE')
                    <x-todo-button class="text-red-600 bg-red-100 hover:bg-red-200" icon="trash-2" />
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
<div class="mb-4">
    {{ $datas->links() }}
</div>
@else
<x-blank>{{ __('Tidak ada catatan.') }}</x-blank>
@endif
@endsection
