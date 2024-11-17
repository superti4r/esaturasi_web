<?php
session_start();
require_once '../helper/config.php';

if (isset($_POST['kirim'])) {
    // Ambil data dari form
    $kode_mpp = $_POST['kode_mpp'];
    $kd_kelas = $_POST['kd_kelas'];
    $nama_mapel = $_POST['nama_mapel'];
    $foto_mapel_lama = $_POST['foto_mapel_lama'];
    $foto_mapel = $_FILES['foto_mapel'];
    $nik = $_POST['nik']; // Ambil nik guru yang dipilih

    // Path direktori penyimpanan gambar
    $target_dir = "../uploads/foto_mapel/";

    // Cek apakah ada file gambar baru yang diunggah
    if (!empty($foto_mapel['name'])) {
        // Format nama file baru dengan kode mpp
        $target_file = $target_dir . $kode_mpp . '.' . strtolower(pathinfo($foto_mapel['name'], PATHINFO_EXTENSION));
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Cek apakah file gambar valid (tipe file)
        if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            // Pindahkan file ke folder tujuan
            if (move_uploaded_file($foto_mapel["tmp_name"], $target_file)) {
                // Hapus file gambar lama jika ada
                if (!empty($foto_mapel_lama) && file_exists($target_dir . $foto_mapel_lama)) {
                    unlink($target_dir . $foto_mapel_lama);
                }
                // Simpan nama file baru ke database
                $foto_mapel_baru = $kode_mpp . '.' . $imageFileType;
            } else {
                echo "<script>alert('Gagal mengunggah gambar baru!'); window.location.href='edit.php?kode_mpp=$kode_mpp';</script>";
                exit();
            }
        } else {
            echo "<script>alert('Hanya file gambar yang diperbolehkan!'); window.location.href='edit.php?kode_mpp=$kode_mpp';</script>";
            exit();
        }
    } else {
        // Jika tidak ada file baru yang diunggah, gunakan gambar lama
        $foto_mapel_baru = $foto_mapel_lama;
    }

    // Query untuk memperbarui data di database (termasuk foto dan nik)
    $query = "UPDATE mata_pelajaran_perkelas 
              SET foto_mapel_perkelas = '$foto_mapel_baru', nik = '$nik' 
              WHERE kode_mpp = '$kode_mpp'";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat memperbarui data!'); window.location.href='edit.php?kode_mpp=$kode_mpp';</script>";
    }
} else {
    echo "<script>alert('Akses tidak sah!'); window.location.href='index.php';</script>";
}
?>
