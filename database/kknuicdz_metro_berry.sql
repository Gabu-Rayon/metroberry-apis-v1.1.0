-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 04, 2024 at 12:03 PM
-- Server version: 8.0.39
-- PHP Version: 8.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kknuicdz_metro_berry`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint UNSIGNED NOT NULL,
  `holder_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `opening_balance` decimal(15,2) NOT NULL DEFAULT '0.00',
  `contact_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `billing_rates`
--

CREATE TABLE `billing_rates` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate_per_km` decimal(8,2) NOT NULL,
  `rate_per_minute` decimal(8,2) NOT NULL,
  `rate_by_car_class` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

--
-- Dumping data for table `billing_rates`
--

INSERT INTO `billing_rates` (`id`, `name`, `rate_per_km`, `rate_per_minute`, `rate_by_car_class`, `created_at`, `updated_at`) VALUES
(1, 'Standard Rate', 10.00, 1.50, '{\"A\":500,\"B\":700,\"C\":1000}', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(2, 'Premium Rate', 15.00, 2.00, '{\"A\":600,\"B\":800,\"C\":1200}', '2024-07-30 03:51:37', '2024-07-30 03:51:37');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('admin@metroberry.co.ke|41.90.176.78', 'i:1;', 1723478637),
('admin@metroberry.co.ke|41.90.176.78:timer', 'i:1723478637;', 1723478637),
('brian.oluoch@metroberry.co.ke|41.90.176.78', 'i:1;', 1723479070),
('brian.oluoch@metroberry.co.ke|41.90.176.78:timer', 'i:1723479070;', 1723479070),
('spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:212:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:14:\"view dashboard\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:5;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:12:\"manage users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:12:\"view profile\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:12:\"edit profile\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:14:\"delete profile\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:16:\"manage customers\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:14:\"view customers\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:15:\"create customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:13:\"edit customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:15:\"delete customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:17:\"activate customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:19:\"deactivate customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:15:\"update customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:16:\"import customers\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:16:\"export customers\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:20:\"manage organisations\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:18:\"view organisations\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:19:\"create organisation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:17:\"edit organisation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:19:\"delete organisation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:19:\"update organisation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:21:\"activate organisation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:23:\"deactivate organisation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:20:\"export organisations\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:20:\"import organisations\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:14:\"manage drivers\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:12:\"view drivers\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:27;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:11:\"show driver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:28;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:13:\"create driver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:29;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:11:\"edit driver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:30;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:15:\"activate driver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:31;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:17:\"deactivate driver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:32;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:14:\"assign vehicle\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:33;a:4:{s:1:\"a\";i:34;s:1:\"b\";s:16:\"unassign vehicle\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:34;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:13:\"delete driver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:35;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:14:\"export drivers\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:36;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:14:\"import drivers\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:37;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:22:\"manage driver licenses\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:38;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:20:\"view driver licenses\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:39;a:4:{s:1:\"a\";i:40;s:1:\"b\";s:19:\"show driver license\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:40;a:4:{s:1:\"a\";i:41;s:1:\"b\";s:21:\"create driver license\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:41;a:4:{s:1:\"a\";i:42;s:1:\"b\";s:19:\"edit driver license\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:42;a:4:{s:1:\"a\";i:43;s:1:\"b\";s:21:\"verify driver license\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:43;a:4:{s:1:\"a\";i:44;s:1:\"b\";s:21:\"revoke driver license\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:44;a:4:{s:1:\"a\";i:45;s:1:\"b\";s:21:\"delete driver license\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:45;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:22:\"export driver licenses\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:46;a:4:{s:1:\"a\";i:47;s:1:\"b\";s:22:\"import driver licenses\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:47;a:4:{s:1:\"a\";i:48;s:1:\"b\";s:23:\"manage driver psvbadges\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:48;a:4:{s:1:\"a\";i:49;s:1:\"b\";s:21:\"view driver psvbadges\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:49;a:4:{s:1:\"a\";i:50;s:1:\"b\";s:20:\"show driver psvbadge\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:50;a:4:{s:1:\"a\";i:51;s:1:\"b\";s:22:\"create driver psvbadge\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:51;a:4:{s:1:\"a\";i:52;s:1:\"b\";s:20:\"edit driver psvbadge\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:52;a:4:{s:1:\"a\";i:53;s:1:\"b\";s:22:\"verify driver psvbadge\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:53;a:4:{s:1:\"a\";i:54;s:1:\"b\";s:22:\"revoke driver psvbadge\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:54;a:4:{s:1:\"a\";i:55;s:1:\"b\";s:22:\"delete driver psvbadge\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:55;a:4:{s:1:\"a\";i:56;s:1:\"b\";s:23:\"export driver psvbadges\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:56;a:4:{s:1:\"a\";i:57;s:1:\"b\";s:23:\"import driver psvbadges\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:57;a:4:{s:1:\"a\";i:58;s:1:\"b\";s:23:\"show driver performance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:58;a:4:{s:1:\"a\";i:59;s:1:\"b\";s:15:\"manage vehicles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:59;a:4:{s:1:\"a\";i:60;s:1:\"b\";s:13:\"view vehicles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:60;a:4:{s:1:\"a\";i:61;s:1:\"b\";s:12:\"show vehicle\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:61;a:4:{s:1:\"a\";i:62;s:1:\"b\";s:14:\"create vehicle\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:62;a:4:{s:1:\"a\";i:63;s:1:\"b\";s:12:\"edit vehicle\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:63;a:4:{s:1:\"a\";i:64;s:1:\"b\";s:14:\"delete vehicle\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:64;a:4:{s:1:\"a\";i:65;s:1:\"b\";s:16:\"activate vehicle\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:65;a:4:{s:1:\"a\";i:66;s:1:\"b\";s:18:\"deactivate vehicle\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:66;a:4:{s:1:\"a\";i:67;s:1:\"b\";s:13:\"assign driver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:67;a:4:{s:1:\"a\";i:68;s:1:\"b\";s:15:\"unassign driver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:68;a:4:{s:1:\"a\";i:69;s:1:\"b\";s:15:\"export vehicles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:69;a:4:{s:1:\"a\";i:70;s:1:\"b\";s:15:\"import vehicles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:70;a:4:{s:1:\"a\";i:71;s:1:\"b\";s:25:\"manage vehicle insurances\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:71;a:4:{s:1:\"a\";i:72;s:1:\"b\";s:23:\"view vehicle insurances\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:72;a:4:{s:1:\"a\";i:73;s:1:\"b\";s:22:\"show vehicle insurance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:73;a:4:{s:1:\"a\";i:74;s:1:\"b\";s:24:\"create vehicle insurance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:74;a:4:{s:1:\"a\";i:75;s:1:\"b\";s:22:\"edit vehicle insurance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:75;a:4:{s:1:\"a\";i:76;s:1:\"b\";s:24:\"delete vehicle insurance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:76;a:4:{s:1:\"a\";i:77;s:1:\"b\";s:26:\"activate vehicle insurance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:77;a:4:{s:1:\"a\";i:78;s:1:\"b\";s:28:\"deactivate vehicle insurance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:78;a:4:{s:1:\"a\";i:79;s:1:\"b\";s:25:\"export vehicle insurances\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:79;a:4:{s:1:\"a\";i:80;s:1:\"b\";s:25:\"import vehicle insurances\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:80;a:4:{s:1:\"a\";i:81;s:1:\"b\";s:38:\"manage vehicle inspection certificates\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:81;a:4:{s:1:\"a\";i:82;s:1:\"b\";s:36:\"view vehicle inspection certificates\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:82;a:4:{s:1:\"a\";i:83;s:1:\"b\";s:35:\"show vehicle inspection certificate\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:83;a:4:{s:1:\"a\";i:84;s:1:\"b\";s:37:\"create vehicle inspection certificate\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:84;a:4:{s:1:\"a\";i:85;s:1:\"b\";s:35:\"edit vehicle inspection certificate\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:85;a:4:{s:1:\"a\";i:86;s:1:\"b\";s:37:\"delete vehicle inspection certificate\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:86;a:4:{s:1:\"a\";i:87;s:1:\"b\";s:39:\"activate vehicle inspection certificate\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:87;a:4:{s:1:\"a\";i:88;s:1:\"b\";s:41:\"deactivate vehicle inspection certificate\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:88;a:4:{s:1:\"a\";i:89;s:1:\"b\";s:38:\"export vehicle inspection certificates\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:89;a:4:{s:1:\"a\";i:90;s:1:\"b\";s:38:\"import vehicle inspection certificates\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:90;a:4:{s:1:\"a\";i:91;s:1:\"b\";s:13:\"manage routes\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:91;a:4:{s:1:\"a\";i:92;s:1:\"b\";s:11:\"view routes\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:92;a:4:{s:1:\"a\";i:93;s:1:\"b\";s:10:\"show route\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:93;a:4:{s:1:\"a\";i:94;s:1:\"b\";s:12:\"create route\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:94;a:4:{s:1:\"a\";i:95;s:1:\"b\";s:10:\"edit route\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:95;a:4:{s:1:\"a\";i:96;s:1:\"b\";s:12:\"delete route\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:96;a:4:{s:1:\"a\";i:97;s:1:\"b\";s:14:\"activate route\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:97;a:4:{s:1:\"a\";i:98;s:1:\"b\";s:16:\"deactivate route\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:98;a:4:{s:1:\"a\";i:99;s:1:\"b\";s:13:\"export routes\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:99;a:4:{s:1:\"a\";i:100;s:1:\"b\";s:13:\"import routes\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:100;a:4:{s:1:\"a\";i:101;s:1:\"b\";s:22:\"manage route locations\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:101;a:4:{s:1:\"a\";i:102;s:1:\"b\";s:20:\"view route locations\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:102;a:4:{s:1:\"a\";i:103;s:1:\"b\";s:19:\"show route location\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:103;a:4:{s:1:\"a\";i:104;s:1:\"b\";s:21:\"create route location\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:104;a:4:{s:1:\"a\";i:105;s:1:\"b\";s:19:\"edit route location\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:105;a:4:{s:1:\"a\";i:106;s:1:\"b\";s:21:\"delete route location\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:106;a:4:{s:1:\"a\";i:107;s:1:\"b\";s:23:\"activate route location\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:107;a:4:{s:1:\"a\";i:108;s:1:\"b\";s:25:\"deactivate route location\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:108;a:4:{s:1:\"a\";i:109;s:1:\"b\";s:22:\"export route locations\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:109;a:4:{s:1:\"a\";i:110;s:1:\"b\";s:22:\"import route locations\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:110;a:4:{s:1:\"a\";i:111;s:1:\"b\";s:12:\"manage trips\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:111;a:4:{s:1:\"a\";i:112;s:1:\"b\";s:10:\"view trips\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:112;a:4:{s:1:\"a\";i:113;s:1:\"b\";s:13:\"schedule trip\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:113;a:4:{s:1:\"a\";i:114;s:1:\"b\";s:32:\"assign vehicle to upcoming trips\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:114;a:4:{s:1:\"a\";i:115;s:1:\"b\";s:11:\"cancel trip\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:115;a:4:{s:1:\"a\";i:116;s:1:\"b\";s:13:\"complete trip\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:116;a:4:{s:1:\"a\";i:117;s:1:\"b\";s:19:\"add billing details\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:117;a:4:{s:1:\"a\";i:118;s:1:\"b\";s:9:\"bill trip\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:118;a:4:{s:1:\"a\";i:119;s:1:\"b\";s:12:\"pay for trip\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:119;a:4:{s:1:\"a\";i:120;s:1:\"b\";s:17:\"send trip invoice\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:120;a:4:{s:1:\"a\";i:121;s:1:\"b\";s:17:\"view trip invoice\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:121;a:4:{s:1:\"a\";i:122;s:1:\"b\";s:20:\"recieve trip payment\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:122;a:4:{s:1:\"a\";i:123;s:1:\"b\";s:12:\"export trips\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:123;a:4:{s:1:\"a\";i:124;s:1:\"b\";s:12:\"import trips\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:124;a:4:{s:1:\"a\";i:125;s:1:\"b\";s:26:\"manage insurance companies\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:125;a:4:{s:1:\"a\";i:126;s:1:\"b\";s:24:\"view insurance companies\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:126;a:4:{s:1:\"a\";i:127;s:1:\"b\";s:22:\"show insurance company\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:127;a:4:{s:1:\"a\";i:128;s:1:\"b\";s:24:\"create insurance company\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:128;a:4:{s:1:\"a\";i:129;s:1:\"b\";s:22:\"edit insurance company\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:129;a:4:{s:1:\"a\";i:130;s:1:\"b\";s:24:\"delete insurance company\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:130;a:4:{s:1:\"a\";i:131;s:1:\"b\";s:26:\"activate insurance company\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:131;a:4:{s:1:\"a\";i:132;s:1:\"b\";s:28:\"deactivate insurance company\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:132;a:4:{s:1:\"a\";i:133;s:1:\"b\";s:26:\"export insurance companies\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:133;a:4:{s:1:\"a\";i:134;s:1:\"b\";s:26:\"import insurance companies\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:134;a:4:{s:1:\"a\";i:135;s:1:\"b\";s:42:\"manage insurance company recurring periods\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:135;a:4:{s:1:\"a\";i:136;s:1:\"b\";s:40:\"view insurance company recurring periods\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:136;a:4:{s:1:\"a\";i:137;s:1:\"b\";s:39:\"show insurance company recurring period\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:137;a:4:{s:1:\"a\";i:138;s:1:\"b\";s:41:\"create insurance company recurring period\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:138;a:4:{s:1:\"a\";i:139;s:1:\"b\";s:39:\"edit insurance company recurring period\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:139;a:4:{s:1:\"a\";i:140;s:1:\"b\";s:41:\"delete insurance company recurring period\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:140;a:4:{s:1:\"a\";i:141;s:1:\"b\";s:43:\"activate insurance company recurring period\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:141;a:4:{s:1:\"a\";i:142;s:1:\"b\";s:45:\"deactivate insurance company recurring period\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:142;a:4:{s:1:\"a\";i:143;s:1:\"b\";s:42:\"export insurance company recurring periods\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:143;a:4:{s:1:\"a\";i:144;s:1:\"b\";s:42:\"import insurance company recurring periods\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:144;a:4:{s:1:\"a\";i:145;s:1:\"b\";s:18:\"manage maintenance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:145;a:4:{s:1:\"a\";i:146;s:1:\"b\";s:16:\"view maintenance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:146;a:4:{s:1:\"a\";i:147;s:1:\"b\";s:16:\"show maintenance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:147;a:4:{s:1:\"a\";i:148;s:1:\"b\";s:18:\"create maintenance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:148;a:4:{s:1:\"a\";i:149;s:1:\"b\";s:16:\"edit maintenance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:149;a:4:{s:1:\"a\";i:150;s:1:\"b\";s:18:\"delete maintenance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:150;a:4:{s:1:\"a\";i:151;s:1:\"b\";s:20:\"activate maintenance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:151;a:4:{s:1:\"a\";i:152;s:1:\"b\";s:22:\"deactivate maintenance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:152;a:4:{s:1:\"a\";i:153;s:1:\"b\";s:18:\"export maintenance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:153;a:4:{s:1:\"a\";i:154;s:1:\"b\";s:18:\"import maintenance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:154;a:4:{s:1:\"a\";i:155;s:1:\"b\";s:15:\"manage fuelling\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:155;a:4:{s:1:\"a\";i:156;s:1:\"b\";s:13:\"view fuelling\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:156;a:4:{s:1:\"a\";i:157;s:1:\"b\";s:13:\"show fuelling\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:157;a:4:{s:1:\"a\";i:158;s:1:\"b\";s:15:\"create fuelling\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:158;a:4:{s:1:\"a\";i:159;s:1:\"b\";s:13:\"edit fuelling\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:159;a:4:{s:1:\"a\";i:160;s:1:\"b\";s:15:\"delete fuelling\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:160;a:4:{s:1:\"a\";i:161;s:1:\"b\";s:17:\"activate fuelling\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:161;a:4:{s:1:\"a\";i:162;s:1:\"b\";s:19:\"deactivate fuelling\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:162;a:4:{s:1:\"a\";i:163;s:1:\"b\";s:15:\"export fuelling\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:163;a:4:{s:1:\"a\";i:164;s:1:\"b\";s:15:\"import fuelling\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:164;a:4:{s:1:\"a\";i:165;s:1:\"b\";s:24:\"manage fuelling stations\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:165;a:4:{s:1:\"a\";i:166;s:1:\"b\";s:22:\"view fuelling stations\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:166;a:4:{s:1:\"a\";i:167;s:1:\"b\";s:21:\"show fuelling station\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:167;a:4:{s:1:\"a\";i:168;s:1:\"b\";s:23:\"create fuelling station\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:168;a:4:{s:1:\"a\";i:169;s:1:\"b\";s:21:\"edit fuelling station\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:169;a:4:{s:1:\"a\";i:170;s:1:\"b\";s:23:\"delete fuelling station\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:170;a:4:{s:1:\"a\";i:171;s:1:\"b\";s:25:\"activate fuelling station\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:171;a:4:{s:1:\"a\";i:172;s:1:\"b\";s:27:\"deactivate fuelling station\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:172;a:4:{s:1:\"a\";i:173;s:1:\"b\";s:24:\"export fuelling stations\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:173;a:4:{s:1:\"a\";i:174;s:1:\"b\";s:24:\"import fuelling stations\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:174;a:4:{s:1:\"a\";i:175;s:1:\"b\";s:12:\"view reports\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:175;a:4:{s:1:\"a\";i:176;s:1:\"b\";s:14:\"export reports\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:176;a:4:{s:1:\"a\";i:177;s:1:\"b\";s:12:\"manage roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:177;a:4:{s:1:\"a\";i:178;s:1:\"b\";s:10:\"view roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:178;a:4:{s:1:\"a\";i:179;s:1:\"b\";s:9:\"show role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:179;a:4:{s:1:\"a\";i:180;s:1:\"b\";s:11:\"create role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:180;a:4:{s:1:\"a\";i:181;s:1:\"b\";s:9:\"edit role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:181;a:4:{s:1:\"a\";i:182;s:1:\"b\";s:11:\"delete role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:182;a:4:{s:1:\"a\";i:183;s:1:\"b\";s:13:\"activate role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:183;a:4:{s:1:\"a\";i:184;s:1:\"b\";s:15:\"deactivate role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:184;a:4:{s:1:\"a\";i:185;s:1:\"b\";s:12:\"export roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:185;a:4:{s:1:\"a\";i:186;s:1:\"b\";s:12:\"import roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:186;a:4:{s:1:\"a\";i:187;s:1:\"b\";s:18:\"manage permissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:187;a:4:{s:1:\"a\";i:188;s:1:\"b\";s:16:\"view permissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:188;a:4:{s:1:\"a\";i:189;s:1:\"b\";s:15:\"show permission\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:189;a:4:{s:1:\"a\";i:190;s:1:\"b\";s:17:\"create permission\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:190;a:4:{s:1:\"a\";i:191;s:1:\"b\";s:15:\"edit permission\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:191;a:4:{s:1:\"a\";i:192;s:1:\"b\";s:17:\"delete permission\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:192;a:4:{s:1:\"a\";i:193;s:1:\"b\";s:19:\"activate permission\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:193;a:4:{s:1:\"a\";i:194;s:1:\"b\";s:21:\"deactivate permission\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:194;a:4:{s:1:\"a\";i:195;s:1:\"b\";s:18:\"export permissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:195;a:4:{s:1:\"a\";i:196;s:1:\"b\";s:18:\"import permissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:196;a:4:{s:1:\"a\";i:197;s:1:\"b\";s:15:\"manage settings\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:197;a:4:{s:1:\"a\";i:198;s:1:\"b\";s:13:\"view settings\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:198;a:4:{s:1:\"a\";i:199;s:1:\"b\";s:13:\"edit settings\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:199;a:4:{s:1:\"a\";i:200;s:1:\"b\";s:15:\"update settings\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:200;a:4:{s:1:\"a\";i:201;s:1:\"b\";s:15:\"export settings\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:201;a:4:{s:1:\"a\";i:202;s:1:\"b\";s:15:\"import settings\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:202;a:4:{s:1:\"a\";i:203;s:1:\"b\";s:20:\"manage bank accounts\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:203;a:4:{s:1:\"a\";i:204;s:1:\"b\";s:18:\"view bank accounts\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:204;a:4:{s:1:\"a\";i:205;s:1:\"b\";s:17:\"show bank account\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:205;a:4:{s:1:\"a\";i:206;s:1:\"b\";s:19:\"create bank account\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:206;a:4:{s:1:\"a\";i:207;s:1:\"b\";s:17:\"edit bank account\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:207;a:4:{s:1:\"a\";i:208;s:1:\"b\";s:19:\"delete bank account\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:208;a:4:{s:1:\"a\";i:209;s:1:\"b\";s:21:\"activate bank account\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:209;a:4:{s:1:\"a\";i:210;s:1:\"b\";s:23:\"deactivate bank account\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:210;a:4:{s:1:\"a\";i:211;s:1:\"b\";s:20:\"export bank accounts\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:211;a:4:{s:1:\"a\";i:212;s:1:\"b\";s:20:\"import bank accounts\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}}s:5:\"roles\";a:5:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:12:\"organisation\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:5;s:1:\"b\";s:17:\"refueling_station\";s:1:\"c\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:8:\"customer\";s:1:\"c\";s:3:\"web\";}i:4;a:3:{s:1:\"a\";i:4;s:1:\"b\";s:6:\"driver\";s:1:\"c\";s:3:\"web\";}}}', 1728031326),
('superadmin@example.com|41.139.135.45', 'i:1;', 1723719414),
('superadmin@example.com|41.139.135.45:timer', 'i:1723719414;', 1723719414),
('victormuthomik@gmail.com|197.248.195.13', 'i:1;', 1722593121),
('victormuthomik@gmail.com|197.248.195.13:timer', 'i:1722593121;', 1722593121);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `organisation_id` bigint UNSIGNED NOT NULL,
  `customer_organisation_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `national_id_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `national_id_front_avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `national_id_behind_avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `user_id`, `organisation_id`, `customer_organisation_code`, `national_id_no`, `national_id_front_avatar`, `national_id_behind_avatar`, `created_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 16, 6, 'UC254', '40250164', 'uploads/front-page-ids/naruto@uzumaki.com-front-id.webp', 'uploads/back-page-ids/naruto@uzumaki.com-back-id.webp', 1, 'active', '2024-08-10 06:46:47', '2024-09-30 08:54:06');

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `organisation_id` bigint UNSIGNED DEFAULT NULL,
  `vehicle_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `national_id_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `national_id_front_avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `national_id_behind_avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `created_by`, `organisation_id`, `vehicle_id`, `user_id`, `national_id_no`, `national_id_front_avatar`, `national_id_behind_avatar`, `status`, `created_at`, `updated_at`) VALUES
(3, 1, 6, NULL, 19, '40250164', 'uploads/front-page-ids/bobitlmr188221@spu.ac.ke-front-id.webp', 'uploads/back-page-ids/bobitlmr188221@spu.ac.ke-back-id.webp', 'active', '2024-10-03 13:22:54', '2024-10-03 13:24:38');

-- --------------------------------------------------------

--
-- Table structure for table `drivers_licenses`
--

CREATE TABLE `drivers_licenses` (
  `id` bigint UNSIGNED NOT NULL,
  `driver_id` bigint UNSIGNED NOT NULL,
  `driving_license_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `driving_license_date_of_issue` date NOT NULL,
  `driving_license_date_of_expiry` date NOT NULL,
  `driving_license_avatar_front` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driving_license_avatar_back` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `drivers_licenses`
--

INSERT INTO `drivers_licenses` (`id`, `driver_id`, `driving_license_no`, `driving_license_date_of_issue`, `driving_license_date_of_expiry`, `driving_license_avatar_front`, `driving_license_avatar_back`, `verified`, `created_at`, `updated_at`) VALUES
(1, 3, 'LICNO12345', '2024-10-03', '2025-10-03', 'uploads/front-license-pics/LICNO12345-front-id.webp', 'uploads/back-license-pics/LICNO12345-back-id.webp', 1, '2024-10-03 13:23:31', '2024-10-03 13:23:36');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `category` enum('vehicle_insurance','ntsa_inspection_certificate','vehicle_service','vehicle_repairs','vehicle_parts_purchase','fuel') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `entry_date` date NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `name`, `amount`, `category`, `entry_date`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Vehicle Insurance', 25000.00, 'vehicle_insurance', '2024-10-03', 'New Vehicle Insurance for KAA AAA1', '2024-10-03 13:12:39', '2024-10-03 13:12:39'),
(2, 'Major Service - Engine Oil', 2500.00, 'vehicle_service', '2024-10-04', 'Major Service - Engine Oil Service for KAA AAA1', '2024-10-04 06:13:54', '2024-10-04 06:13:54');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `incomes`
--

CREATE TABLE `incomes` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `category` enum('trips') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `entry_date` date NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `incomes`
--

INSERT INTO `incomes` (`id`, `name`, `amount`, `category`, `entry_date`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Trip Payment', 375.00, 'trips', '2024-10-04', 'Trip Payment from Uzumaki Naruto for organisation Uzumaki Clan', '2024-10-04 06:49:11', '2024-10-04 06:49:11');

-- --------------------------------------------------------

--
-- Table structure for table `insurance_companies`
--

CREATE TABLE `insurance_companies` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `insurance_companies`
--

INSERT INTO `insurance_companies` (`id`, `name`, `email`, `address`, `website`, `created_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'APA Insurance', 'timberwamalwa@yahoo.com', 'Uthiru 87', 'apa.co.ke', 1, 1, '2024-10-03 13:11:04', '2024-10-03 13:11:36');

