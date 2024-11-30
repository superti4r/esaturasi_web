<?php
session_start();
require_once '../helper/config.php';

// Proses tambah data guru dengan mengambil data dari hasil inputan
if (isset($_POST['proses'])) {
    // Ambil data dari form
    $nik = $_POST['nik'];
    $nip = $_POST['nip'];
    $nama_guru = $_POST['nama'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $email_guru = $_POST['email'];
    $no_telepon_guru = $_POST['phone'];
    $jekel = $_POST['jenkel'];
    $alamat = $_POST['alamat'];
    // Password otomatis
    $password = 'saturasi123';
    $foto_profil = $_FILES['foto']['name'];
    $tmp_name = $_FILES['foto']['tmp_name'];

    // Mengvalidasi setiap inputan
    $errors = [];

    // Validasi NIK
    if (!preg_match('/^[0-9]{16}$/', $nik)) {
        $errors[] = "NIK harus terdiri dari 16 angka.";
    }
    
    // Validasi NIP, hanya jika diisi
    if (!empty($nip) && !preg_match('/^[0-9]{18}$/', $nip)) {
        $errors[] = "NIP harus terdiri dari 18 angka.";
    }
    
    // Validasi Nama Guru
    if (!preg_match('/^[a-zA-Z\s]+$/', $nama_guru)) {
        $errors[] = "Nama guru tidak boleh mengandung angka atau simbol.";
    }
    
    // Validasi Email
    if (!filter_var($email_guru, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email tidak valid.";
    }
    
    // Validasi No Telepon
    if (!preg_match('/^[0-9]{10,13}$/', $no_telepon_guru)) {
        $errors[] = "No telepon harus terdiri dari 10 hingga 13 angka.";
    }
    
    // Jika terdapat error, tampilkan pesan kesalahan
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<script>alert('$error');</script>";
        }
        echo "<script>window.history.back();</script>";
        exit();
    }

    // Cek apakah NIK sudah terdaftar
    $cek_nik = mysqli_query($koneksi, "SELECT * FROM guru WHERE nik='$nik'");
    if (mysqli_num_rows($cek_nik) > 0) {
        echo "<script>alert('NIK sudah terdaftar. Mohon masukkan NIK yang berbeda.'); window.history.back();</script>";
        exit();
    }

    // Cek apakah NIP sudah terdaftar
    $cek_nip = mysqli_query($koneksi, "SELECT * FROM guru WHERE nip='$nip'");
    if (mysqli_num_rows($cek_nip) > 0) {
        echo "<script>alert('NIP sudah terdaftar. Mohon masukkan NIP yang berbeda.'); window.history.back();</script>";
        exit();
    }

    // Menentukan lokasi folder upload
    $upload_dir = '../uploads/profile/';
    if (!is_dir($upload_dir)) {
        // Jika folder belum ada, buat folder baru
        mkdir($upload_dir, 0777, true);
    }

    // Mengatur nama file sesuai dengan NIK
    $file_extension = strtolower(pathinfo($foto_profil, PATHINFO_EXTENSION));
    $file_type = mime_content_type($tmp_name);
    $allowed_extensions = ['jpg', 'jpeg', 'png'];
    $allowed_types = ['image/jpeg', 'image/png'];
    $new_file_name = $nik . '.' . $file_extension; // Nama file sesuai format NIK
    $upload_file = $upload_dir . $new_file_name;

    // Validasi dan proses upload gambar
    if (in_array($file_extension, $allowed_extensions) && in_array($file_type, $allowed_types)) {
        if ($_FILES['foto']['size'] < 2 * 1024 * 1024) { // Maks 2MB
            if (move_uploaded_file($tmp_name, $upload_file)) {
                // Simpan data guru ke database dengan nama file saja
                $sql = mysqli_query($koneksi, "INSERT INTO guru (nik, nip, nama_guru, tanggal_lahir_guru, email_guru, jekel_guru, no_telepon_guru, foto_profil_guru, alamat, password_guru) VALUES ('$nik', '$nip', '$nama_guru', '$tanggal_lahir', '$email_guru', '$jekel', '$no_telepon_guru', '$new_file_name', '$alamat', '$password')");

                if ($sql) {
                    header("Location:./index.php?aksi=suksestambah");
                    exit();
                } else {
                    echo "Error: " . mysqli_error($koneksi);
                }
            } else {
                echo "<script>alert('Gagal mengupload foto profil'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Ukuran file terlalu besar. Maksimal 2MB.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Hanya file dengan ekstensi JPG, JPEG, atau PNG yang diizinkan'); window.history.back();</script>";
    }
}
?>
