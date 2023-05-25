@extends('layouts.app')
@section('hero')
<h1 class="text-2xl font-normal sm:text-3xl md:text-4xl lg:font-light lg:text-6xl">
    {{ __('Profil') }}
</h1>
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
