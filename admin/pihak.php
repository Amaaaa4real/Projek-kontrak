<?php
session_start();
require '../config/koneksi.php';
include '../partials/header.php';

// Ambil jumlah pihak berdasarkan tipe
$total_internal = $conn->query("SELECT COUNT(*) as total FROM pihak WHERE tipe = 'internal'")->fetch_assoc()['total'];
$total_eksternal = $conn->query("SELECT COUNT(*) as total FROM pihak WHERE tipe = 'eksternal'")->fetch_assoc()['total'];
?>

<div class="p-6">
    <h2 class="text-2xl font-bold mb-6">Data Pihak</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Internal -->
        <div class="bg-white shadow p-6 rounded border-l-4 border-blue-500">
            <h3 class="text-lg font-semibold text-gray-700">Pihak Internal</h3>
            <p class="text-3xl font-bold text-blue-600 my-2"><?= $total_internal ?></p>
            <a href="pihak_internal.php" class="text-blue-700 hover:underline">Lihat Detail</a>
        </div>

        <!-- Eksternal -->
        <div class="bg-white shadow p-6 rounded border-l-4 border-green-500">
            <h3 class="text-lg font-semibold text-gray-700">Pihak Eksternal</h3>
            <p class="text-3xl font-bold text-green-600 my-2"><?= $total_eksternal ?></p>
            <a href="pihak_eksternal.php" class="text-green-700 hover:underline">Lihat Detail</a>
        </div>
    </div>

    <a href="tambah_pihak.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Tambah Pihak</a>
</div>