<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$kode_jurusan = $_GET['kode_jurusan'];
$query = mysqli_query($connection, "SELECT * FROM jurusan WHERE kode_jurusan='$kode_jurusan'");
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Ubah Data Jurusan</h1>
    <a href="./index.php" class="btn btn-light">Kembali</a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- // Form -->
          <form action="./update.php" method="post">
            <?php
            while ($row = mysqli_fetch_array($query)) {
            ?>
              <input type="hidden" name="id_jurusan" value="<?= $row['id_jurusan'] ?>">
              <table cellpadding="8" class="w-100">
                <tr>
                  <td>ID Jurusan</td>
                  <td><input class="form-control" required value="<?= $row['id_jurusan'] ?>" disabled></td>
                </tr>
                <tr>
                  <td>Nama Jurusan</td>
                  <td><input class="form-control" type="text" name="nama_jurusan" required value="<?= $row['nama_jurusan'] ?>"></td>
                </tr>
                <tr>
                  <td>Kode Jurusan</td>
                  <td><input class="form-control" type="text" name="id_jurusan" required value="<?= $row['kode_jurusan'] ?>"></td>
                </tr>
                <tr>
                  <td>
                    <input class="btn btn-primary d-inline" type="submit" name="proses" value="Ubah">
                    <a href="./index.php" class="btn btn-danger ml-1">Batal</a>
                  <td>
                </tr>
              </table>

            <?php } ?>
          </form>
        </div>
      </div>
    </div>
</section>

<?php
require_once '../layout/_bottom.php';
?>