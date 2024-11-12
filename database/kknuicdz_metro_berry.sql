-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2024 at 09:15 AM
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
-- Database: `metroberry_apis`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `holder_name` varchar(255) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `opening_balance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `contact_number` varchar(255) DEFAULT NULL,
  `bank_address` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `billing_rates`
--

CREATE TABLE `billing_rates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `rate_per_km` decimal(8,2) NOT NULL,
  `rate_per_minute` decimal(8,2) NOT NULL,
  `rate_by_car_class` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`rate_by_car_class`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `billing_rates`
--

INSERT INTO `billing_rates` (`id`, `name`, `rate_per_km`, `rate_per_minute`, `rate_by_car_class`, `created_at`, `updated_at`) VALUES
(1, 'Standard Rate', 10.00, 1.50, '{\"A\":500,\"B\":700,\"C\":1000}', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(2, 'Premium Rate', 15.00, 2.00, '{\"A\":600,\"B\":800,\"C\":1200}', '2024-11-04 04:55:51', '2024-11-04 04:55:51');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:232:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:20:\"view admin dashboard\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:27:\"view organisation dashboard\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:21:\"view driver dashboard\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:32:\"view refueling station dashboard\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:12:\"manage users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:12:\"view profile\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:12:\"edit profile\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:14:\"delete profile\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:16:\"manage customers\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:14:\"view customers\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:15:\"create customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:13:\"edit customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:15:\"delete customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:17:\"activate customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:19:\"deactivate customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:15:\"update customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:16:\"import customers\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:16:\"export customers\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:20:\"manage organisations\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:18:\"view organisations\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:19:\"create organisation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:17:\"edit organisation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:19:\"delete organisation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:19:\"update organisation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:21:\"activate organisation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:23:\"deactivate organisation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:20:\"export organisations\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:27;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:20:\"import organisations\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:28;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:17:\"show organisation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:29;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:14:\"manage drivers\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:30;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:12:\"view drivers\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:31;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:11:\"show driver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:32;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:13:\"create driver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:33;a:4:{s:1:\"a\";i:34;s:1:\"b\";s:11:\"edit driver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:34;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:15:\"activate driver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:35;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:17:\"deactivate driver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:36;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:14:\"assign vehicle\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:37;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:16:\"unassign vehicle\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:38;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:13:\"delete driver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:39;a:4:{s:1:\"a\";i:40;s:1:\"b\";s:14:\"export drivers\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:40;a:4:{s:1:\"a\";i:41;s:1:\"b\";s:14:\"import drivers\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:41;a:4:{s:1:\"a\";i:42;s:1:\"b\";s:22:\"manage driver licenses\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:42;a:4:{s:1:\"a\";i:43;s:1:\"b\";s:20:\"view driver licenses\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:43;a:4:{s:1:\"a\";i:44;s:1:\"b\";s:19:\"show driver license\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:44;a:4:{s:1:\"a\";i:45;s:1:\"b\";s:21:\"create driver license\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:45;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:19:\"edit driver license\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:46;a:4:{s:1:\"a\";i:47;s:1:\"b\";s:21:\"verify driver license\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:47;a:4:{s:1:\"a\";i:48;s:1:\"b\";s:21:\"revoke driver license\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:48;a:4:{s:1:\"a\";i:49;s:1:\"b\";s:21:\"delete driver license\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:49;a:4:{s:1:\"a\";i:50;s:1:\"b\";s:22:\"export driver licenses\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:50;a:4:{s:1:\"a\";i:51;s:1:\"b\";s:22:\"import driver licenses\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:51;a:4:{s:1:\"a\";i:52;s:1:\"b\";s:23:\"manage driver psvbadges\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:52;a:4:{s:1:\"a\";i:53;s:1:\"b\";s:21:\"view driver psvbadges\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:53;a:4:{s:1:\"a\";i:54;s:1:\"b\";s:20:\"show driver psvbadge\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:54;a:4:{s:1:\"a\";i:55;s:1:\"b\";s:22:\"create driver psvbadge\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:55;a:4:{s:1:\"a\";i:56;s:1:\"b\";s:20:\"edit driver psvbadge\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:56;a:4:{s:1:\"a\";i:57;s:1:\"b\";s:22:\"verify driver psvbadge\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:57;a:4:{s:1:\"a\";i:58;s:1:\"b\";s:22:\"revoke driver psvbadge\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:58;a:4:{s:1:\"a\";i:59;s:1:\"b\";s:22:\"delete driver psvbadge\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:59;a:4:{s:1:\"a\";i:60;s:1:\"b\";s:23:\"export driver psvbadges\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:60;a:4:{s:1:\"a\";i:61;s:1:\"b\";s:23:\"import driver psvbadges\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:61;a:4:{s:1:\"a\";i:62;s:1:\"b\";s:23:\"show driver performance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:62;a:4:{s:1:\"a\";i:63;s:1:\"b\";s:15:\"manage vehicles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:63;a:4:{s:1:\"a\";i:64;s:1:\"b\";s:13:\"view vehicles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:64;a:4:{s:1:\"a\";i:65;s:1:\"b\";s:12:\"show vehicle\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:65;a:4:{s:1:\"a\";i:66;s:1:\"b\";s:14:\"create vehicle\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:66;a:4:{s:1:\"a\";i:67;s:1:\"b\";s:12:\"edit vehicle\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:67;a:4:{s:1:\"a\";i:68;s:1:\"b\";s:14:\"delete vehicle\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:68;a:4:{s:1:\"a\";i:69;s:1:\"b\";s:16:\"activate vehicle\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:69;a:4:{s:1:\"a\";i:70;s:1:\"b\";s:18:\"deactivate vehicle\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:70;a:4:{s:1:\"a\";i:71;s:1:\"b\";s:13:\"assign driver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:71;a:4:{s:1:\"a\";i:72;s:1:\"b\";s:15:\"unassign driver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:72;a:4:{s:1:\"a\";i:73;s:1:\"b\";s:15:\"export vehicles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:73;a:4:{s:1:\"a\";i:74;s:1:\"b\";s:15:\"import vehicles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:74;a:4:{s:1:\"a\";i:75;s:1:\"b\";s:25:\"manage vehicle insurances\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:75;a:4:{s:1:\"a\";i:76;s:1:\"b\";s:23:\"view vehicle insurances\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:76;a:4:{s:1:\"a\";i:77;s:1:\"b\";s:22:\"show vehicle insurance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:77;a:4:{s:1:\"a\";i:78;s:1:\"b\";s:24:\"create vehicle insurance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:78;a:4:{s:1:\"a\";i:79;s:1:\"b\";s:22:\"edit vehicle insurance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:79;a:4:{s:1:\"a\";i:80;s:1:\"b\";s:24:\"delete vehicle insurance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:80;a:4:{s:1:\"a\";i:81;s:1:\"b\";s:26:\"activate vehicle insurance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:81;a:4:{s:1:\"a\";i:82;s:1:\"b\";s:28:\"deactivate vehicle insurance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:82;a:4:{s:1:\"a\";i:83;s:1:\"b\";s:25:\"export vehicle insurances\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:83;a:4:{s:1:\"a\";i:84;s:1:\"b\";s:25:\"import vehicle insurances\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:84;a:4:{s:1:\"a\";i:85;s:1:\"b\";s:38:\"manage vehicle inspection certificates\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:85;a:4:{s:1:\"a\";i:86;s:1:\"b\";s:36:\"view vehicle inspection certificates\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:86;a:4:{s:1:\"a\";i:87;s:1:\"b\";s:35:\"show vehicle inspection certificate\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:87;a:4:{s:1:\"a\";i:88;s:1:\"b\";s:37:\"create vehicle inspection certificate\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:88;a:4:{s:1:\"a\";i:89;s:1:\"b\";s:35:\"edit vehicle inspection certificate\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:89;a:4:{s:1:\"a\";i:90;s:1:\"b\";s:37:\"delete vehicle inspection certificate\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:90;a:4:{s:1:\"a\";i:91;s:1:\"b\";s:39:\"activate vehicle inspection certificate\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:91;a:4:{s:1:\"a\";i:92;s:1:\"b\";s:41:\"deactivate vehicle inspection certificate\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:92;a:4:{s:1:\"a\";i:93;s:1:\"b\";s:38:\"export vehicle inspection certificates\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:93;a:4:{s:1:\"a\";i:94;s:1:\"b\";s:38:\"import vehicle inspection certificates\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:94;a:4:{s:1:\"a\";i:95;s:1:\"b\";s:13:\"manage routes\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:95;a:4:{s:1:\"a\";i:96;s:1:\"b\";s:11:\"view routes\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:96;a:4:{s:1:\"a\";i:97;s:1:\"b\";s:10:\"show route\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:97;a:4:{s:1:\"a\";i:98;s:1:\"b\";s:12:\"create route\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:98;a:4:{s:1:\"a\";i:99;s:1:\"b\";s:10:\"edit route\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:99;a:4:{s:1:\"a\";i:100;s:1:\"b\";s:12:\"delete route\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:100;a:4:{s:1:\"a\";i:101;s:1:\"b\";s:14:\"activate route\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:101;a:4:{s:1:\"a\";i:102;s:1:\"b\";s:16:\"deactivate route\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:102;a:4:{s:1:\"a\";i:103;s:1:\"b\";s:13:\"export routes\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:103;a:4:{s:1:\"a\";i:104;s:1:\"b\";s:13:\"import routes\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:104;a:4:{s:1:\"a\";i:105;s:1:\"b\";s:22:\"manage route locations\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:105;a:4:{s:1:\"a\";i:106;s:1:\"b\";s:20:\"view route locations\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:106;a:4:{s:1:\"a\";i:107;s:1:\"b\";s:19:\"show route location\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:107;a:4:{s:1:\"a\";i:108;s:1:\"b\";s:21:\"create route location\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:108;a:4:{s:1:\"a\";i:109;s:1:\"b\";s:19:\"edit route location\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:109;a:4:{s:1:\"a\";i:110;s:1:\"b\";s:21:\"delete route location\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:110;a:4:{s:1:\"a\";i:111;s:1:\"b\";s:23:\"activate route location\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:111;a:4:{s:1:\"a\";i:112;s:1:\"b\";s:25:\"deactivate route location\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:112;a:4:{s:1:\"a\";i:113;s:1:\"b\";s:22:\"export route locations\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:113;a:4:{s:1:\"a\";i:114;s:1:\"b\";s:22:\"import route locations\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:114;a:4:{s:1:\"a\";i:115;s:1:\"b\";s:12:\"manage trips\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:115;a:4:{s:1:\"a\";i:116;s:1:\"b\";s:10:\"view trips\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:116;a:4:{s:1:\"a\";i:117;s:1:\"b\";s:13:\"schedule trip\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:117;a:4:{s:1:\"a\";i:118;s:1:\"b\";s:32:\"assign vehicle to upcoming trips\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:118;a:4:{s:1:\"a\";i:119;s:1:\"b\";s:11:\"cancel trip\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:119;a:4:{s:1:\"a\";i:120;s:1:\"b\";s:13:\"complete trip\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:120;a:4:{s:1:\"a\";i:121;s:1:\"b\";s:19:\"add billing details\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:121;a:4:{s:1:\"a\";i:122;s:1:\"b\";s:9:\"bill trip\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:122;a:4:{s:1:\"a\";i:123;s:1:\"b\";s:12:\"pay for trip\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:123;a:4:{s:1:\"a\";i:124;s:1:\"b\";s:17:\"send trip invoice\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:124;a:4:{s:1:\"a\";i:125;s:1:\"b\";s:17:\"view trip invoice\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:125;a:4:{s:1:\"a\";i:126;s:1:\"b\";s:20:\"recieve trip payment\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:126;a:4:{s:1:\"a\";i:127;s:1:\"b\";s:12:\"export trips\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:127;a:4:{s:1:\"a\";i:128;s:1:\"b\";s:12:\"import trips\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:128;a:4:{s:1:\"a\";i:129;s:1:\"b\";s:26:\"manage insurance companies\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:129;a:4:{s:1:\"a\";i:130;s:1:\"b\";s:24:\"view insurance companies\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:130;a:4:{s:1:\"a\";i:131;s:1:\"b\";s:22:\"show insurance company\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:131;a:4:{s:1:\"a\";i:132;s:1:\"b\";s:24:\"create insurance company\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:132;a:4:{s:1:\"a\";i:133;s:1:\"b\";s:22:\"edit insurance company\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:133;a:4:{s:1:\"a\";i:134;s:1:\"b\";s:24:\"delete insurance company\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:134;a:4:{s:1:\"a\";i:135;s:1:\"b\";s:26:\"activate insurance company\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:135;a:4:{s:1:\"a\";i:136;s:1:\"b\";s:28:\"deactivate insurance company\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:136;a:4:{s:1:\"a\";i:137;s:1:\"b\";s:26:\"export insurance companies\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:137;a:4:{s:1:\"a\";i:138;s:1:\"b\";s:26:\"import insurance companies\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:138;a:4:{s:1:\"a\";i:139;s:1:\"b\";s:42:\"manage insurance company recurring periods\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:139;a:4:{s:1:\"a\";i:140;s:1:\"b\";s:40:\"view insurance company recurring periods\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:140;a:4:{s:1:\"a\";i:141;s:1:\"b\";s:39:\"show insurance company recurring period\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:141;a:4:{s:1:\"a\";i:142;s:1:\"b\";s:41:\"create insurance company recurring period\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:142;a:4:{s:1:\"a\";i:143;s:1:\"b\";s:39:\"edit insurance company recurring period\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:143;a:4:{s:1:\"a\";i:144;s:1:\"b\";s:41:\"delete insurance company recurring period\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:144;a:4:{s:1:\"a\";i:145;s:1:\"b\";s:43:\"activate insurance company recurring period\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:145;a:4:{s:1:\"a\";i:146;s:1:\"b\";s:45:\"deactivate insurance company recurring period\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:146;a:4:{s:1:\"a\";i:147;s:1:\"b\";s:42:\"export insurance company recurring periods\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:147;a:4:{s:1:\"a\";i:148;s:1:\"b\";s:42:\"import insurance company recurring periods\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:148;a:4:{s:1:\"a\";i:149;s:1:\"b\";s:18:\"manage maintenance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:149;a:4:{s:1:\"a\";i:150;s:1:\"b\";s:16:\"view maintenance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:150;a:4:{s:1:\"a\";i:151;s:1:\"b\";s:16:\"show maintenance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:151;a:4:{s:1:\"a\";i:152;s:1:\"b\";s:18:\"create maintenance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:152;a:4:{s:1:\"a\";i:153;s:1:\"b\";s:16:\"edit maintenance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:153;a:4:{s:1:\"a\";i:154;s:1:\"b\";s:18:\"delete maintenance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:154;a:4:{s:1:\"a\";i:155;s:1:\"b\";s:20:\"activate maintenance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:155;a:4:{s:1:\"a\";i:156;s:1:\"b\";s:22:\"deactivate maintenance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:156;a:4:{s:1:\"a\";i:157;s:1:\"b\";s:18:\"export maintenance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:157;a:4:{s:1:\"a\";i:158;s:1:\"b\";s:18:\"import maintenance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:158;a:4:{s:1:\"a\";i:159;s:1:\"b\";s:15:\"manage fuelling\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:159;a:4:{s:1:\"a\";i:160;s:1:\"b\";s:13:\"view fuelling\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:160;a:4:{s:1:\"a\";i:161;s:1:\"b\";s:13:\"show fuelling\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:161;a:4:{s:1:\"a\";i:162;s:1:\"b\";s:15:\"create fuelling\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:162;a:4:{s:1:\"a\";i:163;s:1:\"b\";s:13:\"edit fuelling\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:163;a:4:{s:1:\"a\";i:164;s:1:\"b\";s:15:\"delete fuelling\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:164;a:4:{s:1:\"a\";i:165;s:1:\"b\";s:17:\"activate fuelling\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:165;a:4:{s:1:\"a\";i:166;s:1:\"b\";s:19:\"deactivate fuelling\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:166;a:4:{s:1:\"a\";i:167;s:1:\"b\";s:15:\"export fuelling\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:167;a:4:{s:1:\"a\";i:168;s:1:\"b\";s:15:\"import fuelling\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:168;a:4:{s:1:\"a\";i:169;s:1:\"b\";s:24:\"manage fuelling stations\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:169;a:4:{s:1:\"a\";i:170;s:1:\"b\";s:22:\"view fuelling stations\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:170;a:4:{s:1:\"a\";i:171;s:1:\"b\";s:21:\"show fuelling station\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:171;a:4:{s:1:\"a\";i:172;s:1:\"b\";s:23:\"create fuelling station\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:172;a:4:{s:1:\"a\";i:173;s:1:\"b\";s:21:\"edit fuelling station\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:173;a:4:{s:1:\"a\";i:174;s:1:\"b\";s:23:\"delete fuelling station\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:174;a:4:{s:1:\"a\";i:175;s:1:\"b\";s:25:\"activate fuelling station\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:175;a:4:{s:1:\"a\";i:176;s:1:\"b\";s:27:\"deactivate fuelling station\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:176;a:4:{s:1:\"a\";i:177;s:1:\"b\";s:24:\"export fuelling stations\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:177;a:4:{s:1:\"a\";i:178;s:1:\"b\";s:24:\"import fuelling stations\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:178;a:4:{s:1:\"a\";i:179;s:1:\"b\";s:12:\"view reports\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:179;a:4:{s:1:\"a\";i:180;s:1:\"b\";s:14:\"export reports\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:180;a:4:{s:1:\"a\";i:181;s:1:\"b\";s:12:\"manage roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:181;a:4:{s:1:\"a\";i:182;s:1:\"b\";s:10:\"view roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:182;a:4:{s:1:\"a\";i:183;s:1:\"b\";s:9:\"show role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:183;a:4:{s:1:\"a\";i:184;s:1:\"b\";s:11:\"create role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:184;a:4:{s:1:\"a\";i:185;s:1:\"b\";s:9:\"edit role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:185;a:4:{s:1:\"a\";i:186;s:1:\"b\";s:11:\"delete role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:186;a:4:{s:1:\"a\";i:187;s:1:\"b\";s:13:\"activate role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:187;a:4:{s:1:\"a\";i:188;s:1:\"b\";s:15:\"deactivate role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:188;a:4:{s:1:\"a\";i:189;s:1:\"b\";s:12:\"export roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:189;a:4:{s:1:\"a\";i:190;s:1:\"b\";s:12:\"import roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:190;a:4:{s:1:\"a\";i:191;s:1:\"b\";s:18:\"manage permissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:191;a:4:{s:1:\"a\";i:192;s:1:\"b\";s:16:\"view permissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:192;a:4:{s:1:\"a\";i:193;s:1:\"b\";s:15:\"show permission\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:193;a:4:{s:1:\"a\";i:194;s:1:\"b\";s:17:\"create permission\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:194;a:4:{s:1:\"a\";i:195;s:1:\"b\";s:15:\"edit permission\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:195;a:4:{s:1:\"a\";i:196;s:1:\"b\";s:17:\"delete permission\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:196;a:4:{s:1:\"a\";i:197;s:1:\"b\";s:19:\"activate permission\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:197;a:4:{s:1:\"a\";i:198;s:1:\"b\";s:21:\"deactivate permission\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:198;a:4:{s:1:\"a\";i:199;s:1:\"b\";s:18:\"export permissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:199;a:4:{s:1:\"a\";i:200;s:1:\"b\";s:18:\"import permissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:200;a:4:{s:1:\"a\";i:201;s:1:\"b\";s:15:\"manage settings\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:201;a:4:{s:1:\"a\";i:202;s:1:\"b\";s:13:\"view settings\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:202;a:4:{s:1:\"a\";i:203;s:1:\"b\";s:13:\"edit settings\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:203;a:4:{s:1:\"a\";i:204;s:1:\"b\";s:15:\"update settings\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:204;a:4:{s:1:\"a\";i:205;s:1:\"b\";s:15:\"export settings\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:205;a:4:{s:1:\"a\";i:206;s:1:\"b\";s:15:\"import settings\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:206;a:4:{s:1:\"a\";i:207;s:1:\"b\";s:20:\"manage bank accounts\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:207;a:4:{s:1:\"a\";i:208;s:1:\"b\";s:18:\"view bank accounts\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:208;a:4:{s:1:\"a\";i:209;s:1:\"b\";s:17:\"show bank account\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:209;a:4:{s:1:\"a\";i:210;s:1:\"b\";s:19:\"create bank account\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:210;a:4:{s:1:\"a\";i:211;s:1:\"b\";s:17:\"edit bank account\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:211;a:4:{s:1:\"a\";i:212;s:1:\"b\";s:19:\"delete bank account\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:212;a:4:{s:1:\"a\";i:213;s:1:\"b\";s:21:\"activate bank account\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:213;a:4:{s:1:\"a\";i:214;s:1:\"b\";s:23:\"deactivate bank account\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:214;a:4:{s:1:\"a\";i:215;s:1:\"b\";s:20:\"export bank accounts\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:215;a:4:{s:1:\"a\";i:216;s:1:\"b\";s:20:\"import bank accounts\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:216;a:4:{s:1:\"a\";i:217;s:1:\"b\";s:15:\"manage expenses\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:217;a:4:{s:1:\"a\";i:218;s:1:\"b\";s:13:\"view expenses\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:218;a:4:{s:1:\"a\";i:219;s:1:\"b\";s:12:\"show expense\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:219;a:4:{s:1:\"a\";i:220;s:1:\"b\";s:14:\"create expense\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:220;a:4:{s:1:\"a\";i:221;s:1:\"b\";s:12:\"edit expense\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:221;a:4:{s:1:\"a\";i:222;s:1:\"b\";s:14:\"delete expense\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:222;a:4:{s:1:\"a\";i:223;s:1:\"b\";s:15:\"export expenses\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:223;a:4:{s:1:\"a\";i:224;s:1:\"b\";s:15:\"import expenses\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:224;a:4:{s:1:\"a\";i:225;s:1:\"b\";s:14:\"manage incomes\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:225;a:4:{s:1:\"a\";i:226;s:1:\"b\";s:12:\"view incomes\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:226;a:4:{s:1:\"a\";i:227;s:1:\"b\";s:11:\"show income\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:227;a:4:{s:1:\"a\";i:228;s:1:\"b\";s:13:\"create income\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:228;a:4:{s:1:\"a\";i:229;s:1:\"b\";s:11:\"edit income\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:229;a:4:{s:1:\"a\";i:230;s:1:\"b\";s:13:\"delete income\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:230;a:4:{s:1:\"a\";i:231;s:1:\"b\";s:14:\"export incomes\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:231;a:4:{s:1:\"a\";i:232;s:1:\"b\";s:14:\"import incomes\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}}s:5:\"roles\";a:5:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:12:\"organisation\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:4;s:1:\"b\";s:6:\"driver\";s:1:\"c\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:5;s:1:\"b\";s:17:\"refueling_station\";s:1:\"c\";s:3:\"web\";}i:4;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:8:\"customer\";s:1:\"c\";s:3:\"web\";}}}', 1731410626);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `organisation_id` bigint(20) UNSIGNED NOT NULL,
  `customer_organisation_code` varchar(255) DEFAULT NULL,
  `national_id_no` varchar(255) DEFAULT NULL,
  `national_id_front_avatar` varchar(255) DEFAULT NULL,
  `national_id_behind_avatar` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `user_id`, `organisation_id`, `customer_organisation_code`, `national_id_no`, `national_id_front_avatar`, `national_id_behind_avatar`, `created_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 11, 1, 'WELLFARGO', NULL, 'uploads/front-page-ids/1/1730724521_national_id_front.png', 'uploads/back-page-ids/1/1730724521_national_id_behind.png', 11, 'active', '2024-11-04 08:40:24', '2024-11-04 09:48:41'),
(2, 14, 2, 'Epledge', '123456789', NULL, NULL, 1, 'active', '2024-11-10 06:11:48', '2024-11-10 06:11:48'),
(3, 15, 2, 'Epledge', '234567890', NULL, NULL, 1, 'active', '2024-11-10 06:11:48', '2024-11-10 06:11:48'),
(4, 16, 2, 'Epledge', '345678901', NULL, NULL, 1, 'active', '2024-11-10 06:11:48', '2024-11-10 06:11:48'),
(5, 17, 2, 'Epledge', '456789012', NULL, NULL, 1, 'active', '2024-11-10 06:11:49', '2024-11-10 06:11:49'),
(6, 18, 2, 'Epledge', '567890123', NULL, NULL, 1, 'active', '2024-11-10 06:11:49', '2024-11-10 06:11:49'),
(7, 19, 2, 'Epledge', '678901234', NULL, NULL, 1, 'active', '2024-11-10 06:11:49', '2024-11-10 06:11:49'),
(8, 20, 2, 'Epledge', '789012345', NULL, NULL, 1, 'active', '2024-11-10 06:11:50', '2024-11-10 06:11:50'),
(9, 21, 2, 'Epledge', '890123456', NULL, NULL, 1, 'active', '2024-11-10 06:11:50', '2024-11-10 06:11:50'),
(10, 22, 2, 'Epledge', '901234567', NULL, NULL, 1, 'active', '2024-11-10 06:11:50', '2024-11-10 06:11:50'),
(11, 23, 2, 'Epledge', '12345678', NULL, NULL, 1, 'active', '2024-11-10 06:11:50', '2024-11-10 06:11:50'),
(12, 24, 2, 'Epledge', '123456789', NULL, NULL, 1, 'active', '2024-11-10 06:11:51', '2024-11-10 06:11:51'),
(13, 25, 2, 'Epledge', '234567890', NULL, NULL, 1, 'active', '2024-11-10 06:11:51', '2024-11-10 06:11:51'),
(14, 26, 2, 'Epledge', '345678901', NULL, NULL, 1, 'active', '2024-11-10 06:11:51', '2024-11-10 06:11:51'),
(15, 27, 2, 'Epledge', '456789012', NULL, NULL, 1, 'active', '2024-11-10 06:11:52', '2024-11-10 06:11:52'),
(16, 28, 2, 'Epledge', '567890123', NULL, NULL, 1, 'active', '2024-11-10 06:11:52', '2024-11-10 06:11:52'),
(17, 29, 2, 'Epledge', '678901234', NULL, NULL, 1, 'active', '2024-11-10 06:11:52', '2024-11-10 06:11:52'),
(18, 30, 2, 'Epledge', '789012345', NULL, NULL, 1, 'active', '2024-11-10 06:11:52', '2024-11-10 06:11:52'),
(19, 31, 2, 'Epledge', '890123456', NULL, NULL, 1, 'active', '2024-11-10 06:11:53', '2024-11-10 06:11:53'),
(20, 32, 2, 'Epledge', '901234567', NULL, NULL, 1, 'active', '2024-11-10 06:11:53', '2024-11-10 06:11:53'),
(21, 33, 2, 'Epledge', '12345678', NULL, NULL, 1, 'active', '2024-11-10 06:11:53', '2024-11-10 06:11:53'),
(22, 47, 2, 'Epledge', NULL, NULL, NULL, 47, 'inactive', '2024-11-12 03:43:29', '2024-11-12 03:43:29');

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `organisation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `vehicle_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `national_id_no` varchar(255) NOT NULL,
  `national_id_front_avatar` varchar(255) DEFAULT NULL,
  `national_id_behind_avatar` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `created_by`, `organisation_id`, `vehicle_id`, `user_id`, `national_id_no`, `national_id_front_avatar`, `national_id_behind_avatar`, `status`, `created_at`, `updated_at`) VALUES
(2, 10, 1, NULL, 10, '36951711', 'uploads/front-page-ids/-national-id-front.png', 'uploads/back-page-ids/-national-id-back.png', 'active', NULL, '2024-11-04 08:41:19'),
(3, 12, 1, NULL, 12, '36941711', 'uploads/front-page-ids/-national-id-front.png', 'uploads/back-page-ids/-national-id-back.png', 'active', NULL, '2024-11-05 09:46:01'),
(4, 1, NULL, NULL, 34, '123456789', NULL, NULL, 'active', '2024-11-10 06:23:02', '2024-11-10 06:23:02'),
(5, 1, NULL, NULL, 35, '234567890', NULL, NULL, 'active', '2024-11-10 06:23:03', '2024-11-10 06:23:03'),
(6, 1, NULL, NULL, 36, '345678901', NULL, NULL, 'active', '2024-11-10 06:23:03', '2024-11-10 06:23:03'),
(7, 1, NULL, NULL, 37, '456789012', NULL, NULL, 'active', '2024-11-10 06:23:03', '2024-11-10 06:23:03'),
(8, 1, NULL, NULL, 38, '567890123', NULL, NULL, 'active', '2024-11-10 06:23:03', '2024-11-10 06:23:03'),
(9, 1, NULL, NULL, 39, '678901234', NULL, NULL, 'active', '2024-11-10 06:23:03', '2024-11-10 06:23:03'),
(10, 1, NULL, NULL, 40, '789012345', NULL, NULL, 'active', '2024-11-10 06:23:04', '2024-11-10 06:23:04'),
(11, 1, NULL, NULL, 41, '890123456', NULL, NULL, 'active', '2024-11-10 06:23:04', '2024-11-10 06:23:04'),
(12, 1, NULL, NULL, 42, '901234567', NULL, NULL, 'active', '2024-11-10 06:23:04', '2024-11-10 06:23:04'),
(13, 1, NULL, NULL, 43, '12345678', NULL, NULL, 'active', '2024-11-10 06:23:04', '2024-11-10 06:23:04'),
(14, 1, NULL, NULL, 44, '1234567890', NULL, NULL, 'active', '2024-11-10 06:23:05', '2024-11-10 06:23:05'),
(15, 1, NULL, NULL, 45, '2345678901', NULL, NULL, 'active', '2024-11-10 06:23:05', '2024-11-10 06:23:05'),
(16, 1, NULL, NULL, 46, '3456789012', NULL, NULL, 'active', '2024-11-10 06:23:05', '2024-11-10 06:23:05');

-- --------------------------------------------------------

--
-- Table structure for table `drivers_licenses`
--

CREATE TABLE `drivers_licenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `driver_id` bigint(20) UNSIGNED NOT NULL,
  `driving_license_no` varchar(255) NOT NULL,
  `driving_license_date_of_issue` date NOT NULL,
  `driving_license_date_of_expiry` date NOT NULL,
  `driving_license_avatar_front` varchar(255) DEFAULT NULL,
  `driving_license_avatar_back` varchar(255) DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `drivers_licenses`
--

INSERT INTO `drivers_licenses` (`id`, `driver_id`, `driving_license_no`, `driving_license_date_of_issue`, `driving_license_date_of_expiry`, `driving_license_avatar_front`, `driving_license_avatar_back`, `verified`, `created_at`, `updated_at`) VALUES
(2, 2, '345708', '2024-11-04', '2025-06-17', 'uploads/front-license-pics/-front-license.png', 'uploads/back-license-pics/-back-license.png', 1, '2024-11-04 08:33:03', '2024-11-04 08:40:43'),
(3, 3, '34570845646', '2024-06-05', '2025-01-09', 'uploads/front-license-pics/-front-license.jpg', 'uploads/back-license-pics/-back-license.png', 0, '2024-11-05 09:29:02', '2024-11-05 09:29:42');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `category` enum('vehicle_insurance','ntsa_inspection_certificate','vehicle_service','vehicle_repairs','vehicle_parts_purchase','fuel') NOT NULL,
  `entry_date` date NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `incomes`
--

CREATE TABLE `incomes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `category` enum('trips') NOT NULL,
  `entry_date` date NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `insurance_companies`
--

CREATE TABLE `insurance_companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `insurance_recurring_periods`
--

CREATE TABLE `insurance_recurring_periods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `period` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(191) DEFAULT NULL,
  `full_name` varchar(191) DEFAULT NULL,
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
  `id` bigint(20) UNSIGNED NOT NULL,
  `mail_mailer` varchar(255) DEFAULT 'smtp',
  `mail_host` varchar(255) DEFAULT NULL,
  `mail_port` int(11) DEFAULT NULL,
  `mail_username` varchar(255) DEFAULT NULL,
  `mail_password` varchar(255) DEFAULT NULL,
  `mail_encryption` varchar(255) DEFAULT NULL,
  `mail_from_address` varchar(255) DEFAULT NULL,
  `mail_from_name` varchar(255) DEFAULT NULL,
  `app_debug` tinyint(1) DEFAULT 0,
  `force_https` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_repairs`
--

CREATE TABLE `maintenance_repairs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED NOT NULL,
  `creator_id` bigint(20) UNSIGNED NOT NULL,
  `part_id` bigint(20) UNSIGNED NOT NULL,
  `repair_date` date NOT NULL,
  `repair_type` enum('repair','replacement','refill') NOT NULL,
  `repair_cost` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `repair_description` text DEFAULT NULL,
  `repair_status` enum('pending','billed','approved','rejected','paid','partially paid') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_repair_payments`
--

CREATE TABLE `maintenance_repair_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `maintenance_repair_id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED NOT NULL,
  `part_id` bigint(20) UNSIGNED NOT NULL,
  `repair_type` varchar(255) NOT NULL,
  `repair_cost` decimal(10,2) NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_no` varchar(255) NOT NULL,
  `receipt_type_code` varchar(255) DEFAULT NULL,
  `payment_type_code` varchar(255) DEFAULT NULL,
  `confirm_date` date DEFAULT NULL,
  `payment_date` date NOT NULL,
  `total_taxable_amount` decimal(10,2) DEFAULT NULL,
  `total_tax_amount` decimal(10,2) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `remark` text DEFAULT NULL,
  `payment_receipt` varchar(255) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `qr_code_url` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_services`
--

CREATE TABLE `maintenance_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED NOT NULL,
  `creator_id` bigint(20) UNSIGNED NOT NULL,
  `service_type_id` bigint(20) UNSIGNED NOT NULL,
  `service_category_id` bigint(20) UNSIGNED NOT NULL,
  `service_date` date NOT NULL,
  `service_cost` decimal(10,2) NOT NULL,
  `service_description` text NOT NULL,
  `service_status` enum('pending','billed','approved','rejected','paid','partially paid') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_service_payments`
--

CREATE TABLE `maintenance_service_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `maintenance_service_id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED NOT NULL,
  `service_type_id` bigint(20) UNSIGNED NOT NULL,
  `service_category_id` bigint(20) UNSIGNED NOT NULL,
  `service_date` date NOT NULL,
  `service_cost` decimal(10,2) NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_no` varchar(255) NOT NULL,
  `receipt_type_code` varchar(255) DEFAULT NULL,
  `payment_type_code` varchar(255) DEFAULT NULL,
  `confirm_date` date DEFAULT NULL,
  `payment_date` date NOT NULL,
  `total_taxable_amount` decimal(10,2) NOT NULL,
  `total_tax_amount` decimal(10,2) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `payment_receipt` varchar(255) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `qr_code_url` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
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
(9, '2024_06_05_12379_create_billing_rates_table', 1),
(10, '2024_06_05_12380_create_customers_table', 1),
(11, '2024_06_05_123828_create_drivers_table', 1),
(12, '2024_06_05_123829_add_foreign_keys_to_vehicles_table', 1),
(13, '2024_06_05_123830_add_foreign_keys_to_drivers_table', 1),
(14, '2024_06_07_133544_create_vehicles_services_table', 1),
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
(47, '2024_07_29_113514_create_languages_table', 1),
(48, '2024_07_31_073239_create_mail_settings_table', 1),
(49, '2024_08_01_080830_add_columns_to_ntsa_inspection_certificates_table', 1),
(50, '2024_08_01_080945_create_expenses_table', 1),
(51, '2024_08_01_113821_create_incomes_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 3),
(2, 'App\\Models\\User', 4),
(2, 'App\\Models\\User', 5),
(2, 'App\\Models\\User', 6),
(2, 'App\\Models\\User', 7),
(2, 'App\\Models\\User', 8),
(2, 'App\\Models\\User', 9),
(2, 'App\\Models\\User', 13);

-- --------------------------------------------------------

--
-- Table structure for table `ntsa_inspection_certificates`
--

CREATE TABLE `ntsa_inspection_certificates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED NOT NULL,
  `creator_id` bigint(20) UNSIGNED NOT NULL,
  `ntsa_inspection_certificate_no` varchar(255) NOT NULL,
  `ntsa_inspection_certificate_date_of_issue` date NOT NULL,
  `ntsa_inspection_certificate_date_of_expiry` date NOT NULL,
  `ntsa_inspection_certificate_avatar` varchar(255) DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cost` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organisations`
--

CREATE TABLE `organisations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `certificate_of_organisation` varchar(255) DEFAULT NULL,
  `billing_cycle` varchar(255) DEFAULT NULL,
  `terms_and_conditions` tinyint(4) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `organisation_code` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organisations`
--

INSERT INTO `organisations` (`id`, `user_id`, `certificate_of_organisation`, `billing_cycle`, `terms_and_conditions`, `created_by`, `organisation_code`, `status`, `created_at`, `updated_at`) VALUES
(1, 9, 'organisation-certificates/wellfargo@gmail.com-certificate.pdf', NULL, NULL, 1, 'WELLFARGO', 'active', '2024-11-04 06:45:43', '2024-11-04 08:33:50'),
(2, 13, 'organisation-certificates/info@epledgeinc.com-certificate.pdf', NULL, NULL, 1, 'Epledge', 'active', '2024-11-10 06:10:27', '2024-11-10 06:10:54');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view admin dashboard', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(2, 'view organisation dashboard', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(3, 'view driver dashboard', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(4, 'view refueling station dashboard', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(5, 'manage users', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(6, 'view profile', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(7, 'edit profile', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(8, 'delete profile', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(9, 'manage customers', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(10, 'view customers', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(11, 'create customer', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(12, 'edit customer', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(13, 'delete customer', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(14, 'activate customer', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(15, 'deactivate customer', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(16, 'update customer', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(17, 'import customers', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(18, 'export customers', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(19, 'manage organisations', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(20, 'view organisations', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(21, 'create organisation', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(22, 'edit organisation', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(23, 'delete organisation', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(24, 'update organisation', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(25, 'activate organisation', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(26, 'deactivate organisation', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(27, 'export organisations', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(28, 'import organisations', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(29, 'show organisation', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(30, 'manage drivers', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(31, 'view drivers', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(32, 'show driver', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(33, 'create driver', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(34, 'edit driver', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(35, 'activate driver', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(36, 'deactivate driver', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(37, 'assign vehicle', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(38, 'unassign vehicle', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(39, 'delete driver', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(40, 'export drivers', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(41, 'import drivers', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(42, 'manage driver licenses', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(43, 'view driver licenses', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(44, 'show driver license', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(45, 'create driver license', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(46, 'edit driver license', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(47, 'verify driver license', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(48, 'revoke driver license', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(49, 'delete driver license', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(50, 'export driver licenses', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(51, 'import driver licenses', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(52, 'manage driver psvbadges', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(53, 'view driver psvbadges', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(54, 'show driver psvbadge', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(55, 'create driver psvbadge', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(56, 'edit driver psvbadge', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(57, 'verify driver psvbadge', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(58, 'revoke driver psvbadge', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(59, 'delete driver psvbadge', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(60, 'export driver psvbadges', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(61, 'import driver psvbadges', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(62, 'show driver performance', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(63, 'manage vehicles', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(64, 'view vehicles', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(65, 'show vehicle', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(66, 'create vehicle', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(67, 'edit vehicle', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(68, 'delete vehicle', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(69, 'activate vehicle', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(70, 'deactivate vehicle', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(71, 'assign driver', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(72, 'unassign driver', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(73, 'export vehicles', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(74, 'import vehicles', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(75, 'manage vehicle insurances', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(76, 'view vehicle insurances', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(77, 'show vehicle insurance', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(78, 'create vehicle insurance', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(79, 'edit vehicle insurance', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(80, 'delete vehicle insurance', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(81, 'activate vehicle insurance', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(82, 'deactivate vehicle insurance', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(83, 'export vehicle insurances', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(84, 'import vehicle insurances', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(85, 'manage vehicle inspection certificates', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(86, 'view vehicle inspection certificates', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(87, 'show vehicle inspection certificate', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(88, 'create vehicle inspection certificate', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(89, 'edit vehicle inspection certificate', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(90, 'delete vehicle inspection certificate', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(91, 'activate vehicle inspection certificate', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(92, 'deactivate vehicle inspection certificate', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(93, 'export vehicle inspection certificates', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(94, 'import vehicle inspection certificates', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(95, 'manage routes', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(96, 'view routes', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(97, 'show route', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(98, 'create route', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(99, 'edit route', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(100, 'delete route', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(101, 'activate route', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(102, 'deactivate route', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(103, 'export routes', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(104, 'import routes', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(105, 'manage route locations', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(106, 'view route locations', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(107, 'show route location', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(108, 'create route location', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(109, 'edit route location', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(110, 'delete route location', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(111, 'activate route location', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(112, 'deactivate route location', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(113, 'export route locations', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(114, 'import route locations', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(115, 'manage trips', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(116, 'view trips', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(117, 'schedule trip', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(118, 'assign vehicle to upcoming trips', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(119, 'cancel trip', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(120, 'complete trip', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(121, 'add billing details', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(122, 'bill trip', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(123, 'pay for trip', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(124, 'send trip invoice', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(125, 'view trip invoice', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(126, 'recieve trip payment', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(127, 'export trips', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(128, 'import trips', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(129, 'manage insurance companies', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(130, 'view insurance companies', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(131, 'show insurance company', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(132, 'create insurance company', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(133, 'edit insurance company', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(134, 'delete insurance company', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(135, 'activate insurance company', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(136, 'deactivate insurance company', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(137, 'export insurance companies', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(138, 'import insurance companies', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(139, 'manage insurance company recurring periods', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(140, 'view insurance company recurring periods', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(141, 'show insurance company recurring period', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(142, 'create insurance company recurring period', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(143, 'edit insurance company recurring period', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(144, 'delete insurance company recurring period', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(145, 'activate insurance company recurring period', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(146, 'deactivate insurance company recurring period', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(147, 'export insurance company recurring periods', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(148, 'import insurance company recurring periods', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(149, 'manage maintenance', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(150, 'view maintenance', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(151, 'show maintenance', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(152, 'create maintenance', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(153, 'edit maintenance', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(154, 'delete maintenance', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(155, 'activate maintenance', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(156, 'deactivate maintenance', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(157, 'export maintenance', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(158, 'import maintenance', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(159, 'manage fuelling', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(160, 'view fuelling', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(161, 'show fuelling', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(162, 'create fuelling', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(163, 'edit fuelling', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(164, 'delete fuelling', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(165, 'activate fuelling', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(166, 'deactivate fuelling', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(167, 'export fuelling', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(168, 'import fuelling', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(169, 'manage fuelling stations', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(170, 'view fuelling stations', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(171, 'show fuelling station', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(172, 'create fuelling station', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(173, 'edit fuelling station', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(174, 'delete fuelling station', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(175, 'activate fuelling station', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(176, 'deactivate fuelling station', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(177, 'export fuelling stations', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(178, 'import fuelling stations', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(179, 'view reports', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(180, 'export reports', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(181, 'manage roles', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(182, 'view roles', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(183, 'show role', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(184, 'create role', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(185, 'edit role', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(186, 'delete role', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(187, 'activate role', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(188, 'deactivate role', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(189, 'export roles', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(190, 'import roles', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(191, 'manage permissions', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(192, 'view permissions', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(193, 'show permission', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(194, 'create permission', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(195, 'edit permission', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(196, 'delete permission', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(197, 'activate permission', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(198, 'deactivate permission', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(199, 'export permissions', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(200, 'import permissions', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(201, 'manage settings', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(202, 'view settings', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(203, 'edit settings', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(204, 'update settings', 'web', '2024-11-04 04:55:50', '2024-11-04 04:55:50'),
(205, 'export settings', 'web', '2024-11-04 04:55:50', '2024-11-04 04:55:50'),
(206, 'import settings', 'web', '2024-11-04 04:55:50', '2024-11-04 04:55:50'),
(207, 'manage bank accounts', 'web', '2024-11-04 04:55:50', '2024-11-04 04:55:50'),
(208, 'view bank accounts', 'web', '2024-11-04 04:55:50', '2024-11-04 04:55:50'),
(209, 'show bank account', 'web', '2024-11-04 04:55:50', '2024-11-04 04:55:50'),
(210, 'create bank account', 'web', '2024-11-04 04:55:50', '2024-11-04 04:55:50'),
(211, 'edit bank account', 'web', '2024-11-04 04:55:50', '2024-11-04 04:55:50'),
(212, 'delete bank account', 'web', '2024-11-04 04:55:50', '2024-11-04 04:55:50'),
(213, 'activate bank account', 'web', '2024-11-04 04:55:50', '2024-11-04 04:55:50'),
(214, 'deactivate bank account', 'web', '2024-11-04 04:55:50', '2024-11-04 04:55:50'),
(215, 'export bank accounts', 'web', '2024-11-04 04:55:50', '2024-11-04 04:55:50'),
(216, 'import bank accounts', 'web', '2024-11-04 04:55:50', '2024-11-04 04:55:50'),
(217, 'manage expenses', 'web', '2024-11-04 04:55:50', '2024-11-04 04:55:50'),
(218, 'view expenses', 'web', '2024-11-04 04:55:50', '2024-11-04 04:55:50'),
(219, 'show expense', 'web', '2024-11-04 04:55:50', '2024-11-04 04:55:50'),
(220, 'create expense', 'web', '2024-11-04 04:55:50', '2024-11-04 04:55:50'),
(221, 'edit expense', 'web', '2024-11-04 04:55:50', '2024-11-04 04:55:50'),
(222, 'delete expense', 'web', '2024-11-04 04:55:50', '2024-11-04 04:55:50'),
(223, 'export expenses', 'web', '2024-11-04 04:55:50', '2024-11-04 04:55:50'),
(224, 'import expenses', 'web', '2024-11-04 04:55:50', '2024-11-04 04:55:50'),
(225, 'manage incomes', 'web', '2024-11-04 04:55:50', '2024-11-04 04:55:50'),
(226, 'view incomes', 'web', '2024-11-04 04:55:50', '2024-11-04 04:55:50'),
(227, 'show income', 'web', '2024-11-04 04:55:50', '2024-11-04 04:55:50'),
(228, 'create income', 'web', '2024-11-04 04:55:50', '2024-11-04 04:55:50'),
(229, 'edit income', 'web', '2024-11-04 04:55:50', '2024-11-04 04:55:50'),
(230, 'delete income', 'web', '2024-11-04 04:55:50', '2024-11-04 04:55:50'),
(231, 'export incomes', 'web', '2024-11-04 04:55:50', '2024-11-04 04:55:50'),
(232, 'import incomes', 'web', '2024-11-04 04:55:50', '2024-11-04 04:55:50');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
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
  `id` bigint(20) UNSIGNED NOT NULL,
  `driver_id` bigint(20) UNSIGNED NOT NULL,
  `psv_badge_no` varchar(255) NOT NULL,
  `psv_badge_date_of_issue` date NOT NULL,
  `psv_badge_date_of_expiry` date NOT NULL,
  `psv_badge_avatar` varchar(255) DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `psv_badges`
--

INSERT INTO `psv_badges` (`id`, `driver_id`, `psv_badge_no`, `psv_badge_date_of_issue`, `psv_badge_date_of_expiry`, `psv_badge_avatar`, `verified`, `created_at`, `updated_at`) VALUES
(1, 2, 'KTYG67-YU56Y', '2024-11-04', '2025-02-12', 'uploads/psvbadge-avatars/-psv-badge.png', 1, '2024-11-04 08:33:33', '2024-11-04 08:41:00'),
(4, 3, 'KTYG67-YU56Y35353', '2024-01-01', '2025-11-19', 'uploads/psvbadge-avatars/-psv-badge.jpg', 0, '2024-11-05 10:20:08', '2024-11-05 10:20:08');

-- --------------------------------------------------------

--
-- Table structure for table `refuelling_stations`
--

CREATE TABLE `refuelling_stations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `station_code` varchar(255) NOT NULL,
  `certificate_of_operations` varchar(255) NOT NULL,
  `payment_period` enum('daily','weekly','monthly','quarterly','biannually','annually') NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `repairs`
--

CREATE TABLE `repairs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `repairs`
--

INSERT INTO `repairs` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Electrical', 'Electrical Repair', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(2, 'Mechanical', 'Mechanical Repair', '2024-11-04 04:55:51', '2024-11-04 04:55:51');

-- --------------------------------------------------------

--
-- Table structure for table `repair_categories`
--

CREATE TABLE `repair_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `repair_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ride_type`
--

CREATE TABLE `ride_type` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(2, 'organisation', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(3, 'customer', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(4, 'driver', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49'),
(5, 'refueling_station', 'web', '2024-11-04 04:55:49', '2024-11-04 04:55:49');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(2, 2),
(3, 1),
(3, 4),
(4, 1),
(4, 5),
(5, 1),
(5, 2),
(6, 1),
(6, 2),
(6, 3),
(6, 4),
(6, 5),
(7, 1),
(7, 2),
(7, 3),
(7, 4),
(7, 5),
(8, 1),
(8, 2),
(8, 3),
(8, 4),
(8, 5),
(9, 1),
(9, 2),
(10, 1),
(10, 2),
(11, 1),
(11, 2),
(12, 1),
(12, 2),
(13, 1),
(13, 2),
(14, 1),
(14, 2),
(15, 1),
(15, 2),
(16, 1),
(16, 2),
(17, 1),
(17, 2),
(18, 1),
(18, 2),
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
(30, 2),
(31, 1),
(31, 2),
(32, 1),
(32, 2),
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
(63, 2),
(64, 1),
(64, 2),
(65, 1),
(65, 2),
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
(95, 2),
(96, 1),
(96, 2),
(97, 1),
(97, 2),
(98, 1),
(99, 1),
(100, 1),
(101, 1),
(102, 1),
(103, 1),
(104, 1),
(105, 1),
(105, 2),
(106, 1),
(106, 2),
(107, 1),
(107, 2),
(108, 1),
(109, 1),
(110, 1),
(111, 1),
(112, 1),
(113, 1),
(114, 1),
(115, 1),
(115, 2),
(115, 3),
(116, 1),
(116, 2),
(116, 3),
(117, 1),
(117, 2),
(117, 3),
(118, 1),
(119, 1),
(119, 4),
(120, 1),
(120, 4),
(121, 1),
(122, 1),
(123, 1),
(123, 2),
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
(149, 4),
(150, 1),
(150, 4),
(151, 1),
(151, 4),
(152, 1),
(152, 4),
(153, 1),
(153, 4),
(154, 1),
(155, 1),
(156, 1),
(157, 1),
(158, 1),
(159, 1),
(159, 4),
(159, 5),
(160, 1),
(160, 4),
(160, 5),
(161, 1),
(161, 4),
(161, 5),
(162, 1),
(162, 4),
(162, 5),
(163, 1),
(163, 4),
(163, 5),
(164, 1),
(164, 5),
(165, 1),
(165, 5),
(166, 1),
(166, 5),
(167, 1),
(167, 5),
(168, 1),
(168, 5),
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
(201, 2),
(202, 1),
(202, 2),
(203, 1),
(203, 2),
(204, 1),
(204, 2),
(205, 1),
(205, 2),
(206, 1),
(206, 2),
(207, 1),
(208, 1),
(209, 1),
(210, 1),
(211, 1),
(212, 1),
(213, 1),
(214, 1),
(215, 1),
(216, 1),
(217, 1),
(218, 1),
(219, 1),
(220, 1),
(221, 1),
(222, 1),
(223, 1),
(224, 1),
(225, 1),
(226, 1),
(227, 1),
(228, 1),
(229, 1),
(230, 1),
(231, 1),
(232, 1);

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `county` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`id`, `county`, `name`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Nairobi', 'Nairobi - Thika', 1, '2024-11-04 08:42:14', '2024-11-04 08:42:14'),
(2, 'Nairobi', 'Nairobi - Limuru', 1, '2024-11-10 05:00:29', '2024-11-10 05:00:29'),
(4, 'Nairobi', 'Nairobi - Kajiado', 1, '2024-11-10 05:01:35', '2024-11-10 05:01:35'),
(5, 'Nairobi', 'Nairobi - Kiambu Town', 1, '2024-11-10 05:02:13', '2024-11-10 05:02:13'),
(6, 'Nairobi', 'Nairobi - Naivasha', 1, '2024-11-10 05:02:57', '2024-11-10 05:02:57');

-- --------------------------------------------------------

--
-- Table structure for table `route_locations`
--

CREATE TABLE `route_locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `route_id` bigint(20) UNSIGNED NOT NULL,
  `is_start_location` tinyint(1) NOT NULL DEFAULT 0,
  `is_end_location` tinyint(1) NOT NULL DEFAULT 0,
  `is_waypoint` tinyint(1) NOT NULL DEFAULT 0,
  `point_order` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `route_locations`
--

INSERT INTO `route_locations` (`id`, `route_id`, `is_start_location`, `is_end_location`, `is_waypoint`, `point_order`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, 0, NULL, 'Nairobi', '2024-11-04 08:42:14', '2024-11-04 08:42:14'),
(2, 1, 0, 1, 0, NULL, 'Thika', '2024-11-04 08:42:14', '2024-11-04 08:42:14'),
(3, 1, 0, 0, 1, 1, 'Ngara', '2024-11-04 08:43:55', '2024-11-10 05:25:32'),
(4, 1, 0, 0, 1, 2, 'Garden City Mall', '2024-11-04 08:43:55', '2024-11-04 08:43:55'),
(5, 1, 0, 0, 1, 3, 'Thika Road Mall', '2024-11-04 08:43:55', '2024-11-04 08:43:55'),
(6, 1, 0, 0, 1, 4, 'Ruiru', '2024-11-04 08:43:55', '2024-11-04 08:43:55'),
(7, 1, 0, 0, 1, 5, 'Juja', '2024-11-04 08:43:55', '2024-11-04 08:43:55'),
(9, 2, 1, 0, 0, NULL, 'Nairobi', '2024-11-10 05:00:29', '2024-11-10 05:00:29'),
(10, 2, 0, 1, 0, NULL, 'Limuru', '2024-11-10 05:00:29', '2024-11-10 05:00:29'),
(13, 4, 1, 0, 0, NULL, 'Nairobi', '2024-11-10 05:01:35', '2024-11-10 05:01:35'),
(14, 4, 0, 1, 0, NULL, 'Kajiado', '2024-11-10 05:01:35', '2024-11-10 05:01:35'),
(15, 5, 1, 0, 0, NULL, 'Nairobi', '2024-11-10 05:02:13', '2024-11-10 05:02:13'),
(16, 5, 0, 1, 0, NULL, 'Kiambu Town', '2024-11-10 05:02:13', '2024-11-10 05:02:13'),
(17, 6, 1, 0, 0, NULL, 'Nairobi', '2024-11-10 05:02:57', '2024-11-10 05:02:57'),
(18, 6, 0, 1, 0, NULL, 'Naivasha', '2024-11-10 05:02:57', '2024-11-10 05:02:57'),
(19, 5, 0, 0, 1, 1, 'Otc', '2024-11-10 05:08:36', '2024-11-10 05:08:36'),
(20, 5, 0, 0, 1, 2, 'Ngara Stage', '2024-11-10 05:08:36', '2024-11-10 05:08:36'),
(21, 5, 0, 0, 1, 3, 'Starehe Divisional Police Station', '2024-11-10 05:08:36', '2024-11-10 05:08:36'),
(22, 5, 0, 0, 1, 4, 'Pangani', '2024-11-10 05:08:36', '2024-11-10 05:08:36'),
(23, 5, 0, 0, 1, 5, 'Muthaiga', '2024-11-10 05:08:36', '2024-11-10 05:08:36'),
(24, 5, 0, 0, 1, 6, 'Kenya Forestry Service Station/Kfs Karura Gate', '2024-11-10 05:08:36', '2024-11-10 05:08:36'),
(25, 5, 0, 0, 1, 7, 'Cid', '2024-11-10 05:08:36', '2024-11-10 05:08:36'),
(26, 5, 0, 0, 1, 8, 'Shark\'s Palace', '2024-11-10 05:08:36', '2024-11-10 05:08:36'),
(27, 5, 0, 0, 1, 9, 'Rock City', '2024-11-10 05:08:36', '2024-11-10 05:08:36'),
(28, 5, 0, 0, 1, 10, 'Wanderjoy', '2024-11-10 05:08:36', '2024-11-10 05:08:36'),
(29, 5, 0, 0, 1, 11, 'Ridgeway Springs', '2024-11-10 05:08:36', '2024-11-10 05:08:36'),
(30, 5, 0, 0, 1, 12, 'Runda Junction', '2024-11-10 05:08:36', '2024-11-10 05:08:36'),
(31, 5, 0, 0, 1, 13, 'Githogoro', '2024-11-10 05:08:36', '2024-11-10 05:08:36'),
(32, 5, 0, 0, 1, 14, 'Kwaheri Flyover', '2024-11-10 05:08:36', '2024-11-10 05:08:36'),
(33, 5, 0, 0, 1, 15, 'Evergreen', '2024-11-10 05:08:36', '2024-11-10 05:08:36'),
(34, 5, 0, 0, 1, 16, 'Kasarini', '2024-11-10 05:08:36', '2024-11-10 05:08:36'),
(35, 5, 0, 0, 1, 17, 'Kasarini Stage', '2024-11-10 05:08:36', '2024-11-10 05:08:36'),
(36, 5, 0, 0, 1, 18, 'Thindigwa', '2024-11-10 05:08:36', '2024-11-10 05:08:36'),
(37, 5, 0, 0, 1, 19, 'Mushroom', '2024-11-10 05:10:31', '2024-11-10 05:10:31'),
(38, 5, 0, 0, 1, 20, 'Barua', '2024-11-10 05:10:31', '2024-11-10 05:10:31'),
(39, 5, 0, 0, 1, 21, 'Kist', '2024-11-10 05:10:31', '2024-11-10 05:10:31'),
(40, 5, 0, 0, 1, 22, 'Kirigiti Junction', '2024-11-10 05:10:31', '2024-11-10 05:10:31'),
(41, 5, 0, 0, 1, 23, 'Kwa Do', '2024-11-10 05:10:31', '2024-11-10 05:10:31'),
(42, 5, 0, 0, 1, 24, 'Kcb Kiambu', '2024-11-10 05:10:31', '2024-11-10 05:10:31'),
(43, 5, 0, 0, 1, 25, 'Kamindi Supermarket', '2024-11-10 05:10:31', '2024-11-10 05:10:31'),
(44, 5, 0, 0, 1, 26, 'Kiambu Bus Terminus', '2024-11-10 05:10:31', '2024-11-10 05:10:31'),
(45, 4, 0, 0, 1, 1, 'Mlolongo', '2024-11-10 05:19:17', '2024-11-10 05:19:17'),
(46, 4, 0, 0, 1, 2, 'Athi River', '2024-11-10 05:19:17', '2024-11-10 05:19:17'),
(47, 4, 0, 0, 1, 3, 'Kitengela', '2024-11-10 05:19:17', '2024-11-10 05:19:17'),
(48, 4, 0, 0, 1, 4, 'Isinya', '2024-11-10 05:19:17', '2024-11-10 05:19:17'),
(49, 4, 0, 0, 1, 5, 'Kisaju', '2024-11-10 05:19:17', '2024-11-10 05:19:17'),
(50, 4, 0, 0, 1, 6, 'Corner Baridi (Ol Tepesi)', '2024-11-10 05:19:17', '2024-11-10 05:19:17'),
(51, 4, 0, 0, 1, 7, 'Kajiado Town', '2024-11-10 05:19:17', '2024-11-10 05:19:17'),
(52, 2, 0, 0, 1, 1, 'Westlands', '2024-11-10 05:21:50', '2024-11-10 05:21:50'),
(53, 2, 0, 0, 1, 2, 'Mountain View', '2024-11-10 05:21:50', '2024-11-10 05:21:50'),
(54, 2, 0, 0, 1, 3, 'Uthiru', '2024-11-10 05:21:50', '2024-11-10 05:21:50'),
(55, 2, 0, 0, 1, 4, 'Kikuyu Town', '2024-11-10 05:21:50', '2024-11-10 05:21:50'),
(56, 2, 0, 0, 1, 5, 'Zambezi', '2024-11-10 05:21:50', '2024-11-10 05:21:50'),
(57, 2, 0, 0, 1, 6, 'Sigona', '2024-11-10 05:21:50', '2024-11-10 05:21:50'),
(58, 2, 0, 0, 1, 7, 'Tigoni', '2024-11-10 05:21:50', '2024-11-10 05:21:50'),
(59, 2, 0, 0, 1, 8, 'Limuru Town', '2024-11-10 05:21:50', '2024-11-10 05:21:50'),
(60, 6, 0, 0, 1, 1, 'Limuru Town', '2024-11-10 05:24:22', '2024-11-10 05:24:22'),
(61, 6, 0, 0, 1, 2, 'The Great Rift Valley Viewpoint', '2024-11-10 05:24:22', '2024-11-10 05:24:22'),
(62, 6, 0, 0, 1, 3, 'Mai Mahiu Town', '2024-11-10 05:24:22', '2024-11-10 05:24:22'),
(63, 6, 0, 0, 1, 4, 'Mt. Longonot National Park Gate', '2024-11-10 05:24:22', '2024-11-10 05:24:22'),
(64, 6, 0, 0, 1, 5, 'Naivasha Town', '2024-11-10 05:24:22', '2024-11-10 05:24:22'),
(65, 6, 0, 0, 1, 6, 'Karagita Public Beach (Lake Naivasha)', '2024-11-10 05:24:22', '2024-11-10 05:24:22');

-- --------------------------------------------------------

--
-- Table structure for table `service_types`
--

CREATE TABLE `service_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_types`
--

INSERT INTO `service_types` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Major Service', 'A major service is a comprehensive service that covers all areas of essential maintenance.', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(2, 'Minor Service', 'A minor service is a basic service that covers all areas of essential maintenance.', '2024-11-04 04:55:51', '2024-11-04 04:55:51');

-- --------------------------------------------------------

--
-- Table structure for table `service_type_categories`
--

CREATE TABLE `service_type_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_type_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_type_categories`
--

INSERT INTO `service_type_categories` (`id`, `service_type_id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 2, 'Engine Oil', 'This is a Minor service for Engine Oil', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(2, 2, 'Gearbox Oil', 'This is a Minor service for Gearbox Oil', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(3, 2, 'Air Cleaner', 'This is a Minor service for Air Cleaner', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(4, 2, 'Oil Filter', 'This is a Minor service for Oil Filter', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(5, 2, 'Air Filter', 'This is a Minor service for Air Filter', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(6, 2, 'Wiper', 'This is a Minor service for Wiper', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(7, 2, 'Engine Coolant', 'This is a Minor service for Engine Coolant', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(8, 2, 'Brakes and Linings', 'This is a Minor service for Brakes and Linings', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(9, 1, 'Engine Oil', 'This is a Major Service for Engine Oil', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(10, 1, 'Gear Box Oil', 'This is a Major Service for Gear Box Oil', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(11, 1, 'Air Cleaner', 'This is a Major Service for Air Cleaner', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(12, 1, 'Oil Filter', 'This is a Major Service for Oil Filter', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(13, 1, 'Air Filter', 'This is a Major Service for Air Filter', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(14, 1, 'Wiper', 'This is a Major Service for Wiper', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(15, 1, 'Engine Coolant', 'This is a Major Service for Engine Coolant', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(16, 1, 'Alternator', 'This is a Major Service for Alternator', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(17, 1, 'Starter', 'This is a Major Service for Starter', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(18, 1, 'Battery', 'This is a Major Service for Battery', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(19, 1, 'Tyres', 'This is a Major Service for Tyres', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(20, 1, 'Timing Chain', 'This is a Major Service for Timing Chain', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(21, 1, 'Pulley Belt', 'This is a Major Service for Pulley Belt', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(22, 1, 'Spare Tyre', 'This is a Major Service for Spare Tyre', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(23, 1, 'Jack Wheel Spanner', 'This is a Major Service for Jack Wheel Spanner', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(24, 1, 'Head Lamps', 'This is a Major Service for Head Lamps', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(25, 1, 'Parking Warning Lights', 'This is a Major Service for Parking Warning Lights', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(26, 1, 'Brakes and Linings', 'This is a Major Service for Brakes and Linings', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(27, 1, 'Suspension Parts', 'This is a Major Service for Suspension Parts', '2024-11-04 04:55:51', '2024-11-04 04:55:51');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('TCxTW7T8yvCaJ8vbiTpAIAjJBTkMDWWBvu53UVCj', 47, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibGJ4QWlEQ294aWhwRlVyTkU1RHBlV2VXbWlXTkk2TnFFaHQ2eThkeCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jdXN0b21lci9ob21lcGFnZSI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ3O30=', 1731393936);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `site_url` varchar(255) DEFAULT NULL,
  `name_of_website` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `station_code_prefix` varchar(255) DEFAULT NULL,
  `maintenance_code_prefix` varchar(255) DEFAULT NULL,
  `station_requisition_prefix` varchar(255) DEFAULT NULL,
  `maintenance_requisition_prefix` varchar(255) DEFAULT NULL,
  `environment` varchar(255) DEFAULT NULL,
  `logo_white` varchar(255) DEFAULT NULL,
  `logo_black` varchar(255) DEFAULT NULL,
  `site_favicon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE `trips` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED DEFAULT NULL,
  `driver_id` bigint(20) UNSIGNED DEFAULT NULL,
  `route_id` bigint(20) UNSIGNED NOT NULL,
  `pick_up_time` time NOT NULL,
  `drop_off_time` time DEFAULT NULL,
  `pick_up_location` varchar(255) NOT NULL,
  `drop_off_location` varchar(255) DEFAULT NULL,
  `distance` decimal(8,2) DEFAULT NULL,
  `number_of_passengers` int(11) DEFAULT NULL,
  `trip_date` date NOT NULL,
  `status` enum('scheduled','assigned','completed','cancelled','billed','paid','partially paid') NOT NULL,
  `vehicle_mileage` decimal(8,2) DEFAULT NULL,
  `engine_hours` int(11) DEFAULT NULL,
  `fuel_consumed` decimal(8,2) DEFAULT NULL,
  `idle_time` int(11) DEFAULT NULL,
  `billing_rate_id` bigint(20) UNSIGNED DEFAULT NULL,
  `biller` bigint(20) UNSIGNED DEFAULT NULL,
  `total_price` decimal(8,2) DEFAULT NULL,
  `billed_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `billed_by` enum('distance','time','car_class') DEFAULT NULL,
  `ride_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trips`
--

INSERT INTO `trips` (`id`, `customer_id`, `vehicle_id`, `driver_id`, `route_id`, `pick_up_time`, `drop_off_time`, `pick_up_location`, `drop_off_location`, `distance`, `number_of_passengers`, `trip_date`, `status`, `vehicle_mileage`, `engine_hours`, `fuel_consumed`, `idle_time`, `billing_rate_id`, `biller`, `total_price`, `billed_at`, `created_by`, `billed_by`, `ride_type_id`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, 1, '14:30:00', NULL, '1', '2', NULL, NULL, '2024-11-11', 'scheduled', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2024-11-10 06:29:43', '2024-11-11 11:23:08'),
(2, 1, NULL, NULL, 1, '17:40:00', NULL, '1', '2', NULL, NULL, '2024-11-12', 'scheduled', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2024-11-10 08:36:16', '2024-11-11 11:22:34'),
(3, 2, NULL, NULL, 1, '16:38:00', NULL, '1', '2', NULL, NULL, '2024-11-11', 'scheduled', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2024-11-10 08:36:49', '2024-11-11 11:23:08'),
(4, 1, NULL, NULL, 4, '17:39:00', NULL, '14', '45', NULL, NULL, '2024-11-12', 'scheduled', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2024-11-10 08:39:45', '2024-11-11 10:32:14'),
(5, 1, NULL, NULL, 2, '17:39:00', NULL, '9', '55', NULL, NULL, '2024-11-12', 'scheduled', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2024-11-10 08:40:17', '2024-11-11 10:32:53'),
(6, 6, NULL, NULL, 4, '17:40:00', NULL, '13', '50', NULL, NULL, '2024-11-12', 'scheduled', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2024-11-10 08:40:52', '2024-11-11 10:32:14'),
(7, 7, NULL, NULL, 5, '17:41:00', NULL, '15', '30', NULL, NULL, '2024-11-12', 'scheduled', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2024-11-10 08:41:26', '2024-11-10 08:41:26'),
(8, 8, NULL, NULL, 4, '17:41:00', NULL, '13', '51', NULL, NULL, '2024-11-12', 'scheduled', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2024-11-10 08:41:56', '2024-11-11 10:32:14'),
(9, 9, NULL, NULL, 2, '17:42:00', NULL, '9', '53', NULL, NULL, '2024-11-12', 'scheduled', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2024-11-10 08:42:43', '2024-11-11 10:32:53'),
(10, 8, NULL, NULL, 2, '17:43:00', NULL, '9', '56', NULL, NULL, '2024-11-12', 'scheduled', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2024-11-10 08:43:18', '2024-11-11 10:32:53'),
(11, 11, NULL, NULL, 4, '17:43:00', NULL, '45', '51', NULL, NULL, '2024-11-12', 'scheduled', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2024-11-10 08:44:00', '2024-11-11 10:32:14'),
(12, 11, NULL, NULL, 1, '18:10:00', NULL, '1', '7', NULL, NULL, '2024-11-12', 'scheduled', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2024-11-10 09:10:38', '2024-11-11 11:22:34'),
(13, 16, NULL, NULL, 1, '17:00:00', NULL, 'Home', '2', NULL, NULL, '2024-11-13', 'scheduled', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2024-11-11 05:52:18', '2024-11-11 11:01:38'),
(14, 22, NULL, NULL, 1, '05:50:00', NULL, '1', 'Home', NULL, NULL, '2024-11-14', 'scheduled', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 47, NULL, NULL, '2024-11-12 03:45:36', '2024-11-12 03:45:36');

-- --------------------------------------------------------

--
-- Table structure for table `trip_payments`
--

CREATE TABLE `trip_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `trip_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_no` varchar(255) NOT NULL,
  `account_id` varchar(255) NOT NULL,
  `customer_tin` varchar(255) DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `receipt_type_code` varchar(255) DEFAULT NULL,
  `payment_type_code` varchar(255) DEFAULT NULL,
  `confirm_date` date DEFAULT NULL,
  `payment_date` date NOT NULL,
  `total_taxable_amount` decimal(15,2) DEFAULT NULL,
  `total_tax_amount` decimal(15,2) DEFAULT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `remark` text DEFAULT NULL,
  `payment_receipt` varchar(255) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `qr_code_url` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trip_pricing`
--

CREATE TABLE `trip_pricing` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ride_type_id` bigint(20) UNSIGNED NOT NULL,
  `base_price` decimal(10,2) DEFAULT NULL,
  `price_per_km` decimal(10,2) DEFAULT NULL,
  `price_per_minute` decimal(10,2) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'admin',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `address`, `avatar`, `role`, `created_by`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'MetroBerry Admin', 'admin@metroberry.co.ke', '$2y$12$eLIR3h9Nc0bFliYPn/lknur0uh1tEHY2Q5A57MNR3glSKNMjPtLQq', '0708373982', 'Nairobi, Kenya', 'avatars/1731392502_GibsonYAL-USER.jpg', 'admin', NULL, NULL, '2024-11-04 04:55:50', '2024-11-12 03:21:42'),
(2, 'Super Admin', 'superadmin@example.com', '$2y$12$eOcgC819JJOjM5ckR.VSa.qj0hDhWRd/4C2XFWhBvJFQgxcDrO6Uu', '0755366089', 'Nairobi, Kenya', 'superadmin.png', 'admin', NULL, NULL, '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(9, 'Wells Fargo', 'wellfargo@gmail.com', '$2y$12$3/edb0wMcTCORFn9JDN1PewgfHvhVu1Tj2/z0.5fIAr5SDd8PN.gK', '0754545454', '-1.2653121560271552, 36.810289465604654', 'company-logos/wellfargo@gmail.com-avatar.png', 'organisation', 1, NULL, '2024-11-04 06:45:43', '2024-11-04 06:45:43'),
(10, 'James Mike', 'jamesmike34@gmail.com', '$2y$12$/vshG9BoAz2fQoK5LZEJlO/0lmTWfng50mXuW5p5jyx0YSc2jRFKy', '0754568961', NULL, NULL, 'driver', NULL, NULL, NULL, NULL),
(11, 'Patel Michael', 'patelmichael@gmail.com', '$2y$12$8wGG5TXAn3Ub9NpZVn6QeufwKYw4962V/AYRSH8wow1qnV4GWyZ9O', '0756893489', NULL, NULL, 'customer', NULL, NULL, '2024-11-04 08:40:24', '2024-11-04 08:40:24'),
(12, 'Lukas Driver Testing', 'lukasdriver@gmail.com', '$2y$12$XMcO5du9B3YSUleMc7EVQ.OY5NHEZQ6tBSCKhGV5fDZZUa58krExy', '0723456789', NULL, NULL, 'driver', NULL, NULL, NULL, NULL),
(13, 'Epledge Inc', 'info@epledgeinc.com', '$2y$12$jFFKoYqr8Q7e60co/SrSNeSiGMTuoiwlEIPBlWpa5p8wedsxycvFa', '0734343434', '-1.2920659, 36.8219462', 'company-logos/info@epledgeinc.com-avatar.png', 'organisation', 1, NULL, '2024-11-10 06:10:27', '2024-11-10 06:10:27'),
(14, 'John Doe', 'johndoe@example.com', '$2y$12$a2Yfd.CqXbhWadbbM/XfI..kIR6WDV4btAwjHL/VtUeZvZ8Pp7.K2', '1234567890', '123 Main St', NULL, 'customer', 1, NULL, '2024-11-10 06:11:48', '2024-11-10 06:11:48'),
(15, 'Jane Smith', 'janesmith@example.com', '$2y$12$T2VTE1GYzIFF1EJ4ManAZO.QykO6yBf6o2tFWTQ09825isl/jdqqW', '2345678901', '456 Elm St', NULL, 'customer', 1, NULL, '2024-11-10 06:11:48', '2024-11-10 06:11:48'),
(16, 'Alice Johnson', 'alicejohnson@example.com', '$2y$12$cdsWkv1HD00C.c5YPrvkIeIBvP/1UFBdCBV1shMkk45nbvQD/u4rK', '3456789012', '789 Pine St', NULL, 'customer', 1, NULL, '2024-11-10 06:11:48', '2024-11-10 06:11:48'),
(17, 'Bob Brown', 'bobbrown@example.com', '$2y$12$XOrLSHR1GlUEIWy1KXCoae0YMS/QwpdyyFyPblvTThrfLV4CRAW0a', '4567890123', '321 Oak St', NULL, 'customer', 1, NULL, '2024-11-10 06:11:49', '2024-11-10 06:11:49'),
(18, 'Carol White', 'carolwhite@example.com', '$2y$12$FuEgwly4Xb3tcykWpiwCZOOcx/NcJN3oFVhurUFhSi2opGK9uJsA2', '5678901234', '654 Cedar St', NULL, 'customer', 1, NULL, '2024-11-10 06:11:49', '2024-11-10 06:11:49'),
(19, 'David Green', 'davidgreen@example.com', '$2y$12$nisUG7.AefPMhE8j23t2m.mn5MiiBwt1RsHSr31cl2yueLD9U3l3e', '6789012345', '987 Maple St', NULL, 'customer', 1, NULL, '2024-11-10 06:11:49', '2024-11-10 06:11:49'),
(20, 'Eva Black', 'evablack@example.com', '$2y$12$zrGUt2q3IZxryAW7iEMEYOaEAYMSGGxljzt3eHPWcsD9oJ5o0Dpoq', '7890123456', '147 Birch St', NULL, 'customer', 1, NULL, '2024-11-10 06:11:49', '2024-11-10 06:11:49'),
(21, 'Frank Harris', 'frankharris@example.com', '$2y$12$XFXpADsZHEN3EeEMYUHZ5.IsMByCFFE9Nb1xkP6sAcvrQgg4X6jsu', '8901234567', '258 Ash St', NULL, 'customer', 1, NULL, '2024-11-10 06:11:50', '2024-11-10 06:11:50'),
(22, 'Grace Lee', 'gracelee@example.com', '$2y$12$2U4aGPjxILQRUCAwEXhhyu1UXQvs.pTa7d14Zt.K/ld9/QmaHJE3y', '9012345678', '369 Walnut St', NULL, 'customer', 1, NULL, '2024-11-10 06:11:50', '2024-11-10 06:11:50'),
(23, 'Henry Clark', 'henryclark@example.com', '$2y$12$6NlFhgsI3efHc7P.g8g.1u1CdyTH1qUqfr88St7KWDB8ULkkCZ.ZG', '123456789', '471 Poplar St', NULL, 'customer', 1, NULL, '2024-11-10 06:11:50', '2024-11-10 06:11:50'),
(24, 'Ivy King', 'ivyking@example.com', '$2y$12$vK5gyB6Q5C5ZsQj/tRe/9Osnn9Q1JOwqDTeNpXM3huE9aW3Bc2cMa', '1234567891', '582 Redwood St', NULL, 'customer', 1, NULL, '2024-11-10 06:11:51', '2024-11-10 06:11:51'),
(25, 'Jack Scott', 'jackscott@example.com', '$2y$12$TZH8.06cF7tXIxok8FgPOu7qvwBi5sCLik0hpWdzPLPQCXfAjF0QC', '2345678902', '693 Spruce St', NULL, 'customer', 1, NULL, '2024-11-10 06:11:51', '2024-11-10 06:11:51'),
(26, 'Karen Baker', 'karenbaker@example.com', '$2y$12$f1EhIa3HKzCrqxEdGe8ot.lTU.XnqKrbm5EewCL6Jmx5pl26TtULi', '3456789013', '804 Sycamore St', NULL, 'customer', 1, NULL, '2024-11-10 06:11:51', '2024-11-10 06:11:51'),
(27, 'Laura Adams', 'lauraadams@example.com', '$2y$12$UStVUDiijafy1q3wyFSkhe71FldrV1.ugN4UuFQ3RY8dZaL0LChUq', '4567890124', '915 Willow St', NULL, 'customer', 1, NULL, '2024-11-10 06:11:51', '2024-11-10 06:11:51'),
(28, 'Mike Turner', 'miketurner@example.com', '$2y$12$l2sIJYtjk50ljdOq0JZsLeZTd6NwfRVRts9vj9uUMWJlRO/D9yIYC', '5678901235', '123 Hickory St', NULL, 'customer', 1, NULL, '2024-11-10 06:11:52', '2024-11-10 06:11:52'),
(29, 'Nancy Young', 'nancyyoung@example.com', '$2y$12$rQEQcK6DyqvRU4KiM6aPyemyVevpLpu2BOImkjrG5BQiTK59OeTPm', '6789012346', '234 Linden St', NULL, 'customer', 1, NULL, '2024-11-10 06:11:52', '2024-11-10 06:11:52'),
(30, 'Oliver Hill', 'oliverhill@example.com', '$2y$12$KMbJoHqHX4qPh1G1jkj9Iu6rIqymO/J3ZEPGdbELgit9U3pRCfGsy', '7890123457', '345 Hemlock St', NULL, 'customer', 1, NULL, '2024-11-10 06:11:52', '2024-11-10 06:11:52'),
(31, 'Paul Allen', 'paulallen@example.com', '$2y$12$L3baqX1B5vvDymFV8WcUouCQ8/87jX82EeFQNuP6.4egggk72s7yW', '8901234568', '456 Dogwood St', NULL, 'customer', 1, NULL, '2024-11-10 06:11:53', '2024-11-10 06:11:53'),
(32, 'Rachel Evans', 'rachelevans@example.com', '$2y$12$DfwV8VsmRc9P3ZuROSGdBOqJUqtFdlNYUslgE3Q5VSvM.Edhb17lO', '9012345679', '567 Aspen St', NULL, 'customer', 1, NULL, '2024-11-10 06:11:53', '2024-11-10 06:11:53'),
(33, 'Steve Baker', 'stevebaker@example.com', '$2y$12$Lez6WAyql4NTpdsaPJTg9uWohubWzBjQNGOBWygCbMF49j/CIlPJm', '123456781', '678 Palm St', NULL, 'customer', 1, NULL, '2024-11-10 06:11:53', '2024-11-10 06:11:53'),
(34, 'John Doe', 'john@example.com', '$2y$12$HU/fBGFK9n38IXlfZQ1MM.FcLljerSu19nxqiBG2eMug8fSnD8kmq', '1234567890', '123 Main St', NULL, 'driver', 1, NULL, '2024-11-10 06:23:02', '2024-11-10 06:23:02'),
(35, 'Jane Smith', 'jane@example.com', '$2y$12$J.Ol6LPSCGDTc5i7geFx5eiSw8533KmrOIwyCq0tZB0.BgYi7BXNq', '2345678901', '456 Oak St', NULL, 'driver', 1, NULL, '2024-11-10 06:23:03', '2024-11-10 06:23:03'),
(36, 'Bob Johnson', 'bob@example.com', '$2y$12$TSqbmj4z.AscHjJQA3iGR.kNFKrZxGZk/AyAZ8hPk4dM3ydWqB5ZS', '3456789012', '789 Pine St', NULL, 'driver', 1, NULL, '2024-11-10 06:23:03', '2024-11-10 06:23:03'),
(37, 'Alice Brown', 'alice@example.com', '$2y$12$OqGFo4ccIGkiCKZsos94XOgcKbIYk/SjIyHyXZX8gXXBafwEdF.nS', '4567890123', '321 Maple Ave', NULL, 'driver', 1, NULL, '2024-11-10 06:23:03', '2024-11-10 06:23:03'),
(38, 'Charlie Davis', 'charlie@example.com', '$2y$12$F0kVbkm02j5aCKdJChL17OvPaZr7ZKat1Tz0Z7u1q48tsexYX9pbC', '5678901234', '654 Cedar Blvd', NULL, 'driver', 1, NULL, '2024-11-10 06:23:03', '2024-11-10 06:23:03'),
(39, 'Emily Evans', 'emily@example.com', '$2y$12$GiAGMSnmSjnHSzIxEO635.xfBmjTBcSRhJCzdGkzCSWZytN4tcRAG', '6789012345', '987 Spruce Dr', NULL, 'driver', 1, NULL, '2024-11-10 06:23:03', '2024-11-10 06:23:03'),
(40, 'Frank Green', 'frank@example.com', '$2y$12$suoNMRXSgg4AGQT4a0Uyme9T/7KH39.POxzvATSj8MCwt3S5G6mea', '7890123456', '123 Birch Rd', NULL, 'driver', 1, NULL, '2024-11-10 06:23:04', '2024-11-10 06:23:04'),
(41, 'Grace Hill', 'grace@example.com', '$2y$12$vti2Ek0TOeGnAny9SJgxve.2Q5jkeoZveJr8NcgpYswJABBCaNEBi', '8901234567', '456 Aspen Ln', NULL, 'driver', 1, NULL, '2024-11-10 06:23:04', '2024-11-10 06:23:04'),
(42, 'Henry White', 'henry@example.com', '$2y$12$.UC4XVkJRXzXWPQuOuLXnuTPOpzmfPQJqIzXe9V42vRKGaI042oue', '9012345678', '789 Elm St', NULL, 'driver', 1, NULL, '2024-11-10 06:23:04', '2024-11-10 06:23:04'),
(43, 'Isabel Young', 'isabel@example.com', '$2y$12$ONSC91eFrLQawCA.dbyRt.Xtp1B.LaFFn8jKwEigyTo0lvK/MGMbq', '1234567801', '321 Chestnut Ct', NULL, 'driver', 1, NULL, '2024-11-10 06:23:04', '2024-11-10 06:23:04'),
(44, 'Jack Black', 'jack@example.com', '$2y$12$dfwS5knadKb2U/pUWZMxdufJ7tc30TB9SORCsIhZpiO7x7ybD2xqm', '2345678902', '654 Walnut Way', NULL, 'driver', 1, NULL, '2024-11-10 06:23:05', '2024-11-10 06:23:05'),
(45, 'Karen Taylor', 'karen@example.com', '$2y$12$/o/RyoYNX8yLP0jSwOn0DuEkThso0i7vTdYnLec1smdip3UsbE.eS', '3456789013', '987 Poplar Pl', NULL, 'driver', 1, NULL, '2024-11-10 06:23:05', '2024-11-10 06:23:05'),
(46, 'Liam Harris', 'liam@example.com', '$2y$12$tbC.dJxMUY8JojI6hsynBezOM3ofYknvMGljOMoedgIsiXM/RM8L6', '4567890124', '123 Hickory Ln', NULL, 'driver', 1, NULL, '2024-11-10 06:23:05', '2024-11-10 06:23:05'),
(47, 'Patel Sherrif', 'patelsherrif@gmail.com', '$2y$12$hIWXkmKH4RD9liOAlksCP.J7f/zQj3Yo98aWWJhLp1OjjNUoUseVi', '0765458954', 'Likoni Gardens', NULL, 'customer', NULL, NULL, '2024-11-12 03:43:29', '2024-11-12 03:43:29');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `driver_id` bigint(20) UNSIGNED DEFAULT NULL,
  `organisation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `model` varchar(255) NOT NULL,
  `make` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL,
  `plate_number` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `seats` int(11) NOT NULL,
  `class` enum('A','B','C','D','E') NOT NULL,
  `fuel_type` varchar(255) NOT NULL,
  `engine_size` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `ride_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `created_by`, `driver_id`, `organisation_id`, `model`, `make`, `year`, `plate_number`, `color`, `seats`, `class`, `fuel_type`, `engine_size`, `avatar`, `ride_type_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, 'Corolla', 'Toyota', '2020', 'ABC123', 'Blue', 5, 'A', 'Petrol', '1.8', NULL, NULL, 'active', '2024-11-10 06:21:44', '2024-11-10 06:21:44'),
(2, 1, 2, 1, 'Civic', 'Honda', '2019', 'XYZ789', 'Red', 5, 'A', 'Petrol', '2', NULL, NULL, 'active', '2024-11-10 06:21:44', '2024-11-10 06:21:44'),
(3, 1, 3, 1, 'Model S', 'Tesla', '2021', 'LMN456', 'White', 5, 'A', 'Electric', '0', NULL, NULL, 'active', '2024-11-10 06:21:44', '2024-11-10 06:21:44'),
(4, 1, 4, NULL, 'F-150', 'Ford', '2018', 'DEF321', 'Black', 5, 'A', 'Diesel', '3.5', NULL, NULL, 'active', '2024-11-10 06:21:44', '2024-11-10 06:21:44'),
(5, 1, 5, NULL, 'X5', 'BMW', '2022', 'GHI654', 'Silver', 7, 'A', 'Petrol', '3', NULL, NULL, 'active', '2024-11-10 06:21:44', '2024-11-10 06:21:44'),
(6, 1, 6, NULL, 'Camry', 'Toyota', '2020', 'JKL987', 'Green', 5, 'A', 'Hybrid', '2.5', NULL, NULL, 'active', '2024-11-10 06:21:44', '2024-11-10 06:21:44'),
(7, 1, 7, NULL, 'Accord', 'Honda', '2019', 'MNO213', 'Blue', 5, 'A', 'Petrol', '1.5', NULL, NULL, 'active', '2024-11-10 06:21:44', '2024-11-10 06:21:44'),
(8, 1, 8, NULL, 'Model X', 'Tesla', '2021', 'PQR432', 'White', 7, 'A', 'Electric', '0', NULL, NULL, 'active', '2024-11-10 06:21:44', '2024-11-10 06:21:44'),
(9, 1, 9, NULL, 'Explorer', 'Ford', '2018', 'STU567', 'Black', 7, 'A', 'Petrol', '3.5', NULL, NULL, 'active', '2024-11-10 06:21:44', '2024-11-10 06:21:44'),
(10, 1, 10, NULL, 'X3', 'BMW', '2022', 'VWX678', 'Silver', 5, 'A', 'Petrol', '2', NULL, NULL, 'active', '2024-11-10 06:21:44', '2024-11-10 06:21:44'),
(11, 1, 11, NULL, 'Altima', 'Nissan', '2020', 'YZA890', 'Red', 5, 'A', 'Petrol', '2', NULL, NULL, 'active', '2024-11-10 06:21:44', '2024-11-10 06:21:44'),
(12, 1, 12, NULL, 'Outback', 'Subaru', '2019', 'BCD901', 'Green', 5, 'A', 'Petrol', '2.5', NULL, NULL, 'active', '2024-11-10 06:21:44', '2024-11-10 06:21:44'),
(13, 1, 13, NULL, 'Cayenne', 'Porsche', '2021', 'EFG432', 'Blue', 5, 'A', 'Petrol', '3', NULL, NULL, 'active', '2024-11-10 06:21:44', '2024-11-10 06:21:44'),
(14, 1, 14, NULL, 'Passat', 'Volkswagen', '2018', 'HIJ123', 'Black', 5, 'A', 'Diesel', '2', NULL, NULL, 'active', '2024-11-10 06:21:44', '2024-11-10 06:21:44'),
(15, 1, 15, NULL, 'Q5', 'Audi', '2022', 'KLM321', 'White', 5, 'A', 'Petrol', '2', NULL, NULL, 'active', '2024-11-10 06:21:44', '2024-11-10 06:21:44'),
(16, 1, 16, NULL, 'A4', 'Audi', '2020', 'NOP654', 'Silver', 5, 'A', 'Petrol', '2', NULL, NULL, 'active', '2024-11-10 06:21:44', '2024-11-10 06:21:44'),
(17, 1, NULL, NULL, 'Tahoe', 'Chevrolet', '2019', 'QRS987', 'Red', 7, 'A', 'Petrol', '5.3', NULL, NULL, 'active', '2024-11-10 06:21:44', '2024-11-10 06:21:44'),
(18, 1, NULL, NULL, 'Impreza', 'Subaru', '2021', 'TUV432', 'Green', 5, 'A', 'Petrol', '2', NULL, NULL, 'active', '2024-11-10 06:21:44', '2024-11-10 06:21:44'),
(19, 1, NULL, NULL, '3 Series', 'BMW', '2018', 'WXY567', 'Blue', 5, 'A', 'Diesel', '2', NULL, NULL, 'active', '2024-11-10 06:21:44', '2024-11-10 06:21:44'),
(20, 1, NULL, NULL, 'Escape', 'Ford', '2022', 'ZAB678', 'Silver', 5, 'A', 'Hybrid', '2.5', NULL, NULL, 'active', '2024-11-10 06:21:44', '2024-11-10 06:21:44');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_classes`
--

CREATE TABLE `vehicle_classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `min_passengers` int(11) NOT NULL,
  `max_passengers` int(11) NOT NULL,
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
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED NOT NULL,
  `insurance_company_id` bigint(20) UNSIGNED NOT NULL,
  `insurance_policy_no` varchar(255) NOT NULL,
  `insurance_date_of_issue` date NOT NULL,
  `insurance_date_of_expiry` date NOT NULL,
  `charges_payable` int(11) NOT NULL,
  `recurring_period_id` bigint(20) UNSIGNED NOT NULL,
  `recurring_date` date NOT NULL,
  `reminder` tinyint(1) NOT NULL,
  `deductible` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `policy_document` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_parts`
--

CREATE TABLE `vehicle_parts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `model_number` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `condition` enum('new','used','refurbished') NOT NULL DEFAULT 'new',
  `compatibility` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_part_categories`
--

CREATE TABLE `vehicle_part_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicle_part_categories`
--

INSERT INTO `vehicle_part_categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Engine', 'Engine parts', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(2, 'Transmission', 'Transmission parts', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(3, 'Suspension', 'Suspension parts', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(4, 'Brakes', 'Brake parts', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(5, 'Exhaust', 'Exhaust parts', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(6, 'Electrical', 'Electrical parts', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(7, 'Interior', 'Interior parts', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(8, 'Exterior', 'Exterior parts', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(9, 'Wheels', 'Wheel parts', '2024-11-04 04:55:51', '2024-11-04 04:55:51'),
(10, 'Tires', 'Tire parts', '2024-11-04 04:55:51', '2024-11-04 04:55:51');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_refuelings`
--

CREATE TABLE `vehicle_refuelings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED NOT NULL,
  `refuelling_station_id` bigint(20) UNSIGNED NOT NULL,
  `creator_id` bigint(20) UNSIGNED NOT NULL,
  `refuelling_date` date NOT NULL,
  `refuelling_time` time NOT NULL,
  `refuelling_volume` decimal(10,2) NOT NULL,
  `refuelling_cost` decimal(10,2) NOT NULL,
  `attendant_name` varchar(255) NOT NULL,
  `attendant_phone` varchar(255) NOT NULL,
  `status` enum('pending','approved','rejected','billed','paid','partially paid') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_services`
--

CREATE TABLE `vehicle_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
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
  ADD KEY `trips_driver_id_foreign` (`driver_id`),
  ADD KEY `trips_vehicle_id_foreign` (`vehicle_id`),
  ADD KEY `trips_route_id_foreign` (`route_id`),
  ADD KEY `trips_billing_rate_id_foreign` (`billing_rate_id`),
  ADD KEY `trips_created_by_foreign` (`created_by`),
  ADD KEY `trips_biller_foreign` (`biller`),
  ADD KEY `trips_ride_type_id_foreign` (`ride_type_id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `billing_rates`
--
ALTER TABLE `billing_rates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `drivers_licenses`
--
ALTER TABLE `drivers_licenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incomes`
--
ALTER TABLE `incomes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `insurance_companies`
--
ALTER TABLE `insurance_companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `insurance_recurring_periods`
--
ALTER TABLE `insurance_recurring_periods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `mail_settings`
--
ALTER TABLE `mail_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maintenance_repairs`
--
ALTER TABLE `maintenance_repairs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maintenance_repair_payments`
--
ALTER TABLE `maintenance_repair_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maintenance_services`
--
ALTER TABLE `maintenance_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maintenance_service_payments`
--
ALTER TABLE `maintenance_service_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `ntsa_inspection_certificates`
--
ALTER TABLE `ntsa_inspection_certificates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `organisations`
--
ALTER TABLE `organisations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=233;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `psv_badges`
--
ALTER TABLE `psv_badges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `refuelling_stations`
--
ALTER TABLE `refuelling_stations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `repairs`
--
ALTER TABLE `repairs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `repair_categories`
--
ALTER TABLE `repair_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ride_type`
--
ALTER TABLE `ride_type`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `route_locations`
--
ALTER TABLE `route_locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `service_types`
--
ALTER TABLE `service_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `service_type_categories`
--
ALTER TABLE `service_type_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trips`
--
ALTER TABLE `trips`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `trip_payments`
--
ALTER TABLE `trip_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trip_pricing`
--
ALTER TABLE `trip_pricing`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `vehicle_classes`
--
ALTER TABLE `vehicle_classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vehicle_insurances`
--
ALTER TABLE `vehicle_insurances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_parts`
--
ALTER TABLE `vehicle_parts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_part_categories`
--
ALTER TABLE `vehicle_part_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `vehicle_refuelings`
--
ALTER TABLE `vehicle_refuelings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_services`
--
ALTER TABLE `vehicle_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `trips_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`) ON DELETE CASCADE,
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
