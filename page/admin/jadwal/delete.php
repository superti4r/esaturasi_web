<?php
session_start();
require_once '../helper/config.php';
//hapus data 
if (isset($_GET['pesan'])) {
  $kd_jadwal = $_GET['kd_jadwal'];
  
    // Hapus data dari tabel kelas setelah kolom kd_kelas di tabel siswa dikosongkan
    $query_delete = mysqli_query($koneksi, "DELETE FROM jadwal WHERE kd_jadwal='$kd_jadwal'");
    if ($query_delete) {
      header("Location: index.php?aksi=hapusok");
      exit();
    } else {
      echo "Error: " . mysqli_error($koneksi);
    }
  } else {
    echo "Error: " . mysqli_error($koneksi);
  }
?>
