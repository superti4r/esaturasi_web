<?php 
require_once '../layout/_top.php';
require_once '../helper/config.php';

$kode_mpp = isset($_GET['kode_mpp']) ? $_GET['kode_mpp'] : '';
$kd_mapel = isset($_GET['kd_mapel']) ? $_GET['kd_mapel'] : '';
$kd_bab = isset($_GET['kd_bab']) ? $_GET['kd_bab'] : '';
$kd_kelas = isset($_GET['kd_kelas']) ? $_GET['kd_kelas'] : '';

$katakunci = "";
if (isset($_POST['cari'])) {
  $katakunci = $_POST['kata_kunci'];
  
  $sql = mysqli_query($koneksi, "SELECT * FROM vmateri WHERE kode_mpp='$kode_mpp' AND kd_bab='$kd_bab' ORDER BY kd_materi ASC");
} else {
  $sql = mysqli_query($koneksi, "SELECT * FROM vmateri WHERE kode_mpp='$kode_mpp' AND kd_bab='$kd_bab' ORDER BY kd_materi ASC");
}

if ($sql) {
  $row = mysqli_num_rows($sql);
} else {
  echo "Error: " . mysqli_error($koneksi); 
}

// Pesan berhasil tambah data
if (isset($_GET['aksi'])) {
  $aksi=$_GET['aksi'];
  if ($aksi=="suksestambah") {
    echo "
    <script>
    alert('Selamat, data Anda berhasil ditambahkan');
    </script>
    ";
  }
} 

if (isset($_GET['aksi'])) {
  $aksi=$_GET['aksi'];
  if ($aksi=="suksesedit") {
    echo "
    <script>
    alert('Selamat, data Anda berhasil diubah');
    </script>
    ";
  } elseif ($aksi=="hapusok") {
    echo "
    <script>
    alert('Selamat, data Anda berhasil dihapus');
    </script>
    ";
  }
}

$sql_bab = mysqli_query($koneksi, "
    SELECT * 
    FROM vbabkelas
    WHERE kd_bab = '$kd_bab' AND kode_mpp ='$kode_mpp'
");
$data_bab = mysqli_fetch_array($sql_bab);
if (mysqli_num_rows($sql_bab) > 0) {
    $bab = mysqli_fetch_assoc($sql_bab);
} else {
    // Jika tidak ada bab, langsung redirect ke halaman createbab.php
    header("Location:createbab.php?kode_mpp=" . urlencode($kode_mpp) . "&kd_bab=" . urlencode($kd_bab) . "&kd_kelas=" . urlencode($kd_kelas) . "&error=Data bab tidak ditemukan");
    exit;  // Pastikan eksekusi berhenti setelah header
}

$loggedInNik = isset($_SESSION['nik']) ? $_SESSION['nik'] : '';
ob_end_flush();
?>

<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>Materi <?php echo htmlspecialchars($data_bab['nama_bab'] ?? ''); ?></h1>
    <div> 
      <a href="create_materi.php?kode_mpp=<?php echo urlencode($kode_mpp); ?>&kd_mapel=<?php echo urlencode($kd_mapel); ?>&kd_bab=<?php echo urlencode($kd_bab); ?>" class="btn btn-primary mr-2">Tambah Materi</a>
      <a href="./index.php" class="btn btn-light"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card pb-4">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover table-striped w-100" id="table-1">
              <thead>
                <tr>
                  <th>NO</th>
                  <th>File</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="tableData">
                <?php
                $nomor = 1; 
                for ($i = 0; $i < $row; $i++) { 
                    $data = mysqli_fetch_array($sql);
                ?>
                <tr>
                  <td><?php echo $nomor++; ?></td>
                  <td>
                    <!-- Link untuk mendownload file -->
                    <a href="../uploads/materi/<?php echo $data['file_materi']; ?>" download>
                      <?php echo $data['file_materi']; ?>
                    </a>
                  </td>
                  <td>
                    <!-- Tombol hapus -->
                    <a href="hapusmateri.php?kd_materi=<?php echo $data['kd_materi']; ?>&pesan=hapus" onClick="return confirm('Apakah data yang Anda pilih akan dihapus?')">
                      <button class="btn btn-danger btn-sm"><i class="fas fa-trash fa-fw"></i></button>
                    </a>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
require_once '../layout/_bottom.php';
?>

<script>
$(document).ready(function () {
  // Event saat tombol cari diklik
  $("#cariBtn").click(function () {
    var kataKunci = $("#kataKunci").val(); // Mengambil nilai dari input pencarian

    // Mengirim permintaan AJAX untuk melakukan pencarian
    $.ajax({
      url: "index.php", // URL untuk file PHP yang akan memproses pencarian
      method: "POST",
      data: { cari: true, kata_kunci: kataKunci },
      success: function (response) {
        // Menampilkan hasil pencarian pada tabel
        $("#tableData").html(response);  // Update table body with the new data
        // Reinitialize DataTable after updating the table
        $("#table-1").DataTable().clear().destroy();
        $("#table-1").DataTable({
          "language": {
            "emptyTable": "Data Tidak Tersedia", 
            "zeroRecords": "Data Tidak Tersedia" 
          }
        });
      },
      error: function () {
        alert("Terjadi kesalahan saat mencari data.");
      },
    });
  });

  // Inisialisasi DataTables pertama kali
  $("#table-1").dataTable({
    "language": {
      "emptyTable": "Data Tidak Tersedia", 
      "zeroRecords": "Data Tidak Tersedia" 
    }
  });
});
</script>
