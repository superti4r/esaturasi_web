<?php 
require_once '../layout/_top.php';
require_once '../helper/config.php';

// Ambil nilai kd_kelas dari parameter URL
$kd_kelas = $_GET['kd_kelas'];
$kelas_query = mysqli_query($koneksi, "SELECT * FROM vmpp WHERE kd_kelas = '$kd_kelas'");

// Cek apakah query berhasil dan menghasilkan hasil
if (isset($_GET['kd_kelas'])) {
  $kd_kelas = $_GET['kd_kelas'];

  // Query untuk mengambil nama kelas berdasarkan kd_kelas
  $kelas_query = mysqli_query($koneksi, "SELECT nama_kelas FROM kelas WHERE kd_kelas = '$kd_kelas'");
  if (mysqli_num_rows($kelas_query) > 0) {
      $kelas = mysqli_fetch_assoc($kelas_query);
      $nama_kelas = $kelas['nama_kelas'];  // Ambil nama kelas, misalnya 'X RPL 1'
  } else {
      echo "Kelas tidak ditemukan!";
      exit;
  }
} else {
  echo "ID kelas tidak ditemukan!";
  exit;
}


// Ambil tahun saat ini (ambil 2 digit terakhir dari tahun)
$tahun = substr(date("Y"), 2);  // Misalnya, 2024 -> '24'

// Ekstrak jurusan dari nama kelas
$kelas_parts = explode(' ', $nama_kelas); // Pisahkan berdasarkan spasi
$jurusan = strtoupper($kelas_parts[1]); // Ambil jurusan, misalnya 'RPL'

// Ambil dua huruf pertama dari jurusan
$kode_jurusan = substr($jurusan, 0, 2); // Misalnya, 'RPL' tetap 'RP'

// Format dasar kode mata pelajaran menjadi '24RP'
$kd_mapel_base = $tahun . $kode_jurusan; // Gabungkan untuk format '24RP'

// Query untuk mencari urutan kode mata pelajaran untuk kelas ini
$urutan_query = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM mata_pelajaran_perkelas WHERE kode_mpp LIKE '$kd_mapel_base%'");
$urutan = mysqli_fetch_assoc($urutan_query)['total'] + 1; // Urutan mata pelajaran berikutnya

// Format urutan menjadi 3 digit, misalnya 001, 002, dst.
$kd_mapel_urutan = str_pad($urutan, 3, '0', STR_PAD_LEFT);  // Format: '001', '002', dll.
$kd_mapel = $kd_mapel_base . $kd_mapel_urutan; // Gabungkan semuanya menjadi '24RP001', '24RP002', dll.

?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Tambah Mata Pelajaran ke Kelas: <?php echo htmlspecialchars($kelas['nama_kelas']); ?></h1>
    <a href="./index.php" class="btn btn-light"><i class="fas fa-arrow-left"></i> </a>
  </div>

  <div class="card">
    <div class="card-body">
    <form action="store.php" method="POST" enctype="multipart/form-data">
        <!-- Kode Mata Pelajaran (readonly) -->
        <div class="form-group">
          <label for="kode_mpp">Kode Mata Pelajaran Kelas</label>
          <input type="text" name="kd_mpp" id="kode_mpp" class="form-control" value="<?php echo $kd_mapel; ?>" readonly>
        </div>

        <input type="hidden" name="kd_kelas" value="<?php echo $kd_kelas; ?>">
        <!-- Pilihan Mata Pelajaran -->
        <div class="form-group">
          <label for="kd_mapel">Pilih Mata Pelajaran</label>
          <select name="kd_mapel" id="kd_mapel" class="form-control" required>
            <option value="">-- Pilih Mata Pelajaran --</option>
            <?php
            // Query untuk mengambil daftar mata pelajaran
            $sql_mapel = mysqli_query($koneksi, "SELECT * FROM mapel ORDER BY nama_mapel ASC");
            if (mysqli_num_rows($sql_mapel) > 0) {
                while ($mapel = mysqli_fetch_assoc($sql_mapel)) {
                    echo '<option value="' . $mapel['kd_mapel'] . '">' . htmlspecialchars($mapel['nama_mapel']) . '</option>';
                }
            } else {
                echo '<option value="">Tidak ada mata pelajaran tersedia</option>';
            }
            ?>
          </select>
        </div>

        <!-- Input Foto Mata Pelajaran -->
        <div class="form-group">
          <label for="foto_mapel">Foto Mata Pelajaran</label>
          <input type="file" name="foto_mapel" id="foto_mapel" class="form-control" accept="image/*" required>
        </div>

        <button type="submit" name="submit" class="btn btn-success">Simpan</button>
        <input class="btn btn-danger" type="reset" name="batal" value="Bersihkan">
      </form>
    </div>
  </div>
</section>

<?php require_once '../layout/_bottom.php'; ?> 