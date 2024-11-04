<?php
session_start();
require_once '../helper/connection.php';

$ident_kelas = $_POST['ident_kelas'];
$kode_kelas = $_POST['kode_kelas'];
$tingkat_kelas = $_POST['tingkat_kelas'];
$id_jurusan = $_POST['id_jurusan'];
$query = mysqli_query($connection, "INSERT INTO kelas (ident_kelas, kode_kelas, tingkat_kelas, id_jurusan) VALUES ('$ident_kelas', '$kode_kelas', '$tingkat_kelas', '$id_jurusan')");

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
