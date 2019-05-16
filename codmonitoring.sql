/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.1.41 : Database - cod_monitoring
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`cod_monitoring` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `cod_monitoring`;

/*Table structure for table `auditlog` */

DROP TABLE IF EXISTS `auditlog`;

CREATE TABLE `auditlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action` varchar(25) DEFAULT NULL,
  `rec_id` int(11) DEFAULT NULL,
  `maker` varchar(15) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `auditlog` */

insert  into `auditlog`(`id`,`action`,`rec_id`,`maker`,`date_created`) values (1,'REMOVE',2,'16','2019-03-21 03:31:50');

/*Table structure for table `cod_payment_details` */

DROP TABLE IF EXISTS `cod_payment_details`;

CREATE TABLE `cod_payment_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod_no` int(11) DEFAULT NULL,
  `tran_no` int(11) DEFAULT NULL,
  `payment_amount` float(10,2) DEFAULT NULL,
  `date_payment` datetime DEFAULT NULL,
  `date_last_update` datetime DEFAULT NULL,
  `maker` varchar(15) DEFAULT NULL,
  `reference_id` varchar(10) DEFAULT NULL,
  `reference_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `cod_payment_details` */

insert  into `cod_payment_details`(`id`,`cod_no`,`tran_no`,`payment_amount`,`date_payment`,`date_last_update`,`maker`,`reference_id`,`reference_date`) values (7,1,224595,781.00,'2019-01-11 08:27:57','2019-04-16 03:54:30','9','cd-1234','2019-01-16'),(8,3,224931,12.00,'2019-01-16 05:15:05','2019-04-16 03:55:28','9','daw231','2019-01-16'),(9,5,245452,1325.00,'2019-04-15 05:49:37',NULL,'seph','P1231','2019-04-15');

/*Table structure for table `cod_transactions` */

DROP TABLE IF EXISTS `cod_transactions`;

CREATE TABLE `cod_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TRAN_NO` int(11) DEFAULT NULL,
  `CUSTOMER_NAME` varchar(100) DEFAULT NULL,
  `TRAN_DATE` datetime DEFAULT NULL,
  `ADDRESS` varchar(200) DEFAULT NULL,
  `DOC_NO` varchar(20) DEFAULT NULL,
  `AMOUNT_TOTAL` float(10,2) DEFAULT NULL,
  `PERCENT_LESS_1` int(11) DEFAULT NULL,
  `PERCENT_LESS_2` int(11) DEFAULT NULL,
  `PERCENT_LESS_3` int(11) DEFAULT NULL,
  `AMOUNT_PERCENT_LESS` float(10,2) DEFAULT NULL,
  `AMOUNT_ADJ_LESS` float(10,2) DEFAULT NULL,
  `DESC_LESS_1` varchar(25) DEFAULT NULL,
  `DESC_LESS_2` varchar(25) DEFAULT NULL,
  `DESC_LESS_3` varchar(25) DEFAULT NULL,
  `AMOUNT_LESS_1` float(10,2) DEFAULT NULL,
  `AMOUNT_LESS_2` float(10,2) DEFAULT NULL,
  `AMOUNT_LESS_3` float(10,2) DEFAULT NULL,
  `DESC_ADDTL` varchar(50) DEFAULT NULL,
  `AMOUNT_ADDTL` float(10,2) DEFAULT NULL,
  `IS_TAX_INCLUSIVE` varchar(5) DEFAULT NULL,
  `PERCENT_TAX` int(11) DEFAULT NULL,
  `AMOUNT_TAX` float(10,2) DEFAULT NULL,
  `AMOUNT_NET` float(10,2) DEFAULT NULL,
  `IS_PAID` varchar(5) DEFAULT NULL,
  `DATE_ENTRY` datetime DEFAULT NULL,
  `DATE_LAST_UPDATE` datetime DEFAULT NULL,
  `maker` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `TRAN_NO` (`TRAN_NO`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `cod_transactions` */

insert  into `cod_transactions`(`id`,`TRAN_NO`,`CUSTOMER_NAME`,`TRAN_DATE`,`ADDRESS`,`DOC_NO`,`AMOUNT_TOTAL`,`PERCENT_LESS_1`,`PERCENT_LESS_2`,`PERCENT_LESS_3`,`AMOUNT_PERCENT_LESS`,`AMOUNT_ADJ_LESS`,`DESC_LESS_1`,`DESC_LESS_2`,`DESC_LESS_3`,`AMOUNT_LESS_1`,`AMOUNT_LESS_2`,`AMOUNT_LESS_3`,`DESC_ADDTL`,`AMOUNT_ADDTL`,`IS_TAX_INCLUSIVE`,`PERCENT_TAX`,`AMOUNT_TAX`,`AMOUNT_NET`,`IS_PAID`,`DATE_ENTRY`,`DATE_LAST_UPDATE`,`maker`) values (1,224595,'ANA B. BERCUSIO','2019-01-09 00:00:00','MDC-102 CALAMBA PABALAN','01067',977.50,20,0,0,195.50,0.00,NULL,NULL,NULL,0.00,0.00,0.00,NULL,0.00,'Y',0,0.00,782.00,'Y','2019-01-09 05:00:02',NULL,'16'),(3,224931,'FINAL CUT SALON - SANJOSE MINDORO','2019-01-10 00:00:00','SAVEMORE DEPT STORE, LIBORO ST. BRGY 5','P4388',0.00,0,0,0,0.00,0.00,NULL,NULL,NULL,0.00,0.00,0.00,NULL,5987.88,'Y',12,641.56,5987.88,'Y','2019-01-11 08:07:13',NULL,'9'),(4,10,'DRA.CRISTINA CONE','2012-12-11 00:00:00','1ST FLR. RM.122 NEW WING MAKATI MEDICALCENTER., MAKATI CITY.LOOK FOR MAM.LOURDES.(SEC.)','76298',8800.00,20,0,0,1760.00,0.00,NULL,NULL,NULL,0.00,0.00,0.00,NULL,0.00,'Y',0,0.00,7040.00,'N','2019-03-09 07:15:16',NULL,'9'),(5,245452,'KATRINE KAW','2019-04-15 00:00:00','29 SACRED HEART ST. HORSESHOE, HORSESHOE, QUEZON CITY   CP#: 09175355063','P6831',1325.00,0,0,0,0.00,0.00,NULL,NULL,NULL,0.00,0.00,0.00,NULL,0.00,'Y',12,141.96,1325.00,'Y','2019-04-15 05:20:11',NULL,'seph');

/*Table structure for table `tblusers` */

DROP TABLE IF EXISTS `tblusers`;

CREATE TABLE `tblusers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Firstname` varchar(25) DEFAULT NULL,
  `Middlename` varchar(25) DEFAULT NULL,
  `Lastname` varchar(25) DEFAULT NULL,
  `Contact` varchar(12) DEFAULT NULL,
  `Birthdate` date DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_last_modified` datetime DEFAULT NULL,
  `token` varchar(60) DEFAULT NULL,
  `is_active` varchar(2) DEFAULT NULL,
  `date_last_login` datetime DEFAULT NULL,
  `user_type` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

