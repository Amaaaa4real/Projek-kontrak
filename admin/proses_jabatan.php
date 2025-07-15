<?php
require '../config/koneksi.php';

if (isset($_POST['jabatan'])) {
    foreach ($_POST['jabatan'] as $id => $jabatan) {
        if (in_array($jabatan, ['DU', 'DO', 'DK'])) {
            $stmt = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
            $stmt->bind_param("si", $jabatan, $id);
            $stmt->execute();
        }
    }
}

// ✅ Alert + Redirect
echo "<script>
    alert('Jabatan user berhasil diperbarui!');
    window.location.href = 'kelola_jabatan.php';
</script>";
exit();
