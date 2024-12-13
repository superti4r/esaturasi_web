<?php
require_once('config.php');

if (!$koneksi) {
    echo json_encode([
        "status" => "error",
        "message" => "Gagal terhubung ke database."
    ]);
    exit();
}

header('Content-Type: application/json;charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

if (isset($_GET['kd_bab']) && isset($_GET['nama_mapel'])) {
    $kd_bab = mysqli_real_escape_string($koneksi, $_GET['kd_bab']);
    $nama_mapel = mysqli_real_escape_string($koneksi, $_GET['nama_mapel']);

   
    $sql = "SELECT file_materi, nama_bab, kd_bab, nama_mapel FROM vmateri WHERE kd_bab = ? AND nama_mapel = ?";

    if ($stmt = mysqli_prepare($koneksi, $sql)) {
        mysqli_stmt_bind_param($stmt, "ss", $kd_bab, $nama_mapel); // Binding parameter
        mysqli_stmt_execute($stmt);

       
        $result = mysqli_stmt_get_result($stmt);

        // Array untuk menampung data
        $data = array();
        
        // Mengambil setiap baris hasil dan menyimpannya dalam array
        while ($row = mysqli_fetch_assoc($result)) {
            
            $data[] = [
                'file_materi' => $row['file_materi'],
                'nama_bab' => $row['nama_bab'],  
                'kd_bab' => $row['kd_bab'],
                'nama_mapel' => $row['nama_mapel']
            ];
        }

       
        if (count($data) > 0) {
            echo json_encode([
                "status" => "success",
                "message" => "Data berhasil diambil",
                "data" => $data
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Materi tidak ditemukan."
            ]);
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Gagal menyiapkan query."
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Parameter kd_bab dan nama_mapel harus diberikan."
    ]);
}
?>
