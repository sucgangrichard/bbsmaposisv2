-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2025 at 05:29 AM
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
-- Database: `bbsmaposis_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `email_settings`
--

CREATE TABLE `email_settings` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `email_settings`
--

INSERT INTO `email_settings` (`id`, `email`) VALUES
(1, 'sucgangrichard_act@plmun.edu.ph');

-- --------------------------------------------------------

--
-- Table structure for table `notification_log`
--

CREATE TABLE `notification_log` (
  `id` int(11) NOT NULL,
  `last_notification` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification_log`
--

INSERT INTO `notification_log` (`id`, `last_notification`) VALUES
(1, '2025-01-01 17:46:22'),
(2, '2025-01-02 17:47:18');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `cat_id` int(11) NOT NULL,
  `category` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`cat_id`, `category`) VALUES
(2, 'Dry'),
(3, 'Wet -Chilled'),
(5, 'Wet - Freezer');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_do_category`
--

CREATE TABLE `tbl_do_category` (
  `do_cat_id` int(11) NOT NULL,
  `do` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_do_category`
--

INSERT INTO `tbl_do_category` (`do_cat_id`, `do`) VALUES
(1, 'Dine In'),
(2, 'Take Out');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice`
--

CREATE TABLE `tbl_invoice` (
  `invoice_id` int(11) NOT NULL,
  `total_due` double NOT NULL,
  `change_amount` double NOT NULL,
  `paid` double NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `vatable_sales` double NOT NULL,
  `vat_amount` double NOT NULL,
  `order_date` date NOT NULL,
  `table_number` int(11) NOT NULL,
  `dine_in` varchar(255) NOT NULL,
  `menu_category` varchar(255) NOT NULL,
  `time_value` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_invoice`
--

