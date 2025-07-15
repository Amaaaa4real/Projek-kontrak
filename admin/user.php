<?php
session_start();
include '../partials/header.php';
require '../config/koneksi.php';

$users = $conn->query("SELECT * FROM users");
?>

<div class="p-6">
    <!-- Tombol tambah user -->
    <div class="flex justify-between items-center mb-4 p-6">
        <h2 class="text-2xl font-bold">Kelola User</h2>
        <a href="tambah_user.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Tambah User</a>
    </div>

    <table class="w-full bg-white shadow rounded">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-3 text-left">Username</th>
                <th class="p-3 text-left">Role</th>
                <th class="p-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($user = $users->fetch_assoc()): ?>
                <tr class="border-t">
                    <td class="p-3"><?= htmlspecialchars($user['username']) ?></td>
                    <td class="p-3 capitalize"><?= htmlspecialchars($user['role']) ?></td>
                    <td class="p-3 text-center">
                        <a href="edit_user.php?id=<?= $user['id'] ?>" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</a>
                        <a href="hapus_user.php?id=<?= $user['id'] ?>" onclick="return confirm('Yakin ingin menghapus user ini?');" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
