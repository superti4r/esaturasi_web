<?php
require_once('config.php'); // Koneksi database

header('Content-Type: application/json;charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

// Validasi parameter
if (empty($_GET['nisn'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Parameter NISN diperlukan."
    ]);
    exit();
}

$nisn = mysqli_real_escape_string($koneksi, $_GET['nisn']);

// Query untuk mengambil data berdasarkan parameter
$query = mysqli_query($koneksi, "
    SELECT 
        kd_tugas, nisn, tgl_pengumpulan, jam, status
    FROM pengumpulan_tugas
    WHERE nisn = '$nisn'
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
        'title' => $row['kd_tugas'],
        'subject' => $row['nisn'],
        'deadline' => $row['tgl_pengumpulan'] . ' ' . $row['jam'],
        'status' => $row['status']
    ];
}

// Kirimkan respons
if (empty($result)) {
    echo json_encode([
        "status" => "success",
        "message" => "Tidak ada tugas untuk siswa ini.",
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
