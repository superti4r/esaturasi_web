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

// Memeriksa apakah parameter 'nama_mapel' dan 'kd_bab' ada dalam request GET
if (isset($_GET['nama_mapel'])) {
    $nama_mapel = mysqli_real_escape_string($koneksi, $_GET['nama_mapel']);
    $kd_bab = isset($_GET['kd_bab']) ? mysqli_real_escape_string($koneksi, $_GET['kd_bab']) : null;

    // Query untuk mengambil data bab berdasarkan mata pelajaran dan optional kode bab
    $sql = "SELECT nama_bab, judul_bab, nama_mapel, kd_bab FROM vbabkelas WHERE nama_mapel = ?";
    
    // Menambahkan kondisi untuk 'kd_bab' jika disertakan dalam request
    if ($kd_bab) {
        $sql .= " AND kd_bab = ?";
    }

    if ($stmt = mysqli_prepare($koneksi, $sql)) {
        // Binding parameter
        if ($kd_bab) {
            mysqli_stmt_bind_param($stmt, "ss", $nama_mapel, $kd_bab); // Binding nama_mapel dan kd_bab
        } else {
            mysqli_stmt_bind_param($stmt, "s", $nama_mapel); // Binding hanya nama_mapel
        }

        mysqli_stmt_execute($stmt);

        // Mendapatkan hasil query
        $result = mysqli_stmt_get_result($stmt);

        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            // Menambahkan data ke array $data
            $data[] = [
                'kdBab' => $row['kd_bab'],    // Menambahkan kode bab ke data
                'namaBab' => $row['nama_bab'],
                'judulBab' => $row['judul_bab'],
                'namaMapel' => $row['nama_mapel']
            ];
        }

        mysqli_stmt_close($stmt);

        // Memeriksa apakah ada data yang ditemukan
        if (count($data) > 0) {
            echo json_encode([
                "status" => "success",
                "message" => "Data berhasil diambil",
                "data" => $data
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Mata pelajaran atau bab yang diminta tidak ditemukan."
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
        "message" => "Parameter 'nama_mapel' tidak ditemukan."
    ]);
}

mysqli_close($koneksi);
?>
