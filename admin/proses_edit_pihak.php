<?php
session_start();
require '../config/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id         = $_POST['id'];
    $nama       = $conn->real_escape_string($_POST['nama']);
    $perusahaan = $conn->real_escape_string($_POST['perusahaan']);
    $kontak     = $conn->real_escape_string($_POST['kontak']);
    $jabatan    = $_POST['jabatan'];
    $tipe       = $_POST['tipe'];

    // Validasi sederhana
    if (empty($nama) || empty($perusahaan) || empty($kontak) || empty($jabatan) || empty($tipe)) {
        header("Location: edit_pihak.php?id=$id&msg=kosong");
        exit();
    }

    // Cek apakah data yang sama sudah ada (kecuali data milik ID ini)
    $cek = $conn->query("SELECT * FROM pihak 
                         WHERE nama = '$nama' AND perusahaan = '$perusahaan' AND id != $id");

    if ($cek->num_rows > 0) {
        header("Location: pihak.php?msg=duplikat");
        exit();
    }

    // Proses update
    $sql = "UPDATE pihak SET 
                nama = '$nama',
                perusahaan = '$perusahaan',
                kontak = '$kontak',
                jabatan = '$jabatan',
                tipe = '$tipe'
            WHERE id = $id";

    if ($conn->query($sql)) {
        header("Location: pihak.php?msg=update");
    } else {
        echo "Gagal mengupdate: " . $conn->error;
    }
}
