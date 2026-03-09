-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2025 at 12:47 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_crs1`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_course`
--

CREATE TABLE `tb_course` (
  `c_code` varchar(10) NOT NULL,
  `c_name` varchar(30) NOT NULL,
  `c_credit` int(11) NOT NULL,
  `c_sem` varchar(11) NOT NULL,
  `c_lec` varchar(10) NOT NULL,
  `max_students` int(11) NOT NULL,
  `current_students` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_course`
--

INSERT INTO `tb_course` (`c_code`, `c_name`, `c_credit`, `c_sem`, `c_lec`, `max_students`, `current_students`) VALUES
('SECJ1033', 'Programming Technique 1', 3, '2024/2025-1', 'L001', 3, 0),
('SECJ1033', 'Programming Technique 1', 3, '2024/2025-2', 'L002', 2, 0),
('SECP2523', 'Database (WBL)', 3, '2024/2025-1', 'L002', 3, 0),
('SECP3032', 'Data Engineering', 3, '2024/2025-2', 'L001', 3, 0),
('SECP3032', 'Data Engineering', 3, '2024/2025-3', 'L002', 3, 0),
('SECP3204', 'Software Engineering (WBL)', 3, '2024/2025-1', 'L001', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_registration`
--

CREATE TABLE `tb_registration` (
  `r_tid` int(11) NOT NULL COMMENT 'This is the transcation id',
  `r_student` varchar(10) NOT NULL,
  `r_course` varchar(10) NOT NULL,
  `r_sem` varchar(11) NOT NULL,
  `r_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `tb_status`
--

CREATE TABLE `tb_status` (
  `s_id` int(11) NOT NULL,
  `s_decs` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_status`
--

INSERT INTO `tb_status` (`s_id`, `s_decs`) VALUES
(1, 'Received'),
(2, 'Approved'),
(3, 'Rejected'),
(4, 'Cancelled');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `u_sno` varchar(10) NOT NULL,
  `u_pwd` varchar(255) NOT NULL,
  `u_email` varchar(30) NOT NULL,
  `u_name` varchar(50) NOT NULL,
  `u_contact` int(11) NOT NULL,
  `u_state` varchar(20) NOT NULL,
  `u_registration` date DEFAULT NULL,
  `u_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`u_sno`, `u_pwd`, `u_email`, `u_name`, `u_contact`, `u_state`, `u_registration`, `u_type`) VALUES
('I001', '$2y$10$Xd4OvNi/lsmaPPT8YImdVO/mL7dezbaekDkExSV4vZIkJA3/1tfHG', 'itstaff@gmail.com', 'Ahmad bin Abu', 123456789, 'Johor', '2025-01-26', 3),
('I002', '$2y$10$RadiVBmQZticGFZaFa3soORSQ50ueu0wRspVjzAQZCulfz.HzRXke', 'adam@gmail.com', 'Adam Abdul', 123456789, 'Johor', '2025-01-01', 3),
('L001', '$2y$10$hHt4QzMRLnQJ.sBv4p8/B.IzFgH7jM.nlXFSxCW.m3aqUpBp8.L8e', 'aina@gmail.com', 'Aina Abdul', 191111111, 'Johor', '2023-06-22', 1),
('L002', '$2y$10$3eyz26Pp/axzNTCRFc7QYu8cPi5Nb0xDFISJt/gjH3BfvGunrrEi.', 'faz@gmail.com', 'Fazura Abdul', 172222222, 'Kelantan', '2024-01-22', 1),
('S001', '$2y$10$/sffeOe262m8ILS8hQ.uiuMuDAJ/TT3ARPS7UCq9kEqjNUXl/iVia', 'fat@gmail.com', 'Fatah Abdul', 133333333, 'Melaka', '2023-11-08', 2),
('S002', '$2y$10$AUkMSGd33cSV.vJpIBkgPOJZ0YWJiGGXmW7DBNzsNyf4oK25PGGXC', 'kam@gmail.com', 'Kamarul Abdul', 124444444, 'Selangor', '2024-10-30', 2),
('S003', '$2y$10$XOAvTgRkrBO22JSOmFzl.uob8nRGry2Fro9VrcJUuj1tun286M6fq', 'fatimah@gmail.com', 'Fatimah Abdul', 123456789, 'Pulau Pinang', '2025-01-27', 2),
('S004', '$2y$10$PNK6YWTPAXb61GLg7hMP8.wDVPfe9xKaYncCsTK85Qo4fKMT9PX8e', 'filza@gmail.com', 'Filza Abdul', 167846693, 'Sabah', '2025-01-27', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tb_utype`
--

CREATE TABLE `tb_utype` (
  `t_id` int(11) NOT NULL,
  `t_desc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_utype`
--

INSERT INTO `tb_utype` (`t_id`, `t_desc`) VALUES
(1, 'Lecturer'),
(2, 'Student'),
(3, 'IT Staff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_course`
--
ALTER TABLE `tb_course`
  ADD PRIMARY KEY (`c_code`,`c_sem`),
  ADD KEY `tb_course_ibfk_1` (`c_lec`);

--
-- Indexes for table `tb_registration`
--
ALTER TABLE `tb_registration`
  ADD PRIMARY KEY (`r_tid`),
  ADD KEY `r_student` (`r_student`),
  ADD KEY `r_course` (`r_course`),
  ADD KEY `r_status` (`r_status`);

--
-- Indexes for table `tb_status`
--
ALTER TABLE `tb_status`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`u_sno`),
  ADD KEY `u_type` (`u_type`);

--
-- Indexes for table `tb_utype`
--
ALTER TABLE `tb_utype`
  ADD PRIMARY KEY (`t_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_registration`
--
ALTER TABLE `tb_registration`
  MODIFY `r_tid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'This is the transcation id';

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_course`
--
ALTER TABLE `tb_course`
  ADD CONSTRAINT `tb_course_ibfk_1` FOREIGN KEY (`c_lec`) REFERENCES `tb_user` (`u_sno`);

--
-- Constraints for table `tb_registration`
--
ALTER TABLE `tb_registration`
  ADD CONSTRAINT `tb_registration_ibfk_1` FOREIGN KEY (`r_student`) REFERENCES `tb_user` (`u_sno`),
  ADD CONSTRAINT `tb_registration_ibfk_2` FOREIGN KEY (`r_course`) REFERENCES `tb_course` (`c_code`),
  ADD CONSTRAINT `tb_registration_ibfk_3` FOREIGN KEY (`r_status`) REFERENCES `tb_status` (`s_id`);

--
-- Constraints for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD CONSTRAINT `tb_user_ibfk_1` FOREIGN KEY (`u_type`) REFERENCES `tb_utype` (`t_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
