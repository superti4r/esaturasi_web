<?php 
require_once '../layout/_top.php';
require_once '../helper/config.php';

$katakunci = "";
if (isset($_POST['cari'])) {
    $katakunci = $_POST['kata_kunci'];

    // Mencegah SQL Injection
    $katakunci = mysqli_real_escape_string($koneksi, $katakunci);
    
    $sql = mysqli_query($koneksi, "
        SELECT * FROM tahun_ajaran 
        WHERE 
        CONCAT(tahun_mulai, '/', tahun_selesai) LIKE '%" . $katakunci . "%' 
        OR semester LIKE '%" . $katakunci . "%'
        OR status LIKE '%" . $katakunci . "%' 
        ORDER BY tahun_mulai DESC
    ");
} else {
    $sql = mysqli_query($koneksi, "
        SELECT * FROM tahun_ajaran 
        ORDER BY tahun_mulai DESC
    ");
}

if ($sql) {
    $row = mysqli_num_rows($sql);
} else {
    echo "Error: " . mysqli_error($koneksi);
}

// Pesan berhasil tambah data
if (isset($_GET['aksi'])) {
    $aksi = $_GET['aksi'];
    if ($aksi == "suksestambah") {
        echo "
        <script>
        alert('Selamat, data Anda berhasil ditambahkan');
        </script>
        ";
    } elseif ($aksi == "suksesedit") {
        echo "
        <script>
        alert('Selamat, data Anda berhasil diubah');
        </script>
        ";
    } elseif ($aksi == "hapusok") {
        echo "
        <script>
        alert('Selamat, data Anda berhasil dihapus');
        </script>
        ";
    }
}

?>
<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Tahun Ajaran</h1>
    <a href="create.php" class="btn btn-primary">Tambah Data</a>
  </div>
  <div class="row">
    <div class="col-12">
    <div class="card pb-4">
        <div class="card-body">
          <div class="d-flex justify-content-between mt-4 mb-1">
         
          </div>
          <div class="table-responsive">
            <table class="table table-hover table-striped w-100" id="table-1">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tahun Ajaran</th>
                  <th>Semester</th>
                  <th>Tanggal Mulai</th>
                  <th>Tanggal Selesai</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="tableData">
                <?php
                $nomor = 1; 
                for ($i = 0; $i < $row; $i++) { 
                    $data = mysqli_fetch_array($sql);
                    $tahun_ajaran = $data['tahun_mulai'] . '/' . $data['tahun_selesai'];
                ?>
                <tr>
                  <td><?php echo $nomor++; ?></td>
                  <td><?php echo $tahun_ajaran; ?></td>
                  <td><?php echo $data['semester']; ?></td>
                  <td><?php echo date('d-m-Y', strtotime($data['tanggal_mulai'])); ?></td>
                  <td><?php echo date('d-m-Y', strtotime($data['tanggal_selesai'])); ?></td>
                  <td><?php echo ucfirst($data['status']); ?></td>
                  <td>
                    <a href="edit.php?id=<?php echo $data['kd_tahun_ajaran']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit fa-fw"></i></a>
                    <a href="delete.php?kd_tahun_ajaran=<?php echo $data['kd_tahun_ajaran']; ?>&pesan=hapus" 
   onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" 
   class="btn btn-danger btn-sm">
   <i class="fas fa-trash fa-fw"></i>
</a>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php
require_once '../layout/_bottom.php';
?>
<script>
$(document).ready(function () {
  // Inisialisasi DataTables
  $("#table-1").dataTable({
    "language": {
      "emptyTable": "Data Tidak Tersedia", 
      "zeroRecords": "Data Tidak Tersedia" 
    }
  });
});
</script>
