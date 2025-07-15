<?php
require '../config/koneksi.php';

// Ambil data dari form
$nama        = trim($_POST['nama']);
$perusahaan  = trim($_POST['perusahaan']);
$kontak      = trim($_POST['kontak']);
$jabatan     = trim($_POST['jabatan']);

$tipe = $_POST['tipe'];
// lalu insert ke database bersama kolom lainnya


// Validasi input kosong
if (!$nama || !$perusahaan || !$kontak || !$jabatan) {
    header("Location: tambah_pihak.php?msg=kosong");
    exit();
}

// Validasi ganda: Cek apakah nama & perusahaan sudah ada
$cek = $conn->prepare("SELECT id FROM pihak WHERE nama = ? AND perusahaan = ?");
$cek->bind_param("ss", $nama, $perusahaan);
$cek->execute();
$cek->store_result();

if ($cek->num_rows > 0) {
    header("Location: pihak.php?msg=duplikat");
    exit();
}

// Jika lolos, simpan data
$stmt = $conn->prepare("INSERT INTO pihak (nama, perusahaan, kontak, jabatan) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $nama, $perusahaan, $kontak, $jabatan);

if ($stmt->execute()) {
    header("Location: pihak.php?msg=berhasil");
} else {
    echo "Gagal menambahkan pihak.";
}
