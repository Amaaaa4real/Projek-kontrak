<?php
require '../config/koneksi.php';

$id = $_GET['id'];
$conn->query("DELETE FROM users WHERE id = $id");

echo "<script>alert('User berhasil dihapus'); window.location='kelola_jabatan.php';</script>";
