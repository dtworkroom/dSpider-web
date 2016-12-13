-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2016-12-13 11:03:11
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
  `state` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `app_keys`
--

INSERT INTO `app_keys` (`id`, `user_id`, `secret`, `name`, `state`, `created_at`, `updated_at`) VALUES
(1, 1, '25XBLR8vTFUHJPNz6LDMEe9r4tro683z', '小赢卡带', 1, '2016-12-11 22:56:40', '2016-12-11 22:56:40');

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
(19, 1, 1, NULL, -2, '{"url":"https://www.baidu.com/","msg":"xx is not defined","args":{},"stack":"语法错误: xx is not defined\\nscript_url:http://172.19.23.62/dSpider-web/api/script?id=19&appkey=1&platform=1\\nReferenceError: xx is not defined\\n    at  http://172.19.23.62/dSpider-web/api/script?id=19&appkey=1&platform=1:307:1\\n    at HTMLDocument.<anonymous> ( http://172.19.23.62/dSpider-web/api/script?id=19&appkey=1&platform=1:177:21)\\n    at HTMLDocument.<anonymous> ( http://172.19.23.62/dSpider-web/api/script?id=19&appkey=1&platform=1:63:15)\\n    at j (https://www.baidu.com/xiaoying/jquery.min.js:2:30000)\\n    at k (https://www.baidu.com/xiaoying/jquery.min.js:2:30314)"}', '1.0', '1.0', 1, '2016-12-12 01:03:50', '2016-12-12 18:36:00'),
(21, 1, 1, NULL, 0, NULL, '1.0', '1.0', 1, '2016-12-12 01:30:21', '2016-12-12 01:30:24');

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
(1, '860076039858476', 1, '6.0', 'HUAWEI NXT-AL10', '2016-12-11 23:28:54', '2016-12-11 23:28:54');

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
(7, '2016_12_12_055152_create_crawl_records_table', 1);

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
  `description` text COLLATE utf8_unicode_ci,
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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `spiders`
--

INSERT INTO `spiders` (`id`, `name`, `user_id`, `content`, `description`, `support`, `star`, `chargeType`, `freeLimits`, `price`, `defaultConfig`, `callCount`, `public`, `access`, `startUrl`, `created_at`, `updated_at`) VALUES
(1, 'test', 1, 'dSpider("test", function(session,env,$) {\r\n log(env)\r\n session.upload("Hi, I am the test data!")\r\n session.finish() \r\n})', NULL, 7, 0, 0, 100, 0.00, NULL, 34, 0, 3, 'https://www.baidu.com', '2016-12-11 22:56:24', '2016-12-12 19:01:24');

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
(1, NULL, 1, 1, 8, 1, '2016-12-11 22:56:40', '2016-12-12 01:30:24');

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
(1, 'wendu', '824783146@qq.com', '$2y$10$yzVYVZ4j3yT365jXtLEJkO.KJtoG8oSNkyxcZPGjcFrhqiqAmiR2.', NULL, '2016-12-11 22:51:17', '2016-12-11 22:51:17');

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `crawl_records`
--
ALTER TABLE `crawl_records`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- 使用表AUTO_INCREMENT `devices`
--
ALTER TABLE `devices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- 使用表AUTO_INCREMENT `spiders`
--
ALTER TABLE `spiders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `spider_configs`
--
ALTER TABLE `spider_configs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
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
