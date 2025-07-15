<?php
session_start();
require '../config/koneksi.php';
include '../partials/header.php';

if (!isset($_GET['id'])) {
    echo "<script>alert('ID user tidak ditemukan!'); window.location='kelola_user.php';</script>";
    exit;
}

$id = $_GET['id'];
$user = $conn->query("SELECT * FROM users WHERE id = $id")->fetch_assoc();

if (!$user) {
    echo "<script>alert('Data user tidak ditemukan!'); window.location='kelola_user.php';</script>";
    exit;
}
?>

<div class="p-6 max-w-xl mx-auto bg-white shadow rounded">
    <h2 class="text-2xl font-bold mb-4">Edit User</h2>
    <form method="POST" action="proses_edit_user.php">
        <input type="hidden" name="id" value="<?= $user['id'] ?>">

        <label class="block mb-1 font-semibold">Username</label>
        <input type="text" name="username" value="<?= $user['username'] ?>" class="w-full p-2 mb-4 border rounded" required>

        <label class="block mb-1 font-semibold">Role</label>
        <select name="role" class="w-full p-2 mb-4 border rounded" required>
            <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
        </select>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Simpan Perubahan</button>
    </form>
</div>