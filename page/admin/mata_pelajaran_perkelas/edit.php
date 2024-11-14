<?php

require_once '../layout/_top.php';
require_once '../helper/config.php';

$kode_mpp = $_GET['kode_mpp'];

// Validasi apakah kode_mpp ada
if (!$kode_mpp) {
    die("Kode Mata Pelajaran tidak ditemukan.");
}

$sql = mysqli_query($koneksi, "
    SELECT * 
    FROM vmpp
    WHERE kode_mpp='$kode_mpp'");
$data = mysqli_fetch_array($sql);

// Validasi apakah data ditemukan
if (!$data) {
    die("Data tidak ditemukan untuk kode mapel: $kode_mpp");
}

?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Edit Mapel <?php echo $data['nama_mapel'] . ' ' . $data['nama_kelas']; ?></h1>
    <a href="./index.php" class="btn btn-light"><i class="fas fa-arrow-left"></i> </a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- Form -->
          <form action="update.php" method="POST" enctype="multipart/form-data">
            <table cellpadding="8" class="w-100">
              <tr>
                <td>Kode Mapel</td>
                <td><input class="form-control" type="text" name="kode_mpp" value="<?php echo $data['kode_mpp']; ?>" readonly></td>
              </tr>
              <tr>
                <td>Nama Mapel</td>
                <td><input class="form-control" type="text" name="nama_mapel" value="<?php echo $data['nama_mapel']; ?>" readonly></td>
              </tr>
              <tr>
                <input type="hidden" name="kd_kelas" value="<?php echo $data['kd_kelas']; ?>">
              </tr>
              <tr> 
                <td>Foto Mapel</td> 
                <td>
                  <?php if (!empty($data['foto_mapel_perkelas'])): ?>
                    <img src="../uploads/foto_mapel/<?php echo $data['foto_mapel_perkelas']; ?>" alt="Foto Mapel" style="max-width: 100px; margin-bottom: 10px;">
                  <?php endif; ?>
                  <input class="form-control" type="file" name="foto_mapel" accept="image/*">
                  <input type="hidden" name="foto_mapel_lama" value="<?php echo $data['foto_mapel_perkelas']; ?>">
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
        const fotoInput = document.querySelector('input[name="foto_mapel"]');
        if (fotoInput) {
            fotoInput.value = ''; // Mengosongkan input file jika ada
        }

        // Jika ingin mereset seluruh form
        document.querySelector('form').reset();
    });
</script>

<?php
require_once '../layout/_bottom.php';
?>
