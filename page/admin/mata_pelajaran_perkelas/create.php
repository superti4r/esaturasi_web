<?php
require_once '../layout/_top.php';
require_once '../helper/config.php';

$kelas = isset($_GET['kelas']) ? $_GET['kelas'] : ''; // Mendapatkan nama kelas
$kd_kelas = isset($_GET['kd_kelas']) ? $_GET['kd_kelas'] : ''; // Mendapatkan kode kelas

$sql = mysqli_query($koneksi, "SELECT * FROM mapel ORDER BY nama_mapel ASC");

?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Atur Jadwal Kelas <?php echo htmlspecialchars($kelas); ?></h1>
    <a href="./index.php" class="btn btn-light"><i class="fas fa-arrow-left"></i> </a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
      <div class="modal-body">
        <form id="formData" action="store.php?kelas=<?php echo urlencode($kelas); ?>&kd_kelas=<?php echo urlencode($kd_kelas); ?>" method="POST">
            <div class="filter-container">
                <label>Pilih Mapel</label>
                <?php
                // Query untuk mengambil semua mata pelajaran
                $sql = mysqli_query($koneksi, "SELECT * FROM mapel");

                // Query untuk mendapatkan mata pelajaran yang sudah terdaftar di kelas ini
                $sql_terdaftar = mysqli_query($koneksi, "SELECT kd_mapel FROM mata_pelajaran_perkelas WHERE kd_kelas = '$kd_kelas'");
                $mapel_terdaftar = [];
                while ($row = mysqli_fetch_assoc($sql_terdaftar)) {
                    $mapel_terdaftar[] = $row['kd_mapel'];
                }

                if (mysqli_num_rows($sql) > 0) {
                    // Perulangan untuk menampilkan checkbox untuk setiap mata pelajaran
                    while ($data = mysqli_fetch_assoc($sql)) {
                        // Cek apakah mata pelajaran sudah terdaftar di kelas
                        $checked = in_array($data['kd_mapel'], $mapel_terdaftar) ? 'checked' : '';

                        echo '
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="mata_pelajaran[]" value="' . $data['kd_mapel'] . '" id="mapel_' . $data['kd_mapel'] . '" ' . $checked . '>
                            <label class="form-check-label" for="mapel_' . $data['kd_mapel'] . '">
                                ' . htmlspecialchars($data['nama_mapel']) . '
                            </label>
                        </div>';
                    }
                } else {
                    echo '<p>Tidak ada mata pelajaran yang tersedia.</p>';
                }
                ?>

                <button type="submit" name="simpan" class="btn btn-primary btn-block mt-3">Simpan Pilihan</button>
            </div>
        </form>
        </div>
    </div>
</div>

</section>
<script>
    // Mendapatkan elemen tombol reset
    const resetButton = document.querySelector('input[type="reset"]');

    // Menambahkan event listener untuk tombol reset
    resetButton.addEventListener('click', function(event) {
      
        // Jika ingin membersihkan gambar yang sudah di-upload
        const fotoInput = document.querySelector('input[name="foto"]');
        if (fotoInput) {
            fotoInput.value = ''; // Mengosongkan input file jika ada
        }

        // Jika ingin mereset seluruh form
        document.getElementById('form-tambah-guru').reset();
    });
</script>

<?php
require_once '../layout/_bottom.php';
?>
