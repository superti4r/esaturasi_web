<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

// Ambil data jurusan untuk dropdown
$jurusanResult = mysqli_query($connection, "SELECT * FROM jurusan");

// Ambil data kelas untuk ditampilkan
$result = mysqli_query($connection, "
    SELECT kelas.ident_kelas, kelas.tingkat_kelas, kelas.kode_kelas, jurusan.nama_jurusan 
    FROM kelas 
    INNER JOIN jurusan ON kelas.id_jurusan = jurusan.id_jurusan
");

?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Data Kelas</h1>
    <a href="./create.php" class="btn btn-primary">Tambah Data</a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover table-striped w-100" id="table-1">
              <thead>
                <tr class="text-center">
                  <th>No</th>
                  <th>ID Kelas</th>
                  <th>Tingkat Kelas</th>
                  <th>Kode Kelas</th>
                  <th>Jurusan</th>
                  <th style="width: 150">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                while ($data = mysqli_fetch_array($result)) :
                ?>

                  <tr class="text-center">
                    <td><?= $no ?></td>
                    <td><?= $data['ident_kelas'] ?></td>
                    <td><?= $data['tingkat_kelas'] ?></td>
                    <td><?= $data['kode_kelas'] ?></td>
                    <td><?= $data['nama_jurusan'] ?></td>
                    <td>
                      <a class="btn btn-sm btn-danger mb-md-0 mb-1" href="delete.php?ident_kelas=<?= $data['ident_kelas'] ?>">
                        <i class="fas fa-trash fa-fw"></i>
                      </a>
                      <a class="btn btn-sm btn-info" href="edit.php?ident_kelas=<?= $data['ident_kelas'] ?>">
                        <i class="fas fa-edit fa-fw"></i>
                      </a>
                    </td>
                  </tr>

                <?php
                  $no++;
                endwhile;
                ?>
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