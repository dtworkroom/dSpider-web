-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2017-01-08 14:23:19
-- 服务器版本： 10.1.10-MariaDB
-- PHP Version: 7.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dspider`
--

-- --------------------------------------------------------

--
-- 表的结构 `app_keys`
--

CREATE TABLE `app_keys` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `secret` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `package` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `app_keys`
--

INSERT INTO `app_keys` (`id`, `user_id`, `secret`, `name`, `package`, `state`, `created_at`, `updated_at`) VALUES
(1, 1, '25XBLR8vTFUHJPNz6LDMEe9r4tro683z', '小赢卡带', 'wendu.test.spider', 1, '2016-12-11 22:56:40', '2016-12-22 23:16:12'),
(4, 1, 'FiLGgJGMiC3S8VSGjgYA9Ok9KtomRxrW', '小赢理财', 'com.licai.xiaoying', 1, '2016-12-19 23:20:19', '2016-12-19 23:20:19');

-- --------------------------------------------------------

--
-- 表的结构 `crawl_records`
--

CREATE TABLE `crawl_records` (
  `id` int(10) UNSIGNED NOT NULL,
  `appKey_id` int(10) UNSIGNED NOT NULL,
  `spider_id` int(10) UNSIGNED NOT NULL,
  `config` text COLLATE utf8_unicode_ci,
  `state` tinyint(4) NOT NULL DEFAULT '-1',
  `msg` mediumtext COLLATE utf8_unicode_ci,
  `app_version` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sdk_version` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `device_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `crawl_records`
--

INSERT INTO `crawl_records` (`id`, `appKey_id`, `spider_id`, `config`, `state`, `msg`, `app_version`, `sdk_version`, `device_id`, `created_at`, `updated_at`) VALUES
(19, 1, 1, NULL, -2, '{"url":"https://www.baidu.com/","msg":"xx is not defined","args":{},"stack":"语法错误: xx is not defined\\nscript_url:http://172.19.23.62/dSpider-web/api/script?id=19&appkey=1&platform=1\\nReferenceError: xx is not defined\\n    at  http://172.19.23.62/dSpider-web/api/script?id=19&appkey=1&platform=1:307:1\\n    at HTMLDocument.<anonymous> ( http://172.19.23.62/dSpider-web/api/script?id=19&appkey=1&platform=1:177:21)\\n    at HTMLDocument.<anonymous> ( http://172.19.23.62/dSpider-web/api/script?id=19&appkey=1&platform=1:63:15)\\n    at j (https://www.baidu.com/xiaoying/jquery.min.js:2:30000)\\n    at k (https://www.baidu.com/xiaoying/jquery.min.js:2:30314)"}', '1.0', '1.0', 1, '2016-12-12 01:03:50', '2016-12-22 22:56:08'),
(21, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-12 01:30:21', '2016-12-12 01:30:24'),
(22, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 21:56:24', '2016-12-14 21:56:27'),
(23, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 22:02:30', '2016-12-14 22:02:33'),
(24, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 22:02:45', '2016-12-14 22:02:46'),
(25, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 22:02:56', '2016-12-14 22:03:36'),
(26, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 22:05:04', '2016-12-14 22:05:07'),
(27, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 22:05:29', '2016-12-14 22:05:30'),
(28, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 22:10:20', '2016-12-14 22:10:22'),
(29, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 22:10:36', '2016-12-14 22:10:37'),
(30, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 22:10:51', '2016-12-14 22:10:56'),
(31, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 22:12:47', '2016-12-14 22:12:49'),
(32, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 22:13:39', '2016-12-14 22:13:41'),
(33, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 22:14:11', '2016-12-14 22:14:13'),
(34, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 22:17:43', '2016-12-14 22:17:44'),
(35, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 22:18:52', '2016-12-14 22:18:54'),
(36, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 22:26:28', '2016-12-14 22:26:30'),
(37, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 22:27:10', '2016-12-14 22:27:12'),
(38, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 22:28:58', '2016-12-14 22:29:00'),
(39, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 22:29:23', '2016-12-14 22:29:38'),
(40, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 22:33:40', '2016-12-14 22:33:53'),
(41, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-14 23:01:16', '2016-12-14 23:01:19'),
(42, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 23:03:21', '2016-12-14 23:03:23'),
(43, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 23:03:49', '2016-12-14 23:03:50'),
(44, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 23:04:24', '2016-12-14 23:04:25'),
(45, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 23:06:05', '2016-12-14 23:06:20'),
(46, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 23:07:15', '2016-12-14 23:07:17'),
(47, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 23:07:24', '2016-12-14 23:07:24'),
(48, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 23:07:26', '2016-12-14 23:07:28'),
(49, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 23:07:30', '2016-12-14 23:07:31'),
(50, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 23:07:33', '2016-12-14 23:07:34'),
(51, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 23:07:36', '2016-12-14 23:07:37'),
(52, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 23:07:39', '2016-12-14 23:07:40'),
(53, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 23:07:42', '2016-12-14 23:07:43'),
(54, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 23:07:45', '2016-12-14 23:07:47'),
(55, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 23:07:49', '2016-12-14 23:07:50'),
(56, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 23:07:53', '2016-12-14 23:07:54'),
(57, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 23:07:58', '2016-12-14 23:07:59'),
(58, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 23:08:02', '2016-12-14 23:08:03'),
(59, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 23:20:48', '2016-12-14 23:20:50'),
(60, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 23:20:52', '2016-12-14 23:20:54'),
(61, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 23:20:56', '2016-12-14 23:20:57'),
(62, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 23:20:59', '2016-12-14 23:21:00'),
(63, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 23:21:02', '2016-12-14 23:21:04'),
(64, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 23:21:06', '2016-12-14 23:21:07'),
(65, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 23:21:09', '2016-12-14 23:21:10'),
(66, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 23:21:14', '2016-12-14 23:21:14'),
(67, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 23:21:17', '2016-12-14 23:21:18'),
(68, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-14 23:26:03', '2016-12-14 23:26:04'),
(69, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-15 00:14:55', '2016-12-15 00:14:58'),
(70, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-15 01:50:41', '2016-12-15 01:50:44'),
(71, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-15 02:07:32', '2016-12-15 02:07:34'),
(72, 1, 1, '', -2, NULL, '1.0', '1.0', 1, '2016-12-22 23:18:12', '2016-12-22 23:18:15'),
(73, 1, 1, '', -2, NULL, '1.0', '1.0', 1, '2016-12-22 23:20:50', '2016-12-22 23:21:22'),
(74, 1, 1, '', -2, NULL, '1.0', '1.0', 1, '2016-12-22 23:25:33', '2016-12-22 23:25:37'),
(75, 1, 1, '', -2, NULL, '1.0', '1.0', 1, '2016-12-22 23:26:06', '2016-12-22 23:27:02'),
(76, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-23 00:01:11', '2016-12-23 00:01:26'),
(77, 1, 1, NULL, -1, NULL, '1.0', '1.0', 1, '2016-12-23 18:09:50', '2016-12-23 18:09:50'),
(78, 1, 1, NULL, -1, NULL, '1.0', '1.0', 1, '2016-12-23 18:10:20', '2016-12-23 18:10:20'),
(79, 1, 1, NULL, -1, NULL, '1.0', '1.0', 1, '2016-12-23 18:12:51', '2016-12-23 18:12:51'),
(80, 1, 1, NULL, -1, NULL, '1.0', '1.0', 1, '2016-12-23 18:18:58', '2016-12-23 18:18:58'),
(81, 1, 1, NULL, -1, NULL, '1.0', '1.0', 1, '2016-12-23 18:21:17', '2016-12-23 18:21:17'),
(82, 1, 1, NULL, -1, NULL, '1.0', '1.0', 1, '2016-12-23 18:21:42', '2016-12-23 18:21:42'),
(83, 1, 1, NULL, -1, NULL, '1.0', '1.0', 1, '2016-12-23 18:22:38', '2016-12-23 18:22:38'),
(84, 1, 1, NULL, -1, NULL, '1.0', '1.0', 1, '2016-12-23 18:22:54', '2016-12-23 18:22:54'),
(85, 1, 1, NULL, -1, NULL, '1.0', '1.0', 1, '2016-12-23 18:25:16', '2016-12-23 18:25:16'),
(86, 1, 1, NULL, -1, NULL, '1.0', '1.0', 1, '2016-12-23 18:25:59', '2016-12-23 18:25:59'),
(87, 1, 1, NULL, -1, NULL, '1.0', '1.0', 1, '2016-12-23 18:29:49', '2016-12-23 18:29:49'),
(88, 1, 1, NULL, -1, NULL, '1.0', '1.0', 1, '2016-12-23 18:32:08', '2016-12-23 18:32:08'),
(89, 1, 1, NULL, -1, NULL, '1.0', '1.0', 1, '2016-12-23 18:32:57', '2016-12-23 18:32:57'),
(90, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-23 18:49:07', '2016-12-23 18:50:08'),
(91, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-23 18:57:28', '2016-12-23 18:57:33'),
(92, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-23 19:02:47', '2016-12-23 19:03:15'),
(93, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-23 19:04:17', '2016-12-23 19:04:22'),
(94, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-23 19:06:04', '2016-12-23 19:06:09'),
(95, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-23 19:08:01', '2016-12-23 19:08:02'),
(96, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-23 19:08:58', '2016-12-23 19:08:59'),
(97, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-23 19:13:01', '2016-12-23 19:13:02'),
(98, 1, 1, NULL, -1, NULL, '1.0', '1.0', 1, '2016-12-23 19:21:32', '2016-12-23 19:21:32'),
(99, 1, 1, NULL, -1, NULL, '1.0', '1.0', 1, '2016-12-23 19:22:22', '2016-12-23 19:22:22'),
(100, 1, 1, NULL, -1, NULL, '1.0', '1.0', 1, '2016-12-23 19:26:32', '2016-12-23 19:26:32'),
(101, 1, 1, NULL, -1, NULL, '1.0', '1.0', 1, '2016-12-23 19:34:52', '2016-12-23 19:34:52'),
(102, 1, 1, NULL, -1, NULL, '1.0', '1.0', 1, '2016-12-23 19:36:14', '2016-12-23 19:36:14'),
(103, 1, 1, NULL, -1, NULL, '1.0', '1.0', 1, '2016-12-23 19:38:28', '2016-12-23 19:38:28'),
(104, 1, 1, NULL, -1, NULL, '1.0', '1.0', 1, '2016-12-23 19:40:04', '2016-12-23 19:40:04'),
(105, 1, 1, NULL, -1, NULL, '1.0', '1.0', 1, '2016-12-23 19:42:45', '2016-12-23 19:42:45'),
(106, 1, 1, NULL, -1, NULL, '1.0', '1.0', 1, '2016-12-23 19:49:06', '2016-12-23 19:49:06'),
(107, 1, 1, NULL, -1, NULL, '1.0', '1.0', 1, '2016-12-23 19:51:52', '2016-12-23 19:51:52'),
(108, 1, 1, NULL, -1, NULL, '1.0', '1.0', 1, '2016-12-23 19:52:09', '2016-12-23 19:52:09'),
(109, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-28 01:23:03', '2016-12-28 01:23:05'),
(110, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-28 01:26:46', '2016-12-28 01:26:47'),
(111, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-28 01:31:48', '2016-12-28 01:31:49'),
(112, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-28 01:46:36', '2016-12-28 01:46:38'),
(113, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-28 01:49:04', '2016-12-28 01:49:05'),
(114, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-28 01:52:23', '2016-12-28 01:52:24'),
(115, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-28 01:54:50', '2016-12-28 01:54:51'),
(116, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-28 01:55:26', '2016-12-28 01:55:26'),
(117, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-28 01:55:34', '2016-12-28 01:55:35'),
(118, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-28 01:55:41', '2016-12-28 01:55:41'),
(119, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-28 01:55:46', '2016-12-28 01:55:47'),
(120, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-28 01:55:53', '2016-12-28 01:55:53'),
(121, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-28 01:57:00', '2016-12-28 01:57:00'),
(122, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-28 01:57:12', '2016-12-28 01:57:13'),
(123, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-28 01:57:19', '2016-12-28 01:57:19'),
(124, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-28 02:00:35', '2016-12-28 02:00:36'),
(125, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-28 02:01:13', '2016-12-28 02:01:13'),
(126, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-28 02:01:18', '2016-12-28 02:01:19'),
(127, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-28 02:08:59', '2016-12-28 02:09:00'),
(128, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-28 02:09:10', '2016-12-28 02:09:11'),
(129, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-28 02:09:16', '2016-12-28 02:09:17'),
(130, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-28 02:09:23', '2016-12-28 02:09:24'),
(131, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-28 02:09:30', '2016-12-28 02:09:31'),
(132, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-28 02:09:36', '2016-12-28 02:09:37'),
(133, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-28 02:09:54', '2016-12-28 02:09:55'),
(134, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2016-12-28 02:12:14', '2016-12-28 02:12:15'),
(135, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2017-01-03 19:19:45', '2017-01-03 19:19:45'),
(136, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2017-01-03 19:21:36', '2017-01-03 19:21:36'),
(137, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2017-01-03 19:26:26', '2017-01-03 19:26:26'),
(138, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2017-01-03 19:27:53', '2017-01-03 19:27:53'),
(139, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2017-01-03 22:38:50', '2017-01-03 22:38:50'),
(140, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2017-01-03 22:48:13', '2017-01-03 22:48:13'),
(141, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2017-01-03 22:49:13', '2017-01-03 22:49:13'),
(142, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2017-01-03 22:50:32', '2017-01-03 22:50:32'),
(143, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2017-01-03 22:51:28', '2017-01-03 22:51:28'),
(144, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2017-01-03 22:53:20', '2017-01-03 22:53:20'),
(145, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2017-01-03 22:53:28', '2017-01-03 22:53:28'),
(146, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2017-01-03 22:53:53', '2017-01-03 22:53:53'),
(147, 1, 1, NULL, -2, NULL, '1.0', '1.0', 1, '2017-01-03 22:56:16', '2017-01-03 22:56:16'),
(148, 1, 1, NULL, -2, NULL, '1.0', '1.0', 2, '2017-01-04 02:11:23', '2017-01-04 02:11:23'),
(149, 1, 1, NULL, -2, NULL, '1.0', '1.0', 2, '2017-01-04 02:31:25', '2017-01-04 02:31:25'),
(150, 1, 1, NULL, -2, NULL, '1.0', '1.0', 2, '2017-01-04 02:36:27', '2017-01-04 02:36:27'),
(151, 1, 1, NULL, -2, NULL, '1.0', '1.0', 2, '2017-01-04 02:37:19', '2017-01-04 02:37:19'),
(152, 1, 1, NULL, -2, NULL, '1.0', '1.0', 2, '2017-01-04 02:37:39', '2017-01-04 02:37:39'),
(153, 1, 1, NULL, -2, NULL, '1.0', '1.0', 2, '2017-01-04 02:38:33', '2017-01-04 02:38:33'),
(154, 1, 1, NULL, -2, NULL, '1.0', '1.0', 2, '2017-01-04 02:53:01', '2017-01-04 02:53:01'),
(155, 1, 1, NULL, -2, NULL, '1.0', '1.0', 2, '2017-01-04 03:09:39', '2017-01-04 03:09:39'),
(156, 1, 1, NULL, -2, NULL, '1.0', '1.0', 2, '2017-01-04 03:10:54', '2017-01-04 03:10:54'),
(157, 1, 1, NULL, -2, NULL, '1.0', '1.0', 2, '2017-01-04 03:15:40', '2017-01-04 03:15:40'),
(158, 1, 1, NULL, -2, NULL, '1.0', '1.0', 2, '2017-01-04 03:17:16', '2017-01-04 03:17:16'),
(159, 1, 1, NULL, -2, NULL, '1.0', '1.0', 2, '2017-01-04 03:23:27', '2017-01-04 03:23:27'),
(160, 1, 1, NULL, -2, NULL, '1.0', '1.0', 2, '2017-01-04 03:24:17', '2017-01-04 03:24:17'),
(161, 1, 1, NULL, -2, NULL, '1.0', '1.0', 2, '2017-01-04 03:25:14', '2017-01-04 03:25:14'),
(162, 1, 1, NULL, -2, NULL, '1.0', '1.0', 2, '2017-01-04 03:25:37', '2017-01-04 03:25:37'),
(163, 1, 1, NULL, -2, NULL, '1.0', '1.0', 2, '2017-01-04 03:33:37', '2017-01-04 03:33:37'),
(164, 1, 1, NULL, -2, NULL, '1.0', '1.0', 2, '2017-01-04 03:37:47', '2017-01-04 03:37:47'),
(165, 1, 1, NULL, -2, NULL, '1.0', '1.0', 2, '2017-01-04 03:39:36', '2017-01-04 03:39:36'),
(166, 1, 1, NULL, -2, NULL, '1.0', '1.0', 2, '2017-01-04 03:40:10', '2017-01-04 03:40:10'),
(167, 1, 1, NULL, -2, NULL, '1.0', '1.0', 2, '2017-01-04 03:41:16', '2017-01-04 03:41:16'),
(168, 1, 1, NULL, -2, NULL, '1.0', '1.0', 2, '2017-01-04 03:42:05', '2017-01-04 03:42:05'),
(169, 1, 1, NULL, -2, NULL, '1.0', '1.0', 2, '2017-01-04 03:46:11', '2017-01-04 03:46:11'),
(170, 1, 1, NULL, -2, NULL, '1.0', '1.0', 2, '2017-01-04 03:48:07', '2017-01-04 03:48:07'),
(171, 1, 1, NULL, -2, NULL, '1.0', '1.0', 2, '2017-01-04 03:49:39', '2017-01-04 03:49:39'),
(172, 1, 1, NULL, -2, NULL, '1.0', '1.0', 2, '2017-01-04 03:57:19', '2017-01-04 03:57:19'),
(173, 1, 1, NULL, -2, NULL, '1.0', '1.0', 2, '2017-01-04 03:59:53', '2017-01-04 03:59:53'),
(174, 1, 1, NULL, -2, NULL, '1.0', '1.0', 2, '2017-01-04 04:00:44', '2017-01-04 04:00:44'),
(175, 1, 1, NULL, -2, NULL, '1.0', '1.0', 2, '2017-01-04 18:12:39', '2017-01-04 18:12:39'),
(176, 1, 1, NULL, -2, NULL, '1.0', '1.0', 2, '2017-01-04 19:24:22', '2017-01-04 19:24:22'),
(177, 1, 1, NULL, -2, NULL, '1.0', '1.0', 2, '2017-01-04 19:26:52', '2017-01-04 19:26:52'),
(178, 1, 1, NULL, -2, NULL, '1.0', '1.0', 3, '2017-01-07 21:06:51', '2017-01-07 21:06:51'),
(179, 1, 1, NULL, -2, NULL, '1.0', '1.0', 3, '2017-01-07 21:10:26', '2017-01-07 21:10:26'),
(180, 1, 1, NULL, -2, NULL, '1.0', '1.0', 3, '2017-01-07 21:11:08', '2017-01-07 21:11:08'),
(181, 1, 1, NULL, -2, NULL, '1.0', '1.0', 3, '2017-01-07 21:12:16', '2017-01-07 21:12:16'),
(182, 1, 1, NULL, -2, NULL, '1.0', '1.0', 3, '2017-01-07 21:15:51', '2017-01-07 21:15:51'),
(183, 1, 1, NULL, -2, NULL, '1.0', '1.0', 3, '2017-01-07 21:16:50', '2017-01-07 21:16:50'),
(184, 1, 1, NULL, -2, NULL, '1.0', '1.0', 3, '2017-01-07 21:17:33', '2017-01-07 21:17:33'),
(185, 1, 1, NULL, -2, NULL, '1.0', '1.0', 3, '2017-01-07 21:17:50', '2017-01-07 21:17:50'),
(186, 1, 1, NULL, -2, NULL, '1.0', '1.0', 3, '2017-01-07 21:19:45', '2017-01-07 21:19:45'),
(187, 1, 1, NULL, -2, NULL, '1.0', '1.0', 3, '2017-01-07 21:20:25', '2017-01-07 21:20:25'),
(188, 1, 1, NULL, -2, NULL, '1.0', '1.0', 3, '2017-01-07 21:21:20', '2017-01-07 21:21:20'),
(189, 1, 1, NULL, -2, NULL, '1.0', '1.0', 3, '2017-01-07 21:21:40', '2017-01-07 21:21:40'),
(190, 1, 1, NULL, -2, NULL, '1.0', '1.0', 3, '2017-01-07 21:23:01', '2017-01-07 21:23:01'),
(191, 1, 1, NULL, -2, NULL, '1.0', '1.0', 3, '2017-01-07 21:26:00', '2017-01-07 21:26:00'),
(192, 1, 1, NULL, -2, NULL, '1.0', '1.0', 3, '2017-01-07 21:31:38', '2017-01-07 21:31:38');

-- --------------------------------------------------------

--
-- 表的结构 `devices`
--

CREATE TABLE `devices` (
  `id` int(10) UNSIGNED NOT NULL,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `os_type` tinyint(4) NOT NULL,
  `os_version` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `devices`
--

INSERT INTO `devices` (`id`, `identifier`, `os_type`, `os_version`, `model`, `created_at`, `updated_at`) VALUES
(1, '860076039858476', 1, '6.0', 'HUAWEI NXT-AL10', '2016-12-11 23:28:54', '2016-12-11 23:28:54'),
(2, 'iphone1', 2, '8.0', 'iphone7', '2017-01-04 02:11:23', '2017-01-04 02:11:23'),
(3, '000000000000000', 1, '5.0.2', 'Android SDK built for x86_64', '2017-01-07 21:06:51', '2017-01-07 21:06:51');

-- --------------------------------------------------------

--
-- 表的结构 `downloads`
--

CREATE TABLE `downloads` (
  `id` int(10) UNSIGNED NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `downloads`
--

INSERT INTO `downloads` (`id`, `count`, `created_at`, `updated_at`) VALUES
(1, 1, '2017-01-07 22:20:40', '2017-01-07 22:20:40'),
(2, 3, '2017-01-07 22:16:26', '2017-01-07 22:20:35');

-- --------------------------------------------------------

--
-- 表的结构 `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_12_01_021056_create_spiders_table', 1),
(4, '2016_12_01_093404_create_app_keys_table', 1),
(5, '2016_12_02_063620_create_spider_configs_table', 1),
(6, '2016_12_07_031352_create_devices_table', 1),
(7, '2016_12_12_055152_create_crawl_records_table', 1),
(8, '2017_01_08_060256_create_downloads_table', 2);

