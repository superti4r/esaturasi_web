<?php 
include '../../config.php';
session_start();
if (!isset($_SESSION['nik'])) {
  header('location:index.php?aksi=belum');

}
$nama=$_SESSION['nama_guru'];
$email=$_SESSION['email_guru'];
$foto=$_SESSION['foto_profil_guru'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Guru | E-Saturasi</title>
        <link rel="icon" type="image/x-icon" href="./images/icon.png" />

    <!-- StyleSheets  -->
    <link rel="stylesheet" href="./assets/css/dashlite.css?ver=3.2.2">
    <link id="skin-default" rel="stylesheet" href="./assets/css/theme.css?ver=3.2.2">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.0/css/dataTables.bootstrap5.min.css">
    <!-- DataTables Responsive CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

</head>

<body class="nk-body bg-lighter npc-default has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            <div class="nk-sidebar nk-sidebar-fixed is-light " data-content="sidebarMenu">
                <div class="nk-sidebar-element nk-sidebar-head">
                    <div class="nk-sidebar-brand">
                        <a href="html/index.html" class="logo-link nk-sidebar-logo">
                            <img class="logo-light logo-img" src="./images/logo.png" srcset="./images/logo2x.png 2x" alt="logo">
                            <img class="logo-dark logo-img" src="./images/logo-dark.png" srcset="./images/logo-dark2x.png 2x" alt="logo-dark">
                            <img class="logo-small logo-img logo-img-small" src="./images/logo-small.png" srcset="./images/logo-small2x.png 2x" alt="logo-small">
                        </a>
                    </div>
                    <div class="nk-menu-trigger me-n2">
                        <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
                        <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                    </div>
                </div><!-- .nk-sidebar-element -->
                <div class="nk-sidebar-element">
                    <div class="nk-sidebar-content">
                        <div class="nk-sidebar-menu" data-simplebar>
                        <ul class="nk-menu">
                                <li class="nk-menu-heading">
                                    <h6 class="overline-title text-primary-alt">Dashboard</h6>
                                </li><!-- .nk-menu-item -->
                                <li class="nk-menu-item">
                                    <a href="./home.php" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-home"></em></span>
                                        <span class="nk-menu-text">Beranda</span>
                                    </a>
                                </li>
                            <ul class="nk-menu">
                                </li>
                                <li class="nk-menu-heading">
                                    <h6 class="overline-title text-primary-alt">Fitur</h6>
                                </li>
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-grid-alt-fill"></em></span>
                                        <span class="nk-menu-text">Master</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                    <li class="nk-menu-item">
                                            <a href="./jadwal.php" class="nk-menu-link"><span class="nk-menu-text">Jadwal</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="./materi.php" class="nk-menu-link"><span class="nk-menu-text">Materi</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="./tugas.php" class="nk-menu-link"><span class="nk-menu-text">Tugas</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="./test.php" class="nk-menu-link"><span class="nk-menu-text">Test</span></a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nk-menu-heading">
                                    <h6 class="overline-title text-primary-alt">Session</h6>
                                </li><!-- .nk-menu-item -->
                                <li class="nk-menu-item">
                                    <a href="./logout.php" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-signout"></em></span>
                                        <span class="nk-menu-text">Log Out</span>
                                    </a>
                                </li>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- sidebar @e -->
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                <div class="nk-header nk-header-fixed is-light">
                    <div class="container-fluid">
                        <div class="nk-header-wrap">
                            <div class="nk-menu-trigger d-xl-none ms-n1">
                                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                            </div>
                            <div class="nk-header-brand d-xl-none">
                                <a href="html/index.html" class="logo-link">
                                    <img class="logo-light logo-img" src="./images/icon.png" srcset="./images/icon.png 2x" alt="logo">
                                    <img class="logo-dark logo-img" src="./images/icon.png" srcset="./images/icon.png 2x" alt="logo-dark">
                                </a>
                            </div><!-- .nk-header-brand -->
                        </div><!-- .nk-header-wrap -->
                    </div><!-- .container-fliud -->
                </div>
                <!-- main header @e -->
                <!-- content @s -->
                <div class="nk-content ">
                <div class="container mt-5">
    <h2 class="mb-4">Data Materi</h2>
    <div class="mb-3">
        <button id="uploadMateriButton" class="btn btn-primary">Upload Materi</button>
    </div>
    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Judul Materi</th> 
                    <th>Kelas</th>
                    <th>Bab</th> 
                    <th>Jenis File</th> 
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Panel untuk Upload Materi -->
<div class="modal fade" id="uploadMateriModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Upload Materi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="uploadMateriForm">
                    <div class="mb-3">
                        <label for="upload_judul_materi" class="form-label">Judul Materi</label>
                        <input type="text" class="form-control" id="upload_judul_materi" required>
                    </div>
                    <div class="mb-3">
                        <label for="upload_kelas" class="form-label">Kelas</label>
                        <input type="text" class="form-control" id="upload_kelas" required>
                    </div>
                    <div class="mb-3">
                        <label for="upload_bab" class="form-label">Bab</label>
                        <input type="text" class="form-control" id="upload_bab" required>
                    </div>
                    <div class="mb-3">
                        <label for="upload_jenis_file" class="form-label">Jenis File</label>
                        <select class="form-select" id="upload_jenis_file" required>
                            <option value="" disabled selected>Pilih jenis file</option>
                            <option value="RAR">RAR</option>
                            <option value="ZIP">ZIP</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="upload_file" class="form-label">Pilih File (RAR/ZIP)</label>
                        <input type="file" class="form-control" id="upload_file" accept=".rar,.zip" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="uploadSaveButton">Upload</button>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.0/js/dataTables.bootstrap5.min.js"></script>
<!-- DataTables Responsive JS -->
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>
<!-- DataTables Buttons JS -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script>
$(document).ready(function() {
    // Inisialisasi DataTable
    var table = $('#example').DataTable({
        "responsive": true,
        "ajax": "data.php", // URL untuk mengambil data dari database
        "columns": [
            { "data": "judul_materi" },
            { "data": "kelas" },
            { "data": "bab" },
            { "data": "jenis_file" },
            { 
                "data": null,
                "render": function (data, type, row) {
                    return `
                        <button class="btn btn-sm btn-warning edit-btn" data-id="${row.id}" data-judul="${row.judul_materi}" data-kelas="${row.kelas}" data-bab="${row.bab}" data-jenis="${row.jenis_file}">Edit</button>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="${row.id}">Delete</button>
                    `;
                }
            }
        ],
        "dom": 'Bfrtip',
        "buttons": [
            'excelHtml5',
            'pdfHtml5'
        ]
    });

    // Fungsi untuk membuka modal upload materi
    $('#uploadMateriButton').on('click', function() {
        $('#uploadMateriModal').modal('show');
    });

    // Fungsi untuk menyimpan data upload materi
    $('#uploadSaveButton').on('click', function() {
        var judulMateri = $('#upload_judul_materi').val();
        var kelas = $('#upload_kelas').val();
        var bab = $('#upload_bab').val();
        var jenisFile = $('#upload_jenis_file').val();
        var fileInput = $('#upload_file')[0].files[0];
        var allowedExtensions = /(\.rar|\.zip)$/i;

        if (!judulMateri || !kelas || !bab || !jenisFile || !fileInput) {
            alert('Semua field wajib diisi!');
            return;
        }

        if (!allowedExtensions.test(fileInput.name)) {
            alert('Hanya file RAR atau ZIP yang diperbolehkan.');
            return;
        }

        // Simulasi upload file (gunakan AJAX untuk upload nyata)
        alert('Materi "' + judulMateri + '" berhasil diunggah dengan file: ' + fileInput.name);

        // Tambahkan data ke DataTable (simulasi server-side)
        table.row.add({
            "judul_materi": judulMateri,
            "kelas": kelas,
            "bab": bab,
            "jenis_file": jenisFile
        }).draw();

        // Tutup modal
        $('#uploadMateriModal').modal('hide');
        $('#uploadMateriForm')[0].reset();
    });

    // Fungsi Edit (membuka modal panel)
    $('#example tbody').on('click', '.edit-btn', function() {
        var dataId = $(this).data('id');
        var judul = $(this).data('judul');
        var kelas = $(this).data('kelas');
        var bab = $(this).data('bab');
        var jenisFile = $(this).data('jenis');
        
        // Set data ke dalam modal
        $('#recordId').val(dataId);
        $('#judul_materi').val(judul);
        $('#kelas').val(kelas);
        $('#bab').val(bab);
        $('#jenis_file').val(jenisFile);

        // Buka modal
        $('#modalPanel').modal('show');
    });

    // Fungsi Save dari modal
    $('#saveButton').on('click', function() {
        var id = $('#recordId').val();
        var judulMateri = $('#judul_materi').val();
        var kelas = $('#kelas').val();
        var bab = $('#bab').val();
        var jenisFile = $('#jenis_file').val();

        alert('Data updated for ID: ' + id);
        // Tambahkan logika penyimpanan edit (AJAX) di sini

        // Tutup modal
        $('#modalPanel').modal('hide');
    });

    // Fungsi Delete
    $('#example tbody').on('click', '.delete-btn', function() {
        var dataId = $(this).data('id');
        if (confirm('Are you sure you want to delete this record?')) {
            // Tambahkan logika delete di sini, misal via AJAX untuk menghapus data di server
            alert('Data deleted with ID: ' + dataId);
        }
    });
});
</script>
                </div>
                <!-- content @e -->
                <!-- footer @s -->
                <div class="nk-footer">
                    <div class="container-fluid">
                        <div class="nk-footer-wrap">
                            <div class="nk-footer-copyright"> &copy; made with <3 <a href="#" target="#">@projectpintar</a>
                            </div>
                        </div>
                    </div>
    <!-- JavaScript -->
    <script src="./assets/js/bundle.js?ver=3.2.2"></script>
    <script src="./assets/js/scripts.js?ver=3.2.2"></script>
</body>

</html>