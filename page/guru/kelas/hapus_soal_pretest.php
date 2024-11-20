<?php
require_once '../helper/config.php';

if (isset($_GET['kd_soal'])) {
    $kd_soal = $_GET['kd_soal'];

    // Query untuk menghapus data pretest berdasarkan kd_pretest
    $sql = "DELETE FROM soal_pretest WHERE kd_soal = '$kd_soal'";

    // Eksekusi query
    if (mysqli_query($koneksi, $sql)) {
        // Redirect ke halaman utama dengan pesan sukses
        header("Location: daftar_soal_pretest.php?aksi=hapusok");
    } else {
        // Tampilkan pesan error jika gagal menghapus
        echo "Gagal menghapus data: " . mysqli_error($koneksi);
    }
} else {
    // Jika parameter kd_pretest tidak ada, redirect ke halaman utama
    header("Location: index.php");
}
?>
