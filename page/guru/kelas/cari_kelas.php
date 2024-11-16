<?php
require_once '../helper/config.php';

$katakunci = isset($_POST['kata_kunci']) ? $_POST['kata_kunci'] : '';

// Query untuk mengambil kelas berdasarkan kata kunci pencarian
$sql_kelas = mysqli_query($koneksi, "
    SELECT * FROM kelas 
    WHERE nama_kelas LIKE '%" . mysqli_real_escape_string($koneksi, $katakunci) . "%'
    ORDER BY nama_kelas ASC
");

if (mysqli_num_rows($sql_kelas) > 0) {
    while ($kelas = mysqli_fetch_assoc($sql_kelas)) {
        echo '
        <div class="card mb-3">
          <div class="card-header">
            Kelas: ' . htmlspecialchars($kelas['nama_kelas']) . '
          </div>
          <div class="card-body">
            <a href="create.php?kelas=' . urlencode($kelas['nama_kelas']) . '&kd_kelas=' . urlencode($kelas['kd_kelas']) . '">
              <button class="btn btn-primary btn-block mb-4">Atur Mata Pelajaran</button>
            </a>
        ';

        // Query untuk mengambil mata pelajaran dari tabel `vmpp` sesuai dengan `kd_kelas`
        $kd_kelas = $kelas['kd_kelas'];
        $sql_mapel = mysqli_query($koneksi, "
            SELECT mapel.nama_mapel, vmpp.kode_mpp, vmpp.kd_mapel, vmpp.kd_kelas 
            FROM vmpp 
            JOIN mapel ON mapel.kd_mapel = vmpp.kd_mapel 
            WHERE vmpp.kd_kelas = '$kd_kelas'
            ORDER BY mapel.nama_mapel ASC
        ");

        if (mysqli_num_rows($sql_mapel) > 0) {
            while ($mapel = mysqli_fetch_assoc($sql_mapel)) {
                echo '
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span>' . htmlspecialchars($mapel['nama_mapel']) . '</span>
                  <div>
                    <a href="index.php?kode_mpp=' . urlencode($mapel['kode_mpp']) . '&kd_mapel=' . urlencode($mapel['kd_mapel']) . '&kd_kelas=' . urlencode($kelas['kd_kelas']) . '&pesan=hapus" onClick="return confirm(\'Apakah data yang anda pilih akan dihapus?\')">
                      <button class="btn btn-danger btn-sm"><i class="fas fa-trash fa-fw"></i></button>
                    </a>
                    <a href="edit.php?kd_kelas=' . urlencode($mapel['kd_kelas']) . '">
                      <button class="btn btn-warning btn-sm"><i class="fas fa-edit fa-fw"></i></button>
                    </a>
                  </div>
                </div>';
            }
        } else {
            echo '<p>Tidak ada mata pelajaran yang tersedia untuk kelas ini.</p>';
        }

        echo '</div></div>';
    }
} else {
    echo '<p>Tidak ada data kelas yang sesuai dengan pencarian.</p>';
}
