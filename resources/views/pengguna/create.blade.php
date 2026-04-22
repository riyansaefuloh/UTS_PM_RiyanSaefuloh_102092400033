@extends('layouts.app')

@section('page_title', 'Tambah Pengguna')

@section('content')

<div class="flex justify-center">

<div class="bg-white rounded-2xl shadow-sm p-8 max-w-3xl w-full">


    <form action="{{ route('pengguna.store') }}" method="POST" class="space-y-5">
        @csrf
 
            <div>
                <label>Nama</label>
                <input name="name" class="w-full border rounded-xl p-2" required>
            </div>

            <div>
                <label>Email</label>
                <input type="email" name="email" class="w-full border rounded-xl p-2" required>
            </div>

            <div>
                <label>Password <span class="text-red-500">*</span><label class="text-sm font-medium">min 4 caracther</label></label>    
                <input type="password" name="password" class="w-full border rounded-xl p-2" required minlength="4" maxlength="10">
            </div>

            <div>
                <label>Role</label>
                <select name="role" class="w-full border rounded-xl p-2">
                <option value="owner">Owner</option>
                <option value="staff">Staff</option>
    </select>
</div>


<div class="flex justify-end gap-3">
    <button class="bg-navy text-white px-6 py-2 rounded-xl">Simpan</button>
    <a href="{{ route('login') }}" class="px-5 py-2 border rounded-xl">Batal</a>
    
</div>

</form>
</div>

@endsection
