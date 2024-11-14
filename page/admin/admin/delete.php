<?php
session_start();
require_once '../helper/config.php';
//hapus data 
if (isset($_GET['pesan'])) {
  $nik = $_GET['nik'];
  
  
    // Hapus data dari tabel kelas setelah kolom kd_kelas di tabel siswa dikosongkan
    $query_delete = mysqli_query($koneksi, "DELETE FROM admin WHERE nik='$nik'");
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
