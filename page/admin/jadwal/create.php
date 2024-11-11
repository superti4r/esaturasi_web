<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Tambah Jadwal</h1>
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
                <td>Kode Jadwal</td>
                <td><input class="form-control" type="text" name="kode_jadwal" size="20" required></td>
              </tr>

              <tr>
                <td>Hari</td>
                <td>
                  <select class="form-control" name="hari" id="hari" required>
                    <option value="">--Pilih Hari--</option>
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>
                    <option value="Sabtu">Sabtu</option>
                  </select>
                </td>
              </tr>

              <tr>
                <td>Nama Guru</td>
                <td>
                  <select class="form-control" name="nama_guru" id="nama_guru" required>
                    <option value="">--Pilih Guru--</option>
                    <option value="Admin">Contoh 1</option>
                    <option value="Guru">Contoh 2</option>
                  </select>
                </td>
              </tr>

              <tr>
                <td>Nama Kelas</td>
                <td>
                  <select class="form-control" name="nama_kelas" id="nama_kelas" required>
                    <option value="">--Pilih Kelas--</option>
                    <option value="X">X</option>
                    <option value="XI">XI</option>
                    <option value="XII">XII</option>
                  </select>
                </td>
              </tr>

              <tr>
                <td>Mata Pelajaran</td>
                <td>
                  <select class="form-control" name="mapel" id="mapel" required>
                    <option value="">--Pilih Mata Pelajaran--</option>
                    <option value="Admin">Contoh 1</option>
                    <option value="Guru">Contoh 2</option>
                  </select>
                </td>
              </tr>

              <tr>
                <td>Dari Jam</td>
                <td><input class="form-control" type="time" name="darijam" size="20" required></td>
              </tr>

              <tr>
                <td>Sampai Jam</td>
                <td><input class="form-control" type="time" name="sampaijam" size="20" required></td>
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