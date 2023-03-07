-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2023 at 08:32 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `matchId` int(100) NOT NULL,
  `userId` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `venue` varchar(100) NOT NULL,
  `tossWon` varchar(100) NOT NULL,
  `tossResult` varchar(100) NOT NULL,
  `maxOvers` int(255) NOT NULL,
  `result` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `player`
--

CREATE TABLE `player` (
  `playerId` int(100) NOT NULL,
  `matchId` int(100) NOT NULL,
  `teamId` int(100) NOT NULL,
  `playerName` varchar(100) NOT NULL,
  `playerRole` varchar(100) NOT NULL,
  `playerStatus` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `score`
--

CREATE TABLE `score` (
  `id` int(100) NOT NULL,
  `matchId` int(100) NOT NULL,
  `teamId` int(100) NOT NULL,
  `playerId` int(100) NOT NULL,
  `runScored` int(100) NOT NULL,
  `ballFaced` int(100) NOT NULL,
  `ballDotted` int(100) NOT NULL,
  `fourHitted` int(100) NOT NULL,
  `sixHitted` int(100) NOT NULL,
  `overBowled` int(100) NOT NULL,
  `runGiven` int(100) NOT NULL,
  `dotGiven` int(100) NOT NULL,
  `maidenGiven` int(100) NOT NULL,
  `fourConsidered` int(100) NOT NULL,
  `sixConsidered` int(100) NOT NULL,
  `wideGiven` int(100) NOT NULL,
  `noBallGiven` int(100) NOT NULL,
  `wicketTaken` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `teamId` int(100) NOT NULL,
  `matchId` int(100) NOT NULL,
  `teamName` varchar(100) NOT NULL,
  `teamRuns` int(100) NOT NULL,
  `teamBalls` int(100) NOT NULL,
  `teamWickets` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userid` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(250) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Pass` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `Name`, `Email`, `Username`, `Pass`) VALUES
(1, '', 'thekingpush417@gmail.com', 'admin', 'admin12345'),
(2, '', 'vedantparkar155@gmail.com', 'vedant', 'vedant11'),
(3, '', 'thakoreaditi65@gmail.com', 'zelda', 'zelda1808');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`matchId`),
  ADD KEY `user_match` (`userId`);

--
-- Indexes for table `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`playerId`),
  ADD KEY `matchId` (`matchId`),
  ADD KEY `teamId` (`teamId`);

--
-- Indexes for table `score`
--
ALTER TABLE `score`
  ADD PRIMARY KEY (`id`),
  ADD KEY `match_player` (`matchId`),
  ADD KEY `team_player` (`teamId`),
  ADD KEY `player_score` (`playerId`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`teamId`),
  ADD KEY `matchId` (`matchId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `game`
--
ALTER TABLE `game`
  MODIFY `matchId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `player`
--
ALTER TABLE `player`
  MODIFY `playerId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `score`
--
ALTER TABLE `score`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `teamId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `game`
--
ALTER TABLE `game`
  ADD CONSTRAINT `user_match` FOREIGN KEY (`userId`) REFERENCES `user` (`userid`);

--
-- Constraints for table `player`
--
ALTER TABLE `player`
  ADD CONSTRAINT `player_match` FOREIGN KEY (`matchId`) REFERENCES `game` (`matchId`),
  ADD CONSTRAINT `player_team` FOREIGN KEY (`teamId`) REFERENCES `team` (`teamId`);

--
-- Constraints for table `score`
--
ALTER TABLE `score`
  ADD CONSTRAINT `match_player` FOREIGN KEY (`matchId`) REFERENCES `game` (`matchId`),
  ADD CONSTRAINT `player_score` FOREIGN KEY (`playerId`) REFERENCES `player` (`playerId`),
  ADD CONSTRAINT `team_player` FOREIGN KEY (`teamId`) REFERENCES `team` (`teamId`);

--
-- Constraints for table `team`
--
ALTER TABLE `team`
  ADD CONSTRAINT `match_team` FOREIGN KEY (`matchId`) REFERENCES `game` (`matchId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
