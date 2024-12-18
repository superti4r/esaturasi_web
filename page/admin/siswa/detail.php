<?php 
require_once '../layout/_top.php';
require_once '../helper/config.php';

$nisn = $_GET['nisn']; 
$query = mysqli_query($koneksi, "SELECT * FROM vsiswa WHERE nisn = '$nisn'");

$data = mysqli_fetch_assoc($query);

?>
<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Detail Siswa</h1>
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
              $foto_path = '../uploads/profilesiswa/' . $data['foto_profil_siswa'];
              if (!empty($data['foto_profil_siswa']) && file_exists($foto_path)) {
                  echo '<img src="' . $foto_path . '" class="img-fluid rounded" alt="Foto Profil Siswa" style="max-height: 200px;">';
              } else {
                  echo '<p>Tidak ada foto</p>';
              }
?>              
            </div>
                                        
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">NISN</th>
                                <td><?php echo $data['nisn']; ?></td>
                            </tr>
                            <tr>
                                <th>Nama Siswa</th>
                                <td><?php echo $data['nama_siswa']; ?></td>
                            </tr>
                      
                            <tr>
                                <th>Kelas</th>
                                <td><?php echo $data['nama_kelas']; ?></td>
                            </tr>
                            <tr>
                                <th>Kelas</th>
                                <td><?php echo $data['nama_jurusan']; ?></td>
                            </tr>
                          
                                <th>Jenis Kelamin</th>
                                <td><?php
                      if ($data['jekel_siswa'] == 'l') {
                          echo 'Laki-laki';
                      } elseif ($data['jekel_siswa'] == 'p') {
                          echo 'Perempuan';
                      } else {
                          echo '-';
                      }
                      ?></td>
                            </tr>
                            <tr>
                                <th>Tempat Lahir</th>
                                <td><?php echo $data['tempat_lahir_siswa']; ?></td>
                            </tr>
                            
                            <tr>
                                <th>Tanggal Lahir</th>
                                <td>
                                    <?php
                                    // Set locale untuk bahasa Indonesia
                                    setlocale(LC_TIME, 'id_ID', 'id_ID.utf8', 'indo');
                                    // Menampilkan tanggal dengan format Indonesia
                                    echo strftime('%d %B %Y', strtotime($data['tgl_lahir_siswa']));
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?php echo $data['email']; ?></td>
                            </tr>
                            <tr>
                                <th>No Telepon</th>
                                <td><?php echo $data['no_telepon_siswa']; ?></td>
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
                                    <div style="white-space: pre-wrap;"><?php echo $data['tahun_masuk_siswa']; ?></div>
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <div style="white-space: pre-wrap;"><?php echo $data['status_siswa']; ?></div>
                                </td>
                            </tr>
                           
                        </table>              
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php
require_once '../layout/_bottom.php';
?>
