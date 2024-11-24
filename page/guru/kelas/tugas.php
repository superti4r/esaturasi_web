<?php 
require_once '../layout/_top.php';
require_once '../helper/config.php';

$kode_mpp = isset($_GET['kode_mpp']) ? $_GET['kode_mpp'] : '';
$kd_mapel = isset($_GET['kd_mapel']) ? $_GET['kd_mapel'] : '';
$kd_bab = isset($_GET['kd_bab']) ? $_GET['kd_bab'] : '';
$kd_kelas = isset($_GET['kd_kelas']) ? $_GET['kd_kelas'] : '';
$kd_bab_kelas = isset($_GET['kd_bab_kelas']) ? $_GET['kd_bab_kelas'] : '';
// Proses pencarian berdasarkan kata kunci
if (isset($_POST['cari'])) {
  $katakunci = $_POST['kata_kunci'];
  $sql = mysqli_query($koneksi, "SELECT * FROM vtugas WHERE kd_bab_kelas = '$kd_bab_kelas' ORDER BY kd_tugas ASC");
} else {
  $sql = mysqli_query($koneksi, "SELECT * FROM vtugas WHERE kd_bab_kelas = '$kd_bab_kelas' ORDER BY kd_tugas ASC");
}
// Memeriksa apakah query berhasil
if (!$sql) {
  echo "Query gagal: " . mysqli_error($koneksi);
  exit;  // Menghentikan eksekusi jika query gagal
}

$row = mysqli_num_rows($sql);
// Pesan berhasil tambah data
if (isset($_GET['aksi'])) {
  $aksi = $_GET['aksi'];
  if ($aksi == "suksestambah") {
    echo "<script>alert('Selamat, data Anda berhasil ditambahkan');</script>";
  } elseif ($aksi == "suksesedit") {
    echo "<script>alert('Selamat, data Anda berhasil diubah');</script>";
  } elseif ($aksi == "hapusok") {
    echo "<script>alert('Selamat, data Anda berhasil dihapus');</script>";
  }
}

$loggedInNik = isset($_SESSION['nik']) ? $_SESSION['nik'] : '';
ob_end_flush();
?>

<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>Tugas</h1>
    <div> 
      <a href="create_tugas.php?kode_mpp=<?php echo urlencode($kode_mpp); ?>&kd_mapel=<?php echo urlencode($kd_mapel); ?>&kd_bab_kelas=<?php echo urlencode($kd_bab_kelas); ?>" class="btn btn-primary mr-2">Tambah Tugas</a>
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
                  <th>Judul Tugas</th>
                  <th>Deskripsi</th>
                  <th>File</th>
                  <th>Tanggal Tugas</th>
                  <th>Tegat Waktu</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="tableData">
                <?php
                $nomor = 1; 
                // Pastikan query menghasilkan data sebelum mencoba menampilkan
                if ($row > 0) {
                  while ($data = mysqli_fetch_array($sql)) {
                ?>
                <tr>
                  <td><?php echo $nomor++; ?></td>
                  <td><?php echo $data['judul_tugas']; ?></td>
                  <td><?php echo $data['deskripsi']; ?></td>

                <td><a href="../uploads/tugas/<?php echo $data['file_tugas']; ?>" download>
                <?php echo $data['file_tugas']; ?></a></td>

                <td><?php echo date('d-m-Y H:i', strtotime($data['tgl_tugas'])); ?></td>
                <td><?php echo date('d-m-Y H:i', strtotime($data['tenggat_waktu'])); ?></td>
                  <td>
                  <a href="edit_tugas.php?kd_tugas=<?php echo $data['kd_tugas']; ?>"><button class="btn btn-success btn-sm"><i class="fas fa-edit fa-fw"></i></button></a>
                    <a href="hapuspretest.php?kd_tugas=<?php echo $data['kd_tugas']; ?>&pesan=hapus" onClick="return confirm('Apakah data yang Anda pilih akan dihapus?')">
                      <button class="btn btn-danger btn-sm"><i class="fas fa-trash fa-fw"></i></button>
                    </a>
                  </td>
                </tr>
                <?php
                  }
                } else {
                  echo "<tr><td colspan='6'>Data Tidak Tersedia</td></tr>";
                }
                ?>
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