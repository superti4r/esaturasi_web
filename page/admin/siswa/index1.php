<?php 
ob_start(); // Tambahkan ini di awal file
require_once '../layout/_top.php';
require_once '../helper/config.php';

//digunakan untuk mencari data dan menampilkan data siswa
$katakunci = "";
if (isset($_POST['cari'])) {
    $katakunci = $_POST['kata_kunci'];
    $sql = mysqli_query($koneksi, "SELECT siswa.*, kelas.nama_kelas FROM siswa
        LEFT JOIN kelas ON siswa.kd_kelas = kelas.kd_kelas
        WHERE siswa.nisn LIKE '%".$katakunci."%' 
        OR siswa.nama_siswa LIKE '%".$katakunci."%' 
        OR siswa.email LIKE '%".$katakunci."%' 
        OR siswa.no_telepon_siswa LIKE '%".$katakunci."%' 
        OR siswa.tempat_lahir_siswa LIKE '%".$katakunci."%' 
        OR siswa.jekel_siswa LIKE '%".$katakunci."%' 
        OR siswa.tahun_masuk_siswa LIKE '%".$katakunci."%' 
        OR siswa.alamat LIKE '%".$katakunci."%' 
        OR kelas.nama_kelas LIKE '%".$katakunci."%' 
        OR siswa.status_siswa LIKE '%".$katakunci."%' 
        ORDER BY siswa.nisn ASC");
} else {
    $sql = mysqli_query($koneksi, "SELECT siswa.*, kelas.nama_kelas FROM siswa
        LEFT JOIN kelas ON siswa.kd_kelas = kelas.kd_kelas
        ORDER BY siswa.nisn ASC");
}

if ($sql) {
    $row = mysqli_num_rows($sql);
} else {
    echo "Error: " . mysqli_error($koneksi); 
}

// Handle delete_selected action
if (isset($_POST['delete_selected'])) {
    if (!empty($_POST['selected_ids'])) {
        $ids = array_map(function($id) use ($koneksi) {
            return mysqli_real_escape_string($koneksi, $id);
        }, $_POST['selected_ids']);
        
        $ids_string = "'" . implode("','", $ids) . "'";
        $delete_query = "DELETE FROM siswa WHERE nisn IN ($ids_string)";
        
        if(mysqli_query($koneksi, $delete_query)) {
            // Simpan pesan dalam session
            $_SESSION['message'] = "Data berhasil dihapus";
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['message'] = "Gagal menghapus data: " . mysqli_error($koneksi);
        }
    } else {
        $_SESSION['message'] = "Pilih minimal satu data untuk dihapus.";
    }
}

// Tampilkan pesan jika ada
if (isset($_SESSION['message'])) {
    echo "<script>alert('" . $_SESSION['message'] . "');</script>";
    unset($_SESSION['message']); // Hapus pesan setelah ditampilkan
}

//untuk menampilkan pesan berhasil menambah data siswa
if (isset($_GET['aksi'])) {
    $aksi = $_GET['aksi'];
    if ($aksi == "suksestambah") {
        echo "<script>alert('Selamat data anda berhasil ditambahkan');</script>";
    } elseif ($aksi == "suksesedit") {
        echo "<script>alert('Selamat data anda berhasil diubah');</script>";
    } elseif ($aksi == "hapusok") {
        echo "<script>alert('Selamat data anda berhasil dihapus');</script>";
    }
}
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
