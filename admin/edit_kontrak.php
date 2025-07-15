<?php
session_start();
require '../config/koneksi.php';
include '../partials/header.php';

if (!isset($_GET['id'])) {
    echo "<script>alert('ID kontrak tidak ditemukan!'); window.location='kontrak.php';</script>";
    exit;
}

$id = $_GET['id'];
$kontrak = $conn->query("SELECT * FROM kontrak WHERE id = $id")->fetch_assoc();
$pihak_internal = $conn->query("SELECT * FROM pihak WHERE tipe = 'internal'");
$pihak_eksternal = $conn->query("SELECT * FROM pihak WHERE tipe = 'eksternal'");

if (!$kontrak) {
    echo "<script>alert('Data kontrak tidak ditemukan!'); window.location='kontrak.php';</script>";
    exit;
}

// Pecah nomor surat
$nomor_parts = explode('/', $kontrak['nomor_surat']);
$nomor_unik = $nomor_parts[0] ?? '';
$perusahaan = $nomor_parts[1] ?? '';
$jabatan_awal = $nomor_parts[2] ?? '';
$bulan = $nomor_parts[3] ?? '';
$tahun = $nomor_parts[4] ?? '';
?>

<div class="p-6 max-w-2xl mx-auto bg-white shadow rounded">
    <h2 class="text-2xl font-bold mb-4">Edit Kontrak</h2>
    <form method="POST" action="proses_edit_kontrak.php">
        <input type="hidden" name="id" value="<?= $kontrak['id'] ?>">

        <input name="judul" type="text" value="<?= $kontrak['judul'] ?>" class="w-full p-2 mb-4 border rounded" required>

        <textarea name="deskripsi" rows="4" class="w-full p-2 mb-4 border rounded" required><?= $kontrak['deskripsi'] ?></textarea>

        <!-- Pihak 1 (Internal) -->
        <label class="font-semibold">Pihak 1 (Internal)</label>
        <select name="pihak1" id="pihak1" class="w-full p-2 mb-4 border rounded" required>
            <?php while ($row = $pihak_internal->fetch_assoc()): ?>
                <option
                    value="<?= $row['id'] ?>"
                    data-jabatan="<?= $row['jabatan'] ?>"
                    <?= ($row['id'] == $kontrak['pihak1_id']) ? 'selected' : '' ?>>
                    <?= $row['nama'] ?> - <?= $row['jabatan'] ?>
                </option>
            <?php endwhile; ?>
        </select>

        <!-- Pihak 2 (Eksternal) -->
        <label class="font-semibold">Pihak 2 (Eksternal)</label>
        <select name="pihak2" class="w-full p-2 mb-4 border rounded" required>
            <?php while ($row = $pihak_eksternal->fetch_assoc()): ?>
                <option
                    value="<?= $row['id'] ?>"
                    <?= ($row['id'] == $kontrak['pihak2_id']) ? 'selected' : '' ?>>
                    <?= $row['nama'] ?> - <?= $row['perusahaan'] ?>
                </option>
            <?php endwhile; ?>
        </select>

        <input type="date" name="tanggal" value="<?= $kontrak['tanggal'] ?>" class="w-full p-2 mb-4 border rounded" required>
        <input type="number" name="dana" value="<?= $kontrak['dana'] ?>" class="w-full p-2 mb-4 border rounded" required>
        <input type="text" name="waktu_kontrak" value="<?= $kontrak['waktu_kontrak'] ?>" class="w-full p-2 mb-4 border rounded" required>

        <!-- Status -->
        <select name="status" class="w-full p-2 mb-4 border rounded" required>
            <option value="aktif" <?= $kontrak['status'] == 'aktif' ? 'selected' : '' ?>>Aktif</option>
            <option value="selesai" <?= $kontrak['status'] == 'selesai' ? 'selected' : '' ?>>Selesai</option>
            <option value="dibatalkan" <?= $kontrak['status'] == 'dibatalkan' ? 'selected' : '' ?>>Dibatalkan</option>
            <option value="pending" <?= $kontrak['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
        </select>

        <hr class="my-4">

        <!-- Nomor Surat: Hidden input + display -->
        <label class="font-semibold">Nomor Surat</label>
        <input
            type="text"
            id="nomor_surat_display"
            value="<?= "$nomor_unik/$perusahaan/$jabatan_awal/$bulan/$tahun" ?>"
            class="w-full p-2 mb-2 border rounded bg-gray-100"
            readonly>
        <input
            type="hidden"
            name="nomor_surat"
            id="nomor_surat"
            value="<?= "$nomor_unik/$perusahaan/$jabatan_awal/$bulan/$tahun" ?>">

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Simpan Perubahan
        </button>
    </form>
</div>

<script>
    const pihak1Select = document.getElementById('pihak1');
    const nomorSurat = document.getElementById('nomor_surat');
    const nomorSuratDisplay = document.getElementById('nomor_surat_display');

    function updateNomorSurat() {
        const selected = pihak1Select.options[pihak1Select.selectedIndex];
        const jabatan = selected.dataset.jabatan || 'DU';

        const parts = nomorSurat.value.split('/');
        if (parts.length === 5) {
            parts[2] = jabatan; // ubah bagian jabatan
            const updated = parts.join('/');
            nomorSurat.value = updated;
            nomorSuratDisplay.value = updated;
        }
    }

    updateNomorSurat();
    pihak1Select.addEventListener('change', updateNomorSurat);
</script>