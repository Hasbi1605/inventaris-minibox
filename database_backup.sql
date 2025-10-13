/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-12.0.2-MariaDB, for osx10.20 (arm64)
--
-- Host: localhost    Database: inventaris_barbershop
-- ------------------------------------------------------
-- Server version	12.0.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `cabang`
--

DROP TABLE IF EXISTS `cabang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cabang` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_cabang` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `status` enum('aktif','tidak_aktif','maintenance','renovasi') NOT NULL DEFAULT 'aktif',
  `jam_operasional_buka` time DEFAULT NULL,
  `jam_operasional_tutup` time DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kategori_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cabang_kategori_id_foreign` (`kategori_id`),
  CONSTRAINT `cabang_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategoris` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cabang`
--

LOCK TABLES `cabang` WRITE;
/*!40000 ALTER TABLE `cabang` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `cabang` VALUES
(1,'Minibox Candi','Candi Winangun','aktif','09:00:00','21:00:00',NULL,'2025-09-20 02:06:53','2025-10-06 05:59:37',17),
(2,'Minibox Krajen','Krajen','aktif','10:00:00','21:00:00',NULL,'2025-10-05 06:58:00','2025-10-05 07:34:20',17),
(3,'Minibox Balong','Balong','aktif','09:00:00','21:00:00',NULL,'2025-10-05 07:08:12','2025-10-05 07:34:14',17),
(4,'Minibox 5 magelang','magelang','aktif',NULL,NULL,NULL,'2025-10-11 19:25:13','2025-10-11 19:25:13',17);
/*!40000 ALTER TABLE `cabang` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `cabang_layanan`
--

DROP TABLE IF EXISTS `cabang_layanan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cabang_layanan` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cabang_id` bigint(20) unsigned NOT NULL,
  `layanan_id` bigint(20) unsigned NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `status` enum('aktif','tidak_aktif') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cabang_layanan_cabang_id_layanan_id_unique` (`cabang_id`,`layanan_id`),
  KEY `cabang_layanan_layanan_id_foreign` (`layanan_id`),
  CONSTRAINT `cabang_layanan_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cabang_layanan_layanan_id_foreign` FOREIGN KEY (`layanan_id`) REFERENCES `layanans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cabang_layanan`
--

LOCK TABLES `cabang_layanan` WRITE;
/*!40000 ALTER TABLE `cabang_layanan` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `cabang_layanan` VALUES
(1,3,4,20000.00,'aktif','2025-10-06 02:18:57','2025-10-09 07:31:11'),
(2,2,4,20000.00,'aktif','2025-10-06 02:18:57','2025-10-09 07:31:12'),
(3,1,4,20000.00,'aktif','2025-10-06 02:18:57','2025-10-09 07:31:12'),
(7,3,6,20000.00,'aktif','2025-10-09 07:30:06','2025-10-09 07:31:27'),
(8,1,6,20000.00,'aktif','2025-10-09 07:30:06','2025-10-09 07:31:27'),
(9,2,6,15000.00,'aktif','2025-10-09 07:30:06','2025-10-09 07:31:27'),
(10,3,7,25000.00,'aktif','2025-10-09 07:32:18','2025-10-09 07:32:18'),
(11,1,7,25000.00,'aktif','2025-10-09 07:32:18','2025-10-09 07:32:18'),
(12,2,7,25000.00,'aktif','2025-10-09 07:32:18','2025-10-09 07:32:18'),
(13,3,8,25000.00,'aktif','2025-10-09 07:32:58','2025-10-09 07:32:58'),
(14,1,8,25000.00,'aktif','2025-10-09 07:32:58','2025-10-09 07:32:58'),
(15,2,8,25000.00,'aktif','2025-10-09 07:32:58','2025-10-09 07:32:58'),
(16,3,9,25000.00,'aktif','2025-10-09 07:33:34','2025-10-09 07:33:34'),
(17,1,9,25000.00,'aktif','2025-10-09 07:33:34','2025-10-09 07:33:34'),
(18,2,9,25000.00,'aktif','2025-10-09 07:33:34','2025-10-09 07:33:34'),
(19,3,10,45000.00,'aktif','2025-10-09 07:34:22','2025-10-09 07:34:22'),
(20,1,10,45000.00,'aktif','2025-10-09 07:34:22','2025-10-09 07:34:22'),
(21,2,10,44000.00,'aktif','2025-10-09 07:34:22','2025-10-09 07:34:22');
/*!40000 ALTER TABLE `cabang_layanan` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `inventaris`
--

DROP TABLE IF EXISTS `inventaris`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventaris` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_barang` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `kategori` enum('alat_cukur','produk_perawatan','furniture','elektronik','lainnya') NOT NULL,
  `kategori_id` bigint(20) unsigned DEFAULT NULL,
  `jenis` enum('produk','aset') NOT NULL DEFAULT 'produk',
  `cabang_id` bigint(20) unsigned DEFAULT NULL,
  `stok_minimal` int(11) NOT NULL,
  `stok_saat_ini` int(11) NOT NULL,
  `harga_satuan` decimal(12,2) NOT NULL,
  `satuan` varchar(255) NOT NULL,
  `status` enum('tersedia','habis','hampir_habis','kadaluarsa') NOT NULL DEFAULT 'tersedia',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inventaris_kategori_id_index` (`kategori_id`),
  KEY `inventaris_cabang_id_foreign` (`cabang_id`),
  CONSTRAINT `inventaris_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`) ON DELETE CASCADE,
  CONSTRAINT `inventaris_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategoris` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventaris`
--

LOCK TABLES `inventaris` WRITE;
/*!40000 ALTER TABLE `inventaris` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `inventaris` VALUES
(9,'Hair Powder',NULL,'alat_cukur',2,'produk',3,0,14,20000.00,'pcs','tersedia','2025-10-05 17:51:02','2025-10-11 19:19:05'),
(10,'Hair Powder',NULL,'alat_cukur',2,'produk',2,0,11,20000.00,'pcs','tersedia','2025-10-05 17:54:55','2025-10-11 19:02:40'),
(11,'Mesin Cukur',NULL,'alat_cukur',1,'produk',3,0,7,0.00,'unit','tersedia','2025-10-05 18:08:35','2025-10-05 18:18:00'),
(12,'Hair Powder',NULL,'alat_cukur',2,'produk',1,0,10,20000.00,'pcs','tersedia','2025-10-05 18:23:16','2025-10-11 18:55:42'),
(13,'Mesin Cukur',NULL,'alat_cukur',1,'produk',2,0,1,0.00,'unit','tersedia','2025-10-05 22:12:40','2025-10-05 22:12:40'),
(14,'Kursi',NULL,'alat_cukur',1,'produk',1,0,2,0.00,'unit','tersedia','2025-10-06 06:14:12','2025-10-06 06:14:12');
/*!40000 ALTER TABLE `inventaris` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `kapster`
--

DROP TABLE IF EXISTS `kapster`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `kapster` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_kapster` varchar(255) NOT NULL,
  `cabang_id` bigint(20) unsigned NOT NULL,
  `spesialisasi` varchar(255) DEFAULT NULL,
  `status` enum('aktif','tidak_aktif') NOT NULL DEFAULT 'aktif',
  `komisi_potong_rambut` decimal(5,2) NOT NULL DEFAULT 40.00 COMMENT 'Komisi untuk layanan potong rambut (%)',
  `komisi_layanan_lain` decimal(5,2) NOT NULL DEFAULT 25.00 COMMENT 'Komisi untuk layanan lain (%)',
  `komisi_produk` decimal(5,2) NOT NULL DEFAULT 25.00 COMMENT 'Komisi untuk penjualan produk (%)',
  `telepon` varchar(255) DEFAULT NULL,
  `komisi_persen` decimal(5,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kapster_cabang_id_foreign` (`cabang_id`),
  CONSTRAINT `kapster_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kapster`
--

LOCK TABLES `kapster` WRITE;
/*!40000 ALTER TABLE `kapster` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `kapster` VALUES
(1,'Khusein',2,NULL,'aktif',40.00,25.00,25.00,NULL,40.00,'2025-09-29 05:11:31','2025-10-11 05:02:37'),
(2,'Panca',1,NULL,'aktif',40.00,25.00,25.00,NULL,40.00,'2025-10-05 07:30:14','2025-10-05 07:30:14'),
(3,'Mahesa',3,NULL,'aktif',40.00,25.00,25.00,NULL,40.00,'2025-10-05 07:34:55','2025-10-05 07:34:55'),
(4,'Arif',3,NULL,'aktif',40.00,25.00,25.00,NULL,40.00,'2025-10-05 07:35:09','2025-10-10 13:03:10');
/*!40000 ALTER TABLE `kapster` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `kategoris`
--

DROP TABLE IF EXISTS `kategoris`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `kategoris` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) NOT NULL,
  `kode_kategori` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `jenis_kategori` enum('inventaris','layanan','pengeluaran','cabang','transaksi') NOT NULL,
  `tipe_penggunaan` enum('retail','operasional','both') NOT NULL DEFAULT 'both',
  `komisi_type` enum('potong_rambut','layanan_lain') NOT NULL DEFAULT 'layanan_lain' COMMENT 'Tipe komisi: potong_rambut = 40%, layanan_lain = 25%',
  `tipe` enum('produk','aset','umum') NOT NULL DEFAULT 'umum' COMMENT 'Tipe kategori: produk (untuk dijual), aset (operasional), umum (keduanya)',
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `warna` varchar(7) DEFAULT NULL COMMENT 'Hex color code',
  `ikon` varchar(255) DEFAULT NULL COMMENT 'Icon class name',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kategoris_kode_kategori_unique` (`kode_kategori`),
  KEY `kategoris_jenis_kategori_status_index` (`jenis_kategori`,`status`),
  KEY `kategoris_parent_id_urutan_index` (`parent_id`,`urutan`),
  CONSTRAINT `kategoris_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `kategoris` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategoris`
--

LOCK TABLES `kategoris` WRITE;
/*!40000 ALTER TABLE `kategoris` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `kategoris` VALUES
(1,'Operasional','INV001','Peralatan untuk memotong rambut','inventaris','operasional','layanan_lain','aset',NULL,1,1,'#FF6B35','fa-cut','2025-09-19 05:41:22','2025-10-05 17:50:04'),
(2,'Produk Retail','INV002','Produk untuk perawatan rambut','inventaris','retail','layanan_lain','produk',NULL,8,1,'#4ECDC4','fa-spray-can','2025-09-19 05:41:22','2025-10-05 07:59:19'),
(9,'Potong Rambut','LAY001','Layanan pemotongan rambut','layanan','both','potong_rambut','umum',NULL,4,1,'#E74C3C','fa-cut','2025-09-19 05:41:22','2025-10-05 07:54:19'),
(11,'Perawatan','LAY003','Layanan perawatan rambut dan kulit','layanan','both','layanan_lain','umum',NULL,17,1,'#2ECC71','fa-leaf','2025-09-19 05:41:22','2025-10-05 07:54:19'),
(13,'Operasional','PEN001','Pengeluaran operasional harian','pengeluaran','both','layanan_lain','umum',NULL,5,1,'#34495E','fa-cogs','2025-09-19 05:41:22','2025-10-05 07:54:19'),
(14,'Pembelian Inventaris','PEN002','Pengeluaran untuk pembelian inventaris','pengeluaran','both','layanan_lain','umum',NULL,13,1,'#16A085','fa-shopping-cart','2025-09-19 05:41:22','2025-10-05 07:54:19'),
(15,'Marketing','PEN003','Pengeluaran untuk kegiatan marketing','pengeluaran','both','layanan_lain','umum',NULL,18,1,'#8E44AD','fa-bullhorn','2025-09-19 05:41:22','2025-10-05 07:54:19'),
(16,'Maintenance','PEN004','Pengeluaran untuk pemeliharaan','pengeluaran','both','layanan_lain','umum',NULL,21,1,'#D35400','fa-wrench','2025-09-19 05:41:22','2025-10-05 07:54:19'),
(17,'Cabang Utama','CAB001','Cabang utama/pusat','cabang','both','layanan_lain','umum',NULL,6,1,'#C0392B','fa-building','2025-09-19 05:41:22','2025-10-05 07:54:19'),
(18,'Cabang Franchise','CAB002','Cabang franchise','cabang','both','layanan_lain','umum',NULL,14,1,'#2980B9','fa-store','2025-09-19 05:41:22','2025-10-05 07:54:19'),
(19,'Penjualan Layanan','TRX001','Transaksi penjualan layanan','transaksi','both','layanan_lain','umum',NULL,7,1,'#27AE60','fa-hand-holding-usd','2025-09-19 05:41:22','2025-09-19 05:50:34'),
(20,'Penjualan Produk','TRX002','Transaksi penjualan produk','transaksi','both','layanan_lain','umum',NULL,15,1,'#F1C40F','fa-shopping-bag','2025-09-19 05:41:22','2025-09-19 05:50:34'),
(21,'Paket Layanan','TRX003','Transaksi paket layanan','transaksi','both','layanan_lain','umum',NULL,19,1,'#E67E22','fa-box','2025-09-19 05:41:22','2025-09-19 05:50:34'),
(23,'Gaji','PEN005',NULL,'pengeluaran','both','layanan_lain','umum',NULL,22,1,NULL,NULL,'2025-10-09 07:23:38','2025-10-09 07:23:38'),
(24,'Kasbon','PEN006',NULL,'pengeluaran','both','layanan_lain','umum',NULL,23,1,NULL,NULL,'2025-10-09 07:24:09','2025-10-09 07:24:09');
/*!40000 ALTER TABLE `kategoris` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `layanans`
--

DROP TABLE IF EXISTS `layanans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `layanans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_layanan` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` decimal(10,2) NOT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `kategori_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `layanans_kategori_id_index` (`kategori_id`),
  CONSTRAINT `layanans_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategoris` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `layanans`
--

LOCK TABLES `layanans` WRITE;
/*!40000 ALTER TABLE `layanans` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `layanans` VALUES
(4,'Potong Rambut + Cuci',NULL,0.00,'aktif',9,'2025-10-06 02:18:57','2025-10-09 07:31:11'),
(6,'Potong Rambut',NULL,0.00,'aktif',9,'2025-10-09 07:30:06','2025-10-09 07:30:06'),
(7,'Bleaching',NULL,0.00,'aktif',11,'2025-10-09 07:32:18','2025-10-09 07:32:18'),
(8,'Toning / Semir',NULL,0.00,'aktif',11,'2025-10-09 07:32:58','2025-10-09 07:32:58'),
(9,'Creambath',NULL,0.00,'aktif',11,'2025-10-09 07:33:34','2025-10-09 07:33:34'),
(10,'Grooming Wajah',NULL,0.00,'aktif',11,'2025-10-09 07:34:22','2025-10-09 07:34:22');
/*!40000 ALTER TABLE `layanans` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `migrations` VALUES
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2025_09_10_070054_create_layanans_table',1),
(5,'2025_09_10_074917_create_inventaris_table',1),
(6,'2025_09_10_080010_create_transaksis_table',1),
(7,'2025_09_10_085219_create_pengeluarans_table',1),
(8,'2025_09_10_093041_create_cabang_table',2),
(9,'2025_09_19_120519_create_kategoris_table',3),
(10,'2025_09_19_123226_add_kategori_id_to_inventaris_table',3),
(11,'2025_09_19_123324_add_kategori_id_to_layanans_table',3),
(12,'2025_09_19_123410_add_kategori_id_to_pengeluarans_table',3),
(13,'2025_09_20_085422_add_kategori_id_to_cabang_table',4),
(14,'2025_09_29_114529_create_kapster_table',5),
(15,'2025_09_29_114834_add_kapster_id_to_transaksi_table',6),
(16,'2025_09_29_115004_remove_manager_fields_from_cabang_table',6),
(17,'2025_10_03_152032_update_transaksis_table_remove_customer_fields',7),
(18,'2025_10_03_152554_update_metode_pembayaran_enum_in_transaksis_table',8),
(19,'2025_10_03_153035_create_transaksi_produk_table',9),
(20,'2025_10_05_062921_remove_durasi_estimasi_from_layanans_table',10),
(21,'2025_10_05_063634_remove_kategori_column_from_layanans_table',11),
(22,'2025_10_05_065130_remove_kategori_column_from_pengeluarans_table',12),
(23,'2025_10_05_075234_remove_merek_and_tanggal_kadaluarsa_from_inventaris_table',13),
(24,'2025_10_05_090718_add_jenis_to_inventaris_table',14),
(25,'2025_10_05_125201_add_cabang_id_to_inventaris_table',15),
(26,'2025_10_05_125207_add_cabang_id_to_inventaris_table',15),
(27,'2025_10_05_125229_create_cabang_layanan_table',15),
(28,'2025_10_05_125253_add_cabang_id_to_transaksis_table',15),
(29,'2025_10_05_125316_add_cabang_id_to_pengeluarans_table',15),
(30,'2025_10_05_144429_add_tipe_field_to_kategoris_table',16),
(31,'2025_10_05_144901_add_tipe_penggunaan_to_kategoris_table',17),
(33,'2025_10_10_060155_create_settings_table',18),
(36,'2025_10_10_060305_add_komisi_type_to_kategoris_table',19),
(37,'2025_10_10_144400_convert_old_payment_methods_in_transaksis_table',19),
(38,'2025_10_10_144454_update_metode_pembayaran_to_qris_in_transaksis_table',19),
(39,'2025_10_10_191646_finalize_qris_payment_method_in_transaksis_table',19),
(40,'2025_10_10_144639_convert_old_payment_methods_in_transaksis_table',20),
(41,'2025_10_10_195130_add_komisi_fields_to_kapster_table',20);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `pengeluarans`
--

DROP TABLE IF EXISTS `pengeluarans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengeluarans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cabang_id` bigint(20) unsigned DEFAULT NULL,
  `nama_pengeluaran` varchar(255) NOT NULL,
  `kategori_id` bigint(20) unsigned DEFAULT NULL,
  `jumlah` decimal(12,2) NOT NULL,
  `tanggal_pengeluaran` date NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `bukti_pengeluaran` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pengeluarans_kategori_id_index` (`kategori_id`),
  KEY `pengeluarans_cabang_id_foreign` (`cabang_id`),
  CONSTRAINT `pengeluarans_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pengeluarans_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategoris` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengeluarans`
--

LOCK TABLES `pengeluarans` WRITE;
/*!40000 ALTER TABLE `pengeluarans` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `pengeluarans` VALUES
(7,NULL,'momo',14,20000.00,'2025-10-05',NULL,NULL,'pending','2025-10-04 23:58:49','2025-10-04 23:58:49'),
(10,NULL,'ghchg',14,20000.00,'2025-10-05',NULL,NULL,'pending','2025-10-05 06:52:37','2025-10-05 06:52:37'),
(11,NULL,'pomade',14,500000.00,'2025-10-08',NULL,NULL,'pending','2025-10-08 01:42:00','2025-10-11 19:20:36'),
(12,NULL,'ghchg',15,2200000.00,'2025-10-12',NULL,NULL,'pending','2025-10-11 19:20:50','2025-10-11 19:20:50');
/*!40000 ALTER TABLE `pengeluarans` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `sessions` VALUES
('137K0CWeLYVFc5vnVAIsxoVxXsD8vjSUzXYXow8R',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiWXNzQ3pvMWJyb2lJd1BaV1N0elJDZWdoUzZlOXFrMURyTG5wVnNsVSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTA6Imh0dHA6Ly9pbnZlbnRhcmlzLWJhcmJlcnNob3AudGVzdC9rZWxvbGEtdHJhbnNha3NpIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1760260858),
('gmKcBp24EjwC3JvEPaoEOeXSBvczZhlN3w7QT0Ul',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiRERZVmpzMXhVNGZQWGd2V0J4ZDhqd1dIZlNPNXlvYzZMRDlDSENlbiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTA6Imh0dHA6Ly9pbnZlbnRhcmlzLWJhcmJlcnNob3AudGVzdC9rZWxvbGEtdHJhbnNha3NpIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1760269152),
('lbKU3uXpUnD9qXtYSSsOryaegkrzVjUEcTE75yBa',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoic05YN0pQMnNNM094TjJnbHBmVk5tb2lLR0NGVnF2YTBpUGtaU2RGQyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly9pbnZlbnRhcmlzLWJhcmJlcnNob3AudGVzdCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1760280617),
('W2Ov0aKCjU0wWVTpbwmBq57TwJ4kOCDJEDYTerOa',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiclAydkhuYjV6Y21oVEJEcmZoSXJPYlRKamZxV3ZieE5zMWZwWmpYSyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTA6Imh0dHA6Ly9pbnZlbnRhcmlzLWJhcmJlcnNob3AudGVzdC9rZWxvbGEtdHJhbnNha3NpIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1760257617);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `group` varchar(255) NOT NULL DEFAULT 'general',
  `type` varchar(255) NOT NULL DEFAULT 'string',
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `settings` VALUES
(1,'komisi_potong_rambut','40','komisi','number','Persentase komisi untuk layanan kategori Potong Rambut','2025-10-09 23:04:11','2025-10-09 23:04:11'),
(2,'komisi_layanan_lain','25','komisi','number','Persentase komisi untuk layanan kategori selain Potong Rambut','2025-10-09 23:04:11','2025-10-09 23:04:11'),
(3,'komisi_produk','25','komisi','number','Persentase komisi untuk penjualan produk retail','2025-10-09 23:04:11','2025-10-09 23:04:11'),
(4,'target_bulanan','20000000','general','string','Target pendapatan bulanan','2025-10-11 17:44:21','2025-10-11 17:49:21');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `transaksi_produk`
--

DROP TABLE IF EXISTS `transaksi_produk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `transaksi_produk` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `transaksi_id` bigint(20) unsigned NOT NULL,
  `inventaris_id` bigint(20) unsigned NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `harga_satuan` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transaksi_produk_transaksi_id_foreign` (`transaksi_id`),
  KEY `transaksi_produk_inventaris_id_foreign` (`inventaris_id`),
  CONSTRAINT `transaksi_produk_inventaris_id_foreign` FOREIGN KEY (`inventaris_id`) REFERENCES `inventaris` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transaksi_produk_transaksi_id_foreign` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksis` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaksi_produk`
--

LOCK TABLES `transaksi_produk` WRITE;
/*!40000 ALTER TABLE `transaksi_produk` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `transaksi_produk` VALUES
(14,21,9,1,20000.00,20000.00,'2025-10-06 06:15:55','2025-10-06 06:15:55'),
(15,22,9,1,20000.00,20000.00,'2025-10-06 08:53:54','2025-10-06 08:53:54'),
(18,28,9,1,20000.00,20000.00,'2025-10-08 13:06:59','2025-10-08 13:06:59'),
(19,29,9,7,20000.00,140000.00,'2025-10-08 21:28:11','2025-10-08 21:28:11'),
(20,34,12,1,20000.00,20000.00,'2025-10-09 15:38:46','2025-10-09 15:38:46'),
(21,35,10,1,20000.00,20000.00,'2025-10-09 22:43:28','2025-10-09 22:43:28'),
(22,37,12,2,20000.00,40000.00,'2025-10-09 22:48:17','2025-10-09 22:48:17'),
(23,38,9,5,20000.00,100000.00,'2025-10-09 22:51:12','2025-10-09 22:51:12'),
(24,39,9,3,20000.00,60000.00,'2025-10-09 22:51:55','2025-10-09 22:51:55'),
(25,40,9,1,20000.00,20000.00,'2025-10-09 22:53:08','2025-10-09 22:53:08'),
(26,53,9,8,20000.00,160000.00,'2025-10-11 19:18:52','2025-10-11 19:18:52'),
(27,51,9,1,20000.00,20000.00,'2025-10-11 19:19:05','2025-10-11 19:19:05');
/*!40000 ALTER TABLE `transaksi_produk` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `transaksis`
--

DROP TABLE IF EXISTS `transaksis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `transaksis` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cabang_id` bigint(20) unsigned DEFAULT NULL,
  `nomor_transaksi` varchar(255) NOT NULL,
  `layanan_id` bigint(20) unsigned NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `metode_pembayaran` enum('tunai','transfer','qris') DEFAULT 'tunai',
  `status` enum('pending','sedang_proses','selesai','dibatalkan') NOT NULL DEFAULT 'pending',
  `catatan` text DEFAULT NULL,
  `kapster_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transaksis_nomor_transaksi_unique` (`nomor_transaksi`),
  KEY `transaksis_layanan_id_foreign` (`layanan_id`),
  KEY `transaksis_kapster_id_foreign` (`kapster_id`),
  KEY `transaksis_cabang_id_foreign` (`cabang_id`),
  CONSTRAINT `transaksis_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transaksis_kapster_id_foreign` FOREIGN KEY (`kapster_id`) REFERENCES `kapster` (`id`) ON DELETE SET NULL,
  CONSTRAINT `transaksis_layanan_id_foreign` FOREIGN KEY (`layanan_id`) REFERENCES `layanans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaksis`
--

LOCK TABLES `transaksis` WRITE;
/*!40000 ALTER TABLE `transaksis` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `transaksis` VALUES
(21,3,'TRX20251000001',4,'2025-10-06',35000.00,'tunai','selesai',NULL,3,'2025-10-06 06:15:55','2025-10-06 06:15:55'),
(22,3,'TRX20251000002',4,'2025-10-06',35000.00,'tunai','selesai',NULL,3,'2025-10-06 08:53:54','2025-10-06 08:53:54'),
(23,3,'TRX20251000003',4,'2025-10-08',15000.00,'tunai','selesai',NULL,4,'2025-10-07 19:04:14','2025-10-07 19:04:14'),
(25,1,'TRX20251000004',4,'2025-10-04',15000.00,'tunai','selesai',NULL,2,'2025-10-08 02:14:54','2025-10-11 09:11:27'),
(28,3,'TRX20251000005',4,'2025-10-08',35000.00,'tunai','selesai',NULL,3,'2025-10-08 13:06:59','2025-10-11 09:11:27'),
(29,3,'TRX20251000006',4,'2025-10-09',155000.00,'tunai','selesai',NULL,4,'2025-10-08 21:28:11','2025-10-11 09:11:27'),
(30,1,'TRX20251000007',4,'2025-10-09',15000.00,'transfer','selesai',NULL,2,'2025-10-08 22:33:49','2025-10-11 09:11:27'),
(33,1,'TRX20251000008',6,'2025-10-09',20000.00,'tunai','selesai',NULL,2,'2025-10-09 07:45:02','2025-10-11 09:11:27'),
(34,1,'TRX20251000009',7,'2025-10-09',45000.00,'transfer','selesai',NULL,2,'2025-10-09 15:38:46','2025-10-11 09:11:27'),
(35,2,'TRX20251000010',9,'2025-10-10',45000.00,'tunai','selesai',NULL,1,'2025-10-09 22:43:28','2025-10-11 09:11:27'),
(36,3,'TRX20251000011',4,'2025-10-10',20000.00,'tunai','selesai',NULL,3,'2025-10-09 22:45:15','2025-10-11 09:11:27'),
(37,1,'TRX20251000012',7,'2025-10-10',65000.00,'tunai','selesai',NULL,2,'2025-10-09 22:48:17','2025-10-11 09:11:27'),
(38,3,'TRX20251000013',6,'2025-10-10',120000.00,'tunai','selesai',NULL,3,'2025-10-09 22:51:12','2025-10-11 09:11:27'),
(39,3,'TRX20251000014',4,'2025-10-10',80000.00,'transfer','selesai',NULL,4,'2025-10-09 22:51:55','2025-10-11 09:11:27'),
(40,3,'TRX20251000015',4,'2025-10-10',40000.00,'transfer','selesai',NULL,4,'2025-10-09 22:53:08','2025-10-11 09:11:27'),
(41,1,'TRX20251000016',7,'2025-10-10',25000.00,'tunai','selesai',NULL,2,'2025-10-10 04:47:46','2025-10-11 09:11:27'),
(42,1,'TRX20251000017',7,'2025-10-10',25000.00,'tunai','selesai',NULL,2,'2025-10-10 04:47:58','2025-10-11 09:11:27'),
(43,2,'TRX20251000018',10,'2025-10-10',44000.00,'tunai','selesai',NULL,1,'2025-10-10 04:48:12','2025-10-11 09:11:27'),
(44,1,'TRX20251000019',6,'2025-10-10',20000.00,'tunai','selesai',NULL,2,'2025-10-10 04:48:22','2025-10-11 09:11:27'),
(45,1,'TRX20251000020',10,'2025-10-10',45000.00,'tunai','selesai',NULL,2,'2025-10-10 04:48:47','2025-10-11 09:11:27'),
(46,2,'TRX20251000021',10,'2025-10-10',44000.00,'transfer','selesai',NULL,1,'2025-10-10 04:49:07','2025-10-11 09:11:27'),
(47,2,'TRX20251000022',10,'2025-10-10',44000.00,'tunai','selesai',NULL,1,'2025-10-10 04:49:32','2025-10-11 09:11:27'),
(48,1,'TRX20251000023',6,'2025-10-10',20000.00,'transfer','selesai',NULL,2,'2025-10-10 07:39:36','2025-10-11 09:11:27'),
(51,3,'TRX20251000024',6,'2025-10-10',40000.00,'qris','selesai',NULL,3,'2025-10-10 12:18:45','2025-10-11 19:19:05'),
(53,3,'TRX20251000025',4,'2025-10-12',180000.00,'qris','selesai',NULL,4,'2025-10-11 19:18:52','2025-10-11 19:18:52');
/*!40000 ALTER TABLE `transaksis` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
commit;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2025-10-12 21:57:18
