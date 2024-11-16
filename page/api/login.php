<?php
// Menambahkan header CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Koneksi ke database
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari request
    $nisn = isset($_POST['nisn']) ? $_POST['nisn'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Memeriksa apakah nisn dan password sudah diinput
    if ($nisn && $password) {
        // Query untuk mengambil data siswa berdasarkan NISN
        $query = "SELECT * FROM siswa WHERE nisn = '$nisn'";
        $result = mysqli_query($koneksi, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_assoc($result);

            // Verifikasi password menggunakan password_verify()
            if (password_verify($password, $data['password'])) {
                // Jika password benar, kirimkan response sukses
                echo json_encode([
                    'success' => true,
                    'message' => 'Login berhasil',
                    'data' => [
                        'nisn' => $data['nisn'],
                        'nama' => $data['nama_siswa']
                    ]
                ]);
            } else {
                // Jika password salah
                echo json_encode(['success' => false, 'message' => 'Password salah']);
            }
        } else {
            // Jika NISN tidak ditemukan
            echo json_encode(['success' => false, 'message' => 'NISN tidak ditemukan']);
        }
    } else {
        // Jika parameter tidak lengkap
        echo json_encode(['success' => false, 'message' => 'Parameter tidak lengkap']);
    }
} else {
    // Jika metode request tidak valid
    echo json_encode(['success' => false, 'message' => 'Metode tidak valid']);
}
?>
