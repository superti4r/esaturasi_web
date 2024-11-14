<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';


?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Laporan Ujian</h1>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h6>Cetak Laporan Ujian</h6>
          <table cellpadding="8" class="w-100">
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
                <td>Nama Ujian</td>
                <td>
                  <select class="form-control" name="jenis_tugas" id="jenis_tugas" required>
                    <option value="">--Pilih Nama Ujian--</option>
                    <option value="#">nama ujian ambil dari DB</option>
                    <option value="#">nama ujian ambil dari DB</option>
                    <option value="#">nama ujian ambil dari DB</option>
                    <option value="#">nama ujian ambil dari DB</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Jenis Ujian</td>
                <td>
                  <select class="form-control" name="jenis_tugas" id="jenis_tugas" required>
                    <option value="">--Pilih Jenis Ujian--</option>
                    <option value="#">jenis ujian ambil dari DB</option>
                    <option value="#">jenis ujian ambil dari DB</option>
                    <option value="#">jenis ujian ambil dari DB</option>
                    <option value="#">jenis ujian ambil dari DB</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>
                  <input class="btn btn-primary" type="submit" name="printReport" value="Cetak">
                  <input class="btn btn-danger" type="reset" name="batal" value="Bersihkan">
                </td>
              </tr>
        </table>
        </div>
      </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover table-striped w-100" id="table-1">
              <thead>
                <tr class="text-center">
                  <th>Nama Siswa</th>
                  <th>Judul Ujian</th>
                  <th>Jenis Ujian</th>
                  <th>Nilai</th>
                </tr>
              </thead>
              <tbody>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
</section>

<?php
require_once '../layout/_bottom.php';
?>
<!-- Page Specific JS File -->
<?php
if (isset($_SESSION['info'])) :
  if ($_SESSION['info']['status'] == 'success') {
?>
    <script>
      iziToast.success({
        title: 'Sukses',
        message: `<?= $_SESSION['info']['message'] ?>`,
        position: 'topCenter',
        timeout: 5000
      });
    </script>
  <?php
  } else {
  ?>
    <script>
      iziToast.error({
        title: 'Gagal',
        message: `<?= $_SESSION['info']['message'] ?>`,
        timeout: 5000,
        position: 'topCenter'
      });
    </script>
<?php
  }

  unset($_SESSION['info']);
  $_SESSION['info'] = null;
endif;
?>
<script src="../assets/js/page/modules-datatables.js"></script>