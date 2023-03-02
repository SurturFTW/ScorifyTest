-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2023 at 04:20 PM
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

--
-- Dumping data for table `game`
--

INSERT INTO `game` (`matchId`, `userId`, `title`, `venue`, `tossWon`, `tossResult`, `maxOvers`, `result`) VALUES
(1, 1, 'Practice', 'Wankhade', 'India', 'bat', 1, 'Australia won by 1 wickets with 0 balls remaining.'),
(2, 2, 'World Cup', 'Mohali', 'India', 'bat', 1, 'India won by 25 runs'),
(3, 1, 'Tournament', 'NGOPAN', 'India', 'bat', 1, 'India won by 12 runs'),
(4, 5, 'world cup', 'wandkhade', 'india', 'bat', 2, 'india won by 1 runs');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `userid` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(250) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Pass` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`userid`, `Name`, `Email`, `Username`, `Pass`) VALUES
(1, 'Pushkar', 'thekingpush417@gmail.com', 'admin', 'admin12345'),
(2, 'Aditi', 'thakoreaditi65@gmail.com', 'zelda', 'aditi1808'),
(5, 'prasad', 'psane300@gmail.com', 'saneprasad', 'pushkar1978');

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

--
-- Dumping data for table `player`
--

INSERT INTO `player` (`playerId`, `matchId`, `teamId`, `playerName`, `playerRole`, `playerStatus`) VALUES
(1, 1, 1, 'Shewag', 'bat', 'b McGrath'),
(2, 1, 1, 'Dhoni', 'wk', 'not out'),
(3, 1, 1, 'Ashwin', 'all_r', 'hit-wicket b McGrath'),
(4, 1, 2, 'Gilchrist', 'wk', 'not out'),
(5, 1, 2, 'Smith', 'bat', 'not out'),
(6, 1, 2, 'McGrath', 'bowl', 'not out'),
(7, 2, 3, 'Tendulkar', 'bat', 'not out'),
(8, 2, 3, 'Dhoni', 'wk', 'not out'),
(9, 2, 3, 'Zaheer', 'bowl', 'yet to bat'),
(10, 2, 4, 'Misbah', 'bat', 'lbw Zaheer'),
(11, 2, 4, 'Afradi', 'all_r', 'not out'),
(12, 2, 4, 'Akhtar', 'bowl', 'not out'),
(13, 3, 5, 'gage', 'bat', 'st gage b rjtrj'),
(14, 3, 5, 'heh', 'bat', 'not out'),
(15, 3, 5, 'rtjrtjr', 'bat', 'lbw rjtrj'),
(16, 3, 6, 'gage', 'bat', 'st gage b rtjrtjr'),
(17, 3, 6, 'hreh', 'bat', 'not out'),
(18, 3, 6, 'rjtrj', 'bat', 'st gage b rtjrtjr'),
(19, 4, 7, 'rohit sharma', 'bat', 'not out'),
(20, 4, 7, 'k l rahul', 'wk', 'b warne'),
(21, 4, 7, 'ashwin', 'all_r', 'not out'),
(22, 4, 8, 'warner', 'bat', 'not out'),
(23, 4, 8, 'mcgrath', 'bowl', 'st rohit sharma b ashwin'),
(24, 4, 8, 'warne', 'all_r', 'not out');

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
  `ballsBowled` int(100) NOT NULL,
  `runGiven` int(100) NOT NULL,
  `dotGiven` int(100) NOT NULL,
  `maidenGiven` int(100) NOT NULL,
  `fourConsidered` int(100) NOT NULL,
  `sixConsidered` int(100) NOT NULL,
  `wideGiven` int(100) NOT NULL,
  `noBallGiven` int(100) NOT NULL,
  `wicketTaken` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `score`
--

INSERT INTO `score` (`id`, `matchId`, `teamId`, `playerId`, `runScored`, `ballFaced`, `ballDotted`, `fourHitted`, `sixHitted`, `ballsBowled`, `runGiven`, `dotGiven`, `maidenGiven`, `fourConsidered`, `sixConsidered`, `wideGiven`, `noBallGiven`, `wicketTaken`) VALUES
(1, 1, 1, 1, 4, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 1, 1, 2, 3, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3, 1, 1, 3, 1, 3, 1, 0, 0, 6, 11, 1, 0, 1, 0, 0, 1, 0),
(4, 1, 2, 4, 2, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(5, 1, 2, 5, 2, 3, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(6, 1, 2, 6, 4, 1, 0, 1, 0, 6, 9, 3, 0, 1, 0, 1, 0, 2),
(7, 2, 3, 7, 3, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(8, 2, 3, 8, 30, 5, 0, 0, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(9, 2, 3, 9, 0, 0, 0, 0, 0, 6, 8, 1, 0, 0, 0, 0, 0, 1),
(10, 2, 4, 10, 2, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(11, 2, 4, 11, 6, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(12, 2, 4, 12, 0, 0, 0, 0, 0, 6, 33, 0, 0, 0, 5, 0, 0, 0),
(13, 3, 5, 13, 12, 4, 0, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(14, 3, 5, 14, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(15, 3, 5, 15, 0, 1, 0, 0, 0, 2, 0, 2, 0, 0, 0, 0, 0, 2),
(16, 3, 6, 16, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(17, 3, 6, 17, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(18, 3, 6, 18, 0, 1, 0, 0, 0, 5, 12, 2, 0, 3, 0, 0, 0, 2),
(19, 4, 7, 19, 4, 5, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(20, 4, 7, 20, 3, 2, 0, 0, 0, 6, 11, 0, 0, 0, 0, 0, 0, 0),
(21, 4, 7, 21, 15, 5, 0, 2, 0, 6, 11, 1, 0, 1, 0, 0, 0, 1),
(22, 4, 8, 22, 12, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(23, 4, 8, 23, 0, 1, 0, 0, 0, 6, 11, 1, 0, 1, 0, 0, 0, 0),
(24, 4, 8, 24, 10, 4, 0, 1, 0, 6, 12, 1, 0, 1, 0, 0, 0, 1);

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

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`teamId`, `matchId`, `teamName`, `teamRuns`, `teamBalls`, `teamWickets`) VALUES
(1, 1, 'India', 9, 6, 2),
(2, 1, 'Australia', 11, 6, 1),
(3, 2, 'India', 33, 6, 0),
(4, 2, 'Pakistan', 8, 6, 1),
(5, 3, 'India', 12, 5, 2),
(6, 3, 'Australia', 0, 2, 2),
(7, 4, 'india', 23, 12, 1),
(8, 4, 'australia', 22, 12, 1);

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
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`userid`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `game`
--
ALTER TABLE `game`
  MODIFY `matchId` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `player`
--
ALTER TABLE `player`
  MODIFY `playerId` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `score`
--
ALTER TABLE `score`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `teamId` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `game`
--
ALTER TABLE `game`
  ADD CONSTRAINT `user_match` FOREIGN KEY (`userId`) REFERENCES `members` (`userid`);

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
