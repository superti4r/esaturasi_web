<?php
require_once '../layout/_top.php';
require_once '../helper/config.php';

?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Tambah Admin</h1>
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
                <td>Nama Guru</td>
                <td>
                  <select class="form-control" name="nik" required>
                    <option value="" disabled selected>--Pilih Guru--</option>
                    <?php
                        // Ambil data jurusan dari database
                        $queryJurusan = mysqli_query($koneksi, "SELECT * FROM guru ORDER BY nama_guru ASC");
                        while ($jurusan = mysqli_fetch_assoc($queryJurusan)) {
                            echo "<option value=\"{$jurusan['nik']}\">{$jurusan['nama_guru']}</option>";
                        }
                        ?>
                   
                  </select>
                </td>
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
