-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Okt 2024 pada 03.57
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `esaturasi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `guru`
--

CREATE TABLE `guru` (
  `nip` char(18) NOT NULL,
  `nik` char(16) NOT NULL,
  `nama_guru` varchar(50) NOT NULL,
  `tanggal_lahir_guru` date NOT NULL,
  `email_guru` varchar(30) NOT NULL,
  `jekel_guru` enum('laki-laki','perempuan','','') NOT NULL,
  `no_telepon_guru` varchar(13) NOT NULL,
  `foto_profil_guru` varchar(30) NOT NULL,
  `role` enum('guru','admin','','') NOT NULL,
  `password_guru` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `guru`
--

INSERT INTO `guru` (`nip`, `nik`, `nama_guru`, `tanggal_lahir_guru`, `email_guru`, `jekel_guru`, `no_telepon_guru`, `foto_profil_guru`, `role`, `password_guru`) VALUES
('12345678910244565', '123456789', 'dija', '2005-02-10', 'chdijahh@gmail.com', 'perempuan', '085204852440', 'profile/foto1.jpg', 'guru', '1234'),
('987654321', '80907', 'nela', '2024-10-09', 'nela@gmail.com', 'perempuan', '085204852440', 'profile/foto.jpg', 'admin', '1234');

-- --------------------------------------------------------

--
-- Struktur dari tabel `informasi`
--

CREATE TABLE `informasi` (
  `kd_informasi` int(11) NOT NULL,
  `kategori` enum('pengumuman','prestasi','extrakulikuler','') NOT NULL,
  `judul` varchar(30) NOT NULL,
  `keterangan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal`
--

CREATE TABLE `jadwal` (
  `kd_jadwal` char(5) NOT NULL,
  `hari` enum('senin','selasa','rabu','kamis','jum''at','sabtu') NOT NULL,
  `kd_kelas` char(4) NOT NULL,
  `kd_mapel` char(5) NOT NULL,
  `nik` char(16) NOT NULL,
  `dari_jam` time NOT NULL,
  `sampai_jam` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurusan`
--

