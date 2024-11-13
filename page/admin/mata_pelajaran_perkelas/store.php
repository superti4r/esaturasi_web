<?php
session_start();
require_once '../helper/config.php';
if (isset($_POST['simpan'])) {
  // Ambil parameter kelas dan kd_kelas dari URL
// Ambil parameter kelas dan kd_kelas dari URL
$kelas = isset($_GET['kelas']) ? $_GET['kelas'] : ''; // Mendapatkan nama kelas
$kd_kelas = isset($_GET['kd_kelas']) ? $_GET['kd_kelas'] : ''; // Mendapatkan kode kelas

if (isset($_POST['simpan'])) {
    if (!empty($_POST['mata_pelajaran'])) {
        // Ambil semua mata pelajaran yang dipilih
        $mata_pelajaran_terpilih = $_POST['mata_pelajaran'];

        // Menghapus mata pelajaran yang tidak lagi dipilih
        $sql_hapus = mysqli_query($koneksi, "SELECT kd_mapel FROM mata_pelajaran_perkelas WHERE kd_kelas = '$kd_kelas'");
        $mapel_terdaftar = [];
        while ($row = mysqli_fetch_assoc($sql_hapus)) {
            $mapel_terdaftar[] = $row['kd_mapel'];
        }

        // Menentukan mapel yang harus dihapus (yang tidak tercentang)
        $mapel_yang_dihapus = array_diff($mapel_terdaftar, $mata_pelajaran_terpilih);
        foreach ($mapel_yang_dihapus as $kd_mapel_hapus) {
            $delete = mysqli_query($koneksi, "DELETE FROM mata_pelajaran_perkelas WHERE kd_kelas = '$kd_kelas' AND kd_mapel = '$kd_mapel_hapus'");
            if (!$delete) {
                echo "<script>alert('Gagal menghapus data untuk mapel $kd_mapel_hapus: " . mysqli_error($koneksi) . "');</script>";
            }
        }

        // Proses menambahkan mata pelajaran baru
        foreach ($mata_pelajaran_terpilih as $kd_mapel) {
            // Cek apakah mata pelajaran sudah ada di kelas ini
            $cek_duplikasi = mysqli_query($koneksi, "SELECT * FROM mata_pelajaran_perkelas WHERE kd_kelas = '$kd_kelas' AND kd_mapel = '$kd_mapel'");
            if (mysqli_num_rows($cek_duplikasi) > 0) {
                echo "<script>alert('Mata pelajaran " . htmlspecialchars($kd_mapel) . " sudah terdaftar di kelas ini!');</script>";
            } else {
                // Query untuk menyimpan relasi kelas dan mata pelajaran
                $insert = mysqli_query($koneksi, "INSERT INTO mata_pelajaran_perkelas (kd_kelas, kd_mapel) VALUES ('$kd_kelas', '$kd_mapel')");
                
                if (!$insert) {
                    // Tampilkan pesan kesalahan jika query gagal
                    echo "<script>alert('Gagal menyimpan data untuk mapel $kd_mapel: " . mysqli_error($koneksi) . "');</script>";
                }
            }
        }

        // Redirect setelah berhasil menambahkan data
        header("Location: index.php?aksi=suksessimpan");
        exit(); // Tambahkan exit setelah header untuk mencegah eksekusi kode lebih lanjut
    } else {
        echo "<script>alert('Pilih setidaknya satu mata pelajaran.'); window.history.back();</script>";
    }
}
}

$sql = mysqli_query($koneksi, "SELECT * FROM mapel ORDER BY nama_mapel ASC");

?>