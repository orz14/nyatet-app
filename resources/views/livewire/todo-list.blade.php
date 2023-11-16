<div>
    @if ($datas->count())
    @foreach ($datas as $data)
    <div class="mb-4 transition-all duration-300 ease-in-out bg-white rounded-lg shadow-md border-l-8 border-teal-400/50 hover:border-teal-400 hover:shadow-lg card @if($data->is_done) todo-hijau @endif">
        <div class="px-3 py-2 leading-none card-body">
            <div class="flex items-center justify-between gap-x-2">
                <div class="w-full py-1">
                    {{ $data->decrypt($data->content) }}
                </div>
                <div class="text-right">
                    <div class="dropdown dropdown-bottom dropdown-end">
                        <label tabindex="0" class="px-2 py-1.5 inline-block transition-all duration-300 ease-in-out my-1 rounded-lg outline-teal-500/50">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                            </svg>
                        </label>
                        <ul tabindex="0" class="p-2 rounded-lg shadow w-max bg-teal-100/90 dropdown-content menu">
                            @if(!$data->is_done)
                            <li>
                                <button wire:click="update('{{ $data->slug }}')" type="button" class="hover:bg-white active:text-black active:bg-white">
                                    <span class="flex items-center gap-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:w-5 md:h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75" />
                                        </svg>
                                        {{ __('Selesai') }}
                                    </span>
                                </button>
                            </li>
                            @endif
    
                            <li>
                                <button x-data x-on:click="modal_delete_open(`todoDestroy('{{ $data->slug }}')`)" type="button" class="hover:bg-white active:text-black active:bg-white">
                                    <span class="flex items-center gap-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:w-5 md:h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                        {{ __('Hapus') }}
                                    </span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @else
    <x-blank>{{ __('Belum ada rencana.') }}</x-blank>
    @endif
</div>
