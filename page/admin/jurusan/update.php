<?php
require_once '../helper/config.php';

if (isset($_POST['kirim'])) {
  // Mendapatkan data dari form
  $kd_jurusan = $_POST['kd_jurusan'] ?: '-';
  $nama_jurusan = $_POST['nama_jurusan'];

  // Update data
  mysqli_query($koneksi, "UPDATE jurusan SET 
    nama_jurusan = '$nama_jurusan'
    WHERE kd_jurusan = '$kd_jurusan'
  ");
  header("Location:index.php?aksi=suksesedit");
  exit;
}

if (isset($_GET['kd_jurusan'])) {
  $kd_jurusan = $_GET['kd_jurusan'];
  $sql = mysqli_query($koneksi, "SELECT * FROM jurusan WHERE kd_jurusan = '$kd_jurusan'");
  
  // Fetch data if exists
  if ($sql && mysqli_num_rows($sql) > 0) {
    $data = mysqli_fetch_array($sql);
  } else {
    echo "Data jurusan tidak ditemukan.";
    exit; 
  }
} else {
  echo "ID Jurusan tidak tersedia.";
  exit; 
}
?>

