<?php
session_start();
require_once '../helper/config.php';
//hapus data 
if (isset($_GET['pesan'])) {
  $kd_kelas = $_GET['kd_kelas'];
  
  // Set kolom kd_kelas menjadi NULL pada tabel siswa
  $query_update = mysqli_query($koneksi, "UPDATE siswa SET kd_kelas=NULL WHERE kd_kelas='$kd_kelas'");
  
  if ($query_update) {
    // Hapus data dari tabel kelas setelah kolom kd_kelas di tabel siswa dikosongkan
    $query_delete = mysqli_query($koneksi, "DELETE FROM kelas WHERE kd_kelas='$kd_kelas'");
    if ($query_delete) {
      header("Location: index.php?aksi=hapusok");
      exit();
    } else {
      echo "Error: " . mysqli_error($koneksi);
    }
  } else {
    echo "Error: " . mysqli_error($koneksi);
  }
}
?>
