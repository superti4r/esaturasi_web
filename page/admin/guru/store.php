<?php
session_start();
require_once '../helper/connection.php';

$nik = $_POST['nik'];
$nip = $_POST['nip'];
$nama_guru = $_POST['nama'];
$tempat_lahir = $_POST['tempat_lahir'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$jenkel = $_POST['jenkel'];
$alamat = $_POST['alamat'];
$stat_kepegawaian = $_POST['stat_kepegawaian'];
$no_telpon = $_POST['no_telpon'];
$email = $_POST['email'];
$password = $_POST['password'];

$query = mysqli_query($connection, "insert into guru(nik, nip, nama_guru, tempat_lahir, tanggal_lahir, jenkel_guru, alamat_guru, stat_kepegawaian, no_telpon, email, password) values('$nik', '$nip', '$nama_guru', '$tempat_lahir', '$tanggal_lahir', '$jenkel', '$alamat', '$stat_kepegawaian', '$no_telpon', '$email', '$password')");

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
