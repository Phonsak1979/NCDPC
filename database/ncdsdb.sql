-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.43 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.12.0.7122
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for ncdsdb
CREATE DATABASE IF NOT EXISTS `ncdsdb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `ncdsdb`;

-- Dumping structure for table ncdsdb.dmckd
CREATE TABLE IF NOT EXISTS `dmckd` (
  `id` int NOT NULL AUTO_INCREMENT,
  `hospcode` varchar(5) COLLATE utf8mb4_general_ci DEFAULT '0',
  `pid` varchar(5) COLLATE utf8mb4_general_ci DEFAULT '0',
  `hid` varchar(5) COLLATE utf8mb4_general_ci DEFAULT '0',
  `vhid` varchar(15) COLLATE utf8mb4_general_ci DEFAULT '0',
  `discharge` int DEFAULT NULL,
  `group_diag` varchar(30) COLLATE utf8mb4_general_ci DEFAULT '0',
  `group_date` varchar(50) COLLATE utf8mb4_general_ci DEFAULT '0',
  `group_hos_dx` varchar(50) COLLATE utf8mb4_general_ci DEFAULT '0',
  `min_date_dx` date DEFAULT '0000-00-00',
  PRIMARY KEY (`id`),
  KEY `hospcode` (`hospcode`,`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='โรคไตจากเบาหวาน\r\n\r\n';

-- Dumping data for table ncdsdb.dmckd: ~530 rows (approximately)

-- Dumping structure for table ncdsdb.hcoach
CREATE TABLE IF NOT EXISTS `hcoach` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cid` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `hcoachname` varchar(200) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `hcode` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `birth` date DEFAULT NULL,
  `tel` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `acc_number` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bank` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cid` (`cid`),
  KEY `vhid` (`hcode`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ncdsdb.hcoach: ~46 rows (approximately)

-- Dumping structure for table ncdsdb.healthlit
CREATE TABLE IF NOT EXISTS `healthlit` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `descript` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `str_url` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `str_img` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cgtype` int DEFAULT NULL,
  `totalview` int DEFAULT NULL,
  `d_update` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='สื่อมีเดียสำหรับ cg';

-- Dumping data for table ncdsdb.healthlit: ~10 rows (approximately)
REPLACE INTO `healthlit` (`id`, `name`, `descript`, `str_url`, `str_img`, `cgtype`, `totalview`, `d_update`) VALUES
	(27, 'การออกกำลังกาย', 'การออกกำลังกาย', '8cI9q3gptng', 'education.png', NULL, NULL, '2026-04-03'),
	(28, 'ป้องกันโรค NCDs “สุขภาพดีเริ่มที่ตัวเรา”', 'ป้องกันโรค NCDs “สุขภาพดีเริ่มที่ตัวเรา”', 'HcXtB9wM_GI', 'education.png', NULL, NULL, '2026-05-11'),
	(29, 'NCD การจัดการอาหารอย่างง่าย', 'NCD การจัดการอาหารอย่างง่าย', 'EYJ_lv8l6hg', 'education.png', NULL, NULL, '2026-05-11'),
	(30, 'หลักโภชนากับการป้องกันโรคเบาหวาน', 'หลักโภชนากับการป้องกันโรคเบาหวาน', 'ZM7AS5-w_cE', 'education.png', NULL, NULL, '2026-05-11'),
	(31, 'โรคเบาหวาน ผู้ป่วยโรคเบาหวานมีวิธีปฏิบัติตัวอย่างไ', 'โรคเบาหวาน ผู้ป่วยโรคเบาหวานมีวิธีปฏิบัติตัวอย่างไ', 'XxqsIjMWlZM', 'education.png', NULL, 0, '2026-05-11'),
	(32, 'โรคเบาหวาน ผู้ป่วยโรคเบาหวานมีวิธีปฏิบัติตัวอย่างไ', 'โรคเบาหวาน ผู้ป่วยโรคเบาหวานมีวิธีปฏิบัติตัวอย่างไ', 'XxqsIjMWlZM', 'education.png', NULL, 0, '2026-05-11'),
	(33, 'โรคความดันโลหิตสูง', 'โรคความดันโลหิตสูง', 'OhUo8PuwMk0', 'education.png', NULL, NULL, '2026-05-11'),
	(34, 'ลดโรคเบาหวาน ความดัน ด้วยการปรับเปลี่ยนพฤติกรรม 3 ', 'ลดโรคเบาหวาน ความดัน ด้วยการปรับเปลี่ยนพฤติกรรม 3 ', 'KjCoKevfNSQ', 'education.png', NULL, NULL, '2026-05-11'),
	(35, 'ลดโรคเบาหวาน ความดัน ด้วยการปรับเปลี่ยนพฤติกรรม3อ2', 'ลดโรคเบาหวาน ความดัน ด้วยการปรับเปลี่ยนพฤติกรรม3อ2', 'KjCoKevfNSQ', 'education.png', NULL, NULL, '2026-05-11'),
	(37, 'ไม่อยากเป็นโรคไตให้ดูแล 3 อย่างนี้', 'ไม่อยากเป็นโรคไตให้ดูแล 3 อย่างนี้', 'u9p0uO6r9Oo', 'education.png', NULL, NULL, '2026-05-11');

