-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 11, 2019 at 06:55 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 5.6.37

SET SQL_MODE   = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone  = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uxconsul_game`
--

-- --------------------------------------------------------

--
-- Table structure for table `GAME_ENTERPRIZE_GAME`
--

CREATE TABLE `GAME_ENTERPRIZE_GAME` (
  `EG_ID` int(11) NOT NULL,
  `EG_EnterprizeID` int(11) NOT NULL,
  `EG_GameID` int(11) NOT NULL,
  `EG_Game_Start_Date` date NOT NULL,
  `EG_Game_End_Date` date NOT NULL,
  `EG_CreatedOn` date NOT NULL,
  `EG_CreatedBy` int(11) NOT NULL,
  `EG_UpdatedOn` date NOT NULL,
  `EG_UpdatedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `GAME_ENTERPRIZE_GAME`
--
ALTER TABLE `GAME_ENTERPRIZE_GAME`
  ADD PRIMARY KEY (`EG_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `GAME_ENTERPRIZE_GAME`
--
ALTER TABLE `GAME_ENTERPRIZE_GAME`
  MODIFY `EG_ID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
