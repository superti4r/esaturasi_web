<?php
session_start();
require_once '../helper/connection.php';

$nisn = $_POST['nisn'];
$nama = $_POST['nama'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$tempat_lahir = $_POST['tempat_lahir'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$alamat = $_POST['alamat'];
$kelas = $_POST['kelas'];
$jurusan = $_POST['jurusan'];
$no_telpon = $_POST['no_telpon'];
$email = $_POST['email'];
$password = $_POST['password'];

$query = mysqli_query($connection, "insert into siswa (nisn, nama, jenis_kelamin, tempat_lahir, tanggal_lahir, alamat, kelas, jurusan, no_telpon, email, password) value('$nisn', '$nama', '$jenis_kelamin', '$tempat_lahir', '$tanggal_lahir', '$alamat', '$kelas', '$jurusan, '$no_telpon', '$email', '$password')");
if ($query) {
  $_SESSION['info'] = [
    'status' => 'success',
    'message' => 'Berhasil menambah data'
  ];
  header('Location: ./index.php');
} else {
  $_SESSION['info'] = [
    'status' => 'failed',
    'message' => mysqli_error($connection)
  ];
  header('Location: ./index.php');
}