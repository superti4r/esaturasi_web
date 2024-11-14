<?php 
require_once '../layout/_top.php';
require_once '../helper/config.php';

$kd_pengumuman = $_GET['kd_pengumuman'];
$query = mysqli_query($koneksi, "SELECT p.*, pg.nama_guru as nama_pembuat 
                                FROM pengumuman p 
                                LEFT JOIN guru pg ON p.nik = pg.nik 
                                WHERE p.kd_pengumuman = '$kd_pengumuman'");
$data = mysqli_fetch_assoc($query);
?>
<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Detail Pengumuman</h1>
    <a href="./index.php" class="btn btn-light"><i class="fas fa-arrow-left"></i> </a>
  </div>
  <section class="section">
    <div class="container py-3">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="card shadow">
            <div class="card-body">
              <div class="text-center mb-4">
                <?php if (!empty($data['file_pengumuman']) && file_exists('../uploads/pengumuman/' . $data['file_pengumuman'])): ?>
                  <img src="../uploads/pengumuman/<?php echo $data['file_pengumuman']; ?>" class="img-fluid rounded" alt="Gambar Pengumuman" style="max-height: 200px;">
                <?php else: ?>
                  <p>Tidak ada foto</p>
                <?php endif; ?>
              </div>
              <table class="table table-bordered">
                <tr>
                  <th width="30%">Kode Pengumuman</th>
                  <td><?php echo $data['kd_pengumuman']; ?></td>
                </tr>
                <tr>
                  <th>Judul</th>
                  <td><?php echo $data['judul_pengumuman']; ?></td>
                </tr>
                <tr>
                  <th>Tanggal</th>
                  <td><?php echo date('d F Y', strtotime($data['tgl_pengumuman'])); ?></td>
                </tr>
                <tr>
                  <th>Dibuat Oleh</th>
                  <td><?php echo $data['nama_pembuat']; ?></td>
                </tr>
                <tr>
                  <th>Deskripsi</th>
                  <td>
                    <div style="white-space: pre-wrap;"><?php echo $data['deskripsi_pengumuman']; ?></div>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>

<?php
require_once '../layout/_bottom.php';
?>