/*Data for the table `tblusers` */

insert  into `tblusers`(`id`,`Firstname`,`Middlename`,`Lastname`,`Contact`,`Birthdate`,`email`,`username`,`password`,`date_created`,`date_last_modified`,`token`,`is_active`,`date_last_login`,`user_type`) values (9,'JOSEPH','PLANTA','CRUZ','0303030303','2018-12-19','jccruz@exxelprime.com','Jccruz','$2y$10$UeAeXgU9su96gTAqr..IeO/lTyOoR1BxPIIJkRlMg71TKkTEBE.5S','2018-12-19 07:20:51','2018-12-26 05:09:36','tgwf5DcEq76gS4GLTZqqxBqEIGcekkX0cvf4MNLa','N','2019-04-15 03:12:44',0),(10,'GERRY',NULL,'CONRADO','45434354354','2018-12-20','gmconrado@gmail.com','Gconrado','$2y$10$LsEtBkfaAGtqWSBUFm1wg.r6GvaCNo.jkzSbIJxUyXHZ7gNS3uc6y','2018-12-19 07:38:35','2019-01-03 03:52:51','tgwf5DcEq76gS4GLTZqqxBqEIGcekkX0cvf4MNLa','N','2019-01-03 03:53:16',2),(18,'JOY','T','CAMPENA','00000000000','2019-04-08','huihiu@yahoo.com','joy','$2y$10$hLV.mr0vKMYVMEQGhSGS.etee7hXvugmrtRCgZAU0ZzjP1kp8Eiyq','2019-01-08 06:00:14',NULL,'4gLJ3lGxufFEtXQ9SA7rOnTZSU4zh7r3CAFNeDYD','Y','2019-01-08 06:00:34',2),(16,'RENSES',NULL,'SABADO','00000000000','2019-01-03','Renses@test.com','RENSES','$2y$10$dWdyCSSwu1qunI5jkf199u4JkSGAV9FmuT0Pn2MBh/wxtyH8.Uxc2','2019-01-03 00:17:27','2019-01-03 03:51:54','7pLn3wVN2JBBPLvn3HHtKT476DfzynMsFcubXS3T','Y','2019-03-21 03:14:26',3),(19,'TINA',NULL,'ISIP','00000000000','2019-01-09','tina@test.com','TINA','$2y$10$FSjjzKPgFSABQQ0NMP0mveciZRu4DQNOL9Zyu0YRclL2FdC.Be4FC','2019-01-09 00:19:33',NULL,'F1KqanFuMtCQJ4cPQYoarXA56Ukqna0pPhL6OTmM','N','2019-01-09 00:38:17',2);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
