<?php 
require_once '../layout/_top.php';
require_once '../helper/config.php';

$katakunci = "";
if (isset($_POST['cari'])) {
  $katakunci = $_POST['kata_kunci'];
}

$guru = $_SESSION['nik'];

// Query untuk mengambil kelas berdasarkan kata kunci pencarian dan NIK guru
$sql_kelas = mysqli_query($koneksi, "
    SELECT * FROM vmpp 
    WHERE nama_kelas LIKE '%$katakunci%' 
    AND status='aktif' 
    AND nik='$guru' 
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

if (isset($_GET['aksi'])) {
  $aksi = $_GET['aksi'];
  if ($aksi == "suksestambah") {
    echo "<script>alert('Selamat, data berhasil ditambahkan');</script>";
  }
}

?>

<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1><i class="fas fa-chalkboard-teacher mr-2"></i> Data Kelas Yang Diampu</h1>
  </div>

  <!-- Form Pencarian -->
  <form method="POST" action="">
    <div class="input-group mb-4">
      <input type="text" name="kata_kunci" id="kata_kunci" class="form-control border-primary" 
             placeholder="Cari kelas..." onkeyup="cariKelas()" autocomplete="off">
      <div class="input-group-append">
        <span class="input-group-text bg-primary text-white">
          <i class="fas fa-search"></i>
        </span>
      </div>
    </div>
  </form>

  <div class="row">
    <div class="col-12">
      <div class="table-responsive" id="kelas-container">
        <?php
        if (mysqli_num_rows($sql_kelas) > 0) {
          $kelas_sudah_ditampilkan = [];
          while ($kelas = mysqli_fetch_assoc($sql_kelas)) {
            if (in_array($kelas['kd_kelas'], $kelas_sudah_ditampilkan)) {
              continue;
            }
            $kelas_sudah_ditampilkan[] = $kelas['kd_kelas'];

            echo '
            <div class="card mb-4 shadow-sm border-primary">
              <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Kelas: ' . htmlspecialchars($kelas['nama_kelas']) . '</h5>
              </div>
              <div class="card-body">
                <div class="list-group">';

            $sql_mapel = mysqli_query($koneksi, "
              SELECT nama_mapel, kode_mpp, kd_mapel, kd_kelas 
              FROM vmpp 
              WHERE nik = '{$_SESSION['nik']}' AND kd_kelas = '{$kelas['kd_kelas']}' 
              AND status = 'aktif' 
              ORDER BY nama_mapel ASC
            ");

            while ($mapel = mysqli_fetch_assoc($sql_mapel)) {
              $kode_mpp = $mapel['kode_mpp'];
              echo '
              <div class="mb-3">
                <h6><i class="fas fa-book-reader text-primary"></i> ' . htmlspecialchars($mapel['nama_mapel']) . '</h6>';

              // Query untuk mendapatkan data bab
              $sql_bab = mysqli_query($koneksi, "
                SELECT * FROM bab
                ORDER BY nama_bab ASC
              ");

              // Jika tidak ada bab, arahkan ke halaman createbab.php
              if (mysqli_num_rows($sql_bab) == 0) {
                header("Location: createbab.php?kode_mpp=" . urlencode($kode_mpp) . "&kd_mapel=" . urlencode($mapel['kd_mapel']) . "&kd_kelas=" . urlencode($kelas['kd_kelas']));
                exit; // Pastikan script berhenti setelah pengalihan
              }

              if (mysqli_num_rows($sql_bab) > 0) {
                echo '<ul class="list-group">';
                while ($bab = mysqli_fetch_assoc($sql_bab)) {
                    echo '
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      ' . htmlspecialchars($bab['nama_bab']) . '
                      <a href="view_bab.php?kode_mpp=' . urlencode($kode_mpp) . '&kd_mapel=' . urlencode($mapel['kd_mapel']) . '&kd_kelas=' . urlencode($kelas['kd_kelas']) . '&kd_bab=' . urlencode($bab['kd_bab']) . '" 
                         class="btn btn-sm btn-primary">
                        <i class="fas fa-eye"></i> Lihat Bab
                      </a>
                    </li>';
                  

                }
                echo '</ul>';
              } else {
                echo '<p class="text-muted">Tidak ada bab untuk mata pelajaran ini.</p>';
              }

              echo '</div>';
            }

            echo '</div>
              </div>
            </div>';
          }
        } else {
            echo '<div class="alert alert-danger">Tidak ada data kelas mengajar</div>';
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
