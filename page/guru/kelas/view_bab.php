<?php
// Start output buffering to prevent output before header redirection
ob_start();

require_once '../helper/config.php';
require_once '../layout/_top.php';

$kode_mpp = isset($_GET['kode_mpp']) ? $_GET['kode_mpp'] : '';
$kd_mapel = isset($_GET['kd_mapel']) ? $_GET['kd_mapel'] : '';
$kd_bab = isset($_GET['kd_bab']) ? $_GET['kd_bab'] : '';
$kd_kelas = isset($_GET['kd_kelas']) ? $_GET['kd_kelas'] : '';

// Query untuk memeriksa data bab
$sql_bab = mysqli_query($koneksi, "
    SELECT * 
    FROM vbabkelas
    WHERE kd_bab = '$kd_bab' AND kode_mpp ='$kode_mpp'
");
$data_bab = mysqli_fetch_array($sql_bab);
if (mysqli_num_rows($sql_bab) > 0) {
    $bab = mysqli_fetch_assoc($sql_bab);
} else {
    // Jika tidak ada bab, langsung redirect ke halaman createbab.php
    header("Location:createbab.php?kode_mpp=" . urlencode($kode_mpp) . "&kd_bab=" . urlencode($kd_bab) . "&kd_kelas=" . urlencode($kd_kelas) . "&error=Data bab tidak ditemukan");
    exit;  // Pastikan eksekusi berhenti setelah header
}

// Cek apakah materi, pretest, dan post-test sudah ada
$sql_materi = mysqli_query($koneksi, "
    SELECT * 
    FROM vmateri 
    WHERE kode_mpp = '$kode_mpp' AND kd_bab = '$kd_bab'
");
$data_materi = mysqli_fetch_assoc($sql_materi);
$sql_pretest = mysqli_query($koneksi, "
    SELECT * 
    FROM vpretest 
    WHERE kode_mpp = '$kode_mpp' AND kd_bab = '$kd_bab'
");
$data_pretest = mysqli_fetch_assoc($sql_pretest);
$sql_tugas = mysqli_query($koneksi, "
    SELECT * 
    FROM vtugas 
    WHERE kode_mpp = '$kode_mpp' AND kd_bab = '$kd_bab'
");
$data_tugas = mysqli_fetch_assoc($sql_tugas);
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1><i class="fas fa-book-reader mr-2"></i> Lihat Bab: <?php echo htmlspecialchars($data_bab['nama_bab'] ?? ''); ?></h1>
    <a href="./index.php" class="btn btn-light ml-auto"><i class="fas fa-arrow-left"></i> </a>
  </div>
  <div class="card mb-4 shadow-sm border-primary">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0">Mengelola <?php echo htmlspecialchars($bab['nama_bab'] ?? ''); ?> : <?php echo htmlspecialchars($data_bab['judul_bab'] ?? ''); ?></h5>
    </div>
    <div class="card-body">
      <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger">
          <?php echo htmlspecialchars($error_message); ?>
        </div>
      <?php else: ?>
        <div class="mb-3">
          <!-- Edit Judul Bab -->
          <a href="edit_bab.php?kode_mpp=<?php echo urlencode($kode_mpp); ?>&kd_bab=<?php echo urlencode($kd_bab); ?>&kd_bab_kelas=<?php echo urlencode($data_bab['kd_bab_kelas']); ?>" 
             class="btn <?php echo $data_bab['judul_bab'] ? 'btn-success' : 'btn-secondary'; ?> btn-sm">
            Edit Judul Bab
          </a>
        </div>

        <div class="mb-3">
          <!-- Edit Pretest -->
          <a href="pretest.php?kode_mpp=<?php echo urlencode($kode_mpp); ?>&kd_mapel=<?php echo urlencode($kd_mapel); ?>&kd_kelas=<?php echo urlencode($kd_kelas); ?>&kd_bab_kelas=<?php echo urlencode($data_bab['kd_bab_kelas']); ?>" 
             class="btn <?php echo $data_pretest ? 'btn-success' : 'btn-secondary'; ?> btn-sm">
            Edit Pretest
          </a>
        </div>

        <div class="mb-3">
          <!-- Upload Materi -->
          <a href="materi.php?kode_mpp=<?php echo urlencode($kode_mpp); ?>&kd_mapel=<?php echo urlencode($kd_mapel); ?>&kd_kelas=<?php echo urlencode($kd_kelas); ?>&kd_bab=<?php echo urlencode($kd_bab); ?>" 
             class="btn <?php echo $data_materi ? 'btn-success' : 'btn-secondary'; ?> btn-sm">
            Upload Materi
          </a>
        </div>

        <div class="mb-3">
          <!-- Edit Tugas -->
          <a href="tugas.php?kode_mpp=<?php echo urlencode($kode_mpp); ?>&kd_mapel=<?php echo urlencode($kd_mapel); ?>&kd_kelas=<?php echo urlencode($kd_kelas); ?>&kd_bab_kelas=<?php echo urlencode($data_bab['kd_bab_kelas']); ?>" 
             class="btn <?php echo $data_tugas ? 'btn-success' : 'btn-secondary'; ?> btn-sm">
            Edit Tugas
          </a>
        </div>

        <div class="mb-3">
          <!-- Edit Post Test -->
          <a href="edit_post_test.php?kode_mpp=<?php echo urlencode($kode_mpp); ?>&kd_mapel=<?php echo urlencode($kd_mapel); ?>&kd_kelas=<?php echo urlencode($kd_kelas); ?>" 
             class="btn <?php echo $data_posttest ? 'btn-success' : 'btn-secondary'; ?> btn-sm">
            Edit Post Test
          </a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php require_once '../layout/_bottom.php'; ?>

<?php
// End output buffering and flush the output
ob_end_flush();
?>
