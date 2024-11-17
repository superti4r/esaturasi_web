<?php
session_start();
require_once '../helper/config.php';

if (isset($_POST['proses'])) {
    $kd_mapel = $_POST['kd_mapel'];
    $hari = $_POST['hari'];
    $kd_kelas = $_POST['kd_kelas'];
    $waktu_mulai = $_POST['waktu_mulai'];
    $waktu_selesai = $_POST['waktu_selesai'];
    $nik = $_POST['nik'];
    $kd_jadwal = $_POST['kd_jadwal'];

    // Cek apakah waktu mulai lebih dari jam 17:00
    if ($waktu_mulai > '17:00') {
        echo "<script>alert('Waktu mulai tidak boleh lebih dari jam 17:00.'); window.history.back();</script>";
        exit;
    }

    // Cek apakah waktu selesai lebih dari jam 18:00
    if ($waktu_selesai > '18:00') {
        echo "<script>alert('Waktu selesai tidak boleh lebih dari jam 18:00.'); window.history.back();</script>";
        exit;
    }

    // Cek apakah waktu mulai lebih besar atau sama dengan waktu selesai
    if ($waktu_selesai <= $waktu_mulai) {
        echo "<script>alert('Waktu selesai tidak boleh lebih kecil atau sama dengan waktu mulai.'); window.history.back();</script>";
        exit;
    }

    // Ambil kode_mpp berdasarkan kd_mapel dan kd_kelas
    $query_get_kode_mpp = "
        SELECT kode_mpp FROM mata_pelajaran_perkelas 
        WHERE kd_mapel = '$kd_mapel' AND kd_kelas = '$kd_kelas'
    ";
    
    $result_kode_mpp = mysqli_query($koneksi, $query_get_kode_mpp);
    
    // Cek jika query gagal atau tidak ada kode_mpp ditemukan
    if (!$result_kode_mpp || mysqli_num_rows($result_kode_mpp) == 0) {
        echo "<script>alert('Data kode_mpp tidak ditemukan.'); window.history.back();</script>";
        exit;
    }

    // Ambil nilai kode_mpp
    $row_kode_mpp = mysqli_fetch_assoc($result_kode_mpp);
    $kode_mpp = $row_kode_mpp['kode_mpp'];

    // Cek apakah ada jadwal yang tumpang tindih dengan jadwal yang baru
    $query_check = "
    SELECT * FROM jadwal 
    WHERE hari = '$hari' 
    AND kode_mpp = '$kode_mpp' 
    AND (
        (dari_jam < '$waktu_selesai' AND sampai_jam > '$waktu_mulai')
        OR
        (dari_jam BETWEEN '$waktu_mulai' AND '$waktu_selesai') 
        OR
        (sampai_jam BETWEEN '$waktu_mulai' AND '$waktu_selesai')
    )";

    $result_check = mysqli_query($koneksi, $query_check);

    // Cek jika query gagal
    if (!$result_check) {
        echo "Error in query: " . mysqli_error($koneksi);
        exit;
    }

    if (mysqli_num_rows($result_check) > 0) {
        echo "<script>alert('Jam yang dipilih sudah ada di jadwal untuk kelas ini. Silakan pilih waktu lain.'); window.history.back();</script>";
        exit;
    }

    // Query untuk menyimpan data jadwal
    $query_insert = "INSERT INTO jadwal (kd_jadwal, kode_mpp, hari, dari_jam, sampai_jam) 
                     VALUES ('$kd_jadwal', '$kode_mpp', '$hari', '$waktu_mulai', '$waktu_selesai')";

    if (mysqli_query($koneksi, $query_insert)) {
        echo "<script>alert('Data berhasil disimpan.'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>
