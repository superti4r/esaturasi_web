<?php
require_once '../layout/_top.php';
require_once '../helper/config.php';

$sql = mysqli_query($koneksi, "SELECT * FROM kelas ORDER BY kd_kelas DESC");
$row = mysqli_num_rows($sql);
$data = mysqli_fetch_array($sql);
$kd=$data['kd_kelas'];
$kd=(int)substr($kd, 2,2);
$kd=$kd+1;
$kd="KL".sprintf("%02s", $kd);

?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Tambah Kelas</h1>
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
                <td>Kode Kelas</td>
                <td><input class="form-control" type="text" name="kd_kelas" required value="<?php echo $kd ?>"  readonly></td>
              </tr>

              <tr>
                <td>Nama Kelas</td>
                <td><input class="form-control" type="text" name="nama_kelas" required ></td>
              </tr>

           
              <tr>
                <td>Jurusan</td>
                <td>
                  <select class="form-control" name="kd_jurusan" required>
                    <option value="" disable>--Pilih Kelas--</option>
                    <?php
                        // Ambil data jurusan dari database
                        $queryJurusan = mysqli_query($koneksi, "SELECT * FROM jurusan ORDER BY nama_jurusan ASC");
                        while ($jurusan = mysqli_fetch_assoc($queryJurusan)) {
                            echo "<option value=\"{$jurusan['kd_jurusan']}\">{$jurusan['nama_jurusan']}</option>";
                        }
                        ?>
                   
                  </select>
                </td>
              </tr>

       

              <tr>
                <td colspan="3">
                  <button type="submit" name="proses" class="btn btn-success">Simpan</button>
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
