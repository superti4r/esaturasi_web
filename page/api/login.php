<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include 'config.php';

$response = array();

// Baca data input JSON
$data = json_decode(file_get_contents("php://input"), true);

// Pastikan data JSON ada
if (!$data) {
    $response['success'] = false;
    $response['message'] = "Data tidak diterima. Pastikan format JSON sesuai.";
    echo json_encode($response);
    exit;
}

// Ambil nilai NISN dan Password
$nisn = isset($data['nisn']) ? $data['nisn'] : null;
$password = isset($data['password']) ? $data['password'] : null;

// Validasi input
if (empty($nisn) || empty($password)) {
    $response['success'] = false;
    $response['message'] = "NISN dan Password harus diisi!";
    echo json_encode($response);
    exit;
}

// Query database
$query = "SELECT * FROM siswa WHERE nisn = '$nisn'";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    // Periksa password
    if (password_verify($password, $row['password'])) {
        $response['success'] = true;
        $response['message'] = "Login berhasil!";
        $response['data'] = array(
            "nisn" => $row['nisn'],
            "nama_siswa" => $row['nama_siswa'],
            "kd_kelas" => $row['kd_kelas']
        );
    } else {
        $response['success'] = false;
        $response['message'] = "Password salah!";
    }
} else {
    $response['success'] = false;
    $response['message'] = "NISN tidak ditemukan!";
}

echo json_encode($response);
?>
