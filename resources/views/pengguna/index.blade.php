@extends('layouts.app') 

@section('page_title', 'Data Pengguna')

@section('content')

<div class="bg-white rounded-xl p-6 shadow">

    <!-- <div class="flex items-center justify-between mb-6"> -->
        <!-- <h3 class="text-navy font-semibold text-lg">Daftar Pengguna</h3> -->

        <!-- <a href="{{ route('pengguna.create') }}"
           class="bg-navy text-white px-5 py-2 rounded-lg flex items-center gap-2">
            <i class="fas fa-plus"></i>Tambah Pengguna
        </a> -->
    <!-- </div> -->

    <div class="overflow-x-auto">
        <table class="w-full text-sm table-fixed">
            <thead class="bg-blue-50 text-gray-700">
                <tr class="text-left text-gray-500 border-b">
                    <th class="px-4 py-3 text-center">Nama</th>
                    <th class="px-4 py-3 text-center">Email</th>
                    <th class="px-4 py-3 text-center">Role</th>
                    <th class="px-4 py-5 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($users as $user)
                <tr class="border-b hover:bg-blue-50/40 transition">
                    <td class="px-4 py-3 text-center">{{ $user->name }}</td>
                    <td class="px-4 py-3 text-center">{{ $user->email }}</td>
                    <td class="px-4 py-5 text-center">{{ $user->role }}</td>
                    <td class="px-4 py-5 text-center space-x-3">

                        <!-- <a href="{{ route('pengguna.edit', $user->id) }}"
                           class="text-blue-500 hover:text-blue-700">
                            <i class="fas fa-edit"></i>
                        </a> -->
                        <a href="{{ route('pengguna.edit', $user->id) }}" class="text-blue-600 hover:text-blue-800">
                            <i class="far fa-pen-to-square"></i>
                        </a>

                        <form action="{{ route('pengguna.destroy', $user->id) }}" method="POST" class="inline">
                            @csrf 
                            @method('DELETE')
                            <button onclick="return confirm('Hapus pengguna ini?')"
                                    class="text-red-500 hover:text-red-700">
                                <i class="far fa-trash-can"></i>
                            </button>
                        </form>

                        <!-- <form action="{{ route('pengguna.destroy', $user->id) }}"
                              method="POST"
                              class="inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Yakin hapus pengguna ini?')"
                                    class="text-red-500 hover:text-red-700">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form> -->

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@endsection
