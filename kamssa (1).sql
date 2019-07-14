-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 14, 2019 at 10:12 PM
-- Server version: 5.7.23-0ubuntu0.18.04.1
-- PHP Version: 7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kamssa`
--

-- --------------------------------------------------------

--
-- Table structure for table `A_level_students`
--

CREATE TABLE `A_level_students` (
  `id` int(5) NOT NULL,
  `school_id` int(5) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `second_name` varchar(50) NOT NULL,
  `index_no` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `A_level_students`
--

INSERT INTO `A_level_students` (`id`, `school_id`, `first_name`, `second_name`, `index_no`) VALUES
(2, 29, 'Julia', 'Micheals', '1233/66'),
(3, 20, 'Kiberu', 'Alex', 'Mi4354'),
(4, 20, 'Julia', 'sendi', '1233/66'),
(5, 30, 'Marvin', 'Sendikaddiwa', '45545');

-- --------------------------------------------------------

--
-- Table structure for table `A_level_student_marks`
--

CREATE TABLE `A_level_student_marks` (
  `id` int(5) NOT NULL,
  `subject_paper_id` int(5) NOT NULL,
  `marks` double(5,2) NOT NULL DEFAULT '0.00',
  `student_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `A_level_student_marks`
--

INSERT INTO `A_level_student_marks` (`id`, `subject_paper_id`, `marks`, `student_id`) VALUES
(11, 2, 90.00, 2),
(12, 3, 77.00, 2),
(13, 4, 55.00, 2),
(18, 8, 0.00, 3),
(20, 9, 0.00, 3),
(21, 11, 0.00, 3),
(22, 10, 0.00, 3),
(23, 12, 0.00, 3),
(24, 1, 0.00, 4),
(25, 1, 75.00, 5),
(26, 58, 77.00, 5),
(27, 59, 77.00, 5),
(28, 37, 77.00, 5),
(29, 38, 77.00, 5),
(30, 39, 70.00, 5),
(31, 43, 80.00, 5),
(32, 44, 70.00, 5),
(33, 45, 85.00, 5),
(34, 35, 90.00, 5),
(35, 36, 80.00, 5);

-- --------------------------------------------------------

--
-- Table structure for table `A_level_subejcts`
--

