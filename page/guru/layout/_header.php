<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
  <form class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
      <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
      <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
    </ul>
  </form>
  <ul class="navbar-nav navbar-right">
    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
    <?php 
  // Cek apakah ada foto profil yang diset dalam session
  if (!empty($_SESSION['foto_profil_guru']) && file_exists('../../admin/uploads/profile/' . $_SESSION['foto_profil_guru'])):
?>
    <img src="../../admin/uploads/profile/<?php echo $_SESSION['foto_profil_guru']; ?>" alt="image" class="rounded-circle mr-1">
<?php else: ?>
    <!-- Jika tidak ada foto profil, tampilkan gambar default -->
    <img src="../assets/img/avatar/avatar-1.png" alt="image" class="rounded-circle mr-1">
<?php endif; ?>

      <div class="d-sm-none d-lg-inline-block">Hi, <?= $_SESSION['nama_guru'] ?></div>
    </a>
    <div class="dropdown-menu dropdown-menu-right">
    <a href="../profil/index.php" class="dropdown-item has-icon">
        <i class="fas fa-user-alt"></i> Profil
      </a>
      <a href="../logout.php" class="dropdown-item has-icon text-danger">
        <i class="fas fa-sign-out-alt"></i> Logout
      </a>
    </div>
  </li>
  </ul>
</nav>
