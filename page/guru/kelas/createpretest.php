<?php 
require_once '../layout/_top.php';
require_once '../helper/config.php';

// Mengecek apakah form disubmit
if (isset($_POST['submit'])) {
    // Mengambil data dari form
    $judul_pretest = mysqli_real_escape_string($koneksi, $_POST['judul_pretest']);
    $kd_bab_kelas = $_POST['kd_bab_kelas'];
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $waktu_pengerjaan = $_POST['waktu_pengerjaan']; // Menggunakan tipe DATE/TIME
    $selesai_pengerjaan = $_POST['selesai_pengerjaan'];
    $kd_pretest ="";

    // Query untuk INSERT data pretest
    $sql_insert = mysqli_query($koneksi, "
    INSERT INTO pretest (judul_pretest, kd_bab_kelas, deskripsi, waktu_pengerjaan, selesai_pengerjaan)
    VALUES ('$judul_pretest', '$kd_bab_kelas', '$deskripsi', '$waktu_pengerjaan', '$selesai_pengerjaan')
");

    if ($sql_insert) {
        echo "<script>alert('Data pretest berhasil disimpan!'); window.location.href='pretest.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menyimpan data pretest.'); window.location.href='createpretest.php';</script>";
    }
}

$kd_mpp1 = isset($_GET['kode_mpp']) ? $_GET['kode_mpp'] : '';
$kd_bab_kelas = isset($_GET['kd_bab_kelas']) ? $_GET['kd_bab_kelas'] : '';
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Buat Pretest</h1>
    <a href="./index.php" class="btn btn-light"><i class="fas fa-arrow-left"></i> </a>
  </div>

  <div class="card">
    <div class="card-body">
      <form action="createpretest.php" method="POST" enctype="multipart/form-data">
        <!-- Judul Pretest -->
        <div class="form-group">
          <label for="judul_pretest">Judul Pretest</label>
          <input type="text" name="judul_pretest" id="judul_pretest" class="form-control" required>
        </div>

        <!-- Deskripsi -->
        <div class="form-group">
          <label for="deskripsi">Deskripsi</label>
          <textarea name="deskripsi" id="deskripsi" class="form-control" rows="5" required></textarea>
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
