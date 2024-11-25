<?php
require_once '../layout/_top.php';
require_once '../helper/config.php';


?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Laporan Tugas</h1>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h6>Laporan Tugas Per-siswa</h6>
          <table cellpadding="8" class="w-100">
              <tr>
                <td>Kelas Yang Diampu</td>
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
                  <select class="form-control" name="mapel" id="mapel" required>
                    <option value="">--Pilih Nama Mata Pelajaran--</option>
                    <option value="X">nama mapel ambil dari DB</option>
                    <option value="X">nama mapel ambil dari DB</option>
                    <option value="X">nama mapel ambil dari DB</option>
                    <option value="X">nama mapel ambil dari DB</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Bab</td>
                <td>
                  <select class="form-control" name="bab" id="bab" required>
                    <option value="">--Pilih Bab--</option>
                    <option value="X">nama bab ambil dari DB</option>
                    <option value="X">nama bab ambil dari DB</option>
                    <option value="X">nama bab ambil dari DB</option>
                    <option value="X">nama bab ambil dari DB</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Siswa</td>
                <td>
                  <select class="form-control" name="pilih_siswa" id="pilih_siswa" required>
                    <option value="">--Pilih Siswa--</option>
                    <option value="X">nama siswa ambil dari DB</option>
                    <option value="X">nama siswa ambil dari DB</option>
                    <option value="X">nama siswa ambil dari DB</option>
                    <option value="X">nama siswa ambil dari DB</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>
                  <input class="btn btn-primary" type="submit" name="printReport" value="Unduh">
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
                  <th>Kelas</th>
                  <th>Nama Tugas</th>
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