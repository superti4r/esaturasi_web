<?php
session_start();
require_once '../helper/config.php';
if (isset($_POST['proses'])) {
  $kd_mapel = $_POST['kd_mapel'];
  $nama_mapel = $_POST['nama_mapel'];
    // Cek apakah nama mapel sudah ada di database
    $cek_mapel = mysqli_query($koneksi, "SELECT * FROM mapel WHERE nama_mapel='$nama_mapel'");
    
    if (mysqli_num_rows($cek_mapel) > 0) {
        // Jika mapel sudah ada, tampilkan pesan
        echo "<script>alert('Nama mata pelajaran sudah tersedia. Mohon masukkan nama mata pelajaran yang berbeda.'); window.history.back();</script>";
        exit();
    }

    // Jika nama mapel belum ada, lanjutkan dengan proses INSERT
    mysqli_query($koneksi, "INSERT INTO mapel (kd_mapel, nama_mapel) VALUES ('$kd_mapel','$nama_mapel')");

    // Redirect setelah berhasil menambah mapel
    header("Location: index.php?aksi=suksestambah");
}