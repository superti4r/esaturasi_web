<?php
session_start();
require_once '../helper/config.php';
if (isset($_GET['pesan'])) {
  $kd_mapel = $_GET['kd_mapel'];
  mysqli_query($koneksi, "DELETE FROM mapel WHERE kd_mapel='$kd_mapel'");
  header("Location:index.php?aksi=hapusok");
}
?>
