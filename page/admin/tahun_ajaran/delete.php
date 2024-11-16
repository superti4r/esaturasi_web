<?php
session_start();
require_once '../helper/config.php';

if (isset($_GET['pesan'])) {
    // Pastikan kita mendapatkan nilai 'kd_tahun_ajaran' dari URL
    $kd_tahun_ajaran = $_GET['kd_tahun_ajaran'];
    
    // Hapus data berdasarkan kd_tahun_ajaran
    mysqli_query($koneksi, "DELETE FROM tahun_ajaran WHERE kd_tahun_ajaran='$kd_tahun_ajaran'");
    
    // Redirect setelah penghapusan
    header("Location:index.php?aksi=hapusok");
}
?>
