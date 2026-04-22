@extends('layouts.app')

@section('page_title', 'Dashboard')

@section('content')

<div class="bg-white rounded-2xl shadow-sm p-6 mt-10">

    <h3 class="text-navy font-semibold text-lg mb-4">
        Obat Perlu Perhatian
    </h3>

    <table class="w-full text-sm text-left">
        <thead class="bg-blue-50 text-gray-700">
            <tr>
                <th class="px-4 py-3 text-center">Nama Obat</th>
                <th class="px-4 py-3 text-center">Stok</th>
                <th class="px-4 py-3 text-center">Status</th>
                <th class="px-4 py-3 text-center">Kadaluarsa</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($obats as $obat)
                <tr class="border-b last:border-none">

                    <td class="px-4 py-3 text-center">
                        {{ $obat->nama_obat }}
                    </td>

                    <td class="px-4 py-3 text-center">
                        {{ $obat->stok }}
                    </td>

                    <td class="px-4 py-3 text-center">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            {{ $obat->status === 'Darurat'
                                ? 'bg-red-100 text-red-600'
                                : 'bg-yellow-100 text-yellow-600' }}">
                            {{ $obat->status }}
                        </span>
                    </td>

                    <td class="px-4 py-3 text-center">
                        {{ \Carbon\Carbon::parse($obat->tanggal_kadaluarsa)
                            ->translatedFormat('d M Y') }}
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="4" class="py-6 text-center text-gray-400">
                        Tidak ada obat darurat / diperiksa
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>


<div class="bg-white rounded-2xl shadow-sm p-6 mt-10">

    <h3 class="text-navy font-semibold text-lg mb-4">
        Pembayaran Terdekat
    </h3>

    <table class="w-full text-sm text-left">
        <thead class="bg-blue-50 text-gray-700">
            <tr>
                <th class="px-4 py-3 text-center">Kode Faktur</th>
                <th class="px-4 py-3 text-center">Nama Distributor</th>
                <th class="px-4 py-3 text-center">Tagihan</th>
                <th class="px-4 py-3 text-center">Status</th>
                <th class="px-4 py-3 text-center">Tanggal Jatuh Tempo</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($fakturs as $faktur)
                <tr class="border-b last:border-none">
                    <td class="px-4 py-3 text-center">{{ $faktur->id }}</td>

                    <td class="px-4 py-3 text-center">
                        {{ $faktur->distributor->nama_distributor }}
                    </td>

                    <td class="px-4 py-3 text-center">
                        Rp {{ number_format($faktur->tagihan, 0, ',', '.') }}
                    </td>

                    <td class="px-4 py-3 text-center">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            {{ $faktur->status === 'Darurat'
                                ? 'bg-red-100 text-red-600'
                                : 'bg-yellow-100 text-yellow-600' }}">
                            {{ $faktur->status }}
                        </span>
                    </td>

                    <td class="px-4 py-3 text-center">
                        {{ \Carbon\Carbon::parse($faktur->tanggal_jatuh_tempo)
                            ->translatedFormat('d M Y') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="py-6 text-center text-gray-400">
                        Tidak ada pembayaran terdekat
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection
