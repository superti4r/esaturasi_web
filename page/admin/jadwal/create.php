<?php
require_once '../layout/_top.php';
require_once '../helper/config.php';

$kd_kelas = $_GET['kd_kelas'];

// Cek apakah query berhasil dan menghasilkan hasil
if (isset($_GET['kd_kelas'])) {
  $kd_kelas = $_GET['kd_kelas'];

  // Query untuk mengambil nama kelas berdasarkan kd_kelas
  $kelas_query = mysqli_query($koneksi, "SELECT nama_kelas FROM kelas WHERE kd_kelas = '$kd_kelas'");
  if (mysqli_num_rows($kelas_query) > 0) {
      $kelas = mysqli_fetch_assoc($kelas_query);
      $nama_kelas = $kelas['nama_kelas'];  // Ambil nama kelas, misalnya 'X RPL 1'
  } else {
      echo "Kelas tidak ditemukan!";
      exit;
  }
} else {
  echo "ID kelas tidak ditemukan!";
  exit;
}


// Ambil tahun saat ini
$tahun = date('y'); // Mengambil dua digit terakhir dari tahun, misalnya "24" untuk tahun 2024

// Ambil kode jadwal yang terakhir dari database
$sql = mysqli_query($koneksi, "SELECT * FROM jadwal ORDER BY kd_jadwal DESC");
$row = mysqli_num_rows($sql);



// Jika ada data
if ($row > 0) {
    $data = mysqli_fetch_array($sql);
    $kd = $data['kd_jadwal'];
    
    // Ambil nomor urut dari kode jadwal (misal, KJ24001)
    $kd = (int)substr($kd, 4, 3); // Mengambil angka setelah "KJ" dan tahun
    $kd = $kd + 1; // Menambah angka urut

    // Gabungkan tahun dan nomor urut menjadi kode jadwal
    $kd = "KJ" . $tahun . sprintf("%03s", $kd); // Menambahkan tahun dan nomor urut
} else {
    // Jika belum ada data, mulai dengan kode jadwal pertama
    $kd = "KJ" . $tahun . "001"; // Misal, KJ240001
}

// Ambil data mata pelajaran berdasarkan kelas yang dipilih
$kd_kelas = isset($_GET['kd_kelas']) ? $_GET['kd_kelas'] : '';
$mapelQuery = "SELECT m.kd_mapel, m.nama_mapel FROM mapel m
             JOIN mata_pelajaran_perkelas mpk ON m.kd_mapel = mpk.kd_mapel
             WHERE mpk.kd_kelas = '$kd_kelas'";
$mapelResult = mysqli_query($koneksi, $mapelQuery);
?>


<section class="section">
  <div class="section-header d-flex justify-content-between">
 
    <h1>Tambah Jadwal Kelas <?php echo htmlspecialchars($kelas['nama_kelas']); ?></h1>
    <a href="./index.php" class="btn btn-light"><i class="fas fa-arrow-left"></i> </a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- Form -->
          <form action="store.php" method="POST" enctype="multipart/form-data">
            <table cellpadding="8" class="w-100">
         
                <td><input type="hidden" class="form-control" name="kd_jadwal" value="<?php echo $kd; ?>" required></td>
            
                <td><input type="hidden" class="form-control" name="kd_kelas" value="<?php echo $kd_kelas; ?>" required></td>
              
                <tr>
  <td>Pilih Mapel</td>
  <td>
    <select name="kd_mapel" id="mapel" class="form-control" required>
      <option value="" disabled selected>-- Pilih Mata Pelajaran --</option>
      <?php if ($mapelResult && mysqli_num_rows($mapelResult) > 0): ?>
        <?php while ($mapel = mysqli_fetch_assoc($mapelResult)): ?>
          <option value="<?= $mapel['kd_mapel']; ?>"><?= $mapel['nama_mapel']; ?></option>
        <?php endwhile; ?>
      <?php else: ?>
        <option value="" disabled>Tidak ada mata pelajaran</option>
      <?php endif; ?>
    </select>
  </td>
</tr>
<tr>
  <td>Guru</td>
  <td>
    <input type="text" class="form-control" id="guru" name="nik" readonly placeholder="-- Nama Guru Akan Ditampilkan --">
  </td>
</tr>

                <td>Pilih Hari</td>
                <td>
                  <select class="form-control" name="hari" required>
                    <option value="" disabled selected>-- Pilih Hari --</option>
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>
                    <option value="Sabtu">Sabtu</option>
                  </select>
                </td>
              <tr>
                <td>Waktu Mulai</td>
                <td><input type="time" class="form-control" name="waktu_mulai" required></td>
              </tr>

           
              <tr>
                <td>Waktu Selesai</td>
                <td><input type="time" class="form-control" name="waktu_selesai" required></td>
              </tr>
              <tr>
                <td><input type="hidden" name="kd_kelas" value="<?php echo $kd_kelas; ?>"></td>
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

    document.getElementById('mapel').addEventListener('change', function () {
    const kdMapel = this.value;
    const kdKelas = "<?php echo $kd_kelas; ?>"; // Ambil kd_kelas dari PHP

    // Kirim request ke server untuk mendapatkan nama guru
    fetch(`get_guru_by_mapel.php?kd_mapel=${kdMapel}&kd_kelas=${kdKelas}`)
        .then(response => response.json())
        .then(data => {
            const guruInput = document.getElementById('guru');
            
            // Jika data ditemukan, tampilkan nama guru
            if (data && data.nama_guru) {
                guruInput.value = data.nama_guru;
            } else {
                guruInput.value = "-- Tidak Ada Guru --";
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('guru').value = "-- Error Memuat Guru --";
        });
});



</script>


<?php
require_once '../layout/_bottom.php';
?>
