<?php
session_start();
require_once '../helper/config.php';

if (isset($_POST['proses'])) {
    $kd_tahun_ajaran = $_POST['kd_tahun_ajaran'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $status = $_POST['status'];

    // Validasi Tanggal
    if (strtotime($tanggal_mulai) >= strtotime($tanggal_selesai)) {
        echo "<script>
                alert('Tanggal Mulai harus lebih kecil dari Tanggal Selesai!');
                window.history.back();
              </script>";
        exit();
    }

    // Jika status diubah menjadi Aktif, nonaktifkan status lainnya
    if ($status === "aktif") {
        // Nonaktifkan status lainnya
        $resetStatus = mysqli_query($koneksi, "UPDATE tahun_ajaran SET status='nonaktif' WHERE status='aktif'");
        
        if (!$resetStatus) {
            echo "<script>
                    alert('Gagal mengubah status lainnya menjadi Tidak Aktif.');
                    window.history.back();
                  </script>";
            exit();
        }
    }

    // Update data di database
    $query = mysqli_query($koneksi, 
        "UPDATE tahun_ajaran 
        SET tanggal_mulai='$tanggal_mulai', tanggal_selesai='$tanggal_selesai', status='$status' 
        WHERE kd_tahun_ajaran='$kd_tahun_ajaran'"
    );

    if ($query) {
        // Redirect setelah berhasil update
        header("Location: index.php?aksi=suksesedit");
    } else {
        // Tampilkan pesan jika gagal update
        echo "<script>
                alert('Gagal mengedit data. Silakan coba lagi.');
                window.history.back();
              </script>";
    }
}
?>