-- --------------------------------------------------------

--
-- 表的结构 `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `spiders`
--

CREATE TABLE `spiders` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `content` text COLLATE utf8_unicode_ci,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `readme` text COLLATE utf8_unicode_ci,
  `support` smallint(6) NOT NULL DEFAULT '7',
  `star` int(11) NOT NULL DEFAULT '0',
  `chargeType` smallint(6) NOT NULL DEFAULT '0',
  `freeLimits` int(11) NOT NULL DEFAULT '100',
  `price` double(8,2) NOT NULL DEFAULT '0.00',
  `defaultConfig` text COLLATE utf8_unicode_ci,
  `callCount` int(11) NOT NULL DEFAULT '0',
  `public` tinyint(1) NOT NULL DEFAULT '0',
  `access` int(11) NOT NULL DEFAULT '3',
  `startUrl` text COLLATE utf8_unicode_ci NOT NULL,
  `ua` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `spiders`
--

INSERT INTO `spiders` (`id`, `name`, `user_id`, `content`, `description`, `readme`, `support`, `star`, `chargeType`, `freeLimits`, `price`, `defaultConfig`, `callCount`, `public`, `access`, `startUrl`, `ua`, `created_at`, `updated_at`) VALUES
(1, 'hello word', 1, 'dSpider("test", function(session,env,$){\n    var count=100;\n    session.showProgress();\n    session.setProgressMsg("正在初始化");\n    var timer=setInterval(function(){\n      var cur=100-(--count);\n      session.setProgress(100-(--count));\n      session.setProgressMsg("正在爬取第"+cur+"条记录");\n      if(count==0){\n       clearInterval(timer);\n       session.finish();\n      }\n    },50);\n})', '测试脚本', '1. 此脚本为测试脚本，每个新建的应用都会默认拥有调用此脚本的权限\n2. 这是一个最简单的爬虫，启动后直接将数据传给sdk,然后结束掉本身。', 7, 0, 0, 100, 0.00, NULL, 184, 1, 3, 'https://www.baidu.com', 1, '2016-12-11 22:56:24', '2017-01-07 21:31:38');

-- --------------------------------------------------------

--
-- 表的结构 `spider_configs`
--

CREATE TABLE `spider_configs` (
  `id` int(10) UNSIGNED NOT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `spider_id` int(10) UNSIGNED NOT NULL,
  `appKey_id` int(10) UNSIGNED NOT NULL,
  `callCount` int(11) NOT NULL DEFAULT '0',
  `online` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `spider_configs`
--

INSERT INTO `spider_configs` (`id`, `content`, `spider_id`, `appKey_id`, `callCount`, `online`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 1, 0, 1, '2016-12-19 23:20:19', '2016-12-19 23:20:19'),
(4, NULL, 1, 4, 0, 1, '2016-12-19 23:20:19', '2016-12-19 23:20:19');

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'wendu', '824783146@qq.com', '$2y$10$yzVYVZ4j3yT365jXtLEJkO.KJtoG8oSNkyxcZPGjcFrhqiqAmiR2.', 'SlKZcIpqs1vCp3wtWTDQ9xSKogTsFEfDdKfmip9Ko7fseweRHGqQEEx2NOff', '2016-12-11 22:51:17', '2017-01-06 06:48:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_keys`
--
ALTER TABLE `app_keys`
  ADD PRIMARY KEY (`id`),
  ADD KEY `app_keys_user_id_foreign` (`user_id`);

