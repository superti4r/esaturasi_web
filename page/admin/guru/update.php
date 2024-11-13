<?php
require_once '../helper/config.php';

// Mendapatkan tanggal saat ini untuk batas maksimum tanggal lahir
$current_date = date("Y-m-d");

if (isset($_POST['kirim'])) {
    // Mendapatkan data dari form
    $nik = $_POST['nik'];
    $nip = $_POST['nip'] ?: '-'; // Jika NIP kosong, set menjadi "-"
    $nama_guru = $_POST['nama_guru'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $email_guru = $_POST['email_guru'];
    $no_telepon_guru = $_POST['no_telepon_guru'];
    $jekel = $_POST['jekel'];
    $alamat = $_POST['alamat'];

    // Mendapatkan data foto profil
    $foto_profil = $_FILES['foto_profil']['name'];
    $tmp_name = $_FILES['foto_profil']['tmp_name'];
    
    // Validasi input
    $errors = [];

    if (!preg_match('/^[0-9]{16}$/', $nik)) {
        $errors[] = "NIK harus terdiri dari 16 angka.";
    }
    if (!empty($nip) && $nip !== '-' && !preg_match('/^[0-9]{18}$/', $nip)) {
        $errors[] = "NIP harus terdiri dari 18 angka atau '-'."; 
    }
    if (!preg_match('/^[a-zA-Z\s]+$/', $nama_guru)) {
        $errors[] = "Nama guru tidak boleh mengandung angka atau simbol.";
    }
    if (!filter_var($email_guru, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email tidak valid.";
    }
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

    // Simpan foto profil jika ada
    $upload_dir = '../uploads/profile';
    $upload_file = ''; // Inisialisasi variabel untuk foto profil

    if (!empty($foto_profil)) {
        // Validasi ekstensi file
        $file_extension = strtolower(pathinfo($foto_profil, PATHINFO_EXTENSION));

        // Cek apakah file benar-benar terupload
        if ($_FILES['foto_profil']['error'] == UPLOAD_ERR_OK) {
            // Cek MIME type
            $file_type = mime_content_type($tmp_name);
            $allowed_extensions = ['jpg', 'jpeg', 'png'];
            $allowed_types = ['image/jpeg', 'image/png'];

            // Gunakan NIK sebagai nama file
            $new_file_name = $nik . '.' . $file_extension; // Menggunakan NIK sebagai nama file
            $upload_file = $upload_dir . '/' . $new_file_name;

            // Validasi ekstensi dan tipe file
            if (in_array($file_extension, $allowed_extensions) && in_array($file_type, $allowed_types)) {
                // Cek ukuran file (maks 2MB)
                if ($_FILES['foto_profil']['size'] < 2 * 1024 * 1024) {
                    // Pindahkan file ke direktori tujuan
                    if (move_uploaded_file($tmp_name, $upload_file)) {
                        // Berhasil upload
                    } else {
                        echo "<script>alert('Gagal mengupload foto profil'); window.history.back();</script>";
                        exit();
                    }
                } else {
                    echo "<script>alert('Ukuran file terlalu besar. Maksimal 2MB.'); window.history.back();</script>";
                    exit();
                }
            } else {
                echo "<script>alert('Hanya file dengan ekstensi JPG, JPEG, atau PNG yang diizinkan'); window.history.back();</script>";
                exit();
            }
        } else {
            echo "<script>alert('Gagal mengupload file.'); window.history.back();</script>";
            exit();
        }
    } else {
        // Jika foto profil tidak diupload, gunakan foto lama
        $upload_file = $_POST['foto_profil_lama']; // Simpan path foto lama ke input tersembunyi di form
    }

    // Update data guru di database
    $sql = "UPDATE guru SET nik='$nik', nama_guru='$nama_guru', tanggal_lahir_guru='$tanggal_lahir', email_guru='$email_guru', jekel_guru='$jekel', no_telepon_guru='$no_telepon_guru', foto_profil_guru='$upload_file', alamat='$alamat'";

    // Jika NIP tidak kosong, tambahkan ke query
    if ($nip !== '-') {
        $sql .= ", nip='$nip'"; // Tambahkan NIP hanya jika tidak "-"
    }

    $sql .= " WHERE nik='$nik'"; // Menggunakan nik untuk identifikasi

    // Eksekusi query
    $sql_query = mysqli_query($koneksi, $sql);

    if ($sql_query) {
        header("Location:./index.php?aksi=suksesedit");
        location.reload();
        exit();
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}

$nik = $_GET['nik'];
$sql = mysqli_query($koneksi, "SELECT * FROM guru WHERE nik='$nik'");
$data = mysqli_fetch_array($sql);

// Mengambil data di database tanggal lahir guru
$tanggal_lahir = isset($data['tanggal_lahir_guru']) ? date('Y-m-d', strtotime($data['tanggal_lahir_guru'])) : '';

$nama = $_SESSION['nama_guru'];
$email = $_SESSION['email_guru'];
$foto = $_SESSION['foto_profil_guru'];
?>