CREATE TABLE `A_level_subejcts` (
  `id` int(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `subject_code` varchar(20) NOT NULL,
  `is_core` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `A_level_subejcts`
--

INSERT INTO `A_level_subejcts` (`id`, `name`, `subject_code`, `is_core`) VALUES
(1, 'General paper', '', '1'),
(2, 'History', '', '0'),
(3, 'Economics', '', '0'),
(4, 'Entrepreneurship Educ.', '', '0'),
(5, 'Islamic Religious Educ.', '', '0'),
(6, 'Christian Religious Educ.', '', '0'),
(7, 'Geography', '', '0'),
(8, 'Literature in English', '', '0'),
(9, 'Kiswahili', '', '0'),
(10, 'Luganda', '', '0'),
(11, 'Mathematics', '', '0'),
(12, 'Physics', '', '0'),
(13, 'Agriculture', '', '0'),
(14, 'Chemistry', '', '0'),
(15, 'Biology', '', '0'),
(16, 'Fine Art', '', '0'),
(17, 'Arabic', '', '0'),
(18, 'Sub math', '', '1'),
(19, 'Sub ICT', '', '1');

-- --------------------------------------------------------

--
-- Table structure for table `A_level_subejcts_papers`
--

CREATE TABLE `A_level_subejcts_papers` (
  `id` int(5) NOT NULL,
  `subject_id` int(5) NOT NULL,
  `paper_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `A_level_subejcts_papers`
--

INSERT INTO `A_level_subejcts_papers` (`id`, `subject_id`, `paper_code`) VALUES
(1, 1, 'Paper 1'),
(2, 2, 'paper 1'),
(3, 2, 'Paper 2'),
(4, 2, 'Paper 3'),
(5, 2, 'Paper 4'),
(6, 2, 'Paper 5'),
(7, 2, 'Paper 6'),
(8, 3, 'Paper 1'),
(9, 3, 'Paper 2'),
(10, 4, 'Paper 1'),
(11, 4, 'Paper 2'),
(12, 4, 'Paper 3'),
(13, 5, 'Paper 1'),
(14, 5, 'Paper 2'),
(15, 5, 'Paper 3'),
(16, 5, 'Paper 4'),
(17, 6, 'Paper 1'),
(18, 6, 'Paper 2'),
(19, 6, 'Paper 3'),
(20, 6, 'Paper 4'),
(21, 6, 'Paper 5'),
(22, 6, 'Paper 6'),
(23, 7, 'Paper 1'),
(24, 7, 'Paper 2'),
(25, 7, 'Paper 3'),
(26, 8, 'Paper 1'),
(27, 8, 'Paper 2'),
(28, 8, 'Paper 3'),
(29, 9, 'Paper 1'),
(30, 9, 'Paper 2'),
(31, 9, 'Paper 3'),
(32, 10, 'Paper 1'),
(33, 10, 'Paper 2'),
(34, 10, 'Paper 3'),
(35, 11, 'Paper 1'),
(36, 11, 'Paper 2'),
(37, 12, 'Paper 1'),
(38, 12, 'Paper 2'),
(39, 12, 'Paper 3'),
(40, 13, 'Paper 1'),
(41, 13, 'Paper 2'),
(42, 13, 'Paper 3'),
(43, 14, 'Paper 1'),
(44, 14, 'Paper 2'),
(45, 14, 'Paper 3'),
(46, 15, 'Paper 1'),
(47, 15, 'Paper 2'),
(48, 16, 'Paper 1'),
(49, 16, 'Paper 2'),
(50, 16, 'Paper 3'),
(51, 16, 'Paper 4'),
(52, 16, 'Paper 5'),
(53, 16, 'Paper 6'),
(54, 17, 'paper 1'),
(55, 17, 'Paper 2'),
(56, 17, 'Paper 3'),
(57, 18, 'paper 1'),
(58, 19, 'paper 1'),
(59, 19, 'Paper 2');

-- --------------------------------------------------------

--
-- Table structure for table `o_level_optionals`
--

CREATE TABLE `o_level_optionals` (
  `id` int(5) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `full_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `o_level_optionals`
--

INSERT INTO `o_level_optionals` (`id`, `subject`, `full_name`) VALUES
(1, 'commerce', 'Commerce'),
(2, 'cre', 'Christian Religious Education'),
(3, 'ent', 'Entreprenurship'),
(4, 'fine_art', 'FIne Art'),
(5, 'agric', 'Agriculture'),
(6, 'luganda', 'Luganda'),
(7, 'lit', 'Litereature'),
(8, 'ire', 'Islamic Religious Education'),
(9, 'computer', 'Computer Studies');

-- --------------------------------------------------------

--
-- Table structure for table `o_level_students`
--

CREATE TABLE `o_level_students` (
  `id` int(5) NOT NULL,
  `school_id` int(5) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `second_name` varchar(50) NOT NULL,
  `index_no` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `o_level_students`
--

INSERT INTO `o_level_students` (`id`, `school_id`, `first_name`, `second_name`, `index_no`) VALUES
(4, 25, 'Arthur', 'Bukenya', '10324/55'),
(5, 28, 'Marvin', 'Sendikaddiwa', '19324'),
(6, 20, 'Obbo', 'Peter', 'udfpof'),
(8, 29, 'Joew', 'Hamish', '345/6677');

-- --------------------------------------------------------

--
-- Table structure for table `o_level_student_marks`
--

CREATE TABLE `o_level_student_marks` (
  `id` int(5) NOT NULL,
  `subject_paper_id` int(5) NOT NULL,
  `marks` double(5,2) NOT NULL DEFAULT '0.00',
  `student_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `o_level_student_marks`
--

INSERT INTO `o_level_student_marks` (`id`, `subject_paper_id`, `marks`, `student_id`) VALUES
(1, 3, 56.00, 5),
(2, 4, 70.00, 5),
(3, 1, 67.00, 4),
(4, 2, 87.00, 4),
(5, 1, 49.00, 2),
(6, 2, 53.00, 2),
(7, 3, 66.00, 2),
(8, 4, 77.00, 2),
(9, 1, 67.00, 5),
(10, 2, 45.00, 5),
(11, 5, 88.00, 5),
(12, 6, 87.00, 5),
(13, 7, 63.00, 5),
(14, 4, 35.00, 4),
(15, 3, 86.00, 4),
(16, 5, 69.00, 4),
(17, 6, 56.00, 4),
(18, 7, 48.00, 4),
(19, 8, 64.00, 4),
(20, 9, 97.00, 4),
(21, 11, 86.00, 4),
(22, 16, 45.00, 4),
(23, 17, 63.00, 4),
(24, 19, 35.00, 4),
(25, 20, 74.00, 4),
(26, 21, 44.00, 4),
(33, 3, 100.00, 6),
(34, 12, 0.00, 4),
(35, 13, 0.00, 4),
(36, 14, 0.00, 4),
(37, 1, 99.00, 8),
(38, 2, 99.00, 8),
(39, 3, 99.00, 8),
(40, 4, 100.00, 8),
(41, 5, 99.00, 8),
(42, 6, 99.00, 8),
(43, 8, 99.00, 8),
(44, 9, 99.00, 8),
(45, 10, 99.00, 8),
(46, 12, 99.00, 8),
(47, 13, 99.00, 8),
(48, 14, 99.00, 8),
(49, 16, 99.00, 8),
(50, 17, 99.00, 8),
(51, 19, 99.00, 8),
(52, 20, 99.00, 8),
(53, 21, 100.00, 8),
(54, 22, 100.00, 8),
(55, 55, 99.00, 8);

-- --------------------------------------------------------

--
-- Table structure for table `o_level_subejcts`
--

CREATE TABLE `o_level_subejcts` (
  `id` int(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `subject_code` varchar(20) NOT NULL,
  `is_core` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `o_level_subejcts`
--

INSERT INTO `o_level_subejcts` (`id`, `name`, `subject_code`, `is_core`) VALUES
(1, 'English', '', '1'),
(2, 'Mathematics', '', '1'),
(3, 'Biology', '', '1'),
(4, 'Physics', '', '1'),
(5, 'Chemistry', '', '1'),
(6, 'History', '', '1'),
(7, 'Geography', '', '1'),
(8, 'Commerce', '', '0'),
(9, 'Christian Religious Education', '', '0'),
(10, 'Entrepreneurship Educ', '', '0'),
(11, 'Fine Art', '', '0'),
(12, 'Agric', '', '0'),
(13, 'Luganda', '', '0'),
(14, 'Lusoga', '', '0'),
(15, 'Lunyakyitara', '', '0'),
(16, 'Swahilli', '', '0'),
(17, 'French', '', '0'),
(18, 'Arabic', '', '0'),
(19, 'Litereature', '', '0'),
(20, 'Islamic Religious Education', '', '0'),
(21, 'Computer Studies', '', '0'),
(22, 'Accounts', '', '0'),
(23, 'Clothing\'s and Textiles', '', '0'),
(24, 'Food and Nutrition', '', '0'),
(25, 'Lugunbara T', '', '0');

-- --------------------------------------------------------

--
-- Table structure for table `o_level_subejcts_papers`
--

CREATE TABLE `o_level_subejcts_papers` (
  `id` int(5) NOT NULL,
  `subject_id` int(5) NOT NULL,
  `paper_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `o_level_subejcts_papers`
--

INSERT INTO `o_level_subejcts_papers` (`id`, `subject_id`, `paper_code`) VALUES
(1, 1, 'Paper 1'),
(2, 1, 'Paper 2'),
(3, 2, 'Paper 1'),
(4, 2, 'Paper 2'),
(5, 3, 'Paper 1'),
(6, 3, 'Paper 2'),
(7, 3, 'Paper 3'),
(8, 4, 'Paper 1'),
(9, 4, 'Paper 2'),
(10, 4, 'Paper 3'),
(11, 4, 'Paper 4'),
(12, 5, 'Paper 1'),
(13, 5, 'Paper 2'),
(14, 5, 'Paper 3'),
(15, 5, 'Paper 4'),
(16, 6, 'Paper 1'),
(17, 6, 'Paper 2'),
(18, 6, 'Paper 4'),
(19, 7, 'Paper 1'),
(20, 7, 'Paper 2'),
(21, 8, 'Paper 1'),
(22, 9, 'Paper 1'),
(23, 10, 'Paper 1'),
(24, 10, 'Paper 2'),
(25, 11, 'Paper 1'),
(26, 11, 'Paper 2'),
(27, 11, 'Paper 3'),
(28, 11, 'Paper 4'),
(29, 12, 'Paper 1'),
(30, 12, 'Paper 2'),
(31, 13, 'Paper 1'),
(32, 13, 'Paper 2'),
(33, 14, 'Paper 1'),
(34, 14, 'Paper 2'),
(35, 15, 'Paper 1'),
(36, 15, 'Paper 2'),
(37, 16, 'Paper 1'),
(38, 17, 'Paper 1'),
(39, 17, 'Paper 2'),
(40, 17, 'Paper 3'),
(41, 18, 'Paper 1'),
(42, 18, 'Paper 2'),
(43, 19, 'Paper 1'),
(44, 20, 'Paper 1'),
(45, 20, 'Paper 2'),
(46, 21, 'Paper 1'),
(47, 21, 'Paper 2'),
(48, 22, 'paper 1'),
(49, 23, 'Paper 1'),
(50, 23, 'Paper 2'),
(53, 24, 'Paper 1'),
(54, 24, 'Paper 2'),
(55, 9, 'Paper 2'),
(56, 25, 'Paper 1'),
(57, 25, 'Paper 2');

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `id` int(5) NOT NULL,
  `name` varchar(500) NOT NULL,
  `no_of_students` int(5) NOT NULL,
  `district` varchar(100) NOT NULL,
  `center_no` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `name`, `no_of_students`, `district`, `center_no`) VALUES
(20, 'Mita kawempe', 55, 'kololo', '44545'),
(25, 'Makerere college', 55, 'kololo', '44545'),
(26, 'Kololo high school', 55, 'kololo', '44545'),
(27, 'Awayita omu', 55, 'kololo', '44545'),
(28, 'Bat vallry', 55, 'kololo', '44545'),
(29, 'Kaboja', 55, 'kololo', '44545'),
(30, 'Kitante Hill School', 78, 'kampala', '566/44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(5) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `password` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `password`) VALUES
(1, 'admin', 'admin123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `A_level_students`
--
ALTER TABLE `A_level_students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `A_level_student_marks`
--
ALTER TABLE `A_level_student_marks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `A_level_subejcts`
--
ALTER TABLE `A_level_subejcts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `A_level_subejcts_papers`
--
ALTER TABLE `A_level_subejcts_papers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `o_level_optionals`
--
ALTER TABLE `o_level_optionals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `o_level_students`
--
ALTER TABLE `o_level_students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `o_level_student_marks`
--
ALTER TABLE `o_level_student_marks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `o_level_subejcts`
--
ALTER TABLE `o_level_subejcts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `o_level_subejcts_papers`
--
ALTER TABLE `o_level_subejcts_papers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `A_level_students`
--
ALTER TABLE `A_level_students`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `A_level_student_marks`
--
ALTER TABLE `A_level_student_marks`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `A_level_subejcts`
--
ALTER TABLE `A_level_subejcts`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `A_level_subejcts_papers`
--
ALTER TABLE `A_level_subejcts_papers`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT for table `o_level_students`
--
ALTER TABLE `o_level_students`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `o_level_student_marks`
--
ALTER TABLE `o_level_student_marks`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT for table `o_level_subejcts`
--
ALTER TABLE `o_level_subejcts`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `o_level_subejcts_papers`
--
ALTER TABLE `o_level_subejcts_papers`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
