-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2018 at 11:33 PM
-- Server version: 10.1.8-MariaDB
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `carquest`
--

-- --------------------------------------------------------

--
-- Table structure for table `carinfo`
--

CREATE TABLE `carinfo` (
  `id` int(1) NOT NULL,
  `Make` varchar(50) DEFAULT NULL,
  `Model` varchar(50) DEFAULT NULL,
  `Year` int(1) DEFAULT NULL,
  `CurrentMileage` int(1) DEFAULT '0',
  `VID` varchar(50) DEFAULT NULL,
  `LicenseTag` varchar(50) DEFAULT NULL,
  `PropertyTax` decimal(19,4) DEFAULT '0.0000',
  `PropertyTaxDue` datetime DEFAULT NULL,
  `InsuranceProvider` varchar(50) DEFAULT NULL,
  `InsurancePolicy` varchar(50) DEFAULT NULL
) ENGINE=Aria DEFAULT CHARSET=utf8;


--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `id` int(1) NOT NULL,
  `rec_No` int(1) NOT NULL,
  `Date` datetime DEFAULT NULL,
  `Location` varchar(50) DEFAULT NULL,
  `Cost` decimal(19,2) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Mileage` int(1) DEFAULT '0'
) ENGINE=Aria DEFAULT CHARSET=utf8;


--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(1) NOT NULL DEFAULT '0',
  `rec_No` int(1) NOT NULL,
  `MileageInterval` int(1) DEFAULT '0',
  `MonthInterval` int(1) DEFAULT '0',
  `LastCompletedMiles` int(1) DEFAULT '0',
  `LastCompletedDate` datetime DEFAULT NULL,
  `NextSchedMaint` int(1) DEFAULT NULL,
  `Description` varchar(100) DEFAULT NULL
) ENGINE=Aria DEFAULT CHARSET=utf8;


--
-- Indexes for table `carinfo`
--
ALTER TABLE `carinfo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `VID` (`VID`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD KEY `Date` (`Date`),
  ADD KEY `Index` (`id`),
  ADD KEY `rec_No` (`rec_No`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD KEY `Index` (`id`),
  ADD KEY `rec_No` (`rec_No`);


--
-- AUTO_INCREMENT for table `carinfo`
--
ALTER TABLE `carinfo`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `rec_No` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;
--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `rec_No` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
