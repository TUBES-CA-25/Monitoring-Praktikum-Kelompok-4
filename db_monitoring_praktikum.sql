-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 23 Jan 2026 pada 08.50
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_monitoring_praktikum`
--

DELIMITER $$
--
-- Prosedur
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_asisten_with_references` (IN `p_id_asisten` INT)   BEGIN
    -- 1️⃣ Hapus mentoring yang terkait frekuensi asisten
    DELETE FROM trs_mentoring
    WHERE id_frekuensi IN (
        SELECT id_frekuensi
        FROM trs_frekuensi
        WHERE id_asisten1 = p_id_asisten
           OR id_asisten2 = p_id_asisten
    );

    -- 2️⃣ Hapus frekuensi yang melibatkan asisten
    DELETE FROM trs_frekuensi
    WHERE id_asisten1 = p_id_asisten
       OR id_asisten2 = p_id_asisten;

    -- 3️⃣ Hapus asisten
    DELETE FROM mst_asisten
    WHERE id_asisten = p_id_asisten;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_user_with_references` (IN `p_id_user` INT)   BEGIN
    DECLARE v_id_asisten INT;

    -- Ambil id_asisten dari user
    SELECT id_asisten
    INTO v_id_asisten
    FROM mst_asisten
    WHERE id_user = p_id_user
    LIMIT 1;

    IF v_id_asisten IS NOT NULL THEN

        -- 1️⃣ HAPUS trs_mentoring DULU
        DELETE FROM trs_mentoring
        WHERE id_frekuensi IN (
            SELECT id_frekuensi
            FROM trs_frekuensi
            WHERE id_asisten1 = v_id_asisten
               OR id_asisten2 = v_id_asisten
        );

        -- 2️⃣ HAPUS trs_frekuensi
        DELETE FROM trs_frekuensi
        WHERE id_asisten1 = v_id_asisten
           OR id_asisten2 = v_id_asisten;

        -- 3️⃣ HAPUS mst_asisten
        DELETE FROM mst_asisten
        WHERE id_asisten = v_id_asisten;

    END IF;

    -- 4️⃣ HAPUS mst_user
    DELETE FROM mst_user
    WHERE id_user = p_id_user;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `mst_asisten`
--

CREATE TABLE `mst_asisten` (
  `id_asisten` int(11) NOT NULL,
  `stambuk` varchar(13) DEFAULT NULL,
  `nama_asisten` varchar(50) DEFAULT NULL,
  `angkatan` year(4) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `jenis_kelamin` enum('Pria','Wanita') DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `photo_profil` text DEFAULT NULL,
  `photo_path` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mst_asisten`
--

