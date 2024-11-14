<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';


?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Tambah Tugas</h1>
    <a href="./index.php" class="btn btn-light">Kembali</a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body text-center">
          <h6>Pilih tipe soal yang akan diberikan</h6>
          <a href="javascript:void(0);" onclick="showForm('pilihanGandaForm')" class="btn btn-primary">Pilihan Ganda</a>
          <a href="javascript:void(0);" onclick="showForm('essayForm')" class="btn btn-danger">Essay</a>
        </div>
      </div>

      <div id="pilihanGandaForm" class="card" style="display: none;">
        <div class="card-body">
          <h5>Pilihan Ganda</h5>
          <form action="./store_pilihan_ganda.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <label>Judul</label>
              <input type="text" name="judul" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Kelas</label>
              <select name="kelas" class="form-control" required>
                <option value="X">X</option>
                <option value="XI">XI</option>
                <option value="XII">XII</option>
              </select>
            </div>
            <div class="form-group">
              <label>Mata Pelajaran</label>
              <select name="mataPelajaran" class="form-control" required>
                <option value="mapel1">Mapel1</option>
                <option value="mapel2">Mapel2</option>
              </select>
            </div>
            <div class="form-group">
              <label>Batas Pengumpulan</label>
              <input type="datetime-local" name="batasPengumpulan" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Bab</label>
              <input type="text" name="bab" class="form-control">
            </div>
            <div class="form-group">
              <label>Status</label>
              <select name="status" class="form-control">
                <option value="aktif">Aktif</option>
                <option value="tidak aktif">Tidak Aktif</option>
              </select>
            </div>
            <div class="form-group">
              <label>Jumlah Soal</label>
              <input type="number" name="jumlahSoal" id="jumlahSoal" class="form-control" min="1" required oninput="generateQuestionFields()">
            </div>
            <div id="questionsContainer"></div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-warning">Reset</button>
            <button type="button" class="btn btn-danger" onclick="hideForm('pilihanGandaForm')">Batal</button>
          </form>
        </div>
      </div>

      <div id="essayForm" class="card" style="display: none;">
        <div class="card-body">
          <h5>Essay</h5>
          <form action="./store_essay.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <label>Judul</label>
              <input type="text" name="judul" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Kelas</label>
              <select name="kelas" class="form-control" required>
                <option value="X">X</option>
                <option value="XI">XI</option>
                <option value="XII">XII</option>
              </select>
            </div>
            <div class="form-group">
              <label>Mata Pelajaran</label>
              <select name="mataPelajaran" class="form-control" required>
                <option value="mapel1">Mapel1</option>
                <option value="mapel2">Mapel2</option>
              </select>
            </div>
            <div class="form-group">
              <label>Batas Pengumpulan</label>
              <input type="datetime-local" name="batasPengumpulan" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Deskripsi Tugas</label>
              <textarea name="deskripsiTugas" class="form-control" required></textarea>
            </div>
            <div class="form-group">
              <label>File Soal (PDF)</label>
              <input type="file" name="fileSoal" accept=".pdf" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-warning">Reset</button>
            <button type="button" class="btn btn-danger" onclick="hideForm('essayForm')">Batal</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  function showForm(formId) {
    document.getElementById('pilihanGandaForm').style.display = 'none';
    document.getElementById('essayForm').style.display = 'none';
    document.getElementById(formId).style.display = 'block';
  }

  function hideForm(formId) {
    document.getElementById(formId).style.display = 'none';
  }

  function generateQuestionFields() {
    let jumlahSoal = document.getElementById('jumlahSoal').value;
    let container = document.getElementById('questionsContainer');
    container.innerHTML = '';

    for (let i = 1; i <= jumlahSoal; i++) {
      let questionHTML = `
        <div class="question-group">
          <h5>Soal ${i}</h5>
          <div class="form-group">
            <label>Soal ${i}</label>
            <textarea name="soal${i}" class="form-control" required></textarea>
          </div>
          <div class="form-group">
            <label>Gambar Soal ${i}</label>
            <input type="file" name="gambarSoal${i}" accept=".jpg,.jpeg,.png,.pdf" class="form-control">
          </div>
          <div class="form-group">
            <label>Jawaban A</label>
            <input type="text" name="jawabanA${i}" class="form-control">
            <input type="file" name="gambarJawabanA${i}" accept=".jpg,.jpeg,.png" class="form-control mt-1">
          </div>
          <div class="form-group">
            <label>Jawaban B</label>
            <input type="text" name="jawabanB${i}" class="form-control">
            <input type="file" name="gambarJawabanB${i}" accept=".jpg,.jpeg,.png" class="form-control mt-1">
          </div>
          <div class="form-group">
            <label>Jawaban C</label>
            <input type="text" name="jawabanC${i}" class="form-control">
            <input type="file" name="gambarJawabanC${i}" accept=".jpg,.jpeg,.png" class="form-control mt-1">
          </div>
          <div class="form-group">
            <label>Jawaban D</label>
            <input type="text" name="jawabanD${i}" class="form-control">
            <input type="file" name="gambarJawabanD${i}" accept=".jpg,.jpeg,.png" class="form-control mt-1">
          </div>
          <div class="form-group">
            <label>Kunci Jawaban untuk Soal ${i}</label>
            <input type="text" name="kunciJawaban${i}" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Bobot Soal ${i}</label>
            <input type="number" name="bobotSoal${i}" class="form-control" required>
          </div>
        </div>
      `;
      container.innerHTML += questionHTML;
    }
  }
</script>

<?php
require_once '../layout/_bottom.php';
?>