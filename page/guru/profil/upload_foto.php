<?php
session_start();
require_once '../helper/config.php';

$nik = $_SESSION['nik'];

// Periksa apakah file sudah diunggah
if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] == UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['foto_profil']['tmp_name'];
    $fileName = $_FILES['foto_profil']['name'];
    $fileSize = $_FILES['foto_profil']['size'];
    $fileType = $_FILES['foto_profil']['type'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Validasi ekstensi file
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($fileExtension, $allowedExtensions)) {
        echo "<script>alert('Hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan!'); window.history.back();</script>";
        exit();
    }

    // Validasi ukuran file (maksimal 2MB)
    if ($fileSize > 2 * 1024 * 1024) {
        echo "<script>alert('Ukuran file tidak boleh lebih dari 2MB!'); window.history.back();</script>";
        exit();
    }

    // Lokasi folder penyimpanan
    $uploadFolder = '../../admin/uploads/profile/';
    $newFileName = $nik . '.' . $fileExtension; // Gunakan NIK sebagai nama file
    $destinationPath = $uploadFolder . $newFileName;

    // Pindahkan file ke folder tujuan
    if (move_uploaded_file($fileTmpPath, $destinationPath)) {
        // Update nama file di database
        $sql = "UPDATE guru SET foto_profil_guru = '$newFileName' WHERE nik = '$nik'";
        if (mysqli_query($koneksi, $sql)) {
            echo "<script>alert('Foto profil berhasil diunggah!'); window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui database!'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Gagal mengunggah file!'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Tidak ada file yang diunggah!'); window.history.back();</script>";
}
?>
