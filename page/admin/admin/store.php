<?php
session_start();
require_once '../helper/config.php';

if (isset($_POST['proses'])) {
  $nik = $_POST['nik'];
  $kd_admin = "";

  // Cek apakah nama kelas sudah ada di database
  $cek_guru = mysqli_query($koneksi, "SELECT * FROM admin WHERE nik='$nik'");
  
  if (mysqli_num_rows($cek_guru) > 0) {
      // Jika kelas sudah ada, tampilkan pesan
      echo "<script>alert('Guru sudah terdaftar sebagai admin. Mohon masukkan guru yang berbeda.'); window.history.back();</script>";
      exit();
  }

  // Jika nama kelas belum ada, lanjutkan dengan proses INSERT
  mysqli_query($koneksi, "INSERT INTO admin (kd_admin, nik) VALUES ('$kd_admin','$nik')");

  // Redirect setelah berhasil menambah kelas
  header("Location: index.php?aksi=suksestambah");
}