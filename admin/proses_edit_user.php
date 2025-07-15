<?php
session_start();
require '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("UPDATE users SET username = ?, role = ? WHERE id = ?");
    $stmt->bind_param("ssi", $username, $role, $id);

    if ($stmt->execute()) {
        echo "<script>alert('User berhasil diperbarui!'); window.location='user.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui user!'); window.history.back();</script>";
    }

    $stmt->close();
}
