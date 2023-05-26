@extends('layouts.app')
@section('hero')
<x-hero-title>{{ __('Profil') }}</x-hero-title>
@endsection

@section('content')
<div class="mb-4 bg-white rounded-lg shadow-md card">
    <div class="card-body">
        <div class="grid w-full grid-cols-1 gap-8 sm:grid-cols-2">
            @include('profile.partials.update-profile-information-form')
            @include('profile.partials.update-password-form')
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection
