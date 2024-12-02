<?php
require_once '../helper/config.php';

// Mendapatkan NISN dari URL
$nisn = $_GET['nisn'];

// Set password default
$new_password = 'saturasi123';

// Query untuk mengupdate password
$sql = "UPDATE siswa SET password ='$new_password' WHERE nisn = '$nisn'";

if (mysqli_query($koneksi, $sql)) {
    echo "<script>alert('Password berhasil direset!'); window.location = 'index.php';</script>";
} else {
    echo "<script>alert('Terjadi kesalahan saat mereset password.'); window.location = 'index.php';</script>";
}
?>
