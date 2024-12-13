<?php
require_once '../helper/config.php';
session_start();

$nik = $_SESSION['nik'];
$email = $_POST['email'];
$telepon = $_POST['telepon'];
$password = $_POST['password'];

// Query untuk update data
if (!empty($password)) {
    // Hash password sebelum disimpan
    
    $query = "UPDATE guru SET email_guru = '$email', no_telepon_guru = '$telepon', password_guru = '$password' WHERE nik = '$nik'";
} else {
    $query = "UPDATE guru SET email_guru = '$email', no_telepon_guru = '$telepon' WHERE nik = '$nik'";
}

if (mysqli_query($koneksi, $query)) {
    echo "<script>
            alert('Data profil berhasil diperbarui.');
            window.location.href = 'index.php';
          </script>";
} else {
    echo "<script>
            alert('Gagal memperbarui profil: " . mysqli_error($koneksi) . "');
            window.history.back();
          </script>";
}
exit();
?>
