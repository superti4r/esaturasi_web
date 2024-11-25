<?php
require_once '../helper/config.php';

if (isset($_GET['kd_posttest'])) {
    $kd_posttest = $_GET['kd_posttest'];

    // Query untuk menghapus data posttest berdasarkan kd_posttest
    $sql = "DELETE FROM posttest WHERE kd_posttest = '$kd_posttest'";

    // Eksekusi query
    if (mysqli_query($koneksi, $sql)) {
        // Redirect ke halaman utama dengan pesan sukses
        header("Location: posttest.php?aksi=hapusok");
    } else {
        // Tampilkan pesan error jika gagal menghapus
        echo "Gagal menghapus data: " . mysqli_error($koneksi);
    }
} else {
    // Jika parameter kd_posttest tidak ada, redirect ke halaman utama
    header("Location: index.php");
}
?>
