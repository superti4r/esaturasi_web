<?php 
require_once '../layout/_top.php';
require_once '../helper/config.php';

$kd_pretest = isset($_GET['kd_pretest']) ? $_GET['kd_pretest'] : '';

// Mengecek apakah form disubmit
if (isset($_POST['submit'])) {
    $pertanyaan = mysqli_real_escape_string($koneksi, $_POST['pertanyaan']);
    $jawaban_a = mysqli_real_escape_string($koneksi, $_POST['jawaban_a']);
    $jawaban_b = mysqli_real_escape_string($koneksi, $_POST['jawaban_b']);
    $jawaban_c = mysqli_real_escape_string($koneksi, $_POST['jawaban_c']);
    $jawaban_d = mysqli_real_escape_string($koneksi, $_POST['jawaban_d']);
    $jawaban_benar = mysqli_real_escape_string($koneksi, $_POST['jawaban_benar']);

    $kd_pretest = $_POST['kd_pretest'];
    $kd_soal="";
    $sql_insert = "
        INSERT INTO soal_pretest (kd_soal,kd_pretest, pertanyaan, opsi_a, opsi_b, opsi_c, opsi_d, jawab_benar) 
        VALUES ('$kd_soal','$kd_pretest', '$pertanyaan', '$jawaban_a', '$jawaban_b', '$jawaban_c', '$jawaban_d', '$jawaban_benar')
    ";

    if (mysqli_query($koneksi, $sql_insert)) {
        echo "<script>alert('Soal pretest berhasil disimpan!'); window.location.href='daftar_soal_pretest.php?kd_pretest=$kd_pretest';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menyimpan soal pretest.');</script>";
    }
}
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Buat Soal Pretest</h1>
    <a href="daftar_soal_pretest.php?kd_pretest=<?php echo $kd_pretest; ?>" class="btn btn-light"><i class="fas fa-arrow-left"></i> </a>
  </div>

  <div class="card">
    <div class="card-body">
      <form action="create_soal.php?kd_pretest=<?php echo $kd_pretest; ?>" method="POST">
        <!-- Pertanyaan -->
        <div class="form-group">
          <label for="pertanyaan">Pertanyaan</label>
          <textarea name="pertanyaan" id="pertanyaan" class="form-control" rows="5" required></textarea>
        </div>

        <!-- Pilihan Jawaban -->
        <div class="form-group">
          <label for="jawaban_a">Jawaban A</label>
          <input type="text" name="jawaban_a" id="jawaban_a" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="jawaban_b">Jawaban B</label>
          <input type="text" name="jawaban_b" id="jawaban_b" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="jawaban_c">Jawaban C</label>
          <input type="text" name="jawaban_c" id="jawaban_c" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="jawaban_d">Jawaban D</label>
          <input type="text" name="jawaban_d" id="jawaban_d" class="form-control" required>
        </div>

        <input type="hidden" name="kd_pretest" value="<?php echo htmlspecialchars($kd_pretest); ?>">

        <!-- Jawaban Benar -->
        <div class="form-group">
          <label for="jawaban_benar">Jawaban Benar</label>
          <select name="jawaban_benar" id="jawaban_benar" class="form-control" required>
            <option value="">-- Pilih Jawaban Benar --</option>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
          </select>
        </div>

        <button type="submit" name="submit" class="btn btn-success">Simpan</button>
        <input class="btn btn-danger" type="reset" name="batal" value="Bersihkan">
      </form>
    </div>
  </div>
</section>

<?php require_once '../layout/_bottom.php'; ?>