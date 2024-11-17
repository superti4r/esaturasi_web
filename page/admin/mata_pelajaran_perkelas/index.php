<?php 
require_once '../layout/_top.php';
require_once '../helper/config.php';

$katakunci = "";
if (isset($_POST['cari'])) {
  $katakunci = $_POST['kata_kunci'];
}

// Query untuk mengambil kelas berdasarkan kata kunci pencarian
$sql_kelas = mysqli_query($koneksi, "
    SELECT * FROM vkelas 
    WHERE nama_kelas LIKE '%" . $katakunci . "%' AND status='aktif'
    ORDER BY nama_kelas ASC
");

if (!$sql_kelas) {
  die("Error pada query kelas: " . mysqli_error($koneksi));
}

// Query untuk mendapatkan tahun ajaran yang aktif
$sql_tahun_ajaran = mysqli_query($koneksi, "
    SELECT * FROM tahun_ajaran 
    WHERE status = 'aktif' 
    LIMIT 1
");

if (!$sql_tahun_ajaran) {
  die("Error pada query tahun ajaran: " . mysqli_error($koneksi));
}

$tahun_ajaran_aktif = mysqli_fetch_assoc($sql_tahun_ajaran);

// Validasi: Jika tidak ada tahun ajaran aktif
if (!$tahun_ajaran_aktif) {
    die("Tidak ada tahun ajaran aktif. Silakan tambahkan tahun ajaran aktif terlebih dahulu.");
}

$kd_tahun_ajaran_aktif = $tahun_ajaran_aktif['kd_tahun_ajaran'];

// Untuk menampilkan pesan berhasil menambah, mengubah, atau menghapus data
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
    <h1>Data Mata Pelajaran Per-Kelas</h1>
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

            // Query untuk mengambil mata pelajaran dari tabel `vmpp` sesuai dengan `kd_kelas` dan `kd_tahun_ajaran`
            $kd_kelas = $kelas['kd_kelas'];
            $sql_mapel = mysqli_query($koneksi, "
                SELECT 
                    mapel.nama_mapel, 
                    vmpp.kode_mpp, 
                    vmpp.kd_mapel, 
                    vmpp.kd_kelas,
                    vmpp.nama_guru 
                FROM vmpp 
                JOIN mapel ON mapel.kd_mapel = vmpp.kd_mapel 
                WHERE vmpp.kd_kelas = '$kd_kelas' 
                AND vmpp.kd_tahun_ajaran = '$kd_tahun_ajaran_aktif'
                ORDER BY mapel.nama_mapel ASC
            ");

            if (!$sql_mapel) {
              die("Error pada query mapel: " . mysqli_error($koneksi));
            }

            if (mysqli_num_rows($sql_mapel) > 0) {
              while ($mapel = mysqli_fetch_assoc($sql_mapel)) {
                $kode_mpp = $mapel['kode_mpp'];
                echo '
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span>
                    ' . htmlspecialchars($mapel['nama_mapel']) . ' - 
                    <strong>' . htmlspecialchars($mapel['nama_guru']) . '</strong>
                  </span>
                  <div>
                    <a href="delete.php?kode_mpp=' . urlencode($kode_mpp) . '&kd_mapel=' . urlencode($mapel['kd_mapel']) . '&kd_kelas=' . urlencode($kelas['kd_kelas']) . '&pesan=hapus" onClick="return confirm(\'Apakah data yang anda pilih akan dihapus?\')">
                      <button class="btn btn-danger btn-sm"><i class="fas fa-trash fa-fw"></i></button>
                    </a>
                    <a href="edit.php?kode_mpp=' . urlencode($kode_mpp) . '&kd_mapel=' . urlencode($mapel['kd_mapel']) . '&kd_kelas=' . urlencode($kelas['kd_kelas']) . '">
                      <button class="btn btn-warning btn-sm"><i class="fas fa-edit fa-fw"></i></button>
                    </a>
                  </div>
                </div>';
              }
            } else {
              echo '<p class="mt-5">Tidak ada mata pelajaran yang tersedia untuk kelas ini pada tahun ajaran aktif.</p>';
            }

            echo '</div></div>';
          }
        } else {
          echo '<p>Tidak ada data kelas yang sesuai dengan pencarian.</p>';
        }
        ?>
      </div>
    </div>
  </div>
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
