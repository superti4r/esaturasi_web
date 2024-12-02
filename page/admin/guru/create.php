<?php
require_once '../layout/_top.php';
// Mendapatkan tanggal hari ini
$current_date = date('Y-m-d');
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Tambah Guru</h1>
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
                <td>NIK</td>
                <td><input class="form-control" type="text" name="nik" required placeholder="16 Digit"></td>
              </tr>

              <tr>
                <td>Nama Guru</td>
                <td><input class="form-control" type="text" name="nama" required placeholder="Nama Tidak Boleh Mengandung Angka dan Simbol"></td>
              </tr>

              <tr>
                <td>NIP</td>
                <td><input class="form-control" type="text" name="nip" placeholder="18 Digit"></td>
              </tr>

             
              <tr>
                <td>Jenis Kelamin</td>
                <td>
                  <select class="form-control" name="jenkel" required>
                    <option value="" disabled selected>--Pilih Jenis Kelamin--</option>
                    <option value="l">Laki-Laki</option>
                    <option value="p">Perempuan</option>
                  </select>
                </td>
              </tr>

              <tr>
                <td>Tanggal Lahir</td>
                <td><input class="form-control" type="date" name="tanggal_lahir" max="<?= $current_date ?>" required></td>
              </tr>

              <tr>
                <td>Foto</td>
                <td><input class="form-control" type="file" name="foto" accept="image/*" ></td>
              </tr>

              <tr>
                <td>Alamat</td>
                <td colspan="3"><textarea class="form-control" name="alamat" required placeholder="Contoh : Jln Brawijaya N0.10 Kab Probolinggo"></textarea></td>
              </tr>

              <tr>
                <td>No Telepon</td>
                <td><input class="form-control" type="text" name="phone" required placeholder="Tidak Boleh Huruf dan Simbol"></td>
              </tr>

              <tr>
                <td>Email</td>
                <td><input class="form-control" type="email" name="email" required placeholder="Sesuaikan dengan Penulisan Email (person@gmail.com)"></td>
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
