<?php 
require_once '../layout/_top.php';
require_once '../helper/config.php';

$katakunci = "";
$row = 0; // Initialize $row to avoid undefined variable warning

if (isset($_POST['cari'])) {
    $katakunci = $_POST['kata_kunci'];

    // Menggunakan mysqli_real_escape_string untuk mencegah SQL injection
    $katakunci = mysqli_real_escape_string($koneksi, $katakunci);

    // Query ke view 'vkelas' dengan kondisi status aktif dan pencarian kata kunci
    $sql = mysqli_query($koneksi, "
        SELECT * FROM vkelas 
        WHERE status = 'aktif' 
        AND (
            kd_kelas LIKE '%" . $katakunci . "%' 
            OR nama_kelas LIKE '%" . $katakunci . "%' 
            OR nama_jurusan LIKE '%" . $katakunci . "%'
        ) 
        ORDER BY kd_kelas ASC
    ");
} else {
    // Query default ke view 'vkelas' dengan kondisi status aktif
    $sql = mysqli_query($koneksi, "
        SELECT * FROM vkelas 
        WHERE status = 'aktif' 
        ORDER BY kd_kelas ASC
    ");
}

if ($sql) {
    $row = mysqli_num_rows($sql);
} else {
    echo "Error: " . mysqli_error($koneksi);
}

// Pesan berhasil tambah, edit, atau hapus data
if (isset($_GET['aksi'])) {
    $aksi = $_GET['aksi'];
    if ($aksi == "suksestambah") {
        echo "<script>alert('Selamat, data berhasil ditambahkan!');</script>";
    } elseif ($aksi == "suksesedit") {
        echo "<script>alert('Selamat, data berhasil diubah!');</script>";
    } elseif ($aksi == "hapusok") {
        echo "<script>alert('Selamat, data berhasil dihapus!');</script>";
    }
}

ob_end_flush();
?>
<section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1>Data Kelas</h1>
        <a href="create.php" class="btn btn-primary">Tambah Data</a>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card pb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped w-100" id="table-1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Kelas</th>
                                    <th>Nama Kelas</th>
                                    <th>Jurusan</th>
                                    
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tableData">
                                <?php
                                if ($row > 0) {
                                    $nomor = 1;
                                    while ($data = mysqli_fetch_array($sql)) {
                                ?>
                                        <tr>
                                            <td><?php echo $nomor++; ?></td>
                                            <td><?php echo $data['kd_kelas']; ?></td>
                                            <td><?php echo $data['nama_kelas']; ?></td>
                                            <td><?php echo $data['nama_jurusan']; ?></td>
                                           
                                            <td>
                                                <a href="edit.php?kd_kelas=<?php echo $data['kd_kelas']; ?>"><button class="btn btn-warning btn-sm"><i class="fas fa-edit fa-fw"></i></button></a>
                                                <a href="delete.php?kd_kelas=<?php echo $data['kd_kelas']; ?>&pesan=hapus" onClick="return confirm('Apakah data yang Anda pilih akan dihapus?')"><button class="btn btn-danger btn-sm"><i class="fas fa-trash fa-fw"></i></button></a>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='6'>Data Tidak Tersedia</td></tr>";
                                }
                                ?>
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
                $("#tableData").html(response);
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
