<?php
require_once '../helper/config.php';

if (isset($_POST['kirim'])) {
  // Mendapatkan data dari form
  $kd_bab = $_POST['kd_bab']; // Mengambil kd_bab yang tidak perlu ternary
  $nama_bab = $_POST['nama_bab']; // Menambahkan pengambilan data nama_bab

  // Cek apakah nama bab sudah ada
  $cekbab = mysqli_query($koneksi, "SELECT * FROM bab WHERE nama_bab='$nama_bab' AND kd_bab != '$kd_bab'");
  if (mysqli_num_rows($cekbab) > 0) {
      // Jika nama bab sudah ada, tampilkan pesan dan hentikan proses
      echo "<script>alert('Nama bab sudah tersedia. Silakan masukkan nama lain.');</script>";
  } else {
      // Update data bab jika nama bab belum ada
      mysqli_query($koneksi, "UPDATE bab SET nama_bab = '$nama_bab' WHERE kd_bab = '$kd_bab'");
      header("Location:index.php?aksi=suksesedit");
      exit;
  }
}
?>
