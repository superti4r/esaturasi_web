<?php
require_once '../layout/_top.php';
require_once '../helper/config.php';

$query_guru = "SELECT COUNT(*) AS total_guru FROM guru"; 
$result_guru = mysqli_query($koneksi, $query_guru);
if ($result_guru) {
    $row_guru = mysqli_fetch_assoc($result_guru);
    $total_guru = $row_guru['total_guru'];
} else {
    $total_guru = 0;
}


$query_siswa = "SELECT COUNT(*) AS total_siswa FROM siswa"; 
$result_siswa = mysqli_query($koneksi, $query_siswa);
if ($result_siswa) {
    $row_siswa = mysqli_fetch_assoc($result_siswa);
    $total_siswa = $row_siswa['total_siswa'];
} else {
    $total_siswa = 0;
}


$query_mapel = "SELECT COUNT(*) AS total_mapel FROM mapel"; // Ganti 'mata_pelajaran' dengan nama tabel yang sesuai
$result_mapel = mysqli_query($koneksi, $query_mapel);
if ($result_mapel) {
    $row_mapel = mysqli_fetch_assoc($result_mapel);
    $total_mapel = $row_mapel['total_mapel'];
} else {
    $total_mapel = 0;
}


$query_kelas = "SELECT COUNT(*) AS total_kelas FROM kelas"; 
$result_kelas = mysqli_query($koneksi, $query_kelas);
if ($result_kelas) {
    $row_kelas = mysqli_fetch_assoc($result_kelas);
    $total_kelas = $row_kelas['total_kelas'];
} else {
    $total_kelas = 0;
}
?>


<section class="section">
  <div class="section-header">
    <h1>Dashboard</h1>
  </div>
  <div class="column">
    <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-primary">
            <i class="far fa-user"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Total Guru</h4>
            </div>
            <div class="card-body">
              <?= $total_guru ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-danger">
            <i class="fas fa-users"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Total Siswa</h4>
            </div>
            <div class="card-body">
              <?= $total_siswa ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">

      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-warning">
            <i class="fas fa-school"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Total Kelas</h4>
            </div>
            <div class="card-body">
              <?= $total_kelas ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-success">
            <i class="fas fa-book"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Total Mata Pelajaran</h4>
            </div>
            <div class="card-body">
              <?= $total_mapel ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>



<?php
require_once '../layout/_bottom.php';
?>