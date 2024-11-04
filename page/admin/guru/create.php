<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Tambah Guru</h1>
    <a href="./index.php" class="btn btn-light">Kembali</a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- // Form -->
          <form action="./store.php" method="POST">
            <table cellpadding="8" class="w-100">

              <tr>
                <td>NIK</td>
                <td><input class="form-control" type="number" name="nik" size="20" required></td>
              </tr>

              <tr>
                <td>NIP</td>
                <td><input class="form-control" type="number" name="nip" size="20" required></td>
              </tr>

              <tr>
                <td>Nama Guru</td>
                <td><input class="form-control" type="text" name="nama" size="20" required></td>
              </tr>

              <tr>
                <td>Tempat Lahir</td>
                <td><input class="form-control" type="text" name="tempat_lahir" size="20" required></td>
              </tr>

              <tr>
                <td>Tanggal Lahir</td>
                <td><input class="form-control" type="date" id="datepicker" name="tanggal_lahir"></td>
              </tr>

              <tr>
                <td>Jenis Kelamin</td>
                <td>
                  <select class="form-control" name="jenkel" id="jenkel" required>
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="Pria">Pria</option>
                    <option value="Wanita">Wanita</option>
                  </select>
                </td>
              </tr>

              <tr>
                <td>Alamat</td>
                <td colspan="3"><textarea class="form-control" name="alamat" id="alamat" required></textarea></td>
              </tr>

              <tr>
                <td>Status Kepegawaian</td>
                <td>
                  <select class="form-control" name="stat_kepegawaian" id="stat_kepegawaian" required>
                    <option value="">Pilih Status Kepegawaian</option>
                    <option value="PNS">Pegawai Negeri Sipil</option>
                    <option value="Honorer">Honorer</option>
                  </select>
                </td>
              </tr>

              <tr>
                <td>Nomor Telepon</td>
                <td><input class="form-control" type="phone" name="no_telpon" size="20" required></td>
              </tr>

              <tr>
                <td>Email</td>
                <td><input class="form-control" type="email" name="email" size="20" required></td>
              </tr>

              <tr>
                <td>Password</td>
                <td><input class="form-control" type="text" name="password" size="20" required></td>
              </tr>
              
              <tr>
                <td>
                  <input class="btn btn-primary" type="submit" name="proses" value="Simpan">
                  <input class="btn btn-danger" type="reset" name="batal" value="Bersihkan"></td>
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