<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$nik = $_GET['nik'];
$query = mysqli_query($connection, "SELECT * FROM guru WHERE nik='$nik'");
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
            <?php
            while ($row = mysqli_fetch_array($query)) {
            ?>
              <input type="hidden" name="nik" value="<?= $row['nik'] ?>">
              <table cellpadding="8" class="w-100">
                <tr>
                  <td>NIK</td>
                  <td><input class="form-control" type="number" name="nik" size="20" required value="<?= $row['nik'] ?>" disabled></td>
                </tr>
                <tr>
                  <td>NIP</td>
                  <td><input class="form-control" type="number" name="nip" size="20" required value="<?= $row['nip'] ?>" disabled></td>
                </tr>
                <tr>
                  <td>Nama Guru</td>
                  <td><input class="form-control" type="text" name="nama" size="20" required value="<?= $row['nama_guru'] ?>"></td>
                </tr>
                  <tr>
                  <td>Tempat Lahir</td>
                  <td><input class="form-control" type="text" name="tempat_lahir" size="20" required value="<?= $row['tempat_lahir'] ?>"></td>
                </tr>
                <tr>
                  <td>Tanggal Lahir</td>
                  <td><input class="form-control" type="date" id="datepicker" name="tanggal_lahir" required value="<?= $row['tanggal_lahir'] ?>"></td>
                </tr>
                <tr>
                  <td>Jenis Kelamin</td>
                  <td>
                    <select class="form-control" name="jenkel" id="jenkel" required>
                      <option value="Pria" <?php if ($row['jenkel_guru'] == "Pria") {
                                              echo "selected";
                                            } ?>>Pria</option>
                      <option value="Wanita" <?php if ($row['jenkel_guru'] == "Wanita") {
                                                echo "selected";
                                              } ?>>Wanita</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>Alamat</td>
                  <td colspan="3"><textarea class="form-control" name="alamat" id="alamat" required><?= $row['alamat_guru'] ?></textarea></td>
                </tr>
                <tr>
                  <td>Status Kepegawaian</td>
                  <td>
                    <select class="form-control" name="stat_kepegawaian" id="stat_kepegawaian" required>
                      <option value="PNS" <?php if ($row['stat_kepegawaian'] == "PNS") {
                                              echo "selected";
                                            } ?>>Pegawai Negeri Sipil</option>
                      <option value="Honorer" <?php if ($row['stat_kepegawaian'] == "Honorer") {
                                                echo "selected";
                                              } ?>>Honorer</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>No Telpon</td>
                  <td><input class="form-control" type="phone" name="no_telpon" size="20" required value="<?= $row['no_telpon'] ?>"></td>
                </tr>
                <tr>
                  <td>Email</td>
                  <td><input class="form-control" type="email" name="email" size="20" required value="<?= $row['email'] ?>"></td>
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