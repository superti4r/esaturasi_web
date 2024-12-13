<?php
require_once '../layout/_top.php';
require_once '../helper/config.php';

// Set zona waktu
date_default_timezone_set('Asia/Jakarta');

// Ambil NIK guru dari session
$nik = $_SESSION['nik'];

// Query untuk mendapatkan data total kelas yang unik berdasarkan nik
$total_kelas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(DISTINCT kd_kelas) AS total FROM vmpp WHERE nik = '$nik'"))['total'];

// Query untuk mendapatkan total mata pelajaran yang unik berdasarkan nik
$total_mapel = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(DISTINCT kd_mapel) AS total FROM vmpp WHERE nik = '$nik'"))['total'];

// Query untuk mendapatkan jumlah tugas berdasarkan nik
$total_tugas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM vtugas WHERE nik = '$nik'"))['total'];

// Hari dan jam sekarang
$hari_indo = [
    'Sunday' => 'Minggu',
    'Monday' => 'Senin',
    'Tuesday' => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis',
    'Friday' => 'Jumat',
    'Saturday' => 'Sabtu'
];
$hari = (new DateTime())->format('l');
$hari = $hari_indo[$hari];
$jam_sekarang = date('H:i');

// Query untuk mendapatkan jadwal mengajar hari ini berdasarkan nik
$query_jadwal = mysqli_query($koneksi, "
  SELECT kd_mapel, nama_mapel, dari_jam, sampai_jam, nama_kelas
  FROM vjadwal
  WHERE nik = '$nik' AND hari = '$hari'
  ORDER BY dari_jam ASC
");
?>


<section class="section">
  <div class="section-header">
    <h1>Dashboard</h1>
  </div>
  <div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-warning text-white">
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
        <div class="card-icon bg-success text-white">
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
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-info text-white">
          <i class="fas fa-tasks"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Total Tugas</h4>
          </div>
          <div class="card-body">
            <?= $total_tugas ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Jadwal Mengajar Hari Ini -->
  <div class="row mt-4">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Jadwal Mengajar Hari Ini (<?= ucfirst($hari) ?>)</h4>
          <div style="float: right; font-size: 1.2em; font-weight: bold;">
            <?= $jam_sekarang ?> <!-- Menampilkan Jam Sekarang di sebelah kanan -->
          </div>
        </div>
        <div class="card-body">
          <?php if (mysqli_num_rows($query_jadwal) > 0): ?>
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Jam</th>
                  <th>Mata Pelajaran</th>
                  <th>Kelas</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($data = mysqli_fetch_assoc($query_jadwal)): ?>
                  <tr>
                    <td><?= $data['dari_jam'] ?> - <?= $data['sampai_jam'] ?></td>
                    <td><?= $data['nama_mapel'] ?></td>
                    <td><?= $data['nama_kelas'] ?></td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          <?php else: ?>
            <p>Tidak ada jadwal mengajar hari ini.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

</section>

<?php
require_once '../layout/_bottom.php';
?>  
