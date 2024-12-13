<?php
require_once '../layout/_top.php';
require_once '../helper/config.php';

// Menyiapkan kode bab baru
$sql = mysqli_query($koneksi, "SELECT * FROM bab ORDER BY kd_bab DESC");

if (mysqli_num_rows($sql) > 0) {
    $data = mysqli_fetch_array($sql);
    $kode_bab = $data['kd_bab'];
    $kode_bab = (int)substr($kode_bab, 2, 3); // Ambil angka di belakang "BB"
    $kode_bab = $kode_bab + 1;
    $kode_bab = "BB" . sprintf("%03s", $kode_bab); // Format kode bab, misalnya BB001, BB002, dst.
} else {
    // Jika tidak ada data, mulai dari BB001
    $kode_bab = "BB001";
}

?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Tambah Bab</h1>
    <a href="./index.php" class="btn btn-light"><i class="fas fa-arrow-left"></i> Kembali</a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- Form untuk menambah bab -->
          <form action="store.php" method="POST" enctype="multipart/form-data">
            <table cellpadding="8" class="w-100">

              <tr>
                <td>Kode Bab</td>
                <td><input class="form-control" type="text" name="kd_bab" value="<?php echo $kode_bab ?>" readonly></td>
              </tr>

              <tr>
                <td>Nama Bab</td>
                <td><input class="form-control" type="text" name="nama_bab" required></td>
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
        document.getElementById('form-tambah-bab').reset();
    });
</script>

<?php
require_once '../layout/_bottom.php';
?>
