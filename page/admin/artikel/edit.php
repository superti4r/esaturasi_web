<?php

require_once '../layout/_top.php';
require_once '../helper/config.php';

$nama = $_SESSION['nama_guru'];
$email = $_SESSION['email_guru'];
$foto = $_SESSION['foto_profil_guru'];

$id_pengumuman = $_GET['kd_pengumuman'];
$sql = mysqli_query($koneksi, "SELECT pengumuman.*, guru.nama_guru 
                               FROM pengumuman 
                               JOIN guru ON pengumuman.nik = guru.nik 
                               WHERE pengumuman.kd_pengumuman='$id_pengumuman'");
$data = mysqli_fetch_array($sql);

$tanggal_display = date('d-F-Y', strtotime($data['tgl_pengumuman']));
$tanggal_hidden = date('Y-m-d', strtotime($data['tgl_pengumuman']));

?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Edit Pengumuman</h1>
    <a href="./index.php" class="btn btn-light"><i class="fas fa-arrow-left"></i> </a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- Edit Form -->
          <form id="form-edit-guru" action="update.php" method="POST" enctype="multipart/form-data">
    <table cellpadding="8" class="w-100">
      <!-- foto lama -->
      <input type="hidden" name="file_lama" value="<?php echo htmlspecialchars($data['file_pengumuman']); ?>">
      <!-- Input tersembunyi untuk menyimpan NIP (nik) -->
      <input type="hidden" name="nik" value="<?php echo $data['nik']; ?>">
        <input type="hidden" name="kd_pengumuman" value="<?php echo $id_pengumuman; ?>">

        <tr>
            <td>Nama Pembuat</td>
            <td> <input type="text" class="form-control" name="nama_guru" id="kode" value="<?php echo $data['nama_guru']; ?>" readonly></td>
        </tr>
        <tr>
            <td>Judul Pengumuman</td>
            <td><input type="text" class="form-control" name="judul" id="kode" value="<?php echo $data['judul_pengumuman']; ?>"></td>
            </div>
        </tr>
        <tr>
            <td>Tanggal Pengumuman</td>
            <td><input type="text" class="form-control" name="tgl_pengumuman_display" value="<?php echo $tanggal_display; ?>" readonly>
            <input type="hidden" name="tgl_pengumuman" value="<?php echo $tanggal_hidden; ?>" required></td>
            </div>
        </tr>
       
        <tr>
            <td>File Pengumuman</td>
            <td>
            <?php 
                $file_path = "../uploads/pengumuman/" . $data['file_pengumuman'];
                // Cek apakah file tersedia dan file benar-benar ada
                if (!empty($data['file_pengumuman']) && file_exists($file_path)): 
            ?>
                <img src="<?php echo $file_path; ?>" alt="Foto Pengumuman" width="25%" height="25%" style="display:block; margin-bottom:10px;">
            <?php else: ?>
                <p>Gambar tidak tersedia.</p>
            <?php endif; ?>
            
            <!-- Input untuk upload file -->
            <input type="file" class="form-control" name="file">
        </div>
            </td>
        </tr>
        <tr>
            <td>Deskripsi Pengumuman</td>
            <td><textarea class="form-control" name="deskripsi"><?php echo $data['deskripsi_pengumuman']; ?></textarea></td>
            </div>
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
