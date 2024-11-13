<?php
session_start();
require_once '../helper/config.php';
if (isset($_GET['pesan'])) {
  $kd_jurusan = $_GET['kd_jurusan'];
  mysqli_query($koneksi, "DELETE FROM jurusan WHERE kd_jurusan='$kd_jurusan'");
  header("Location:index.php?aksi=hapusok");
}
?>
