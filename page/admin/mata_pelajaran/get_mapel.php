<?php
require_once '../helper/config.php';

$katakunci = isset($_POST['kata_kunci']) ? $_POST['kata_kunci'] : "";

$sql = "select nama_mapel from mapel";
$result = mysqli_query($koneksi, $sql);

if ($result) {
    $data = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($data);
} else {

    header('Content-Type: application/json');
    echo json_encode(array("error" => "Terjadi kesalahan: " . mysqli_error($koneksi)));
}
?>
