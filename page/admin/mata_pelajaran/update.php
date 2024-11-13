<?php
require_once '../helper/config.php';

$id_mapel = $_GET['kd_mapel'];
$sql = mysqli_query($koneksi, "SELECT * FROM mapel WHERE kd_mapel='$id_mapel'");
$data = mysqli_fetch_array($sql);

if (isset($_POST['kirim'])) {
  $kd_mapel=$_POST['kd_mapel'];
  $nama_mapel=$_POST['nama_mapel'];
  $cek_mapel = mysqli_query($koneksi, "SELECT * FROM mapel WHERE nama_mapel='$nama_mapel'");
    
  if (mysqli_num_rows($cek_mapel) > 0) {
      // Jika mapel sudah ada, tampilkan pesan
      echo "<script>alert('Nama mata pelajaran sudah tersedia. Mohon masukkan nama mata pelajaran yang berbeda.'); window.history.back();</script>";
      exit();
  }
  mysqli_query($koneksi, "UPDATE mapel SET 
    nama_mapel = '$nama_mapel'
    WHERE 
    kd_mapel ='$kd_mapel'
");
  header("Location:index.php?aksi=suksesedit");
}

?>

