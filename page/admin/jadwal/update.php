<?php
require_once '../helper/config.php';


if (isset($_POST['kirim'])) {
    // Ambil data dari form
    $kd_jadwal = $_POST['kd_jadwal'];  // Ambil kd_jadwal dari URL
    $kode_mpp = $_GET['kode_mpp'];    // Ambil kode_mpp dari URL
    $nik = $_POST['nik'];             // Guru yang dipilih
    $waktu_mulai = $_POST['waktu_mulai'];  // Waktu mulai
    $waktu_selesai = $_POST['waktu_selesai'];  // Waktu selesai


    // Proses update jadwal jika data ada
    $update_query = "UPDATE jadwal 
                     SET nik='$nik', dari_jam='$waktu_mulai', sampai_jam='$waktu_selesai'
                     WHERE kd_jadwal='$kd_jadwal'";

    // Eksekusi query update
    if (mysqli_query($koneksi, $update_query)) {
        // Jika berhasil diupdate
        header("Location: index.php?aksi=suksesedit");
    } else {
        // Jika gagal
        echo "<script>alert('Gagal memperbarui jadwal. Silakan coba lagi.'); window.history.back();</script>";
    }
}
?>
