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

    // Direktori upload
    $upload_dir = '../uploads/profile';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $upload_file = $_POST['foto_profil_lama'] ?? ''; // Gunakan foto lama jika tidak ada upload baru

    if (!empty($foto_profil)) {
        // Validasi ekstensi dan tipe file
        $file_extension = strtolower(pathinfo($foto_profil, PATHINFO_EXTENSION));
        $file_type = mime_content_type($tmp_name);
        $allowed_extensions = ['jpg', 'jpeg', 'png'];
        $allowed_types = ['image/jpeg', 'image/png'];

        if (in_array($file_extension, $allowed_extensions) && in_array($file_type, $allowed_types)) {
            if ($_FILES['foto_profil']['size'] < 2 * 1024 * 1024) { // Maksimal 2MB
                $new_file_name = $nik . '.' . $file_extension; // Format file: NIK.ekstensi
                $upload_file = $upload_dir . '/' . $new_file_name;

                // Hapus file lama jika ada
                $old_files = glob($upload_dir . '/' . $nik . '.*');
                foreach ($old_files as $file) {
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }

                // Pindahkan file baru
                if (!move_uploaded_file($tmp_name, $upload_file)) {
                    echo "<script>alert('Gagal mengupload file. Periksa izin direktori.'); window.history.back();</script>";
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
    }

    // Simpan ke database
    $sql = "UPDATE guru SET 
            nik='$nik', 
            nama_guru='$nama_guru', 
            tanggal_lahir_guru='$tanggal_lahir', 
            email_guru='$email_guru', 
            jekel_guru='$jekel', 
            no_telepon_guru='$no_telepon_guru', 
            foto_profil_guru='$new_file_name', 
            alamat='$alamat'";

    if ($nip !== '-') {
        $sql .= ", nip='$nip'";
    }

    $sql .= " WHERE nik='$nik'";

    $sql_query = mysqli_query($koneksi, $sql);

    if ($sql_query) {
        header("Location: ./index.php?aksi=suksesedit");
        exit();
    } else {
        echo "<script>alert('Gagal memperbarui data: " . mysqli_error($koneksi) . "'); window.history.back();</script>";
        exit();
    }
}

// Mendapatkan data untuk form edit
$nik = $_GET['nik'] ?? '';
$sql = mysqli_query($koneksi, "SELECT * FROM guru WHERE nik='$nik'");
$data = mysqli_fetch_array($sql);

// Mengambil data di database
$tanggal_lahir = isset($data['tanggal_lahir_guru']) ? date('Y-m-d', strtotime($data['tanggal_lahir_guru'])) : '';
$foto_lama = $data['foto_profil_guru'] ?? '';

$nama = $_SESSION['nama_guru'];
$email = $_SESSION['email_guru'];
$foto = $_SESSION['foto_profil_guru'];
?>
