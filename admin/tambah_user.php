<?php
include '../partials/header.php';
?>

<div class="p-6 max-w-lg mx-auto bg-white shadow rounded">
    <h2 class="text-xl font-bold mb-4">Tambah User Baru</h2>
    <form method="POST" action="proses_tambah_user.php">
        <!-- Username -->
        <input type="text" name="username" placeholder="Username" class="w-full p-2 mb-4 border rounded" required>

        <!-- Password -->
        <input type="password" name="password" placeholder="Password" class="w-full p-2 mb-4 border rounded" required>

        <!-- Role -->
        <select name="role" class="w-full p-2 mb-4 border rounded" required>
            <option value="">-- Pilih Role --</option>
            <option value="admin">Admin</option>
            <option value="user">User</option>
        </select>

        <!-- Tombol Simpan -->
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Simpan
        </button>
    </form>
</div>