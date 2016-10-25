

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

-- Dumping structure for table boe_project.Bug
CREATE TABLE IF NOT EXISTS `Bug` (
  `BID` varchar(30) NOT NULL,
  `PID` varchar(16) NOT NULL,
  `Prod_code` varchar(20) NOT NULL,
  `WBS_ID` varchar(20) NOT NULL,
  `B_Status` varchar(1) NOT NULL,
  `Bug_Hours` int(6) NOT NULL,
  `Created` datetime NOT NULL,
  `Updated` datetime NOT NULL,
  PRIMARY KEY (`BID`),
  KEY `FK_Bug_Product` (`Prod_code`),
  KEY `FK_Bug_WBS` (`WBS_ID`),
  KEY `FK_Bug_PID` (`PID`),
  CONSTRAINT `FK_Bug_Product` FOREIGN KEY (`Prod_code`) REFERENCES `Product` (`Product_Code`),
  CONSTRAINT `FK_Bug_Project` FOREIGN KEY (`PID`) REFERENCES `Project` (`PID`),
  CONSTRAINT `FK_Bug_WBS` FOREIGN KEY (`WBS_ID`) REFERENCES `WBS` (`WBS_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table boe_project.Contains
CREATE TABLE IF NOT EXISTS `Contains` (
  `PID` varchar(16) NOT NULL,
  `Product_Code` varchar(20) NOT NULL,
  PRIMARY KEY (`PID`,`Product_Code`),
  KEY `FK_Contains_Product` (`Product_Code`),
  CONSTRAINT `FK_Contains_Product` FOREIGN KEY (`Product_Code`) REFERENCES `Product` (`Product_Code`),
  CONSTRAINT `FK_Contains_Project` FOREIGN KEY (`PID`) REFERENCES `Project` (`PID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table boe_project.Describes
CREATE TABLE IF NOT EXISTS `Describes` (
  `PID` varchar(16) NOT NULL,
  `Product_Code` varchar(20) NOT NULL,
  `WBS_ID` varchar(20) NOT NULL,
  `Date` date NOT NULL,
  `SLOC` bigint(20) NOT NULL,
  `D_Hours` int(11) NOT NULL,
  PRIMARY KEY (`PID`,`Product_Code`,`WBS_ID`,`Date`),
  KEY `FK__Product_2` (`Product_Code`),
  KEY `FK__WBS` (`WBS_ID`),
  CONSTRAINT `FK__Product_2` FOREIGN KEY (`Product_Code`) REFERENCES `Product` (`Product_Code`),
  CONSTRAINT `FK__Project` FOREIGN KEY (`PID`) REFERENCES `Project` (`PID`),
  CONSTRAINT `FK__WBS` FOREIGN KEY (`WBS_ID`) REFERENCES `WBS` (`WBS_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `PID` varchar(16) NOT NULL,
  `Project_Name` varchar(30) NOT NULL,
  `Build_Date` date NOT NULL,
  `End_Date` date NOT NULL,
  PRIMARY KEY (`PID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table boe_project.user
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) DEFAULT '0',
  `user_email` varchar(100) DEFAULT '0',
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `user_password` varchar(300) DEFAULT '0',
  `active` bit(1) DEFAULT b'1',
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table boe_project.WBS
CREATE TABLE IF NOT EXISTS `WBS` (
  `WBS_ID` varchar(20) NOT NULL,
  `WBS_Name` varchar(50) NOT NULL,
  PRIMARY KEY (`WBS_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
