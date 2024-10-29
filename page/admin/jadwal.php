<?php 
include '../../config.php';
session_start();
if (!isset($_SESSION['nik'])) {
  header('location:index.php?aksi=belum');
}
//digunakan untuk mencari data dan menampilkan data siswa
$katakunci = "";
if (isset($_POST['cari'])) {
    $katakunci = $_POST['kata_kunci'];
    $sql = mysqli_query($koneksi, "
        SELECT jadwal.*, mapel.nama_mapel, guru.nama_guru, kelas.nama_kelas 
        FROM jadwal
        LEFT JOIN mapel ON jadwal.kd_mapel = mapel.kd_mapel
        LEFT JOIN guru ON jadwal.nik = guru.nik
        LEFT JOIN kelas ON jadwal.kd_kelas = kelas.kd_kelas
        WHERE jadwal.kd_jadwal LIKE '%".$katakunci."%' 
        OR mapel.nama_mapel LIKE '%".$katakunci."%' 
        OR jadwal.hari LIKE '%".$katakunci."%' 
        OR jadwal.dari_jam LIKE '%".$katakunci."%' 
        OR jadwal.sampai_jam LIKE '%".$katakunci."%' 
        OR kelas.nama_kelas LIKE '%".$katakunci."%' 
        OR guru.nama_guru LIKE '%".$katakunci."%'
        ORDER BY jadwal.kd_jadwal ASC");
} else {
    $sql = mysqli_query($koneksi, "
        SELECT jadwal.*, mapel.nama_mapel, guru.nama_guru, kelas.nama_kelas 
        FROM jadwal
        LEFT JOIN mapel ON jadwal.kd_mapel = mapel.kd_mapel
        LEFT JOIN guru ON jadwal.nik = guru.nik
        LEFT JOIN kelas ON jadwal.kd_kelas = kelas.kd_kelas
        ORDER BY jadwal.kd_jadwal ASC");
}

// Cek apakah query berhasil
if ($sql) {
    $row = mysqli_num_rows($sql);
} else {
    echo "Error: " . mysqli_error($koneksi); 
}

if ($sql) {
    $row = mysqli_num_rows($sql);
} else {
    echo "Error: " . mysqli_error($koneksi); 
}


if (isset($_POST['delete_selected'])) {
    if (!empty($_POST['selected_ids'])) {
        $ids_to_delete = implode(",", $_POST['selected_ids']);
        mysqli_query($koneksi, "DELETE FROM siswa WHERE nisn IN ($ids_to_delete)");
        header("Location:siswa.php?aksi=hapusok");
    } else {
        echo "<script>alert('Pilih minimal satu data untuk dihapus.');</script>";
    }
}

//untuk menampilkan pesan berhasil menambah data siswa
if (isset($_GET['aksi'])) {
  $aksi=$_GET['aksi'];
  if ($aksi=="suksestambah") {
    echo "
    <script>
    alert('selamat data anda berhasil ditambahkan');
    </script>
    ";
  }
} 

//untuk menampilkan pesan berhasil edit data siswa
if (isset($_GET['aksi'])) {
  $aksi=$_GET['aksi'];
  if ($aksi=="suksesedit") {
    echo "
    <script>
    alert('selamat data anda berhasil diubah');
    </script>
    ";

//untuk menampilkan pesan berhasil menghapus data siswa
  }elseif ($aksi=="hapusok") {
    echo "
    <script>
    alert('selamat data anda berhasil hapus');
    </script>
    ";
  }

}

//perintah untuk hapus data yang dipilih
if (isset($_GET['pesan'])) {
  $nisn = $_GET['nisn'];
  mysqli_query($koneksi, "DELETE FROM siswa WHERE nisn='$nisn'");
  header("Location:siswa.php?aksi=hapusok");
}

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

    <style>
    /*biar gambar lingkaran*/
    .foto-profil {
        width: 100px; 
        height: 35px; 
        border-radius: 50%; 
        object-fit: cover;
        border: 0px solid #ddd;
    }

  
    table {
        width: 100%;
        border-collapse: collapse; 
    }

    th, td {
        padding: 20px;
        text-align: left; 
        border: 1px solid #ddd; 
    }

    th {
        background-color: #f2f2f2; 
    }
</style>
<!-- jarak button hapus semua -->
<style>
    /* Memberi jarak antara tabel dan tombol hapus */
    #dataTable {
        margin-bottom: 20px; /* Jarak bawah tabel */
    }
    .btn-delete-selected {
        margin-top: 10px; /* Jarak atas tombol */
        margin-bottom: 20px;
    }
</style>
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
    
            <div class="nk-wrap ">
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
    <h3 class="text-center mt-5 mb-4">Data Siswa</h3>
    <div class="d-flex justify-content-between align-items-center mt-4 mb-1">
        <a href="tambah_jadwal.php">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalForm">Tambah Data</button>
        </a>
     

        <!-- Form Pencarian -->
        <form class="form-inline ms-1" action="siswa.php" method="POST">
            <div class="input-group input-group-sm">
                <input type="text" name="kata_kunci" class="form-control" placeholder="Cari" aria-label="Cari">
                <button type="submit" class="btn btn-primary icon ni ni-search" name="cari">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>
    <form method="POST" action="siswa.php">
  <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
    <table>
    <thead>
        <tr>
            <th><input type="checkbox" id="select_all"> Pilih Semua</th>
            <th>Kode Jadwal</th>
            <th>Mata Pelajaran</th>
            <th>Hari</th>
            <th>Dari Jam</th>
            <th>Sampai Jam</th>
            <th>Kelas</th>
            <th>Pengajar</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Asumsikan $sql adalah hasil query untuk mengambil data jadwal
        $row = mysqli_num_rows($sql); // Jumlah baris hasil query
        for ($i = 0; $i < $row; $i++) {
            $data = mysqli_fetch_array($sql);
        ?>
        <tr>
            <td><input type="checkbox" name="selected_ids[]" value="<?php echo $data['kd_jadwal']; ?>"></td>
            <td><?php echo $data['kd_jadwal']; ?></td>
            <td><?php echo $data['nama_mapel']; ?></td> <!-- Ubah sesuai dengan nama mata pelajaran -->
            <td><?php echo $data['hari']; ?></td>
            <td><?php echo $data['dari_jam']; ?></td>
            <td><?php echo $data['sampai_jam']; ?></td>
            <td><?php echo $data['nama_kelas']; ?></td> <!-- Ubah sesuai dengan nama kelas -->
            <td><?php echo $data['nama_guru']; ?></td> <!-- NIK pengajar -->
            <td>
                <a href="edit_jadwal.php?kd_jadwal=<?php echo $data['kd_jadwal']; ?>">
                    <button type="button" class="btn btn-warning btn-sm mb-1">Edit</button>
                </a>
                <a href="jadwal.php?kd_jadwal=<?php echo $data['kd_jadwal']; ?>&pesan=hapus" onClick="return confirm('Apakah data yang anda pilih akan dihapus?')">
                    <button type="button" class="btn btn-danger btn-sm">Delete</button>
                </a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
        </table>
    <button type="submit" name="delete_selected" onClick="return confirm('Apakah data yang dipilih akan dihapus?')" class="btn btn-danger btn-delete-selected">Hapus yang Dipilih</button>
</form>

<script>
document.getElementById('select_all').onclick = function() {
    var checkboxes = document.querySelectorAll('input[name="selected_ids[]"]');
    for (var checkbox of checkboxes) {
        checkbox.checked = this.checked;
    }
}
</script>

  </table>
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
    <script src="./assets/js/bundle.js?ver=3.2.2"></script>
    <script src="./assets/js/scripts.js?ver=3.2.2"></script>
</body>

</html>