<?php

require_once '../layout/_top.php';
require_once '../helper/config.php';

// Mendapatkan tanggal saat ini untuk batas maksimum tanggal lahir
$current_date = date("Y-m-d");

$nik = $_GET['nik'];
$sql = mysqli_query($koneksi, "SELECT * FROM guru WHERE nik='$nik'");
$data = mysqli_fetch_array($sql);


//mengambil data di database tanggal lahir guru
$tanggal_lahir = isset($data['tanggal_lahir_guru']) ? date('Y-m-d', strtotime($data['tanggal_lahir_guru'])) : '';

$nama = $_SESSION['nama_guru'];
$email = $_SESSION['email_guru'];
$foto = $_SESSION['foto_profil_guru'];
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Edit Guru</h1>
    <a href="./index.php" class="btn btn-light"><i class="fas fa-arrow-left"></i> </a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- Edit Form -->
          <form id="form-edit-guru" action="update.php" method="POST" enctype="multipart/form-data">
    <table cellpadding="8" class="w-100">
        <tr>
            <td>NIK</td>
            <td><input class="form-control" type="text" name="nik" value="<?php echo $data['nik']; ?>" readonly></td>
        </tr>
        <tr>
            <td>Nama Guru</td>
            <td><input class="form-control" type="text" name="nama_guru" value="<?php echo $data['nama_guru']; ?>" required placeholder="Nama Tidak Boleh Mengandung Angka dan Simbol"></td>
        </tr>
        <tr>
            <td>NIP</td>
            <td><input class="form-control" type="text" name="nip" value="<?php echo $data['nip']; ?>" placeholder="18 Digit"></td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>
                <select class="form-control" name="jekel" required>
                    <option value="" disabled selected>--Pilih Jenis Kelamin--</option>
                    <option value="l" <?php echo $data['jekel_guru'] == 'l' ? 'selected' : ''; ?>>Laki-Laki</option>
                    <option value="p" <?php echo $data['jekel_guru'] == 'p' ? 'selected' : ''; ?>>Perempuan</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Tanggal Lahir</td>
            <td><input class="form-control" type="date" name="tanggal_lahir" value="<?php echo $data['tanggal_lahir_guru']; ?>" max="<?= $current_date ?>" required></td>
        </tr>
        <tr>
            <td>Foto</td>
            <td>
                <img src="../uploads/profile/<?php echo $data['foto_profil_guru']; ?>" alt="Foto Profil" width="100" height="100">
                <input class="form-control" type="file" name="foto_profil" accept="image/*">
                <input type="hidden" name="foto_profil_lama" value="<?php echo htmlspecialchars($data['foto_profil_guru']); ?>">

            </td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td colspan="3"><textarea class="form-control" name="alamat" required placeholder="Contoh : Jln Brawijaya N0.10 Kab Probolinggo"><?php echo $data['alamat']; ?></textarea></td>
        </tr>
        <tr>
            <td>No Telepon</td>
            <td><input class="form-control" type="text" name="no_telepon_guru" value="<?php echo $data['no_telepon_guru']; ?>" required placeholder="Tidak Boleh Huruf dan Simbol"></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input class="form-control" type="email" name="email_guru" value="<?php echo $data['email_guru']; ?>" required placeholder="Sesuai Format Email"></td>
        </tr>
        
        <tr>
            <td><input type="hidden" name="password" value="saturasi123"></td>
        </tr>
        <tr>
            <td colspan="3">
                <button type="submit" name="kirim" class="btn btn-success">Simpan Perubahan</button>
                <input class="btn btn-danger" type="reset" name="batal" value="Bersihkan">
               <!-- Tombol Reset Password -->
<a href="reset_password.php?nik=<?php echo $data['nik']; ?>" class="btn btn-warning">Reset Password</a>

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
