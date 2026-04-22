@extends('layouts.app')

@section('title','Tambah Faktur')
@section('page_title','Tambah Faktur')

@section('content')
<div class="bg-white rounded-xl shadow p-10">

    {{-- JUDUL FORM --}}
    <div class="text-center mb-10">
        <h3 class="text-navy font-bold text-lg">
            Formulir Penambahan Faktur
        </h3>
        <p class="text-sm text-gray-400 mt-1">
            Pastikan seluruh informasi terisi dengan lengkap dan akurat
        </p>
    </div>

    {{-- FORM --}}
    <form action="{{ route('faktur.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-2 gap-x-10 gap-y-6">
            {{-- DISTRIBUTOR --}}
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">
                    Nama Distributor <span class="text-red-500">*</span>
                </label>
                <select name="distributor_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih Distributor</option>
                    @foreach ($distributors as $distributor)
                        <option value="{{ $distributor->id }}"
                            {{ old('distributor_id') == $distributor->id ? 'selected' : '' }}>
                            {{ $distributor->nama_distributor }}
                        </option>
                    @endforeach
                </select>
                @error('distributor_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            
            {{-- TANGGAL FAKTUR --}}
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">
                    Tanggal Faktur <span class="text-red-500">*</span>
                </label>
                <input type="date"
       name="tanggal_faktur"
       min="{{ date('Y-m-d') }}"
       value="{{ old('tanggal_faktur') }}"
       class="w-full border border-gray-300 rounded-lg px-3 py-2">
                @error('tanggal_faktur')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- TAGIHAN --}}
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">
                    Tagihan <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                        
                    </span>
                    <input type="number"
                           name="tagihan"
                           min="1"
                           value="{{ old('tagihan') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Rp"
                           oninvalid="this.setCustomValidity('Tagihan tidak boleh 0')"
                           oninput="this.setCustomValidity('')">
                </div>
                @error('tagihan')
                    <p class="text-xs text-red-500 mt-1">{{ $message  }}</p>
                @enderror
            </div>

            {{-- TANGGAL JATUH TEMPO --}}
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">
                    Tanggal Jatuh Tempo <span class="text-red-500">*</span>
                </label>
                <input type="date"
       name="tanggal_jatuh_tempo"
       min="{{ date('Y-m-d') }}"
       value="{{ old('tanggal_jatuh_tempo') }}"
       class="w-full border border-gray-300 rounded-lg px-3 py-2">
                @error('tanggal_jatuh_tempo')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>


        </div>

        {{-- BUTTON --}}
        <div class="flex justify-end gap-4 mt-14">
            <button type="submit"
                    class="w-32 py-2 rounded-lg bg-navy text-white font-semibold hover:opacity-90 transition flex justify-center items-center">
                Simpan
            </button>

            <a href="{{ route('faktur.index') }}"
               class="w-32 py-2 rounded-lg bg-red-500 text-white font-semibold hover:bg-red-600 transition flex justify-center items-center">
                Batal
            </a>

        </div>

    </form>
</div>
@endsection