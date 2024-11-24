<?php
require_once '../layout/_top.php';
require_once '../helper/config.php';

$kode_mpp = isset($_GET['kode_mpp']) ? $_GET['kode_mpp'] : '';
$kd_mapel = isset($_GET['kd_mapel']) ? $_GET['kd_mapel'] : '';
$kd_bab = isset($_GET['kd_bab']) ? $_GET['kd_bab_kelas'] : '';
$kd_bab_kelas = isset($_GET['kd_bab_kelas']) ? $_GET['kd_bab_kelas'] : '';
// Proses penyimpanan data
if (isset($_POST['submit'])) {
    $judul_tugas = $_POST['judul_tugas'];
    $deskripsi = $_POST['deskripsi'];
    $file_tugas = $_FILES['file_tugas']['name'];
    $tgl_tugas = $_POST['tgl_tugas'];
    $kd_bab_kelas = $_POST['kd_bab_kelas'];
    $tegat_waktu = $_POST['tegat_waktu'];
    $kd_tugas = "";

    // Direktori untuk menyimpan file upload
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/tugas/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Validasi file yang diunggah
    $allowed_types = ['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
    $file_type = mime_content_type($_FILES['file_tugas']['tmp_name']);
    $file_tugas = basename($_FILES['file_tugas']['name']);
    $filePath = $uploadDir . $file_tugas;

    if (in_array($file_type, $allowed_types)) {
        if (move_uploaded_file($_FILES['file_tugas']['tmp_name'], $filePath)) {
            $sql = "INSERT INTO tugas (kd_tugas, kd_bab_kelas, judul_tugas, file_tugas, deskripsi, tgl_tugas, tenggat_waktu) 
        VALUES ('$kd_tugas', '$kd_bab_kelas', '$judul_tugas', '$file_tugas', '$deskripsi', '$tgl_tugas', '$tegat_waktu')";
            if (mysqli_query($koneksi, $sql)) {
                header("Location:tugas.php?kode_mpp=$kode_mpp&kd_mapel=$kd_mapel&kd_bab_kelas=$kd_bab_kelas&aksi=suksestambah");
            } else {
                echo "Gagal menambahkan data: " . mysqli_error($koneksi);
            }
        } else {
            echo "Gagal mengunggah file.";
        }
    } else {
        echo "<script>alert('Hanya file PDF, DOCX, dan Excel yang diizinkan!'); window.location.href='tugas.php';</script>";
    }
}

if (isset($_GET['aksi'])) {
    $aksi = $_GET['aksi'];
    if ($aksi == "suksestambah") {
      echo "<script>alert('Selamat, data berhasil ditambahkan');</script>";
    }
  }
?>

<section class="section">
    <div class="section-header d-flex justify-content-between align-items-center">
        <h1>Tambah Tugas</h1>
        <a href="tugas.php?kode_mpp=<?php echo urlencode($kode_mpp); ?>&kd_mapel=<?php echo urlencode($kd_mapel); ?>&kd_bab_kelas=<?php echo urlencode($kd_bab_kelas); ?>" class="btn btn-light">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="judul_tugas">Judul Tugas</label>
                            <input type="text" name="judul_tugas" id="judul_tugas" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="file_tugas">File Tugas</label>
                            <input type="file" name="file_tugas" id="file_tugas" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="tgl_tugas">Tanggal Mulai</label>
                            <input type="datetime-local" name="tgl_tugas" id="tgl_tugas" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="tegat_waktu">Tanggal Selesai</label>
                            <input type="datetime-local" name="tegat_waktu" id="tegat_waktu" class="form-control" required>
                        </div>

                        <input type="hidden" name="kd_bab_kelas" value="<?php echo htmlspecialchars($kd_bab_kelas); ?>">


                        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                        <a href="index.php?kode_mpp=<?php echo urlencode($kode_mpp); ?>&kd_mapel=<?php echo urlencode($kd_mapel); ?>&kd_bab_kelas=<?php echo urlencode($kd_bab_kelas); ?>" class="btn btn-light">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
require_once '../layout/_bottom.php';
?>
