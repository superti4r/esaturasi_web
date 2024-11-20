<?php
require_once '../helper/config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kata_kunci = isset($_POST['kata_kunci']) ? $_POST['kata_kunci'] : '';
    $guru = $_SESSION['nik'];

    // Query untuk mengambil kelas berdasarkan kata kunci pencarian dan NIK guru
    $sql_kelas = mysqli_query($koneksi, "
        SELECT * FROM vmpp 
        WHERE nama_kelas LIKE '%$kata_kunci%' 
        AND status='aktif' 
        AND nik='$guru' 
        ORDER BY nama_kelas ASC
    ");

    if (!$sql_kelas) {
        die("Error pada query kelas: " . mysqli_error($koneksi));
    }

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
              WHERE nik = '{$guru}' AND kd_kelas = '{$kelas['kd_kelas']}' 
              AND status = 'aktif' 
              ORDER BY nama_mapel ASC
            ");

            while ($mapel = mysqli_fetch_assoc($sql_mapel)) {
                $kode_mpp = $mapel['kode_mpp'];
                echo '
                <div class="mb-3">
                  <h6><i class="fas fa-book-reader text-primary"></i> ' . htmlspecialchars($mapel['nama_mapel']) . '</h6>';

                $sql_bab = mysqli_query($koneksi, "
                  SELECT * FROM bab
                  ORDER BY nama_bab ASC
                ");

                if (mysqli_num_rows($sql_bab) > 0) {
                    echo '<ul class="list-group">';
                    while ($bab = mysqli_fetch_assoc($sql_bab)) {
                        echo '
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                          ' . htmlspecialchars($bab['nama_bab']) . '
                          <a href="create_bab.php?kode_mpp=' . urlencode($kode_mpp) . '&kd_mapel=' . urlencode($mapel['kd_mapel']) . '&kd_kelas=' . urlencode($kelas['kd_kelas']) . '" 
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
        echo '<div class="alert alert-danger">Tidak ada data kelas yang sesuai dengan pencarian.</div>';
    }
}
?>
