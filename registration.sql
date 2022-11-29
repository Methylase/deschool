-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql113.epizy.com
-- Generation Time: Oct 04, 2022 at 01:01 PM
-- Server version: 10.3.27-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `registration`
--

-- --------------------------------------------------------

--
-- Table structure for table `corox_models`
--

CREATE TABLE `corox_models` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `remember_token` varchar(300) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `corox_models`
--

INSERT INTO `corox_models` (`id`, `email`, `password`, `remember_token`) VALUES
(54, 'methyl2007@gmail.com', '$2y$10$c63fwhQPtsQ2rb3EANHGQuWztMvv9SMrh6SIBfUrM1X02/JEgs7ma', '3twynq7Hpeydg1ovyOF4CY2AjWbZuxhrwtOQReVFF9Sw4ngijZSREXzBsdKv'),
(51, 'adekunledare@gmail.com', '$2y$10$Z2RtyLVSuaadrU9jj94aqeTO5ucf./llwHMoY//5h1T8ze4bIzD.K', 'n9lakxV3BzGwCea3vMKRQjdL66dxV9dpA98Lou3v9InGiTkG8V09kQDPMiO6'),
(52, 'methyl2005@gmail.com', '$2y$10$pSIq699B5NsZ4CWuN5p0ZOR7HQ81HMEcF8UfbBs.hlohfyZtwY3fe', 'h47w2LC25c9Y39DF5q1KJnQqH593jTkr7b9E8TMK');

-- --------------------------------------------------------

--
-- Table structure for table `corox_model_role`
--

