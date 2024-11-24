<?php
require_once '../layout/_top.php';
require_once '../helper/config.php';
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
                                        <input type="text" class="form-control" id="nik">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="nip">NIP</label>
                                        <input type="text" class="form-control" id="nip">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input type="text" class="form-control" id="nama">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password">
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
                            <img src="../assets/img/default.png" alt="Foto Profil" class="img-fluid rounded-circle mb-3" style="max-width: 150px;" id="foto-preview">
                            <div class="form-group">
                            <label for="foto_profil" class="form-label" style="color: red;">*Ukuran foto adalah 500x500</label>
                                <input type="file" class="form-control mb-2" id="foto_profil">
                            </div>
                            <button type="button" class="btn btn-primary">Unggah Foto</button>
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
