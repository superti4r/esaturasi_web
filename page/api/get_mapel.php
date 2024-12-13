<?php 
require_once 'config.php';

header('Content-Type: application/json; charset=UTF-8');

$sql = "SELECT nama_mapel, foto_mapel_perkelas FROM vmpp";
$result = mysqli_query($koneksi, $sql);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode([
    "status" => "success",
    "message" => "Data berhasil diambil",
    "data" => $data
]);

mysqli_close($koneksi);
?>
