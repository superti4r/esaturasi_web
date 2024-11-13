<?php 
require_once '../layout/_top.php';
require_once '../helper/config.php';
// digunakan untuk mencari data dan menampilkan data guru
$katakunci = "";
if (isset($_POST['cari'])) {
  $katakunci = $_POST['kata_kunci'];
  
  $sql = mysqli_query($koneksi, "SELECT * FROM mapel WHERE kd_mapel LIKE '%".$katakunci."%' OR nama_mapel LIKE '%".$katakunci."%' ORDER BY kd_mapel ASC");
} else {
  $sql = mysqli_query($koneksi, "SELECT * FROM mapel ORDER BY kd_mapel ASC");
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
  }

}
$loggedInNik = isset($_SESSION['nik']) ? $_SESSION['nik'] : '';
ob_end_flush();
?>
<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Data Mata Pelajaran Kelas</h1>
    
  </div>
  <div class="row">
    <div class="col-12">
          <div class="table-responsive">
            <?php
          // Query untuk mengambil data kelas
$sql_kelas = mysqli_query($koneksi, "SELECT * FROM kelas ORDER BY nama_kelas ASC");

if (!$sql_kelas) {
    die("Error pada query kelas: " . mysqli_error($koneksi));
}

if (mysqli_num_rows($sql_kelas) > 0) {
    while ($kelas = mysqli_fetch_assoc($sql_kelas)) {
        echo '
        <div class="card mb-3">
            <div class="card-header">
                Kelas: ' . htmlspecialchars($kelas['nama_kelas']) . '
            </div>
            <div class="card-body ">
                <a href="create.php?kelas=' . urlencode($kelas['nama_kelas']) . '&kd_kelas=' . urlencode($kelas['kd_kelas']) . '">

                    <button class="btn btn-primary btn-block mb-4">Atur Mata Pelajaran</button>
                </a>
        ';

        // Query untuk mengambil mata pelajaran yang sesuai dengan kelas saat ini
        $kd_kelas = $kelas['kd_kelas'];
        $sql_mapel = mysqli_query($koneksi, "
            SELECT mapel.kd_mapel, mapel.nama_mapel, mata_pelajaran_perkelas.kode_mpp
            FROM mata_pelajaran_perkelas 
            JOIN mapel ON mata_pelajaran_perkelas.kd_mapel = mapel.kd_mapel 
            WHERE mata_pelajaran_perkelas.kd_kelas = '$kd_kelas'
            ORDER BY mapel.nama_mapel ASC
        ");

        // Cek apakah query mata pelajaran berhasil
        if (!$sql_mapel) {
            die("Error pada query mapel: " . mysqli_error($koneksi));
        }

        if (mysqli_num_rows($sql_mapel) > 0) {
            while ($mapel = mysqli_fetch_assoc($sql_mapel)) {
                $kode_mpp = $mapel['kode_mpp'];  // Ini adalah kode induk (kode_mpp) yang digunakan untuk penghapusan

                echo '
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>' . htmlspecialchars($mapel['nama_mapel']) . '</span>
                    <a href="index.php?kode_mpp=' . urlencode($kode_mpp) . '&kd_mapel=' . urlencode($mapel['kd_mapel']) . '&kd_kelas=' . urlencode($kelas['kd_kelas']) . '&pesan=hapus" onClick="return confirm(\'Apakah data yang anda pilih akan dihapus?\')">
                        <button class="btn btn-danger btn-sm"><i class="fas fa-trash fa-fw"></i> </button>
                    </a>
                </div>
                ';
            }
        } else {
            echo '<p>Tidak ada mata pelajaran yang tersedia untuk kelas ini.</p>';
        }

        echo '</div></div>';
    }
} else {
    echo '<p>Tidak ada data kelas yang tersedia.</p>';
}

if (isset($_GET['aksi'])) {
    $aksi=$_GET['aksi'];
    if ($aksi=="suksessimpan") {
      echo "
      <script>
      alert('selamat data anda berhasil diperbarui');
      </script>
      ";
    }
  } 
?>




</div>
</div>
</div>
<?php
require_once '../layout/_bottom.php';

?>

<td>
<script>
document.getElementById('select_all').onclick = function() {
    var checkboxes = document.querySelectorAll('input[name="selected_ids[]"]');
    for (var checkbox of checkboxes) {
        checkbox.checked = this.checked;
    }
}
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
