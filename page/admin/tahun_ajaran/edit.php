<?php
require_once '../layout/_top.php';
require_once '../helper/config.php';

// Mendapatkan ID Tahun Ajaran yang akan diedit
if (!isset($_GET['id'])) {
    echo "<script>alert('ID Tahun Ajaran tidak ditemukan!'); window.location='index.php';</script>";
    exit();
}

$kd_tahun_ajaran = $_GET['id'];

// Ambil data Tahun Ajaran berdasarkan ID
$query = mysqli_query($koneksi, "SELECT * FROM tahun_ajaran WHERE kd_tahun_ajaran='$kd_tahun_ajaran'");
$data = mysqli_fetch_array($query);

if (!$data) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='index.php';</script>";
    exit();
}
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Edit Tahun Ajaran</h1>
    <a href="./index.php" class="btn btn-light"><i class="fas fa-arrow-left"></i></a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- Form -->
          <form action="update.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="kd_tahun_ajaran" value="<?= $data['kd_tahun_ajaran'] ?>">
            <table cellpadding="8" class="w-100">

              <tr>
                <td>Tahun Mulai</td>
                <td><input class="form-control" type="number" name="tahun_mulai" value="<?= $data['tahun_mulai'] ?>" readonly min="2000" max="2100" placeholder="Contoh: 2023"></td>
              </tr>

              <tr>
                <td>Tahun Selesai</td>
                <td><input class="form-control" type="number" name="tahun_selesai" value="<?= $data['tahun_selesai'] ?>" readonly min="2000" max="2100" placeholder="Contoh: 2024"></td>
              </tr>
              <tr>
                <td>Semester</td>
                <td><input class="form-control" type="number" name="semester" value="<?= $data['semester'] ?>" readonly min="2000" max="2100" placeholder="Contoh: 2024"></td>
              </tr>

             

              <tr>
                <td>Tanggal Mulai</td>
                <td><input class="form-control" type="date" name="tanggal_mulai" value="<?= $data['tanggal_mulai'] ?>" required></td>
              </tr>

              <tr>
                <td>Tanggal Selesai</td>
                <td><input class="form-control" type="date" name="tanggal_selesai" value="<?= $data['tanggal_selesai'] ?>" required></td>
              </tr>

              <tr>
                <td>Status</td>
                <td>
                  <select class="form-control" name="status" required>
                    <option value="" disabled>--Pilih Status--</option>
                    <option value="aktif" <?= $data['status'] == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                    <option value="nonaktif" <?= $data['status'] == 'nonaktif' ? 'selected' : '' ?>>Tidak Aktif</option>
                  </select>
                </td>
              </tr>

              <tr>
                <td colspan="3">
                  <button type="submit" name="proses" class="btn btn-success">Simpan</button>
                  <a href="./index.php" class="btn btn-danger">Batal</a>
                </td>
              </tr>

            </table>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
require_once '../layout/_bottom.php';
?>
