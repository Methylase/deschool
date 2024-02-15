-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 27, 2023 at 01:04 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
  `remember_token` varchar(300) NOT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `corox_models`
--

INSERT INTO `corox_models` (`id`, `email`, `password`, `remember_token`, `status`) VALUES
(54, 'methyl2007@gmail.com', '$2y$10$SxT9nzLZ2RVSGyCtmqeGB.k62QK17sGFYzDreZNa3TpFctL3NPUxu', 'Vy0nOB24VUH0pO64FHgkMMo2Uz0zuIqRfmJCSAFeQqmkA7c5UJNXpakPYTkR', NULL),
(51, 'adekunledare@gmail.com', '$2y$10$AyyosSJXJHeUyNswtj7dGu68a5jVhGnDLHAoz2RPGj/qLTme3QCii', 'n9lakxV3BzGwCea3vMKRQjdL66dxV9dpA98Lou3v9InGiTkG8V09kQDPMiO6', NULL),
(52, 'methyl2005@gmail.com', '$2y$10$AyyosSJXJHeUyNswtj7dGu68a5jVhGnDLHAoz2RPGj/qLTme3QCii', 'h47w2LC25c9Y39DF5q1KJnQqH593jTkr7b9E8TMK', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `corox_model_role`
--

CREATE TABLE `corox_model_role` (
  `id` int(11) NOT NULL,
  `corox_model_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `corox_model_role`
--

INSERT INTO `corox_model_role` (`id`, `corox_model_id`, `role_id`, `status`) VALUES
(138, 54, 1, NULL),
(127, 40, 1, NULL),
(136, 52, 2, NULL),
(139, 51, 2, NULL);

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
-- Table structure for table `register_academic_session`
--

CREATE TABLE `register_academic_session` (
  `id` int(11) NOT NULL,
  `term` varchar(40) NOT NULL,
  `session` varchar(40) NOT NULL,
  `corox_model_id` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `register_academic_session`
--

INSERT INTO `register_academic_session` (`id`, `term`, `session`, `corox_model_id`) VALUES
(1, 'firstterm', '2023-2024', '54');

-- --------------------------------------------------------

--
-- Table structure for table `register_aggregator`
--

CREATE TABLE `register_aggregator` (
  `id` int(11) NOT NULL,
  `student_id` varchar(40) NOT NULL,
  `subject_id` varchar(40) NOT NULL,
  `class_id` varchar(40) NOT NULL,
  `mark` varchar(40) NOT NULL,
  `mark_type` varchar(40) NOT NULL,
  `term` varchar(40) NOT NULL,
  `year` varchar(40) NOT NULL,
  `status` varchar(40) DEFAULT ' ',
  `corox_model_id` varchar(40) NOT NULL,
  `register_time` time NOT NULL,
  `register_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `register_aggregator`
--

INSERT INTO `register_aggregator` (`id`, `student_id`, `subject_id`, `class_id`, `mark`, `mark_type`, `term`, `year`, `status`, `corox_model_id`, `register_time`, `register_date`) VALUES
(15, '2', '3', '1', '13', 'note', 'first term', '2023-2024', 'open', '54', '09:00:56', '2023-03-30'),
(17, '1', '2', '2', '8', 'note', 'first term', '2023-2024', 'open', '54', '19:19:12', '2023-04-14');

-- --------------------------------------------------------

--
-- Table structure for table `register_assign_book`
--

CREATE TABLE `register_assign_book` (
  `id` int(10) NOT NULL,
  `student_id` varchar(40) NOT NULL,
  `class_id` varchar(40) NOT NULL,
  `book_id` varchar(40) NOT NULL,
  `book_condition` text NOT NULL,
  `book_status` varchar(50) NOT NULL,
  `assign_time` time NOT NULL,
  `return_time` time DEFAULT NULL,
  `assign_date` date NOT NULL,
  `corox_model_id` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `register_assign_book`
--

INSERT INTO `register_assign_book` (`id`, `student_id`, `class_id`, `book_id`, `book_condition`, `book_status`, `assign_time`, `return_time`, `assign_date`, `corox_model_id`) VALUES
(4, '1', '1', '2', '', 'returned', '08:45:49', '08:45:49', '2023-03-18', '54'),
(5, '2', '1', '2', '', 'returned', '08:45:49', '08:14:54', '2023-03-18', '54'),
(9, '1', '1', '2', 'dcdcsdcssdsvs', 'returned', '07:53:50', '08:45:49', '2023-03-19', '54'),
(10, '1', '1', '2', 'sdssdcsdcsd', 'returned', '07:55:55', '08:15:29', '2023-03-19', '54'),
(11, '1', '1', '2', 'vfsgs', 'returned', '08:15:53', '08:16:20', '2023-03-19', '54'),
(12, '1', '1', '2', 'sdssd', 'returned', '08:49:56', '08:57:59', '2023-03-19', '54'),
(13, '1', '1', '2', 'Ddddrrrrffdd', 'returned', '11:52:25', '12:12:54', '2023-03-19', '54'),
(14, '1', '1', '2', 'gergeer', 'returned', '17:12:47', '17:14:53', '2023-03-19', '54'),
(15, '1', '1', '2', 'ewfwfwwe', 'returned', '17:15:48', '17:16:07', '2023-03-19', '54'),
(16, '1', '1', '2', 'wgerge', 'returned', '17:17:51', '17:18:05', '2023-03-19', '54'),
(17, '1', '1', '2', 'aerghrtrh', 'returned', '17:18:44', '17:19:20', '2023-03-19', '54');

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
(3, 'basic3 ', 54, '2020-04-20'),
(4, 'basic4', 54, '2022-08-11'),
(5, 'Basic 6', 54, '2022-08-11'),
(6, 'SSS1', 54, '2023-04-17');

-- --------------------------------------------------------

--
-- Table structure for table `register_class_register_status`
--

CREATE TABLE `register_class_register_status` (
  `id` int(11) NOT NULL,
  `student_id` varchar(40) NOT NULL,
  `class_id` varchar(40) NOT NULL,
  `term` varchar(40) NOT NULL,
  `year` varchar(40) NOT NULL,
  `corox_model_id` varchar(40) NOT NULL,
  `register_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `register_class_register_status`
--

INSERT INTO `register_class_register_status` (`id`, `student_id`, `class_id`, `term`, `year`, `corox_model_id`, `register_date`) VALUES
(1, '1', '1', 'first term', '2023-2024', '54', '2023-03-25'),
(2, '1', '2', 'first term', '2023-2024', '54', '2023-04-14');

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
(4, 'mutiu.adepoju@livestock247.com', '54', 'mbnvxfvcvbn', 'vxvcbvn', 'bolatito@gmail.com methyl2007@yahoo.com'),
(5, 'methyl2007@gmail.com', '54', 'We are buying chalk', 'we will be buying chalk nextweek', 'methyl2007@yahoo.com'),
(6, 'methyl2007@yahoo.com', '54', 'Need Help For Paystack Implementation', 'fwefwefwe', 'methyl2007@gmail.com methyl2007@yahoo.com'),
(7, 'methyl2007@yahoo.com', '54', 'sfsdfsdfsdfsd', 'efwefwefw', 'methyl2007@gmail.com'),
(8, 'methyl2007@yahoo.com', '54', 'wefsdsd', 'sdvder', 'methyl2007@gmail.com'),
(9, 'methyl2007@yahoo.com', '54', 'wefsdsd', 'sdvder', 'methyl2007@yahoo.com'),
(10, 'methyl2007@yahoo.com', '54', 'We are buying chalk', 'gergger', 'methyl2007@gmail.com'),
(11, 'methyl2007@yahoo.com', '54', 'We are buying chalk', 'gergger', 'methyl2007@yahoo.com'),
(12, 'methyl2007@yahoo.com', '54', 'We are buying chalk', 'WEGWEFGFGWE', 'methyl2007@yahoo.com'),
(13, 'methyl2007@yahoo.com', '54', 'Need Help For Paystack Implementation', 'fwagagwwge', 'methyl2007@gmail.com'),
(14, 'methyl2007@yahoo.com', '54', 'Need Help For Paystack Implementation', 'fwagagwwge', 'methyl2007@yahoo.com'),
(15, 'methyl2007@gmail.com', '54', 'Staff Meeting', 'Good morning all staff i will like to remind everyone that we will be having our meeting this afternoon', 'methyl2007@gmail.com'),
(16, 'methyl2007@gmail.com', '54', 'Staff Meeting', 'Good morning all staff i will like to remind everyone that we will be having our meeting this afternoon', 'methyl2007@yahoo.com'),
(17, 'methyl2007@gmail.com', '54', 'Staff Meeting', 'Good morning all staff i will like to remind everyone that we will be having our meeting this afternoon', 'methyl2007@gmail.com'),
(18, 'methyl2007@gmail.com', '54', 'Staff Meeting', 'Good morning all staff i will like to remind everyone that we will be having our meeting this afternoon', 'methyl2007@yahoo.com'),
(19, 'methyl2007@yahoo.com', '54', 'Need Help For Paystack Implementation', 'sdgregwefwwefaaC  berb', 'methyl2007@gmail.com'),
(20, 'methyl2007@yahoo.com', '54', 'Need Help For Paystack Implementation', 'sdgregwefwwefaaC  berb', 'methyl2007@yahoo.com'),
(21, 'methyl2007@yahoo.com', '54', 'Need Help For Paystack Implementation', 'sdgregwefwwefaaC  berb', 'methyl2007@gmail.com'),
(22, 'methyl2007@yahoo.com', '54', 'Need Help For Paystack Implementation', 'sdgregwefwwefaaC  berb', 'methyl2007@yahoo.com');

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
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_corox_model_id` int(10) DEFAULT NULL,
  `corox_model_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `register_parent_informations`
--

INSERT INTO `register_parent_informations` (`id`, `parent_firstname`, `parent_middlename`, `parent_lastname`, `parent_email`, `parent_marital_status`, `parent_gender`, `parent_phone`, `parent_dob`, `parent_disability`, `parent_list_disability`, `parent_hobbies`, `parent_address`, `parent_city`, `parent_social_media`, `parent_state`, `parent_localG`, `parent_profile_image`, `status`, `user_corox_model_id`, `corox_model_id`) VALUES
(2, 'Adedeji', 'Olanrewaju', 'Adedeji', 'olalekan@gmail.com', 'married', 'male', '08188373898', '1976-01-20', 'no', '', 'meeting people', '20 Olanrewaju street', 'Ogba', 'olanrewaju@facebook', 'Lagos State', 'Ikeja', NULL, NULL, 0, 54),
(3, 'Folashade', 'bidemi', 'Olukoya', 'folashade@gmail.com', 'married', 'female', '', '1978-08-05', 'no', '', 'reading and meeting people', '20 Old Drive Adeniyi Jone', 'Adeniyi Jones', 'bidemi@gmail.com', 'Lagos State', 'Ikeja', 'phpAA32.tmp.jpg', NULL, 0, 54),
(7, 'jkhg', 'ddewwe', 'dscsd', 'temitope.akiola@livestock247.com', 'single', 'male', '45678', '2022-07-31', 'yes', 'fdfhf', 'ggfh', 'xfcgvbn', 'dfdfg', 'DS', 'Adamawa State', 'Fufure', NULL, NULL, 0, 54);

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
-- Table structure for table `register_result_estimator`
--

CREATE TABLE `register_result_estimator` (
  `id` int(11) NOT NULL,
  `estimator_type` varchar(40) NOT NULL,
  `estimator_value` varchar(40) NOT NULL,
  `corox_model_id` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `register_result_estimator`
--

INSERT INTO `register_result_estimator` (`id`, `estimator_type`, `estimator_value`, `corox_model_id`) VALUES
(1, 'first test', '15', '54'),
(8, 'second test', '25', '54'),
(9, 'note', '5', '54'),
(10, 'assignment', '5', '54'),
(11, 'test total', '40', '54'),
(12, 'examination', '60', '54');

-- --------------------------------------------------------

--
-- Table structure for table `register_sales_record`
--

CREATE TABLE `register_sales_record` (
  `id` int(11) NOT NULL,
  `stationary_id` varchar(40) NOT NULL,
  `student_id` varchar(40) NOT NULL,
  `quantity` varchar(40) NOT NULL,
  `transaction_type` varchar(40) NOT NULL,
  `corox_model_id` varchar(40) NOT NULL,
  `date` date NOT NULL,
  `time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `register_sales_record`
--

INSERT INTO `register_sales_record` (`id`, `stationary_id`, `student_id`, `quantity`, `transaction_type`, `corox_model_id`, `date`, `time`) VALUES
(1, '1', '1', '1', 'cash', '54', '2023-03-21', '21:10:55'),
(2, '1', '2', '1', 'transfer', '54', '2023-03-21', '21:12:59'),
(3, '1', '1', '1', 'teller', '54', '2023-03-21', '21:14:21'),
(4, '1', '1', '1', 'cash', '54', '2023-03-21', '22:18:19'),
(5, '1', '2', '1', 'transfer', '54', '2023-03-21', '22:25:05');

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
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `corox_model_id` int(10) UNSIGNED DEFAULT NULL,
  `user_corox_model_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `register_staff_informations`
--

INSERT INTO `register_staff_informations` (`id`, `staff_firstname`, `staff_middlename`, `staff_lastname`, `staff_email`, `staff_marital_status`, `staff_gender`, `staff_phone`, `staff_dob`, `staff_disability`, `staff_list_disability`, `staff_hobbies`, `staff_address`, `staff_city`, `staff_social_media`, `staff_state`, `staff_localG`, `staff_profile_image`, `status`, `corox_model_id`, `user_corox_model_id`, `created_at`, `updated_at`) VALUES
(33, 'adekunle', 'oludare', 'olumide', 'adekunledare@gmail.com', 'married', 'male', '08188378698', '1976-08-12', 'no', '', 'meeting people', '20 adediran close', 'ogba', 'dare@facebook', 'Lagos State', 'Ikeja', NULL, NULL, 54, 51, '2020-06-08 08:52:33', '2022-05-04 07:49:19'),
(34, 'Esther', 'Uri', 'Adewale', 'methyl2007@gmail.com', 'married', 'female', '08188378987', '1975-01-06', 'no', NULL, 'meeting people', '20 adediran close', 'Ogba', 'esther@facebook', 'Lagos State', 'Ikeja', NULL, NULL, 54, 52, '2020-06-08 09:02:57', '2020-06-08 09:05:27'),
(35, 'Adebayo', 'Tunde', 'Tejuosho', 'tejuosho@gmail.com', 'none', 'male', '08135389834', '1981-01-03', 'none', '', 'singing', 'william street', 'ikeja', '', 'none', 'none', 'php2145.tmp.jpg', NULL, 54, 0, '2020-06-14 09:56:10', '2020-06-15 06:07:31'),
(37, 'bolatito', 'oladele', 'sulaimon', 'bolatito@gmail.com', 'single', 'female', '08137389834', '', 'no', '', 'meeting poeple', 'sulaimon stree', 'ogba', '', 'Lagos State', 'Ikeja', 'phpF91A.tmp.jpg', NULL, 54, 0, '2020-06-15 03:34:16', '2020-06-15 06:05:10'),
(38, 'asxa', 'sd', 'sd', 'methyl2007@yahoo.com', 'none', 'female', '0907864532', '2021-01-22', 'yes', 'asssa', 'jhgf', 'uryyr', 'ewe', 'fgf', 'Enugu State', 'Igbo Eze South', NULL, NULL, 54, 0, '2021-01-13 21:46:38', '2021-01-13 21:46:38');

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
(5, '34', '2022-04-25', '8:58 AM', 'late', 54),
(6, '33', '2023-04-23', '12:00 PM', 'late', 54);

-- --------------------------------------------------------

--
-- Table structure for table `register_staff_teacher`
--

CREATE TABLE `register_staff_teacher` (
  `id` int(10) UNSIGNED NOT NULL,
  `staff_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `teacher_role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `corox_model_id` int(10) UNSIGNED DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `register_staff_teacher`
--

INSERT INTO `register_staff_teacher` (`id`, `staff_id`, `teacher_role`, `class_id`, `corox_model_id`, `status`) VALUES
(180, '33', 'classteacher', '1', 54, NULL),
(181, '33', 'subjectteacher', '2', 54, NULL),
(182, '33', 'subjectteacher', '3', 54, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `register_stationeries`
--

CREATE TABLE `register_stationeries` (
  `id` int(11) NOT NULL,
  `stationary_name` varchar(255) NOT NULL,
  `stationary_status` varchar(40) NOT NULL,
  `stationary_quantity` varchar(40) NOT NULL,
  `stationary_amount` varchar(40) NOT NULL,
  `corox_model_id` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `register_stationeries`
--

INSERT INTO `register_stationeries` (`id`, `stationary_name`, `stationary_status`, `stationary_quantity`, `stationary_amount`, `corox_model_id`) VALUES
(1, 'Mathematics', 'for-sale', '37', '4000', '54'),
(2, 'Mathematics', 'library', '29', '4000', '54');

-- --------------------------------------------------------

--
-- Table structure for table `register_student_class_status`
--

CREATE TABLE `register_student_class_status` (
  `id` int(11) NOT NULL,
  `student_id` varchar(40) NOT NULL,
  `class_id` varchar(40) NOT NULL,
  `corox_model_id` varchar(40) NOT NULL,
  `status` varchar(40) NOT NULL,
  `year` varchar(40) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `register_student_class_status`
--

INSERT INTO `register_student_class_status` (`id`, `student_id`, `class_id`, `corox_model_id`, `status`, `year`, `date`) VALUES
(1, '1', '1', '54', 'previous', '2023-2024', '2023-03-25'),
(2, '2', '1', '54', 'present', '2023-2024', '2023-03-25'),
(3, '4', '2', '54', 'present', '2023-2024', '2023-03-25'),
(6, '1', '2', '54', 'present', '2023-2024', '2023-03-26');

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
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_corox_model_id` int(11) NOT NULL,
  `corox_model_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `register_student_informations`
--

INSERT INTO `register_student_informations` (`id`, `student_firstname`, `student_middlename`, `student_lastname`, `student_email`, `student_gender`, `student_phone`, `student_dob`, `student_disability`, `student_list_disability`, `student_hobbies`, `student_registration_number`, `student_address`, `student_city`, `student_class_id`, `student_session`, `student_parent_id`, `student_state`, `student_localG`, `student_profile_image`, `status`, `user_corox_model_id`, `corox_model_id`) VALUES
(1, 'Tobiloba', 'Olatunde', 'Adedeji', 'adedeji@gmail.com', 'male', '08188373898', '2007-01-03', 'no', '', 'reading', '01', '20 adediran close okeira', 'lagos', '1', '2020', '2', 'Lagos State', 'Ikeja', 'php2020.tmp.jpg', NULL, 0, 54),
(2, 'bolatito', 'bukola', 'Olukoya', 'bolatit@yahoo.com', 'female', '08145768934', '2010-02-11', 'no', '', 'reading and playing games', '02', '20 OLd Drive Adeniyi Jone', 'Adeniyi Jones', '1', '2020', '3', 'Lagos State', 'Ikeja', 'php1E2A.tmp.jpg', NULL, 0, 54),
(4, 'SCASCA', 'hgh', 'cfgj', 'mutiu.vbadepoju@livestock247.com', 'male', '45678', '2022-08-02', 'yes', 'sadxcfv', 'aszxc', '5554', 'xzc v', 'SDDS', '1', '2022', '2', 'Bayelsa State', 'Kolokuma/Opokuma', 'no image', NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `register_student_register`
--

CREATE TABLE `register_student_register` (
  `id` int(10) UNSIGNED NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `class_id` varchar(40) NOT NULL,
  `register_date` date NOT NULL,
  `register_time` varchar(255) NOT NULL,
  `register_resumption_status` varchar(10) NOT NULL,
  `corox_model_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `register_student_register`
--

INSERT INTO `register_student_register` (`id`, `student_id`, `class_id`, `register_date`, `register_time`, `register_resumption_status`, `corox_model_id`) VALUES
(1, '1', '1', '2023-01-03', '3:50', 'on-time', 54),
(2, '2', '1', '2023-01-03', '3:50', 'on-time', 54),
(3, '4', '2', '2023-01-03', '3:50', 'on-time', 54),
(4, '1', '1', '2023-03-26', '3:50', 'on-time', 54);

-- --------------------------------------------------------

--
-- Table structure for table `register_student_status`
--

CREATE TABLE `register_student_status` (
  `id` int(10) NOT NULL,
  `student_id` varchar(40) NOT NULL,
  `class_id` varchar(40) NOT NULL,
  `term` varchar(40) NOT NULL,
  `year` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `register_student_subject`
--

CREATE TABLE `register_student_subject` (
  `id` int(10) NOT NULL,
  `student_id` varchar(40) NOT NULL,
  `subject_id` varchar(40) NOT NULL,
  `class_id` varchar(40) NOT NULL,
  `department` varchar(40) NOT NULL,
  `term` varchar(40) NOT NULL,
  `year` varchar(40) NOT NULL,
  `corox_model_id` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `register_student_subject`
--

INSERT INTO `register_student_subject` (`id`, `student_id`, `subject_id`, `class_id`, `department`, `term`, `year`, `corox_model_id`) VALUES
(1, '1', '2', '1', '', 'first term', '2023-2024', '54'),
(2, '2', '3', '1', '', 'first term', '2023-2024', '54'),
(3, '2', '4', '1', '', 'first term', '2023-2024', '54'),
(4, '1', '6', '1', '', 'first term', '2023-2024', '54'),
(5, '1', '4', '1', '', 'first term', '2023-2024', '54'),
(6, '1', '3', '1', '', 'first term', '2023-2024', '54'),
(7, '1', '2', '2', '', 'first term', '2023-2024', '54'),
(8, '1', '3', '2', '', 'first term', '2023-2024', '54'),
(9, '1', '4', '2', '', 'first term', '2023-2024', '54'),
(10, '1', '6', '2', '', 'first term', '2023-2024', '54');

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
(6, 'biology', 54, '2020-06-06'),
(7, 'Chemistry', 54, '2023-04-17'),
(8, 'Further-mathematics', 54, '2023-04-17'),
(9, 'commerce', 54, '2023-04-17'),
(10, 'Account', 54, '2023-04-17'),
(11, 'Civi education', 54, '2023-04-17'),
(12, 'Technical drawing', 54, '2023-04-17');

-- --------------------------------------------------------

--
-- Table structure for table `register_teacher_subject`
--

CREATE TABLE `register_teacher_subject` (
  `id` int(11) NOT NULL,
  `teacher_id` varchar(40) NOT NULL,
  `subject_id` varchar(40) NOT NULL,
  `corox_model_id` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `register_teacher_subject`
--

INSERT INTO `register_teacher_subject` (`id`, `teacher_id`, `subject_id`, `corox_model_id`) VALUES
(8, '33', '2', '54');

-- --------------------------------------------------------

--
-- Table structure for table `register_transaction`
--

CREATE TABLE `register_transaction` (
  `id` int(11) NOT NULL,
  `class_id` varchar(40) NOT NULL,
  `student_id` varchar(40) NOT NULL,
  `corox_model_id` varchar(40) NOT NULL,
  `term` varchar(40) NOT NULL,
  `year` varchar(40) NOT NULL,
  `transaction_type` varchar(40) NOT NULL,
  `amount` varchar(40) NOT NULL,
  `transaction_time` time NOT NULL,
  `transaction_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `register_transaction`
--

INSERT INTO `register_transaction` (`id`, `class_id`, `student_id`, `corox_model_id`, `term`, `year`, `transaction_type`, `amount`, `transaction_time`, `transaction_date`) VALUES
(1, '1', '2', '54', 'first term', '2023-2024', 'schoolfees', '45000', '08:47:54', '2023-04-23'),
(2, '2', '1', '54', 'first term', '2023-2024', 'schoolfees', '80000', '15:53:59', '2023-01-23');

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
-- Indexes for table `register_academic_session`
--
ALTER TABLE `register_academic_session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register_aggregator`
--
ALTER TABLE `register_aggregator`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register_assign_book`
--
ALTER TABLE `register_assign_book`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register_classes`
--
ALTER TABLE `register_classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register_class_register_status`
--
ALTER TABLE `register_class_register_status`
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
-- Indexes for table `register_result_estimator`
--
ALTER TABLE `register_result_estimator`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register_sales_record`
--
ALTER TABLE `register_sales_record`
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
-- Indexes for table `register_stationeries`
--
ALTER TABLE `register_stationeries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register_student_class_status`
--
ALTER TABLE `register_student_class_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register_student_informations`
--
ALTER TABLE `register_student_informations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register_student_register`
--
ALTER TABLE `register_student_register`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register_student_status`
--
ALTER TABLE `register_student_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register_student_subject`
--
ALTER TABLE `register_student_subject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register_subject`
--
ALTER TABLE `register_subject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register_teacher_subject`
--
ALTER TABLE `register_teacher_subject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register_transaction`
--
ALTER TABLE `register_transaction`
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
-- AUTO_INCREMENT for table `register_academic_session`
--
ALTER TABLE `register_academic_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `register_aggregator`
--
ALTER TABLE `register_aggregator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `register_assign_book`
--
ALTER TABLE `register_assign_book`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `register_classes`
--
ALTER TABLE `register_classes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `register_class_register_status`
--
ALTER TABLE `register_class_register_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `register_memo`
--
ALTER TABLE `register_memo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `register_parent_informations`
--
ALTER TABLE `register_parent_informations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `register_period`
--
ALTER TABLE `register_period`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `register_result_estimator`
--
ALTER TABLE `register_result_estimator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `register_sales_record`
--
ALTER TABLE `register_sales_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `register_staff_teacher`
--
ALTER TABLE `register_staff_teacher`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT for table `register_stationeries`
--
ALTER TABLE `register_stationeries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `register_student_class_status`
--
ALTER TABLE `register_student_class_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `register_student_informations`
--
ALTER TABLE `register_student_informations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `register_student_register`
--
ALTER TABLE `register_student_register`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `register_student_status`
--
ALTER TABLE `register_student_status`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `register_student_subject`
--
ALTER TABLE `register_student_subject`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `register_subject`
--
ALTER TABLE `register_subject`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `register_teacher_subject`
--
ALTER TABLE `register_teacher_subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `register_transaction`
--
ALTER TABLE `register_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
