<?php
include 'config.php';
session_start(); 
$pesan = "";
if (isset($_POST['kirim'])) {
	$role="admin";
    $nik = mysqli_real_escape_string($koneksi, $_POST['nik']);
    $pass = mysqli_real_escape_string($koneksi, $_POST['password']);
    $query = mysqli_query($koneksi, "SELECT * FROM guru WHERE nik='$nik' AND password_guru='$pass' AND role='$role'");
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
        header("location:page/admin/page.php");
    } else {
        header("location:login-admin.php?aksi=eror");
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
	<title>Admin | E-Saturasi</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<link rel="icon" type="image/x-icon" href="assets/favicon.png" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>

<body>
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					<div class="text-center my-5">
						<img src="./assets/img/icon_sekolah.svg" alt="logo" width="100">
					</div>
					<div class="card shadow-lg">
						<div class="card-body p-5">
							<h1 class="fs-4 card-title fw-bold mb-4">Login Admin</h1>
							<form method="POST" class="needs-validation" novalidate="" autocomplete="off">
								<div class="mb-3">
									<label class="mb-2 text-muted" for="email">NIK</label>
									<input id="nik" type="text" class="form-control" name="nik" value="" required>
									<div class="invalid-feedback">
										Email is invalid
									</div>
								</div>

								<div class="mb-3">
	<div class="mb-2 w-100 d-flex align-items-center">
		<label class="text-muted" for="password">Password</label>
	</div>
	<div class="input-group">
		<input id="password" type="password" class="form-control" name="password" required>
		<span class="input-group-text" id="togglePassword" style="cursor: pointer;">
			<i class="fas fa-eye"></i>
		</span>
		<div class="invalid-feedback">
			Password is required
		</div>
	</div>
</div>

								<div class="d-flex align-items-center">
									
									<button type="submit" name="kirim" class="btn btn-primary ms-auto">
										Login
									</button>
								</div>
								 
							</form>
							<br><center>
							<font color="red"><?php echo  $pesan; ?></font>
						</div>
						<div class="card-footer py-3 border-0">
							<div class="text-center">
								Tidak bisa mengakses akun? hubungi admin.
							</div>
						</div>
					</div>
					<div class="text-center mt-5 text-muted">
						made with <3 &copy; &mdash; @projectpintar
					</div>
					<div class="text-center mt-5 text-muted">
					
				</div>
			</div>
		</div>
	</section>

	<script src="js/login.js"></script>
	<script>
		document.getElementById("togglePassword").addEventListener("click", function () {
	const passwordInput = document.getElementById("password");
	const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
	passwordInput.setAttribute("type", type);
	this.querySelector("i").classList.toggle("fa-eye-slash");
});
	</script>
</body>
</html>
