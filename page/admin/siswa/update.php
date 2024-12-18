<?php
session_start();
require_once '../helper/config.php';

// Proses update data siswa dan foto
if (isset($_POST['kirim'])) {
    $nisn = $_POST['nisn'];
    $nama_siswa = $_POST['nama_siswa'];
    $tgl_lahir_siswa = $_POST['tgl_lahir_siswa'];
    $email = $_POST['email'];
    $no_telepon_siswa = $_POST['no_telepon_siswa'];
    $jekel_siswa = $_POST['jekel_siswa'];
    $alamat = $_POST['alamat'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tahun_masuk_siswa = $_POST['tahun_masuk_siswa'];
    $kd_kelas = $_POST['kd_kelas'];
    $status_siswa = $_POST['status_siswa'];
    $foto_lama = $_POST['foto_profil_lama']; // Tambahkan ini

    // Validasi input
    $errors = [];

    if (!preg_match('/^[0-9]{10}$/', $nisn)) {
        $errors[] = "NISN harus terdiri dari 10 angka.";
    }

    if (!preg_match('/^[a-zA-Z\s]+$/', $nama_siswa)) {
        $errors[] = "Nama siswa tidak boleh mengandung angka atau simbol.";
    }

    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email tidak valid.";
    }

    if (!preg_match('/^[0-9]{10,13}$/', $no_telepon_siswa)) {
        $errors[] = "No telepon harus terdiri dari 10 hingga 13 angka.";
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: edit.php?nisn=$nisn");
        exit();
    }

    // Update data siswa
    $sql = "UPDATE siswa 
            SET nama_siswa=?, 
                email=?, 
                no_telepon_siswa=?, 
                jekel_siswa=?, 
                tempat_lahir_siswa=?, 
                tgl_lahir_siswa=?, 
                alamat=?, 
                tahun_masuk_siswa=?, 
                status_siswa=?, 
                kd_kelas=? 
            WHERE nisn=?";

    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "sssssssssss", 
        $nama_siswa, $email, $no_telepon_siswa, $jekel_siswa, 
        $tempat_lahir, $tgl_lahir_siswa, $alamat, 
        $tahun_masuk_siswa, $status_siswa, $kd_kelas, $nisn);

    // Proses upload foto
    if (!empty($_FILES['foto_profil']['name'])) {
        $foto_baru = $_FILES['foto_profil'];
        
        // Direktori penyimpanan foto
        $target_dir = "../uploads/profilesiswa/";
        
        // Pastikan direktori ada
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        // Validasi tipe file
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($foto_baru['type'], $allowed_types)) {
            $_SESSION['error'] = "Tipe file tidak diizinkan. Gunakan JPG, JPEG, PNG, atau GIF.";
            header("Location: edit.php?nisn=$nisn");
            exit();
        }

        // Generate nama file unik
        $file_ext = strtolower(pathinfo($foto_baru['name'], PATHINFO_EXTENSION));
        $foto_name = $nisn . '.' . $file_ext;
        $foto_path = $target_dir . $foto_name;

        // Hapus foto lama jika ada
        if (!empty($foto_lama) && file_exists($target_dir . $foto_lama)) {
            unlink($target_dir . $foto_lama);
        }

        // Pindahkan file foto baru
        if (move_uploaded_file($foto_baru['tmp_name'], $foto_path)) {
            // Update nama foto di database
            $update_foto_sql = "UPDATE siswa SET foto_profil_siswa=? WHERE nisn=?";
            $stmt_foto = mysqli_prepare($koneksi, $update_foto_sql);
            mysqli_stmt_bind_param($stmt_foto, "ss", $foto_name, $nisn);
            mysqli_stmt_execute($stmt_foto);
        } else {
            $_SESSION['error'] = "Gagal mengunggah foto.";
            header("Location: edit.php?nisn=$nisn");
            exit();
        }
    }

    // Eksekusi update data siswa
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Data berhasil diperbarui";
        header("Location: index.php?aksi=suksesedit");
        exit();
    } else {
        $_SESSION['error'] = "Gagal memperbarui data: " . mysqli_error($koneksi);
        header("Location: edit.php?nisn=$nisn");
        exit();
    }
}
?>