--
-- Indexes for table `crawl_records`
--
ALTER TABLE `crawl_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `crawl_records_appkey_id_foreign` (`appKey_id`),
  ADD KEY `crawl_records_spider_id_foreign` (`spider_id`),
  ADD KEY `crawl_records_device_id_foreign` (`device_id`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `downloads`
--
ALTER TABLE `downloads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `spiders`
--
ALTER TABLE `spiders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `spiders_user_id_foreign` (`user_id`);

--
-- Indexes for table `spider_configs`
--
ALTER TABLE `spider_configs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `spider_configs_appkey_id_foreign` (`appKey_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `app_keys`
--
ALTER TABLE `app_keys`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- 使用表AUTO_INCREMENT `crawl_records`
--
ALTER TABLE `crawl_records`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;
--
-- 使用表AUTO_INCREMENT `devices`
--
ALTER TABLE `devices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `downloads`
--
ALTER TABLE `downloads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- 使用表AUTO_INCREMENT `spiders`
--
ALTER TABLE `spiders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `spider_configs`
--
ALTER TABLE `spider_configs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 限制导出的表
--

--
-- 限制表 `app_keys`
--
ALTER TABLE `app_keys`
  ADD CONSTRAINT `app_keys_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- 限制表 `crawl_records`
--
ALTER TABLE `crawl_records`
  ADD CONSTRAINT `crawl_records_appkey_id_foreign` FOREIGN KEY (`appKey_id`) REFERENCES `app_keys` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `crawl_records_device_id_foreign` FOREIGN KEY (`device_id`) REFERENCES `devices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `crawl_records_spider_id_foreign` FOREIGN KEY (`spider_id`) REFERENCES `spiders` (`id`) ON DELETE CASCADE;

--
-- 限制表 `spiders`
--
ALTER TABLE `spiders`
  ADD CONSTRAINT `spiders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- 限制表 `spider_configs`
--
ALTER TABLE `spider_configs`
  ADD CONSTRAINT `spider_configs_appkey_id_foreign` FOREIGN KEY (`appKey_id`) REFERENCES `app_keys` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
