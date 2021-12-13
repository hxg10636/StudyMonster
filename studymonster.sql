-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 14, 2021 at 06:27 AM
-- Server version: 5.6.50-log
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `studymonster`
--

-- --------------------------------------------------------

--
-- Table structure for table `certificate`
--

CREATE TABLE `certificate` (
  `certificate_id` int(30) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `date_of_issue` datetime DEFAULT CURRENT_TIMESTAMP,
  `description` longtext NOT NULL,
  `url` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `certificate`
--

INSERT INTO `certificate` (`certificate_id`, `name`, `date_of_issue`, `description`, `url`) VALUES
(11, 'JAVAcertificate', '2021-12-12 00:29:34', 'JAVAcertificate', 'JAVAcertificate.docx'),
(12, 'Apexcertificate', '2021-12-13 20:02:44', 'Apexcertificate', 'Apexcertificate.docx'),
(13, 'LOLcertificate', '2021-12-13 20:02:56', 'LOLcertificate', 'LOLcertificate.docx'),
(14, 'CPAcertificate', '2021-12-13 20:03:07', 'CPAcertificate', 'CPAcertificate.docx'),
(15, 'GWUcertificate', '2021-12-13 20:03:21', 'GWUcertificate', 'GWUcertificate.docx'),
(16, 'Actor_certificate', '2021-12-13 20:03:40', 'Actor_certificate', 'Actor_certificate.docx');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(30) NOT NULL,
  `instructor_id` int(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(200) NOT NULL,
  `course_pict` varchar(200) NOT NULL DEFAULT 'default.jpg',
  `duration` varchar(30) NOT NULL,
  `status` varchar(6) NOT NULL DEFAULT '2' COMMENT '1 = pass; 2 = fail'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `instructor_id`, `name`, `description`, `course_pict`, `duration`, `status`) VALUES
(2, 3, 'JAVA Course ', 'This is a JAVA course', '61b421ac72b6b.jpg', '17 months', '1'),
(4, 4, 'DOTA2 course', 'This course will teach you how to be a professional dota2 player.', '61a8aa2c4bcfd.jpg', '5 years', '1'),
(7, 3, 'APEX course', 'This course will teach you how to play APEX.', '61ae863436049.jpg', '8 days', '1'),
(8, 5, 'Amazing Dance 111', 'This is a dance course.', '61a71b1203c8c.jpg', '10 years', '1'),
(10, 3, 'Basketball', 'This course teach you how to play basketball', '61a88320437f2.jpg', '11 weeks', '1'),
(14, 21, 'Supply Chain Risk Mgt', 'Industry supply chain management', '61a55890b8ad9.png', '3 months', '2'),
(18, 23, 'Physical Geology', 'Introduction Physical Geology', '61a56e6c1bfbc.jpg', '2 months', '2'),
(19, 25, 'Machine learning 400', 'Machine learning is the study of computer algorithms that can improve automatically through experience and by the use of data. It is seen as a part of artificial intelligence', '61a55cca3f1fc.jpg', '5 weeks', '1'),
(23, 3, 'Database Implement', 'This course will teach you how to write SQL code.', '61a7e7b4b0d91.jpg', '4 month', '1'),
(24, 27, 'Test Course1', 'This is a test course', '61a894e2227eb.jpg', '100 days', '1'),
(26, 19, 'Public Health Course', 'This course will teach you how to stay healthy.', '61a9be1f38b62.jpg', '100 years', '1'),
(27, 19, 'Chinese Food Cooking Course', 'This course will teach you how to cook Chinese food.', '61a9bf19a9b35.jpg', '100 days', '1'),
(28, 3, 'Student management', 'for example.', '61ae862ae048e.jpg', '2 weeks', '1'),
(33, 3, 'Test course', 'This is a test description.', 'default.jpg', '5 weeks', '2'),
(34, 32, 'Course Chcek', 'Hi this is a demo test', 'default.jpg', '15 Days', '2');

-- --------------------------------------------------------

--
-- Table structure for table `coursematerials`
--

CREATE TABLE `coursematerials` (
  `coursematerials_id` int(30) NOT NULL,
  `course_id` int(30) NOT NULL,
  `name` longtext NOT NULL,
  `description` longtext NOT NULL,
  `type` longtext NOT NULL,
  `url` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `coursematerials`
--

INSERT INTO `coursematerials` (`coursematerials_id`, `course_id`, `name`, `description`, `type`, `url`) VALUES
(61, 2, 'MP4', 'MP4 Example', 'video', '61a94eadec1c0.mp4'),
(64, 26, 'Syllabus', 'This is a word example file.', 'resource', '61a9be31c4976.docx'),
(72, 4, '123', '123', 'video', '61ac466dc9a6c.mp4'),
(73, 7, '123', '123', 'video', '61ac46754d2ed.mp4'),
(74, 8, '123', '123', 'video', '61ac467e95eaf.mp4'),
(75, 23, '123', '123', 'video', '61ac4686e0d18.mp4'),
(76, 24, '123', '123', 'video', '61ac46910b046.mp4'),
(77, 26, '123', '213', 'video', '61ac46a5b61f4.mp4'),
(78, 27, '123', '123', 'video', '61ac46b2b0ed7.mp4'),
(79, 10, '123', '123', 'video', '61ac9209495c8.mp4'),
(80, 28, '123', '123', 'resource', '61ad428fc9a56.jpg'),
(82, 2, '123', '123', 'resource', '61adae4a64ff4.jpg'),
(102, 2, '13', '222', 'resource', '61b4218f6a3e7.jpg'),
(103, 2, 'Midterm', 'This is midterm', 'test', 'Test.docx'),
(104, 7, 'Midterm', 'Midterm', 'test', 'Midterm.docx');

-- --------------------------------------------------------

--
-- Table structure for table `exam_feedback`
--

CREATE TABLE `exam_feedback` (
  `examfeedback_id` int(30) NOT NULL,
  `course_id` int(30) NOT NULL,
  `instructor_id` int(30) NOT NULL,
  `student_id` int(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(200) NOT NULL,
  `url` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `exam_feedback`
--

INSERT INTO `exam_feedback` (`examfeedback_id`, `course_id`, `instructor_id`, `student_id`, `name`, `description`, `url`) VALUES
(2, 2, 3, 4, 'Midterm1Answer_XigangHuang', 'This is Midterm1 Answer of XigangHuang.', 'Test.docx'),
(3, 4, 4, 4, 'DOTA2_Midterm', 'DOTA2_Midterm', 'DOTA2_Midterm.docx'),
(4, 7, 3, 4, 'APEX_Midterm', 'APEX_Midterm', 'APEX_Midterm.docx'),
(5, 8, 5, 4, 'Dance_Midterm.docx', 'Dance_Midterm.docx', 'Dance_Midterm.docx'),
(7, 26, 19, 4, 'Publichealth_Midterm', 'Publichealth_Midterm', 'Publichealth_Midterm.docx');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `uid` tinytext NOT NULL,
  `userEmails` tinytext NOT NULL,
  `avatar` varchar(100) NOT NULL DEFAULT 'default_user.jpg',
  `dob` date NOT NULL,
  `pwd` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `name`, `uid`, `userEmails`, `avatar`, `dob`, `pwd`) VALUES
(4, 'Xigang Huang', 'dennis', 'dennis@test.com', '61aebbfee4bf0.jpeg', '1997-09-22', '123'),
(10, 'akshan', 'akashan999', 'akashan999@gmail.com', 'default_user.jpg', '1997-08-07', 'akashanmiddle'),
(13, 'Talon', 'Talon8899', 'Talon89@gmail.com', 'default_user.jpg', '1968-07-08', 'Mxdsf998.com'),
(15, 'Singed', 'Singed88', 'Singed88@gmail.com', 'default_user.jpg', '1999-08-09', 'Mxdsf998'),
(18, 'Graves', 'graves123', 'graves123@gmail.com', 'default_user.jpg', '1987-08-07', 'Mxdsf998'),
(20, 'Jinx', 'Jinx7777', 'jinx7777@gmail.com', '61a9bb94952cc.jpg', '1977-07-11', 'Jinx7777'),
(22, 'Sona', 'Sona2222', 'Sona2222@gmail.com', '61a9bf52555f9.jpg', '1992-02-22', 'Sona2222'),
(23, 'xerath', 'xerath0000', 'xerath0000@gmail.com', 'default_user.jpg', '1990-01-11', 'xerath0000'),
(24, 'Ziggs', 'ziggs5566', 'ziggs5566@gmail.com', '61a9be8782ea7.jpg', '1996-05-11', 'ziggs5566'),
(25, 'XINHAO MA', 'sunnyma', 'sunnyma5@vt.edu', '61a552d8753a0.jpg', '1993-01-07', '123456'),
(26, 'benlong', 'benlong', 'benlong@gwu.edu', 'default_user.jpg', '1995-01-05', '123456'),
(27, 'anbo', 'anbo', 'anbo@gwu.edu', 'default_user.jpg', '1997-04-05', '123456'),
(28, 'Super11Man', 'sm2222', 'superman11@test.com', 'default_user.jpg', '1982-01-02', '12345'),
(29, 'Super11Girl', 'sg2222', 'supergirl111@admin.com', 'default_user.jpg', '1946-01-01', '12345'),
(30, 'xiexie', 'xiexie', 'xiexie@gwu.edu', 'default_user.jpg', '1998-12-31', '123456'),
(31, 'Supersass11Girl', 'sg2222', 'supergirl111@admin.com', 'default_user.jpg', '1946-01-01', '12345'),
(33, 'yiyi', 'yiyi', 'yiyi@hotmail.com', 'default_user.jpg', '1992-01-19', '123456'),
(34, 'xixi', '12xixi', '123xixi@qq.com', 'default_user.jpg', '2000-01-20', '123456'),
(35, 'Ahri', 'ahri2222', 'ahri222@gmail.com', 'default_user.jpg', '1999-08-09', 'sdsds121'),
(36, 'Ashe', 'ashe2222', 'ashe111@gmail.com', 'default_user.jpg', '1997-01-01', 'sdsds121'),
(37, 'Brad', 'brad2222', 'brad222@gmail.com', 'default_user.jpg', '1946-03-05', 'sdsds121'),
(38, 'corki', 'ck2222', 'cj2222@gmail.com', 'default_user.jpg', '1996-04-06', 'sdsds121'),
(39, 'Draven', 'dr2222', 'dr2222@gmail.com', 'default_user.jpg', '1949-01-07', 'sdsds121'),
(40, 'Fizz', 'ff2222', 'ff2222@gmail.com', 'default_user.jpg', '1996-09-08', 'sdsds121'),
(41, 'Irelia', 'ire2222', 'ire2222@gmail.com', 'default_user.jpg', '1976-05-06', 'sdsds121'),
(42, 'Kalista', 'kal2222', 'kal2222@gmail.com', 'default_user.jpg', '1986-06-04', 'sdsds121'),
(43, 'kayn', 'kayn2222', 'kayn22221@gmail.com', 'default_user.jpg', '1996-07-04', 'sdsds121'),
(45, 'lulu', 'lulu2222', 'lulu2222@gmail.com', 'default_user.jpg', '1996-08-01', 'sdsds121'),
(46, 'Ahi', 'ah222', 'ahr@gmail.com', 'default_user.jpg', '1999-08-09', 'sdsds121'),
(48, 'Bad', 'bd2222', 'ad222@gmail.com', 'default_user.jpg', '1946-03-05', 'sdsds121'),
(49, 'coki', 'c222', 'c2222@gmail.com', 'default_user.jpg', '1996-04-06', 'sdsds121'),
(50, 'Daven', 'dr22', 'd2222@gmail.com', 'default_user.jpg', '1949-01-07', 'sdsds121'),
(51, 'Fzz', 'f222', 'ff22@gmail.com', 'default_user.jpg', '1996-09-08', 'sdsds121'),
(52, 'elia', 'e2222', 'e222@gmail.com', 'default_user.jpg', '1976-05-06', 'sdsds121'),
(53, 'alista', 'al2222', 'k2222@gmail.com', 'default_user.jpg', '1986-06-04', 'sdsds121'),
(54, 'ayn', 'kayn22', 'k22221@gmail.com', 'default_user.jpg', '1996-07-04', 'sdsds121'),
(55, 'led', 'kled22', 'k2222@gmail.com', 'default_user.jpg', '1996-08-01', 'sdsds121'),
(56, 'ulu', 'lulu22', 'l2222@gmail.com', 'default_user.jpg', '1996-08-01', 'sdsds121'),
(57, 'Ahx', 'ah22x2', 'ahxr@gmail.com', 'default_user.jpg', '1999-08-09', 'sdsds121'),
(58, 'hex', 'a22x22', 'ae11x1@gmail.com', 'default_user.jpg', '1997-01-01', 'sdsds121'),
(59, 'adx', 'bd2x222', 'ad22x2@gmail.com', 'default_user.jpg', '1946-03-05', 'sdsds121'),
(60, 'okxi', 'c2x22', 'c222x2@gmail.com', 'default_user.jpg', '1996-04-06', 'sdsds121'),
(61, 'avxen', 'drx22', 'd22x22@gmail.com', 'default_user.jpg', '1949-01-07', 'sdsds121'),
(62, 'zzx', 'f2x22', 'ff2x2@gmail.com', 'default_user.jpg', '1996-09-08', 'sdsds121'),
(63, 'liax', 'e22x22', 'e22x2@gmail.com', 'default_user.jpg', '1976-05-06', 'sdsds121'),
(64, 'lisxta', 'al2x222', 'k2222@gmail.com', 'default_user.jpg', '1986-06-04', 'sdsds121'),
(65, 'anx', 'kayn2x2', 'k2222x1@gmail.com', 'default_user.jpg', '1996-07-04', 'sdsds121'),
(66, 'ldx', 'kled2x2', 'k222x2@gmail.com', 'default_user.jpg', '1996-08-01', 'sdsds121'),
(67, 'uux', 'lulu2x2', 'l222x2@gmail.com', 'default_user.jpg', '1996-08-01', 'sdsds121'),
(68, 'aAhx', 'ah22ax2', 'ahlxr@gmail.com', 'default_user.jpg', '1999-08-09', 'sdsds121'),
(69, 'ahex', 'a22xa22', 'ae1l1x1@gmail.com', 'default_user.jpg', '1997-01-01', 'sdsds121'),
(70, 'aadx', 'bd2xa222', 'ad2l2x2@gmail.com', 'default_user.jpg', '1946-03-05', 'sdsds121'),
(71, 'aokxi', 'c2xa22', 'c222xl2@gmail.com', 'default_user.jpg', '1996-04-06', 'sdsds121'),
(72, 'xavxen', 'drax22', 'd22lx22@gmail.com', 'default_user.jpg', '1949-01-07', 'sdsds121'),
(73, 'azzx', 'f2x2a2', 'ff2xl2@gmail.com', 'default_user.jpg', '1996-09-08', 'sdsds121'),
(74, 'aliax', 'e22xa22', 'e2l2x2@gmail.com', 'default_user.jpg', '1976-05-06', 'sdsds121'),
(75, 'alisxta', 'aal2x222', 'kl2222@gmail.com', 'default_user.jpg', '1986-06-04', 'sdsds121'),
(76, 'tanx', 'kayan2x2', 'k222l2x1@gmail.com', 'default_user.jpg', '1996-07-04', 'sdsds121'),
(77, 'tldx', 'klaed2x2', 'k222lx2@gmail.com', 'default_user.jpg', '1996-08-01', 'sdsds121'),
(78, 'xuux', 'laulu2x2', 'l222lx2@gmail.com', 'default_user.jpg', '1996-08-01', 'sdsds121'),
(79, 'aAhyx', 'ah22axy2', 'ahalr@gmail.com', 'default_user.jpg', '1999-08-09', 'sdsds121'),
(80, 'aheyx', 'a22xay22', 'ae1a1x1@gmail.com', 'default_user.jpg', '1997-01-01', 'sdsds121'),
(81, 'aaydx', 'bd2xay222', 'ad2ax2@gmail.com', 'default_user.jpg', '1946-03-05', 'sdsds121'),
(82, 'aoykxi', 'c2xay22', 'c2la2@gmail.com', 'default_user.jpg', '1996-04-06', 'sdsds121'),
(83, 'xayvxen', 'drayx22', 'd2a2lxa22@gmail.com', 'default_user.jpg', '1949-01-07', 'sdsds121'),
(84, 'azyzx', 'f2x2ay2', 'ff2xal2@gmail.com', 'default_user.jpg', '1996-09-08', 'sdsds121'),
(85, 'alyiax', 'e22xya22', 'ea2l2x2@gmail.com', 'default_user.jpg', '1976-05-06', 'sdsds121'),
(86, 'alyisxta', 'aal2x222', 'akl2@gmail.com', 'default_user.jpg', '1986-06-04', 'sdsds121'),
(87, 'taynx', 'kayyan2x2', 'kla2x1@gmail.com', 'default_user.jpg', '1996-07-04', 'sdsds121'),
(88, 'tlydx', 'klyaed2x2', 'k2a22lx2@gmail.com', 'default_user.jpg', '1996-08-01', 'sdsds121'),
(89, 'xuyux', 'laulu2xy2', 'l2alx2@gmail.com', 'default_user.jpg', '1996-08-01', 'sdsds121'),
(90, 'kog', 'ahzzz', 'akor@gmail.com', 'default_user.jpg', '1999-08-09', 'sdsds121'),
(91, 'noc', 'a2zzz', 'aenoca1@gmail.com', 'default_user.jpg', '1997-01-01', 'sdsds121'),
(92, 'rakan', 'bdxsx', 'adran2@gmail.com', 'default_user.jpg', '1996-03-05', 'sdsds121'),
(93, 'rengar', 'c22ss2', 'c2rengar2@gmail.com', 'default_user.jpg', '1996-04-06', 'sdsds121'),
(94, 'teemo', 'drddd', 'd2a2lteemo2@gmail.com', 'default_user.jpg', '1999-01-07', 'sdsds121'),
(95, 'twitch', 'faysds2', 'ff2sd2@gmail.com', 'default_user.jpg', '1996-09-08', 'sdsds121'),
(97, 'zilean', 'axsd222', 'akzileanl2@gmail.com', 'default_user.jpg', '1976-06-04', 'sdsds121'),
(98, 'yasuo', 'kan2sdsx2', 'klayasuo1@gmail.com', 'default_user.jpg', '1996-07-04', 'sdsds121'),
(99, 'yone', 'klysds', 'k2ateemox2@gmail.com', 'default_user.jpg', '1996-08-01', 'sdsds121'),
(100, 'zrya', 'laudsdsl', 'l2zryax2@gmail.com', 'default_user.jpg', '1996-08-01', 'sdsds121'),
(101, 'keg', 'adzz', 'ak@gmail.com', 'default_user.jpg', '1999-08-09', 'sdsds121'),
(102, 'nic', 'a2ddz', 'aca1@gmail.com', 'default_user.jpg', '1997-01-01', 'sdsds121'),
(103, 'rekan', 'dxsx', 'aan2@gmail.com', 'default_user.jpg', '1996-03-05', 'sdsds121'),
(104, 'rengee', 'cd2ss2', 'c2gar2@gmail.com', 'default_user.jpg', '1996-04-06', 'sdsds121'),
(105, 'teemuuu', 'dxddd', 'd2aemo2@gmail.com', 'default_user.jpg', '1999-01-07', 'sdsds121'),
(106, 'twiink', 'fxysds2', 'fd2@gmail.com', 'default_user.jpg', '1996-09-08', 'sdsds121'),
(107, 'zacside', 'e32xds2', 'ea2sdsz2@gmail.com', 'default_user.jpg', '1976-05-06', 'sdsds121'),
(108, 'zistudy', 'axxd222', 'akeanl2@gmail.com', 'default_user.jpg', '1976-06-04', 'sdsds121'),
(109, 'yahike', '552sdsx2', 'kyasuo1@gmail.com', 'default_user.jpg', '1996-07-04', 'sdsds121'),
(110, 'yikee', 'klxxxds', 'k2eemox2@gmail.com', 'default_user.jpg', '1996-08-01', 'sdsds121'),
(111, 'zrssa', 'lxxxsdsl', 'zrax2@gmail.com', 'default_user.jpg', '1996-08-01', 'sdsds121'),
(112, 'studentking', 'student10086', '10086@163.com', '61a56f7c8a99c.jpg', '1979-09-22', '123'),
(113, 'denniswong1', 'denniswong', '1063615618@qq.com', 'default_user.jpg', '1877-05-12', '123'),
(114, 'dennis123', 'dennis123', 'dennis@test123.com', '61a580f2ecd8a.jpg', '1234-12-12', '123'),
(116, 'Sean Ho', 'Donald1', 'Donald1@gwu.edu', 'default_user.jpg', '2222-02-22', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `student_course`
--

CREATE TABLE `student_course` (
  `student_id` int(30) NOT NULL,
  `course_id` int(30) NOT NULL,
  `grade` varchar(30) DEFAULT NULL,
  `Enrolldate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `certificate_id` int(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_course`
--

INSERT INTO `student_course` (`student_id`, `course_id`, `grade`, `Enrolldate`, `certificate_id`) VALUES
(24, 26, '100', '2021-12-03 06:51:59', NULL),
(22, 26, NULL, '2021-12-03 06:55:21', NULL),
(22, 27, NULL, '2021-12-03 06:55:44', NULL),
(4, 2, '99', '2021-12-11 23:09:47', 11),
(4, 4, NULL, '2021-12-11 23:19:19', 11),
(4, 7, NULL, '2021-12-13 20:04:21', NULL),
(4, 8, NULL, '2021-12-13 20:04:22', NULL),
(4, 10, '100', '2021-12-13 20:04:24', NULL),
(4, 26, NULL, '2021-12-13 20:05:55', NULL),
(116, 7, NULL, '2021-12-13 21:28:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `uid` tinytext NOT NULL,
  `userEmails` tinytext NOT NULL,
  `avatar` varchar(200) NOT NULL DEFAULT 'default_user.jpg',
  `dob` date NOT NULL,
  `pwd` longtext NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`id`, `name`, `uid`, `userEmails`, `avatar`, `dob`, `pwd`, `role`) VALUES
(3, 'Daniel Wu', 'professor1', 'professor1@test.com', '61ae7170b52b5.jpg', '1989-01-12', '123', '1'),
(4, 'admin1', 'admin', 'dennis@test.com', '61b51bbbda672.jpg', '1996-01-02', '123', '2'),
(5, 'Lili Wang', 'liliwang', 'lili@test.com', '61a53eb925b22.jpg', '2122-02-22', '12345', '1'),
(7, 'Albert Einstein ', 'albert', 'albert@outlook.com', 'default_user.jpg', '1970-07-15', 'ALBERT.COM', '1'),
(19, 'chengxi', 'chengxxxx', 'chengxi5@163.com', '61a9bc1000b72.jpg', '1987-03-04', '123456', '1'),
(21, 'Law Liu', 'Richlaw', 'richlaw@gwu.edu', '61a9bbe0ceea7.jpg', '1992-03-22', '123456qwer', '1'),
(23, 'venus', 'venus5', 'venus@gmail.com', 'default_user.jpg', '1976-01-09', '123', '1'),
(25, 'joker', 'joker', 'joker@gmail.com', 'default_user.jpg', '1978-02-04', '123', '1'),
(27, 'ProfessorHuang', 'professor', 'professor@test.com', '61a5855f1c502.jpg', '1997-09-22', '123', '1'),
(28, 'admintest2', 'admin2', 'admin2@test.com', '61a944db71636.jpg', '1997-09-22', '123', '2'),
(29, 'admintest3', 'admin3', 'admin3@test.com', 'default_user.jpg', '1997-09-22', '123', '2'),
(32, 'teacher1', 'teacher1', 'Donald12@gwu.edu', 'default_user.jpg', '2132-10-20', '123', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `certificate`
--
ALTER TABLE `certificate`
  ADD PRIMARY KEY (`certificate_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `instructor_id` (`instructor_id`);

--
-- Indexes for table `coursematerials`
--
ALTER TABLE `coursematerials`
  ADD PRIMARY KEY (`coursematerials_id`),
  ADD KEY `coursematerials_fk0` (`course_id`);

--
-- Indexes for table `exam_feedback`
--
ALTER TABLE `exam_feedback`
  ADD PRIMARY KEY (`examfeedback_id`),
  ADD KEY `exam_feedback_fk0` (`course_id`),
  ADD KEY `exam_feedback_fk1` (`instructor_id`),
  ADD KEY `exam_feedback_fk2` (`student_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_course`
--
ALTER TABLE `student_course`
  ADD KEY `student_course_fk0` (`student_id`,`course_id`),
  ADD KEY `student_course_fk1` (`course_id`),
  ADD KEY `student_course_FK4` (`certificate_id`),
  ADD KEY `student_course_FK5` (`certificate_id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `certificate`
--
ALTER TABLE `certificate`
  MODIFY `certificate_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `coursematerials`
--
ALTER TABLE `coursematerials`
  MODIFY `coursematerials_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `exam_feedback`
--
ALTER TABLE `exam_feedback`
  MODIFY `examfeedback_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`instructor_id`) REFERENCES `teacher` (`id`);

--
-- Constraints for table `coursematerials`
--
ALTER TABLE `coursematerials`
  ADD CONSTRAINT `coursematerials_fk0` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`);

--
-- Constraints for table `exam_feedback`
--
ALTER TABLE `exam_feedback`
  ADD CONSTRAINT `exam_feedback_fk0` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`),
  ADD CONSTRAINT `exam_feedback_fk1` FOREIGN KEY (`instructor_id`) REFERENCES `teacher` (`id`),
  ADD CONSTRAINT `exam_feedback_fk2` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`);

--
-- Constraints for table `student_course`
--
ALTER TABLE `student_course`
  ADD CONSTRAINT `student_course_FK5` FOREIGN KEY (`certificate_id`) REFERENCES `certificate` (`certificate_id`),
  ADD CONSTRAINT `student_course_fk0` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`),
  ADD CONSTRAINT `student_course_fk1` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
