-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 22, 2019 at 02:38 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sippm-del`
--

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1551087483),
('m130524_201442_init', 1551087489);

-- --------------------------------------------------------

--
-- Table structure for table `sippm_admin`
--

CREATE TABLE `sippm_admin` (
  `adm_id` int(11) NOT NULL,
  `adm_fullname` varchar(100) DEFAULT NULL,
  `adm_email` varchar(100) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sippm_assignment`
--

CREATE TABLE `sippm_assignment` (
  `asg_id` int(11) NOT NULL,
  `asg_title` varchar(100) DEFAULT NULL,
  `asg_description` varchar(500) DEFAULT NULL,
  `asg_start_time` datetime DEFAULT NULL,
  `asg_end_time` datetime DEFAULT NULL,
  `asg_year` varchar(32) DEFAULT NULL,
  `class` varchar(32) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `cat_proj_id` int(11) DEFAULT NULL,
  `sts_asg_id` int(11) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sippm_assignment`
--

INSERT INTO `sippm_assignment` (`asg_id`, `asg_title`, `asg_description`, `asg_start_time`, `asg_end_time`, `asg_year`, `class`, `course_id`, `cat_proj_id`, `sts_asg_id`, `deleted`, `deleted_at`, `deleted_by`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(47, 'Pengumpulan Proyek PAM', 'Jangan Telat Ya', '2019-03-21 21:35:06', '2019-03-22 21:35:07', '2019', NULL, 2, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sippm_category_project`
--

CREATE TABLE `sippm_category_project` (
  `cat_proj_id` int(11) NOT NULL,
  `cat_proj_name` varchar(32) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sippm_category_project`
--

INSERT INTO `sippm_category_project` (`cat_proj_id`, `cat_proj_name`, `deleted`, `deleted_at`, `deleted_by`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Matakuliah', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'PKM', 0, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sippm_category_usage`
--

CREATE TABLE `sippm_category_usage` (
  `cat_usg_id` int(11) NOT NULL,
  `cat_usg_name` varchar(32) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sippm_class`
--

CREATE TABLE `sippm_class` (
  `cls_id` int(11) NOT NULL,
  `cls_name` varchar(32) DEFAULT NULL,
  `prod_id` int(11) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sippm_class`
--

INSERT INTO `sippm_class` (`cls_id`, `cls_name`, `prod_id`, `deleted`, `deleted_at`, `deleted_by`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'kelas1', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'kelas2', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sippm_class_assignment`
--

CREATE TABLE `sippm_class_assignment` (
  `cls_asg_id` int(11) NOT NULL,
  `class` varchar(100) NOT NULL,
  `asg_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sippm_class_assignment`
--

INSERT INTO `sippm_class_assignment` (`cls_asg_id`, `class`, `asg_id`) VALUES
(59, '42TI', 47);

-- --------------------------------------------------------

--
-- Table structure for table `sippm_course`
--

CREATE TABLE `sippm_course` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(100) DEFAULT NULL,
  `course_alias` varchar(32) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sippm_course`
--

INSERT INTO `sippm_course` (`course_id`, `course_name`, `course_alias`, `deleted`, `deleted_at`, `deleted_by`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Pengembangan Situs Web I', 'PSW I', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Pengembangan Aplikasi Mobile', 'PAM', 0, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sippm_file`
--

CREATE TABLE `sippm_file` (
  `file_id` int(11) NOT NULL,
  `file_name` varchar(100) DEFAULT NULL,
  `file_path` varchar(100) DEFAULT NULL,
  `proj_id` int(11) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sippm_lecturer`
--

CREATE TABLE `sippm_lecturer` (
  `lec_id` int(11) NOT NULL,
  `lec_fullname` varchar(100) DEFAULT NULL,
  `lec_email` varchar(100) DEFAULT NULL,
  `lec_nip` varchar(32) DEFAULT NULL,
  `lec_nidn` varchar(32) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sippm_prodi`
--

CREATE TABLE `sippm_prodi` (
  `prod_id` int(11) NOT NULL,
  `prod_name` varchar(32) DEFAULT NULL,
  `prod_alias` varchar(32) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sippm_project`
--

CREATE TABLE `sippm_project` (
  `proj_id` int(11) NOT NULL,
  `proj_title` varchar(100) DEFAULT NULL,
  `proj_description` varchar(500) DEFAULT NULL,
  `proj_downloaded` int(11) DEFAULT NULL,
  `asg_id` int(11) NOT NULL,
  `sts_win_id` int(11) DEFAULT NULL,
  `sts_proj_id` int(11) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sippm_project_usage`
--

CREATE TABLE `sippm_project_usage` (
  `proj_usg_id` int(11) NOT NULL,
  `proj_usg_usage` varchar(500) DEFAULT NULL,
  `proj_id` int(11) DEFAULT NULL,
  `sts_proj_usg_id` int(11) DEFAULT NULL,
  `cat_usg_id` int(11) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sippm_role`
--

CREATE TABLE `sippm_role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(32) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sippm_role`
--

INSERT INTO `sippm_role` (`role_id`, `role_name`, `deleted`, `deleted_at`, `deleted_by`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Student', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Lecturer', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Admin', 0, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sippm_status_assignment`
--

CREATE TABLE `sippm_status_assignment` (
  `sts_asg_id` int(11) NOT NULL,
  `sts_asg_name` varchar(32) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sippm_status_project`
--

CREATE TABLE `sippm_status_project` (
  `sts_proj_id` int(11) NOT NULL,
  `sts_proj_name` varchar(32) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sippm_status_project_usage`
--

CREATE TABLE `sippm_status_project_usage` (
  `sts_proj_usg_id` int(11) NOT NULL,
  `sts_proj_usg_name` varchar(32) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sippm_status_win`
--

CREATE TABLE `sippm_status_win` (
  `sts_win_id` int(11) NOT NULL,
  `sts_win_name` varchar(32) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sippm_student`
--

CREATE TABLE `sippm_student` (
  `stu_id` int(11) NOT NULL,
  `stu_fullname` varchar(100) DEFAULT NULL,
  `stu_email` varchar(100) DEFAULT NULL,
  `stu_nim` varchar(32) DEFAULT NULL,
  `cls_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sippm_student`
--

INSERT INTO `sippm_student` (`stu_id`, `stu_fullname`, `stu_email`, `stu_nim`, `cls_id`, `user_id`, `deleted`, `deleted_at`, `deleted_by`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Jhonson Samuel Tua Hutagaol', 'jhonson@email.com', '11416005', 1, 2, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(2, '2', 'hgjhvbkjn', 'hgjvhbknlk', 1, 2, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'adsdd', 'sdfs', 'jhb', 1, 2, 0, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sippm_student_assignment`
--

CREATE TABLE `sippm_student_assignment` (
  `stu_asg_id` int(11) NOT NULL,
  `stu_id` int(11) DEFAULT NULL,
  `asg_id` int(11) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sippm_student_assignment`
--

INSERT INTO `sippm_student_assignment` (`stu_asg_id`, `stu_id`, `asg_id`, `deleted`, `deleted_at`, `deleted_by`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(30, 1, 47, 0, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sippm_student_project`
--

CREATE TABLE `sippm_student_project` (
  `stu_proj_id` int(11) NOT NULL,
  `stu_id` int(11) DEFAULT NULL,
  `proj_id` int(11) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `role_id`, `status`, `created_at`, `updated_at`) VALUES
(2, 'jhonson', 'e2YzYnjsPfe3Rr75sWGx2B0OF8wPk0pB', '$2y$13$MCL8BVQpMqeZaQVFk.4bx.JkYns21OXR7d97s8Jg5Ts4oSYQrrmXG', NULL, 'jhonson@jh.ds', 1, 10, 1551664731, 1551664731),
(3, 'admin', 'yfZ3Z-e5VRqOVqCn_dTTxUYeGXWiow-J', '$2y$13$K65jNmZ8fOI70AKOHw/sm.YXh5WzJgHZuwybGij6tNPork/WVeU5a', NULL, 'admin@kj.d', 3, 10, 1551667878, 1551667878);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `sippm_admin`
--
ALTER TABLE `sippm_admin`
  ADD PRIMARY KEY (`adm_id`),
  ADD KEY `fk_user_admin` (`user_id`);

--
-- Indexes for table `sippm_assignment`
--
ALTER TABLE `sippm_assignment`
  ADD PRIMARY KEY (`asg_id`),
  ADD KEY `fk_status_assignment` (`sts_asg_id`),
  ADD KEY `fk_course_assignment` (`course_id`),
  ADD KEY `fk_category_project_assignment` (`cat_proj_id`);

--
-- Indexes for table `sippm_category_project`
--
ALTER TABLE `sippm_category_project`
  ADD PRIMARY KEY (`cat_proj_id`);

--
-- Indexes for table `sippm_category_usage`
--
ALTER TABLE `sippm_category_usage`
  ADD PRIMARY KEY (`cat_usg_id`);

--
-- Indexes for table `sippm_class`
--
ALTER TABLE `sippm_class`
  ADD PRIMARY KEY (`cls_id`),
  ADD KEY `fk_prodi_class` (`prod_id`);

--
-- Indexes for table `sippm_class_assignment`
--
ALTER TABLE `sippm_class_assignment`
  ADD PRIMARY KEY (`cls_asg_id`),
  ADD KEY `fk_class_assignment` (`asg_id`);

--
-- Indexes for table `sippm_course`
--
ALTER TABLE `sippm_course`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `sippm_file`
--
ALTER TABLE `sippm_file`
  ADD PRIMARY KEY (`file_id`),
  ADD KEY `fk_project_file` (`proj_id`);

--
-- Indexes for table `sippm_lecturer`
--
ALTER TABLE `sippm_lecturer`
  ADD PRIMARY KEY (`lec_id`),
  ADD KEY `fk_user_lecturer` (`user_id`);

--
-- Indexes for table `sippm_prodi`
--
ALTER TABLE `sippm_prodi`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `sippm_project`
--
ALTER TABLE `sippm_project`
  ADD PRIMARY KEY (`proj_id`),
  ADD KEY `fk_status_win_project` (`sts_win_id`),
  ADD KEY `fk_status_project_project` (`sts_proj_id`),
  ADD KEY `fk_project_assignment` (`asg_id`);

--
-- Indexes for table `sippm_project_usage`
--
ALTER TABLE `sippm_project_usage`
  ADD PRIMARY KEY (`proj_usg_id`),
  ADD KEY `fk_status_project_usage` (`sts_proj_usg_id`),
  ADD KEY `fk_category_usage_project` (`cat_usg_id`);

--
-- Indexes for table `sippm_role`
--
ALTER TABLE `sippm_role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `sippm_status_assignment`
--
ALTER TABLE `sippm_status_assignment`
  ADD PRIMARY KEY (`sts_asg_id`);

--
-- Indexes for table `sippm_status_project`
--
ALTER TABLE `sippm_status_project`
  ADD PRIMARY KEY (`sts_proj_id`);

--
-- Indexes for table `sippm_status_project_usage`
--
ALTER TABLE `sippm_status_project_usage`
  ADD PRIMARY KEY (`sts_proj_usg_id`);

--
-- Indexes for table `sippm_status_win`
--
ALTER TABLE `sippm_status_win`
  ADD PRIMARY KEY (`sts_win_id`);

--
-- Indexes for table `sippm_student`
--
ALTER TABLE `sippm_student`
  ADD PRIMARY KEY (`stu_id`),
  ADD KEY `fk_class_student` (`cls_id`),
  ADD KEY `fk_user_student` (`user_id`);

--
-- Indexes for table `sippm_student_assignment`
--
ALTER TABLE `sippm_student_assignment`
  ADD PRIMARY KEY (`stu_asg_id`),
  ADD KEY `fk_student_assignment` (`stu_id`),
  ADD KEY `fk_assignment` (`asg_id`);

--
-- Indexes for table `sippm_student_project`
--
ALTER TABLE `sippm_student_project`
  ADD PRIMARY KEY (`stu_proj_id`),
  ADD KEY `fk_project_student` (`proj_id`),
  ADD KEY `fk_student` (`stu_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`),
  ADD KEY `fk_user_role` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sippm_admin`
--
ALTER TABLE `sippm_admin`
  MODIFY `adm_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sippm_assignment`
--
ALTER TABLE `sippm_assignment`
  MODIFY `asg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `sippm_category_project`
--
ALTER TABLE `sippm_category_project`
  MODIFY `cat_proj_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sippm_category_usage`
--
ALTER TABLE `sippm_category_usage`
  MODIFY `cat_usg_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sippm_class`
--
ALTER TABLE `sippm_class`
  MODIFY `cls_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sippm_class_assignment`
--
ALTER TABLE `sippm_class_assignment`
  MODIFY `cls_asg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `sippm_course`
--
ALTER TABLE `sippm_course`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sippm_file`
--
ALTER TABLE `sippm_file`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sippm_lecturer`
--
ALTER TABLE `sippm_lecturer`
  MODIFY `lec_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sippm_prodi`
--
ALTER TABLE `sippm_prodi`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sippm_project`
--
ALTER TABLE `sippm_project`
  MODIFY `proj_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sippm_project_usage`
--
ALTER TABLE `sippm_project_usage`
  MODIFY `proj_usg_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sippm_role`
--
ALTER TABLE `sippm_role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sippm_status_assignment`
--
ALTER TABLE `sippm_status_assignment`
  MODIFY `sts_asg_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sippm_status_project`
--
ALTER TABLE `sippm_status_project`
  MODIFY `sts_proj_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sippm_status_project_usage`
--
ALTER TABLE `sippm_status_project_usage`
  MODIFY `sts_proj_usg_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sippm_status_win`
--
ALTER TABLE `sippm_status_win`
  MODIFY `sts_win_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sippm_student`
--
ALTER TABLE `sippm_student`
  MODIFY `stu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sippm_student_assignment`
--
ALTER TABLE `sippm_student_assignment`
  MODIFY `stu_asg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `sippm_student_project`
--
ALTER TABLE `sippm_student_project`
  MODIFY `stu_proj_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sippm_admin`
--
ALTER TABLE `sippm_admin`
  ADD CONSTRAINT `fk_user_admin` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `sippm_assignment`
--
ALTER TABLE `sippm_assignment`
  ADD CONSTRAINT `fk_category_project_assignment` FOREIGN KEY (`cat_proj_id`) REFERENCES `sippm_category_project` (`cat_proj_id`),
  ADD CONSTRAINT `fk_course_assignment` FOREIGN KEY (`course_id`) REFERENCES `sippm_course` (`course_id`),
  ADD CONSTRAINT `fk_status_assignment` FOREIGN KEY (`sts_asg_id`) REFERENCES `sippm_status_assignment` (`sts_asg_id`);

--
-- Constraints for table `sippm_class`
--
ALTER TABLE `sippm_class`
  ADD CONSTRAINT `fk_prodi_class` FOREIGN KEY (`prod_id`) REFERENCES `sippm_prodi` (`prod_id`);

--
-- Constraints for table `sippm_class_assignment`
--
ALTER TABLE `sippm_class_assignment`
  ADD CONSTRAINT `fk_class_assignment` FOREIGN KEY (`asg_id`) REFERENCES `sippm_assignment` (`asg_id`);

--
-- Constraints for table `sippm_file`
--
ALTER TABLE `sippm_file`
  ADD CONSTRAINT `fk_project_file` FOREIGN KEY (`proj_id`) REFERENCES `sippm_project` (`proj_id`);

--
-- Constraints for table `sippm_lecturer`
--
ALTER TABLE `sippm_lecturer`
  ADD CONSTRAINT `fk_user_lecturer` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `sippm_project`
--
ALTER TABLE `sippm_project`
  ADD CONSTRAINT `fk_project_assignment` FOREIGN KEY (`asg_id`) REFERENCES `sippm_assignment` (`asg_id`),
  ADD CONSTRAINT `fk_status_project_project` FOREIGN KEY (`sts_proj_id`) REFERENCES `sippm_status_project` (`sts_proj_id`),
  ADD CONSTRAINT `fk_status_win_project` FOREIGN KEY (`sts_win_id`) REFERENCES `sippm_status_win` (`sts_win_id`);

--
-- Constraints for table `sippm_project_usage`
--
ALTER TABLE `sippm_project_usage`
  ADD CONSTRAINT `fk_category_usage_project` FOREIGN KEY (`cat_usg_id`) REFERENCES `sippm_category_usage` (`cat_usg_id`),
  ADD CONSTRAINT `fk_status_project_usage` FOREIGN KEY (`sts_proj_usg_id`) REFERENCES `sippm_status_project_usage` (`sts_proj_usg_id`);

--
-- Constraints for table `sippm_student`
--
ALTER TABLE `sippm_student`
  ADD CONSTRAINT `fk_class_student` FOREIGN KEY (`cls_id`) REFERENCES `sippm_class` (`cls_id`),
  ADD CONSTRAINT `fk_user_student` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `sippm_student_assignment`
--
ALTER TABLE `sippm_student_assignment`
  ADD CONSTRAINT `fk_assignment` FOREIGN KEY (`asg_id`) REFERENCES `sippm_assignment` (`asg_id`),
  ADD CONSTRAINT `fk_student_assigment` FOREIGN KEY (`stu_id`) REFERENCES `sippm_student` (`stu_id`);

--
-- Constraints for table `sippm_student_project`
--
ALTER TABLE `sippm_student_project`
  ADD CONSTRAINT `fk_project_student` FOREIGN KEY (`proj_id`) REFERENCES `sippm_project` (`proj_id`),
  ADD CONSTRAINT `fk_student` FOREIGN KEY (`stu_id`) REFERENCES `sippm_student` (`stu_id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_role` FOREIGN KEY (`role_id`) REFERENCES `sippm_role` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
