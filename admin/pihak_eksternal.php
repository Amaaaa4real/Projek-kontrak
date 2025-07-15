<?php
session_start();
require '../config/koneksi.php';
include '../partials/header.php';

$pihak = $conn->query("SELECT * FROM pihak WHERE tipe = 'eksternal'");

?>

<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Pihak Internal</h2>
    <a href="pihak.php" class="mb-4 inline-block text-blue-600 hover:underline">← Kembali</a>

    <div class="overflow-x-auto">
        <table class="w-full bg-white shadow rounded">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-3 text-left">Nama</th>
                    <th class="p-3 text-left">Perusahaan</th>
                    <th class="p-3 text-left">Kontak</th>
                    <th class="p-3 text-left">Jabatan</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $pihak->fetch_assoc()): ?>
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-3"><?= htmlspecialchars($row['nama']) ?></td>
                        <td class="p-3"><?= htmlspecialchars($row['perusahaan']) ?></td>
                        <td class="p-3"><?= htmlspecialchars($row['kontak']) ?></td>
                        <td class="p-3"><?= htmlspecialchars($row['jabatan']) ?></td>
                        <td class="p-3 text-center">
                            <a href="edit_pihak.php?id=<?= $row['id'] ?>" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</a>
                            <a href="hapus_pihak.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus?');" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>