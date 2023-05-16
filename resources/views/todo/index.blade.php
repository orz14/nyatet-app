@extends('layouts.app')
@section('hero')
<h1 class="text-2xl font-normal sm:text-3xl md:text-4xl lg:font-light lg:text-6xl">
    {{ __('Apa Rencanamu Hari Ini ?') }}
</h1>

{{-- Session Status --}}
<x-session-status />

<div class="text-xl font-medium my-7">
    <form method="POST" action="{{ route('todo.store') }}">
        @csrf
        <div class="form-control">
            <div class="justify-center input-group">
                <input type="text" name="content" placeholder="Tulis Disini …" class="w-full truncate transition-all duration-300 ease-in-out text-slate-700 bg-teal-400/50 input placeholder:text-slate-500 focus:outline-none focus:ring focus:ring-teal-600/20 focus:border-teal-500" value="{{ old('content') }}" />
                <button type="submit" class="text-white bg-teal-700 border-teal-700 btn btn-square hover:bg-teal-900 hover:border-teal-900">
                    <i class="w-5" data-feather="plus"></i>
                </button>
            </div>
            <x-error name="content" />
        </div>
    </form>
</div>

<a href="{{ route('todo.history') }}" class="text-white bg-teal-500 border-none btn hover:bg-teal-600">{{ __('History List') }}</a>
@endsection

@section('content')
@if ($datas->count())
@foreach ($datas as $data)
<div class="mb-4 transition-all duration-300 ease-in-out bg-white border-4 rounded-none border-teal-400/50 card hover:border-teal-400 @if($data->is_done) todo-hijau @endif">
    <div class="p-4 card-body">
        <div class="flex items-center justify-between">
            <div class="pr-2">{{ $data->decrypt($data->content) }}</div>
            <div>
                <form method="POST" action="{{ route('todo.destroy', $data->slug) }}" class="block sm:inline-block">
                    @csrf
                    @method('DELETE')
                    <x-todo-button class="text-red-600 bg-red-100 hover:bg-red-200" icon="trash-2" />
                </form>
                @if($data->is_done == false)
                <form method="POST" action="{{ route('todo.update', $data->slug) }}" class="block sm:inline-block">
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
@else
<x-blank>{{ __('Belum ada rencana.') }}</x-blank>
@endif
@endsection
