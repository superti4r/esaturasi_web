-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Nov 2024 pada 08.26
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
  `jekel_guru` enum('l','p') NOT NULL,
  `no_telepon_guru` varchar(13) NOT NULL,
  `foto_profil_guru` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `password_guru` varchar(25) NOT NULL,
  `status` enum('aktif','tidak aktif') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `guru`
--

INSERT INTO `guru` (`nip`, `nik`, `nama_guru`, `tanggal_lahir_guru`, `email_guru`, `jekel_guru`, `no_telepon_guru`, `foto_profil_guru`, `alamat`, `password_guru`, `status`) VALUES
('200407142024051001', '3509195407040001', 'Dwi Yulianti', '2003-07-14', 'dwiyulianti@gmail.com', 'p', '082233962148', '../uploads/profile/3509195407040001.png', 'Jl hayam wuruk 1, Kaliwates, jember, jatim, Indonesia', 'saturasi123', 'aktif'),
('196511081990031001', '3510104801150002', 'Naela Zahwa Salsabila', '2005-11-08', 'nela@gmail.com', 'p', '088230697372 ', '', 'Jl raya jember nomer 148, sepanjang, kecamatan Glenmore Kab. Banyuwangi\r\n', '12345678', 'aktif'),
('200312012024052001', '3510110112030004', 'Bachtiar Dwi Pramudi', '2003-12-01', 'bactiar@gmail.com', 'l', '085175315009', '../uploads/profile/3510110112030004.png', 'Kalibaru, Banyuwangi\r\n', 'saturasi123', 'aktif');

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
  `kd_jadwal` char(6) NOT NULL,
  `hari` enum('senin','selasa','rabu','kamis','jum''at','sabtu') NOT NULL,
  `kode_mpp` int(11) NOT NULL,
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

--
-- Dumping data untuk tabel `jurusan`
--

INSERT INTO `jurusan` (`kd_jurusan`, `nama_jurusan`) VALUES
('JR001', 'RPL'),
('JR002', 'TITL'),
('JR003', 'TKR');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `kd_kelas` char(4) NOT NULL,
  `nama_kelas` varchar(10) NOT NULL,
  `kd_jurusan` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`kd_kelas`, `nama_kelas`, `kd_jurusan`) VALUES
('KL01', 'X RPL 1', 'JR001'),
('KL02', 'X RPL 2', 'JR001'),
('KL03', 'XI TKR 1', 'JR003');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mapel`
--

CREATE TABLE `mapel` (
  `kd_mapel` char(5) NOT NULL,
  `nama_mapel` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mapel`
--

INSERT INTO `mapel` (`kd_mapel`, `nama_mapel`) VALUES
('MP001', 'Agama'),
('MP002', 'Inggris'),
('MP003', 'Informatika'),
('MP004', 'Bahasa Indonesia'),
('MP005', 'Jaringan Komputer'),
('MP006', 'Mesin'),
('MP007', 'Basis Data'),
('MP008', 'Teknologi Dasar Otom'),
('MP009', 'Pemeliharaan Mesin'),
('MP010', 'Pemrograman Dasar'),
('MP011', 'Desain Grafis');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mata_pelajaran_perkelas`
--

CREATE TABLE `mata_pelajaran_perkelas` (
  `kode_mpp` int(11) NOT NULL,
  `kd_kelas` char(4) DEFAULT NULL,
  `kd_mapel` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mata_pelajaran_perkelas`
--

INSERT INTO `mata_pelajaran_perkelas` (`kode_mpp`, `kd_kelas`, `kd_mapel`) VALUES
(13, 'KL01', 'MP001'),
(17, 'KL01', 'MP002'),
(19, 'KL02', 'MP001'),
(20, 'KL02', 'MP002'),
(21, 'KL02', 'MP003'),
(22, NULL, 'MP004'),
(23, NULL, 'MP005'),
(24, NULL, 'MP007');

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
  `kd_pengumuman` char(11) NOT NULL,
  `judul_pengumuman` varchar(30) NOT NULL,
  `tgl_pengumuman` date NOT NULL,
  `nik` char(16) NOT NULL,
  `file_pengumuman` varchar(25) NOT NULL,
  `deskripsi_pengumuman` varchar(255) NOT NULL
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
  `jekel_siswa` enum('p','l') NOT NULL,
  `tempat_lahir_siswa` varchar(20) NOT NULL,
  `tgl_lahir_siswa` date NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `tahun_masuk_siswa` int(4) NOT NULL,
  `status_siswa` enum('Aktif','Tidak Aktif') NOT NULL,
  `kd_kelas` char(4) DEFAULT NULL,
  `foto_profil_siswa` varchar(50) NOT NULL,
  `password` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`nisn`, `nama_siswa`, `email`, `no_telepon_siswa`, `jekel_siswa`, `tempat_lahir_siswa`, `tgl_lahir_siswa`, `alamat`, `tahun_masuk_siswa`, `status_siswa`, `kd_kelas`, `foto_profil_siswa`, `password`) VALUES
