<?php
session_start();
include '../partials/header.php';
?>

<div class="p-6 max-w-xl mx-auto bg-white rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Tambah Pihak</h2>

    <form action="proses_tambah_pihak.php" method="POST" class="space-y-4">
        <div>
            <label class="block mb-1 font-semibold text-gray-700">Nama Lengkap</label>
            <input name="nama" type="text" placeholder="Nama Lengkap" class="w-full p-2 border rounded" required>
        </div>

        <div>
            <label class="block mb-1 font-semibold text-gray-700">Perusahaan</label>
            <input name="perusahaan" type="text" placeholder="Nama Perusahaan" class="w-full p-2 border rounded" required>
        </div>

        <div>
            <label class="block mb-1 font-semibold text-gray-700">Kontak</label>
            <input name="kontak" type="text" placeholder="Kontak (Telepon / Email)" class="w-full p-2 border rounded" required>
        </div>

        <div>
            <label class="block mb-1 font-semibold text-gray-700">Jabatan</label>
            <select name="jabatan" class="w-full p-2 border rounded" required>
                <option value="">-- Pilih Jabatan --</option>
                <option value="DU">Direktur Utama (DU)</option>
                <option value="DO">Direktur Operasi (DO)</option>
                <option value="DK">Direktur Keuangan (DK)</option>
            </select>
        </div>

        <div>
            <label class="block mb-1 font-semibold text-gray-700">Tipe Pihak</label>
            <select name="tipe" class="w-full p-2 border rounded" required>
                <option value="">-- Pilih Tipe --</option>
                <option value="internal">Internal (Perusahaan Kita)</option>
                <option value="eksternal">Eksternal (Pihak Luar)</option>
            </select>
        </div>

        <div class="flex justify-end space-x-2 pt-4">
            <a href="pihak.php" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Batal</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>