@extends('layouts.app')
@section('hero')
    <x-hero-title>{{ __('Mobile App') }}</x-hero-title>
@endsection

@section('content')
    <div class="mb-4 bg-white rounded-lg shadow-md card">
        <div class="card-body">
            Hello World!
        </div>
    </div>
@endsection
