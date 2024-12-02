<?php
require_once '../helper/config.php';
require_once '../vendor/autoload.php'; // Sesuaikan path autoload


// Menggunakan PhpSpreadsheet untuk membaca file Excel
require __DIR__ . '/../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

// Memproses upload data dari file Excel
if (isset($_POST['upload'])) {
    if ($_FILES['file_excel']['name']) {
        $file = $_FILES['file_excel']['tmp_name'];
        
        // Membaca file Excel
        $spreadsheet = IOFactory::load($file);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        // Loop melalui setiap baris dan simpan ke database
        foreach ($sheetData as $row) {
            // Pastikan $row tidak null dan memiliki kolom yang diharapkan
            if (is_array($row) && isset($row['A'])) {
                // Misalkan kolom di Excel adalah: NISN, Nama, Tanggal Lahir, Tempat Lahir, Jenis Kelamin, Email, No Telepon, Tahun Masuk, Kelas, Alamat
                $nisn = $row['A']; // Sesuaikan dengan kolom di Excel
                $nama_siswa = $row['B'];
                $tgl_lahir = $row['G'];
                $tempat_lahir = $row['F'];
                $jekel_siswa = strtolower($row['E']); // Mendapatkan nilai jenis kelamin dari Excel

// Menentukan nilai yang akan disimpan di database
if ($jekel_siswa == 'laki-laki') {
    $jekel_siswa = 'l';
} elseif ($jekel_siswa == 'perempuan') {
    $jekel_siswa = 'p';
} else {
    // Jika tidak ditemukan jenis kelamin yang sesuai, bisa di-set default atau diabaikan
    $jekel_siswa = null;
}
                $email = $row['C'];
                $no_telepon_siswa = $row['D'];
                $tahun_masuk_siswa = $row['I'];
                $nama_kelas = $row['J']; // Pastikan kolom ini berisi nama kelas
                $alamat = $row['H'];

                // Mencari kd_kelas berdasarkan nama_kelas
                $query_kelas = mysqli_query($koneksi, "SELECT kd_kelas FROM kelas WHERE nama_kelas='$nama_kelas'");
                $kelas_data = mysqli_fetch_assoc($query_kelas);

                // Jika kelas ditemukan, simpan kd_kelas
                $kd_kelas = $kelas_data ? $kelas_data['kd_kelas'] : null;

                // Cek jika kd_kelas null
                if (!$kd_kelas) {
                    error_log("Kelas tidak ditemukan untuk nama_kelas: $nama_kelas");
                    continue; // Lewati iterasi ini jika kelas tidak ditemukan
                }

                $password = "saturasi123";
                $foto_profil_siswa = "";
                $status_siswa = "Aktif";

                // Cek apakah NISN sudah terdaftar
                $ceknisn = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nisn='$nisn'");
                if (mysqli_num_rows($ceknisn) == 0) {
                    // Menyimpan data ke tabel siswa
                    $sql = "INSERT INTO siswa (nisn, nama_siswa, email, no_telepon_siswa, jekel_siswa, tempat_lahir_siswa, tgl_lahir_siswa, alamat, tahun_masuk_siswa, status_siswa, kd_kelas, password, foto_profil_siswa) VALUES ('$nisn', '$nama_siswa', '$email', '$no_telepon_siswa', '$jekel_siswa', '$tempat_lahir', '$tgl_lahir', '$alamat', '$tahun_masuk_siswa', '$status_siswa', '$kd_kelas', '$password', '$foto_profil_siswa')";

                    // Eksekusi query
                    if (!mysqli_query($koneksi, $sql)) {
                        error_log("Error saving student with NISN: $nisn. Error: " . mysqli_error($koneksi));
                    }
                }
            }
        }
        header("Location: index.php?aksi=suksestambah");
        exit();
    } else {
        echo "<script>alert('Silakan pilih file Excel untuk diupload.');</script>";
    }
}
?>
