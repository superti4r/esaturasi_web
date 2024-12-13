<?php
require_once '../layout/_top.php';
require_once '../helper/config.php';

// Membuat kode otomatis untuk Tahun Ajaran
$sql = mysqli_query($koneksi, "SELECT * FROM tahun_ajaran ORDER BY kd_tahun_ajaran DESC");
$row = mysqli_num_rows($sql);
$data = mysqli_fetch_array($sql);
$kd = isset($data['kd_tahun_ajaran']) ? $data['kd_tahun_ajaran'] : 'TA00';
$kd = (int)substr($kd, 2, 2) + 1;
$kd = "TA" . sprintf("%02s", $kd);
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Tambah Tahun Ajaran</h1>
    <a href="./index.php" class="btn btn-light"><i class="fas fa-arrow-left"></i></a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- Form -->
          <form action="store.php" method="POST" enctype="multipart/form-data">
            <table cellpadding="8" class="w-100">

             
              <tr>
                <td>Tahun Mulai</td>
                <td><input class="form-control" type="number" name="tahun_mulai" required min="2000" max="2100" placeholder="Contoh: 2023"></td>
              </tr>

              <tr>
                <td>Tahun Selesai</td>
                <td><input class="form-control" type="number" name="tahun_selesai" required min="2000" max="2100" placeholder="Contoh: 2024"></td>
              </tr>
              <tr>
                <td>Semester</td>
                <td>
                  <select class="form-control" name="semester" required>
                    <option value="" disabled selected>--Pilih Semester--</option>
                    <option value="ganjil">Ganjil</option>
                    <option value="genap">Genap</option>
                  </select>
                </td>
              </tr>

              <tr>
                <td>Tanggal Mulai</td>
                <td><input class="form-control" type="date" name="tanggal_mulai" required></td>
              </tr>

              <tr>
                <td>Tanggal Selesai</td>
                <td><input class="form-control" type="date" name="tanggal_selesai" required></td>
              </tr>

          

              <tr>
                <td colspan="3">
                  <button type="submit" name="proses" class="btn btn-success">Simpan</button>
                  <input class="btn btn-warning" type="reset" name="batal" value="Bersihkan">
                  <a href="index.php" class="btn btn-danger">Batal</a>
                </td>
              </tr>

            </table>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
    // Mendapatkan elemen tombol reset
    const resetButton = document.querySelector('input[type="reset"]');

    // Menambahkan event listener untuk tombol reset
    resetButton.addEventListener('click', function(event) {
        // Jika ingin mereset seluruh form
        const form = document.querySelector('form');
        form.reset();
    });
</script>

<?php
require_once '../layout/_bottom.php';
?>
