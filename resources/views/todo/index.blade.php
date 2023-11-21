@extends('layouts.app')
@section('hero')
    <x-hero-title>{{ __('Apa Rencanamu Hari Ini ?') }}</x-hero-title>
    
    <livewire:session-status />
    
    <div class="text-xl font-medium my-7">
        <livewire:todo-form />
    </div>
    
    <a href="{{ route('todo.history') }}" class="text-white bg-teal-500 border-none btn hover:bg-teal-600" role="button" aria-label="History List" wire:navigate.hover>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1 md:w-5 md:h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        {{ __('History List') }}
    </a>
@endsection

@section('content')
    <livewire:todo-list />
@endsection
