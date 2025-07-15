<?php
session_start();
require '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul         = $_POST['judul'];
    $pihak1_id     = $_POST['pihak1'];
    $pihak2_id     = $_POST['pihak2'];
    $tanggal       = $_POST['tanggal'];
    $dana          = $_POST['dana'];
    $waktu_kontrak = $_POST['waktu_kontrak'];
    $status        = $_POST['status'];
    $perusahaan    = $_POST['perusahaan'];
    $jabatan       = $_POST['jabatan'];
    $deskripsi     = $_POST['deskripsi'];

    // Ambil tahun
    $tahun = date('Y', strtotime($tanggal));

    // Hitung jumlah surat yang sudah ada di tahun ini
    $cek = $conn->query("SELECT COUNT(*) as total FROM kontrak WHERE YEAR(tanggal) = '$tahun'");
    $row = $cek->fetch_assoc();
    $nomorUrut = str_pad($row['total'] + 1, 3, '0', STR_PAD_LEFT);

    // Format: 001/NamaPerusahaan/Jabatan/07/2025
    $bulan = date('m', strtotime($tanggal));
    $nomor_surat = "$nomorUrut/$perusahaan/$jabatan/$bulan/$tahun";

    // Simpan kontrak
    $stmt = $conn->prepare("INSERT INTO kontrak (judul, pihak1_id, pihak2_id, tanggal, dana, waktu_kontrak, status, nomor_surat, deskripsi) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("siissssss", $judul, $pihak1_id, $pihak2_id, $tanggal, $dana, $waktu_kontrak, $status, $nomor_surat, $deskripsi);

    if ($stmt->execute()) {
        header("Location: kontrak.php?msg=berhasil");
    } else {
        echo "Gagal menambahkan kontrak: " . $conn->error;
    }
} else {
    header("Location: tambah_kontrak.php");
    exit();
}
