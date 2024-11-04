<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$siswa = mysqli_query($connection, "SELECT COUNT(*) FROM guru");
$siswa = mysqli_query($connection, "SELECT COUNT(*) FROM guru");
$siswa = mysqli_query($connection, "SELECT COUNT(*) FROM guru");
$siswa = mysqli_query($connection, "SELECT COUNT(*) FROM guru");

$total_siswa = mysqli_fetch_array($siswa)[0];
$total_siswa = mysqli_fetch_array($siswa)[0];
$total_siswa = mysqli_fetch_array($siswa)[0];
$total_siswa = mysqli_fetch_array($siswa)[0];
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
              <?= $total_siswa ?>
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
            <i class="fas fa-book"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Total Mata Pelajaran</h4>
            </div>
            <div class="card-body">
              <?= $total_siswa ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-success">
            <i class="fas fa-school"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Total Kelas</h4>
            </div>
            <div class="card-body">
              <?= $total_siswa ?>
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