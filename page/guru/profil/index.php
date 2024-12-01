<?php
require_once '../layout/_top.php';
require_once '../helper/config.php';

$nik = $_SESSION['nik']; 
$sql = mysqli_query($koneksi, "SELECT * FROM guru WHERE nik = '$nik'");
$guru = mysqli_fetch_assoc($sql);
?>

<section class="section">
    <div class="section-header">
        <h1 class="text-center">Profil</h1>
    </div>
    <div class="column">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <h6 class="mb-2 text-primary">Data Profil</h6>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="nik">NIK</label>
                                        <input type="text" class="form-control" id="nik" value="<?= $guru['nik'] ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="nip">NIP</label>
                                        <input type="text" class="form-control" id="nip" value="<?= $guru['nik'] ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input type="text" class="form-control" id="nama" value="<?= $guru['nama_guru'] ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" value="<?= $guru['email_guru'] ?>" required>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="telepon">Telepon</label>
                                        <input type="number" class="form-control" id="telepon" value="<?= $guru['no_telepon_guru'] ?>" required>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password" value="<?= $guru['password_guru'] ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                    <div class="card h-100">
                        <div class="card-body text-center">
                        <img src="../../admin/uploads/profile/<?php echo $data['foto_profil_guru']; ?>" alt="Tidak Ada Foto" width="100" height="100">
                                
                        <form action="upload_foto.php" method="POST" enctype="multipart/form-data">
    <div class="form-group">
    
        <input type="file" class="form-control mb-2 mt-5" id="foto_profil" name="foto_profil">
    </div>
    <button type="submit" class="btn btn-primary mb-2">Unggah Foto</button>
</form>

                       
                            <button type="button" class="btn btn-danger" id="btn-hapus-foto">Hapus Foto</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.getElementById('btn-hapus-foto').addEventListener('click', function () {
        if (confirm('Apakah Anda yakin ingin menghapus foto profil?')) {
            document.getElementById('foto-preview').src = '../assets/img/default.png';
            alert('Foto profil berhasil dihapus.');
        }
    });
</script>

<?php
require_once '../layout/_bottom.php';
?>
