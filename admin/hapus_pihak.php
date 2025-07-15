<?php
require '../config/koneksi.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: pihak.php");
    exit();
}

// Hapus pihak berdasarkan ID
$stmt = $conn->prepare("DELETE FROM pihak WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: pihak.php?msg=hapus");
} else {
    echo "Gagal menghapus data.";
}
