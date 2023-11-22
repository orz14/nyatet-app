@extends('layouts.app')
@section('hero')
<x-hero-title>{{ __('Catatan') }}</x-hero-title>

<livewire:session-status />

<a href="{{ route('note.create') }}" class="text-white bg-teal-500 border-none btn hover:bg-teal-600 mt-7" wire:navigate.hover>
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1 md:w-5 md:h-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
    </svg>
    {{ __('Tambahkan Catatan') }}
</a>
@endsection

@section('content')
@if ($datas->count())
@foreach ($datas as $data)
<div class="mb-4 transition-all duration-300 ease-in-out bg-white rounded-lg shadow-md border-l-8 border-teal-400/50 card hover:border-teal-400 hover:shadow-lg @isset($data->password) note-locked @endisset">
    <div class="px-3 py-0 leading-none card-body">
        <div class="flex items-center justify-between gap-x-2">
            <div class="w-full py-3 cursor-pointer">
                @isset($data->password)
                    <div x-data x-on:click="modal_unlock_open(`unlock('{{ $data->slug }}')`)">
                        <div class="font-bold">{{ isset($data->title) ? $data->decrypt($data->title) : 'Tanpa Judul' }}</div>
                        <div class="text-xs font-bold">{{ \Carbon\Carbon::parse($data->updated_at)->translatedFormat('l, d F Y H:i') }}</div>
                    </div>
                @else
                    <a wire:navigate.hover href="{{ route('note.edit', $data->slug) }}">
                        <div class="font-bold">{{ isset($data->title) ? $data->decrypt($data->title) : 'Tanpa Judul' }}</div>
                        <div class="text-xs font-bold">{{ \Carbon\Carbon::parse($data->updated_at)->translatedFormat('l, d F Y H:i') }}</div>
                    </a>
                @endisset
            </div>
            <div class="text-right">
                <div class="dropdown dropdown-bottom dropdown-end">
                    <label tabindex="0" class="px-2 py-1.5 inline-block transition-all duration-300 ease-in-out my-1 rounded-lg outline-teal-500/50 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-black hover:text-gray-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                        </svg>
                    </label>
                    <ul tabindex="0" class="p-2 rounded-lg shadow w-max bg-teal-100/90 dropdown-content menu">
                        @isset($data->password)
                        <li>
                            <button x-data x-on:click="modal_unlock_open(`unlock('{{ $data->slug }}')`)" type="button" class="hover:bg-white active:text-black active:bg-white">
                                <span class="flex items-center gap-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:w-5 md:h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 119 0v3.75M3.75 21.75h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H3.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                    </svg>
                                    {{ __('Buka Kunci') }}
                                </span>
                            </button>
                        </li>
                        @else
                        <li>
                            <button x-data x-on:click="modal_lock_open(`lock('{{ $data->slug }}')`)" type="button" class="hover:bg-white active:text-black active:bg-white">
                                <span class="flex items-center gap-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:w-5 md:h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                    </svg>
                                    {{ __('Kunci') }}
                                </span>
                            </button>
                        </li>
                        @endisset

                        @if (!isset($data->password))
                        <li>
                            <button x-data x-on:click="modal_delete_open(`noteDestroy('{{ $data->slug }}')`)" type="button" class="hover:bg-white active:text-black active:bg-white">
                                <span class="flex items-center gap-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:w-5 md:h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                    {{ __('Hapus') }}
                                </span>
                            </button>
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
