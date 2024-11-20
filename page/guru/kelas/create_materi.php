<?php
require_once '../layout/_top.php';
require_once '../helper/config.php';
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$tanggal = date('d'); // Day
$bulan = date('m');   // Month
$tahun = date('Y');   // Year

// Function to generate kd_materi
function generateKdMateri($koneksi) {
    $tanggal = date('d'); // Day
    $bulan = date('m');   // Month
    $tahun = date('Y');   // Year

    // Ambil urutan terakhir dari database
    $query_urutan = mysqli_query($koneksi, "SELECT MAX(kd_materi) AS last_kd_materi FROM materi");
    $data_urutan = mysqli_fetch_assoc($query_urutan);

    // Ambil urutan terakhir dan increment
    $last_kd_materi = $data_urutan['last_kd_materi'];
    $urutan = (int)substr($last_kd_materi, -3) + 1; // Ambil 3 digit terakhir dan increment

    // Format urutan agar menjadi 3 digit
    $urutan = str_pad($urutan, 3, '0', STR_PAD_LEFT);

    // Buat kode materi dengan format M+tanggal+bulan+tahun+urutan
    return 'M' . $tanggal . $bulan . $tahun . $urutan;
}

// Ambil urutan terakhir dari database
$query_urutan = mysqli_query($koneksi, "SELECT MAX(kd_materi) AS last_kd_materi FROM materi");
$data_urutan = mysqli_fetch_assoc($query_urutan);

// Ambil urutan terakhir dan increment
$last_kd_materi = $data_urutan['last_kd_materi'];
$urutan = (int)substr($last_kd_materi, -3) + 1; // Ambil 3 digit terakhir dan increment

// Format urutan agar menjadi 3 digit
$urutan = str_pad($urutan, 3, '0', STR_PAD_LEFT);

// Buat kode materi dengan format M+tanggal+bulan+tahun+urutan
$kd_materi = 'M' . $tanggal . $bulan . $tahun . $urutan;

if (isset($_POST['submit'])) {
    // Mengambil data dari form
    $kd_bab = $_POST['kd_bab'];
    $kode_mpp = $_POST['kode_mpp']; // Relasi ke mata pelajaran
    $kd_materi = $_POST['kd_materi'];

    // Proses upload file
    $file_name = $_FILES['judul_bab']['name'];
    $file_tmp = $_FILES['judul_bab']['tmp_name'];
    $file_error = $_FILES['judul_bab']['error'];
    $file_type = $_FILES['judul_bab']['type'];

    // Validasi tipe file
    $allowed_types = [
        'application/pdf',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'application/vnd.ms-powerpoint',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    ];

    if (in_array($file_type, $allowed_types) && $file_error == 0) {
        // Direktori tujuan
        $upload_dir = '../uploads/materi';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Ambil judul_bab dari tabel bab_kelas
        $query_bab_kelas = mysqli_query($koneksi, "
            SELECT judul_bab 
            FROM vbabkelas
           
            WHERE kd_bab = '$kd_bab' AND kode_mpp = '$kode_mpp'
        ");

        $data_bab_kelas = mysqli_fetch_assoc($query_bab_kelas);
        $judul_bab = $data_bab_kelas['judul_bab'];

        if ($judul_bab) {
            // Ganti nama file dengan judul_bab dan ekstensi file yang sama
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $new_file_name = $judul_bab . '.' . $file_ext;

            // Pindahkan file ke direktori tujuan dengan nama baru
            $file_path = $upload_dir . '/' . $new_file_name;
            if (move_uploaded_file($file_tmp, $file_path)) {
                // Pastikan relasi `kd_bab`, `kd_mapel`, dan `kd_kelas` ada di tabel `bab_kelas`
                $query_check_relasi = mysqli_query($koneksi, "
                    SELECT kd_bab_kelas 
                    FROM bab_kelas 
                    WHERE kd_bab = '$kd_bab' AND kode_mpp = '$kode_mpp'
                ");

                if (mysqli_num_rows($query_check_relasi) > 0) {
                    // Ambil kd_bab_kelas yang cocok
                    $data_relasi = mysqli_fetch_assoc($query_check_relasi);
                    $kd_bab_kelas = $data_relasi['kd_bab_kelas'];

                    // Generate kd_materi
                    $kd_materi = generateKdMateri($koneksi);

                    // Query untuk insert ke tabel `materi`
                    $tgl_materi = date('Y-m-d'); // Tanggal otomatis
                    $sql_insert_materi = mysqli_query($koneksi, "
                        INSERT INTO materi (kd_materi, kd_bab_kelas, file_materi, tgl_materi)
                        VALUES ('$kd_materi', '$kd_bab_kelas', '$new_file_name', '$tgl_materi')
                    ");

                    if ($sql_insert_materi) {
                        echo "<script>alert('Data berhasil disimpan!'); window.location.href='materi.php';</script>";
                    } else {
                        echo "<script>alert('Gagal menyimpan data ke tabel materi: " . mysqli_error($koneksi) . "'); window.location.href='createbab.php';</script>";
                    }
                } else {
                    echo "<script>alert('Relasi kd_bab, kode_mpp, atau kd_kelas tidak ditemukan!'); window.location.href='createbab.php';</script>";
                }
            } else {
                echo "<script>alert('Gagal mengunggah file.'); window.location.href='createbab.php';</script>";
            }
        } else {
            echo "<script>alert('Judul bab tidak ditemukan.'); window.location.href='createbab.php';</script>";
        }
    } else {
        echo "<script>alert('File yang diunggah harus berupa PDF, PPT, atau DOC.'); window.location.href='createbab.php';</script>";
    }
}

// Mendapatkan data bab untuk ditampilkan di form jika sedang mengedit
$kd_mpp1 = isset($_GET['kode_mpp']) ? $_GET['kode_mpp'] : '';
$kd_bab1 = isset($_GET['kd_bab']) ? $_GET['kd_bab'] : '';
$sqlbab = mysqli_query($koneksi, "
    SELECT nama_bab FROM bab 
    WHERE kd_bab='$kd_bab1'");
$data = mysqli_fetch_array($sqlbab);
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Tambah Materi</h1>
    <a href="./materi.php" class="btn btn-light"><i class="fas fa-arrow-left"></i> </a>
  </div>

  <div class="card">
    <div class="card-body">
      <form action="create_materi.php" method="POST" enctype="multipart/form-data">
        <!-- Upload Materi -->
        <div class="form-group">
          <label for="judul_bab">Upload Materi (PDF, PPT, DOC)</label>
          <input type="file" name="judul_bab" id="judul_bab" class="form-control" accept=".pdf,.ppt,.pptx,.doc,.docx" required>
        </div>

        <!-- Hidden untuk kode_bab dan kode_mpp -->
        <input type="hidden" name="kd_bab" value="<?php echo htmlspecialchars($kd_bab1); ?>">
        <input type="hidden" name="kd_materi" value="<?php echo $kd_materi ?>">
        <input type="hidden" name="kode_mpp" value="<?php echo htmlspecialchars($kd_mpp1); ?>">

        <button type="submit" name="submit" class="btn btn-success">Simpan</button>
        <input class="btn btn-danger" type="reset" name="batal" value="Bersihkan">
      </form>
    </div>
  </div>
</section>

<?php require_once '../layout/_bottom.php'; ?>
