<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$prodi = mysqli_query($connection, "SELECT * FROM siswa");
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Tambah Siswa</h1>
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
                <td>NISN</td>
                <td><input class="form-control" type="number" name="nisn"></td>
              </tr>
              <tr>
                <td>Nama Siswa</td>
                <td><input class="form-control" type="text" name="nama"></td>
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
                <td>Tempat Lahir</td>
                <td><input class="form-control" type="text" name="kota_lahir" size="20"></td>
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
                    <option value="">Pilih Kelas</option>
                    <option value="10">X</option>
                    <option value="11">XI</option>
                    <option value="12">XII</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Jurusan</td>
                <td>
                  <select class="form-control" name="jurusan" id="jurusan" required>
                    <option value="">Pilih Jurusan</option>
                    <option value="1">Teknik Komputer & Jaringan</option>
                    <option value="2">Teknik Kendaraan Ringan</option>
                    <option value="3">Akuntansi</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>No Telpon</td>
                <td><input class="form-control" type="phone" name="no_telpon"></td>
              </tr>
              <tr>
                <td>Email</td>
                <td><input class="form-control" type="email" name="email"></td>
              </tr>
              <tr>
                <td>Password</td>
                <td><input class="form-control" type="text" name="password"></td>
              </tr>
              <tr>
                <td>
                  <input class="btn btn-primary" type="submit" name="proses" value="Simpan">
                  <input class="btn btn-danger" type="reset" name="batal" value="Bersihkan">
                </td>
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