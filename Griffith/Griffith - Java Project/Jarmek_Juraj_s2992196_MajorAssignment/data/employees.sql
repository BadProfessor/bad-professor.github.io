--	DO NOT EDIT THIS FILE

-- 	This file contains the table creation statements for your schema 
--	in addition to statements to populate the tables with data.


-- MySQL dump 10.13  Distrib 5.7.9, for osx10.9 (x86_64)
--
-- Host: 127.0.0.1    Database: spare3
-- ------------------------------------------------------
-- Server version	5.7.9

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `oop_departments`
--

DROP TABLE IF EXISTS `oop_departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oop_departments` (
  `dept_no` char(4) NOT NULL,
  `dept_name` varchar(40) NOT NULL,
  PRIMARY KEY (`dept_no`),
  UNIQUE KEY `dept_name` (`dept_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oop_departments`
--

LOCK TABLES `oop_departments` WRITE;
/*!40000 ALTER TABLE `oop_departments` DISABLE KEYS */;
INSERT INTO `oop_departments` VALUES ('5','CumstomerService'),('1','Finance_'),('4','HR'),('3','Marketing'),('2','Sales');
/*!40000 ALTER TABLE `oop_departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oop_dept_emp`
--

DROP TABLE IF EXISTS `oop_dept_emp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oop_dept_emp` (
  `emp_no` int(11) NOT NULL,
  `dept_no` char(4) NOT NULL,
  PRIMARY KEY (`emp_no`,`dept_no`),
  KEY `emp_no` (`emp_no`),
  KEY `dept_no` (`dept_no`),
  CONSTRAINT `oop_dept_emp_ibfk_1` FOREIGN KEY (`emp_no`) REFERENCES `oop_employees` (`emp_no`) ON DELETE CASCADE,
  CONSTRAINT `oop_dept_emp_ibfk_2` FOREIGN KEY (`dept_no`) REFERENCES `oop_departments` (`dept_no`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oop_dept_emp`
--

LOCK TABLES `oop_dept_emp` WRITE;
/*!40000 ALTER TABLE `oop_dept_emp` DISABLE KEYS */;
INSERT INTO `oop_dept_emp` VALUES (1,'1'),(2,'2'),(3,'3'),(4,'4'),(5,'5'),(6,'1'),(7,'2'),(8,'3'),(9,'4'),(10,'5');
/*!40000 ALTER TABLE `oop_dept_emp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oop_dept_manager`
--

DROP TABLE IF EXISTS `oop_dept_manager`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oop_dept_manager` (
  `dept_no` char(4) NOT NULL,
  `emp_no` int(11) NOT NULL,
  PRIMARY KEY (`emp_no`,`dept_no`),
  KEY `emp_no` (`emp_no`),
  KEY `dept_no` (`dept_no`),
  CONSTRAINT `oop_dept_manager_ibfk_1` FOREIGN KEY (`emp_no`) REFERENCES `oop_employees` (`emp_no`) ON DELETE CASCADE,
  CONSTRAINT `oop_dept_manager_ibfk_2` FOREIGN KEY (`dept_no`) REFERENCES `oop_departments` (`dept_no`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oop_dept_manager`
--

LOCK TABLES `oop_dept_manager` WRITE;
/*!40000 ALTER TABLE `oop_dept_manager` DISABLE KEYS */;
INSERT INTO `oop_dept_manager` VALUES ('1',1),('2',1),('3',1),('4',2),('5',2);
/*!40000 ALTER TABLE `oop_dept_manager` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oop_employees`
--

DROP TABLE IF EXISTS `oop_employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oop_employees` (
  `emp_no` int(11) NOT NULL,
  `birth_date` date NOT NULL,
  `first_name` varchar(14) NOT NULL,
  `last_name` varchar(16) NOT NULL,
  `gender` enum('M','F') NOT NULL,
  `hire_date` date NOT NULL,
  PRIMARY KEY (`emp_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oop_employees`
--

LOCK TABLES `oop_employees` WRITE;
/*!40000 ALTER TABLE `oop_employees` DISABLE KEYS */;
INSERT INTO `oop_employees` VALUES (1,'2000-01-01','Albert','Abraham','M','2000-02-01'),(2,'2000-01-02','Bruce','Banner','M','2000-02-02'),(3,'2000-01-03','Cat','Cannon','F','2000-02-03'),(4,'2000-01-04','Derek','Dunne','M','2000-02-04'),(5,'2000-01-05','Elenor','Edwards','F','2000-02-05'),(6,'2000-01-06','Fred','Flints','M','2000-02-06'),(7,'2000-01-07','Gerald','Goodman','M','2000-02-07'),(8,'2000-01-08','Hugh','Harvey','M','2000-02-08'),(9,'2000-01-09','Ina','Inks','F','2000-02-09'),(10,'2000-01-10','Jack','Jackson','M','2000-02-10'),(11,'2015-11-22','Alex','Cronin','M','2015-11-23');
/*!40000 ALTER TABLE `oop_employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oop_salaries`
--

DROP TABLE IF EXISTS `oop_salaries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oop_salaries` (
  `emp_no` int(11) NOT NULL,
  `salary` int(11) NOT NULL,
  PRIMARY KEY (`emp_no`),
  KEY `emp_no` (`emp_no`),
  CONSTRAINT `oop_salaries_ibfk_1` FOREIGN KEY (`emp_no`) REFERENCES `oop_employees` (`emp_no`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oop_salaries`
--

LOCK TABLES `oop_salaries` WRITE;
/*!40000 ALTER TABLE `oop_salaries` DISABLE KEYS */;
INSERT INTO `oop_salaries` VALUES (1,1000),(2,2000),(3,3000),(4,4000),(5,5000),(6,6000),(7,7000),(8,8000),(9,9000),(10,10000);
/*!40000 ALTER TABLE `oop_salaries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'spare3'
--
/*!50003 DROP PROCEDURE IF EXISTS `getEmployeeCount` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE PROCEDURE `getEmployeeCount`()
SELECT COUNT(emp_no) AS num FROM oop_employees ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-12-02 14:36:55
