<?php
require_once '../layout/_top.php';
require_once '../helper/config.php';

// Ambil tahun sekarang dan ambil dua digit terakhir
$tahun_sekarang = date('Y'); 
$tahun_terakhir = substr($tahun_sekarang, 2, 2); // Mengambil dua digit terakhir, contoh "24" untuk tahun 2024

// Query untuk mendapatkan kode kelas terakhir
$sql = mysqli_query($koneksi, "SELECT * FROM kelas ORDER BY kd_kelas DESC LIMIT 1");

// Cek apakah query berhasil dan mengembalikan data
if (mysqli_num_rows($sql) > 0) {
    $data = mysqli_fetch_array($sql);

    // Mendapatkan nomor urut dari kode kelas terakhir
    $kd = $data['kd_kelas']; 

    // Mengambil urutan (misalnya 001, 002, dst) dari kode kelas terakhir
    $urutan = (int)substr($kd, 4, 2); // Menyesuaikan posisi urutan jika formatnya K + Tahun + Urutan

    // Menambah urutan 1
    $urutan = $urutan + 1;

    // Membuat kode kelas baru dengan format K + 2-digit TAHUN + URUTAN (3 digit)
    $kd_kelas_baru = "K" . $tahun_terakhir . str_pad($urutan, 2, '0', STR_PAD_LEFT); // Menambahkan padding 0
} else {
    // Jika tidak ada kelas, set kode kelas baru ke K + tahun + 001
    $kd_kelas_baru = "K" . $tahun_terakhir . "01";
}
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
                <td><input class="form-control" type="text" name="kd_kelas" required value="<?php echo $kd_kelas_baru ?>" readonly></td>
              </tr>

              <tr>
                <td>Nama Kelas</td>
                <td><input class="form-control" type="text" name="nama_kelas" required ></td>
              </tr>
              <tr>
                <td>Tingkatan Kelas</td>
                <td>
                    <select class="form-control" name="tingkatan_kelas" required>
                        <option value="" disabled selected>--Pilih Tingkatan Kelas--</option>
                        <option value="1">X</option>
                        <option value="2">XI</option>
                        <option value="3">XII</option>
                    </select>
                </td>
              </tr>

              <tr>
                <td>No Kelas</td>
                <td><input class="form-control" type="text" name="no_kelas" required ></td>
              </tr>
              <tr> 
              <tr>
                
                <td>Jurusan</td>
                <td>
                  <select class="form-control" name="kd_jurusan" required>
                    <option value="" disabled selected>--Pilih Jurusan--</option>
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
