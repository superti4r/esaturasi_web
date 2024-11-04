<?php
session_start();
require_once '../helper/connection.php';

$nik = $_POST['nik'];
$nip = $_POST['nip'];
$nama_guru = $_POST['nama'];
$tempat_lahir = $POST['tempat_lahir'];
$tanggal_lahir = $POST['tanggal_lahir'];
$jenkel = $_POST['jenkel'];
$alamat = $_POST['alamat'];
$stat_kepegawaian = $_POST['stat_kepegawaian'];
$no_telpon = $_POST['no_telpon'];
$email = $_POST['email'];
$password = $_POST['password'];

$query = mysqli_query($connection, "UPDATE guru SET nama_guru = '$nama_guru', tempat_lahir = '$tempat_lahir', tanggal_lahir = '$tanggal_lahir', jenkel_guru = '$jenkel', alamat_guru = '$alamat', stat_kepegawaian = '$stat_kepegawaian', no_telpon = '$no_telpon', email = '$email', WHERE nik = '$nik'");
if ($query) {
  $_SESSION['info'] = [
    'status' => 'success',
    'message' => 'Berhasil mengubah data'
  ];
  header('Location: ./index.php');
} else {
  $_SESSION['info'] = [
    'status' => 'failed',
    'message' => mysqli_error($connection)
  ];
  header('Location: ./index.php');
}
