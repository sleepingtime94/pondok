-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table pondok-test.transaksi
CREATE TABLE IF NOT EXISTS `transaksi` (
  `id_trx` varchar(50) NOT NULL,
  `no_resi` varchar(50) NOT NULL,
  `id_user` bigint unsigned NOT NULL,
  `nik` varchar(16) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `kk` varchar(16) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama` varchar(100) NOT NULL,
  `keterangan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id_dokumen` bigint unsigned NOT NULL,
  `tgl` date NOT NULL,
  `jam` varchar(8) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tgl_respon` date NOT NULL,
  `jam_respon` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tgl_selesai` date NOT NULL,
  `jam_selesai` varchar(10) NOT NULL,
  `id_kec` bigint unsigned NOT NULL,
  `id_kel` bigint unsigned NOT NULL,
  `status` int unsigned NOT NULL,
  `ikm` int NOT NULL,
  `pengambilan_id` bigint unsigned NOT NULL,
  `konfirmasi` varchar(1) NOT NULL,
  `tgl_konfirmasi` date NOT NULL,
  `jam_konfirmasi` varchar(12) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `deleted_at` timestamp NOT NULL,
  PRIMARY KEY (`id_trx`),
  KEY `id_user` (`id_user`),
  KEY `status` (`status`),
  KEY `ikm` (`ikm`),
  KEY `id_dokumen` (`id_dokumen`),
  KEY `pengambilan_tempat` (`pengambilan_id`) USING BTREE,
  KEY `no_kec` (`id_kec`) USING BTREE,
  KEY `no_kel` (`id_kel`) USING BTREE,
  CONSTRAINT `FK_dok` FOREIGN KEY (`id_dokumen`) REFERENCES `jenis_pelayanan` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_kel` FOREIGN KEY (`id_kel`) REFERENCES `desa` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_pengambilan` FOREIGN KEY (`pengambilan_id`) REFERENCES `pengambilan` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_status` FOREIGN KEY (`status`) REFERENCES `status` (`id_status`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table pondok-test.transaksi: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
