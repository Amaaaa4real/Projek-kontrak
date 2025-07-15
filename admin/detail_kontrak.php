<?php
session_start();
require '../config/koneksi.php';
include '../partials/header.php';

$id = $_GET['id'];

$query = "
    SELECT k.*, 
           p1.nama AS pihak1_nama, p1.jabatan AS jabatan1, p1.perusahaan AS perusahaan1,
           p2.nama AS pihak2_nama, p2.jabatan AS jabatan2, p2.perusahaan AS perusahaan2
    FROM kontrak k
    LEFT JOIN pihak p1 ON k.pihak1_id = p1.id
    LEFT JOIN pihak p2 ON k.pihak2_id = p2.id
    WHERE k.id = $id
";

$result = $conn->query($query);
$kontrak = $result->fetch_assoc();
?>

<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md mt-10">
    <h2 class="text-3xl font-semibold text-gray-800 mb-6 border-b pb-2">Detail Kontrak</h2>

    <div class="space-y-4">
        <div>
            <p class="font-semibold text-gray-700">Judul</p>
            <p class="text-gray-800"><?= htmlspecialchars($kontrak['judul']) ?></p>
        </div>

        <div>
            <p class="font-semibold text-gray-700">Deskripsi</p>
            <p class="text-gray-800 whitespace-pre-line"><?= nl2br(htmlspecialchars($kontrak['deskripsi'])) ?></p>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <p class="font-semibold text-gray-700">Status</p>
                <p class="text-gray-800"><?= htmlspecialchars($kontrak['status']) ?></p>
            </div>
            <div>
                <p class="font-semibold text-gray-700">Tanggal</p>
                <p class="text-gray-800"><?= $kontrak['tanggal'] ?></p>
            </div>
            <div>
                <p class="font-semibold text-gray-700">Waktu Kontrak</p>
                <p class="text-gray-800"><?= $kontrak['waktu_kontrak'] ?></p>
            </div>
            <div>
                <p class="font-semibold text-gray-700">Dana</p>
                <p class="text-gray-800">Rp <?= number_format($kontrak['dana'], 0, ',', '.') ?></p>
            </div>
            <div>
                <p class="font-semibold text-gray-700">Nomor Surat</p>
                <p class="text-gray-800"><?= htmlspecialchars($kontrak['nomor_surat']) ?></p>
            </div>
        </div>

        <div class="mt-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Pihak 1</h3>
            <ul class="list-disc ml-6 text-gray-800 space-y-1">
                <li>Nama: <?= htmlspecialchars($kontrak['pihak1_nama']) ?></li>
                <li>Jabatan: <?= htmlspecialchars($kontrak['jabatan1']) ?></li>
                <li>Perusahaan: <?= htmlspecialchars($kontrak['perusahaan1']) ?></li>
            </ul>
        </div>

        <div class="mt-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Pihak 2</h3>
            <ul class="list-disc ml-6 text-gray-800 space-y-1">
                <li>Nama: <?= htmlspecialchars($kontrak['pihak2_nama']) ?></li>
                <li>Jabatan: <?= htmlspecialchars($kontrak['jabatan2']) ?></li>
                <li>Perusahaan: <?= htmlspecialchars($kontrak['perusahaan2']) ?></li>
            </ul>
        </div>
    </div>

    <div class="mt-8 flex justify-end space-x-3">
        <a href="kontrak.php" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">← Kembali</a>
        <a href="cetak_kontrak.php?id=<?= $kontrak['id'] ?>" target="_blank" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Cetak PDF</a>
    </div>
</div>