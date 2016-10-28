-- --------------------------------------------------------
-- Host:                         elvis.rowan.edu
-- Server version:               10.1.16-MariaDB - MariaDB Server
-- Server OS:                    Linux
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for boe_project
CREATE DATABASE IF NOT EXISTS `boe_project` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `boe_project`;

-- Dumping structure for table boe_project.Development
CREATE TABLE IF NOT EXISTS `Development` (
  `Development_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `WBS_Project_Product_ID` int(10) unsigned NOT NULL,
  `Date` date NOT NULL,
  `SLOC` bigint(20) unsigned NOT NULL,
  `Hours` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Development_ID`),
  KEY `FK_Development_WBS_Project_Product` (`WBS_Project_Product_ID`),
  CONSTRAINT `FK_Development_WBS_Project_Product` FOREIGN KEY (`WBS_Project_Product_ID`) REFERENCES `WBS_Project_Product` (`Wbs_Project_Product_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=256 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table boe_project.NewBug
CREATE TABLE IF NOT EXISTS `NewBug` (
  `Bug_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `WBS_Project_Product_ID` int(10) unsigned NOT NULL,
  `B_Status` varchar(1) NOT NULL,
  `Bug_Hours` int(10) unsigned NOT NULL,
  `Updated` datetime NOT NULL,
  `Created` datetime NOT NULL,
  PRIMARY KEY (`Bug_ID`),
  KEY `FK_NewBug_WBS_Project_Product` (`WBS_Project_Product_ID`),
  CONSTRAINT `FK_NewBug_WBS_Project_Product` FOREIGN KEY (`WBS_Project_Product_ID`) REFERENCES `WBS_Project_Product` (`Wbs_Project_Product_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1024 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table boe_project.Product
CREATE TABLE IF NOT EXISTS `Product` (
  `Product_Code` varchar(20) NOT NULL,
  `Product_Name` varchar(50) NOT NULL,
  PRIMARY KEY (`Product_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table boe_project.Project
CREATE TABLE IF NOT EXISTS `Project` (
  `Project_ID` varchar(16) NOT NULL,
  `Project_Name` varchar(30) NOT NULL,
  `Build_Date` date NOT NULL,
  `End_Date` date NOT NULL,
  PRIMARY KEY (`Project_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table boe_project.Project_Product
CREATE TABLE IF NOT EXISTS `Project_Product` (
  `Project_ProductID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Project_ID` varchar(16) NOT NULL,
  `Product_code` varchar(20) NOT NULL,
  PRIMARY KEY (`Project_ProductID`),
  KEY `FK_Project_Product_Project` (`Project_ID`),
  KEY `FK_Project_Product_Product` (`Product_code`),
  CONSTRAINT `FK_Project_Product_Product` FOREIGN KEY (`Product_code`) REFERENCES `Product` (`Product_Code`),
  CONSTRAINT `FK_Project_Product_Project` FOREIGN KEY (`Project_ID`) REFERENCES `Project` (`Project_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table boe_project.WBS
CREATE TABLE IF NOT EXISTS `WBS` (
  `WBS_ID` varchar(20) NOT NULL,
  `WBS_Name` varchar(50) NOT NULL,
  PRIMARY KEY (`WBS_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table boe_project.WBS_Project_Product
CREATE TABLE IF NOT EXISTS `WBS_Project_Product` (
  `Wbs_Project_Product_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Project_ProductID` int(10) unsigned NOT NULL,
  `WBS_ID` varchar(20) NOT NULL,
  PRIMARY KEY (`Wbs_Project_Product_ID`),
  KEY `FK_Wbs_Project_Product_Project_Product` (`Project_ProductID`),
  KEY `FK_Wbs_Project_Product_WBS` (`WBS_ID`),
  CONSTRAINT `FK_Wbs_Project_Product_Project_Product` FOREIGN KEY (`Project_ProductID`) REFERENCES `Project_Product` (`Project_ProductID`),
  CONSTRAINT `FK_Wbs_Project_Product_WBS` FOREIGN KEY (`WBS_ID`) REFERENCES `WBS` (`WBS_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=231 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
