<?php
require_once('config.php'); // Koneksi ke database

header('Content-Type: application/json;charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

// Validasi parameter (opsional, jika diperlukan parameter tambahan)
if (!empty($_GET['kd_pengumuman'])) {
    $kd_pengumuman = mysqli_real_escape_string($koneksi, $_GET['kd_pengumuman']);
    $query = "SELECT kd_pengumuman, judul_pengumuman, tgl_pengumuman, file_pengumuman, deskripsi_pengumuman FROM pengumuman WHERE kd_pengumuman = '$kd_pengumuman'";
} else {
    $query = "SELECT kd_pengumuman, judul_pengumuman, tgl_pengumuman, file_pengumuman, deskripsi_pengumuman FROM pengumuman";
}

// Eksekusi query
$result = mysqli_query($koneksi, $query);

if (!$result) {
    echo json_encode([
        "status" => "error",
        "message" => "Kesalahan pada query: " . mysqli_error($koneksi)
    ]);
    exit();
}

// Ambil hasil data
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = [
        'kd_pengumuman' => $row['kd_pengumuman'],
        'judul_pengumuman' => $row['judul_pengumuman'],
        'tgl_pengumuman' => $row['tgl_pengumuman'],
        'file_pengumuman' => $row['file_pengumuman'],
        'deskripsi_pengumuman' => $row['deskripsi_pengumuman']
    ];
}

// Kirimkan respons
if (empty($data)) {
    echo json_encode([
        "status" => "success",
        "message" => "Tidak ada data pengumuman.",
        "data" => []
    ]);
} else {
    echo json_encode([
        "status" => "success",
        "message" => "Data pengumuman berhasil diambil.",
        "data" => $data
    ]);
}

// Tutup koneksi
mysqli_close($koneksi);
?>
