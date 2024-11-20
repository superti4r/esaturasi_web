<?php 
require_once '../layout/_top.php';
require_once '../helper/config.php';

// Mengecek apakah form disubmit
if (isset($_POST['submit'])) {
    // Mengambil data dari form
    $kd_bab_kelas = $_POST['kd_bab_kelas'];  // Mendapatkan nilai dari input hidden
    $judul_bab = $_POST['judul_bab'];  // Nama bab yang diinputkan di form
    $kode_mpp = $_POST['kode_mpp']; // Kode mata pelajaran dari parameter URL

    // Query untuk UPDATE data bab
    $sql_update = mysqli_query($koneksi, "
        UPDATE bab_kelas 
        SET judul_bab = '$judul_bab' 
        WHERE kd_bab_kelas = '$kd_bab_kelas' AND kode_mpp='$kode_mpp'
    ");

    if ($sql_update) {
        // Jika berhasil update
        echo "<script>alert('Data berhasil diperbarui!'); window.location.href='index.php';</script>";
    } else {
        // Jika gagal update
        echo "<script>alert('Terjadi kesalahan saat memperbarui data.'); window.location.href='createbab.php';</script>";
    }
}

// Mendapatkan data bab untuk ditampilkan di form jika sedang mengedit
$kd_mpp1 = isset($_GET['kode_mpp']) ? $_GET['kode_mpp'] : '';
$kd_bab1 = isset($_GET['kd_bab']) ? $_GET['kd_bab'] : '';
$kd_bab_kelas = isset($_GET['kd_bab_kelas']) ? $_GET['kd_bab_kelas'] : '';
$sqlbab = mysqli_query($koneksi, "
    SELECT judul_bab FROM bab_kelas 
    WHERE kode_mpp ='$kd_mpp1' AND kd_bab='$kd_bab1' AND kd_bab_kelas='$kd_bab_kelas'");
$data = mysqli_fetch_array($sqlbab); 
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Edit Judul Bab</h1>
    <a href="./index.php" class="btn btn-light"><i class="fas fa-arrow-left"></i> </a>
  </div>

  <div class="card">
    <div class="card-body">
      <form action="edit_bab.php" method="POST" enctype="multipart/form-data">
        <!-- Nama Bab -->
        <div class="form-group">
          <label for="judul_bab">Nama Bab</label>
          <input type="text" name="judul_bab" id="judul_bab" class="form-control" value="<?php echo htmlspecialchars($data['judul_bab']); ?>" required>
        </div>

        <!-- Hidden untuk kode_bab_kelas dan kode_mpp -->
        <input type="hidden" name="kd_bab_kelas" value="<?php echo htmlspecialchars($kd_bab_kelas); ?>">
        <input type="hidden" name="kd_bab" value="<?php echo htmlspecialchars($kd_bab1); ?>">
        <input type="hidden" name="kode_mpp" value="<?php echo htmlspecialchars($kd_mpp1); ?>">

        <button type="submit" name="submit" class="btn btn-success">Simpan</button>
        <input class="btn btn-danger" type="reset" name="batal" value="Bersihkan">
      </form>
    </div>
  </div>
</section>

<?php require_once '../layout/_bottom.php'; ?>