-- --------------------------------------------------------

--
-- Table structure for table `insurance_recurring_periods`
--

CREATE TABLE `insurance_recurring_periods` (
  `id` bigint UNSIGNED NOT NULL,
  `period` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) DEFAULT '1',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `insurance_recurring_periods`
--

INSERT INTO `insurance_recurring_periods` (`id`, `period`, `description`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Millenially', 'No idea if this even exists', 1, 1, '2024-10-03 13:11:26', '2024-10-03 13:11:26');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `full_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `code`, `full_name`, `created_at`, `updated_at`) VALUES
(1, 'ar', 'Arabic', '2024-06-08 02:56:25', '2024-06-08 02:56:25'),
(2, 'zh', 'Chinese', '2024-06-08 02:56:25', '2024-06-08 02:56:25'),
(3, 'da', 'Danish', '2024-06-08 02:56:25', '2024-06-08 02:56:25'),
(4, 'de', 'German', '2024-06-08 02:56:25', '2024-06-08 02:56:25'),
(5, 'en', 'English', '2024-06-08 02:56:25', '2024-06-08 02:56:25'),
(6, 'es', 'Spanish', '2024-06-08 02:56:25', '2024-06-08 02:56:25'),
(7, 'fr', 'French', '2024-06-08 02:56:25', '2024-06-08 02:56:25'),
(8, 'he', 'Hebrew', '2024-06-08 02:56:25', '2024-06-08 02:56:25'),
(9, 'it', 'Italian', '2024-06-08 02:56:25', '2024-06-08 02:56:25'),
(10, 'ja', 'Japanese', '2024-06-08 02:56:25', '2024-06-08 02:56:25'),
(11, 'nl', 'Dutch', '2024-06-08 02:56:25', '2024-06-08 02:56:25'),
(12, 'pl', 'Polish', '2024-06-08 02:56:25', '2024-06-08 02:56:25'),
(13, 'pt', 'Portuguese', '2024-06-08 02:56:25', '2024-06-08 02:56:25'),
(14, 'ru', 'Russian', '2024-06-08 02:56:25', '2024-06-08 02:56:25'),
(15, 'tr', 'Turkish', '2024-06-08 02:56:25', '2024-06-08 02:56:25'),
(16, 'pt-br', 'Portuguese (Brazil)', '2024-06-08 02:56:25', '2024-06-08 02:56:25');

-- --------------------------------------------------------

--
-- Table structure for table `mail_settings`
--

CREATE TABLE `mail_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `mail_mailer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'smtp',
  `mail_host` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_port` int DEFAULT NULL,
  `mail_username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_encryption` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_from_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_from_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mail_settings`
--

INSERT INTO `mail_settings` (`id`, `mail_mailer`, `mail_host`, `mail_port`, `mail_username`, `mail_password`, `mail_encryption`, `mail_from_address`, `mail_from_name`, `created_at`, `updated_at`) VALUES
(1, 'smtp', 'mail.metroberry.co.ke', 465, 'admin@metroberry.co.ke', 'w])DCW_TJ]sw', 'ssl', 'admin@metroberry.co.ke', '${APP_NAME}', '2024-07-31 06:57:11', '2024-07-31 07:19:00');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_repairs`
--

CREATE TABLE `maintenance_repairs` (
  `id` bigint UNSIGNED NOT NULL,
  `vehicle_id` bigint UNSIGNED NOT NULL,
  `creator_id` bigint UNSIGNED NOT NULL,
  `part_id` bigint UNSIGNED NOT NULL,
  `repair_date` date NOT NULL,
  `repair_type` enum('repair','replacement','refill') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `repair_cost` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `repair_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `repair_status` enum('pending','billed','approved','rejected','paid','partially paid') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_repair_payments`
--

CREATE TABLE `maintenance_repair_payments` (
  `id` bigint UNSIGNED NOT NULL,
  `maintenance_repair_id` bigint UNSIGNED NOT NULL,
  `vehicle_id` bigint UNSIGNED NOT NULL,
  `part_id` bigint UNSIGNED NOT NULL,
  `repair_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `repair_cost` decimal(10,2) NOT NULL,
  `account_id` bigint UNSIGNED NOT NULL,
  `invoice_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `receipt_type_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_type_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirm_date` date DEFAULT NULL,
  `payment_date` date NOT NULL,
  `total_taxable_amount` decimal(10,2) DEFAULT NULL,
  `total_tax_amount` decimal(10,2) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payment_receipt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qr_code_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_services`
--

CREATE TABLE `maintenance_services` (
  `id` bigint UNSIGNED NOT NULL,
  `vehicle_id` bigint UNSIGNED NOT NULL,
  `creator_id` bigint UNSIGNED NOT NULL,
  `service_type_id` bigint UNSIGNED NOT NULL,
  `service_category_id` bigint UNSIGNED NOT NULL,
  `service_date` date NOT NULL,
  `service_cost` decimal(10,2) NOT NULL,
  `service_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_status` enum('pending','billed','approved','rejected','paid','partially paid') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `maintenance_services`
--

INSERT INTO `maintenance_services` (`id`, `vehicle_id`, `creator_id`, `service_type_id`, `service_category_id`, `service_date`, `service_cost`, `service_description`, `service_status`, `created_at`, `updated_at`) VALUES
(1, 5, 1, 1, 9, '2024-10-04', 2500.00, 'Some Description', 'billed', '2024-10-04 06:13:41', '2024-10-04 06:13:54');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_service_payments`
--

CREATE TABLE `maintenance_service_payments` (
  `id` bigint UNSIGNED NOT NULL,
  `maintenance_service_id` bigint UNSIGNED NOT NULL,
  `vehicle_id` bigint UNSIGNED NOT NULL,
  `service_type_id` bigint UNSIGNED NOT NULL,
  `service_category_id` bigint UNSIGNED NOT NULL,
  `service_date` date NOT NULL,
  `service_cost` decimal(10,2) NOT NULL,
  `account_id` bigint UNSIGNED NOT NULL,
  `invoice_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `receipt_type_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_type_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirm_date` date DEFAULT NULL,
  `payment_date` date NOT NULL,
  `total_taxable_amount` decimal(10,2) NOT NULL,
  `total_tax_amount` decimal(10,2) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payment_receipt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qr_code_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_06_04_070118_create_routes_table', 1),
(5, '2024_06_04_091735_create_personal_access_tokens_table', 1),
(6, '2024_06_04_113024_create_permission_tables', 1),
(7, '2024_06_04_130440_create_organisations_table', 1),
(8, '2024_06_04_131029_create_vehicles_table', 1),
(9, '2024_06_05_123824_create_customers_table', 1),
(10, '2024_06_05_123828_create_drivers_table', 1),
(11, '2024_06_05_123829_add_foreign_keys_to_vehicles_table', 1),
(12, '2024_06_05_123830_add_foreign_keys_to_drivers_table', 1),
(13, '2024_06_07_133544_create_vehicles_services_table', 1),
(14, '2024_06_16_080543_create_billing_rates_table', 1),
(15, '2024_06_18_122045_add_extra_columns_to_organisations_table', 1),
(16, '2024_06_19_131851_create_ride_type_table', 1),
(17, '2024_06_19_132224_create_trip_pricing_table', 1),
(18, '2024_06_19_132225_create_trips_table', 1),
(19, '2024_06_19_132549_add_extra_column_to_vehicles_table', 1),
(20, '2024_06_19_132630_add_extra_column_to_trips_table', 1),
(21, '2024_07_08_131423_create_insurance_recurring_periods_table', 1),
(22, '2024_07_08_131424_create_insurance_companies_table', 1),
(23, '2024_07_08_131426_create_vehicle_insurances_table', 1),
(24, '2024_07_08_131849_create_n_t_s_a_inspection_certificates_table', 1),
(25, '2024_07_08_132732_create_drivers_licenses_table', 1),
(26, '2024_07_08_133242_create_p_s_v_badges_table', 1),
(27, '2024_07_11_131240_create_route_locations_table', 1),
(28, '2024_07_16_125328_create_permission_groups_table', 1),
(29, '2024_07_17_070208_create_vehicle_classes_table', 1),
(30, '2024_07_17_074236_create_service_types_table', 1),
(31, '2024_07_17_075109_create_service_type_categories_table', 1),
(32, '2024_07_17_094134_create_repairs_table', 1),
(33, '2024_07_17_095019_create_repair_categories_table', 1),
(34, '2024_07_17_095020_add_columns_to_trips_table', 1),
(35, '2024_07_17_095021_add_columns_to_trips_table', 1),
(36, '2024_07_17_111955_create_vehicle_part_categories_table', 1),
(37, '2024_07_17_111956_create_vehicle_parts_table', 1),
(38, '2024_07_17_131910_create_accounts_table', 1),
(39, '2024_07_17_132026_create_maintenance_services_table', 1),
(40, '2024_07_18_062250_create_maintenance_repairs_table', 1),
(41, '2024_07_18_093645_create_refuelling_stations_table', 1),
(42, '2024_07_18_120142_create_vehicle_refuelings_table', 1),
(43, '2024_07_18_133545_create_billings_table', 1),
(44, '2024_07_20_090258_create_maintenance_service_payments_table', 1),
(45, '2024_07_20_091746_create_maintenance_repair_payments_table', 1),
(46, '2024_07_29_105236_create_site_settings_table', 1),
(47, '2024_07_29_113514_create_languages_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 14),
(5, 'App\\Models\\User', 15),
(3, 'App\\Models\\User', 16),
(4, 'App\\Models\\User', 19);

-- --------------------------------------------------------

--
-- Table structure for table `ntsa_inspection_certificates`
--

CREATE TABLE `ntsa_inspection_certificates` (
  `id` bigint UNSIGNED NOT NULL,
  `vehicle_id` bigint UNSIGNED NOT NULL,
  `creator_id` bigint UNSIGNED NOT NULL,
  `ntsa_inspection_certificate_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ntsa_inspection_certificate_date_of_issue` date NOT NULL,
  `ntsa_inspection_certificate_date_of_expiry` date NOT NULL,
  `ntsa_inspection_certificate_avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ntsa_inspection_certificates`
--

INSERT INTO `ntsa_inspection_certificates` (`id`, `vehicle_id`, `creator_id`, `ntsa_inspection_certificate_no`, `ntsa_inspection_certificate_date_of_issue`, `ntsa_inspection_certificate_date_of_expiry`, `ntsa_inspection_certificate_avatar`, `verified`, `created_at`, `updated_at`) VALUES
(1, 5, 1, 'INSPCERT001', '2024-10-03', '2025-10-03', 'uploads/ntsa-insp-cert-copies/INSPCERT001-avatar.webp', 1, '2024-10-03 13:21:21', '2024-10-03 13:21:27');

-- --------------------------------------------------------

--
-- Table structure for table `organisations`
--

CREATE TABLE `organisations` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `certificate_of_organisation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_cycle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `terms_and_conditions` tinyint DEFAULT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `organisation_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organisations`
--

INSERT INTO `organisations` (`id`, `user_id`, `certificate_of_organisation`, `billing_cycle`, `terms_and_conditions`, `created_by`, `organisation_code`, `status`, `created_at`, `updated_at`) VALUES
(6, 14, 'uploads/organisation-certificates/admin@uzumaki.co.ke-certificate.pdf', NULL, NULL, 1, 'UC254', 'active', '2024-07-31 06:56:20', '2024-07-31 06:57:31');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('admin@rubis.co.ke', '$2y$12$kqGEH/pDfvbIrw7cJ5AuauzbsGQCe3sobQkcIevcSpeP9KN67G9F.', '2024-07-31 08:11:10');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view dashboard', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(2, 'manage users', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(3, 'view profile', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(4, 'edit profile', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(5, 'delete profile', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(6, 'manage customers', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(7, 'view customers', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(8, 'create customer', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(9, 'edit customer', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(10, 'delete customer', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(11, 'activate customer', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(12, 'deactivate customer', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(13, 'update customer', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(14, 'import customers', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(15, 'export customers', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(16, 'manage organisations', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(17, 'view organisations', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(18, 'create organisation', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(19, 'edit organisation', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(20, 'delete organisation', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(21, 'update organisation', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(22, 'activate organisation', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(23, 'deactivate organisation', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(24, 'export organisations', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(25, 'import organisations', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(26, 'manage drivers', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(27, 'view drivers', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(28, 'show driver', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(29, 'create driver', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(30, 'edit driver', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(31, 'activate driver', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(32, 'deactivate driver', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(33, 'assign vehicle', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(34, 'unassign vehicle', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(35, 'delete driver', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(36, 'export drivers', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(37, 'import drivers', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(38, 'manage driver licenses', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(39, 'view driver licenses', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(40, 'show driver license', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(41, 'create driver license', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(42, 'edit driver license', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(43, 'verify driver license', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(44, 'revoke driver license', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(45, 'delete driver license', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(46, 'export driver licenses', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(47, 'import driver licenses', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(48, 'manage driver psvbadges', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(49, 'view driver psvbadges', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(50, 'show driver psvbadge', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(51, 'create driver psvbadge', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(52, 'edit driver psvbadge', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(53, 'verify driver psvbadge', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(54, 'revoke driver psvbadge', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(55, 'delete driver psvbadge', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(56, 'export driver psvbadges', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(57, 'import driver psvbadges', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(58, 'show driver performance', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(59, 'manage vehicles', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(60, 'view vehicles', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(61, 'show vehicle', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(62, 'create vehicle', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(63, 'edit vehicle', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(64, 'delete vehicle', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(65, 'activate vehicle', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(66, 'deactivate vehicle', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(67, 'assign driver', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(68, 'unassign driver', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(69, 'export vehicles', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(70, 'import vehicles', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(71, 'manage vehicle insurances', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(72, 'view vehicle insurances', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(73, 'show vehicle insurance', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(74, 'create vehicle insurance', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(75, 'edit vehicle insurance', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(76, 'delete vehicle insurance', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(77, 'activate vehicle insurance', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(78, 'deactivate vehicle insurance', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(79, 'export vehicle insurances', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(80, 'import vehicle insurances', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(81, 'manage vehicle inspection certificates', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(82, 'view vehicle inspection certificates', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(83, 'show vehicle inspection certificate', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(84, 'create vehicle inspection certificate', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(85, 'edit vehicle inspection certificate', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(86, 'delete vehicle inspection certificate', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(87, 'activate vehicle inspection certificate', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(88, 'deactivate vehicle inspection certificate', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(89, 'export vehicle inspection certificates', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(90, 'import vehicle inspection certificates', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(91, 'manage routes', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(92, 'view routes', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(93, 'show route', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(94, 'create route', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(95, 'edit route', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(96, 'delete route', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(97, 'activate route', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(98, 'deactivate route', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(99, 'export routes', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(100, 'import routes', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(101, 'manage route locations', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(102, 'view route locations', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(103, 'show route location', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(104, 'create route location', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(105, 'edit route location', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(106, 'delete route location', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(107, 'activate route location', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(108, 'deactivate route location', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(109, 'export route locations', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(110, 'import route locations', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(111, 'manage trips', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(112, 'view trips', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(113, 'schedule trip', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(114, 'assign vehicle to upcoming trips', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(115, 'cancel trip', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(116, 'complete trip', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(117, 'add billing details', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(118, 'bill trip', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(119, 'pay for trip', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(120, 'send trip invoice', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(121, 'view trip invoice', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(122, 'recieve trip payment', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(123, 'export trips', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(124, 'import trips', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(125, 'manage insurance companies', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(126, 'view insurance companies', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(127, 'show insurance company', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(128, 'create insurance company', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(129, 'edit insurance company', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(130, 'delete insurance company', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(131, 'activate insurance company', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(132, 'deactivate insurance company', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(133, 'export insurance companies', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(134, 'import insurance companies', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(135, 'manage insurance company recurring periods', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(136, 'view insurance company recurring periods', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(137, 'show insurance company recurring period', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(138, 'create insurance company recurring period', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(139, 'edit insurance company recurring period', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(140, 'delete insurance company recurring period', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(141, 'activate insurance company recurring period', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(142, 'deactivate insurance company recurring period', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(143, 'export insurance company recurring periods', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(144, 'import insurance company recurring periods', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(145, 'manage maintenance', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(146, 'view maintenance', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(147, 'show maintenance', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(148, 'create maintenance', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(149, 'edit maintenance', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(150, 'delete maintenance', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(151, 'activate maintenance', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(152, 'deactivate maintenance', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(153, 'export maintenance', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(154, 'import maintenance', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(155, 'manage fuelling', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(156, 'view fuelling', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(157, 'show fuelling', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(158, 'create fuelling', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(159, 'edit fuelling', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(160, 'delete fuelling', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(161, 'activate fuelling', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(162, 'deactivate fuelling', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(163, 'export fuelling', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(164, 'import fuelling', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(165, 'manage fuelling stations', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(166, 'view fuelling stations', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(167, 'show fuelling station', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(168, 'create fuelling station', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(169, 'edit fuelling station', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(170, 'delete fuelling station', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(171, 'activate fuelling station', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(172, 'deactivate fuelling station', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(173, 'export fuelling stations', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(174, 'import fuelling stations', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(175, 'view reports', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(176, 'export reports', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(177, 'manage roles', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(178, 'view roles', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(179, 'show role', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(180, 'create role', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(181, 'edit role', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(182, 'delete role', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(183, 'activate role', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(184, 'deactivate role', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(185, 'export roles', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(186, 'import roles', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(187, 'manage permissions', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(188, 'view permissions', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(189, 'show permission', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(190, 'create permission', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(191, 'edit permission', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(192, 'delete permission', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(193, 'activate permission', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(194, 'deactivate permission', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(195, 'export permissions', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(196, 'import permissions', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(197, 'manage settings', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(198, 'view settings', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(199, 'edit settings', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(200, 'update settings', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(201, 'export settings', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(202, 'import settings', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(203, 'manage bank accounts', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(204, 'view bank accounts', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(205, 'show bank account', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(206, 'create bank account', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(207, 'edit bank account', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(208, 'delete bank account', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(209, 'activate bank account', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(210, 'deactivate bank account', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(211, 'export bank accounts', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36'),
(212, 'import bank accounts', 'web', '2024-07-30 03:51:36', '2024-07-30 03:51:36');

-- --------------------------------------------------------

--
-- Table structure for table `permission_groups`
--

CREATE TABLE `permission_groups` (
  `id` bigint UNSIGNED NOT NULL,
  `permission_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_name` enum('settings','dashboard','employee','organisation','drivers','license','psv_badge','driver_performance','vehicle','vehicle_insurance','route','route_location','trip','insurance_company','vehicle_maintenance','account_setting') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `psv_badges`
--

CREATE TABLE `psv_badges` (
  `id` bigint UNSIGNED NOT NULL,
  `driver_id` bigint UNSIGNED NOT NULL,
  `psv_badge_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `psv_badge_date_of_issue` date NOT NULL,
  `psv_badge_date_of_expiry` date NOT NULL,
  `psv_badge_avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `psv_badges`
--

INSERT INTO `psv_badges` (`id`, `driver_id`, `psv_badge_no`, `psv_badge_date_of_issue`, `psv_badge_date_of_expiry`, `psv_badge_avatar`, `verified`, `created_at`, `updated_at`) VALUES
(1, 3, 'BDGNO12345', '2024-10-03', '2025-10-03', 'uploads/psvbadge-avatars/BDGNO12345-back-id.webp', 1, '2024-10-03 13:24:25', '2024-10-03 13:24:29');

-- --------------------------------------------------------

--
-- Table structure for table `refuelling_stations`
--

CREATE TABLE `refuelling_stations` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `station_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `certificate_of_operations` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_period` enum('daily','weekly','monthly','quarterly','biannually','annually') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `refuelling_stations`
--

INSERT INTO `refuelling_stations` (`id`, `user_id`, `station_code`, `certificate_of_operations`, `payment_period`, `status`, `created_at`, `updated_at`) VALUES
(1, 15, 'RB254', 'uploads/cert-ops/admin@rubis.co.ke-cert-op.pdf', 'daily', 'active', '2024-07-31 07:00:41', '2024-07-31 08:13:33');

-- --------------------------------------------------------

--
-- Table structure for table `repairs`
--

CREATE TABLE `repairs` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `repairs`
--

INSERT INTO `repairs` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Electrical', 'Electrical Repair', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(2, 'Mechanical', 'Mechanical Repair', '2024-07-30 03:51:37', '2024-07-30 03:51:37');

-- --------------------------------------------------------

--
-- Table structure for table `repair_categories`
--

CREATE TABLE `repair_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `repair_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ride_type`
--

CREATE TABLE `ride_type` (
  `id` bigint UNSIGNED NOT NULL,
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(2, 'organisation', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(3, 'customer', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(4, 'driver', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35'),
(5, 'refueling_station', 'web', '2024-07-30 03:51:35', '2024-07-30 03:51:35');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(87, 1),
(88, 1),
(89, 1),
(90, 1),
(91, 1),
(92, 1),
(93, 1),
(94, 1),
(95, 1),
(96, 1),
(97, 1),
(98, 1),
(99, 1),
(100, 1),
(101, 1),
(102, 1),
(103, 1),
(104, 1),
(105, 1),
(106, 1),
(107, 1),
(108, 1),
(109, 1),
(110, 1),
(111, 1),
(112, 1),
(113, 1),
(114, 1),
(115, 1),
(116, 1),
(117, 1),
(118, 1),
(119, 1),
(120, 1),
(121, 1),
(122, 1),
(123, 1),
(124, 1),
(125, 1),
(126, 1),
(127, 1),
(128, 1),
(129, 1),
(130, 1),
(131, 1),
(132, 1),
(133, 1),
(134, 1),
(135, 1),
(136, 1),
(137, 1),
(138, 1),
(139, 1),
(140, 1),
(141, 1),
(142, 1),
(143, 1),
(144, 1),
(145, 1),
(146, 1),
(147, 1),
(148, 1),
(149, 1),
(150, 1),
(151, 1),
(152, 1),
(153, 1),
(154, 1),
(155, 1),
(156, 1),
(157, 1),
(158, 1),
(159, 1),
(160, 1),
(161, 1),
(162, 1),
(163, 1),
(164, 1),
(165, 1),
(166, 1),
(167, 1),
(168, 1),
(169, 1),
(170, 1),
(171, 1),
(172, 1),
(173, 1),
(174, 1),
(175, 1),
(176, 1),
(177, 1),
(178, 1),
(179, 1),
(180, 1),
(181, 1),
(182, 1),
(183, 1),
(184, 1),
(185, 1),
(186, 1),
(187, 1),
(188, 1),
(189, 1),
(190, 1),
(191, 1),
(192, 1),
(193, 1),
(194, 1),
(195, 1),
(196, 1),
(197, 1),
(198, 1),
(199, 1),
(200, 1),
(201, 1),
(202, 1),
(203, 1),
(204, 1),
(205, 1),
(206, 1),
(207, 1),
(208, 1),
(209, 1),
(210, 1),
(211, 1),
(212, 1),
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(15, 2),
(26, 2),
(27, 2),
(28, 2),
(59, 2),
(60, 2),
(61, 2),
(91, 2),
(92, 2),
(93, 2),
(101, 2),
(102, 2),
(103, 2),
(111, 2),
(112, 2),
(113, 2),
(119, 2),
(197, 2),
(198, 2),
(199, 2),
(200, 2),
(201, 2),
(202, 2),
(3, 3),
(4, 3),
(5, 3),
(111, 3),
(112, 3),
(113, 3),
(3, 4),
(4, 4),
(5, 4),
(115, 4),
(116, 4),
(145, 4),
(146, 4),
(147, 4),
(148, 4),
(149, 4),
(155, 4),
(156, 4),
(157, 4),
(158, 4),
(159, 4),
(1, 5),
(3, 5),
(4, 5),
(5, 5),
(155, 5),
(156, 5),
(157, 5),
(158, 5),
(159, 5),
(160, 5),
(161, 5),
(162, 5),
(163, 5),
(164, 5);

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `id` bigint UNSIGNED NOT NULL,
  `county` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`id`, `county`, `name`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Kenya', 'Nairobi - Thika Town', 1, '2024-09-30 08:55:12', '2024-09-30 08:55:12');

-- --------------------------------------------------------

--
-- Table structure for table `route_locations`
--

CREATE TABLE `route_locations` (
  `id` bigint UNSIGNED NOT NULL,
  `route_id` bigint UNSIGNED NOT NULL,
  `is_start_location` tinyint(1) NOT NULL DEFAULT '0',
  `is_end_location` tinyint(1) NOT NULL DEFAULT '0',
  `is_waypoint` tinyint(1) NOT NULL DEFAULT '0',
  `point_order` int DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `route_locations`
--

INSERT INTO `route_locations` (`id`, `route_id`, `is_start_location`, `is_end_location`, `is_waypoint`, `point_order`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, 0, NULL, 'Nairobi', '2024-09-30 08:55:16', '2024-09-30 08:55:16'),
(2, 1, 0, 1, 0, NULL, 'Thika Town', '2024-09-30 08:55:17', '2024-09-30 08:55:17'),
(3, 1, 0, 0, 1, 1, 'Garden City mall', '2024-09-30 08:56:37', '2024-09-30 08:56:37'),
(4, 1, 0, 0, 1, 2, 'Thika Road Mall', '2024-09-30 08:57:08', '2024-09-30 08:57:08'),
(5, 1, 0, 0, 1, 1, 'Pahali Flani', '2024-10-03 12:38:41', '2024-10-03 12:38:41');

-- --------------------------------------------------------

--
-- Table structure for table `service_types`
--

CREATE TABLE `service_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_types`
--

INSERT INTO `service_types` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Major Service', 'A major service is a comprehensive service that covers all areas of essential maintenance.', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(2, 'Minor Service', 'A minor service is a basic service that covers all areas of essential maintenance.', '2024-07-30 03:51:37', '2024-07-30 03:51:37');

-- --------------------------------------------------------

--
-- Table structure for table `service_type_categories`
--

CREATE TABLE `service_type_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `service_type_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_type_categories`
--

INSERT INTO `service_type_categories` (`id`, `service_type_id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 2, 'Engine Oil', 'This is a Minor service for Engine Oil', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(2, 2, 'Gearbox Oil', 'This is a Minor service for Gearbox Oil', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(3, 2, 'Air Cleaner', 'This is a Minor service for Air Cleaner', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(4, 2, 'Oil Filter', 'This is a Minor service for Oil Filter', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(5, 2, 'Air Filter', 'This is a Minor service for Air Filter', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(6, 2, 'Wiper', 'This is a Minor service for Wiper', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(7, 2, 'Engine Coolant', 'This is a Minor service for Engine Coolant', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(8, 2, 'Brakes and Linings', 'This is a Minor service for Brakes and Linings', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(9, 1, 'Engine Oil', 'This is a Major Service for Engine Oil', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(10, 1, 'Gear Box Oil', 'This is a Major Service for Gear Box Oil', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(11, 1, 'Air Cleaner', 'This is a Major Service for Air Cleaner', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(12, 1, 'Oil Filter', 'This is a Major Service for Oil Filter', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(13, 1, 'Air Filter', 'This is a Major Service for Air Filter', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(14, 1, 'Wiper', 'This is a Major Service for Wiper', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(15, 1, 'Engine Coolant', 'This is a Major Service for Engine Coolant', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(16, 1, 'Alternator', 'This is a Major Service for Alternator', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(17, 1, 'Starter', 'This is a Major Service for Starter', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(18, 1, 'Battery', 'This is a Major Service for Battery', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(19, 1, 'Tyres', 'This is a Major Service for Tyres', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(20, 1, 'Timing Chain', 'This is a Major Service for Timing Chain', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(21, 1, 'Pulley Belt', 'This is a Major Service for Pulley Belt', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(22, 1, 'Spare Tyre', 'This is a Major Service for Spare Tyre', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(23, 1, 'Jack Wheel Spanner', 'This is a Major Service for Jack Wheel Spanner', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(24, 1, 'Head Lamps', 'This is a Major Service for Head Lamps', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(25, 1, 'Parking Warning Lights', 'This is a Major Service for Parking Warning Lights', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(26, 1, 'Brakes and Linings', 'This is a Major Service for Brakes and Linings', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(27, 1, 'Suspension Parts', 'This is a Major Service for Suspension Parts', '2024-07-30 03:51:37', '2024-07-30 03:51:37');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('zwsrg481wTSKGejo2Tuay76ybMM8sng90MLiGBeH', 1, '41.139.135.45', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWW5hNjNySnlzQ3ZlMVdnNVQ1Z0ZuZzA3N2NrTEhWb2RhWG5LczhJaiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjI6Imh0dHBzOi8vcG9ydGFsLm1ldHJvYmVycnkuY28ua2UvdHJpcC9iaWxsZWQvMS9wYXltZW50L2NoZWNrb3V0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1728024567);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `site_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_of_website` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `station_code_prefix` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `maintenance_code_prefix` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `station_requisition_prefix` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `maintenance_requisition_prefix` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `environment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_white` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_black` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_favicon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `app_debug` tinyint DEFAULT '0',
  `force_https` tinyint DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `site_url`, `name_of_website`, `description`, `station_code_prefix`, `maintenance_code_prefix`, `station_requisition_prefix`, `maintenance_requisition_prefix`, `environment`, `logo_white`, `logo_black`, `site_favicon`, `app_debug`, `force_https`, `created_at`, `updated_at`) VALUES
(1, 'https://metroberry.co.ke', 'Metro Berry Tours & Travel', 'Metro Berry Tours & Travel', 'MB-FSC-', 'MB-MCP-', 'MB-FRSC-', 'MB-MRCP-', 'production', 'public/logo_white.png', 'public/logo_black.png', 'public/favicon.ico', 1, 1, '2024-07-31 05:49:21', '2024-07-31 09:28:02');

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE `trips` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `vehicle_id` bigint UNSIGNED DEFAULT NULL,
  `driver_id` bigint UNSIGNED DEFAULT NULL,
  `route_id` bigint UNSIGNED NOT NULL,
  `pick_up_time` time NOT NULL,
  `drop_off_time` time DEFAULT NULL,
  `pick_up_location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `drop_off_location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `distance` decimal(8,2) DEFAULT NULL,
  `number_of_passengers` int DEFAULT NULL,
  `trip_date` date NOT NULL,
  `status` enum('scheduled','completed','cancelled','billed','paid','partially paid','assigned') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'scheduled',
  `vehicle_mileage` decimal(8,2) DEFAULT NULL,
  `engine_hours` int DEFAULT NULL,
  `fuel_consumed` decimal(8,2) DEFAULT NULL,
  `idle_time` int DEFAULT NULL,
  `billing_rate_id` bigint UNSIGNED DEFAULT NULL,
  `biller` bigint UNSIGNED DEFAULT NULL,
  `total_price` decimal(8,2) DEFAULT NULL,
  `billed_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `billed_by` enum('distance','time','car_class') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ride_type_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trips`
--

INSERT INTO `trips` (`id`, `customer_id`, `vehicle_id`, `driver_id`, `route_id`, `pick_up_time`, `drop_off_time`, `pick_up_location`, `drop_off_location`, `distance`, `number_of_passengers`, `trip_date`, `status`, `vehicle_mileage`, `engine_hours`, `fuel_consumed`, `idle_time`, `billing_rate_id`, `biller`, `total_price`, `billed_at`, `created_by`, `billed_by`, `ride_type_id`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 3, 1, '15:15:00', '16:59:37', '1', '4', NULL, NULL, '2024-09-30', 'billed', 25.00, 2, 250.00, 1, 2, NULL, 375.00, '2024-10-04 09:49:11', 1, 'distance', NULL, '2024-09-30 08:59:14', '2024-10-04 06:49:11'),
(2, 1, 5, 3, 1, '15:15:00', '16:59:55', '1', '4', NULL, NULL, '2024-10-01', 'completed', 35.00, 3, 350.00, 0, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2024-09-30 09:00:12', '2024-10-04 06:48:38'),
(3, 1, 5, 3, 1, '22:15:00', '09:42:15', '1', '2', NULL, NULL, '2024-10-10', 'completed', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2024-10-04 06:14:35', '2024-10-04 06:42:15'),
(4, 1, 5, 3, 1, '22:20:00', NULL, '1', '2', NULL, NULL, '2024-10-04', 'cancelled', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2024-10-04 06:19:08', '2024-10-04 06:42:26');

-- --------------------------------------------------------

--
-- Table structure for table `trip_payments`
--

CREATE TABLE `trip_payments` (
  `id` bigint UNSIGNED NOT NULL,
  `trip_id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `invoice_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_tin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `receipt_type_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_type_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirm_date` date DEFAULT NULL,
  `payment_date` date NOT NULL,
  `total_taxable_amount` decimal(15,2) DEFAULT NULL,
  `total_tax_amount` decimal(15,2) DEFAULT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payment_receipt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `qr_code_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trip_pricing`
--

CREATE TABLE `trip_pricing` (
  `id` bigint UNSIGNED NOT NULL,
  `ride_type_id` bigint UNSIGNED NOT NULL,
  `base_price` decimal(10,2) DEFAULT NULL,
  `price_per_km` decimal(10,2) DEFAULT NULL,
  `price_per_minute` decimal(10,2) DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `address`, `avatar`, `role`, `created_by`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'MetroBerry Admin', 'admin@metroberry.co.ke', '$2y$12$oe9bDT5tRupOjnaBJ4tNF.5iN34Gb8u2lLuwqnfBoQ8ywmsubl.x6', '0708373982', 'Nairobi, Kenya', 'avatars/gJrAkRcDbdtNVt6acv1OFvddP2phh7jWaIDXAQn4.jpg', 'admin', NULL, 'CVgRxb4TdTqIK6Nydo5xQJ3zJCYCyrmUpeeJ8CZNmIzUGpr9kTgoOX7zyFb6', '2024-07-30 03:51:37', '2024-10-03 14:16:19'),
(14, 'Uzumaki Clan', 'admin@uzumaki.co.ke', '$2y$12$o3CY7yPl9Ku4XzHrAysXlOyI3umFHq6tMK2MOMGoSD6u0k31qfeUe', '0708373982', 'Uzushiogakure, Kuni', 'uploads/company-logos/admin@uzumaki.co.ke-avatar.webp', 'organisation', 1, NULL, '2024-07-31 06:56:20', '2024-07-31 06:56:20'),
(15, 'Rubis', 'timberwamalwa@yahoo.com', '$2y$12$vIQXVZNYAY4dmyGAD3Ht1.OyvcHgPmEqTyZ/1bFYbFOXiQqoMnU5K', '0708373983', 'Nairobi, Kenya', 'uploads/user-avatars/admin@rubis.co.ke-avatar.webp', 'refueling_station', 1, 'JtNL83MD1MiD4MzzJO8hWPKjG0DOhkbFSQJ3pSdMA0oW4uefUqGvcTusm43M', '2024-07-31 07:00:41', '2024-07-31 08:15:12'),
(16, 'Uzumaki Naruto', 'naruto@uzumaki.com', '$2y$12$vONf.NteJn3kTOM.S515BeiuR6q56gmcYRWUqxZe7LJH9z3tTIfr.', '0783421672', 'Uzushiogakure, Kuni', 'uploads/user-avatars/naruto@uzumaki.com-avatar.webp', 'customer', 1, NULL, '2024-08-10 06:46:47', '2024-08-10 06:46:47'),
(19, 'Christian Wamalwa', 'bobitlmr188221@spu.ac.ke', '$2y$12$xtJjT3qHKE.9JAK2H1YEZO7oJr1LXZ.dPoTRTxfcMlxywM.SB/.qq', '0708373989', 'Uthiru 87', 'uploads/user-avatars/bobitlmr188221@spu.ac.ke-avatar.jpg', 'driver', 1, NULL, '2024-10-03 13:22:54', '2024-10-03 13:22:54');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `driver_id` bigint UNSIGNED DEFAULT NULL,
  `organisation_id` bigint UNSIGNED DEFAULT NULL,
  `model` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `make` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `plate_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seats` int NOT NULL,
  `class` enum('A','B','C','D','E') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fuel_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `engine_size` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ride_type_id` bigint UNSIGNED DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `created_by`, `driver_id`, `organisation_id`, `model`, `make`, `year`, `plate_number`, `color`, `seats`, `class`, `fuel_type`, `engine_size`, `avatar`, `ride_type_id`, `status`, `created_at`, `updated_at`) VALUES
(5, 1, 3, 6, 'Benz', 'Mercedes', '2024', 'KAA AAA1', 'White', 4, 'A', 'Diesel', '30', '1723283397.webp', NULL, 'active', '2024-08-10 06:49:57', '2024-10-03 13:24:47');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_classes`
--

CREATE TABLE `vehicle_classes` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_passengers` int NOT NULL,
  `max_passengers` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicle_classes`
--

INSERT INTO `vehicle_classes` (`id`, `name`, `min_passengers`, `max_passengers`, `created_at`, `updated_at`) VALUES
(1, 'A', 1, 4, NULL, NULL),
(2, 'B', 4, 6, NULL, NULL),
(3, 'C', 7, 14, NULL, NULL),
(4, 'D', 14, 28, NULL, NULL),
(5, 'E', 29, 32, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_insurances`
--

CREATE TABLE `vehicle_insurances` (
  `id` bigint UNSIGNED NOT NULL,
  `vehicle_id` bigint UNSIGNED NOT NULL,
  `insurance_company_id` bigint UNSIGNED NOT NULL,
  `insurance_policy_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `insurance_date_of_issue` date NOT NULL,
  `insurance_date_of_expiry` date NOT NULL,
  `charges_payable` int NOT NULL,
  `recurring_period_id` bigint UNSIGNED NOT NULL,
  `recurring_date` date NOT NULL,
  `reminder` tinyint(1) NOT NULL,
  `deductible` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `policy_document` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicle_insurances`
--

INSERT INTO `vehicle_insurances` (`id`, `vehicle_id`, `insurance_company_id`, `insurance_policy_no`, `insurance_date_of_issue`, `insurance_date_of_expiry`, `charges_payable`, `recurring_period_id`, `recurring_date`, `reminder`, `deductible`, `status`, `remark`, `policy_document`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 5, 1, '001', '2024-10-03', '2025-10-03', 25000, 1, '2024-11-03', 1, 2500, 1, 'some remarks', '1727961159.pdf', 1, '2024-10-03 13:12:39', '2024-10-03 13:12:39');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_parts`
--

CREATE TABLE `vehicle_parts` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `brand` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int NOT NULL DEFAULT '0',
  `condition` enum('new','used','refurbished') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `compatibility` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicle_parts`
--

INSERT INTO `vehicle_parts` (`id`, `name`, `sku`, `category_id`, `brand`, `model_number`, `price`, `quantity`, `condition`, `compatibility`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'Engine Oil', 'ENGOIL001', 1, 'Castrol', 'SYNTEC', 25.99, 100, 'new', 'All vehicles', 'High performance oil', '2024-07-30 03:51:37', '2024-07-30 03:51:37');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_part_categories`
--

CREATE TABLE `vehicle_part_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicle_part_categories`
--

INSERT INTO `vehicle_part_categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Engine', 'Engine parts', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(2, 'Transmission', 'Transmission parts', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(3, 'Suspension', 'Suspension parts', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(4, 'Brakes', 'Brake parts', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(5, 'Exhaust', 'Exhaust parts', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(6, 'Electrical', 'Electrical parts', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(7, 'Interior', 'Interior parts', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(8, 'Exterior', 'Exterior parts', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(9, 'Wheels', 'Wheel parts', '2024-07-30 03:51:37', '2024-07-30 03:51:37'),
(10, 'Tires', 'Tire parts', '2024-07-30 03:51:37', '2024-07-30 03:51:37');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_refuelings`
--

CREATE TABLE `vehicle_refuelings` (
  `id` bigint UNSIGNED NOT NULL,
  `vehicle_id` bigint UNSIGNED NOT NULL,
  `refuelling_station_id` bigint UNSIGNED NOT NULL,
  `creator_id` bigint UNSIGNED NOT NULL,
  `refuelling_date` date NOT NULL,
  `refuelling_time` time NOT NULL,
  `refuelling_volume` decimal(10,2) NOT NULL,
  `refuelling_cost` decimal(10,2) NOT NULL,
  `attendant_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attendant_phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','approved','rejected','billed','paid','partially paid') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_services`
--

CREATE TABLE `vehicle_services` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `accounts_account_number_unique` (`account_number`),
  ADD KEY `accounts_created_by_foreign` (`created_by`);

--
-- Indexes for table `billing_rates`
--
ALTER TABLE `billing_rates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_user_id_foreign` (`user_id`),
  ADD KEY `customers_organisation_id_foreign` (`organisation_id`),
  ADD KEY `customers_created_by_foreign` (`created_by`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `drivers_created_by_foreign` (`created_by`),
  ADD KEY `drivers_organisation_id_foreign` (`organisation_id`),
  ADD KEY `drivers_user_id_foreign` (`user_id`),
  ADD KEY `drivers_vehicle_id_foreign` (`vehicle_id`);

--
-- Indexes for table `drivers_licenses`
--
ALTER TABLE `drivers_licenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `drivers_licenses_driver_id_foreign` (`driver_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `incomes`
--
ALTER TABLE `incomes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `insurance_companies`
--
ALTER TABLE `insurance_companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `insurance_companies_created_by_foreign` (`created_by`);

--
-- Indexes for table `insurance_recurring_periods`
--
ALTER TABLE `insurance_recurring_periods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `insurance_recurring_periods_created_by_foreign` (`created_by`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mail_settings`
--
ALTER TABLE `mail_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintenance_repairs`
--
ALTER TABLE `maintenance_repairs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `maintenance_repairs_vehicle_id_foreign` (`vehicle_id`),
  ADD KEY `maintenance_repairs_creator_id_foreign` (`creator_id`),
  ADD KEY `maintenance_repairs_part_id_foreign` (`part_id`);

--
-- Indexes for table `maintenance_repair_payments`
--
ALTER TABLE `maintenance_repair_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `maintenance_repair_payments_maintenance_repair_id_foreign` (`maintenance_repair_id`),
  ADD KEY `maintenance_repair_payments_vehicle_id_foreign` (`vehicle_id`),
  ADD KEY `maintenance_repair_payments_part_id_foreign` (`part_id`),
  ADD KEY `maintenance_repair_payments_account_id_foreign` (`account_id`),
  ADD KEY `maintenance_repair_payments_created_by_foreign` (`created_by`);

--
-- Indexes for table `maintenance_services`
--
ALTER TABLE `maintenance_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintenance_service_payments`
--
ALTER TABLE `maintenance_service_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `maintenance_service_payments_maintenance_service_id_foreign` (`maintenance_service_id`),
  ADD KEY `maintenance_service_payments_vehicle_id_foreign` (`vehicle_id`),
  ADD KEY `maintenance_service_payments_service_type_id_foreign` (`service_type_id`),
  ADD KEY `maintenance_service_payments_service_category_id_foreign` (`service_category_id`),
  ADD KEY `maintenance_service_payments_account_id_foreign` (`account_id`),
  ADD KEY `maintenance_service_payments_created_by_foreign` (`created_by`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `ntsa_inspection_certificates`
--
ALTER TABLE `ntsa_inspection_certificates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ntsa_inspection_certificates_vehicle_id_foreign` (`vehicle_id`),
  ADD KEY `ntsa_inspection_certificates_creator_id_foreign` (`creator_id`);

--
-- Indexes for table `organisations`
--
ALTER TABLE `organisations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `organisations_organisation_code_unique` (`organisation_code`),
  ADD KEY `organisations_user_id_foreign` (`user_id`),
  ADD KEY `organisations_created_by_foreign` (`created_by`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `permission_groups`
--
ALTER TABLE `permission_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permission_groups_permission_name_group_name_unique` (`permission_name`,`group_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `psv_badges`
--
ALTER TABLE `psv_badges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `psv_badges_driver_id_foreign` (`driver_id`);

--
-- Indexes for table `refuelling_stations`
--
ALTER TABLE `refuelling_stations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `refuelling_stations_user_id_foreign` (`user_id`);

--
-- Indexes for table `repairs`
--
ALTER TABLE `repairs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `repair_categories`
--
ALTER TABLE `repair_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `repair_categories_repair_id_foreign` (`repair_id`);

--
-- Indexes for table `ride_type`
--
ALTER TABLE `ride_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ride_type_created_by_foreign` (`created_by`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `routes_created_by_foreign` (`created_by`);

--
-- Indexes for table `route_locations`
--
ALTER TABLE `route_locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `route_locations_route_id_foreign` (`route_id`);

--
-- Indexes for table `service_types`
--
ALTER TABLE `service_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_type_categories`
--
ALTER TABLE `service_type_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_type_categories_service_type_id_foreign` (`service_type_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trips`
--
ALTER TABLE `trips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trips_customer_id_foreign` (`customer_id`),
  ADD KEY `trips_vehicle_id_foreign` (`vehicle_id`),
  ADD KEY `trips_route_id_foreign` (`route_id`),
  ADD KEY `trips_billing_rate_id_foreign` (`billing_rate_id`),
  ADD KEY `trips_created_by_foreign` (`created_by`),
  ADD KEY `trips_biller_foreign` (`biller`),
  ADD KEY `trips_ride_type_id_foreign` (`ride_type_id`),
  ADD KEY `trips_driver_id_foreign` (`driver_id`);

--
-- Indexes for table `trip_payments`
--
ALTER TABLE `trip_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trip_payments_trip_id_foreign` (`trip_id`),
  ADD KEY `trip_payments_customer_id_foreign` (`customer_id`),
  ADD KEY `trip_payments_created_by_foreign` (`created_by`);

--
-- Indexes for table `trip_pricing`
--
ALTER TABLE `trip_pricing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trip_pricing_ride_type_id_foreign` (`ride_type_id`),
  ADD KEY `trip_pricing_created_by_foreign` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_created_by_foreign` (`created_by`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vehicles_plate_number_unique` (`plate_number`),
  ADD KEY `vehicles_created_by_foreign` (`created_by`),
  ADD KEY `vehicles_organisation_id_foreign` (`organisation_id`),
  ADD KEY `vehicles_driver_id_foreign` (`driver_id`),
  ADD KEY `vehicles_ride_type_id_foreign` (`ride_type_id`);

--
-- Indexes for table `vehicle_classes`
--
ALTER TABLE `vehicle_classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_insurances`
--
ALTER TABLE `vehicle_insurances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicle_insurances_vehicle_id_foreign` (`vehicle_id`),
  ADD KEY `vehicle_insurances_insurance_company_id_foreign` (`insurance_company_id`),
  ADD KEY `vehicle_insurances_recurring_period_id_foreign` (`recurring_period_id`),
  ADD KEY `vehicle_insurances_created_by_foreign` (`created_by`);

--
-- Indexes for table `vehicle_parts`
--
ALTER TABLE `vehicle_parts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vehicle_parts_sku_unique` (`sku`),
  ADD KEY `vehicle_parts_category_id_foreign` (`category_id`);

--
-- Indexes for table `vehicle_part_categories`
--
ALTER TABLE `vehicle_part_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_refuelings`
--
ALTER TABLE `vehicle_refuelings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicle_refuelings_vehicle_id_foreign` (`vehicle_id`),
  ADD KEY `vehicle_refuelings_refuelling_station_id_foreign` (`refuelling_station_id`),
  ADD KEY `vehicle_refuelings_creator_id_foreign` (`creator_id`);

--
-- Indexes for table `vehicle_services`
--
ALTER TABLE `vehicle_services`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `billing_rates`
--
ALTER TABLE `billing_rates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `drivers_licenses`
--
ALTER TABLE `drivers_licenses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incomes`
--
ALTER TABLE `incomes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `insurance_companies`
--
ALTER TABLE `insurance_companies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `insurance_recurring_periods`
--
ALTER TABLE `insurance_recurring_periods`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `mail_settings`
--
ALTER TABLE `mail_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `maintenance_repairs`
--
ALTER TABLE `maintenance_repairs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maintenance_repair_payments`
--
ALTER TABLE `maintenance_repair_payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maintenance_services`
--
ALTER TABLE `maintenance_services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `maintenance_service_payments`
--
ALTER TABLE `maintenance_service_payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `ntsa_inspection_certificates`
--
ALTER TABLE `ntsa_inspection_certificates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `organisations`
--
ALTER TABLE `organisations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=213;

--
-- AUTO_INCREMENT for table `permission_groups`
--
ALTER TABLE `permission_groups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `psv_badges`
--
ALTER TABLE `psv_badges`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `refuelling_stations`
--
ALTER TABLE `refuelling_stations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `repairs`
--
ALTER TABLE `repairs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `repair_categories`
--
ALTER TABLE `repair_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ride_type`
--
ALTER TABLE `ride_type`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `route_locations`
--
ALTER TABLE `route_locations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `service_types`
--
ALTER TABLE `service_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `service_type_categories`
--
ALTER TABLE `service_type_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `trips`
--
ALTER TABLE `trips`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `trip_payments`
--
ALTER TABLE `trip_payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trip_pricing`
--
ALTER TABLE `trip_pricing`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vehicle_classes`
--
ALTER TABLE `vehicle_classes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vehicle_insurances`
--
ALTER TABLE `vehicle_insurances`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vehicle_parts`
--
ALTER TABLE `vehicle_parts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vehicle_part_categories`
--
ALTER TABLE `vehicle_part_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `vehicle_refuelings`
--
ALTER TABLE `vehicle_refuelings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_services`
--
ALTER TABLE `vehicle_services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customers_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `drivers`
--
ALTER TABLE `drivers`
  ADD CONSTRAINT `drivers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `drivers_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `drivers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `drivers_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `drivers_licenses`
--
ALTER TABLE `drivers_licenses`
  ADD CONSTRAINT `drivers_licenses_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `insurance_companies`
--
ALTER TABLE `insurance_companies`
  ADD CONSTRAINT `insurance_companies_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `insurance_recurring_periods`
--
ALTER TABLE `insurance_recurring_periods`
  ADD CONSTRAINT `insurance_recurring_periods_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `maintenance_repairs`
--
ALTER TABLE `maintenance_repairs`
  ADD CONSTRAINT `maintenance_repairs_creator_id_foreign` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `maintenance_repairs_part_id_foreign` FOREIGN KEY (`part_id`) REFERENCES `vehicle_parts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `maintenance_repairs_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `maintenance_repair_payments`
--
ALTER TABLE `maintenance_repair_payments`
  ADD CONSTRAINT `maintenance_repair_payments_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `maintenance_repair_payments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `maintenance_repair_payments_maintenance_repair_id_foreign` FOREIGN KEY (`maintenance_repair_id`) REFERENCES `maintenance_repairs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `maintenance_repair_payments_part_id_foreign` FOREIGN KEY (`part_id`) REFERENCES `vehicle_parts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `maintenance_repair_payments_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `maintenance_service_payments`
--
ALTER TABLE `maintenance_service_payments`
  ADD CONSTRAINT `maintenance_service_payments_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `maintenance_service_payments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `maintenance_service_payments_maintenance_service_id_foreign` FOREIGN KEY (`maintenance_service_id`) REFERENCES `maintenance_services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `maintenance_service_payments_service_category_id_foreign` FOREIGN KEY (`service_category_id`) REFERENCES `service_type_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `maintenance_service_payments_service_type_id_foreign` FOREIGN KEY (`service_type_id`) REFERENCES `service_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `maintenance_service_payments_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ntsa_inspection_certificates`
--
ALTER TABLE `ntsa_inspection_certificates`
  ADD CONSTRAINT `ntsa_inspection_certificates_creator_id_foreign` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ntsa_inspection_certificates_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `organisations`
--
ALTER TABLE `organisations`
  ADD CONSTRAINT `organisations_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `organisations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permission_groups`
--
ALTER TABLE `permission_groups`
  ADD CONSTRAINT `permission_groups_permission_name_foreign` FOREIGN KEY (`permission_name`) REFERENCES `permissions` (`name`) ON DELETE CASCADE;

--
-- Constraints for table `psv_badges`
--
ALTER TABLE `psv_badges`
  ADD CONSTRAINT `psv_badges_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `refuelling_stations`
--
ALTER TABLE `refuelling_stations`
  ADD CONSTRAINT `refuelling_stations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `repair_categories`
--
ALTER TABLE `repair_categories`
  ADD CONSTRAINT `repair_categories_repair_id_foreign` FOREIGN KEY (`repair_id`) REFERENCES `repairs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ride_type`
--
ALTER TABLE `ride_type`
  ADD CONSTRAINT `ride_type_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `routes`
--
ALTER TABLE `routes`
  ADD CONSTRAINT `routes_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `route_locations`
--
ALTER TABLE `route_locations`
  ADD CONSTRAINT `route_locations_route_id_foreign` FOREIGN KEY (`route_id`) REFERENCES `routes` (`id`);

--
-- Constraints for table `service_type_categories`
--
ALTER TABLE `service_type_categories`
  ADD CONSTRAINT `service_type_categories_service_type_id_foreign` FOREIGN KEY (`service_type_id`) REFERENCES `service_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `trips`
--
ALTER TABLE `trips`
  ADD CONSTRAINT `trips_biller_foreign` FOREIGN KEY (`biller`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `trips_billing_rate_id_foreign` FOREIGN KEY (`billing_rate_id`) REFERENCES `billing_rates` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `trips_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `trips_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `trips_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `trips_ride_type_id_foreign` FOREIGN KEY (`ride_type_id`) REFERENCES `ride_type` (`id`),
  ADD CONSTRAINT `trips_route_id_foreign` FOREIGN KEY (`route_id`) REFERENCES `routes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `trips_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `trip_payments`
--
ALTER TABLE `trip_payments`
  ADD CONSTRAINT `trip_payments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `trip_payments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `trip_payments_trip_id_foreign` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `trip_pricing`
--
ALTER TABLE `trip_pricing`
  ADD CONSTRAINT `trip_pricing_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `trip_pricing_ride_type_id_foreign` FOREIGN KEY (`ride_type_id`) REFERENCES `ride_type` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vehicles_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vehicles_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vehicles_ride_type_id_foreign` FOREIGN KEY (`ride_type_id`) REFERENCES `ride_type` (`id`);

--
-- Constraints for table `vehicle_insurances`
--
ALTER TABLE `vehicle_insurances`
  ADD CONSTRAINT `vehicle_insurances_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vehicle_insurances_insurance_company_id_foreign` FOREIGN KEY (`insurance_company_id`) REFERENCES `insurance_companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vehicle_insurances_recurring_period_id_foreign` FOREIGN KEY (`recurring_period_id`) REFERENCES `insurance_recurring_periods` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vehicle_insurances_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vehicle_parts`
--
ALTER TABLE `vehicle_parts`
  ADD CONSTRAINT `vehicle_parts_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `vehicle_part_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vehicle_refuelings`
--
ALTER TABLE `vehicle_refuelings`
  ADD CONSTRAINT `vehicle_refuelings_creator_id_foreign` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vehicle_refuelings_refuelling_station_id_foreign` FOREIGN KEY (`refuelling_station_id`) REFERENCES `refuelling_stations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vehicle_refuelings_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
