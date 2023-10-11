@extends('layouts.app')
@section('hero')
    <x-hero-title>{{ __('History List') }}</x-hero-title>

    <livewire:session-status />

    <a href="{{ route('todo.index') }}" class="text-white bg-teal-500 border-none btn hover:bg-teal-600 mt-7">{{ __('Tulis List') }}</a>
@endsection

@section('content')
    <livewire:history-todo-list />
@endsection
