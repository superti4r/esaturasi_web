<?php 
require_once '../layout/_top.php';
require_once '../helper/config.php';

$guru = $_SESSION['nik']; // Mendapatkan nik dari sesi pengguna

if (isset($_POST['cari'])) {
    $katakunci = $_POST['kata_kunci'];
    $sql = mysqli_query($koneksi, "
        SELECT * FROM vjadwal 
        WHERE (nip LIKE '%$katakunci%' 
            OR nama_kelas LIKE '%$katakunci%' 
            OR nama_guru LIKE '%$katakunci%' 
            OR NAMA_MAPEL LIKE '%$katakunci%' 
            OR dari_jam LIKE '%$katakunci%' 
            OR sampai_jam LIKE '%$katakunci%' 
            AND nik = '$guru'
        ORDER BY nama_guru ASC
    ");
} else {
    $sql = mysqli_query($koneksi, "SELECT * FROM vjadwal WHERE nik = '$guru' ORDER BY nik ASC");
}

if ($sql) {
    $row = mysqli_num_rows($sql);
} else {
    echo "Error: " . mysqli_error($koneksi); 
}


$loggedInNik = isset($_SESSION['nik']) ? $_SESSION['nik'] : '';
ob_end_flush();
?>
<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Jadwal Mengajar</h1>
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
                  <th>Hari</th>
                  <th>Kelas</th>
                  <th>Mata Pelajaran</th>
                  <th>Waktu Mulai</th>
                  <th>Waktu Selesai</th>
                  
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
                  <td><?php echo $data['hari']; ?></td>
                  <td><?php echo $data['nama_kelas']; ?></td>
                  <td><?php echo $data['nama_mapel']; ?></td>
                  <td><?php echo $data['dari_jam']; ?></td>
                  <td><?php echo $data['sampai_jam']; ?></td>
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
