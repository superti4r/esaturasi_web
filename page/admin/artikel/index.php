<?php 
require_once '../layout/_top.php';
require_once '../helper/config.php';
// digunakan untuk mencari data dan menampilkan data pengumuman
$katakunci = "";
if (isset($_POST['cari'])) {
  $katakunci = $_POST['kata_kunci'];
  
  $sql = mysqli_query($koneksi, "SELECT * FROM pengumuman WHERE kd_pengumuman LIKE '%".$katakunci."%' OR judul LIKE '%".$katakunci."%' ORDER BY kd_pengumuman ASC");
} else {
  $sql = mysqli_query($koneksi, "SELECT * FROM pengumuman ORDER BY kd_pengumuman ASC");
}
if ($sql) {
  $row = mysqli_num_rows($sql);
} else {
  echo "Error: " . mysqli_error($koneksi); 
}
//pesan berhasil tambah data
if (isset($_GET['aksi'])) {
  $aksi=$_GET['aksi'];
  if ($aksi=="suksestambah") {
    echo "
    <script>
    alert('selamat data anda berhasil ditambahkan');
    </script>
    ";
  }
} 

if (isset($_GET['aksi'])) {
  $aksi=$_GET['aksi'];
  if ($aksi=="suksesedit") {
    echo "
    <script>
    alert('selamat data anda berhasil diubah');
    </script>
    ";
  }elseif ($aksi=="hapusok") {
    echo "
    <script>
    alert('selamat data anda berhasil hapus');
    </script>
    ";
  }

}
if (isset($_GET['pesan'])) {
    $kd_pengumuman = $_GET['kd_pengumuman'];
  
    // Ambil nama file foto dari database
    $query = mysqli_query($koneksi, "SELECT file_pengumuman FROM pengumuman WHERE kd_pengumuman='$kd_pengumuman'");
    $data = mysqli_fetch_assoc($query);
    $foto = $data['file_pengumuman'];
  
    // Hapus file foto jika ada
    $fotoPath = "uploads/pengumuman/$foto";
    if (file_exists($fotoPath)) {
      unlink($fotoPath);
    }
  
    // Hapus data pengumuman dari database
    mysqli_query($koneksi, "DELETE FROM pengumuman WHERE kd_pengumuman='$kd_pengumuman'");
    header("Location:pengumuman.php?aksi=hapusok");
  }
$loggedInNik = isset($_SESSION['nik']) ? $_SESSION['nik'] : '';
ob_end_flush();
?>
<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Data Mata Pelajaran</h1>
    <a href="create.php" class="btn btn-primary">Tambah Data</a>
  </div>
  <div class="row">
    <div class="col-12">
    <div class="card pb-4">
        <div class="card-body">
          <!-- Removed the search form from here -->
          <div class="d-flex justify-content-between mt-4 mb-1">
           
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-hover table-striped w-100" id="table-1">
              <thead>
              <tr>
        <th>Kode Pengumuman</th>
        <th>Tanggal</th>
        <th>Judul</th>
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
           <td><?php echo $data['kd_pengumuman'] ?></td>
            <td><?php echo $data['tgl_pengumuman'] ?></td>
            <td><?php echo $data['judul_pengumuman'] ?></td>
        <td>
        <a href="detail.php?kd_pengumuman=<?php echo $data['kd_pengumuman']; ?>"><button class="btn btn-success btn-sm"><i class="fas fa-info-circle"></i></button></a>
                  <a href="edit.php?kd_pengumuman=<?php echo $data['kd_pengumuman']; ?>"><button class="btn btn-warning btn-sm"><i class="fas fa-edit fa-fw"></i></button></a>
</a>                  <a href="delete.php?kd_pengumuman=<?php echo $data['kd_pengumuman']; ?>&pesan=hapus" onClick="return confirm('Apakah data yang Anda pilih akan dihapus?')"><button class="btn btn-danger btn-sm"><i class="fas fa-trash fa-fw"></i> </button></a>
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

<td>
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
