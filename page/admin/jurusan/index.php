<?php 
require_once '../layout/_top.php';
require_once '../helper/config.php';
// digunakan untuk mencari data dan menampilkan data guru
$katakunci = "";
if (isset($_POST['cari'])) {
  $katakunci = $_POST['kata_kunci'];
  $sql = mysqli_query($koneksi, "SELECT * FROM jurusan WHERE kd_jurusan LIKE '%".$katakunci."%' OR nama_jurusan LIKE '%".$katakunci."%' ORDER BY kd_jurusan ASC");
} else {
  $sql = mysqli_query($koneksi, "SELECT * FROM jurusan ORDER BY kd_jurusan ASC");
}
if ($sql) {
    $row = mysqli_num_rows($sql);
  } else {
    echo "Error: " . mysqli_error($koneksi); 
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
  }elseif ($aksi=="suksestambah") {
    echo "
    <script>
    alert('selamat data anda berhasil ditambahkan');
    </script>
    ";
  }

}

$loggedInNik = isset($_SESSION['nik']) ? $_SESSION['nik'] : '';
ob_end_flush();
?>
<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Data Jurusan</h1>
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
                  <th>NO</th>
                  <th>Kode Jurusan</th>
                  <th>Nama Jurusan</th>
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
                  <td><?php echo $data['kd_jurusan']; ?></td>
                  <td><?php echo $data['nama_jurusan']; ?></td>
                  <td>
                  <a href="edit.php?kd_jurusan=<?php echo $data['kd_jurusan']; ?>"><button class="btn btn-warning btn-sm"><i class="fas fa-edit fa-fw"></i></button></a>

</a>                  <a href="delete.php?kd_jurusan=<?php echo $data['kd_jurusan']; ?>&pesan=hapus" onClick="return confirm('Apakah data yang Anda pilih akan dihapus?')"><button class="btn btn-danger btn-sm"><i class="fas fa-trash fa-fw"></i> </button></a>
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
