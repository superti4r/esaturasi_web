<?php
session_start();
require_once '../helper/config.php';
if (isset($_POST['proses'])) {
  $kd_bab = $_POST['kd_bab'];
  $nama_bab = $_POST['nama_bab'];


  // Cek apakah nama jurusan sudah tersedia
  $cekbab = mysqli_query($koneksi, "SELECT * FROM bab WHERE nama_bab='$nama_bab'");
  if (mysqli_num_rows($cekbab) > 0) {
      // Jika nama jurusan sudah ada, tampilkan pesan dan hentikan proses
      echo "<script>alert('Nama bab sudah tersedia. Silakan masukkan nama lain.');</script>";
  } else {
      // Jika nama jurusan belum ada, simpan ke database
      mysqli_query($koneksi, "INSERT INTO bab VALUES ('$kd_bab','$nama_bab')");
      header("Location:index.php?aksi=suksestambah");
  }
}
?>
