@extends('layouts.app')
@section('hero')
<x-hero-title>{{ __('History List') }}</x-hero-title>

{{-- Session Status --}}
<x-session-status />

<a href="{{ route('todo.index') }}" class="text-white bg-teal-500 border-none btn hover:bg-teal-600 mt-7">{{ __('Tulis List') }}</a>
@endsection

@section('content')
@if ($datas->count())
@foreach ($datas as $data)
<div class="mb-4 transition-all duration-300 ease-in-out bg-white rounded-lg shadow-md card hover:shadow-lg @if($data->is_done) todo-hijau @else todo-merah @endif">
    <div class="px-3 py-2 leading-none card-body">
        <div class="flex items-center justify-between">
            <div class="pr-2">
                <div class="text-xs font-bold">{{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('l, d F Y') }}</div>
                <div>{{ $data->decrypt($data->content) }}</div>
            </div>
            <div class="text-right">
                <x-todo-button x-data x-on:click="modal_delete_open('{{ route('todo.destroy', $data->slug) }}')" class="text-red-600 bg-red-100 hover:bg-red-200" icon="trash-2" />
                    
                @if($data->is_done == false)
                <form method="POST" action="{{ route('todo.update', $data->slug) }}" class="inline-block">
                    @csrf
                    @method('PATCH')
                    <x-todo-button class="text-green-600 bg-green-100 hover:bg-green-200" icon="check" />
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach
<div class="mb-4">
    {{ $datas->links() }}
</div>
@else
<x-blank>{{ __('Tidak ada history.') }}</x-blank>
@endif
@endsection
