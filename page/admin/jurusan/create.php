<?php
require_once '../layout/_top.php';
require_once '../helper/config.php';

$sql = mysqli_query($koneksi, "SELECT * FROM jurusan ORDER BY kd_jurusan DESC");
$row = mysqli_num_rows($sql);
$data = mysqli_fetch_array($sql);
$kd = $data['kd_jurusan'];
$kd = (int)substr($kd, 2, 3);
$kd = $kd + 1;
$kd = "JR" . sprintf("%03s", $kd);
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Tambah Jurusan</h1>
    <a href="./index.php" class="btn btn-light"><i class="fas fa-arrow-left"></i> </a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- Form -->
          <form action="store.php" method="POST" enctype="multipart/form-data">
            <table cellpadding="8" class="w-100">

              <tr>
                <td>Kode Jurusan</td>
                <td><input class="form-control" type="text" name="kd_jurusan" value="<?php  echo $kd ?>" readonly></td>
              </tr>

              <tr>
                <td>Nama Jurusan</td>
                <td><input class="form-control" type="text" name="nama_jurusan" required></td>
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
