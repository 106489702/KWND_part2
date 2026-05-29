-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost
-- Thời gian đã tạo: Th5 29, 2026 lúc 07:45 AM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `kwnd_db`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contributions`
--

CREATE TABLE `contributions` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `contribution` varchar(200) DEFAULT NULL,
  `assessment_part` int(11) NOT NULL CHECK (`assessment_part` in (1,2))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `contributions`
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

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
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

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `contributions`
--
ALTER TABLE `contributions`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`job_ref`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `contributions`
--
ALTER TABLE `contributions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

CREATE TABLE `eoi` (
  `EOINumber`   INT(11)      NOT NULL AUTO_INCREMENT,
  `JobRef`      VARCHAR(5)   NOT NULL,
  `FirstName`   VARCHAR(20)  NOT NULL,
  `LastName`    VARCHAR(20)  NOT NULL,
  `DOB`         DATE         NOT NULL,
  `Gender`      ENUM('Male','Female','Other') NOT NULL,
  `Street`      VARCHAR(40)  NOT NULL,
  `SuburbTown`  VARCHAR(40)  NOT NULL,
  `State`       ENUM('VIC','NSW','QLD','SA','WA','TAS','ACT','NT') NOT NULL,
  `Postcode`    CHAR(4)      NOT NULL,
  `Email`       VARCHAR(60)  NOT NULL,
  `Phone`       VARCHAR(12)  NOT NULL,
  `Skills`      VARCHAR(300) NOT NULL,
  `OtherSkills` VARCHAR(300) DEFAULT NULL,
  `Status`      ENUM('New','Current','Final') NOT NULL DEFAULT 'New',
  PRIMARY KEY (`EOINumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
