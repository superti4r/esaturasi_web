<?php
include '../../config.php';
session_start();

// Mendapatkan tanggal hari ini
$current_date = date('Y-m-d');

// Menggunakan PhpSpreadsheet untuk membaca file Excel
require __DIR__ . '/../../vendor/autoload.php';
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
                $jekel_siswa = $row['E'];
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

                $password = $nisn;
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
        header("Location: siswa.php?aksi=suksestambah");
        exit();
    } else {
        echo "<script>alert('Silakan pilih file Excel untuk diupload.');</script>";
    }
}


// Proses tambah data siswa
if (isset($_POST['kirim'])) {
    $nisn = $_POST['nisn'];
    $nama_siswa = $_POST['nama_siswa'];
    $tgl_lahir_siswa = $_POST['tgl_lahir_siswa'];
    $email = $_POST['email'];
    $no_telepon_siswa = $_POST['no_telepon_siswa'];
    $jekel_siswa = $_POST['jekel_siswa'];
    $alamat = $_POST['alamat'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tahun_masuk_siswa = $_POST['tahun_masuk_siswa'];
    $password = $nisn;
    $kd_kelas = $_POST['kd_kelas'];
    $foto_profil_siswa = "";
    $status_siswa = "Aktif";

    // Validasi input
    $errors = [];

    if (!preg_match('/^[0-9]{10}$/', $nisn)) {
        $errors[] = "NISN harus terdiri dari 10 angka.";
    }

    if (!preg_match('/^[a-zA-Z\s]+$/', $nama_siswa)) {
        $errors[] = "Nama siswa tidak boleh mengandung angka atau simbol.";
    }

    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email tidak valid.";
    }
    

    if (!preg_match('/^[0-9]{10,13}$/', $no_telepon_siswa)) {
        $errors[] = "No telepon harus terdiri dari 10 hingga 13 angka.";
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<script>alert('$error');</script>";
        }
        echo "<script>window.history.back();</script>";
        exit();
    }

    // Cek apakah NISN sudah terdaftar
    $ceknisn = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nisn='$nisn'");
    if (mysqli_num_rows($ceknisn) > 0) {
        echo "<script>alert('NISN sudah terdaftar. Mohon masukkan NISN yang berbeda.'); window.history.back();</script>";
        exit();
    }

    // Menyimpan data ke tabel siswa
    $sql = "INSERT INTO siswa (nisn, nama_siswa, email, no_telepon_siswa, jekel_siswa, tempat_lahir_siswa, tgl_lahir_siswa, alamat, tahun_masuk_siswa, status_siswa, kd_kelas, password, foto_profil_siswa) VALUES ('$nisn', '$nama_siswa', '$email', '$no_telepon_siswa', '$jekel_siswa', '$tempat_lahir', '$tgl_lahir_siswa', '$alamat', '$tahun_masuk_siswa', '$status_siswa', '$kd_kelas', '$password', '$foto_profil_siswa')";

    // Eksekusi query
    if (mysqli_query($koneksi, $sql)) {
        header("Location: siswa.php?aksi=suksestambah");
        exit();
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}

