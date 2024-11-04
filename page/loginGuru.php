<?php
require_once 'helper/connection.php';
session_start();
if (isset($_POST['submit'])) {
  $nik = $_POST['nik'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM guru WHERE nik='$nik' and password='$password' LIMIT 1";
  $result = mysqli_query($connection, $sql);

  $row = mysqli_fetch_assoc($result);
  if ($row) {
    $_SESSION['login'] = $row;
    header('Location: index.php');
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
							<h1 class="fs-4 card-title fw-bold mb-4">Login Guru</h1>
							<form method="POST" class="needs-validation" novalidate="" autocomplete="off">
								<div class="mb-3">
									<label class="mb-2 text-muted" for="nik">NIK</label>
									<input id="nik" type="text" class="form-control" name="nik" value="" required>
									<div class="invalid-feedback">
										NIK Salah!
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
