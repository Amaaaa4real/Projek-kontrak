<?php
session_start();
require '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $pihak1 = $_POST['pihak1'];
    $pihak2 = $_POST['pihak2'];
    $tanggal = $_POST['tanggal'];
    $dana = $_POST['dana'];
    $waktu_kontrak = $_POST['waktu_kontrak'];
    $status = $_POST['status'];
    $nomor_surat = $_POST['nomor_surat']; // dari hidden input yang otomatis diupdate via JS

    // Validasi: pihak1 ≠ pihak2
    if ($pihak1 == $pihak2) {
        echo "<script>alert('Pihak 1 dan Pihak 2 tidak boleh sama!'); window.history.back();</script>";
        exit;
    }

    // Update data kontrak termasuk nomor_surat
    $stmt = $conn->prepare("
        UPDATE kontrak 
        SET judul=?, deskripsi=?, pihak1_id=?, pihak2_id=?, tanggal=?, dana=?, waktu_kontrak=?, status=?, nomor_surat=?
        WHERE id=?
    ");

    $stmt->bind_param(
        "ssiisisssi",
        $judul,
        $deskripsi,
        $pihak1,
        $pihak2,
        $tanggal,
        $dana,
        $waktu_kontrak,
        $status,
        $nomor_surat,
        $id
    );

    if ($stmt->execute()) {
        echo "<script>alert('Kontrak berhasil diperbarui.'); window.location='kontrak.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui kontrak.'); window.history.back();</script>";
    }

    $stmt->close();
}
