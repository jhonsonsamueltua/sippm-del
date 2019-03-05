-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2019 at 07:02 AM
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
  `user_id` int(11) DEFAULT NULL
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
  `asg_tahun_ajaran` varchar(32) DEFAULT NULL,
  `cls_id` int(11) DEFAULT NULL,
  `sts_asg_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sippm_category`
--

CREATE TABLE `sippm_category` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sippm_class`
--

CREATE TABLE `sippm_class` (
  `cls_id` int(11) NOT NULL,
  `cls_name` varchar(32) DEFAULT NULL,
  `prod_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sippm_file`
--

CREATE TABLE `sippm_file` (
  `file_id` int(11) NOT NULL,
  `file_name` varchar(100) DEFAULT NULL,
  `file_path` varchar(100) DEFAULT NULL,
  `proj_id` int(11) DEFAULT NULL
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
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sippm_prodi`
--

CREATE TABLE `sippm_prodi` (
  `prod_id` int(11) NOT NULL,
  `prod_name` varchar(32) DEFAULT NULL,
  `prod_alias` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sippm_project`
--

CREATE TABLE `sippm_project` (
  `proj_id` int(11) NOT NULL,
  `proj_title` varchar(100) DEFAULT NULL,
  `proj_description` varchar(500) DEFAULT NULL,
  `proj_abstract` varchar(500) DEFAULT NULL,
  `proj_downloaded` int(11) DEFAULT NULL,
  `sts_win_id` int(11) DEFAULT NULL,
  `sts_proj_id` int(11) DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sippm_project_usage`
--

CREATE TABLE `sippm_project_usage` (
  `proj_usg_id` int(11) NOT NULL,
  `proj_usg_usage` varchar(500) DEFAULT NULL,
  `proj_id` int(11) DEFAULT NULL,
  `sts_proj_usg_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sippm_role`
--

CREATE TABLE `sippm_role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sippm_status_assignment`
--

CREATE TABLE `sippm_status_assignment` (
  `sts_asg_id` int(11) NOT NULL,
  `sts_asg_name` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sippm_status_project`
--

CREATE TABLE `sippm_status_project` (
  `sts_proj_id` int(11) NOT NULL,
  `sts_proj_name` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sippm_status_project_usage`
--

CREATE TABLE `sippm_status_project_usage` (
  `sts_proj_usg_id` int(11) NOT NULL,
  `sts_proj_usg_name` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sippm_status_win`
--

CREATE TABLE `sippm_status_win` (
  `sts_win_id` int(11) NOT NULL,
  `sts_win_name` varchar(32) DEFAULT NULL
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
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sippm_student_assignment`
--

CREATE TABLE `sippm_student_assignment` (
  `stu_asg_id` int(11) NOT NULL,
  `stu_id` int(11) DEFAULT NULL,
  `asg_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sippm_student_project`
--

CREATE TABLE `sippm_student_project` (
  `stu_proj_id` int(11) NOT NULL,
  `stu_id` int(11) DEFAULT NULL,
  `proj_id` int(11) DEFAULT NULL
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
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'jhonson', 'NhKgVWO-4Rmd8LG7MM-7qG4HY75_XnSk', '$2y$13$UbR2dcftxs3PYO6.PVNGeOsYRJ06.uUkD3MFqjwVHw3G6FWtND6WS', NULL, 'jhonson@jh.ds', 10, 1551088038, 1551088038);

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
  ADD KEY `fk_class_assignment` (`cls_id`),
  ADD KEY `fk_status_assignment` (`sts_asg_id`);

--
-- Indexes for table `sippm_category`
--
ALTER TABLE `sippm_category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `sippm_class`
--
ALTER TABLE `sippm_class`
  ADD PRIMARY KEY (`cls_id`),
  ADD KEY `fk_prodi_class` (`prod_id`);

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
  ADD KEY `fk_category_project` (`cat_id`),
  ADD KEY `fk_status_win_project` (`sts_win_id`),
  ADD KEY `fk_status_project_project` (`sts_proj_id`);

--
-- Indexes for table `sippm_project_usage`
--
ALTER TABLE `sippm_project_usage`
  ADD PRIMARY KEY (`proj_usg_id`),
  ADD KEY `fk_status_project_usage` (`sts_proj_usg_id`);

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
  ADD KEY `fk_student_assigment` (`stu_id`),
  ADD KEY `fk_assigment` (`asg_id`);

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
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

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
  MODIFY `asg_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sippm_category`
--
ALTER TABLE `sippm_category`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sippm_class`
--
ALTER TABLE `sippm_class`
  MODIFY `cls_id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `stu_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sippm_student_assignment`
--
ALTER TABLE `sippm_student_assignment`
  MODIFY `stu_asg_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sippm_student_project`
--
ALTER TABLE `sippm_student_project`
  MODIFY `stu_proj_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  ADD CONSTRAINT `fk_class_assignment` FOREIGN KEY (`cls_id`) REFERENCES `sippm_class` (`cls_id`),
  ADD CONSTRAINT `fk_status_assignment` FOREIGN KEY (`sts_asg_id`) REFERENCES `sippm_status_assignment` (`sts_asg_id`);

--
-- Constraints for table `sippm_class`
--
ALTER TABLE `sippm_class`
  ADD CONSTRAINT `fk_prodi_class` FOREIGN KEY (`prod_id`) REFERENCES `sippm_prodi` (`prod_id`);

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
  ADD CONSTRAINT `fk_category_project` FOREIGN KEY (`cat_id`) REFERENCES `sippm_category` (`cat_id`),
  ADD CONSTRAINT `fk_status_project_project` FOREIGN KEY (`sts_proj_id`) REFERENCES `sippm_status_project` (`sts_proj_id`),
  ADD CONSTRAINT `fk_status_win_project` FOREIGN KEY (`sts_win_id`) REFERENCES `sippm_status_win` (`sts_win_id`);

--
-- Constraints for table `sippm_project_usage`
--
ALTER TABLE `sippm_project_usage`
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
  ADD CONSTRAINT `fk_assigment` FOREIGN KEY (`asg_id`) REFERENCES `sippm_assignment` (`asg_id`),
  ADD CONSTRAINT `fk_student_assigment` FOREIGN KEY (`stu_id`) REFERENCES `sippm_student` (`stu_id`);

--
-- Constraints for table `sippm_student_project`
--
ALTER TABLE `sippm_student_project`
  ADD CONSTRAINT `fk_project_student` FOREIGN KEY (`proj_id`) REFERENCES `sippm_project` (`proj_id`),
  ADD CONSTRAINT `fk_student` FOREIGN KEY (`stu_id`) REFERENCES `sippm_student` (`stu_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;