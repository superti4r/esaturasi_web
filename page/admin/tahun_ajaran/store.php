<?php
session_start();
require_once '../helper/config.php';

if (isset($_POST['proses'])) {
    $tahun_mulai = $_POST['tahun_mulai'];
    $tahun_selesai = $_POST['tahun_selesai'];
    $semester = $_POST['semester'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $status = "nonaktif"; // Status tahun ajaran yang baru akan diaktifkan

    // Validasi tahun selesai tidak boleh kurang dari tahun mulai
    if ($tahun_selesai < $tahun_mulai) {
        echo "<script>alert('Tahun selesai tidak boleh kurang dari tahun mulai!'); window.history.back();</script>";
        exit();
    }

    // Cek apakah Tahun Ajaran sudah ada
    $cek_tahun_ajaran = mysqli_query($koneksi, 
        "SELECT * FROM tahun_ajaran 
        WHERE tahun_mulai='$tahun_mulai' 
        AND tahun_selesai='$tahun_selesai' 
        AND semester='$semester'"
    );

    if (mysqli_num_rows($cek_tahun_ajaran) > 0) {
        // Jika Tahun Ajaran sudah ada, tampilkan pesan
        echo "<script>alert('Tahun Ajaran dengan periode dan semester tersebut sudah ada.'); window.history.back();</script>";
        exit();
    }

    // Cek apakah tahun dari tanggal mulai dan tanggal selesai sesuai dengan tahun ajaran
    $tahun_mulai_input = date('Y', strtotime($tanggal_mulai));
    $tahun_selesai_input = date('Y', strtotime($tanggal_selesai));

    if (($tahun_mulai_input != $tahun_mulai && $tahun_mulai_input != $tahun_selesai) || 
        ($tahun_selesai_input != $tahun_mulai && $tahun_selesai_input != $tahun_selesai)) {
        echo "<script>alert('Tanggal mulai dan tanggal selesai harus berada dalam rentang tahun ajaran yang sesuai (misal: 2024/2025).'); window.history.back();</script>";
        exit();
    }

    // Cek apakah tanggal mulai dan selesai tumpang tindih dengan data tahun ajaran lain
    $cek_tanggal = mysqli_query($koneksi, 
        "SELECT * FROM tahun_ajaran 
        WHERE (
            ('$tanggal_mulai' BETWEEN tanggal_mulai AND tanggal_selesai) OR
            ('$tanggal_selesai' BETWEEN tanggal_mulai AND tanggal_selesai) OR
            (tanggal_mulai BETWEEN '$tanggal_mulai' AND '$tanggal_selesai') OR
            (tanggal_selesai BETWEEN '$tanggal_mulai' AND '$tanggal_selesai')
        )"
    );

    if (mysqli_num_rows($cek_tanggal) > 0) {
        // Jika tanggalnya tumpang tindih, tampilkan pesan
        echo "<script>alert('Tanggal yang dimasukkan bertabrakan dengan tahun ajaran lain. Silakan pilih tanggal yang berbeda.'); window.history.back();</script>";
        exit();
    }

    // Cek apakah sudah ada tahun ajaran yang aktif
    $cek_status_aktif = mysqli_query($koneksi, "SELECT * FROM tahun_ajaran WHERE status='aktif' LIMIT 1");

    // Update status tahun ajaran yang sedang aktif menjadi nonaktif hanya jika belum ada tahun ajaran aktif
    if (mysqli_num_rows($cek_status_aktif) > 0) {
        // Jika ada tahun ajaran yang aktif, kita tidak perlu melakukan update status
        // Tahun ajaran baru akan tetap memiliki status nonaktif
    } else {
        // Jika tidak ada tahun ajaran aktif, update status tahun ajaran yang baru menjadi aktif
        $status = "aktif";
    }

    // Membuat kode otomatis untuk Tahun Ajaran
    $sql = mysqli_query($koneksi, "SELECT * FROM tahun_ajaran ORDER BY kd_tahun_ajaran DESC");
    $data = mysqli_fetch_array($sql);
    $kd = isset($data['kd_tahun_ajaran']) ? $data['kd_tahun_ajaran'] : 'TA00';
    $kd = (int)substr($kd, 2, 2) + 1;
    $kd_tahun_ajaran = "TA" . sprintf("%02s", $kd);

    // Insert data tahun ajaran baru dengan status yang telah ditentukan
    $query = mysqli_query($koneksi, 
        "INSERT INTO tahun_ajaran 
        (kd_tahun_ajaran, tahun_mulai, tahun_selesai, semester, tanggal_mulai, tanggal_selesai, status) 
        VALUES 
        ('$kd_tahun_ajaran', '$tahun_mulai', '$tahun_selesai', '$semester', '$tanggal_mulai', '$tanggal_selesai', '$status')"
    );

    if ($query) {
        // Redirect setelah berhasil menyimpan data
        header("Location: index.php?aksi=suksestambah");
    } else {
        // Tampilkan pesan jika gagal menyimpan data
        echo "<script>alert('Gagal menyimpan data. Silakan coba lagi.'); window.history.back();</script>";
    }
}
?>
