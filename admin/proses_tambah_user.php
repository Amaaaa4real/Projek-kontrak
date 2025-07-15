<?php
require '../config/koneksi.php';

$username = trim($_POST['username']);
$role = $_POST['role'];

// Validasi input
if (empty($username) || empty($role)) {
    echo "<script>alert('Semua kolom wajib diisi'); window.location='tambah_user.php';</script>";
    exit;
}

// Cek apakah username sudah ada
$check = $conn->prepare("SELECT id FROM users WHERE username = ?");
$check->bind_param("s", $username);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo "<script>alert('Username sudah digunakan!'); window.location='tambah_user.php';</script>";
    exit;
}

// Insert ke database
$stmt = $conn->prepare("INSERT INTO users (username, role) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $role);

if ($stmt->execute()) {
    echo "<script>alert('User berhasil ditambahkan'); window.location='user.php';</script>";
} else {
    echo "<script>alert('Gagal menambahkan user!'); window.history.back();</script>";
}

$stmt->close();
