<?php 
require_once '../layout/_top.php';
require_once '../helper/config.php';

// Mengecek apakah form disubmit
if (isset($_POST['submit'])) {
    // Mengambil data dari form
    $judul_posttest = mysqli_real_escape_string($koneksi, $_POST['judul_posttest']);
    $kd_bab_kelas = $_POST['kd_bab_kelas'];
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $kkm = mysqli_real_escape_string($koneksi, $_POST['kkm']);
    $waktu_pengerjaan = $_POST['waktu_pengerjaan']; // Menggunakan tipe DATE/TIME
    $selesai_pengerjaan = $_POST['selesai_pengerjaan'];
    $kd_posttest ="";

    // Query untuk INSERT data posttest
    $sql_insert = mysqli_query($koneksi, "
    INSERT INTO posttest (judul_posttest, kd_bab_kelas, deskripsi, kkm, waktu_pengerjaan, selesai_pengerjaan)
    VALUES ('$judul_posttest', '$kd_bab_kelas', '$deskripsi', '$kkm', '$waktu_pengerjaan', '$selesai_pengerjaan')
");

    if ($sql_insert) {
        echo "<script>alert('Data posttest berhasil disimpan!'); window.location.href='posttest.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menyimpan data posttest.'); window.location.href='createposttest.php';</script>";
    }
}

$kd_mpp1 = isset($_GET['kode_mpp']) ? $_GET['kode_mpp'] : '';
$kd_bab_kelas = isset($_GET['kd_bab_kelas']) ? $_GET['kd_bab_kelas'] : '';
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Buat posttest</h1>
    <a href="./index.php" class="btn btn-light"><i class="fas fa-arrow-left"></i> </a>
  </div>

  <div class="card">
    <div class="card-body">
      <form action="createposttest.php" method="POST" enctype="multipart/form-data">
        <!-- Judul posttest -->
        <div class="form-group">
          <label for="judul_posttest">Judul posttest</label>
          <input type="text" name="judul_posttest" id="judul_posttest" class="form-control" required>
        </div>

        <!-- Deskripsi -->
        <div class="form-group">
          <label for="deskripsi">Deskripsi</label>
          <textarea name="deskripsi" id="deskripsi" class="form-control" rows="5" required></textarea>
        </div>

        <!-- KKM -->
        <div class="form-group">
          <label for="kkm">KKM</label>
          <textarea name="kkm" id="kkm" class="form-control" rows="5" required></textarea>
        </div>

        <!-- Waktu Pengerjaan -->
        <div class="form-group">
          <label for="waktu_pengerjaan">Waktu Pengerjaan</label>
          <input type="datetime-local" name="waktu_pengerjaan" id="waktu_pengerjaan" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="waktu_pengerjaan">Selesai Pengerjaan</label>
          <input type="datetime-local" name="selesai_pengerjaan" id="selesai_pengerjaan" class="form-control" required>
        </div>

     
        <!-- Hidden untuk kode_mpp -->

        <input type="hidden" name="kd_bab_kelas" value="<?php echo htmlspecialchars($kd_bab_kelas); ?>">

        <button type="submit" name="submit" class="btn btn-success">Simpan</button>
        <input class="btn btn-danger" type="reset" name="batal" value="Bersihkan">
      </form>
    </div>
  </div>
</section>

<?php require_once '../layout/_bottom.php'; ?>
