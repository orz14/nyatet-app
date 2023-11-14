@extends('layouts.app')
@section('hero')
<x-hero-title>{{ __('Catatan') }}</x-hero-title>

{{-- Session Status --}}
<x-session-status />

<a href="{{ route('note.create') }}" class="text-white bg-teal-500 border-none btn hover:bg-teal-600 mt-7" wire:navigate.hover>{{ __('Tambahkan Catatan') }}</a>
@endsection

@section('content')
@if ($datas->count())
@foreach ($datas as $data)
<div class="mb-4 transition-all duration-300 ease-in-out bg-white rounded-lg shadow-md border-l-8 border-teal-400/50 card hover:border-teal-400 hover:shadow-lg @isset($data->password) note-locked @endisset">
    <div class="px-3 py-0 leading-none card-body">
        <div class="flex items-center justify-between gap-x-2">
            <div class="w-full py-3">
                <a @isset($data->password) x-data x-on:click="modal_unlock_open('{{ route('note.unlock', $data->slug) }}')" @else href="{{ route('note.edit', $data->slug) }}" wire:navigate.hover @endisset>
                    <div class="font-bold">{{ isset($data->title) ? $data->decrypt($data->title) : 'Tanpa Judul' }}</div>
                    <div class="text-xs font-bold">{{ \Carbon\Carbon::parse($data->updated_at)->translatedFormat('l, d F Y H:i') }}</div>
                </a>
            </div>
            <div class="text-right">
                <div class="dropdown dropdown-bottom dropdown-end">
                    <label tabindex="0" class="px-2 py-1.5 inline-block transition-all duration-300 ease-in-out my-1 orz-pointer rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                        </svg>
                    </label>
                    <ul tabindex="0" class="p-2 shadow bg-teal-100/80 dropdown-content menu rounded-box w-52">
                        @isset($data->password)
                        <li class="orz-pointer">
                            <button x-data x-on:click="modal_unlock_open('{{ route('note.unlock', $data->slug) }}')" type="button" class="hover:bg-white active:text-black active:bg-white">{{ __('Buka Kunci') }}</button>
                        </li>
                        @else
                        <li class="orz-pointer">
                            <button x-data x-on:click="modal_lock_open(`lock('{{ $data->slug }}')`)" type="button" class="hover:bg-white active:text-black active:bg-white">{{ __('Kunci') }}</button>
                        </li>
                        @endisset

                        @if (!isset($data->password))
                        <li class="orz-pointer">
                            <button x-data x-on:click="modal_delete_open(`destroy('{{ $data->slug }}')`)" type="button" class="hover:bg-white active:text-black active:bg-white">{{ __('Hapus') }}</button>
                        </li>
                        @endif
                    </ul>
                </div>
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
