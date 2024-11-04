<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

// Ambil ID siswa dari parameter URL
$id_siswa = $_GET['id'];

// Ambil data siswa berdasarkan ID
$query_siswa = "SELECT * FROM siswa WHERE id_siswa = '$id_siswa'";
$result_siswa = $koneksi->query($query_siswa);
$data_siswa = $result_siswa->fetch_assoc();

// Ambil data Kelas
$query_kelas = "SELECT * FROM kelas";
$result_kelas = $koneksi->query($query_kelas);

// Ambil data Jurusan
$query_jurusan = "SELECT * FROM jurusan";
$result_jurusan = $koneksi->query($query_jurusan);


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
            <?php
            while ($row = mysqli_fetch_array($query)) {
            ?>
              <input type="hidden" name="nisn" value="<?= $row['nisn'] ?>">
              <table cellpadding="8" class="w-100">
                <tr>
                  <td>NISN</td>
                  <td><input class="form-control" required value="<?= $row['nisn'] ?>" disabled></td>
                </tr>
                <tr>
                  <td>Nama Siswa</td>
                  <td><input class="form-control" type="text" name="nama" required value="<?= $row['nama'] ?>"></td>
                </tr>
                <tr>
                  <td>Jenis Kelamin</td>
                  <td>
                    <select class="form-control" name="jenkel" id="jenkel" required>
                      <option value="Pria" <?php if ($row['jenis_kelamin'] == "Pria") {
                                              echo "selected";
                                            } ?>>Pria</option>
                      <option value="Wanita" <?php if ($row['jenis_kelamin'] == "Wanita") {
                                                echo "selected";
                                              } ?>>Wanita</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>Tempat Lahir</td>
                  <td><input class="form-control" type="text" name="tempat_lahir" required value="<?= $row['tempat_lahir'] ?>"></td>
                </tr>
                <tr>
                  <td>Tanggal Lahir</td>
                  <td><input class="form-control" type="date" name="tanggal_lahir" required value="<?= $row['tanggal_lahir'] ?>"></td>
                </tr>
                <tr>
                  <td>Alamat</td>
                  <td colspan="3"><textarea class="form-control" name="alamat" id="alamat" required><?= $row['alamat'] ?></textarea></td>
                </tr>
                <tr>
                  <td>Kelas</td>
                  <td><input class="form-control" type="text" name="tempat_lahir" required value="<?= $row['kelas'] ?>"></td>
                </tr>
                <tr>
                  <td>Jurusan</td>
                  <td>
                    <select class="form-control" name="tahun_masuk" id="tahun_masuk" required>
                      <?php
                      for ($x = 2015; $x <= 2021; $x++) {
                      ?>
                        <option value=<?= $x ?> <?php if ($row['tahun_masuk'] == $x) {
                                                  echo "selected";
                                                } ?>><?= $x ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>No Telpon</td>
                  <td><input class="form-control" type="phone" name="nomor_telpon" required value="<?= $row['kota_kelahiran'] ?>"></td>
                </tr>
                <tr>
                  <td>Email</td>
                  <td><input class="form-control" type="email" name="email" required value="<?= $row['kota_kelahiran'] ?>"></td>
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