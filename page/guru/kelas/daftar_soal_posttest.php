<?php 
require_once '../layout/_top.php';
require_once '../helper/config.php';


$kd_posttest = isset($_GET['kd_posttest']) ? $_GET['kd_posttest'] : '';
// Proses pencarian berdasarkan kata kunci
if (isset($_POST['cari'])) {
  $katakunci = $_POST['kata_kunci'];
  $sql = mysqli_query($koneksi, "SELECT * FROM vsoalposttest WHERE kd_posttest = '$kd_posttest' ORDER BY kd_posttest ASC");
} else {
  $sql = mysqli_query($koneksi, "SELECT * FROM vsoalposttest WHERE kd_posttest = '$kd_posttest' ORDER BY kd_posttest ASC");
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
    <h1>Soal posttest</h1>
    <div> 
      <a href="create_soal_posttest.php?kd_posttest=<?php echo urlencode($kd_posttest); ?>" class="btn btn-primary mr-2">Tambah Soal</a>
      <a href="./posttest.php" class="btn btn-light"><i class="fas fa-arrow-left"></i> Kembali</a>
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
                  <th>No</th>
                  <th>Soal</th>
                  <th>Opsi 1</th>
                  <th>Opsi 2</th>
                  <th>Opsi 3</th>
                  <th>Opsi 4</th>
                  <th>Jawaban</th>
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
                  <td><?php echo $data['pertanyaan']; ?></td>
                  <td><?php echo $data['opsi_a']; ?></td>
                  <td><?php echo $data['opsi_b']; ?></td>
                  <td><?php echo $data['opsi_c']; ?></td>
                  <td><?php echo $data['opsi_d']; ?></td>
                  <td><?php echo $data['jawab_benar']; ?></td>
                  <td>
                  <a href="edit_soal_prost.php?kd_soal=<?php echo $data['kd_soal']; ?>"><button class="btn btn-success btn-sm"><i class="fas fa-edit fa-fw"></i></button></a>
                    <a href="hapus_soal_posttest.php?kd_soal=<?php echo $data['kd_soal']; ?>&pesan=hapus" onClick="return confirm('Apakah data yang Anda pilih akan dihapus?')">
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