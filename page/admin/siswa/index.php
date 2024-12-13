<?php
ob_start(); // Tambahkan ini di awal file
require_once '../layout/_top.php';
require_once '../helper/config.php';

if (isset($_POST['promote_selected'])) {
    if (!empty($_POST['selected_ids'])) {
        $ids = array_map(function($id) use ($koneksi) {
            return mysqli_real_escape_string($koneksi, $id);
        }, $_POST['selected_ids']);
        
        // Ambil data kelas siswa yang dipilih
        $ids_string = "'" . implode("','", $ids) . "'";
        $query = "SELECT siswa.nisn, siswa.kd_kelas, kelas.tingkatan, kelas.kd_jurusan, kelas.no_kelas 
                  FROM siswa 
                  LEFT JOIN kelas ON siswa.kd_kelas = kelas.kd_kelas 
                  WHERE siswa.nisn IN ($ids_string)";
        
        $result = mysqli_query($koneksi, $query);
        
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $kd_kelas = $row['kd_kelas'];
                $tingkat_kelas = $row['tingkatan'];
                $kd_jurusan = $row['kd_jurusan'];
                $no_kelas = $row['no_kelas']; // Ambil no_kelas dari query

                // Tentukan kelas baru dengan tingkat yang lebih tinggi dan nomor kelas yang sama
                if ($tingkat_kelas == 1) {
                    $tingkat_baru = $tingkat_kelas + 1;  // Tingkat baru

                    // Cari kelas baru berdasarkan tingkat dan jurusan yang sama, dan no_kelas yang sama
                    $new_class_query = "SELECT kd_kelas 
                                        FROM kelas 
                                        WHERE no_kelas = '$no_kelas' 
                                        AND kd_jurusan = '$kd_jurusan' 
                                        AND tingkatan = '$tingkat_baru' 
                                        LIMIT 1";
                    $new_class_result = mysqli_query($koneksi, $new_class_query);
                    
                    if ($new_class_result && mysqli_num_rows($new_class_result) > 0) {
                        $new_class_data = mysqli_fetch_assoc($new_class_result);
                        $new_kd_kelas = $new_class_data['kd_kelas'];
                        
                        // Update kelas siswa
                        $update_query = "UPDATE siswa 
                                         SET kd_kelas = '$new_kd_kelas'
                                         WHERE nisn = '".$row['nisn']."'";
                        if (mysqli_query($koneksi, $update_query)) {
                            // Jika tingkat kelas sudah 3 (tingkat akhir), ubah status siswa menjadi "Tidak Aktif"
                            if ($tingkat_baru == 3) {
                                $update_status_query = "UPDATE siswa 
                                                        SET status_siswa = 'aktif' 
                                                        WHERE nisn = '".$row['nisn']."'";
                                if (!mysqli_query($koneksi, $update_status_query)) {
                                    error_log("Gagal update status siswa untuk NISN: ".$row['nisn'].". Error: " . mysqli_error($koneksi));
                                }
                            }
                        } else {
                            error_log("Gagal update kelas untuk NISN: ".$row['nisn'].". Error: " . mysqli_error($koneksi));
                        }
                    } else {
                        $_SESSION['message'] = "Kelas baru untuk jurusan yang sama dan tingkat yang lebih tinggi tidak ditemukan.";
                        header("Location: index.php");
                        exit();
                    }
                } elseif ($tingkat_kelas == 2) {
                    // Logika untuk tingkat kelas 2, jika perlu
                    $tingkat_baru = $tingkat_kelas + 1;  // Tingkat baru
                   // Cari kelas baru berdasarkan tingkat dan jurusan yang sama, dan no_kelas yang sama
                   $new_class_query = "SELECT kd_kelas 
                   FROM kelas 
                   WHERE no_kelas = '$no_kelas' 
                   AND kd_jurusan = '$kd_jurusan' 
                   AND tingkatan = '$tingkat_baru' 
                   LIMIT 1";
$new_class_result = mysqli_query($koneksi, $new_class_query);

if ($new_class_result && mysqli_num_rows($new_class_result) > 0) {
   $new_class_data = mysqli_fetch_assoc($new_class_result);
   $new_kd_kelas = $new_class_data['kd_kelas'];
   
   // Update kelas siswa
   $update_query = "UPDATE siswa 
                    SET kd_kelas = '$new_kd_kelas'
                    WHERE nisn = '".$row['nisn']."'";
   if (mysqli_query($koneksi, $update_query)) {
       // Jika tingkat kelas sudah 3 (tingkat akhir), ubah status siswa menjadi "Tidak Aktif"
       if ($tingkat_baru == 3) {
           $update_status_query = "UPDATE siswa 
                                   SET status_siswa = 'aktif' 
                                   WHERE nisn = '".$row['nisn']."'";
           if (!mysqli_query($koneksi, $update_status_query)) {
               error_log("Gagal update status siswa untuk NISN: ".$row['nisn'].". Error: " . mysqli_error($koneksi));
           }
       }
   } else {
       error_log("Gagal update kelas untuk NISN: ".$row['nisn'].". Error: " . mysqli_error($koneksi));
   }
} else {
   $_SESSION['message'] = "Kelas baru untuk jurusan yang sama dan tingkat yang lebih tinggi tidak ditemukan.";
   header("Location: index.php");
   exit();
}
                }
               
                if ($tingkat_kelas == 3) {
                    // Update status siswa menjadi "Tidak Aktif"
                    $update_status_query = "UPDATE siswa 
                                            SET status_siswa = 'tidak aktif' 
                                            WHERE nisn = '".$row['nisn']."'";
                    if (!mysqli_query($koneksi, $update_status_query)) {
                        error_log("Gagal update status siswa untuk NISN: ".$row['nisn'].". Error: " . mysqli_error($koneksi));
                    }
                }
            }

            $_SESSION['message'] = "Siswa berhasil naik kelas.";
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['message'] = "Gagal mengambil data kelas siswa.";
        }
    } else {
        $_SESSION['message'] = "Pilih minimal satu data untuk dipromosikan.";
    }
}