-- Dumping structure for table ncdsdb.hl_survey
CREATE TABLE IF NOT EXISTS `hl_survey` (
  `id` int NOT NULL AUTO_INCREMENT,
  `hospcode` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `pid` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `hcoachname` varchar(50) COLLATE utf8mb4_general_ci DEFAULT '',
  `q1` int DEFAULT NULL,
  `q2` int DEFAULT NULL,
  `q3` int DEFAULT NULL,
  `q4` int DEFAULT NULL,
  `q5` int DEFAULT NULL,
  `q6` int DEFAULT NULL,
  `q7` int DEFAULT NULL,
  `q8` int DEFAULT NULL,
  `q9` int DEFAULT NULL,
  `q10` int DEFAULT NULL,
  `q11` int DEFAULT NULL,
  `q12` int DEFAULT NULL,
  `score_access` int DEFAULT NULL,
  `score_understand` int DEFAULT NULL,
  `score_apply` int DEFAULT NULL,
  `score_eval` int DEFAULT NULL,
  `score_total` int DEFAULT NULL,
  `level` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `coach_id` (`hcoachname`) USING BTREE,
  KEY `user_id` (`hospcode`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ncdsdb.hl_survey: ~4 rows (approximately)

-- Dumping structure for table ncdsdb.home
CREATE TABLE IF NOT EXISTS `home` (
  `id` int NOT NULL AUTO_INCREMENT,
  `hospcode` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `hid` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `village` varchar(2) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tambon` varchar(2) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ampur` varchar(2) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `changwat` varchar(2) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `latitude` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `longitude` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nfamily` int DEFAULT NULL,
  `d_update` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hospcode` (`hospcode`,`hid`)
) ENGINE=InnoDB AUTO_INCREMENT=1076 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='hospcode|hid|house_id|housetype|roomno|condo|house|soisub|soimain|road|villaname|village|tambon|ampur|changwat|telephone|latitude|longitude|nfamily|locatype|vhvid|headid|toilet|water|watertype|garbage|housing|durability|cleanliness|ventilation|light|watertm|mfood|bcontrol|acontrol|chemical|outdate|d_update';

-- Dumping data for table ncdsdb.home: ~0 rows (approximately)

-- Dumping structure for table ncdsdb.ltc_users
CREATE TABLE IF NOT EXISTS `ltc_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `hcode` varchar(20) NOT NULL COMMENT 'รหัสหน่วยงาน',
  `email` varchar(100) NOT NULL,
  `fname` text,
  `username` varchar(100) NOT NULL COMMENT 'รหัสผู้ใช้งาน',
  `password_hash` varchar(255) NOT NULL,
  `permis` varchar(50) NOT NULL COMMENT 'สถานะผู้ใช้งาน',
  `created_at` date DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `username` (`username`),
  KEY `hcode` (`hcode`)
) ENGINE=InnoDB AUTO_INCREMENT=273 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- Dumping data for table ncdsdb.ltc_users: ~50 rows (approximately)
REPLACE INTO `ltc_users` (`id`, `hcode`, `email`, `fname`, `username`, `password_hash`, `permis`, `created_at`) VALUES
	(272, '00312', 'admin@admin.com', 'ทดสอบ', 'admin', '$2y$10$0hGoHTwxRjUZIoY7ujcWGunxmNy.5NNrbpLk4tNhG5emL7lG/oHFm', 'auth', NULL);

-- Dumping structure for table ncdsdb.newdm
CREATE TABLE IF NOT EXISTS `newdm` (
  `id` int NOT NULL AUTO_INCREMENT,
  `hospcode` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pid` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `vhid` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mix_dx` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `type_dx` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_dx` date DEFAULT NULL,
  `hosp_dx` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ld_hba1c` date DEFAULT NULL,
  `rs_hba1c` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ih_hba1c` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ld_fpg1` date DEFAULT NULL,
  `rs_fpg1` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ih_fpg1` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ld_fpg2` date DEFAULT NULL,
  `rs_fpg2` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ih_fpg2` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ld_retina` date DEFAULT NULL,
  `rs_retina` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ih_retina` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ld_foot` date DEFAULT NULL,
  `rs_foot` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ih_foot` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `min_date_dx_dm` date DEFAULT NULL,
  `year_dx` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hospcode` (`hospcode`,`pid`,`vhid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='												\r\n';

-- Dumping data for table ncdsdb.newdm: ~346 rows (approximately)

-- Dumping structure for table ncdsdb.newdmht
CREATE TABLE IF NOT EXISTS `newdmht` (
  `id` int NOT NULL AUTO_INCREMENT,
  `hospcode` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pid` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `vhid` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mix_dx` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `type_dx` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_dx` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `hosp_dx` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ld_hba1c` date DEFAULT NULL,
  `rs_hba1c` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ih_hba1c` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ld_fpg1` date DEFAULT NULL,
  `rs_fpg1` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ih_fpg1` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ld_fpg2` date DEFAULT NULL,
  `rs_fpg2` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ih_fpg2` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ld_retina` date DEFAULT NULL,
  `rs_retina` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ih_retina` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ld_foot` date DEFAULT NULL,
  `rs_foot` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ih_foot` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ld_bp1` date DEFAULT NULL,
  `ih_bp1` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rs_bps1` int DEFAULT NULL,
  `rs_bpd1` int DEFAULT NULL,
  `ld_bp2` date DEFAULT NULL,
  `ih_bp2` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rs_bps2` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rs_bpd2` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `min_date_dx_dm` date DEFAULT NULL,
  `min_date_dx_ht` date DEFAULT NULL,
  `year_dx` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hospcode` (`hospcode`,`pid`,`vhid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='												\r\n';

-- Dumping data for table ncdsdb.newdmht: ~3,379 rows (approximately)

-- Dumping structure for table ncdsdb.newht
CREATE TABLE IF NOT EXISTS `newht` (
  `id` int NOT NULL AUTO_INCREMENT,
  `hospcode` varchar(10) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `pid` varchar(10) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `hid` varchar(10) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `vhid` varchar(10) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `discharge` varchar(5) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `typearea` varchar(5) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `source_tb` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mix_dx` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `type_dx` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_dx` date DEFAULT NULL,
  `hosp_dx` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ld_bp1` date DEFAULT NULL,
  `ih_bp1` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rs_bps1` int DEFAULT NULL,
  `rs_bpd1` int DEFAULT NULL,
  `ld_bp2` date DEFAULT NULL,
  `ih_bp2` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rs_bps2` int DEFAULT NULL,
  `rs_bpd2` int DEFAULT NULL,
  `min_date_dx_ht` date DEFAULT NULL,
  `year_dx` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hospcode` (`hospcode`,`pid`,`hid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='															\r\n';

-- Dumping data for table ncdsdb.newht: ~508 rows (approximately)

-- Dumping structure for table ncdsdb.office
CREATE TABLE IF NOT EXISTS `office` (
  `hcode` varchar(10) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'รหัสหน่วยงาน',
  `hname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ชื่อหน่วยงาน',
  `htype` enum('สสอ.','รพ.สต.','อบต.','เทศบาล','รพ.','สสช.') COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'ประเภทหน่วยงาน',
  `hdepart` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tmb_code` varchar(6) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'รหัสตำบล',
  `amp_code` varchar(4) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'รหัสอำภอ',
  `chw_code` varchar(2) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'รหัสจังหวัด',
  `d_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`hcode`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table ncdsdb.office: ~18 rows (approximately)
REPLACE INTO `office` (`hcode`, `hname`, `htype`, `hdepart`, `tmb_code`, `amp_code`, `chw_code`, `d_update`) VALUES
	('00312', 'สสอ.ศรีเมืองใหม่', 'สสอ.', NULL, NULL, NULL, NULL, '2025-11-09 01:49:54'),
	('03541', 'รพ.สต.บ้านนาแค', 'รพ.สต.', NULL, NULL, NULL, NULL, '2025-11-09 01:49:26'),
	('03542', 'รพ.สต.บ้านบก ตำบลเอือดใหญ่', 'รพ.สต.', NULL, NULL, NULL, NULL, '2025-11-09 01:49:26'),
	('03543', 'รพ.สต.หนองขุ่น', 'รพ.สต.', NULL, NULL, NULL, NULL, '2025-11-09 01:49:26'),
	('03544', 'รพ.สต.บ้านจันทัย ตำบลวาริน', 'รพ.สต.', NULL, NULL, NULL, NULL, '2025-11-09 01:49:26'),
	('03545', 'รพ.สต.บ้านลาดควาย ตำบลลาดควาย', 'รพ.สต.', NULL, NULL, NULL, NULL, '2025-11-09 01:49:26'),
	('03546', 'รพ.สต.บ้านคำบง ตำบลสงยาง', 'รพ.สต.', NULL, NULL, NULL, NULL, '2025-11-09 01:49:26'),
	('03547', 'รพ.สต.บ้านภูหล่น ตำบลสงยาง', 'รพ.สต.', NULL, NULL, NULL, NULL, '2025-11-09 01:49:26'),
	('03548', 'รพ.สต.ตะบ่าย', 'รพ.สต.', NULL, NULL, NULL, NULL, '2025-11-09 01:49:26'),
	('03549', 'รพ.สต.บ้านคำไหล ตำบลคำไหล', 'รพ.สต.', NULL, NULL, NULL, NULL, '2025-11-09 01:49:26'),
	('03550', 'รพ.สต.บ้านห้วยหมากน้อย', 'รพ.สต.', NULL, NULL, NULL, NULL, '2025-11-09 01:49:26'),
	('03551', 'รพ.สต.บ้านหนามแท่ง', 'รพ.สต.', NULL, NULL, NULL, NULL, '2025-11-09 01:49:26'),
	('03552', 'รพ.สต.บ้านคำหมาไน ตำบลนาเลิน', 'รพ.สต.', NULL, NULL, NULL, NULL, '2025-11-09 01:49:26'),
	('03553', 'รพ.สต.บ้านดอนใหญ่ ตำบลดอนใหญ่', 'รพ.สต.', NULL, NULL, NULL, NULL, '2025-11-09 01:49:26'),
	('10224', 'สสช.โหง่นขาม', 'สสช.', NULL, NULL, NULL, NULL, '2025-11-09 01:50:49'),
	('10225', 'สสช.ดงนา', 'สสช.', NULL, NULL, NULL, NULL, '2025-11-09 01:50:45'),
	('10944', 'โรงพยาบาลศรีเมืองใหม่', 'รพ.', NULL, NULL, NULL, NULL, '2025-11-09 01:50:51'),
	('13871', 'รพ.สต.นาทอย', 'รพ.สต.', 'อบจ.', NULL, NULL, NULL, '2026-04-20 04:43:08');

-- Dumping structure for table ncdsdb.olddm
CREATE TABLE IF NOT EXISTS `olddm` (
  `id` int NOT NULL AUTO_INCREMENT,
  `hospcode` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pid` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `vhid` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mix_dx` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `type_dx` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_dx` date DEFAULT NULL,
  `hosp_dx` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ld_hba1c` date DEFAULT NULL,
  `rs_hba1c` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ih_hba1c` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ld_fpg1` date DEFAULT NULL,
  `rs_fpg1` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ih_fpg1` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ld_fpg2` date DEFAULT NULL,
  `rs_fpg2` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ih_fpg2` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ld_retina` date DEFAULT NULL,
  `rs_retina` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ih_retina` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ld_foot` date DEFAULT NULL,
  `rs_foot` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ih_foot` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `min_date_dx_dm` date DEFAULT NULL,
  `year_dx` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hospcode` (`hospcode`,`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='												\r\n';

-- Dumping data for table ncdsdb.olddm: ~4,382 rows (approximately)

-- Dumping structure for table ncdsdb.oldht
CREATE TABLE IF NOT EXISTS `oldht` (
  `id` int NOT NULL AUTO_INCREMENT,
  `hospcode` varchar(10) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `pid` varchar(10) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `hid` varchar(10) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `vhid` varchar(10) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `discharge` varchar(5) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `typearea` varchar(5) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `source_tb` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mix_dx` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `type_dx` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_dx` date DEFAULT NULL,
  `hosp_dx` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ld_bp1` date DEFAULT NULL,
  `ih_bp1` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rs_bps1` int DEFAULT NULL,
  `rs_bpd1` int DEFAULT NULL,
  `ld_bp2` date DEFAULT NULL,
  `ih_bp2` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rs_bps2` int DEFAULT NULL,
  `rs_bpd2` int DEFAULT NULL,
  `min_date_dx_ht` date DEFAULT NULL,
  `year_dx` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hospcode` (`hospcode`,`pid`,`hid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='															\r\n';

-- Dumping data for table ncdsdb.oldht: ~7,301 rows (approximately)

-- Dumping structure for table ncdsdb.patient_vitals
CREATE TABLE IF NOT EXISTS `patient_vitals` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `hospcode` varchar(10) DEFAULT NULL,
  `pid` varchar(10) DEFAULT NULL,
  `weight` decimal(5,1) NOT NULL COMMENT 'กิโลกรัม',
  `height` decimal(5,1) NOT NULL COMMENT 'เซนติเมตร',
  `bmi` decimal(4,1) NOT NULL,
  `bmi_level` enum('underweight','normal','overweight','obese1','obese2') NOT NULL,
  `bp_systolic` smallint unsigned NOT NULL COMMENT 'มม.ปรอท (ตัวบน)',
  `bp_diastolic` smallint unsigned NOT NULL COMMENT 'มม.ปรอท (ตัวล่าง)',
  `bp_level` enum('normal','elevated','stage1','stage2','crisis') NOT NULL,
  `blood_sugar` decimal(5,1) NOT NULL COMMENT 'มก./ดล.',
  `sugar_type` enum('fasting','random','2h_postprandial') NOT NULL COMMENT 'ประเภทการตรวจ',
  `sugar_level` enum('normal','prediabetes','diabetes') NOT NULL,
  `note` text,
  `recorded_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `hcoachname` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `recorded_at` (`recorded_at`),
  KEY `patient_id` (`pid`) USING BTREE,
  KEY `hospcode` (`hospcode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table ncdsdb.patient_vitals: ~1 rows (approximately)

-- Dumping structure for table ncdsdb.person
CREATE TABLE IF NOT EXISTS `person` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `hospcode` varchar(9) COLLATE utf8mb4_general_ci NOT NULL,
  `cid` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `pid` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `hid` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `prename` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `fname` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `lname` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `hn` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sex` varchar(2) COLLATE utf8mb4_general_ci NOT NULL,
  `birth` date NOT NULL,
  `mstatus` varchar(2) COLLATE utf8mb4_general_ci NOT NULL,
  `typearea` varchar(2) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `adl` int DEFAULT NULL,
  `tai` int DEFAULT NULL,
  `riskfall` int DEFAULT NULL,
  `d_update` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `hospcode` (`hospcode`,`pid`,`hid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ncdsdb.person: ~53,688 rows (approximately)

-- Dumping structure for table ncdsdb.remission
CREATE TABLE IF NOT EXISTS `remission` (
  `id` int NOT NULL AUTO_INCREMENT,
  `idcard` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `remission_date` date NOT NULL,
  `hba1c1` decimal(4,2) DEFAULT NULL,
  `date_h1` date DEFAULT NULL,
  `hba1c2` decimal(4,2) DEFAULT NULL,
  `date_h2` date DEFAULT NULL,
  `hba1c3` decimal(4,2) DEFAULT NULL,
  `date_h3` date DEFAULT NULL,
  `dtx` decimal(5,2) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `bmi` decimal(4,2) DEFAULT NULL,
  `notes` mediumtext COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ncdsdb.remission: ~0 rows (approximately)

-- Dumping structure for table ncdsdb.riskdm
CREATE TABLE IF NOT EXISTS `riskdm` (
  `id` int NOT NULL AUTO_INCREMENT,
  `hospcode` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pid` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `birth` date DEFAULT NULL,
  `hid` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `vhid` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sex` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `discharge` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `typearea` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_screen` date DEFAULT NULL,
  `bstest` int DEFAULT NULL,
  `bslevel` int DEFAULT NULL,
  `result` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `inprojected` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hospcode` (`hospcode`,`pid`,`hid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='กลุ่มเสี่ยงเบาหวาน\r\n';

-- Dumping data for table ncdsdb.riskdm: ~2,077 rows (approximately)

-- Dumping structure for table ncdsdb.riskht
CREATE TABLE IF NOT EXISTS `riskht` (
  `id` int NOT NULL AUTO_INCREMENT,
  `hospcode` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `pid` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `sex` varchar(5) COLLATE utf8mb4_general_ci NOT NULL,
  `birth` date DEFAULT NULL,
  `hid` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `vhid` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `discharge` varchar(10) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `typearea` varchar(5) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `date_screen` date NOT NULL,
  `sbp` int NOT NULL DEFAULT '0',
  `dbp` int NOT NULL DEFAULT '0',
  `result` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `inprojected` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hospcode` (`hospcode`,`pid`,`hid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='กลุ่มเสี่ยงความดันโลหิตสูง\r\nhoscode	hosname	cid	pid	name	lname	sex	birth	hid	addr	check_vhid	nation	discharge	typearea	date_screen	sbp	dbp	result\r\n';

-- Dumping data for table ncdsdb.riskht: ~1,947 rows (approximately)

-- Dumping structure for table ncdsdb.screened_dm
CREATE TABLE IF NOT EXISTS `screened_dm` (
  `id` int NOT NULL AUTO_INCREMENT,
  `hospcode` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pid` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `check_vhid` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `typearea` varchar(2) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_screen` date DEFAULT NULL,
  `bstest` int DEFAULT NULL,
  `bslevel` int DEFAULT NULL,
  `hosp_screen` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `hosp_input` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `risk` varchar(2) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `result` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hospcode` (`hospcode`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=23662 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='คัดกรอง dm';

-- Dumping data for table ncdsdb.screened_dm: ~0 rows (approximately)

-- Dumping structure for table ncdsdb.screened_ht
CREATE TABLE IF NOT EXISTS `screened_ht` (
  `id` int NOT NULL AUTO_INCREMENT,
  `hospcode` varchar(10) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `pid` varchar(10) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `check_vhid` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `typearea` varchar(2) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_screen` date DEFAULT NULL,
  `sbp` int NOT NULL DEFAULT '0',
  `dbp` int NOT NULL DEFAULT '0',
  `hosp_screen` varchar(10) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `hosp_input` varchar(10) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `risk` int NOT NULL DEFAULT '0',
  `result` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `hospcode` (`hospcode`),
  KEY `pid` (`pid`),
  KEY `check_vhid` (`check_vhid`)
) ENGINE=InnoDB AUTO_INCREMENT=21045 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='คัดกรอง ht';

-- Dumping data for table ncdsdb.screened_ht: ~0 rows (approximately)

-- Dumping structure for table ncdsdb.selected_riskdm
CREATE TABLE IF NOT EXISTS `selected_riskdm` (
  `id` int NOT NULL AUTO_INCREMENT,
  `hospcode` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pid` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `birth` date DEFAULT NULL,
  `hid` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `vhid` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sex` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `discharge` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `typearea` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_screen` date DEFAULT NULL,
  `bstest` int DEFAULT NULL,
  `bslevel` int DEFAULT NULL,
  `sbp` int DEFAULT NULL,
  `dbp` int DEFAULT NULL,
  `result` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bstest2` int DEFAULT NULL,
  `bslevel2` int DEFAULT NULL,
  `sbp2` int DEFAULT NULL,
  `dbp2` int DEFAULT NULL,
  `result2` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `inprojected` int DEFAULT NULL,
  `risktype` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `send` varchar(1) COLLATE utf8mb4_general_ci NOT NULL,
  `hcoach` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `d_update` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `hospcode` (`hospcode`,`pid`,`hid`),
  KEY `hcoach` (`hcoach`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='กลุ่มเสี่ยงเบาหวาน\r\n';

-- Dumping data for table ncdsdb.selected_riskdm: ~430 rows (approximately)

-- Dumping structure for table ncdsdb.selected_riskht
CREATE TABLE IF NOT EXISTS `selected_riskht` (
  `id` int NOT NULL AUTO_INCREMENT,
  `hospcode` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `pid` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `sex` varchar(5) COLLATE utf8mb4_general_ci NOT NULL,
  `birth` date DEFAULT NULL,
  `hid` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `vhid` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `discharge` varchar(10) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `typearea` varchar(5) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `date_screen` date NOT NULL,
  `sbp` int NOT NULL DEFAULT '0',
  `dbp` int NOT NULL DEFAULT '0',
  `result` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `sbp2` int NOT NULL DEFAULT '0',
  `dbp2` int NOT NULL DEFAULT '0',
  `result2` varchar(10) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `inprojected` int DEFAULT NULL,
  `risktype` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `send` varchar(1) COLLATE utf8mb4_general_ci NOT NULL,
  `hcoach` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `hospcode` (`hospcode`,`pid`,`hid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='กลุ่มเสี่ยงความดันโลหิตสูง\r\nhoscode	hosname	cid	pid	name	lname	sex	birth	hid	addr	check_vhid	nation	discharge	typearea	date_screen	sbp	dbp	result\r\n';

-- Dumping data for table ncdsdb.selected_riskht: ~125 rows (approximately)

-- Dumping structure for table ncdsdb.tb_osm
CREATE TABLE IF NOT EXISTS `tb_osm` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cid` varchar(15) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `prename` varchar(10) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `fname` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `lname` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `birth` date NOT NULL,
  `osm_year` varchar(10) COLLATE utf8mb4_general_ci DEFAULT '0',
  `hcode` varchar(10) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `acc_number` varchar(15) COLLATE utf8mb4_general_ci DEFAULT '0',
  `bank` varchar(10) COLLATE utf8mb4_general_ci DEFAULT '0',
  `tel` varchar(10) COLLATE utf8mb4_general_ci DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `hcode` (`hcode`),
  KEY `cid` (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='อสม.';

-- Dumping data for table ncdsdb.tb_osm: ~1,265 rows (approximately)

-- Dumping structure for table ncdsdb.tumbon
CREATE TABLE IF NOT EXISTS `tumbon` (
  `tumid` varchar(8) COLLATE utf8mb4_general_ci NOT NULL,
  `tumbon` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tumbon_eng` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `ampid` int NOT NULL,
  `provid` int NOT NULL,
  `pop` int NOT NULL,
  PRIMARY KEY (`tumid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ncdsdb.tumbon: ~11 rows (approximately)

-- Dumping structure for table ncdsdb.usertype
CREATE TABLE IF NOT EXISTS `usertype` (
  `utid` int NOT NULL AUTO_INCREMENT,
  `usertypename` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `allow` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`utid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ประเภท user';

-- Dumping data for table ncdsdb.usertype: ~4 rows (approximately)
REPLACE INTO `usertype` (`utid`, `usertypename`, `allow`) VALUES
	(1, 'ผู้ดูแลระบบ รพ.สต.(admin)', 'admin'),
	(2, 'ระดับอำเภอ', 'auth'),
	(3, 'Care Manger (cm)', 'cm'),
	(4, 'Organization (อปท)', 'org');

-- Dumping structure for table ncdsdb.village
CREATE TABLE IF NOT EXISTS `village` (
  `hoscode` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `villcode` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `mumoi` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `villname` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `lat` decimal(50,10) NOT NULL,
  `lon` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`villcode`),
  KEY `hoscode` (`hoscode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ncdsdb.village: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
