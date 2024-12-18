<?php
require_once '../layout/_top.php';
require_once '../helper/config.php';
// Mendapatkan tanggal hari ini
$current_date = date('Y-m-d');
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Tambah Siswa</h1>
    <a href="./index.php" class="btn btn-light"><i class="fas fa-arrow-left"></i> </a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
        <form action="upload_excel.php" method="POST" enctype="multipart/form-data" class="row align-items-center mb-4">
  <div class="col-md-9">
    <label for="excelFile" class="form-label">Upload Data Siswa (Excel)</label>
    <input type="file" name="file_excel" class="form-control" name="excelFile" id="excelFile" accept=".xlsx, .xls" required>
  </div>
  <div class="col-md-3">
    <label class="d-none d-md-block">&nbsp;</label>
    <button type="submit" name="upload" class="btn btn-primary w-100">Upload</button>
  </div>
</form>

          <!-- Form -->
          <form action="store.php" method="POST" enctype="multipart/form-data">
            <table cellpadding="8" class="w-100">

              <tr>
                <td>NISN</td>
                <td><input class="form-control" type="text" name="nisn" required placeholder="10 Digit"></td>
              </tr>

              <tr>
                <td>Nama Lengkap</td>
                <td><input class="form-control" type="text" name="nama_siswa" placeholder="Tidak Boleh Mengandung Angka/Simbol"></td>
              </tr>

              <tr>
                <td>Tempat Lahir</td>
                <td><input class="form-control" type="text" name="tempat_lahir" placeholder="Contoh Probolinggo"></td>
              </tr>

              
              <tr>
                <td>Tanggal Lahir</td>
                <td><input class="form-control" type="date" name="tgl_lahir_siswa" max="<?= $current_date ?>" required></td>
              </tr>

             
              <tr>
                <td>Jenis Kelamin</td>
                <td>
                  <select class="form-control" name="jekel_siswa" required>
                    <option value="" disabled selected>--Pilih Jenis Kelamin--</option>
                    <option value="l">Laki-Laki</option>
                    <option value="p">Perempuan</option>
                  </select>
                </td>
              </tr>

              <tr>
                <td>Email
                <td><input class="form-control" type="text" name="email" placeholder="Sesuaikan dengan Penulisan Email (person@gmail.com)"></td>
              </tr>
              <tr>
                <td>No Telepon
                <td><input class="form-control" type="text" name="no_telepon_siswa" placeholder="Tidak Boleh Mengandung Huruf dan Min 10 Max 13"></td>
              </tr>

              <tr>
                <td>Tahun Masuk</td>
                <td>
                  <select class="form-control" name="tahun_masuk_siswa" required>
                    <option value="" disabled selected>--Pilih Tahun Masuk--</option>
                    <?php
                     $tahunSekarang = date("Y");
                        for ($i = $tahunSekarang - 4; $i < $tahunSekarang + 1; $i++) {
                            echo "<option value=\"$i\">$i</option>";
                                                                    }
                                                                ?>
                  </select>
                </td>
              </tr>

              <tr>
                <td>Pilih Kelas</td>
                <td>
                  <select class="form-control" name="kd_kelas" required>
                    <option value="" disabled selected>--Pilih Kelas--</option>
                    <?php
            $queryKelas = mysqli_query($koneksi, "SELECT kd_kelas, nama_kelas FROM kelas ORDER BY nama_kelas ASC");
            while ($kelas = mysqli_fetch_assoc($queryKelas)) {
                echo "<option value=\"{$kelas['kd_kelas']}\">{$kelas['nama_kelas']}</option>";
            }
        ?>
                  </select>
                </td>
              </tr>
              <tr>
  <td>Foto Profil</td>
  <tr>
            <td>Foto Profil</td>
            <td><input class="form-control" type="file" name="foto_profil" accept=".jpg, .jpeg, .png" required></td>
        </tr>

              <tr>
                <td>Alamat</td>
                <td colspan="3"><textarea class="form-control" name="alamat" required placeholder="Contoh : Jln Brawijaya N0.10 Kab Probolinggo"></textarea></td>
              </tr>

              <!-- Password otomatis (input hidden) -->
              <tr>
                <td><input type="hidden" name="password" value="saturasi123"></td>
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