//digunakan untuk mencari data dan menampilkan data siswa
$katakunci = "";
if (isset($_POST['cari'])) {
    $katakunci = $_POST['kata_kunci'];
    $sql = mysqli_query($koneksi, "SELECT siswa.*, kelas.nama_kelas FROM siswa
        LEFT JOIN kelas ON siswa.kd_kelas = kelas.kd_kelas
        WHERE siswa.nisn LIKE '%".$katakunci."%' 
        OR siswa.nama_siswa LIKE '%".$katakunci."%' 
        OR siswa.email LIKE '%".$katakunci."%' 
        OR siswa.no_telepon_siswa LIKE '%".$katakunci."%' 
        OR siswa.tempat_lahir_siswa LIKE '%".$katakunci."%' 
        OR siswa.jekel_siswa LIKE '%".$katakunci."%' 
        OR siswa.tahun_masuk_siswa LIKE '%".$katakunci."%' 
        OR siswa.alamat LIKE '%".$katakunci."%' 
        OR kelas.nama_kelas LIKE '%".$katakunci."%' 
        OR siswa.status_siswa LIKE '%".$katakunci."%' 
        ORDER BY siswa.nisn ASC");
} else {
    $sql = mysqli_query($koneksi, "SELECT siswa.*, kelas.nama_kelas FROM siswa
        LEFT JOIN kelas ON siswa.kd_kelas = kelas.kd_kelas
        ORDER BY siswa.nisn ASC");
}

if ($sql) {
    $row = mysqli_num_rows($sql);
} else {
    echo "Error: " . mysqli_error($koneksi); 
}

// Handle delete_selected action
if (isset($_POST['delete_selected'])) {
    if (!empty($_POST['selected_ids'])) {
        $ids = array_map(function($id) use ($koneksi) {
            return mysqli_real_escape_string($koneksi, $id);
        }, $_POST['selected_ids']);
        
        $ids_string = "'" . implode("','", $ids) . "'";
        $delete_query = "DELETE FROM siswa WHERE nisn IN ($ids_string)";
        
        if(mysqli_query($koneksi, $delete_query)) {
            // Simpan pesan dalam session
            $_SESSION['message'] = "Data berhasil dihapus";
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['message'] = "Gagal menghapus data: " . mysqli_error($koneksi);
        }
    } else {
        $_SESSION['message'] = "Pilih minimal satu data untuk dihapus.";
    }
}

// Handle naik_kelas action
if (isset($_POST['naik_kelas'])) {
    if (!empty($_POST['selected_ids'])) {
        $ids = array_map(function($id) use ($koneksi) {
            return mysqli_real_escape_string($koneksi, $id);
        }, $_POST['selected_ids']);
        
        $ids_string = "'" . implode("','", $ids) . "'";

        // Update kelas untuk siswa yang dipilih
        // Misalnya, jika ingin naik kelas dengan menambah 1 pada `tingkatan` dan mengupdate `kd_kelas`
        $update_query = "UPDATE siswa SET 
                         kd_kelas = (SELECT kd_kelas FROM kelas WHERE tingkatan = (SELECT tingkatan+1 FROM kelas WHERE kd_kelas = siswa.kd_kelas) LIMIT 1)
                         WHERE nisn IN ($ids_string)";
        
        if(mysqli_query($koneksi, $update_query)) {
            $_SESSION['message'] = "Siswa berhasil naik kelas";
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['message'] = "Gagal naik kelas: " . mysqli_error($koneksi);
        }
    } else {
        $_SESSION['message'] = "Pilih minimal satu data untuk naik kelas.";
    }
}

// Untuk menampilkan pesan berhasil menambah, mengubah, atau menghapus data
if (isset($_GET['aksi'])) {
    $aksi = $_GET['aksi'];
    if ($aksi == "suksestambah") {
      echo "<script>alert('Selamat, data berhasil ditambahkan');</script>";
    } elseif ($aksi == "suksesedit") {
      echo "<script>alert('Selamat, data berhasil diubah');</script>";
    } elseif ($aksi == "hapusok") {
      echo "<script>alert('Selamat, data berhasil dihapus');</script>";
    }
  }

// Tampilkan pesan jika ada
if (isset($_SESSION['message'])) {
    echo "<script>alert('" . $_SESSION['message'] . "');</script>";
    unset($_SESSION['message']); // Hapus pesan setelah ditampilkan
}
?>

<section class="section">
    <form method="POST" id="deleteForm">
        <div class="section-header d-flex justify-content-between">
            <h1>Data Siswa</h1>
            <div>
                <a href="create.php" class="btn btn-primary">Tambah Data</a>
                <button type="submit" name="delete_selected" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data yang dipilih?')">
                    <i class="fas fa-trash"></i> Hapus Yang Dipilih
                </button>
                <button type="submit" name="promote_selected" class="btn btn-success" onclick="return confirm('Apakah Anda yakin ingin mempromosikan data yang dipilih?')">
    <i class="fas fa-arrow-up"></i> Naik Kelas
</button>

            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card pb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped w-100" id="table-1">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="select_all"> Pilih Semua</th>
                                        <th>NISN</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th>Tahun Masuk</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tableData">
                                    <?php
                                    for ($i = 0; $i < $row; $i++) { 
                                        $data = mysqli_fetch_array($sql);
                                    ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="selected_ids[]" value="<?php echo $data['nisn']; ?>">
                                        </td>
                                        <td><?php echo $data['nisn']; ?></td>
                                        <td><?php echo $data['nama_siswa']; ?></td>
                                        <td><?php echo $data['nama_kelas']; ?></td> 
                                        <td><?php echo $data['tahun_masuk_siswa']; ?></td>
                                        <td><?php echo $data['status_siswa']; ?></td>
                                        <td>
                                            <a href="detail.php?nisn=<?php echo $data['nisn']; ?>" class="btn btn-success btn-sm">
                                                <i class="fas fa-info-circle"></i>
                                            </a>
                                            <a href="edit.php?nisn=<?php echo $data['nisn']; ?>" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit fa-fw"></i>
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
    </form>
</section>

<?php require_once '../layout/_bottom.php'; ?>

<script>
document.getElementById('select_all').onclick = function() {
    var checkboxes = document.querySelectorAll('input[name="selected_ids[]"]');
    for (var checkbox of checkboxes) {
        checkbox.checked = this.checked;
    }
}
</script>

<?php require_once '../layout/_bottom.php'; ?>

<script>
document.getElementById('select_all').onclick = function() {
    var checkboxes = document.querySelectorAll('input[name="selected_ids[]"]');
    for (var checkbox of checkboxes) {
        checkbox.checked = this.checked;
    }
}
</script>
<script>
$(document).ready(function () {
  // Event saat tombol cari diklik
  $("#cariBtn").click(function () {
    var kataKunci = $("#kataKunci").val(); // Mengambil nilai dari input pencarian

    // Mengirim permintaan AJAX untuk melakukan pencarian
    $.ajax({
      url: "index.php", // URL untuk file PHP yang akan memproses pencarian
      method: "POST",
      data: { cari: true, kata_kunci: kataKunci },
      success: function (response) {
        // Menampilkan hasil pencarian pada tabel
        $("#tableData").html(response);  // Update table body with the new data
        // Reinitialize DataTable after updating the table
        $("#table-1").DataTable().clear().destroy();
        $("#table-1").DataTable({
          "language": {
            "emptyTable": "Data Tidak Tersedia", 
            "zeroRecords": "Data Tidak Tersedia" 
          }
        });
      },
      error: function () {
        alert("Terjadi kesalahan saat mencari data.");
      },
    });
  });

  // Inisialisasi DataTables pertama kali
  $("#table-1").dataTable({
    "language": {
      "emptyTable": "Data Tidak Tersedia", 
      "zeroRecords": "Data Tidak Tersedia" 
    }
  });
});

</script>
