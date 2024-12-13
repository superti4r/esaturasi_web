<?php
require_once('config.php'); // Koneksi database

header('Content-Type: application/json;charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

// Validasi parameter
if (empty($_GET['kd_kelas'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Parameter Kode Kelas diperlukan."
    ]);
    exit();
}

$kd_kelas = mysqli_real_escape_string($koneksi, $_GET['kd_kelas']);
// Query untuk mengambil data berdasarkan parameter kd_kelas
$query = mysqli_query($koneksi, "
    SELECT 
        kd_tugas, nama_bab, kd_kelas, nama_mapel,  judul_bab, tenggat_waktu
    FROM vtugas
    WHERE kd_kelas = '$kd_kelas'
");

if (!$query) {
    echo json_encode([
        "status" => "error",
        "message" => "Kesalahan pada query: " . mysqli_error($koneksi)
    ]);
    exit();
}

$result = [];
while ($row = mysqli_fetch_assoc($query)) {
    $result[] = [
        'task_id' => $row['nama_bab'], 
        'class_code' => $row['kd_kelas'], 
        'subject' => $row['nama_mapel'], 
        'chapter_title' => $row['judul_bab'], 
        'deadline' => $row['tenggat_waktu'], 
    ];
}

// Kirimkan respons
if (empty($result)) {
    echo json_encode([
        "status" => "success",
        "message" => "Tidak ada tugas untuk kelas ini.",
        "data" => []
    ]);
} else {
    echo json_encode([
        "status" => "success",
        "message" => "Data tugas berhasil diambil.",
        "data" => $result
    ]);
}

mysqli_close($koneksi);
?>
