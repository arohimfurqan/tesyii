/*
SQLyog Ultimate v8.55 
MySQL - 5.5.5-10.4.17-MariaDB : Database - yii2basic
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`yii2basic` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `yii2basic`;

/*Table structure for table `auth` */

DROP TABLE IF EXISTS `auth`;

CREATE TABLE `auth` (
  `module` varchar(60) DEFAULT NULL,
  `controller` varchar(60) DEFAULT NULL,
  `action` varchar(60) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `auth` */

insert  into `auth`(`module`,`controller`,`action`,`user_id`) values ('basic','auth','create',7),('basic','auth','update',7),('basic','ajax','book',7),('basic','ajax','get-cities',7),('basic','site','signup',7),('basic','auth','index',7),('basic','auth','view',7),('basic','auth','process-auth',7),('basic','ajax','book',7),('basic','auth','delete-auth',7),('basic','ajax','get-book',7),('basic','ajax','provinsi',7),('basic','auth','delete',7),('basic','book','index',7),('basic','book','view',7),('basic','book','create',7),('basic','book','update',7),('basic','book','delete',7),('basic','book','check',7),('basic','employee','index',7),('basic','employee','create',7),('basic','employee','update',7),('basic','employee','delete',7),('basic','employee','sorting',7),('basic','site','error',7),('basic','site','captcha',7),('basic','site','auth',7),('basic','site','index',7),('basic','site','login',7),('basic','site','logout',7),('basic','site','contact',7),('basic','site','about',7),('basic','site','komentar',7),('basic','site','query',7),('basic','site','query2',7),('basic','test','login',7),('basic','test','blog',7),('admin','admin/book','index',7),('admin','admin/book','view',7),('admin','admin/book','create',7),('admin','admin/book','update',7),('admin','admin/book','delete',7),('admin','admin/default','index',7),('debug','debug/default','db-explain',7),('debug','debug/default','index',7),('debug','debug/default','view',7),('debug','debug/default','toolbar',7),('debug','debug/default','download-mail',7),('debug','debug/user','set-identity',7),('debug','debug/user','reset-identity',7),('gii','gii/default','index',7),('gii','gii/default','view',7),('gii','gii/default','preview',7),('gii','gii/default','diff',7),('gii','gii/default','action',7);

/*Table structure for table `auth_assignment` */

DROP TABLE IF EXISTS `auth_assignment`;

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `idx-auth_assignment-user_id` (`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `auth_assignment` */

insert  into `auth_assignment`(`item_name`,`user_id`,`created_at`) values ('Administrator','7',1610337359),('ajax','9',1610337604),('user','5',1610337554);

/*Table structure for table `auth_item` */

DROP TABLE IF EXISTS `auth_item`;

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `auth_item` */

insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/*',2,NULL,NULL,NULL,1610337278,1610337278),('/ajax/*',2,NULL,NULL,NULL,1610337581,1610337581),('/book/*',2,NULL,NULL,NULL,1610337316,1610337316),('Administrator',1,NULL,NULL,NULL,1610337263,1610337263),('ajax',1,NULL,NULL,NULL,1610337578,1610337578),('user',1,NULL,NULL,NULL,1610337407,1610337407);

/*Table structure for table `auth_item_child` */

DROP TABLE IF EXISTS `auth_item_child`;

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `auth_item_child` */

insert  into `auth_item_child`(`parent`,`child`) values ('Administrator','/*'),('ajax','/ajax/*'),('user','/book/*');

/*Table structure for table `auth_rule` */

DROP TABLE IF EXISTS `auth_rule`;

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `auth_rule` */

/*Table structure for table `city` */

DROP TABLE IF EXISTS `city`;

CREATE TABLE `city` (
  `city_id` int(11) NOT NULL,
  `province_id` int(11) DEFAULT NULL,
  `city_name` varchar(255) DEFAULT NULL,
  `type` enum('kabupaten','kota') DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`city_id`),
  KEY `FK_city` (`province_id`),
  CONSTRAINT `FK_city` FOREIGN KEY (`province_id`) REFERENCES `province` (`province_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `city` */

insert  into `city`(`city_id`,`province_id`,`city_name`,`type`,`postal_code`) values (1,21,'Aceh Barat','kabupaten','23681'),(2,21,'Aceh Barat Daya','kabupaten','23764'),(3,21,'Aceh Besar','kabupaten','23951'),(4,21,'Aceh Jaya','kabupaten','23654'),(5,21,'Aceh Selatan','kabupaten','23719'),(6,21,'Aceh Singkil','kabupaten','24785'),(7,21,'Aceh Tamiang','kabupaten','24476'),(8,21,'Aceh Tengah','kabupaten','24511'),(9,21,'Aceh Tenggara','kabupaten','24611'),(10,21,'Aceh Timur','kabupaten','24454'),(11,21,'Aceh Utara','kabupaten','24382'),(12,32,'Agam','kabupaten','26411'),(13,23,'Alor','kabupaten','85811'),(14,19,'Ambon','kota','97222'),(15,34,'Asahan','kabupaten','21214'),(16,24,'Asmat','kabupaten','99777'),(17,1,'Badung','kabupaten','80351'),(18,13,'Balangan','kabupaten','71611'),(19,15,'Balikpapan','kota','76111'),(20,21,'Banda Aceh','kota','23238'),(21,18,'Bandar Lampung','kota','35139'),(22,9,'Bandung','kabupaten','40311'),(23,9,'Bandung','kota','40111'),(24,9,'Bandung Barat','kabupaten','40721'),(25,29,'Banggai','kabupaten','94711'),(26,29,'Banggai Kepulauan','kabupaten','94881'),(27,2,'Bangka','kabupaten','33212'),(28,2,'Bangka Barat','kabupaten','33315'),(29,2,'Bangka Selatan','kabupaten','33719'),(30,2,'Bangka Tengah','kabupaten','33613'),(31,11,'Bangkalan','kabupaten','69118'),(32,1,'Bangli','kabupaten','80619'),(33,13,'Banjar','kabupaten','70619'),(34,9,'Banjar','kota','46311'),(35,13,'Banjarbaru','kota','70712'),(36,13,'Banjarmasin','kota','70117'),(37,10,'Banjarnegara','kabupaten','53419'),(38,28,'Bantaeng','kabupaten','92411'),(39,5,'Bantul','kabupaten','55715'),(40,33,'Banyuasin','kabupaten','30911'),(41,10,'Banyumas','kabupaten','53114'),(42,11,'Banyuwangi','kabupaten','68416'),(43,13,'Barito Kuala','kabupaten','70511'),(44,14,'Barito Selatan','kabupaten','73711'),(45,14,'Barito Timur','kabupaten','73671'),(46,14,'Barito Utara','kabupaten','73881'),(47,28,'Barru','kabupaten','90719'),(48,17,'Batam','kota','29413'),(49,10,'Batang','kabupaten','51211'),(50,8,'Batang Hari','kabupaten','36613'),(51,11,'Batu','kota','65311'),(52,34,'Batu Bara','kabupaten','21655'),(53,30,'Bau-Bau','kota','93719'),(54,9,'Bekasi','kabupaten','17837'),(55,9,'Bekasi','kota','17121'),(56,2,'Belitung','kabupaten','33419'),(57,2,'Belitung Timur','kabupaten','33519'),(58,23,'Belu','kabupaten','85711'),(59,21,'Bener Meriah','kabupaten','24581'),(60,26,'Bengkalis','kabupaten','28719'),(61,12,'Bengkayang','kabupaten','79213'),(62,4,'Bengkulu','kota','38229'),(63,4,'Bengkulu Selatan','kabupaten','38519'),(64,4,'Bengkulu Tengah','kabupaten','38319'),(65,4,'Bengkulu Utara','kabupaten','38619'),(66,15,'Berau','kabupaten','77311'),(67,24,'Biak Numfor','kabupaten','98119'),(68,22,'Bima','kabupaten','84171'),(69,22,'Bima','kota','84139'),(70,34,'Binjai','kota','20712'),(71,17,'Bintan','kabupaten','29135'),(72,21,'Bireuen','kabupaten','24219'),(73,31,'Bitung','kota','95512'),(74,11,'Blitar','kabupaten','66171'),(75,11,'Blitar','kota','66124'),(76,10,'Blora','kabupaten','58219'),(77,7,'Boalemo','kabupaten','96319'),(78,9,'Bogor','kabupaten','16911'),(79,9,'Bogor','kota','16119'),(80,11,'Bojonegoro','kabupaten','62119'),(81,31,'Bolaang Mongondow (Bolmong)','kabupaten','95755'),(82,31,'Bolaang Mongondow Selatan','kabupaten','95774'),(83,31,'Bolaang Mongondow Timur','kabupaten','95783'),(84,31,'Bolaang Mongondow Utara','kabupaten','95765'),(85,30,'Bombana','kabupaten','93771'),(86,11,'Bondowoso','kabupaten','68219'),(87,28,'Bone','kabupaten','92713'),(88,7,'Bone Bolango','kabupaten','96511'),(89,15,'Bontang','kota','75313'),(90,24,'Boven Digoel','kabupaten','99662'),(91,10,'Boyolali','kabupaten','57312'),(92,10,'Brebes','kabupaten','52212'),(93,32,'Bukittinggi','kota','26115'),(94,1,'Buleleng','kabupaten','81111'),(95,28,'Bulukumba','kabupaten','92511'),(96,16,'Bulungan (Bulongan)','kabupaten','77211'),(97,8,'Bungo','kabupaten','37216'),(98,29,'Buol','kabupaten','94564'),(99,19,'Buru','kabupaten','97371'),(100,19,'Buru Selatan','kabupaten','97351'),(101,30,'Buton','kabupaten','93754'),(102,30,'Buton Utara','kabupaten','93745'),(103,9,'Ciamis','kabupaten','46211'),(104,9,'Cianjur','kabupaten','43217'),(105,10,'Cilacap','kabupaten','53211'),(106,3,'Cilegon','kota','42417'),(107,9,'Cimahi','kota','40512'),(108,9,'Cirebon','kabupaten','45611'),(109,9,'Cirebon','kota','45116'),(110,34,'Dairi','kabupaten','22211'),(111,24,'Deiyai (Deliyai)','kabupaten','98784'),(112,34,'Deli Serdang','kabupaten','20511'),(113,10,'Demak','kabupaten','59519'),(114,1,'Denpasar','kota','80227'),(115,9,'Depok','kota','16416'),(116,32,'Dharmasraya','kabupaten','27612'),(117,24,'Dogiyai','kabupaten','98866'),(118,22,'Dompu','kabupaten','84217'),(119,29,'Donggala','kabupaten','94341'),(120,26,'Dumai','kota','28811'),(121,33,'Empat Lawang','kabupaten','31811'),(122,23,'Ende','kabupaten','86351'),(123,28,'Enrekang','kabupaten','91719'),(124,25,'Fakfak','kabupaten','98651'),(125,23,'Flores Timur','kabupaten','86213'),(126,9,'Garut','kabupaten','44126'),(127,21,'Gayo Lues','kabupaten','24653'),(128,1,'Gianyar','kabupaten','80519'),(129,7,'Gorontalo','kabupaten','96218'),(130,7,'Gorontalo','kota','96115'),(131,7,'Gorontalo Utara','kabupaten','96611'),(132,28,'Gowa','kabupaten','92111'),(133,11,'Gresik','kabupaten','61115'),(134,10,'Grobogan','kabupaten','58111'),(135,5,'Gunung Kidul','kabupaten','55812'),(136,14,'Gunung Mas','kabupaten','74511'),(137,34,'Gunungsitoli','kota','22813'),(138,20,'Halmahera Barat','kabupaten','97757'),(139,20,'Halmahera Selatan','kabupaten','97911'),(140,20,'Halmahera Tengah','kabupaten','97853'),(141,20,'Halmahera Timur','kabupaten','97862'),(142,20,'Halmahera Utara','kabupaten','97762'),(143,13,'Hulu Sungai Selatan','kabupaten','71212'),(144,13,'Hulu Sungai Tengah','kabupaten','71313'),(145,13,'Hulu Sungai Utara','kabupaten','71419'),(146,34,'Humbang Hasundutan','kabupaten','22457'),(147,26,'Indragiri Hilir','kabupaten','29212'),(148,26,'Indragiri Hulu','kabupaten','29319'),(149,9,'Indramayu','kabupaten','45214'),(150,24,'Intan Jaya','kabupaten','98771'),(151,6,'Jakarta Barat','kota','11220'),(152,6,'Jakarta Pusat','kota','10540'),(153,6,'Jakarta Selatan','kota','12230'),(154,6,'Jakarta Timur','kota','13330'),(155,6,'Jakarta Utara','kota','14140'),(156,8,'Jambi','kota','36111'),(157,24,'Jayapura','kabupaten','99352'),(158,24,'Jayapura','kota','99114'),(159,24,'Jayawijaya','kabupaten','99511'),(160,11,'Jember','kabupaten','68113'),(161,1,'Jembrana','kabupaten','82251'),(162,28,'Jeneponto','kabupaten','92319'),(163,10,'Jepara','kabupaten','59419'),(164,11,'Jombang','kabupaten','61415'),(165,25,'Kaimana','kabupaten','98671'),(166,26,'Kampar','kabupaten','28411'),(167,14,'Kapuas','kabupaten','73583'),(168,12,'Kapuas Hulu','kabupaten','78719'),(169,10,'Karanganyar','kabupaten','57718'),(170,1,'Karangasem','kabupaten','80819'),(171,9,'Karawang','kabupaten','41311'),(172,17,'Karimun','kabupaten','29611'),(173,34,'Karo','kabupaten','22119'),(174,14,'Katingan','kabupaten','74411'),(175,4,'Kaur','kabupaten','38911'),(176,12,'Kayong Utara','kabupaten','78852'),(177,10,'Kebumen','kabupaten','54319'),(178,11,'Kediri','kabupaten','64184'),(179,11,'Kediri','kota','64125'),(180,24,'Keerom','kabupaten','99461'),(181,10,'Kendal','kabupaten','51314'),(182,30,'Kendari','kota','93126'),(183,4,'Kepahiang','kabupaten','39319'),(184,17,'Kepulauan Anambas','kabupaten','29991'),(185,19,'Kepulauan Aru','kabupaten','97681'),(186,32,'Kepulauan Mentawai','kabupaten','25771'),(187,26,'Kepulauan Meranti','kabupaten','28791'),(188,31,'Kepulauan Sangihe','kabupaten','95819'),(189,6,'Kepulauan Seribu','kabupaten','14550'),(190,31,'Kepulauan Siau Tagulandang Biaro (Sitaro)','kabupaten','95862'),(191,20,'Kepulauan Sula','kabupaten','97995'),(192,31,'Kepulauan Talaud','kabupaten','95885'),(193,24,'Kepulauan Yapen (Yapen Waropen)','kabupaten','98211'),(194,8,'Kerinci','kabupaten','37167'),(195,12,'Ketapang','kabupaten','78874'),(196,10,'Klaten','kabupaten','57411'),(197,1,'Klungkung','kabupaten','80719'),(198,30,'Kolaka','kabupaten','93511'),(199,30,'Kolaka Utara','kabupaten','93911'),(200,30,'Konawe','kabupaten','93411'),(201,30,'Konawe Selatan','kabupaten','93811'),(202,30,'Konawe Utara','kabupaten','93311'),(203,13,'Kotabaru','kabupaten','72119'),(204,31,'Kotamobagu','kota','95711'),(205,14,'Kotawaringin Barat','kabupaten','74119'),(206,14,'Kotawaringin Timur','kabupaten','74364'),(207,26,'Kuantan Singingi','kabupaten','29519'),(208,12,'Kubu Raya','kabupaten','78311'),(209,10,'Kudus','kabupaten','59311'),(210,5,'Kulon Progo','kabupaten','55611'),(211,9,'Kuningan','kabupaten','45511'),(212,23,'Kupang','kabupaten','85362'),(213,23,'Kupang','kota','85119'),(214,15,'Kutai Barat','kabupaten','75711'),(215,15,'Kutai Kartanegara','kabupaten','75511'),(216,15,'Kutai Timur','kabupaten','75611'),(217,34,'Labuhan Batu','kabupaten','21412'),(218,34,'Labuhan Batu Selatan','kabupaten','21511'),(219,34,'Labuhan Batu Utara','kabupaten','21711'),(220,33,'Lahat','kabupaten','31419'),(221,14,'Lamandau','kabupaten','74611'),(222,11,'Lamongan','kabupaten','64125'),(223,18,'Lampung Barat','kabupaten','34814'),(224,18,'Lampung Selatan','kabupaten','35511'),(225,18,'Lampung Tengah','kabupaten','34212'),(226,18,'Lampung Timur','kabupaten','34319'),(227,18,'Lampung Utara','kabupaten','34516'),(228,12,'Landak','kabupaten','78319'),(229,34,'Langkat','kabupaten','20811'),(230,21,'Langsa','kota','24412'),(231,24,'Lanny Jaya','kabupaten','99531'),(232,3,'Lebak','kabupaten','42319'),(233,4,'Lebong','kabupaten','39264'),(234,23,'Lembata','kabupaten','86611'),(235,21,'Lhokseumawe','kota','24352'),(236,32,'Lima Puluh Koto/Kota','kabupaten','26671'),(237,17,'Lingga','kabupaten','29811'),(238,22,'Lombok Barat','kabupaten','83311'),(239,22,'Lombok Tengah','kabupaten','83511'),(240,22,'Lombok Timur','kabupaten','83612'),(241,22,'Lombok Utara','kabupaten','83711'),(242,33,'Lubuk Linggau','kota','31614'),(243,11,'Lumajang','kabupaten','67319'),(244,28,'Luwu','kabupaten','91994'),(245,28,'Luwu Timur','kabupaten','92981'),(246,28,'Luwu Utara','kabupaten','92911'),(247,11,'Madiun','kabupaten','63153'),(248,11,'Madiun','kota','63122'),(249,10,'Magelang','kabupaten','56519'),(250,10,'Magelang','kota','56133'),(251,11,'Magetan','kabupaten','63314'),(252,9,'Majalengka','kabupaten','45412'),(253,27,'Majene','kabupaten','91411'),(254,28,'Makassar','kota','90111'),(255,11,'Malang','kabupaten','65163'),(256,11,'Malang','kota','65112'),(257,16,'Malinau','kabupaten','77511'),(258,19,'Maluku Barat Daya','kabupaten','97451'),(259,19,'Maluku Tengah','kabupaten','97513'),(260,19,'Maluku Tenggara','kabupaten','97651'),(261,19,'Maluku Tenggara Barat','kabupaten','97465'),(262,27,'Mamasa','kabupaten','91362'),(263,24,'Mamberamo Raya','kabupaten','99381'),(264,24,'Mamberamo Tengah','kabupaten','99553'),(265,27,'Mamuju','kabupaten','91519'),(266,27,'Mamuju Utara','kabupaten','91571'),(267,31,'Manado','kota','95247'),(268,34,'Mandailing Natal','kabupaten','22916'),(269,23,'Manggarai','kabupaten','86551'),(270,23,'Manggarai Barat','kabupaten','86711'),(271,23,'Manggarai Timur','kabupaten','86811'),(272,25,'Manokwari','kabupaten','98311'),(273,25,'Manokwari Selatan','kabupaten','98355'),(274,24,'Mappi','kabupaten','99853'),(275,28,'Maros','kabupaten','90511'),(276,22,'Mataram','kota','83131'),(277,25,'Maybrat','kabupaten','98051'),(278,34,'Medan','kota','20228'),(279,12,'Melawi','kabupaten','78619'),(280,8,'Merangin','kabupaten','37319'),(281,24,'Merauke','kabupaten','99613'),(282,18,'Mesuji','kabupaten','34911'),(283,18,'Metro','kota','34111'),(284,24,'Mimika','kabupaten','99962'),(285,31,'Minahasa','kabupaten','95614'),(286,31,'Minahasa Selatan','kabupaten','95914'),(287,31,'Minahasa Tenggara','kabupaten','95995'),(288,31,'Minahasa Utara','kabupaten','95316'),(289,11,'Mojokerto','kabupaten','61382'),(290,11,'Mojokerto','kota','61316'),(291,29,'Morowali','kabupaten','94911'),(292,33,'Muara Enim','kabupaten','31315'),(293,8,'Muaro Jambi','kabupaten','36311'),(294,4,'Muko Muko','kabupaten','38715'),(295,30,'Muna','kabupaten','93611'),(296,14,'Murung Raya','kabupaten','73911'),(297,33,'Musi Banyuasin','kabupaten','30719'),(298,33,'Musi Rawas','kabupaten','31661'),(299,24,'Nabire','kabupaten','98816'),(300,21,'Nagan Raya','kabupaten','23674'),(301,23,'Nagekeo','kabupaten','86911'),(302,17,'Natuna','kabupaten','29711'),(303,24,'Nduga','kabupaten','99541'),(304,23,'Ngada','kabupaten','86413'),(305,11,'Nganjuk','kabupaten','64414'),(306,11,'Ngawi','kabupaten','63219'),(307,34,'Nias','kabupaten','22876'),(308,34,'Nias Barat','kabupaten','22895'),(309,34,'Nias Selatan','kabupaten','22865'),(310,34,'Nias Utara','kabupaten','22856'),(311,16,'Nunukan','kabupaten','77421'),(312,33,'Ogan Ilir','kabupaten','30811'),(313,33,'Ogan Komering Ilir','kabupaten','30618'),(314,33,'Ogan Komering Ulu','kabupaten','32112'),(315,33,'Ogan Komering Ulu Selatan','kabupaten','32211'),(316,33,'Ogan Komering Ulu Timur','kabupaten','32312'),(317,11,'Pacitan','kabupaten','63512'),(318,32,'Padang','kota','25112'),(319,34,'Padang Lawas','kabupaten','22763'),(320,34,'Padang Lawas Utara','kabupaten','22753'),(321,32,'Padang Panjang','kota','27122'),(322,32,'Padang Pariaman','kabupaten','25583'),(323,34,'Padang Sidempuan','kota','22727'),(324,33,'Pagar Alam','kota','31512'),(325,34,'Pakpak Bharat','kabupaten','22272'),(326,14,'Palangka Raya','kota','73112'),(327,33,'Palembang','kota','30111'),(328,28,'Palopo','kota','91911'),(329,29,'Palu','kota','94111'),(330,11,'Pamekasan','kabupaten','69319'),(331,3,'Pandeglang','kabupaten','42212'),(332,9,'Pangandaran','kabupaten','46511'),(333,28,'Pangkajene Kepulauan','kabupaten','90611'),(334,2,'Pangkal Pinang','kota','33115'),(335,24,'Paniai','kabupaten','98765'),(336,28,'Parepare','kota','91123'),(337,32,'Pariaman','kota','25511'),(338,29,'Parigi Moutong','kabupaten','94411'),(339,32,'Pasaman','kabupaten','26318'),(340,32,'Pasaman Barat','kabupaten','26511'),(341,15,'Paser','kabupaten','76211'),(342,11,'Pasuruan','kabupaten','67153'),(343,11,'Pasuruan','kota','67118'),(344,10,'Pati','kabupaten','59114'),(345,32,'Payakumbuh','kota','26213'),(346,25,'Pegunungan Arfak','kabupaten','98354'),(347,24,'Pegunungan Bintang','kabupaten','99573'),(348,10,'Pekalongan','kabupaten','51161'),(349,10,'Pekalongan','kota','51122'),(350,26,'Pekanbaru','kota','28112'),(351,26,'Pelalawan','kabupaten','28311'),(352,10,'Pemalang','kabupaten','52319'),(353,34,'Pematang Siantar','kota','21126'),(354,15,'Penajam Paser Utara','kabupaten','76311'),(355,18,'Pesawaran','kabupaten','35312'),(356,18,'Pesisir Barat','kabupaten','35974'),(357,32,'Pesisir Selatan','kabupaten','25611'),(358,21,'Pidie','kabupaten','24116'),(359,21,'Pidie Jaya','kabupaten','24186'),(360,28,'Pinrang','kabupaten','91251'),(361,7,'Pohuwato','kabupaten','96419'),(362,27,'Polewali Mandar','kabupaten','91311'),(363,11,'Ponorogo','kabupaten','63411'),(364,12,'Pontianak','kabupaten','78971'),(365,12,'Pontianak','kota','78112'),(366,29,'Poso','kabupaten','94615'),(367,33,'Prabumulih','kota','31121'),(368,18,'Pringsewu','kabupaten','35719'),(369,11,'Probolinggo','kabupaten','67282'),(370,11,'Probolinggo','kota','67215'),(371,14,'Pulang Pisau','kabupaten','74811'),(372,20,'Pulau Morotai','kabupaten','97771'),(373,24,'Puncak','kabupaten','98981'),(374,24,'Puncak Jaya','kabupaten','98979'),(375,10,'Purbalingga','kabupaten','53312'),(376,9,'Purwakarta','kabupaten','41119'),(377,10,'Purworejo','kabupaten','54111'),(378,25,'Raja Ampat','kabupaten','98489'),(379,4,'Rejang Lebong','kabupaten','39112'),(380,10,'Rembang','kabupaten','59219'),(381,26,'Rokan Hilir','kabupaten','28992'),(382,26,'Rokan Hulu','kabupaten','28511'),(383,23,'Rote Ndao','kabupaten','85982'),(384,21,'Sabang','kota','23512'),(385,23,'Sabu Raijua','kabupaten','85391'),(386,10,'Salatiga','kota','50711'),(387,15,'Samarinda','kota','75133'),(388,12,'Sambas','kabupaten','79453'),(389,34,'Samosir','kabupaten','22392'),(390,11,'Sampang','kabupaten','69219'),(391,12,'Sanggau','kabupaten','78557'),(392,24,'Sarmi','kabupaten','99373'),(393,8,'Sarolangun','kabupaten','37419'),(394,32,'Sawah Lunto','kota','27416'),(395,12,'Sekadau','kabupaten','79583'),(396,28,'Selayar (Kepulauan Selayar)','kabupaten','92812'),(397,4,'Seluma','kabupaten','38811'),(398,10,'Semarang','kabupaten','50511'),(399,10,'Semarang','kota','50135'),(400,19,'Seram Bagian Barat','kabupaten','97561'),(401,19,'Seram Bagian Timur','kabupaten','97581'),(402,3,'Serang','kabupaten','42182'),(403,3,'Serang','kota','42111'),(404,34,'Serdang Bedagai','kabupaten','20915'),(405,14,'Seruyan','kabupaten','74211'),(406,26,'Siak','kabupaten','28623'),(407,34,'Sibolga','kota','22522'),(408,28,'Sidenreng Rappang/Rapang','kabupaten','91613'),(409,11,'Sidoarjo','kabupaten','61219'),(410,29,'Sigi','kabupaten','94364'),(411,32,'Sijunjung (Sawah Lunto Sijunjung)','kabupaten','27511'),(412,23,'Sikka','kabupaten','86121'),(413,34,'Simalungun','kabupaten','21162'),(414,21,'Simeulue','kabupaten','23891'),(415,12,'Singkawang','kota','79117'),(416,28,'Sinjai','kabupaten','92615'),(417,12,'Sintang','kabupaten','78619'),(418,11,'Situbondo','kabupaten','68316'),(419,5,'Sleman','kabupaten','55513'),(420,32,'Solok','kabupaten','27365'),(421,32,'Solok','kota','27315'),(422,32,'Solok Selatan','kabupaten','27779'),(423,28,'Soppeng','kabupaten','90812'),(424,25,'Sorong','kabupaten','98431'),(425,25,'Sorong','kota','98411'),(426,25,'Sorong Selatan','kabupaten','98454'),(427,10,'Sragen','kabupaten','57211'),(428,9,'Subang','kabupaten','41215'),(429,21,'Subulussalam','kota','24882'),(430,9,'Sukabumi','kabupaten','43311'),(431,9,'Sukabumi','kota','43114'),(432,14,'Sukamara','kabupaten','74712'),(433,10,'Sukoharjo','kabupaten','57514'),(434,23,'Sumba Barat','kabupaten','87219'),(435,23,'Sumba Barat Daya','kabupaten','87453'),(436,23,'Sumba Tengah','kabupaten','87358'),(437,23,'Sumba Timur','kabupaten','87112'),(438,22,'Sumbawa','kabupaten','84315'),(439,22,'Sumbawa Barat','kabupaten','84419'),(440,9,'Sumedang','kabupaten','45326'),(441,11,'Sumenep','kabupaten','69413'),(442,8,'Sungaipenuh','kota','37113'),(443,24,'Supiori','kabupaten','98164'),(444,11,'Surabaya','kota','60119'),(445,10,'Surakarta (Solo)','kota','57113'),(446,13,'Tabalong','kabupaten','71513'),(447,1,'Tabanan','kabupaten','82119'),(448,28,'Takalar','kabupaten','92212'),(449,25,'Tambrauw','kabupaten','98475'),(450,16,'Tana Tidung','kabupaten','77611'),(451,28,'Tana Toraja','kabupaten','91819'),(452,13,'Tanah Bumbu','kabupaten','72211'),(453,32,'Tanah Datar','kabupaten','27211'),(454,13,'Tanah Laut','kabupaten','70811'),(455,3,'Tangerang','kabupaten','15914'),(456,3,'Tangerang','kota','15111'),(457,3,'Tangerang Selatan','kota','15332'),(458,18,'Tanggamus','kabupaten','35619'),(459,34,'Tanjung Balai','kota','21321'),(460,8,'Tanjung Jabung Barat','kabupaten','36513'),(461,8,'Tanjung Jabung Timur','kabupaten','36719'),(462,17,'Tanjung Pinang','kota','29111'),(463,34,'Tapanuli Selatan','kabupaten','22742'),(464,34,'Tapanuli Tengah','kabupaten','22611'),(465,34,'Tapanuli Utara','kabupaten','22414'),(466,13,'Tapin','kabupaten','71119'),(467,16,'Tarakan','kota','77114'),(468,9,'Tasikmalaya','kabupaten','46411'),(469,9,'Tasikmalaya','kota','46116'),(470,34,'Tebing Tinggi','kota','20632'),(471,8,'Tebo','kabupaten','37519'),(472,10,'Tegal','kabupaten','52419'),(473,10,'Tegal','kota','52114'),(474,25,'Teluk Bintuni','kabupaten','98551'),(475,25,'Teluk Wondama','kabupaten','98591'),(476,10,'Temanggung','kabupaten','56212'),(477,20,'Ternate','kota','97714'),(478,20,'Tidore Kepulauan','kota','97815'),(479,23,'Timor Tengah Selatan','kabupaten','85562'),(480,23,'Timor Tengah Utara','kabupaten','85612'),(481,34,'Toba Samosir','kabupaten','22316'),(482,29,'Tojo Una-Una','kabupaten','94683'),(483,29,'Toli-Toli','kabupaten','94542'),(484,24,'Tolikara','kabupaten','99411'),(485,31,'Tomohon','kota','95416'),(486,28,'Toraja Utara','kabupaten','91831'),(487,11,'Trenggalek','kabupaten','66312'),(488,19,'Tual','kota','97612'),(489,11,'Tuban','kabupaten','62319'),(490,18,'Tulang Bawang','kabupaten','34613'),(491,18,'Tulang Bawang Barat','kabupaten','34419'),(492,11,'Tulungagung','kabupaten','66212'),(493,28,'Wajo','kabupaten','90911'),(494,30,'Wakatobi','kabupaten','93791'),(495,24,'Waropen','kabupaten','98269'),(496,18,'Way Kanan','kabupaten','34711'),(497,10,'Wonogiri','kabupaten','57619'),(498,10,'Wonosobo','kabupaten','56311'),(499,24,'Yahukimo','kabupaten','99041'),(500,24,'Yalimo','kabupaten','99481'),(501,5,'Yogyakarta','kota','55111');

/*Table structure for table `employee` */

DROP TABLE IF EXISTS `employee`;

CREATE TABLE `employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `age` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

/*Data for the table `employee` */

insert  into `employee`(`id`,`name`,`age`) values (1,'Arohim Furqan',22),(2,'him',22),(3,'asds',23),(4,'arohim',22),(5,'eqw',22),(6,'www',11),(7,'cuk',12);

/*Table structure for table `event` */

DROP TABLE IF EXISTS `event`;

CREATE TABLE `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `event` */

insert  into `event`(`id`,`title`,`start`,`end`,`location`) values (2,'dd','2021-01-01 00:00:00','2021-01-09 00:00:00','sdw');

/*Table structure for table `event_tools` */

DROP TABLE IF EXISTS `event_tools`;

CREATE TABLE `event_tools` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) DEFAULT NULL,
  `nama_event` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_event_tools` (`event_id`),
  CONSTRAINT `FK_event_tools` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `event_tools` */

insert  into `event_tools`(`id`,`event_id`,`nama_event`,`quantity`) values (4,2,'ds',2);

/*Table structure for table `framework` */

DROP TABLE IF EXISTS `framework`;

CREATE TABLE `framework` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_framework` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `framework` */

insert  into `framework`(`id`,`nama_framework`) values (1,'Codeigniter'),(2,'Laravel'),(3,'Symfony'),(4,'Yii');

/*Table structure for table `gallery` */

DROP TABLE IF EXISTS `gallery`;

CREATE TABLE `gallery` (
  `user_id` int(11) DEFAULT NULL,
  `images` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `gallery` */

insert  into `gallery`(`user_id`,`images`) values (7,'1610024.jpg'),(7,'KTP.jpg'),(7,'Sertifikat Dicoding.png');

/*Table structure for table `kota` */

DROP TABLE IF EXISTS `kota`;

CREATE TABLE `kota` (
  `id_kota` int(11) NOT NULL AUTO_INCREMENT,
  `id_provinsi` int(11) DEFAULT NULL,
  `nama_kota` varchar(255) DEFAULT NULL,
  `type` enum('kabupaten','kota') DEFAULT NULL,
  `kode_pos` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_kota`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `kota` */

insert  into `kota`(`id_kota`,`id_provinsi`,`nama_kota`,`type`,`kode_pos`) values (1,1,'padang','kota','25115'),(2,2,'Medan','kota','22384');

/*Table structure for table `migration` */

DROP TABLE IF EXISTS `migration`;

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `migration` */

insert  into `migration`(`version`,`apply_time`) values ('m000000_000000_base',1610075580),('m140506_102106_rbac_init',1610331854),('m151024_072453_create_route_table',1610332922),('m170907_052038_rbac_add_index_on_auth_assignment_user_id',1610331854),('m180523_151638_rbac_updates_indexes_without_prefix',1610331854),('m200409_110543_rbac_update_mssql_trigger',1610331854);

/*Table structure for table `province` */

DROP TABLE IF EXISTS `province`;

CREATE TABLE `province` (
  `province_id` int(11) NOT NULL,
  `province` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`province_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `province` */

insert  into `province`(`province_id`,`province`) values (1,'Bali'),(2,'Bangka Belitung'),(3,'Banten'),(4,'Bengkulu'),(5,'DI Yogyakarta'),(6,'DKI Jakarta'),(7,'Gorontalo'),(8,'Jambi'),(9,'Jawa Barat'),(10,'Jawa Tengah'),(11,'Jawa Timur'),(12,'Kalimantan Barat'),(13,'Kalimantan Selatan'),(14,'Kalimantan Tengah'),(15,'Kalimantan Timur'),(16,'Kalimantan Utara'),(17,'Kepulauan Riau'),(18,'Lampung'),(19,'Maluku'),(20,'Maluku Utara'),(21,'Nanggroe Aceh Darussalam (NAD)'),(22,'Nusa Tenggara Barat (NTB)'),(23,'Nusa Tenggara Timur (NTT)'),(24,'Papua'),(25,'Papua Barat'),(26,'Riau'),(27,'Sulawesi Barat'),(28,'Sulawesi Selatan'),(29,'Sulawesi Tengah'),(30,'Sulawesi Tenggara'),(31,'Sulawesi Utara'),(32,'Sumatera Barat'),(33,'Sumatera Selatan'),(34,'Sumatera Utara');

/*Table structure for table `route` */

DROP TABLE IF EXISTS `route`;

CREATE TABLE `route` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT 1,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `route` */

insert  into `route`(`name`,`alias`,`type`,`status`) values ('/*','*','',1),('/admin/*','*','admin',1),('/admin/book/*','*','admin/book',1),('/admin/book/create','create','admin/book',1),('/admin/book/delete','delete','admin/book',1),('/admin/book/index','index','admin/book',1),('/admin/book/update','update','admin/book',1),('/admin/book/view','view','admin/book',1),('/admin/default/*','*','admin/default',1),('/admin/default/index','index','admin/default',1),('/ajax/*','*','ajax',1),('/ajax/book','book','ajax',1),('/ajax/get-book','get-book','ajax',1),('/ajax/get-cities','get-cities','ajax',1),('/ajax/provinsi','provinsi','ajax',1),('/auth/*','*','auth',1),('/auth/create','create','auth',1),('/auth/delete','delete','auth',1),('/auth/delete-auth','delete-auth','auth',1),('/auth/index','index','auth',1),('/auth/process-auth','process-auth','auth',1),('/auth/update','update','auth',1),('/auth/view','view','auth',1),('/book/*','*','book',1),('/book/check','check','book',1),('/book/create','create','book',1),('/book/delete','delete','book',1),('/book/index','index','book',1),('/book/update','update','book',1),('/book/view','view','book',1),('/debug/*','*','debug',1),('/debug/default/*','*','debug/default',1),('/debug/default/db-explain','db-explain','debug/default',1),('/debug/default/download-mail','download-mail','debug/default',1),('/debug/default/index','index','debug/default',1),('/debug/default/toolbar','toolbar','debug/default',1),('/debug/default/view','view','debug/default',1),('/debug/user/*','*','debug/user',1),('/debug/user/reset-identity','reset-identity','debug/user',1),('/debug/user/set-identity','set-identity','debug/user',1),('/employee/*','*','employee',1),('/employee/create','create','employee',1),('/employee/delete','delete','employee',1),('/employee/index','index','employee',1),('/employee/sorting','sorting','employee',1),('/employee/update','update','employee',1),('/gii/*','*','gii',1),('/gii/default/*','*','gii/default',1),('/gii/default/action','action','gii/default',1),('/gii/default/diff','diff','gii/default',1),('/gii/default/index','index','gii/default',1),('/gii/default/preview','preview','gii/default',1),('/gii/default/view','view','gii/default',1),('/mimin/*','*','mimin',1),('/mimin/role/*','*','mimin/role',1),('/mimin/role/create','create','mimin/role',1),('/mimin/role/delete','delete','mimin/role',1),('/mimin/role/index','index','mimin/role',1),('/mimin/role/permission','permission','mimin/role',1),('/mimin/role/update','update','mimin/role',1),('/mimin/role/view','view','mimin/role',1),('/mimin/route/*','*','mimin/route',1),('/mimin/route/create','create','mimin/route',1),('/mimin/route/delete','delete','mimin/route',1),('/mimin/route/generate','generate','mimin/route',1),('/mimin/route/index','index','mimin/route',1),('/mimin/route/update','update','mimin/route',1),('/mimin/route/view','view','mimin/route',1),('/mimin/user/*','*','mimin/user',1),('/mimin/user/create','create','mimin/user',1),('/mimin/user/delete','delete','mimin/user',1),('/mimin/user/index','index','mimin/user',1),('/mimin/user/update','update','mimin/user',1),('/mimin/user/view','view','mimin/user',1),('/site/*','*','site',1),('/site/about','about','site',1),('/site/auth','auth','site',1),('/site/captcha','captcha','site',1),('/site/contact','contact','site',1),('/site/error','error','site',1),('/site/index','index','site',1),('/site/komentar','komentar','site',1),('/site/login','login','site',1),('/site/logout','logout','site',1),('/site/query','query','site',1),('/site/query2','query2','site',1),('/site/signup','signup','site',1),('/test/*','*','test',1),('/test/blog','blog','test',1),('/test/login','login','test',1);

/*Table structure for table `setting` */

DROP TABLE IF EXISTS `setting`;

CREATE TABLE `setting` (
  `nama_setting` varchar(100) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `setting` */

insert  into `setting`(`nama_setting`,`value`,`note`) values ('maintenance','no',NULL);

/*Table structure for table `student` */

DROP TABLE IF EXISTS `student`;

CREATE TABLE `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `code` varchar(15) NOT NULL,
  `gender` tinyint(1) NOT NULL DEFAULT 1,
  `age` int(3) DEFAULT NULL,
  `address` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `student` */

/*Table structure for table `survey_framework` */

DROP TABLE IF EXISTS `survey_framework`;

CREATE TABLE `survey_framework` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `framework_id` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_survey_framework` (`framework_id`),
  CONSTRAINT `FK_survey_framework` FOREIGN KEY (`framework_id`) REFERENCES `framework` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPRESSED;

/*Data for the table `survey_framework` */

insert  into `survey_framework`(`id`,`framework_id`,`year`,`total`) values (1,1,2014,90),(2,2,2014,66),(3,3,2014,45),(4,4,2014,88),(5,1,2015,77),(6,2,2015,45),(7,3,2015,87),(8,4,2015,66);

/*Table structure for table `tb_book` */

DROP TABLE IF EXISTS `tb_book`;

CREATE TABLE `tb_book` (
  `id_buku` int(11) NOT NULL AUTO_INCREMENT,
  `nama_buku` varchar(255) NOT NULL,
  `penerbit` varchar(255) NOT NULL,
  `tahun_terbit` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_buku`)
) ENGINE=InnoDB AUTO_INCREMENT=169 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_book` */

insert  into `tb_book`(`id_buku`,`nama_buku`,`penerbit`,`tahun_terbit`,`created_at`,`updated_at`) values (165,'cincin','aku',2020,'2021-01-12 10:06:45','2021-01-12 10:06:45'),(166,'naruto','tes2',2012,'2021-01-12 10:06:45','2021-01-13 11:17:04'),(167,'cincin','aku',2020,'2021-01-12 11:23:22','2021-01-12 11:23:22'),(168,'tes','tes2',2012,'2021-01-12 11:23:22','2021-01-12 11:23:22');

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT 10,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

/*Data for the table `user` */

insert  into `user`(`id`,`username`,`auth_key`,`password_hash`,`password_reset_token`,`email`,`status`,`created_at`,`updated_at`) values (5,'rohim98@gmail.com','fvLhtGt0DTsq6EJKqHUTKdXFmd9YkJvb','$2y$13$eJIgtvIYFcRLwfROlMeG3e6awqmU9scgedgzp2TEkZUdtBoCnMSQS','pOSOhPEHwZX27Ss5TpHLfrrsHgltxnNy_1610090418','rohim98@gmail.com',10,1610090418,1610337676),(7,'admin','111','$2y$13$WgTgwZdO0sXbsD8NobkD1uJd6Yj2iTqL6Fb3BS5Tq7gSw9Ews7kCK',NULL,'him@gmail.com',10,2147483647,2147483647),(8,'adm','EKkWtif6D-iin-zlLEbBK4Dq9gNeB2ZW','$2y$13$0T9yUN7fqeznmXqyqsgWXuEz1U6U1MrYdZQ/uw5VOffHtV2Z.ntH6',NULL,'ham@gmail.com',0,1610166460,1610337616),(9,'asshidqi05@gmail.com','gk0OgSurX9lli-njok3Qv9bxBzTWl29T','$2y$13$aQSi41xNT2kxU7HmAjtDHeEZzeMu0X/KJ2CsNXi8ZHYLhydw4TVv2','gOHtZzaQ04G-mfKhKwiXfoGoAJHRVx3J_1610187724','asshidqi05@gmail.com',10,1610187724,1610187724);

/*Table structure for table `user_photo` */

DROP TABLE IF EXISTS `user_photo`;

CREATE TABLE `user_photo` (
  `user_id` int(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `user_photo` */

insert  into `user_photo`(`user_id`,`photo`) values (7,'1610024.JPG');

/*Table structure for table `user_social_media` */

DROP TABLE IF EXISTS `user_social_media`;

CREATE TABLE `user_social_media` (
  `id` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `social_media` enum('facebook','google') DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_user_social_media` (`user_id`),
  CONSTRAINT `FK_user_social_media` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `user_social_media` */

insert  into `user_social_media`(`id`,`username`,`user_id`,`social_media`,`created_at`,`updated_at`) values ('102787581382683171083','rohim98@gmail.com',5,'google',NULL,NULL),('105040658946542965471','asshidqi05@gmail.com',9,'google',NULL,NULL),('3903063486412752','rohim98@gmail.com',5,'facebook',NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
