/*
SQLyog Enterprise - MySQL GUI v8.02 RC
MySQL - 5.6.17 : Database - audit
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`audit` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `audit`;

/*Table structure for table `tbl_admin` */

DROP TABLE IF EXISTS `tbl_admin`;

CREATE TABLE `tbl_admin` (
  `admin_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Admin Id',
  `admin_first_name` varchar(60) NOT NULL,
  `admin_last_name` varchar(60) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `admin_status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `admin_last_login` datetime NOT NULL,
  `admin_createdate` datetime NOT NULL,
  `admin_updatedate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `admin_email` (`admin_email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_admin` */

insert  into `tbl_admin`(`admin_id`,`admin_first_name`,`admin_last_name`,`admin_email`,`admin_password`,`admin_status`,`admin_last_login`,`admin_createdate`,`admin_updatedate`) values (4,'admin','admin','admin@admin.com','admin123','ACTIVE','2015-07-07 12:20:20','2015-07-07 12:20:20','2015-07-13 18:52:29');

/*Table structure for table `tbl_client_template` */

DROP TABLE IF EXISTS `tbl_client_template`;

CREATE TABLE `tbl_client_template` (
  `ctp_id` int(11) NOT NULL AUTO_INCREMENT,
  `ctp_clt_id` int(11) NOT NULL,
  `ctp_tpl_id` int(11) NOT NULL,
  `ctp_next_schedule` date DEFAULT NULL,
  `ctp_createdate` datetime NOT NULL,
  `ctp_updatedate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ctp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_client_template` */

insert  into `tbl_client_template`(`ctp_id`,`ctp_clt_id`,`ctp_tpl_id`,`ctp_next_schedule`,`ctp_createdate`,`ctp_updatedate`) values (25,1,2,NULL,'2015-07-24 09:29:07','2015-07-24 14:59:07');
insert  into `tbl_client_template`(`ctp_id`,`ctp_clt_id`,`ctp_tpl_id`,`ctp_next_schedule`,`ctp_createdate`,`ctp_updatedate`) values (26,1,9,'2015-07-25','2015-07-24 09:30:04','2015-07-24 15:00:04');

/*Table structure for table `tbl_client_template_fields` */

DROP TABLE IF EXISTS `tbl_client_template_fields`;

CREATE TABLE `tbl_client_template_fields` (
  `ctf_if` int(11) NOT NULL AUTO_INCREMENT,
  `ctf_ctp_id` int(11) NOT NULL,
  `ctf_fld_id` int(11) NOT NULL,
  `ctf_fld_value` text,
  `ctf_createdate` datetime NOT NULL,
  `ctf_updatedate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ctf_if`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_client_template_fields` */

insert  into `tbl_client_template_fields`(`ctf_if`,`ctf_ctp_id`,`ctf_fld_id`,`ctf_fld_value`,`ctf_createdate`,`ctf_updatedate`) values (1,25,33,'ds','2015-07-24 09:29:07','2015-07-24 14:59:07');
insert  into `tbl_client_template_fields`(`ctf_if`,`ctf_ctp_id`,`ctf_fld_id`,`ctf_fld_value`,`ctf_createdate`,`ctf_updatedate`) values (2,25,34,'admin@adminc.om','2015-07-24 09:29:07','2015-07-24 14:59:07');
insert  into `tbl_client_template_fields`(`ctf_if`,`ctf_ctp_id`,`ctf_fld_id`,`ctf_fld_value`,`ctf_createdate`,`ctf_updatedate`) values (3,25,35,'10k','2015-07-24 09:29:07','2015-07-24 14:59:07');
insert  into `tbl_client_template_fields`(`ctf_if`,`ctf_ctp_id`,`ctf_fld_id`,`ctf_fld_value`,`ctf_createdate`,`ctf_updatedate`) values (4,25,36,'Male','2015-07-24 09:29:07','2015-07-24 14:59:07');
insert  into `tbl_client_template_fields`(`ctf_if`,`ctf_ctp_id`,`ctf_fld_id`,`ctf_fld_value`,`ctf_createdate`,`ctf_updatedate`) values (5,25,37,'Ahmedabad','2015-07-24 09:29:07','2015-07-24 14:59:07');
insert  into `tbl_client_template_fields`(`ctf_if`,`ctf_ctp_id`,`ctf_fld_id`,`ctf_fld_value`,`ctf_createdate`,`ctf_updatedate`) values (6,26,61,'dsa','2015-07-24 09:30:04','2015-07-24 15:00:04');
insert  into `tbl_client_template_fields`(`ctf_if`,`ctf_ctp_id`,`ctf_fld_id`,`ctf_fld_value`,`ctf_createdate`,`ctf_updatedate`) values (7,26,62,'dsa','2015-07-24 09:30:04','2015-07-24 15:00:04');
insert  into `tbl_client_template_fields`(`ctf_if`,`ctf_ctp_id`,`ctf_fld_id`,`ctf_fld_value`,`ctf_createdate`,`ctf_updatedate`) values (8,26,63,'male','2015-07-24 09:30:04','2015-07-24 15:00:04');
insert  into `tbl_client_template_fields`(`ctf_if`,`ctf_ctp_id`,`ctf_fld_id`,`ctf_fld_value`,`ctf_createdate`,`ctf_updatedate`) values (9,26,64,'fgh','2015-07-24 09:30:04','2015-07-24 15:00:04');
insert  into `tbl_client_template_fields`(`ctf_if`,`ctf_ctp_id`,`ctf_fld_id`,`ctf_fld_value`,`ctf_createdate`,`ctf_updatedate`) values (10,26,65,'fghfhg','2015-07-24 09:30:04','2015-07-24 15:00:04');

/*Table structure for table `tbl_clients` */

DROP TABLE IF EXISTS `tbl_clients`;

CREATE TABLE `tbl_clients` (
  `clt_id` int(11) NOT NULL AUTO_INCREMENT,
  `clt_name` varchar(50) NOT NULL,
  `clt_address` varchar(100) NOT NULL,
  `clt_designation` varchar(25) NOT NULL,
  `clt_timing` varchar(30) NOT NULL,
  `clt_owner` varchar(50) NOT NULL,
  `clt_administrator` varchar(15) DEFAULT NULL,
  `clt_phone` varchar(15) NOT NULL,
  `clt_mobile` varchar(15) NOT NULL,
  `clt_email` varchar(25) DEFAULT NULL,
  `clt_fax` varchar(15) DEFAULT NULL,
  `clt_web` varchar(50) DEFAULT NULL,
  `clt_country` varchar(10) DEFAULT NULL,
  `clt_state` varchar(10) DEFAULT NULL,
  `clt_city` varchar(15) DEFAULT NULL,
  `clt_status` enum('ACTIVE','INACTIVE') DEFAULT 'ACTIVE',
  `clt_createdate` datetime NOT NULL,
  `clt_updatedate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`clt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_clients` */

insert  into `tbl_clients`(`clt_id`,`clt_name`,`clt_address`,`clt_designation`,`clt_timing`,`clt_owner`,`clt_administrator`,`clt_phone`,`clt_mobile`,`clt_email`,`clt_fax`,`clt_web`,`clt_country`,`clt_state`,`clt_city`,`clt_status`,`clt_createdate`,`clt_updatedate`) values (1,'Rainbow Hospital','Swami Shivanand Soc.','Consultant','Morning 10 to 1','Dr. Hitesh Bhatt','self','022-123465798','23546789','dsad@sd.com','545454','http://asdasd.com','1','2','45465','ACTIVE','2015-07-20 12:10:26','2015-07-20 17:40:26');
insert  into `tbl_clients`(`clt_id`,`clt_name`,`clt_address`,`clt_designation`,`clt_timing`,`clt_owner`,`clt_administrator`,`clt_phone`,`clt_mobile`,`clt_email`,`clt_fax`,`clt_web`,`clt_country`,`clt_state`,`clt_city`,`clt_status`,`clt_createdate`,`clt_updatedate`) values (2,'df','fds','fds','fds','fds','','fds','fsdfds','dfds@asd.com','','','1','2','432432432','ACTIVE','2015-07-22 09:43:22','2015-07-22 15:13:22');

/*Table structure for table `tbl_clt_insurance` */

DROP TABLE IF EXISTS `tbl_clt_insurance`;

CREATE TABLE `tbl_clt_insurance` (
  `ins_id` int(11) NOT NULL AUTO_INCREMENT,
  `ins_clt_id` int(11) DEFAULT NULL,
  `ins_ins_id` varchar(50) NOT NULL,
  `ins_number` varchar(20) NOT NULL,
  `ins_company` varchar(50) NOT NULL,
  `ins_agent` varchar(50) DEFAULT NULL,
  `ins_contact_person` varchar(50) DEFAULT NULL,
  `ins_contact_no` varchar(15) DEFAULT NULL,
  `ins_valid_up_to` date NOT NULL,
  `ins_remark` varchar(200) DEFAULT NULL,
  `ins_createdate` datetime DEFAULT NULL,
  `ins_updatedate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ins_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_clt_insurance` */

insert  into `tbl_clt_insurance`(`ins_id`,`ins_clt_id`,`ins_ins_id`,`ins_number`,`ins_company`,`ins_agent`,`ins_contact_person`,`ins_contact_no`,`ins_valid_up_to`,`ins_remark`,`ins_createdate`,`ins_updatedate`) values (17,1,'1','dsa','dsa','dsa','dsa','dsa','2015-07-20','dsadsa dsadsadasd','2015-07-21 07:21:50','2015-07-21 19:59:57');

/*Table structure for table `tbl_clt_license` */

DROP TABLE IF EXISTS `tbl_clt_license`;

CREATE TABLE `tbl_clt_license` (
  `lic_id` int(11) NOT NULL AUTO_INCREMENT,
  `lic_clt_id` int(11) DEFAULT NULL,
  `lic_lic_id` int(11) NOT NULL,
  `lic_number` varchar(20) NOT NULL,
  `lic_issue_authority` varchar(50) NOT NULL,
  `lic_agent` varchar(50) DEFAULT NULL,
  `lic_contact_person` varchar(50) DEFAULT NULL,
  `lic_contact_no` varchar(15) DEFAULT NULL,
  `lic_valid_up_to` date NOT NULL,
  `lic_remark` varchar(200) DEFAULT NULL,
  `lic_createdate` datetime DEFAULT NULL,
  `lic_updatedate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`lic_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_clt_license` */

insert  into `tbl_clt_license`(`lic_id`,`lic_clt_id`,`lic_lic_id`,`lic_number`,`lic_issue_authority`,`lic_agent`,`lic_contact_person`,`lic_contact_no`,`lic_valid_up_to`,`lic_remark`,`lic_createdate`,`lic_updatedate`) values (8,1,2,'aaa','bbb','ccc','ddd','eee','2015-07-20','fffddd','2015-07-20 03:54:26','2015-07-21 19:34:14');
insert  into `tbl_clt_license`(`lic_id`,`lic_clt_id`,`lic_lic_id`,`lic_number`,`lic_issue_authority`,`lic_agent`,`lic_contact_person`,`lic_contact_no`,`lic_valid_up_to`,`lic_remark`,`lic_createdate`,`lic_updatedate`) values (9,1,3,'aaa','bbb','ccc','ddd','eee','2015-07-21','fffddd','2015-07-20 03:54:32','2015-07-21 19:34:17');
insert  into `tbl_clt_license`(`lic_id`,`lic_clt_id`,`lic_lic_id`,`lic_number`,`lic_issue_authority`,`lic_agent`,`lic_contact_person`,`lic_contact_no`,`lic_valid_up_to`,`lic_remark`,`lic_createdate`,`lic_updatedate`) values (10,2,2,'dsa','sad','dsa','dsa','dsadsa','2015-07-23','dsadas','2015-07-22 09:43:41','2015-07-22 15:13:41');

/*Table structure for table `tbl_country` */

DROP TABLE IF EXISTS `tbl_country`;

CREATE TABLE `tbl_country` (
  `cnt_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `cnt_code` varchar(20) NOT NULL DEFAULT '',
  `cnt_name` varchar(20) NOT NULL DEFAULT '',
  `cnt_createdate` datetime NOT NULL,
  `cnt_updatedate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cnt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_country` */

insert  into `tbl_country`(`cnt_id`,`cnt_code`,`cnt_name`,`cnt_createdate`,`cnt_updatedate`) values (1,'US','USA','2015-07-20 14:19:18','2015-07-20 14:19:18');
insert  into `tbl_country`(`cnt_id`,`cnt_code`,`cnt_name`,`cnt_createdate`,`cnt_updatedate`) values (2,'CA','Canada','2015-07-20 14:19:25','2015-07-20 14:19:25');

/*Table structure for table `tbl_insurance` */

DROP TABLE IF EXISTS `tbl_insurance`;

CREATE TABLE `tbl_insurance` (
  `ins_id` int(11) NOT NULL AUTO_INCREMENT,
  `ins_name` varchar(50) NOT NULL,
  `ins_createdate` datetime NOT NULL,
  `ins_updatedate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ins_id`,`ins_name`,`ins_createdate`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_insurance` */

insert  into `tbl_insurance`(`ins_id`,`ins_name`,`ins_createdate`,`ins_updatedate`) values (1,'INDEMNITY','2015-07-21 11:42:20','2015-07-21 11:42:20');

/*Table structure for table `tbl_license` */

DROP TABLE IF EXISTS `tbl_license`;

CREATE TABLE `tbl_license` (
  `lic_id` int(11) NOT NULL AUTO_INCREMENT,
  `lic_name` varchar(40) NOT NULL,
  `lic_createdate` datetime NOT NULL,
  `lic_updatedate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`lic_id`,`lic_name`,`lic_createdate`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_license` */

insert  into `tbl_license`(`lic_id`,`lic_name`,`lic_createdate`,`lic_updatedate`) values (1,'Nursing Home','2015-07-21 10:54:35','2015-07-21 10:54:35');
insert  into `tbl_license`(`lic_id`,`lic_name`,`lic_createdate`,`lic_updatedate`) values (2,'Biomedical Waste','2015-07-21 10:54:41','2015-07-21 10:54:41');
insert  into `tbl_license`(`lic_id`,`lic_name`,`lic_createdate`,`lic_updatedate`) values (3,'PNDT','2015-07-21 10:54:44','2015-07-21 10:54:44');

/*Table structure for table `tbl_state` */

DROP TABLE IF EXISTS `tbl_state`;

CREATE TABLE `tbl_state` (
  `sta_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `sta_cnt_id` tinyint(4) NOT NULL,
  `sta_name` varchar(40) NOT NULL,
  `sta_createdate` datetime NOT NULL,
  `sta_updatedate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`sta_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_state` */

insert  into `tbl_state`(`sta_id`,`sta_cnt_id`,`sta_name`,`sta_createdate`,`sta_updatedate`) values (1,1,'New York','2015-07-20 14:19:41','2015-07-20 14:19:41');
insert  into `tbl_state`(`sta_id`,`sta_cnt_id`,`sta_name`,`sta_createdate`,`sta_updatedate`) values (2,1,'Los Angeles','2015-07-20 14:19:50','2015-07-20 14:19:50');
insert  into `tbl_state`(`sta_id`,`sta_cnt_id`,`sta_name`,`sta_createdate`,`sta_updatedate`) values (3,2,'British Columbia','2015-07-20 14:19:58','2015-07-20 14:19:58');
insert  into `tbl_state`(`sta_id`,`sta_cnt_id`,`sta_name`,`sta_createdate`,`sta_updatedate`) values (4,2,'Torentu','2015-07-20 14:20:05','2015-07-20 14:20:05');

/*Table structure for table `tbl_template` */

DROP TABLE IF EXISTS `tbl_template`;

CREATE TABLE `tbl_template` (
  `template_id` int(11) NOT NULL AUTO_INCREMENT,
  `template_name` varchar(50) NOT NULL,
  `template_create_date` datetime NOT NULL,
  PRIMARY KEY (`template_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_template` */

insert  into `tbl_template`(`template_id`,`template_name`,`template_create_date`) values (2,'Registration','2015-07-14 08:52:10');
insert  into `tbl_template`(`template_id`,`template_name`,`template_create_date`) values (8,'Contact Us','2015-07-14 11:25:29');
insert  into `tbl_template`(`template_id`,`template_name`,`template_create_date`) values (9,'Login','2015-07-16 02:14:21');
insert  into `tbl_template`(`template_id`,`template_name`,`template_create_date`) values (11,'Hello','2015-07-17 12:41:55');
insert  into `tbl_template`(`template_id`,`template_name`,`template_create_date`) values (12,'Demo','2015-07-27 09:29:56');
insert  into `tbl_template`(`template_id`,`template_name`,`template_create_date`) values (13,'Central Registered','2015-07-30 07:39:05');
insert  into `tbl_template`(`template_id`,`template_name`,`template_create_date`) values (14,'INSPECTION ','2015-07-30 09:01:44');
insert  into `tbl_template`(`template_id`,`template_name`,`template_create_date`) values (15,'Questionnaire','2015-07-30 09:07:41');

/*Table structure for table `tbl_template_field` */

DROP TABLE IF EXISTS `tbl_template_field`;

CREATE TABLE `tbl_template_field` (
  `fld_id` int(11) NOT NULL AUTO_INCREMENT,
  `tmp_id` int(11) NOT NULL,
  `fld_type` varchar(100) NOT NULL,
  `fld_title` varchar(255) NOT NULL,
  `fld_required` varchar(50) DEFAULT NULL,
  `fld_options` varchar(255) DEFAULT NULL,
  `fld_weightage` float DEFAULT NULL,
  PRIMARY KEY (`fld_id`)
) ENGINE=InnoDB AUTO_INCREMENT=140 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_template_field` */

insert  into `tbl_template_field`(`fld_id`,`tmp_id`,`fld_type`,`fld_title`,`fld_required`,`fld_options`,`fld_weightage`) values (50,11,'checkbox','ghjj','false','a:2:{i:0;s:3:\"jgj\";i:1;s:6:\"ghjjgh\";}',NULL);
insert  into `tbl_template_field`(`fld_id`,`tmp_id`,`fld_type`,`fld_title`,`fld_required`,`fld_options`,`fld_weightage`) values (61,9,'text','Email','true','',0);
insert  into `tbl_template_field`(`fld_id`,`tmp_id`,`fld_type`,`fld_title`,`fld_required`,`fld_options`,`fld_weightage`) values (62,9,'password','Password','true','',0);
insert  into `tbl_template_field`(`fld_id`,`tmp_id`,`fld_type`,`fld_title`,`fld_required`,`fld_options`,`fld_weightage`) values (63,9,'checkbox','Gender ?','false','a:2:{i:0;s:4:\"male\";i:1;s:6:\"female\";}',0);
insert  into `tbl_template_field`(`fld_id`,`tmp_id`,`fld_type`,`fld_title`,`fld_required`,`fld_options`,`fld_weightage`) values (64,9,'radio','ggg','false','a:2:{i:0;s:3:\"fgh\";i:1;s:6:\"fghgfh\";}',0);
insert  into `tbl_template_field`(`fld_id`,`tmp_id`,`fld_type`,`fld_title`,`fld_required`,`fld_options`,`fld_weightage`) values (65,9,'select','hghfgh','false','a:1:{i:0;s:6:\"fghfhg\";}',0);
insert  into `tbl_template_field`(`fld_id`,`tmp_id`,`fld_type`,`fld_title`,`fld_required`,`fld_options`,`fld_weightage`) values (86,2,'text','gfgh','false','',10.2);
insert  into `tbl_template_field`(`fld_id`,`tmp_id`,`fld_type`,`fld_title`,`fld_required`,`fld_options`,`fld_weightage`) values (91,12,'text','hello','false','',10);
insert  into `tbl_template_field`(`fld_id`,`tmp_id`,`fld_type`,`fld_title`,`fld_required`,`fld_options`,`fld_weightage`) values (92,12,'text','whats up?','false','',5);
insert  into `tbl_template_field`(`fld_id`,`tmp_id`,`fld_type`,`fld_title`,`fld_required`,`fld_options`,`fld_weightage`) values (93,12,'label_text','fghfh','false','',54);
insert  into `tbl_template_field`(`fld_id`,`tmp_id`,`fld_type`,`fld_title`,`fld_required`,`fld_options`,`fld_weightage`) values (113,13,'form_name','Details of Centre Registered under PC-PNDT Act','false','',1);
insert  into `tbl_template_field`(`fld_id`,`tmp_id`,`fld_type`,`fld_title`,`fld_required`,`fld_options`,`fld_weightage`) values (114,13,'text','Name of the applicant','false','',2);
insert  into `tbl_template_field`(`fld_id`,`tmp_id`,`fld_type`,`fld_title`,`fld_required`,`fld_options`,`fld_weightage`) values (115,13,'text','Address of the applicant','false','',3);
insert  into `tbl_template_field`(`fld_id`,`tmp_id`,`fld_type`,`fld_title`,`fld_required`,`fld_options`,`fld_weightage`) values (116,13,'text','Type of facility registered','false','',4);
insert  into `tbl_template_field`(`fld_id`,`tmp_id`,`fld_type`,`fld_title`,`fld_required`,`fld_options`,`fld_weightage`) values (117,13,'text','Type of ownership of organization ','false','',5);
insert  into `tbl_template_field`(`fld_id`,`tmp_id`,`fld_type`,`fld_title`,`fld_required`,`fld_options`,`fld_weightage`) values (129,14,'form_name','FORMAT FOR INSPECTION UNDER PC-PNDT ACT','false','',1);
insert  into `tbl_template_field`(`fld_id`,`tmp_id`,`fld_type`,`fld_title`,`fld_required`,`fld_options`,`fld_weightage`) values (130,14,'text','Inspection by-Name ','false','',2);
insert  into `tbl_template_field`(`fld_id`,`tmp_id`,`fld_type`,`fld_title`,`fld_required`,`fld_options`,`fld_weightage`) values (131,14,'text','Designation ','false','',3);
insert  into `tbl_template_field`(`fld_id`,`tmp_id`,`fld_type`,`fld_title`,`fld_required`,`fld_options`,`fld_weightage`) values (132,14,'text','Date and Time of inspection','false','',4);
insert  into `tbl_template_field`(`fld_id`,`tmp_id`,`fld_type`,`fld_title`,`fld_required`,`fld_options`,`fld_weightage`) values (133,14,'text','Ward','false','',5);
insert  into `tbl_template_field`(`fld_id`,`tmp_id`,`fld_type`,`fld_title`,`fld_required`,`fld_options`,`fld_weightage`) values (134,14,'radio','Display of Notice board in Local language and English – at Conspicuous place','false','a:2:{i:0;s:3:\"Yes\";i:1;s:2:\"No\";}',6);
insert  into `tbl_template_field`(`fld_id`,`tmp_id`,`fld_type`,`fld_title`,`fld_required`,`fld_options`,`fld_weightage`) values (135,14,'radio','Original Certificate of Registration - displayed at conspicuous place','false','a:2:{i:0;s:3:\"Yes\";i:1;s:2:\"No\";}',7);
insert  into `tbl_template_field`(`fld_id`,`tmp_id`,`fld_type`,`fld_title`,`fld_required`,`fld_options`,`fld_weightage`) values (136,15,'form_name','Questionnaire for the management','false','',1);
insert  into `tbl_template_field`(`fld_id`,`tmp_id`,`fld_type`,`fld_title`,`fld_required`,`fld_options`,`fld_weightage`) values (137,15,'text','Who is the A.A. in Ahmedabad?','false','',2);
insert  into `tbl_template_field`(`fld_id`,`tmp_id`,`fld_type`,`fld_title`,`fld_required`,`fld_options`,`fld_weightage`) values (138,15,'text','Do you know who the members are of State advisory Board?','false','',3);
insert  into `tbl_template_field`(`fld_id`,`tmp_id`,`fld_type`,`fld_title`,`fld_required`,`fld_options`,`fld_weightage`) values (139,15,'text','Who are the members of State commission?','false','',4);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
