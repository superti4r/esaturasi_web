<?php
session_start();
require_once '../helper/connection.php';

$kode_jurusan = $_POST['kode_jurusan'];
$nama_jurusan = $_POST['nama_jurusan'];
$id_jurusan = $_POST['id_jurusan'];
$query = mysqli_query($connection, "insert into jurusan (kode_jurusan, nama_jurusan, id_jurusan) value ('$kode_jurusan', '$nama_jurusan', '$id_jurusan')");

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