INSERT INTO `mst_asisten` (`id_asisten`, `stambuk`, `nama_asisten`, `angkatan`, `status`, `jenis_kelamin`, `id_user`, `photo_profil`, `photo_path`) VALUES
(1, '13020200103', 'Adam Adnan, S.Kom', '2020', 'Asisten', 'Pria', 2, 'public/img/uploads/Adam Adnan.png', 'public/img/signature/Adam Adnan.png'),
(2, '13020200318', 'As\'syahrin Nanda, S.Kom', '2020', 'Asisten', 'Pria', 3, 'public/img/uploads/fotoProfile.jpeg', 'public/img/signature/TTDku-As\'syahrinNanda.png'),
(3, '13020210048', 'Ahmad Rendi', '2021', 'Asisten', 'Pria', 4, 'public/img/uploads/Ahmad Rendi.JPG', 'public/img/signature/Ahmad Rendi.png'),
(4, '13020210287', 'Athar Fathana Rakasyah', '2021', 'Asisten', 'Pria', 5, 'public/img/uploads/Athar Fathana Rakasyah.jpg', 'TIDAK'),
(5, '13020210023', 'Annisa Pratama Putri', '2021', 'Asisten', 'Wanita', 6, 'public/img/uploads/Annisa Pratama Putri.jpg', 'public/img/signature/nisa ttd.png'),
(6, '13120210008', 'Muhammad Akbar', '2021', 'Asisten', 'Pria', 7, 'public/img/uploads/Muhammad Akbar.png', 'public/img/signature/Akbar-removebg-preview.png'),
(7, '13120210004', 'Muhammad Dani Arya Putra', '2021', 'Asisten', 'Pria', 8, 'public/img/uploads/Muhammad Dani Arya Putra.jpg', 'public/img/signature/arya ttd.png'),
(8, '13020210134', 'Nasrullah', '2021', 'Asisten', 'Pria', 9, 'public/img/uploads/Nasrullah.jpg', 'public/img/signature/Nasrullah.png'),
(9, '13020210205', 'Naufal Abiyyu Supriadi', '2021', 'Asisten', 'Pria', 10, 'public/img/uploads/Naufal Abiyyu Supriadi.jpg', 'public/img/signature/Naufal ttd.png'),
(10, '13020210242', 'Nirmala', '2021', 'Asisten', 'Wanita', 11, 'public/img/uploads/Nirmala.jpg', 'public/img/signature/IMG_20241008_135850_104-removebg-preview.png'),
(11, '13020210066', 'Nurul Azmi', '2021', 'Asisten', 'Wanita', 12, 'public/img/uploads/Nurul Azmi.JPG', 'public/img/signature/Azmi (1).png'),
(12, '13020210053', 'Imran Afdillah Dahlan', '2021', 'Asisten', 'Pria', 13, 'public/img/uploads/Imran Abdillah.JPG', 'public/img/signature/Abdillah ttd.png'),
(13, '13120210005', 'Furqon Fatahillah', '2021', 'Asisten', 'Pria', 14, 'public/img/uploads/Furqon Fatahillah.jpg', 'public/img/signature/Furqon ttd.png'),
(14, '13020220227', 'Ahmad Mufli Ramadhan', '2022', 'Calon Asisten', 'Pria', 15, 'TIDAK', 'public/img/signature/Ahmad Mufli Ramadhan.png'),
(15, '13020220292', 'Maharani Safwa Andini', '2022', 'Calon Asisten', 'Wanita', 16, 'TIDAK', 'public/img/signature/Maharani_.png'),
(16, '13020220265', 'Farid Wajdi Mufti', '2022', 'Calon Asisten', 'Pria', 17, 'TIDAK', 'public/img/signature/Farid Wajdi Mufti.png'),
(17, '13020210093', 'Rahma Puspitasari', '2021', 'Calon Asisten', 'Wanita', 18, 'public/img/uploads/RHM03397.JPG', 'public/img/signature/Rahma.png'),
(18, '13020220301', 'Julisa', '2022', 'Calon Asisten', 'Wanita', 19, NULL, 'public/img/signature/Julisa ttd.png'),
(21, '13020220081', 'Wahyu Kadri Rahmat Suat', '2022', 'Calon Asisten', 'Pria', 22, 'public/img/uploads/RHM03414.JPG', 'public/img/signature/Wahyu ttd.png'),
(22, '13020210143', 'Berlian Septiani', '2021', 'Calon Asisten', 'Wanita', 23, NULL, 'public/img/signature/Berlian Septiani.png'),
(23, '13020220323', 'Dewi Ernita Rahma', '2022', 'Calon Asisten', 'Wanita', 24, NULL, 'public/img/signature/Dewi_Ernita_Rahma.png'),
(24, '13020220109', 'Tazkirah Amaliah', '2022', 'Calon Asisten', 'Wanita', 25, 'public/img/uploads/RHM03395.JPG', 'public/img/signature/TTD_Tazkirah.png'),
(26, '13020200141', 'Rizal Rahmadani, S.Kom., MCF', '2020', 'Asisten', 'Pria', 27, NULL, 'public/img/signature/Rizal.png'),
(30, '13020230253', 'Zaki Falihin Ayyubi', '2023', 'Asisten', 'Pria', 32, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mst_dosen`
--

CREATE TABLE `mst_dosen` (
  `id_dosen` int(11) NOT NULL,
  `nip` varchar(30) DEFAULT NULL,
  `nama_dosen` varchar(50) DEFAULT NULL,
  `photo_path` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mst_dosen`
--

INSERT INTO `mst_dosen` (`id_dosen`, `nip`, `nama_dosen`, `photo_path`) VALUES
(1, '0919027301', 'Ir. Purnawansyah, S.Kom.,M.Kom., MTA', 'public/img/signature/Pak Pur (2).PNG'),
(2, '0922078101', 'Ir. Yulita Salim, S.Kom.,M.T., MTA', 'public/img/signature/yuli.PNG'),
(6, '0910126901', 'Tasrif Hasanuddin, S.Kom., M.Cs.', 'public/img/signature/pak tasrif.png'),
(7, '0428077401', 'Dr. Ir. Dolly Indra, S.Kom.,M.M.SI., MTA', 'public/img/signature/Dolly.jpg'),
(8, '0913038506', 'Ir. Herman, S.Kom.,M.Cs., MTA', 'public/img/signature/herman.PNG'),
(9, '0931018001', 'Ir. Abdul Rachman Manga’, S.Kom.,M.T., MTA', 'TIDAK'),
(10, '0920098801', 'Ir. Huzain Azis, S.Kom.,M.Cs., MTA', 'public/img/signature/uceng.PNG'),
(11, '0917068601', 'Ir. Dedy Atmajaya, S.Kom.,M.Eng., MTA', 'public/img/signature/dedy atmajaya.jpg'),
(12, '0911098601', 'Ir. Farniwati Fattah, S.T.,M.T., MTA', 'TIDAK'),
(13, '0906078701', 'Mardiyyah Hasnawi, S.Kom.,M.T., MTA', 'TIDAK'),
(14, '0906048205', 'Lilis Nur Hayati, S.Kom.,M.Eng., MTA', 'TIDAK'),
(15, '0922088701', 'Siska Anraeni, S.Kom., M.T.', 'public/img/signature/siska.jpg'),
(16, '0919056501', 'Ramdan Satra, S.Kom.,M.Kom., MTA', 'TIDAK'),
(17, '0920107601', 'Ir. Muh. Aliyazid Mude, S.Kom.,M.Kom.', 'TIDAK'),
(18, '0915028503', 'Irawati, S.Kom.,M.T., MTA', 'TIDAK'),
(19, '0919018501', 'Ir. St. Hajrah Mansyur, S.Kom.,M.Cs., MTA', 'public/img/signature/hajrah.jpg'),
(20, '0926048704', 'Ir. Syahrul Mubarak Abdullah, S.Kom.,M.Kom., MTA', 'TIDAK'),
(21, '0915068601', 'Ir. Nia Kurniati, S.Kom.,M.Kom., MTA', 'TIDAK'),
(22, '0924048501', 'Sugiarti, S.Kom.,M.Kom., MTA.', 'public/img/signature/sugiarti.png'),
(23, '0906128504', 'Ir. Erick Irawadi Alwi, S.Kom.,M.Eng., MTA', 'TIDAK'),
(24, '0921018902', 'Lutfi Budi Ilmawan, S.Kom.,M.Cs., MTA', 'public/img/signature/lutfi.png'),
(25, '0924069001', 'Ir. Herdianti, S.Si., M.Eng., MTA', 'TIDAK'),
(26, '0922078801', 'Fitriyani Umar, S.Si., M.Eng.', 'TIDAK'),
(27, '0922118003', 'Ir. Lukman Syafie, S.Si., M.Si., MTA', 'public/img/signature/lukman syafei.jpg'),
(28, '0908089202', 'Andi Ulfah Tenripada, S.Kom., M.Kom.', 'public/img/signature/uphe.jpg'),
(29, '2107057202', 'Ihwana As’ad, S.Ag., M.Sc., Ph.D., MTA.', 'public/img/signature/ihwana.jpg'),
(30, '1302902', 'Fahmi, S.Kom., M.T', 'public/img/signature/fahmi.png'),
(31, '0908099401', 'Andi Widya Mufila Gaffar, S.T., M.Kom', 'public/img/signature/widya.PNG'),
(32, '0911039301', 'Ramdaniah, S.Kom., M.T., MTA', 'public/img/signature/ramdaniah.jpg'),
(33, '0909029203', 'Muhammad Arfah Asis, S.Kom., M.T., MTA', 'TIDAK'),
(34, '0924049303', 'Amaliah Faradibah, S.Kom., M.Kom., MTA., MCF', 'public/img/signature/paraf amel.jpg'),
(35, '0901019302', 'Dewi Widyawati, S.Kom., M.Kom., MTA', 'TIDAK'),
(37, '130014', 'Syariful Mujaddid, S.Kom., M.T', 'TIDAK'),
(38, '', 'Lukman, S.E., M.Acc', 'public/img/signature/lukman akuntansi.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mst_jurusan`
--

CREATE TABLE `mst_jurusan` (
  `id_jurusan` int(11) NOT NULL,
  `jurusan` varchar(50) DEFAULT NULL,
  `singkatan_jurusan` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mst_jurusan`
--

INSERT INTO `mst_jurusan` (`id_jurusan`, `jurusan`, `singkatan_jurusan`) VALUES
(1, 'Teknik Informatika', 'TI'),
(2, 'Sistem Informasi', 'SI');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mst_kelas`
--

CREATE TABLE `mst_kelas` (
  `id_kelas` int(11) NOT NULL,
  `id_jurusan` int(11) DEFAULT NULL,
  `kelas` varchar(5) DEFAULT NULL,
  `frekuensi` varchar(20) DEFAULT NULL,
  `angkatan` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mst_kelas`
--

INSERT INTO `mst_kelas` (`id_kelas`, `id_jurusan`, `kelas`, `frekuensi`, `angkatan`) VALUES
(1, 1, 'A1', NULL, '2024'),
(2, 1, 'A2', NULL, '2024'),
(3, 1, 'A3', NULL, '2024'),
(4, 1, 'A4', NULL, '2024'),
(5, 1, 'A5', NULL, '2024'),
(6, 1, 'A6', NULL, '2024'),
(7, 1, 'A7', NULL, '2024'),
(8, 1, 'A8', NULL, '2024'),
(9, 1, 'B1', NULL, '2024'),
(10, 1, 'B2', NULL, '2024'),
(11, 1, 'B3', NULL, '2024'),
(12, 1, 'B4', NULL, '2024'),
(13, 1, 'B5', NULL, '2024'),
(14, 1, 'D1', NULL, '2024'),
(15, 2, 'A1', NULL, '2024'),
(16, 2, 'B1', NULL, '2024'),
(17, 1, 'A1', NULL, '2023'),
(18, 1, 'A2', NULL, '2023'),
(19, 1, 'A3', NULL, '2023'),
(20, 1, 'A4', NULL, '2023'),
(21, 1, 'A5', NULL, '2023'),
(22, 1, 'A6', NULL, '2023'),
(23, 1, 'A7', NULL, '2023'),
(24, 1, 'A8', NULL, '2023'),
(25, 1, 'A9', NULL, '2023'),
(26, 1, 'A10', NULL, '2023'),
(27, 1, 'B1', NULL, '2023'),
(28, 1, 'B2', NULL, '2023'),
(29, 1, 'B3', NULL, '2023'),
(30, 1, 'B4', NULL, '2023'),
(31, 1, 'C1', NULL, '2023'),
(32, 1, 'D1', NULL, '2023'),
(33, 2, 'A1', NULL, '2023'),
(34, 2, 'B1', NULL, '2023'),
(35, 2, 'D1', NULL, '2023'),
(36, 1, 'A1', NULL, '2022'),
(37, 1, 'A2', NULL, '2022'),
(38, 1, 'A3', NULL, '2022'),
(39, 1, 'A4', NULL, '2022'),
(40, 1, 'A5', NULL, '2022'),
(41, 1, 'A6', NULL, '2022'),
(42, 1, 'A7', NULL, '2022'),
(43, 1, 'A8', NULL, '2022'),
(44, 1, 'B1', NULL, '2022'),
(45, 1, 'B2', NULL, '2022'),
(46, 1, 'B3', NULL, '2022'),
(47, 1, 'B4', NULL, '2022'),
(48, 1, 'B5', NULL, '2022'),
(49, 1, 'C1', NULL, '2022'),
(50, 1, 'D1', NULL, '2022'),
(51, 2, 'A1', NULL, '2022'),
(52, 2, 'B1', NULL, '2022'),
(53, 2, 'D1', NULL, '2022'),
(54, 1, 'C2', NULL, '2021');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mst_matakuliah`
--

CREATE TABLE `mst_matakuliah` (
  `id_matkul` int(11) NOT NULL,
  `kode_matkul` varchar(12) DEFAULT NULL,
  `nama_matkul` varchar(50) DEFAULT NULL,
  `singkatan` varchar(20) DEFAULT NULL,
  `semester` enum('GANJIL','GENAP') DEFAULT NULL,
  `sks` int(11) DEFAULT NULL,
  `id_jurusan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mst_matakuliah`
--

INSERT INTO `mst_matakuliah` (`id_matkul`, `kode_matkul`, `nama_matkul`, `singkatan`, `semester`, `sks`, `id_jurusan`) VALUES
(1, '1303PPA104', 'Pengantar Teknologi Informasi', 'PTI', 'GANJIL', 3, 1),
(2, '1303PPA105', 'Algoritma dan Pemrograman 1', 'ALPRO1', 'GANJIL', 3, 1),
(3, '1303PPA302', 'Struktur Data', 'SD', 'GANJIL', 3, 1),
(4, '1303PPA304', 'Basis Data II', 'BD2', 'GANJIL', 3, 1),
(5, '1303KKA504', 'Microcontroller ', 'MICRO', 'GANJIL', 3, 1),
(6, '1303KKA713', 'Pemrograman Mobile', 'MOBILE', 'GANJIL', 3, 1),
(7, '1313KKB107', 'Algoritma Pemrograman', 'ALPRO', 'GANJIL', 3, 2),
(8, '1313KKB109', 'Sistem dan Teknologi Informasi ', 'STI', 'GANJIL', 3, 2),
(9, '1313KKB304', 'Jaringan Komputer', 'JARKOM', 'GANJIL', 3, 2),
(10, '1313KKB306', 'Pemrograman Web', 'WEB', 'GANJIL', 3, 2),
(11, '1313KKB309', 'Basis Data II', 'BD2', 'GANJIL', 3, 2),
(12, '1313KKB503', 'Sistem Operasi', 'SO', 'GANJIL', 3, 2),
(13, '1313PPB507', 'Aplikasi Akuntansi', 'AA', 'GANJIL', 3, 2),
(14, '1303KKA203', 'Elektronika Dasar', 'ELEKTRO', 'GENAP', 3, 1),
(15, '1303PPA205', 'Algoritma & Pemrograman 2', 'ALPRO2', 'GENAP', 3, 1),
(16, '1303PPA207', 'Basis Data I', 'BD1', 'GENAP', 3, 1),
(17, '1303KKA403', 'Pemrograman Berorientasi Objek', 'PBO', 'GENAP', 3, 1),
(18, '1303KKA407', 'Jaringan Komputer', 'JARKOM', 'GENAP', 3, 1),
(19, '1303KKA408', 'Pemrograman Web', 'WEB', 'GENAP', 3, 1),
(20, '1313KKB204', 'Basis Data I ', 'BD1', 'GENAP', 3, 2),
(21, '1313KKB205', 'Algoritma & Struktur Data ', 'ASD', 'GENAP', 3, 2),
(22, '1313KKB401', 'Pemrograman Berorientasi Objek', 'PBO', 'GENAP', 3, 2),
(23, '1313KKB402', 'Desain Grafis ', 'DG', 'GENAP', 3, 2),
(24, '1313KKB407', 'Pemrograman Mobile ', 'MOBILE', 'GENAP', 3, 2),
(25, '1313KKB604', 'Multimedia System', 'MS', 'GENAP', 3, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mst_ruangan`
--

CREATE TABLE `mst_ruangan` (
  `id_ruangan` int(11) NOT NULL,
  `nama_ruangan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mst_ruangan`
--

INSERT INTO `mst_ruangan` (`id_ruangan`, `nama_ruangan`) VALUES
(1, 'Laboratorium IoT'),
(2, 'Laboratorium StartUp'),
(3, 'Laboratorium Data Science'),
(4, 'Laboratorium Computer Vision'),
(5, 'Laboratorium Computer Network'),
(6, 'Laboratorium Multimedia'),
(7, 'Laboratorium Microcontroller'),
(8, 'Laboratorium Riset 1'),
(9, 'Laboratorium Riset 2'),
(10, 'Laboratorium Riset 3');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mst_tahun_ajaran`
--

CREATE TABLE `mst_tahun_ajaran` (
  `id_tahun` int(11) NOT NULL,
  `tahun_ajaran` varchar(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mst_tahun_ajaran`
--

INSERT INTO `mst_tahun_ajaran` (`id_tahun`, `tahun_ajaran`) VALUES
(1, '2023/2024'),
(2, '2024/2025'),
(3, '2025/2026'),
(4, '2026/2027'),
(5, '2027/2028'),
(6, '2028/2029'),
(7, '2029/2030');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mst_user`
--

CREATE TABLE `mst_user` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mst_user`
--

INSERT INTO `mst_user` (`id_user`, `nama_user`, `username`, `password`, `role`) VALUES
(1, 'Fatima A.R. Tuasamu', 'admin@gmail.com', '41e5653fc7aeb894026d6bb7b2db7f65902b454945fa8fd65a6327047b5277fb', 'Admin'),
(2, 'Adam Adnan', 'adnan100701@gmail.com', 'c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3', 'Asisten'),
(3, 'As\'syahrin Nanda', 'syahrinnanda@gmail.com', 'dae787a2c11951f8a35b9b79c3ac5c674cbd612e8229d49fe4460ab30815f40b', 'Asisten'),
(4, 'Ahmad Rendi', 'ahmadrendiajah@gmail.com', 'c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3', 'Asisten'),
(5, 'Athar Fathana Rakasyah', 'atharfathanarakasyah.iclabs@umi.ac.id', 'c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3', 'Asisten'),
(6, 'Annisa Pratama Putri', 'ichaicha.iic63@gmail.com', '36f256288ed4ddb5d30dc513db2bc00140ef69ecd6bd5f47f6222481a2c433a9', 'Asisten'),
(7, 'Muhammad Akbar', 'muhakbar1141@gmail.com', 'c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3', 'Asisten'),
(8, 'Muhammad Dani Arya Putra', 'daniaryap01@gmail.com', 'bec8e31aa369aef490adb2db4ebef44e29987dddef0ac2763f1da390a4de0e07', 'Asisten'),
(9, 'Nasrullah', 'nasrullah.iclabs@umi.ac.id', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'Asisten'),
(10, 'Naufal Abiyyu Supriadi', 'naufal.supriadi02@gmail.com', 'c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3', 'Asisten'),
(11, 'Nirmala', 'malaaaanir.iclabs@umi.ac.id', '6ec5edd852fcd1c73a658cc4d6a2bdf67188cfe198b2727a3b30d8a10e77b854', 'Asisten'),
(12, 'Nurul Azmi', 'nrl.azmi160103@gmail.com', '2db6ccb5909c267526bab28591ad7c6126e0d8a9fa1c30357004bff4e64f2abc', 'Asisten'),
(13, 'Imran Afdillah Dahlan', 'imranafdillah9c@gmail.com', 'c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3', 'Asisten'),
(14, 'Furqon Fatahillah', 'furqonfatahillah999@gmail.com', 'c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3', 'Asisten'),
(15, 'Ahmad Mufli Ramadhan', 'Laxmiwatimaani@gmail.com', 'c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3', 'Asisten'),
(16, 'Maharani Safwa Andini', 'maharanisafwandini@gmail.com', 'c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3', 'Asisten'),
(17, 'Farid Wajdi Mufti', 'faridwajedi.m@gmail.com', 'c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3', 'Asisten'),
(18, 'Rahma Puspitasari', 'rahma86788@gmail.com', '4ef7bcad9cfa0ea30e86850ad138a03aff82a95741d74c21e71760b287c63894', 'Asisten'),
(19, 'Julisa', 'julisabahtiar77@gmail.com', 'c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3', 'Asisten'),
(22, 'Wahyu Kadri Rahmat Suat', 'wahyusuat101@gmail.com', 'c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3', 'Asisten'),
(23, 'Berlian Septiani', 'berliansptn@gmail.com', 'c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3', 'Asisten'),
(24, 'Dewi Ernita Rahma', 'dewiernitarahma@gmail.com', 'c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3', 'Asisten'),
(25, 'Tazkirah Amaliah', 'tazkirah1804@gmail.com', 'c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3', 'Asisten'),
(27, 'Rizal Rahmadani', '13020200141@umi.ac.id', 'c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3', 'Asisten'),
(32, 'Zaki Falihin Ayyubi', '13020230253@gmail.com', 'c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3', 'Asisten');

-- --------------------------------------------------------

--
-- Struktur dari tabel `trs_frekuensi`
--

CREATE TABLE `trs_frekuensi` (
  `id_frekuensi` int(11) NOT NULL,
  `id_jurusan` int(11) DEFAULT NULL,
  `id_matkul` int(11) DEFAULT NULL,
  `frekuensi` varchar(20) DEFAULT NULL,
  `id_tahun` int(11) DEFAULT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `hari` varchar(25) DEFAULT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `id_ruangan` int(11) DEFAULT NULL,
  `id_dosen` int(11) DEFAULT NULL,
  `id_asisten1` int(11) DEFAULT NULL,
  `id_asisten2` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `trs_frekuensi`
--

INSERT INTO `trs_frekuensi` (`id_frekuensi`, `id_jurusan`, `id_matkul`, `frekuensi`, `id_tahun`, `id_kelas`, `hari`, `jam_mulai`, `jam_selesai`, `id_ruangan`, `id_dosen`, `id_asisten1`, `id_asisten2`) VALUES
(2, 1, 1, 'TI_PTI-1', 2, 1, 'Sabtu', '07:00:00', '09:30:00', 2, 27, 8, 5),
(3, 1, 1, 'TI_PTI-2', 2, 2, 'Sabtu', '07:00:00', '09:30:00', 1, 27, 7, 15),
(4, 1, 1, 'TI_PTI-3', 2, 3, 'Jumat', '15:40:00', '18:10:00', 2, 22, 7, 23),
(6, 1, 1, 'TI_PTI-5', 2, 5, 'Jumat', '13:00:00', '15:30:00', 2, 27, 7, 13),
(7, 1, 1, 'TI_PTI-6', 2, 6, 'Jumat', '13:00:00', '15:30:00', 1, 27, 2, 21),
(8, 1, 1, 'TI_PTI-7', 2, 7, 'Selasa', '07:00:00', '09:30:00', 2, 29, 3, 14),
(9, 1, 1, 'TI_PTI-8', 2, 8, 'Selasa', '15:40:00', '18:10:00', 3, 27, 1, 21),
(10, 1, 1, 'TI_PTI-9', 2, 9, 'Sabtu', '13:00:00', '15:30:00', 2, 29, 6, 10),
(12, 1, 1, 'TI_PTI-11', 2, 11, 'Sabtu', '09:40:00', '12:10:00', 2, 22, 11, 15),
(14, 1, 1, 'TI_PTI-13', 2, 13, 'Selasa', '15:40:00', '18:10:00', 4, 27, 9, 10),
(15, 1, 2, 'TI_ALPRO1-1', 2, 1, 'Selasa', '13:00:00', '15:30:00', 2, 24, 9, 5),
(16, 1, 2, 'TI_ALPRO1-2', 2, 2, 'Selasa', '13:00:00', '15:30:00', 1, 24, 2, 23),
(17, 1, 2, 'TI_ALPRO1-3', 2, 3, 'Selasa', '15:40:00', '18:10:00', 2, 15, 8, 14),
(20, 1, 2, 'TI_ALPRO1-6', 2, 6, 'Senin', '09:40:00', '12:10:00', 1, 15, 8, 18),
(21, 1, 2, 'TI_ALPRO1-7', 2, 7, 'Jumat', '09:40:00', '12:10:00', 2, 10, 6, 23),
(22, 1, 2, 'TI_ALPRO1-8', 2, 8, 'Jumat', '09:40:00', '12:10:00', 1, 10, 13, 5),
(23, 1, 2, 'TI_ALPRO1-9', 2, 9, 'Rabu', '13:00:00', '15:30:00', 2, 10, 10, 21),
(24, 1, 2, 'TI_ALPRO1-10', 2, 10, 'Rabu', '13:00:00', '15:30:00', 1, 10, 6, 18),
(25, 1, 2, 'TI_ALPRO1-11', 2, 11, 'Rabu', '15:40:00', '18:10:00', 2, 15, 13, 17),
(26, 1, 2, 'TI_ALPRO1-12', 2, 12, 'Rabu', '15:40:00', '18:10:00', 1, 15, 7, 21),
(27, 1, 2, 'TI_ALPRO1-13', 2, 13, 'Jumat', '15:40:00', '18:10:00', 4, 10, 10, 17),
(28, 1, 3, 'TI_SD-1', 2, 17, 'Rabu', '09:40:00', '12:10:00', 4, 24, 5, 14),
(29, 1, 3, 'TI_SD-2', 2, 18, 'Rabu', '09:40:00', '12:10:00', 3, 24, 12, 16),
(30, 1, 3, 'TI_SD-3', 2, 19, 'Kamis', '07:00:00', '09:30:00', 4, 24, 3, 15),
(31, 1, 3, 'TI_SD-4', 2, 20, 'Kamis', '07:00:00', '09:30:00', 3, 24, 11, 12),
(32, 1, 3, 'TI_SD-5', 2, 21, 'Senin', '13:00:00', '15:30:00', 4, 37, 2, 14),
(33, 1, 3, 'TI_SD-6', 2, 22, 'Senin', '15:40:00', '18:10:00', 4, 37, 8, 14),
(34, 1, 3, 'TI_SD-7', 2, 23, 'Senin', '13:00:00', '15:30:00', 3, 37, 5, 17),
(36, 1, 3, 'TI_SD-9', 2, 25, 'Sabtu', '09:40:00', '12:10:00', 4, 34, 3, 23),
(37, 1, 3, 'TI_SD-10', 2, 26, 'Sabtu', '09:40:00', '12:10:00', 3, 34, 6, 16),
(40, 1, 3, 'TI_SD-13', 2, 29, 'Rabu', '13:00:00', '15:30:00', 4, 32, 8, 14),
(41, 1, 3, 'TI_SD-14', 2, 30, 'Rabu', '13:00:00', '15:30:00', 3, 32, 3, 11),
(42, 1, 3, 'TI_SD-10', 2, 32, 'Sabtu', '09:40:00', '12:10:00', 3, 34, 6, 16),
(43, 1, 4, 'TI_BD2-1', 2, 17, 'Selasa', '13:00:00', '15:30:00', 4, 34, 10, 21),
(44, 1, 5, 'TI_MICRO-1', 2, 36, 'Jumat', '07:00:00', '09:30:00', 7, 33, 9, 18),
(45, 1, 4, 'TI_BD2-2', 2, 18, 'Selasa', '13:00:00', '15:30:00', 3, 34, 13, 17),
(46, 1, 4, 'TI_BD2-3', 2, 19, 'Selasa', '09:40:00', '12:10:00', 4, 34, 6, 3),
(47, 1, 5, 'TI_MICRO-2', 2, 37, 'Jumat', '09:40:00', '12:10:00', 7, 33, 3, 12),
(49, 1, 4, 'TI_BD2-5', 2, 21, 'Rabu', '07:00:00', '09:30:00', 4, 34, 10, 13),
(50, 1, 4, 'TI_BD2-6', 2, 22, 'Rabu', '07:00:00', '09:30:00', 3, 34, 7, 21),
(51, 1, 4, 'TI_BD2-7', 2, 23, 'Rabu', '15:40:00', '18:10:00', 4, 28, 2, 23),
(52, 1, 4, 'TI_BD2-8', 2, 24, 'Rabu', '15:40:00', '18:10:00', 3, 28, 12, 18),
(53, 1, 4, 'TI_BD2-9', 2, 25, 'Kamis', '09:40:00', '12:10:00', 4, 34, 1, 5),
(55, 1, 4, 'TI_BD2-11', 2, 27, 'Jumat', '07:00:00', '09:30:00', 2, 11, 11, 15),
(56, 1, 4, 'TI_BD2-12', 2, 28, 'Jumat', '07:00:00', '09:30:00', 1, 11, 2, 3),
(57, 1, 4, 'TI_BD2-13', 2, 29, 'Rabu', '09:40:00', '12:10:00', 1, 11, 2, 3),
(58, 1, 4, 'TI_BD2-14', 2, 30, 'Rabu', '07:00:00', '09:30:00', 2, 11, 8, 17),
(59, 1, 4, 'TI_BD2-15', 2, 31, 'Sabtu', '15:40:00', '18:10:00', 4, 8, 10, 15),
(60, 1, 4, 'TI_BD2-15', 2, 32, 'Sabtu', '15:40:00', '18:10:00', 4, 8, 10, 15),
(61, 1, 5, 'TI_MICRO-3', 2, 38, 'Sabtu', '13:00:00', '15:30:00', 7, 33, 1, 21),
(62, 1, 5, 'TI_MICRO-4', 2, 39, 'Kamis', '07:00:00', '21:30:00', 7, 33, 1, 22),
(63, 1, 5, 'TI_MICRO-5', 2, 40, 'Jumat', '13:00:00', '15:30:00', 7, 31, 1, 9),
(64, 1, 5, 'TI_MICRO-6', 2, 41, 'Jumat', '15:40:00', '18:10:00', 7, 31, 9, 22),
(65, 1, 5, 'TI_MICRO-7', 2, 42, 'Rabu', '09:40:00', '12:10:00', 7, 6, 1, 22),
(66, 1, 5, 'TI_MICRO-8', 2, 43, 'Rabu', '07:00:00', '09:30:00', 7, 6, 9, 11),
(67, 1, 5, 'TI_MICRO-9', 2, 44, 'Selasa', '07:00:00', '09:30:00', 7, 31, 1, 22),
(68, 1, 5, 'TI_MICRO-10', 2, 45, 'Selasa', '09:40:00', '12:10:00', 7, 31, 9, 22),
(69, 1, 5, 'TI_MICRO-11', 2, 46, 'Senin', '09:40:00', '12:10:00', 7, 31, 1, 22),
(70, 1, 5, 'TI_MICRO-12', 2, 47, 'Kamis', '13:00:00', '15:30:00', 7, 31, 9, 11),
(71, 1, 5, 'TI_MICRO-13', 2, 48, 'Senin', '07:00:00', '09:30:00', 7, 31, 9, 17),
(72, 1, 5, 'TI_MICRO-14', 2, 49, 'Sabtu', '09:40:00', '12:10:00', 7, 31, 9, 22),
(74, 1, 6, 'TI_MOBILE-1', 2, 54, 'Kamis', '09:40:00', '12:10:00', 5, 24, 6, 6),
(75, 2, 7, 'SI_ALPRO-1', 2, 15, 'Kamis', '07:00:00', '09:30:00', 2, 19, 6, 14),
(76, 2, 7, 'SI_ALPRO-2', 2, 16, 'Kamis', '07:00:00', '21:30:00', 1, 19, 13, 16),
(77, 2, 8, 'SI_STI-1', 2, 15, 'Sabtu', '15:40:00', '18:10:00', 2, 7, 8, 7),
(78, 2, 8, 'SI_STI-2', 2, 16, 'Sabtu', '15:40:00', '18:10:00', 1, 7, 12, 11),
(79, 2, 9, 'SI_JARKOM-1', 2, 33, 'Selasa', '09:40:00', '12:10:00', 6, 30, 12, 18),
(81, 2, 10, 'SI_WEB-1', 2, 33, 'Kamis', '09:40:00', '12:10:00', 1, 8, 8, 16),
(82, 2, 10, 'SI_WEB-2', 2, 34, 'Kamis', '09:40:00', '12:10:00', 2, 8, 2, 23),
(83, 2, 11, 'SI_BD2-1', 2, 33, 'Kamis', '15:40:00', '18:10:00', 1, 28, 3, 11),
(86, 2, 12, 'SI_SO-2', 2, 52, 'Kamis', '13:00:00', '15:30:00', 3, 33, 6, 5),
(87, 2, 13, 'SI_AA-1', 2, 51, 'Senin', '15:40:00', '18:10:00', 2, 38, 7, 18),
(88, 2, 13, 'SI_AA-2', 2, 52, 'Senin', '15:40:00', '18:10:00', 1, 38, 10, 15);

-- --------------------------------------------------------

--
-- Struktur dari tabel `trs_mentoring`
--

CREATE TABLE `trs_mentoring` (
  `id_mentoring` int(11) NOT NULL,
  `id_frekuensi` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `uraian_materi` text DEFAULT NULL,
  `uraian_tugas` text DEFAULT NULL,
  `hadir` int(11) DEFAULT NULL,
  `alpa` int(11) DEFAULT NULL,
  `status_dosen` varchar(10) DEFAULT NULL,
  `status_asisten1` varchar(10) DEFAULT NULL,
  `status_asisten2` varchar(10) DEFAULT NULL,
  `id_asisten_pengganti` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `trs_mentoring`
--

INSERT INTO `trs_mentoring` (`id_mentoring`, `id_frekuensi`, `tanggal`, `uraian_materi`, `uraian_tugas`, `hadir`, `alpa`, `status_dosen`, `status_asisten1`, `status_asisten2`, `id_asisten_pengganti`) VALUES
(1, 7, '2024-09-28', 'Pengenalan Komponen PC', 'Tugas Merakit PC', 20, 5, 'Hadir', 'Hadir', 'Hadir', NULL),
(2, 32, '2024-10-07', 'Penggunaan Array dan Struct', 'Tugas penduhuan \r\nMengetahui apa itu stact dan queue', 24, 4, 'Hadir', 'Hadir', 'Hadir', NULL),
(3, 87, '2024-10-07', 'Pengenalan Aplikasi Sidek', '-', 12, 8, 'Hadir', 'Hadir', 'Hadir', NULL),
(4, 88, '2024-10-07', 'Pengenalan Aplikasi Sidek,\r\nPenjelasan terkait langkah-langkah pengisian disetiap menu yang ada di aplikasi\r\n', '-', 18, 2, 'Hadir', 'Hadir', NULL, 22),
(6, 33, '2024-10-07', 'Array and Struct', 'Tugas Pendahuluan I\r\nTugas Evaluasi Praktikum I', 22, 5, 'Hadir', 'Hadir', 'Hadir', NULL),
(7, 46, '2024-10-08', 'Relationship(ERD), DDL', 'Pengenalan Penggunaan Workbench\r\nStudi Kasus membuat database apotek', 12, 7, 'Hadir', 'Hadir', 'Hadir', NULL),
(10, 34, '2024-10-07', 'struktur pemrograman pada c++', 'TP1 stack dan queu dan konsep FIFO dan LIFO', 21, 3, 'Hadir', 'Hadir', 'Hadir', NULL),
(11, 68, '2024-10-08', 'tinkercard, push-button & Buzzer', 'mengerjakan kegiatan praktikum dan soal kasus materi dosen, pemberian tugas tinkercard untuk dikerja dirumah', 21, 3, 'Hadir', 'Hadir', 'Hadir', NULL),
(12, 43, '2024-10-08', 'Modul 1 ERD dan DLL serta pengenalan aplikasi Workbench', 'Studi Kasus Modul 1 dan Evaluasi Praktikum 1', 21, 3, 'Hadir', 'Hadir', 'Hadir', NULL),
(13, 45, '2024-10-08', 'Relationship (ERD), DDL', 'membuat database dan membuat tabel yang saling berelasi', 22, 2, 'Hadir', 'Hadir', 'Hadir', NULL),
(15, 50, '2024-10-09', 'Relationship (ERD) dan DDL. (Modul 1)', 'Mengerjakan kegiatan praktikum, yakni membuat schema database sekaligus menginput data ke 2 tabel di database', 19, 5, 'Hadir', 'Hadir', 'Hadir', NULL),
(16, 29, '2024-10-09', 'Materi mengenai tentang Double Linked List ', 'Tugas yang dikerjakan yaitu membuat program stack dan queue', 14, 7, 'Hadir', 'Hadir', 'Hadir', NULL),
(17, 49, '2024-10-09', 'Modul 1 ERD dan DLL serta pengenalan aplikasi Workbench', 'Evaluasi Praktikum Modul 1', 22, 3, 'Hadir', 'Hadir', 'Hadir', NULL),
(18, 28, '2024-10-09', 'double linklist', 'Tugas Evaluasi stuck and queu', 21, 2, 'Hadir', NULL, 'Hadir', NULL),
(19, 40, '2024-10-09', 'Stack', '1. Pengerjaan Studi Kasus\r\n2. Tugas Evaluasi Praktikum I', 24, 0, 'Hadir', 'Hadir', 'Hadir', NULL),
(20, 66, '2024-10-09', 'Pertemuan 5 : Push Button & Buzzer', 'merancang dengan komponen push button dan buzzer', 24, 3, 'Hadir', 'Hadir', 'Hadir', NULL),
(21, 65, '2024-10-09', ' Simulator\r\n Tinkercad\r\n Penggunaan Tinkercad\r\n Soal Kasus', 'Merangkai Led berdasarkan tugas praktikum dan studi kasus', 15, 9, 'Hadir', 'Hadir', 'Hadir', NULL),
(22, 41, '2024-10-09', 'Stack', 'Pengerjaan Studi Kasus Dan Tugas Evaluasi Praktikum I', 20, 0, 'Hadir', 'Hadir', 'Hadir', NULL),
(24, 67, '2024-10-08', 'Switch\r\nPush Button\r\n Buzzer', 'Merangkai push button, buzzer sesuai tugas praktikum dan studi kasus', 24, 1, 'Hadir', 'Hadir', 'Hadir', NULL),
(25, 30, '2024-10-10', 'Stack & Queue', 'Implementasi program Stack & Queue', 13, 8, 'Hadir', 'Hadir', 'Hadir', NULL),
(26, 53, '2024-10-10', 'erd, dan ddl', 'lembar evaluasi praktikum 1, modul 1 mengenai erd dan ddl', 16, 5, 'Hadir', 'Hadir', 'Hadir', NULL),
(27, 70, '2024-10-10', 'Pertemuan 5 : Push Button dan Buzzer', 'Tugas Pembuatan rangkaian dengan komponen Push Button dan Buzzer', 19, 3, 'Hadir', 'Hadir', 'Hadir', NULL),
(28, 44, '2024-10-11', 'Pertemuan 5 : Push-Button & BUzzer', 'merangkai dengan komponen push-button & buzzer', 12, 10, 'Hadir', 'Hadir', 'Hadir', NULL),
(29, 47, '2024-10-11', 'pertemuan 5 : Push-Buttom & Buzzer', 'merangkai menggunakan komponen push button & buzzer', 12, 10, 'Hadir', NULL, 'Hadir', 9),
(30, 63, '2024-10-11', 'Switch\r\nPush Button\r\nBuzzer', 'Merangkai komponen pushbutton, buzzer, dan led sesuai dengan tugas praktikum dan studi kasus', 13, 9, 'Hadir', 'Hadir', 'Hadir', NULL),
(31, 62, '2024-10-10', 'Switch Push Button Buzzer', 'Merangkai komponen pushbutton, buzzer, dan led sesuai dengan tugas praktikum dan studi kasus', 5, 20, 'Hadir', 'Hadir', 'Hadir', NULL),
(32, 64, '2024-10-11', 'pertemuan 5 menjelaskan penggunaan switch, push button dan buzzer serta bagaimana cara merangkainya. Mengerjakan tugas praktikum 1-4 dan studi kasus', 'mengerjakan tugas pertemuan 2 dan 3 pada tingkercard', 3, 14, 'Hadir', 'Hadir', 'Hadir', NULL),
(33, 72, '2024-10-12', 'Pertemuan 5 : Push-Button & Buzzer', 'merangkai menggunakan komponen push button dan buzzer', 7, 19, 'Hadir', 'Hadir', 'Hadir', NULL),
(34, 36, '2024-10-12', 'Struct', 'Membuat  struct di dalam function', 13, 7, NULL, NULL, 'Hadir', 1),
(40, 71, '2024-10-14', 'pertemuan 5 : push button & buzzer', 'merangkai rangkaian dengan komponen push button & buzzer', 11, 1, 'Hadir', 'Hadir', 'Hadir', NULL),
(41, 69, '2024-10-14', 'pertemuan 5 menjelaskan cara penggunaan switch,push button dan buzzer mengerjakan praktikum 1-4 dan studi kasus dan kelas pengganti dijam 13.00 untuk pertemuan 6 menjelaskan penggunaan seven segmen dan tugas praktikum 1-2 studi kasus 1-2', 'mengerjakan tugas evaluasi 4', 19, 3, 'Hadir', 'Hadir', 'Hadir', NULL),
(42, 20, '2024-10-14', 'Modul 1 : Selection Statement (IF Statement)', 'Tugas Evaluasi Praktikum 1\r\n- Studi Kasus A & B', 25, 2, 'Hadir', 'Hadir', 'Hadir', NULL),
(43, 88, '2024-10-14', 'Cara persiapan dan pembuatan akun SIDEK', 'Data Kasus Simulasi: Akun Dan Daftar Saldo, serta Pembentukan Akun dan Daftar Saldo di Aplikasi', 18, 2, 'Hadir', 'Hadir', 'Hadir', NULL),
(44, 32, '2024-10-15', 'Pengimplementasian kode array dan queue dalam bahasa pemrograman C++ ', 'Tugas Evaluasi\r\nPengimplementasian stack pada bahasa pemrograman C++\r\nTugas Pendahuluan \r\nPenjelasan Teori menganai konsep kerja stack', 24, 4, 'Hadir', 'Hadir', 'Hadir', NULL),
(46, 46, '2024-10-15', 'DML, SQL JOIN, VIEW', 'Studi Kasus', 12, 7, 'Hadir', 'Hadir', 'Hadir', NULL),
(47, 68, '2024-10-15', 'Pertemuan 6 : Seven Segment', 'merangkai menggunakan komponen seven segment', 21, 3, 'Hadir', 'Hadir', 'Hadir', NULL),
(48, 67, '2024-10-15', 'pertemuan 6 menjelaskan mengenai seven segmen cara merangkai ', 'mengerjakan tugas praktikum dan studi kasus', 23, 2, 'Hadir', 'Hadir', 'Hadir', NULL),
(50, 87, '2024-10-15', 'Pembuatan nama akun dan jurnal umum', 'mengerjakan studi kasus pada modul', 15, 5, 'Hadir', 'Hadir', 'Hadir', NULL),
(52, 79, '2024-10-15', 'Pengenalan Layout Aplikasi Cisco Packet Tracer', 'Membuat Rangkaian Topologi Star', 21, 4, 'Hadir', 'Hadir', 'Hadir', NULL),
(53, 17, '2024-10-15', 'Modul 1: Selection Statement (IF Selection)', '1. Studi Kasus, 2. Tugas Evaluasi I', 26, 0, 'Hadir', 'Hadir', 'Hadir', NULL),
(57, 43, '2024-10-15', 'Data Manipulation Language (DML)', 'Studi Kasus dan Evaluasi Praktikum 2', 22, 2, 'Hadir', 'Hadir', 'Hadir', NULL),
(58, 15, '2024-10-15', 'operator Aritmatika, relational, logika dan bitwise', 'TUGAS EVALUASI 1, if selection', 23, 15, 'Hadir', 'Hadir', 'Hadir', NULL),
(59, 34, '2024-10-15', 'modul 1, stack and queu', 'TUGAS EVALUASI 1 MODUL 2, singel linked list', 20, 3, 'Hadir', 'Hadir', 'Hadir', NULL),
(62, 31, '2024-10-15', 'Stack & Queue	', 'Implementasi program Stack & Queue', 14, 10, 'Hadir', 'Hadir', 'Hadir', NULL),
(63, 16, '2024-10-16', 'Pengenala sintax input dan output serta implementasi opertator aritmatika', 'Tugas Evaluai Prkatikum\r\nmengimplementasikan kodingan untuk mehitung pajak kendaraan', 20, 2, 'Hadir', 'Hadir', 'Hadir', NULL),
(65, 58, '2024-10-16', 'Modul 2 : DML, SQL Join, View', 'Tugas Evaluasi Praktikum II', 18, 2, 'Hadir', 'Hadir', 'Hadir', NULL),
(66, 57, '2024-10-16', 'Modul 2 pengimplementasian dml, sql join, view', 'Tugas Evaluasi membuat sebuah struktur database dengan mengimplementasikan dml, sql join, view', 22, 2, 'Hadir', 'Hadir', 'Hadir', NULL),
(67, 29, '2024-10-16', 'Single Linked List', 'Membuat Program Single Linked List', 16, 5, 'Hadir', 'Hadir', 'Hadir', NULL),
(68, 28, '2024-10-16', 'modul2, Single linked list', 'tugas evaluasi praktikum 2 mengenai Single Linked List', 21, 3, 'Hadir', 'Hadir', 'Hadir', NULL),
(69, 65, '2024-10-16', 'menjelaskan mengenai switch,push button dan buzzer serta cara merangkai', 'merangkai swicth, push button dan buzzer serta mengerjakan tugas praktikum 1-4 dan studi kasus', 17, 7, 'Hadir', NULL, 'Hadir', 9),
(70, 41, '2024-10-16', 'Queue', 'Kegiatan praktikum Queue', 18, 2, NULL, 'Hadir', 'Hadir', NULL),
(71, 50, '2024-10-16', 'Melakukan DDL dan DML di MySQL Workbench', 'mengerjakan studi kasus yang diberikan dosen. Membuat 7 tabel yang beberapa tabel berelasi, dan di inputkan nilai.', 12, 11, 'Hadir', 'Hadir', 'Hadir', NULL),
(72, 52, '2024-10-16', 'ERD, DDL', 'Mengerjakan STUDI Kasus ERD Apotek', 14, 1, 'Hadir', 'Hadir', 'Hadir', NULL),
(73, 25, '2024-10-16', 'Modul 1 praktikum SELECTION STATEMENT: IF SELECTION', 'Studi kasus IF ELSE', 25, 0, 'Hadir', 'Hadir', 'Hadir', NULL),
(74, 26, '2024-10-16', 'MODUL 1 -SELECTION STATEMENT: IF SELECTION dan mengerjakan praktik dari internet untuk mendalami selection IF', 'Mengerjakan studi kasus a pada modul, buat kalkulator BMI (Body Mass Index)', 24, 1, 'Hadir', 'Hadir', 'Hadir', NULL),
(75, 23, '2024-10-16', 'Perintah Dasar Input dan Output', 'Latihan 1, Latihan 2, Latihan 3, dan Latihan 4 dasar input output', 27, 1, 'Hadir', 'Hadir', 'Hadir', NULL),
(76, 40, '2024-10-16', 'Queue', '1. Studi Kasus, 2. Tugas Evaluasi Praktikum II', 22, 2, NULL, 'Hadir', 'Hadir', NULL),
(77, 51, '2024-10-16', 'Implementasi perintah DDL dan DML dalam membuat database apotik', 'tugas Evaluasi praktikum\r\nmengerjakan studi kasus dalam Implementasi perintah DDL dan DML dalam membuat database ', 19, 4, 'Hadir', 'Hadir', 'Hadir', NULL),
(78, 30, '2024-10-17', 'SingleLinkedList', 'Studi kasus implementasi SingleLinkedList', 12, 9, 'Hadir', 'Hadir', 'Hadir', NULL),
(79, 81, '2024-10-17', 'Modul 1 : Elemen Dasar HTML', 'Tugas Evaluasi Praktikum I', 15, 6, 'Hadir', 'Hadir', 'Hadir', NULL),
(80, 66, '2024-10-17', 'pertemuan 6 : Seven Segment', 'merangkai rangkaian arduino menggunakan seven segment', 16, 11, 'Hadir', 'Hadir', 'Hadir', NULL),
(81, 82, '2024-10-17', 'Pengenalan tag dasar html', 'tugas evaluasi praktikum\r\nmembuat sebuah web sederhana menggunakan tag dasar html', 31, 2, 'Hadir', 'Hadir', 'Hadir', NULL),
(82, 62, '2024-10-17', 'menjelaskan mengenai seven segmen dan merangkainya serta mengerjakan tugas praktikum', 'mengerjakan tugas praktikum dan studi kasus\r\n', 18, 7, 'Hadir', 'Hadir', 'Hadir', NULL),
(84, 70, '2024-10-17', 'pertemuan 6 : seven segment', 'merangkai dengan menggunakan komponen seven segment', 20, 2, 'Hadir', 'Hadir', 'Hadir', NULL),
(85, 83, '2024-10-17', 'DDL Tingkat Lanjut', 'Kegiatan Praktikum', 23, 3, 'Hadir', 'Hadir', 'Hadir', NULL),
(86, 31, '2024-10-17', 'Single Linked List', 'Kegiatan Praktikum', 16, 8, 'Hadir', 'Hadir', NULL, NULL),
(87, 76, '2024-10-17', 'membuat variabel, input, dan output', 'membuat kalkulator sederhana', 23, 5, NULL, 'Hadir', 'Hadir', NULL),
(88, 75, '2024-10-17', 'pengenalan syntax input output di c++', 'input output sederhan', 28, 6, NULL, 'Hadir', 'Hadir', NULL),
(89, 47, '2024-10-18', 'Seven Segmen', 'Studi Kasus', 11, 11, 'Hadir', 'Hadir', 'Hadir', NULL),
(90, 21, '2024-10-18', 'INPUT OUTPUT\r\nVARIABEL', '1. membuat program input nama, nim, kelas dan alamat dan menampilkan hasil inputan.\r\n2. membuat program menghitung umur dari selisih tahun sekarang dan tahun lahir\r\n3. membuat program menghitung tahun sekarang dari selisih tahun lahir dan umur', 21, 4, 'Hadir', 'Hadir', 'Hadir', NULL),
(91, 55, '2024-10-18', 'DML, SQL JOIN, VIEW', 'Kegiatan Praktikum', 26, 3, 'Hadir', 'Hadir', 'Hadir', NULL),
(92, 22, '2024-10-18', 'belajar membuat variable, cin, cout', 'TUGAS EVALUASI 1, membuat kalkulator sederhana', 22, 3, 'Hadir', 'Hadir', NULL, NULL),
(93, 27, '2024-10-19', 'Dasar Input Output', 'Latihan 1, Latihan 2, Latihan 3, dan Latihan 4 ', 26, 2, 'Hadir', 'Hadir', 'Hadir', NULL),
(94, 37, '2024-10-19', 'Modul 1 Stack dan Queue', 'implementasi stack dan queue', 12, 9, 'Hadir', 'Hadir', 'Hadir', NULL),
(95, 36, '2024-10-19', 'Stack', 'Studi Kasus implementasi Stack', 10, 10, 'Hadir', 'Hadir', NULL, 21),
(96, 61, '2024-10-19', 'seven segment', 'menampilkan angka secara bergantian & menampilkan nim secara berurutan', 19, 4, 'Hadir', 'Hadir', 'Hadir', NULL),
(97, 20, '2024-10-21', 'Modul 2 : Selection Statement (SWITCH-CASE Statement)	', 'Tugas Evaluasi Praktikum 2 - Studi Kasus A & B	', 3, 23, 'Hadir', 'Hadir', 'Hadir', NULL),
(99, 69, '2024-10-21', 'pertemuan 6 mahasiswa ditugaskanuntuk melengkapi kegiatan praktikum yang tidak dapat diselesaikan pada pertemuan sebelumnya', 'mengerjakan tugas praktikum sebelumnya', 16, 0, 'Hadir', 'Hadir', 'Hadir', NULL),
(100, 32, '2024-10-21', 'pengenalan single linked list dan stack', 'penggunaan single linked list, membuat program dengan menggunakan single linked list', 24, 4, 'Hadir', 'Hadir', 'Hadir', NULL),
(101, 34, '2024-10-21', 'Single Linked List', 'Tugas Evaluasi Praktikum TP 2 Single linked list ', 17, 6, 'Hadir', NULL, 'Hadir', NULL),
(102, 33, '2024-10-14', 'Queue', 'Tugas Pendahuluan II, Tugas Evaluasi Praktikum II', 19, 8, 'Hadir', 'Hadir', 'Hadir', NULL),
(103, 33, '2024-10-21', 'Stack', 'Tugas Pendahuluan III, Tugas Evaluasi III', 20, 7, 'Hadir', 'Hadir', 'Hadir', NULL),
(105, 72, '2024-10-22', 'pertemuan 6 : Seven Segment', 'merangkai menggunakan seven segment', 10, 16, 'Hadir', 'Hadir', 'Hadir', NULL),
(106, 64, '2024-10-22', 'pertemuan 6 : seven segment', 'mernagkai menggunakan seven segment', 6, 11, 'Hadir', 'Hadir', 'Hadir', NULL),
(107, 71, '2024-10-22', 'pertemuan 6 : seven segment ', 'mernagkai menggunakan seven segment', 9, 3, 'Hadir', 'Hadir', 'Hadir', NULL),
(108, 71, '2024-10-22', 'pertemuan 7 : melengkapi tugas', 'melengkapi tugas yang belum selesai', 10, 2, 'Hadir', 'Hadir', 'Hadir', NULL),
(110, 67, '2024-10-22', 'mengerjakan tugas praktikum bagi mahasiswa yang tidak dapat menyelesaikan tugas praktikum pertemuan sebeleumnya ', 'mengerjakan tugas praktikum pekan lalu', 24, 0, 'Hadir', NULL, 'Hadir', 9),
(111, 8, '2024-10-22', 'Perakitan Personal Komputer', 'Merakit PC Secara Berkelompok', 24, 8, 'Hadir', 'Hadir', 'Hadir', NULL),
(113, 79, '2024-10-22', 'Transmisi Jaringan', 'Membuat Kabel LAN', 21, 5, NULL, 'Hadir', 'Hadir', NULL),
(115, 46, '2024-10-22', 'SQL DML(2)\r\n- Select Distinct, Group by, Having\r\n	- Order By, Limit\r\n	- SQL JOIN', 'Studi Kasus Modul', 15, 4, 'Hadir', NULL, 'Hadir', NULL),
(116, 49, '2024-10-16', 'DML ', 'Studi Kasus dan Evaluasi Praktikum 2', 17, 8, 'Hadir', 'Hadir', 'Hadir', NULL),
(117, 43, '2024-10-22', 'Distinct, Group by, dan Having', 'Studi Kasus dan Evaluasi Praktikum 3', 20, 4, 'Hadir', 'Hadir', 'Hadir', NULL),
(118, 16, '2024-10-22', 'Penerepan Sintax Selection dalam pemrograman c++', 'Membuat program dengan mengimplementasikan selection yakni sintax if else dan switch case', 29, 7, 'Hadir', 'Hadir', 'Hadir', NULL),
(119, 17, '2024-10-22', 'Modul 2 : Selection Statement (SWITCH-CASE Statement)', 'Studi Kasus, Tugas Evaluasi Praktikum II', 22, 4, 'Hadir', 'Hadir', 'Hadir', NULL),
(120, 14, '2024-10-22', 'Booting', 'Evaluasi Praktikum 1', 27, 1, 'Hadir', 'Hadir', 'Hadir', NULL),
(122, 9, '2024-10-22', 'Penjelasan seputar BIOS, penjelasan seputar task manager & komponen PC', 'penggunakan BIOS', 25, 0, 'Hadir', 'Hadir', 'Hadir', NULL),
(124, 45, '2024-10-22', 'DML', 'Implementasi perintah DML', 21, 3, 'Hadir', 'Hadir', 'Hadir', NULL),
(125, 45, '2024-10-22', 'Distinct, Group by, Having', 'Implementasi perintah distinct group by dan having', 17, 7, 'Hadir', 'Hadir', 'Hadir', NULL),
(126, 87, '2024-10-23', 'Melanjutkan penjurnalan umum', 'Melanjutkan penjurnalan umum yang sebelumnya dikerjakan di pertemuan 1', 14, 6, 'Hadir', 'Hadir', 'Hadir', NULL),
(127, 50, '2024-10-23', 'Modul 3 - Distinct, Group By, Having', 'Mengerjakan Studi kasus di modul 3 yang merupakan praktik Conditional Select Statement dengan Klausa Where', 19, 5, 'Hadir', 'Hadir', 'Hadir', NULL),
(128, 58, '2024-10-23', 'Asisten 1 : Modul 1 & 2', 'Asisten 1 : Modul 1 & 2', 20, 0, NULL, 'Hadir', 'Hadir', NULL),
(130, 57, '2024-10-23', 'Asistensi 1', '-', 20, 4, 'Hadir', 'Hadir', 'Hadir', NULL),
(131, 28, '2024-10-23', 'singel linked list', 'implementasi stack dan queue menggunakan single linked list', 18, 5, 'Hadir', 'Hadir', NULL, 24),
(132, 86, '2024-10-23', 'dasar-dasar penggunaan command prom ', 'perintah membuat folder, masuk folder, mengisi file dengan perintah echo, tambilkan file dengan perintah type, dan perintah hapus file', 18, 1, 'Hadir', 'Hadir', 'Hadir', NULL),
(133, 86, '2024-10-23', 'perintah dasar terminal', 'perintah membuat folder, file berisi nama dan nim,menampilkan file, menghapus', 18, 1, 'Hadir', NULL, 'Hadir', 24),
(134, 29, '2024-10-23', 'stack and queue', 'Implementasi stack and queue dengan single linked list', 17, 4, 'Hadir', 'Hadir', 'Hadir', NULL),
(136, 41, '2024-10-23', 'SingleLinkedList', 'Studi Kasus Modul', 18, 2, NULL, 'Hadir', 'Hadir', NULL),
(137, 65, '2024-10-23', 'menjelaskan mengenai seven segment dan mengerjakan tugas praktikum', 'mengerjakan tugas praktikum dan studi kasus', 16, 6, 'Hadir', 'Hadir', 'Hadir', NULL),
(138, 23, '2024-10-23', 'If Selection', 'Studi Kasus a dan b', 26, 2, 'Hadir', 'Hadir', 'Hadir', NULL),
(139, 51, '2024-10-23', 'mengimplementasikan perintah DML, SQL JOIN, VIEW', 'membuat sebuah struktur database dengan mengimplementasikan perintah DML, SQL JOIN, VIEW', 20, 3, 'Hadir', 'Hadir', 'Hadir', NULL),
(140, 26, '2024-10-23', 'Modul 2 - SELECTION STATEMENT: SWITCH SELECTION', 'Mengerjakan Studi Kasus a pada modul 2 iclabs', 25, 0, 'Hadir', 'Hadir', 'Hadir', NULL),
(141, 52, '2024-10-23', 'DML', 'latihan DML, View, JOIN', 10, 5, 'Hadir', 'Hadir', 'Hadir', NULL),
(142, 25, '2024-10-23', 'Modul 2 Switch case', 'studi kasus switch case', 25, 0, 'Hadir', 'Hadir', 'Hadir', NULL),
(143, 66, '2024-10-23', 'Review materi minggu - minggu sebelumnya', 'Menyelesaikan tugas praktikum bagi praktikan yang belum selesai', 21, 6, 'Hadir', 'Hadir', 'Hadir', NULL),
(144, 40, '2024-10-23', 'Single Linked List', 'Membuat aplikasi sederhana menggunakan Single Linked List', 18, 6, NULL, 'Hadir', 'Hadir', NULL),
(145, 24, '2024-10-23', 'Mengimplementasikan penggunaan selection statement pada C++', 'Mengerjakan studi kasus yang ada di modul 1', 24, 2, 'Hadir', 'Hadir', 'Hadir', NULL),
(146, 31, '2024-10-24', 'Single Linked List', 'Implementasi Stack dan Queue dengan single linked list', 10, 14, 'Hadir', 'Hadir', 'Hadir', NULL),
(147, 75, '2024-10-24', 'Modul 1 Selection If Else', 'Studi Kasus', 32, 5, 'Hadir', 'Hadir', 'Hadir', NULL),
(148, 74, '2024-10-24', 'Input Control', 'studi kasus', 2, 9, 'Hadir', 'Hadir', 'Hadir', NULL),
(149, 62, '2024-10-24', 'mengerjakan tugas pratikum bagi mahasiswa yang tidak dapat menyelesaikan pertemuan sebeleumnya', 'mengerjakan tugas praktikum dan studi kasus sebelumnya', 20, 5, 'Hadir', 'Hadir', 'Hadir', NULL),
(150, 53, '2024-10-24', 'mempelajari tentang dml, sql, join dan view', 'studi kasus, modul 2 membuat database dengan nama apotik', 11, 9, 'Hadir', 'Hadir', 'Hadir', NULL),
(151, 53, '2024-10-24', 'modul 3 tentang Distinct, Group by, Having', 'membuat table, mengisi record, memasukkan data, mengupdate, menghapus data, dan melakukan select data', 10, 10, 'Hadir', 'Hadir', 'Hadir', NULL),
(153, 70, '2024-10-24', 'melanjutkan tugas', 'menyelesaikan tugas praktikum yang belum selesai , dan memeriksa komponen yang rusak', 18, 4, 'Hadir', 'Hadir', 'Hadir', NULL),
(154, 83, '2024-10-24', 'DML Tingkat Lanjut', 'Kegiatan Praktikum', 20, 6, 'Hadir', 'Hadir', 'Hadir', NULL),
(155, 21, '2024-10-25', 'Selection If', 'Menghitung BMI dan Rekomendasi vaksin covid', 21, 4, NULL, 'Hadir', 'Hadir', NULL),
(156, 22, '2024-10-25', 'mempelajari tentang if selection', 'studi kasus  modul 1 membuat kalkulator BMI', 24, 1, 'Hadir', 'Hadir', 'Hadir', NULL),
(157, 44, '2024-10-25', 'pertemuan 6 : seven segment', 'merangkai menggnuakan seven segment ', 16, 6, 'Hadir', 'Hadir', NULL, NULL),
(158, 44, '2024-10-25', 'pertemuan 7 : Melengkapi tugas', 'melengkapi tugas yang belum selesai serta belajar persiapan MID', 15, 7, 'Hadir', 'Hadir', NULL, 18),
(159, 63, '2024-10-25', 'PERTEMUAN 6 : SEVEN SEGMENT ', 'Merangkai menggunakan seven segment', 17, 5, 'Hadir', 'Hadir', 'Hadir', NULL),
(160, 56, '2024-10-04', 'Modul 1 Pengenala fitur dasar Aplikasi mysql workbench', 'Mebuat Realation Table menggunakan Aplikasi mysql workbench', 24, 1, 'Hadir', 'Hadir', 'Hadir', NULL),
(161, 63, '2024-10-25', 'pertemuan 7 : melengkapi tugas ', 'melengkapi tugas praktikum yang belum selesai & pengecekan komponen yang rusak , dan belajar persiapan MID', 15, 7, 'Hadir', 'Hadir', 'Hadir', NULL),
(162, 56, '2024-10-25', 'Membuat Design Database sesuai dengan ide masing', 'Mengimplementasikan Design Database sesuai dengan ide masing', 24, 1, 'Hadir', 'Hadir', 'Hadir', NULL),
(163, 56, '2024-10-18', 'Modul 2 pengimplementasian dml, sql join, view', 'Tugas Evaluasi membuat sebuah struktur database dengan mengimplementasikan dml, sql join, view', 24, 1, 'Hadir', 'Hadir', 'Hadir', NULL),
(164, 56, '2024-10-25', 'Asistensi-1', '-', 24, 1, NULL, 'Hadir', 'Hadir', NULL),
(165, 6, '2024-10-25', 'Modul 1 - Perakitan Personal Computer (PC)', 'Melakukan Perakitan PC ', 23, 2, 'Hadir', 'Hadir', 'Hadir', NULL),
(166, 4, '2024-10-25', 'Modul 1 - Perakitan Personal Computer (PC) dan Modul 2 - Proses Booting Sistem Informasi', 'Merakit pc, mulai dari membongkar hingga memasang dan memastikan pc yang dibongkar tetap menyala. Kemudian lanjut membahas mengenai booting pada sistem operasi windows.', 22, 4, 'Hadir', 'Hadir', 'Hadir', NULL),
(167, 3, '2024-10-26', 'Modul 2 - Proses Booting Sistem Operasi', 'Melakukan praktikum di BIOS pada pc', 31, 4, 'Hadir', 'Hadir', 'Hadir', NULL),
(168, 83, '2024-10-26', 'Trigger', 'studi kasus modul Implementasi trigger ', 5, 21, NULL, 'Hadir', 'Hadir', NULL),
(169, 36, '2024-10-26', 'Queue', 'studi kasus modul Implementasi queue', 12, 8, 'Hadir', 'Hadir', 'Hadir', NULL),
(170, 2, '2024-10-26', 'PERAKITAN PERSONAL COMPUTER (PC)', 'tugas kegiatan praktikum merakit pc, tugas evaluasi 1 modul 1 menjelaskan komponen\" pada pc, dll', 26, 9, 'Hadir', 'Hadir', 'Hadir', NULL),
(171, 37, '2024-10-26', 'Modul 1 Queue', 'studi kasus queue', 13, 7, 'Hadir', 'Hadir', 'Hadir', NULL),
(172, 12, '2024-10-26', '1. Perakitan Personal Computer (PC),\r\n2. Proses Booting Sistem Oprasi\r\n', 'Kegiatan Praktikum merakit PC dan proses booting', 23, 2, 'Hadir', 'Hadir', 'Hadir', NULL),
(174, 61, '2024-10-26', 'Seven Segment & Buzzer', 'Lanjutkan tugas yang belum selesai pertemuan sebelumnya', 15, 8, 'Hadir', 'Hadir', 'Hadir', NULL),
(176, 78, '2024-10-26', 'Pengenalan Bios', 'Setting bios', 27, 0, 'Hadir', 'Hadir', 'Hadir', NULL),
(177, 77, '2024-10-26', 'Modul 1 : Komponen\" PC', 'Merkait PC', 30, 7, 'Hadir', 'Hadir', 'Hadir', NULL),
(178, 10, '2024-10-26', 'Merakit Komponen Perangkat Keras', 'Evaluasi Praktikum Modul 2', 28, 0, 'Hadir', 'Hadir', 'Hadir', NULL),
(179, 88, '2024-10-21', 'Pencatatan Akun', 'Pencatatan Akun Dari Soal', 16, 4, 'Hadir', 'Hadir', NULL, 21),
(180, 49, '2024-10-23', 'Distinct, Group by, dan Having	', 'Studi Kasus dan Evaluasi Praktikum 3', 35, 2, 'Hadir', 'Hadir', 'Hadir', NULL),
(183, 27, '2024-10-25', 'If Selection', 'Studi Kasus dan Evaluasi Praktikum Modul 1', 22, 6, 'Hadir', NULL, 'Hadir', NULL),
(184, 69, '2024-10-28', 'Mengerjakan UTS', 'UTS', 18, 4, 'Hadir', 'Hadir', 'Hadir', NULL),
(185, 20, '2024-10-28', 'Looping (For, While, dan Do While)', 'Studi Kasus', 23, 3, 'Hadir', NULL, 'Hadir', 10),
(187, 32, '2024-10-28', '1. pemahaman tentang single linked list\r\n2. add Node\r\n3. Tambah data dari depan\r\n4.  Tambah data dari belakang\r\n', '1. Konsep Double Liked List\r\n2. Perbedaan Single Linked List dengan Double Linked Linked List', 26, 2, 'Hadir', 'Hadir', 'Hadir', NULL),
(188, 33, '2024-10-28', '-', 'Asistensi ke-1 (Stack & Queue)', 22, 5, 'Hadir', 'Hadir', 'Hadir', NULL),
(191, 67, '2024-10-29', 'Mengerjakan UTS', 'UTS', 24, 1, 'Hadir', 'Hadir', 'Hadir', NULL),
(192, 46, '2024-10-29', 'MID', 'soal MID', 15, 4, 'Hadir', 'Hadir', 'Hadir', NULL),
(193, 68, '2024-10-22', 'Pertemuan 7 : Menyelesaikan materi', 'melengkapi Tugas yang belum selesai ', 22, 2, 'Hadir', 'Hadir', 'Hadir', NULL),
(194, 68, '2024-10-29', 'MID MICROCONTROLLER', 'MID MICROCONTROLLER', 23, 1, 'Hadir', 'Hadir', 'Hadir', NULL),
(195, 87, '2024-10-29', 'Melanjutkan penjurnalan umum	', 'Melanjutkan penjurnalan umum yang sebelumnya dikerjakan di pertemuan 2', 11, 8, 'Hadir', 'Hadir', 'Hadir', NULL),
(196, 79, '2024-10-29', 'Konversi Bilangan IP Address dan Subnetting', 'Subnetting IP kelas C', 20, 6, NULL, 'Hadir', 'Hadir', NULL),
(198, 45, '2024-10-29', 'Ujian Tengah Semester', 'Ujian Tengah Semester', 20, 4, 'Hadir', 'Hadir', 'Hadir', NULL),
(199, 17, '2024-10-29', 'Modul 3 : Looping Statement', 'Studi Kasus A dan B', 23, 3, 'Hadir', 'Hadir', 'Hadir', NULL),
(201, 16, '2024-10-29', 'pengenalan dan penggunaan switch case pada sebuah program', 'Tugas Evaluasi 3\r\nmembuat sebuah program dengan mengimplentasikan sebuah switch pada studi kasus ', 26, 10, 'Hadir', 'Hadir', 'Hadir', NULL),
(203, 57, '2024-10-02', 'Modul 1 Pengenala fitur dasar Aplikasi mysql workbench', 'Mebuat Realation Table menggunakan Aplikasi mysql workbench', 24, 0, 'Hadir', 'Hadir', 'Hadir', NULL),
(204, 43, '2024-10-29', 'MID', 'MID TEST', 21, 3, 'Hadir', 'Hadir', 'Hadir', NULL),
(205, 57, '2024-10-09', 'Membuat Design Database sesuai dengan ide masing', 'Mengimplementasikan Design Database sesuai dengan ide masing', 24, 0, 'Hadir', 'Hadir', 'Hadir', NULL),
(206, 14, '2024-10-29', 'Operasi Windows', 'Studi Kasus ', 23, 5, 'Hadir', 'Hadir', 'Hadir', NULL),
(208, 9, '2024-10-29', 'Membogkar pc', 'membongkar semua komponen yang tertancap pada papan maderbot', 23, 2, 'Hadir', 'Hadir', 'Hadir', NULL),
(209, 50, '2024-10-30', 'MID Basis Data 2', 'Mengerjakan mid basis data 2', 20, 4, 'Hadir', 'Hadir', 'Hadir', NULL),
(210, 49, '2024-10-30', 'UTS', 'UTS', 23, 2, NULL, 'Hadir', 'Hadir', NULL),
(211, 57, '2024-10-30', 'Procedure dan Function', 'Studi Kasus Procedure dan Function, dan Evaluasi Procedure dan Function', 24, 0, 'Hadir', 'Hadir', NULL, 10),
(212, 65, '2024-10-30', 'Mengerjakan SOAL UTS', 'UTS', 20, 4, 'Hadir', 'Hadir', 'Hadir', NULL),
(213, 28, '2024-10-30', 'MID TEST', 'MID TEST', 22, 2, 'Hadir', 'Hadir', NULL, 24),
(214, 29, '2024-10-30', '-', 'MID ', 18, 3, 'Hadir', 'Hadir', 'Hadir', NULL),
(215, 58, '2024-10-30', 'Modul 3: Stored Procedure', 'Studi kasis procedure dan function', 15, 15, NULL, 'Hadir', 'Hadir', NULL),
(216, 40, '2024-10-30', 'Double Linked List', 'Mengerjakan studi kasus double linked list', 22, 2, 'Hadir', 'Hadir', 'Hadir', NULL),
(217, 24, '2024-10-30', 'mengimplementasikan penggunaan Selection Statement pada C++.', 'studi kasus pada modul 2', 23, 2, 'Hadir', 'Hadir', 'Hadir', NULL),
(218, 52, '2024-10-30', 'PROCEDURE DAN FUNCTION', 'Latihan Procedure dan Function', 6, 9, NULL, 'Hadir', 'Hadir', NULL),
(219, 51, '2024-10-30', 'mengimplementasikan perintah procedur, Function.', 'membuat sebuah struktur database dengan mengimplementasikan perintah procedur, Function.', 16, 7, NULL, 'Hadir', 'Hadir', NULL),
(220, 66, '2024-10-30', 'Pertemuan 8 : UTS/MID Semester', 'UTS/MID Semester', 17, 10, 'Hadir', 'Hadir', 'Hadir', NULL),
(221, 25, '2024-10-30', 'Looping Statement ', 'membuat studi kasus pengimplementasian for loop', 24, 1, 'Hadir', 'Hadir', 'Hadir', NULL),
(222, 41, '2024-10-30', 'Double Linked List	', 'Mengerjakan studi kasus double linked list', 19, 1, 'Hadir', 'Hadir', 'Hadir', NULL),
(223, 31, '2024-10-31', 'Double Linked List', 'Implementasi Double Linked List', 17, 7, 'Hadir', 'Hadir', 'Hadir', NULL),
(224, 62, '2024-10-31', 'Mengerjakan soal UTS', 'UTS', 19, 6, 'Hadir', 'Hadir', 'Hadir', NULL),
(225, 30, '2024-10-24', 'Queue, Stack, SingleLinkedList', 'implementasi Queue dan Stack menggunakan SingleLinkedList', 13, 8, 'Hadir', NULL, 'Hadir', NULL),
(226, 30, '2024-10-31', 'DoubleLinkedList', 'implementasi doubleLinkedList', 14, 7, 'Hadir', 'Hadir', 'Hadir', NULL),
(227, 82, '2024-10-31', 'Pengimplementasian Table dan Form pada Website', 'Tugas Evaluasi Praktikum \r\n1. Membuat sebuah tampilan form Pengajuan KTP\r\n2. Membuat sebuah tampilan website yang menampilkan jadwal kuliah anda selama satu pekan\r\n', 30, 33, 'Hadir', 'Hadir', 'Hadir', NULL),
(228, 81, '2024-10-31', 'Modul 2 : Tabel dan Form', 'Membuat sebuah form registrasi pendaftaran osis', 14, 8, 'Hadir', 'Hadir', 'Hadir', NULL),
(229, 53, '2024-10-31', 'uts', 'uts', 15, 6, NULL, 'Hadir', 'Hadir', NULL),
(230, 74, '2024-10-31', 'input control', 'studi kasus', 2, 9, 'Hadir', 'Hadir', 'Hadir', NULL),
(231, 70, '2024-10-31', 'Pertemuan 8 : UTS/MID semester', 'UTS/MID semester', 20, 2, NULL, 'Hadir', 'Hadir', NULL),
(233, 83, '2024-10-31', 'Procedure dan Function', 'impementasi Procedure dan Function pada studi kasus di modul', 8, 18, 'Hadir', 'Hadir', 'Hadir', NULL),
(234, 55, '2024-11-01', 'Pertemuan 1 : Relationship (ERD), DDL', 'Kegiatan Praktikum dan tugas evaluasi praktikum', 27, 2, 'Hadir', 'Hadir', 'Hadir', NULL),
(235, 55, '2024-11-01', 'Pertemuan 3 : Design Database', 'Mengimplementasikan Design Database', 9, 20, 'Hadir', 'Hadir', 'Hadir', NULL),
(236, 55, '2024-11-01', 'Pertemuan 4 : Asistensi 1', 'Asistensi 1', 27, 2, NULL, 'Hadir', 'Hadir', NULL),
(237, 55, '2024-11-01', 'Pertemuan 5 : Stored Procedure, Function', 'Studi Kasus Kegiatan Praktikum', 28, 1, NULL, 'Hadir', 'Hadir', NULL),
(238, 47, '2024-11-01', 'MID', '-', 16, 6, 'Hadir', 'Hadir', 'Hadir', NULL),
(239, 76, '2024-11-01', 'IF selection', 'implementasi IF selection', 24, 4, NULL, 'Hadir', 'Hadir', NULL),
(240, 22, '2024-11-01', 'Switch selection', 'implementasi switch selection', 13, 12, 'Hadir', 'Hadir', 'Hadir', NULL),
(241, 47, '2024-10-25', 'Seven Segmen', 'Implementasi Seven Segment pada Studi kasus modul', 14, 8, 'Hadir', 'Hadir', 'Hadir', NULL),
(242, 56, '2024-11-01', 'Procedure dan Function', 'Studi Kasus Procedure dan Function, dan Evaluasi Procedure dan Function', 23, 2, NULL, 'Hadir', 'Hadir', NULL),
(243, 6, '2024-11-01', 'Modul 2. Booting pada PC', 'Eksplorasi menu bios pada pc lab', 21, 4, 'Hadir', 'Hadir', 'Hadir', NULL),
(244, 21, '2024-11-01', 'Switch Case', '1. Membuat program c++  menghitung luas dan keliling persegi, persegi panajang, dan lingkaran\r\n2.  Membuat program c++  menghitung penjualan alat tulis', 22, 3, 'Hadir', 'Hadir', 'Hadir', NULL),
(245, 21, '2024-11-01', 'Switch Case', '1. Membuat program c++  menghitung luas dan keliling persegi, persegi panajang, dan lingkaran\r\n2.  Membuat program c++  menghitung penjualan alat tulis', 22, 3, 'Hadir', 'Hadir', 'Hadir', NULL),
(246, 27, '2024-11-01', 'Switch Selection', 'Studi Kasus dan Evaluasi Praktikum Modul 2', 24, 4, 'Hadir', 'Hadir', 'Hadir', NULL),
(247, 4, '2024-11-01', 'Modul 3. Sistem Operasi Windows', 'Melakukan instalasi windows pada virtualbox', 23, 3, 'Hadir', 'Hadir', 'Hadir', NULL),
(248, 75, '2024-10-31', 'if else dan switch statement', 'Tugas praktikum Evaluasi III', 34, 2, NULL, 'Hadir', 'Hadir', NULL),
(249, 64, '2024-10-25', 'materi : menyelesaikan materi', 'menyelesaikan tugas yang belum selesai', 9, 8, 'Hadir', 'Hadir', 'Hadir', NULL),
(250, 64, '2024-11-01', 'MID ', 'MID', 8, 9, 'Hadir', 'Hadir', 'Hadir', NULL),
(251, 63, '2024-11-01', 'MID MICROCONTROLLER', 'MENYELSAIKAN MID', 16, 6, 'Hadir', 'Hadir', 'Hadir', NULL),
(252, 44, '2024-11-01', 'MID MICROCONTROLLER', 'MID', 13, 9, 'Hadir', 'Hadir', NULL, 18),
(253, 7, '2024-11-01', 'Modul 2 PROSES BOOTING SISTEM OPERASI', 'TUGAS EVALUASI PRAKTIKUM\r\n1. Sebutkan dan jelaskan beberapa jenis booting pada sistem operasi!\r\n2. Uraikan secara umum tahapan-tahapan yang terjadi pada proses booting !\r\n3. Jelaskan proses start up booting pada sistem operasi windows!', 25, 1, 'Hadir', 'Hadir', 'Hadir', NULL),
(254, 2, '2024-11-02', 'Modul 2 : Proses Booting SO', 'Studi kasus', 29, 6, 'Hadir', 'Hadir', 'Hadir', NULL),
(255, 37, '2024-11-02', 'Single Linked List', 'Studi kasus', 12, 9, 'Hadir', 'Hadir', 'Hadir', NULL),
(256, 36, '2024-11-02', 'Single Linked List', 'Implementasi Single Linked List pada studi kasus modul', 13, 7, 'Hadir', 'Hadir', 'Hadir', NULL),
(258, 12, '2024-11-02', 'Pengenalan Sistem Operasi Windows', 'Penginstalan SO Windows menggunakan Virtual Box', 21, 4, 'Hadir', 'Hadir', NULL, 17),
(260, 61, '2024-11-02', 'UTS', 'UTS', 16, 7, 'Hadir', 'Hadir', 'Hadir', NULL),
(261, 10, '2024-11-02', 'Proses Booting', 'Evaluasi Praktikum Modul 2', 28, 0, NULL, 'Hadir', 'Hadir', NULL),
(262, 78, '2024-11-02', 'Perakitan Personal Computer (PC)', 'Perakitan Personal Computer (PC) secara perkelompok', 24, 4, 'Hadir', 'Hadir', 'Hadir', NULL),
(263, 8, '2024-10-29', 'Booting', 'Melakukan Booting', 18, 14, 'Hadir', 'Hadir', 'Hadir', NULL),
(265, 20, '2024-11-04', 'Break dan Continue pada Looping', 'Implementasi Break dan Continue', 25, 1, 'Hadir', 'Hadir', 'Hadir', NULL),
(267, 46, '2024-11-05', 'Join', 'studi kasus', 15, 4, 'Hadir', 'Hadir', 'Hadir', NULL),
(268, 79, '2024-11-05', 'VLAN mode Acces dan trunk', 'Membuat Vlan ', 19, 7, 'Hadir', 'Hadir', 'Hadir', NULL),
(270, 45, '2024-11-05', 'SQL Join', 'studi kasus implementasi query join', 21, 1, NULL, 'Hadir', 'Hadir', NULL),
(271, 87, '2024-11-04', 'Penjurnalan dan Pembuatan Buku Besar', 'Membuat buku besar', 8, 12, 'Hadir', 'Hadir', 'Hadir', NULL),
(272, 15, '2024-11-05', ' operasi aritmatika ', 'menginput, validasi mebayaran dan menghitung sisa uang', 32, 5, 'Hadir', NULL, 'Hadir', 15),
(273, 15, '2024-11-05', 'modul 2 switch selection', 'tugas evaluasi 2 modul 2 SELECTION STATEMENT: SWITCH SELECTION', 33, 5, 'Hadir', 'Hadir', NULL, NULL),
(274, 15, '2024-11-05', 'MID', 'MID', 32, 6, 'Hadir', 'Hadir', 'Hadir', NULL),
(277, 50, '2024-11-06', 'SQL Join', 'Praktik Menggunakan Perintah SQL Join', 19, 5, 'Hadir', 'Hadir', 'Hadir', NULL),
(278, 58, '2024-11-06', 'Ujian Tengah Semester', 'Ujian Tengah Semester', 19, 1, 'Hadir', NULL, 'Hadir', 3),
(279, 16, '2024-11-05', 'MID', '-', 26, 10, 'Hadir', 'Hadir', 'Hadir', NULL),
(283, 49, '2024-11-06', 'JOIN', 'implementasi JOIN', 22, 25, 'Hadir', 'Hadir', 'Hadir', NULL),
(284, 57, '2024-11-06', 'MID', '-', 24, 0, 'Hadir', 'Hadir', 'Hadir', NULL),
(285, 28, '2024-11-06', 'modul 3, materi double linked list', 'tugas evaluasi praktikum mengenai double linked list', 19, 3, NULL, 'Hadir', 'Hadir', NULL),
(286, 29, '2024-11-06', 'Double Linked List', 'Double Linked Lisst', 17, 4, 'Hadir', 'Hadir', NULL, 17),
(287, 65, '2024-11-06', 'menjelaskan mengenai kegunaan RTC dan cara merangkainya', 'mengerjakan tugas praktikum 1-4 dan studi kasus', 18, 6, NULL, 'Hadir', 'Hadir', NULL),
(288, 41, '2024-11-06', 'Perpaduan Single Linked List dengan Stack dan Queue', 'Studi kasus', 19, 1, NULL, 'Hadir', 'Hadir', NULL),
(289, 52, '2024-11-06', 'MID', '-', 14, 1, 'Hadir', 'Hadir', 'Hadir', NULL),
(290, 25, '2024-11-06', 'Looping Statement', 'Mengimplementasikan perintah for, while, do while, dan algoritma Fizz Buzz ', 19, 6, 'Hadir', 'Hadir', 'Hadir', NULL),
(291, 3, '2024-11-02', 'Modul 1 Pengenalan Komponen PC', 'melakukan pembongkaran pc dan merakit kembali pc', 25, 9, 'Hadir', 'Hadir', NULL, NULL),
(292, 26, '2024-10-30', 'Perulangan FOR', 'Praktik menggunakan perulangan for pada C++', 24, 0, 'Hadir', 'Hadir', 'Hadir', NULL),
(293, 26, '2024-11-06', 'Perulangan while dan do while', 'Praktik menggunakan while dan do while dalam C++', 24, 0, 'Hadir', 'Hadir', 'Hadir', NULL),
(294, 77, '2024-11-02', 'Booting dan BIOS pada PC', 'Explore BIOS pada pc yang digunakan praktikan', 30, 6, 'Hadir', 'Hadir', 'Hadir', NULL),
(295, 24, '2024-11-06', 'Mengimplementasikan penggunaan Looping Statement (for, while, do while) pada C++.', 'mengerjakan studi kasus tentang for, while, dan do while', 23, 2, 'Hadir', 'Hadir', 'Hadir', NULL),
(296, 62, '2024-11-07', 'menjelaskan mengenai kegunaan RTC dan cara merangkainya', 'Mengerjakan tugas praktikum 1-4 dan studi kasus', 19, 6, 'Hadir', 'Hadir', 'Hadir', NULL),
(297, 74, '2024-11-07', 'UTS', 'UTS', 2, 9, 'Hadir', 'Hadir', 'Hadir', NULL),
(298, 81, '2024-11-07', 'Modul 3 : CSS', 'Pengerjaan studi kasus', 15, 7, 'Hadir', 'Hadir', 'Hadir', NULL),
(299, 53, '2024-11-07', 'mnjelaskan materi mengenai dml, sql join dan view. ', 'modul 2, mengerjakan studi kasus a-g', 15, 5, 'Hadir', 'Hadir', 'Hadir', NULL),
(300, 86, '2024-11-07', 'batch and bash script', 'membuat bacth file untuk menampilkan tanggal, waktu, memasukkan angka 2 kali, mencari file ', 14, 1, 'Hadir', 'Hadir', 'Hadir', NULL),
(301, 86, '2024-11-07', 'batch and bash script', 'membuat bacth file untuk menampilkan tanggal, waktu, memasukkan angka 2 kali, mencari file ', 14, 1, 'Hadir', 'Hadir', 'Hadir', NULL),
(302, 86, '2024-11-07', 'uts ', 'uts', 15, 4, 'Hadir', 'Hadir', 'Hadir', NULL),
(305, 31, '2024-11-07', 'MID', 'MID', 21, 3, 'Hadir', 'Hadir', NULL, NULL),
(306, 83, '2024-11-07', 'Procedure dan Function	', 'impementasi Procedure pada studi kasus di modul', 21, 5, 'Hadir', 'Hadir', 'Hadir', NULL),
(307, 30, '2024-11-07', 'MID', 'MID', 16, 5, 'Hadir', 'Hadir', NULL, NULL),
(308, 82, '2024-11-07', 'MODUL 3 – Cascading Style Sheet (CSS)', 'Identifikasi dan implementasi Layouting Web pada Framework CSS Boostrap minimal 15 komponen dan class!\r\n', 23, 2, 'Hadir', 'Hadir', 'Hadir', NULL),
(309, 55, '2024-11-08', 'MID', 'MID', 28, 1, 'Hadir', 'Hadir', 'Hadir', NULL),
(310, 47, '2024-11-08', 'RTC', 'Implementasi RTC', 12, 10, 'Hadir', 'Hadir', 'Hadir', NULL),
(311, 21, '2024-11-08', 'For loop\r\nwhile\r\ndo while\r\n', '1. Membuat kalkulator sederhana menggunakan do-while yang memiliki menu:\r\n1. Penjumlahan\r\n2. Pengurangan\r\n3. Perkalian\r\n4. Pembagian\r\n\r\nclue : do-while, switch/if-else\r\n\r\n2. Buatlah sebuah program inputan yang di mana ketika inputannya itu == 0 maka program akan berhenti, akan tetapi jika bukan  == 0 maka program akan terus berjalan. Semua angka yang dimasukkan akan dijumlahkan dan ditampilkan setelah program berhenti\r\n\r\n', 22, 3, 'Hadir', 'Hadir', 'Hadir', NULL),
(312, 21, '2024-11-08', '1. For loop\r\n2. While\r\n3. Do-While', '1. Membuat kalkulator sederhana menggunakan do-while yang memiliki menu:\r\n1. Penjumlahan\r\n2. Pengurangan\r\n3. Perkalian\r\n4. Pembagian\r\n\r\nclue : do-while, switch/if-else\r\n\r\n2. Buatlah sebuah program inputan yang di mana ketika inputannya itu == 0 maka program akan berhenti, akan tetapi jika bukan  == 0 maka program akan terus berjalan. Semua angka yang dimasukkan akan dijumlahkan dan ditampilkan setelah program berhenti\r\n', 22, 3, 'Hadir', 'Hadir', 'Hadir', NULL),
(313, 22, '2024-11-08', 'do while, switch dan if else', 'mengerjakan studi kasus mengenai kalkulator sederhana mengunakan do while dan membuat program inputan dimana prgram akan  jika ==0 program akan berhenti', 21, 4, 'Hadir', 'Hadir', 'Hadir', NULL),
(314, 66, '2024-11-06', 'Pertemuan 9 : Real Time Clock', 'merangakai menggunakan komponen RTC', 19, 8, 'Hadir', 'Hadir', 'Hadir', NULL),
(315, 63, '2024-11-08', 'Pertmuan 9 : Real Time Clock', 'merangkai menggunakan komponen RTC', 18, 4, 'Hadir', 'Hadir', 'Hadir', NULL),
(316, 44, '2024-11-08', 'Pertmuan 9 : Real Time Clock', 'merangkain menggunakan komponen RTC', 14, 8, 'Hadir', 'Hadir', NULL, 18),
(317, 6, '2024-11-08', 'sistem operasi windows', 'instalasi windows', 16, 9, 'Hadir', 'Hadir', 'Hadir', NULL),
(318, 4, '2024-11-08', 'Modul 4 Sistem Operasi Linux', 'Melakukan penginstalan sistem operasi linux pada virtualbox', 20, 6, 'Hadir', 'Hadir', 'Hadir', NULL),
(322, 2, '2024-11-09', 'Modul 3 : Instalasi Windows di Virtual Box', 'Penginstalan windows pada virtual box', 28, 7, 'Hadir', 'Hadir', NULL, NULL),
(323, 3, '2024-11-09', 'Modul 3 Sistem Operasi Windows', 'Melakukan instalasi sistem operasi windows pada virtualbox. Mulai dari setup, pilih bahasa, dan buat partisi', 25, 10, 'Hadir', 'Hadir', NULL, NULL),
(324, 88, '2024-10-28', 'Lanjutan Pencatatan Akun', 'Lanjutan Pencatatan Akun', 15, 5, 'Hadir', 'Hadir', 'Hadir', NULL),
(325, 37, '2024-11-09', 'MID', 'MID', 13, 8, 'Hadir', 'Hadir', 'Hadir', NULL),
(326, 56, '2024-11-08', 'mid', '-', 23, 2, 'Hadir', 'Hadir', 'Hadir', NULL),
(327, 36, '2024-11-09', 'MID', 'MID', 14, 6, 'Hadir', 'Hadir', 'Hadir', NULL),
(328, 12, '2024-11-09', 'Pengenalan Sistem Operasi Linux', 'Penginstallan SO Linux Ubuntu menggunakan VirtualBox', 15, 10, 'Hadir', 'Hadir', NULL, 17),
(329, 7, '2024-11-08', 'MODUL 3 – PENGENALAN SISTEM OPERASI WINDOWS', 'EVALUASI PRAKTIKUM\r\n1. Buat tutorial instalasi Sistem Operasi Windows menggunakan Flash Disk, uraikan\r\ntahapannya dan dilengkapi dengan gambar!\r\n2. Jelaskan perbedaan Sistem Operasi Windows dan Sistem Operasi Linux!', 25, 1, 'Hadir', 'Hadir', 'Hadir', NULL),
(330, 88, '2024-11-04', 'Lanjutan Pembuatan Akun Jurnal AJU', 'Lanjutan Pengisian Akun Jurnal AJU', 8, 12, 'Hadir', 'Hadir', 'Hadir', NULL),
(332, 61, '2024-11-09', 'RTC (REAL TIME MONITOR)', 'Membuat sebuah rangkaian untuk menyalakan led dengan rtc secara real time mengikut waktu yang ada pada monitornya', 12, 10, 'Hadir', 'Hadir', 'Hadir', NULL),
(333, 77, '2024-11-09', 'Modul 3 : Instalasi Windows di Virtual Box', 'Menginstall windows 10 di virtual bix', 29, 8, 'Hadir', 'Hadir', 'Hadir', NULL),
(336, 69, '2024-11-11', 'Menjelaskan fungsi RTC dan cara menggunakannya (merangkai) dan menjelaskan mengenai sensor peer dan sensor ultrasonik', 'mengerjakan tugas praktikum dan studi kasus untuk RTC', 19, 3, 'Hadir', 'Hadir', 'Hadir', NULL),
(337, 20, '2024-11-11', 'MID Test', ' MID Test', 26, 0, 'Hadir', 'Hadir', 'Hadir', NULL),
(338, 34, '2024-11-11', 'Double Linked List', 'studi kasus', 17, 6, 'Hadir', 'Hadir', 'Hadir', NULL),
(339, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(340, 32, '2024-11-11', 'MID', '-', 17, 11, 'Hadir', 'Hadir', 'Hadir', NULL),
(342, 67, '2024-11-12', 'Menjelaskan fungsi RTC dan cara menggunakannya (merangkai) dan menjelaskan mengenai sensor peer dan sensor ultrasonik', 'mengerjakan tugas praktikum 1-4 dan studi kasus materi RTC', 21, 3, 'Hadir', 'Hadir', 'Hadir', NULL),
(343, 79, '2024-11-12', 'MID', '-', 21, 5, 'Hadir', 'Hadir', 'Hadir', NULL),
(344, 46, '2024-11-12', 'View dan Select, Trigger', 'Implementas pembuatan view dan trigger', 14, 5, 'Hadir', NULL, 'Hadir', NULL),
(346, 68, '2024-11-12', 'pertemuan 9 & 10 : RTC & Sensor', 'merangkai menggunakan RTC dan Sensor', 20, 4, 'Hadir', 'Hadir', 'Hadir', NULL),
(349, 17, '2024-11-05', 'Looping Statement: for, Whike, dan do Whilel;\r\npengkondisian if else\r\n', 'Pembuatan looping for, while dan Do While; studi kasus kombinasi perulangan loop dan kondisi if else', 21, 5, 'Hadir', NULL, 'Hadir', 5),
(350, 17, '2024-11-12', 'Midtest quiziz dan mengerjakan program pengechekan tahun kabisat', 'Midtest ', 25, 1, 'Hadir', 'Hadir', 'Hadir', NULL),
(352, 16, '2024-11-12', 'Modul 4 LOOPING STATEMENT', 'Mengimplementasikan Looping : for, while, do while dalam sebuah program', 27, 9, 'Hadir', 'Hadir', 'Hadir', NULL),
(353, 14, '2024-11-05', 'Merakit PC', 'Tugas Evaluasi Praktikum', 18, 10, 'Hadir', 'Hadir', 'Hadir', NULL),
(354, 14, '2024-11-12', 'Installasi Linux', 'Evaluasi Praktikum 4', 24, 4, 'Hadir', 'Hadir', 'Hadir', NULL),
(355, 43, '2024-11-12', 'View dan Trigger', 'Evaluasi Praktikum View dan Trigger', 16, 8, 'Hadir', 'Hadir', 'Hadir', NULL),
(356, 43, '2024-11-05', 'Join SQL', 'Evaluasi Praktikum Join', 20, 4, 'Hadir', 'Hadir', 'Hadir', NULL),
(357, 23, '2024-10-30', 'Swicth Selection', 'Evaluasi Praktikum ', 28, 0, 'Hadir', 'Hadir', 'Hadir', NULL),
(358, 23, '2024-11-06', 'For Looping', 'Evaluasi Praktikum Loop', 26, 2, 'Hadir', 'Hadir', 'Hadir', NULL),
(359, 45, '2024-11-12', 'VIEW dan Trigger', 'Implementasi View yang dikombinasikan dengan JOIN dan Trigger ', 18, 6, 'Hadir', 'Hadir', 'Hadir', NULL),
(360, 9, '2024-11-12', 'pertemuan 4: sistem operasi linux', 'Menginstal linux ubuntu dan tantangannya membagi partisi ', 18, 6, 'Hadir', 'Hadir', 'Hadir', NULL),
(361, 25, '2024-11-14', 'MID', 'MID', 25, 0, 'Hadir', 'Hadir', 'Hadir', NULL),
(362, 52, '2024-11-13', 'TRIGGER', 'Eval 4 Trigger', 12, 3, NULL, 'Hadir', 'Hadir', NULL),
(363, 41, '2024-11-14', 'MID', 'MID', 18, 2, NULL, 'Hadir', 'Hadir', NULL),
(364, 76, '2024-11-14', 'Looping dan array', 'implementasi looping dan array', 23, 5, 'Hadir', 'Hadir', 'Hadir', NULL),
(365, 30, '2024-11-14', 'Tree', 'Mengerjakan Tugas Materi Tentang Tree', 17, 4, 'Hadir', 'Hadir', 'Hadir', NULL),
(366, 62, '2024-11-14', 'menjelaskan cara penggunaan sensor PIR, sensor ULTRASONIK dan beberapa sensor lainnya', 'mengerjakan tugas praktikum studi kasus', 17, 7, 'Hadir', 'Hadir', 'Hadir', NULL),
(367, 31, '2024-11-14', 'Tree', 'Tugas Materi Tree', 12, 10, 'Hadir', 'Hadir', 'Hadir', NULL),
(368, 66, '2024-11-13', 'Pertemuan 10 : Sensor', 'merangakai menggunakan komponen Sensor', 20, 7, 'Hadir', 'Hadir', 'Hadir', NULL),
(369, 74, '2024-10-17', 'Explicit intent', 'studi kasus', 3, 8, 'Hadir', 'Hadir', 'Hadir', NULL),
(370, 74, '2024-11-14', 'sqlite', 'studi kasus', 3, 8, 'Hadir', 'Hadir', 'Hadir', NULL),
(371, 81, '2024-11-14', 'Modul 4 : JavaScript', 'kegiatan praktikum javascript', 19, 3, 'Hadir', 'Hadir', 'Hadir', NULL),
(372, 50, '2024-11-13', 'View dan Trigger', 'Melakukan praktik n workbench MySQL membuat view dan trigger SQL', 20, 4, 'Hadir', 'Hadir', 'Hadir', NULL),
(373, 26, '2024-11-13', 'Melakukan ujian UTS teori dan UTS lab', 'mengerjakan ujian UTS teori dan UTS lab', 24, 1, 'Hadir', 'Hadir', 'Hadir', NULL),
(374, 86, '2024-11-14', 'Manajemen User', 'studi kasus', 16, 3, 'Hadir', 'Hadir', NULL, 17),
(378, 49, '2024-11-14', 'View dan Trigger ', 'implementasi View dan Trigger ', 16, 9, 'Hadir', 'Hadir', 'Hadir', NULL),
(379, 53, '2024-11-14', 'Trigger ', 'Evaluasi Praktikum Trigger', 10, 11, 'Hadir', 'Hadir', 'Hadir', NULL),
(380, 53, '2024-11-14', 'Trigger ', 'Evaluasi Praktikum Trigger', 10, 11, 'Hadir', 'Hadir', NULL, 12),
(381, 53, '2024-11-14', 'Trigger ', 'Evaluasi Praktikum Trigger', 10, 11, 'Hadir', 'Hadir', NULL, 12),
(382, 83, '2024-11-14', 'MID ', 'MID', 22, 4, NULL, 'Hadir', 'Hadir', NULL),
(383, 70, '2024-11-14', 'Pertemuan 9 : Real Time Clock', 'merangakai menggunakan komponen RTC', 19, 3, 'Hadir', 'Hadir', 'Hadir', NULL),
(384, 15, '2024-11-12', 'Looping', 'Studi kasus Kegiatan praktikum', 27, 3, 'Hadir', 'Hadir', NULL, 7),
(385, 55, '2024-11-15', 'Pertemuan 6 : Asistensi 2', 'Asistensi 2', 25, 4, NULL, 'Hadir', 'Hadir', NULL),
(386, 21, '2024-11-15', 'Nested For (for di dalam for)', '1. Membuat Segitiga Terbalik\r\n2. Membuat Segitiga  yang isinya kosong', 24, 1, NULL, 'Hadir', 'Hadir', NULL),
(387, 22, '2024-11-15', 'nested loop', 'membuat segitiga menggunakan nested loop', 17, 3, 'Hadir', 'Hadir', NULL, 7),
(388, 6, '2024-11-15', 'Modul 4 Sistem Operasi Linux', 'Melakukan instalasi linux ubuntu pada virtualbox. mulai dari memilih iso, setup partisi dan memori ram hingga core', 20, 5, 'Hadir', 'Hadir', 'Hadir', NULL),
(389, 4, '2024-11-15', 'Modul 5 Struktur File', 'Explore Struktur file pada windows dan linux', 24, 2, 'Hadir', 'Hadir', 'Hadir', NULL),
(390, 64, '2024-11-08', 'PERTEMUAN 10 : Real Time Clock', 'merangkai menggunakan rtc', 6, 11, 'Hadir', 'Hadir', 'Hadir', NULL),
(391, 64, '2024-11-15', 'Pertemuan 10 : Sensor', 'mernagkai menggunakan sensor pir, ultrasonic, dan random sensor', 6, 11, 'Hadir', 'Hadir', 'Hadir', NULL),
(392, 44, '2024-11-15', 'Pertemuan 10 : Sensor', 'merangkai menggunakan sensor pir , ultrasonic, dan random sensor', 14, 8, 'Hadir', 'Hadir', 'Hadir', NULL),
(394, 2, '2024-11-16', 'Modul 4 : Instalasi Linux di Virtual Box', 'penginstalan linux secara mandiri & asistensi ke 2', 31, 4, 'Hadir', 'Hadir', NULL, 12),
(395, 3, '2024-11-16', 'Modul 4 Sistem Operasi Linux', 'Melakukan instalasi sistem operasi linux pada virtualbox. mulai dari pembuatan virtual machine yaitu penentuan ram, core, dan HDD', 21, 13, 'Hadir', 'Hadir', 'Hadir', NULL),
(396, 36, '2024-11-16', 'Double Linked List', 'Implementasi double linked list pada modul', 11, 9, 'Hadir', 'Hadir', 'Hadir', NULL),
(398, 12, '2024-11-16', 'Hirarki direktori Windows dan Linux', 'Kegiatan Praktikum : studi kasus', 19, 6, 'Hadir', 'Hadir', 'Hadir', NULL),
(399, 75, '2024-11-14', 'Looping do while, while, for', 'Tugas Evaluasi IV, tentang perulangan yang di ajarkan di laboratorium', 29, 8, 'Hadir', 'Hadir', 'Hadir', NULL),
(400, 10, '2024-11-09', 'Install windows', 'membuat virtual machine windows', 28, 0, 'Hadir', 'Hadir', 'Hadir', NULL),
(401, 10, '2024-11-16', 'install linux', 'membuat virtual machine linux', 26, 2, 'Hadir', 'Hadir', NULL, 3),
(402, 37, '2024-11-16', 'double linked list', 'studi kasus double linked list', 8, 13, 'Hadir', 'Hadir', NULL, NULL),
(403, 61, '2024-11-16', 'SENSOR PIR DAN ULTRA SONIC', 'MERANGKAI MENGGUNAKAN PIR, ULTRA SONIC DAN RENDOM SENSOR (LDR & FLAME)', 17, 6, 'Hadir', 'Hadir', 'Hadir', NULL),
(404, 78, '2024-11-09', 'Pengenalan SO Windows ', 'Penginstalan SO Windows menggunakan Virtual Box', 27, 0, 'Hadir', 'Hadir', 'Hadir', NULL),
(405, 78, '2024-11-16', 'Pengenalan SO Linux', 'Penginstalan SO Linux menggunakan Virtual Box', 18, 9, 'Hadir', 'Hadir', 'Hadir', NULL),
(406, 77, '2024-11-16', 'Modul 4 : Instalasi linux', 'penginstalan linux secar amandiru', 21, 16, 'Hadir', 'Hadir', 'Hadir', NULL),
(407, 82, '2024-11-15', 'Modul 4 Belajar bahasa Pemrograman JavaScript', 'Membuat sebuah web dengan pengimplementasikan Javascript dan Jquery', 29, 4, 'Hadir', NULL, 'Hadir', 10),
(408, 7, '2024-11-15', 'MODUL 4 – PENGENALAN SISTEM OPERASI LINUX UBUNTU', 'EVALUASI PRAKTIKUM Membuat video Instalasi Sistem Operasi Linux Ubunt', 17, 9, 'Hadir', 'Hadir', 'Hadir', NULL),
(409, 20, '2024-11-18', 'Modul 4 : Procedure & Function', 'mengimplementasikan procedure dan function', 22, 4, 'Hadir', 'Hadir', 'Hadir', NULL),
(411, 69, '2024-11-18', 'menjelaskan macam macam sensor', 'mengerjakan studi kasus sensor 1 dan 3', 19, 3, 'Hadir', 'Hadir', 'Hadir', NULL),
(412, 34, '2024-11-18', 'Pemaparan tugas besar ', 'Menjelaskan apa yang akan di buat untuk tugas besar', 20, 3, 'Hadir', NULL, 'Hadir', 21),
(413, 33, '2024-11-11', '-', 'MID', 20, 7, 'Hadir', 'Hadir', 'Hadir', NULL),
(414, 33, '2024-11-18', 'Pemaparan tugas besar', 'Mencari ide project yang baik', 22, 5, 'Hadir', 'Hadir', 'Hadir', NULL),
(416, 67, '2024-11-19', 'menjelaskan mengenai beberapasensor', 'mengerjakan tugas praktikum studi kasus 1-3', 24, 1, 'Hadir', 'Hadir', 'Hadir', NULL),
(435, 63, '2026-01-23', 'abc', 'abc', 12, 8, 'Hadir', 'Hadir', 'Hadir', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `mst_asisten`
--
ALTER TABLE `mst_asisten`
  ADD PRIMARY KEY (`id_asisten`),
  ADD UNIQUE KEY `stambuk` (`stambuk`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `mst_dosen`
--
ALTER TABLE `mst_dosen`
  ADD PRIMARY KEY (`id_dosen`),
  ADD UNIQUE KEY `nip` (`nip`);

--
-- Indeks untuk tabel `mst_jurusan`
--
ALTER TABLE `mst_jurusan`
  ADD PRIMARY KEY (`id_jurusan`);

--
-- Indeks untuk tabel `mst_kelas`
--
ALTER TABLE `mst_kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `id_jurusan` (`id_jurusan`);

--
-- Indeks untuk tabel `mst_matakuliah`
--
ALTER TABLE `mst_matakuliah`
  ADD PRIMARY KEY (`id_matkul`),
  ADD UNIQUE KEY `kode_matkul` (`kode_matkul`),
  ADD KEY `id_jurusan` (`id_jurusan`);

--
-- Indeks untuk tabel `mst_ruangan`
--
ALTER TABLE `mst_ruangan`
  ADD PRIMARY KEY (`id_ruangan`);

--
-- Indeks untuk tabel `mst_tahun_ajaran`
--
ALTER TABLE `mst_tahun_ajaran`
  ADD PRIMARY KEY (`id_tahun`);

--
-- Indeks untuk tabel `mst_user`
--
ALTER TABLE `mst_user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `trs_frekuensi`
--
ALTER TABLE `trs_frekuensi`
  ADD PRIMARY KEY (`id_frekuensi`),
  ADD KEY `id_jurusan` (`id_jurusan`),
  ADD KEY `id_matkul` (`id_matkul`),
  ADD KEY `id_tahun` (`id_tahun`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_ruangan` (`id_ruangan`),
  ADD KEY `id_dosen` (`id_dosen`),
  ADD KEY `id_asisten1` (`id_asisten1`),
  ADD KEY `id_asisten2` (`id_asisten2`);

--
-- Indeks untuk tabel `trs_mentoring`
--
ALTER TABLE `trs_mentoring`
  ADD PRIMARY KEY (`id_mentoring`),
  ADD KEY `id_frekuensi` (`id_frekuensi`),
  ADD KEY `id_asisten_pengganti` (`id_asisten_pengganti`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `mst_asisten`
--
ALTER TABLE `mst_asisten`
  MODIFY `id_asisten` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `mst_dosen`
--
ALTER TABLE `mst_dosen`
  MODIFY `id_dosen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT untuk tabel `mst_jurusan`
--
ALTER TABLE `mst_jurusan`
  MODIFY `id_jurusan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `mst_kelas`
--
ALTER TABLE `mst_kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT untuk tabel `mst_matakuliah`
--
ALTER TABLE `mst_matakuliah`
  MODIFY `id_matkul` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `mst_ruangan`
--
ALTER TABLE `mst_ruangan`
  MODIFY `id_ruangan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `mst_tahun_ajaran`
--
ALTER TABLE `mst_tahun_ajaran`
  MODIFY `id_tahun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `mst_user`
--
ALTER TABLE `mst_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `trs_frekuensi`
--
ALTER TABLE `trs_frekuensi`
  MODIFY `id_frekuensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT untuk tabel `trs_mentoring`
--
ALTER TABLE `trs_mentoring`
  MODIFY `id_mentoring` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=436;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `mst_asisten`
--
ALTER TABLE `mst_asisten`
  ADD CONSTRAINT `mst_asisten_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `mst_user` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `mst_kelas`
--
ALTER TABLE `mst_kelas`
  ADD CONSTRAINT `mst_kelas_ibfk_1` FOREIGN KEY (`id_jurusan`) REFERENCES `mst_jurusan` (`id_jurusan`);

--
-- Ketidakleluasaan untuk tabel `mst_matakuliah`
--
ALTER TABLE `mst_matakuliah`
  ADD CONSTRAINT `mst_matakuliah_ibfk_1` FOREIGN KEY (`id_jurusan`) REFERENCES `mst_jurusan` (`id_jurusan`);

--
-- Ketidakleluasaan untuk tabel `trs_frekuensi`
--
ALTER TABLE `trs_frekuensi`
  ADD CONSTRAINT `trs_frekuensi_ibfk_1` FOREIGN KEY (`id_jurusan`) REFERENCES `mst_jurusan` (`id_jurusan`),
  ADD CONSTRAINT `trs_frekuensi_ibfk_2` FOREIGN KEY (`id_matkul`) REFERENCES `mst_matakuliah` (`id_matkul`),
  ADD CONSTRAINT `trs_frekuensi_ibfk_3` FOREIGN KEY (`id_tahun`) REFERENCES `mst_tahun_ajaran` (`id_tahun`),
  ADD CONSTRAINT `trs_frekuensi_ibfk_4` FOREIGN KEY (`id_kelas`) REFERENCES `mst_kelas` (`id_kelas`),
  ADD CONSTRAINT `trs_frekuensi_ibfk_5` FOREIGN KEY (`id_ruangan`) REFERENCES `mst_ruangan` (`id_ruangan`),
  ADD CONSTRAINT `trs_frekuensi_ibfk_6` FOREIGN KEY (`id_dosen`) REFERENCES `mst_dosen` (`id_dosen`),
  ADD CONSTRAINT `trs_frekuensi_ibfk_7` FOREIGN KEY (`id_asisten1`) REFERENCES `mst_asisten` (`id_asisten`),
  ADD CONSTRAINT `trs_frekuensi_ibfk_8` FOREIGN KEY (`id_asisten2`) REFERENCES `mst_asisten` (`id_asisten`);

--
-- Ketidakleluasaan untuk tabel `trs_mentoring`
--
ALTER TABLE `trs_mentoring`
  ADD CONSTRAINT `trs_mentoring_ibfk_1` FOREIGN KEY (`id_frekuensi`) REFERENCES `trs_frekuensi` (`id_frekuensi`),
  ADD CONSTRAINT `trs_mentoring_ibfk_2` FOREIGN KEY (`id_asisten_pengganti`) REFERENCES `mst_asisten` (`id_asisten`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
