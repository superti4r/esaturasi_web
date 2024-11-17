<?php
require_once '../helper/config.php';

// Ambil parameter dari request
$kd_mapel = $_GET['kd_mapel'];
$kd_kelas = $_GET['kd_kelas'];

// Query untuk mendapatkan data guru berdasarkan kd_mapel dan kd_kelas
$query = "
  SELECT g.nama_guru 
  FROM mata_pelajaran_perkelas gmk
  JOIN guru g ON gmk.nik = g.nik
  WHERE gmk.kd_mapel = '$kd_mapel' AND gmk.kd_kelas = '$kd_kelas'
";

$result = mysqli_query($koneksi, $query);

$guru = mysqli_fetch_assoc($result);

// Kirim data nama guru dalam format JSON
header('Content-Type: application/json');
echo json_encode($guru);
?>
