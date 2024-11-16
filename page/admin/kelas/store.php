<?php
session_start();
require_once '../helper/config.php';

if (isset($_POST['proses'])) {
  $kd_kelas = $_POST['kd_kelas'];
  $nama_kelas = $_POST['nama_kelas'];
  $kd_jurusan = $_POST['kd_jurusan'];
  $no_kelas = $_POST['no_kelas'];
  $tingkatan_kelas = $_POST['tingkatan_kelas'];  // Ambil nilai tingkatan kelas

  // Cek apakah nama kelas sudah ada di database
  $cek_kelas = mysqli_query($koneksi, "SELECT * FROM kelas WHERE nama_kelas='$nama_kelas'");

  if (mysqli_num_rows($cek_kelas) > 0) {
      // Jika kelas sudah ada, tampilkan pesan
      echo "<script>alert('Nama kelas sudah tersedia. Mohon masukkan nama kelas yang berbeda.'); window.history.back();</script>";
      exit();
  }

  // Ambil kd_tahun_ajaran yang aktif
  $queryTahunAjaran = mysqli_query($koneksi, "SELECT kd_tahun_ajaran FROM tahun_ajaran WHERE status = 'aktif' LIMIT 1");
  $tahunAjaranData = mysqli_fetch_assoc($queryTahunAjaran);
  $kd_tahun_ajaran = $tahunAjaranData['kd_tahun_ajaran'];

  // Cek apakah ada tahun ajaran aktif
  if (!$kd_tahun_ajaran) {
      echo "<script>alert('Tahun ajaran aktif belum diatur.'); window.history.back();</script>";
      exit();
  }

  // Jika nama kelas belum ada, lanjutkan dengan proses INSERT
  $query = "INSERT INTO kelas (kd_kelas , no_kelas, nama_kelas, kd_jurusan, tingkatan, kd_tahun_ajaran) 
            VALUES ('$kd_kelas', '$no_kelas','$nama_kelas', '$kd_jurusan', '$tingkatan_kelas', '$kd_tahun_ajaran')";

  // Eksekusi query untuk menyimpan data kelas
  if (mysqli_query($koneksi, $query)) {
    // Redirect setelah berhasil menambah kelas
    header("Location: index.php?aksi=suksestambah");
  } else {
    // Jika ada kesalahan dalam penyimpanan data
    echo "<script>alert('Gagal menyimpan data kelas.'); window.history.back();</script>";
  }
}
?>
