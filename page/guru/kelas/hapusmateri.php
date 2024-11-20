<?php
require_once '../layout/_top.php';
require_once '../helper/config.php';

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Pastikan ada parameter 'kd_materi' untuk mengidentifikasi materi yang akan dihapus
if (isset($_GET['kd_materi'])) {
    $kd_materi = $_GET['kd_materi'];

    // Ambil data materi untuk mendapatkan nama file
    $sql_materi = mysqli_query($koneksi, "SELECT file_materi FROM materi WHERE kd_materi = '$kd_materi'");
    if (mysqli_num_rows($sql_materi) > 0) {
        $data_materi = mysqli_fetch_assoc($sql_materi);
        $file_materi = $data_materi['file_materi'];

        // Tentukan path file yang akan dihapus
        $file_path = '../uploads/materi/' . $file_materi;

        // Pastikan file ada di server
        if (file_exists($file_path)) {
            // Hapus file materi dari server
            if (unlink($file_path)) {
                // Hapus data materi dari database
                $sql_hapus_materi = mysqli_query($koneksi, "DELETE FROM materi WHERE kd_materi = '$kd_materi'");

                if ($sql_hapus_materi) {
                    echo "<script>alert('Materi berhasil dihapus!'); window.location.href='materi.php';</script>";
                } else {
                    echo "<script>alert('Gagal menghapus data materi dari database.'); window.location.href='materi.php';</script>";
                }
            } else {
                echo "<script>alert('Gagal menghapus file materi.'); window.location.href='materi.php';</script>";
            }
        } else {
            echo "<script>alert('File materi tidak ditemukan di server.'); window.location.href='materi.php';</script>";
        }
    } else {
        echo "<script>alert('Materi tidak ditemukan di database.'); window.location.href='materi.php';</script>";
    }
} else {
    echo "<script>alert('Parameter tidak lengkap.'); window.location.href='materi.php';</script>";
}

require_once '../layout/_bottom.php';
?>
