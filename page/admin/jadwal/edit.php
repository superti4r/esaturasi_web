<?php
require_once '../layout/_top.php';
require_once '../helper/config.php';

$kd_jadwal = $_GET['kd_jadwal'];
$kode_mpp = $_GET['kode_mpp'];
$sql = mysqli_query($koneksi, "SELECT * FROM vjadwal WHERE kd_jadwal='$kd_jadwal' AND kode_mpp='$kode_mpp'");
$data = mysqli_fetch_array($sql);

?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Edit Jadwal Kelas <?php echo htmlspecialchars($data['nama_kelas']); ?></h1>
    <a href="./index.php" class="btn btn-light"><i class="fas fa-arrow-left"></i> </a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- Form -->
          <form action="update.php" method="POST" enctype="multipart/form-data">
            <table cellpadding="8" class="w-100">

            <td><input type="hidden" class="form-control" name="kd_jadwal" value="<?php echo $kd_jadwal; ?>" required></td>
            <td><input type="hidden" class="form-control" name="kode_mpp" value="<?php echo $kode_mpp; ?>" required></td>
              <tr>
                <td>Nama Mapel</td>
                <td><input class="form-control" type="text" name="kd_mapel" value="<?php echo $data['nama_mapel']; ?>" readonly></td>
              </tr>



              <tr>
                <td>Hari</td>
                <td><input class="form-control" type="text" name="hari" value="<?php echo $data['hari']; ?>" readonly></td>
              </tr>
              <tr>
  <td>Guru</td>
  <td>
    <select class="form-control" name="nik" required>
      <option value="" disabled selected>Pilih Guru</option>
      <?php
        $nik_selected = $data['nik']; // Ambil nik yang dipilih sebelumnya dari data
        
        // Query untuk mengambil data guru
        $queryguru = mysqli_query($koneksi, "SELECT nik, nama_guru FROM guru ORDER BY nama_guru ASC");

        while ($guru = mysqli_fetch_assoc($queryguru)) {
          // Tandai jika nik guru yang ditampilkan sama dengan nik yang dipilih
          $selected = ($guru['nik'] == $nik_selected) ? 'selected' : ''; 
          echo "<option value=\"{$guru['nik']}\" $selected>{$guru['nama_guru']}</option>";
        }
      ?>
    </select>
  </td>
</tr>

<tr>
  <td>Waktu Mulai</td>
  <td>
    <input type="time" class="form-control" name="waktu_mulai" value="<?php echo isset($data['dari_jam']) ? $data['dari_jam'] : ''; ?>" required>
  </td>
</tr>

<tr>
  <td>Waktu Selesai</td>
  <td>
    <input type="time" class="form-control" name="waktu_selesai" value="<?php echo isset($data['sampai_jam']) ? $data['sampai_jam'] : ''; ?>" required>
  </td>
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
