@extends('layouts.app')
{{-- Menggunakan layout utama --}}

@section('title', 'Daftar Distributor')
{{-- Judul halaman --}}

@section('content')
{{-- =========================
     AWAL CONTENT
     ========================= --}}

<style>
/* =========================
   STYLE HALAMAN DISTRIBUTOR
   ========================= */

/* Card utama */
.dist-card {
  background: #ffffff;
  border-radius: 16px;
  padding: 28px;
}

/* Toolbar */
.dist-toolbar {
  display: flex;
  align-items: center;
  gap: 16px; /* Memberi jarak antara tombol dan search */
  margin-bottom: 24px;
}

/* Input search */
.search-input {
  width: 380px;
  padding: 10px 14px;
  border-radius: 10px;
  border: 1px solid #e5e7eb;
}

/* Tabel */
.dist-table {
  width: 100%;
  border-collapse: collapse;
}

.dist-table thead th {
  padding: 14px 10px;
  text-align: left;
  color: #1b4985;
  font-weight: 600;
}

.dist-table tbody td {
  padding: 14px 10px;
  border-top: 1px solid #f1f5f9;
}

/* ===== PERBAIKAN ALIGNMENT KOLOM AKSI ===== */

/* Header kolom Aksi */
.dist-table thead th.aksi-col {
  text-align: center;        /* Tengah horizontal */
  vertical-align: middle;    /* Tengah vertikal */
}

/* Isi kolom Aksi */
.dist-table tbody td.aksi-col {
  text-align: center;
  vertical-align: middle;
  padding-top: 16px;         /* Samakan tinggi visual */
  padding-bottom: 16px;
}

/* Kolom aksi */
.aksi-col {
  width: 120px;
  text-align: center;
}

/* Kolom aksi */
.aksi-col {
  width: 120px;
  text-align: center;
  vertical-align: middle;
}

/* Wrapper icon aksi */
.aksi-wrapper {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 16px;
}

/* Icon aksi */
.aksi-wrapper a,
.aksi-wrapper button {
  width: 36px;
  height: 36px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 8px;
  background: none;
  border: none;
  cursor: pointer;
}

.aksi-wrapper a:hover,
.aksi-wrapper button:hover {
  background: #f1f5f9;
}

/* =========================
   MODAL POPUP
   ========================= */

.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(15, 23, 42, 0.45);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
}

.modal-card {
  background: white;
  width: 420px;
  padding: 28px;
  border-radius: 16px;
  text-align: center;
}

.modal-card h3 {
  font-size: 18px;
  font-weight: 600;
  margin-bottom: 10px;
}

.modal-card p {
  color: #475569;
  margin-bottom: 20px;
}

.modal-card .danger {
  color: #ef4444;
  font-weight: 600;
}

.modal-actions {
  display: flex;
  justify-content: center;
  gap: 14px;
}

.modal-actions button {
  padding: 8px 18px;
  border-radius: 8px;
  border: none;
  cursor: pointer;
}

.modal-actions .confirm {
  background: #1b4985;
  color: white;
}

.modal-actions .cancel {
  background: #e5e7eb;
}

.hidden {
  display: none;
}
</style>

{{-- =========================
     CARD UTAMA
     ========================= --}}
