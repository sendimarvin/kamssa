-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2019 at 12:44 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.20

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
-- Table structure for table `a_level_combinations`
--

CREATE TABLE `a_level_combinations` (
  `id` int(5) NOT NULL,
  `combination` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `a_level_combinations`
--

INSERT INTO `a_level_combinations` (`id`, `combination`) VALUES
(1, 'PCM / ICT'),
(2, 'PEM / ICT'),
(5, 'MEE / ENT'),
(6, 'HEG');

-- --------------------------------------------------------

--
-- Table structure for table `a_level_students`
--

CREATE TABLE `a_level_students` (
  `id` int(5) NOT NULL,
  `school_id` int(5) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `second_name` varchar(50) NOT NULL,
  `index_no` varchar(50) NOT NULL,
  `combination_id` int(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `a_level_students`
--

INSERT INTO `a_level_students` (`id`, `school_id`, `first_name`, `second_name`, `index_no`, `combination_id`) VALUES
(12, 30, 'Marvin', 'Sendikaddiwa', 'u0030/582', 1),
(13, 30, 'Peter', 'Blessed', 'uoo75/34', 2);

-- --------------------------------------------------------

--
-- Table structure for table `a_level_student_marks`
--

CREATE TABLE `a_level_student_marks` (
  `id` int(5) NOT NULL,
  `subject_paper_id` int(5) NOT NULL,
  `marks` double(5,2) NOT NULL DEFAULT '0.00',
  `student_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `a_level_student_marks`
--

INSERT INTO `a_level_student_marks` (`id`, `subject_paper_id`, `marks`, `student_id`) VALUES
(60, 1, 79.23, 12),
(61, 37, 43.37, 12),
(62, 38, 79.18, 12),
(63, 39, 65.78, 12),
(64, 43, 91.37, 12),
(65, 44, 59.49, 12),
(66, 45, 23.34, 12),
(67, 35, 38.25, 12),
(68, 36, 21.24, 12),
(69, 58, 91.43, 12),
(70, 59, 93.43, 12),
(71, 1, 92.86, 13),
(72, 58, 84.03, 13),
(73, 59, 41.55, 13),
(74, 37, 55.67, 13),
(75, 38, 53.68, 13),
(76, 39, 1.40, 13),
(77, 8, 45.96, 13),
(78, 9, 25.58, 13),
(79, 35, 90.05, 13),
(80, 36, 73.50, 13);

-- --------------------------------------------------------

--
-- Table structure for table `a_level_subejcts`
--

CREATE TABLE `a_level_subejcts` (
  `id` int(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `subject_code` varchar(20) NOT NULL,
  `is_core` enum('0','1','2') NOT NULL DEFAULT '0',
  `no_of_papers_done` int(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `a_level_subejcts`
--

INSERT INTO `a_level_subejcts` (`id`, `name`, `subject_code`, `is_core`, `no_of_papers_done`) VALUES
(1, 'General paper', '', '2', 1),
(2, 'History', '', '0', 2),
(3, 'Economics', '', '0', 2),
(4, 'Entrepreneurship Educ.', '', '0', 2),
(5, 'Islamic Religious Educ.', '', '0', 2),
(6, 'Christian Religious Educ.', '', '0', 2),
(7, 'Geography', '', '0', 2),
(8, 'Literature in English', '', '0', 2),
(9, 'Kiswahili', '', '0', 2),
(10, 'Luganda', '', '0', 2),
(11, 'Mathematics', '', '0', 2),
(12, 'Physics', '', '0', 3),
(13, 'Agriculture', '', '0', 2),
(14, 'Chemistry', '', '0', 3),
(15, 'Biology', '', '0', 2),
(16, 'Fine Art', '', '0', 2),
(17, 'Arabic', '', '0', 2),
(18, 'Sub math', '', '1', 2),
(19, 'Sub ICT', '', '1', 2),
(20, 'Tailoring', 'tr', '1', 2);

-- --------------------------------------------------------

--
-- Table structure for table `a_level_subejcts_papers`
--

CREATE TABLE `a_level_subejcts_papers` (
  `id` int(5) NOT NULL,
  `subject_id` int(5) NOT NULL,
  `paper_code` varchar(20) NOT NULL,
  `is_default` enum('0','1') NOT NULL DEFAULT '0',
  `paper_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `a_level_subejcts_papers`
--

INSERT INTO `a_level_subejcts_papers` (`id`, `subject_id`, `paper_code`, `is_default`, `paper_name`) VALUES
(1, 1, 'Paper 1', '0', ''),
(2, 2, 'paper 1', '0', ''),
(3, 2, 'Paper 2', '0', ''),
(4, 2, 'Paper 3', '0', ''),
(5, 2, 'Paper 4', '0', ''),
(6, 2, 'Paper 5', '0', ''),
(7, 2, 'Paper 6', '0', ''),
(8, 3, 'Paper 1', '0', ''),
(9, 3, 'Paper 2', '0', ''),
(10, 4, 'Paper 1', '0', ''),
(11, 4, 'Paper 2', '0', ''),
(12, 4, 'Paper 3', '0', ''),
(13, 5, 'Paper 1', '0', ''),
(14, 5, 'Paper 2', '0', ''),
(15, 5, 'Paper 3', '0', ''),
(16, 5, 'Paper 4', '0', ''),
(17, 6, 'Paper 1', '0', ''),
(18, 6, 'Paper 2', '0', ''),
(19, 6, 'Paper 3', '0', ''),
(20, 6, 'Paper 4', '0', ''),
(21, 6, 'Paper 5', '0', ''),
(22, 6, 'Paper 6', '0', ''),
(23, 7, 'Paper 1', '0', ''),
(24, 7, 'Paper 2', '0', ''),
(25, 7, 'Paper 3', '0', ''),
(26, 8, 'Paper 1', '0', ''),
(27, 8, 'Paper 2', '0', ''),
(28, 8, 'Paper 3', '0', ''),
(29, 9, 'Paper 1', '0', ''),
(30, 9, 'Paper 2', '0', ''),
(31, 9, 'Paper 3', '0', ''),
(32, 10, 'Paper 1', '0', ''),
(33, 10, 'Paper 2', '0', ''),
(34, 10, 'Paper 3', '0', ''),
(35, 11, 'Paper 1', '0', ''),
(36, 11, 'Paper 2', '0', ''),
(37, 12, 'Paper 1', '0', ''),
(38, 12, 'Paper 2', '0', ''),
(39, 12, 'Paper 3', '0', ''),
(40, 13, 'Paper 1', '0', ''),
(41, 13, 'Paper 2', '0', ''),
(42, 13, 'Paper 3', '0', ''),
(43, 14, 'Paper 1', '0', ''),
(44, 14, 'Paper 2', '0', ''),
(45, 14, 'Paper 3', '0', ''),
(46, 15, 'Paper 1', '0', ''),
(47, 15, 'Paper 2', '0', ''),
(48, 16, 'Paper 1', '0', ''),
(49, 16, 'Paper 2', '0', ''),
(50, 16, 'Paper 3', '0', ''),
(51, 16, 'Paper 4', '0', ''),
(52, 16, 'Paper 5', '0', ''),
(53, 16, 'Paper 6', '0', ''),
(54, 17, 'paper 1', '0', ''),
(55, 17, 'Paper 2', '0', ''),
(56, 17, 'Paper 3', '0', ''),
(57, 18, 'paper 1', '0', 'trytry'),
(58, 19, 'paper 1', '0', ''),
(59, 19, 'Paper 2', '0', ''),
(60, 20, 'paiyyu', '1', 'uiuyiyui'),
(61, 20, 'uyiyu', '1', 'iuyuiyu');

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
(4, 20, 'Arthur', 'Bukenya', '10324/55'),
(5, 20, 'Marvin', 'Sendikaddiwa', '19324'),
(6, 20, 'Obbo', 'Peter', 'udfpof'),
(8, 20, 'Joew', 'Hamish', '345/6677'),
(9, 20, 'df', 'fdc', '54'),
(10, 28, 'joew', 'kimera', 'wrer5'),
(11, 20, 'Davis', 'Wabulika', '10324/55'),
(12, 28, '653', '54', '435'),
(13, 28, '653', '54', '435'),
(14, 28, '653', '54', '435'),
(15, 30, 'Njako', 'Samuel', '5656');

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
(1, 3, 75.00, 5),
(3, 1, 56.45, 4),
(4, 2, 31.95, 4),
(5, 1, 90.37, 2),
(6, 2, 56.03, 2),
(7, 3, 9.03, 2),
(8, 4, 77.05, 2),
(9, 1, 100.00, 5),
(10, 2, 88.00, 5),
(11, 5, 84.00, 5),
(12, 6, 83.00, 5),
(13, 7, 74.00, 5),
(14, 4, 11.72, 4),
(15, 3, 80.67, 4),
(16, 5, 68.19, 4),
(17, 6, 98.92, 4),
(18, 7, 90.05, 4),
(19, 8, 53.50, 4),
(20, 9, 97.34, 4),
(21, 11, 26.21, 4),
(22, 16, 39.03, 4),
(23, 17, 16.50, 4),
(24, 19, 65.41, 4),
(25, 20, 77.56, 4),
(26, 21, 91.55, 4),
(33, 3, 25.09, 6),
(34, 12, 50.81, 4),
(35, 13, 78.75, 4),
(36, 14, 41.34, 4),
(37, 1, 70.47, 8),
(38, 2, 28.30, 8),
(39, 3, 30.09, 8),
(40, 4, 65.56, 8),
(41, 5, 37.53, 8),
(42, 6, 90.98, 8),
(43, 8, 42.32, 8),
(44, 9, 38.64, 8),
(45, 10, 66.25, 8),
(46, 12, 15.34, 8),
(47, 13, 77.95, 8),
(48, 14, 43.73, 8),
(49, 16, 84.80, 8),
(50, 17, 92.79, 8),
(51, 19, 9.56, 8),
(52, 20, 69.44, 8),
(53, 21, 18.50, 8),
(54, 22, 84.19, 8),
(55, 55, 65.46, 8),
(56, 1, 74.73, 9),
(57, 2, 77.25, 9),
(58, 12, 62.08, 9),
(59, 13, 78.64, 9),
(60, 14, 6.95, 9),
(61, 3, 98.82, 9),
(62, 4, 73.28, 9),
(63, 5, 69.91, 9),
(64, 6, 29.72, 9),
(65, 7, 38.86, 9),
(66, 8, 5.16, 9),
(67, 9, 9.22, 9),
(68, 10, 30.63, 9),
(69, 16, 25.47, 9),
(70, 17, 35.49, 9),
(71, 19, 1.01, 9),
(72, 20, 98.58, 9),
(73, 1, 89.90, 10),
(74, 2, 53.73, 10),
(75, 3, 98.95, 10),
(76, 4, 33.55, 10),
(77, 6, 70.90, 10),
(78, 7, 53.85, 10),
(79, 8, 56.57, 10),
(80, 9, 21.31, 10),
(81, 10, 36.82, 10),
(82, 12, 20.19, 10),
(83, 13, 90.46, 10),
(84, 14, 91.76, 10),
(85, 16, 87.40, 10),
(86, 17, 61.72, 10),
(87, 19, 46.40, 10),
(88, 20, 46.85, 10),
(89, 58, 95.03, 6),
(90, 59, 34.60, 10),
(91, 60, 87.90, 4),
(92, 56, 35.70, 6),
(93, 57, 14.81, 6),
(94, 0, 66.95, 12),
(95, 0, 90.34, 12),
(96, 0, 50.83, 12),
(97, 0, 83.15, 12),
(98, 0, 63.26, 12),
(99, 0, 66.83, 12),
(100, 0, 44.38, 12),
(101, 0, 21.43, 12),
(102, 0, 73.98, 12),
(103, 0, 5.64, 12),
(104, 0, 6.25, 12),
(105, 0, 14.35, 12),
(106, 0, 52.97, 12),
(107, 0, 21.83, 12),
(108, 0, 50.21, 12),
(109, 0, 85.57, 12),
(110, 0, 77.22, 12),
(111, 0, 29.39, 13),
(112, 0, 15.29, 13),
(113, 0, 88.27, 13),
(114, 0, 95.47, 13),
(115, 0, 12.55, 13),
(116, 0, 76.32, 13),
(117, 0, 43.97, 13),
(118, 0, 90.88, 13),
(119, 0, 22.48, 13),
(120, 0, 39.76, 13),
(121, 0, 31.37, 13),
(122, 0, 37.56, 13),
(123, 0, 93.71, 13),
(124, 0, 55.86, 13),
(125, 0, 98.18, 13),
(126, 0, 23.31, 13),
(127, 0, 22.02, 13),
(128, 1, 40.16, 14),
(129, 2, 34.74, 14),
(130, 3, 53.21, 14),
(131, 4, 61.82, 14),
(132, 5, 49.48, 14),
(133, 6, 61.95, 14),
(134, 7, 61.32, 14),
(135, 8, 20.76, 14),
(136, 9, 19.82, 14),
(137, 10, 36.84, 14),
(138, 12, 24.74, 14),
(139, 13, 13.18, 14),
(140, 14, 91.66, 14),
(141, 16, 18.76, 14),
(142, 17, 18.83, 14),
(143, 19, 37.88, 14),
(144, 20, 32.91, 14),
(145, 1, 0.00, 15),
(146, 2, 0.00, 15),
(147, 3, 0.00, 15),
(148, 4, 0.00, 15),
(149, 5, 0.00, 15),
(150, 6, 0.00, 15),
(151, 7, 0.00, 15),
(152, 8, 6.53, 15),
(153, 9, 0.00, 15),
(154, 10, 0.00, 15),
(155, 12, 0.00, 15),
(156, 13, 0.00, 15),
(157, 14, 0.00, 15),
(158, 16, 0.00, 15),
(159, 17, 0.00, 15),
(160, 19, 0.00, 15),
(161, 20, 0.00, 15),
(162, 22, 0.00, 15),
(163, 55, 0.00, 15),
(164, 23, 0.00, 15),
(165, 24, 0.00, 15),
(166, 4, 49.00, 5),
(167, 8, 0.00, 5),
(168, 9, 0.00, 5),
(169, 10, 0.00, 5),
(170, 12, 0.00, 5),
(171, 13, 0.00, 5),
(172, 14, 0.00, 5),
(173, 16, 0.00, 5),
(174, 17, 0.00, 5),
(176, 19, 0.00, 5),
(177, 20, 0.00, 5),
(178, 21, 0.00, 5);

-- --------------------------------------------------------

--
-- Table structure for table `o_level_subejcts`
--

CREATE TABLE `o_level_subejcts` (
  `id` int(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `subject_code` varchar(20) NOT NULL,
  `is_core` enum('0','1') NOT NULL DEFAULT '0',
  `no_of_papers_done` tinyint(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `o_level_subejcts`
--

INSERT INTO `o_level_subejcts` (`id`, `name`, `subject_code`, `is_core`, `no_of_papers_done`) VALUES
(1, 'English', 'tyty', '1', 2),
(2, 'Mathematics', 'mth', '1', 2),
(3, 'Biology', 'hgh', '1', 3),
(4, 'Physics', 'ytyt', '1', 3),
(5, 'Chemistry', 'tr', '1', 3),
(6, 'History', 'hg', '1', 2),
(7, 'Geography', 'hg', '1', 2),
(8, 'Commerce', 'h', '0', 1),
(9, 'Christian Religious Education', 'bn', '0', 2),
(10, 'Entrepreneurship Educ', 'nb', '0', 2),
(11, 'Fine Art', 'ghhg', '0', 3),
(12, 'Agric', 'jh', '0', 2),
(13, 'Luganda', 'hg', '0', 2),
(14, 'Lusoga', 'nb', '0', 2),
(15, 'Lunyakyitara', '', '0', 1),
(17, 'French', '', '0', 1),
(18, 'Arabic', '', '0', 1),
(19, 'Litereature', '', '0', 1),
(21, 'Computer Studies', '', '0', 1),
(22, 'Accounts', '', '0', 1),
(23, 'Clothing''s and Textiles', '', '0', 1);

-- --------------------------------------------------------

--
-- Table structure for table `o_level_subejcts_papers`
--

CREATE TABLE `o_level_subejcts_papers` (
  `id` int(5) NOT NULL,
  `subject_id` int(5) NOT NULL,
  `paper_code` varchar(20) NOT NULL,
  `is_default` enum('0','1') NOT NULL DEFAULT '0',
  `paper_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `o_level_subejcts_papers`
--

INSERT INTO `o_level_subejcts_papers` (`id`, `subject_id`, `paper_code`, `is_default`, `paper_name`) VALUES
(1, 1, 'Paper 1', '1', 'yt'),
(2, 1, 'Paper 2', '1', 'yt'),
(3, 2, 'Paper 1', '1', 'df'),
(4, 2, 'Paper 2', '1', 'df'),
(5, 3, 'Paper 1', '1', 'df'),
(6, 3, 'Paper 2', '1', 'df'),
(7, 3, 'Paper 3', '1', 'df'),
(8, 4, 'Paper 1', '1', 'fd'),
(9, 4, 'Paper 2', '1', 'fd'),
(10, 4, 'Paper 3', '1', 'df'),
(11, 4, 'Paper 4', '0', ''),
(12, 5, 'Paper 1', '1', 'df'),
(13, 5, 'Paper 2', '1', 'df'),
(14, 5, 'Paper 3', '1', 'fd'),
(15, 5, 'Paper 4', '0', ''),
(16, 6, 'Paper 1', '1', 'df'),
(17, 6, 'Paper 2', '1', 'fd'),
(18, 6, 'Paper 4', '0', ''),
(19, 7, 'Paper 1', '1', 'fd'),
(20, 7, 'Paper 2', '1', 'fd'),
(21, 8, 'Paper 1', '1', 'new'),
(22, 9, 'Paper 1', '1', 'fd'),
(23, 10, 'Paper 1', '1', 'fd'),
(24, 10, 'Paper 2', '1', 'fd'),
(25, 11, 'Paper 1', '1', 'fd'),
(26, 11, 'Paper 2', '1', 'fd'),
(27, 11, 'Paper 3', '1', 'fd'),
(28, 11, 'Paper 4', '0', ''),
(29, 12, 'Paper 1', '1', 'fd'),
(30, 12, 'Paper 2', '1', 'fd'),
(31, 13, 'Paper 1', '1', 'fd'),
(32, 13, 'Paper 2', '0', ''),
(33, 14, 'Paper 1', '1', 'fd'),
(34, 14, 'Paper 2', '1', 'fd'),
(35, 15, 'Paper 1', '1', 'fd'),
(36, 15, 'Paper 2', '1', 'fd'),
(38, 17, 'Paper 1', '1', 'fd'),
(39, 17, 'Paper 2', '1', 'fd'),
(40, 17, 'Paper 3', '0', ''),
(41, 18, 'Paper 1', '0', ''),
(42, 18, 'Paper 2', '0', ''),
(43, 19, 'Paper 1', '0', ''),
(46, 21, 'Paper 1', '0', ''),
(47, 21, 'Paper 2', '0', ''),
(48, 22, 'paper 1', '0', ''),
(49, 23, 'Paper 1', '0', ''),
(50, 23, 'Paper 2', '0', ''),
(55, 9, 'Paper 2', '1', 'fd');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(5) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`) VALUES
(1, 'Settings'),
(2, 'Students'),
(3, 'Results'),
(4, 'Reports'),
(5, 'Schools');

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
(20, 'Mita kawempe college ss', 55, 'kololo', '44545'),
(25, 'Makerere college', 55, 'kololo', '44545'),
(28, 'Bat valley', 55, 'kololo', '44545'),
(29, 'Kaboja', 55, 'kololo', '44545'),
(30, 'Kitante Hill School', 78, 'kampala', '566/44');

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `1` int(11) NOT NULL,
  `2` int(11) NOT NULL,
  `3` int(11) NOT NULL,
  `4` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(1, 'admin', '\r/B$CÕI¢Ü–*ÇVA'),
(4, 'judith', '_²õÔüW¡<}nMÜãä'),
(6, 'test', 'MÁ\0Ã''Œ¡À›²-‡'),
(7, 'juliana', 'MÁ\0Ã''Œ¡À›²-‡');

-- --------------------------------------------------------

--
-- Table structure for table `user_permissions`
--

CREATE TABLE `user_permissions` (
  `id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `perm_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_permissions`
--

INSERT INTO `user_permissions` (`id`, `user_id`, `perm_id`) VALUES
(50, 1, 1),
(51, 1, 2),
(52, 1, 3),
(53, 1, 4),
(54, 1, 5),
(56, 6, 1),
(57, 7, 2),
(58, 7, 3),
(62, 4, 1),
(63, 4, 2),
(64, 4, 3),
(65, 4, 4),
(66, 4, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `a_level_combinations`
--
ALTER TABLE `a_level_combinations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `a_level_students`
--
ALTER TABLE `a_level_students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `a_level_student_marks`
--
ALTER TABLE `a_level_student_marks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `a_level_subejcts`
--
ALTER TABLE `a_level_subejcts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `a_level_subejcts_papers`
--
ALTER TABLE `a_level_subejcts_papers`
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
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
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
-- Indexes for table `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `perm_id` (`perm_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `a_level_combinations`
--
ALTER TABLE `a_level_combinations`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `a_level_students`
--
ALTER TABLE `a_level_students`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `a_level_student_marks`
--
ALTER TABLE `a_level_student_marks`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
--
-- AUTO_INCREMENT for table `a_level_subejcts`
--
ALTER TABLE `a_level_subejcts`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `a_level_subejcts_papers`
--
ALTER TABLE `a_level_subejcts_papers`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT for table `o_level_students`
--
ALTER TABLE `o_level_students`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `o_level_student_marks`
--
ALTER TABLE `o_level_student_marks`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;
--
-- AUTO_INCREMENT for table `o_level_subejcts`
--
ALTER TABLE `o_level_subejcts`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `o_level_subejcts_papers`
--
ALTER TABLE `o_level_subejcts_papers`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `user_permissions`
--
ALTER TABLE `user_permissions`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD CONSTRAINT `user_permissions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_permissions_ibfk_2` FOREIGN KEY (`perm_id`) REFERENCES `permissions` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
