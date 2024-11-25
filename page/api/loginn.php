<?php
require_once 'config.php';
header('Content-Type: application/json; charset=UTF-8');

// Periksa apakah parameter POST ada
if (isset($_POST['nisn']) && isset($_POST['password'])) {
    $nisn = $_POST['nisn'];
    $password = $_POST['password'];

    // Query ke database
    $sql = "SELECT nisn, nama_siswa, kd_kelas FROM siswa WHERE nisn = '$nisn' AND password = '$password'";
    $result = mysqli_query($koneksi, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $response = array(
            "status" => "success",
            "message" => "Login berhasil",
            "data" => $row
        );
    } else {
        $response = array(
            "status" => "error",
            "message" => "Login gagal, NISN atau Password salah"
        );
    }
} else {
    $response = array(
        "status" => "error",
        "message" => "NISN dan Password harus disertakan"
    );
}

echo json_encode($response);
mysqli_close($koneksi);

?>
