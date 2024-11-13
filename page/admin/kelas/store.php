<?php
session_start();
require_once '../helper/config.php';

if (isset($_POST['proses'])) {
  $kd_kelas = $_POST['kd_kelas'];
  $nama_kelas = $_POST['nama_kelas'];
  $kd_jurusan = $_POST['kd_jurusan'];

  // Cek apakah nama kelas sudah ada di database
  $cek_kelas = mysqli_query($koneksi, "SELECT * FROM kelas WHERE nama_kelas='$nama_kelas'");
  
  if (mysqli_num_rows($cek_kelas) > 0) {
      // Jika kelas sudah ada, tampilkan pesan
      echo "<script>alert('Nama kelas sudah tersedia. Mohon masukkan nama kelas yang berbeda.'); window.history.back();</script>";
      exit();
  }

  // Jika nama kelas belum ada, lanjutkan dengan proses INSERT
  mysqli_query($koneksi, "INSERT INTO kelas (kd_kelas, nama_kelas, kd_jurusan) VALUES ('$kd_kelas','$nama_kelas','$kd_jurusan')");

  // Redirect setelah berhasil menambah kelas
  header("Location: index.php?aksi=suksestambah");
}