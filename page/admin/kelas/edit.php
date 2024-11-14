<?php
require_once '../layout/_top.php';
require_once '../helper/config.php';

$kd_kelas = $_GET['kd_kelas'];
$sql = mysqli_query($koneksi, "SELECT * FROM kelas WHERE kd_kelas='$kd_kelas'");
$data = mysqli_fetch_array($sql);

?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Edit Kelas</h1>
    <a href="./index.php" class="btn btn-light"><i class="fas fa-arrow-left"></i> </a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- Form -->
          <form action="update.php" method="POST" enctype="multipart/form-data">
            <table cellpadding="8" class="w-100">

              <tr>
                <td>Kode Kelas</td>
                <td><input class="form-control" type="text" name="kd_kelas" value="<?php echo $data['kd_kelas']; ?>" readonly></td>
              </tr>

              <tr>
                <td>Nama Kelas</td>
                <td><input class="form-control" type="text" name="nama_kelas" value="<?php echo $data['nama_kelas']; ?>" required></td>
              </tr>

              <tr>
                <td>Jurusan</td>
                <td>
                  <select class="form-control" name="kd_jurusan" required>
                    <option value="" disabled selected>Pilih Jurusan</option>
                    <?php
                      $kd_jurusan = $data['kd_jurusan']; // Ambil data kd_kelas dari database untuk ditampilkan
                          $queryJurusan = mysqli_query($koneksi, "SELECT kd_jurusan, nama_jurusan FROM jurusan ORDER BY nama_jurusan ASC");
                          while ($jurusan = mysqli_fetch_assoc($queryJurusan)) {
                            $selected = ($jurusan['kd_jurusan'] == $kd_jurusan) ? 'selected' : ''; // Tandai jika sesuai
                              echo "<option value=\"{$jurusan['kd_jurusan']}\" $selected>{$jurusan['nama_jurusan']}</option>";
                                }
                                ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td colspan="3">
                  <button type="submit" name="kirim" class="btn btn-success">Simpan</button>
                  <input class="btn btn-danger" type="reset" name="batal" value="Bersihkan">
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