INSERT INTO `tbl_invoice` (`invoice_id`, `total_due`, `change_amount`, `paid`, `payment_type`, `vatable_sales`, `vat_amount`, `order_date`, `table_number`, `dine_in`, `menu_category`, `time_value`) VALUES
(1, 209, 0, 209, 'CASH', 186.61, 22.39, '2024-12-01', 12, 'Dine In', 'Lauriat Family', '12:30:00'),
(2, 72, 0, 72, 'CASH', 64.29, 7.71, '2024-12-02', 7, 'Take Out', 'Drinks', '02:15:00'),
(3, 143, 7, 150, 'CARD', 127.68, 15.32, '2024-12-03', 5, 'Dine In', 'Chao Fan', '01:45:00'),
(4, 77, 3, 80, 'CASH', 68.75, 8.25, '2024-12-04', 8, 'Take Out', 'Siopao Dimsum', '11:00:00'),
(5, 193, 0, 193, 'CARD', 172.32, 20.68, '2024-12-05', 3, 'Dine In', 'Noodles Soup', '06:45:00'),
(6, 164, 36, 200, 'CASH', 146.43, 17.57, '2024-12-06', 9, 'Take Out', 'Rice Meals', '12:00:00'),
(7, 237, 0, 237, 'CARD', 211.61, 25.39, '2024-12-07', 10, 'Dine In', 'Lauriat Family', '07:15:00'),
(8, 109, 41, 150, 'CASH', 97.32, 11.68, '2024-12-08', 6, 'Take Out', 'MilkSha', '03:30:00'),
(9, 176, 24, 200, 'CASH', 157.14, 18.86, '2024-12-09', 4, 'Dine In', 'BreakFast', '08:00:00'),
(10, 131, 19, 150, 'CASH', 116.96, 14.04, '2024-12-10', 2, 'Take Out', 'BreakFast', '09:45:00'),
(11, 77, 23, 100, 'CASH', 68.75, 8.25, '2024-12-11', 15, 'Dine In', 'Sdish Dessert', '02:00:00'),
(12, 83, 17, 100, 'CASH', 74.11, 8.89, '2024-12-12', 14, 'Take Out', 'Siopao Dimsum', '04:15:00'),
(13, 231, 69, 300, 'CASH', 206.25, 24.75, '2024-12-13', 13, 'Dine In', 'Chao Fan', '07:45:00'),
(14, 132, 18, 150, 'CASH', 117.86, 14.14, '2024-12-14', 11, 'Take Out', 'MilkSha', '01:00:00'),
(15, 98, 2, 100, 'CASH', 87.5, 10.5, '2024-12-15', 1, 'Dine In', 'Rice Meals', '12:15:00'),
(16, 243, 7, 250, 'CARD', 217.86, 25.14, '2024-12-16', 17, 'Take Out', 'Siopao Dimsum', '06:00:00'),
(17, 176, 24, 200, 'CASH', 157.14, 18.86, '2024-12-17', 16, 'Dine In', 'Lauriat Family', '08:45:00'),
(18, 131, 19, 150, 'CASH', 116.96, 14.04, '2024-12-18', 9, 'Take Out', 'BreakFast', '10:30:00'),
(19, 98, 2, 100, 'CASH', 87.5, 10.5, '2024-12-19', 12, 'Dine In', 'Rice Meals', '01:45:00'),
(20, 198, 2, 200, 'CARD', 176.79, 21.21, '2024-12-20', 4, 'Take Out', 'Sdish Dessert', '11:15:00'),
(21, 209, 41, 250, 'CASH', 186.61, 22.39, '2024-12-21', 6, 'Dine In', 'Noodles Soup', '06:15:00'),
(22, 120, 30, 150, 'CASH', 107.14, 12.86, '2024-12-22', 3, 'Take Out', 'Chao Fan', '02:30:00'),
(23, 263, 37, 300, 'CARD', 234.82, 28.18, '2024-12-23', 11, 'Dine In', 'MilkSha', '07:45:00'),
(24, 198, 2, 200, 'CASH', 176.79, 21.21, '2024-12-24', 7, 'Take Out', 'Siopao Dimsum', '04:45:00'),
(25, 164, 36, 200, 'CARD', 146.43, 17.57, '2024-12-25', 10, 'Dine In', 'Rice Meals', '12:00:00'),
(26, 237, 63, 300, 'CASH', 211.61, 25.39, '2024-12-26', 13, 'Take Out', 'Lauriat Family', '05:15:00'),
(27, 86, 14, 100, 'CASH', 76.79, 9.21, '2024-12-27', 1, 'Dine In', 'Sdish Dessert', '10:00:00'),
(28, 209, 41, 250, 'CASH', 186.61, 22.39, '2024-12-28', 8, 'Take Out', 'Noodles Soup', '07:15:00'),
(29, 142, 8, 150, 'CASH', 126.79, 15.21, '2024-12-29', 14, 'Dine In', 'Chao Fan', '06:30:00'),
(30, 109, 41, 150, 'CASH', 97.32, 11.68, '2024-12-30', 2, 'Take Out', 'MilkSha', '05:15:00'),
(31, 215, 35, 250, 'CASH', 191.96, 23.04, '2024-12-31', 5, 'Dine In', 'Lauriat Family', '08:00:00'),
(69, 357, 43, 400, 'Cash', 318.75, 38.25, '2025-01-01', 32, 'Dine In', 'NULL', '04:46:19'),
(70, 407, 93, 500, 'Cash', 363.39, 43.61, '2025-01-03', 45, 'Take Out', 'NULL', '02:09:24'),
(71, 358, 42, 400, 'Cash', 319.64, 38.36, '2025-01-02', 56, 'Dine In', 'NULL', '02:10:09'),
(72, 3280, 720, 4000, 'Cash', 2928.57, 351.43, '2025-01-03', 32, 'Dine In', '', '12:17:01');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice_details`
--

CREATE TABLE `tbl_invoice_details` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `qty` double NOT NULL,
  `total_per_qty` double NOT NULL,
  `table_number` int(11) NOT NULL,
  `dine_in` varchar(255) NOT NULL,
  `menu_category` varchar(255) NOT NULL,
  `order_date` date NOT NULL,
  `time_value` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_invoice_details`
