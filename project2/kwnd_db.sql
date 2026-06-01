-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2026 at 03:54 PM
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
(14, 'Nguyen', 'Pham', 'Contributed to Github', 1),
(15, 'Will', 'Luck', 'reformatted .html files to .php', 2),
(16, 'Will', 'Luck', 'created settings.php', 2),
(17, 'Will', 'Luck', 'Created contributions table', 2),
(18, 'Will', 'Luck', 'Dynamically rendered contributions table in about.php', 2),
(19, 'Kerrigan', 'La-Brooy', 'Created manage.php', 2),
(20, 'Kerrigan', 'La-Brooy', 'Dynamically rendered eoi table in manage.php', 2),
(21, 'Kerrigan', 'La-Brooy', 'Allowed interaction with eoi table from manage.php (sort, search, delete)', 2),
(22, 'Duy', 'Phan', 'created jobs table', 2),
(23, 'Duy', 'Phan', 'Dynamically rendered jobs table on jobs.html', 2),
(24, 'Duy', 'Phan', 'Created login.php', 2),
(25, 'Duy', 'Phan', 'Authenticated login/logout of manage.php using a users table', 2),
(26, 'Nguyen', 'Pham', 'Created Process_eoi.php (validated record)', 2),
(27, 'Nguyen', 'Pham', 'Created eoi table', 2),
(28, 'Nguyen', 'Pham', 'Linked eoi table to existing form on apply.php', 2);

-- --------------------------------------------------------

--
-- Table structure for table `eoi`
--

CREATE TABLE `eoi` (
  `EOINumber` int(11) NOT NULL,
  `JobRef` varchar(5) NOT NULL,
  `FirstName` varchar(20) NOT NULL,
  `LastName` varchar(20) NOT NULL,
  `DOB` date NOT NULL,
  `Gender` enum('Male','Female','Other') NOT NULL,
  `Street` varchar(40) NOT NULL,
  `SuburbTown` varchar(40) NOT NULL,
  `State` enum('VIC','NSW','QLD','SA','WA','TAS','ACT','NT') NOT NULL,
  `Postcode` char(4) NOT NULL,
  `Email` varchar(60) NOT NULL,
  `Phone` varchar(12) NOT NULL,
  `Skills` varchar(300) NOT NULL,
  `OtherSkills` varchar(300) DEFAULT NULL,
  `Status` enum('New','Current','Final') NOT NULL DEFAULT 'New'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eoi`
--

INSERT INTO `eoi` (`EOINumber`, `JobRef`, `FirstName`, `LastName`, `DOB`, `Gender`, `Street`, `SuburbTown`, `State`, `Postcode`, `Email`, `Phone`, `Skills`, `OtherSkills`, `Status`) VALUES
(1, 'ABC01', 'Nguyen ', 'Pham', '2016-05-12', 'Male', '', 'Hawthorne', 'VIC', '3122', 'pham@test.com', '04 8378 8378', 'very smarty', 'skillful', 'New'),
(2, 'EFG01', 'Duy', '', '2016-05-12', 'Male', '', 'Hawthorne', 'VIC', '3123', 'Duy@test.com', '04 8378 8378', 'Very Valorant', 'skillful plat', 'New'),
(3, 'ART01', 'Kerrigan', 'La-Brooy', '2008-03-09', 'Male', 'Blake', 'Berwick', 'VIC', '3806', 'legend@test.com', '04 8378 8378', 'skilled', 'very skilled', 'Current'),
(4, 'ABC01', 'Will', 'Luck', '2008-03-09', 'Male', '', 'gisborne', 'VIC', '3437', 'lucky@test.com', '04 8378 8378', 'skilled', 'very lucky', 'Current');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `job_ref` varchar(5) NOT NULL,
  `job_title` varchar(100) NOT NULL,
  `salary` varchar(100) NOT NULL,
  `reporting_line` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `responsibilities` text NOT NULL,
  `essentials` text NOT NULL,
  `preferables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`job_ref`, `job_title`, `salary`, `reporting_line`, `description`, `responsibilities`, `essentials`, `preferables`) VALUES
('COP03', 'Copywriter', '60000', 'Creative Director', 'Write engaging content for advertising and digital campaigns.', 'Create ad copy, website text, and social captions.', 'Excellent writing skills, attention to detail.', 'SEO knowledge.'),
('GRA01', 'Graphic Designer', '65000', 'Creative Director', 'Create visual assets for client campaigns and social media.', 'Design graphics, update branding materials, collaborate with team.', 'Adobe Photoshop, Illustrator, strong design skills.', 'Motion graphics experience.'),
('SOC02', 'Social Media Coordinator', '55000', 'Marketing Manager', 'Help manage content across social platforms.', 'Schedule posts, monitor engagement, assist with campaigns.', 'Strong communication skills, social media knowledge.', 'Experience with Canva or Meta Business Suite.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contributions`
--
ALTER TABLE `contributions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eoi`
--
ALTER TABLE `eoi`
  ADD PRIMARY KEY (`EOINumber`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`job_ref`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contributions`
--
ALTER TABLE `contributions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `eoi`
--
ALTER TABLE `eoi`
  MODIFY `EOINumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
