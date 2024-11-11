<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

?>

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>


<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Ubah Artikel</h1>
    <a href="./index.php" class="btn btn-light">Kembali</a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- // Form -->
          <form action="./update.php" method="post">
              <input type="hidden" name="nisn" value="">
              <table cellpadding="8" class="w-100">
              <tr>
                <td>Kode Artikel</td>
                <td><input class="form-control" type="text" name="kode_artikel" size="20" required></td>
              </tr>

              <tr>
                <td>Judul Artikel</td>
                <td><input class="form-control" type="text" name="judul_artikel" size="20" required></td>
              </tr>

              <tr>
                <td>Gambar</td>
                <td><input class="form-control" type="file" name="foto" accept="image/*" required></td>
              </tr>

              <tr>
                <td>Tanggal Upload</td>
                <td><input class="form-control" type="date" name="tanggal_artikel" size="20" required></td>
              </tr>

              <tr>
                <td>Isi Artikel</td>
                <td>
                  <div id="editor" style="height: 200px;"></div>
                  <input type="hidden" name="isi_artikel" id="isi_artikel">
                </td>
              </tr>

                <tr>
                  <td>
                    <input class="btn btn-primary d-inline" type="submit" name="proses" value="Ubah">
                    <a href="./index.php" class="btn btn-danger ml-1">Batal</a>
                <td>
              </tr>
            </table>
          </form>
        </div>
      </div>
    </div>
</section>

<script>
  // Inisialisasi QuillJS
  var quill = new Quill('#editor', {
    theme: 'snow'
  });

  // Ambil data dari Quill sebelum form di-submit
  document.querySelector('form').onsubmit = function() {
    document.querySelector('#isi_artikel').value = quill.root.innerHTML;
  };
</script>


<?php
require_once '../layout/_bottom.php';
?>