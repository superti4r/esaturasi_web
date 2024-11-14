<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';


?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Ubah Materi</h1>
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
                <td>Kode Materi</td>
                <td><input class="form-control" type="number" name="kode_materi"></td>
              </tr>
              <tr>
                <td>Nama Materi</td>
                <td><input class="form-control" type="text" name="nama_materi"></td>
              </tr>
              <tr>
                <td>Kelas</td>
                <td>
                  <select class="form-control" name="kelas" id="kelas" required>
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
                  <select class="form-control" name="mata_pelajaran" id="mata_pelajaran" required>
                    <option value="">--Pilih Mata Pelajaran--</option>
                    <option value="1">Contoh Mapel_ambil dari DB</option>
                    <option value="1">Contoh Mapel_ambil dari DB</option>
                    <option value="1">Contoh Mapel_ambil dari DB</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Bab</td>
                <td><input class="form-control" type="number" id="bab" name="bab"></td>
              </tr>
              <tr>
                <td>File</td>
                <td><input type="file" name="file" class="form-control" accept="application/pdf, image/jpeg, image/png"></td>
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