--

INSERT INTO `tbl_invoice_details` (`id`, `invoice_id`, `menu_id`, `product_name`, `qty`, `total_per_qty`, `table_number`, `dine_in`, `menu_category`, `order_date`, `time_value`) VALUES
(255, 59, 91, 'IMPERIAL CHICKEN CHOP WITH EGG FRIED RICE', 1, 98, 50, 'NULL', 'NULL', '2024-12-26', '18:24:55'),
(256, 59, 130, 'SWEET & SOUR FISH LAURIAT', 1, 243, 50, 'NULL', 'NULL', '2024-12-26', '18:24:55'),
(257, 59, 138, 'LYCHEE FRUIT TEA WITH JELLY', 1, 109, 50, 'NULL', 'NULL', '2024-12-26', '18:24:55'),
(265, 60, 48, 'CHAO FAN WITH 2pc FRIED CHICKEN', 1, 231, 60, 'NULL', 'NULL', '2024-12-27', '00:00:00'),
(266, 60, 129, 'SWEET & SOUR CHICKEN LAURIAT', 1, 237, 60, 'NULL', 'NULL', '2024-12-27', '00:00:00'),
(267, 60, 133, 'BREAKFAST BEEF CHAO FAN', 1, 131, 60, 'NULL', 'NULL', '2024-12-27', '00:00:00'),
(268, 60, 90, 'CHIX & SAUCE RICE MEAL', 1, 164, 60, 'NULL', 'NULL', '2024-12-27', '00:00:00'),
(269, 61, 46, 'BEEF CHAO FAN', 45, 4410, 45, 'NULL', 'NULL', '2024-12-27', '16:25:53'),
(270, 62, 77, '2PC SIOMAI', 1, 44, 61, 'NULL', 'NULL', '2024-12-28', '01:55:38'),
(271, 62, 119, 'ASIAN SPICY SAUCE', 1, 17, 61, 'NULL', 'NULL', '2024-12-28', '01:55:38'),
(272, 63, 78, '3PC SIOPAO BOX', 1, 162, 47, 'NULL', 'NULL', '2024-12-28', '01:56:15'),
(273, 63, 138, 'LYCHEE FRUIT TEA WITH JELLY', 1, 109, 47, 'NULL', 'NULL', '2024-12-28', '01:56:15'),
(274, 63, 119, 'ASIAN SPICY SAUCE', 1, 17, 47, 'NULL', 'NULL', '2024-12-28', '01:56:15'),
(275, 63, 134, 'BREAKFAST CRISPY WONTON BEEF CHAO FAN', 1, 187, 47, 'NULL', 'NULL', '2024-12-28', '01:56:15'),
(276, 64, 91, 'IMPERIAL CHICKEN CHOP WITH EGG FRIED RICE', 5, 490, 20, 'NULL', 'NULL', '2024-12-28', '02:29:41'),
(277, 64, 139, 'MILKSHA PERFECT PAIR good for 2', 5, 1315, 20, 'NULL', 'NULL', '2024-12-28', '02:29:41'),
(278, 65, 39, 'BEEF MAMI', 22, 4246, 70, 'NULL', 'NULL', '2024-12-28', '02:32:49'),
(279, 66, 46, 'BEEF CHAO FAN', 11, 1078, 23, 'NULL', 'NULL', '2024-12-29', '14:16:51'),
(280, 67, 136, 'BLACK TEA LATTE WITH PUDDING', 1, 132, 45, 'NULL', 'NULL', '2024-12-30', '16:26:23'),
(281, 67, 134, 'BREAKFAST CRISPY WONTON BEEF CHAO FAN', 7, 1309, 45, 'NULL', 'NULL', '2024-12-30', '16:26:23'),
(282, 67, 126, 'WONTON SOUP', 1, 55, 45, 'NULL', 'NULL', '2024-12-30', '16:26:23'),
(283, 67, 91, 'IMPERIAL CHICKEN CHOP WITH EGG FRIED RICE', 1, 98, 45, 'NULL', 'NULL', '2024-12-30', '16:26:23'),
(284, 68, 119, 'ASIAN SPICY SAUCE', 20, 340, 45, 'NULL', 'NULL', '2024-12-30', '16:52:26'),
(285, 69, 39, 'BEEF MAMI', 1, 193, 32, 'NULL', 'NULL', '2025-01-01', '04:46:19'),
(286, 69, 90, 'CHIX & SAUCE RICE MEAL', 1, 164, 32, 'NULL', 'NULL', '2025-01-01', '04:46:19'),
(287, 70, 90, 'CHIX & SAUCE RICE MEAL', 1, 164, 45, 'NULL', 'NULL', '2025-01-03', '02:09:24'),
(288, 70, 130, 'SWEET & SOUR FISH LAURIAT', 1, 243, 45, 'NULL', 'NULL', '2025-01-03', '02:09:24'),
(292, 71, 134, 'BREAKFAST CRISPY WONTON BEEF CHAO FAN', 1, 187, 56, 'NULL', 'NULL', '2025-01-03', '00:00:00'),
(293, 71, 137, 'HONEY PEARL BLACK TEA LATTE', 1, 132, 56, 'NULL', 'NULL', '2025-01-03', '00:00:00'),
(294, 71, 122, 'EXTRA PLAIN RICE', 1, 39, 56, 'NULL', 'NULL', '2025-01-03', '00:00:00'),
(295, 72, 90, 'CHIX & SAUCE RICE MEAL', 20, 3280, 32, '', '', '2025-01-03', '12:17:01');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menu_category`
--

CREATE TABLE `tbl_menu_category` (
  `menu_cat_id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_menu_category`
--

INSERT INTO `tbl_menu_category` (`menu_cat_id`, `category`) VALUES
(10, 'Noodles Soup'),
(11, 'Chao Fan'),
(12, 'Drinks'),
(13, 'Siopao Dimsum'),
(14, 'Rice Meals'),
(15, 'Lauriat Family'),
(16, 'MilkSha'),
(17, 'BreakFast'),
(18, 'Sdish Dessert');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mmenu`
--

