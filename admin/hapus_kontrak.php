<?php
require '../config/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM kontrak WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

echo "<script>alert('Kontrak berhasil dihapus'); window.location='kontrak.php';</script>";
