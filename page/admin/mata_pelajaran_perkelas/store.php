<?php
session_start();
require_once '../helper/config.php';

if (isset($_POST['submit'])) {
    // Ambil data dari form
    $kd_mpp = $_POST['kd_mpp'];  
    $kd_kelas = $_POST['kd_kelas'];  // Ambil data kd_kelas dari form
    $kd_mapel_selected = $_POST['kd_mapel'];  // Kode mata pelajaran yang dipilih
    $foto_mapel = $_FILES['foto_mapel'];

    // Validasi upload file gambar
    $target_dir = "../uploads/foto_mapel/";  // Direktori penyimpanan gambar
    $target_file = $target_dir . $kd_mpp . '.' . strtolower(pathinfo($foto_mapel["name"], PATHINFO_EXTENSION));
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file gambar valid (tipe file)
    if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        // Pindahkan file ke folder tujuan
        if (move_uploaded_file($foto_mapel["tmp_name"], $target_file)) {
            // Simpan data ke database dengan nama file adalah kode MPP
            $query = "INSERT INTO mata_pelajaran_perkelas (kode_mpp, kd_kelas, kd_mapel, foto_mapel_perkelas) VALUES ('$kd_mpp', '$kd_kelas', '$kd_mapel_selected', '$kd_mpp.$imageFileType')";
            if (mysqli_query($koneksi, $query)) {
                echo "<script>alert('Data berhasil disimpan!'); window.location.href='index.php';</script>";
            } else {
                echo "<script>alert('Terjadi kesalahan saat menyimpan data!');</script>";
                
            }
        } else {
            echo "<script>alert('Gagal mengunggah gambar!');</script>";
        }
    } else {
        echo "<script>alert('Hanya file gambar yang diperbolehkan!');</script>";
    }
}
?>
