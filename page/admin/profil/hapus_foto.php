<?php
require_once '../helper/config.php';
session_start();

$nik = $_SESSION['nik'];

// Ambil data guru berdasarkan NIK
$sql = mysqli_query($koneksi, "SELECT foto_profil_guru FROM guru WHERE nik = '$nik'");
$guru = mysqli_fetch_assoc($sql);

if (!empty($guru['foto_profil_guru'])) {
    $file_path = '../uploads/profile/' . $guru['foto_profil_guru'];

    // Hapus file jika ada
    if (file_exists($file_path)) {
        unlink($file_path);
    }
}

// Kosongkan kolom `foto_profil_guru` di database
$query = "UPDATE guru SET foto_profil_guru = NULL WHERE nik = '$nik'";
if (mysqli_query($koneksi, $query)) {
    echo "<script>alert('Berhasil Hapus Foto'); window.location.href = 'index.php';</script>";
} else {
    echo "<script>alert('Gagal memperbarui database!'); window.history.back();</script>";
}

exit();
?>