CREATE TABLE `jurusan` (
  `kd_jurusan` varchar(5) NOT NULL,
  `nama_jurusan` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `kd_kelas` char(4) NOT NULL,
  `nama_kelas` varchar(5) NOT NULL,
  `tingkatan` enum('10','11','12','') NOT NULL,
  `kd_jurusan` char(4) NOT NULL,
  `no_kelas` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `mapel`
--

CREATE TABLE `mapel` (
  `kd_mapel` char(5) NOT NULL,
  `nama_mapel` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `materi`
--

CREATE TABLE `materi` (
  `kd_materi` int(11) NOT NULL,
  `kd_jadwal` char(5) NOT NULL,
  `bab` int(2) NOT NULL,
  `judul_materi` varchar(30) NOT NULL,
  `foto` varchar(30) NOT NULL,
  `materi` varchar(30) NOT NULL,
  `tgl_materi` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengumpulan_tugas`
--

CREATE TABLE `pengumpulan_tugas` (
  `kd_pengumpulan` int(11) NOT NULL,
  `kd_tugas` int(11) NOT NULL,
  `nisn` char(10) NOT NULL,
  `tgl_pengumpulan` date NOT NULL,
  `jam` time NOT NULL,
  `file` int(11) NOT NULL,
  `status` enum('tepat_waktu','terlambat','','') NOT NULL,
  `nilai` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengumuman`
--

CREATE TABLE `pengumuman` (
  `kd_pengumuman` int(11) NOT NULL,
  `judul_pengumuman` varchar(30) NOT NULL,
  `tgl_pengumuman` date NOT NULL,
  `nip` char(16) NOT NULL,
  `file_pengumuman` varchar(25) NOT NULL,
  `deskripsi_pengumuman` int(150) NOT NULL,
  `kategori_pengumuman` enum('pengumuman','prestasi','osis','ekstrakurikuler') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `nisn` char(10) NOT NULL,
  `nama_siswa` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `no_telepon_siswa` varchar(13) NOT NULL,
  `foto_profil_siswa` varchar(30) NOT NULL,
  `jekel_siswa` enum('perempuan','laki-laki','','') NOT NULL,
  `tempat_lahir_siswa` varchar(20) NOT NULL,
  `tgl_lahir_siswa` date NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `tahun_masuk_siswa` date NOT NULL,
  `status_siswa` enum('aktif','tidak aktif','','') NOT NULL,
  `kd_kelas` char(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tugas`
--

CREATE TABLE `tugas` (
  `kd_tugas` int(11) NOT NULL,
  `kd_jadwal` char(5) NOT NULL,
  `judul_tugas` varchar(25) NOT NULL,
  `file_tugas` varchar(30) NOT NULL,
  `deskripsi` varchar(50) NOT NULL,
  `tgl_tugas` date NOT NULL,
  `tenggat_jam` time NOT NULL,
  `tenggat_waktu` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`nik`);

--
-- Indeks untuk tabel `informasi`
--
ALTER TABLE `informasi`
  ADD PRIMARY KEY (`kd_informasi`);

--
-- Indeks untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`kd_jadwal`),
  ADD KEY `kd_kelas` (`kd_kelas`),
  ADD KEY `kd_mapel` (`kd_mapel`),
  ADD KEY `nik` (`nik`);

--
-- Indeks untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`kd_jurusan`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`kd_kelas`),
  ADD KEY `kd_jurusan` (`kd_jurusan`);

--
-- Indeks untuk tabel `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`kd_mapel`);

--
-- Indeks untuk tabel `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`kd_materi`),
  ADD KEY `kd_jadwal` (`kd_jadwal`);

--
-- Indeks untuk tabel `pengumpulan_tugas`
--
ALTER TABLE `pengumpulan_tugas`
  ADD PRIMARY KEY (`kd_pengumpulan`),
  ADD KEY `nisn` (`nisn`),
  ADD KEY `kd_tugas` (`kd_tugas`);

--
-- Indeks untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`kd_pengumuman`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`nisn`),
  ADD KEY `kd_kelas` (`kd_kelas`);

--
-- Indeks untuk tabel `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`kd_tugas`),
  ADD KEY `kd_jadwal` (`kd_jadwal`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `materi`
--
ALTER TABLE `materi`
  MODIFY `kd_materi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengumpulan_tugas`
--
ALTER TABLE `pengumpulan_tugas`
  MODIFY `kd_pengumpulan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `kd_pengumuman` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tugas`
--
ALTER TABLE `tugas`
  MODIFY `kd_tugas` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `jadwal_ibfk_1` FOREIGN KEY (`kd_kelas`) REFERENCES `kelas` (`kd_kelas`),
  ADD CONSTRAINT `jadwal_ibfk_2` FOREIGN KEY (`kd_mapel`) REFERENCES `mapel` (`kd_mapel`),
  ADD CONSTRAINT `jadwal_ibfk_3` FOREIGN KEY (`nik`) REFERENCES `guru` (`nik`);

--
-- Ketidakleluasaan untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`kd_jurusan`) REFERENCES `jurusan` (`kd_jurusan`);

--
-- Ketidakleluasaan untuk tabel `materi`
--
ALTER TABLE `materi`
  ADD CONSTRAINT `materi_ibfk_1` FOREIGN KEY (`kd_jadwal`) REFERENCES `jadwal` (`kd_jadwal`);

--
-- Ketidakleluasaan untuk tabel `pengumpulan_tugas`
--
ALTER TABLE `pengumpulan_tugas`
  ADD CONSTRAINT `pengumpulan_tugas_ibfk_1` FOREIGN KEY (`nisn`) REFERENCES `siswa` (`nisn`),
  ADD CONSTRAINT `pengumpulan_tugas_ibfk_2` FOREIGN KEY (`kd_tugas`) REFERENCES `tugas` (`kd_tugas`);

--
-- Ketidakleluasaan untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`kd_kelas`) REFERENCES `kelas` (`kd_kelas`);

--
-- Ketidakleluasaan untuk tabel `tugas`
--
ALTER TABLE `tugas`
  ADD CONSTRAINT `tugas_ibfk_1` FOREIGN KEY (`kd_jadwal`) REFERENCES `jadwal` (`kd_jadwal`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
