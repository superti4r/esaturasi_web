<?php
include '../../config.php';
session_start();
if (!isset($_SESSION['nik'])) {
  header('location:index.php?aksi=belum');
}

function generateKodeJadwal($koneksi, $kd_kelas) {
    // Ambil kode jurusan dari kd_kelas, misalnya "RPL" dari "RPL1"
    $kode_jurusan = substr($kd_kelas, 0, 3); // Ambil 3 karakter pertama
    $kode_kelas = substr($kd_kelas, 3); // Ambil sisa dari kd_kelas

    // Mengambil nomor urut terakhir
    $query_last = mysqli_query($koneksi, "SELECT kd_jadwal FROM jadwal WHERE kd_jadwal LIKE '$kode_jurusan$kode_kelas%' ORDER BY kd_jadwal DESC LIMIT 1");
    $last_jadwal = mysqli_fetch_array($query_last);

    if ($last_jadwal) {
        // Mengambil nomor urut terakhir dari kode jadwal yang diambil
        $last_kode = substr($last_jadwal['kd_jadwal'], -2); // Ambil 4 karakter terakhir
        $nomor_urut = (int)$last_kode + 1; // Increment nomor urut
    } else {
        $nomor_urut = 1; // Jika belum ada jadwal, mulai dari 1
    }

    // Format kode jadwal menjadi XRPL1001
    $kode_jadwal = $kode_jurusan . $kode_kelas . sprintf("%02s", $nomor_urut); // Format nomor urut menjadi 4 digit

    return $kode_jadwal;
}

