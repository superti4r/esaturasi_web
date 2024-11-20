<?php
require_once '../layout/_top.php';
require_once '../helper/config.php';

// Ambil ID bab dari URL
$kd_bab = $_GET['kd_bab'];
$sql = mysqli_query($koneksi, "SELECT * FROM bab WHERE kd_bab='$kd_bab'");
$data = mysqli_fetch_array($sql);

?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Edit Bab</h1>
    <a href="./index.php" class="btn btn-light"><i class="fas fa-arrow-left"></i> Kembali</a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- Form untuk edit bab -->
          <form action="update.php" method="POST" enctype="multipart/form-data">
            <table cellpadding="8" class="w-100">

              <tr>
                <td>Kode Bab</td>
                <td><input class="form-control" type="text" name="kd_bab" value="<?php echo $data['kd_bab']; ?>" readonly></td>
              </tr>

              <tr>
                <td>Nama Bab</td>
                <td><input class="form-control" type="text" name="nama_bab" value="<?php echo $data['nama_bab']; ?>" required></td>
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
      
        // Jika ingin mereset seluruh form
        document.getElementById('form-edit-bab').reset();
    });
</script>

<?php
require_once '../layout/_bottom.php';
?> 
