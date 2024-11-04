<?php
session_start();
require_once '../helper/connection.php';

$id_kelas = $_POST['id_kelas'];
$ident_kelas = $_POST['ident_kelas'];
$kode_kelas = $_POST['kode_kelas'];
$tingkat_kelas = $_POST['tingkat_kelas'];
$id_jurusan = $_POST['id_jurusan'];

$query = mysqli_query($connection, "UPDATE kelas SET kode_kelas = '$kode_kelas', ident_kelas = '$ident_kelas', tingkat_kelas = '$tingkat_kelas', id_jurusan = '$id_jurusan' WHERE id_kelas = '$id_kelas'");
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