<div class="dist-card">

  {{-- ===== TOOLBAR ===== --}}
  <div class="flex items-center gap-4 mb-6">

    {{-- Tombol tambah --}}
    <a href="{{ route('distributors.create') }}"
       class="bg-[#1b4985] text-white px-6 py-2.5 rounded-xl font-medium flex items-center shrink-0">
      + Tambah Distributor
    </a>

    {{-- Search Container --}}
    <div class="relative w-[850px]">
      <form action="{{ route('distributors.index') }}" method="GET">
        <span class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
          <i class="fas fa-search text-gray-400"></i>
        </span>
        <input type="text"
               name="search"
               class="w-full pl-12 pr-4 py-2.5 rounded-xl bg-[#f8fbff] border border-gray-100 text-sm focus:ring-2 focus:ring-blue-100 outline-none"
               placeholder="Cari Faktur"
               value="{{ request('search') }}">
      </form>
    </div>

  </div>

  {{-- =========================
       MODAL SUKSES
       ========================= --}}
  @if (session('success'))
  <div id="successModal" class="modal-overlay">
    <div class="modal-card">
      <h3>Berhasil</h3>
      <p>{{ session('success') }}</p>
      <div class="modal-actions">
        <button class="confirm" onclick="closeSuccess()">Ya</button>
      </div>
    </div>
  </div>
  @endif

  {{-- =========================
       MODAL KONFIRMASI DELETE
       ========================= --}}
  <div id="deleteModal" class="modal-overlay hidden">
    <div class="modal-card">
      <h3>Apakah anda yakin ingin <span class="danger">menghapus</span>?</h3>
      <p id="deleteText"></p>
      <div class="modal-actions">
        <button class="cancel" onclick="closeDelete()">Batal</button>
        <button class="confirm" onclick="submitDelete()">Ya</button>
      </div>
    </div>
  </div>

  {{-- =========================
       TABEL DISTRIBUTOR
       ========================= --}}
  <table class="dist-table">
    <thead class="bg-blue-50 text-gray-700">
      <tr>
        <th >Nama Distributor</th>
        <th>Kontak</th>
        <th>Alamat</th>
        <th class="aksi-col">Aksi</th>
      </tr>
    </thead>
    <tbody>

      @forelse ($distributors as $d)
      <tr>
        <td>{{ $d->nama_distributor }}</td>
        <td>{{ $d->kontak }}</td>
        <td>{{ $d->alamat }}</td>
        <td class="aksi-col">
          <div class="aksi-wrapper">

            {{-- Edit --}}
            <!-- <a href="{{ route('distributors.edit', $d->id) }}" title="Edit">
              <i class="fas fa-pen text-orange-500"></i>
            </a> -->

            <a href="{{ route('distributors.edit', $d->id) }}" class="text-blue-600 hover:text-blue-800">
                            <i class="far fa-pen-to-square"></i>
                        </a>

            {{-- Hapus --}}
            <!-- <button type="button"
                    data-url="{{ route('distributors.destroy', $d->id) }}"
                    data-name="{{ $d->nama_distributor }}"
                    onclick="openDelete(this)">
              <i class="fas fa-trash text-gray-400"></i>
            </button> -->

            <form action="{{ route('distributors.destroy', $d->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Hapus obat ini?')" class="text-red-500">
                                <i class="far fa-trash-can"></i>
                            </button>
            </form>

          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="4" class="text-center py-6 text-gray-400">
          Belum ada data distributor
        </td>
      </tr>
      @endforelse

    </tbody>
  </table>

</div>

{{-- =========================
     FORM DELETE TERSEMBUNYI
     ========================= --}}
<form id="deleteForm" method="POST" style="display:none;">
  @csrf
  @method('DELETE')
</form>

{{-- =========================
     JAVASCRIPT
     ========================= --}}
<script>
const deleteForm = document.getElementById('deleteForm');

/* Buka modal delete */
function openDelete(btn) {
  deleteForm.action = btn.dataset.url;
  document.getElementById('deleteText').innerText =
    `Distributor "${btn.dataset.name}" akan dihapus.`;
  document.getElementById('deleteModal').classList.remove('hidden');
}

/* Tutup modal delete */
function closeDelete() {
  document.getElementById('deleteModal').classList.add('hidden');
}

/* Kirim delete ke database */
function submitDelete() {
  deleteForm.submit();
}

/* Tutup modal sukses */
function closeSuccess() {
  document.getElementById('successModal').remove();
}
</script>

@endsection
{{-- =========================
     AKHIR CONTENT
     ========================= --}}