// Mengambil data guru untuk ditampilkan di halaman
$sql = mysqli_query($koneksi, "SELECT * FROM guru ORDER BY nik DESC");
$nama = $_SESSION['nama_guru'];
$email = $_SESSION['email_guru'];
$foto = $_SESSION['foto_profil_guru'];
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
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                               
                         </div>
                    </div>
                </div>
            </div>
            <!-- sidebar @e -->
            <!-- wrap @s -->
            <div class="nk-wrap mb-5">
                <!-- main header @s -->
                <div class="nk-header nk-header-fixed is-light">
                    <div class="container-fluid">
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
                            <div class="nk-header-search ms-3 ms-xl-0">
                               
                            </div>
                            <div class="nk-header-tools">
                                    <li class="dropdown user-dropdown">
                                        <a href="#" class="dropdown-toggle me-n1" data-bs-toggle="dropdown">
                                            <div class="user-toggle">
                                            <div class="user-avatar">
                                                    <?php if (!empty($foto)): ?>
                                                        <img src="<?php echo $foto ?>" alt="User Avatar" style="width: 40px; height: 40px; border-radius: 50%;">
                                                    <?php else: ?>
                                                        <span>#</span> <!-- Placeholder jika tidak ada foto -->
                                                    <?php endif; ?>
                                                </div>
                                                <div class="user-info d-none d-xl-block">
                                                    <div class="user-name dropdown-indicator"><?php echo $_SESSION['nama_guru']?></div>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-end">
                                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                                <div class="user-card">
                                                <div class="user-avatar">
                                                    <?php if (!empty($foto)): ?>
                                                        <img src="<?php echo $foto ?>" alt="User Avatar" style="width: 40px; height: 40px; border-radius: 50%;">
                                                    <?php else: ?>
                                                        <span>#</span> <!-- Placeholder jika tidak ada foto -->
                                                    <?php endif; ?>
                                                </div>
                                                    <div class="user-info">
                                                        <span class="lead-text"><?php echo $_SESSION['nama_guru']?></span>
                                                        <span class="sub-text"><?php echo $_SESSION['email_guru']?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    <li><a class="dark-switch" href="#"><em class="icon ni ni-moon"></em><span>Mode Gelap</span></a></li>
                                                </ul>
                                            </div>
                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    <li><a href="logout.php"><em class="icon ni ni-signout"></em><span>Keluar</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div><!-- .nk-header-wrap -->
                    </div><!-- .container-fliud -->
                </div>
                <div class="container mt-5">
    <h3 class="text-center mt-5 mb-4" >Halaman Tambah Siswa</h3>
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalFormLabel">Tambah Siswa</h5>
     
      </div>
      <div class="modal-body">
      <form action="" method="POST" enctype="multipart/form-data">
                                                <div class="row g-gs">
                                                <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Nisn</label>
                                                            <input type="text" class="form-control" name="nisn" placeholder="10 Digit" required>
                                                        </div>
                                                    </div>
                                                <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Nama Lengkap</label>
                                                            <input type="text" class="form-control" name="nama_siswa" placeholder="Tidak Boleh Mengandung Angka/Simbo/Angka" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                                        <input type="date" class="form-control" name="tgl_lahir_siswa" id="tanggal_lahir_siswa"  max="<?= $current_date ?>" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Tempat Lahir</label>
                                                            <input type="text" class="form-control" name="tempat_lahir"  placeholder="Contoh : Probolinggo">
                                                        </div>
                                                    </div>            
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Jenis Kelamin</label>
                                                            <select class="form-control" name="jekel_siswa" required>
                                                                <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                                                <option value="l">Laki-laki</option>
                                                                <option value="p">Perempuan</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Email</label>
                                                            <input type="email" class="form-control" name="email" placeholder="Sesuaikan dengan Penulisan Email (person@gmail.com)">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">No Telepon</label>
                                                            <input type="text" class="form-control" name="no_telepon_siswa" placeholder="Tidak Boleh Mengandung Angka dan Min 10 Max 13">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                    <div class="form-group">
                                                            <label class="form-label">Tahun Masuk</label>
                                                            <select class="form-control" name="tahun_masuk_siswa" required>
                                                                <option value="" disabled selected>Pilih Tahun Masuk</option>
                                                                <?php
                                                                    $tahunSekarang = date("Y");
                                                                    for ($i = $tahunSekarang - 4; $i < $tahunSekarang + 1; $i++) {
                                                                        echo "<option value=\"$i\">$i</option>";
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                    <div class="form-group">
    <label class="form-label">Kelas</label>
    <select class="form-control" name="kd_kelas" required>
        <option value="" disabled selected>Pilih Kelas</option>
        <?php
            $queryKelas = mysqli_query($koneksi, "SELECT kd_kelas, nama_kelas FROM kelas ORDER BY nama_kelas ASC");
            while ($kelas = mysqli_fetch_assoc($queryKelas)) {
                echo "<option value=\"{$kelas['kd_kelas']}\">{$kelas['nama_kelas']}</option>";
            }
        ?>
    </select>
</div>

                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Alamat</label>
                                                            <textarea class="form-control" name="alamat" placeholder="Jln.Brawijaya Kec.Probolinggo" required></textarea>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- password otomatis -->
                                                     <!-- foto profil dikosongkan otomatis -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <button type="submit" name="kirim" class="btn btn-primary">Simpan Data</button>
                                                            <button type="button" name="batal" class="btn btn-danger" onclick="window.location.href='siswa.php'">Batal</button>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </form>
                                        </div>

<script>
  // Mengubah tampilan passwsord
  const togglePasswordButton = document.getElementById('togglePassword');
  const passwordInput = document.getElementById('password');
  const eyeIcon = document.getElementById('eyeIcon');

  togglePasswordButton.addEventListener('click', function () {
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    
    // Ganti ikon berdasarkan status
    eyeIcon.classList.toggle('fa-eye');
    eyeIcon.classList.toggle('fa-eye-slash');
  });
</script>




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
