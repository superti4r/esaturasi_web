<?php
session_start();
require_once '../helper/connection.php';

$kode_jurusan = $_GET['kode_jurusan'];

$result = mysqli_query($connection, "DELETE FROM jurusan WHERE kode_jurusan='$kode_jurusan'");

if (mysqli_affected_rows($connection) > 0) {
  $_SESSION['info'] = [
    'status' => 'success',
    'message' => 'Berhasil menghapus data'
  ];
  header('Location: ./index.php');
} else {
  $_SESSION['info'] = [
    'status' => 'failed',
    'message' => mysqli_error($connection)
  ];
  header('Location: ./index.php');
}
