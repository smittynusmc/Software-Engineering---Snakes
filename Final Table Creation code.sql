-- --------------------------------------------------------
-- Host:                         elvis.rowan.edu
-- Server version:               5.7.15 - MySQL Community Server (GPL)
-- Server OS:                    Linux
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for boe_project
DROP DATABASE IF EXISTS `boe_project`;
CREATE DATABASE IF NOT EXISTS `boe_project` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `boe_project`;

-- Dumping structure for table boe_project.capability
DROP TABLE IF EXISTS `capability`;
CREATE TABLE IF NOT EXISTS `capability` (
  `capability_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `capability_name` varchar(75) NOT NULL,
  PRIMARY KEY (`capability_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table boe_project.cpcr
DROP TABLE IF EXISTS `cpcr`;
CREATE TABLE IF NOT EXISTS `cpcr` (
  `cpcr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `obs_id` int(10) unsigned NOT NULL,
  `cpcr_status` varchar(1) NOT NULL,
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cpcr_id`),
  KEY `FK_cpcr_obs` (`obs_id`),
  CONSTRAINT `FK_cpcr_obs` FOREIGN KEY (`obs_id`) REFERENCES `obs` (`obs_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1439 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Data exporting was unselected.
-- Dumping structure for table boe_project.cpcr_capability
DROP TABLE IF EXISTS `cpcr_capability`;
CREATE TABLE IF NOT EXISTS `cpcr_capability` (
  `cpcr_capability_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cpcr_id` int(10) unsigned NOT NULL DEFAULT '0',
  `capability_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cpcr_capability_id`),
  KEY `FK_cpcr_capability_cpcr` (`cpcr_id`),
  KEY `FK_cpcr_capability_capability` (`capability_id`),
  CONSTRAINT `FK_cpcr_capability_capability` FOREIGN KEY (`capability_id`) REFERENCES `capability` (`capability_id`),
  CONSTRAINT `FK_cpcr_capability_cpcr` FOREIGN KEY (`cpcr_id`) REFERENCES `cpcr` (`cpcr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table boe_project.cpcr_sprint
DROP TABLE IF EXISTS `cpcr_sprint`;
CREATE TABLE IF NOT EXISTS `cpcr_sprint` (
  `cpcr_sprint_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sprint_id` int(10) unsigned NOT NULL DEFAULT '0',
  `cpcr_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cpcr_sprint_id`),
  KEY `FK_cpcr_sprint_sprint` (`sprint_id`),
  KEY `FK_cpcr_sprint_cpcr` (`cpcr_id`),
  CONSTRAINT `FK_cpcr_sprint_cpcr` FOREIGN KEY (`cpcr_id`) REFERENCES `cpcr` (`cpcr_id`),
  CONSTRAINT `FK_cpcr_sprint_sprint` FOREIGN KEY (`sprint_id`) REFERENCES `sprint` (`sprint_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16384 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table boe_project.development
DROP TABLE IF EXISTS `development`;
CREATE TABLE IF NOT EXISTS `development` (
  `development_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `obs_id` int(10) unsigned NOT NULL,
  `date` date NOT NULL,
  `sloc` bigint(20) unsigned DEFAULT NULL,
  `hours` int(10) unsigned NOT NULL,
  PRIMARY KEY (`development_id`),
  KEY `FK_development_obs` (`obs_id`),
  CONSTRAINT `FK_development_obs` FOREIGN KEY (`obs_id`) REFERENCES `obs` (`obs_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1198 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Data exporting was unselected.
-- Dumping structure for table boe_project.obs
DROP TABLE IF EXISTS `obs`;
CREATE TABLE IF NOT EXISTS `obs` (
  `obs_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `program_id` int(10) unsigned NOT NULL DEFAULT '0',
  `product_id` int(10) unsigned NOT NULL DEFAULT '0',
  `wbs_id` int(10) unsigned NOT NULL DEFAULT '0',
  `midas_code` varchar(20) DEFAULT NULL,
  `jira_code` varchar(20) DEFAULT NULL,
  `starsys_code` varchar(20) DEFAULT NULL,
  `deltech_code` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`obs_id`),
  KEY `FK_obs_program` (`program_id`),
  KEY `FK_obs_wbs` (`wbs_id`),
  KEY `FK_obs_product` (`product_id`),
  CONSTRAINT `FK_obs_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  CONSTRAINT `FK_obs_program` FOREIGN KEY (`program_id`) REFERENCES `program` (`program_id`),
  CONSTRAINT `FK_obs_wbs` FOREIGN KEY (`wbs_id`) REFERENCES `wbs` (`wbs_id`)
) ENGINE=InnoDB AUTO_INCREMENT=915 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table boe_project.product
DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_code` varchar(20) NOT NULL,
  `product_name` varchar(75) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table boe_project.program
DROP TABLE IF EXISTS `program`;
CREATE TABLE IF NOT EXISTS `program` (
  `program_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `program_code` varchar(16) NOT NULL,
  `program_name` varchar(75) NOT NULL,
  `build_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`program_id`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table boe_project.sprint
DROP TABLE IF EXISTS `sprint`;
CREATE TABLE IF NOT EXISTS `sprint` (
  `sprint_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sprint_name` varchar(20) NOT NULL,
  `jira_code` varchar(50) DEFAULT NULL,
  `weeks` int(11) DEFAULT NULL,
  PRIMARY KEY (`sprint_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table boe_project.sprint_development
DROP TABLE IF EXISTS `sprint_development`;
CREATE TABLE IF NOT EXISTS `sprint_development` (
  `sprint_development_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sprint_id` int(10) unsigned NOT NULL DEFAULT '0',
  `development_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`sprint_development_id`),
  KEY `FK_sprint_development_sprint` (`sprint_id`),
  KEY `FK_sprint_development_development` (`development_id`),
  CONSTRAINT `FK_sprint_development_development` FOREIGN KEY (`development_id`) REFERENCES `development` (`development_id`),
  CONSTRAINT `FK_sprint_development_sprint` FOREIGN KEY (`sprint_id`) REFERENCES `sprint` (`sprint_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table boe_project.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) DEFAULT '0',
  `user_email` varchar(100) DEFAULT '0',
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `user_password` varchar(300) DEFAULT '0',
  `active` bit(1) DEFAULT b'1',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for view boe_project.view_cpcr
DROP VIEW IF EXISTS `view_cpcr`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `view_cpcr` (
	`wbs_id` INT(10) UNSIGNED NOT NULL,
	`product_id` INT(10) UNSIGNED NOT NULL,
	`program_id` INT(10) UNSIGNED NOT NULL,
	`obs_id` INT(10) UNSIGNED NOT NULL,
	`cpcr_id` INT(10) UNSIGNED NOT NULL,
	`cpcr_status` VARCHAR(1) NOT NULL COLLATE 'latin1_swedish_ci',
	`updated` DATETIME NOT NULL,
	`created` DATETIME NOT NULL,
	`midas_code` VARCHAR(20) NULL COLLATE 'latin1_swedish_ci',
	`jira_code` VARCHAR(20) NULL COLLATE 'latin1_swedish_ci',
	`starsys_code` VARCHAR(20) NULL COLLATE 'latin1_swedish_ci',
	`deltech_code` VARCHAR(20) NULL COLLATE 'latin1_swedish_ci',
	`program_code` VARCHAR(16) NOT NULL COLLATE 'latin1_swedish_ci',
	`program_name` VARCHAR(75) NOT NULL COLLATE 'latin1_swedish_ci',
	`build_date` DATE NULL,
	`end_date` DATE NULL,
	`product_code` VARCHAR(20) NOT NULL COLLATE 'latin1_swedish_ci',
	`product_name` VARCHAR(75) NOT NULL COLLATE 'latin1_swedish_ci',
	`wbs_code` VARCHAR(20) NOT NULL COLLATE 'latin1_swedish_ci',
	`wbs_name` VARCHAR(75) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view boe_project.view_development
DROP VIEW IF EXISTS `view_development`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `view_development` (
	`wbs_id` INT(10) UNSIGNED NOT NULL,
	`product_id` INT(10) UNSIGNED NOT NULL,
	`program_id` INT(10) UNSIGNED NOT NULL,
	`obs_id` INT(10) UNSIGNED NOT NULL,
	`development_id` INT(10) UNSIGNED NOT NULL,
	`date` DATE NOT NULL,
	`sloc` BIGINT(20) UNSIGNED NULL,
	`hours` INT(10) UNSIGNED NOT NULL,
	`midas_code` VARCHAR(20) NULL COLLATE 'latin1_swedish_ci',
	`jira_code` VARCHAR(20) NULL COLLATE 'latin1_swedish_ci',
	`starsys_code` VARCHAR(20) NULL COLLATE 'latin1_swedish_ci',
	`deltech_code` VARCHAR(20) NULL COLLATE 'latin1_swedish_ci',
	`program_code` VARCHAR(16) NOT NULL COLLATE 'latin1_swedish_ci',
	`program_name` VARCHAR(75) NOT NULL COLLATE 'latin1_swedish_ci',
	`build_date` DATE NULL,
	`end_date` DATE NULL,
	`product_code` VARCHAR(20) NOT NULL COLLATE 'latin1_swedish_ci',
	`product_name` VARCHAR(75) NOT NULL COLLATE 'latin1_swedish_ci',
	`wbs_code` VARCHAR(20) NOT NULL COLLATE 'latin1_swedish_ci',
	`wbs_name` VARCHAR(75) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view boe_project.view_obs
DROP VIEW IF EXISTS `view_obs`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `view_obs` (
	`obs_id` INT(10) UNSIGNED NOT NULL,
	`program_id` INT(10) UNSIGNED NOT NULL,
	`program_code` VARCHAR(16) NOT NULL COLLATE 'latin1_swedish_ci',
	`program_name` VARCHAR(75) NOT NULL COLLATE 'latin1_swedish_ci',
	`product_id` INT(10) UNSIGNED NOT NULL,
	`product_code` VARCHAR(20) NOT NULL COLLATE 'latin1_swedish_ci',
	`product_name` VARCHAR(75) NOT NULL COLLATE 'latin1_swedish_ci',
	`wbs_id` INT(10) UNSIGNED NOT NULL,
	`wbs_code` VARCHAR(20) NOT NULL COLLATE 'latin1_swedish_ci',
	`wbs_name` VARCHAR(75) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for table boe_project.wbs
DROP TABLE IF EXISTS `wbs`;
CREATE TABLE IF NOT EXISTS `wbs` (
  `wbs_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wbs_code` varchar(20) NOT NULL,
  `wbs_name` varchar(75) NOT NULL,
  PRIMARY KEY (`wbs_id`)
) ENGINE=InnoDB AUTO_INCREMENT=158 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for view boe_project.view_cpcr
DROP VIEW IF EXISTS `view_cpcr`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `view_cpcr`;
CREATE ALGORITHM=MERGE DEFINER=`boe_project`@`%` SQL SECURITY DEFINER VIEW `view_cpcr` AS select `obs`.`wbs_id` AS `wbs_id`,`obs`.`product_id` AS `product_id`,`obs`.`program_id` AS `program_id`,`cpcr`.`obs_id` AS `obs_id`,`cpcr`.`cpcr_id` AS `cpcr_id`,`cpcr`.`cpcr_status` AS `cpcr_status`,`cpcr`.`updated` AS `updated`,`cpcr`.`created` AS `created`,`obs`.`midas_code` AS `midas_code`,`obs`.`jira_code` AS `jira_code`,`obs`.`starsys_code` AS `starsys_code`,`obs`.`deltech_code` AS `deltech_code`,`program`.`program_code` AS `program_code`,`program`.`program_name` AS `program_name`,`program`.`build_date` AS `build_date`,`program`.`end_date` AS `end_date`,`product`.`product_code` AS `product_code`,`product`.`product_name` AS `product_name`,`wbs`.`wbs_code` AS `wbs_code`,`wbs`.`wbs_name` AS `wbs_name` from ((((`cpcr` join `obs` on((`cpcr`.`obs_id` = `obs`.`obs_id`))) join `program` on((`obs`.`program_id` = `program`.`program_id`))) join `product` on((`obs`.`product_id` = `product`.`product_id`))) join `wbs` on((`obs`.`wbs_id` = `wbs`.`wbs_id`)));

-- Dumping structure for view boe_project.view_development
DROP VIEW IF EXISTS `view_development`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `view_development`;
CREATE ALGORITHM=UNDEFINED DEFINER=`boe_project`@`%` SQL SECURITY DEFINER VIEW `view_development` AS select `obs`.`wbs_id` AS `wbs_id`,`obs`.`product_id` AS `product_id`,`obs`.`program_id` AS `program_id`,`development`.`obs_id` AS `obs_id`,`development`.`development_id` AS `development_id`,`development`.`date` AS `date`,`development`.`sloc` AS `sloc`,`development`.`hours` AS `hours`,`obs`.`midas_code` AS `midas_code`,`obs`.`jira_code` AS `jira_code`,`obs`.`starsys_code` AS `starsys_code`,`obs`.`deltech_code` AS `deltech_code`,`program`.`program_code` AS `program_code`,`program`.`program_name` AS `program_name`,`program`.`build_date` AS `build_date`,`program`.`end_date` AS `end_date`,`product`.`product_code` AS `product_code`,`product`.`product_name` AS `product_name`,`wbs`.`wbs_code` AS `wbs_code`,`wbs`.`wbs_name` AS `wbs_name` from ((((`development` join `obs` on((`development`.`obs_id` = `obs`.`obs_id`))) join `program` on((`obs`.`program_id` = `program`.`program_id`))) join `product` on((`obs`.`product_id` = `product`.`product_id`))) join `wbs` on((`obs`.`wbs_id` = `wbs`.`wbs_id`)));

-- Dumping structure for view boe_project.view_obs
DROP VIEW IF EXISTS `view_obs`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `view_obs`;
CREATE ALGORITHM=UNDEFINED DEFINER=`boe_project`@`%` SQL SECURITY DEFINER VIEW `view_obs` AS select `obs`.`obs_id` AS `obs_id`,`obs`.`program_id` AS `program_id`,`program`.`program_code` AS `program_code`,`program`.`program_name` AS `program_name`,`obs`.`product_id` AS `product_id`,`product`.`product_code` AS `product_code`,`product`.`product_name` AS `product_name`,`obs`.`wbs_id` AS `wbs_id`,`wbs`.`wbs_code` AS `wbs_code`,`wbs`.`wbs_name` AS `wbs_name` from (((`obs` join `program` on((`obs`.`program_id` = `program`.`program_id`))) join `product` on((`obs`.`product_id` = `product`.`product_id`))) join `wbs` on((`obs`.`wbs_id` = `wbs`.`wbs_id`)));

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
