@extends('layouts.app')

@section('title','Daftar Faktur')
@section('page_title','Daftar Faktur')

@section('content')

<div class="flex items-center justify-start mb-6">
    <div class="flex items-center gap-4">
        {{-- TOMBOL TAMBAH --}}
        <a href="{{ route('faktur.create') }}"
           class="bg-navy text-white px-5 py-2 rounded-lg flex items-center gap-2">
            + Tambah Faktur
        </a>

        {{-- FILTER + SEARCH --}}
        <form method="GET" action="{{ route('faktur.index') }}"
            class="flex items-center gap-4">

            {{-- FILTER STATUS --}}
            <select name="status"
                    onchange="this.form.submit()"
                    class="rounded-lg border border-gray-300 text-sm px-4 h-10
                        focus:outline-none focus:ring-2 focus:ring-blue-400
                        min-w-[150px]">
                <option value="">Semua Status</option>
                <option value="aman" {{ request('status') == 'aman' ? 'selected' : '' }}>Aman</option>
                <option value="dipantau" {{ request('status') == 'dipantau' ? 'selected' : '' }}>Dipantau</option>
                <option value="darurat" {{ request('status') == 'darurat' ? 'selected' : '' }}>Darurat</option>
            </select>

            {{-- SEARCH --}}
            <div class="relative">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 3.5
                                a7.5 7.5 0 0013.15 13.15z"/>
                    </svg>
                </span>

                <input type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari ID Faktur / Distributor"
                    class="pl-10 pr-4 h-10 w-96 border rounded-lg text-sm
                            focus:ring-blue-400 focus:outline-none"
                    oninput="if(this.value === '') this.form.submit()">
            </div>
        </form>
    </div>
</div>

<div class="bg-white rounded-xl shadow p-4">
    <table class="w-full text-sm table-fixed">
        <thead class="bg-blue-50 text-gray-700">
            <tr>
                <th class="p-3 text-left">ID Faktur</th>
                <th class="p-3 text-left">Distributor</th>
                <th class="p-3 text-left">Tagihan</th>
                <th class="p-3 text-left">Tanggal Faktur</th>
                <th class="p-3 text-left">Tanggal Jatuh Tempo</th>
                <th class="p-3 text-center w-32">Status</th>
                <th class="p-3 text-center">Pembayaran</th>
                <th class="p-3 text-center w-32">Aksi</th>
            </tr>
        </thead>

        <tbody>
        @forelse($fakturs as $f)
            <tr class="border-b hover:bg-blue-50/40 transition">

                <td class="p-3">
                    {{ $f->id }}
                </td>

                <td class="p-3">
                    {{ $f->distributor->nama_distributor }}
                </td>

                <td class="p-3">
                    Rp {{ number_format($f->tagihan,0,',','.') }}
                </td>

                <td class="p-3">
                    {{ $f->tanggal_faktur }}
                </td>

                <td class="p-3">
                    {{ $f->tanggal_jatuh_tempo }}
                </td>

                {{-- STATUS --}}
                <td class="p-3 text-center w-32">
                    @if($f->status == 'Darurat')
                        <span class="inline-flex items-center justify-center px-3 py-1 text-xs font-semibold rounded-full
                                     bg-red-100 text-red-600">
                            Darurat
                        </span>
                    @elseif($f->status == 'Dipantau')
                        <span class="inline-flex items-center justify-center px-3 py-1 text-xs font-semibold rounded-full
                                     bg-yellow-100 text-yellow-600">
                            Dipantau
                        </span>
                    @else
                        <span class="inline-flex items-center justify-center px-3 py-1 text-xs font-semibold rounded-full
                                     bg-green-100 text-green-600">
                            Aman
                        </span>
                    @endif
                </td>






                <td class="p-3 text-center">
    @if($f->status_pembayaran == 'Lunas')
        <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs">
            Lunas
        </span>
    @elseif($f->status_pembayaran == 'Menunggu Pembayaran')
        <span class="bg-yellow-100 text-yellow-600 px-3 py-1 rounded-full text-xs">
            Pending
        </span>
    @elseif($f->status_pembayaran == 'Gagal')
        <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs">
            Gagal
        </span>
    @else
        <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs">
            Belum Bayar
        </span>
    @endif
</td>









                {{-- AKSI --}}
                <td class="p-3 text-center w-32">
                    <div class="flex justify-center gap-4">
                        <a href="{{ route('faktur.payment', $f->id) }}"
   class="text-green-600 hover:text-green-800 transition"
   title="Bayar Faktur">
    💳
</a>
                        {{-- VIEW --}}
                        <a href="{{ route('faktur.show', $f->id) }}"
                        class="text-gray-500 hover:text-gray-700 transition"
                        title="Lihat Detail">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5
                                        c4.478 0 8.268 2.943 9.542 7
                                        -1.274 4.057-5.064 7-9.542 7
                                        -4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </a>

                        {{-- EDIT --}}
                        <a href="{{ route('faktur.edit', $f->id) }}"
                        class="text-blue-600 hover:text-blue-800 transition"
                        title="Edit Faktur">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11
                                        a2 2 0 002 2h11
                                        a2 2 0 002-2v-5"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18.5 2.5a2.121 2.121 0 113 3L12 15
                                        l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                        </a>

                        {{-- DELETE --}}
                        <form method="POST" action="{{ route('faktur.destroy', $f->id) }}"
                            onsubmit="return confirm('Yakin ingin menghapus faktur ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-red-600 hover:text-red-800 transition"
                                    title="Hapus Faktur">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862
                                            a2 2 0 01-1.995-1.858L5 7m5-4h4
                                            a1 1 0 011 1v2H9V4a1 1 0 011-1z"/>
                                </svg>
                            </button>
                        </form>

                    </div>
                </td>

            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center py-10 text-gray-400">
                    Belum ada data faktur
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection