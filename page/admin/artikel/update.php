<?php
require_once '../helper/config.php';
if (isset($_POST['kirim'])) {
  $kd_pengumuman = $_POST['kd_pengumuman'];
  $judul = $_POST['judul'];
  $nik = $_POST['nik'];
  $tgl_pengumuman = $_POST['tgl_pengumuman'];
  $deskripsi = $_POST['deskripsi'];

  // Simpan nama file lama
  $file_lama = $_POST['file_pengumuman'];

  // Cek apakah file baru diupload
$file = $_FILES['file'];
if ($file['name'] != '') {
  // Jika ada file baru
  $nama_file = $file['name'];
  $file_tmp = $file['tmp_name'];
  $file_error = $file['error'];
  $file_size = $file['size'];
  $ekstensi_file = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
  $ekstensi_diizinkan = array('jpg', 'jpeg', 'png', 'gif');
  $max_size = 5 * 1024 * 1024;

  if (in_array($ekstensi_file, $ekstensi_diizinkan)) {
      if ($file_error === 0) {
          if ($file_size <= $max_size) {
              $nama_file_baru = $kd_pengumuman . '.' . $ekstensi_file;
              $lokasi_upload = '../uploads/pengumuman/' . $nama_file_baru;

              if (!file_exists('../uploads/pengumuman/')) {
                  mkdir('../uploads/pengumuman/', 0777, true);
              }

              // Pindahkan file yang diupload
              move_uploaded_file($file_tmp, $lokasi_upload);

              // Update data pengumuman dengan file baru
              $file_pengumuman = $nama_file_baru;
          } else {
              echo "<script>alert('Ukuran file terlalu besar! Maksimal 5MB'); window.history.back();</script>";
              exit;
          }
      } else {
          echo "<script>alert('Terjadi kesalahan saat upload file!'); window.history.back();</script>";
          exit;
      }
  } else {
      echo "<script>alert('Format file tidak diizinkan! Silakan gunakan format: jpg, jpeg, png, atau gif'); window.history.back();</script>";
      exit;
  }
} else {
  // Jika tidak ada file baru, gunakan file lama
  $file_pengumuman = $_POST['file_lama'];
}

// Update data pengumuman
$update_query = "UPDATE pengumuman SET 
  judul_pengumuman = '$judul',
  tgl_pengumuman = '$tgl_pengumuman',
  deskripsi_pengumuman = '$deskripsi',
  file_pengumuman = '$file_pengumuman'  -- Gunakan $file_pengumuman yang sudah diupdate
  WHERE kd_pengumuman = '$kd_pengumuman' AND nik = '$nik'";

if (mysqli_query($koneksi, $update_query)) {
  header("Location: index.php?aksi=suksesedit");
  exit;
} else {
  echo "Error: " . mysqli_error($koneksi);
}
}

?>