('0048227539', 'Gilang', 'radengilang@gmail.com', '09933000088', 'l', 'Stibuondo', '2004-07-07', 'STB', 2022, 'Aktif', 'KL01', '', '0048227539'),
('0053881352', 'Rio Pamungkas', 'rio.pamungkas@email.com', '082345678833', 'l', 'Bandar Lampung', '2006-02-02', 'Jl. Melati Putih No.23', 2022, 'Aktif', 'KL02', '', '0053881352'),
('0056144233', 'Chodijah', 'chodijahdija10@gmail.com', '085204852449', '', 'Probolinggo', '0000-00-00', 'Jln.Brawijaya No.10', 2023, 'Aktif', 'KL02', '', '0056144233');

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

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `vjadwal`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `vjadwal` (
`kd_jadwal` char(6)
,`hari` enum('senin','selasa','rabu','kamis','jum''at','sabtu')
,`kd_kelas` char(4)
,`nama_kelas` varchar(10)
,`kd_jurusan` char(5)
,`nama_jurusan` varchar(25)
,`kd_mapel` char(5)
,`nama_mapel` varchar(20)
,`nik` char(16)
,`nama_guru` varchar(50)
,`tanggal_lahir_guru` date
,`foto_profil_guru` varchar(50)
,`no_telepon_guru` varchar(13)
,`email_guru` varchar(30)
,`alamat` varchar(100)
,`status` enum('aktif','tidak aktif')
,`dari_jam` time
,`sampai_jam` time
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `vmpp`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `vmpp` (
`kode_mpp` int(11)
,`kd_kelas` char(4)
,`nama_kelas` varchar(10)
,`kd_mapel` char(5)
,`nama_mapel` varchar(20)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `vsiswa`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `vsiswa` (
`nisn` char(10)
,`nama_siswa` varchar(30)
,`email` varchar(30)
,`no_telepon_siswa` varchar(13)
,`jekel_siswa` enum('p','l')
,`tgl_lahir_siswa` date
,`tempat_lahir_siswa` varchar(20)
,`alamat` varchar(50)
,`tahun_masuk_siswa` int(4)
,`status_siswa` enum('Aktif','Tidak Aktif')
,`kd_kelas` char(4)
,`nama_kelas` varchar(10)
,`kd_jurusan` char(5)
,`nama_jurusan` varchar(25)
,`foto_profil_siswa` varchar(50)
,`password` varchar(25)
);

-- --------------------------------------------------------

--
-- Struktur untuk view `vjadwal`
--
DROP TABLE IF EXISTS `vjadwal`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vjadwal`  AS SELECT `jadwal`.`kd_jadwal` AS `kd_jadwal`, `jadwal`.`hari` AS `hari`, `mata_pelajaran_perkelas`.`kd_kelas` AS `kd_kelas`, `kelas`.`nama_kelas` AS `nama_kelas`, `kelas`.`kd_jurusan` AS `kd_jurusan`, `jurusan`.`nama_jurusan` AS `nama_jurusan`, `mata_pelajaran_perkelas`.`kd_mapel` AS `kd_mapel`, `mapel`.`nama_mapel` AS `nama_mapel`, `jadwal`.`nik` AS `nik`, `guru`.`nama_guru` AS `nama_guru`, `guru`.`tanggal_lahir_guru` AS `tanggal_lahir_guru`, `guru`.`foto_profil_guru` AS `foto_profil_guru`, `guru`.`no_telepon_guru` AS `no_telepon_guru`, `guru`.`email_guru` AS `email_guru`, `guru`.`alamat` AS `alamat`, `guru`.`status` AS `status`, `jadwal`.`dari_jam` AS `dari_jam`, `jadwal`.`sampai_jam` AS `sampai_jam` FROM (((((`jadwal` join `mata_pelajaran_perkelas` on(`jadwal`.`kode_mpp` = `mata_pelajaran_perkelas`.`kode_mpp`)) join `kelas` on(`mata_pelajaran_perkelas`.`kd_kelas` = `kelas`.`kd_kelas`)) join `jurusan` on(`kelas`.`kd_jurusan` = `jurusan`.`kd_jurusan`)) join `mapel` on(`mata_pelajaran_perkelas`.`kd_mapel` = `mapel`.`kd_mapel`)) join `guru` on(`jadwal`.`nik` = `guru`.`nik`)) ;

-- --------------------------------------------------------

--
-- Struktur untuk view `vmpp`
--
DROP TABLE IF EXISTS `vmpp`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vmpp`  AS SELECT `mata_pelajaran_perkelas`.`kode_mpp` AS `kode_mpp`, `mata_pelajaran_perkelas`.`kd_kelas` AS `kd_kelas`, `kelas`.`nama_kelas` AS `nama_kelas`, `mata_pelajaran_perkelas`.`kd_mapel` AS `kd_mapel`, `mapel`.`nama_mapel` AS `nama_mapel` FROM ((`mata_pelajaran_perkelas` join `kelas` on(`mata_pelajaran_perkelas`.`kd_kelas` = `kelas`.`kd_kelas`)) join `mapel` on(`mata_pelajaran_perkelas`.`kd_mapel` = `mapel`.`kd_mapel`)) ;

-- --------------------------------------------------------

--
-- Struktur untuk view `vsiswa`
--
DROP TABLE IF EXISTS `vsiswa`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vsiswa`  AS SELECT `siswa`.`nisn` AS `nisn`, `siswa`.`nama_siswa` AS `nama_siswa`, `siswa`.`email` AS `email`, `siswa`.`no_telepon_siswa` AS `no_telepon_siswa`, `siswa`.`jekel_siswa` AS `jekel_siswa`, `siswa`.`tgl_lahir_siswa` AS `tgl_lahir_siswa`, `siswa`.`tempat_lahir_siswa` AS `tempat_lahir_siswa`, `siswa`.`alamat` AS `alamat`, `siswa`.`tahun_masuk_siswa` AS `tahun_masuk_siswa`, `siswa`.`status_siswa` AS `status_siswa`, `siswa`.`kd_kelas` AS `kd_kelas`, `kelas`.`nama_kelas` AS `nama_kelas`, `kelas`.`kd_jurusan` AS `kd_jurusan`, `jurusan`.`nama_jurusan` AS `nama_jurusan`, `siswa`.`foto_profil_siswa` AS `foto_profil_siswa`, `siswa`.`password` AS `password` FROM ((`siswa` join `kelas` on(`siswa`.`kd_kelas` = `kelas`.`kd_kelas`)) join `jurusan` on(`kelas`.`kd_jurusan` = `jurusan`.`kd_jurusan`)) ;

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
  ADD KEY `nik` (`nik`),
  ADD KEY `kode_mpp` (`kode_mpp`);

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
  ADD KEY `kelas_ibfk_1` (`kd_jurusan`);

--
-- Indeks untuk tabel `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`kd_mapel`);

--
-- Indeks untuk tabel `mata_pelajaran_perkelas`
--
ALTER TABLE `mata_pelajaran_perkelas`
  ADD PRIMARY KEY (`kode_mpp`),
  ADD KEY `mata_pelajaran_perkelas_ibfk_3` (`kd_kelas`),
  ADD KEY `mata_pelajaran_perkelas_ibfk_2` (`kd_mapel`);

--
-- Indeks untuk tabel `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`kd_materi`);

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
  ADD PRIMARY KEY (`kd_pengumuman`),
  ADD KEY `pengumuman_ibfk_1` (`nik`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`nisn`),
  ADD KEY `siswa_ibfk_1` (`kd_kelas`);

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
-- AUTO_INCREMENT untuk tabel `mata_pelajaran_perkelas`
--
ALTER TABLE `mata_pelajaran_perkelas`
  MODIFY `kode_mpp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

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
  ADD CONSTRAINT `jadwal_ibfk_3` FOREIGN KEY (`nik`) REFERENCES `guru` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`kd_jurusan`) REFERENCES `jurusan` (`kd_jurusan`);

--
-- Ketidakleluasaan untuk tabel `mata_pelajaran_perkelas`
--
ALTER TABLE `mata_pelajaran_perkelas`
  ADD CONSTRAINT `mata_pelajaran_perkelas_ibfk_2` FOREIGN KEY (`kd_mapel`) REFERENCES `mapel` (`kd_mapel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mata_pelajaran_perkelas_ibfk_3` FOREIGN KEY (`kd_kelas`) REFERENCES `kelas` (`kd_kelas`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Ketidakleluasaan untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD CONSTRAINT `pengumuman_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `guru` (`nik`);

--
-- Ketidakleluasaan untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`kd_kelas`) REFERENCES `kelas` (`kd_kelas`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tugas`
--
ALTER TABLE `tugas`
  ADD CONSTRAINT `tugas_ibfk_1` FOREIGN KEY (`kd_jadwal`) REFERENCES `jadwal` (`kd_jadwal`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
