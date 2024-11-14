<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';


?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Data Pengumpulan Tugas</h1>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover table-striped w-100" id="table-1">
              <thead>
                <tr class="text-center">
                  <th>Kode Tugas</th>
                  <th>Judul</th>
                  <th>Sudah Mengumpulkan</th>
                  <th>Belum Mengumpulkan</th>
                </tr>
              </thead>
              <tbody>
                  <tr>
                    <td></td>
                    <td></td>
                    <td>
                      <a class="btn btn-sm btn-primary" href="view_submit.php?kode_tugas=">
                        <i class="fas fa-eye fa-fw"></i>
                      </a>
                    </td>
                    <td>
                      <a class="btn btn-sm btn-warning" href="view_belum_submit.php?kode_tugas=">
                        <i class="fas fa-eye fa-fw"></i>
                      </a>
                    </td>
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