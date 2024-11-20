<?php 
require_once '../layout/_top.php';
require_once '../helper/config.php';

// Mengecek apakah form disubmit
if (isset($_POST['submit'])) {
    // Mengambil data dari form
    $kd_bab = $_POST['kd_bab'];
    $kd="";
    $judul_bab = mysqli_real_escape_string($koneksi, $_POST['judul_bab']);  // Nama bab yang diinputkan di form
    $kode_mpp = $_POST['kode_mpp']; // Kode mata pelajaran dari parameter URL

    // Query untuk INSERT data bab
    $sql_insert = mysqli_query($koneksi, "
        INSERT INTO bab_kelas (kd_bab_kelas, kd_bab, kode_mpp, judul_bab)
        VALUES ('$kd', '$kd_bab', '$kode_mpp', '$judul_bab')
    ");
    if ($sql_insert) {
        // Jika berhasil insert
        echo "<script>alert('Data berhasil disimpan!'); window.location.href='index.php';</script>";
    } else {
        // Jika gagal insert 
        echo "<script>alert('Terjadi kesalahan saat menyimpan data.'); window.location.href='createbab.php';</script>";
    }
}

// Mendapatkan data bab untuk ditampilkan di form jika sedang mengedit
$kd_mpp1 = isset($_GET['kode_mpp']) ? $_GET['kode_mpp'] : '';
$kd_bab1 = isset($_GET['kd_bab']) ? $_GET['kd_bab'] : '';
$sqlbab = mysqli_query($koneksi, "
    SELECT nama_bab FROM bab 
    WHERE kd_bab='$kd_bab1'");
$data = mysqli_fetch_array($sqlbab); 
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Tambah Bab : <?php echo htmlspecialchars($data['nama_bab']); ?></h1>
    <a href="./index.php" class="btn btn-light"><i class="fas fa-arrow-left"></i> </a>
  </div>

  <div class="card">
    <div class="card-body">
      <form action="createbab.php" method="POST" enctype="multipart/form-data">
        <!-- Nama Bab -->
        <div class="form-group">
          <label for="judul_bab">Nama Bab</label>
          <input type="text" name="judul_bab" id="judul_bab" class="form-control" value="" required>
        </div>

        <!-- Hidden untuk kode_bab dan kode_mpp -->
        <input type="hidden" name="kd_bab" value="<?php echo htmlspecialchars($kd_bab1); ?>">
        <input type="hidden" name="kode_mpp" value="<?php echo htmlspecialchars($kd_mpp1); ?>">

        <button type="submit" name="submit" class="btn btn-success">Simpan</button>
        <input class="btn btn-danger" type="reset" name="batal" value="Bersihkan">
      </form>
    </div>
  </div>
</section>

<?php require_once '../layout/_bottom.php'; ?>
