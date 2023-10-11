@extends('layouts.app')
@section('hero')
    <x-hero-title>{{ __('Apa Rencanamu Hari Ini ?') }}</x-hero-title>
    
    <livewire:session-status />
    
    <div class="text-xl font-medium my-7">
        <livewire:todo-form />
    </div>
    
    <a href="{{ route('todo.history') }}" class="text-white bg-teal-500 border-none btn hover:bg-teal-600">{{ __('History List') }}</a>
@endsection

@section('content')
    <livewire:todo-list />
@endsection
