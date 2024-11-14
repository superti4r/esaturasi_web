<?php 
require_once '../layout/_top.php';
require_once '../helper/config.php';

$katakunci = "";
if (isset($_POST['cari'])) {
  $katakunci = $_POST['kata_kunci'];
}


// Query untuk mengambil kelas berdasarkan kata kunci pencarian
$sql_kelas = mysqli_query($koneksi, "
    SELECT * FROM kelas 
    WHERE nama_kelas LIKE '%" . $katakunci . "%'
    ORDER BY nama_kelas ASC
");


if (!$sql_kelas) {
  die("Error pada query kelas: " . mysqli_error($koneksi));
}
// untuk menampilkan pesan berhasil menambah, mengubah, atau menghapus data
if (isset($_GET['aksi'])) {
  $aksi = $_GET['aksi'];
  if ($aksi == "suksestambah") {
    echo "<script>alert('Selamat, data berhasil ditambahkan');</script>";
  } elseif ($aksi == "suksesedit") {
    echo "<script>alert('Selamat, data berhasil diubah');</script>";
  } elseif ($aksi == "hapusok") {
    echo "<script>alert('Selamat, data berhasil dihapus');</script>";
  }
}

ob_end_flush();
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Data Jadwal Kelas</h1>
  </div>

  <!-- Form Pencarian -->
  <form method="POST" action="">
    <div class="input-group mb-3">
      <input type="text" name="kata_kunci" id="kata_kunci" class="form-control" placeholder="Cari kelas..." onkeyup="cariKelas()" autocomplete="off">
    </div>
  </form>

  <div class="row">
    <div class="col-12">
      <div class="table-responsive" id="kelas-container">
       
      <?php 
if (mysqli_num_rows($sql_kelas) > 0) {
  while ($kelas = mysqli_fetch_assoc($sql_kelas)) {
    echo '
    <div class="card mb-3">
      <div class="card-header">
        Kelas: ' . htmlspecialchars($kelas['nama_kelas']) . '
      </div>
      <div class="card-body">
        <a href="create.php?kd_kelas=' . urlencode($kelas['kd_kelas']) . '">
          <button class="btn btn-primary btn-block mb-4">Tambah Mata Pelajaran</button>
        </a>';

    // Array untuk hari-hari
    $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
    foreach ($hari as $h) {
      echo '<label for="hari">' . $h . '</label>';
      
      // Query untuk mengambil jadwal sesuai hari dan kelas
      $kd_kelas = $kelas['kd_kelas'];
      $sql_jadwal = mysqli_query($koneksi, "
          SELECT * FROM vjadwal
          WHERE kd_kelas = '$kd_kelas' AND hari = '$h'
          ORDER BY hari ASC
      ");

      if (!$sql_jadwal) {
        die("Error pada query jadwal: " . mysqli_error($koneksi));
      }

      if (mysqli_num_rows($sql_jadwal) > 0) {
        while ($jadwal = mysqli_fetch_assoc($sql_jadwal)) {
            $kd_jadwal = $jadwal['kd_jadwal'];
            echo '
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span>' . substr(htmlspecialchars($jadwal['dari_jam']), 0, 5) . ' - ' . substr(htmlspecialchars($jadwal['sampai_jam']), 0, 5) . ' | ' . htmlspecialchars($jadwal['nama_mapel']) . ' | ' . htmlspecialchars($jadwal['nama_guru']) . '</span>
                <div>
                    <a href="delete.php?kd_jadwal=' . urlencode($kd_jadwal) . '&pesan=hapus" onClick="return confirm(\'Apakah data yang anda pilih akan dihapus?\')">
                        <button class="btn btn-danger btn-sm"><i class="fas fa-trash fa-fw"></i></button>
                    </a>
                    <a href="edit.php?kd_jadwal=' . urlencode($kd_jadwal) . '&kode_mpp=' . urlencode($jadwal['kode_mpp']) .'">
                        <button class="btn btn-warning btn-sm"><i class="fas fa-edit fa-fw"></i></button>
                    </a>
                </div>
            </div>';
        }
      } else {
        echo '<p>Tidak ada jadwal uyang tersedia.</p>';
      }

      echo '<hr>'; // Pemisah antara hari
    }

    echo '</div></div>';
  }
} else {
  echo '<p>Tidak ada data kelas yang sesuai dengan pencarian.</p>';
}
?>

</section>
<script>
function cariKelas() {
  const kataKunci = document.getElementById("kata_kunci").value;

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "cari_kelas.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) {
      document.getElementById("kelas-container").innerHTML = xhr.responseText;
    }
  };
  xhr.send("kata_kunci=" + encodeURIComponent(kataKunci));
}
</script>

<?php require_once '../layout/_bottom.php'; ?>
