<?php
include 'helper/config.php';
session_start(); 
$pesan = "";

if (isset($_POST['submit'])) {
    $nik = mysqli_real_escape_string($koneksi, $_POST['nik']);
    $pass = mysqli_real_escape_string($koneksi, $_POST['password']);
    $query = mysqli_query($koneksi, "SELECT * FROM vadmin WHERE nik='$nik' AND password_guru='$pass'");
    if (!$query) {
        die("Query Error: " . mysqli_error($koneksi)); 
    }
    $row = mysqli_num_rows($query);
    if ($row > 0) {
        $data = mysqli_fetch_array($query);

        $_SESSION['nik'] = $data['nik'];
        $_SESSION['email_guru'] = $data['email_guru'];
        $_SESSION['nama_guru'] = $data['nama_guru'];
		$_SESSION['foto_profil_guru'] = $data['foto_profil_guru'];
        header("location:dashboard/index.php");
    } else {
        header("location:login.php?aksi=eror");
    }
}
if (isset($_GET['aksi'])) {
  $aksi = $_GET['aksi'];
  if ($aksi == 'eror') {
      $pesan = "Username atau Password yang Anda masukkan salah.";
  } elseif ($aksi == 'belum') {
      $pesan = "Anda belum login.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="description" content="This is a login page template based on Bootstrap 5">
	<title>Guru | E-Saturasi</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<link rel="icon" type="image/x-icon" href="assets/favicon.png" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Login &mdash; E-Saturasi</title>
  <link rel="icon" type="image/x-icon" href="../../assets/favicon.png" />
  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="assets/modules/bootstrap-social/bootstrap-social.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="./assets/esaturasi.png" alt="logo" width="300">
            </div>

            <div class="card card-primary">
              <div class="card-header">
                <h4>Login Admin</h4>
              </div>

              <div class="card-body">
                <form method="POST" action="" class="needs-validation" novalidate="">
                  <div class="form-group">
                  <label for="nik">NIK</label>
                  <input id="nik" type="text" class="form-control" name="nik" tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                    Mohon isi NIK
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Password</label>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    <div class="invalid-feedback">
                      Mohon isi kata sandi
                    </div>
                  </div>

                 
                  <div class="form-group">
                    <button name="submit" type="submit" class="btn btn-primary btn-lg btn-block" tabindex="3">
                      Login
                    </button>
                  </div>
                </form>
                <br><center>
							<font color="red"><?php echo  $pesan; ?></font>
</div>
              </div>
            </div>
            <div class="simple-footer">
              Copyright &copy; Project Pintar 2023
            </div>
          </div>
        </divW
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="assets/js/stisla.js"></script>

  <!-- JS Libraies -->

  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>

  <!-- Page Specific JS File -->
</body>

</html>