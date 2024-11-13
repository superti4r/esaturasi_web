<?php
session_start();
require_once '../helper/config.php';
if (isset($_POST['proses'])) {
  $kd_jurusan = $_POST['kd_jurusan'];
  $nama_jurusan = $_POST['nama_jurusan'];

  // Cek apakah nama jurusan sudah tersedia
  $cek_jurusan = mysqli_query($koneksi, "SELECT * FROM jurusan WHERE nama_jurusan='$nama_jurusan'");
  if (mysqli_num_rows($cek_jurusan) > 0) {
      // Jika nama jurusan sudah ada, tampilkan pesan dan hentikan proses
      echo "<script>alert('Nama jurusan sudah tersedia. Silakan masukkan nama lain.');</script>";
  } else {
      // Jika nama jurusan belum ada, simpan ke database
      mysqli_query($koneksi, "INSERT INTO jurusan VALUES ('$kd_jurusan','$nama_jurusan')");
      header("Location:index.php?aksi=suksestambah");
  }
}
?>