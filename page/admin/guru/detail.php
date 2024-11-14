<?php 
require_once '../layout/_top.php';
require_once '../helper/config.php';

$nik = $_GET['nik'];
$query = mysqli_query($koneksi, "SELECT * FROM guru WHERE nik = '$nik'");
$data = mysqli_fetch_assoc($query);
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Detail Guru</h1>
    <a href="./index.php" class="btn btn-light"><i class="fas fa-arrow-left"></i> </a>
  </div>
<section class="section">
  <div class="container py-3">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card shadow">
          <div class="card-body">
            <div class="text-center mb-4">
              <?php
              $foto_path = $data['foto_profil_guru'];
              if (!empty($data['foto_profil_guru']) && file_exists($foto_path)): ?>
                <img src="<?php echo $foto_path; ?>" class="img-fluid rounded" alt="Foto Profil Guru" style="max-height: 200px;">
              <?php else: ?>
                <p>Tidak ada foto</p>
              <?php endif; ?>
            </div>
            <table class="table table-bordered">
              <tr>
                <th width="30%">NIK</th>
                <td><?php echo $data['nik']; ?></td>
              </tr>
              <tr>
                <th>Nama Guru</th>
                <td><?php echo $data['nama_guru']; ?></td>
              </tr>
              <tr>
                <th>NIP</th>
                <td><?php echo !empty($data['nip']) ? $data['nip'] : '-'; ?></td>
              </tr>
              <tr>
                <th>Jenis Kelamin</th>
                <td><?php
                if ($data['jekel_guru'] == 'l') {
                    echo 'Laki-laki';
                } elseif ($data['jekel_guru'] == 'p') {
                    echo 'Perempuan';
                } else {
                    echo '-';
                }
                ?></td>
              </tr>
              <tr>
                <th>Tanggal Lahir</th>
                <td>
                  <?php
                  // Set locale untuk bahasa Indonesia
                  setlocale(LC_TIME, 'id_ID', 'id_ID.utf8', 'indo');
                  // Menampilkan tanggal dengan format Indonesia
                  echo strftime('%d %B %Y', strtotime($data['tanggal_lahir_guru']));
                  ?>
                </td>
              </tr>
              <tr>
                <th>Email</th>
                <td><?php echo $data['email_guru']; ?></td>
              </tr>
              <tr>
                <th>No Telepon</th>
                <td><?php echo $data['no_telepon_guru']; ?></td>
              </tr>
              <tr>
                <th>Alamat</th>
                <td>
                  <div style="white-space: pre-wrap;"><?php echo $data['alamat']; ?></div>
                </td>
              </tr>
              <tr>
                <th>Status</th>
                <td>
                  <div style="white-space: pre-wrap;"><?php echo $data['status']; ?></div>
                </td>
              </tr>
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
