<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Ubah Data Siswa</h1>
    <a href="./index.php" class="btn btn-light">Kembali</a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- // Form -->
          <form action="./update.php" method="post">
              <input type="hidden" name="nim" value="">
              <table cellpadding="8" class="w-100">
              <tr>
                <td>NIK</td>
                <td><input class="form-control" type="number" name="nik"></td>
              </tr>

              <tr>
                <td>Nama Siswa</td>
                <td><input class="form-control" type="text" name="nama"></td>
              </tr>

              <tr>
                <td>Jenis Kelamin</td>
                <td>
                  <select class="form-control" name="jenkel" id="jenkel" required>
                    <option value="">--Pilih Jenis Kelamin--</option>
                    <option value="Pria">Pria</option>
                    <option value="Wanita">Wanita</option>
                  </select>
                </td>
              </tr>

              <tr>
                <td>Tempat Lahir</td>
                <td><input class="form-control" type="text" name="tempat_lahir" size="20"></td>
              </tr>

              <tr>
                <td>Tanggal Lahir</td>
                <td><input class="form-control" type="date" id="datepicker" name="tanggal_lahir"></td>
              </tr>

              <tr>
                <td>Alamat</td>
                <td><textarea name="alamat" class="form-control"></textarea></td>
              </tr>

              <tr>
                <td>Kelas</td>
                <td>
                  <select class="form-control" name="kelas" id="kelas" required>
                    <option value="">--Pilih Kelas--</option>
                    <option value="Teknik Informatika">X</option>
                    <option value="Sistem Informasi">XI</option>
                    <option value="Sistem Informasi">XII</option>
                  </select>
                </td>
              </tr>

              <tr>
                <td>Foto Siswa</td>
                <td><input class="form-control" type="file" name="foto" accept="image/*" required></td>
              </tr>

              <tr>
                <td>No Telpon</td>
                <td><input class="form-control" type="phone" name="phone"></td>
              </tr>

              <tr>
                <td>Email</td>
                <td><input class="form-control" type="email" name="email"></td>
              </tr>

              <tr>
                <td>Password</td>
                <td><input class="form-control" type="password" name="password"></td>
              </tr>

                <tr>
                  <td>
                    <input class="btn btn-primary d-inline" type="submit" name="proses" value="Ubah">
                    <a href="./index.php" class="btn btn-danger ml-1">Batal</a>
                  <td>
                </tr>
              </table>
          </form>
        </div>
      </div>
    </div>
</section>

<?php
require_once '../layout/_bottom.php';
?>