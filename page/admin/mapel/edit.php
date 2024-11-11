<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Ubah Data Mata Pelajaran</h1>
    <a href="./index.php" class="btn btn-light">Kembali</a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- // Form -->
          <form action="./update.php" method="post">
              <input type="hidden" name="kode_mapel" value="">
              <table cellpadding="8" class="w-100">
              <tr>
                  <td>Kode Mata Pelajaran</td>
                  <td><input class="form-control" required value=""></td>
                </tr>
                <tr>
                  <td>Nama Mata Pelajaran</td>
                  <td><input class="form-control" required value=""></td>
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