CREATE TABLE `corox_model_role` (
  `id` int(11) NOT NULL,
  `corox_model_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `corox_model_role`
--

INSERT INTO `corox_model_role` (`id`, `corox_model_id`, `role_id`) VALUES
(138, 54, 1),
(127, 40, 1),
(136, 52, 2),
(139, 51, 2);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `register_classes`
--

CREATE TABLE `register_classes` (
  `id` int(10) UNSIGNED NOT NULL,
  `class_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `corox_model_id` int(10) UNSIGNED DEFAULT NULL,
  `class_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `register_classes`
--

INSERT INTO `register_classes` (`id`, `class_name`, `corox_model_id`, `class_date`) VALUES
(1, 'basic1', 54, '2020-06-04'),
(2, 'basic2', 54, '2020-06-06'),
(3, 'basic3', 54, '2020-04-20'),
(4, 'mathematics', 54, '2022-08-11'),
(5, 'Basic 6', 54, '2022-08-11');

-- --------------------------------------------------------

--
-- Table structure for table `register_memo`
--

CREATE TABLE `register_memo` (
  `id` int(11) NOT NULL,
  `sender_email` varchar(255) NOT NULL,
  `corox_model_id` varchar(10) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `receiver_email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `register_memo`
--

INSERT INTO `register_memo` (`id`, `sender_email`, `corox_model_id`, `subject`, `message`, `receiver_email`) VALUES
(1, 'mutiu.adepoju@livestock247.com', '54', 'mbnvxfvcvbn', 'ncfhgghvhh', 'methyl2007@yahoo.com'),
(2, 'mutiu.adepoju@gmail.com', '54', 'mbnvxfvcvbn', 'jhgvhjm', 'methyl2007@yahoo.com'),
(3, 'mutiu.adepoju@livestock247.com', '54', 'mbnvxfvcvbn', 'vxvcbvn', 'methyl2007@yahoo.com'),
(4, 'mutiu.adepoju@livestock247.com', '54', 'mbnvxfvcvbn', 'vxvcbvn', 'bolatito@gmail.com methyl2007@yahoo.com');

-- --------------------------------------------------------

--
-- Table structure for table `register_parent_informations`
--

CREATE TABLE `register_parent_informations` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_middlename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_marital_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_dob` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_disability` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_list_disability` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_hobbies` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_social_media` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_localG` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_corox_model_id` int(10) DEFAULT NULL,
  `corox_model_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `register_parent_informations`
--

INSERT INTO `register_parent_informations` (`id`, `parent_firstname`, `parent_middlename`, `parent_lastname`, `parent_email`, `parent_marital_status`, `parent_gender`, `parent_phone`, `parent_dob`, `parent_disability`, `parent_list_disability`, `parent_hobbies`, `parent_address`, `parent_city`, `parent_social_media`, `parent_state`, `parent_localG`, `parent_profile_image`, `user_corox_model_id`, `corox_model_id`) VALUES
(2, 'Adedeji', 'Olanrewaju', 'Adedeji', 'olalekan@gmail.com', 'married', 'male', '08188373898', '1976-01-20', 'no', '', 'meeting people', '20 Olanrewaju street', 'Ogba', 'olanrewaju@facebook', 'Lagos State', 'Ikeja', NULL, 0, 54),
(3, 'Folashade', 'bidemi', 'Olukoya', 'folashade@gmail.com', 'married', 'female', '', '1978-08-05', 'no', '', 'reading and meeting people', '20 Old Drive Adeniyi Jone', 'Adeniyi Jones', 'bidemi@gmail.com', 'Lagos State', 'Ikeja', 'phpAA32.tmp.jpg', 0, 54),
(7, 'jkhg', 'ddewwe', 'dscsd', 'temitope.akiola@livestock247.com', 'single', 'male', '45678', '2022-07-31', 'yes', 'fdfhf', 'ggfh', 'xfcgvbn', 'dfdfg', 'DS', 'Adamawa State', 'Fufure', NULL, 0, 54);

-- --------------------------------------------------------

--
-- Table structure for table `register_period`
--

CREATE TABLE `register_period` (
  `id` int(10) UNSIGNED NOT NULL,
  `period_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `corox_model_id` bigint(20) UNSIGNED NOT NULL,
  `period_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `register_period`
--

INSERT INTO `register_period` (`id`, `period_name`, `corox_model_id`, `period_date`) VALUES
(1, 'single', 54, '2020-06-04'),
(2, 'double', 54, '2022-08-11');

-- --------------------------------------------------------

--
-- Table structure for table `register_school_information`
--

CREATE TABLE `register_school_information` (
  `id` int(10) UNSIGNED NOT NULL,
  `school_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_phone1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_phone2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_license` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_social_media` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_localG` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_number_of_staffs` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_services` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_establish_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_license_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_postal_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_profile_image` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `corox_model_id` int(10) UNSIGNED DEFAULT NULL,
  `school_enable` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `register_school_information`
--

INSERT INTO `register_school_information` (`id`, `school_name`, `school_email`, `school_phone1`, `school_phone2`, `school_address`, `school_license`, `school_city`, `school_social_media`, `school_state`, `school_localG`, `school_number_of_staffs`, `school_description`, `school_services`, `school_establish_date`, `school_license_number`, `school_postal_address`, `school_profile_image`, `corox_model_id`, `school_enable`, `created_at`, `updated_at`) VALUES
(12, 'Leadersville College', 'methyl2008@gmail.com', '08188373898', '091378649', '20, bollola street', 'approved', 'Ogba', 'leadersville', 'Lagos State', 'Eti Osa', '5', 'we  believe in delivering quality education to young Nigerians and bring up young leaders the way they will bring development to the society', 'primary/basic-nursery-secondary', '1992-08-05', '4556', 'P.O box 48647', 'php97D1.tmp.jpg', 54, '', '2020-06-03 18:50:01', '2022-07-31 05:03:10');

-- --------------------------------------------------------

--
-- Table structure for table `register_staff_informations`
--

CREATE TABLE `register_staff_informations` (
  `id` int(10) UNSIGNED NOT NULL,
  `staff_firstname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `staff_middlename` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `staff_lastname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `staff_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `staff_marital_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `staff_gender` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `staff_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `staff_dob` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `staff_disability` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `staff_list_disability` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `staff_hobbies` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `staff_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `staff_city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `staff_social_media` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `staff_state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `staff_localG` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `staff_profile_image` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `corox_model_id` int(10) UNSIGNED DEFAULT NULL,
  `user_corox_model_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `register_staff_informations`
--

INSERT INTO `register_staff_informations` (`id`, `staff_firstname`, `staff_middlename`, `staff_lastname`, `staff_email`, `staff_marital_status`, `staff_gender`, `staff_phone`, `staff_dob`, `staff_disability`, `staff_list_disability`, `staff_hobbies`, `staff_address`, `staff_city`, `staff_social_media`, `staff_state`, `staff_localG`, `staff_profile_image`, `corox_model_id`, `user_corox_model_id`, `created_at`, `updated_at`) VALUES
(33, 'adekunle', 'oludare', 'olumide', 'adekunledare@gmail.com', 'married', 'male', '08188378698', '1976-08-12', 'no', '', 'meeting people', '20 adediran close', 'ogba', 'dare@facebook', 'Lagos State', 'Ikeja', NULL, 54, 51, '2020-06-08 08:52:33', '2022-05-04 07:49:19'),
(34, 'Esther', 'Uri', 'Adewale', 'methyl2005@gmail.com', 'married', 'female', '08188378987', '1975-01-06', 'no', NULL, 'meeting people', '20 adediran close', 'Ogba', 'esther@facebook', 'Lagos State', 'Ikeja', NULL, 54, 52, '2020-06-08 09:02:57', '2020-06-08 09:05:27'),
(35, 'Adebayo', 'Tunde', 'Tejuosho', 'tejuosho@gmail.com', 'none', 'male', '08135389834', '1981-01-03', 'none', '', 'singing', 'william street', 'ikeja', '', 'none', 'none', 'php2145.tmp.jpg', 54, 0, '2020-06-14 09:56:10', '2020-06-15 06:07:31'),
(37, 'bolatito', 'oladele', 'sulaimon', 'bolatito@gmail.com', 'single', 'female', '08137389834', '', 'no', '', 'meeting poeple', 'sulaimon stree', 'ogba', '', 'Lagos State', 'Ikeja', 'phpF91A.tmp.jpg', 54, 0, '2020-06-15 03:34:16', '2020-06-15 06:05:10'),
(38, 'asxa', 'sd', 'sd', 'methyl2007@yahoo.com', 'none', 'female', '0907864532', '2021-01-22', 'yes', 'asssa', 'jhgf', 'uryyr', 'ewe', 'fgf', 'Enugu State', 'Igbo Eze South', NULL, 54, 0, '2021-01-13 21:46:38', '2021-01-13 21:46:38');

-- --------------------------------------------------------

--
-- Table structure for table `register_staff_register`
--

CREATE TABLE `register_staff_register` (
  `id` int(10) UNSIGNED NOT NULL,
  `staff_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `register_date` date NOT NULL,
  `register_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `register_resumption_status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `corox_model_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `register_staff_register`
--

INSERT INTO `register_staff_register` (`id`, `staff_id`, `register_date`, `register_time`, `register_resumption_status`, `corox_model_id`) VALUES
(1, '33', '2020-06-12', '7:00 AM', 'on-time', 54),
(2, '34', '2020-06-12', '10:27 AM', 'late', 54),
(3, '33', '2022-01-03', '1:00 AM', 'late', 54),
(4, '33', '2022-04-25', '8:57 AM', 'late', 54),
(5, '34', '2022-04-25', '8:58 AM', 'late', 54);

-- --------------------------------------------------------

--
-- Table structure for table `register_staff_teacher`
--

CREATE TABLE `register_staff_teacher` (
  `id` int(10) UNSIGNED NOT NULL,
  `staff_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `teacher_role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `corox_model_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `register_staff_teacher`
--

INSERT INTO `register_staff_teacher` (`id`, `staff_id`, `teacher_role`, `class_id`, `corox_model_id`) VALUES
(180, '33', 'classteacher', '1', 54),
(181, '33', 'subjectteacher', '2', 54),
(182, '33', 'subjectteacher', '3', 54);

-- --------------------------------------------------------

--
-- Table structure for table `register_student_informations`
--

CREATE TABLE `register_student_informations` (
  `id` int(10) UNSIGNED NOT NULL,
  `student_firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_middlename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_dob` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_disability` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_list_disability` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_hobbies` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_registration_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_class_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_session` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `student_parent_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_localG` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_profile_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_corox_model_id` int(11) NOT NULL,
  `corox_model_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `register_student_informations`
--

INSERT INTO `register_student_informations` (`id`, `student_firstname`, `student_middlename`, `student_lastname`, `student_email`, `student_gender`, `student_phone`, `student_dob`, `student_disability`, `student_list_disability`, `student_hobbies`, `student_registration_number`, `student_address`, `student_city`, `student_class_id`, `student_session`, `student_parent_id`, `student_state`, `student_localG`, `student_profile_image`, `user_corox_model_id`, `corox_model_id`) VALUES
(1, 'Tobiloba', 'Olatunde', 'Adedeji', 'adedeji@gmail.com', 'male', '08188373898', '2007-01-03', 'no', '', 'reading', '01', '20 adediran close okeira', 'lagos', '1', '2020', '2', 'Lagos State', 'Ikeja', 'php2020.tmp.jpg', 0, 54),
(2, 'bolatito', 'bukola', 'Olukoya', 'bolatit@yahoo.com', 'female', '08145768934', '2010-02-11', 'no', '', 'reading and playing games', '02', '20 OLd Drive Adeniyi Jone', 'Adeniyi Jones', '1', '2020', '3', 'Lagos State', 'Ikeja', 'php1E2A.tmp.jpg', 0, 54),
(4, 'SCASCA', 'hgh', 'cfgj', 'mutiu.vbadepoju@livestock247.com', 'male', '45678', '2022-08-02', 'yes', 'sadxcfv', 'aszxc', '5554', 'xzc v', 'SDDS', '1', '2022', '2', 'Bayelsa State', 'Kolokuma/Opokuma', 'no image', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `register_subject`
--

CREATE TABLE `register_subject` (
  `id` int(10) UNSIGNED NOT NULL,
  `subject_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `corox_model_id` int(10) UNSIGNED DEFAULT NULL,
  `subject_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `register_subject`
--

INSERT INTO `register_subject` (`id`, `subject_name`, `corox_model_id`, `subject_date`) VALUES
(2, 'English', 54, '2020-06-03'),
(3, 'Mathematics', 54, '2020-06-04'),
(4, 'Physics', 54, '2020-06-04'),
(6, 'biology', 54, '2020-06-06');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`) VALUES
(1, 'admin'),
(2, 'member'),
(3, 'contributor');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `corox_models`
--
ALTER TABLE `corox_models`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `corox_model_role`
--
ALTER TABLE `corox_model_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `fk_corox` (`corox_model_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register_classes`
--
ALTER TABLE `register_classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register_memo`
--
ALTER TABLE `register_memo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register_parent_informations`
--
ALTER TABLE `register_parent_informations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register_period`
--
ALTER TABLE `register_period`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register_school_information`
--
ALTER TABLE `register_school_information`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `register_school_information_school_email_unique` (`school_email`);

--
-- Indexes for table `register_staff_informations`
--
ALTER TABLE `register_staff_informations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `register_staff_informations_staff_email_unique` (`staff_email`);

--
-- Indexes for table `register_staff_register`
--
ALTER TABLE `register_staff_register`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register_staff_teacher`
--
ALTER TABLE `register_staff_teacher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register_student_informations`
--
ALTER TABLE `register_student_informations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register_subject`
--
ALTER TABLE `register_subject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
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
-- AUTO_INCREMENT for table `corox_models`
--
ALTER TABLE `corox_models`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `corox_model_role`
--
ALTER TABLE `corox_model_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `register_classes`
--
ALTER TABLE `register_classes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `register_memo`
--
ALTER TABLE `register_memo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `register_parent_informations`
--
ALTER TABLE `register_parent_informations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `register_period`
--
ALTER TABLE `register_period`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `register_school_information`
--
ALTER TABLE `register_school_information`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `register_staff_informations`
--
ALTER TABLE `register_staff_informations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `register_staff_register`
--
ALTER TABLE `register_staff_register`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `register_staff_teacher`
--
ALTER TABLE `register_staff_teacher`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT for table `register_student_informations`
--
ALTER TABLE `register_student_informations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `register_subject`
--
ALTER TABLE `register_subject`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
