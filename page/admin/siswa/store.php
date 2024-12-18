<?php

session_start();
require_once '../helper/config.php';

// Proses tambah data siswa
if (isset($_POST['proses'])) {
  $nisn = $_POST['nisn'];
  $nama_siswa = $_POST['nama_siswa'];
  $tgl_lahir_siswa = $_POST['tgl_lahir_siswa'];
  $email = $_POST['email'];
  $no_telepon_siswa = $_POST['no_telepon_siswa'];
  $jekel_siswa = $_POST['jekel_siswa'];
  $alamat = $_POST['alamat'];
  $tempat_lahir = $_POST['tempat_lahir'];
  $tahun_masuk_siswa = $_POST['tahun_masuk_siswa'];
  $password = $nisn;  // Anda bisa mengganti ini jika ingin password berbeda
  $kd_kelas = $_POST['kd_kelas'];
  $foto_profil_siswa = "";
  $status_siswa = "Aktif";

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

  // Cek apakah NISN sudah terdaftar
  $ceknisn = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nisn='$nisn'");
  if (mysqli_num_rows($ceknisn) > 0) {
      echo "<script>alert('NISN sudah terdaftar. Mohon masukkan NISN yang berbeda.'); window.history.back();</script>";
      exit();
  }
// Proses upload foto profil
if ($_FILES['foto_profil']['error'] === UPLOAD_ERR_OK) {
    $foto_tmp = $_FILES['foto_profil']['tmp_name'];
    $foto_ext = pathinfo($_FILES['foto_profil']['name'], PATHINFO_EXTENSION);
    $foto_nama = $nisn . '.' . $foto_ext; // Nama file foto berdasarkan NISN
    $upload_dir = '../uploads/profilesiswa/';

    // Membuat folder jika belum ada
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    // Pindahkan file ke folder uploads/profilesiswa
    if (move_uploaded_file($foto_tmp, $upload_dir . $foto_nama)) {
        $foto_profil_siswa = $foto_nama;
    } else {
        echo "<script>alert('Gagal mengupload foto profil.'); window.history.back();</script>";
        exit();
    }
} else {
    echo "<script>alert('Tidak ada file foto yang diupload.'); window.history.back();</script>";
    exit();
}
  


  // Menyimpan data ke tabel siswa
  $sql = "INSERT INTO siswa (nisn, nama_siswa, email, no_telepon_siswa, jekel_siswa, tempat_lahir_siswa, tgl_lahir_siswa, alamat, tahun_masuk_siswa, status_siswa, kd_kelas, password, foto_profil_siswa) 
          VALUES ('$nisn', '$nama_siswa', '$email', '$no_telepon_siswa', '$jekel_siswa', '$tempat_lahir', '$tgl_lahir_siswa', '$alamat', '$tahun_masuk_siswa', '$status_siswa', '$kd_kelas', '$password', '$foto_profil_siswa')";

  // Eksekusi query
  if (mysqli_query($koneksi, $sql)) {
      header("Location: index.php?aksi=suksestambah");
      exit();
  } else {
      echo "Error: " . mysqli_error($koneksi);
  }
}
?>
