<?php
session_start();
require_once '../helper/config.php';

if (isset($_POST['kirim'])) {
    // Ambil NIP dari session
    $nik = $_SESSION['nik'];
    
    // Generate kd_pengumuman
    $today = date('dmY');
    
    // Cek nomor urut terakhir dari database untuk hari ini
    $cek_terakhir = mysqli_query($koneksi, "SELECT kd_pengumuman FROM pengumuman 
                                           WHERE kd_pengumuman LIKE 'P$today%' 
                                           ORDER BY kd_pengumuman DESC LIMIT 1");
    
    if (mysqli_num_rows($cek_terakhir) > 0) {
        $row = mysqli_fetch_array($cek_terakhir);
        $nomor_terakhir = substr($row['kd_pengumuman'], -2);
        $nomor_urut = str_pad((int)$nomor_terakhir + 1, 2, '0', STR_PAD_LEFT);
    } else {
        $nomor_urut = '01';
    }
    
    $kd_pengumuman = 'P' . $today . $nomor_urut;
    
    // Ambil data dari form
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $tgl_pengumuman = $_POST['tgl_pengumuman'];
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    
    // Proses upload file
    $file = $_FILES['file'];
    $nama_file = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_error = $file['error'];
    $file_size = $file['size'];
    
    // Ambil ekstensi file
    $ekstensi_file = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
    
    // Ekstensi yang diizinkan
    $ekstensi_diizinkan = array('jpg', 'jpeg', 'png', 'gif');
    
    // Ukuran maksimal file (5MB)
    $max_size = 5 * 1024 * 1024;
    
    if (in_array($ekstensi_file, $ekstensi_diizinkan)) {
        if ($file_error === 0) {
            if ($file_size <= $max_size) {
                // Buat nama file baru yang unik
                $nama_file_baru = $kd_pengumuman . '.' . $ekstensi_file;
                $lokasi_upload = '../uploads/pengumuman/' . $nama_file_baru;
                
                // Buat direktori jika belum ada
                if (!file_exists('../uploads/pengumuman/')) {
                    mkdir('../uploads/pengumuman/', 0777, true);
                }
                
                if (move_uploaded_file($file_tmp, $lokasi_upload)) {
                    // Simpan data ke database
                    $query = mysqli_query($koneksi, "INSERT INTO pengumuman 
                                                   (kd_pengumuman, judul_pengumuman, tgl_pengumuman, nik, file_pengumuman, deskripsi_pengumuman) 
                                                   VALUES 
                                                   ('$kd_pengumuman', '$judul', '$tgl_pengumuman', '$nik', '$nama_file_baru', '$deskripsi')");
                    
                    if ($query) {
                        // Ambil nama pembuat pengumuman untuk ditampilkan di alert
                        $query_pembuat = mysqli_query($koneksi, "SELECT nama_guru FROM guru WHERE nik='$nik'");
                        $pembuat = mysqli_fetch_assoc($query_pembuat);
                        $nama_pembuat = $pembuat['nama_guru'];
                        
                        echo "<script>
                                alert('Pengumuman berhasil ditambahkan oleh $nama_pembuat!');
                                window.location.href = 'index.php?aksi=suksestambah';
                              </script>";
                    } else {
                        echo "<script>
                                alert('Gagal menyimpan data pengumuman! Error: " . mysqli_error($koneksi) . "');
                                window.history.back();
                              </script>";
                    }
                } else {
                    echo "<script>
                            alert('Gagal mengupload file gambar! Error: " . $_FILES['file']['error'] . "');
                            window.history.back();
                          </script>";
                }
            } else {
                echo "<script>
                        alert('Ukuran file terlalu besar! Maksimal 5MB');
                        window.history.back();
                      </script>";
            }
        } else {
            echo "<script>
                    alert('Terjadi kesalahan saat upload file! Error: " . $_FILES['file']['error'] . "');
                    window.history.back();
                  </script>";
        }
    } else {
        echo "<script>
                alert('Format file tidak diizinkan! Silakan gunakan format: jpg, jpeg, png, atau gif');
                window.history.back();
              </script>";
    }
}
?>
