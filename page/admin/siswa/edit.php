<?php

require_once '../layout/_top.php';
require_once '../helper/config.php';

// Mendapatkan tanggal saat ini untuk batas maksimum tanggal lahir
$current_date = date("Y-m-d");

$nisn = $_GET['nisn'];
$sql = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nisn='$nisn'");
$data = mysqli_fetch_array($sql);


//mengambil data di database tanggal lahir guru
$tanggal_lahir = isset($data['tanggal_lahir_siswa']) ? date('Y-m-d', strtotime($data['tanggal_lahir_siswa'])) : '';


?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Edit Siswa</h1>
    <a href="./index.php" class="btn btn-light"><i class="fas fa-arrow-left"></i> </a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- Edit Form -->
          <form id="form-edit-siswa" action="update.php" method="POST" enctype="multipart/form-data">
    <table cellpadding="8" class="w-100">
        <tr>
            <td>NISN</td>
            <td><input class="form-control" type="text" name="nisn" value="<?php echo $data['nisn']; ?>" readonly></td>
        </tr>
        <tr>
            <td>Nama Lengkap</td>
            <td><input class="form-control" type="text" name="nama_siswa" value="<?php echo $data['nama_siswa']; ?>" required placeholder="Nama Tidak Boleh Mengandung Angka dan Simbol"></td>
        </tr>
        <tr>
        <tr>
                <td>Tempat Lahir</td>
                <td><input class="form-control" type="text" name="tempat_lahir"  value="<?php echo $data['tempat_lahir_siswa']; ?>" required></td>
              </tr>
              <tr>
              <td>Tanggal Lahir</td>
            <td><input class="form-control" type="date" name="tgl_lahir_siswa" value="<?php echo $data['tgl_lahir_siswa']; ?>" max="<?= $current_date ?>" required></td>
        </tr>

        <tr>
            <td>Jenis Kelamin</td>
            <td>
                <select class="form-control" name="jekel_siswa" required>
                    <option value="" disable >--Pilih Jenis Kelamin--</option>
                    <option value="l" <?php echo $data['jekel_siswa'] == 'l' ? 'selected' : ''; ?>>Laki-Laki</option>
                    <option value="p" <?php echo $data['jekel_siswa'] == 'p' ? 'selected' : ''; ?>>Perempuan</option>
                </select>
            </td>
        </tr>
        <tr>

        <tr>
                <td>Email
                <td><input class="form-control" type="text" name="email" value="<?php echo $data['email']; ?>"></td>
              </tr>
              <tr>
                <td>No Telepon
                <td><input class="form-control" type="text" name="no_telepon_siswa" value="<?php echo $data['no_telepon_siswa']; ?>" required></td>
              </tr>

              <tr>
                <td>Tahun Masuk</td>
                <td>
                  <select class="form-control" name="tahun_masuk_siswa" required>
                    <option value="" disabled selected>--Pilih Tahun Masuk--</option>
                    <?php
                      $tahunSekarang = date("Y");
                          $tahun_masuk_siswa = $data['tahun_masuk_siswa']; // Data tahun masuk dari database
                            for ($i = $tahunSekarang - 4; $i < $tahunSekarang + 1; $i++) {
                               $selected = ($i == $tahun_masuk_siswa) ? 'selected' : ''; // Menandai tahun yang sesuai dengan data
                                                                    echo "<option value=\"$i\" $selected>$i</option>";
                                                                }
                                                            ?>
                                                            </td>
                                                              </tr>
                                                              <tr>
                <td>Kelas</td>
                <td>
                  <select class="form-control" name="kd_kelas" required>
                    <option value="" disabled selected>--Pilih Kelas--</option>
                    <option value="" disabled>Pilih Kelas</option>
                                                                    <?php
                                                                        $kd_kelas_siswa = $data['kd_kelas']; // Ambil data kd_kelas dari database untuk ditampilkan
                                                                        $queryKelas = mysqli_query($koneksi, "SELECT kd_kelas, nama_kelas FROM kelas ORDER BY nama_kelas ASC");

                                                                        while ($kelas = mysqli_fetch_assoc($queryKelas)) {
                                                                            $selected = ($kelas['kd_kelas'] == $kd_kelas_siswa) ? 'selected' : ''; // Tandai jika sesuai
                                                                            echo "<option value=\"{$kelas['kd_kelas']}\" $selected>{$kelas['nama_kelas']}</option>";
                                                                        }
                                                                    ?>
                                                            </td>
                                                                      </tr>

                                                                      <tr>
                <td>Status</td>
                <td>
                <select class="form-control" name="status_siswa" required>
                                                                    <option value="Aktif" <?php echo (isset($status_siswa) && $status_siswa == 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
                                                                    <option value="Tidak Aktif" <?php echo (isset($status_siswa) && $status_siswa == 'Tidak Aktif') ? 'selected' : ''; ?>>Tidak Aktif</option>
                                                                </select>
                                                            </td>
                                                                      </tr>
     
        <tr>
            <td>Alamat</td>
            <td colspan="3"><textarea class="form-control" name="alamat" required placeholder="Contoh : Jln Brawijaya N0.10 Kab Probolinggo"><?php echo $data['alamat']; ?></textarea></td>
        </tr>
        
          
        </tr>
        <tr>
            <td colspan="3">
                <button type="submit" name="kirim" class="btn btn-success">Simpan Perubahan</button>
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
