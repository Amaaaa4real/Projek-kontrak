<?php
session_start();
include '../partials/header.php';
require '../config/koneksi.php';

// Ambil data kontrak + join dengan pihak
$where = "";
$status_filter = $_GET['status'] ?? '';

if (!empty($status_filter)) {
    $where = "WHERE k.status = '" . $conn->real_escape_string($status_filter) . "'";
}

$query = "
SELECT k.*, 
       p1.nama AS pihak1_nama, p1.jabatan AS jabatan1, p1.perusahaan AS perusahaan1,
       p2.nama AS pihak2_nama, p2.jabatan AS jabatan2, p2.perusahaan AS perusahaan2
FROM kontrak k
LEFT JOIN pihak p1 ON k.pihak1_id = p1.id
LEFT JOIN pihak p2 ON k.pihak2_id = p2.id
$where
ORDER BY k.tanggal DESC
";

$data = $conn->query($query);

function statusBadge($status)
{
    $color = [
        'aktif' => 'bg-green-100 text-green-800',
        'selesai' => 'bg-blue-100 text-blue-800',
        'dibatalkan' => 'bg-red-100 text-red-800',
        'pending' => 'bg-yellow-100 text-yellow-800',
    ][$status] ?? 'bg-gray-100 text-gray-800';

    return "<span class=\"px-2 py-1 rounded text-sm font-medium $color\">" . ucfirst($status) . "</span>";
}
?>

<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Daftar Kontrak</h2>
        <a href="tambah_kontrak.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Tambah Kontrak</a>
    </div>

    <!-- Filter Status -->
    <form method="GET" class="mb-4">
        <select name="status" onchange="this.form.submit()" class="p-2 border rounded">
            <option value="">-- Filter Status --</option>
            <option value="aktif" <?= ($status_filter == 'aktif') ? 'selected' : '' ?>>Aktif</option>
            <option value="selesai" <?= ($status_filter == 'selesai') ? 'selected' : '' ?>>Selesai</option>
            <option value="dibatalkan" <?= ($status_filter == 'dibatalkan') ? 'selected' : '' ?>>Dibatalkan</option>
            <option value="pending" <?= ($status_filter == 'pending') ? 'selected' : '' ?>>Pending</option>
        </select>
    </form>

    <table class="w-full bg-white shadow-md rounded overflow-hidden">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-3 text-left">Nomor Surat</th>
                <th class="p-3 text-left">Deskripsi</th>
                <th class="p-3 text-left">Pihak 2 (Perusahaan)</th>
                <th class="p-3 text-center">Status</th>
                <th class="p-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $data->fetch_assoc()): ?>
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3"><?= htmlspecialchars($row['nomor_surat']) ?></td>
                    <td class="p-3"><?= htmlspecialchars($row['deskripsi']) ?></td>
                    <td class="p-3"><?= htmlspecialchars($row['perusahaan2']) ?></td>
                    <td class="p-3 text-center"><?= statusBadge($row['status']) ?></td>
                    <td class="p-3 text-center space-x-2">
                        <a href="edit_kontrak.php?id=<?= $row['id'] ?>" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</a>
                        <a href="hapus_kontrak.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus?');" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Hapus</a>
                        <a href="detail_kontrak.php?id=<?= $row['id'] ?>" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">Detail</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>