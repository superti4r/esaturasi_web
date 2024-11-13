<?php
require_once '../helper/config.php';

if (isset($_POST['kirim'])) {
  // Mendapatkan data dari form
  $kd_kelas = $_POST['kd_kelas'];
  $nama_kelas = $_POST['nama_kelas'];
  $kd_jurusan = $_POST['kd_jurusan'];

  // Update data
  $query = mysqli_query($koneksi, "UPDATE kelas SET 
    nama_kelas = '$nama_kelas', 
    kd_jurusan = '$kd_jurusan'
    WHERE kd_kelas = '$kd_kelas'");

  if ($query) {
    header("Location: index.php?aksi=suksesedit");
    exit;
  } else {
    echo "Error: " . mysqli_error($koneksi);
  }
} else {
  echo "Data tidak valid.";
}
?>