CREATE TABLE `tbl_mmenu` (
  `menu_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `available` int(11) NOT NULL,
  `price` float NOT NULL,
  `image` varchar(255) NOT NULL,
  `updated_date` date NOT NULL,
  `approved_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_mmenu`
--

INSERT INTO `tbl_mmenu` (`menu_id`, `product_name`, `category`, `available`, `price`, `image`, `updated_date`, `approved_by`) VALUES
(39, 'BEEF MAMI', 'Noodles Soup', 23, 193, '', '2024-12-24', 'MOD'),
(40, 'BEEF WONTON MAMI', 'Noodles Soup', 19, 209, '', '2024-12-24', 'MOD'),
(41, 'LARGE WONTON MAMI', 'Noodles Soup', 19, 143, '', '2024-12-24', 'MOD'),
(42, 'PANCIT CANTON', 'Noodles Soup', 58, 83, '', '2024-12-24', 'MOD'),
(43, 'PANCIT CANTON WITH FRIED CHCIKEN', 'Noodles Soup', 25, 198, '', '2024-12-24', 'MOD'),
(44, 'REGULAR WONTON MAMI', 'Noodles Soup', 64, 98, '', '2024-12-24', 'MOD'),
(45, 'WONTON MAMI WITH ASADO SIOPAO', 'Noodles Soup', 31, 149, '', '2024-12-24', 'MOD'),
(46, 'BEEF CHAO FAN', 'Chao Fan', 15, 98, '6770edbcc1d9d.jpg', '2024-12-24', 'MOD'),
(47, 'CHAO FAN WITH 1 PC FRIED CHICKEN', 'Chao Fan', 29, 142, '', '2024-12-24', 'MOD'),
(48, 'CHAO FAN WITH 2pc FRIED CHICKEN', 'Chao Fan', 24, 231, '', '2024-12-24', 'MOD'),
(49, 'CHAO FAN WITH CHIX & SAUCE', 'Chao Fan', 35, 208, '', '2024-12-24', 'MOD'),
(50, 'CHAO FAN WITH SWEET & SOUR CHICKEN', 'Chao Fan', 25, 208, '', '2024-12-24', 'MOD'),
(51, 'CRISPY WONTON CHAO FAN', 'Chao Fan', 45, 120, '', '2024-12-24', 'MOD'),
(52, 'CRISPY WONTON SPICY CHAO FAN', 'Chao Fan', 50, 142, '', '2024-12-24', 'MOD'),
(53, 'PORK CHAO FAN', 'Chao Fan', 70, 55, '', '2024-12-24', 'MOD'),
(54, 'PORK CHAO FAN FRIED CHICKEN', 'Chao Fan', 35, 142, '', '2024-12-24', 'MOD'),
(55, 'SIOMAI BEEF CHAO FAN', 'Chao Fan', 40, 143, '', '2024-12-24', 'MOD'),
(56, 'SIOMAI CHAO FAN', 'Chao Fan', 60, 109, '', '2024-12-24', 'MOD'),
(57, 'SIOMAI SPICY CHAO FAN', 'Chao Fan', 45, 131, '', '2024-12-24', 'MOD'),
(58, 'SPICY CHAO FAN', 'Chao Fan', 65, 76, '', '2024-12-24', 'MOD'),
(59, 'SPICY CHAO FAN WITH FRIED CHICKEN', 'Chao Fan', 30, 164, '', '2024-12-24', 'MOD'),
(60, 'SPRITE', 'Drinks', 100, 72, '', '2024-12-24', 'MOD'),
(61, 'PINEAPPLE JUICE', 'Drinks', 90, 72, '', '2024-12-24', 'MOD'),
(62, 'PEPSI', 'Drinks', 106, 72, '', '2024-12-24', 'MOD'),
(63, 'MUG ROOTBEER', 'Drinks', 81, 72, '', '2024-12-24', 'MOD'),
(64, 'MOUNTAIN DEW', 'Drinks', 90, 72, '', '2024-12-24', 'MOD'),
(65, 'ICED TEA', 'Drinks', 120, 72, '', '2024-12-24', 'MOD'),
(66, 'COKE ZERO', 'Drinks', 80, 72, '', '2024-12-24', 'MOD'),
(67, 'COKE', 'Drinks', 114, 72, '', '2024-12-24', 'MOD'),
(76, '2PC FRIED ASADO SIOPAO', 'Siopao Dimsum', 50, 83, '', '2024-12-24', 'MOD'),
(77, '2PC SIOMAI', 'Siopao Dimsum', 58, 44, '', '2024-12-24', 'MOD'),
(78, '3PC SIOPAO BOX', 'Siopao Dimsum', 26, 162, '', '2024-12-24', 'MOD'),
(79, '4PC FRIED SIOPAO BOX', 'Siopao Dimsum', 38, 165, '', '2024-12-24', 'MOD'),
(80, '4PC LUMPIANG SHANGHAI', 'Siopao Dimsum', 61, 72, '', '2024-12-24', 'MOD'),
(81, '4PC SIOMAI', 'Siopao Dimsum', 65, 66, '', '2024-12-24', 'MOD'),
(82, '6PC SPICY WONTON', 'Siopao Dimsum', 50, 77, '', '2024-12-24', 'MOD'),
(83, '6PC CRISPY WONTON WITH SWEET CHILI', 'Siopao Dimsum', 45, 77, '', '2024-12-24', 'MOD'),
(84, 'BOLA-BOLA SIOPAO SUPREME', 'Siopao Dimsum', 55, 77, '', '2024-12-24', 'MOD'),
(85, 'CHUNKY ASADO SIOPAO', 'Siopao Dimsum', 70, 54, '', '2024-12-24', 'MOD'),
(86, 'DIMSUM MIX PLATTER', 'Siopao Dimsum', 25, 243, '', '2024-12-24', 'MOD'),
(87, 'FRIED PORK SIOMAI GROUP PLATTER', 'Siopao Dimsum', 30, 198, '', '2024-12-24', 'MOD'),
(88, 'LUMPIANG SHANGHAI GROUP PLATTER', 'Siopao Dimsum', 24, 215, '', '2024-12-24', 'MOD'),
(89, 'STEAMED PORK SIOMAI GROUP PLATTER', 'Siopao Dimsum', 30, 198, '', '2024-12-24', 'MOD'),
(90, 'CHIX & SAUCE RICE MEAL', 'Rice Meals', 6, 164, '', '2024-12-24', 'MOD'),
(91, 'IMPERIAL CHICKEN CHOP WITH EGG FRIED RICE', 'Rice Meals', 30, 98, '', '2024-12-24', 'MOD'),
(92, 'IMPERIAL CHICKEN CHOP WITH WHITE RICE', 'Rice Meals', 59, 83, '', '2024-12-24', 'MOD'),
(93, 'LUMPIANG SHANGHAI RICE MEAL', 'Rice Meals', 51, 83, '', '2024-12-24', 'MOD'),
(118, '3PC BUCHI', 'Sdish Dessert', 23, 86, '', '2024-12-24', 'MOD'),
(119, 'ASIAN SPICY SAUCE', 'Sdish Dessert', 19, 17, '677260b7d14dc.png', '2024-12-24', 'MOD'),
(120, 'CHICHARAP', 'Sdish Dessert', 31, 66, '', '2024-12-24', 'MOD'),
(121, 'EXTRA EGG FRIED RICE', 'Sdish Dessert', 29, 50, '', '2024-12-24', 'MOD'),
(122, 'EXTRA PLAIN RICE', 'Sdish Dessert', 29, 39, '', '2024-12-24', 'MOD'),
(123, 'KANGKONG WITH CHINESE BAGOONG', 'Sdish Dessert', 35, 77, '', '2024-12-24', 'MOD'),
(124, 'NEW! 3pc ASSORTED BUCHI', 'Sdish Dessert', 36, 97, '', '2024-12-24', 'MOD'),
(125, 'STIR FRIED BOK CHOY', 'Sdish Dessert', 36, 77, '', '2024-12-24', 'MOD'),
(126, 'WONTON SOUP', 'Sdish Dessert', 15, 55, '', '2024-12-24', 'MOD'),
(127, 'CHINESE STYLED FRIED CHICKEN LAURIAT', 'Lauriat Family', 23, 209, '', '2024-12-24', 'MOD'),
(128, 'CHIX & SAUCE LAURIAT', 'Lauriat Family', 14, 237, '', '2024-12-24', 'MOD'),
(129, 'SWEET & SOUR CHICKEN LAURIAT', 'Lauriat Family', 39, 237, '', '2024-12-24', 'MOD'),
(130, 'SWEET & SOUR FISH LAURIAT', 'Lauriat Family', 12, 243, '', '2024-12-24', 'MOD'),
(131, 'SWEET & SOUR PORK LAURIAT', 'Lauriat Family', 69, 237, '', '2024-12-24', 'MOD'),
(132, 'BEEF TAPA', 'BreakFast', 15, 176, '676d773f89c3c.jpg', '2024-12-24', 'MOD'),
(133, 'BREAKFAST BEEF CHAO FAN', 'BreakFast', 15, 131, '676d76f547669.jpg', '2024-12-24', 'MOD'),
(134, 'BREAKFAST CRISPY WONTON BEEF CHAO FAN', 'BreakFast', 16, 187, '6772598e4011c.jpg', '2024-12-24', 'MOD'),
(135, 'BREAKFAST CRISPY WONTON CHAO FAN', 'BreakFast', 14, 153, '', '2024-12-24', 'MOD'),
(136, 'BLACK TEA LATTE WITH PUDDING', 'MilkSha', 20, 132, '', '2024-12-24', 'MOD'),
(137, 'HONEY PEARL BLACK TEA LATTE', 'MilkSha', 12, 132, '', '2024-12-24', 'MOD'),
(138, 'LYCHEE FRUIT TEA WITH JELLY', 'MilkSha', 14, 109, '676d77510e9b1.jpg', '2024-12-24', 'MOD'),
(139, 'MILKSHA PERFECT PAIR good for 2', 'MilkSha', 15, 263, '676ef231488f1.jpg', '2024-12-24', 'MOD');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `expiration_date` date NOT NULL,
  `date_of_receipt` date NOT NULL,
  `received_by` varchar(255) NOT NULL,
  `condition_at_receipt` varchar(255) NOT NULL,
  `packaging_type` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`id`, `product_id`, `barcode`, `product_name`, `stock`, `category`, `description`, `expiration_date`, `date_of_receipt`, `received_by`, `condition_at_receipt`, `packaging_type`, `product_image`) VALUES
(8, 0, '50096610', 'Product 2', 15, 'Dry', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.    ', '2024-12-31', '2024-12-21', 'Ms. Norhanah', 'NULL', 'Cartons', '67669a5c3d08f.jpg'),
(9, 0, '17784196', 'Product 3', 15, 'Wet - Freezer', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.             ', '2024-12-31', '2024-12-21', 'Ms. Jade', 'NULL', 'Cans', '67669aa712001.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_taxdis`
--

CREATE TABLE `tbl_taxdis` (
  `taxdis_id` int(11) NOT NULL,
  `vat` float NOT NULL,
  `seniordiscount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_taxdis`
--

INSERT INTO `tbl_taxdis` (`taxdis_id`, `vat`, `seniordiscount`) VALUES
(1, 12, 20);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `userpassword` varchar(50) NOT NULL,
  `role` varchar(20) NOT NULL,
  `logintime` datetime NOT NULL,
  `logout` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `username`, `userpassword`, `role`, `logintime`, `logout`) VALUES
(1, 'admin', 'admin', 'Admin', '2025-01-03 11:50:10', '2025-01-03 01:23:57'),
(2, 'user', 'user', 'User', '2024-12-26 16:03:48', '2025-01-01 04:46:27');

-- --------------------------------------------------------

--
-- Table structure for table `time_records`
--

CREATE TABLE `time_records` (
  `id` int(11) NOT NULL,
  `time_value` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `email_settings`
--
ALTER TABLE `email_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_log`
--
ALTER TABLE `notification_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `tbl_do_category`
--
ALTER TABLE `tbl_do_category`
  ADD PRIMARY KEY (`do_cat_id`);

--
-- Indexes for table `tbl_invoice`
--
ALTER TABLE `tbl_invoice`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `tbl_invoice_details`
--
ALTER TABLE `tbl_invoice_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_menu_category`
--
ALTER TABLE `tbl_menu_category`
  ADD PRIMARY KEY (`menu_cat_id`);

--
-- Indexes for table `tbl_mmenu`
--
ALTER TABLE `tbl_mmenu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_taxdis`
--
ALTER TABLE `tbl_taxdis`
  ADD PRIMARY KEY (`taxdis_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `time_records`
--
ALTER TABLE `time_records`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `email_settings`
--
ALTER TABLE `email_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notification_log`
--
ALTER TABLE `notification_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_do_category`
--
ALTER TABLE `tbl_do_category`
  MODIFY `do_cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_invoice`
--
ALTER TABLE `tbl_invoice`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `tbl_invoice_details`
--
ALTER TABLE `tbl_invoice_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=296;

--
-- AUTO_INCREMENT for table `tbl_menu_category`
--
ALTER TABLE `tbl_menu_category`
  MODIFY `menu_cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_mmenu`
--
ALTER TABLE `tbl_mmenu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_taxdis`
--
ALTER TABLE `tbl_taxdis`
  MODIFY `taxdis_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `time_records`
--
ALTER TABLE `time_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
