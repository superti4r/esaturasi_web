<?php
session_start();
require_once '../helper/config.php';
// Proses tambah data siswa
if (isset($_POST['kirim'])) {
  $nisn = $_POST['nisn'];
  $nama_siswa = $_POST['nama_siswa'];
  $tgl_lahir_siswa = $_POST['tgl_lahir_siswa'];
  $email = $_POST['email'];
  $no_telepon_siswa = $_POST['no_telepon_siswa'];
  $jekel_siswa = $_POST['jekel_siswa'];
  $alamat = $_POST['alamat'];
  $tempat_lahir = $_POST['tempat_lahir'];
  $tahun_masuk_siswa = $_POST['tahun_masuk_siswa'];
  $kd_kelas = $_POST['kd_kelas'];
  $status_siswa = $_POST['status_siswa'];

  // Validasi input
  $errors = [];

  if (!preg_match('/^[0-9]{10}$/', $nisn)) {
      $errors[] = "NISN harus terdiri dari 10 angka.";
  }

  if (!preg_match('/^[a-zA-Z\s]+$/', $nama_siswa)) {
      $errors[] = "Nama siswa tidak boleh mengandung angka atau simbol.";
  }

  if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors[] = "Email tidak valid.";
  }

  if (!preg_match('/^[0-9]{10,13}$/', $no_telepon_siswa)) {
      $errors[] = "No telepon harus terdiri dari 10 hingga 13 angka.";
  }

  if (!empty($errors)) {
      foreach ($errors as $error) {
          echo "<script>alert('$error');</script>";
      }
      echo "<script>window.history.back();</script>";
      exit();
  }

  // Menyimpan data ke tabel siswa
  $sql = "UPDATE siswa 
          SET nama_siswa='$nama_siswa', 
              email='$email', 
              no_telepon_siswa='$no_telepon_siswa', 
              jekel_siswa='$jekel_siswa', 
              tempat_lahir_siswa='$tempat_lahir', 
              tgl_lahir_siswa='$tgl_lahir_siswa', 
              alamat='$alamat', 
              tahun_masuk_siswa='$tahun_masuk_siswa', 
              status_siswa='$status_siswa', 
              kd_kelas='$kd_kelas' 
          WHERE nisn='$nisn'";

  // Eksekusi query
  if (mysqli_query($koneksi, $sql)) {
      header("Location: index.php?aksi=suksesedit");
      exit();
  } else {
      echo "Error: " . mysqli_error($koneksi);
  }
}


// mengambil data yang akan di edit
$nisn = $_GET['nisn'];
$sql = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nisn='$nisn'");
$data = mysqli_fetch_array($sql);
