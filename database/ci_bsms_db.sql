/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.4.24-MariaDB : Database - ci_bsms_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`ci_bsms_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `ci_bsms_db`;

/*Table structure for table `bioskop` */

DROP TABLE IF EXISTS `bioskop`;

CREATE TABLE `bioskop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kd_bioskop` varchar(255) DEFAULT NULL,
  `nama_bioskop` varchar(255) DEFAULT NULL,
  `alamat_bioskop` varchar(255) DEFAULT NULL,
  `kota` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Data for the table `bioskop` */

insert  into `bioskop`(`id`,`kd_bioskop`,`nama_bioskop`,`alamat_bioskop`,`kota`) values 
(1,'MDL004','mandala','jalan andalas','malang'),
(2,'CXX002','cinema xxi','jalan dieng','malang'),
(3,'STS003','sutos','jalan pesanggrahan','malang');

/*Table structure for table `film` */

DROP TABLE IF EXISTS `film`;

CREATE TABLE `film` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `kd_film` varchar(20) DEFAULT NULL,
  `judul_film` varchar(255) DEFAULT NULL,
  `tgl_launch` datetime(6) DEFAULT NULL,
  `synopsys` text DEFAULT NULL,
  `price` int(25) DEFAULT NULL,
  `category_code` int(11) DEFAULT NULL,
  `film_img` varchar(255) DEFAULT NULL,
  `writer` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

/*Data for the table `film` */

insert  into `film`(`id`,`kd_film`,`judul_film`,`tgl_launch`,`synopsys`,`price`,`category_code`,`film_img`,`writer`) values 
(4,'RW001','Run Winner','2022-11-07 05:28:00.000000',NULL,50000,1,NULL,'Author'),
(5,'WY005','Aways','0000-00-00 00:00:00.000000',NULL,50000,3,NULL,'Author'),
(6,'KD003','Aku Suka Kamu Apa Adanya','2022-11-08 05:30:00.000000',NULL,4000000,1,NULL,'Author'),
(7,'HA004','Hai','2022-11-17 05:31:00.000000',NULL,4000000,1,NULL,'Author');

/*Table structure for table `film_category` */

DROP TABLE IF EXISTS `film_category`;

CREATE TABLE `film_category` (
  `category_code` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) NOT NULL,
  PRIMARY KEY (`category_code`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `film_category` */

insert  into `film_category`(`category_code`,`category_name`) values 
(1,'Educational'),
(2,'Fiction'),
(3,'Fantasy'),
(4,'Horror'),
(5,'Sample 101'),
(6,'Baru');

/*Table structure for table `tayang` */

DROP TABLE IF EXISTS `tayang`;

CREATE TABLE `tayang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kd_tayang` varchar(255) NOT NULL,
  `judul_film` varchar(255) DEFAULT NULL,
  `waktu_tayang` datetime(6) DEFAULT NULL,
  `jml_kursi` int(20) DEFAULT NULL,
  `film_id` int(20) DEFAULT NULL,
  `bioskop_id` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`,`kd_tayang`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tayang` */

insert  into `tayang`(`id`,`kd_tayang`,`judul_film`,`waktu_tayang`,`jml_kursi`,`film_id`,`bioskop_id`) values 
(1,'MDL071120220514RW00100001','Run Winner','2022-11-07 05:14:44.000000',44,4,1),
(2,'CXX071120220537KD00300002','Aku Suka Kamu Apa Adanya','2022-11-07 05:37:03.000000',49,6,1),
(3,'STS241120220622HA00400003','Hai','2022-11-24 06:22:58.000000',16,7,2),
(4,'CXX071120220620WY00200004','Away','2022-11-07 06:20:38.000000',3,5,2);

/*Table structure for table `transaction` */

DROP TABLE IF EXISTS `transaction`;

CREATE TABLE `transaction` (
  `transaction_code` int(11) NOT NULL AUTO_INCREMENT,
  `user_code` int(11) NOT NULL,
  `buyer_name` varchar(100) NOT NULL,
  `total` int(11) NOT NULL,
  `tgl` date NOT NULL,
  `judul_film` varchar(255) NOT NULL,
  `jml_kursi` int(11) NOT NULL,
  PRIMARY KEY (`transaction_code`),
  KEY `kode_user` (`user_code`),
  CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`user_code`) REFERENCES `user` (`user_code`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `transaction` */

insert  into `transaction`(`transaction_code`,`user_code`,`buyer_name`,`total`,`tgl`,`judul_film`,`jml_kursi`) values 
(1,1,'Customer 101',450,'2022-10-11','Sample Book 102',1),
(2,1,'vd',1750,'2022-11-04','Sample Book 101',5),
(3,1,'test',100000,'2022-11-07','Away',1),
(4,1,'vd',100000,'2022-11-07','Away',1),
(5,1,'d',100000,'2022-11-07','Away',1),
(6,2,'vd',100000,'2022-11-07','Away',1),
(7,2,'vd',100000,'2022-11-07','Away',1),
(8,2,'vd',100000,'2022-11-07','Away',1),
(9,2,'test',4050000,'2022-11-07','Aku Suka Kamu Apa Adanya',1),
(10,1,'test',16000000,'2022-11-07','Hai',4);

/*Table structure for table `transaction_detail` */

DROP TABLE IF EXISTS `transaction_detail`;

CREATE TABLE `transaction_detail` (
  `transaction_code` int(11) NOT NULL,
  `kd_tayang` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  KEY `kode_transaksi` (`transaction_code`),
  KEY `kode_tayang` (`kd_tayang`),
  CONSTRAINT `transaction_detail_ibfk_1` FOREIGN KEY (`transaction_code`) REFERENCES `transaction` (`transaction_code`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `transaction_detail_ibfk_2` FOREIGN KEY (`kd_tayang`) REFERENCES `tayang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `transaction_detail` */

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `user_code` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `level` varchar(100) NOT NULL,
  PRIMARY KEY (`user_code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `user` */

insert  into `user`(`user_code`,`fullname`,`username`,`password`,`level`) values 
(1,'Administrator','admin','21232f297a57a5a743894a0e4a801fc3','admin'),
(2,'kasir','kasir','c7911af3adbd12a035b289556d96470a','cashier');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
