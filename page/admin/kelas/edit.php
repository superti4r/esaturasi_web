<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$ident_kelas = $_GET['ident_kelas'];
$query = mysqli_query($connection, "SELECT * FROM kelas WHERE ident_kelas='$ident_kelas'");
$jurusanResult = mysqli_query($connection, "SELECT * FROM jurusan");

?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Ubah Data Kelas</h1>
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
              <input type="hidden" name="id_kelas" value="<?= $row['ident_kelas'] ?>">
              <table cellpadding="8" class="w-100">
                <tr>
                  <td>ID Kelas</td>
                  <td><input class="form-control" required value="<?= $row['ident_kelas'] ?>" disabled></td>
                </tr>
                <tr>
                <td>Tingkat Kelas</td>
                <td>
                <select name="tingkat_kelas" id="tingkat_kelas" class="form-control">
                  <option value="X" <?= $row['tingkat_kelas'] == 'X' ? 'selected' : '' ?>>X</option>
                  <option value="XI" <?= $row['tingkat_kelas'] == 'XI' ? 'selected' : '' ?>>XI</option>
                  <option value="XII" <?= $row['tingkat_kelas'] == 'XII' ? 'selected' : '' ?>>XII</option>
                </td>
              </tr>
              <tr>
                <td>Jurusan</td>
                <td>
                <select name="id_jurusan" id="jurusan" class="form-control">
                <?php while ($jurusan = mysqli_fetch_array($jurusanResult)): ?>
                    <option value="<?= $jurusan['id_jurusan'] ?>" <?= $row['id_jurusan'] == $jurusan['id_jurusan'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($jurusan['nama_jurusan']) ?>
                    </option>
                <?php endwhile; ?>
                </select>
                </td>
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