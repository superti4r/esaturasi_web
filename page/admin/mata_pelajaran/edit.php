<?php
require_once '../layout/_top.php';
require_once '../helper/config.php';

$id_mapel = $_GET['kd_mapel'];
$sql = mysqli_query($koneksi, "SELECT * FROM mapel WHERE kd_mapel='$id_mapel'");
$data = mysqli_fetch_array($sql);

?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Edit Mata Pelajaran</h1>
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
                <td>Kode Mapel</td>
                <td><input class="form-control" type="text" name="kd_mapel" value="<?php echo $data['kd_mapel']; ?>" readonly></td>
              </tr>

              <tr>
                <td>Nama Mapel</td>
                <td><input class="form-control" type="text" name="nama_mapel" value="<?php echo $data['nama_mapel']; ?>" required></td>
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