// Proses ketika tombol kirim ditekan
if (isset($_POST['kirim'])) {
    $kd_mapel = $_POST['kd_mapel'];
    $hari = $_POST['hari'];
    $waktu_mulai = $_POST['waktu_mulai'];
    $waktu_selesai = $_POST['waktu_selesai'];
    $kd_kelas = $_POST['kd_kelas'];
    $nik = $_POST['nik'];

    // Cek apakah waktu mulai lebih dari jam 17:00
    if ($waktu_mulai > '17:00') {
        echo "<script>alert('Waktu mulai tidak boleh lebih dari jam 17:00.'); window.history.back();</script>";
        exit;
    }
    
    // Cek apakah waktu selesai lebih dari jam 18:00
    if ($waktu_selesai > '18:00') {
        echo "<script>alert('Waktu selesai tidak boleh lebih dari jam 18:00.'); window.history.back();</script>";
        exit;
    }

    // Cek apakah waktu mulai lebih besar atau sama dengan waktu selesai
    if ($waktu_selesai <= $waktu_mulai) {
        echo "<script>alert('Waktu selesai tidak boleh lebih kecil atau sama dengan waktu mulai.'); window.history.back();</script>";
        exit;
    }

    // Cek apakah ada jadwal yang sama pada hari dan jam yang sama untuk kelas yang sama
    $query_check = "
        SELECT * FROM jadwal 
        WHERE hari = '$hari' 
        AND kd_kelas = '$kd_kelas' 
        AND (
            (dari_jam < '$waktu_selesai' AND sampai_jam > '$waktu_mulai')
        )";
    $result_check = mysqli_query($koneksi, $query_check);
    
    if (mysqli_num_rows($result_check) > 0) {
        echo "<script>alert('Jam yang dipilih sudah ada di jadwal untuk kelas ini. Silakan pilih waktu lain.'); window.history.back();</script>";
        exit;
    }

    // Generate kode jadwal otomatis
    $kd_jadwal = generateKodeJadwal($koneksi, $kd_kelas); // Pastikan fungsi ini sudah ada

    // Query untuk menyimpan data jadwal
    $query_insert = "INSERT INTO jadwal (kd_jadwal, kd_mapel, hari, dari_jam, sampai_jam, kd_kelas, nik) VALUES ('$kd_jadwal', '$kd_mapel', '$hari', '$waktu_mulai', '$waktu_selesai', '$kd_kelas', '$nik')";

    if (mysqli_query($koneksi, $query_insert)) {
        echo "<script>alert('Data berhasil disimpan.'); window.location.href='jadwal.php';</script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Guru | E-Saturasi</title>
        <link rel="icon" type="image/x-icon" href="./images/icon.png" />

    <!-- StyleSheets  -->
    <link rel="stylesheet" href="./assets/css/dashlite.css?ver=3.2.2">
    <link id="skin-default" rel="stylesheet" href="./assets/css/theme.css?ver=3.2.2">
     <!-- Datepicker -->
     <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- jQuery, DataTables JS, and Buttons plugin -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body class="nk-body bg-lighter npc-default has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            <div class="nk-sidebar nk-sidebar-fixed is-light " data-content="sidebarMenu">
                <div class="nk-sidebar-element nk-sidebar-head">
                    <div class="nk-sidebar-brand">
                        <a href="html/index.html" class="logo-link nk-sidebar-logo">
                            <img class="logo-light logo-img" src="./images/logo.png" srcset="./images/logo2x.png 2x" alt="logo">
                            <img class="logo-dark logo-img" src="./images/logo-dark.png" srcset="./images/logo-dark2x.png 2x" alt="logo-dark">
                            <img class="logo-small logo-img logo-img-small" src="./images/logo-small.png" srcset="./images/logo-small2x.png 2x" alt="logo-small">
                        </a>
                    </div>
                    <div class="nk-menu-trigger me-n2">
                        <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
                        <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                    </div>
                </div><!-- .nk-sidebar-element -->
                <div class="nk-sidebar-element">
                    <div class="nk-sidebar-content">
                        <div class="nk-sidebar-menu" data-simplebar>
                            <ul class="nk-menu">
                            <li class="nk-menu-heading">
                                    <h6 class="overline-title text-primary-alt">Dashboard</h6>
                                </li><!-- .nk-menu-item -->
                                <li class="nk-menu-item">
                                    <a href="./home.php" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-home"></em></span>
                                        <span class="nk-menu-text">Beranda</span>
                                    </a>
                                </li>
                                </li>
                                <li class="nk-menu-heading">
                                    <h6 class="overline-title text-primary-alt">Master</h6>
                                </li>
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-users-fill"></em></span>
                                        <span class="nk-menu-text">Manajemen User</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="./guru.php" class="nk-menu-link"><span class="nk-menu-text">Guru</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="./siswa.php" class="nk-menu-link"><span class="nk-menu-text">Siswa</span></a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-grid-alt-fill"></em></span>
                                        <span class="nk-menu-text">Data</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="./jurusan.php" class="nk-menu-link"><span class="nk-menu-text">Data Jurusan</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="./kelas.php" class="nk-menu-link"><span class="nk-menu-text">Data Kelas</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="./mata_pelajaran.php" class="nk-menu-link"><span class="nk-menu-text">Data Mata Pelajaran</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="./jadwal.php" class="nk-menu-link"><span class="nk-menu-text">Data Jadwal</span></a>
                                    </li>
                                </ul>
                                <li class="nk-menu-heading">
                                    <h6 class="overline-title text-primary-alt">Session</h6>
                                </li><!-- .nk-menu-item -->
                                <li class="nk-menu-item">
                                    <a href="./logout.php" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-signout"></em></span>
                                        <span class="nk-menu-text">Log Out</span>
                                    </a>
                                </li>
                            </li>
                         </div>
                    </div>
                </div>
            </div>
            <!-- sidebar @e -->
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                <div class="nk-header nk-header-fixed is-light mb-5">
                    <div class="container-fluid ">
                        <div class="nk-header-wrap">
                            <div class="nk-menu-trigger d-xl-none ms-n1">
                                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                            </div>
                            <div class="nk-header-brand d-xl-none">
                                <a href="html/index.html" class="logo-link">
                                    <img class="logo-light logo-img" src="./images/logo.png" srcset="./images/logo2x.png 2x" alt="logo">
                                    <img class="logo-dark logo-img" src="./images/logo-dark.png" srcset="./images/logo-dark2x.png 2x" alt="logo-dark">
                                </a>
                            </div><!-- .nk-header-brand -->
                        </div><!-- .nk-header-wrap -->
                    </div><!-- .container-fliud -->
                </div>
                <!-- main header @e -->
                <!-- content @s -->
                <div class="container mt-5">
    <h3 class="text-center mt-3 mb-3">Tambah Jadwal</h3>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalFormLabel">Tambah Jadwal</h5>
        </div>
        <div class="modal-body">
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="row g-gs">
            <!-- Hapus bagian kode jadwal -->
            <div class="col-md-6" style="display: none;">
                <div class="form-group">
                    <label class="form-label">Kode Jadwal</label>
                    <input type="text" class="form-control" name="kd_jadwal" value="<?= $kd_jadwal; ?>" readonly>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Nama Mata Pelajaran</label>
                    <select class="form-control" name="kd_mapel" required>
                        <option value="" disabled selected>Pilih Mata Pelajaran</option>
                        <?php
                        $query_mapel = mysqli_query($koneksi, "SELECT * FROM mapel");
                        while ($data_mapel = mysqli_fetch_array($query_mapel)) {
                            echo "<option value='{$data_mapel['kd_mapel']}'>{$data_mapel['nama_mapel']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Hari</label>
                    <select class="form-control" name="hari" required>
                        <option value="" disabled selected>Pilih Hari</option>
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Waktu Mulai</label>
                    <input type="time" class="form-control" name="waktu_mulai" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Waktu Selesai</label>
                    <input type="time" class="form-control" name="waktu_selesai" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Kelas</label>
                    <select class="form-control" name="kd_kelas" required>
                        <option value="" disabled selected>Pilih Kelas</option>
                        <?php
                        $query_kelas = mysqli_query($koneksi, "SELECT * FROM kelas");
                        while ($data_kelas = mysqli_fetch_array($query_kelas)) {
                            echo "<option value='{$data_kelas['kd_kelas']}'>{$data_kelas['nama_kelas']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Nama Guru</label>
                    <select class="form-control" name="nik" required>
                        <option value="" disabled selected>Pilih Nama Guru</option>
                        <?php
                        $query_guru = mysqli_query($koneksi, "SELECT * FROM guru");
                        while ($data_guru = mysqli_fetch_array($query_guru)) {
                            echo "<option value='{$data_guru['nik']}'>{$data_guru['nama_guru']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <button type="submit" name="kirim" class="btn btn-primary">Simpan Data</button>
                    <button type="button" name="batal" class="btn btn-danger" onclick="window.location.href='jadwal.php'">Batal</button>
                </div>
            </div>
        </div>
    </form>
</div>
</div>




<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.0/js/dataTables.bootstrap5.min.js"></script>
<!-- DataTables Responsive JS -->
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>
<!-- DataTables Buttons JS -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    <!-- JavaScript -->
    <script src="./assets/js/bundle.js?ver=3.2.2"></script>
    <script src="./assets/js/scripts.js?ver=3.2.2"></script>
</body>

</html>
