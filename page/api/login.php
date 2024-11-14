<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nisn = isset($_POST['nisn']) ? $_POST['nisn'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($nisn && $password) {
        require_once 'config.php'; // Koneksi ke database

        $query = "SELECT * FROM siswa WHERE nisn = '$nisn'";
        $result = mysqli_query($koneksi, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_assoc($result);

            // Verifikasi password
            if (password_verify($password, $data['password'])) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Login berhasil',
                    'data' => [
                        'nisn' => $data['nisn'],
                        'nama' => $data['nama_siswa']
                    ]
                    
                ]);
                
            } else {
                echo json_encode(['success' => false, 'message' => 'Password salah']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'NISN tidak ditemukan']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Parameter tidak lengkap']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Metode tidak valid']);
}
?>