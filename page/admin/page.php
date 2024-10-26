<?php 
include '../../config.php';
session_start();
if (!isset($_SESSION['nik'])) {
  header('location:index.php?aksi=belum');

}
$nama=$_SESSION['nama_guru'];
$email=$_SESSION['email_guru'];
$foto=$_SESSION['foto_profil_guru'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Admin | E-Saturasi</title>
        <link rel="icon" type="image/x-icon" href="./images/icon.png" />
    <link rel="stylesheet" href="./assets/css/dashlite.css?ver=3.2.2">
    <link id="skin-default" rel="stylesheet" href="./assets/css/theme.css?ver=3.2.2">
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
                                </li>
                                <li class="nk-menu-heading">
                                    <h6 class="overline-title text-primary-alt">Fitur</h6>
                                </li>
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-users-fill"></em></span>
                                        <span class="nk-menu-text">Manajemen User</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="guru.php" class="nk-menu-link"><span class="nk-menu-text">Guru</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="../admin/siswa.php" class="nk-menu-link"><span class="nk-menu-text">Siswa</span></a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-grid-alt-fill"></em></span>
                                        <span class="nk-menu-text">Pengaturan</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="../admin/jurusan.php" class="nk-menu-link"><span class="nk-menu-text">Data Jurusan</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="../admin/kelas.php" class="nk-menu-link"><span class="nk-menu-text">Data Kelas</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="../admin/mata_pelajaran.php" class="nk-menu-link"><span class="nk-menu-text">Data Mata Pelajaran</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="../admin/jadwal.php" class="nk-menu-link"><span class="nk-menu-text">Data Jadwal</span></a>
                                    </li>
                                </ul>
                            </li>
                         </div>
                    </div>
                </div>
            </div>
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
                                <em class="icon ni ni-search"></em>
                                <input type="text" class="form-control border-transparent form-focus-none" placeholder="Cari...">
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
                <!-- main header @e -->
                <!-- content @s -->
                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    
    <!-- JavaScript -->
    <script src="./assets/js/bundle.js?ver=3.2.2"></script>
    <script src="./assets/js/scripts.js?ver=3.2.2"></script>
</body>

</html>