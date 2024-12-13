<?php
require_once '../helper/config.php';

// Mendapatkan NIK dari URL
$nik = $_GET['nik'];

// Query untuk mengambil data guru berdasarkan NIK
$sql = "SELECT * FROM guru WHERE nik = '$nik'";
$result = mysqli_query($koneksi, $sql);

// Mengecek apakah ada data guru yang sesuai dengan NIK
if (mysqli_num_rows($result) > 0) {
    // Mengambil data guru
    $data = mysqli_fetch_array($result);
    $new_password = $data['nik']; // Menggunakan NIK sebagai password baru

    // Query untuk mengupdate password guru
    $update_sql = "UPDATE guru SET password_guru = '$new_password' WHERE nik = '$nik'";

    if (mysqli_query($koneksi, $update_sql)) {
        echo "<script>alert('Password berhasil direset!'); window.location = 'index.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat mereset password.'); window.location = 'index.php';</script>";
    }
} else {
    echo "<script>alert('NIK tidak ditemukan.'); window.location = 'index.php';</script>";
}
?>
