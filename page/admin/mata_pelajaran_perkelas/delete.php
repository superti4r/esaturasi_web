<?php
session_start();
require_once '../helper/config.php';

$kd_mpp = $_GET['kode_mpp'];
function hapusMataPelajaranPerKelas($kd_mpp) {
    global $koneksi;

    // Query untuk mengambil path foto mapel berdasarkan kd_mpp
    $query = mysqli_query($koneksi, "SELECT foto_mapel_perkelas FROM mata_pelajaran_perkelas WHERE kode_mpp = '$kd_mpp'");
    if (!$query) {
        die("Query gagal: " . mysqli_error($koneksi));
    }
  
    $data = mysqli_fetch_assoc($query);

    // Memastikan foto mapel ada dan file tersebut ada di server
    if (!empty($data['foto_mapel_perkelas'])) {
        // Menentukan path absolut foto berdasarkan direktori root
        $fotoPath = $_SERVER['DOCUMENT_ROOT'] . '/../uploads/foto_mapel/' . $data['foto_mapel_perkelas'];
      
        // Mengecek apakah file foto ada di server
        if (file_exists($fotoPath)) {
            // Menghapus file foto dari server
            if (!unlink($fotoPath)) {
                echo "Gagal menghapus foto.<br>";
            }
        } else {
            echo "File foto tidak ditemukan di server.<br>";
        }
    }

    // Menghapus data mapel perkelas dari database berdasarkan kd_mpp
    $deleteQuery = "DELETE FROM mata_pelajaran_perkelas WHERE kode_mpp = '$kd_mpp'";
    if (mysqli_query($koneksi, $deleteQuery)) {
        return true;
    } else {
        echo "Error: " . mysqli_error($koneksi);
        return false;
    }
}

if (isset($_GET['pesan']) && isset($_GET['kode_mpp'])) {
    $kode_mpp = $_GET['kode_mpp'];
    if (hapusMataPelajaranPerKelas($kode_mpp)) {
        header("Location: index.php?aksi=hapusok");
        exit();
    } else {
        echo "<script>
                alert('Gagal menghapus data mata pelajaran per kelas!');
                window.location.href = 'index.php';
              </script>";
        exit();
    }
}
?>
