<?php
session_start();
require_once '../helper/config.php';

if (isset($_GET['pesan']) && isset($_GET['nik'])) {
  $nik = $_GET['nik'];

  // Query untuk mengambil path foto guru berdasarkan NIK
  $query = mysqli_query($koneksi, "SELECT foto_profil_guru FROM guru WHERE nik = '$nik'");
  if (!$query) {
      die("Query gagal: " . mysqli_error($koneksi));
  }
  
  $data = mysqli_fetch_assoc($query);

  // Memastikan foto profil ada dan file tersebut ada di server
  if (!empty($data['foto_profil_guru'])) {
      // Menentukan path absolut foto berdasarkan direktori root
      $fotoPath = $_SERVER['DOCUMENT_ROOT'] . '/../uploads/profile/' . $data['foto_profil_guru'];


      
      // Mengecek apakah file foto ada di server
      if (file_exists($fotoPath)) {
          // Menghapus file foto dari server
          if (unlink($fotoPath)) {
              echo "Foto berhasil dihapus!<br>";
          } else {
              echo "Gagal menghapus foto.<br>";
          }
      } else {
          echo "File foto tidak ditemukan di server.<br>";
      }
  } else {
      echo "Tidak ada foto yang ditemukan untuk guru dengan NIK: $nik<br>";
  }

  // Menghapus data guru dari database berdasarkan NIK
  $deleteQuery = "DELETE FROM guru WHERE nik = '$nik'";
  if (mysqli_query($koneksi, $deleteQuery)) {
      // Redirect setelah berhasil menghapus data
      header("Location: index.php?aksi=hapusok");
      exit();
  } else {
      // Menampilkan error jika terjadi masalah saat menghapus data
      echo "<script>
              alert('Gagal menghapus data guru! Error: " . mysqli_error($koneksi) . "');
              window.location.href = 'index.php';
            </script>";
      exit();
  }
}
?>


