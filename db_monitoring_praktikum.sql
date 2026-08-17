-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for osx10.10 (x86_64)
--
-- Host: localhost    Database: db_monitoring_praktikum
-- ------------------------------------------------------
-- Server version	10.4.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `mst_asisten`
--

DROP TABLE IF EXISTS `mst_asisten`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_asisten` (
  `id_asisten` int(11) NOT NULL AUTO_INCREMENT,
  `stambuk` varchar(13) DEFAULT NULL,
  `nama_asisten` varchar(50) DEFAULT NULL,
  `angkatan` year(4) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `jenis_kelamin` enum('Pria','Wanita') DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `photo_profil` text DEFAULT NULL,
  `photo_path` text DEFAULT NULL,
  PRIMARY KEY (`id_asisten`),
  UNIQUE KEY `stambuk` (`stambuk`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `mst_asisten_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `mst_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_asisten`
--

LOCK TABLES `mst_asisten` WRITE;
/*!40000 ALTER TABLE `mst_asisten` DISABLE KEYS */;
INSERT INTO `mst_asisten` VALUES (47,'13020230244','Rizqi Ananda Jalil',2023,'Calon Asisten','Wanita',58,NULL,NULL),(49,'13020230297','Sitti Nurhalimah',2023,'Calon Asisten','Wanita',61,NULL,NULL),(62,'13020230306','Raihan Nur Rizqillah',2023,'Calon Asisten','Pria',69,NULL,NULL),(68,'13020230253','Zaki Falihin Ayyubi',2023,'Calon Asisten','Pria',72,'public/img/uploads//profil_72.jpg','public/img/signature//Zaki_Falihin_Ayyubi_ttd.jpeg'),(70,'13020230030','Muhammad Nur Fuad',2023,'Calon Asisten','Pria',73,NULL,NULL),(72,'13020230049','Ichwal',2023,'Calon Asisten','Pria',74,NULL,NULL),(74,'13020230081','⁠Aan Maulana Sampe',2023,'Calon Asisten','Pria',75,NULL,NULL),(76,'13020230100','M. Rizwan',2023,'Asisten','Pria',76,NULL,NULL),(78,'13020230187','Nahwa Kaka Saputra Anggareksa',2023,'Asisten','Pria',77,NULL,NULL),(80,'13020230193','Muhammad Rifky Saputra Scania',2023,'Calon Asisten','Pria',78,NULL,NULL),(82,'13020230219','Andi Rifqi Aunur Rahman',2023,'Calon Asisten','Pria',79,NULL,NULL),(84,'13020230224','Andi Ahsan Ashuri',2023,'Calon Asisten','Pria',80,NULL,NULL),(86,'13020230251','Andi Ikhlas Mallomo',2023,'Calon Asisten','Pria',81,NULL,NULL),(88,'13020230232','Laode Muhammad Dhaifan Kasyfillah',2023,'Calon Asisten','Pria',82,NULL,NULL),(90,'13020230290','Muhammad Rafli',2023,'Calon Asisten','Pria',83,NULL,NULL),(92,'13020230319','Muh. Fatwah Fajriansyah M',2023,'Calon Asisten','Pria',84,NULL,NULL),(94,'13020230309','Hendrawan',2023,'Calon Asisten','Pria',85,NULL,NULL),(96,'13020230268','Farah Tsabitaputri Az Zahra',2023,'Calon Asisten','Pria',86,NULL,NULL),(98,'13020230241','⁠Firli Anastasya Hafid',2023,'Calon Asisten','Wanita',87,NULL,NULL),(100,'13020230096','⁠Thalita Sherly Putri Jasmin',2023,'Calon Asisten','Wanita',88,NULL,NULL),(102,'13020230217','Siti Safira Tawetubun ',2023,'Calon Asisten','Wanita',89,NULL,NULL),(104,'13020230255','Sitti Lutfia',2023,'Calon Asisten','Wanita',90,NULL,NULL);
/*!40000 ALTER TABLE `mst_asisten` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_dosen`
--

DROP TABLE IF EXISTS `mst_dosen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_dosen` (
  `id_dosen` int(11) NOT NULL AUTO_INCREMENT,
  `nip` varchar(30) DEFAULT NULL,
  `nama_dosen` varchar(50) DEFAULT NULL,
  `photo_path` text DEFAULT NULL,
  PRIMARY KEY (`id_dosen`),
  UNIQUE KEY `nip` (`nip`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_dosen`
--

LOCK TABLES `mst_dosen` WRITE;
/*!40000 ALTER TABLE `mst_dosen` DISABLE KEYS */;
INSERT INTO `mst_dosen` VALUES (1,'0919027301','Ir. Purnawansyah, S.Kom.,M.Kom., MTA','public/img/signature/Pak Pur (2).PNG'),(2,'0922078101','Ir. Yulita Salim, S.Kom.,M.T., MTA','public/img/signature/yuli.PNG'),(6,'0910126901','Tasrif Hasanuddin, S.Kom., M.Cs.','public/img/signature/pak tasrif.png'),(7,'0428077401','Dr. Ir. Dolly Indra, S.Kom.,M.M.SI., MTA','public/img/signature/Dolly.jpg'),(8,'0913038506','Ir. Herman, S.Kom.,M.Cs., MTA','public/img/signature/herman.PNG'),(9,'0931018001','Ir. Abdul Rachman Manga’, S.Kom.,M.T., MTA','TIDAK'),(10,'0920098801','Ir. Huzain Azis, S.Kom.,M.Cs., MTA','public/img/signature/uceng.PNG'),(11,'0917068601','Ir. Dedy Atmajaya, S.Kom.,M.Eng., MTA','public/img/signature/dedy atmajaya.jpg'),(12,'0911098601','Ir. Farniwati Fattah, S.T.,M.T., MTA','TIDAK'),(13,'0906078701','Mardiyyah Hasnawi, S.Kom.,M.T., MTA','TIDAK'),(14,'0906048205','Lilis Nur Hayati, S.Kom.,M.Eng., MTA','TIDAK'),(15,'0922088701','Siska Anraeni, S.Kom., M.T.','public/img/signature/siska.jpg'),(16,'0919056501','Ramdan Satra, S.Kom.,M.Kom., MTA','TIDAK'),(17,'0920107601','Ir. Muh. Aliyazid Mude, S.Kom.,M.Kom.','TIDAK'),(18,'0915028503','Irawati, S.Kom.,M.T., MTA','TIDAK'),(19,'0919018501','Ir. St. Hajrah Mansyur, S.Kom.,M.Cs., MTA','public/img/signature/hajrah.jpg'),(20,'0926048704','Ir. Syahrul Mubarak Abdullah, S.Kom.,M.Kom., MTA','TIDAK'),(21,'0915068601','Ir. Nia Kurniati, S.Kom.,M.Kom., MTA','TIDAK'),(22,'0924048501','Sugiarti, S.Kom.,M.Kom., MTA.','public/img/signature/sugiarti.png'),(23,'0906128504','Ir. Erick Irawadi Alwi, S.Kom.,M.Eng., MTA','TIDAK'),(24,'0921018902','Lutfi Budi Ilmawan, S.Kom.,M.Cs., MTA','public/img/signature/lutfi.png'),(25,'0924069001','Ir. Herdianti, S.Si., M.Eng., MTA','TIDAK'),(26,'0922078801','Fitriyani Umar, S.Si., M.Eng.','TIDAK'),(27,'0922118003','Ir. Lukman Syafie, S.Si., M.Si., MTA','public/img/signature/lukman syafei.jpg'),(28,'0908089202','Andi Ulfah Tenripada, S.Kom., M.Kom.','public/img/signature/uphe.jpg'),(29,'2107057202','Ihwana As’ad, S.Ag., M.Sc., Ph.D., MTA.','public/img/signature/ihwana.jpg'),(30,'1302902','Fahmi, S.Kom., M.T','public/img/signature/fahmi.png'),(31,'0908099401','Andi Widya Mufila Gaffar, S.T., M.Kom','public/img/signature/widya.PNG'),(32,'0911039301','Ramdaniah, S.Kom., M.T., MTA','public/img/signature/ramdaniah.jpg'),(33,'0909029203','Muhammad Arfah Asis, S.Kom., M.T., MTA','TIDAK'),(34,'0924049303','Amaliah Faradibah, S.Kom., M.Kom., MTA., MCF','public/img/signature/paraf amel.jpg'),(35,'0901019302','Dewi Widyawati, S.Kom., M.Kom., MTA','TIDAK'),(37,'130014','Syariful Mujaddid, S.Kom., M.T','TIDAK'),(38,'','Lukman, S.E., M.Acc','public/img/signature/lukman akuntansi.png');
/*!40000 ALTER TABLE `mst_dosen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_jurusan`
--

DROP TABLE IF EXISTS `mst_jurusan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_jurusan` (
  `id_jurusan` int(11) NOT NULL AUTO_INCREMENT,
  `jurusan` varchar(50) DEFAULT NULL,
  `singkatan_jurusan` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_jurusan`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_jurusan`
--

LOCK TABLES `mst_jurusan` WRITE;
/*!40000 ALTER TABLE `mst_jurusan` DISABLE KEYS */;
INSERT INTO `mst_jurusan` VALUES (1,'Teknik Informatika','TI'),(2,'Sistem Informasi','SI');
/*!40000 ALTER TABLE `mst_jurusan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_kelas`
--

DROP TABLE IF EXISTS `mst_kelas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_kelas` (
  `id_kelas` int(11) NOT NULL AUTO_INCREMENT,
  `id_jurusan` int(11) DEFAULT NULL,
  `kelas` varchar(5) DEFAULT NULL,
  `frekuensi` varchar(20) DEFAULT NULL,
  `angkatan` year(4) NOT NULL,
  PRIMARY KEY (`id_kelas`),
  KEY `id_jurusan` (`id_jurusan`),
  CONSTRAINT `mst_kelas_ibfk_1` FOREIGN KEY (`id_jurusan`) REFERENCES `mst_jurusan` (`id_jurusan`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_kelas`
--

LOCK TABLES `mst_kelas` WRITE;
/*!40000 ALTER TABLE `mst_kelas` DISABLE KEYS */;
INSERT INTO `mst_kelas` VALUES (1,1,'A1',NULL,2024),(2,1,'A2',NULL,2024),(3,1,'A3',NULL,2024),(4,1,'A4',NULL,2024),(5,1,'A5',NULL,2024),(6,1,'A6',NULL,2024),(7,1,'A7',NULL,2024),(8,1,'A8',NULL,2024),(9,1,'B1',NULL,2024),(10,1,'B2',NULL,2024),(11,1,'B3',NULL,2024),(12,1,'B4',NULL,2024),(13,1,'B5',NULL,2024),(14,1,'D1',NULL,2024),(15,2,'A1',NULL,2024),(16,2,'B1',NULL,2024),(17,1,'A1',NULL,2023),(18,1,'A2',NULL,2023),(19,1,'A3',NULL,2023),(20,1,'A4',NULL,2023),(21,1,'A5',NULL,2023),(22,1,'A6',NULL,2023),(23,1,'A7',NULL,2023),(24,1,'A8',NULL,2023),(25,1,'A9',NULL,2023),(26,1,'A10',NULL,2023),(27,1,'B1',NULL,2023),(28,1,'B2',NULL,2023),(29,1,'B3',NULL,2023),(30,1,'B4',NULL,2023),(31,1,'C1',NULL,2023),(32,1,'D1',NULL,2023),(33,2,'A1',NULL,2023),(34,2,'B1',NULL,2023),(35,2,'D1',NULL,2023),(57,1,'A7',NULL,2025);
/*!40000 ALTER TABLE `mst_kelas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_matakuliah`
--

DROP TABLE IF EXISTS `mst_matakuliah`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_matakuliah` (
  `id_matkul` int(11) NOT NULL AUTO_INCREMENT,
  `kode_matkul` varchar(12) DEFAULT NULL,
  `nama_matkul` varchar(50) DEFAULT NULL,
  `singkatan` varchar(20) DEFAULT NULL,
  `semester` enum('GANJIL','GENAP') DEFAULT NULL,
  `sks` int(11) DEFAULT NULL,
  `id_jurusan` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_matkul`),
  UNIQUE KEY `kode_matkul` (`kode_matkul`),
  KEY `id_jurusan` (`id_jurusan`),
  CONSTRAINT `mst_matakuliah_ibfk_1` FOREIGN KEY (`id_jurusan`) REFERENCES `mst_jurusan` (`id_jurusan`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_matakuliah`
--

LOCK TABLES `mst_matakuliah` WRITE;
/*!40000 ALTER TABLE `mst_matakuliah` DISABLE KEYS */;
INSERT INTO `mst_matakuliah` VALUES (2,'1303PPA105','Algoritma dan Pemrograman 1','ALPRO1','GANJIL',3,1),(3,'1303PPA302','Struktur Data','SD','GANJIL',3,1),(4,'1303PPA304','Basis Data II','BD2','GANJIL',3,1),(5,'1303KKA504','Microcontroller ','MICRO','GANJIL',3,1),(6,'1303KKA713','Pemrograman Mobile','MOBILE','GANJIL',3,1),(7,'1313KKB107','Algoritma Pemrograman','ALPRO','GANJIL',3,2),(8,'1313KKB109','Sistem dan Teknologi Informasi ','STI','GANJIL',3,2),(9,'1313KKB304','Jaringan Komputer','JARKOM','GANJIL',3,2),(10,'1313KKB306','Pemrograman Web','WEB','GANJIL',3,2),(11,'1313KKB309','Basis Data II','BD2','GANJIL',3,2),(12,'1313KKB503','Sistem Operasi','SO','GANJIL',3,2),(13,'1313PPB507','Aplikasi Akuntansi','AA','GANJIL',3,2),(14,'1303KKA203','Elektronika Dasar','ELEKTRO','GENAP',3,1),(15,'1303PPA205','Algoritma & Pemrograman 2','ALPRO2','GENAP',3,1),(16,'1303PPA207','Basis Data I','BD1','GENAP',3,1),(17,'1303KKA403','Pemrograman Berorientasi Objek','PBO','GENAP',3,1),(18,'1303KKA407','Jaringan Komputer','JARKOM','GENAP',3,1),(19,'1303KKA408','Pemrograman Web','WEB','GENAP',3,1),(20,'1313KKB204','Basis Data I ','BD1','GENAP',3,2),(21,'1313KKB205','Algoritma & Struktur Data ','ASD','GENAP',3,2),(22,'1313KKB401','Pemrograman Berorientasi Objek','PBO','GENAP',3,2),(23,'1313KKB402','Desain Grafis ','DG','GENAP',3,2),(24,'1313KKB407','Pemrograman Mobile ','MOBILE','GENAP',3,2),(25,'1313KKB604','Multimedia System','MS','GENAP',3,2),(27,'1303PPA501','Bisnis Digital','BD','GANJIL',3,NULL),(29,'123445','1234','12','GANJIL',-1,1);
/*!40000 ALTER TABLE `mst_matakuliah` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_ruangan`
--

DROP TABLE IF EXISTS `mst_ruangan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_ruangan` (
  `id_ruangan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_ruangan` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_ruangan`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_ruangan`
--

LOCK TABLES `mst_ruangan` WRITE;
/*!40000 ALTER TABLE `mst_ruangan` DISABLE KEYS */;
INSERT INTO `mst_ruangan` VALUES (1,'Laboratorium IoT'),(2,'Laboratorium StartUp'),(3,'Laboratorium Data Science'),(4,'Laboratorium Computer Vision'),(5,'Laboratorium Computer Network'),(6,'Laboratorium Multimedia'),(7,'Laboratorium Microcontroller'),(8,'Laboratorium Riset 1'),(9,'Laboratorium Riset 2'),(39,'Laboratorium Riset 3');
/*!40000 ALTER TABLE `mst_ruangan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_tahun_ajaran`
--

DROP TABLE IF EXISTS `mst_tahun_ajaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_tahun_ajaran` (
  `id_tahun` int(11) NOT NULL AUTO_INCREMENT,
  `tahun_ajaran` varchar(9) DEFAULT NULL,
  PRIMARY KEY (`id_tahun`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_tahun_ajaran`
--

LOCK TABLES `mst_tahun_ajaran` WRITE;
/*!40000 ALTER TABLE `mst_tahun_ajaran` DISABLE KEYS */;
INSERT INTO `mst_tahun_ajaran` VALUES (1,'2023/2024'),(2,'2024/2025'),(3,'2025/2026'),(4,'2026/2027'),(5,'2027/2028'),(6,'2028/2029'),(7,'2029/2030');
/*!40000 ALTER TABLE `mst_tahun_ajaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_user`
--

DROP TABLE IF EXISTS `mst_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nama_user` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_user`
--

LOCK TABLES `mst_user` WRITE;
/*!40000 ALTER TABLE `mst_user` DISABLE KEYS */;
INSERT INTO `mst_user` VALUES (1,'Fatima A.R. Tuasamu','admin@gmail.com','$2y$10$ii7dNMAw9K7aNmYUW8yAfeGg4Us9n3cFZN4nJUq9ArBe8FNLErxua','Admin'),(58,'Rizqi Ananda Jalil','13020230244@student.umi.ac.id','c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3','Asisten'),(61,'Sitti Nurhalimah','13020230297@student.umi.ac.id','c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3','Asisten'),(69,'Raihan Nur Rizqillah','13020230306@student.umi.ac.id','c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3','Asisten'),(72,'Zaki Falihin Ayyubi','13020230253@student.umi.ac.id','$2y$10$DLHW61sER2iTdrgfIrh6W.fc31tF9DoMORyb9I5M8HREIWql88n5G','Asisten'),(73,'Muhammad Nur Fuad','13020230030@student.umi.ac.id','c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3','Asisten'),(74,'Ichwal','13020230049@student.umi.ac.id','c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3','Asisten'),(75,'⁠Aan Maulana Sampe','13020230081@student.umi.ac.id','c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3','Asisten'),(76,'M. Rizwan','13020230100@student.umi.ac.id','c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3','Asisten'),(77,'Nahwa Kaka Saputra Anggareksa','13020230187@student.umi.ac.id','c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3','Asisten'),(78,'Muhammad Rifky Saputra Scania','13020230193@student.umi.ac.id','c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3','Asisten'),(79,'Andi Rifqi Aunur Rahman','13020230219@student.umi.ac.id','c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3','Asisten'),(80,'Andi Ahsan Ashuri','13020230224@student.umi.ac.id','c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3','Asisten'),(81,'Andi Ikhlas Mallomo','13020230251@student.umi.ac.id','c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3','Asisten'),(82,'Laode Muhammad Dhaifan Kasyfillah','13020230232@student.umi.ac.id','c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3','Asisten'),(83,'Muhammad Rafli','13020230290@student.umi.ac.id','c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3','Asisten'),(84,'Muh. Fatwah Fajriansyah M','13020230319@student.umi.ac.id','c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3','Asisten'),(85,'Hendrawan','13020230309@student.umi.ac.id','c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3','Asisten'),(86,'Farah Tsabitaputri Az Zahra','13020230268@student.umi.ac.id','c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3','Asisten'),(87,'⁠Firli Anastasya Hafid','13020230241@student.umi.ac.id','c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3','Asisten'),(88,'⁠Thalita Sherly Putri Jasmin','13020230096@student.umi.ac.id','c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3','Asisten'),(89,'Siti Safira Tawetubun ','13020230217@student.umi.ac.id','c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3','Asisten'),(90,'Sitti Lutfia','13020230255@student.umi.ac.id','c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3','Asisten');
/*!40000 ALTER TABLE `mst_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `restore`
--

DROP TABLE IF EXISTS `restore`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `restore` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_data` varchar(100) NOT NULL,
  `data_json` longtext NOT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_jenis_data` (`jenis_data`),
  KEY `idx_deleted_at` (`deleted_at`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `restore`
--

LOCK TABLES `restore` WRITE;
/*!40000 ALTER TABLE `restore` DISABLE KEYS */;
INSERT INTO `restore` VALUES (19,'mst_user','{\"id_user\":70,\"nama_user\":\"Ichwal\",\"username\":\"13020230049@student.umi.ac.id\",\"password\":\"c930b3c377e643aeb098073360f0042744f3412aca5bc352aca667da2634fed3\",\"role\":\"Asisten\"}',1,'2026-04-30 15:15:07'),(20,'mst_asisten','{\"id_asisten\":66,\"stambuk\":\"13020230049\",\"nama_asisten\":\"Ichwal\",\"angkatan\":\"2023\",\"status\":\"Calon Asisten\",\"jenis_kelamin\":\"Pria\",\"id_user\":71,\"photo_profil\":null,\"photo_path\":null}',1,'2026-04-30 15:17:44');
/*!40000 ALTER TABLE `restore` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trs_frekuensi`
--

DROP TABLE IF EXISTS `trs_frekuensi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trs_frekuensi` (
  `id_frekuensi` int(11) NOT NULL AUTO_INCREMENT,
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
  `id_asisten2` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_frekuensi`),
  KEY `id_jurusan` (`id_jurusan`),
  KEY `id_matkul` (`id_matkul`),
  KEY `id_tahun` (`id_tahun`),
  KEY `id_kelas` (`id_kelas`),
  KEY `id_ruangan` (`id_ruangan`),
  KEY `id_dosen` (`id_dosen`),
  KEY `id_asisten1` (`id_asisten1`),
  KEY `id_asisten2` (`id_asisten2`),
  CONSTRAINT `trs_frekuensi_ibfk_1` FOREIGN KEY (`id_jurusan`) REFERENCES `mst_jurusan` (`id_jurusan`),
  CONSTRAINT `trs_frekuensi_ibfk_2` FOREIGN KEY (`id_matkul`) REFERENCES `mst_matakuliah` (`id_matkul`),
  CONSTRAINT `trs_frekuensi_ibfk_3` FOREIGN KEY (`id_tahun`) REFERENCES `mst_tahun_ajaran` (`id_tahun`),
  CONSTRAINT `trs_frekuensi_ibfk_4` FOREIGN KEY (`id_kelas`) REFERENCES `mst_kelas` (`id_kelas`),
  CONSTRAINT `trs_frekuensi_ibfk_5` FOREIGN KEY (`id_ruangan`) REFERENCES `mst_ruangan` (`id_ruangan`),
  CONSTRAINT `trs_frekuensi_ibfk_6` FOREIGN KEY (`id_dosen`) REFERENCES `mst_dosen` (`id_dosen`),
  CONSTRAINT `trs_frekuensi_ibfk_7` FOREIGN KEY (`id_asisten1`) REFERENCES `mst_asisten` (`id_asisten`),
  CONSTRAINT `trs_frekuensi_ibfk_8` FOREIGN KEY (`id_asisten2`) REFERENCES `mst_asisten` (`id_asisten`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trs_frekuensi`
--

LOCK TABLES `trs_frekuensi` WRITE;
/*!40000 ALTER TABLE `trs_frekuensi` DISABLE KEYS */;
/*!40000 ALTER TABLE `trs_frekuensi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trs_mentoring`
--

DROP TABLE IF EXISTS `trs_mentoring`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trs_mentoring` (
  `id_mentoring` int(11) NOT NULL AUTO_INCREMENT,
  `id_frekuensi` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `uraian_materi` text DEFAULT NULL,
  `uraian_tugas` text DEFAULT NULL,
  `hadir` int(11) DEFAULT NULL,
  `alpa` int(11) DEFAULT NULL,
  `status_dosen` varchar(10) DEFAULT NULL,
  `status_asisten1` varchar(10) DEFAULT NULL,
  `status_asisten2` varchar(10) DEFAULT NULL,
  `id_asisten_pengganti` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_mentoring`),
  KEY `id_frekuensi` (`id_frekuensi`),
  KEY `id_asisten_pengganti` (`id_asisten_pengganti`),
  CONSTRAINT `trs_mentoring_ibfk_1` FOREIGN KEY (`id_frekuensi`) REFERENCES `trs_frekuensi` (`id_frekuensi`),
  CONSTRAINT `trs_mentoring_ibfk_2` FOREIGN KEY (`id_asisten_pengganti`) REFERENCES `mst_asisten` (`id_asisten`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trs_mentoring`
--

LOCK TABLES `trs_mentoring` WRITE;
/*!40000 ALTER TABLE `trs_mentoring` DISABLE KEYS */;
/*!40000 ALTER TABLE `trs_mentoring` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trs_restore`
--

DROP TABLE IF EXISTS `trs_restore`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trs_restore` (
  `id_restore` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_data` varchar(50) DEFAULT NULL,
  `data_json` text DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_restore`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trs_restore`
--

LOCK TABLES `trs_restore` WRITE;
/*!40000 ALTER TABLE `trs_restore` DISABLE KEYS */;
/*!40000 ALTER TABLE `trs_restore` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-08-12 17:34:27
