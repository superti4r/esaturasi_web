<?php
require_once '../layout/_top.php';

$current_date = date('Y-m-d');
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Tambah Pengumuman</h1>
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
                <td>Judul</td>
                <td><input type="text" class="form-control" name="judul" id="judul"></td>
              </tr>
              <tr>
                <td>Tanggal Pengumuman</td>
                <td><input type="text" class="form-control" name="tgl_pengumuman_display" value="<?php echo date('d-F-Y'); ?>" readonly>
                <input type="hidden" name="tgl_pengumuman" value="<?php echo date('Y-m-d'); ?>" required>
                <td>
              </tr>

              <tr>
                <td>File (Berupa Gambar)</td>
                <td> 
                <input type="file" class="form-control" name="file" id="file" required></td>
              </tr>

              <tr>
                <td>Deskripsi Pengumuman</td>
                <td><textarea class="form-control" name="deskripsi" ></textarea></td>
              </tr>


              <tr>
                <td colspan="3">
                  <button type="submit" name="kirim" class="btn btn-success">Simpan</button>
                  <input class="btn btn-warning" type="reset" name="reset" value="Bersihkan">
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
