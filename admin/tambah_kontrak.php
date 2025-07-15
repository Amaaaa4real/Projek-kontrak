<?php
session_start();
require '../config/koneksi.php';
include '../partials/header.php';

$pihak_internal = $conn->query("SELECT * FROM pihak WHERE tipe = 'internal'");
$pihak_eksternal = $conn->query("SELECT * FROM pihak WHERE tipe = 'eksternal'");
?>

<div class="p-6 max-w-2xl mx-auto bg-white shadow rounded">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Tambah Kontrak</h2>

    <form method="POST" action="proses_tambah_kontrak.php" class="space-y-4">

        <input name="judul" type="text" placeholder="Judul Kontrak" class="w-full p-2 border rounded" required>

        <!-- Pihak Internal -->
        <div>
            <label class="block font-semibold mb-1">Pihak 1 (Internal)</label>
            <select name="pihak1" id="pihak1" class="w-full p-2 border rounded" required onchange="isiJabatan()">
                <option value="">-- Pilih Pihak 1 --</option>
                <?php while ($row = $pihak_internal->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>" data-jabatan="<?= $row['jabatan'] ?>">
                        <?= $row['nama'] ?> - <?= $row['jabatan'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- Pihak Eksternal -->
        <div>
            <label class="block font-semibold mb-1">Pihak 2 (Eksternal)</label>
            <select name="pihak2" class="w-full p-2 border rounded" required>
                <option value="">-- Pilih Pihak 2 --</option>
                <?php while ($row = $pihak_eksternal->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>">
                        <?= $row['nama'] ?> - <?= $row['perusahaan'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <input type="date" name="tanggal" class="w-full p-2 border rounded" required>
        <input type="number" name="dana" placeholder="Dana (Rp)" class="w-full p-2 border rounded" required>
        <input type="text" name="waktu_kontrak" placeholder="Waktu Kontrak (misal: 1 tahun)" class="w-full p-2 border rounded" required>

        <!-- Status Kontrak -->
        <select name="status" class="w-full p-2 border rounded" required>
            <option value="pending">Pending</option>
            <option value="aktif">Aktif</option>
            <option value="selesai">Selesai</option>
            <option value="dibatalkan">Dibatalkan</option>
        </select>

        <hr class="my-4">

        <h3 class="text-lg font-semibold mb-2">Informasi Nomor Surat</h3>
        <input type="text" name="perusahaan" placeholder="Nama Perusahaan" class="w-full p-2 border rounded" required>
        <input type="text" id="jabatan" name="jabatan" placeholder="Jabatan (otomatis dari Pihak 1)" class="w-full p-2 border rounded" required readonly>
        <textarea name="deskripsi" rows="4" placeholder="Deskripsi kontrak" class="w-full p-2 border rounded" required></textarea>

        <div class="pt-4 flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Simpan Kontrak
            </button>
        </div>
    </form>
</div>

<script>
    function isiJabatan() {
        const select = document.getElementById('pihak1');
        const selected = select.options[select.selectedIndex];
        const jabatan = selected.getAttribute('data-jabatan') || '';
        document.getElementById('jabatan').value = jabatan;
    }
</script>