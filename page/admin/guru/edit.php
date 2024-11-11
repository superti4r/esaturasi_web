<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Ubah Data Guru</h1>
    <a href="./index.php" class="btn btn-light">Kembali</a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- // Form -->
          <form action="./update.php" method="post">
              <input type="hidden" name="nisn" value="">
              <table cellpadding="8" class="w-100">
                <tr>
                  <td>NISN</td>
                  <td><input class="form-control" type="number" name="nisn" size="20" required value="" disabled></td>
                </tr>

                <tr>
                  <td>NIP</td>
                  <td><input class="form-control" type="number" name="nisn" size="20" required value="" disabled></td>
                </tr>

                <tr>
                <td>Nama Guru</td>
                <td><input class="form-control" type="text" name="nama" size="20" required></td>
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
                <td>Hak Akses</td>
                <td>
                  <select class="form-control" name="role" id="role" required>
                    <option value="">--Pilih Hak Akses--</option>
                    <option value="Admin">Admin</option>
                    <option value="Guru">Guru</option>
                  </select>
                </td>
              </tr>

              <tr>
                <td>Foto Guru</td>
                <td><input class="form-control" type="file" name="foto" accept="image/*" required></td>
              </tr>

              <tr>
                <td>Alamat</td>
                <td colspan="3"><textarea class="form-control" name="alamat" id="alamat" required></textarea></td>
              </tr>

              <tr>
                <td>No Telpon</td>
                <td><input class="form-control" type="phone" name="phone" size="20" required></td>
              </tr>

              <tr>
                <td>Email</td>
                <td><input class="form-control" type="email" name="email" size="20" required></td>
              </tr>

              <tr>
                <td>Password</td>
                <td><input class="form-control" type="password" name="password" size="20" required></td>
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