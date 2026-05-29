-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2026 at 06:34 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kwnd_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `contributions`
--

CREATE TABLE `contributions` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `contribution` varchar(200) DEFAULT NULL,
  `assessment_part` int(11) NOT NULL CHECK (`assessment_part` in (1,2))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contributions`
--

INSERT INTO `contributions` (`id`, `first_name`, `last_name`, `contribution`, `assessment_part`) VALUES
(1, 'Will', 'Luck', 'Created index.html\r\n\r\n\r\n\r\n', 1),
(2, 'Will', 'Luck', 'Created style.css', 1),
(3, 'Will', 'Luck', 'Created github', 1),
(4, 'Will', 'Luck', 'Created jira', 1),
(5, 'Will', 'Luck', 'Group leader', 1),
(6, 'Kerrigan', 'La-Brooy', 'Created about.html', 1),
(7, 'Kerrigan', 'La-Brooy', 'Created styling for about.html', 1),
(8, 'Kerrigan', 'La-Brooy', 'Contributed to Github', 1),
(9, 'Duy', 'Phan', 'Created apply.html', 1),
(10, 'Duy', 'Phan', 'Created styling for apply.html', 1),
(11, 'Duy', 'Phan', 'Contributed to Github', 1),
(12, 'Nguyen', 'Pham', 'Created jobs.html', 1),
(13, 'Nguyen', 'Pham', 'Created styling for jobs.html', 1),
(14, 'Nguyen', 'Pham', 'Contributed to Github', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contributions`
--
ALTER TABLE `contributions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contributions`
--
ALTER TABLE `contributions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
