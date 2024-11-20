<?php
require_once '../layout/_top.php';
require_once '../helper/config.php';

// Contoh penghitungan total data dari database (ganti query sesuai kebutuhan)
$total_guru = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM guru"));
$total_siswa = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM siswa"));
$total_kelas = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kelas"));
$total_mapel = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM mapel"));

?>

<section class="section">
  <div class="section-header">
    <h1>Dashboard</h1>
  </div>
  <div class="row">
    <!-- Total Guru -->
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
    <!-- Total Siswa -->
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
    <!-- Total Kelas -->
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
    <!-- Total Mata Pelajaran -->
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
  <!-- Row tambahan untuk informasi lain -->
  <div class="row mt-4">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Selamat Datang</h4>
        </div>
        <div class="card-body">
          <p>Selamat datang di Dashboard Sistem E-Learning. Anda dapat mengelola data guru, siswa, kelas, dan mata pelajaran dari menu yang tersedia.</p>
         
        </div>
      </div>
    </div>
  </div>
</section>

<?php
require_once '../layout/_bottom.php';
?>
