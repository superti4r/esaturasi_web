<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$jurusanResult = mysqli_query($connection, "SELECT * FROM jurusan");
$result = mysqli_query($connection, "
    SELECT kelas.ident_kelas, kelas.nama_kelas, kelas.tingkat_kelas, kelas.kode_kelas, jurusan.nama_jurusan 
    FROM kelas 
    INNER JOIN jurusan ON kelas.id_jurusan = jurusan.id_jurusan
");
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Tambah Kelas</h1>
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
                <td>ID Kelas</td>
                <td><input class="form-control" type="text" name="ident_kelas" id="ident_kelas"></td>
              </tr>
              <tr>
                <td>Nama Kelas</td>
                <td><input class="form-control" type="text" name="nama_kelas" id="nama_kelas"></td>
              </tr>
              <tr>
                <td>Kode Kelas</td>
                <td>
                  <select class="form-control" name="kode_kelas" id="kode_kelas" required>
                    <option value="">Pilih Kode Kelas</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Tingkat Kelas</td>
                <td>
                  <select class="form-control" name="tingkat_kelas" id="tingkat_kelas" required>
                    <option value="">Pilih Tingkatan Kelas</option>
                    <option value="1">X</option>
                    <option value="2">XI</option>
                    <option value="3">XII</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Jurusan</td>
                <td>
                <select name="id_jurusan" id="jurusan" class="form-control">
                            <?php while ($jurusan = mysqli_fetch_array($jurusanResult)): ?>
                                <option value="<?= $jurusan['id_jurusan'] ?>"><?= htmlspecialchars($jurusan['nama_jurusan']) ?></option>
                            <?php endwhile; ?>
                        </select>
                </td>
              </tr>
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