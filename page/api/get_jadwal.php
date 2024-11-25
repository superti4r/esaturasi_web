<?php
require_once('config.php'); // Koneksi database

header('Content-Type: application/json;charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

// Validasi parameter
if (empty($_GET['kd_kelas']) || empty($_GET['hari'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Parameter kd_kelas dan hari diperlukan."
    ]);
    exit();
}

$kd_kelas = mysqli_real_escape_string($koneksi, $_GET['kd_kelas']);
$hari = mysqli_real_escape_string($koneksi, $_GET['hari']);

// Query untuk mengambil data berdasarkan parameter
$query = mysqli_query($koneksi, "
    SELECT 
        kd_mapel, nama_mapel, nama_guru, foto_profil_guru, dari_jam, sampai_jam,
        foto_mapel_perkelas
    FROM vjadwal 
    WHERE kd_kelas='$kd_kelas' AND hari='$hari'
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
        'kd_mapel' => $row['kd_mapel'],
        'nama_mapel' => $row['nama_mapel'],
        'nama_guru' => $row['nama_guru'],
        'foto_profil_guru' => $row['foto_profil_guru'],
        'dari_jam' => $row['dari_jam'],
        'sampai_jam' => $row['sampai_jam'],
        'foto_mapel_perkelas' => $row['foto_mapel_perkelas']
    ];
}

// Kirimkan respons
if (empty($result)) {
    echo json_encode([
        "status" => "success",
        "message" => "Tidak ada data jadwal untuk kelas dan hari ini.",
        "data" => []
    ]);
} else {
    echo json_encode([
        "status" => "success",
        "message" => "Data jadwal berhasil diambil.",
        "data" => $result
    ]);
}

mysqli_close($koneksi);
?>
