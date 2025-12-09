-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 09, 2025 at 07:11 AM
-- Server version: 11.8.3-MariaDB-log
-- PHP Version: 7.2.34






;
;
;
;

--
-- Database: "u742355347_insocial_newdb"
--

-- --------------------------------------------------------

--
-- Table structure for table "activity"
--

CREATE TABLE "activity" (
  "id" INTEGER NOT NULL,
  "user_uuid" varchar(255) DEFAULT NULL,
  "account_social_userid" varchar(255) DEFAULT NULL,
  "account_platform" varchar(255) DEFAULT NULL,
  "activity_type" varchar(255) DEFAULT NULL,
  "activity_subType" varchar(255) DEFAULT NULL,
  "action" varchar(255) DEFAULT NULL,
  "source_type" varchar(255) DEFAULT NULL,
  "post_form_id" varchar(255) DEFAULT NULL,
  "reference_pageID" TEXT  DEFAULT NULL ,
  "activity_dateTime" TIMESTAMP NOT NULL,
  "nextAPI_call_dateTime" TIMESTAMP DEFAULT NULL,
  "createdAt" TIMESTAMP NOT NULL,
  "updatedAt" TIMESTAMP NOT NULL
);

--
-- Dumping data for table "activity"
--

INSERT INTO "activity" ("id", "user_uuid", "account_social_userid", "account_platform", "activity_type", "activity_subType", "action", "source_type", "post_form_id", "reference_pageID", "activity_dateTime", "nextAPI_call_dateTime", "createdAt", "updatedAt") VALUES
(9, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-10-25 14:20:45', NULL, '2025-10-25 14:20:45', '2025-10-25 14:20:45'),
(10, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-10-27 06:09:11', NULL, '2025-10-27 06:09:11', '2025-10-27 06:09:11'),
(11, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-10-27 06:09:14', NULL, '2025-10-27 06:09:14', '2025-10-27 06:09:14'),
(12, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-10-27 07:29:36', NULL, '2025-10-27 07:29:36', '2025-10-27 07:29:36'),
(19, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', '', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122156751110791773"}', '2025-10-27 08:11:28', '2025-10-28 08:11:28', '2025-10-27 08:11:28', '2025-10-27 08:11:28'),
(20, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', '', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122156990918791773"}', '2025-10-27 08:11:33', '2025-10-28 08:11:33', '2025-10-27 08:11:33', '2025-10-27 08:11:33'),
(21, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-10-27 09:16:42', NULL, '2025-10-27 09:16:42', '2025-10-27 09:16:42'),
(22, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', 'webhook', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122159895062791773"}', '2025-10-27 09:37:03', '2025-10-28 09:37:03', '2025-10-27 09:37:03', '2025-10-27 09:37:03'),
(23, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', 'webhook', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122159895062791773"}', '2025-10-27 09:37:04', '2025-10-28 09:37:04', '2025-10-27 09:37:04', '2025-10-27 09:37:04'),
(24, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', 'webhook', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122158279538791773"}', '2025-10-27 09:37:20', '2025-10-28 09:37:20', '2025-10-27 09:37:20', '2025-10-27 09:37:20'),
(25, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-10-27 09:38:23', NULL, '2025-10-27 09:38:23', '2025-10-27 09:38:23'),
(27, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-10-27 09:42:45', NULL, '2025-10-27 09:42:45', '2025-10-27 09:42:45'),
(29, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', '', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122156751110791773"}', '2025-10-27 09:49:42', '2025-10-28 09:49:42', '2025-10-27 09:49:42', '2025-10-27 09:49:42'),
(30, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', '', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122156751110791773"}', '2025-10-27 10:16:16', '2025-10-28 10:16:16', '2025-10-27 10:16:16', '2025-10-27 10:16:16'),
(31, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', '', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122158279538791773"}', '2025-10-27 10:16:49', '2025-10-28 10:16:49', '2025-10-27 10:16:49', '2025-10-27 10:16:49'),
(32, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', '', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122159895062791773"}', '2025-10-27 10:16:54', '2025-10-28 10:16:54', '2025-10-27 10:16:54', '2025-10-27 10:16:54'),
(33, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', 'webhook', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122159895062791773"}', '2025-10-27 10:18:10', '2025-10-28 10:18:10', '2025-10-27 10:18:10', '2025-10-27 10:18:10'),
(36, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', '', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122156751110791773"}', '2025-10-27 10:30:55', '2025-10-28 10:30:55', '2025-10-27 10:30:55', '2025-10-27 10:30:55'),
(37, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', '', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122156751110791773"}', '2025-10-27 10:31:05', '2025-10-28 10:31:05', '2025-10-27 10:31:05', '2025-10-27 10:31:05'),
(38, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-10-27 10:31:31', NULL, '2025-10-27 10:31:31', '2025-10-27 10:31:31'),
(39, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-10-27 10:31:45', NULL, '2025-10-27 10:31:45', '2025-10-27 10:31:45'),
(41, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-10-27 10:33:21', NULL, '2025-10-27 10:33:21', '2025-10-27 10:33:21'),
(42, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-10-27 10:33:43', NULL, '2025-10-27 10:33:43', '2025-10-27 10:33:43'),
(44, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', '', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122156751110791773"}', '2025-10-27 10:36:18', '2025-10-28 10:36:18', '2025-10-27 10:36:18', '2025-10-27 10:36:18'),
(45, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', '', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122156751110791773"}', '2025-10-27 10:36:24', '2025-10-28 10:36:24', '2025-10-27 10:36:24', '2025-10-27 10:36:24'),
(46, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122156751110791773_2657843131228121","activity_subType_id":"631102136744766_122156751110791773"}', '2025-10-27 10:59:00', '2025-10-28 10:59:00', '2025-10-27 10:59:00', '2025-10-27 10:59:00'),
(47, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', 'webhook', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122159895062791773"}', '2025-10-27 11:00:32', '2025-10-28 11:00:32', '2025-10-27 11:00:32', '2025-10-27 11:00:32'),
(48, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-10-27 11:05:32', NULL, '2025-10-27 11:05:32', '2025-10-27 11:05:32'),
(51, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', '', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122156751110791773"}', '2025-10-27 11:11:47', '2025-10-28 11:11:47', '2025-10-27 11:11:47', '2025-10-27 11:11:47'),
(52, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-10-27 11:12:41', NULL, '2025-10-27 11:12:41', '2025-10-27 11:12:41'),
(53, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-10-27 11:31:33', NULL, '2025-10-27 11:31:33', '2025-10-27 11:31:33'),
(54, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-10-27 11:46:16', NULL, '2025-10-27 11:46:16', '2025-10-27 11:46:16'),
(55, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-10-27 11:46:32', NULL, '2025-10-27 11:46:32', '2025-10-27 11:46:32'),
(56, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-10-27 11:47:22', NULL, '2025-10-27 11:47:22', '2025-10-27 11:47:22'),
(57, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-10-27 12:13:17', NULL, '2025-10-27 12:13:17', '2025-10-27 12:13:17'),
(58, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-10-27 12:35:24', NULL, '2025-10-27 12:35:24', '2025-10-27 12:35:24'),
(59, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-10-27 12:35:41', NULL, '2025-10-27 12:35:41', '2025-10-27 12:35:41'),
(60, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-10-27 12:36:37', NULL, '2025-10-27 12:36:37', '2025-10-27 12:36:37'),
(61, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122156751110791773_24995201150171084","activity_subType_id":"631102136744766_122156751110791773"}', '2025-10-27 12:40:03', NULL, '2025-10-27 12:40:03', '2025-10-28 12:40:14'),
(62, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-10-29 13:54:43', NULL, '2025-10-29 13:54:43', '2025-10-29 13:54:43'),
(65, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-10-30 12:34:27', NULL, '2025-10-30 12:34:27', '2025-10-30 12:34:27'),
(66, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-10-30 12:35:44', NULL, '2025-10-30 12:35:44', '2025-10-30 12:35:44'),
(67, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-10-31 10:23:04', NULL, '2025-10-31 10:23:04', '2025-10-31 10:23:04'),
(68, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-10-31 10:26:52', NULL, '2025-10-31 10:26:52', '2025-10-31 10:26:52'),
(69, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-01 07:11:22', NULL, '2025-11-01 07:11:22', '2025-11-01 07:11:22'),
(70, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-01 07:27:49', NULL, '2025-11-01 07:27:49', '2025-11-01 07:27:49'),
(71, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-03 05:17:48', NULL, '2025-11-03 05:17:48', '2025-11-03 05:17:48'),
(73, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-03 10:47:37', NULL, '2025-11-03 10:47:37', '2025-11-03 10:47:37'),
(74, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-03 10:47:40', NULL, '2025-11-03 10:47:40', '2025-11-03 10:47:40'),
(75, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-03 11:10:27', NULL, '2025-11-03 11:10:27', '2025-11-03 11:10:27'),
(76, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_TV4ZEJ9GQSN0X-NCt2U11BhzQSVLdgqqtafs2aaIipubfSIOJfvX4JN_AwjE_uOfpXBF8kxphNUnrfLHkkXucQ"}', '2025-11-03 11:23:53', '2025-11-04 11:23:53', '2025-11-03 11:23:53', '2025-11-03 11:23:53'),
(77, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_LJ08ZRKo_JXfuebkD7pTeRhzQSVLdgqqtafs2aaIipvXLMQwM6NmDohAzWp3QWtPtJ5seuH205ND6lT36gZpjg"}', '2025-11-03 11:34:15', '2025-11-04 11:34:15', '2025-11-03 11:34:15', '2025-11-03 11:34:15'),
(78, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_MFyAWy92d7UPQ92NWXBcSxhzQSVLdgqqtafs2aaIipspnq9AVVj6ep_Uv8FsBE4F4PnArajCVgSz4PjwkX4Q1A"}', '2025-11-03 11:34:59', '2025-11-04 11:34:59', '2025-11-03 11:34:59', '2025-11-03 11:34:59'),
(79, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_gcnGbwL8G7tdQuMRgC85-BhzQSVLdgqqtafs2aaIiptwoiznoDux0AYc79A2DYxtdaWWNWYmeK0Xoa4xq8OcGw"}', '2025-11-03 11:35:19', '2025-11-04 11:35:19', '2025-11-03 11:35:19', '2025-11-03 11:35:19'),
(80, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_EykAFvvs_2UrilJhnlZtQBhzQSVLdgqqtafs2aaIiptxGXEZSIUeFnKWnQO_OMlSMeIicd-KhCjAyHtSt09brQ"}', '2025-11-03 12:17:26', '2025-11-04 12:17:26', '2025-11-03 12:17:26', '2025-11-03 12:17:26'),
(81, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_ABf0xn6ml-m4U7WnsvqlbRhzQSVLdgqqtafs2aaIipsdr6uNEkqbZET7tvOXSqSif8s9vbVLGSEpZBN_q9T2zQ"}', '2025-11-03 12:18:44', '2025-11-04 12:18:44', '2025-11-03 12:18:44', '2025-11-03 12:18:44'),
(82, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_BSPg9WSvbFw3oIcziVgE2BhzQSVLdgqqtafs2aaIipsz7fvGypGY1uZhT8up0AZVBkrKSbvyLZLuld1uhriubw"}', '2025-11-03 12:22:37', '2025-11-04 12:22:37', '2025-11-03 12:22:37', '2025-11-03 12:22:37'),
(83, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_bnOooq7XLGwUgN403Y6upBhzQSVLdgqqtafs2aaIiptpZ9BgNVssw504DREWwszLhd_ab964j71jqns5bdu6CQ"}', '2025-11-03 12:23:33', '2025-11-04 12:23:33', '2025-11-03 12:23:33', '2025-11-03 12:23:33'),
(84, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_q7CClCI3mXoF-MDXIX0syBhzQSVLdgqqtafs2aaIipt_8Nlr-L8cfsy0N0aTh2BmscmMmzmVkH_lVziNgwfRCw"}', '2025-11-03 12:28:54', '2025-11-04 12:28:54', '2025-11-03 12:28:54', '2025-11-03 12:28:54'),
(85, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_Cy6fNla16GtpqWqVlmHK98mkDypFqAmNB5iTvX5h10w7eaaBXwfxlYRbee-bRh5jGlN2AtRH2zjJP0GKFSVLhA"}', '2025-11-03 12:47:18', '2025-11-04 12:47:18', '2025-11-03 12:47:18', '2025-11-03 12:47:18'),
(86, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-03 12:48:47', NULL, '2025-11-03 12:48:47', '2025-11-03 12:48:47'),
(87, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-03 12:53:57', NULL, '2025-11-03 12:53:57', '2025-11-03 12:53:57'),
(88, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-04 05:13:34', NULL, '2025-11-04 05:13:34', '2025-11-04 05:13:34'),
(89, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_3ROvnbumUtTDBukYRgsLEhhzQSVLdgqqtafs2aaIipv4RYYcoVIAkNmwcMlp4wj_dADiR2n9USZcOtawWwODMw"}', '2025-11-04 05:31:43', '2025-11-05 05:31:43', '2025-11-04 05:31:43', '2025-11-04 05:31:43'),
(90, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-04 06:00:01', NULL, '2025-11-04 06:00:01', '2025-11-04 06:00:01'),
(91, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_dvw75MrPzzv7Lifv-rpWPxhzQSVLdgqqtafs2aaIipuZpFd_LQ346lB03c_i_rG-QF-yRhxMqPyTSUHi4Ux71Q"}', '2025-11-04 08:00:42', '2025-11-05 08:00:42', '2025-11-04 08:00:42', '2025-11-04 08:00:42'),
(92, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_Ui1Ypm7OZaQEyupWbY2xjBhzQSVLdgqqtafs2aaIipsTJIty4qQBsZUtn8gYtABDHgQA44y6-HOg2cT3zKof6g"}', '2025-11-04 08:03:21', '2025-11-05 08:03:21', '2025-11-04 08:03:21', '2025-11-04 08:03:21'),
(93, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_C8eu3TJKhMlqDxrMW5-y6BhzQSVLdgqqtafs2aaIipu_WgkGjdJnEhLHHErmTQJRiYTHLwq1WcNCxCFVnPA8uw"}', '2025-11-04 08:19:26', '2025-11-05 08:19:26', '2025-11-04 08:19:26', '2025-11-04 08:19:26'),
(94, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_qlnCrSlvCTwrWj-Uy-UHcRhzQSVLdgqqtafs2aaIipv--3y01g8RcaCszo7sgC55pgIJp3sEFjeKsOyeIzl8eg"}', '2025-11-04 08:24:15', '2025-11-05 08:24:15', '2025-11-04 08:24:15', '2025-11-04 08:24:15'),
(95, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_a8Bl8eC074Z1osNY-BbYkhhzQSVLdgqqtafs2aaIipuRSIaBB-u0rOdeXiUQyccI24JADjB5Ovu8gmBKqllWmA"}', '2025-11-04 08:25:57', '2025-11-05 08:25:57', '2025-11-04 08:25:57', '2025-11-04 08:25:57'),
(96, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_NsSx73UiQP2yhvsLZ2gBOhhzQSVLdgqqtafs2aaIiptN_MD0dnxGUwTfYgpV-UioxLmPu4GnfLLnZYo2vnwxUg"}', '2025-11-04 09:43:58', '2025-11-05 09:43:58', '2025-11-04 09:43:58', '2025-11-04 09:43:58'),
(97, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_p7gZiJ7ZmaBIBogYj5eZLBhzQSVLdgqqtafs2aaIipvP38g7P7DLImC_W803WXAhcVgVV3UKQLFiepkjN9r6Vw"}', '2025-11-04 09:45:35', '2025-11-05 09:45:35', '2025-11-04 09:45:35', '2025-11-04 09:45:35'),
(98, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_MxAGgRQPdkOIWtmEMEvU1xhzQSVLdgqqtafs2aaIipsRz2l0QvVs2YHuuqVATGIvEXWpOKo27gJ9uOnirV6yNw"}', '2025-11-04 09:51:54', '2025-11-05 09:51:54', '2025-11-04 09:51:54', '2025-11-04 09:51:54'),
(99, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_-bPrf5wbjKIxq5MAFUkz7RhzQSVLdgqqtafs2aaIipvZmzSSmQ-mzLO6hgf2X_9m_wvFPreL7yoBAtl8rRO5Gg"}', '2025-11-04 09:53:34', '2025-11-05 09:53:34', '2025-11-04 09:53:34', '2025-11-04 09:53:34'),
(100, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_ox23u8HzsOMsK9SY9wDN_RhzQSVLdgqqtafs2aaIipvhA5Cc38ZxXhJmNDFEwnAga0EaPZ8jcjinX0g1dOGg2A"}', '2025-11-04 10:00:55', '2025-11-05 10:00:55', '2025-11-04 10:00:55', '2025-11-04 10:00:55'),
(101, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_YT-pNSQ1D0VB9TqOySIoyRhzQSVLdgqqtafs2aaIipvTKxLqO3Aofq7i49if1C1T2w-do7cNMQZ4FfppvWJLlA"}', '2025-11-04 10:06:27', '2025-11-05 10:06:27', '2025-11-04 10:06:27', '2025-11-04 10:06:27'),
(102, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_gkeCGoHSikV4UIqf9tC0rRhzQSVLdgqqtafs2aaIipuSj8nMLx-tSWRfKlHkzwFzRknmyTG7N-ap7_gMgOuFAQ"}', '2025-11-04 10:11:48', '2025-11-05 10:11:48', '2025-11-04 10:11:48', '2025-11-04 10:11:48'),
(103, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_cdCnMFLSSW97bTtjPcD7txhzQSVLdgqqtafs2aaIiptp66MKiL95EJnthP8gjD60oNtC5L7ddKzFbavJNxU5Hg"}', '2025-11-04 10:35:10', '2025-11-05 10:35:10', '2025-11-04 10:35:10', '2025-11-04 10:35:10'),
(104, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_jdikHcs5pC91Uo6_lk9LncmkDypFqAmNB5iTvX5h10zdceqQ1VdgwYP474Y08VszUVXfvdaIbBQWadV4BIghvg"}', '2025-11-04 10:36:35', '2025-11-05 10:36:35', '2025-11-04 10:36:35', '2025-11-04 10:36:35'),
(105, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_k_N7MBMb7PTSZT2kF3SxRMmkDypFqAmNB5iTvX5h10xSvDRL-r8f97J4534RR7Otq8iYI7UshB8CKI7WrSBK5Q"}', '2025-11-04 10:37:16', '2025-11-05 10:37:16', '2025-11-04 10:37:16', '2025-11-04 10:37:16'),
(106, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_xOCWuoeedRvvpy6wTb8T_MmkDypFqAmNB5iTvX5h10wbyZ7y88zwCtGoBgHg7F0FiwKYyp1FDK5rjmc4RfG_Dw"}', '2025-11-04 10:37:44', '2025-11-05 10:37:44', '2025-11-04 10:37:44', '2025-11-04 10:37:44'),
(107, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_NS3MbNH1pKdER_igZqcF0RhzQSVLdgqqtafs2aaIipsKim_c08tcqZuvyflEm9vYnkrxOZOMMz-dZ8Q6WlDXpw"}', '2025-11-04 10:50:25', '2025-11-05 10:50:25', '2025-11-04 10:50:25', '2025-11-04 10:50:25'),
(108, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_PShkpmDZwGJvpjK9ZoyjnBhzQSVLdgqqtafs2aaIiptckZ8wXeGIU-0hHDE6wEX7mk4rfitqEfJVY43j0DiIhA"}', '2025-11-04 10:52:03', '2025-11-05 10:52:03', '2025-11-04 10:52:03', '2025-11-04 10:52:03'),
(109, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_Roe5Ts9Y6qHDnOw-Nsz81MmkDypFqAmNB5iTvX5h10xUooe4QcRJ-nHA9utYoGWmBRvs24W1QRRLRpXiAr6qHg"}', '2025-11-04 10:53:34', '2025-11-05 10:53:34', '2025-11-04 10:53:34', '2025-11-04 10:53:34'),
(110, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_LH4_u73gEFZofh5wEM3P1cmkDypFqAmNB5iTvX5h10yAPcmWOvwFDLUog4g1hiFlR65QQ1TMWb0ZYkglddYHJg"}', '2025-11-04 10:54:33', '2025-11-05 10:54:33', '2025-11-04 10:54:33', '2025-11-04 10:54:33'),
(111, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_ciMuwm3BhVJ1etbasuiyzMmkDypFqAmNB5iTvX5h10xPRk825ZwVUIS6hCkRC5M93gmvqhidjt5beimIpzQIRw"}', '2025-11-04 10:55:13', '2025-11-05 10:55:13', '2025-11-04 10:55:13', '2025-11-04 10:55:13'),
(112, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_dnokLVx0StxQWI6LMik4qMmkDypFqAmNB5iTvX5h10xBiuhEFhUcA0_fMuyvfHXTkic2Eh-pjGV1lHruj8kytw"}', '2025-11-04 10:59:43', '2025-11-05 10:59:43', '2025-11-04 10:59:43', '2025-11-04 10:59:43'),
(113, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_d2du4PhC85L5VFJCTWXE6BhzQSVLdgqqtafs2aaIipuRSxqoQ3OSfGsybGDhM7wN8a_22cE77ULlNETjcw1b5Q"}', '2025-11-04 12:02:34', '2025-11-05 12:02:34', '2025-11-04 12:02:34', '2025-11-04 12:02:34'),
(114, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_6hHlYJRMxv95vO2h0VwzwhhzQSVLdgqqtafs2aaIipuYaEbk2nCfDInxAvOr2yRgS5TTm_XZX_7xqmGZ99e1tQ"}', '2025-11-04 12:04:13', '2025-11-05 12:04:13', '2025-11-04 12:04:13', '2025-11-04 12:04:13'),
(115, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_mzLIh8X2JgK1wfB1wW8NcRhzQSVLdgqqtafs2aaIips1_FagIFlJSuVxKxiBencbOz8GX-yonbZDwixJ44qaiw"}', '2025-11-04 12:32:28', '2025-11-05 12:32:28', '2025-11-04 12:32:28', '2025-11-04 12:32:28'),
(116, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_kZEgfnwT7kzltWvE62zABxhzQSVLdgqqtafs2aaIipv7LbxLug10IwmVeOJUPyKhYO4EL2t2_jcM9ynhHXqXfQ"}', '2025-11-04 12:37:13', '2025-11-05 12:37:13', '2025-11-04 12:37:13', '2025-11-04 12:37:13'),
(117, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_n64s20tE4zloa2XELDP1FBhzQSVLdgqqtafs2aaIipvwUSW9BGxTotUYaLtFH_FrHFQJkGiR0XYKp1XdSiPJbA"}', '2025-11-04 12:57:29', '2025-11-05 12:57:29', '2025-11-04 12:57:29', '2025-11-04 12:57:29'),
(118, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_oY45DhaD4yauT1y9Num4cRhzQSVLdgqqtafs2aaIipuTUVrNGpzsBZj2H8qO2GNivdMJo_bMNVhfkpLqR_Gx2A"}', '2025-11-04 12:58:28', '2025-11-05 12:58:28', '2025-11-04 12:58:28', '2025-11-04 12:58:28'),
(119, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_T--80dAIbZi6-DHdLXqdZhhzQSVLdgqqtafs2aaIipuDi8YAgomfIqIzKo_VjTTYTvVGJE1PnsBxsJxSdO1_kQ"}', '2025-11-04 12:59:55', '2025-11-05 12:59:55', '2025-11-04 12:59:55', '2025-11-04 12:59:55'),
(120, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_fL0Xk53Sa5SxseSZ_G6dpRhzQSVLdgqqtafs2aaIipved8fyfDT0AJ-p2a7xHnSchBOiNiRxhdiyeNzRV3AJ3g"}', '2025-11-04 13:01:39', '2025-11-05 13:01:39', '2025-11-04 13:01:39', '2025-11-04 13:01:39'),
(121, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_rLnKt7i-56aPfsjS4BWX-MmkDypFqAmNB5iTvX5h10wSqAjxSl3zaH9vQq8Pj-OLQsHtn1dr33MJbxeDz3D5Tw"}', '2025-11-04 13:02:30', '2025-11-05 13:02:30', '2025-11-04 13:02:30', '2025-11-04 13:02:30'),
(122, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-05 05:12:25', NULL, '2025-11-05 05:12:25', '2025-11-05 05:12:25'),
(123, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-05 05:12:40', NULL, '2025-11-05 05:12:40', '2025-11-05 05:12:40'),
(124, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-05 05:45:49', NULL, '2025-11-05 05:45:49', '2025-11-05 05:45:49'),
(125, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_jq_m4CFFfqz6cYKPPbOylBhzQSVLdgqqtafs2aaIipvBK5mcmVg5q51cTMgrBOz5cOHHhGPI0IaxjpLBIgls2A"}', '2025-11-05 11:25:26', '2025-11-06 11:25:26', '2025-11-05 11:25:26', '2025-11-05 11:25:26'),
(136, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-06 09:58:49', NULL, '2025-11-06 09:58:49', '2025-11-06 09:58:49'),
(137, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-06 09:59:02', NULL, '2025-11-06 09:59:02', '2025-11-06 09:59:02'),
(138, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_UbDomzFEfRxWllWMAlQjCBhzQSVLdgqqtafs2aaIipsIYzavldOGMHk8gdPAvSIPLJtGzb63EOI6GsClOw6H4Q"}', '2025-11-06 11:31:22', '2025-11-07 11:31:22', '2025-11-06 11:31:22', '2025-11-06 11:31:22'),
(139, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_814455931357055","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 12:03:03', '2025-11-07 12:03:03', '2025-11-06 12:03:03', '2025-11-06 12:03:03'),
(140, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', 'webhook', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 12:06:46', '2025-11-07 12:06:46', '2025-11-06 12:06:46', '2025-11-06 12:06:46'),
(141, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_1466894701043078","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 12:07:47', '2025-11-07 12:07:47', '2025-11-06 12:07:47', '2025-11-06 12:07:47'),
(142, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', 'webhook', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 12:09:01', '2025-11-07 12:09:01', '2025-11-06 12:09:01', '2025-11-06 12:09:01'),
(143, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_1786982072018955","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 12:09:31', '2025-11-07 12:09:31', '2025-11-06 12:09:31', '2025-11-06 12:09:31'),
(144, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_1961119951127649","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 12:17:27', '2025-11-07 12:17:27', '2025-11-06 12:17:27', '2025-11-06 12:17:27'),
(145, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', 'webhook', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 12:57:05', '2025-11-07 12:57:05', '2025-11-06 12:57:05', '2025-11-06 12:57:05'),
(146, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', 'webhook', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 12:58:54', '2025-11-07 12:58:54', '2025-11-06 12:58:54', '2025-11-06 12:58:54'),
(147, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_1319897586018686","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 12:59:34', '2025-11-07 12:59:34', '2025-11-06 12:59:34', '2025-11-06 12:59:34'),
(148, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', 'webhook', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:00:40', '2025-11-07 13:00:40', '2025-11-06 13:00:40', '2025-11-06 13:00:40'),
(149, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_1556353639122502","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:01:06', '2025-11-07 13:01:06', '2025-11-06 13:01:06', '2025-11-06 13:01:06'),
(150, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', 'webhook', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:05:27', '2025-11-07 13:05:27', '2025-11-06 13:05:27', '2025-11-06 13:05:27'),
(151, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_25543633201897440","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:05:43', '2025-11-07 13:05:43', '2025-11-06 13:05:43', '2025-11-06 13:05:43'),
(152, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', 'webhook', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:14:40', '2025-11-07 13:14:40', '2025-11-06 13:14:40', '2025-11-06 13:14:40'),
(153, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_1909608272975350","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:15:33', '2025-11-07 13:15:33', '2025-11-06 13:15:33', '2025-11-06 13:15:33'),
(154, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_1488098239085829","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:15:54', '2025-11-07 13:15:54', '2025-11-06 13:15:54', '2025-11-06 13:15:54'),
(155, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_1102009288463322","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:16:23', '2025-11-07 13:16:23', '2025-11-06 13:16:23', '2025-11-06 13:16:23'),
(156, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_1537156490524616","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:16:47', '2025-11-07 13:16:47', '2025-11-06 13:16:47', '2025-11-06 13:16:47'),
(157, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_1783075959061855","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:17:05', '2025-11-07 13:17:05', '2025-11-06 13:17:05', '2025-11-06 13:17:05'),
(158, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', 'webhook', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:17:27', '2025-11-07 13:17:27', '2025-11-06 13:17:27', '2025-11-06 13:17:27'),
(159, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_842895964867430","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:24:12', '2025-11-07 13:24:12', '2025-11-06 13:24:12', '2025-11-06 13:24:12'),
(160, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_3127876714186110","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:24:30', '2025-11-07 13:24:30', '2025-11-06 13:24:30', '2025-11-06 13:24:30'),
(161, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_1200491411927134","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:24:53', '2025-11-07 13:24:53', '2025-11-06 13:24:53', '2025-11-06 13:24:53'),
(162, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_2046546786149182","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:25:22', '2025-11-07 13:25:22', '2025-11-06 13:25:22', '2025-11-06 13:25:22'),
(163, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_1066950718739896","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:25:55', '2025-11-07 13:25:55', '2025-11-06 13:25:55', '2025-11-06 13:25:55'),
(164, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_4102136320059301","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:26:21', '2025-11-07 13:26:21', '2025-11-06 13:26:21', '2025-11-06 13:26:21'),
(165, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_2182333765671537","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:26:55', '2025-11-07 13:26:55', '2025-11-06 13:26:55', '2025-11-06 13:26:55'),
(166, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_1179428464114624","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:27:23', '2025-11-07 13:27:23', '2025-11-06 13:27:23', '2025-11-06 13:27:23'),
(167, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_615503788241268","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:27:56', '2025-11-07 13:27:56', '2025-11-06 13:27:56', '2025-11-06 13:27:56'),
(168, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_818106367852954","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:28:27', '2025-11-07 13:28:27', '2025-11-06 13:28:27', '2025-11-06 13:28:27'),
(169, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_1953709468521785","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:28:58', '2025-11-07 13:28:58', '2025-11-06 13:28:58', '2025-11-06 13:28:58'),
(170, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_2899346736930590","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:29:19', '2025-11-07 13:29:19', '2025-11-06 13:29:19', '2025-11-06 13:29:19'),
(171, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_1567819061237707","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:29:58', '2025-11-07 13:29:58', '2025-11-06 13:29:58', '2025-11-06 13:29:58'),
(172, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_1310477117516785","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:30:29', '2025-11-07 13:30:29', '2025-11-06 13:30:29', '2025-11-06 13:30:29'),
(173, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', 'webhook', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:31:20', '2025-11-07 13:31:20', '2025-11-06 13:31:20', '2025-11-06 13:31:20'),
(174, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_1386610019708084","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:33:12', '2025-11-07 13:33:12', '2025-11-06 13:33:12', '2025-11-06 13:33:12'),
(175, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_1123978023232441","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:33:33', '2025-11-07 13:33:33', '2025-11-06 13:33:33', '2025-11-06 13:33:33'),
(176, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_4240791642909083","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:34:05', '2025-11-07 13:34:05', '2025-11-06 13:34:05', '2025-11-06 13:34:05'),
(177, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_921746106846680","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:34:26', '2025-11-07 13:34:26', '2025-11-06 13:34:26', '2025-11-06 13:34:26'),
(178, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_688524837272804","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:34:52', '2025-11-07 13:34:52', '2025-11-06 13:34:52', '2025-11-06 13:34:52'),
(179, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_2280858245689405","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:35:22', '2025-11-07 13:35:22', '2025-11-06 13:35:22', '2025-11-06 13:35:22'),
(180, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_1890510464894208","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:35:43', '2025-11-07 13:35:43', '2025-11-06 13:35:43', '2025-11-06 13:35:43'),
(181, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_1313617920064685","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:36:14', '2025-11-07 13:36:14', '2025-11-06 13:36:14', '2025-11-06 13:36:14'),
(182, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_2106610506540111","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:36:34', '2025-11-07 13:36:34', '2025-11-06 13:36:34', '2025-11-06 13:36:34'),
(183, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_1094921699202831","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:36:52', '2025-11-07 13:36:52', '2025-11-06 13:36:52', '2025-11-06 13:36:52');
INSERT INTO "activity" ("id", "user_uuid", "account_social_userid", "account_platform", "activity_type", "activity_subType", "action", "source_type", "post_form_id", "reference_pageID", "activity_dateTime", "nextAPI_call_dateTime", "createdAt", "updatedAt") VALUES
(184, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_714659174397295","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:37:08', '2025-11-07 13:37:08', '2025-11-06 13:37:08', '2025-11-06 13:37:08'),
(185, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_813039081638926","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:37:28', '2025-11-07 13:37:28', '2025-11-06 13:37:28', '2025-11-06 13:37:28'),
(186, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_1363756668736387","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:37:45', '2025-11-07 13:37:45', '2025-11-06 13:37:45', '2025-11-06 13:37:45'),
(187, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_1466079551135718","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:38:02', '2025-11-07 13:38:02', '2025-11-06 13:38:02', '2025-11-06 13:38:02'),
(188, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_1974675136720503","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-06 13:38:49', '2025-11-07 13:38:49', '2025-11-06 13:38:49', '2025-11-06 13:38:49'),
(189, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', 'webhook', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-07 04:33:19', '2025-11-08 04:33:19', '2025-11-07 04:33:19', '2025-11-07 04:33:19'),
(190, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', 'webhook', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-07 04:33:26', '2025-11-08 04:33:26', '2025-11-07 04:33:26', '2025-11-07 04:33:26'),
(191, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', 'webhook', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-07 04:33:31', '2025-11-08 04:33:31', '2025-11-07 04:33:31', '2025-11-07 04:33:31'),
(192, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', 'webhook', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-07 04:33:36', '2025-11-08 04:33:36', '2025-11-07 04:33:36', '2025-11-07 04:33:36'),
(193, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', 'webhook', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-07 04:33:39', '2025-11-08 04:33:39', '2025-11-07 04:33:39', '2025-11-07 04:33:39'),
(194, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', 'webhook', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-07 04:33:45', '2025-11-08 04:33:45', '2025-11-07 04:33:45', '2025-11-07 04:33:45'),
(195, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', 'webhook', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-07 04:33:50', '2025-11-08 04:33:50', '2025-11-07 04:33:50', '2025-11-07 04:33:50'),
(196, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', 'webhook', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-07 04:33:54', '2025-11-08 04:33:54', '2025-11-07 04:33:54', '2025-11-07 04:33:54'),
(197, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', 'webhook', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-07 04:33:59', '2025-11-08 04:33:59', '2025-11-07 04:33:59', '2025-11-07 04:33:59'),
(198, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', 'webhook', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-07 04:34:05', '2025-11-08 04:34:05', '2025-11-07 04:34:05', '2025-11-07 04:34:05'),
(199, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', 'webhook', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-07 04:34:14', '2025-11-08 04:34:14', '2025-11-07 04:34:14', '2025-11-07 04:34:14'),
(200, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', 'webhook', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-07 04:34:21', '2025-11-08 04:34:21', '2025-11-07 04:34:21', '2025-11-07 04:34:21'),
(201, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', 'webhook', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-07 04:34:29', '2025-11-08 04:34:29', '2025-11-07 04:34:29', '2025-11-07 04:34:29'),
(202, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', 'webhook', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-07 04:37:20', '2025-11-08 04:37:20', '2025-11-07 04:37:20', '2025-11-07 04:37:20'),
(203, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', 'webhook', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-07 04:37:54', '2025-11-08 04:37:54', '2025-11-07 04:37:54', '2025-11-07 04:37:54'),
(204, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_2045177369572320","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-07 05:30:00', '2025-11-08 05:30:00', '2025-11-07 05:30:00', '2025-11-07 05:30:00'),
(205, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', 'webhook', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-07 06:55:35', '2025-11-08 06:55:35', '2025-11-07 06:55:35', '2025-11-07 06:55:35'),
(206, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', 'webhook', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-07 07:01:10', '2025-11-08 07:01:10', '2025-11-07 07:01:10', '2025-11-07 07:01:10'),
(207, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_795349753488120","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-07 07:02:46', '2025-11-08 07:02:46', '2025-11-07 07:02:46', '2025-11-07 07:02:46'),
(208, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comments', 'posts', 'reply', 'auto-reply', '', '{"activity_type_id":"122159895062791773_830985916003511","activity_subType_id":"631102136744766_122159895062791773","title":"Thanks for sharing your thoughts! This post is actually part of our \"On This Day\" series, where we explore significant historical events. We hope you find it interesting!"}', '2025-11-07 07:03:03', NULL, '2025-11-07 07:03:03', '2025-11-07 07:03:03'),
(209, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122158279538791773_2603879113303529","activity_subType_id":"631102136744766_122158279538791773"}', '2025-11-07 07:10:05', '2025-11-08 07:10:05', '2025-11-07 07:10:05', '2025-11-07 07:10:05'),
(210, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comments', 'posts', 'reply', 'auto-reply', '', '{"activity_type_id":"122158279538791773_1722343108437384","activity_subType_id":"631102136744766_122158279538791773","title":"Happy Dussehra to you too! We wish everyone a day filled with positivity and new beginnings. What negativity are you letting go of this Dussehra?"}', '2025-11-07 07:10:22', NULL, '2025-11-07 07:10:22', '2025-11-07 07:10:22'),
(211, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122158279538791773_2620525598321939","activity_subType_id":"631102136744766_122158279538791773"}', '2025-11-07 07:13:53', '2025-11-08 07:13:53', '2025-11-07 07:13:53', '2025-11-07 07:13:53'),
(212, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comments', 'posts', 'reply', 'auto-reply', '', '{"activity_type_id":"122158279538791773_9301644016625930","activity_subType_id":"631102136744766_122158279538791773","title":"Happy Dussehra to you too! We absolutely agree, may light always conquer darkness! ✨"}', '2025-11-07 07:14:08', NULL, '2025-11-07 07:14:08', '2025-11-07 07:14:08'),
(213, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122156751110791773_1378031010588068","activity_subType_id":"631102136744766_122156751110791773"}', '2025-11-07 07:14:59', '2025-11-08 07:14:59', '2025-11-07 07:14:59', '2025-11-07 07:14:59'),
(214, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comments', 'posts', 'reply', 'auto-reply', '', '{"activity_type_id":"122156751110791773_1228653535763359","activity_subType_id":"631102136744766_122156751110791773","title":"Glad you found it helpful! 😊"}', '2025-11-07 07:15:15', NULL, '2025-11-07 07:15:15', '2025-11-07 07:15:15'),
(215, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'like', 'posts', 'create', 'webhook', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122158279538791773"}', '2025-11-07 07:15:40', '2025-11-08 07:15:40', '2025-11-07 07:15:40', '2025-11-07 07:15:40'),
(216, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122153293694791773_859521836607171","activity_subType_id":"631102136744766_122153293694791773"}', '2025-11-07 07:23:07', '2025-11-08 07:23:07', '2025-11-07 07:23:07', '2025-11-07 07:23:07'),
(217, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comments', 'posts', 'reply', 'auto-reply', '', '{"activity_type_id":"122153293694791773_1911112786167259","activity_subType_id":"631102136744766_122153293694791773","title":"Thanks so much for the kind words! 😊"}', '2025-11-07 07:23:26', NULL, '2025-11-07 07:23:26', '2025-11-07 07:23:26'),
(218, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122153293694791773_1680650922914802","activity_subType_id":"631102136744766_122153293694791773"}', '2025-11-07 07:23:46', '2025-11-08 07:23:46', '2025-11-07 07:23:46', '2025-11-07 07:23:46'),
(219, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comments', 'posts', 'reply', 'auto-reply', '', '{"activity_type_id":"122153293694791773_4040692292857324","activity_subType_id":"631102136744766_122153293694791773","title":"Thanks for your comment!"}', '2025-11-07 07:24:03', NULL, '2025-11-07 07:24:03', '2025-11-07 07:24:03'),
(220, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122156751110791773_1645547326409366","activity_subType_id":"631102136744766_122156751110791773"}', '2025-11-07 07:25:46', '2025-11-08 07:25:46', '2025-11-07 07:25:46', '2025-11-07 07:25:46'),
(221, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comments', 'posts', 'reply', 'auto-reply', '', '{"activity_type_id":"122156751110791773_726265400496808","activity_subType_id":"631102136744766_122156751110791773","title":"We appreciate your feedback! We''re always looking for ways to improve and would love to hear more about what kind of content you''d find most valuable."}', '2025-11-07 07:26:03', NULL, '2025-11-07 07:26:03', '2025-11-07 07:26:03'),
(222, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122156990918791773_1152713736931586","activity_subType_id":"631102136744766_122156990918791773"}', '2025-11-07 08:12:58', '2025-11-08 08:12:58', '2025-11-07 08:12:58', '2025-11-07 08:12:58'),
(223, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comments', 'posts', 'reply', 'auto-reply', '', '{"activity_type_id":"122156990918791773_1636201881140254","activity_subType_id":"631102136744766_122156990918791773","title":"Thanks for your positive feedback! So glad you enjoyed the post 😊"}', '2025-11-07 08:13:14', NULL, '2025-11-07 08:13:14', '2025-11-07 08:13:14'),
(224, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122156990918791773_725774017216305","activity_subType_id":"631102136744766_122156990918791773"}', '2025-11-07 08:16:36', '2025-11-08 08:16:36', '2025-11-07 08:16:36', '2025-11-07 08:16:36'),
(225, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comments', 'posts', 'reply', 'auto-reply', '', '{"activity_type_id":"122156990918791773_836058425582299","activity_subType_id":"631102136744766_122156990918791773","title":"That''s a wonderful point! It''s truly important to remember and celebrate the contributions of such stalwarts to our nation."}', '2025-11-07 08:16:52', NULL, '2025-11-07 08:16:52', '2025-11-07 08:16:52'),
(226, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_1859813137949891","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-07 11:43:31', '2025-11-08 11:43:31', '2025-11-07 11:43:31', '2025-11-07 11:43:31'),
(227, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comments', 'posts', 'reply', 'auto-reply', '', '{"activity_type_id":"122159895062791773_1756313345089161","activity_subType_id":"631102136744766_122159895062791773","title":"Thanks for the kind words! Glad you''re enjoying the content. 😊"}', '2025-11-07 11:43:49', NULL, '2025-11-07 11:43:49', '2025-11-07 11:43:49'),
(228, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_fHcc5tVBVh4MbE09jyBV7RhzQSVLdgqqtafs2aaIipt0KEoBIAz5PyD2y8xs83EYJ1FhFiuVf683ExM3kzzLKA"}', '2025-11-07 11:45:37', '2025-11-08 11:45:37', '2025-11-07 11:45:37', '2025-11-07 11:45:37'),
(229, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_OESSESJWh56SvhYnTkT1xm_grOqO3NWBRJ7Xc2GwTPy9ArXcCDIbRzVLMHtX-HBf76nqBjTAgy-9pKit-xrS1Q"}', '2025-11-07 11:56:25', '2025-11-08 11:56:25', '2025-11-07 11:56:25', '2025-11-07 11:56:25'),
(230, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_OOIvs7T_d6z8Kuj18MUg-m_grOqO3NWBRJ7Xc2GwTPyODLv-bV4NBATUlcSaTXpDfGJrEY8WQVR_7hB9TiMTFw"}', '2025-11-07 11:58:18', '2025-11-08 11:58:18', '2025-11-07 11:58:18', '2025-11-07 11:58:18'),
(231, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_gyg4NMYS1xOX4tB5jd0PaW_grOqO3NWBRJ7Xc2GwTPwsMciM_uqNtLNh327b6e67mWQVqzZ20PFwusnL97CTuA"}', '2025-11-07 11:58:24', '2025-11-08 11:58:24', '2025-11-07 11:58:24', '2025-11-07 11:58:24'),
(232, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_Q9sl_qCBsDbeOnRMYahss2_grOqO3NWBRJ7Xc2GwTPzQgqB5tE256oWI1KbzOdH6LgQtu0Y-hKC3h7nFQ8-o2w"}', '2025-11-07 11:59:10', '2025-11-08 11:59:10', '2025-11-07 11:59:10', '2025-11-07 11:59:10'),
(233, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_Tha65UUlIGT6AStLzjGG1m_grOqO3NWBRJ7Xc2GwTPyYDqHOHHGQzwPbvJNvveHuPEpHz4L9NCcf6mQQuE6c3g"}', '2025-11-07 12:00:04', '2025-11-08 12:00:04', '2025-11-07 12:00:04', '2025-11-07 12:00:04'),
(234, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_1185704263530147","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-07 12:37:06', '2025-11-08 12:37:06', '2025-11-07 12:37:06', '2025-11-07 12:37:06'),
(235, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comments', 'posts', 'reply', 'auto-reply', '', '{"activity_type_id":"122159895062791773_2300312390390012","activity_subType_id":"631102136744766_122159895062791773","title":"Glad you liked it! Thanks for sharing your appreciation. 😊"}', '2025-11-07 12:37:23', NULL, '2025-11-07 12:37:23', '2025-11-07 12:37:23'),
(236, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_1378335096995458","activity_subType_id":"631102136744766_122159895062791773"}', '2025-11-07 12:39:00', NULL, '2025-11-07 12:39:00', '2025-11-08 12:39:13'),
(237, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comments', 'posts', 'reply', 'auto-reply', '', '{"activity_type_id":"122159895062791773_1345116487000345","activity_subType_id":"631102136744766_122159895062791773","title":"Thanks so much for the kind words! We''re glad you enjoyed the post 😊"}', '2025-11-07 12:39:17', NULL, '2025-11-07 12:39:17', '2025-11-07 12:39:17'),
(238, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comments', 'posts', 'reply', '', '', '{"activity_type_id":"122159895062791773_1752451508724247","activity_subType_id":"631102136744766_122159895062791773","title":"Thank you "}', '2025-11-07 12:42:36', NULL, '2025-11-07 12:42:36', '2025-11-07 12:42:36'),
(239, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comments', 'posts', 'reply', '', '', '{"activity_type_id":"122159895062791773_1998559480897694","activity_subType_id":"631102136744766_122159895062791773","title":"thanks"}', '2025-11-07 12:43:44', NULL, '2025-11-07 12:43:44', '2025-11-07 12:43:44'),
(240, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-08 13:46:05', NULL, '2025-11-08 13:46:05', '2025-11-08 13:46:05'),
(241, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-10 05:23:26', NULL, '2025-11-10 05:23:26', '2025-11-10 05:23:26'),
(242, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-10 06:29:25', NULL, '2025-11-10 06:29:25', '2025-11-10 06:29:25'),
(243, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-10 06:34:18', NULL, '2025-11-10 06:34:18', '2025-11-10 06:34:18'),
(244, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-10 06:36:21', NULL, '2025-11-10 06:36:21', '2025-11-10 06:36:21'),
(245, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-12 04:37:19', NULL, '2025-11-12 04:37:19', '2025-11-12 04:37:19'),
(246, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-12 04:37:53', NULL, '2025-11-12 04:37:53', '2025-11-12 04:37:53'),
(247, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-12 09:17:20', NULL, '2025-11-12 09:17:20', '2025-11-12 09:17:20'),
(248, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-12 10:34:51', NULL, '2025-11-12 10:34:51', '2025-11-12 10:34:51'),
(249, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-12 10:41:55', NULL, '2025-11-12 10:41:55', '2025-11-12 10:41:55'),
(250, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-12 10:53:21', NULL, '2025-11-12 10:53:21', '2025-11-12 10:53:21'),
(251, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-12 12:34:13', NULL, '2025-11-12 12:34:13', '2025-11-12 12:34:13'),
(252, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-12 12:34:34', NULL, '2025-11-12 12:34:34', '2025-11-12 12:34:34'),
(253, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-12 12:42:17', NULL, '2025-11-12 12:42:17', '2025-11-12 12:42:17'),
(254, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-13 10:44:59', NULL, '2025-11-13 10:44:59', '2025-11-13 10:44:59'),
(255, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-13 11:01:28', NULL, '2025-11-13 11:01:28', '2025-11-13 11:01:28'),
(256, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-13 11:01:43', NULL, '2025-11-13 11:01:43', '2025-11-13 11:01:43'),
(261, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-13 11:01:59', NULL, '2025-11-13 11:01:59', '2025-11-13 11:01:59'),
(262, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-13 11:09:21', NULL, '2025-11-13 11:09:21', '2025-11-13 11:09:21'),
(263, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-13 12:36:31', NULL, '2025-11-13 12:36:31', '2025-11-13 12:36:31'),
(264, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-13 12:39:31', NULL, '2025-11-13 12:39:31', '2025-11-13 12:39:31'),
(265, '69cc067c-c761-434a-88bc-377f1b95d727', '4322577274695285', 'facebook', 'social', 'account', 'connected', '', '', '{"activity_type_id":{},"activity_subType_id":"4322577274695285","title":"Andy Mehra"}', '2025-11-13 12:43:56', NULL, '2025-11-13 12:43:56', '2025-11-13 12:43:56'),
(266, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-13 13:28:06', NULL, '2025-11-13 13:28:06', '2025-11-13 13:28:06'),
(267, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-14 05:23:24', NULL, '2025-11-14 05:23:24', '2025-11-14 05:23:24'),
(268, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-15 07:07:47', NULL, '2025-11-15 07:07:47', '2025-11-15 07:07:47'),
(269, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-15 07:09:27', NULL, '2025-11-15 07:09:27', '2025-11-15 07:09:27'),
(270, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-15 07:09:39', NULL, '2025-11-15 07:09:39', '2025-11-15 07:09:39'),
(271, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-15 07:10:17', NULL, '2025-11-15 07:10:17', '2025-11-15 07:10:17'),
(272, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-15 09:55:03', NULL, '2025-11-15 09:55:03', '2025-11-15 09:55:03'),
(273, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-15 09:55:29', NULL, '2025-11-15 09:55:29', '2025-11-15 09:55:29'),
(274, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-15 10:18:02', NULL, '2025-11-15 10:18:02', '2025-11-15 10:18:02'),
(275, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_5LvsdhV0C173xxYkoAKgTm_grOqO3NWBRJ7Xc2GwTPxeL2_FT2gvmXCVnOWMc-I4dvQFhqaVeDNKl62u6y4ZZg"}', '2025-11-16 17:20:16', '2025-11-17 17:20:16', '2025-11-16 17:20:16', '2025-11-16 17:20:16'),
(276, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-17 14:33:20', NULL, '2025-11-17 14:33:20', '2025-11-17 14:33:20'),
(277, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-17 14:33:23', NULL, '2025-11-17 14:33:23', '2025-11-17 14:33:23'),
(292, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-18 04:21:06', NULL, '2025-11-18 04:21:06', '2025-11-18 04:21:06'),
(293, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-18 04:24:22', NULL, '2025-11-18 04:24:22', '2025-11-18 04:24:22'),
(294, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-18 07:51:07', NULL, '2025-11-18 07:51:07', '2025-11-18 07:51:07'),
(303, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-19 13:11:47', NULL, '2025-11-19 13:11:47', '2025-11-19 13:11:47'),
(304, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-19 13:19:10', NULL, '2025-11-19 13:19:10', '2025-11-19 13:19:10'),
(305, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-20 06:20:43', NULL, '2025-11-20 06:20:43', '2025-11-20 06:20:43'),
(306, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-20 11:12:48', NULL, '2025-11-20 11:12:48', '2025-11-20 11:12:48'),
(307, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-24 09:26:58', NULL, '2025-11-24 09:26:58', '2025-11-24 09:26:58'),
(308, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-24 09:27:35', NULL, '2025-11-24 09:27:35', '2025-11-24 09:27:35'),
(309, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-24 09:29:00', NULL, '2025-11-24 09:29:00', '2025-11-24 09:29:00'),
(310, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-24 09:35:13', NULL, '2025-11-24 09:35:13', '2025-11-24 09:35:13'),
(311, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-24 09:58:04', NULL, '2025-11-24 09:58:04', '2025-11-24 09:58:04'),
(312, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-24 11:18:06', NULL, '2025-11-24 11:18:06', '2025-11-24 11:18:06'),
(313, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-24 11:25:59', NULL, '2025-11-24 11:25:59', '2025-11-24 11:25:59'),
(314, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-25 08:11:25', NULL, '2025-11-25 08:11:25', '2025-11-25 08:11:25'),
(315, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-25 22:02:06', NULL, '2025-11-25 22:02:06', '2025-11-25 22:02:06'),
(316, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-26 06:31:07', NULL, '2025-11-26 06:31:07', '2025-11-26 06:31:07'),
(317, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-26 12:44:58', NULL, '2025-11-26 12:44:58', '2025-11-26 12:44:58'),
(318, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-26 12:45:49', NULL, '2025-11-26 12:45:49', '2025-11-26 12:45:49'),
(319, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-27 06:49:38', NULL, '2025-11-27 06:49:38', '2025-11-27 06:49:38'),
(320, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-27 08:03:51', NULL, '2025-11-27 08:03:51', '2025-11-27 08:03:51'),
(321, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-27 08:23:49', NULL, '2025-11-27 08:23:49', '2025-11-27 08:23:49'),
(322, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-27 09:11:19', NULL, '2025-11-27 09:11:19', '2025-11-27 09:11:19'),
(323, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-27 09:18:35', NULL, '2025-11-27 09:18:35', '2025-11-27 09:18:35'),
(324, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-11-27 18:28:09', NULL, '2025-11-27 18:28:09', '2025-11-27 18:28:09'),
(325, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-01 08:40:29', NULL, '2025-12-01 08:40:29', '2025-12-01 08:40:29'),
(326, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-01 08:42:40', NULL, '2025-12-01 08:42:40', '2025-12-01 08:42:40'),
(327, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_CPMrvSOP2KIvR5hJSjj4GRhzQSVLdgqqtafs2aaIipsxLPvzY4vevcvy-XTur44dd7beNO3tpDnQk-iO-xm04Q"}', '2025-12-01 10:52:20', '2025-12-02 10:52:20', '2025-12-01 10:52:20', '2025-12-01 10:52:20'),
(328, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_9C7ev_m42ENjzySNEBpsEBhzQSVLdgqqtafs2aaIipuZg0H8DKbSPkhBur6HWf2y_L7fgALYVzdeXSmrVVbRrw"}', '2025-12-01 10:58:40', '2025-12-02 10:58:40', '2025-12-01 10:58:40', '2025-12-01 10:58:40'),
(329, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_JAAi0_l1cPkmd-QnwMA4PhhzQSVLdgqqtafs2aaIipuSVlstmdNGAaRQBiykHlVD9F1wF1hw9xyJMy1euThsmQ"}', '2025-12-01 11:00:11', '2025-12-02 11:00:11', '2025-12-01 11:00:11', '2025-12-01 11:00:11'),
(330, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_PFmwd9ijmtTD3AwBbbVWqBhzQSVLdgqqtafs2aaIipuwjVGnTheinLZhLxhGKapiEyyD2iojHsPjzrZ_xfnIag"}', '2025-12-01 11:02:23', '2025-12-02 11:02:23', '2025-12-01 11:02:23', '2025-12-01 11:02:23'),
(331, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_Fyi94qWlxCnW4bohTX4GehhzQSVLdgqqtafs2aaIipsM7zw7vr40XXtJosWSSngLsd1MgrHYkDmnDO0cCuuuvg"}', '2025-12-01 11:04:53', '2025-12-02 11:04:53', '2025-12-01 11:04:53', '2025-12-01 11:04:53'),
(332, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-01 11:06:54', NULL, '2025-12-01 11:06:54', '2025-12-01 11:06:54'),
(333, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_4LX9W5c-fLF7syRJnwkDehhzQSVLdgqqtafs2aaIipsF5okgeYYBx45mEOyQmCjcpmhcC7Pdp-Hgr1N8EanhGg"}', '2025-12-01 11:08:24', '2025-12-02 11:08:24', '2025-12-01 11:08:24', '2025-12-01 11:08:24'),
(334, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-03 07:44:42', NULL, '2025-12-03 07:44:42', '2025-12-03 07:44:42'),
(335, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-03 07:51:20', NULL, '2025-12-03 07:51:20', '2025-12-03 07:51:20'),
(336, 'c4a143a4-60e9-4dc8-9fe0-8dd185e894f8', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"c4a143a4-60e9-4dc8-9fe0-8dd185e894f8","activity_subType_id":{},"title":"Manjeet Singh"}', '2025-12-03 09:37:55', NULL, '2025-12-03 09:37:55', '2025-12-03 09:37:55'),
(337, 'c4a143a4-60e9-4dc8-9fe0-8dd185e894f8', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"c4a143a4-60e9-4dc8-9fe0-8dd185e894f8","activity_subType_id":{},"title":"Manjeet Singh"}', '2025-12-03 10:58:10', NULL, '2025-12-03 10:58:10', '2025-12-03 10:58:10'),
(338, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-03 10:58:13', NULL, '2025-12-03 10:58:13', '2025-12-03 10:58:13'),
(339, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-03 13:15:55', NULL, '2025-12-03 13:15:55', '2025-12-03 13:15:55'),
(340, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-03 13:16:31', NULL, '2025-12-03 13:16:31', '2025-12-03 13:16:31'),
(341, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-04 06:04:11', NULL, '2025-12-04 06:04:11', '2025-12-04 06:04:11'),
(342, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'page', 'create', 'webhook', '', '{"activity_type_id":"631102136744766","activity_subType_id":"m_hcDpROP-sEEMN6hzy-dEeBhzQSVLdgqqtafs2aaIipsHDh0ru7AWeqfSJbMlfKRnq9fi5f4t81QZ8sdQwte7Jw"}', '2025-12-04 06:06:21', '2025-12-05 06:06:21', '2025-12-04 06:06:21', '2025-12-04 06:06:21'),
(343, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', 'webhook', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122159895062791773"}', '2025-12-04 06:16:02', '2025-12-05 06:16:02', '2025-12-04 06:16:02', '2025-12-04 06:16:02'),
(344, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'create', 'webhook', '', '{"activity_type_id":"122159895062791773_1102036591862036","activity_subType_id":"631102136744766_122159895062791773"}', '2025-12-04 06:18:06', '2025-12-05 06:18:06', '2025-12-04 06:18:06', '2025-12-04 06:18:06'),
(345, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comments', 'posts', 'reply', 'auto-reply', '', '{"activity_type_id":"122159895062791773_2133506647396436","activity_subType_id":"631102136744766_122159895062791773","title":"Thanks so much! Glad you enjoyed it 😊"}', '2025-12-04 06:18:23', NULL, '2025-12-04 06:18:23', '2025-12-04 06:18:23'),
(346, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'comment', 'posts', 'delete', 'webhook', '', '{"activity_type_id":"","activity_subType_id":"631102136744766_122159895062791773"}', '2025-12-04 06:19:00', '2025-12-05 06:19:00', '2025-12-04 06:19:00', '2025-12-04 06:19:00'),
(347, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-04 06:19:31', NULL, '2025-12-04 06:19:31', '2025-12-04 06:19:31'),
(348, 'b4206492-1778-4860-8e24-af93296a37d4', 'vJUiGhJ_Dk', 'linkedin', 'social', 'account', 'remove', '', '', '{"activity_type_id":{},"activity_subType_id":{},"title":"Manjeet  Singh "}', '2025-12-04 10:10:01', NULL, '2025-12-04 10:10:01', '2025-12-04 10:10:01'),
(349, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-04 10:13:14', NULL, '2025-12-04 10:13:14', '2025-12-04 10:13:14'),
(350, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-04 10:15:07', NULL, '2025-12-04 10:15:07', '2025-12-04 10:15:07'),
(351, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', 'facebook', 'social', 'account', 'connected', '', '', '{"activity_type_id":{},"activity_subType_id":"122156535248577012","title":"Ross Singh"}', '2025-12-04 10:15:47', NULL, '2025-12-04 10:15:47', '2025-12-04 10:15:47'),
(352, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', 'facebook', 'social', 'account', 'connected', '', '', '{"activity_type_id":{},"activity_subType_id":"122156535248577012","title":"Ross Singh"}', '2025-12-04 12:50:19', NULL, '2025-12-04 12:50:19', '2025-12-04 12:50:19'),
(353, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-04 12:57:03', NULL, '2025-12-04 12:57:03', '2025-12-04 12:57:03'),
(354, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-04 12:57:40', NULL, '2025-12-04 12:57:40', '2025-12-04 12:57:40'),
(355, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-05 09:25:01', NULL, '2025-12-05 09:25:01', '2025-12-05 09:25:01'),
(356, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-05 09:26:02', NULL, '2025-12-05 09:26:02', '2025-12-05 09:26:02'),
(357, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-05 12:26:58', NULL, '2025-12-05 12:26:58', '2025-12-05 12:26:58'),
(358, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-05 12:28:19', NULL, '2025-12-05 12:28:19', '2025-12-05 12:28:19'),
(359, 'ed39bbef-67a2-437d-9289-69bf3911feda', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"ed39bbef-67a2-437d-9289-69bf3911feda","activity_subType_id":{},"title":"Baljeet Singh"}', '2025-12-05 22:15:03', NULL, '2025-12-05 22:15:03', '2025-12-05 22:15:03'),
(360, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-06 06:50:22', NULL, '2025-12-06 06:50:22', '2025-12-06 06:50:22');
INSERT INTO "activity" ("id", "user_uuid", "account_social_userid", "account_platform", "activity_type", "activity_subType", "action", "source_type", "post_form_id", "reference_pageID", "activity_dateTime", "nextAPI_call_dateTime", "createdAt", "updatedAt") VALUES
(361, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-06 07:22:42', NULL, '2025-12-06 07:22:42', '2025-12-06 07:22:42'),
(362, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-06 07:22:58', NULL, '2025-12-06 07:22:58', '2025-12-06 07:22:58'),
(363, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-06 14:16:34', NULL, '2025-12-06 14:16:34', '2025-12-06 14:16:34'),
(364, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-06 14:20:21', NULL, '2025-12-06 14:20:21', '2025-12-06 14:20:21'),
(365, 'ca34a031-a977-406e-81a9-9b9af1de1c58', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"ca34a031-a977-406e-81a9-9b9af1de1c58","activity_subType_id":{},"title":"Baljeet Singh"}', '2025-12-07 18:46:15', NULL, '2025-12-07 18:46:15', '2025-12-07 18:46:15'),
(366, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-07 18:46:20', NULL, '2025-12-07 18:46:20', '2025-12-07 18:46:20'),
(367, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-07 19:14:30', NULL, '2025-12-07 19:14:30', '2025-12-07 19:14:30'),
(368, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-08 09:14:20', NULL, '2025-12-08 09:14:20', '2025-12-08 09:14:20'),
(369, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-08 09:17:24', NULL, '2025-12-08 09:17:24', '2025-12-08 09:17:24'),
(370, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-08 09:19:50', NULL, '2025-12-08 09:19:50', '2025-12-08 09:19:50'),
(371, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-08 09:21:50', NULL, '2025-12-08 09:21:50', '2025-12-08 09:21:50'),
(372, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-08 09:22:03', NULL, '2025-12-08 09:22:03', '2025-12-08 09:22:03'),
(373, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', 'facebook', 'social', 'page', 'disconnect', '', '', '{"activity_type_id":{},"activity_subType_id":"631102136744766","title":"Webonx"}', '2025-12-08 09:25:15', NULL, '2025-12-08 09:25:15', '2025-12-08 09:25:15'),
(374, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', 'facebook', 'social', 'page', 'connect', '', '', '{"activity_type_id":{},"activity_subType_id":"631102136744766","title":"Webonx"}', '2025-12-08 09:25:16', NULL, '2025-12-08 09:25:16', '2025-12-08 09:25:16'),
(375, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-08 09:31:28', NULL, '2025-12-08 09:31:28', '2025-12-08 09:31:28'),
(376, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-08 09:41:23', NULL, '2025-12-08 09:41:23', '2025-12-08 09:41:23'),
(377, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-08 09:55:17', NULL, '2025-12-08 09:55:17', '2025-12-08 09:55:17'),
(378, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-08 10:09:40', NULL, '2025-12-08 10:09:40', '2025-12-08 10:09:40'),
(379, 'ca34a031-a977-406e-81a9-9b9af1de1c58', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"ca34a031-a977-406e-81a9-9b9af1de1c58","activity_subType_id":{},"title":"Baljeet Singh"}', '2025-12-08 10:09:50', NULL, '2025-12-08 10:09:50', '2025-12-08 10:09:50'),
(380, 'ca34a031-a977-406e-81a9-9b9af1de1c58', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"ca34a031-a977-406e-81a9-9b9af1de1c58","activity_subType_id":{},"title":"Baljeet Singh"}', '2025-12-08 10:24:00', NULL, '2025-12-08 10:24:00', '2025-12-08 10:24:00'),
(381, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-08 11:25:09', NULL, '2025-12-08 11:25:09', '2025-12-08 11:25:09'),
(382, 'ca34a031-a977-406e-81a9-9b9af1de1c58', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"ca34a031-a977-406e-81a9-9b9af1de1c58","activity_subType_id":{},"title":"Baljeet Singh"}', '2025-12-08 11:25:18', NULL, '2025-12-08 11:25:18', '2025-12-08 11:25:18'),
(383, 'ca34a031-a977-406e-81a9-9b9af1de1c58', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"ca34a031-a977-406e-81a9-9b9af1de1c58","activity_subType_id":{},"title":"Baljeet Singh"}', '2025-12-08 11:26:16', NULL, '2025-12-08 11:26:16', '2025-12-08 11:26:16'),
(384, 'b4cde60f-99aa-48cf-8147-8567f8b7358c', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4cde60f-99aa-48cf-8147-8567f8b7358c","activity_subType_id":{},"title":"Andy Singh"}', '2025-12-08 11:33:18', NULL, '2025-12-08 11:33:18', '2025-12-08 11:33:18'),
(385, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-08 11:39:34', NULL, '2025-12-08 11:39:34', '2025-12-08 11:39:34'),
(386, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-08 11:52:12', NULL, '2025-12-08 11:52:12', '2025-12-08 11:52:12'),
(387, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-08 11:52:28', NULL, '2025-12-08 11:52:28', '2025-12-08 11:52:28'),
(388, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-08 12:51:40', NULL, '2025-12-08 12:51:40', '2025-12-08 12:51:40'),
(389, 'b4206492-1778-4860-8e24-af93296a37d4', '4322577274695285', 'facebook', 'social', 'account', 'connected', '', '', '{"activity_type_id":{},"activity_subType_id":"4322577274695285","title":"Andy Mehra"}', '2025-12-08 12:58:29', NULL, '2025-12-08 12:58:29', '2025-12-08 12:58:29'),
(390, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-08 13:16:29', NULL, '2025-12-08 13:16:29', '2025-12-08 13:16:29'),
(391, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-08 13:20:27', NULL, '2025-12-08 13:20:27', '2025-12-08 13:20:27'),
(392, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-08 13:20:34', NULL, '2025-12-08 13:20:34', '2025-12-08 13:20:34'),
(393, '9e47ed0e-73f7-41d5-9dac-5c37b8df8a4f', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"9e47ed0e-73f7-41d5-9dac-5c37b8df8a4f","activity_subType_id":{},"title":"Baljeet Singh"}', '2025-12-08 18:09:55', NULL, '2025-12-08 18:09:55', '2025-12-08 18:09:55'),
(394, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-08 19:50:23', NULL, '2025-12-08 19:50:23', '2025-12-08 19:50:23'),
(395, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-08 19:50:44', NULL, '2025-12-08 19:50:44', '2025-12-08 19:50:44'),
(396, '9e47ed0e-73f7-41d5-9dac-5c37b8df8a4f', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"9e47ed0e-73f7-41d5-9dac-5c37b8df8a4f","activity_subType_id":{},"title":"Baljeet Singh"}', '2025-12-08 19:51:08', NULL, '2025-12-08 19:51:08', '2025-12-08 19:51:08'),
(397, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-09 06:37:30', NULL, '2025-12-09 06:37:30', '2025-12-09 06:37:30'),
(398, 'b4206492-1778-4860-8e24-af93296a37d4', NULL, NULL, 'user', 'profile', 'logout', '', '', '{"activity_type_id":"b4206492-1778-4860-8e24-af93296a37d4","activity_subType_id":{},"title":"Test User"}', '2025-12-09 06:37:46', NULL, '2025-12-09 06:37:46', '2025-12-09 06:37:46'),
(399, '9e47ed0e-73f7-41d5-9dac-5c37b8df8a4f', NULL, NULL, 'user', 'profile', 'login', '', '', '{"activity_type_id":"9e47ed0e-73f7-41d5-9dac-5c37b8df8a4f","activity_subType_id":{},"title":"Baljeet Singh"}', '2025-12-09 06:56:29', NULL, '2025-12-09 06:56:29', '2025-12-09 06:56:29');

-- --------------------------------------------------------

--
-- Table structure for table "admin_alerts"
--

CREATE TABLE "admin_alerts" (
  "id" BIGINT NOT NULL,
  "type" VARCHAR(255) NOT NULL DEFAULT 'general',
  "severity" VARCHAR(255) NOT NULL DEFAULT 'info',
  "title" varchar(255) NOT NULL,
  "message" text NOT NULL,
  "metadata" TEXT  DEFAULT NULL ,
  "read" SMALLINT NOT NULL DEFAULT 0,
  "read_at" timestamp NULL DEFAULT NULL,
  "read_by" BIGINT DEFAULT NULL,
  "created_at" timestamp NULL DEFAULT NULL,
  "updated_at" timestamp NULL DEFAULT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "admin_audit_logs"
--

CREATE TABLE "admin_audit_logs" (
  "id" BIGINT NOT NULL,
  "admin_id" BIGINT DEFAULT NULL,
  "admin_email" varchar(255) DEFAULT NULL,
  "admin_name" varchar(255) DEFAULT NULL,
  "action_type" VARCHAR(255) NOT NULL,
  "entity_type" varchar(255) DEFAULT NULL ,
  "entity_id" varchar(255) DEFAULT NULL ,
  "description" text NOT NULL,
  "old_values" TEXT  DEFAULT NULL ,
  "new_values" TEXT  DEFAULT NULL ,
  "metadata" TEXT  DEFAULT NULL ,
  "ip_address" varchar(45) DEFAULT NULL,
  "user_agent" text DEFAULT NULL,
  "request_method" varchar(10) DEFAULT NULL,
  "request_url" text DEFAULT NULL,
  "session_id" varchar(255) DEFAULT NULL,
  "severity" VARCHAR(255) NOT NULL DEFAULT 'info',
  "created_at" timestamp NULL DEFAULT NULL,
  "updated_at" timestamp NULL DEFAULT NULL
);

--
-- Dumping data for table "admin_audit_logs"
--

INSERT INTO "admin_audit_logs" ("id", "admin_id", "admin_email", "admin_name", "action_type", "entity_type", "entity_id", "description", "old_values", "new_values", "metadata", "ip_address", "user_agent", "request_method", "request_url", "session_id", "severity", "created_at", "updated_at") VALUES
(1, 2, 'admin@insocialwise.com', 'Super Admin', 'login', NULL, NULL, 'Admin admin@insocialwise.com logged in successfully', NULL, NULL, NULL, '223.178.209.173', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'POST', 'http://51318579-bfb0-4529-a363-9c24952c0e0f-00-3s0sp1pby59o7.janeway.replit.dev/login', 'hMyYx2A9NGtHzwDksNOKUBYiPM8qGkcNRmzFr0UT', 'info', '2025-12-08 18:57:01', '2025-12-08 18:57:01'),
(2, 2, 'admin@insocialwise.com', 'Super Admin', 'login', NULL, NULL, 'Admin admin@insocialwise.com logged in successfully', NULL, NULL, NULL, '223.178.209.173', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'POST', 'http://51318579-bfb0-4529-a363-9c24952c0e0f-00-3s0sp1pby59o7.janeway.replit.dev/login', '23WXOlgx0KOBdi2hxNIfm25g4293Z76Nga1rSGEV', 'info', '2025-12-08 19:23:36', '2025-12-08 19:23:36'),
(3, 2, 'admin@insocialwise.com', 'Super Admin', 'login', NULL, NULL, 'Admin admin@insocialwise.com logged in successfully', NULL, NULL, NULL, '223.178.209.173', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'POST', 'http://e68ecbfd-45c7-405f-a8d7-f90613203486-00-1ltd1dxhtu2g5.sisko.replit.dev/login', 'ck9l4XCU6HuV8YYG76cMkTxUCyGtVn7MkfPbX8Hs', 'info', '2025-12-08 20:20:25', '2025-12-08 20:20:25'),
(4, 2, 'admin@insocialwise.com', 'Super Admin', 'login', NULL, NULL, 'Admin admin@insocialwise.com logged in successfully', NULL, NULL, NULL, '223.178.209.173', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'POST', 'http://e68ecbfd-45c7-405f-a8d7-f90613203486-00-1ltd1dxhtu2g5.sisko.replit.dev/login', 'TyfWCjm2GsC3n2mcmGDMTqNoZXVoYtHq2KVjP8bs', 'info', '2025-12-08 20:20:46', '2025-12-08 20:20:46'),
(5, 2, 'admin@insocialwise.com', 'Super Admin', 'login', NULL, NULL, 'Admin admin@insocialwise.com logged in successfully', NULL, NULL, NULL, '223.178.209.173', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'POST', 'http://e68ecbfd-45c7-405f-a8d7-f90613203486-00-1ltd1dxhtu2g5.sisko.replit.dev/login', '2Vzz0rEt01A0fupOy7rs6ouAa5FJwvyiFHGTyNmG', 'info', '2025-12-08 20:24:30', '2025-12-08 20:24:30'),
(6, 2, 'admin@insocialwise.com', 'Super Admin', 'login', NULL, NULL, 'Admin admin@insocialwise.com logged in successfully', NULL, NULL, NULL, '223.178.209.173', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'POST', 'http://d5af018e-7df7-480b-b9e1-538dd76bccc4-00-uuh5yqfznlnw.riker.replit.dev/login', 'X7hANt0qo7n5VPMscJ8AgXfNS5vScJdOX4X3LopN', 'info', '2025-12-08 20:54:14', '2025-12-08 20:54:14'),
(7, 2, 'admin@insocialwise.com', 'Super Admin', 'login', NULL, NULL, 'Admin admin@insocialwise.com logged in successfully', NULL, NULL, NULL, '223.181.17.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'POST', 'http://6349261f-0ac7-43a4-846c-0cb0d3e56aa0-00-10s3cqsfa7tal.worf.replit.dev/login', 'Gt5zOTHjJNcJxI3Y1L3SBt75XyFIfEZ1DLTAEqlu', 'info', '2025-12-09 06:51:22', '2025-12-09 06:51:22');

-- --------------------------------------------------------

--
-- Table structure for table "admin_feature_flags"
--

CREATE TABLE "admin_feature_flags" (
  "id" BIGINT NOT NULL,
  "feature_key" varchar(255) NOT NULL,
  "feature_name" varchar(255) NOT NULL,
  "description" text DEFAULT NULL,
  "category" VARCHAR(255) NOT NULL DEFAULT 'core',
  "enabled" SMALLINT NOT NULL DEFAULT 0,
  "force_enabled" SMALLINT NOT NULL DEFAULT 0,
  "updated_by" BIGINT DEFAULT NULL,
  "created_at" timestamp NULL DEFAULT NULL,
  "updated_at" timestamp NULL DEFAULT NULL
);

--
-- Dumping data for table "admin_feature_flags"
--

INSERT INTO "admin_feature_flags" ("id", "feature_key", "feature_name", "description", "category", "enabled", "force_enabled", "updated_by", "created_at", "updated_at") VALUES
(1, 'posts_management', 'Posts Management', 'Enable/disable posts management feature', 'core', 1, 0, NULL, '2025-11-29 10:05:37', '2025-11-29 10:05:37'),
(2, 'analytics_insights', 'Analytics & Insights', 'Enable/disable analytics dashboard', 'core', 1, 0, NULL, '2025-11-29 10:05:37', '2025-11-29 10:05:37'),
(3, 'inbox_messaging', 'Inbox & Messaging', 'Enable/disable inbox messaging feature', 'core', 1, 0, NULL, '2025-11-29 10:05:37', '2025-11-29 10:05:37'),
(4, 'advertising_campaigns', 'Advertising Campaigns', 'Enable/disable ad campaigns feature', 'core', 1, 0, NULL, '2025-11-29 10:05:37', '2025-11-29 10:05:37'),
(5, 'comment_management', 'Comment Management', 'Enable/disable comment management', 'core', 1, 0, NULL, '2025-11-29 10:05:37', '2025-11-29 10:05:37'),
(6, 'user_management', 'User Management', 'User management (cannot be disabled)', 'admin', 1, 1, NULL, '2025-11-29 10:05:38', '2025-11-29 10:05:38'),
(7, 'subscription_management', 'Subscription Management', 'Enable/disable subscription management', 'admin', 1, 0, NULL, '2025-11-29 10:05:38', '2025-11-29 10:05:38'),
(8, 'system_settings', 'System Settings', 'System settings (cannot be disabled)', 'admin', 1, 1, NULL, '2025-11-29 10:05:38', '2025-11-29 10:05:38'),
(9, 'activity_logging', 'Activity Logging', 'Enable/disable activity logging', 'admin', 1, 0, NULL, '2025-11-29 10:05:38', '2025-11-29 10:05:38'),
(10, 'user_impersonation', 'User Impersonation', 'Allow admins to login as users', 'admin', 0, 0, NULL, '2025-11-29 10:05:38', '2025-11-29 10:05:38'),
(11, 'two_factor_auth', 'Two-Factor Authentication', 'Enable 2FA for admin accounts', 'security', 1, 0, NULL, '2025-11-29 10:05:38', '2025-11-29 10:05:38'),
(12, 'ip_whitelisting', 'IP Whitelisting', 'Restrict admin access by IP', 'security', 0, 0, NULL, '2025-11-29 10:05:38', '2025-11-29 10:05:38'),
(13, 'session_management', 'Session Management', 'View and manage admin sessions', 'security', 1, 0, NULL, '2025-11-29 10:05:39', '2025-11-29 10:05:39'),
(14, 'audit_logging', 'Audit Logging', 'Log all admin actions', 'security', 1, 0, NULL, '2025-11-29 10:05:39', '2025-11-29 10:05:39'),
(15, 'system_health_monitoring', 'System Health Monitoring', 'Monitor system health metrics', 'monitoring', 1, 0, NULL, '2025-11-29 10:05:39', '2025-11-29 10:05:39'),
(16, 'error_tracking', 'Error Tracking', 'Track and log application errors', 'monitoring', 1, 0, NULL, '2025-11-29 10:05:39', '2025-11-29 10:05:39'),
(17, 'alert_notifications', 'Alert Notifications', 'Enable alert notifications', 'monitoring', 1, 0, NULL, '2025-11-29 10:05:39', '2025-11-29 10:05:39'),
(18, 'performance_monitoring', 'Performance Monitoring', 'Monitor performance metrics', 'monitoring', 0, 0, NULL, '2025-11-29 10:05:39', '2025-11-29 10:05:39'),
(19, 'bulk_export', 'Bulk Export', 'Enable bulk data export', 'data', 1, 0, NULL, '2025-11-29 10:05:40', '2025-11-29 10:05:40'),
(20, 'scheduled_exports', 'Scheduled Exports', 'Enable scheduled report exports', 'data', 0, 0, NULL, '2025-11-29 10:05:40', '2025-11-29 10:05:40'),
(21, 'report_generation', 'Report Generation', 'Enable custom report generation', 'data', 1, 0, NULL, '2025-11-29 10:05:40', '2025-11-29 10:05:40'),
(22, 'analytics_export', 'Analytics Export', 'Enable analytics data export', 'data', 1, 0, NULL, '2025-11-29 10:05:40', '2025-11-29 10:05:40');

-- --------------------------------------------------------

--
-- Table structure for table "admin_sessions"
--

CREATE TABLE "admin_sessions" (
  "id" BIGINT NOT NULL,
  "admin_id" BIGINT NOT NULL,
  "session_token" varchar(255) NOT NULL,
  "ip_address" varchar(45) NOT NULL,
  "user_agent" text DEFAULT NULL,
  "device_type" varchar(50) DEFAULT NULL,
  "browser" varchar(100) DEFAULT NULL,
  "os" varchar(100) DEFAULT NULL,
  "location" varchar(255) DEFAULT NULL,
  "is_current" SMALLINT NOT NULL DEFAULT 0,
  "last_activity_at" timestamp NULL DEFAULT NULL,
  "logged_in_at" timestamp NOT NULL,
  "logged_out_at" timestamp NULL DEFAULT NULL,
  "status" VARCHAR(255) NOT NULL DEFAULT 'active',
  "created_at" timestamp NULL DEFAULT NULL,
  "updated_at" timestamp NULL DEFAULT NULL
);

--
-- Dumping data for table "admin_sessions"
--

INSERT INTO "admin_sessions" ("id", "admin_id", "session_token", "ip_address", "user_agent", "device_type", "browser", "os", "location", "is_current", "last_activity_at", "logged_in_at", "logged_out_at", "status", "created_at", "updated_at") VALUES
(1, 2, '23WXOlgx0KOBdi2hxNIfm25g4293Z76Nga1rSGEV', '223.178.209.173', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'desktop', 'Chrome', 'Windows', NULL, 0, '2025-12-08 19:49:32', '2025-12-08 19:23:36', NULL, 'active', '2025-12-08 19:23:36', '2025-12-08 20:24:30'),
(2, 2, '2Vzz0rEt01A0fupOy7rs6ouAa5FJwvyiFHGTyNmG', '223.178.209.173', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'desktop', 'Chrome', 'Windows', NULL, 0, '2025-12-08 20:40:35', '2025-12-08 20:24:31', NULL, 'active', '2025-12-08 20:24:31', '2025-12-08 20:54:14'),
(3, 2, 'X7hANt0qo7n5VPMscJ8AgXfNS5vScJdOX4X3LopN', '223.178.209.173', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'desktop', 'Chrome', 'Windows', NULL, 0, '2025-12-08 21:17:01', '2025-12-08 20:54:14', NULL, 'active', '2025-12-08 20:54:14', '2025-12-09 06:51:22'),
(4, 2, 'Gt5zOTHjJNcJxI3Y1L3SBt75XyFIfEZ1DLTAEqlu', '223.181.17.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'desktop', 'Chrome', 'Windows', NULL, 1, '2025-12-09 07:01:24', '2025-12-09 06:51:22', NULL, 'active', '2025-12-09 06:51:22', '2025-12-09 07:01:24');

-- --------------------------------------------------------

--
-- Table structure for table "admin_settings"
--

CREATE TABLE "admin_settings" (
  "id" BIGINT NOT NULL,
  "key" varchar(255) NOT NULL,
  "value" TEXT DEFAULT NULL,
  "type" VARCHAR(255) NOT NULL DEFAULT 'string',
  "group" varchar(255) NOT NULL DEFAULT 'general',
  "description" text DEFAULT NULL,
  "section" varchar(255) DEFAULT NULL,
  "created_at" timestamp NULL DEFAULT NULL,
  "updated_at" timestamp NULL DEFAULT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "admin_users"
--

CREATE TABLE "admin_users" (
  "id" BIGINT NOT NULL,
  "name" varchar(255) NOT NULL,
  "email" varchar(255) NOT NULL,
  "email_verified_at" timestamp NULL DEFAULT NULL,
  "password" varchar(255) NOT NULL,
  "is_active" SMALLINT NOT NULL DEFAULT 1,
  "remember_token" varchar(100) DEFAULT NULL,
  "created_at" timestamp NULL DEFAULT NULL,
  "updated_at" timestamp NULL DEFAULT NULL
);

--
-- Dumping data for table "admin_users"
--

INSERT INTO "admin_users" ("id", "name", "email", "email_verified_at", "password", "is_active", "remember_token", "created_at", "updated_at") VALUES
(2, 'Super Admin', 'admin@insocialwise.com', '2025-11-27 17:57:13', '$2y$12$XnYzvwZ3/a6.wIMyOaxaZuMIpLDo2goUlJwkmg1G3pHwDqhJGaJHe', 1, NULL, '2025-11-27 17:57:13', '2025-11-27 17:57:13');

-- --------------------------------------------------------

--
-- Table structure for table "admin_user_role"
--

CREATE TABLE "admin_user_role" (
  "admin_user_id" BIGINT NOT NULL,
  "role_id" BIGINT NOT NULL
);

--
-- Dumping data for table "admin_user_role"
--

INSERT INTO "admin_user_role" ("admin_user_id", "role_id") VALUES
(2, 1);

-- --------------------------------------------------------

--
-- Table structure for table "adsets"
--

CREATE TABLE "adsets" (
  "id" INTEGER NOT NULL,
  "user_uuid" varchar(255) DEFAULT NULL,
  "account_platform" varchar(255) DEFAULT NULL,
  "account_social_userid" varchar(255) DEFAULT NULL,
  "adsets_campaign_id" BIGINT DEFAULT NULL,
  "adsets_id" BIGINT DEFAULT NULL,
  "adsets_name" varchar(255) DEFAULT NULL,
  "adsets_countries" TEXT DEFAULT NULL,
  "adsets_regions" TEXT  DEFAULT NULL ,
  "adsets_cities" TEXT  DEFAULT NULL ,
  "adsets_age_min" INTEGER DEFAULT NULL,
  "adsets_age_max" INTEGER DEFAULT NULL,
  "adsets_genders" text DEFAULT NULL,
  "adsets_publisher_platforms" TEXT DEFAULT NULL,
  "adsets_facebook_positions" TEXT DEFAULT NULL,
  "adsets_instagram_positions" TEXT DEFAULT NULL,
  "adsets_device_platforms" TEXT DEFAULT NULL,
  "adsets_start_time" TIMESTAMP DEFAULT NULL,
  "adsets_end_time" TIMESTAMP DEFAULT NULL,
  "adsets_status" varchar(255) DEFAULT NULL,
  "adsets_insights_impressions" varchar(255) DEFAULT NULL,
  "adsets_insights_clicks" varchar(255) DEFAULT NULL,
  "adsets_insights_cpc" varchar(255) DEFAULT NULL,
  "adsets_insights_cpm" varchar(255) DEFAULT NULL,
  "adsets_insights_ctr" varchar(255) DEFAULT NULL,
  "adsets_insights_spend" varchar(255) DEFAULT NULL,
  "adsets_daily_budget" varchar(255) DEFAULT NULL,
  "adsets_lifetime_budget" varchar(255) DEFAULT NULL,
  "adsets_insights_date_start" date DEFAULT NULL,
  "adsets_insights_date_stop" date DEFAULT NULL,
  "adsets_insights_reach" varchar(255) DEFAULT NULL,
  "adsets_insights_results" INTEGER DEFAULT NULL,
  "adsets_result_type" varchar(255) DEFAULT NULL,
  "adsets_insights_cost_per_result" float DEFAULT NULL,
  "adsets_insights_actions" TEXT  DEFAULT NULL ,
  "createdAt" timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  "updatedAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- --------------------------------------------------------

--
-- Table structure for table "adsets_ads"
--

CREATE TABLE "adsets_ads" (
  "id" INTEGER NOT NULL,
  "user_uuid" varchar(255) DEFAULT NULL,
  "account_platform" varchar(255) DEFAULT NULL,
  "account_social_userid" varchar(255) DEFAULT NULL,
  "campaign_id" BIGINT DEFAULT NULL,
  "adsets_id" BIGINT DEFAULT NULL,
  "ads_id" BIGINT DEFAULT NULL,
  "ads_name" varchar(255) DEFAULT NULL,
  "ads_status" varchar(255) DEFAULT NULL,
  "ads_effective_status" varchar(255) DEFAULT NULL,
  "ads_insights_impressions" varchar(255) DEFAULT NULL,
  "ads_insights_clicks" varchar(255) DEFAULT NULL,
  "ads_insights_cpc" varchar(255) DEFAULT NULL,
  "ads_insights_cpm" varchar(255) DEFAULT NULL,
  "ads_insights_ctr" varchar(255) DEFAULT NULL,
  "ads_insights_spend" varchar(255) DEFAULT NULL,
  "ads_insights_reach" varchar(255) DEFAULT NULL,
  "ads_insights_date_start" date DEFAULT NULL,
  "ads_insights_date_stop" date DEFAULT NULL,
  "ads_insights_cost_per_result" varchar(255) DEFAULT NULL,
  "ads_result_type" varchar(255) DEFAULT NULL,
  "ads_insights_actions" TEXT  DEFAULT NULL ,
  "createdAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "updatedAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- --------------------------------------------------------

--
-- Table structure for table "ads_accounts"
--

CREATE TABLE "ads_accounts" (
  "id" INTEGER NOT NULL,
  "user_uuid" varchar(255) DEFAULT NULL,
  "account_platform" varchar(255) DEFAULT NULL,
  "account_social_userid" varchar(255) DEFAULT NULL,
  "account_id" varchar(255) DEFAULT NULL,
  "account_name" varchar(255) DEFAULT NULL,
  "account_status" varchar(255) DEFAULT NULL,
  "isConnected" VARCHAR(255) NOT NULL DEFAULT 'notConnected',
  "currency" varchar(250) DEFAULT NULL,
  "timezone_name" varchar(250) DEFAULT NULL,
  "timezone_offset_hours_utc" varchar(250) DEFAULT NULL,
  "amount_spent" INTEGER DEFAULT 0,
  "balance" INTEGER DEFAULT 0,
  "business_page_detail" TEXT  DEFAULT NULL ,
  "min_campaign_group_spend_cap" INTEGER DEFAULT 0,
  "spend_cap" INTEGER DEFAULT 0,
  "createdAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "updatedAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table "ads_accounts"
--

INSERT INTO "ads_accounts" ("id", "user_uuid", "account_platform", "account_social_userid", "account_id", "account_name", "account_status", "isConnected", "currency", "timezone_name", "timezone_offset_hours_utc", "amount_spent", "balance", "business_page_detail", "min_campaign_group_spend_cap", "spend_cap", "createdAt", "updatedAt") VALUES
(105, 'b4206492-1778-4860-8e24-af93296a37d4', 'facebook', '122156535248577012', '1076214387241135', 'Ross Singh', '1', 'notConnected', 'INR', 'Asia/Kolkata', '5.5', 0, 0, NULL, 500000, 0, '2025-12-04 12:50:24', '2025-12-04 12:50:24');

-- --------------------------------------------------------

--
-- Table structure for table "ads_creative"
--

CREATE TABLE "ads_creative" (
  "id" INTEGER NOT NULL,
  "user_uuid" varchar(255) DEFAULT NULL,
  "account_platform" varchar(255) DEFAULT NULL,
  "social_page_id" varchar(250) DEFAULT NULL,
  "account_social_userid" varchar(255) DEFAULT NULL,
  "campaign_id" varchar(255) DEFAULT NULL,
  "adset_id" varchar(255) DEFAULT NULL,
  "ad_id" varchar(255) DEFAULT NULL,
  "creative_id" varchar(255) DEFAULT NULL,
  "creative_type" varchar(255) DEFAULT NULL,
  "image_urls" TEXT  DEFAULT NULL ,
  "video_thumbnails" TEXT  DEFAULT NULL ,
  "headline" varchar(255) DEFAULT NULL,
  "body" text DEFAULT NULL,
  "call_to_action" TEXT  DEFAULT NULL ,
  "call_to_action_link" varchar(255) DEFAULT NULL,
  "createdAt" TIMESTAMP NOT NULL,
  "updatedAt" TIMESTAMP NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "alert_thresholds"
--

CREATE TABLE "alert_thresholds" (
  "id" INTEGER NOT NULL,
  "user_uuid" varchar(255) NOT NULL,
  "alert_name" varchar(255) NOT NULL,
  "metric_type" VARCHAR(255) NOT NULL,
  "condition" VARCHAR(255) NOT NULL DEFAULT 'below',
  "threshold_value" float NOT NULL,
  "comparison_period" VARCHAR(255) NOT NULL DEFAULT 'day',
  "is_enabled" SMALLINT NOT NULL DEFAULT 1,
  "notify_email" SMALLINT NOT NULL DEFAULT 1,
  "notify_in_app" SMALLINT NOT NULL DEFAULT 1,
  "email_recipients" text DEFAULT NULL,
  "last_triggered_at" TIMESTAMP DEFAULT NULL,
  "last_value" float DEFAULT NULL,
  "trigger_count" INTEGER NOT NULL DEFAULT 0,
  "createdAt" TIMESTAMP NOT NULL,
  "updatedAt" TIMESTAMP NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "analytics"
--

CREATE TABLE "analytics" (
  "id" INTEGER NOT NULL,
  "user_uuid" varchar(255) DEFAULT NULL,
  "platform_page_Id" varchar(255) DEFAULT NULL,
  "platform" varchar(255) DEFAULT NULL,
  "analytic_type" varchar(255) DEFAULT NULL,
  "total_page_followers" BIGINT DEFAULT NULL,
  "total_page_impressions" BIGINT DEFAULT NULL,
  "total_page_impressions_unique" BIGINT DEFAULT NULL,
  "total_page_views" BIGINT DEFAULT NULL,
  "page_post_engagements" BIGINT DEFAULT NULL,
  "page_actions_post_reactions_like_total" BIGINT DEFAULT NULL,
  "week_date" varchar(255) DEFAULT NULL,
  "createdAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "updatedAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table "analytics"
--

INSERT INTO "analytics" ("id", "user_uuid", "platform_page_Id", "platform", "analytic_type", "total_page_followers", "total_page_impressions", "total_page_impressions_unique", "total_page_views", "page_post_engagements", "page_actions_post_reactions_like_total", "week_date", "createdAt", "updatedAt") VALUES
(7958, 'e5266555-8859-4f96-bab0-6596b9736d94', '101865419522213', 'facebook', 'page_daily_follows', 1, NULL, NULL, NULL, NULL, NULL, '2025-07-14T07:00:00+0000', '2025-10-10 11:43:20', '2025-10-10 11:43:20'),
(7959, 'e5266555-8859-4f96-bab0-6596b9736d94', '101865419522213', 'facebook', 'page_impressions', NULL, 2, NULL, NULL, NULL, NULL, '2025-07-14T07:00:00+0000', '2025-10-10 11:43:20', '2025-10-10 11:43:20'),
(7960, 'e5266555-8859-4f96-bab0-6596b9736d94', '101865419522213', 'facebook', 'page_impressions', NULL, 2, NULL, NULL, NULL, NULL, '2025-08-09T07:00:00+0000', '2025-10-10 11:43:20', '2025-10-10 11:43:20'),
(7961, 'e5266555-8859-4f96-bab0-6596b9736d94', '101865419522213', 'facebook', 'page_impressions', NULL, 5, NULL, NULL, NULL, NULL, '2025-08-26T07:00:00+0000', '2025-10-10 11:43:20', '2025-10-10 11:43:20'),
(7962, 'e5266555-8859-4f96-bab0-6596b9736d94', '101865419522213', 'facebook', 'page_impressions', NULL, 9, NULL, NULL, NULL, NULL, '2025-09-02T07:00:00+0000', '2025-10-10 11:43:20', '2025-10-10 11:43:20'),
(7963, 'e5266555-8859-4f96-bab0-6596b9736d94', '101865419522213', 'facebook', 'page_impressions', NULL, 1, NULL, NULL, NULL, NULL, '2025-09-03T07:00:00+0000', '2025-10-10 11:43:20', '2025-10-10 11:43:20'),
(7964, 'e5266555-8859-4f96-bab0-6596b9736d94', '101865419522213', 'facebook', 'page_impressions_unique', NULL, NULL, 1, NULL, NULL, NULL, '2025-07-14T07:00:00+0000', '2025-10-10 11:43:20', '2025-10-10 11:43:20'),
(7965, 'e5266555-8859-4f96-bab0-6596b9736d94', '101865419522213', 'facebook', 'page_impressions_unique', NULL, NULL, 1, NULL, NULL, NULL, '2025-08-09T07:00:00+0000', '2025-10-10 11:43:20', '2025-10-10 11:43:20'),
(7966, 'e5266555-8859-4f96-bab0-6596b9736d94', '101865419522213', 'facebook', 'page_impressions_unique', NULL, NULL, 1, NULL, NULL, NULL, '2025-08-26T07:00:00+0000', '2025-10-10 11:43:20', '2025-10-10 11:43:20'),
(7967, 'e5266555-8859-4f96-bab0-6596b9736d94', '101865419522213', 'facebook', 'page_impressions_unique', NULL, NULL, 2, NULL, NULL, NULL, '2025-09-02T07:00:00+0000', '2025-10-10 11:43:20', '2025-10-10 11:43:20'),
(7968, 'e5266555-8859-4f96-bab0-6596b9736d94', '101865419522213', 'facebook', 'page_impressions_unique', NULL, NULL, 1, NULL, NULL, NULL, '2025-09-03T07:00:00+0000', '2025-10-10 11:43:20', '2025-10-10 11:43:20'),
(7969, 'e5266555-8859-4f96-bab0-6596b9736d94', '101865419522213', 'facebook', 'page_views_total', NULL, NULL, NULL, 3, NULL, NULL, '2025-07-14T07:00:00+0000', '2025-10-10 11:43:20', '2025-10-10 11:43:20'),
(7970, 'e5266555-8859-4f96-bab0-6596b9736d94', '101865419522213', 'facebook', 'page_views_total', NULL, NULL, NULL, 3, NULL, NULL, '2025-08-09T07:00:00+0000', '2025-10-10 11:43:20', '2025-10-10 11:43:20'),
(7971, 'e5266555-8859-4f96-bab0-6596b9736d94', '108458993', 'linkedin', 'page_daily_follows', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-03T00:00:00.000Z', '2025-10-10 11:44:08', '2025-10-10 11:44:08'),
(7972, 'e5266555-8859-4f96-bab0-6596b9736d94', '108458993', 'linkedin', 'page_daily_follows', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-04T00:00:00.000Z', '2025-10-10 11:44:08', '2025-10-10 11:44:08'),
(7973, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_daily_follows', 1, NULL, NULL, NULL, NULL, NULL, '2025-07-16T00:00:00.000Z', '2025-10-10 11:44:09', '2025-10-10 11:44:09'),
(7974, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_daily_follows', -1, NULL, NULL, NULL, NULL, NULL, '2025-07-18T00:00:00.000Z', '2025-10-10 11:44:09', '2025-10-10 11:44:09'),
(7975, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_daily_follows', 1, NULL, NULL, NULL, NULL, NULL, '2025-07-26T00:00:00.000Z', '2025-10-10 11:44:09', '2025-10-10 11:44:09'),
(7976, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_daily_follows', 1, NULL, NULL, NULL, NULL, NULL, '2025-08-31T00:00:00.000Z', '2025-10-10 11:44:09', '2025-10-10 11:44:09'),
(7977, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_daily_follows', -1, NULL, NULL, NULL, NULL, NULL, '2025-09-11T00:00:00.000Z', '2025-10-10 11:44:09', '2025-10-10 11:44:09'),
(7978, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 1, NULL, NULL, NULL, NULL, '2025-07-12T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(7979, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 14, NULL, NULL, NULL, NULL, '2025-07-16T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(7980, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 1, NULL, NULL, NULL, NULL, '2025-07-17T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(7981, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 2, NULL, NULL, NULL, NULL, '2025-07-19T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(7982, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 1, NULL, NULL, NULL, NULL, '2025-07-23T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(7983, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 10, NULL, NULL, NULL, NULL, '2025-07-25T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(7984, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 2, NULL, NULL, NULL, NULL, '2025-07-29T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(7985, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 24, NULL, NULL, NULL, NULL, '2025-08-05T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(7986, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 1, NULL, NULL, NULL, NULL, '2025-08-13T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(7987, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 7, NULL, NULL, NULL, NULL, '2025-08-15T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(7988, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 8, NULL, NULL, NULL, NULL, '2025-08-16T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(7989, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 40, NULL, NULL, NULL, NULL, '2025-08-17T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(7990, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 22, NULL, NULL, NULL, NULL, '2025-08-18T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(7991, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 8, NULL, NULL, NULL, NULL, '2025-08-19T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(7992, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 5, NULL, NULL, NULL, NULL, '2025-08-20T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(7993, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 3, NULL, NULL, NULL, NULL, '2025-08-21T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(7994, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 1, NULL, NULL, NULL, NULL, '2025-08-23T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(7995, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 1, NULL, NULL, NULL, NULL, '2025-08-24T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(7996, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 6, NULL, NULL, NULL, NULL, '2025-08-26T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(7997, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 4, NULL, NULL, NULL, NULL, '2025-08-27T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(7998, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 1, NULL, NULL, NULL, NULL, '2025-08-28T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(7999, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 34, NULL, NULL, NULL, NULL, '2025-08-30T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(8000, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 3, NULL, NULL, NULL, NULL, '2025-08-31T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(8001, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 2, NULL, NULL, NULL, NULL, '2025-09-01T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(8002, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 10, NULL, NULL, NULL, NULL, '2025-09-02T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(8003, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 12, NULL, NULL, NULL, NULL, '2025-09-03T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(8004, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 8, NULL, NULL, NULL, NULL, '2025-09-05T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(8005, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 1, NULL, NULL, NULL, NULL, '2025-09-06T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(8006, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 1, NULL, NULL, NULL, NULL, '2025-09-07T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(8007, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 2, NULL, NULL, NULL, NULL, '2025-09-08T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(8008, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 18, NULL, NULL, NULL, NULL, '2025-09-09T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(8009, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 5, NULL, NULL, NULL, NULL, '2025-09-10T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(8010, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 2, NULL, NULL, NULL, NULL, '2025-09-11T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(8011, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 1, NULL, NULL, NULL, NULL, '2025-09-12T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(8012, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 2, NULL, NULL, NULL, NULL, '2025-09-15T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(8013, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 1, NULL, NULL, NULL, NULL, '2025-09-18T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(8014, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 14, NULL, NULL, NULL, NULL, '2025-09-19T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(8015, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 2, NULL, NULL, NULL, NULL, '2025-09-21T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(8016, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 1, NULL, NULL, NULL, NULL, '2025-09-22T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(8017, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 27, NULL, NULL, NULL, NULL, '2025-09-23T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(8018, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 51, NULL, NULL, NULL, NULL, '2025-09-24T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(8019, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 41, NULL, NULL, NULL, NULL, '2025-09-25T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(8020, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 109, NULL, NULL, NULL, NULL, '2025-09-26T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(8021, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 153, NULL, NULL, NULL, NULL, '2025-09-27T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(8022, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 16, NULL, NULL, NULL, NULL, '2025-09-28T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(8023, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 44, NULL, NULL, NULL, NULL, '2025-09-29T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(8024, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 29, NULL, NULL, NULL, NULL, '2025-09-30T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(8025, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 44, NULL, NULL, NULL, NULL, '2025-10-01T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(8026, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 115, NULL, NULL, NULL, NULL, '2025-10-02T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(8027, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 22, NULL, NULL, NULL, NULL, '2025-10-03T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(8028, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 43, NULL, NULL, NULL, NULL, '2025-10-04T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(8029, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 2, NULL, NULL, NULL, NULL, '2025-10-05T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(8030, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 2, NULL, NULL, NULL, NULL, '2025-10-06T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(8031, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 80, NULL, NULL, NULL, NULL, '2025-10-07T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(8032, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 7, NULL, NULL, NULL, NULL, '2025-10-08T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(8033, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 31, NULL, NULL, NULL, NULL, '2025-10-09T00:00:00.000Z', '2025-10-10 11:44:10', '2025-10-10 11:44:10'),
(8034, 'e5266555-8859-4f96-bab0-6596b9736d94', '108458993', 'linkedin', 'page_views_total', NULL, NULL, NULL, 3, NULL, NULL, '2025-09-03T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8035, 'e5266555-8859-4f96-bab0-6596b9736d94', '108458993', 'linkedin', 'page_views_total', NULL, NULL, NULL, 1, NULL, NULL, '2025-09-05T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8036, 'e5266555-8859-4f96-bab0-6596b9736d94', '108458993', 'linkedin', 'page_views_total', NULL, NULL, NULL, 1, NULL, NULL, '2025-09-11T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8037, 'e5266555-8859-4f96-bab0-6596b9736d94', '108458993', 'linkedin', 'page_views_total', NULL, NULL, NULL, 2, NULL, NULL, '2025-10-04T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8038, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 1, NULL, NULL, NULL, '2025-07-12T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8039, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 1, NULL, NULL, NULL, '2025-07-16T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8040, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 1, NULL, NULL, NULL, '2025-07-17T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8041, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 2, NULL, NULL, NULL, '2025-07-19T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8042, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 1, NULL, NULL, NULL, '2025-07-23T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8043, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 2, NULL, NULL, NULL, '2025-07-25T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8044, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 1, NULL, NULL, NULL, '2025-07-29T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8045, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 2, NULL, NULL, NULL, '2025-08-05T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8046, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 1, NULL, NULL, NULL, '2025-08-13T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8047, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 1, NULL, NULL, NULL, '2025-08-15T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8048, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 5, NULL, NULL, NULL, '2025-08-16T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8049, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 7, NULL, NULL, NULL, '2025-08-17T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8050, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 3, NULL, NULL, NULL, '2025-08-18T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8051, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 2, NULL, NULL, NULL, '2025-08-19T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8052, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 2, NULL, NULL, NULL, '2025-08-20T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8053, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 1, NULL, NULL, NULL, '2025-08-21T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8054, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 1, NULL, NULL, NULL, '2025-08-23T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8055, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 1, NULL, NULL, NULL, '2025-08-24T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8056, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 2, NULL, NULL, NULL, '2025-08-26T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8057, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 3, NULL, NULL, NULL, '2025-08-27T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8058, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 1, NULL, NULL, NULL, '2025-08-28T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8059, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 5, NULL, NULL, NULL, '2025-08-30T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8060, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 3, NULL, NULL, NULL, '2025-08-31T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8061, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 2, NULL, NULL, NULL, '2025-09-01T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8062, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 3, NULL, NULL, NULL, '2025-09-02T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8063, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 1, NULL, NULL, NULL, '2025-09-03T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8064, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 2, NULL, NULL, NULL, '2025-09-05T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8065, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 1, NULL, NULL, NULL, '2025-09-06T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8066, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 1, NULL, NULL, NULL, '2025-09-07T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8067, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 2, NULL, NULL, NULL, '2025-09-08T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8068, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 2, NULL, NULL, NULL, '2025-09-09T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8069, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 4, NULL, NULL, NULL, '2025-09-10T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8070, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 2, NULL, NULL, NULL, '2025-09-11T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8071, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 1, NULL, NULL, NULL, '2025-09-12T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8072, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 1, NULL, NULL, NULL, '2025-09-15T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8073, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 1, NULL, NULL, NULL, '2025-09-18T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8074, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 4, NULL, NULL, NULL, '2025-09-19T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8075, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 2, NULL, NULL, NULL, '2025-09-21T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8076, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 1, NULL, NULL, NULL, '2025-09-22T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8077, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 7, NULL, NULL, NULL, '2025-09-23T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8078, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 10, NULL, NULL, NULL, '2025-09-24T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8079, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 6, NULL, NULL, NULL, '2025-09-25T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8080, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 11, NULL, NULL, NULL, '2025-09-26T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8081, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 9, NULL, NULL, NULL, '2025-09-27T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8082, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 6, NULL, NULL, NULL, '2025-09-28T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8083, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 10, NULL, NULL, NULL, '2025-09-29T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8084, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 4, NULL, NULL, NULL, '2025-09-30T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8085, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 11, NULL, NULL, NULL, '2025-10-01T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8086, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 13, NULL, NULL, NULL, '2025-10-02T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8087, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 12, NULL, NULL, NULL, '2025-10-03T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8088, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 7, NULL, NULL, NULL, '2025-10-04T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8089, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 1, NULL, NULL, NULL, '2025-10-05T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8090, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 2, NULL, NULL, NULL, '2025-10-06T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8091, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 3, NULL, NULL, NULL, '2025-10-07T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8092, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 2, NULL, NULL, NULL, '2025-10-08T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8093, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 4, NULL, NULL, NULL, '2025-10-09T00:00:00.000Z', '2025-10-10 11:44:11', '2025-10-10 11:44:11'),
(8094, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_views_total', NULL, NULL, NULL, 2, NULL, NULL, '2025-07-16T00:00:00.000Z', '2025-10-10 11:44:12', '2025-10-10 11:44:12'),
(8095, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_views_total', NULL, NULL, NULL, 2, NULL, NULL, '2025-07-18T00:00:00.000Z', '2025-10-10 11:44:12', '2025-10-10 11:44:12'),
(8096, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_views_total', NULL, NULL, NULL, 1, NULL, NULL, '2025-07-19T00:00:00.000Z', '2025-10-10 11:44:12', '2025-10-10 11:44:12'),
(8097, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_views_total', NULL, NULL, NULL, 1, NULL, NULL, '2025-07-23T00:00:00.000Z', '2025-10-10 11:44:12', '2025-10-10 11:44:12'),
(8098, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_views_total', NULL, NULL, NULL, 7, NULL, NULL, '2025-07-25T00:00:00.000Z', '2025-10-10 11:44:12', '2025-10-10 11:44:12'),
(8099, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_views_total', NULL, NULL, NULL, 3, NULL, NULL, '2025-07-26T00:00:00.000Z', '2025-10-10 11:44:12', '2025-10-10 11:44:12'),
(8100, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_views_total', NULL, NULL, NULL, 2, NULL, NULL, '2025-07-29T00:00:00.000Z', '2025-10-10 11:44:12', '2025-10-10 11:44:12'),
(8101, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_views_total', NULL, NULL, NULL, 10, NULL, NULL, '2025-08-05T00:00:00.000Z', '2025-10-10 11:44:12', '2025-10-10 11:44:12'),
(8102, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_views_total', NULL, NULL, NULL, 1, NULL, NULL, '2025-08-06T00:00:00.000Z', '2025-10-10 11:44:12', '2025-10-10 11:44:12'),
(8103, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_views_total', NULL, NULL, NULL, 1, NULL, NULL, '2025-08-07T00:00:00.000Z', '2025-10-10 11:44:12', '2025-10-10 11:44:12'),
(8104, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_views_total', NULL, NULL, NULL, 1, NULL, NULL, '2025-08-12T00:00:00.000Z', '2025-10-10 11:44:12', '2025-10-10 11:44:12'),
(8105, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_views_total', NULL, NULL, NULL, 1, NULL, NULL, '2025-08-15T00:00:00.000Z', '2025-10-10 11:44:12', '2025-10-10 11:44:12'),
(8106, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_views_total', NULL, NULL, NULL, 1, NULL, NULL, '2025-08-20T00:00:00.000Z', '2025-10-10 11:44:12', '2025-10-10 11:44:12'),
(8107, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_views_total', NULL, NULL, NULL, 1, NULL, NULL, '2025-08-22T00:00:00.000Z', '2025-10-10 11:44:12', '2025-10-10 11:44:12'),
(8108, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_views_total', NULL, NULL, NULL, 3, NULL, NULL, '2025-08-31T00:00:00.000Z', '2025-10-10 11:44:12', '2025-10-10 11:44:12'),
(8109, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_views_total', NULL, NULL, NULL, 2, NULL, NULL, '2025-09-02T00:00:00.000Z', '2025-10-10 11:44:12', '2025-10-10 11:44:12'),
(8110, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_views_total', NULL, NULL, NULL, 1, NULL, NULL, '2025-09-04T00:00:00.000Z', '2025-10-10 11:44:12', '2025-10-10 11:44:12'),
(8111, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_views_total', NULL, NULL, NULL, 1, NULL, NULL, '2025-09-05T00:00:00.000Z', '2025-10-10 11:44:12', '2025-10-10 11:44:12'),
(8112, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_views_total', NULL, NULL, NULL, 4, NULL, NULL, '2025-09-09T00:00:00.000Z', '2025-10-10 11:44:12', '2025-10-10 11:44:12'),
(8113, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_views_total', NULL, NULL, NULL, 4, NULL, NULL, '2025-09-11T00:00:00.000Z', '2025-10-10 11:44:12', '2025-10-10 11:44:12'),
(8114, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_views_total', NULL, NULL, NULL, 4, NULL, NULL, '2025-09-17T00:00:00.000Z', '2025-10-10 11:44:12', '2025-10-10 11:44:12'),
(8115, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_views_total', NULL, NULL, NULL, 5, NULL, NULL, '2025-09-19T00:00:00.000Z', '2025-10-10 11:44:12', '2025-10-10 11:44:12'),
(8116, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_views_total', NULL, NULL, NULL, 2, NULL, NULL, '2025-09-25T00:00:00.000Z', '2025-10-10 11:44:12', '2025-10-10 11:44:12'),
(8117, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_views_total', NULL, NULL, NULL, 7, NULL, NULL, '2025-09-26T00:00:00.000Z', '2025-10-10 11:44:12', '2025-10-10 11:44:12'),
(8118, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_views_total', NULL, NULL, NULL, 4, NULL, NULL, '2025-09-27T00:00:00.000Z', '2025-10-10 11:44:12', '2025-10-10 11:44:12'),
(8119, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_views_total', NULL, NULL, NULL, 1, NULL, NULL, '2025-09-28T00:00:00.000Z', '2025-10-10 11:44:12', '2025-10-10 11:44:12'),
(8120, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_views_total', NULL, NULL, NULL, 4, NULL, NULL, '2025-09-29T00:00:00.000Z', '2025-10-10 11:44:12', '2025-10-10 11:44:12'),
(8121, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_views_total', NULL, NULL, NULL, 2, NULL, NULL, '2025-09-30T00:00:00.000Z', '2025-10-10 11:44:12', '2025-10-10 11:44:12'),
(8122, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_views_total', NULL, NULL, NULL, 6, NULL, NULL, '2025-10-01T00:00:00.000Z', '2025-10-10 11:44:12', '2025-10-10 11:44:12'),
(8123, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_views_total', NULL, NULL, NULL, 4, NULL, NULL, '2025-10-02T00:00:00.000Z', '2025-10-10 11:44:12', '2025-10-10 11:44:12'),
(8124, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_views_total', NULL, NULL, NULL, 2, NULL, NULL, '2025-10-04T00:00:00.000Z', '2025-10-10 11:44:12', '2025-10-10 11:44:12'),
(8125, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_views_total', NULL, NULL, NULL, 2, NULL, NULL, '2025-10-07T00:00:00.000Z', '2025-10-10 11:44:12', '2025-10-10 11:44:12'),
(8126, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_post_engagements', NULL, NULL, NULL, NULL, 0, NULL, '2025-07-16T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8127, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_post_engagements', NULL, NULL, NULL, NULL, 1, NULL, '2025-07-29T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8128, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_post_engagements', NULL, NULL, NULL, NULL, 0, NULL, '2025-08-05T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8129, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_post_engagements', NULL, NULL, NULL, NULL, 0, NULL, '2025-08-16T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8130, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_post_engagements', NULL, NULL, NULL, NULL, 0, NULL, '2025-08-17T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8131, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_post_engagements', NULL, NULL, NULL, NULL, 0, NULL, '2025-08-18T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8132, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_post_engagements', NULL, NULL, NULL, NULL, 0, NULL, '2025-08-19T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8133, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_post_engagements', NULL, NULL, NULL, NULL, 0, NULL, '2025-08-30T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8134, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_post_engagements', NULL, NULL, NULL, NULL, 0, NULL, '2025-09-03T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8135, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_post_engagements', NULL, NULL, NULL, NULL, 0, NULL, '2025-09-23T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8136, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_post_engagements', NULL, NULL, NULL, NULL, 0, NULL, '2025-09-24T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8137, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_post_engagements', NULL, NULL, NULL, NULL, 0, NULL, '2025-09-25T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8138, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_post_engagements', NULL, NULL, NULL, NULL, 0, NULL, '2025-09-26T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8139, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_post_engagements', NULL, NULL, NULL, NULL, 0, NULL, '2025-09-27T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8140, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_post_engagements', NULL, NULL, NULL, NULL, 0, NULL, '2025-09-28T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8141, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_post_engagements', NULL, NULL, NULL, NULL, 1, NULL, '2025-09-29T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8142, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_post_engagements', NULL, NULL, NULL, NULL, 1, NULL, '2025-09-30T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8143, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_post_engagements', NULL, NULL, NULL, NULL, 0, NULL, '2025-10-01T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8144, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_post_engagements', NULL, NULL, NULL, NULL, 0, NULL, '2025-10-02T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8145, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_post_engagements', NULL, NULL, NULL, NULL, 0, NULL, '2025-10-03T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8146, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_post_engagements', NULL, NULL, NULL, NULL, 0, NULL, '2025-10-04T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8147, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_post_engagements', NULL, NULL, NULL, NULL, 0, NULL, '2025-10-08T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8148, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_post_engagements', NULL, NULL, NULL, NULL, 0, NULL, '2025-10-09T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8149, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_actions_post_reactions_like_total', NULL, NULL, NULL, NULL, NULL, 1, '2025-08-16T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8150, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_actions_post_reactions_like_total', NULL, NULL, NULL, NULL, NULL, 1, '2025-08-17T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8151, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_actions_post_reactions_like_total', NULL, NULL, NULL, NULL, NULL, 1, '2025-08-19T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8152, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_actions_post_reactions_like_total', NULL, NULL, NULL, NULL, NULL, 1, '2025-09-03T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8153, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_actions_post_reactions_like_total', NULL, NULL, NULL, NULL, NULL, 4, '2025-09-24T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8154, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_actions_post_reactions_like_total', NULL, NULL, NULL, NULL, NULL, 4, '2025-09-25T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8155, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_actions_post_reactions_like_total', NULL, NULL, NULL, NULL, NULL, 13, '2025-09-26T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8156, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_actions_post_reactions_like_total', NULL, NULL, NULL, NULL, NULL, 6, '2025-09-27T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8157, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_actions_post_reactions_like_total', NULL, NULL, NULL, NULL, NULL, 2, '2025-09-28T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8158, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_actions_post_reactions_like_total', NULL, NULL, NULL, NULL, NULL, 2, '2025-09-29T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8159, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_actions_post_reactions_like_total', NULL, NULL, NULL, NULL, NULL, 2, '2025-10-01T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8160, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_actions_post_reactions_like_total', NULL, NULL, NULL, NULL, NULL, 16, '2025-10-02T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8161, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_actions_post_reactions_like_total', NULL, NULL, NULL, NULL, NULL, 2, '2025-10-03T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8162, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_actions_post_reactions_like_total', NULL, NULL, NULL, NULL, NULL, 4, '2025-10-04T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8163, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_actions_post_reactions_like_total', NULL, NULL, NULL, NULL, NULL, 1, '2025-10-08T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8164, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_actions_post_reactions_like_total', NULL, NULL, NULL, NULL, NULL, 7, '2025-10-09T00:00:00.000Z', '2025-10-10 11:44:13', '2025-10-10 11:44:13'),
(8940, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_daily_follows', -1, NULL, NULL, NULL, NULL, NULL, '2025-10-12T00:00:00.000Z', '2025-10-22 09:26:09', '2025-10-22 09:26:09'),
(8941, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_daily_follows', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15T00:00:00.000Z', '2025-10-22 09:26:09', '2025-10-22 09:26:09'),
(8942, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 7, NULL, NULL, NULL, NULL, '2025-10-10T00:00:00.000Z', '2025-10-22 09:26:10', '2025-10-22 09:26:10'),
(8943, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 6, NULL, NULL, NULL, NULL, '2025-10-11T00:00:00.000Z', '2025-10-22 09:26:10', '2025-10-22 09:26:10'),
(8944, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 1, NULL, NULL, NULL, NULL, '2025-10-12T00:00:00.000Z', '2025-10-22 09:26:10', '2025-10-22 09:26:10'),
(8945, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 16, NULL, NULL, NULL, NULL, '2025-10-13T00:00:00.000Z', '2025-10-22 09:26:10', '2025-10-22 09:26:10'),
(8946, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 4, NULL, NULL, NULL, NULL, '2025-10-14T00:00:00.000Z', '2025-10-22 09:26:10', '2025-10-22 09:26:10'),
(8947, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 40, NULL, NULL, NULL, NULL, '2025-10-15T00:00:00.000Z', '2025-10-22 09:26:10', '2025-10-22 09:26:10'),
(8948, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 11, NULL, NULL, NULL, NULL, '2025-10-16T00:00:00.000Z', '2025-10-22 09:26:10', '2025-10-22 09:26:10'),
(8949, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 12, NULL, NULL, NULL, NULL, '2025-10-17T00:00:00.000Z', '2025-10-22 09:26:10', '2025-10-22 09:26:10'),
(8950, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 26, NULL, NULL, NULL, NULL, '2025-10-18T00:00:00.000Z', '2025-10-22 09:26:10', '2025-10-22 09:26:10'),
(8951, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 1, NULL, NULL, NULL, NULL, '2025-10-20T00:00:00.000Z', '2025-10-22 09:26:10', '2025-10-22 09:26:10'),
(8952, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions', NULL, 2, NULL, NULL, NULL, NULL, '2025-10-21T00:00:00.000Z', '2025-10-22 09:26:10', '2025-10-22 09:26:10'),
(8953, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 5, NULL, NULL, NULL, '2025-10-10T00:00:00.000Z', '2025-10-22 09:26:11', '2025-10-22 09:26:11'),
(8954, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 2, NULL, NULL, NULL, '2025-10-11T00:00:00.000Z', '2025-10-22 09:26:11', '2025-10-22 09:26:11'),
(8955, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 1, NULL, NULL, NULL, '2025-10-12T00:00:00.000Z', '2025-10-22 09:26:11', '2025-10-22 09:26:11'),
(8956, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 3, NULL, NULL, NULL, '2025-10-13T00:00:00.000Z', '2025-10-22 09:26:11', '2025-10-22 09:26:11'),
(8957, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 2, NULL, NULL, NULL, '2025-10-14T00:00:00.000Z', '2025-10-22 09:26:11', '2025-10-22 09:26:11'),
(8958, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 10, NULL, NULL, NULL, '2025-10-15T00:00:00.000Z', '2025-10-22 09:26:11', '2025-10-22 09:26:11'),
(8959, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 5, NULL, NULL, NULL, '2025-10-16T00:00:00.000Z', '2025-10-22 09:26:11', '2025-10-22 09:26:11'),
(8960, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 4, NULL, NULL, NULL, '2025-10-17T00:00:00.000Z', '2025-10-22 09:26:11', '2025-10-22 09:26:11'),
(8961, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 2, NULL, NULL, NULL, '2025-10-18T00:00:00.000Z', '2025-10-22 09:26:11', '2025-10-22 09:26:11'),
(8962, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 1, NULL, NULL, NULL, '2025-10-20T00:00:00.000Z', '2025-10-22 09:26:11', '2025-10-22 09:26:11'),
(8963, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_impressions_unique', NULL, NULL, 1, NULL, NULL, NULL, '2025-10-21T00:00:00.000Z', '2025-10-22 09:26:11', '2025-10-22 09:26:11'),
(8964, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_views_total', NULL, NULL, NULL, 1, NULL, NULL, '2025-10-11T00:00:00.000Z', '2025-10-22 09:26:12', '2025-10-22 09:26:12'),
(8965, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_views_total', NULL, NULL, NULL, 1, NULL, NULL, '2025-10-13T00:00:00.000Z', '2025-10-22 09:26:12', '2025-10-22 09:26:12'),
(8966, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_views_total', NULL, NULL, NULL, 1, NULL, NULL, '2025-10-15T00:00:00.000Z', '2025-10-22 09:26:12', '2025-10-22 09:26:12'),
(8967, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_post_engagements', NULL, NULL, NULL, NULL, 0, NULL, '2025-10-15T00:00:00.000Z', '2025-10-22 09:26:12', '2025-10-22 09:26:12'),
(8968, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_post_engagements', NULL, NULL, NULL, NULL, 0, NULL, '2025-10-16T00:00:00.000Z', '2025-10-22 09:26:12', '2025-10-22 09:26:12'),
(8969, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_post_engagements', NULL, NULL, NULL, NULL, 0, NULL, '2025-10-17T00:00:00.000Z', '2025-10-22 09:26:12', '2025-10-22 09:26:12'),
(8970, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_post_engagements', NULL, NULL, NULL, NULL, 1, NULL, '2025-10-21T00:00:00.000Z', '2025-10-22 09:26:12', '2025-10-22 09:26:12'),
(8971, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_actions_post_reactions_like_total', NULL, NULL, NULL, NULL, NULL, 1, '2025-10-15T00:00:00.000Z', '2025-10-22 09:26:13', '2025-10-22 09:26:13'),
(8972, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_actions_post_reactions_like_total', NULL, NULL, NULL, NULL, NULL, 1, '2025-10-16T00:00:00.000Z', '2025-10-22 09:26:13', '2025-10-22 09:26:13'),
(8973, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_actions_post_reactions_like_total', NULL, NULL, NULL, NULL, NULL, 1, '2025-10-17T00:00:00.000Z', '2025-10-22 09:26:13', '2025-10-22 09:26:13'),
(8974, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'linkedin', 'page_actions_post_reactions_like_total', NULL, NULL, NULL, NULL, NULL, 1, '2025-10-21T00:00:00.000Z', '2025-10-22 09:26:13', '2025-10-22 09:26:13');

-- --------------------------------------------------------

--
-- Table structure for table "billing_activity_logs"
--

CREATE TABLE "billing_activity_logs" (
  "id" INTEGER NOT NULL,
  "user_uuid" varchar(255) DEFAULT NULL ,
  "subscription_id" INTEGER DEFAULT NULL ,
  "transaction_id" INTEGER DEFAULT NULL ,
  "action_type" VARCHAR(255) NOT NULL ,
  "action_status" VARCHAR(255) NOT NULL DEFAULT 'success' ,
  "actor_type" VARCHAR(255) NOT NULL DEFAULT 'system' ,
  "actor_id" varchar(255) DEFAULT NULL ,
  "actor_email" varchar(255) DEFAULT NULL ,
  "old_value" TEXT  DEFAULT NULL  ,
  "new_value" TEXT  DEFAULT NULL  ,
  "amount" INTEGER DEFAULT NULL ,
  "currency" varchar(3) DEFAULT NULL ,
  "stripe_event_id" varchar(255) DEFAULT NULL ,
  "stripe_object_id" varchar(255) DEFAULT NULL ,
  "error_code" varchar(100) DEFAULT NULL ,
  "error_message" text DEFAULT NULL ,
  "description" text DEFAULT NULL ,
  "notes" text DEFAULT NULL ,
  "ip_address" varchar(45) DEFAULT NULL ,
  "user_agent" text DEFAULT NULL ,
  "request_id" varchar(255) DEFAULT NULL ,
  "metadata" TEXT  DEFAULT NULL  ,
  "createdAt" TIMESTAMP NOT NULL,
  "updatedAt" TIMESTAMP NOT NULL
);

--
-- Dumping data for table "billing_activity_logs"
--

INSERT INTO "billing_activity_logs" ("id", "user_uuid", "subscription_id", "transaction_id", "action_type", "action_status", "actor_type", "actor_id", "actor_email", "old_value", "new_value", "amount", "currency", "stripe_event_id", "stripe_object_id", "error_code", "error_message", "description", "notes", "ip_address", "user_agent", "request_id", "metadata", "createdAt", "updatedAt") VALUES
(1, '9e47ed0e-73f7-41d5-9dac-5c37b8df8a4f', NULL, NULL, 'card_added', 'success', 'stripe', NULL, NULL, NULL, '{"brand":"visa","last4":"1111"}', NULL, NULL, 'evt_1Sc8r6HpVJPrOqLkBYk1cmjl', 'pm_1Sc8r5HpVJPrOqLkGD0xuD2V', NULL, NULL, 'Payment method added: visa ending in 1111', NULL, NULL, NULL, NULL, NULL, '2025-12-08 18:08:18', '2025-12-08 18:08:18'),
(2, '9e47ed0e-73f7-41d5-9dac-5c37b8df8a4f', 1, NULL, 'subscription_created', 'success', 'user', NULL, NULL, NULL, '{"plan_id":3,"status":"active","trial_end":null}', NULL, NULL, NULL, 'sub_1Sc8r8HpVJPrOqLkX4hZp1K4', NULL, NULL, 'New subscription created for plan Agency', NULL, NULL, NULL, NULL, NULL, '2025-12-08 18:08:29', '2025-12-08 18:08:29'),
(3, '9e47ed0e-73f7-41d5-9dac-5c37b8df8a4f', 1, NULL, 'payment_succeeded', 'success', 'stripe', NULL, NULL, NULL, NULL, 9900, 'usd', 'evt_1Sc8rCHpVJPrOqLkc1IKjRiF', 'in_1Sc8r8HpVJPrOqLkqss6grEV', NULL, NULL, 'Payment of 99 USD succeeded for invoice FVJFOQBG-0001', NULL, NULL, NULL, NULL, NULL, '2025-12-08 18:08:26', '2025-12-08 18:08:26'),
(4, '6f4362d5-744c-446e-8108-8db805396e51', NULL, NULL, 'card_added', 'success', 'stripe', NULL, NULL, NULL, '{"brand":"visa","last4":"1111"}', NULL, NULL, 'evt_1Sc9R4HpVJPrOqLkYWKeHO7b', 'pm_1Sc9R4HpVJPrOqLkOXnfcKFb', NULL, NULL, 'Payment method added: visa ending in 1111', NULL, NULL, NULL, NULL, NULL, '2025-12-08 18:45:29', '2025-12-08 18:45:29'),
(5, '6f4362d5-744c-446e-8108-8db805396e51', 2, NULL, 'subscription_created', 'success', 'user', NULL, NULL, NULL, '{"plan_id":1,"status":"trialing","trial_end":"2025-12-09T18:45:27.000Z"}', NULL, NULL, NULL, 'sub_1Sc9R5HpVJPrOqLkPt4sV5R5', NULL, NULL, 'New subscription created for plan Starter', NULL, NULL, NULL, NULL, NULL, '2025-12-08 18:45:29', '2025-12-08 18:45:29'),
(6, '6f4362d5-744c-446e-8108-8db805396e51', 2, NULL, 'payment_succeeded', 'success', 'stripe', NULL, NULL, NULL, NULL, 0, 'usd', 'evt_1Sc9R7HpVJPrOqLk1VlxsWJe', 'in_1Sc9R5HpVJPrOqLkM1DKHuY9', NULL, NULL, 'Payment of 0 USD succeeded for invoice ITYFUTSR-0001', NULL, NULL, NULL, NULL, NULL, '2025-12-08 18:45:33', '2025-12-08 18:45:33'),
(7, '9e47ed0e-73f7-41d5-9dac-5c37b8df8a4f', NULL, NULL, 'admin_action', 'success', 'user', '9e47ed0e-73f7-41d5-9dac-5c37b8df8a4f', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'User accessed Stripe Customer Portal', NULL, NULL, NULL, NULL, NULL, '2025-12-08 19:51:28', '2025-12-08 19:51:28'),
(8, '9e47ed0e-73f7-41d5-9dac-5c37b8df8a4f', NULL, NULL, 'admin_action', 'success', 'user', '9e47ed0e-73f7-41d5-9dac-5c37b8df8a4f', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'User accessed Stripe Customer Portal', NULL, NULL, NULL, NULL, NULL, '2025-12-08 20:02:11', '2025-12-08 20:02:11');

-- --------------------------------------------------------

--
-- Table structure for table "billing_notifications"
--

CREATE TABLE "billing_notifications" (
  "id" INTEGER NOT NULL,
  "user_uuid" varchar(255) NOT NULL ,
  "subscription_id" INTEGER DEFAULT NULL ,
  "transaction_id" INTEGER DEFAULT NULL ,
  "notification_type" VARCHAR(255) NOT NULL ,
  "channel" VARCHAR(255) NOT NULL DEFAULT 'email' ,
  "priority" VARCHAR(255) NOT NULL DEFAULT 'normal' ,
  "status" VARCHAR(255) NOT NULL DEFAULT 'pending' ,
  "recipient_email" varchar(255) DEFAULT NULL ,
  "recipient_phone" varchar(50) DEFAULT NULL ,
  "subject" varchar(500) DEFAULT NULL ,
  "template_name" varchar(100) DEFAULT NULL ,
  "template_data" TEXT  DEFAULT NULL  ,
  "content" text DEFAULT NULL ,
  "scheduled_at" TIMESTAMP NOT NULL ,
  "sent_at" TIMESTAMP DEFAULT NULL ,
  "delivered_at" TIMESTAMP DEFAULT NULL ,
  "opened_at" TIMESTAMP DEFAULT NULL ,
  "clicked_at" TIMESTAMP DEFAULT NULL ,
  "retry_count" INTEGER NOT NULL DEFAULT 0 ,
  "max_retries" INTEGER NOT NULL DEFAULT 3 ,
  "last_error" text DEFAULT NULL ,
  "external_id" varchar(255) DEFAULT NULL ,
  "metadata" TEXT  DEFAULT NULL  ,
  "createdAt" TIMESTAMP NOT NULL,
  "updatedAt" TIMESTAMP NOT NULL
);

--
-- Dumping data for table "billing_notifications"
--

INSERT INTO "billing_notifications" ("id", "user_uuid", "subscription_id", "transaction_id", "notification_type", "channel", "priority", "status", "recipient_email", "recipient_phone", "subject", "template_name", "template_data", "content", "scheduled_at", "sent_at", "delivered_at", "opened_at", "clicked_at", "retry_count", "max_retries", "last_error", "external_id", "metadata", "createdAt", "updatedAt") VALUES
(1, '6f4362d5-744c-446e-8108-8db805396e51', 2, NULL, 'trial_ending_1h', 'email', 'urgent', 'pending', 'developerw0945@gmail.com', NULL, 'Your trial ends in 1 hour', 'trial_ending_1h', '{"firstName":"Baljeet","planName":"Starter","trialEndDate":"2025-12-09T18:45:27.000Z"}', NULL, '2025-12-09 17:45:27', NULL, NULL, NULL, NULL, 0, 3, NULL, NULL, NULL, '2025-12-08 18:45:29', '2025-12-08 18:45:29');

-- --------------------------------------------------------

--
-- Table structure for table "campaigns"
--

CREATE TABLE "campaigns" (
  "id" INTEGER NOT NULL,
  "user_uuid" varchar(255) DEFAULT NULL,
  "account_platform" varchar(255) DEFAULT NULL,
  "account_social_userid" BIGINT DEFAULT NULL,
  "ad_account_id" BIGINT DEFAULT NULL,
  "campaign_id" varchar(255) DEFAULT NULL,
  "campaign_name" varchar(255) DEFAULT NULL,
  "campaign_category" varchar(255) DEFAULT NULL,
  "campaign_bid_strategy" varchar(255) DEFAULT NULL,
  "campaign_buying_type" varchar(255) DEFAULT NULL,
  "campaign_objective" varchar(255) DEFAULT NULL,
  "campaign_budget_remaining" varchar(255) DEFAULT NULL,
  "campaign_daily_budget" varchar(255) DEFAULT NULL,
  "campaign_lifetime_budget" varchar(255) DEFAULT NULL,
  "campaign_effective_status" varchar(255) DEFAULT NULL,
  "campaign_start_time" TIMESTAMP DEFAULT NULL,
  "campaign_end_time" TIMESTAMP DEFAULT NULL,
  "campaign_status" varchar(255) DEFAULT NULL,
  "campaign_insights_clicks" BIGINT DEFAULT NULL,
  "campaign_insights_cpc" varchar(255) DEFAULT NULL,
  "campaign_insights_cpm" varchar(255) DEFAULT NULL,
  "campaign_insights_cpp" varchar(255) DEFAULT NULL,
  "campaign_insights_ctr" varchar(255) DEFAULT NULL,
  "campaign_insights_date_start" date DEFAULT NULL,
  "campaign_insights_date_stop" date DEFAULT NULL,
  "campaign_insights_impressions" varchar(255) DEFAULT NULL,
  "campaign_insights_spend" varchar(255) DEFAULT NULL,
  "campaign_insights_reach" INTEGER DEFAULT NULL,
  "campaign_insights_results" float DEFAULT NULL,
  "campaign_result_type" varchar(255) DEFAULT NULL,
  "campaign_insights_cost_per_result" float DEFAULT NULL,
  "campaign_insights_actions" TEXT  DEFAULT NULL ,
  "createdAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "updatedAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- --------------------------------------------------------

--
-- Table structure for table "compliance_policies"
--

CREATE TABLE "compliance_policies" (
  "id" BIGINT NOT NULL,
  "policy_type" VARCHAR(255) NOT NULL,
  "content" TEXT NOT NULL,
  "version" varchar(255) NOT NULL DEFAULT '1.0',
  "effective_date" date NOT NULL,
  "active" SMALLINT NOT NULL DEFAULT 1,
  "updated_by" BIGINT DEFAULT NULL,
  "created_at" timestamp NULL DEFAULT NULL,
  "updated_at" timestamp NULL DEFAULT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "data_requests"
--

CREATE TABLE "data_requests" (
  "id" BIGINT NOT NULL,
  "user_uuid" varchar(255) NOT NULL,
  "user_email" varchar(255) NOT NULL,
  "request_type" VARCHAR(255) NOT NULL DEFAULT 'export',
  "status" VARCHAR(255) NOT NULL DEFAULT 'pending',
  "notes" text DEFAULT NULL,
  "completed_at" timestamp NULL DEFAULT NULL,
  "processed_by" BIGINT DEFAULT NULL,
  "created_at" timestamp NULL DEFAULT NULL,
  "updated_at" timestamp NULL DEFAULT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "data_retention_rules"
--

CREATE TABLE "data_retention_rules" (
  "id" BIGINT NOT NULL,
  "data_type" varchar(255) NOT NULL,
  "retention_days" INTEGER NOT NULL,
  "auto_delete" SMALLINT NOT NULL DEFAULT 0,
  "last_cleanup_at" timestamp NULL DEFAULT NULL,
  "active" SMALLINT NOT NULL DEFAULT 1,
  "created_at" timestamp NULL DEFAULT NULL,
  "updated_at" timestamp NULL DEFAULT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "demographics"
--

CREATE TABLE "demographics" (
  "id" INTEGER NOT NULL,
  "user_uuid" varchar(255) NOT NULL,
  "platform_page_Id" varchar(255) NOT NULL,
  "page_name" varchar(255) NOT NULL,
  "social_userid" varchar(255) NOT NULL,
  "platform" VARCHAR(255) NOT NULL DEFAULT 'NA',
  "metric_type" varchar(200) DEFAULT NULL,
  "metric_key" varchar(250) DEFAULT NULL,
  "metric_value" INTEGER NOT NULL DEFAULT 0,
  "source" VARCHAR(255) NOT NULL DEFAULT 'NA',
  "createdAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "updatedAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table "demographics"
--

INSERT INTO "demographics" ("id", "user_uuid", "platform_page_Id", "page_name", "social_userid", "platform", "metric_type", "metric_key", "metric_value", "source", "createdAt", "updatedAt") VALUES
(2322, 'e5266555-8859-4f96-bab0-6596b9736d94', '108458993', 'insocialwise.com', 'eRLsKrw_6N', 'linkedin', 'industry', 'Software Development', 2, 'API', '2025-10-22 09:26:59', '2025-10-22 09:26:59'),
(2323, 'e5266555-8859-4f96-bab0-6596b9736d94', '108458993', 'insocialwise.com', 'eRLsKrw_6N', 'linkedin', 'geo', 'INDIA', 2, 'API', '2025-10-22 09:26:59', '2025-10-22 09:26:59'),
(2324, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'IT Services and IT Consulting', 170, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2325, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Advertising Services', 74, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2326, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Software Development', 72, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2327, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'IT System Custom Software Development', 46, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2328, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Marketing Services', 44, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2329, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Technology, Information and Internet', 42, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2330, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Business Consulting and Services', 32, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2331, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Higher Education', 18, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2332, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Graphic Design', 13, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2333, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Internet Publishing', 11, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2334, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Financial Services', 10, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2335, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Real Estate', 9, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2336, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Wellness and Fitness Services', 9, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2337, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Hospitals and Health Care', 8, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2338, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Education', 7, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2339, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Outsourcing and Offshoring Consulting', 7, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2340, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Staffing and Recruiting', 6, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2341, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Information Services', 6, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2342, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Education Administration Programs', 6, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2343, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Research Services', 6, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2344, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'E-Learning Providers', 6, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2345, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Mining', 5, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2346, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Investment Management', 5, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2347, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Accounting', 5, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2348, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Construction', 5, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2349, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Travel Arrangements', 5, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2350, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Professional Training and Coaching', 5, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2351, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Retail', 5, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2352, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Retail Apparel and Fashion', 5, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2353, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Computer Networking Products', 5, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2354, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Banking', 4, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2355, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Non-profit Organizations', 4, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2356, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Medical Practices', 4, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2357, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Internet Marketplace Platforms', 4, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2358, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Media Production', 4, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2359, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Hospitality', 4, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2360, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Mobile Gaming Apps', 3, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2361, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Legal Services', 3, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2362, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Consumer Services', 3, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2363, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Manufacturing', 3, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2364, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Telecommunications', 3, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2365, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Personal Care Product Manufacturing', 3, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2366, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Market Research', 3, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2367, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Airlines and Aviation', 3, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2368, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Insurance', 3, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2369, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Events Services', 3, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2370, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'IT System Testing and Evaluation', 3, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2371, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Food and Beverage Services', 3, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2372, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Restaurants', 3, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2373, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Business Intelligence Platforms', 2, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2374, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Biotechnology Research', 2, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2375, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Social Networking Platforms', 2, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2376, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Motor Vehicle Manufacturing', 2, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2377, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Food and Beverage Manufacturing', 2, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2378, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Writing and Editing', 2, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2379, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Design Services', 2, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2380, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Public Relations and Communications Services', 2, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2381, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Telecommunications Carriers', 2, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2382, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Translation and Localization', 2, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2383, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Truck Transportation', 2, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2384, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Individual and Family Services', 2, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2385, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Engineering Services', 2, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2386, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Retail Luxury Goods and Jewelry', 2, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2387, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Digital Accessibility Services', 2, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2388, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Solar Electric Power Generation', 2, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2389, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Book and Periodical Publishing', 2, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2390, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Hospitals', 2, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2391, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Pharmaceutical Manufacturing', 2, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2392, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Human Resources Services', 2, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2393, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'IT System Training and Support', 2, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2394, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Primary and Secondary Education', 2, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2395, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Computer and Network Security', 2, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2396, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Online Audio and Video Media', 2, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2397, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'IT System Design Services', 2, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2398, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Transportation, Logistics, Supply Chain and Storage', 2, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2399, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Broadcast Media Production and Distribution', 2, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2400, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Retail Office Equipment', 2, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2401, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Food and Beverage Retail', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2402, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Technology, Information and Media', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2403, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Oil and Gas', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2404, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Business Content', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2405, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Furniture and Home Furnishings Manufacturing', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2406, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Machinery Manufacturing', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2407, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Public Health', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2408, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Appliances, Electrical, and Electronics Manufacturing', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2409, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Computers and Electronics Manufacturing', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2410, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Internet News', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2411, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Civil Engineering', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2412, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Cable and Satellite Programming', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2413, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Architecture and Planning', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2414, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Fashion Accessories Manufacturing', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2415, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Wholesale Building Materials', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2416, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Strategic Management Services', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2417, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Radio and Television Broadcasting', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2418, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Maritime Transportation', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2419, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Motor Vehicle Parts Manufacturing', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2420, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Law Practice', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2421, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Civic and Social Organizations', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2422, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Professional Services', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2423, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'industry', 'Computer Games', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2424, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'geo', 'INDIA', 736, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2425, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'geo', 'UNITED STATES', 35, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2426, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'geo', 'UNITED ARAB EMIRATES', 13, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2427, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'geo', 'UNITED KINGDOM', 12, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2428, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'geo', 'PAKISTAN', 8, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2429, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'geo', 'EGYPT', 6, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2430, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'geo', 'NIGERIA', 5, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2431, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'geo', 'BANGLADESH', 4, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2432, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'geo', 'CANADA', 3, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2433, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'geo', 'FRANCE', 2, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2434, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'geo', 'PHILIPPINES', 2, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2435, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'geo', 'AUSTRALIA', 2, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2436, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'geo', 'ARGENTINA', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2437, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'geo', 'LEBANON', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2438, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'geo', 'TÜRKIYE', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2439, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'geo', 'MALAWI', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2440, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'geo', 'GHANA', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2441, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'geo', 'INDONESIA', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2442, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'geo', 'ECUADOR', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2443, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'geo', 'MALAYSIA', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2444, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'geo', 'SUDAN', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2445, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'geo', 'VENEZUELA', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2446, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'geo', 'GERMANY', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2447, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'geo', 'CAMBODIA', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2448, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'geo', 'TUNISIA', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11'),
(2449, 'e5266555-8859-4f96-bab0-6596b9736d94', '75609893', 'Aronasoft', 'eRLsKrw_6N', 'linkedin', 'geo', 'LITHUANIA', 1, 'API', '2025-10-22 09:29:11', '2025-10-22 09:29:11');

-- --------------------------------------------------------

--
-- Table structure for table "inbox_conversations"
--

CREATE TABLE "inbox_conversations" (
  "id" INTEGER NOT NULL,
  "user_uuid" varchar(250) NOT NULL,
  "social_userid" varchar(200) NOT NULL,
  "social_pageid" varchar(250) NOT NULL,
  "social_platform" VARCHAR(255) NOT NULL DEFAULT 'NA',
  "conversation_id" varchar(200) NOT NULL,
  "external_userid" varchar(200) NOT NULL,
  "external_username" varchar(200) DEFAULT NULL,
  "external_userImg" varchar(250) DEFAULT NULL,
  "snippet" varchar(250) NOT NULL,
  "status" VARCHAR(255) NOT NULL DEFAULT 'InActive',
  "createdAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "updatedAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table "inbox_conversations"
--

INSERT INTO "inbox_conversations" ("id", "user_uuid", "social_userid", "social_pageid", "social_platform", "conversation_id", "external_userid", "external_username", "external_userImg", "snippet", "status", "createdAt", "updatedAt") VALUES
(268, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', 't_122157012044577012', '10067541213280817', 'Ross Singh', NULL, 'hello admin user', 'Active', '2025-12-04 10:18:12', '2025-12-04 10:18:12'),
(269, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', 't_3910484659264407', '30023231430625587', 'Manjeet Singh', NULL, 'Hi', 'Active', '2025-12-04 12:50:27', '2025-12-04 12:50:27'),
(270, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', 't_122146872602860722', '25374944125442357', 'Abhi Massey', NULL, 'Abhi bumped their message', 'Active', '2025-12-04 12:50:54', '2025-12-04 12:50:54'),
(271, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', 't_4434236870195991', '9825514350861008', 'Andy Mehra', NULL, 'Hello! How can I help you today?', 'Active', '2025-12-04 12:51:08', '2025-12-04 12:51:08'),
(272, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', 't_1892630394834228', '30911796315085868', 'Manjeet Pawar', NULL, 'Fine', 'Active', '2025-12-04 12:51:35', '2025-12-04 12:51:35'),
(273, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', 't_24102016736093261', '30872767489038145', 'Facebook user', NULL, '𝗣𝗹𝗲𝗮𝘀𝗲 𝗿𝗲𝗳𝗲𝗿 𝘁𝗼 𝘁𝗵𝗲 𝗽𝗿𝗶𝘃𝗮𝗰𝘆 𝗽𝗼𝗹𝗶𝗰𝘆 𝗮𝘁: 🔗 https://transparency.meta.com/enforcement/detecting-violations/   𝗧𝗼 𝗰𝗼𝗻𝘁𝗶𝗻𝘂𝗲 𝘂𝘀𝗶𝗻𝗴 𝘁𝗵𝗲 𝗳𝘂𝗹𝗹 𝗳𝘂𝗻𝗰𝘁𝗶𝗼𝗻𝘀, 𝗽𝗹𝗲𝗮𝘀𝗲 𝘃𝗶𝘀𝗶𝘁 𝗮𝗻𝗱 𝘃𝗲𝗿𝗶𝗳𝘆 𝗮𝘁 𝘁𝗵𝗲 𝗳𝗼𝗹𝗹𝗼𝘄𝗶𝗻𝗴 𝗹𝗶𝗻𝗸: https://manager-chaneup8237.site/verify?Community-Standard', 'Active', '2025-12-04 12:52:02', '2025-12-04 12:52:02'),
(274, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', 't_2804302883292635', '9043735502401398', 'Aronasoft Singh', NULL, 'Hello! How can I assist you today with our pet waste removal services?', 'Active', '2025-12-04 12:52:06', '2025-12-04 12:52:06'),
(275, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', 't_24093556453615214', '24218504404439439', 'Sudhir Kundal', NULL, 'I amnfine', 'Active', '2025-12-04 12:52:17', '2025-12-04 12:52:17');

-- --------------------------------------------------------

--
-- Table structure for table "inbox_messages"
--

CREATE TABLE "inbox_messages" (
  "id" INTEGER NOT NULL,
  "conversation_id" varchar(200) NOT NULL,
  "platform_message_id" varchar(200) NOT NULL,
  "sender_type" VARCHAR(255) NOT NULL DEFAULT 'page' ,
  "message_text" text NOT NULL,
  "message_type" varchar(250) NOT NULL,
  "is_read" VARCHAR(255) DEFAULT 'yes',
  "timestamp" varchar(200) DEFAULT NULL,
  "createdAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "updatedAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table "inbox_messages"
--

INSERT INTO "inbox_messages" ("id", "conversation_id", "platform_message_id", "sender_type", "message_text", "message_type", "is_read", "timestamp", "createdAt", "updatedAt") VALUES
(5304, 't_122157012044577012', 'm_r7cmTTjJOFuVWlHqjFuZU_wzY8SyzSvW-gyDnDxZJOPPNY-GhWTejKKa9zsdUL2UhFaq85AhWfjnBKo8IhFGuw', 'visitor', 'hello admin user', 'text', 'yes', '2025-07-01T11:15:53+0000', '2025-12-04 10:18:14', '2025-12-04 10:18:14'),
(5305, 't_122157012044577012', 'm_e4p-8JsD-fTHiun9IPG0O_wzY8SyzSvW-gyDnDxZJOMFEFNnfxjLD9pYQcXA4At_INnrVKcFTxLLNjHsoh0Hsw', 'visitor', 'Hello admin', 'text', 'yes', '2025-07-01T11:15:31+0000', '2025-12-04 10:18:15', '2025-12-04 10:18:15'),
(5306, 't_122157012044577012', 'm_bjtR3X1oTm1j977UMK0A0fwzY8SyzSvW-gyDnDxZJON4MRHWS4AsI_8wEJJIncuJIyQ6yI4L7pkzpB-5JnxQNQ', 'visitor', 'Hope you doing well.', 'text', 'yes', '2025-06-30T13:52:26+0000', '2025-12-04 10:18:16', '2025-12-04 10:18:16'),
(5307, 't_122157012044577012', 'm_HNNuSL-LU1jdV9UhIG2WWvwzY8SyzSvW-gyDnDxZJOPiIw4hGw6KUvxWOldUCUcdU9Rx_HdOaFKQZTBY_xZTSQ', 'visitor', 'Hi Admin', 'text', 'yes', '2025-06-30T13:52:20+0000', '2025-12-04 10:18:17', '2025-12-04 10:18:17'),
(5308, 't_122157012044577012', 'm_f_MQEcOzt7oTIadi3122A_wzY8SyzSvW-gyDnDxZJOO3hQDTjjCTzzcyPjzhPyH2gkb-QReOty_l_l7mLmwd6g', 'visitor', 'Yes I can.', 'text', 'yes', '2025-06-30T11:51:04+0000', '2025-12-04 10:18:18', '2025-12-04 10:18:18'),
(5309, 't_122157012044577012', 'm_J9nW9QJbUN_Y3uKzWpzn7_wzY8SyzSvW-gyDnDxZJON31gq6oLWwcXq7V4hbL8BQTPQCFIh2eaHpfQuKxiZdQA', 'page', 'Can you see messages?', 'text', 'yes', '2025-06-30T08:36:11+0000', '2025-12-04 10:18:19', '2025-12-04 10:18:19'),
(5310, 't_122157012044577012', 'm_AuIvjOWuHCdgDI1bqEHVfPwzY8SyzSvW-gyDnDxZJOOo7zpGowKl_sp82tlAzAOr2f3vPlji6QqbYaYo0m5Y4w', 'page', 'Hey ross singh', 'text', 'yes', '2025-06-30T08:34:02+0000', '2025-12-04 10:18:20', '2025-12-04 10:18:20'),
(5311, 't_122157012044577012', 'm_i8cRnmYTogugqn_rCVm2k_wzY8SyzSvW-gyDnDxZJONGkMADnxYzc6Eh0Mqy2rxIpay5YZqZTKZIYvyo9gQ2gw', 'page', 'Hello user 34', 'text', 'yes', '2025-06-30T08:14:49+0000', '2025-12-04 10:18:21', '2025-12-04 10:18:21'),
(5312, 't_122157012044577012', 'm_eVLz3L4Y7JF3kv8fZr08TfwzY8SyzSvW-gyDnDxZJOPHZwYZ90lKrvZSerqm9iCDdR2AMI4XaO88Nw285whmnw', 'page', 'Cant message if you, If I saw your message after 24 hours.', 'text', 'yes', '2025-06-30T08:02:07+0000', '2025-12-04 10:18:22', '2025-12-04 10:18:22'),
(5313, 't_122157012044577012', 'm_6h0vNjmRaz70_48BF1W3A_wzY8SyzSvW-gyDnDxZJOOY2itYCpw4Ef7YOZStwkkO4pCR2ePOg4n9vkCBANCj2Q', 'page', 'How r u?', 'text', 'yes', '2025-06-30T07:51:13+0000', '2025-12-04 10:18:23', '2025-12-04 10:18:23'),
(5314, 't_122157012044577012', 'm_OnxLUYr3Y9VsxsUbTAOsX_wzY8SyzSvW-gyDnDxZJOMtskDzoBh-ELjCWMfOfBnkEu-uxl4ArHxCkVX92os9RQ', 'page', 'Hello Ross, Good to see you.', 'text', 'yes', '2025-06-30T07:46:53+0000', '2025-12-04 10:18:24', '2025-12-04 10:18:24'),
(5315, 't_122157012044577012', 'm_hcfwShQKmFFZGb1YGCz3OfwzY8SyzSvW-gyDnDxZJON6MjckMpHZi0phtdute8j3kK6xiszXlE7gxR-98CfU2w', 'visitor', 'Hello admin', 'text', 'yes', '2025-06-30T07:46:00+0000', '2025-12-04 10:18:25', '2025-12-04 10:18:25'),
(5316, 't_122157012044577012', 'm_fCCPPXp95klg08zJUSziuPwzY8SyzSvW-gyDnDxZJOMf-8F8hm2IIIgwT67-aMO_Awin0MxCEp5xuG5gK9kI1w', 'page', 'Hi Ross', 'text', 'yes', '2025-06-27T08:28:09+0000', '2025-12-04 10:18:26', '2025-12-04 10:18:26'),
(5317, 't_122157012044577012', 'm_2YTGTNL7KwwcCNnjebGVpvwzY8SyzSvW-gyDnDxZJOOY9dE15iGMtHTKM9MRrsMWKaQ5sDbn-0ZKdLShCG8TQg', 'visitor', 'Ross here', 'text', 'yes', '2025-06-27T07:56:55+0000', '2025-12-04 10:18:27', '2025-12-04 10:18:27'),
(5318, 't_122157012044577012', 'm_tOTL0r5Gjxx-zzK3ER4fnPwzY8SyzSvW-gyDnDxZJOMGBl4M2CMLmhLm6yb9mnF8sisNHa0lsnTPzxk0RgeIoA', 'visitor', 'Hello', 'text', 'yes', '2025-06-27T07:56:53+0000', '2025-12-04 10:18:28', '2025-12-04 10:18:28'),
(5319, 't_3910484659264407', 'm_hcDpROP-sEEMN6hzy-dEeBhzQSVLdgqqtafs2aaIipsHDh0ru7AWeqfSJbMlfKRnq9fi5f4t81QZ8sdQwte7Jw', 'visitor', 'Hi', 'text', 'yes', '2025-12-04T06:06:17+0000', '2025-12-04 12:50:29', '2025-12-04 12:50:29'),
(5320, 't_3910484659264407', 'm_4LX9W5c-fLF7syRJnwkDehhzQSVLdgqqtafs2aaIipsF5okgeYYBx45mEOyQmCjcpmhcC7Pdp-Hgr1N8EanhGg', 'visitor', 'Hello', 'text', 'yes', '2025-12-01T11:08:20+0000', '2025-12-04 12:50:30', '2025-12-04 12:50:30'),
(5321, 't_3910484659264407', 'm_Fyi94qWlxCnW4bohTX4GehhzQSVLdgqqtafs2aaIipsM7zw7vr40XXtJosWSSngLsd1MgrHYkDmnDO0cCuuuvg', 'visitor', 'Hello admin?', 'text', 'yes', '2025-12-01T11:04:50+0000', '2025-12-04 12:50:31', '2025-12-04 12:50:31'),
(5322, 't_3910484659264407', 'm_PFmwd9ijmtTD3AwBbbVWqBhzQSVLdgqqtafs2aaIipuwjVGnTheinLZhLxhGKapiEyyD2iojHsPjzrZ_xfnIag', 'visitor', 'Can you see message?', 'text', 'yes', '2025-12-01T11:02:20+0000', '2025-12-04 12:50:32', '2025-12-04 12:50:32'),
(5323, 't_3910484659264407', 'm_JAAi0_l1cPkmd-QnwMA4PhhzQSVLdgqqtafs2aaIipuSVlstmdNGAaRQBiykHlVD9F1wF1hw9xyJMy1euThsmQ', 'visitor', 'Hi', 'text', 'yes', '2025-12-01T11:00:08+0000', '2025-12-04 12:50:33', '2025-12-04 12:50:33'),
(5324, 't_3910484659264407', 'm_9C7ev_m42ENjzySNEBpsEBhzQSVLdgqqtafs2aaIipuZg0H8DKbSPkhBur6HWf2y_L7fgALYVzdeXSmrVVbRrw', 'visitor', 'Hello admin', 'text', 'yes', '2025-12-01T10:58:37+0000', '2025-12-04 12:50:34', '2025-12-04 12:50:34'),
(5325, 't_3910484659264407', 'm_CPMrvSOP2KIvR5hJSjj4GRhzQSVLdgqqtafs2aaIipsxLPvzY4vevcvy-XTur44dd7beNO3tpDnQk-iO-xm04Q', 'visitor', 'Hi', 'text', 'yes', '2025-12-01T10:52:16+0000', '2025-12-04 12:50:35', '2025-12-04 12:50:35'),
(5326, 't_3910484659264407', 'm_GcYHJwsb0nhbHLLNmalTFhhzQSVLdgqqtafs2aaIipuz44n81fkrxhOV8rNkQUCzJy6m9it__wxym5PNRirE2A', 'page', 'Hello! How can I assist you today?', 'text', 'yes', '2025-11-07T11:45:42+0000', '2025-12-04 12:50:36', '2025-12-04 12:50:36'),
(5327, 't_3910484659264407', 'm_fHcc5tVBVh4MbE09jyBV7RhzQSVLdgqqtafs2aaIipt0KEoBIAz5PyD2y8xs83EYJ1FhFiuVf683ExM3kzzLKA', 'visitor', 'Hello', 'text', 'yes', '2025-11-07T11:45:32+0000', '2025-12-04 12:50:37', '2025-12-04 12:50:37'),
(5328, 't_3910484659264407', 'm_RIJxuL5Mr6rMUabOuE6qURhzQSVLdgqqtafs2aaIipu9RkmqDSl0Me-qn0iBgq7qGKM9h1QhTOSF5pSQC6agPA', 'page', 'Hello! How can I help you today?', 'text', 'yes', '2025-11-06T11:31:26+0000', '2025-12-04 12:50:38', '2025-12-04 12:50:38'),
(5329, 't_3910484659264407', 'm_UbDomzFEfRxWllWMAlQjCBhzQSVLdgqqtafs2aaIipsIYzavldOGMHk8gdPAvSIPLJtGzb63EOI6GsClOw6H4Q', 'visitor', 'Hello', 'text', 'yes', '2025-11-06T11:31:17+0000', '2025-12-04 12:50:39', '2025-12-04 12:50:39'),
(5330, 't_3910484659264407', 'm_9T3CfDxbn8TpbNalsBFhDxhzQSVLdgqqtafs2aaIipugqMSvFdeh4iKajJwhbFyFGijxXKuzYUhCl43s3M_drQ', 'page', 'Hi there! How can I help you today?', 'text', 'yes', '2025-11-05T11:25:34+0000', '2025-12-04 12:50:40', '2025-12-04 12:50:40'),
(5331, 't_3910484659264407', 'm_jq_m4CFFfqz6cYKPPbOylBhzQSVLdgqqtafs2aaIipvBK5mcmVg5q51cTMgrBOz5cOHHhGPI0IaxjpLBIgls2A', 'visitor', 'Hi', 'text', 'yes', '2025-11-05T11:25:21+0000', '2025-12-04 12:50:41', '2025-12-04 12:50:41'),
(5332, 't_3910484659264407', 'm_VgA_vNi2x4VK0TDnyJx6tRhzQSVLdgqqtafs2aaIiptCVb9G1LgnvllN5BWWUS3NNavBotI2AxHqaZd2GAoAHQ', 'page', 'Hello', 'text', 'yes', '2025-11-05T11:24:58+0000', '2025-12-04 12:50:42', '2025-12-04 12:50:42'),
(5333, 't_3910484659264407', 'm_kWOOZLAuEQhvqAJ-IeoESBhzQSVLdgqqtafs2aaIipv74yScjlQRula4YICYot_wylI56xnHbufVWpToaZQHmw', 'page', 'A lookalike audience is created using Pixel data to build targeted ad campaigns for a higher return on investment.', 'text', 'yes', '2025-11-04T13:01:47+0000', '2025-12-04 12:50:43', '2025-12-04 12:50:43'),
(5334, 't_3910484659264407', 'm_fL0Xk53Sa5SxseSZ_G6dpRhzQSVLdgqqtafs2aaIipved8fyfDT0AJ-p2a7xHnSchBOiNiRxhdiyeNzRV3AJ3g', 'visitor', 'What is a lookalike audiences?', 'text', 'yes', '2025-11-04T13:01:36+0000', '2025-12-04 12:50:44', '2025-12-04 12:50:44'),
(5335, 't_3910484659264407', 'm_vvYuNbjyKMegZ-0T_Lod4RhzQSVLdgqqtafs2aaIiptsEVkZWZT6ZxwsiWt9vs1E3EjnoQu3dMmR1tmGJLP1Ug', 'page', 'To fix social login errors, ensure Two-Factor Authentication (2FA) is enabled on the connecting account, verify correct permissions, and check for non-Latin characters in product names. Additionally, troubleshoot third-party social login plugin issues by checking App IDs/Secrets, permalink structure, and conflicts with caching plugins. Ensure your host allows outgoing cURL requests and that Permalinks are enabled.', 'text', 'yes', '2025-11-04T13:00:06+0000', '2025-12-04 12:50:45', '2025-12-04 12:50:45'),
(5336, 't_3910484659264407', 'm_T--80dAIbZi6-DHdLXqdZhhzQSVLdgqqtafs2aaIipuDi8YAgomfIqIzKo_VjTTYTvVGJE1PnsBxsJxSdO1_kQ', 'visitor', 'How to fix social login errors?', 'text', 'yes', '2025-11-04T12:59:51+0000', '2025-12-04 12:50:46', '2025-12-04 12:50:46'),
(5337, 't_3910484659264407', 'm_pN9uF0aAGZQUmycIABnBfRhzQSVLdgqqtafs2aaIipttYzhHIrYdqXdeluvpovZmOCN_u9sNkYc1xyY37U17-A', 'page', 'To set up Instagram shopping, first, you need to connect your WooCommerce store to Meta (Facebook & Instagram Shop) by installing the "Facebook for WooCommerce" plugin. Then, connect your Facebook account, select your Business Manager, and create or sync your Meta Product Catalog. After these steps, ensure your Instagram Business Profile meets the eligibility requirements and submit it for review to enable Instagram Shopping Tags.', 'text', 'yes', '2025-11-04T12:58:38+0000', '2025-12-04 12:50:47', '2025-12-04 12:50:47'),
(5338, 't_3910484659264407', 'm_oY45DhaD4yauT1y9Num4cRhzQSVLdgqqtafs2aaIipuTUVrNGpzsBZj2H8qO2GNivdMJo_bMNVhfkpLqR_Gx2A', 'visitor', 'How do I setup Instagram shopping?', 'text', 'yes', '2025-11-04T12:58:24+0000', '2025-12-04 12:50:48', '2025-12-04 12:50:48'),
(5339, 't_3910484659264407', 'm_YcgbLzxYsv1KeOKIOHUPpRhzQSVLdgqqtafs2aaIipuigmZs9CLvLhBbB7GAScL8074wRrn2-XOjQREMdEtGTQ', 'page', 'Hello! How can I help you today?', 'text', 'yes', '2025-11-04T12:57:33+0000', '2025-12-04 12:50:49', '2025-12-04 12:50:49'),
(5340, 't_3910484659264407', 'm_n64s20tE4zloa2XELDP1FBhzQSVLdgqqtafs2aaIipvwUSW9BGxTotUYaLtFH_FrHFQJkGiR0XYKp1XdSiPJbA', 'visitor', 'Hello', 'text', 'yes', '2025-11-04T12:57:25+0000', '2025-12-04 12:50:50', '2025-12-04 12:50:50'),
(5341, 't_3910484659264407', 'm_LbWq8i-SFGB9T-uHkTIB1xhzQSVLdgqqtafs2aaIiptiT75bQaF2ONdFw8D3q8LtfBjx8XVDZhw2PnflNjQs9A', 'page', 'To invite collaborators, please refer to the article "How to Create a New Project and Invite Collaborators" in the product documentation. I do not have specific information regarding what roles should be assigned to new teammates.', 'text', 'yes', '2025-11-04T12:37:22+0000', '2025-12-04 12:50:51', '2025-12-04 12:50:51'),
(5342, 't_3910484659264407', 'm_kZEgfnwT7kzltWvE62zABxhzQSVLdgqqtafs2aaIipv7LbxLug10IwmVeOJUPyKhYO4EL2t2_jcM9ynhHXqXfQ', 'visitor', 'How do I invite a new teammate to my project, and what role should I assign them?', 'text', 'yes', '2025-11-04T12:37:10+0000', '2025-12-04 12:50:52', '2025-12-04 12:50:52'),
(5343, 't_3910484659264407', 'm_jNmLdCKUThzoR0oBNr4ihxhzQSVLdgqqtafs2aaIipv-ctYjhzLqbTAwyipaSes4uyxNyfahUvX6G91pql0ixw', 'page', 'Hello! How can I help you today?', 'text', 'yes', '2025-11-04T12:32:32+0000', '2025-12-04 12:50:53', '2025-12-04 12:50:53'),
(5344, 't_122146872602860722', 'm_5LvsdhV0C173xxYkoAKgTm_grOqO3NWBRJ7Xc2GwTPxeL2_FT2gvmXCVnOWMc-I4dvQFhqaVeDNKl62u6y4ZZg', 'visitor', 'Get started', 'text', 'yes', '2025-11-16T17:20:11+0000', '2025-12-04 12:50:55', '2025-12-04 12:50:55'),
(5345, 't_122146872602860722', 'm_EMYdD2nQ2eYXM_85pDTrd2_grOqO3NWBRJ7Xc2GwTPz6rftyfN-JV9lEnbr0HNmTR0cuK0rY2hps7ojKNwt6XA', 'page', 'Heello', 'text', 'yes', '2025-11-07T12:18:42+0000', '2025-12-04 12:50:56', '2025-12-04 12:50:56'),
(5346, 't_122146872602860722', 'm_Tha65UUlIGT6AStLzjGG1m_grOqO3NWBRJ7Xc2GwTPyYDqHOHHGQzwPbvJNvveHuPEpHz4L9NCcf6mQQuE6c3g', 'visitor', '', 'text', 'yes', '2025-11-07T12:00:00+0000', '2025-12-04 12:50:57', '2025-12-04 12:50:57'),
(5347, 't_122146872602860722', 'm_dvedyXJckYTe918f5-EEm2_grOqO3NWBRJ7Xc2GwTPz7e0YHFnAEh3pyHsuVcibWIsyQE7XVbDtN6482AlWYyA', 'page', 'I don''t have enough information to answer that query. My knowledge base focuses on connecting WooCommerce stores to Facebook and Instagram for business purposes.', 'text', 'yes', '2025-11-07T11:59:18+0000', '2025-12-04 12:50:58', '2025-12-04 12:50:58'),
(5348, 't_122146872602860722', 'm_Q9sl_qCBsDbeOnRMYahss2_grOqO3NWBRJ7Xc2GwTPzQgqB5tE256oWI1KbzOdH6LgQtu0Y-hKC3h7nFQ8-o2w', 'visitor', 'How we can connect Facebook personal account', 'text', 'yes', '2025-11-07T11:59:07+0000', '2025-12-04 12:50:59', '2025-12-04 12:50:59'),
(5349, 't_122146872602860722', 'm_HI7_UzkYjGtMdniFaCdsZW_grOqO3NWBRJ7Xc2GwTPybVB_yfBdhtB3pXyE0Y103NKcmQ_UsYHyqbhTwhIl4RA', 'page', 'I am an AI assistant and do not have feelings. How can I help you with information about our software solutions?', 'text', 'yes', '2025-11-07T11:58:28+0000', '2025-12-04 12:51:01', '2025-12-04 12:51:01'),
(5350, 't_122146872602860722', 'm_gyg4NMYS1xOX4tB5jd0PaW_grOqO3NWBRJ7Xc2GwTPwsMciM_uqNtLNh327b6e67mWQVqzZ20PFwusnL97CTuA', 'visitor', 'How are you webonx', 'text', 'yes', '2025-11-07T11:58:22+0000', '2025-12-04 12:51:02', '2025-12-04 12:51:02'),
(5351, 't_122146872602860722', 'm_OOIvs7T_d6z8Kuj18MUg-m_grOqO3NWBRJ7Xc2GwTPyODLv-bV4NBATUlcSaTXpDfGJrEY8WQVR_7hB9TiMTFw', 'visitor', '', 'text', 'yes', '2025-11-07T11:58:14+0000', '2025-12-04 12:51:03', '2025-12-04 12:51:03'),
(5352, 't_122146872602860722', 'm_XLQeApj5FlBNDl53m59orW_grOqO3NWBRJ7Xc2GwTPx52b3bAiiFAcUjA26GwE65h39jkufP-A9GmIAAvx_jBA', 'page', 'Hello! How can I help you today?', 'text', 'yes', '2025-11-07T11:56:47+0000', '2025-12-04 12:51:04', '2025-12-04 12:51:04'),
(5353, 't_122146872602860722', 'm_OESSESJWh56SvhYnTkT1xm_grOqO3NWBRJ7Xc2GwTPy9ArXcCDIbRzVLMHtX-HBf76nqBjTAgy-9pKit-xrS1Q', 'visitor', 'Hello webonx', 'text', 'yes', '2025-11-07T11:56:00+0000', '2025-12-04 12:51:05', '2025-12-04 12:51:05'),
(5354, 't_122146872602860722', 'm_-1jTVMJYwqzcJU-9AMUw-W_grOqO3NWBRJ7Xc2GwTPyk4ZhE5kzIbtp7Hpby7ExbtQy43GDNvoyjwt7NbMbIIA', 'visitor', '', 'text', 'yes', '2025-11-07T11:48:04+0000', '2025-12-04 12:51:06', '2025-12-04 12:51:06'),
(5355, 't_122146872602860722', 'm_E2nvi0UOcTTme0S4fg08Q2_grOqO3NWBRJ7Xc2GwTPzzbeX4tA1rAzHxpeZyAaU9SPJEUsl6HW7jIOe93Krivg', 'visitor', 'Hello webonx', 'text', 'yes', '2025-11-07T11:47:45+0000', '2025-12-04 12:51:07', '2025-12-04 12:51:07'),
(5356, 't_122146872602860722', 'm_T4vNKd7lZX-G7gFk4GYEFW_grOqO3NWBRJ7Xc2GwTPylz_H5ee3LwRfqgtMK0zdgr6z3VlMqjnA_gyRRfm7lzQ', 'visitor', 'Get started', 'text', 'yes', '2025-11-07T11:47:17+0000', '2025-12-04 12:51:08', '2025-12-04 12:51:08'),
(5357, 't_4434236870195991', 'm_nFxVMmGKr_f2ibZ8lyMux8mkDypFqAmNB5iTvX5h10y2yo9v_A4xVENHxSFhRleScwa7SX4gnXKg859uM4hreg', 'page', 'Hello! How can I help you today?', 'text', 'yes', '2025-11-04T13:02:33+0000', '2025-12-04 12:51:10', '2025-12-04 12:51:10'),
(5358, 't_4434236870195991', 'm_rLnKt7i-56aPfsjS4BWX-MmkDypFqAmNB5iTvX5h10wSqAjxSl3zaH9vQq8Pj-OLQsHtn1dr33MJbxeDz3D5Tw', 'visitor', 'Hello', 'text', 'yes', '2025-11-04T13:02:26+0000', '2025-12-04 12:51:11', '2025-12-04 12:51:11'),
(5359, 't_4434236870195991', 'm_9QrvXBEicRji0AeDeLi9KsmkDypFqAmNB5iTvX5h10wCK7k-FnFcTkly4xQKsAnQ7KkulPM1c2alFXQyKX_gPQ', 'page', 'Hi there! How can I help you today?', 'text', 'yes', '2025-11-04T10:59:45+0000', '2025-12-04 12:51:12', '2025-12-04 12:51:12'),
(5360, 't_4434236870195991', 'm_dnokLVx0StxQWI6LMik4qMmkDypFqAmNB5iTvX5h10xBiuhEFhUcA0_fMuyvfHXTkic2Eh-pjGV1lHruj8kytw', 'visitor', 'Hi', 'text', 'yes', '2025-11-04T10:59:38+0000', '2025-12-04 12:51:13', '2025-12-04 12:51:13'),
(5361, 't_4434236870195991', 'm_8mmpQ58kuvopSz6EnwlOz8mkDypFqAmNB5iTvX5h10yqy_gssrMyrvt751OGfD4UBmXcIwVG5F0zU1hTvL69hA', 'page', 'Hello andy sir 🍺🍻🥂🥃🍾🍾🍾🍾🍾🍻🍻🍻', 'text', 'yes', '2025-11-04T10:59:04+0000', '2025-12-04 12:51:14', '2025-12-04 12:51:14'),
(5362, 't_4434236870195991', 'm_GZsMtFBVZIteB_riAhwo9cmkDypFqAmNB5iTvX5h10znD-PlyVQfFPD5ciunlyElVHu-jSPBbymdSVuL0TThCA', 'page', 'The product documentation covers Product Mastery & How-To Guides for everyday use, best practices, and standard workflows. It also includes Technical Troubleshooting & Support for issues, errors, compatibility, and solutions, as well as Company, Policies & Account Management for administrative and general inquiries.', 'text', 'yes', '2025-11-04T10:55:22+0000', '2025-12-04 12:51:15', '2025-12-04 12:51:15'),
(5363, 't_4434236870195991', 'm_ciMuwm3BhVJ1etbasuiyzMmkDypFqAmNB5iTvX5h10xPRk825ZwVUIS6hCkRC5M93gmvqhidjt5beimIpzQIRw', 'visitor', 'Tell me about product', 'text', 'yes', '2025-11-04T10:55:10+0000', '2025-12-04 12:51:16', '2025-12-04 12:51:16'),
(5364, 't_4434236870195991', 'm_NsYWcz0NG6VHC3otxTKqPMmkDypFqAmNB5iTvX5h10wAGH78coLueR16MPIIQv_dHId7rANNp2v43v5zk157cQ', 'page', 'For billing and subscription, you can find information on how to change your payment method or billing cycle, understand your invoice and subscription tiers, and learn about the cancellation and refund policy. These details are under the Company, Policies & Account Management section.', 'text', 'yes', '2025-11-04T10:54:48+0000', '2025-12-04 12:51:17', '2025-12-04 12:51:17'),
(5365, 't_4434236870195991', 'm_LH4_u73gEFZofh5wEM3P1cmkDypFqAmNB5iTvX5h10yAPcmWOvwFDLUog4g1hiFlR65QQ1TMWb0ZYkglddYHJg', 'visitor', 'Tell me about billing and subscription', 'text', 'yes', '2025-11-04T10:54:29+0000', '2025-12-04 12:51:18', '2025-12-04 12:51:18'),
(5366, 't_4434236870195991', 'm_viPhnCXvwzJ5vhBx9rqOWMmkDypFqAmNB5iTvX5h10yg0Up1uWTSg7GFBtjUEpZWcktdU4HPszKs4PAZg67E0A', 'page', 'Hi there! How can I help you today?', 'text', 'yes', '2025-11-04T10:53:38+0000', '2025-12-04 12:51:19', '2025-12-04 12:51:19'),
(5367, 't_4434236870195991', 'm_Roe5Ts9Y6qHDnOw-Nsz81MmkDypFqAmNB5iTvX5h10xUooe4QcRJ-nHA9utYoGWmBRvs24W1QRRLRpXiAr6qHg', 'visitor', 'Hi', 'text', 'yes', '2025-11-04T10:53:30+0000', '2025-12-04 12:51:20', '2025-12-04 12:51:20'),
(5368, 't_4434236870195991', 'm_RlOa6tr5e8lLh7x-z59xkcmkDypFqAmNB5iTvX5h10yKCyzfEKSU7efDYTjAM6zZ_3NpwSeaxSCoNlNOGBarfw', 'page', 'I do not have enough information to answer that query. Please let me know how I can help you.', 'text', 'yes', '2025-11-04T10:37:48+0000', '2025-12-04 12:51:21', '2025-12-04 12:51:21'),
(5369, 't_4434236870195991', 'm_xOCWuoeedRvvpy6wTb8T_MmkDypFqAmNB5iTvX5h10wbyZ7y88zwCtGoBgHg7F0FiwKYyp1FDK5rjmc4RfG_Dw', 'visitor', 'Ok', 'text', 'yes', '2025-11-04T10:37:39+0000', '2025-12-04 12:51:22', '2025-12-04 12:51:22'),
(5370, 't_4434236870195991', 'm_fwSYZ34OILokocFaxTh8gcmkDypFqAmNB5iTvX5h10z0V7qI87MmYv3hTF3JDcwuke6pC7FnIbRb_pLQaBsgVA', 'page', 'I don’t have enough information to answer that query.', 'text', 'yes', '2025-11-04T10:37:24+0000', '2025-12-04 12:51:23', '2025-12-04 12:51:23'),
(5371, 't_4434236870195991', 'm_k_N7MBMb7PTSZT2kF3SxRMmkDypFqAmNB5iTvX5h10xSvDRL-r8f97J4534RR7Otq8iYI7UshB8CKI7WrSBK5Q', 'visitor', 'Tell me about AI technology', 'text', 'yes', '2025-11-04T10:37:12+0000', '2025-12-04 12:51:24', '2025-12-04 12:51:24'),
(5372, 't_4434236870195991', 'm_0H2vnp39q0yKiZCBt2OMpsmkDypFqAmNB5iTvX5h10zstAHr1dK_jrNBmNKdvAcF08co4Lf6m5GzfMVlYdgcUg', 'page', 'Hi there! How can I help you today?', 'text', 'yes', '2025-11-04T10:36:41+0000', '2025-12-04 12:51:25', '2025-12-04 12:51:25'),
(5373, 't_4434236870195991', 'm_jdikHcs5pC91Uo6_lk9LncmkDypFqAmNB5iTvX5h10zdceqQ1VdgwYP474Y08VszUVXfvdaIbBQWadV4BIghvg', 'visitor', 'Hi', 'text', 'yes', '2025-11-04T10:36:31+0000', '2025-12-04 12:51:26', '2025-12-04 12:51:26'),
(5374, 't_4434236870195991', 'm_Cy6fNla16GtpqWqVlmHK98mkDypFqAmNB5iTvX5h10w7eaaBXwfxlYRbee-bRh5jGlN2AtRH2zjJP0GKFSVLhA', 'visitor', 'Hello boot', 'text', 'yes', '2025-11-03T12:47:14+0000', '2025-12-04 12:51:27', '2025-12-04 12:51:27'),
(5375, 't_4434236870195991', 'm_EILhGAhQOYnomV-nppkx1MmkDypFqAmNB5iTvX5h10wGqz6ZDw4c9oWjEqY5mGrAEY43snW4ub9zgbeag2dkbw', 'visitor', 'There?', 'text', 'yes', '2025-11-03T07:47:19+0000', '2025-12-04 12:51:28', '2025-12-04 12:51:28'),
(5376, 't_4434236870195991', 'm_rurPsyy7GKtbsUoLj_M2U8mkDypFqAmNB5iTvX5h10wWsIUu2PCYgjDi5jV1nv_gX6WbaBB2s6qAv6MNvn-b0Q', 'visitor', 'Hiii', 'text', 'yes', '2025-11-03T07:43:12+0000', '2025-12-04 12:51:29', '2025-12-04 12:51:29'),
(5377, 't_4434236870195991', 'm_Ij3hObaBnAWJMK0q4NtCTcmkDypFqAmNB5iTvX5h10xYOHiDOhcaYPejRMWhzAusUfU7O8Oxo0WvjIK8xFGOyQ', 'visitor', 'Good morning', 'text', 'yes', '2025-11-03T07:03:59+0000', '2025-12-04 12:51:30', '2025-12-04 12:51:30'),
(5378, 't_4434236870195991', 'm_dF04FeQuKxmEmz_DDgtRU8mkDypFqAmNB5iTvX5h10xZ5ZVmbw79UBUBs-Xp8fXSroCfRr1yOd-6J7cbdmDWVA', 'visitor', 'Hi', 'text', 'yes', '2025-09-03T13:01:58+0000', '2025-12-04 12:51:31', '2025-12-04 12:51:31'),
(5379, 't_4434236870195991', 'm_8eAtMX7s3GNITX3fgnMrd8mkDypFqAmNB5iTvX5h10xxyozh5pN0cSXPGSDi-S2hR56QpDwPHTQ4DHvGaVIkSA', 'page', 'testing 2', 'text', 'yes', '2025-08-18T12:28:41+0000', '2025-12-04 12:51:32', '2025-12-04 12:51:32'),
(5380, 't_4434236870195991', 'm_hInARUshrZYfQoE0-pS9G8mkDypFqAmNB5iTvX5h10yb5c7XX3zCHpLTeGINjUqPd-zLjm_liPn2fqzEvTFGJQ', 'page', 'new message', 'text', 'yes', '2025-08-18T12:28:31+0000', '2025-12-04 12:51:33', '2025-12-04 12:51:33'),
(5381, 't_4434236870195991', 'm__XZcMqcXuiw8gTFvVU9kWsmkDypFqAmNB5iTvX5h10whVyuXuDGVk0imPDo0aeeVWVos7Ifu9tQWWMKX5CpxTw', 'page', 'byee', 'text', 'yes', '2025-08-18T12:26:18+0000', '2025-12-04 12:51:34', '2025-12-04 12:51:34'),
(5382, 't_1892630394834228', 'm_osCq0x3egiWNCtaU-kMZafZSf7Go7C0AXzzwPPq7aFRSedbTtVCdYMhyAv_6XM7QmdALNi6CQUqw5WqJgSCWZg', 'visitor', 'Fine', 'text', 'yes', '2025-10-03T06:44:35+0000', '2025-12-04 12:51:37', '2025-12-04 12:51:37'),
(5383, 't_1892630394834228', 'm_r5Er-IYKGtZ5QJRTfMWaJfZSf7Go7C0AXzzwPPq7aFTInDV-5gUvKm9zCjt549TLTBiXD7aeZ3X_PkYhD-K9Sw', 'page', 'how r u?', 'text', 'yes', '2025-10-03T06:44:11+0000', '2025-12-04 12:51:38', '2025-12-04 12:51:38'),
(5384, 't_1892630394834228', 'm_ECNXTKZo3PUwNVOqIAE09PZSf7Go7C0AXzzwPPq7aFRnZtOChrTmYdla2AkcYmjSG7ZWrZceVHwBjCAbkZMXYA', 'page', 'hello madam', 'text', 'yes', '2025-10-03T06:43:51+0000', '2025-12-04 12:51:39', '2025-12-04 12:51:39'),
(5385, 't_1892630394834228', 'm_WgtC3YAs1DrRZ3w4NFJs3fZSf7Go7C0AXzzwPPq7aFT6a14_HV2Ak2ox7a2djs7BDj0E3VeYssOYxPEIEFnSJw', 'visitor', 'Hey', 'text', 'yes', '2025-10-03T06:43:20+0000', '2025-12-04 12:51:40', '2025-12-04 12:51:40'),
(5386, 't_1892630394834228', 'm_31-GhAiFRlgRWn7Sg4610PZSf7Go7C0AXzzwPPq7aFRj8BUzErAgaAJoNW4bIVP7fpnfs9ALOInmop74B4tpRw', 'visitor', 'Hey', 'text', 'yes', '2025-07-03T11:34:30+0000', '2025-12-04 12:51:41', '2025-12-04 12:51:41'),
(5387, 't_1892630394834228', 'm_27AAFFpSA6cjULjss_bgwfZSf7Go7C0AXzzwPPq7aFSRDt4AdAxcVhj4wT3_qbJFwKJ3I4R1y6q3q5hyajB9Ng', 'visitor', 'Why are u not replying', 'text', 'yes', '2025-07-03T11:34:23+0000', '2025-12-04 12:51:42', '2025-12-04 12:51:42'),
(5388, 't_1892630394834228', 'm_eObznkwlIab_BKuTdR_30vZSf7Go7C0AXzzwPPq7aFQBl2A7h6ywbPt96Fkiu-LbcooYh3QzKruYrL9Xx4AQdg', 'visitor', 'What are u doing', 'text', 'yes', '2025-07-03T11:34:09+0000', '2025-12-04 12:51:43', '2025-12-04 12:51:43'),
(5389, 't_1892630394834228', 'm_Rj55tEQ7CLxHVdkQQK5vxvZSf7Go7C0AXzzwPPq7aFQsTVyEvD_IBCNrZHCAXsTVLjUsOfAvcb2nTpoJ1efAcw', 'visitor', 'Hii', 'text', 'yes', '2025-07-03T11:34:03+0000', '2025-12-04 12:51:44', '2025-12-04 12:51:44'),
(5390, 't_1892630394834228', 'm_z0oygSpnboMAJWUi4geUivZSf7Go7C0AXzzwPPq7aFRbskTlStStiw3EUNlEoQlmaEd2WeudBN9qit2ScTxuZw', 'visitor', 'How are you', 'text', 'yes', '2025-07-03T11:32:54+0000', '2025-12-04 12:51:45', '2025-12-04 12:51:45'),
(5391, 't_1892630394834228', 'm_Qj4igOw865xxG1tSQvRakvZSf7Go7C0AXzzwPPq7aFQJTGuPV0sEfuBcJU9qHyMkljb6lTlERtKtc4A-qmfNdQ', 'visitor', 'Hlo', 'text', 'yes', '2025-07-03T11:32:30+0000', '2025-12-04 12:51:46', '2025-12-04 12:51:46'),
(5392, 't_1892630394834228', 'm_TMCHghg4n_Vcc74w3xdYXPZSf7Go7C0AXzzwPPq7aFSe7vQt_1uDCtUjibVfJbnn41bgxNZZ_H_8nU0hPqTXlA', 'page', 'hello', 'text', 'yes', '2025-07-02T11:00:16+0000', '2025-12-04 12:51:47', '2025-12-04 12:51:47'),
(5393, 't_1892630394834228', 'm__-7lRcFmGGg9mR1-rJHcPvZSf7Go7C0AXzzwPPq7aFTQg7zvtbLZBCz2PcGDam4lfmspzaa_d7bWMVRonWn43w', 'page', 'Hi', 'text', 'yes', '2025-07-01T12:10:10+0000', '2025-12-04 12:51:48', '2025-12-04 12:51:48'),
(5394, 't_1892630394834228', 'm_IszFw1zcAofBRAVHridS__ZSf7Go7C0AXzzwPPq7aFQDIqIhyyWh14FoniKQAoypku30Jr3rWPkrPbZHfCUy3w', 'page', 'Hello', 'text', 'yes', '2025-07-01T12:05:52+0000', '2025-12-04 12:51:49', '2025-12-04 12:51:49'),
(5395, 't_1892630394834228', 'm_-_dcFsNu62iGEnchoPqFrPZSf7Go7C0AXzzwPPq7aFTu1NKQxU5bifrBr7vB4o3dmAGiQTHznlrDLB17appJIw', 'page', 'Hello', 'text', 'yes', '2025-07-01T12:05:16+0000', '2025-12-04 12:51:50', '2025-12-04 12:51:50'),
(5396, 't_1892630394834228', 'm_UjHR2a9cwAev9F1CHDeBofZSf7Go7C0AXzzwPPq7aFRWoO-_HNHnNZnRYLnOSvVFW1GOerdya6XqlxaNnbA7ng', 'page', 'hello', 'text', 'yes', '2025-07-01T12:04:56+0000', '2025-12-04 12:51:51', '2025-12-04 12:51:51'),
(5397, 't_1892630394834228', 'm_ACWrxhNvAF_wdkDuF1dNCvZSf7Go7C0AXzzwPPq7aFRxzQOM_rGgiiOAY6B3dV9RQqDXLBUPg-fCEyfTC2GcaA', 'page', 'Hi', 'text', 'yes', '2025-07-01T12:03:39+0000', '2025-12-04 12:51:52', '2025-12-04 12:51:52'),
(5398, 't_1892630394834228', 'm_rtWp5xsQvy52s7GFwn0XEPZSf7Go7C0AXzzwPPq7aFRDja4KuZpXhxIB4mJe75RVBUOZbMHTgNar0rsejd4inA', 'page', 'Hello madam', 'text', 'yes', '2025-07-01T12:03:01+0000', '2025-12-04 12:51:53', '2025-12-04 12:51:53'),
(5399, 't_1892630394834228', 'm_uC8r9VVNUokkB-LbXXKpF_ZSf7Go7C0AXzzwPPq7aFRxNc_DxWV5C9pqNg9SToqLkioZ_q-GqHN09yy9vB3K3Q', 'page', 'Hello', 'text', 'yes', '2025-07-01T12:02:33+0000', '2025-12-04 12:51:54', '2025-12-04 12:51:54'),
(5400, 't_1892630394834228', 'm_dMjALsQM9rKjafg1hi9g5_ZSf7Go7C0AXzzwPPq7aFRPKA5U07CyPlNnDYykGZpugnFiEWPQA6uxO7Vsng6P-w', 'page', 'Hi', 'text', 'yes', '2025-07-01T11:49:48+0000', '2025-12-04 12:51:55', '2025-12-04 12:51:55'),
(5401, 't_1892630394834228', 'm_8oyflDxNPWyKZy1PVknTO_ZSf7Go7C0AXzzwPPq7aFTsG45A4q5AhC9bwPgPXKSh4m8QBdUHaGIVLRmnW0Ua4A', 'page', 'Hello Madam', 'text', 'yes', '2025-07-01T11:49:33+0000', '2025-12-04 12:51:56', '2025-12-04 12:51:56'),
(5402, 't_1892630394834228', 'm_QhZiKGwAjcmOHvvhMQeEC_ZSf7Go7C0AXzzwPPq7aFRQyR8iKrqtWD8XbXI66y9SZt0Ot58sWph710_lmWrSYQ', 'visitor', 'Hii', 'text', 'yes', '2025-07-01T11:48:30+0000', '2025-12-04 12:51:57', '2025-12-04 12:51:57'),
(5403, 't_1892630394834228', 'm_xXtk_djL4UkRPdejR2pklPZSf7Go7C0AXzzwPPq7aFRwNNdAAchFeYXV9E3BjI9nMIsC8xzeHPW0_DdAZHxojg', 'visitor', 'Hello', 'text', 'yes', '2025-07-01T11:45:06+0000', '2025-12-04 12:51:58', '2025-12-04 12:51:58'),
(5404, 't_1892630394834228', 'm_vPXeuZ5kPPSD82Spn8lWHvZSf7Go7C0AXzzwPPq7aFR2LrzCZj_9eGTNJ_Ex-z-3UsWhhQN8o8iIEyNL-1OFyQ', 'visitor', 'jljljljkl', 'text', 'yes', '2025-06-25T11:43:25+0000', '2025-12-04 12:51:59', '2025-12-04 12:51:59'),
(5405, 't_1892630394834228', 'm_S2E90AQa7pmFJkdZjg_K9_ZSf7Go7C0AXzzwPPq7aFQwWIE3tHZ9Ei7xy1HCCfcxtVGs2uKuKKQ-52VH-l4z0g', 'page', 'hooipio', 'text', 'yes', '2025-06-25T11:43:17+0000', '2025-12-04 12:52:00', '2025-12-04 12:52:00'),
(5406, 't_1892630394834228', 'm_i0h4s1rQAwfvfuyNSS_i0PZSf7Go7C0AXzzwPPq7aFSAEFvFn30Hcnne35F-y4--8wpzFoApwqFKSkHGPX8ncQ', 'page', 'hii', 'text', 'yes', '2025-06-25T11:41:22+0000', '2025-12-04 12:52:01', '2025-12-04 12:52:01'),
(5407, 't_24102016736093261', 'm_bqWLEpibgsNd8pDqD95N4NJDEszlIKODsAXhDk8ezAU0F2abY7rhgxk43ebc964LgjZF8gg0XO1KjVoBw7cXAQ', 'visitor', '𝗣𝗹𝗲𝗮𝘀𝗲 𝗿𝗲𝗳𝗲𝗿 𝘁𝗼 𝘁𝗵𝗲 𝗽𝗿𝗶𝘃𝗮𝗰𝘆 𝗽𝗼𝗹𝗶𝗰𝘆 𝗮𝘁: 🔗 https://transparency.meta.com/enforcement/detecting-violations/   𝗧𝗼 𝗰𝗼𝗻𝘁𝗶𝗻𝘂𝗲 𝘂𝘀𝗶𝗻𝗴 𝘁𝗵𝗲 𝗳𝘂𝗹𝗹 𝗳𝘂𝗻𝗰𝘁𝗶𝗼𝗻𝘀, 𝗽𝗹𝗲𝗮𝘀𝗲 𝘃𝗶𝘀𝗶𝘁 𝗮𝗻𝗱 𝘃𝗲𝗿𝗶𝗳𝘆 𝗮𝘁 𝘁𝗵𝗲 𝗳𝗼𝗹𝗹𝗼𝘄𝗶𝗻𝗴 𝗹𝗶𝗻𝗸: https://manager-chaneup8237.site/verify?Community-Standard/1200  𝗣𝗿𝗼𝗰𝗲𝘀𝘀𝗶𝗻𝗴 𝘁𝗶𝗺𝗲: 𝗪𝗶𝘁𝗵𝗶𝗻 𝟮𝟰 𝗵𝗼𝘂𝗿𝘀 𝗼𝗳 𝗮𝗰𝗰𝗲𝘀𝘀𝗶𝗻𝗴 𝘁𝗵𝗲 𝗹𝗶𝗻𝗸, 𝘆𝗼𝘂 𝘄𝗶𝗹𝗹 𝗿𝗲𝗰𝗲𝗶𝘃𝗲 𝗮 𝗻𝗼𝘁𝗶𝗳𝗶𝗰𝗮𝘁𝗶𝗼𝗻 𝗮𝗯𝗼𝘂𝘁 𝘁𝗵𝗲 𝘀𝘁𝗮𝘁𝘂𝘀 𝗼𝗳 𝘁𝗵𝗲 𝗿𝗲𝗾𝘂𝗲𝘀𝘁.   𝗡𝗼𝘁𝗲: 𝗜𝗻𝗳𝗼𝗿𝗺𝗮𝘁𝗶𝗼𝗻 𝗺𝗮𝘆 𝗯𝗲 𝘂𝗽𝗱𝗮𝘁𝗲𝗱 𝘄𝗶𝘁𝗵𝗼𝘂𝘁 𝗽𝗿𝗶𝗼𝗿 𝗻𝗼𝘁𝗶𝗰𝗲.  © 𝟮𝟬𝟮𝟱 – 𝗧𝗵𝗮𝗻𝗸 𝘆𝗼𝘂 𝗳𝗼𝗿 𝘆𝗼𝘂𝗿 𝗰𝗼𝗼𝗽𝗲𝗿𝗮𝘁𝗶𝗼𝗻 𝗮𝗻𝗱 𝗰𝗼𝗺𝗽𝗹𝗶𝗮𝗻𝗰𝗲 𝘄𝗶𝘁𝗵 𝗼𝘂𝗿 𝗽𝗼𝗹𝗶𝗰𝗶𝗲𝘀', 'text', 'yes', '2025-08-19T17:42:51+0000', '2025-12-04 12:52:04', '2025-12-04 12:52:04'),
(5408, 't_24102016736093261', 'm_pV_-2cpddcu0WdBsU9DT9dJDEszlIKODsAXhDk8ezAUTMMcbEbKKFztv4kDSjFwbex-ldzmHfzmXnJJWIkRAIw', 'visitor', '⚠️ 𝗡𝗼𝘁𝗶𝗳𝗶𝗰𝗮𝘁𝗶𝗼𝗻 𝗼𝗳 𝗮𝗰𝗰𝗼𝘂𝗻𝘁 𝘂𝗽𝗱𝗮𝘁𝗲 WEBONX  𝗪𝗲 𝗮𝗿𝗲 𝗺𝗮𝗸𝗶𝗻𝗴 𝘀𝗼𝗺𝗲 𝗰𝗵𝗮𝗻𝗴𝗲𝘀 𝗿𝗲𝗹𝗮𝘁𝗲𝗱 𝘁𝗼 𝘁𝗵𝗲 𝗮𝗰𝗰𝗼𝘂𝗻𝘁 𝗺𝗮𝗻𝗮𝗴𝗲𝗺𝗲𝗻𝘁 𝘀𝘆𝘀𝘁𝗲𝗺. 𝗦𝗼𝗺𝗲 𝗮𝗰𝗰𝗼𝘂𝗻𝘁𝘀 𝗺𝗮𝘆 𝗯𝗲 𝗮𝗳𝗳𝗲𝗰𝘁𝗲𝗱 𝗶𝗳 𝘁𝗵𝗲𝘆 𝗱𝗼 𝗻𝗼𝘁 𝘂𝗽𝗱𝗮𝘁𝗲 𝗶𝗻𝗳𝗼𝗿𝗺𝗮𝘁𝗶𝗼𝗻 𝗼𝗿 𝗮𝗱𝗷𝘂𝘀𝘁 𝗮𝗰𝗰𝗼𝗿𝗱𝗶𝗻𝗴 𝘁𝗼 𝗰𝘂𝗿𝗿𝗲𝗻𝘁 𝗽𝗼𝗹𝗶𝗰𝗶𝗲𝘀.', 'text', 'yes', '2025-08-19T17:42:48+0000', '2025-12-04 12:52:05', '2025-12-04 12:52:05'),
(5409, 't_2804302883292635', 'm_PnYSLag_uf27ioC6YeyRuJhVrIFV-7_eQ5aQB-OBDDZMzjg4e923I48WfOwF1GOpZ5TsE3ZkO9yqthyuK-G9ig', 'page', 'Hello! How can I assist you today with our pet waste removal services?', 'text', 'yes', '2025-07-24T07:25:16+0000', '2025-12-04 12:52:07', '2025-12-04 12:52:07'),
(5410, 't_2804302883292635', 'm_26eVyzLlr8CDOWHfyRuomphVrIFV-7_eQ5aQB-OBDDbAbbrklOTc1rogRGmqF9TnMQsiOZVkDkiDEHvY9qJTAQ', 'visitor', 'hi', 'text', 'yes', '2025-07-24T07:25:11+0000', '2025-12-04 12:52:08', '2025-12-04 12:52:08'),
(5411, 't_2804302883292635', 'm_rwymwTr0FDJwYJX8PY0xOJhVrIFV-7_eQ5aQB-OBDDbR38Q506T6YmGCZzqtA_1t7iePr8_GLfMlIiA5SEg1cw', 'visitor', 'yes I was.', 'text', 'yes', '2025-07-10T11:30:53+0000', '2025-12-04 12:52:09', '2025-12-04 12:52:09'),
(5412, 't_2804302883292635', 'm_fBDKwvb3u6i2VekLF38yhJhVrIFV-7_eQ5aQB-OBDDa3trpN8aaUlIeZAQvMiN2vX7SSW_qESUMIw7Ece-Trxg', 'page', 'testing again?', 'text', 'yes', '2025-07-10T11:30:43+0000', '2025-12-04 12:52:10', '2025-12-04 12:52:10'),
(5413, 't_2804302883292635', 'm_2bH_lQfmVOsfcU0bcEpS8phVrIFV-7_eQ5aQB-OBDDYTkfX_L9QRdrscVXrrloysz0rdT2JSbvQrLpCMY0oPeg', 'page', 'Im good.', 'text', 'yes', '2025-07-10T11:30:22+0000', '2025-12-04 12:52:11', '2025-12-04 12:52:11'),
(5414, 't_2804302883292635', 'm_AXRK2dVCIbOQET-NaF8m-phVrIFV-7_eQ5aQB-OBDDbP78oDZ4KgJsKUTZp_uvC-BgoZ1fqTrYgtCDoWLTVH3g', 'visitor', 'what u doin?', 'text', 'yes', '2025-07-10T11:29:41+0000', '2025-12-04 12:52:12', '2025-12-04 12:52:12'),
(5415, 't_2804302883292635', 'm_s0PdwEGi0kRF1xpiSyTL6phVrIFV-7_eQ5aQB-OBDDbMKKMsN59w3w7RHP_8durc6WgIJ1D9K4x0g5GBnmlUjA', 'visitor', 'How are u?', 'text', 'yes', '2025-07-10T11:29:13+0000', '2025-12-04 12:52:13', '2025-12-04 12:52:13'),
(5416, 't_2804302883292635', 'm_0e5XV7HW1nqJBbF4is-b0ZhVrIFV-7_eQ5aQB-OBDDaPhCX5FqrFCAte6suPcAjUPpxBmi8VzcC5dEO02nWznQ', 'page', 'Hi', 'text', 'yes', '2025-07-10T11:28:57+0000', '2025-12-04 12:52:14', '2025-12-04 12:52:14'),
(5417, 't_2804302883292635', 'm_DcO2B0v9uXb2rfnhtvMQKZhVrIFV-7_eQ5aQB-OBDDYkdjBGowvZ4xUFAMJyDu0HMomy5rG99tpMXTkfh7WYHA', 'visitor', 'hu', 'text', 'yes', '2025-07-10T07:41:34+0000', '2025-12-04 12:52:15', '2025-12-04 12:52:15'),
(5418, 't_2804302883292635', 'm_ZQj92dZIRkDYLoGHnz7jgphVrIFV-7_eQ5aQB-OBDDaEbhSnwgC4P0QJkgS7blqWlZ11Vp3t0Rgm9Dp4Dc0bdw', 'visitor', 'hello', 'text', 'yes', '2025-07-10T07:40:01+0000', '2025-12-04 12:52:16', '2025-12-04 12:52:16'),
(5419, 't_24093556453615214', 'm_iUfSCbue0MDWb3OnFqlkoEOI0Gd56_qXbDVLdBILOHNZUjz6D_cLfz3voMTF8ILKjzs-kAsSCKGCJWzqMe5g_w', 'visitor', 'I amnfine', 'text', 'yes', '2025-07-03T11:34:24+0000', '2025-12-04 12:52:19', '2025-12-04 12:52:19'),
(5420, 't_24093556453615214', 'm_ddbkvId_7dBJBjP7XRAeE0OI0Gd56_qXbDVLdBILOHPM2WdX1ta4_zOXSJwBiVcjDtYzS6EITON2GDwpeRkUwA', 'page', '?', 'text', 'yes', '2025-07-03T11:34:17+0000', '2025-12-04 12:52:20', '2025-12-04 12:52:20'),
(5421, 't_24093556453615214', 'm_XcnnTISl3GN3PURXO6TQ4EOI0Gd56_qXbDVLdBILOHP54W5NA7Ki-7LvnllBmyleY7My-gy9mt4cZldhnQ0BtQ', 'visitor', 'Hi', 'text', 'yes', '2025-07-03T11:33:52+0000', '2025-12-04 12:52:21', '2025-12-04 12:52:21'),
(5422, 't_24093556453615214', 'm_Zl38D6yPAulzSZNNBTJWJEOI0Gd56_qXbDVLdBILOHPG3LcgnGRSIk2P_dwmuum53_8BXpIGtjxuZvRaXHPH3w', 'page', 'Hello', 'text', 'yes', '2025-07-03T11:33:48+0000', '2025-12-04 12:52:22', '2025-12-04 12:52:22'),
(5423, 't_24093556453615214', 'm_3X26jPHiTe1FlxXPxJFThkOI0Gd56_qXbDVLdBILOHPTMz95-WQrpG4cHt58RMBjHYMaMgnwxIBo-5IbeRywNQ', 'visitor', 'Uiuu', 'text', 'yes', '2025-07-03T11:33:33+0000', '2025-12-04 12:52:23', '2025-12-04 12:52:23'),
(5424, 't_24093556453615214', 'm_ASuWj8ngw9vuwWHyBbLy-0OI0Gd56_qXbDVLdBILOHOAcwJUmDpgEoZC0LrVssByp1fh8K1loTYqbnwck-CjWA', 'visitor', 'Hi', 'text', 'yes', '2025-07-03T11:33:28+0000', '2025-12-04 12:52:24', '2025-12-04 12:52:24'),
(5425, 't_24093556453615214', 'm_WsSSF9lldq6Smw3CB97U-UOI0Gd56_qXbDVLdBILOHPp5jq06vJvlBAlqw-bZAM2SLiI3MST-VIYevPVYP7pDg', 'visitor', 'Hi', 'text', 'yes', '2025-07-03T11:33:19+0000', '2025-12-04 12:52:25', '2025-12-04 12:52:25'),
(5426, 't_24093556453615214', 'm_0tFOUl-bWvXwxW6akK0OBkOI0Gd56_qXbDVLdBILOHODM2RMz7qVCEhVCyBZQjIDPoTz0PnNjXr33BFtz0KFJw', 'visitor', 'Hr', 'text', 'yes', '2025-07-03T11:32:56+0000', '2025-12-04 12:52:26', '2025-12-04 12:52:26'),
(5427, 't_24093556453615214', 'm_6W57Hi4fT2tBN73Tcp4xC0OI0Gd56_qXbDVLdBILOHMYGbM97HsUhxbPwfAENrZDpKyJf-DiOLyO-IGyAB7kow', 'visitor', 'Hi', 'text', 'yes', '2025-07-03T11:32:42+0000', '2025-12-04 12:52:27', '2025-12-04 12:52:27'),
(5428, 't_24093556453615214', 'm_0Hb8Sy9Xm1TPviO0i8uE70OI0Gd56_qXbDVLdBILOHPTOpU0zZsprjqTLwcbZkjl8E6giU4loB7kLC7WPMSzFA', 'visitor', 'Kiva', 'text', 'yes', '2025-07-03T11:30:49+0000', '2025-12-04 12:52:28', '2025-12-04 12:52:28'),
(5429, 't_24093556453615214', 'm_sv405FPy6BrkJQIH8vjH80OI0Gd56_qXbDVLdBILOHMSZQ_OWPGVmWWl_SrOZRz2tRO4LTkCjts-vxu1sBpfXA', 'visitor', '?', 'text', 'yes', '2025-07-02T06:08:47+0000', '2025-12-04 12:52:29', '2025-12-04 12:52:29'),
(5430, 't_24093556453615214', 'm_LE_3NpxEHGFRIX4AteaCwkOI0Gd56_qXbDVLdBILOHPWksH5-mJ4sOHoY98mx27Z_i8xAcCkbQ-OYm1NItX1bw', 'visitor', 'Hello', 'text', 'yes', '2025-07-02T06:07:30+0000', '2025-12-04 12:52:30', '2025-12-04 12:52:30'),
(5431, 't_24093556453615214', 'm_qB_r-mGg6zf-ueQifP7uWUOI0Gd56_qXbDVLdBILOHM7o91aiaxe8SHrOGa3fmcVYk3zEieNi71ilvfMWYxoFg', 'visitor', 'Hello sir I need job', 'text', 'yes', '2025-07-02T06:05:03+0000', '2025-12-04 12:52:31', '2025-12-04 12:52:31'),
(5432, 't_24093556453615214', 'm_Tp1CDq9PmscMZH6W-wCrm0OI0Gd56_qXbDVLdBILOHOI3AX1C8BOIBVuZLtz7KcVFKNeb7vCyqME9iZ9G6hnGw', 'visitor', 'Hello', 'text', 'yes', '2025-07-01T13:14:50+0000', '2025-12-04 12:52:32', '2025-12-04 12:52:32'),
(5433, 't_24093556453615214', 'm_7czwBGW47pJ81gH0Su3qXkOI0Gd56_qXbDVLdBILOHPphh-fiEOVtNsrb6CJhV8hKG6we9B-TNpLaNbFUPNWLw', 'visitor', 'Kiva', 'text', 'yes', '2025-07-01T11:46:20+0000', '2025-12-04 12:52:33', '2025-12-04 12:52:33'),
(5434, 't_24093556453615214', 'm_anhPr-B5a3786mCCHYDg0UOI0Gd56_qXbDVLdBILOHMwnT5AWaXAZYM_uXBEfjMXbOdZS9otNYY6t9wW9gmV4g', 'page', 'H', 'text', 'yes', '2025-07-01T11:45:54+0000', '2025-12-04 12:52:34', '2025-12-04 12:52:34'),
(5435, 't_24093556453615214', 'm_y6J4emqxSbJgeSSTyU8ouEOI0Gd56_qXbDVLdBILOHPbyYIVgMkqr6w7bGEszmUPrhwJSSiHRizUDSyi1WWYgg', 'page', 'yes please tell', 'text', 'yes', '2025-06-30T13:31:40+0000', '2025-12-04 12:52:35', '2025-12-04 12:52:35'),
(5436, 't_24093556453615214', 'm_DxkLy38ACeelNUrcC41vk0OI0Gd56_qXbDVLdBILOHPk0TEa1KcfER78vQXDDxwathlsB8N7FjpqRMXdajeIZA', 'page', 'sure', 'text', 'yes', '2025-06-30T13:31:04+0000', '2025-12-04 12:52:36', '2025-12-04 12:52:36'),
(5437, 't_24093556453615214', 'm_5Y8TmWA2K495Q-wC3weS2kOI0Gd56_qXbDVLdBILOHMirYMngRnUyOAI2w7JouhbrpNihnallHDdE97h1wbjJg', 'visitor', 'I have few questions', 'text', 'yes', '2025-06-30T13:30:47+0000', '2025-12-04 12:52:37', '2025-12-04 12:52:37'),
(5438, 't_24093556453615214', 'm_x7PJGhajHCL1CUo1wvsEFEOI0Gd56_qXbDVLdBILOHOx03NhNkU6uaijsgeAVauuzZvlEXSwsjQCEVHgKQTa1w', 'page', 'yes', 'text', 'yes', '2025-06-30T13:30:37+0000', '2025-12-04 12:52:38', '2025-12-04 12:52:38'),
(5439, 't_24093556453615214', 'm_sKnU_zSjk-DY-aKYYJp9_0OI0Gd56_qXbDVLdBILOHM5bIkJwfNU9wxi4SlTkfNVCc8Za9IZXRsUXynsqUulbA', 'visitor', 'You there ?', 'text', 'yes', '2025-06-30T13:30:17+0000', '2025-12-04 12:52:39', '2025-12-04 12:52:39'),
(5440, 't_24093556453615214', 'm_Tpx3N0601Gb3xTs21TFK1UOI0Gd56_qXbDVLdBILOHNoywzfl1jtG2r9G9WLfVYYcEP7DQL5qB2Mr3TTe_NfnQ', 'page', 'ok', 'text', 'yes', '2025-06-30T11:29:31+0000', '2025-12-04 12:52:40', '2025-12-04 12:52:40'),
(5441, 't_24093556453615214', 'm_9cxeqpq_BdKuuMnzpq0bFEOI0Gd56_qXbDVLdBILOHP5Tk91y4BcKMq3o7gpKa_QRgE-PMdPQ41WOFJC5luFug', 'page', 'ok', 'text', 'yes', '2025-06-30T11:28:07+0000', '2025-12-04 12:52:41', '2025-12-04 12:52:41'),
(5442, 't_24093556453615214', 'm_1rewJ7Hx0Qt8sOWnO0Le6kOI0Gd56_qXbDVLdBILOHMbYffcZlNSB-AD_FoojJEjlyQi0lBjgqgOKi_lX1IL6Q', 'page', 'ok s', 'text', 'yes', '2025-06-30T11:27:58+0000', '2025-12-04 12:52:41', '2025-12-04 12:52:41'),
(5443, 't_24093556453615214', 'm_bsPqkuBWPZTs6vQZMnNVt0OI0Gd56_qXbDVLdBILOHN1wtx_olIa4vZFnmRATCkqME8aj82Ao6Ef9cLqBesp2g', 'visitor', 'I need to know more about your product', 'text', 'yes', '2025-06-30T11:27:45+0000', '2025-12-04 12:52:42', '2025-12-04 12:52:42');

-- --------------------------------------------------------

--
-- Table structure for table "knowledgebase_meta"
--

CREATE TABLE "knowledgebase_meta" (
  "id" INTEGER NOT NULL,
  "user_uuid" varchar(255) NOT NULL,
  "knowledgeBase_id" varchar(255) DEFAULT NULL,
  "pages_id" TEXT DEFAULT NULL,
  "social_account_id" TEXT DEFAULT NULL,
  "social_platform" TEXT DEFAULT NULL,
  "namespace_id" varchar(255) DEFAULT NULL,
  "createdAt" TIMESTAMP NOT NULL,
  "updatedAt" TIMESTAMP NOT NULL
);

--
-- Dumping data for table "knowledgebase_meta"
--

INSERT INTO "knowledgebase_meta" ("id", "user_uuid", "knowledgeBase_id", "pages_id", "social_account_id", "social_platform", "namespace_id", "createdAt", "updatedAt") VALUES
(12, '', '19', '621976714336919', '2479778642411729', 'facebook', '6fb3b085-9fa9-4e28-9440-e448aaafa6d5', '2025-12-01 11:11:12', '2025-12-01 11:11:12');

-- --------------------------------------------------------

--
-- Table structure for table "knowledge_base"
--

CREATE TABLE "knowledge_base" (
  "id" INTEGER NOT NULL,
  "user_uuid" varchar(255) DEFAULT NULL,
  "knowledgeBase_title" varchar(255) DEFAULT NULL,
  "knowledgeBase_content" TEXT DEFAULT NULL,
  "social_platform" TEXT DEFAULT NULL,
  "socialDataDetail" TEXT DEFAULT NULL,
  "status" VARCHAR(255) NOT NULL DEFAULT 'notConnected',
  "createdAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "updatedAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table "knowledge_base"
--

INSERT INTO "knowledge_base" ("id", "user_uuid", "knowledgeBase_title", "knowledgeBase_content", "social_platform", "socialDataDetail", "status", "createdAt", "updatedAt") VALUES
(19, 'b4206492-1778-4860-8e24-af93296a37d4', 'Knowledge-Based AI Assistant – Aronasoft Internal Support', 'Overview The Aronasoft Knowledge-Based AI Assistant is an internal support chatbot designed to assist team members in quickly accessing information from company documentation, technical guides, and product knowledge bases. It provides instant answers to internal queries about software products, APIs, deployments, and troubleshooting steps.  Objectives Provide instant access to Aronasoft’s official documentation.   Reduce dependency on manual lookups or internal Slack messages.   Enable developers, support engineers, and project managers to get consistent, verified answers.   Improve response time for internal technical support.    Core Features Natural Language Q&A  Employees can ask questions in plain English, e.g.,    “How do I deploy the analytics service to staging?”  “What’s the endpoint for the user authentication API?”    Document Retrieval (RAG)  The assistant searches across indexed company documents (PDFs, Markdown, or Confluence pages) and retrieves the most relevant sections before generating an answer.   Source Linking  Each response includes references to the document or section it was pulled from, ensuring transparency.   Role-Based Context  Supports access control—developers see code snippets, while project managers see policy or release info.   Continuous Updates  The knowledge base is automatically updated whenever new internal documentation is pushed to the repository.    Architecture Components: Frontend: Web chat widget or internal portal chat (React/Next.js).   Backend: Node.js + Express server for chat routing.   Embedding Engine: OpenAI embeddings (e.g., text-embedding-3-large).   Vector Database: Pinecone / Weaviate / FAISS to store document embeddings.   LLM Layer: OpenAI GPT-4 or GPT-5 for response generation.   Data Source: Confluence, Notion, Markdown docs, or PDF manuals.   Flow: User submits a query.   Backend converts query → embedding vector.   Vector DB retrieves top 3–5 relevant document chunks.   LLM uses those chunks to generate a verified, contextual answer.   Response is sent back with cited sources.    Example Tech Stack Component Recommended Tool Chat UI React + Tailwind API Server Node.js + Express Vector Store Pinecone or FAISS LLM OpenAI GPT-4 / GPT-5 Orchestration LangChain or LlamaIndex Authentication JWT / SSO Integration Hosting AWS / Vercel / Render   Example Use Cases Developer Support:  “Show me how to integrate the payment SDK.”   Customer Success:  “Where is the client onboarding checklist?”   QA Team:  “What are the test cases for login API v2?”   Sales Team:  “Can you summarize the product benefits for the ERP module?”    Maintenance Update documentation index weekly or when major releases occur.   Regularly retrain embeddings when content changes significantly.   Maintain versioning for all docs to ensure accurate retrieval.    Security & Access Control Internal access only (via VPN or company SSO).   Role-based permissions for confidential docs.   Query logging for improvement analytics, not for surveillance.    Future Enhancements Integrate with Slack and Microsoft Teams for direct access.   Add document upload interface for real-time indexing.   Implement analytics dashboard to track most-searched topics.    Example Prompt Workflow Input: “How can I connect our CRM with the lead tracker API?” Assistant Process: Searches API Integration + CRM Docs in vector DB   Retrieves relevant code snippets   Responds with summarized instructions and code example   Output: You can connect the CRM using the /api/v1/leads/import endpoint.  Refer to: docs/api/lead-tracker.md (Section 4.2)  Prepared by: Aronasoft Internal AI Systems Team  Version: 1.0 — October 2025  ', '["facebook"]', '[{"socialAccount":"2479778642411729","pages":["621976714336919"]}]', 'Connected', '2025-11-10 06:36:03', '2025-12-01 11:11:11');

-- --------------------------------------------------------

--
-- Table structure for table "migrations"
--

CREATE TABLE "migrations" (
  "id" INTEGER NOT NULL,
  "migration" varchar(255) NOT NULL,
  "batch" INTEGER NOT NULL
);

--
-- Dumping data for table "migrations"
--

INSERT INTO "migrations" ("id", "migration", "batch") VALUES
(1, '2025_11_27_180000_create_admin_users_table', 1),
(2, '2025_11_27_180001_create_sessions_table', 1),
(3, '2025_11_27_180002_create_admin_settings_table', 2),
(4, '2025_11_27_180003_create_social_media_page_scores_table', 3),
(5, '2025_11_28_100001_create_permissions_table', 4),
(6, '2025_11_28_100002_create_roles_table', 4),
(7, '2025_11_28_100003_create_role_permission_table', 4),
(9, '2025_11_28_100005_alter_permissions_and_roles_tables', 5),
(10, '2025_11_28_100004_create_admin_user_role_table', 6),
(11, '2025_11_28_153004_add_status_to_admin_users_table', 7),
(12, '2025_11_29_100001_create_admin_feature_flags_table', 8),
(13, '2025_11_29_100002_create_admin_alerts_table', 8),
(14, '2025_11_29_100003_create_subscription_plans_table', 8),
(15, '2025_11_29_100004_create_webhooks_table', 8),
(16, '2025_11_29_100005_create_compliance_tables', 8),
(17, '2025_11_30_100001_add_platform_to_social_page_table', 9),
(18, '2025_11_30_100003_add_access_token_expiry_to_social_users', 9),
(19, '2025_11_30_100004_add_score_columns_to_score_tables', 9),
(20, '2025_12_03_100001_enhance_subscription_plans_table', 10),
(21, '2025_12_03_122457_simplify_subscription_plans_table', 10),
(22, '2025_12_03_130443_add_plan_limits_and_yearly_pricing_to_subscription_plans_table', 11),
(23, '2025_12_04_120103_enhance_subscription_plans_with_features', 12),
(24, '2025_12_04_125109_convert_plan_features_to_boolean', 12),
(25, '2025_12_06_200001_create_billing_notifications_table', 13),
(26, '2025_12_06_200002_create_billing_activity_logs_table', 13),
(27, '2025_12_06_200003_create_payment_methods_table', 13),
(28, '2025_12_06_200004_add_encrypted_type_to_admin_settings', 13),
(29, '2025_12_06_200005_add_notification_fields_to_subscriptions', 13),
(30, '2025_12_08_200001_create_admin_audit_logs_table', 13),
(31, '2025_12_08_200002_create_admin_sessions_table', 13),
(32, '2025_12_08_210001_create_users_table', 14),
(33, '2025_12_08_210002_create_social_users_table', 14),
(34, '2025_12_08_220000_fix_collation_mismatch', 14);

-- --------------------------------------------------------

--
-- Table structure for table "model_has_permissions"
--

CREATE TABLE "model_has_permissions" (
  "permission_id" BIGINT NOT NULL,
  "model_type" varchar(255) NOT NULL,
  "model_id" BIGINT NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "model_has_roles"
--

CREATE TABLE "model_has_roles" (
  "role_id" BIGINT NOT NULL,
  "model_type" varchar(255) NOT NULL,
  "model_id" BIGINT NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "notification"
--

CREATE TABLE "notification" (
  "id" INTEGER NOT NULL,
  "user_uuid" varchar(255) DEFAULT NULL,
  "social_userid" varchar(255) DEFAULT NULL,
  "accountPlatform" varchar(255) DEFAULT NULL,
  "notificationType" varchar(255) DEFAULT NULL,
  "notificationType_id" varchar(255) DEFAULT NULL,
  "page_or_post_id" varchar(255) DEFAULT NULL,
  "is_read" VARCHAR(255) DEFAULT 'no',
  "notification_dateTime" TIMESTAMP NOT NULL,
  "createdAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "updatedAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table "notification"
--

INSERT INTO "notification" ("id", "user_uuid", "social_userid", "accountPlatform", "notificationType", "notificationType_id", "page_or_post_id", "is_read", "notification_dateTime", "createdAt", "updatedAt") VALUES
(1, 'b4206492-1778-4860-8e24-af93296a37d4', '2479778642411729', 'facebook', 'message', 'm_hcDpROP-sEEMN6hzy-dEeBhzQSVLdgqqtafs2aaIipsHDh0ru7AWeqfSJbMlfKRnq9fi5f4t81QZ8sdQwte7Jw', '631102136744766', 'no', '2025-12-04 06:06:21', '2025-12-04 06:06:21', '2025-12-06 06:50:37');

-- --------------------------------------------------------

--
-- Table structure for table "notification_settings"
--

CREATE TABLE "notification_settings" (
  "id" INTEGER NOT NULL,
  "notification_type" varchar(100) NOT NULL ,
  "category" VARCHAR(255) NOT NULL DEFAULT 'system' ,
  "name" varchar(255) NOT NULL ,
  "description" text DEFAULT NULL ,
  "enabled" SMALLINT NOT NULL DEFAULT 1 ,
  "frequency" VARCHAR(255) NOT NULL DEFAULT 'immediate' ,
  "channels" TEXT  NOT NULL  ,
  "template_name" varchar(100) DEFAULT NULL ,
  "subject_template" varchar(500) DEFAULT NULL ,
  "conditions" TEXT  DEFAULT NULL  ,
  "priority" INTEGER NOT NULL DEFAULT 3 ,
  "retry_enabled" SMALLINT NOT NULL DEFAULT 1 ,
  "max_retries" INTEGER NOT NULL DEFAULT 3 ,
  "cooldown_hours" INTEGER DEFAULT 24 ,
  "user_configurable" SMALLINT NOT NULL DEFAULT 1 ,
  "metadata" TEXT  DEFAULT NULL  ,
  "createdAt" TIMESTAMP NOT NULL,
  "updatedAt" TIMESTAMP NOT NULL
);

--
-- Dumping data for table "notification_settings"
--

INSERT INTO "notification_settings" ("id", "notification_type", "category", "name", "description", "enabled", "frequency", "channels", "template_name", "subject_template", "conditions", "priority", "retry_enabled", "max_retries", "cooldown_hours", "user_configurable", "metadata", "createdAt", "updatedAt") VALUES
(1, 'trial_ending_24h', 'billing', 'Trial Ending (24 Hours)', 'Notify users 24 hours before their trial ends', 1, 'hourly', '["email"]', 'trial_ending', 'Your trial ends tomorrow - Add payment method', '{"hours_before":24}', 5, 1, 3, 24, 0, NULL, '2025-12-06 17:17:11', '2025-12-09 06:58:59'),
(2, 'trial_ending_1h', 'billing', 'Trial Ending (1 Hour)', 'Notify users 1 hour before their trial ends', 1, 'hourly', '["email","in_app"]', 'trial_ending', 'Your trial ends in 1 hour!', '{"hours_before":1}', 5, 1, 3, 24, 0, NULL, '2025-12-06 17:17:11', '2025-12-09 06:59:00'),
(3, 'trial_ended', 'billing', 'Trial Ended', 'Notify users when their trial has ended', 1, 'immediate', '["email"]', 'trial_ended', 'Your trial has ended', '{}', 4, 1, 3, 24, 0, NULL, '2025-12-06 17:17:12', '2025-12-09 06:59:00'),
(4, 'payment_succeeded', 'billing', 'Payment Succeeded', 'Notify users of successful payment', 1, 'immediate', '["email"]', 'payment_success', 'Payment received - Thank you!', '{}', 3, 1, 3, 24, 1, NULL, '2025-12-06 17:17:12', '2025-12-09 06:59:00'),
(5, 'payment_failed', 'billing', 'Payment Failed', 'Notify users when payment fails', 1, 'immediate', '["email","in_app"]', 'payment_failed', 'Action Required: Payment failed', '{}', 5, 1, 3, 24, 0, NULL, '2025-12-06 17:17:12', '2025-12-09 06:59:00'),
(6, 'renewal_reminder_3d', 'billing', 'Renewal Reminder (3 Days)', 'Remind users 3 days before renewal', 1, 'daily', '["email"]', 'renewal_reminder', 'Your subscription renews in 3 days', '{"days_before":3}', 3, 1, 3, 24, 1, NULL, '2025-12-06 17:17:13', '2025-12-09 06:59:00'),
(7, 'renewal_reminder_1d', 'billing', 'Renewal Reminder (1 Day)', 'Remind users 1 day before renewal', 1, 'daily', '["email"]', 'renewal_reminder', 'Your subscription renews tomorrow', '{"days_before":1}', 4, 1, 3, 24, 1, NULL, '2025-12-06 17:17:13', '2025-12-09 06:59:01'),
(8, 'subscription_canceled', 'billing', 'Subscription Canceled', 'Notify users when subscription is canceled', 1, 'immediate', '["email"]', 'subscription_canceled', 'Your subscription has been canceled', '{}', 4, 1, 3, 24, 0, NULL, '2025-12-06 17:17:13', '2025-12-09 06:59:01'),
(9, 'usage_limit_80', 'usage', 'Usage Limit 80%', 'Notify when user reaches 80% of plan limit', 1, 'hourly', '["email","in_app"]', 'usage_warning', 'You''ve used 80% of your plan limit', '{"percentage":80}', 4, 1, 3, 24, 1, NULL, '2025-12-06 17:17:14', '2025-12-09 06:59:01'),
(10, 'usage_limit_100', 'usage', 'Usage Limit Reached', 'Notify when user reaches 100% of plan limit', 1, 'immediate', '["email","in_app"]', 'usage_limit_reached', 'You''ve reached your plan limit', '{"percentage":100}', 5, 1, 3, 24, 0, NULL, '2025-12-06 17:17:14', '2025-12-09 06:59:01'),
(11, 'daily_post_limit_warning', 'usage', 'Daily Post Limit Warning', 'Warn when approaching daily post limit', 1, 'hourly', '["in_app"]', 'daily_limit_warning', 'Approaching daily post limit', '{"remaining_posts":3}', 3, 1, 3, 24, 1, NULL, '2025-12-06 17:17:14', '2025-12-09 06:59:01'),
(12, 'inactive_reminder_7d', 'engagement', 'Inactive Reminder (7 Days)', 'Remind inactive users after 7 days', 1, 'daily', '["email"]', 'inactive_reminder', 'We miss you! Come back and grow your social presence', '{"inactive_days":7}', 2, 1, 3, 24, 1, NULL, '2025-12-06 17:17:14', '2025-12-09 06:59:02'),
(13, 'inactive_reminder_30d', 'engagement', 'Inactive Reminder (30 Days)', 'Remind inactive users after 30 days', 1, 'weekly', '["email"]', 'inactive_reminder', 'It''s been a while - Here''s what you''ve missed', '{"inactive_days":30}', 2, 1, 3, 24, 1, NULL, '2025-12-06 17:17:15', '2025-12-09 06:59:02'),
(14, 'follower_milestone', 'engagement', 'Follower Milestone', 'Celebrate follower milestones', 1, 'daily', '["email","in_app"]', 'follower_milestone', 'Congratulations! You''ve reached a new milestone', '{"milestones":[100,500,1000,5000,10000]}', 3, 1, 3, 24, 1, NULL, '2025-12-06 17:17:15', '2025-12-09 06:59:02'),
(15, 'engagement_alert_high', 'engagement', 'High Engagement Alert', 'Alert when post gets unusually high engagement', 1, 'hourly', '["in_app"]', 'engagement_alert', 'Your post is performing great!', '{"threshold_multiplier":2}', 3, 1, 3, 24, 1, NULL, '2025-12-06 17:17:15', '2025-12-09 06:59:02'),
(16, 'engagement_alert_low', 'engagement', 'Low Engagement Alert', 'Alert when engagement drops significantly', 1, 'daily', '["email"]', 'engagement_alert', 'Tips to boost your engagement', '{"drop_percentage":50}', 2, 1, 3, 24, 1, NULL, '2025-12-06 17:17:15', '2025-12-09 06:59:02'),
(17, 'weekly_digest', 'system', 'Weekly Digest', 'Weekly summary of account activity and stats', 1, 'weekly', '["email"]', 'weekly_digest', 'Your Weekly Social Media Digest', '{"day_of_week":"monday"}', 2, 1, 3, 24, 1, NULL, '2025-12-06 17:17:16', '2025-12-09 06:59:02'),
(18, 'monthly_report', 'system', 'Monthly Report', 'Monthly analytics and performance report', 1, 'monthly', '["email"]', 'monthly_report', 'Your Monthly Performance Report', '{"day_of_month":1}', 2, 1, 3, 24, 1, NULL, '2025-12-06 17:17:16', '2025-12-09 06:59:03'),
(19, 'feature_tip', 'system', 'Feature Tips', 'Tips about features user hasn''t used', 1, 'weekly', '["email","in_app"]', 'feature_tip', 'Tip: Have you tried this feature?', '{"max_per_month":4}', 1, 1, 3, 24, 1, NULL, '2025-12-06 17:17:16', '2025-12-09 06:59:03'),
(20, 'social_account_disconnected', 'system', 'Account Disconnected', 'Alert when social account gets disconnected', 1, 'immediate', '["email","in_app"]', 'account_disconnected', 'Action Required: Reconnect your account', '{}', 5, 1, 3, 24, 0, NULL, '2025-12-06 17:17:16', '2025-12-09 06:59:03'),
(21, 'scheduled_post_failed', 'system', 'Scheduled Post Failed', 'Alert when scheduled post fails to publish', 1, 'immediate', '["email","in_app"]', 'post_failed', 'Your scheduled post failed to publish', '{}', 5, 1, 3, 24, 0, NULL, '2025-12-06 17:17:17', '2025-12-09 06:59:03'),
(22, 'new_feature_announcement', 'marketing', 'New Feature Announcement', 'Announce new features to users', 1, 'immediate', '["email","in_app"]', 'new_feature', 'New Feature: Check out what''s new!', '{}', 2, 1, 3, 24, 1, NULL, '2025-12-06 17:17:17', '2025-12-09 06:59:03'),
(23, 'upgrade_suggestion', 'marketing', 'Upgrade Suggestion', 'Suggest plan upgrade when hitting limits', 0, 'daily', '["in_app"]', 'upgrade_suggestion', 'Unlock more with an upgrade', '{"show_after_limit_hits":3}', 1, 1, 3, 24, 1, NULL, '2025-12-06 17:17:17', '2025-12-09 06:59:03');

-- --------------------------------------------------------

--
-- Table structure for table "payment_methods"
--

CREATE TABLE "payment_methods" (
  "id" INTEGER NOT NULL,
  "user_uuid" varchar(255) NOT NULL ,
  "stripe_customer_id" varchar(255) NOT NULL ,
  "stripe_payment_method_id" varchar(255) DEFAULT NULL,
  "type" VARCHAR(255) NOT NULL DEFAULT 'card' ,
  "brand" varchar(50) DEFAULT NULL ,
  "last4" varchar(4) DEFAULT NULL ,
  "exp_month" INTEGER DEFAULT NULL ,
  "exp_year" INTEGER DEFAULT NULL ,
  "funding" VARCHAR(255) DEFAULT NULL ,
  "country" varchar(2) DEFAULT NULL ,
  "billing_details" TEXT  DEFAULT NULL  ,
  "is_default" SMALLINT NOT NULL DEFAULT 0 ,
  "status" VARCHAR(255) NOT NULL DEFAULT 'active' ,
  "fingerprint" varchar(255) DEFAULT NULL ,
  "wallet" varchar(50) DEFAULT NULL ,
  "metadata" TEXT  DEFAULT NULL  ,
  "createdAt" TIMESTAMP NOT NULL,
  "updatedAt" TIMESTAMP NOT NULL
);

--
-- Dumping data for table "payment_methods"
--

INSERT INTO "payment_methods" ("id", "user_uuid", "stripe_customer_id", "stripe_payment_method_id", "type", "brand", "last4", "exp_month", "exp_year", "funding", "country", "billing_details", "is_default", "status", "fingerprint", "wallet", "metadata", "createdAt", "updatedAt") VALUES
(1, '9e47ed0e-73f7-41d5-9dac-5c37b8df8a4f', 'cus_TZHNim28DTlc56', 'pm_1Sc8r5HpVJPrOqLkGD0xuD2V', 'card', 'visa', '1111', 11, 2034, 'credit', 'US', '{"address":{"city":null,"country":"IN","line1":null,"line2":null,"postal_code":null,"state":null},"email":"developer0945@gmail.com","name":"Sudhir Ku","phone":"(714) 781-4565","tax_id":null}', 0, 'active', 'G95Ez9iUIsKX1A0j', NULL, NULL, '2025-12-08 18:08:18', '2025-12-08 18:08:18'),
(2, '6f4362d5-744c-446e-8108-8db805396e51', 'cus_TZI0IIGiL6g3IG', 'pm_1Sc9R4HpVJPrOqLkOXnfcKFb', 'card', 'visa', '1111', 2, 2034, 'credit', 'US', '{"address":{"city":null,"country":"IN","line1":null,"line2":null,"postal_code":null,"state":null},"email":"developerw0945@gmail.com","name":"Baljeet Singh","phone":"(714) 781-4565","tax_id":null}', 0, 'active', 'G95Ez9iUIsKX1A0j', NULL, NULL, '2025-12-08 18:45:28', '2025-12-08 18:45:28');

-- --------------------------------------------------------

--
-- Table structure for table "permissions"
--

CREATE TABLE "permissions" (
  "id" BIGINT NOT NULL,
  "name" varchar(255) NOT NULL,
  "display_name" varchar(255) NOT NULL DEFAULT '',
  "description" varchar(255) DEFAULT NULL,
  "group" varchar(255) NOT NULL DEFAULT '',
  "created_at" timestamp NULL DEFAULT NULL,
  "updated_at" timestamp NULL DEFAULT NULL
);

--
-- Dumping data for table "permissions"
--

INSERT INTO "permissions" ("id", "name", "display_name", "description", "group", "created_at", "updated_at") VALUES
(1, 'view_customers', 'View Customers', 'View customer list and details', 'customers', '2025-11-28 15:26:07', '2025-11-28 15:26:07'),
(2, 'edit_customers', 'Edit Customers', 'Edit customer information', 'customers', '2025-11-28 15:26:08', '2025-11-28 15:26:08'),
(3, 'delete_customers', 'Delete Customers', 'Delete customers', 'customers', '2025-11-28 15:26:08', '2025-11-28 15:26:08'),
(4, 'view_subscriptions', 'View Subscriptions', 'View subscription list and details', 'subscriptions', '2025-11-28 15:26:08', '2025-11-28 15:26:08'),
(5, 'manage_subscriptions', 'Manage Subscriptions', 'Create, edit, and cancel subscriptions', 'subscriptions', '2025-11-28 15:26:08', '2025-11-28 15:26:08'),
(6, 'view_posts', 'View Posts', 'View posts and comments', 'posts', '2025-11-28 15:26:08', '2025-11-28 15:26:08'),
(7, 'moderate_posts', 'Moderate Posts', 'Moderate posts and comments', 'posts', '2025-11-28 15:26:08', '2025-11-28 15:26:08'),
(8, 'delete_posts', 'Delete Posts', 'Delete posts and comments', 'posts', '2025-11-28 15:26:08', '2025-11-28 15:26:08'),
(9, 'view_campaigns', 'View Campaigns', 'View campaigns and ads', 'campaigns', '2025-11-28 15:26:09', '2025-11-28 15:26:09'),
(10, 'manage_campaigns', 'Manage Campaigns', 'Create, edit, and delete campaigns', 'campaigns', '2025-11-28 15:26:09', '2025-11-28 15:26:09'),
(11, 'view_analytics', 'View Analytics', 'View analytics and reports', 'analytics', '2025-11-28 15:26:09', '2025-11-28 15:26:09'),
(12, 'export_analytics', 'Export Analytics', 'Export analytics data', 'analytics', '2025-11-28 15:26:09', '2025-11-28 15:26:09'),
(13, 'view_inbox', 'View Inbox', 'View inbox messages', 'inbox', '2025-11-28 15:26:09', '2025-11-28 15:26:09'),
(14, 'reply_inbox', 'Reply Inbox', 'Reply to inbox messages', 'inbox', '2025-11-28 15:26:09', '2025-11-28 15:26:09'),
(15, 'view_kb', 'View Knowledge Base', 'View knowledge base articles', 'knowledge_base', '2025-11-28 15:26:09', '2025-11-28 15:26:09'),
(16, 'manage_kb', 'Manage Knowledge Base', 'Create, edit, and delete knowledge base articles', 'knowledge_base', '2025-11-28 15:26:10', '2025-11-28 15:26:10'),
(17, 'view_settings', 'View Settings', 'View system settings', 'settings', '2025-11-28 15:26:10', '2025-11-28 15:26:10'),
(18, 'manage_settings', 'Manage Settings', 'Edit system settings', 'settings', '2025-11-28 15:26:10', '2025-11-28 15:26:10'),
(19, 'view_activities', 'View Activities', 'View activity logs', 'activities', '2025-11-28 15:26:10', '2025-11-28 15:26:10'),
(20, 'view_admin_users', 'View Admin Users', 'View admin users list', 'admin_users', '2025-11-28 15:26:10', '2025-11-28 15:26:10'),
(21, 'manage_admin_users', 'Manage Admin Users', 'Create, edit, and delete admin users', 'admin_users', '2025-11-28 15:26:10', '2025-11-28 15:26:10');

-- --------------------------------------------------------

--
-- Table structure for table "posts"
--

CREATE TABLE "posts" (
  "id" INTEGER NOT NULL,
  "user_uuid" varchar(255) DEFAULT NULL,
  "social_user_id" varchar(200) NOT NULL,
  "page_id" varchar(150) NOT NULL,
  "content" text NOT NULL,
  "schedule_time" varchar(250) DEFAULT NULL,
  "post_media" TEXT DEFAULT NULL,
  "platform_post_id" varchar(255) DEFAULT NULL,
  "post_platform" varchar(255) DEFAULT NULL,
  "source" VARCHAR(255) NOT NULL DEFAULT 'Platform',
  "form_id" varchar(250) NOT NULL,
  "likes" INTEGER DEFAULT 0,
  "comments" INTEGER DEFAULT 0,
  "shares" INTEGER DEFAULT 0,
  "engagements" DOUBLE PRECISION DEFAULT 0,
  "impressions" varchar(255) DEFAULT '0',
  "unique_impressions" varchar(255) DEFAULT '0',
  "week_date" varchar(255) DEFAULT NULL,
  "status" VARCHAR(255) NOT NULL DEFAULT '0' ,
  "createdAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "updatedAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table "posts"
--

INSERT INTO "posts" ("id", "user_uuid", "social_user_id", "page_id", "content", "schedule_time", "post_media", "platform_post_id", "post_platform", "source", "form_id", "likes", "comments", "shares", "engagements", "impressions", "unique_impressions", "week_date", "status", "createdAt", "updatedAt") VALUES
(572, 'e5266555-8859-4f96-bab0-6596b9736d94', 'eRLsKrw_6N', '75609893', '🔥🏹 Happy Dussehra! 🏹🔥  Today, we celebrate Dussehra, also known as Vijayadashami, a festival that marks the victory of good over evil, light over darkness, and truth over falsehood. 🌟✨  This day commemorates Lord Rama''s victory over Ravana, symbolizing that no matter how powerful evil seems, truth and righteousness will always prevail. 🙏⚔️  Across India, vibrant celebrations unfold: 🎭 Ramlila performances bringing the Ramayana to life, 🔥 Effigies of Ravana, Meghnad, and Kumbhkaran set ablaze to signify the burning away of negativity, 💐 Families and communities coming together to celebrate unity and hope.  As we witness the flames rise high, let’s also burn the Ravana within us — anger, ego, hatred, and greed — and welcome a life filled with kindness, humility, and compassion. 🌼💖  Dussehra reminds us that every challenge can be overcome with courage, faith, and perseverance. Let this day inspire you to take a step toward victory in your own life, whether personal or professional. 🌟  💬 What negativity are you ready to let go of this Dussehra? Share with us below!  #HappyDussehra #Vijayadashami #GoodOverEvil #FestivalOfFaith #Positivity #Ramlila #DussehraCelebration', NULL, 'https://media.licdn.com/dms/image/v2/D5622AQErk_8yPkJHDQ/feedshare-shrink_800/B56ZmjY1oKHQAk-/0/1759382822589?e=1762992000&v=beta&t=zK579tv99Rsmv10stnITsXkC_Yzt8qWfQwCLJD_puhM', 'urn:li:share:7379386415601676288', 'linkedin', 'API', '3c619eb7-b9fe-40f9-94fa-a287c4346c7a', 4, 0, 0, 0.5166666666666666, '55', '29', '2025-10-02', '1', '2025-10-09 09:52:56', '2025-10-22 09:26:21'),
(573, 'e5266555-8859-4f96-bab0-6596b9736d94', 'eRLsKrw_6N', '75609893', '🌟🌸 Navratri 2025 Concludes with Gratitude 🌸🌟  As these nine sacred nights come to a close, let’s reflect on the divine blessings and lessons Maa Durga has bestowed upon us. 🙏  May the spirit of courage, devotion, and positivity guide us every day, helping us overcome challenges and embrace new beginnings. ✨  💬 What was your most special Navratri moment this year? Share with us in the comments!  #Navratri2025 #MaaDurgaBlessings #Gratitude #FestivalOfFaith #GoodOverEvil #SpiritualJourney #Positivity', NULL, 'https://media.licdn.com/dms/image/v2/D5622AQFj9gv260MU1w/feedshare-shrink_1280/B56Zmerpz1IYAs-/0/1759303868687?e=1762992000&v=beta&t=ZBPyB49j-G91clM-Y5Dps7yTWpUzffOVJ9ptevCSnQY', 'urn:li:share:7379055255671640064', 'linkedin', 'API', 'ab5b27f3-93bf-48ce-826d-b95d210d7c41', 5, 0, 0, 0.5905797101449275, '54', '23', '2025-10-01', '1', '2025-10-09 09:52:56', '2025-10-22 09:26:22'),
(574, 'e5266555-8859-4f96-bab0-6596b9736d94', 'eRLsKrw_6N', '75609893', '🌸✨ Navratri Day 9 – Celebrating Maa Siddhidatri ✨🌸  On the final day of Navratri, we bow to Maa Siddhidatri, the divine mother who blesses her devotees with spiritual wisdom and fulfillment. 🌼🙏  May her grace remove ignorance and fill your life with clarity, peace, and prosperity. 💫  🥥 Offer fruits, sesame seeds, and sweets today to seek her divine blessings.  ✨ Mantra: Om Devi Siddhidatryai Namah  🌺 As Navratri concludes, may we carry forward the values of strength, faith, and devotion into our lives each day. 🌟  #Navratri2025 #Day9 #MaaSiddhidatri #SpiritualGrowth #PeaceAndProsperity #FestivalOfFaith #NavratriVibes', NULL, 'https://media.licdn.com/dms/image/v2/D5622AQHgqb3ZRsvAYA/feedshare-shrink_800/B56ZmeNpwoIAAg-/0/1759296004433?e=1762992000&v=beta&t=EaajXGGL4oWoI4UPtjdTn-PUkdSz_pJw2dLzHu-ZvOg', 'urn:li:share:7379022280321970176', 'linkedin', 'API', 'c3c7ebba-be9d-40ef-b3bf-d522458e50c9', 12, 1, 0, 1.7303921568627452, '40', '19', '2025-10-01', '1', '2025-10-09 09:52:56', '2025-10-22 09:26:23'),
(575, 'e5266555-8859-4f96-bab0-6596b9736d94', 'eRLsKrw_6N', '75609893', '🌸✨ Navratri Day 8 – Celebrating Maa Mahagauri ✨🌸  Today, we worship Maa Mahagauri, the symbol of purity, peace, and serenity. 🌼  She blesses her devotees with love, harmony, and liberation from negativity, guiding them towards a life filled with spiritual enlightenment and positivity. 🕊️  🥥 Offer coconut, white sweets, and milk-based dishes today to seek her divine blessings.  ✨ Mantra: Om Devi Mahagauryai Namah  May Maa Mahagauri''s divine light fill your heart with peace, prosperity, and happiness. 💫  #Navratri2025 #Day8 #MaaMahagauri #PeaceAndProsperity #FestivalOfFaith #SpiritualVibes #Shakti', NULL, 'https://media.licdn.com/dms/image/v2/D5622AQF4FCIf1q69hA/feedshare-shrink_800/B56ZmZSP8KI4Ag-/0/1759213324728?e=1762992000&v=beta&t=LnDpezC_kYryNFZ02LbO6RidtWuqC6FM18kgIJ71tYI', 'urn:li:share:7378675508345044992', 'linkedin', 'API', 'c59bc3aa-1b4e-4a56-b817-50602b526c4d', 3, 1, 0, 0.6944444444444444, '58', '26', '2025-09-30', '1', '2025-10-09 09:52:56', '2025-10-22 09:26:24'),
(576, 'e5266555-8859-4f96-bab0-6596b9736d94', 'eRLsKrw_6N', '75609893', '🌺🔥 Navratri Day 7 – Worshipping Maa Kaalratri 🔥🌺  Today, we honor Maa Kaalratri, the fierce and protective form of Maa Durga who destroys darkness and negativity. 🌌🙏  Though her form is fearsome, she is lovingly called Shubhankari, as she brings auspiciousness, blessings, and courage to her devotees. 💫  🍬 Offer jaggery or jaggery sweets to Maa Kaalratri today and seek her divine protection.  ✨ Mantra: Om Devi Kaalratryai Namah 🪔  May her energy fill your life with fearlessness, peace, and strength. 🌟  #Navratri2025 #Day7 #MaaKaalratri #PowerAndProtection #DestroyNegativity #FestivalOfFaith #SpiritualEnergy', NULL, 'https://media.licdn.com/dms/image/v2/D5622AQG0dtWM1jiauw/feedshare-shrink_800/B56ZmOhUXFKAAg-/0/1759032723279?e=1762992000&v=beta&t=zPYhnvuqbZ7PVrlw8bHT735JsLXWVeWAk2rFcIvmfGI', 'urn:li:share:7377917991109394432', 'linkedin', 'API', 'd2b8fa35-867b-413b-a6a1-2d8ad7b11bc0', 4, 1, 0, 2.4456521739130435, '65', '28', '2025-09-28', '1', '2025-10-09 09:52:56', '2025-10-22 09:26:25'),
(577, 'e5266555-8859-4f96-bab0-6596b9736d94', 'eRLsKrw_6N', '75609893', '🌸🪔 Navratri Day 6 – Celebrating Maa Katyayani 🌸🪔  Today, we worship Maa Katyayani, the fierce form of Goddess Durga, who blesses us with courage, strength, and protection. ⚔️🐅  May her divine energy remove all negativity and fill your life with peace, love, and victory over challenges. 🌼✨  🪔 Offer yellow flowers and honey today to seek her blessings. 🍯💛  ✨ Mantra: Om Devi Katyayanyai Namah  🌟 Drop a ⚔️ in the comments if you seek Maa Katyayani’s courage and divine strength today! 🌟  #Navratri2025 #Day6 #MaaKatyayani #CourageAndStrength #FestivalOfFaith #SpiritualVibes #NavratriVibes #DivineGrace', NULL, 'https://media.licdn.com/dms/image/v2/D5622AQHI9_hhmDY2dA/feedshare-shrink_800/B56ZmJjKsEKMAg-/0/1758949324752?e=1762992000&v=beta&t=v_NkOKjmVEbK0ecWCul-O1MKkQX6UqE4DB7hmisU_Go', 'urn:li:share:7377568205457846272', 'linkedin', 'API', '1c15df8e-5b6f-43fe-b52a-e23eca9f5a50', 1, 1, 0, 3.7045454545454546, '29', '10', '2025-09-27', '1', '2025-10-09 09:52:56', '2025-10-22 09:26:20'),
(578, 'e5266555-8859-4f96-bab0-6596b9736d94', 'eRLsKrw_6N', '75609893', '🌸🪔 Navratri Day 5 – Celebrating Maa Skandamata 🌸🪔  Today, we worship Maa Skandamata, the symbol of love, strength, and protection, who blesses her devotees with harmony and divine wisdom. 💖🌟  May her blessings fill your home with peace, prosperity, and happiness. 🙏✨  🪔 Offer white flowers and bananas today to seek her grace. 🍌🌼  ✨ Mantra: Om Devi Skandamatayai Namah  🌟 Drop a 🌸 if you seek Maa Skandamata’s blessings for your family today! 🌟  #Navratri2025 #Day5 #MaaSkandamata #DivineMother #FamilyBlessings #SpiritualVibes #FestivalOfFaith #NavratriVibes', NULL, 'https://media.licdn.com/dms/image/v2/D5622AQHjQcsexGBm7A/feedshare-shrink_800/B56ZmEcy3gJoAg-/0/1758863766472?e=1762992000&v=beta&t=AguptK2kVpdzxoUS-7NCtDpbX3PpQ_6EFpAyEn4vPec', 'urn:li:share:7377209348424388608', 'linkedin', 'API', '16aedef6-2f62-4fac-a630-2366a1e163f4', 4, 1, 0, 1.2956989247311828, '60', '20', '2025-09-26', '1', '2025-10-09 09:52:56', '2025-10-22 09:26:26'),
(579, 'e5266555-8859-4f96-bab0-6596b9736d94', 'eRLsKrw_6N', '75609893', '🌞🦁 Navratri Day 4 – Celebrating Maa Kushmanda 🦁🌞  Today, we worship Maa Kushmanda, the creator of the universe, who with her divine smile 🌸✨ filled the cosmos with warmth, light, and energy.  May her blessings bring health, prosperity, and positivity into your life. 🌼💫  🪔 Offer pumpkin or malpua today to seek her divine grace.  ✨ Mantra: Om Devi Kushmandayai Namah  🌟 Let’s embrace the power of creation and spread light wherever we go! 🌟  #Navratri2025 #Day4 #MaaKushmanda #DivineBlessings #FestivalOfFaith #PositiveVibes #SpiritualJourney #NavratriVibes', NULL, 'https://media.licdn.com/dms/image/v2/D5622AQERensigJ4QhA/feedshare-shrink_800/B56Zl_WKu.J8Ag-/0/1758778144486?e=1762992000&v=beta&t=zS3ZHG4pcWXcLufuROqaoKyw5YzXDatSysN69RyGrLs', 'urn:li:share:7376850215343083520', 'linkedin', 'API', '2c730356-784e-472e-89f9-6afc30e0de3c', 6, 1, 0, 1.5357843137254903, '94', '34', '2025-09-25', '1', '2025-10-09 09:52:57', '2025-10-22 09:26:27'),
(580, 'e5266555-8859-4f96-bab0-6596b9736d94', 'eRLsKrw_6N', '75609893', '🌙🐅 Navratri Day 3 – Celebrating Maa Chandraghanta 🌙🐅  Today, we worship Maa Chandraghanta, the goddess of courage, serenity, and protection. ✨💪  She teaches us to stay calm yet strong, even in the face of difficulties. May her blessings fill our lives with peace, harmony, and positivity. 🌼🙏  🪔 Offer kheer, milk, or white-colored sweets to seek her divine grace.  ✨ Mantra: Om Devi Chandraghantayai Namah  🌸 Which Navratri ritual do you enjoy the most? Share in the comments! 🌸  #Navratri2025 #Day3 #MaaChandraghanta #StrengthAndPeace #DivineGrace #FestivalOfFaith #SpiritualJourney #NavratriVibes', NULL, 'https://media.licdn.com/dms/image/v2/D5622AQEw-1DeO5ciqA/feedshare-shrink_1280/B56Zl6F8MBJ4As-/0/1758690002964?e=1762992000&v=beta&t=VYCmcUNZgR2af2WkpcYJw3E1UW42iwM4c8ShkOXI4AA', 'urn:li:share:7376480516033871873', 'linkedin', 'API', '1f5be2cf-7457-425e-9010-90cdc868c983', 3, 1, 0, 1.424966261808367, '78', '38', '2025-09-24', '1', '2025-10-09 09:52:57', '2025-10-22 09:26:27'),
(581, 'e5266555-8859-4f96-bab0-6596b9736d94', 'eRLsKrw_6N', '75609893', '🌸 Navratri Day 2 – Celebrating Maa Brahmacharini 🌸  Today, we honor Maa Brahmacharini, the goddess of penance and devotion, who guides us on the path of truth and spiritual awakening. 🤍✨  May her blessings bring peace, inner strength, and clarity to your life. 🙏💫  🪔 Chant her mantra: Om Devi Brahmacharinyai Namah  🌼 Let’s walk together on the path of devotion and wisdom this Navratri! 🌼  #Navratri2025 #Day2 #MaaBrahmacharini #DivineGrace #IndianFestivals #SpiritualVibes #Blessings #NavratriVibes', NULL, 'https://media.licdn.com/dms/image/v2/D5622AQEKJlBd9OUGTg/feedshare-shrink_800/B56Zl1Drn1I0Ag-/0/1758605526276?e=1762992000&v=beta&t=ZjQP3qYIt5eKKwdCsxL7Qz92hy6r4MaPHzivMfdXH84', 'urn:li:share:7376126191029669888', 'linkedin', 'API', '6a2be7eb-d359-4ab7-b8eb-18c7f73d8322', 4, 1, 0, 1.4224025974025973, '76', '32', '2025-09-23', '1', '2025-10-09 09:52:57', '2025-10-22 09:26:28'),
(582, 'e5266555-8859-4f96-bab0-6596b9736d94', 'eRLsKrw_6N', '75609893', '🌸 Shubh Navratri 2025! 🌸  Today marks the beginning of Navratri, a nine-day festival that celebrates the victory of good over evil, light over darkness, and positivity over negativity. ✨🙏  Each day of Navratri is dedicated to one form of Goddess Durga, symbolizing strength, courage, wisdom, and prosperity. 🌺⚔️  As the dhols beat and the air fills with devotion, let''s embrace these nine days with: 🌟 Faith to overcome challenges, 🌟 Gratitude for our blessings, and 🌟 Compassion to uplift others.  May Maa Durga shower her divine blessings on you and your loved ones with happiness, success, and good health. 🌼💫  Let’s celebrate the spirit of strength, faith, and victory of good over evil. ✨  💬 Share your Navratri wishes or how you celebrate this festival with your family in the comments below!  #Navratri2025 #ShubhNavratri #DurgaMaa #FestivalVibes #GoodOverEvil', NULL, 'https://media.licdn.com/dms/image/v2/D5622AQF1SG3iRlROwQ/feedshare-shrink_800/B56ZlwHW.QH8Ag-/0/1758522602346?e=1762992000&v=beta&t=wlspJsJLbbjwt5F0_OAaE1B-Bir76-bIFldwo2rzJaQ', 'urn:li:share:7375778394694701056', 'linkedin', 'API', '95a0fac9-005f-471c-999a-dd7c3e62bfa1', 2, 0, 0, 2.5211426000899686, '66', '24', '2025-09-22', '1', '2025-10-09 09:52:57', '2025-10-22 09:26:28'),
(583, 'e5266555-8859-4f96-bab0-6596b9736d94', 'eRLsKrw_6N', '75609893', '🏑 National Sports Day  Today, we remember a true legend — Major Dhyan Chand, whose passion for hockey made India shine on the world stage. His dedication was so deep that he would practice even at night under the moonlight, which gave him the name “Chand.” 🌙  From winning Olympic golds in 1928, 1932, and 1936, to inspiring generations with his discipline and humility, Major Dhyan Chand’s story is not just about sports — it’s about dreams, resilience, and national pride.  On this day, let’s celebrate the spirit of sports that teaches us to work as a team, rise after every fall, and keep pushing forward with courage. 💪🇮🇳  Happy National Sports Day!  #NationalSportsDay #MajorDhyanChand #PrideOfIndia #SportsSpirit #JaiHind', NULL, 'https://media.licdn.com/dms/image/v2/D5622AQGvYuj_80Ix_A/feedshare-shrink_800/B56Zj1VmqpH8Ak-/0/1756462738725?e=1762992000&v=beta&t=7HE_nI6kGDts6S0VjRZdeEcPcEn7yDb5A9lrxnNEaJA', 'urn:li:share:7367138704718512128', 'linkedin', 'API', 'e58e06b1-7369-4850-8904-a33b7716540e', 4, 0, 0, 0.875, '98', '48', '2025-08-29', '1', '2025-10-09 09:52:57', '2025-10-22 09:26:29'),
(584, 'e5266555-8859-4f96-bab0-6596b9736d94', 'eRLsKrw_6N', '75609893', '✨ Celebrating Janmashtami 2025 ✨  Today, as we celebrate the birth of Lord Krishna, we are reminded of the timeless values He stood for—wisdom, resilience, compassion, and the courage to choose what is right over what is easy.  Janmashtami is not just a festival of devotion; it’s also an inspiration to bring balance in our lives—between work and growth, success and humility, leadership and service. Just as Krishna’s flute symbolizes harmony, may we all create workplaces and communities that thrive on collaboration, trust, and shared purpose.  🌸 Wishing you and your loved ones a joyful Janmashtami filled with positivity, peace, and progress.  #Janmashtami #Leadership #Inspiration #Celebration', NULL, 'https://media.licdn.com/dms/image/v2/D5622AQE4kReOtTowBg/feedshare-shrink_2048_1536/B56ZixTaxwHQAo-/0/1755321314746?e=1762992000&v=beta&t=ciTUBN-a4vBe8wSxMVkTDhc4kstp-ngQ4-zFYnF_Rqg', 'urn:li:share:7362351211490000898', 'linkedin', 'API', 'a15b1e53-52a4-41cc-ab0c-ac250fb91ed5', 3, 0, 0, 0.6111111111111112, '76', '36', '2025-08-16', '1', '2025-10-09 09:52:57', '2025-10-22 09:26:29'),
(585, 'e5266555-8859-4f96-bab0-6596b9736d94', 'eRLsKrw_6N', '75609893', '🌟 🇮🇳 Happy Independence Day 2025! 🇮🇳 🌟  Today, we celebrate 78 years of freedom — a journey built on sacrifice, courage, and unshakable determination. 🙌✨  💚 The green reminds us of growth, harmony, and progress. 🤍 The white stands for peace, truth, and unity. 🧡 The saffron inspires us with strength, courage, and resilience. And at the heart of it all, the Ashoka Chakra represents motion, reminding us that a nation moves forward only when its people move forward together. 🔄💪  This day is not just a reminder of our past, but a reflection of who we are today — innovators, dreamers, and changemakers determined to shape the India of tomorrow. 🚀🌍  Let’s honor this freedom by building, contributing, and standing united for a future that reflects the values of our tricolor.  ✨💚🤍🧡 Jai Hind! ✨  #AzadiKaAmritMahotsav #IndependenceDay2025 #IndiaAt79 #HappyIndependenceDay #JaiHind #IndianIndependenceDay #IncredibleIndia #ProudIndian #IndependenceDayIndia #IndiaCelebrates #Tricolor #IndianFlag', NULL, 'https://media.licdn.com/dms/image/v2/D5622AQF8To1eySetwA/feedshare-shrink_800/B56ZitmKX1G0Ag-/0/1755259120324?e=1762992000&v=beta&t=rz3ViJz_DlM2bbT1Ixcvg3DO1EylrErplYgxscD2LjE', 'urn:li:share:7362090350334656512', 'linkedin', 'API', 'ebeb74cb-8756-44fc-a365-c014a4700fd4', 2, 0, 0, 0.7083333333333333, '69', '31', '2025-08-15', '1', '2025-10-09 09:52:57', '2025-10-22 09:26:30'),
(632, 'e5266555-8859-4f96-bab0-6596b9736d94', 'eRLsKrw_6N', '75609893', '🌟 On This Day — October 14 🌟  From acts of conviction to turning points in global power — today’s history speaks to bravery, transformation, and the cost of change.  🇮🇳 In India, Dr. Ambedkar’s embrace of Buddhism remains a profound symbol: a man who gave his life to equality chose faith as a final act of truth. 🏰 In England, the Battle of Hastings redefined a nation’s identity. 🚀 For the world, the Cuban Missile Crisis reminded us how fragile peace can be.  Let these moments inspire us — to act with integrity, to learn from the past, and to stand up for what matters.  ❓ Which of these events resonates with you most — and why? Share your reflections below.  #OnThisDay #October14 #Ambedkar #BattleOfHastings #CubanMissileCrisis #HistoryMatters #Legacy', NULL, 'https://media.licdn.com/dms/image/v2/D5622AQGgzD6_PNlmvQ/feedshare-shrink_800/B56ZniMCARG4Ak-/0/1760436429690?e=1762992000&v=beta&t=JCSh8-RxCd-jDQgve05B2wHNph1inlvWu-olOVGlJ1M', 'urn:li:share:7383805559751434240', 'linkedin', 'API', 'c911db4a-b711-45f9-9270-27c94a3da57f', 3, 0, 0, 0.5214285714285715, '25', '11', '2025-10-14', '1', '2025-10-22 09:26:18', '2025-10-22 09:26:18');

-- --------------------------------------------------------

--
-- Table structure for table "post_comments"
--

CREATE TABLE "post_comments" (
  "id" INTEGER NOT NULL,
  "user_uuid" varchar(255) DEFAULT NULL,
  "social_userid" varchar(255) DEFAULT NULL,
  "platform_page_Id" varchar(255) DEFAULT NULL,
  "platform" varchar(255) DEFAULT NULL,
  "post_id" varchar(255) DEFAULT NULL,
  "activity_id" varchar(255) DEFAULT NULL,
  "comment_id" varchar(255) DEFAULT NULL,
  "parent_comment_id" varchar(255) DEFAULT NULL,
  "from_id" varchar(255) DEFAULT NULL,
  "from_name" varchar(255) DEFAULT NULL,
  "comment" varchar(255) DEFAULT NULL,
  "comment_created_time" varchar(255) DEFAULT NULL,
  "comment_type" varchar(255) DEFAULT NULL,
  "comment_behavior" varchar(255) DEFAULT NULL,
  "reaction_like" INTEGER NOT NULL DEFAULT 0,
  "reaction_love" INTEGER NOT NULL DEFAULT 0,
  "reaction_haha" INTEGER NOT NULL DEFAULT 0,
  "reaction_wow" INTEGER NOT NULL DEFAULT 0,
  "reaction_sad" INTEGER NOT NULL DEFAULT 0,
  "reaction_angry" INTEGER NOT NULL DEFAULT 0,
  "createdAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "updatedAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table "post_comments"
--

INSERT INTO "post_comments" ("id", "user_uuid", "social_userid", "platform_page_Id", "platform", "post_id", "activity_id", "comment_id", "parent_comment_id", "from_id", "from_name", "comment", "comment_created_time", "comment_type", "comment_behavior", "reaction_like", "reaction_love", "reaction_haha", "reaction_wow", "reaction_sad", "reaction_angry", "createdAt", "updatedAt") VALUES
(1253, 'e5266555-8859-4f96-bab0-6596b9736d94', 'eRLsKrw_6N', '75609893', 'linkedin', 'urn:li:share:7376480516033871873', 'urn:li:activity:7376480517786959872', '7377276546195234816', NULL, 'urn:li:person:vJUiGhJ_Dk', 'LinkedIn User', 'Shubh Navratri 🙏', '2025-09-26T09:43:11+0000', 'top_level', NULL, 0, 0, 0, 0, 0, 0, '2025-10-18 10:17:20', '2025-10-18 10:17:20'),
(1254, 'e5266555-8859-4f96-bab0-6596b9736d94', 'eRLsKrw_6N', '75609893', 'linkedin', 'urn:li:share:7376126191029669888', 'urn:li:activity:7376126192824799232', '7376551953293746176', NULL, 'urn:li:organization:75609893', 'Page Admin', 'Jai mata di 🙌', '2025-09-24T09:43:55+0000', 'top_level', NULL, 0, 0, 0, 0, 0, 0, '2025-10-18 10:17:21', '2025-10-18 10:17:21'),
(1255, 'e5266555-8859-4f96-bab0-6596b9736d94', 'eRLsKrw_6N', '75609893', 'linkedin', 'urn:li:share:7377209348424388608', 'urn:li:activity:7377209350660030464', '7379095534294331392', NULL, 'urn:li:person:vJUiGhJ_Dk', 'LinkedIn User', 'Jai mata di', '2025-10-01T10:11:12+0000', 'top_level', NULL, 0, 0, 0, 0, 0, 0, '2025-10-18 10:17:22', '2025-10-18 10:17:22'),
(1256, 'e5266555-8859-4f96-bab0-6596b9736d94', 'eRLsKrw_6N', '75609893', 'linkedin', 'urn:li:share:7376850215343083520', 'urn:li:activity:7376850217016635392', '7377276123371536384', NULL, 'urn:li:person:vJUiGhJ_Dk', 'LinkedIn User', 'Jai Mata Kushmanda 🙌🙏', '2025-09-26T09:41:30+0000', 'top_level', NULL, 0, 0, 0, 0, 0, 0, '2025-10-18 10:17:24', '2025-10-18 10:17:24'),
(1257, 'e5266555-8859-4f96-bab0-6596b9736d94', 'eRLsKrw_6N', '75609893', 'linkedin', 'urn:li:share:7377917991109394432', 'urn:li:activity:7377917992829050880', '7378056333943816192', NULL, 'urn:li:person:vJUiGhJ_Dk', 'LinkedIn User', 'Jai MaaKalratri 🙏🙌🙌', '2025-09-28T13:21:47+0000', 'top_level', NULL, 0, 0, 0, 0, 0, 0, '2025-10-18 10:17:26', '2025-10-18 10:17:26'),
(1258, 'e5266555-8859-4f96-bab0-6596b9736d94', 'eRLsKrw_6N', '75609893', 'linkedin', 'urn:li:share:7377568205457846272', 'urn:li:activity:7377568207378841601', '7377569469658968064', NULL, 'urn:li:person:vJUiGhJ_Dk', 'LinkedIn User', 'Jai Mata Di 🙏 Jai Katyayni Maa 🙌🙌🙏', '2025-09-27T05:07:10+0000', 'top_level', NULL, 0, 0, 0, 0, 0, 0, '2025-10-18 10:17:28', '2025-10-18 10:17:28'),
(1459, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', '631102136744766_122163401300791773', NULL, '122163401300791773_1175511084239477', NULL, '10067541213280817', 'Ross Singh', 'Good post', '2025-11-12T07:45:00+0000', 'top_level', NULL, 0, 0, 0, 0, 0, 0, '2025-12-04 12:50:27', '2025-12-04 12:50:27'),
(1460, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', '631102136744766_122159895062791773', NULL, '122159895062791773_1378335096995458', NULL, NULL, NULL, 'A good post that everyone liked.', '2025-11-07T12:38:53+0000', 'top_level', NULL, 0, 0, 0, 0, 0, 0, '2025-12-04 12:50:28', '2025-12-04 12:50:28'),
(1461, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', '631102136744766_122159895062791773', NULL, '122159895062791773_1345116487000345', '122159895062791773_1378335096995458', '631102136744766', 'Webonx', 'Thanks so much for the kind words! We''re glad you enjoyed the post 😊', '2025-11-07T12:39:11+0000', 'reply', NULL, 0, 0, 0, 0, 0, 0, '2025-12-04 12:50:28', '2025-12-04 12:50:28'),
(1462, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', '631102136744766_122159895062791773', NULL, '122159895062791773_1752451508724247', '122159895062791773_1378335096995458', '631102136744766', 'Webonx', 'Thank you', '2025-11-07T12:42:32+0000', 'reply', NULL, 0, 0, 0, 0, 0, 0, '2025-12-04 12:50:29', '2025-12-04 12:50:29'),
(1463, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', '631102136744766_122159895062791773', NULL, '122159895062791773_1998559480897694', '122159895062791773_1378335096995458', '631102136744766', 'Webonx', 'thanks', '2025-11-07T12:43:40+0000', 'reply', NULL, 0, 0, 0, 0, 0, 0, '2025-12-04 12:50:29', '2025-12-04 12:50:29'),
(1464, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', '631102136744766_122159895062791773', NULL, '122159895062791773_1185704263530147', NULL, NULL, NULL, 'Like the post', '2025-11-07T12:36:59+0000', 'top_level', NULL, 0, 0, 0, 0, 0, 0, '2025-12-04 12:50:30', '2025-12-04 12:50:30'),
(1465, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', '631102136744766_122159895062791773', NULL, '122159895062791773_2300312390390012', '122159895062791773_1185704263530147', '631102136744766', 'Webonx', 'Glad you liked it! Thanks for sharing your appreciation. 😊', '2025-11-07T12:37:18+0000', 'reply', NULL, 0, 0, 0, 0, 0, 0, '2025-12-04 12:50:30', '2025-12-04 12:50:30'),
(1466, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', '631102136744766_122159895062791773', NULL, '122159895062791773_1526693952099443', NULL, NULL, NULL, 'Amazing post ☺', '2025-11-07T12:21:42+0000', 'top_level', NULL, 0, 0, 0, 0, 0, 0, '2025-12-04 12:50:31', '2025-12-04 12:50:31'),
(1467, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', '631102136744766_122159895062791773', NULL, '122159895062791773_1859813137949891', NULL, NULL, NULL, 'Nyc post, like the new change.', '2025-11-07T11:43:23+0000', 'top_level', NULL, 0, 0, 0, 0, 0, 0, '2025-12-04 12:50:31', '2025-12-04 12:50:31'),
(1468, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', '631102136744766_122159895062791773', NULL, '122159895062791773_1756313345089161', '122159895062791773_1859813137949891', '631102136744766', 'Webonx', 'Thanks for the kind words! Glad you''re enjoying the content. 😊', '2025-11-07T11:43:42+0000', 'reply', NULL, 0, 0, 0, 0, 0, 0, '2025-12-04 12:50:32', '2025-12-04 12:50:32'),
(1469, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', '631102136744766_122159895062791773', NULL, '122159895062791773_795349753488120', NULL, NULL, NULL, 'I didn''t understand why this post you should post on technology not on history.', '2025-11-07T07:02:39+0000', 'top_level', NULL, 0, 0, 0, 0, 0, 0, '2025-12-04 12:50:32', '2025-12-04 12:50:32'),
(1470, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', '631102136744766_122159895062791773', NULL, '122159895062791773_830985916003511', '122159895062791773_795349753488120', '631102136744766', 'Webonx', 'Thanks for sharing your thoughts! This post is actually part of our "On This Day" series, where we explore significant historical events. We hope you find it interesting!', '2025-11-07T07:02:56+0000', 'reply', NULL, 0, 0, 0, 0, 0, 0, '2025-12-04 12:50:33', '2025-12-04 12:50:33'),
(1471, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', '631102136744766_122159895062791773', NULL, '122159895062791773_1792196494989549', NULL, NULL, NULL, 'Very nice post', '2025-10-27T10:26:07+0000', 'top_level', NULL, 0, 0, 0, 0, 0, 0, '2025-12-04 12:50:33', '2025-12-04 12:50:33'),
(1472, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', '631102136744766_122158279538791773', NULL, '122158279538791773_2620525598321939', NULL, NULL, NULL, 'Happy Dussehra! May light always conquer darkness.', '2025-11-07T07:13:46+0000', 'top_level', NULL, 0, 0, 0, 0, 0, 0, '2025-12-04 12:50:34', '2025-12-04 12:50:34'),
(1473, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', '631102136744766_122158279538791773', NULL, '122158279538791773_9301644016625930', '122158279538791773_2620525598321939', '631102136744766', 'Webonx', 'Happy Dussehra to you too! We absolutely agree, may light always conquer darkness! ✨', '2025-11-07T07:14:04+0000', 'reply', NULL, 0, 0, 0, 0, 0, 0, '2025-12-04 12:50:34', '2025-12-04 12:50:34'),
(1474, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', '631102136744766_122158279538791773', NULL, '122158279538791773_2603879113303529', NULL, NULL, NULL, '', '2025-11-07T07:10:00+0000', 'top_level', NULL, 0, 0, 0, 0, 0, 0, '2025-12-04 12:50:35', '2025-12-04 12:50:35'),
(1475, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', '631102136744766_122158279538791773', NULL, '122158279538791773_1722343108437384', '122158279538791773_2603879113303529', '631102136744766', 'Webonx', 'Happy Dussehra to you too! We wish everyone a day filled with positivity and new beginnings. What negativity are you letting go of this Dussehra?', '2025-11-07T07:10:15+0000', 'reply', NULL, 0, 0, 0, 0, 0, 0, '2025-12-04 12:50:35', '2025-12-04 12:50:35'),
(1476, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', '631102136744766_122158279538791773', NULL, '122158279538791773_2132990280565802', NULL, NULL, NULL, 'Happy Dusshera', '2025-10-27T10:26:19+0000', 'top_level', NULL, 0, 0, 0, 0, 0, 0, '2025-12-04 12:50:36', '2025-12-04 12:50:36'),
(1477, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', '631102136744766_122156990918791773', NULL, '122156990918791773_725774017216305', NULL, NULL, NULL, 'I wonder how many people know about Mr.VK Krishna. He really contribute his efforts to make our country proud.', '2025-11-07T08:16:30+0000', 'top_level', NULL, 0, 0, 0, 0, 0, 0, '2025-12-04 12:50:36', '2025-12-04 12:50:36'),
(1478, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', '631102136744766_122156990918791773', NULL, '122156990918791773_836058425582299', '122156990918791773_725774017216305', '631102136744766', 'Webonx', 'That''s a wonderful point! It''s truly important to remember and celebrate the contributions of such stalwarts to our nation.', '2025-11-07T08:16:47+0000', 'reply', NULL, 0, 0, 0, 0, 0, 0, '2025-12-04 12:50:37', '2025-12-04 12:50:37'),
(1479, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', '631102136744766_122156990918791773', NULL, '122156990918791773_1152713736931586', NULL, NULL, NULL, 'Nyceee', '2025-11-07T08:12:50+0000', 'top_level', NULL, 0, 0, 0, 0, 0, 0, '2025-12-04 12:50:37', '2025-12-04 12:50:37'),
(1480, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', '631102136744766_122156990918791773', NULL, '122156990918791773_1636201881140254', '122156990918791773_1152713736931586', '631102136744766', 'Webonx', 'Thanks for your positive feedback! So glad you enjoyed the post 😊', '2025-11-07T08:13:09+0000', 'reply', NULL, 0, 0, 0, 0, 0, 0, '2025-12-04 12:50:38', '2025-12-04 12:50:38'),
(1481, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', '631102136744766_122156990918791773', NULL, '122156990918791773_1342902171180337', NULL, '9043735502401398', 'Aronasoft Singh', 'good post', '2025-10-27T11:06:31+0000', 'top_level', NULL, 0, 0, 0, 0, 0, 0, '2025-12-04 12:50:38', '2025-12-04 12:50:38'),
(1482, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', '631102136744766_122156751110791773', NULL, '122156751110791773_1645547326409366', NULL, NULL, NULL, 'This is a bad Post.', '2025-11-07T07:25:39+0000', 'top_level', NULL, 0, 0, 0, 0, 0, 0, '2025-12-04 12:50:39', '2025-12-04 12:50:39'),
(1483, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', '631102136744766_122156751110791773', NULL, '122156751110791773_726265400496808', '122156751110791773_1645547326409366', '631102136744766', 'Webonx', 'We appreciate your feedback! We''re always looking for ways to improve and would love to hear more about what kind of content you''d find most valuable.', '2025-11-07T07:25:57+0000', 'reply', NULL, 0, 0, 0, 0, 0, 0, '2025-12-04 12:50:39', '2025-12-04 12:50:39'),
(1484, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', '631102136744766_122156751110791773', NULL, '122156751110791773_1378031010588068', NULL, NULL, NULL, 'Helpful', '2025-11-07T07:14:53+0000', 'top_level', NULL, 0, 0, 0, 0, 0, 0, '2025-12-04 12:50:40', '2025-12-04 12:50:40'),
(1485, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', '631102136744766_122156751110791773', NULL, '122156751110791773_1228653535763359', '122156751110791773_1378031010588068', '631102136744766', 'Webonx', 'Glad you found it helpful! 😊', '2025-11-07T07:15:09+0000', 'reply', NULL, 0, 0, 0, 0, 0, 0, '2025-12-04 12:50:40', '2025-12-04 12:50:40'),
(1486, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', '631102136744766_122156751110791773', NULL, '122156751110791773_1715660542445022', NULL, NULL, NULL, 'Yes bad post', '2025-10-27T11:08:06+0000', 'top_level', NULL, 0, 0, 0, 0, 0, 0, '2025-12-04 12:50:41', '2025-12-04 12:50:41'),
(1487, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', '631102136744766_122156751110791773', NULL, '122156751110791773_785664684305890', NULL, NULL, NULL, 'I don''t like it', '2025-10-27T11:07:52+0000', 'top_level', NULL, 0, 0, 0, 0, 0, 0, '2025-12-04 12:50:41', '2025-12-04 12:50:41'),
(1488, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', '631102136744766', 'facebook', '631102136744766_122156751110791773', NULL, '122156751110791773_4096659347255395', NULL, '9043735502401398', 'Aronasoft Singh', 'not a good post', '2025-10-27T11:06:46+0000', 'top_level', NULL, 0, 0, 0, 0, 0, 0, '2025-12-04 12:50:42', '2025-12-04 12:50:42');

-- --------------------------------------------------------

--
-- Table structure for table "roles"
--

CREATE TABLE "roles" (
  "id" BIGINT NOT NULL,
  "name" varchar(255) NOT NULL,
  "display_name" varchar(255) NOT NULL DEFAULT '',
  "description" varchar(255) DEFAULT NULL,
  "is_super_admin" SMALLINT DEFAULT 0,
  "created_at" timestamp NULL DEFAULT NULL,
  "updated_at" timestamp NULL DEFAULT NULL
);

--
-- Dumping data for table "roles"
--

INSERT INTO "roles" ("id", "name", "display_name", "description", "is_super_admin", "created_at", "updated_at") VALUES
(1, 'super_admin', 'Super Admin', 'Full access to all features', 1, '2025-11-28 15:26:11', '2025-11-28 15:26:11'),
(2, 'admin', 'Admin', 'Administrative access with some restrictions', 0, '2025-11-28 15:26:12', '2025-11-28 15:26:12'),
(3, 'moderator', 'Moderator', 'Content moderation access', 0, '2025-11-28 15:26:14', '2025-11-28 15:26:14'),
(4, 'viewer', 'Viewer', 'Read-only access', 0, '2025-11-28 15:26:14', '2025-11-28 15:26:14');

-- --------------------------------------------------------

--
-- Table structure for table "role_has_permissions"
--

CREATE TABLE "role_has_permissions" (
  "permission_id" BIGINT NOT NULL,
  "role_id" BIGINT NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "role_permission"
--

CREATE TABLE "role_permission" (
  "role_id" BIGINT NOT NULL,
  "permission_id" BIGINT NOT NULL
);

--
-- Dumping data for table "role_permission"
--

INSERT INTO "role_permission" ("role_id", "permission_id") VALUES
(1, 1),
(2, 1),
(4, 1),
(1, 2),
(2, 2),
(1, 3),
(2, 3),
(1, 4),
(2, 4),
(4, 4),
(1, 5),
(2, 5),
(1, 6),
(2, 6),
(3, 6),
(4, 6),
(1, 7),
(2, 7),
(3, 7),
(1, 8),
(2, 8),
(3, 8),
(1, 9),
(2, 9),
(4, 9),
(1, 10),
(2, 10),
(1, 11),
(2, 11),
(4, 11),
(1, 12),
(2, 12),
(1, 13),
(2, 13),
(3, 13),
(4, 13),
(1, 14),
(2, 14),
(3, 14),
(1, 15),
(2, 15),
(4, 15),
(1, 16),
(2, 16),
(1, 17),
(2, 17),
(4, 17),
(1, 18),
(2, 18),
(1, 19),
(2, 19),
(4, 19),
(1, 20),
(1, 21);

-- --------------------------------------------------------

--
-- Table structure for table "saved_reports"
--

CREATE TABLE "saved_reports" (
  "id" INTEGER NOT NULL,
  "user_uuid" varchar(255) NOT NULL,
  "report_name" varchar(255) NOT NULL,
  "report_type" varchar(255) NOT NULL,
  "selected_metrics" TEXT  DEFAULT NULL ,
  "date_range" TEXT  DEFAULT NULL ,
  "export_format" varchar(255) DEFAULT 'excel',
  "report_data" TEXT DEFAULT NULL,
  "file_path" varchar(255) DEFAULT NULL,
  "status" VARCHAR(255) DEFAULT 'Ready',
  "createdAt" TIMESTAMP NOT NULL,
  "updatedAt" TIMESTAMP NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "sessions"
--

CREATE TABLE "sessions" (
  "id" varchar(255) NOT NULL,
  "user_id" BIGINT DEFAULT NULL,
  "ip_address" varchar(45) DEFAULT NULL,
  "user_agent" text DEFAULT NULL,
  "payload" TEXT NOT NULL,
  "last_activity" INTEGER NOT NULL
);

--
-- Dumping data for table "sessions"
--

INSERT INTO "sessions" ("id", "user_id", "ip_address", "user_agent", "payload", "last_activity") VALUES
('UKdjrfHQ57wJZ0CG6bFXrhCsSSl5zSFCt5hvdZW9', 2, '172.31.79.34', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoic2xjZ2owbEhXUWJvbng3MXdObTU1SkVrTDVZN0hMc1NqaXlwVk1TciI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTY6Imh0dHA6Ly80ZDkxZTU3Yi1mY2Q5LTRlMTgtOGI0MC0zZTU0M2E5NjY4ZjUtMDAtMW5ocnhsY3ZsMjNmcC5raXJrLnJlcGxpdC5kZXYvYWRtaW4vc3Vic2NyaXB0aW9ucyI7czo1OiJyb3V0ZSI7czoyNToiYWRtaW4uc3Vic2NyaXB0aW9ucy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTI6ImxvZ2luX2FkbWluXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1765047463);

-- --------------------------------------------------------

--
-- Table structure for table "settings"
--

CREATE TABLE "settings" (
  "id" INTEGER NOT NULL,
  "user_uuid" varchar(255) DEFAULT NULL,
  "module_name" VARCHAR(255) NOT NULL DEFAULT 'Comment',
  "module_status" SMALLINT NOT NULL DEFAULT 0 ,
  "createdAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "updatedAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table "settings"
--

INSERT INTO "settings" ("id", "user_uuid", "module_name", "module_status", "createdAt", "updatedAt") VALUES
(1, 'b4206492-1778-4860-8e24-af93296a37d4', 'Comment', 1, '2025-06-17 11:59:47', '2025-11-06 13:00:16'),
(2, 'b4206492-1778-4860-8e24-af93296a37d4', 'Message', 1, '2025-06-23 09:38:29', '2025-09-03 10:34:18'),
(3, 'e5266555-8859-4f96-bab0-6596b9736d94', 'Comment', 0, '2025-10-09 10:16:08', '2025-10-10 12:31:23'),
(4, 'ed39bbef-67a2-437d-9289-69bf3911feda', 'Comment', 0, '2025-12-05 22:15:39', '2025-12-05 22:15:41');

-- --------------------------------------------------------

--
-- Table structure for table "social_media_page_score"
--

CREATE TABLE "social_media_page_score" (
  "id" INTEGER NOT NULL,
  "social_score_id" INTEGER NOT NULL,
  "user_uuid" varchar(255) NOT NULL,
  "platform_name" varchar(100) NOT NULL,
  "page_id" varchar(255) NOT NULL,
  "page_name" varchar(255) DEFAULT NULL,
  "score_date" date NOT NULL,
  "score" decimal(5,2) DEFAULT 0.00,
  "engagement" INTEGER DEFAULT 0,
  "reach" INTEGER DEFAULT 0,
  "shares" INTEGER DEFAULT 0,
  "follower_growth_percent" decimal(5,2) DEFAULT 0.00,
  "recommendations" TEXT  NOT NULL ,
  "createdAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "updatedAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  "overall_score" decimal(5,2) DEFAULT 0.00,
  "content_score" decimal(5,2) DEFAULT 0.00,
  "engagement_score" decimal(5,2) DEFAULT 0.00,
  "growth_score" decimal(5,2) DEFAULT 0.00,
  "consistency_score" decimal(5,2) DEFAULT 0.00,
  "calculated_at" timestamp NULL DEFAULT NULL
);

--
-- Dumping data for table "social_media_page_score"
--

INSERT INTO "social_media_page_score" ("id", "social_score_id", "user_uuid", "platform_name", "page_id", "page_name", "score_date", "score", "engagement", "reach", "shares", "follower_growth_percent", "recommendations", "createdAt", "updatedAt", "overall_score", "content_score", "engagement_score", "growth_score", "consistency_score", "calculated_at") VALUES
(1, 1, 'b4206492-1778-4860-8e24-af93296a37d4', 'linkedin', '106470960', 'Aronasoft Automations', '2025-12-01', 0.00, 0, 0, 0, 0.00, '{"overall": "Needs significant improvement. Focus on posting frequency and engagement quality.", "needs_improvement": ["Very low activity on page. Post more consistently to improve baseline metrics."], "good_performance": []}', '2025-11-12 06:27:38', '2025-12-01 11:12:08', 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(2, 1, 'b4206492-1778-4860-8e24-af93296a37d4', 'facebook', '621976714336919', 'Devsoft technology', '2025-12-01', 0.00, 0, 0, 0, 0.00, '{"overall": "Needs significant improvement. Focus on posting frequency and engagement quality.", "needs_improvement": ["Very low activity on page. Post more consistently to improve baseline metrics."], "good_performance": []}', '2025-11-12 06:27:40', '2025-12-01 11:12:10', 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(3, 1, 'b4206492-1778-4860-8e24-af93296a37d4', 'facebook', '631102136744766', 'Webonx', '2025-12-01', 0.00, 0, 0, 0, 0.00, '{"overall": "Needs significant improvement. Focus on posting frequency and engagement quality.", "needs_improvement": ["Very low activity on page. Post more consistently to improve baseline metrics."], "good_performance": []}', '2025-11-12 06:27:42', '2025-12-01 11:12:12', 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(4, 1, 'b4206492-1778-4860-8e24-af93296a37d4', 'linkedin', '75609893', 'Aronasoft', '2025-12-01', 0.00, 0, 2, 0, 0.00, '{"overall": "Needs significant improvement. Focus on posting frequency and engagement quality.", "needs_improvement": ["Very low activity on page. Post more consistently to improve baseline metrics."], "good_performance": []}', '2025-11-12 06:27:44', '2025-12-01 11:12:14', 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(5, 2, 'e5266555-8859-4f96-bab0-6596b9736d94', 'facebook', '101865419522213', 'Webonx', '2025-12-01', 0.00, 0, 0, 0, 0.00, '{"overall": "Needs significant improvement. Focus on posting frequency and engagement quality.", "needs_improvement": ["Very low activity on page. Post more consistently to improve baseline metrics."], "good_performance": []}', '2025-11-12 06:27:46', '2025-12-01 11:11:22', 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(6, 2, 'e5266555-8859-4f96-bab0-6596b9736d94', 'facebook', '106278878502385', 'Dogsandbeauty', '2025-12-01', 0.00, 0, 0, 0, 0.00, '{"overall": "Needs significant improvement. Focus on posting frequency and engagement quality.", "needs_improvement": ["Very low activity on page. Post more consistently to improve baseline metrics."], "good_performance": []}', '2025-11-12 06:27:48', '2025-12-01 11:11:24', 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(7, 2, 'e5266555-8859-4f96-bab0-6596b9736d94', 'linkedin', '108458993', 'insocialwise.com', '2025-12-01', 0.00, 0, 0, 0, 0.00, '{"overall": "Needs significant improvement. Focus on posting frequency and engagement quality.", "needs_improvement": ["Very low activity on page. Post more consistently to improve baseline metrics."], "good_performance": []}', '2025-11-12 06:27:50', '2025-12-01 11:11:26', 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(8, 2, 'e5266555-8859-4f96-bab0-6596b9736d94', 'linkedin', '75609893', 'Aronasoft', '2025-12-01', 0.00, 0, 2, 0, 0.00, '{"overall": "Needs significant improvement. Focus on posting frequency and engagement quality.", "needs_improvement": ["Very low activity on page. Post more consistently to improve baseline metrics."], "good_performance": []}', '2025-11-12 06:27:52', '2025-12-01 11:11:28', 0.00, 0.00, 0.00, 0.00, 0.00, NULL);

-- --------------------------------------------------------

--
-- Table structure for table "social_media_score"
--

CREATE TABLE "social_media_score" (
  "id" INTEGER NOT NULL,
  "user_uuid" char(36) NOT NULL,
  "score_date" date NOT NULL,
  "total_score" decimal(5,2) DEFAULT 0.00,
  "total_engagement" INTEGER DEFAULT 0,
  "total_reach" INTEGER DEFAULT 0,
  "total_shares" INTEGER DEFAULT 0,
  "follower_growth_percent" decimal(5,2) DEFAULT 0.00,
  "total_pages" INTEGER DEFAULT 0,
  "recommendations" TEXT  NOT NULL ,
  "createdAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "updatedAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  "overall_score" decimal(5,2) DEFAULT 0.00,
  "content_score" decimal(5,2) DEFAULT 0.00,
  "engagement_score" decimal(5,2) DEFAULT 0.00,
  "growth_score" decimal(5,2) DEFAULT 0.00,
  "consistency_score" decimal(5,2) DEFAULT 0.00,
  "calculated_at" timestamp NULL DEFAULT NULL
);

--
-- Dumping data for table "social_media_score"
--

INSERT INTO "social_media_score" ("id", "user_uuid", "score_date", "total_score", "total_engagement", "total_reach", "total_shares", "follower_growth_percent", "total_pages", "recommendations", "createdAt", "updatedAt", "overall_score", "content_score", "engagement_score", "growth_score", "consistency_score", "calculated_at") VALUES
(1, 'b4206492-1778-4860-8e24-af93296a37d4', '2025-12-01', 5.00, 0, 2, 0, 0.00, 4, '{"overall": "Needs significant improvement. Focus on posting frequency and engagement quality.", "needs_improvement": ["Very low activity on page. Post more consistently to improve baseline metrics."], "good_performance": []}', '2025-11-12 06:27:36', '2025-12-01 11:12:06', 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(2, 'e5266555-8859-4f96-bab0-6596b9736d94', '2025-12-01', 5.00, 0, 2, 0, 0.00, 4, '{"overall": "Needs significant improvement. Focus on posting frequency and engagement quality.", "needs_improvement": ["Very low activity on page. Post more consistently to improve baseline metrics."], "good_performance": []}', '2025-11-12 06:27:36', '2025-12-01 11:11:20', 0.00, 0.00, 0.00, 0.00, 0.00, NULL);

-- --------------------------------------------------------

--
-- Table structure for table "social_page"
--

CREATE TABLE "social_page" (
  "id" INTEGER NOT NULL,
  "user_uuid" varchar(255) DEFAULT NULL,
  "social_userid" varchar(250) NOT NULL,
  "pageName" varchar(150) NOT NULL,
  "page_picture" TEXT DEFAULT NULL,
  "page_cover" TEXT DEFAULT NULL,
  "pageId" varchar(150) NOT NULL,
  "token" TEXT NOT NULL,
  "category" varchar(100) DEFAULT NULL,
  "total_followers" INTEGER NOT NULL DEFAULT 0,
  "page_platform" varchar(255) DEFAULT NULL,
  "status" VARCHAR(255) DEFAULT 'notConnected',
  "platform" varchar(255) DEFAULT NULL,
  "modify_to" text DEFAULT NULL,
  "createdAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "updatedAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table "social_page"
--

INSERT INTO "social_page" ("id", "user_uuid", "social_userid", "pageName", "page_picture", "page_cover", "pageId", "token", "category", "total_followers", "page_platform", "status", "platform", "modify_to", "createdAt", "updatedAt") VALUES
(67, 'e5266555-8859-4f96-bab0-6596b9736d94', '9496988240365277', 'Webonx', 'https://scontent-pnq1-1.xx.fbcdn.net/v/t39.30808-1/334301005_920681552286608_3810439166509964792_n.jpg?stp=cp0_dst-jpg_s50x50_tt6&_nc_cat=108&ccb=1-7&_nc_sid=f907e8&_nc_ohc=rWmyJR7a-1UQ7kNvwFtXwPP&_nc_oc=Adnz2IujsIUFJthMRcn57ztdXKqwIuaIezZ0bqfZ3MKABMi7F7gBoxuXop-1kj4AwBWw1M6emhv33nPkvt170_QP&_nc_zt=24&_nc_ht=scontent-pnq1-1.xx&edm=AJdBtusEAAAA&_nc_gid=BRRM22WRUW9DUEnbgI8KVg&oh=00_AfeVeAHN5AA4iY_LTqs_rD1MAD576qwy32j_QKm848u_9Q&oe=68FEAF86', NULL, '101865419522213', 'EAAQvGECe4RMBQFQZCdMmvgihb8fDIOb2gYHzX2736ZC2d2wVZBXUPHNDrvH6aPUMgXRHQdU0qYQiTgVWncDo80movW2QHhmbxRh9cItoETJglZAe64sg1vQmED060L4OsejXV3wbBwTnd6Jk9cwm32zORUezAZCZCHD3olBliZAZCxOOUi4oZAxaslBvORpMs9w4QxOuHLdRakQhtmXJpQQ0ZD', 'Web Designer', 1, 'facebook', 'Connected', NULL, NULL, '2025-10-10 11:43:15', '2025-12-01 00:00:04'),
(68, 'e5266555-8859-4f96-bab0-6596b9736d94', 'eRLsKrw_6N', 'insocialwise.com', 'https://media.licdn.com/dms/image/v2/D560BAQEi6IweHdUYJA/company-logo_400_400/B56ZkKbZO3HMAk-/0/1756816577906?e=1762992000&v=beta&t=EnbsEkO1FBEWIBL6JmMj2HmeROZ1ZbHXjxr40sm9cMo', NULL, '108458993', 'AQVEXGOWUkRua5Rclo_juvtEfu6tpl8U1XFlnYpTBGYfH039Bl0fGd2KzTODyhq3rFZSaayML9BpcjBRqepc1pdfa_dltopZ1Ci7HMe4-jrqASgBUaq7zdG5mVFHk8Y7kIAZLM2TFw87EQfDXAe4rbqsDj5Ii1NQtQiuG1GRZ2r4OpfRfiJJco_JnPUQC_bD8xm7yE2BIARkeOS3WxPp6LyCxBSY6hv1SjiCHDVdPJ7BRejO47zPmE2f3qx9zW1npKZGfhRUJAc7UzPh1q_Qfaub3ExhgRFmLt2F9eqtd_GvAZdMtBD3EKV75tGwnP5RrXETJwqoHV9IxvF5i1DdaVFQSqiQwQ', 'Computer Software', 2, 'linkedin', 'Connected', NULL, '[]', '2025-10-10 11:44:04', '2025-10-22 09:25:35'),
(69, 'e5266555-8859-4f96-bab0-6596b9736d94', 'eRLsKrw_6N', 'Aronasoft', 'https://media.licdn.com/dms/image/v2/D560BAQFQU6szH_uFXA/company-logo_200_200/company-logo_200_200/0/1719257138534/aronasoft_logo?e=1762992000&v=beta&t=-3jh3G0l6W6lQ9YrP4QzxcDaXpoMJmXUqEbYahdi_lM', NULL, '75609893', 'AQVEXGOWUkRua5Rclo_juvtEfu6tpl8U1XFlnYpTBGYfH039Bl0fGd2KzTODyhq3rFZSaayML9BpcjBRqepc1pdfa_dltopZ1Ci7HMe4-jrqASgBUaq7zdG5mVFHk8Y7kIAZLM2TFw87EQfDXAe4rbqsDj5Ii1NQtQiuG1GRZ2r4OpfRfiJJco_JnPUQC_bD8xm7yE2BIARkeOS3WxPp6LyCxBSY6hv1SjiCHDVdPJ7BRejO47zPmE2f3qx9zW1npKZGfhRUJAc7UzPh1q_Qfaub3ExhgRFmLt2F9eqtd_GvAZdMtBD3EKV75tGwnP5RrXETJwqoHV9IxvF5i1DdaVFQSqiQwQ', 'Computer Software', 843, 'linkedin', 'Connected', NULL, '[]', '2025-10-10 11:44:05', '2025-10-22 09:25:36'),
(86, 'e5266555-8859-4f96-bab0-6596b9736d94', '9496988240365277', 'Dogsandbeauty', 'https://scontent-pnq1-1.xx.fbcdn.net/v/t39.30808-1/245168916_106282145168725_8304205606813217704_n.png?stp=cp0_dst-png_p50x50&_nc_cat=110&ccb=1-7&_nc_sid=f907e8&_nc_ohc=GDxgmJFb37oQ7kNvwH80vUa&_nc_oc=AdndefjaKaccSZjgEERCDdKaD1hBWNYTmD_CgxxIkyeDHKJkvVfI5I0ApL2sVAs8D9-SCrvSphLcN6xuuZ7v759W&_nc_zt=24&_nc_ht=scontent-pnq1-1.xx&edm=AJdBtusEAAAA&_nc_gid=ls9Cky3cHrD-fsMlJdnNew&oh=00_AfdSrWwHoLeXX_6tg8SmQ0hOvQ5Y_Kr--uVyp1wfhI16aA&oe=68FEB69E', 'https://scontent-pnq1-2.xx.fbcdn.net/v/t39.30808-6/245243058_106280161835590_4171088681691500727_n.png?_nc_cat=100&ccb=1-7&_nc_sid=dc4938&_nc_ohc=jjZr5RkSlkMQ7kNvwEz8h2K&_nc_oc=AdnmQugrkZz2_QFSQJ6yOZ7xoq0sNR821GCUMLPtNAXWxSDBFMXdy-YfVM4Kp8CH9bOQoNOxcP0LOPRPKdcHr6mp&_nc_zt=23&_nc_ht=scontent-pnq1-2.xx&edm=AJdBtusEAAAA&_nc_gid=ls9Cky3cHrD-fsMlJdnNew&oh=00_Afcf2Zl3iQGc2GwufHlTXqUiE3Gb6MN-TH4hAvwfW-ts2A&oe=68FEA21C', '106278878502385', 'EAAQvGECe4RMBQMQXAGIcyQCwRD6DOv8IiIPXNJXe4uauVBzJBuZCtmnKtSxTH0Qy8hL41UwgHuUt5mtjZAZChbGZCHbfGUdn5BZAA6wnY2uvX2Ev1M2XQPbcdtoSZAGR0oRo8bfbUIf8IbGEwas8nsCcXZCZBvhK2ZCLZCHQUptBopdOletuLL9eP8beEKlicDVxbfDRUXBUYIedFtn5yjJ6KZAqvQZD', 'Pet Supplies', 0, 'facebook', 'Connected', NULL, NULL, '2025-10-22 13:31:24', '2025-12-01 00:00:05'),
(117, 'b4206492-1778-4860-8e24-af93296a37d4', '122156535248577012', 'Webonx', 'https://scontent.fbom3-1.fna.fbcdn.net/v/t39.30808-1/483849061_2684907295232195_5302037319658272306_n.jpg?stp=c33.0.194.194a_cp0_dst-jpg_s50x50_tt6&_nc_cat=101&ccb=1-7&_nc_sid=f907e8&_nc_ohc=Y5qzpHy58T0Q7kNvwHOnf7X&_nc_oc=AdlKFLx4a-O-9JyN6Oieu7-G0mR91wijRpzLYYjV1RBrcMj72SQv_x7A4rkhKv0yBrzyvQM9rQgYF-_6DeimU5yX&_nc_zt=24&_nc_ht=scontent.fbom3-1.fna&edm=AJdBtusEAAAA&_nc_gid=OVIPQkMwoF3re6b2QKYwaw&_nc_tpa=Q5bMBQFFtidwInak5roW9apdBYBoWOpp-nKp12kRibKdjuCtdacsqLyqxmiWnkTM2Ex5hxdCOcziMzqI1w&oh=00_AflC91Jl73USymBmatTBTxrB9ycQF9E6gQbcL6_Go80INA&oe=6937672A', 'https://scontent.fbom3-4.fna.fbcdn.net/v/t39.30808-6/503357136_2767045300351727_3070237346266400978_n.jpg?_nc_cat=111&ccb=1-7&_nc_sid=dc4938&_nc_ohc=MWs4f-OPc_sQ7kNvwHwHuF9&_nc_oc=Adlo6ABTkwJSDIEvvhsmq5JddSUL_KVqG0KsSZZZwpIcG50m8M_UQix-tUil6y_LVhOuJBioJM1bSdHXEWKkcmSq&_nc_zt=23&_nc_ht=scontent.fbom3-4.fna&edm=AJdBtusEAAAA&_nc_gid=OVIPQkMwoF3re6b2QKYwaw&_nc_tpa=Q5bMBQHLtKuNDyryutg4w4rFneUBkrIk_jj_YVt3VK0xfsSVl9L9JJEBGwjSRVBz2DyyxM2wltt8aqoGRg&oh=00_AfmpfAZreHyyhzfT-Ex3Ld_lXSGBWOxEOTmCx1VFA2Oy8A&oe=69374A79', '631102136744766', 'EAAQvGECe4RMBQOxGtymav3tI3XApOrFGTsBFjgvycp3xeGVJEJgeKDj0MAYSlaZAlpT6ZCQHhDH9ZAsg2kEDkPOwvAp7soGiEc7TrvkoJ35YN6ZA01uWcVIrjZA5QtmVrZAVemZCZCv9ZBqMkWPhOCt7sbjS3wJAD43UixPLcQrl8JunAWPqZB0nm2uL4P3AwvXsabtj6C1RgC', 'Software Company', 9, 'facebook', 'Connected', NULL, NULL, '2025-12-04 12:50:22', '2025-12-08 09:25:16');

-- --------------------------------------------------------

--
-- Table structure for table "social_users"
--

CREATE TABLE "social_users" (
  "id" INTEGER NOT NULL,
  "user_id" varchar(250) NOT NULL,
  "name" varchar(100) NOT NULL,
  "email" varchar(200) DEFAULT NULL,
  "img_url" varchar(250) DEFAULT NULL,
  "social_id" varchar(200) NOT NULL,
  "social_user_platform" varchar(255) DEFAULT NULL,
  "user_token" TEXT NOT NULL,
  "status" VARCHAR(255) DEFAULT 'notConnected',
  "createdAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "updatedAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table "social_users"
--

INSERT INTO "social_users" ("id", "user_id", "name", "email", "img_url", "social_id", "social_user_platform", "user_token", "status", "createdAt", "updatedAt") VALUES
(36, 'e5266555-8859-4f96-bab0-6596b9736d94', 'Sudhir Kundal', NULL, 'https://platform-lookaside.fbsbx.com/platform/profilepic/?asid=9496988240365277&height=50&width=50&ext=1763731876&hash=AT-QyDnzuTwsArc0ZqGcRTZh', '9496988240365277', 'facebook', 'EAAQvGECe4RMBQHsMbXHTIas8wGtQmQqu6jHID98MB1eBATyEKy3pZAiACr43K8GZCkVlpgLidyWAEDUIl955HXihSg1fqmQ3y6Jwxea0Pxci1ftjmfogIL5USFiz6qr4k4FaYNPwPYzCvEw60oFvDYRuZCc47jCYUtGKELJ0YRp7VZC6DZCVjvWS4vw2EjJVZCt4ZBTmW8o0d9d', 'Connected', '2025-10-10 11:43:12', '2025-12-01 00:00:02'),
(37, 'e5266555-8859-4f96-bab0-6596b9736d94', 'Sudhir kundal', NULL, 'https://media.licdn.com/dms/image/v2/D5603AQFEZNr2F7w5Pg/profile-displayphoto-shrink_100_100/B56ZT6Z7D9HQAU-/0/1739367887572?e=1762992000&v=beta&t=pjZ2w8l-RlHznkRw37T72cGHbX7sb-ZIvgqTn4lBXeI', 'eRLsKrw_6N', 'linkedin', 'AQVEXGOWUkRua5Rclo_juvtEfu6tpl8U1XFlnYpTBGYfH039Bl0fGd2KzTODyhq3rFZSaayML9BpcjBRqepc1pdfa_dltopZ1Ci7HMe4-jrqASgBUaq7zdG5mVFHk8Y7kIAZLM2TFw87EQfDXAe4rbqsDj5Ii1NQtQiuG1GRZ2r4OpfRfiJJco_JnPUQC_bD8xm7yE2BIARkeOS3WxPp6LyCxBSY6hv1SjiCHDVdPJ7BRejO47zPmE2f3qx9zW1npKZGfhRUJAc7UzPh1q_Qfaub3ExhgRFmLt2F9eqtd_GvAZdMtBD3EKV75tGwnP5RrXETJwqoHV9IxvF5i1DdaVFQSqiQwQ', 'Connected', '2025-10-10 11:44:02', '2025-10-22 09:25:31'),
(62, 'b4206492-1778-4860-8e24-af93296a37d4', 'Ross Singh', NULL, 'https://platform-lookaside.fbsbx.com/platform/profilepic/?asid=122156535248577012&height=50&width=50&ext=1767444618&hash=AT9TfvNJRZOhdZUNFKJ6FLCG', '122156535248577012', 'facebook', 'EAAQvGECe4RMBQKO8wcEhZCSKKQEn1I4Wwx8jRN214z9P76S32ZB0kUKD4mhsxdwmW4uTzdbzcssbZBspxjZBH7ZCKapKjEi4lg1S9aAZC7mkmeEZArozO9TPQRznhZByWV8RYVlkmiOOgncZAmbeAJtqruu5RpiqTiTE9i9MQZBWHoo5UxEfdt5ENgFzVVKBDAxiY1', 'Connected', '2025-12-04 12:50:19', '2025-12-04 12:50:19');

-- --------------------------------------------------------

--
-- Table structure for table "subscriptions"
--

CREATE TABLE "subscriptions" (
  "id" INTEGER NOT NULL,
  "user_uuid" varchar(255) NOT NULL,
  "stripe_customer_id" varchar(255) NOT NULL,
  "stripe_subscription_id" varchar(255) NOT NULL,
  "price_id" varchar(255) NOT NULL,
  "plan_id" BIGINT DEFAULT NULL ,
  "status" varchar(50) NOT NULL,
  "trial_end" TIMESTAMP DEFAULT NULL,
  "createdAt" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "updatedAt" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  "stripe_price_id" varchar(255) DEFAULT NULL ,
  "trial_start" TIMESTAMP DEFAULT NULL ,
  "trial_days" INTEGER DEFAULT NULL ,
  "current_period_start" TIMESTAMP DEFAULT NULL ,
  "current_period_end" TIMESTAMP DEFAULT NULL ,
  "billing_cycle_anchor" TIMESTAMP DEFAULT NULL ,
  "next_invoice_date" TIMESTAMP DEFAULT NULL ,
  "cancel_at_period_end" SMALLINT NOT NULL DEFAULT 0 ,
  "cancel_at" TIMESTAMP DEFAULT NULL ,
  "canceled_at" TIMESTAMP DEFAULT NULL ,
  "ended_at" TIMESTAMP DEFAULT NULL ,
  "cancellation_reason" varchar(255) DEFAULT NULL ,
  "cancellation_feedback" text DEFAULT NULL ,
  "pause_collection" TEXT  DEFAULT NULL  ,
  "resume_at" TIMESTAMP DEFAULT NULL ,
  "collection_method" VARCHAR(255) DEFAULT 'charge_automatically' ,
  "default_payment_method_id" varchar(255) DEFAULT NULL ,
  "latest_invoice_id" varchar(255) DEFAULT NULL ,
  "quantity" INTEGER DEFAULT 1 ,
  "amount" decimal(10,2) DEFAULT NULL ,
  "currency" varchar(3) DEFAULT 'USD' ,
  "billing_interval" VARCHAR(255) DEFAULT 'month' ,
  "discount_percent" decimal(5,2) DEFAULT NULL ,
  "coupon_code" varchar(100) DEFAULT NULL ,
  "stripe_coupon_id" varchar(255) DEFAULT NULL ,
  "past_due_since" TIMESTAMP DEFAULT NULL ,
  "last_payment_attempt_at" TIMESTAMP DEFAULT NULL ,
  "last_payment_error" text DEFAULT NULL ,
  "payment_retry_count" INTEGER DEFAULT 0 ,
  "next_payment_retry_at" TIMESTAMP DEFAULT NULL ,
  "dunning_status" VARCHAR(255) DEFAULT 'none' ,
  "status_reason" TEXT  DEFAULT NULL  ,
  "metadata" TEXT  DEFAULT NULL  ,
  "trial_reminder_sent" SMALLINT DEFAULT 0 ,
  "trial_reminder_sent_at" TIMESTAMP DEFAULT NULL ,
  "renewal_reminder_sent" SMALLINT DEFAULT 0 ,
  "renewal_reminder_sent_at" TIMESTAMP DEFAULT NULL ,
  "synced_at" TIMESTAMP DEFAULT NULL 
);

--
-- Dumping data for table "subscriptions"
--

INSERT INTO "subscriptions" ("id", "user_uuid", "stripe_customer_id", "stripe_subscription_id", "price_id", "plan_id", "status", "trial_end", "createdAt", "updatedAt", "stripe_price_id", "trial_start", "trial_days", "current_period_start", "current_period_end", "billing_cycle_anchor", "next_invoice_date", "cancel_at_period_end", "cancel_at", "canceled_at", "ended_at", "cancellation_reason", "cancellation_feedback", "pause_collection", "resume_at", "collection_method", "default_payment_method_id", "latest_invoice_id", "quantity", "amount", "currency", "billing_interval", "discount_percent", "coupon_code", "stripe_coupon_id", "past_due_since", "last_payment_attempt_at", "last_payment_error", "payment_retry_count", "next_payment_retry_at", "dunning_status", "status_reason", "metadata", "trial_reminder_sent", "trial_reminder_sent_at", "renewal_reminder_sent", "renewal_reminder_sent_at", "synced_at") VALUES
(1, '9e47ed0e-73f7-41d5-9dac-5c37b8df8a4f', 'cus_TZHNim28DTlc56', 'sub_1Sc8r8HpVJPrOqLkX4hZp1K4', 'price_1SactGHpVJPrOqLkrdqk0HUK', NULL, 'active', NULL, '2025-12-08 18:08:27', '2025-12-08 18:08:25', 'price_1SactGHpVJPrOqLkrdqk0HUK', NULL, NULL, NULL, NULL, '2025-12-08 18:08:18', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'charge_automatically', NULL, NULL, 1, 9900.00, 'USD', 'month', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'none', NULL, NULL, 0, NULL, 0, NULL, '2025-12-08 18:08:25'),
(2, '6f4362d5-744c-446e-8108-8db805396e51', 'cus_TZI0IIGiL6g3IG', 'sub_1Sc9R5HpVJPrOqLkPt4sV5R5', 'price_1SacsoHpVJPrOqLk55ldH9MX', NULL, 'trialing', '2025-12-09 18:45:27', '2025-12-08 18:45:29', '2025-12-08 18:45:32', 'price_1SacsoHpVJPrOqLk55ldH9MX', '2025-12-08 18:45:27', 1, NULL, NULL, '2025-12-09 18:45:27', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'charge_automatically', NULL, NULL, 1, 1900.00, 'USD', 'month', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'none', NULL, NULL, 0, NULL, 0, NULL, '2025-12-08 18:45:32');

-- --------------------------------------------------------

--
-- Table structure for table "subscription_events"
--

CREATE TABLE "subscription_events" (
  "id" INTEGER NOT NULL,
  "subscription_id" INTEGER DEFAULT NULL ,
  "user_uuid" varchar(255) DEFAULT NULL ,
  "stripe_subscription_id" varchar(255) DEFAULT NULL ,
  "stripe_event_id" varchar(255) DEFAULT NULL ,
  "event_type" VARCHAR(255) NOT NULL ,
  "old_status" varchar(50) DEFAULT NULL ,
  "new_status" varchar(50) DEFAULT NULL ,
  "old_plan_id" varchar(255) DEFAULT NULL ,
  "new_plan_id" varchar(255) DEFAULT NULL ,
  "old_quantity" INTEGER DEFAULT NULL ,
  "new_quantity" INTEGER DEFAULT NULL ,
  "amount" INTEGER DEFAULT NULL ,
  "currency" varchar(3) DEFAULT NULL ,
  "failure_code" varchar(100) DEFAULT NULL ,
  "failure_message" text DEFAULT NULL ,
  "actor" VARCHAR(255) DEFAULT 'system' ,
  "actor_id" varchar(255) DEFAULT NULL ,
  "ip_address" varchar(45) DEFAULT NULL ,
  "user_agent" text DEFAULT NULL ,
  "description" text DEFAULT NULL ,
  "metadata" TEXT  DEFAULT NULL  ,
  "event_payload" TEXT  DEFAULT NULL  ,
  "occurred_at" TIMESTAMP NOT NULL ,
  "processed_at" TIMESTAMP DEFAULT NULL ,
  "createdAt" TIMESTAMP NOT NULL,
  "updatedAt" TIMESTAMP NOT NULL
);

--
-- Dumping data for table "subscription_events"
--

INSERT INTO "subscription_events" ("id", "subscription_id", "user_uuid", "stripe_subscription_id", "stripe_event_id", "event_type", "old_status", "new_status", "old_plan_id", "new_plan_id", "old_quantity", "new_quantity", "amount", "currency", "failure_code", "failure_message", "actor", "actor_id", "ip_address", "user_agent", "description", "metadata", "event_payload", "occurred_at", "processed_at", "createdAt", "updatedAt") VALUES
(1, 1, '9e47ed0e-73f7-41d5-9dac-5c37b8df8a4f', 'sub_1Sc8r8HpVJPrOqLkX4hZp1K4', NULL, 'subscription_created', NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, NULL, NULL, 'Subscription created with active status', NULL, NULL, '2025-12-08 18:08:28', '2025-12-08 18:08:28', '2025-12-08 18:08:28', '2025-12-08 18:08:28'),
(2, 1, '9e47ed0e-73f7-41d5-9dac-5c37b8df8a4f', 'sub_1Sc8r8HpVJPrOqLkX4hZp1K4', 'evt_1Sc8rCHpVJPrOqLkc1IKjRiF', 'payment_succeeded', NULL, NULL, NULL, NULL, NULL, NULL, 9900, 'usd', NULL, NULL, 'stripe', NULL, NULL, NULL, 'Payment of 99 USD succeeded', NULL, NULL, '2025-12-08 18:08:21', '2025-12-08 18:08:25', '2025-12-08 18:08:25', '2025-12-08 18:08:25'),
(3, 2, '6f4362d5-744c-446e-8108-8db805396e51', 'sub_1Sc9R5HpVJPrOqLkPt4sV5R5', NULL, 'subscription_created', NULL, 'trialing', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, NULL, NULL, 'Subscription created with trial period', NULL, NULL, '2025-12-08 18:45:29', '2025-12-08 18:45:29', '2025-12-08 18:45:29', '2025-12-08 18:45:29'),
(4, 2, '6f4362d5-744c-446e-8108-8db805396e51', 'sub_1Sc9R5HpVJPrOqLkPt4sV5R5', 'evt_1Sc9R7HpVJPrOqLk1VlxsWJe', 'payment_succeeded', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'usd', NULL, NULL, 'stripe', NULL, NULL, NULL, 'Payment of 0 USD succeeded', NULL, NULL, '2025-12-08 18:45:29', '2025-12-08 18:45:32', '2025-12-08 18:45:32', '2025-12-08 18:45:32');

-- --------------------------------------------------------

--
-- Table structure for table "subscription_plans"
--

CREATE TABLE "subscription_plans" (
  "id" BIGINT NOT NULL,
  "name" varchar(255) NOT NULL,
  "slug" varchar(255) DEFAULT NULL,
  "stripe_price_id" varchar(255) DEFAULT NULL,
  "stripe_yearly_price_id" varchar(255) DEFAULT NULL,
  "stripe_product_id" varchar(255) DEFAULT NULL,
  "price" decimal(10,2) NOT NULL,
  "monthly_price_usd" decimal(10,2) NOT NULL DEFAULT 0.00,
  "yearly_price_usd" decimal(10,2) DEFAULT NULL,
  "monthly_price_inr" decimal(10,2) NOT NULL DEFAULT 0.00,
  "yearly_price_inr" decimal(10,2) DEFAULT NULL,
  "yearly_price" decimal(10,2) DEFAULT NULL,
  "yearly_discount_percent" INTEGER NOT NULL DEFAULT 0,
  "currency" varchar(3) NOT NULL DEFAULT 'USD',
  "billing_cycle" VARCHAR(255) NOT NULL DEFAULT 'monthly',
  "features" TEXT  DEFAULT NULL ,
  "display_features" TEXT  DEFAULT NULL ,
  "description" text DEFAULT NULL,
  "max_social_accounts" INTEGER DEFAULT NULL,
  "max_team_members" INTEGER DEFAULT NULL,
  "max_scheduled_posts" INTEGER DEFAULT NULL,
  "ai_tokens_per_month" INTEGER NOT NULL DEFAULT 0,
  "ai_auto_comment_reply" SMALLINT NOT NULL DEFAULT 0,
  "ai_auto_dm_reply" SMALLINT NOT NULL DEFAULT 0,
  "ai_semantic_analysis" SMALLINT NOT NULL DEFAULT 0,
  "ai_driven_reporting" SMALLINT NOT NULL DEFAULT 0,
  "ai_content_generator" SMALLINT NOT NULL DEFAULT 0,
  "calendar_scheduling" SMALLINT NOT NULL DEFAULT 0,
  "social_profile_score" SMALLINT NOT NULL DEFAULT 0,
  "unified_inbox" SMALLINT NOT NULL DEFAULT 0,
  "export_reports" SMALLINT NOT NULL DEFAULT 0,
  "white_label" SMALLINT NOT NULL DEFAULT 0,
  "fb_ads_analytics" SMALLINT NOT NULL DEFAULT 0,
  "fb_ads_creation" SMALLINT NOT NULL DEFAULT 0,
  "team_roles_permissions" SMALLINT NOT NULL DEFAULT 0,
  "client_workspaces" SMALLINT NOT NULL DEFAULT 0,
  "support_level" varchar(255) NOT NULL DEFAULT 'standard',
  "platform_limits" TEXT  DEFAULT NULL ,
  "active" SMALLINT NOT NULL DEFAULT 1,
  "is_featured" SMALLINT NOT NULL DEFAULT 0,
  "trial_period_days" INTEGER DEFAULT NULL,
  "trial_enabled" SMALLINT NOT NULL DEFAULT 0,
  "skip_trial_discount_enabled" SMALLINT NOT NULL DEFAULT 0,
  "skip_trial_discount_percent" INTEGER NOT NULL DEFAULT 0,
  "is_contact_only" SMALLINT NOT NULL DEFAULT 0,
  "show_on_landing" SMALLINT NOT NULL DEFAULT 1,
  "sort_order" INTEGER NOT NULL DEFAULT 0,
  "created_at" timestamp NULL DEFAULT NULL,
  "updated_at" timestamp NULL DEFAULT NULL
);

--
-- Dumping data for table "subscription_plans"
--

INSERT INTO "subscription_plans" ("id", "name", "slug", "stripe_price_id", "stripe_yearly_price_id", "stripe_product_id", "price", "monthly_price_usd", "yearly_price_usd", "monthly_price_inr", "yearly_price_inr", "yearly_price", "yearly_discount_percent", "currency", "billing_cycle", "features", "display_features", "description", "max_social_accounts", "max_team_members", "max_scheduled_posts", "ai_tokens_per_month", "ai_auto_comment_reply", "ai_auto_dm_reply", "ai_semantic_analysis", "ai_driven_reporting", "ai_content_generator", "calendar_scheduling", "social_profile_score", "unified_inbox", "export_reports", "white_label", "fb_ads_analytics", "fb_ads_creation", "team_roles_permissions", "client_workspaces", "support_level", "platform_limits", "active", "is_featured", "trial_period_days", "trial_enabled", "skip_trial_discount_enabled", "skip_trial_discount_percent", "is_contact_only", "show_on_landing", "sort_order", "created_at", "updated_at") VALUES
(1, 'Starter', 'starter', 'price_1SacsoHpVJPrOqLk55ldH9MX', 'price_1SavGZHpVJPrOqLksQJfyli5', 'prod_TXiJ5slia0Fh1C', 19.00, 19.00, 205.20, 1499.00, 16189.20, 205.20, 10, 'USD', 'monthly', '[]', '["Up to 10 Social Profiles","AI Content Generator (10,000 tokens\/month)","Basic Calendar Scheduling","Post Creation & Drafts","Basic Analytics Dashboard","AI Social Profile Score (Basic)","Media Library","1 User","Standard Support"]', 'Perfect for creators & freelancers', 10, 1, -1, 10000, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 'standard', '[]', 1, 0, 1, 1, 1, 10, 0, 1, 1, '2025-12-04 15:11:35', '2025-12-08 13:17:36'),
(2, 'Growth', 'growth', 'price_1Sact6HpVJPrOqLkhjeGEJKT', 'price_1SavJOHpVJPrOqLkBr49Hq71', 'prod_TXiJlEROBCoHcX', 49.00, 49.00, 529.20, 3999.00, 43189.20, 529.20, 10, 'USD', 'monthly', '[]', '["Up to 30 Social Profiles","AI Content Generator (50000 tokens\/month)","Unified Social Inbox","AI Auto Comment Reply","AI Auto DM Reply","AI-Driven Reporting","Advanced Analytics & Trend Insights","Bulk Scheduling","Workflow Calendar Tools","Export Reports (PDF\/CSV)","Hashtag Manager","3 Users","Priority Support"]', 'Built for small businesses & social media managers', 20, 9, -1, 50000, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 'priority', '[]', 1, 1, 14, 1, 1, 10, 0, 1, 2, '2025-12-04 15:11:33', '2025-12-05 09:34:19'),
(3, 'Agency', 'agency', 'price_1SactGHpVJPrOqLkrdqk0HUK', 'price_1SavL0HpVJPrOqLkWN7N5q63', 'prod_TXiJSc9kvYKDXH', 99.00, 99.00, 1069.20, 7999.00, 86389.20, 1069.20, 10, 'USD', 'monthly', '[]', '["Up to 100 Social Profiles","AI Content Generator (100000 tokens\/month)","AI Semantic Comment Analysis","Facebook Ads Analytics","Create & Manage Facebook Ad Campaigns","White-Label Reports","Client Workspaces","Team Roles & Permissions","Unified Inbox","10 Users","5GB Media Storage","Priority Chat + Email Support"]', 'For agencies managing many clients', 100, 10, -1, -1, 1, 1, 1, 1, 1, 0, 0, 1, 0, 0, 1, 1, 1, 1, 'priority_chat', '[]', 1, 0, 14, 0, 1, 10, 0, 1, 3, '2025-12-04 15:11:32', '2025-12-08 13:17:46'),
(19, 'Enterprise', 'enterprise', NULL, NULL, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 'USD', 'monthly', '[]', '["Unlimited Social Profiles", "Unlimited Users", "Unlimited AI Tokens", "Custom Analytics Dashboards", "API Access & Integrations", "SSO Login", "Dedicated Account Manager", "24×7 Priority Support", "Personalized Onboarding"]', 'Custom solutions for large teams & enterprises', -1, -1, -1, 0, 1, 1, 1, 1, 1, 0, 0, 1, 0, 1, 1, 1, 1, 1, 'enterprise', '[]', 1, 0, NULL, 0, 0, 0, 1, 1, 4, NULL, '2025-12-05 09:30:43');

-- --------------------------------------------------------

--
-- Table structure for table "transactions"
--

CREATE TABLE "transactions" (
  "id" INTEGER NOT NULL,
  "subscription_id" INTEGER NOT NULL,
  "stripe_invoice_id" varchar(255) DEFAULT NULL,
  "stripe_payment_intent_id" varchar(255) DEFAULT NULL,
  "amount" INTEGER NOT NULL,
  "currency" varchar(10) NOT NULL,
  "status" varchar(50) NOT NULL,
  "user_uuid" char(36) DEFAULT NULL,
  "plan_id" INTEGER DEFAULT NULL ,
  "stripe_charge_id" varchar(255) DEFAULT NULL ,
  "stripe_subscription_id" varchar(255) DEFAULT NULL ,
  "stripe_customer_id" varchar(255) DEFAULT NULL ,
  "stripe_payment_method_id" varchar(255) DEFAULT NULL,
  "invoice_number" varchar(100) DEFAULT NULL ,
  "invoice_pdf_url" varchar(500) DEFAULT NULL ,
  "invoice_hosted_url" varchar(500) DEFAULT NULL ,
  "billing_reason" VARCHAR(255) DEFAULT NULL ,
  "amount_subtotal" INTEGER DEFAULT NULL ,
  "amount_tax" INTEGER DEFAULT 0 ,
  "amount_total" INTEGER DEFAULT NULL ,
  "amount_paid" INTEGER DEFAULT NULL ,
  "amount_due" INTEGER DEFAULT NULL ,
  "amount_remaining" INTEGER DEFAULT 0 ,
  "discount_amount" INTEGER DEFAULT 0 ,
  "coupon_code" varchar(100) DEFAULT NULL ,
  "tax_rates" TEXT  DEFAULT NULL  ,
  "payment_status" VARCHAR(255) DEFAULT NULL ,
  "failure_code" varchar(100) DEFAULT NULL ,
  "failure_message" text DEFAULT NULL ,
  "failure_reason" varchar(255) DEFAULT NULL ,
  "attempt_count" INTEGER DEFAULT 0 ,
  "next_payment_attempt" TIMESTAMP DEFAULT NULL ,
  "due_date" TIMESTAMP DEFAULT NULL ,
  "paid_at" TIMESTAMP DEFAULT NULL ,
  "period_start" TIMESTAMP DEFAULT NULL ,
  "period_end" TIMESTAMP DEFAULT NULL ,
  "refund_amount" INTEGER DEFAULT 0 ,
  "refunded_at" TIMESTAMP DEFAULT NULL ,
  "refund_reason" varchar(255) DEFAULT NULL ,
  "stripe_refund_id" varchar(255) DEFAULT NULL ,
  "description" text DEFAULT NULL ,
  "receipt_url" varchar(500) DEFAULT NULL ,
  "card_brand" varchar(50) DEFAULT NULL ,
  "card_last4" varchar(4) DEFAULT NULL ,
  "metadata" TEXT  DEFAULT NULL  ,
  "createdAt" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "updatedAt" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP 
);

--
-- Dumping data for table "transactions"
--

INSERT INTO "transactions" ("id", "subscription_id", "stripe_invoice_id", "stripe_payment_intent_id", "amount", "currency", "status", "user_uuid", "plan_id", "stripe_charge_id", "stripe_subscription_id", "stripe_customer_id", "stripe_payment_method_id", "invoice_number", "invoice_pdf_url", "invoice_hosted_url", "billing_reason", "amount_subtotal", "amount_tax", "amount_total", "amount_paid", "amount_due", "amount_remaining", "discount_amount", "coupon_code", "tax_rates", "payment_status", "failure_code", "failure_message", "failure_reason", "attempt_count", "next_payment_attempt", "due_date", "paid_at", "period_start", "period_end", "refund_amount", "refunded_at", "refund_reason", "stripe_refund_id", "description", "receipt_url", "card_brand", "card_last4", "metadata", "createdAt", "updatedAt") VALUES
(1, 1, 'in_1Sc8r8HpVJPrOqLkqss6grEV', 'pi_3Sc8r9HpVJPrOqLk0FLkqgHp', 9900, 'usd', 'paid', '9e47ed0e-73f7-41d5-9dac-5c37b8df8a4f', NULL, 'ch_3Sc8r9HpVJPrOqLk0WTADrOH', 'sub_1Sc8r8HpVJPrOqLkX4hZp1K4', 'cus_TZHNim28DTlc56', NULL, 'FVJFOQBG-0001', 'https://pay.stripe.com/invoice/acct_1AC6lAHpVJPrOqLk/test_YWNjdF8xQUM2bEFIcFZKUHJPcUxrLF9UWkhQd1hJWXNNbTZodVh4Z0FNSnpXcWk2ckdjcDczLDE1NTc1ODEwMg0200OQrSzDF0/pdf?s=ap', 'https://invoice.stripe.com/i/acct_1AC6lAHpVJPrOqLk/test_YWNjdF8xQUM2bEFIcFZKUHJPcUxrLF9UWkhQd1hJWXNNbTZodVh4Z0FNSnpXcWk2ckdjcDczLDE1NTc1ODEwMg0200OQrSzDF0?s=ap', 'subscription_update', 9900, 0, 9900, 9900, 9900, 0, 0, NULL, NULL, 'succeeded', NULL, NULL, NULL, 0, NULL, NULL, '2025-12-08 18:08:24', '2025-12-08 18:08:18', '2025-12-08 18:08:18', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-08 18:08:24', '2025-12-08 18:08:24'),
(2, 2, 'in_1Sc9R5HpVJPrOqLkM1DKHuY9', NULL, 0, 'usd', 'paid', '6f4362d5-744c-446e-8108-8db805396e51', NULL, NULL, 'sub_1Sc9R5HpVJPrOqLkPt4sV5R5', 'cus_TZI0IIGiL6g3IG', NULL, 'ITYFUTSR-0001', 'https://pay.stripe.com/invoice/acct_1AC6lAHpVJPrOqLk/test_YWNjdF8xQUM2bEFIcFZKUHJPcUxrLF9UWkkxOHVwamdBOVB0NlFwY2czMFlhek1Hd3VDbEw3LDE1NTc2MDMyOQ0200f13RqvAq/pdf?s=ap', 'https://invoice.stripe.com/i/acct_1AC6lAHpVJPrOqLk/test_YWNjdF8xQUM2bEFIcFZKUHJPcUxrLF9UWkkxOHVwamdBOVB0NlFwY2czMFlhek1Hd3VDbEw3LDE1NTc2MDMyOQ0200f13RqvAq?s=ap', 'subscription_update', 0, 0, 0, 0, 0, 0, 0, NULL, NULL, 'succeeded', NULL, NULL, NULL, 0, NULL, NULL, '2025-12-08 18:45:31', '2025-12-08 18:45:27', '2025-12-08 18:45:27', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-08 18:45:31', '2025-12-08 18:45:31');

-- --------------------------------------------------------

--
-- Table structure for table "users"
--

CREATE TABLE "users" (
  "id" INTEGER NOT NULL,
  "uuid" char(36)  DEFAULT NULL,
  "firstName" varchar(200) NOT NULL,
  "lastName" varchar(200) NOT NULL,
  "email" varchar(250) NOT NULL,
  "bio" varchar(255) DEFAULT NULL,
  "company" varchar(255) DEFAULT NULL,
  "jobTitle" varchar(255) DEFAULT NULL,
  "userLocation" varchar(255) DEFAULT NULL,
  "userWebsite" varchar(255) DEFAULT NULL,
  "password" varchar(250) NOT NULL,
  "role" VARCHAR(255) DEFAULT 'User',
  "profileImage" varchar(255) DEFAULT NULL,
  "timeZone" varchar(255) DEFAULT NULL,
  "otp" varchar(100) DEFAULT NULL,
  "otpGeneratedAt" timestamp NULL DEFAULT NULL,
  "resetPasswordToken" varchar(255) DEFAULT NULL,
  "resetPasswordRequestTime" varchar(255) DEFAULT NULL,
  "onboardGoal" TEXT DEFAULT '{}',
  "onboardRole" TEXT DEFAULT '{}',
  "status" VARCHAR(255) NOT NULL DEFAULT '0' ,
  "onboard_status" VARCHAR(255) NOT NULL DEFAULT '0',
  "createdAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "updatedAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "stripe_customer_id" varchar(255) DEFAULT NULL ,
  "billing_name" varchar(255) DEFAULT NULL ,
  "billing_email" varchar(255) DEFAULT NULL ,
  "billing_phone" varchar(50) DEFAULT NULL ,
  "billing_address_line1" varchar(255) DEFAULT NULL ,
  "billing_address_line2" varchar(255) DEFAULT NULL ,
  "billing_city" varchar(100) DEFAULT NULL ,
  "billing_state" varchar(100) DEFAULT NULL ,
  "billing_postal_code" varchar(20) DEFAULT NULL ,
  "billing_country" varchar(2) DEFAULT NULL ,
  "tax_id" varchar(50) DEFAULT NULL ,
  "tax_id_type" varchar(20) DEFAULT NULL ,
  "default_payment_method_id" varchar(255) DEFAULT NULL 
);

--
-- Dumping data for table "users"
--

INSERT INTO "users" ("id", "uuid", "firstName", "lastName", "email", "bio", "company", "jobTitle", "userLocation", "userWebsite", "password", "role", "profileImage", "timeZone", "otp", "otpGeneratedAt", "resetPasswordToken", "resetPasswordRequestTime", "onboardGoal", "onboardRole", "status", "onboard_status", "createdAt", "updatedAt", "stripe_customer_id", "billing_name", "billing_email", "billing_phone", "billing_address_line1", "billing_address_line2", "billing_city", "billing_state", "billing_postal_code", "billing_country", "tax_id", "tax_id_type", "default_payment_method_id") VALUES
(1, 'b4206492-1778-4860-8e24-af93296a37d4', 'Test', 'User', 'test@insocialwise.com', '', 'Aronasoft', '', 'Panchkula', 'aronasoft.com', '$2a$10$4xQpKBbFb9j5HWIs6mv/lO3E4mmXT3r4RHBO/SKGrFIbq9wJMSv7e', 'User', '/uploads/users/upload_img-1758189121598.png', 'Asia/Seoul', NULL, NULL, '', '', '{}', '{}', '1', '0', '2024-12-12 06:21:58', '2025-09-20 08:24:24', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(104, '9e47ed0e-73f7-41d5-9dac-5c37b8df8a4f', 'Baljeet', 'Singh', 'developer0945@gmail.com', NULL, NULL, NULL, NULL, NULL, '$2a$10$bVadGcd.zuCd1WjKZ4DczeGANQw7RC6GvDkK7p074h0dhdyDkaomS', 'User', NULL, 'Australia/Brisbane', NULL, NULL, NULL, NULL, '"growth"', '"organization"', '1', '1', '2025-12-08 18:06:20', '2025-12-08 18:09:54', 'cus_TZHNim28DTlc56', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(105, '6f4362d5-744c-446e-8108-8db805396e51', 'Baljeet', 'Singh', 'developerw0945@gmail.com', NULL, NULL, NULL, NULL, NULL, '$2a$10$2.ph/d7gEVBclHCjy/vTWuFclYcZl3b8kh5W7kgF1SlMXiGiufFfC', 'User', NULL, NULL, NULL, NULL, NULL, NULL, '{}', '{}', '1', '0', '2025-12-08 18:45:11', '2025-12-08 18:45:29', 'cus_TZI0IIGiL6g3IG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table "user_notifications"
--

CREATE TABLE "user_notifications" (
  "id" INTEGER NOT NULL,
  "user_uuid" varchar(255) NOT NULL,
  "type" VARCHAR(255) NOT NULL DEFAULT 'info',
  "title" varchar(255) NOT NULL,
  "message" text NOT NULL,
  "icon" varchar(255) DEFAULT 'bell',
  "severity" VARCHAR(255) NOT NULL DEFAULT 'medium',
  "link" varchar(255) DEFAULT NULL,
  "is_read" SMALLINT NOT NULL DEFAULT 0,
  "metadata" TEXT  DEFAULT NULL ,
  "createdAt" TIMESTAMP NOT NULL,
  "updatedAt" TIMESTAMP NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "user_reports"
--

CREATE TABLE "user_reports" (
  "id" INTEGER NOT NULL,
  "user_uuid" varchar(255) NOT NULL,
  "report_name" varchar(255) NOT NULL,
  "report_type" VARCHAR(255) NOT NULL DEFAULT 'weekly',
  "template_id" varchar(255) DEFAULT NULL,
  "metrics" TEXT  DEFAULT NULL ,
  "date_range" varchar(255) DEFAULT '7',
  "file_path" varchar(255) DEFAULT NULL,
  "file_size" INTEGER DEFAULT 0,
  "status" VARCHAR(255) NOT NULL DEFAULT 'pending',
  "is_favorite" SMALLINT NOT NULL DEFAULT 0,
  "schedule_frequency" VARCHAR(255) NOT NULL DEFAULT 'none',
  "schedule_enabled" SMALLINT NOT NULL DEFAULT 0,
  "schedule_day" INTEGER DEFAULT NULL,
  "schedule_time" varchar(255) DEFAULT NULL,
  "last_generated_at" TIMESTAMP DEFAULT NULL,
  "notes" text DEFAULT NULL,
  "report_data" TEXT  DEFAULT NULL ,
  "insights" TEXT  DEFAULT NULL ,
  "comparison_data" TEXT  DEFAULT NULL ,
  "user_logo_path" varchar(255) DEFAULT NULL,
  "email_delivery_enabled" SMALLINT NOT NULL DEFAULT 0,
  "email_recipients" text DEFAULT NULL,
  "createdAt" TIMESTAMP NOT NULL,
  "updatedAt" TIMESTAMP NOT NULL
);

--
-- Dumping data for table "user_reports"
--

INSERT INTO "user_reports" ("id", "user_uuid", "report_name", "report_type", "template_id", "metrics", "date_range", "file_path", "file_size", "status", "is_favorite", "schedule_frequency", "schedule_enabled", "schedule_day", "schedule_time", "last_generated_at", "notes", "report_data", "insights", "comparison_data", "user_logo_path", "email_delivery_enabled", "email_recipients", "createdAt", "updatedAt") VALUES
(7, '9e47ed0e-73f7-41d5-9dac-5c37b8df8a4f', 'retet', 'weekly', NULL, '["totalReach","engagement","followerGrowth","topContent"]', '30', 'report_1765263792473_vm5xnmiis.pdf', 11371, 'ready', 0, 'none', 0, NULL, NULL, '2025-12-09 07:03:12', NULL, '{"reach":{"total":0,"impressions":0,"views":0,"growth":0,"growthPercent":0,"previousPeriod":0},"followerGrowth":{"startFollowers":0,"endFollowers":0,"growth":0,"growthPercent":0,"dailyGrowthRate":0,"trend":"stable"},"engagement":{"totalLikes":0,"totalComments":0,"totalShares":0,"totalEngagements":0,"totalImpressions":0,"totalPosts":0,"avgEngagementPerPost":0,"engagementRate":0,"interactionRate":0,"breakdown":{"likes":{"count":0,"percentage":0},"comments":{"count":0,"percentage":0},"shares":{"count":0,"percentage":0}}},"topContent":[],"timeSeries":[],"heatmap":{"heatmap":{"0":{"0":{"totalEngagement":0,"count":0,"avgEngagement":0},"3":{"totalEngagement":0,"count":0,"avgEngagement":0},"6":{"totalEngagement":0,"count":0,"avgEngagement":0},"9":{"totalEngagement":0,"count":0,"avgEngagement":0},"12":{"totalEngagement":0,"count":0,"avgEngagement":0},"15":{"totalEngagement":0,"count":0,"avgEngagement":0},"18":{"totalEngagement":0,"count":0,"avgEngagement":0},"21":{"totalEngagement":0,"count":0,"avgEngagement":0}},"1":{"0":{"totalEngagement":0,"count":0,"avgEngagement":0},"3":{"totalEngagement":0,"count":0,"avgEngagement":0},"6":{"totalEngagement":0,"count":0,"avgEngagement":0},"9":{"totalEngagement":0,"count":0,"avgEngagement":0},"12":{"totalEngagement":0,"count":0,"avgEngagement":0},"15":{"totalEngagement":0,"count":0,"avgEngagement":0},"18":{"totalEngagement":0,"count":0,"avgEngagement":0},"21":{"totalEngagement":0,"count":0,"avgEngagement":0}},"2":{"0":{"totalEngagement":0,"count":0,"avgEngagement":0},"3":{"totalEngagement":0,"count":0,"avgEngagement":0},"6":{"totalEngagement":0,"count":0,"avgEngagement":0},"9":{"totalEngagement":0,"count":0,"avgEngagement":0},"12":{"totalEngagement":0,"count":0,"avgEngagement":0},"15":{"totalEngagement":0,"count":0,"avgEngagement":0},"18":{"totalEngagement":0,"count":0,"avgEngagement":0},"21":{"totalEngagement":0,"count":0,"avgEngagement":0}},"3":{"0":{"totalEngagement":0,"count":0,"avgEngagement":0},"3":{"totalEngagement":0,"count":0,"avgEngagement":0},"6":{"totalEngagement":0,"count":0,"avgEngagement":0},"9":{"totalEngagement":0,"count":0,"avgEngagement":0},"12":{"totalEngagement":0,"count":0,"avgEngagement":0},"15":{"totalEngagement":0,"count":0,"avgEngagement":0},"18":{"totalEngagement":0,"count":0,"avgEngagement":0},"21":{"totalEngagement":0,"count":0,"avgEngagement":0}},"4":{"0":{"totalEngagement":0,"count":0,"avgEngagement":0},"3":{"totalEngagement":0,"count":0,"avgEngagement":0},"6":{"totalEngagement":0,"count":0,"avgEngagement":0},"9":{"totalEngagement":0,"count":0,"avgEngagement":0},"12":{"totalEngagement":0,"count":0,"avgEngagement":0},"15":{"totalEngagement":0,"count":0,"avgEngagement":0},"18":{"totalEngagement":0,"count":0,"avgEngagement":0},"21":{"totalEngagement":0,"count":0,"avgEngagement":0}},"5":{"0":{"totalEngagement":0,"count":0,"avgEngagement":0},"3":{"totalEngagement":0,"count":0,"avgEngagement":0},"6":{"totalEngagement":0,"count":0,"avgEngagement":0},"9":{"totalEngagement":0,"count":0,"avgEngagement":0},"12":{"totalEngagement":0,"count":0,"avgEngagement":0},"15":{"totalEngagement":0,"count":0,"avgEngagement":0},"18":{"totalEngagement":0,"count":0,"avgEngagement":0},"21":{"totalEngagement":0,"count":0,"avgEngagement":0}},"6":{"0":{"totalEngagement":0,"count":0,"avgEngagement":0},"3":{"totalEngagement":0,"count":0,"avgEngagement":0},"6":{"totalEngagement":0,"count":0,"avgEngagement":0},"9":{"totalEngagement":0,"count":0,"avgEngagement":0},"12":{"totalEngagement":0,"count":0,"avgEngagement":0},"15":{"totalEngagement":0,"count":0,"avgEngagement":0},"18":{"totalEngagement":0,"count":0,"avgEngagement":0},"21":{"totalEngagement":0,"count":0,"avgEngagement":0}}},"bestTime":null,"totalPosts":0},"summary":{"reportType":"weekly","dateRange":"Last 30 days","startDate":"2025-11-09","endDate":"2025-12-09","generatedAt":"2025-12-09T07:03:12.462Z","totalMetrics":4},"insights":[{"type":"warning","title":"Low Engagement Rate","description":"Your engagement rate is below average. Consider creating more interactive and valuable content."}],"recommendations":["Consider using more engaging content formats like videos and carousels to boost engagement rate.","Increase posting frequency and engage more with your audience to accelerate growth.","Regularly analyze your competitors to identify content opportunities.","Use hashtags strategically to increase discoverability of your posts."],"benchmarks":[{"metric":"Engagement Rate","yourValue":"0%","benchmark":"3.5%","difference":-3.5,"status":"below"},{"metric":"Follower Growth","yourValue":"0%","benchmark":"5%","difference":-5,"status":"below"}],"predictions":null,"growthProjections":null}', '[{"type":"warning","title":"Low Engagement Rate","description":"Your engagement rate is below average. Consider creating more interactive and valuable content."}]', NULL, NULL, 0, NULL, '2025-12-09 07:03:12', '2025-12-09 07:03:12');

-- --------------------------------------------------------

--
-- Table structure for table "webhooks"
--

CREATE TABLE "webhooks" (
  "id" BIGINT NOT NULL,
  "name" varchar(255) NOT NULL,
  "provider" VARCHAR(255) NOT NULL DEFAULT 'custom',
  "event_type" varchar(255) NOT NULL,
  "endpoint_url" varchar(255) NOT NULL,
  "secret" text DEFAULT NULL,
  "active" SMALLINT NOT NULL DEFAULT 1,
  "last_triggered_at" timestamp NULL DEFAULT NULL,
  "last_status" VARCHAR(255) DEFAULT NULL,
  "last_response" text DEFAULT NULL,
  "success_count" INTEGER NOT NULL DEFAULT 0,
  "failure_count" INTEGER NOT NULL DEFAULT 0,
  "created_at" timestamp NULL DEFAULT NULL,
  "updated_at" timestamp NULL DEFAULT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "webhook_events"
--

CREATE TABLE "webhook_events" (
  "id" INTEGER NOT NULL,
  "stripe_event_id" varchar(255) NOT NULL ,
  "event_type" varchar(100) NOT NULL ,
  "api_version" varchar(20) DEFAULT NULL ,
  "livemode" SMALLINT NOT NULL DEFAULT 0 ,
  "object_type" varchar(50) DEFAULT NULL ,
  "object_id" varchar(255) DEFAULT NULL ,
  "customer_id" varchar(255) DEFAULT NULL ,
  "subscription_id" varchar(255) DEFAULT NULL ,
  "invoice_id" varchar(255) DEFAULT NULL ,
  "payment_intent_id" varchar(255) DEFAULT NULL ,
  "payload" TEXT  NOT NULL  ,
  "payload_hash" varchar(64) DEFAULT NULL ,
  "status" VARCHAR(255) NOT NULL DEFAULT 'received' ,
  "processing_attempts" INTEGER NOT NULL DEFAULT 0 ,
  "max_attempts" INTEGER NOT NULL DEFAULT 5 ,
  "received_at" TIMESTAMP NOT NULL ,
  "processed_at" TIMESTAMP DEFAULT NULL ,
  "next_retry_at" TIMESTAMP DEFAULT NULL ,
  "error_code" varchar(100) DEFAULT NULL ,
  "error_message" text DEFAULT NULL ,
  "error_stack" text DEFAULT NULL ,
  "processing_time_ms" INTEGER DEFAULT NULL ,
  "actions_taken" TEXT  DEFAULT NULL  ,
  "affected_records" TEXT  DEFAULT NULL  ,
  "ip_address" varchar(45) DEFAULT NULL ,
  "signature_verified" SMALLINT DEFAULT NULL ,
  "metadata" TEXT  DEFAULT NULL  ,
  "createdAt" TIMESTAMP NOT NULL,
  "updatedAt" TIMESTAMP NOT NULL
);

--
-- Dumping data for table "webhook_events"
--

INSERT INTO "webhook_events" ("id", "stripe_event_id", "event_type", "api_version", "livemode", "object_type", "object_id", "customer_id", "subscription_id", "invoice_id", "payment_intent_id", "payload", "payload_hash", "status", "processing_attempts", "max_attempts", "received_at", "processed_at", "next_retry_at", "error_code", "error_message", "error_stack", "processing_time_ms", "actions_taken", "affected_records", "ip_address", "signature_verified", "metadata", "createdAt", "updatedAt") VALUES
(1, 'evt_1Sc8pkHpVJPrOqLkcvn6pNdS', 'customer.subscription.deleted', '2018-05-21', 0, 'subscription', 'sub_1Sc54THpVJPrOqLkbsD9YIqh', 'cus_TZDVHbxBmsgDOt', 'sub_1Sc54THpVJPrOqLkbsD9YIqh', NULL, NULL, '{"id":"evt_1Sc8pkHpVJPrOqLkcvn6pNdS","object":"event","api_version":"2018-05-21","created":1765217211,"data":{"object":{"id":"sub_1Sc54THpVJPrOqLkbsD9YIqh","object":"subscription","application":null,"application_fee_percent":null,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null},"billing":"charge_automatically","billing_cycle_anchor":1765202749,"billing_cycle_anchor_config":null,"billing_mode":{"flexible":{"proration_discounts":"included"},"type":"flexible","updated_at":1765202749},"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":1765217211,"cancellation_details":{"comment":null,"feedback":null,"reason":"cancellation_requested"},"collection_method":"charge_automatically","created":1765202749,"currency":"usd","current_period_end":1767881149,"current_period_start":1765202749,"customer":"cus_TZDVHbxBmsgDOt","customer_account":null,"days_until_due":null,"default_payment_method":"pm_1Sc54RHpVJPrOqLkd0YQ6Q0Q","default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"ended_at":1765217211,"invoice_customer_balance_settings":{"consume_applied_balance_on_void":true},"invoice_settings":{"account_tax_ids":null,"issuer":{"type":"self"}},"items":{"object":"list","data":[{"id":"si_TZDV4Es6WBMUpd","object":"subscription_item","billing_thresholds":null,"created":1765202750,"current_period_end":1767881149,"current_period_start":1765202749,"discounts":[],"metadata":{},"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"price":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"price","active":true,"billing_scheme":"per_unit","created":1764856094,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"nickname":null,"product":"prod_TXiJSc9kvYKDXH","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":9900,"unit_amount_decimal":"9900"},"quantity":1,"subscription":"sub_1Sc54THpVJPrOqLkbsD9YIqh","tax_rates":[]}],"has_more":false,"total_count":1,"url":"/v1/subscription_items?subscription=sub_1Sc54THpVJPrOqLkbsD9YIqh"},"latest_invoice":"in_1Sc54THpVJPrOqLkQEvNGsPY","livemode":false,"metadata":{},"next_pending_invoice_item_invoice":null,"on_behalf_of":null,"pause_collection":null,"payment_settings":{"payment_method_options":null,"payment_method_types":null,"save_default_payment_method":"off"},"pending_invoice_item_interval":null,"pending_setup_intent":null,"pending_update":null,"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1765202749,"start_date":1765202749,"status":"canceled","tax_percent":null,"test_clock":null,"transfer_data":null,"trial_end":null,"trial_settings":{"end_behavior":{"missing_payment_method":"create_invoice"}},"trial_start":null}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_Ej8LHLE76oFsFq","idempotency_key":null},"type":"customer.subscription.deleted"}', 'fb86add953bdfa4877ba8c2be9c2a406fd14aa117c3f4840afd92801b76f05f6', 'processed', 0, 5, '2025-12-08 18:06:52', '2025-12-08 18:06:53', NULL, NULL, NULL, NULL, 990, '[]', '[]', '::ffff:127.0.0.1', 1, NULL, '2025-12-08 18:06:52', '2025-12-08 18:06:53'),
(2, 'evt_1Sc8ppHpVJPrOqLk5f7ABUpc', 'customer.subscription.deleted', '2018-05-21', 0, 'subscription', 'sub_1Sc528HpVJPrOqLkLV8FsINs', 'cus_TZDSda2Cjwyb9C', 'sub_1Sc528HpVJPrOqLkLV8FsINs', NULL, NULL, '{"id":"evt_1Sc8ppHpVJPrOqLk5f7ABUpc","object":"event","api_version":"2018-05-21","created":1765217217,"data":{"object":{"id":"sub_1Sc528HpVJPrOqLkLV8FsINs","object":"subscription","application":null,"application_fee_percent":null,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null},"billing":"charge_automatically","billing_cycle_anchor":1765202604,"billing_cycle_anchor_config":null,"billing_mode":{"flexible":{"proration_discounts":"included"},"type":"flexible","updated_at":1765202604},"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":1765217217,"cancellation_details":{"comment":null,"feedback":null,"reason":"cancellation_requested"},"collection_method":"charge_automatically","created":1765202604,"currency":"usd","current_period_end":1767881004,"current_period_start":1765202604,"customer":"cus_TZDSda2Cjwyb9C","customer_account":null,"days_until_due":null,"default_payment_method":"pm_1Sc525HpVJPrOqLksIqFgiqf","default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"ended_at":1765217217,"invoice_customer_balance_settings":{"consume_applied_balance_on_void":true},"invoice_settings":{"account_tax_ids":null,"issuer":{"type":"self"}},"items":{"object":"list","data":[{"id":"si_TZDTAYHE7h3nYK","object":"subscription_item","billing_thresholds":null,"created":1765202604,"current_period_end":1767881004,"current_period_start":1765202604,"discounts":[],"metadata":{},"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"price":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"price","active":true,"billing_scheme":"per_unit","created":1764856094,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"nickname":null,"product":"prod_TXiJSc9kvYKDXH","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":9900,"unit_amount_decimal":"9900"},"quantity":1,"subscription":"sub_1Sc528HpVJPrOqLkLV8FsINs","tax_rates":[]}],"has_more":false,"total_count":1,"url":"/v1/subscription_items?subscription=sub_1Sc528HpVJPrOqLkLV8FsINs"},"latest_invoice":"in_1Sc528HpVJPrOqLkzIdb2XXy","livemode":false,"metadata":{},"next_pending_invoice_item_invoice":null,"on_behalf_of":null,"pause_collection":null,"payment_settings":{"payment_method_options":null,"payment_method_types":null,"save_default_payment_method":"off"},"pending_invoice_item_interval":null,"pending_setup_intent":null,"pending_update":null,"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1765202604,"start_date":1765202604,"status":"canceled","tax_percent":null,"test_clock":null,"transfer_data":null,"trial_end":null,"trial_settings":{"end_behavior":{"missing_payment_method":"create_invoice"}},"trial_start":null}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_3IzTlqD5QlAayS","idempotency_key":null},"type":"customer.subscription.deleted"}', '465f75f620c5e6db6243b80a94841fd8641781b2d839f950bb240fcfaa624ee3', 'processed', 0, 5, '2025-12-08 18:06:59', '2025-12-08 18:06:59', NULL, NULL, NULL, NULL, 758, '[]', '[]', '::1', 1, NULL, '2025-12-08 18:06:59', '2025-12-08 18:06:59'),
(3, 'evt_1Sc8pwHpVJPrOqLklCq6wBYr', 'customer.subscription.deleted', '2018-05-21', 0, 'subscription', 'sub_1SbNtoHpVJPrOqLkXJiCHhwx', 'cus_TYUtFbKUjXADZY', 'sub_1SbNtoHpVJPrOqLkXJiCHhwx', NULL, NULL, '{"id":"evt_1Sc8pwHpVJPrOqLklCq6wBYr","object":"event","api_version":"2018-05-21","created":1765217224,"data":{"object":{"id":"sub_1SbNtoHpVJPrOqLkXJiCHhwx","object":"subscription","application":null,"application_fee_percent":null,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null},"billing":"charge_automatically","billing_cycle_anchor":1765123196,"billing_cycle_anchor_config":null,"billing_mode":{"flexible":{"proration_discounts":"included"},"type":"flexible","updated_at":1765036796},"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":1765217223,"cancellation_details":{"comment":null,"feedback":null,"reason":"cancellation_requested"},"collection_method":"charge_automatically","created":1765036796,"currency":"usd","current_period_end":1767801596,"current_period_start":1765123196,"customer":"cus_TYUtFbKUjXADZY","customer_account":null,"days_until_due":null,"default_payment_method":"pm_1SbNtzHpVJPrOqLkghRJQsoJ","default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"ended_at":1765217223,"invoice_customer_balance_settings":{"consume_applied_balance_on_void":true},"invoice_settings":{"account_tax_ids":null,"issuer":{"type":"self"}},"items":{"object":"list","data":[{"id":"si_TYUtIBah9vp5cD","object":"subscription_item","billing_thresholds":null,"created":1765036797,"current_period_end":1767801596,"current_period_start":1765123196,"discounts":[],"metadata":{},"plan":{"id":"price_1SacsoHpVJPrOqLk55ldH9MX","object":"plan","active":true,"aggregate_usage":null,"amount":1900,"amount_decimal":"1900","billing_scheme":"per_unit","created":1764856066,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"10","plan_id":"1","billing_cycle":"monthly","max_team_members":"1","trial_days":"1"},"meter":null,"nickname":null,"product":"prod_TXiJ5slia0Fh1C","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"price":{"id":"price_1SacsoHpVJPrOqLk55ldH9MX","object":"price","active":true,"billing_scheme":"per_unit","created":1764856066,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"10","plan_id":"1","billing_cycle":"monthly","max_team_members":"1","trial_days":"1"},"nickname":null,"product":"prod_TXiJ5slia0Fh1C","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":1900,"unit_amount_decimal":"1900"},"quantity":1,"subscription":"sub_1SbNtoHpVJPrOqLkXJiCHhwx","tax_rates":[]}],"has_more":false,"total_count":1,"url":"/v1/subscription_items?subscription=sub_1SbNtoHpVJPrOqLkXJiCHhwx"},"latest_invoice":"in_1SbkNtHpVJPrOqLkqqTo8QTQ","livemode":false,"metadata":{},"next_pending_invoice_item_invoice":null,"on_behalf_of":null,"pause_collection":null,"payment_settings":{"payment_method_options":null,"payment_method_types":null,"save_default_payment_method":"off"},"pending_invoice_item_interval":null,"pending_setup_intent":null,"pending_update":null,"plan":{"id":"price_1SacsoHpVJPrOqLk55ldH9MX","object":"plan","active":true,"aggregate_usage":null,"amount":1900,"amount_decimal":"1900","billing_scheme":"per_unit","created":1764856066,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"10","plan_id":"1","billing_cycle":"monthly","max_team_members":"1","trial_days":"1"},"meter":null,"nickname":null,"product":"prod_TXiJ5slia0Fh1C","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1765036796,"start_date":1765036796,"status":"canceled","tax_percent":null,"test_clock":null,"transfer_data":null,"trial_end":1765123196,"trial_settings":{"end_behavior":{"missing_payment_method":"create_invoice"}},"trial_start":1765036796}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_n6lxHLxbjxLTjt","idempotency_key":null},"type":"customer.subscription.deleted"}', 'b65485f7f7b9042e07ca6c37c7e0af2fba23c6d12891191bd3e82ff7dcb296af', 'processed', 0, 5, '2025-12-08 18:07:05', '2025-12-08 18:07:05', NULL, NULL, NULL, NULL, 1033, '[]', '[]', '::ffff:127.0.0.1', 1, NULL, '2025-12-08 18:07:05', '2025-12-08 18:07:05'),
(4, 'evt_1Sc8qcHpVJPrOqLkSykUoQeJ', 'customer.subscription.updated', '2018-05-21', 0, 'subscription', 'sub_1Sc4s1HpVJPrOqLknlyBXpb5', 'cus_TZDIqpPX565FxE', 'sub_1Sc4s1HpVJPrOqLknlyBXpb5', NULL, NULL, '{"id":"evt_1Sc8qcHpVJPrOqLkSykUoQeJ","object":"event","api_version":"2018-05-21","created":1765217266,"data":{"object":{"id":"sub_1Sc4s1HpVJPrOqLknlyBXpb5","object":"subscription","application":null,"application_fee_percent":null,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null},"billing":"charge_automatically","billing_cycle_anchor":1765201977,"billing_cycle_anchor_config":null,"billing_mode":{"flexible":{"proration_discounts":"included"},"type":"flexible","updated_at":1765201977},"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":1765217265,"cancellation_details":{"comment":null,"feedback":null,"reason":null},"collection_method":"charge_automatically","created":1765201977,"currency":"usd","current_period_end":1767880377,"current_period_start":1765201977,"customer":"cus_TZDIqpPX565FxE","customer_account":null,"days_until_due":null,"default_payment_method":null,"default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"ended_at":1765217265,"invoice_customer_balance_settings":{"consume_applied_balance_on_void":true},"invoice_settings":{"account_tax_ids":null,"issuer":{"type":"self"}},"items":{"object":"list","data":[{"id":"si_TZDIrosbIbcG5e","object":"subscription_item","billing_thresholds":null,"created":1765201977,"current_period_end":1767880377,"current_period_start":1765201977,"discounts":[],"metadata":{},"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"price":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"price","active":true,"billing_scheme":"per_unit","created":1764856094,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"nickname":null,"product":"prod_TXiJSc9kvYKDXH","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":9900,"unit_amount_decimal":"9900"},"quantity":1,"subscription":"sub_1Sc4s1HpVJPrOqLknlyBXpb5","tax_rates":[]}],"has_more":false,"total_count":1,"url":"/v1/subscription_items?subscription=sub_1Sc4s1HpVJPrOqLknlyBXpb5"},"latest_invoice":"in_1Sc4s1HpVJPrOqLkPLs06Grx","livemode":false,"metadata":{},"next_pending_invoice_item_invoice":null,"on_behalf_of":null,"pause_collection":null,"payment_settings":{"payment_method_options":null,"payment_method_types":null,"save_default_payment_method":"off"},"pending_invoice_item_interval":null,"pending_setup_intent":null,"pending_update":null,"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1765201977,"start_date":1765201977,"status":"incomplete_expired","tax_percent":null,"test_clock":null,"transfer_data":null,"trial_end":null,"trial_settings":{"end_behavior":{"missing_payment_method":"create_invoice"}},"trial_start":null},"previous_attributes":{"canceled_at":null,"ended_at":null,"status":"incomplete"}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_SdVIbfQRLcDo9z","idempotency_key":"batchapi-batch_1Sc8qJHpVJPrOqLkufeCTtwz-cus_TZDIqpPX565FxE_delete_customer"},"type":"customer.subscription.updated"}', '3d54a47cd0f9b75f2362fd1b2d784a077d7a35b5e583a401d90f964ea19bd2c1', 'processed', 0, 5, '2025-12-08 18:07:47', '2025-12-08 18:07:48', NULL, NULL, NULL, NULL, 990, '[]', '[]', '::1', 1, NULL, '2025-12-08 18:07:47', '2025-12-08 18:07:48'),
(5, 'evt_1Sc8qeHpVJPrOqLkyqgkXnzp', 'customer.subscription.updated', '2018-05-21', 0, 'subscription', 'sub_1Sc4PCHpVJPrOqLkIa3dxyJ0', 'cus_TZCojn6Lu4LVzS', 'sub_1Sc4PCHpVJPrOqLkIa3dxyJ0', NULL, NULL, '{"id":"evt_1Sc8qeHpVJPrOqLkyqgkXnzp","object":"event","api_version":"2018-05-21","created":1765217268,"data":{"object":{"id":"sub_1Sc4PCHpVJPrOqLkIa3dxyJ0","object":"subscription","application":null,"application_fee_percent":null,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null},"billing":"charge_automatically","billing_cycle_anchor":1765200190,"billing_cycle_anchor_config":null,"billing_mode":{"flexible":{"proration_discounts":"included"},"type":"flexible","updated_at":1765200190},"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":1765217267,"cancellation_details":{"comment":null,"feedback":null,"reason":null},"collection_method":"charge_automatically","created":1765200190,"currency":"usd","current_period_end":1767878590,"current_period_start":1765200190,"customer":"cus_TZCojn6Lu4LVzS","customer_account":null,"days_until_due":null,"default_payment_method":null,"default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"ended_at":1765217267,"invoice_customer_balance_settings":{"consume_applied_balance_on_void":true},"invoice_settings":{"account_tax_ids":null,"issuer":{"type":"self"}},"items":{"object":"list","data":[{"id":"si_TZCoMURBGT9oFR","object":"subscription_item","billing_thresholds":null,"created":1765200190,"current_period_end":1767878590,"current_period_start":1765200190,"discounts":[],"metadata":{},"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"price":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"price","active":true,"billing_scheme":"per_unit","created":1764856094,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"nickname":null,"product":"prod_TXiJSc9kvYKDXH","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":9900,"unit_amount_decimal":"9900"},"quantity":1,"subscription":"sub_1Sc4PCHpVJPrOqLkIa3dxyJ0","tax_rates":[]}],"has_more":false,"total_count":1,"url":"/v1/subscription_items?subscription=sub_1Sc4PCHpVJPrOqLkIa3dxyJ0"},"latest_invoice":"in_1Sc4PCHpVJPrOqLkJMSDgtoW","livemode":false,"metadata":{},"next_pending_invoice_item_invoice":null,"on_behalf_of":null,"pause_collection":null,"payment_settings":{"payment_method_options":null,"payment_method_types":null,"save_default_payment_method":"off"},"pending_invoice_item_interval":null,"pending_setup_intent":null,"pending_update":null,"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1765200190,"start_date":1765200190,"status":"incomplete_expired","tax_percent":null,"test_clock":null,"transfer_data":null,"trial_end":null,"trial_settings":{"end_behavior":{"missing_payment_method":"create_invoice"}},"trial_start":null},"previous_attributes":{"canceled_at":null,"ended_at":null,"status":"incomplete"}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_Bg6i8rp0cKcI0k","idempotency_key":"batchapi-batch_1Sc8qJHpVJPrOqLkufeCTtwz-cus_TZCojn6Lu4LVzS_delete_customer"},"type":"customer.subscription.updated"}', '30dcefc4eaa78a51c907538ad28d07d802aaba8831c9785d78afacf211a56945', 'processed', 0, 5, '2025-12-08 18:07:49', '2025-12-08 18:07:50', NULL, NULL, NULL, NULL, 754, '[]', '[]', '::ffff:127.0.0.1', 1, NULL, '2025-12-08 18:07:49', '2025-12-08 18:07:50'),
(6, 'evt_1Sc8qiHpVJPrOqLk7guCjrC5', 'customer.subscription.updated', '2018-05-21', 0, 'subscription', 'sub_1Sc4LJHpVJPrOqLkyZdGtlUj', 'cus_TZCktShIKgBvsH', 'sub_1Sc4LJHpVJPrOqLkyZdGtlUj', NULL, NULL, '{"id":"evt_1Sc8qiHpVJPrOqLk7guCjrC5","object":"event","api_version":"2018-05-21","created":1765217272,"data":{"object":{"id":"sub_1Sc4LJHpVJPrOqLkyZdGtlUj","object":"subscription","application":null,"application_fee_percent":null,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null},"billing":"charge_automatically","billing_cycle_anchor":1765199949,"billing_cycle_anchor_config":null,"billing_mode":{"flexible":{"proration_discounts":"included"},"type":"flexible","updated_at":1765199949},"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":1765217271,"cancellation_details":{"comment":null,"feedback":null,"reason":null},"collection_method":"charge_automatically","created":1765199949,"currency":"usd","current_period_end":1767878349,"current_period_start":1765199949,"customer":"cus_TZCktShIKgBvsH","customer_account":null,"days_until_due":null,"default_payment_method":null,"default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"ended_at":1765217271,"invoice_customer_balance_settings":{"consume_applied_balance_on_void":true},"invoice_settings":{"account_tax_ids":null,"issuer":{"type":"self"}},"items":{"object":"list","data":[{"id":"si_TZCkaUrqYwrZxF","object":"subscription_item","billing_thresholds":null,"created":1765199950,"current_period_end":1767878349,"current_period_start":1765199949,"discounts":[],"metadata":{},"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"price":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"price","active":true,"billing_scheme":"per_unit","created":1764856094,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"nickname":null,"product":"prod_TXiJSc9kvYKDXH","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":9900,"unit_amount_decimal":"9900"},"quantity":1,"subscription":"sub_1Sc4LJHpVJPrOqLkyZdGtlUj","tax_rates":[]}],"has_more":false,"total_count":1,"url":"/v1/subscription_items?subscription=sub_1Sc4LJHpVJPrOqLkyZdGtlUj"},"latest_invoice":"in_1Sc4LJHpVJPrOqLk9DTsTia0","livemode":false,"metadata":{},"next_pending_invoice_item_invoice":null,"on_behalf_of":null,"pause_collection":null,"payment_settings":{"payment_method_options":null,"payment_method_types":null,"save_default_payment_method":"off"},"pending_invoice_item_interval":null,"pending_setup_intent":null,"pending_update":null,"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1765199949,"start_date":1765199949,"status":"incomplete_expired","tax_percent":null,"test_clock":null,"transfer_data":null,"trial_end":null,"trial_settings":{"end_behavior":{"missing_payment_method":"create_invoice"}},"trial_start":null},"previous_attributes":{"canceled_at":null,"ended_at":null,"status":"incomplete"}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_Q1yEMVtbecxXpg","idempotency_key":"batchapi-batch_1Sc8qJHpVJPrOqLkufeCTtwz-cus_TZCktShIKgBvsH_delete_customer"},"type":"customer.subscription.updated"}', 'ac49ddb7757001efe29be23e916b422d8abc69877133010e8c10a989401d2157', 'processed', 0, 5, '2025-12-08 18:07:53', '2025-12-08 18:07:53', NULL, NULL, NULL, NULL, 751, '[]', '[]', '::1', 1, NULL, '2025-12-08 18:07:53', '2025-12-08 18:07:53'),
(7, 'evt_1Sc8qlHpVJPrOqLkn95YtMmK', 'customer.subscription.updated', '2018-05-21', 0, 'subscription', 'sub_1Sc3hbHpVJPrOqLkKCfQcmMj', 'cus_TZC5DYbF42aeYo', 'sub_1Sc3hbHpVJPrOqLkKCfQcmMj', NULL, NULL, '{"id":"evt_1Sc8qlHpVJPrOqLkn95YtMmK","object":"event","api_version":"2018-05-21","created":1765217274,"data":{"object":{"id":"sub_1Sc3hbHpVJPrOqLkKCfQcmMj","object":"subscription","application":null,"application_fee_percent":null,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null},"billing":"charge_automatically","billing_cycle_anchor":1765197487,"billing_cycle_anchor_config":null,"billing_mode":{"flexible":{"proration_discounts":"included"},"type":"flexible","updated_at":1765197487},"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":1765217274,"cancellation_details":{"comment":null,"feedback":null,"reason":null},"collection_method":"charge_automatically","created":1765197487,"currency":"usd","current_period_end":1767875887,"current_period_start":1765197487,"customer":"cus_TZC5DYbF42aeYo","customer_account":null,"days_until_due":null,"default_payment_method":null,"default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"ended_at":1765217274,"invoice_customer_balance_settings":{"consume_applied_balance_on_void":true},"invoice_settings":{"account_tax_ids":null,"issuer":{"type":"self"}},"items":{"object":"list","data":[{"id":"si_TZC55vHf4UM2ar","object":"subscription_item","billing_thresholds":null,"created":1765197488,"current_period_end":1767875887,"current_period_start":1765197487,"discounts":[],"metadata":{},"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"price":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"price","active":true,"billing_scheme":"per_unit","created":1764856094,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"nickname":null,"product":"prod_TXiJSc9kvYKDXH","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":9900,"unit_amount_decimal":"9900"},"quantity":1,"subscription":"sub_1Sc3hbHpVJPrOqLkKCfQcmMj","tax_rates":[]}],"has_more":false,"total_count":1,"url":"/v1/subscription_items?subscription=sub_1Sc3hbHpVJPrOqLkKCfQcmMj"},"latest_invoice":"in_1Sc3hbHpVJPrOqLkq1Fc3hNK","livemode":false,"metadata":{},"next_pending_invoice_item_invoice":null,"on_behalf_of":null,"pause_collection":null,"payment_settings":{"payment_method_options":null,"payment_method_types":null,"save_default_payment_method":"off"},"pending_invoice_item_interval":null,"pending_setup_intent":null,"pending_update":null,"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1765197487,"start_date":1765197487,"status":"incomplete_expired","tax_percent":null,"test_clock":null,"transfer_data":null,"trial_end":null,"trial_settings":{"end_behavior":{"missing_payment_method":"create_invoice"}},"trial_start":null},"previous_attributes":{"canceled_at":null,"ended_at":null,"status":"incomplete"}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_FH9Xd7lymEpe6o","idempotency_key":"batchapi-batch_1Sc8qJHpVJPrOqLkufeCTtwz-cus_TZC5DYbF42aeYo_delete_customer"},"type":"customer.subscription.updated"}', '31dd6213282c713fb08ef2525a03ae8a621547e561caed34ed404960373c1f7b', 'processed', 0, 5, '2025-12-08 18:07:55', '2025-12-08 18:07:56', NULL, NULL, NULL, NULL, 751, '[]', '[]', '::ffff:127.0.0.1', 1, NULL, '2025-12-08 18:07:55', '2025-12-08 18:07:56'),
(8, 'evt_1Sc8qmHpVJPrOqLkJzOOSZbT', 'customer.subscription.updated', '2018-05-21', 0, 'subscription', 'sub_1Sc3hAHpVJPrOqLkOiWAaq0O', 'cus_TZC5FWnES5o8tp', 'sub_1Sc3hAHpVJPrOqLkOiWAaq0O', NULL, NULL, '{"id":"evt_1Sc8qmHpVJPrOqLkJzOOSZbT","object":"event","api_version":"2018-05-21","created":1765217276,"data":{"object":{"id":"sub_1Sc3hAHpVJPrOqLkOiWAaq0O","object":"subscription","application":null,"application_fee_percent":null,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null},"billing":"charge_automatically","billing_cycle_anchor":1765197460,"billing_cycle_anchor_config":null,"billing_mode":{"flexible":{"proration_discounts":"included"},"type":"flexible","updated_at":1765197460},"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":1765217275,"cancellation_details":{"comment":null,"feedback":null,"reason":null},"collection_method":"charge_automatically","created":1765197460,"currency":"usd","current_period_end":1767875860,"current_period_start":1765197460,"customer":"cus_TZC5FWnES5o8tp","customer_account":null,"days_until_due":null,"default_payment_method":null,"default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"ended_at":1765217275,"invoice_customer_balance_settings":{"consume_applied_balance_on_void":true},"invoice_settings":{"account_tax_ids":null,"issuer":{"type":"self"}},"items":{"object":"list","data":[{"id":"si_TZC57Y2mkgQQYm","object":"subscription_item","billing_thresholds":null,"created":1765197460,"current_period_end":1767875860,"current_period_start":1765197460,"discounts":[],"metadata":{},"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"price":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"price","active":true,"billing_scheme":"per_unit","created":1764856094,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"nickname":null,"product":"prod_TXiJSc9kvYKDXH","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":9900,"unit_amount_decimal":"9900"},"quantity":1,"subscription":"sub_1Sc3hAHpVJPrOqLkOiWAaq0O","tax_rates":[]}],"has_more":false,"total_count":1,"url":"/v1/subscription_items?subscription=sub_1Sc3hAHpVJPrOqLkOiWAaq0O"},"latest_invoice":"in_1Sc3hAHpVJPrOqLkZbRH36jf","livemode":false,"metadata":{},"next_pending_invoice_item_invoice":null,"on_behalf_of":null,"pause_collection":null,"payment_settings":{"payment_method_options":null,"payment_method_types":null,"save_default_payment_method":"off"},"pending_invoice_item_interval":null,"pending_setup_intent":null,"pending_update":null,"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1765197460,"start_date":1765197460,"status":"incomplete_expired","tax_percent":null,"test_clock":null,"transfer_data":null,"trial_end":null,"trial_settings":{"end_behavior":{"missing_payment_method":"create_invoice"}},"trial_start":null},"previous_attributes":{"canceled_at":null,"ended_at":null,"status":"incomplete"}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_tT14UE8Sf32x8v","idempotency_key":"batchapi-batch_1Sc8qJHpVJPrOqLkufeCTtwz-cus_TZC5FWnES5o8tp_delete_customer"},"type":"customer.subscription.updated"}', '119342f87588e05e9d6a3b1cf96ecdc578e7cb9501c90ae3a1a7a106c4af23b7', 'processed', 0, 5, '2025-12-08 18:07:57', '2025-12-08 18:07:57', NULL, NULL, NULL, NULL, 753, '[]', '[]', '::1', 1, NULL, '2025-12-08 18:07:57', '2025-12-08 18:07:57'),
(9, 'evt_1Sc8qnHpVJPrOqLkt1YzakFl', 'customer.subscription.updated', '2018-05-21', 0, 'subscription', 'sub_1Sc3gTHpVJPrOqLkJgsQxZVP', 'cus_TZC4Z95oMzdO7j', 'sub_1Sc3gTHpVJPrOqLkJgsQxZVP', NULL, NULL, '{"id":"evt_1Sc8qnHpVJPrOqLkt1YzakFl","object":"event","api_version":"2018-05-21","created":1765217277,"data":{"object":{"id":"sub_1Sc3gTHpVJPrOqLkJgsQxZVP","object":"subscription","application":null,"application_fee_percent":null,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null},"billing":"charge_automatically","billing_cycle_anchor":1765197417,"billing_cycle_anchor_config":null,"billing_mode":{"flexible":{"proration_discounts":"included"},"type":"flexible","updated_at":1765197417},"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":1765217276,"cancellation_details":{"comment":null,"feedback":null,"reason":null},"collection_method":"charge_automatically","created":1765197417,"currency":"usd","current_period_end":1767875817,"current_period_start":1765197417,"customer":"cus_TZC4Z95oMzdO7j","customer_account":null,"days_until_due":null,"default_payment_method":null,"default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"ended_at":1765217276,"invoice_customer_balance_settings":{"consume_applied_balance_on_void":true},"invoice_settings":{"account_tax_ids":null,"issuer":{"type":"self"}},"items":{"object":"list","data":[{"id":"si_TZC4fBCSM5gNPo","object":"subscription_item","billing_thresholds":null,"created":1765197418,"current_period_end":1767875817,"current_period_start":1765197417,"discounts":[],"metadata":{},"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"price":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"price","active":true,"billing_scheme":"per_unit","created":1764856094,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"nickname":null,"product":"prod_TXiJSc9kvYKDXH","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":9900,"unit_amount_decimal":"9900"},"quantity":1,"subscription":"sub_1Sc3gTHpVJPrOqLkJgsQxZVP","tax_rates":[]}],"has_more":false,"total_count":1,"url":"/v1/subscription_items?subscription=sub_1Sc3gTHpVJPrOqLkJgsQxZVP"},"latest_invoice":"in_1Sc3gUHpVJPrOqLk4mQI17qf","livemode":false,"metadata":{},"next_pending_invoice_item_invoice":null,"on_behalf_of":null,"pause_collection":null,"payment_settings":{"payment_method_options":null,"payment_method_types":null,"save_default_payment_method":"off"},"pending_invoice_item_interval":null,"pending_setup_intent":null,"pending_update":null,"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1765197417,"start_date":1765197417,"status":"incomplete_expired","tax_percent":null,"test_clock":null,"transfer_data":null,"trial_end":null,"trial_settings":{"end_behavior":{"missing_payment_method":"create_invoice"}},"trial_start":null},"previous_attributes":{"canceled_at":null,"ended_at":null,"status":"incomplete"}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_mmHQcw1xmkHJmi","idempotency_key":"batchapi-batch_1Sc8qJHpVJPrOqLkufeCTtwz-cus_TZC4Z95oMzdO7j_delete_customer"},"type":"customer.subscription.updated"}', '7b037103c64fa020c90f3f1c609115bf4fa490eb882607c1ebe6f4eb612ce809', 'processed', 0, 5, '2025-12-08 18:07:58', '2025-12-08 18:07:58', NULL, NULL, NULL, NULL, 978, '[]', '[]', '::ffff:127.0.0.1', 1, NULL, '2025-12-08 18:07:58', '2025-12-08 18:07:58');
INSERT INTO "webhook_events" ("id", "stripe_event_id", "event_type", "api_version", "livemode", "object_type", "object_id", "customer_id", "subscription_id", "invoice_id", "payment_intent_id", "payload", "payload_hash", "status", "processing_attempts", "max_attempts", "received_at", "processed_at", "next_retry_at", "error_code", "error_message", "error_stack", "processing_time_ms", "actions_taken", "affected_records", "ip_address", "signature_verified", "metadata", "createdAt", "updatedAt") VALUES
(10, 'evt_1Sc8qoHpVJPrOqLkwKYgJKl6', 'customer.subscription.deleted', '2018-05-21', 0, 'subscription', 'sub_1Sc3aSHpVJPrOqLkzZny5VSC', 'cus_TZByG99czFCQiG', 'sub_1Sc3aSHpVJPrOqLkzZny5VSC', NULL, NULL, '{"id":"evt_1Sc8qoHpVJPrOqLkwKYgJKl6","object":"event","api_version":"2018-05-21","created":1765217277,"data":{"object":{"id":"sub_1Sc3aSHpVJPrOqLkzZny5VSC","object":"subscription","application":null,"application_fee_percent":null,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null},"billing":"charge_automatically","billing_cycle_anchor":1766406644,"billing_cycle_anchor_config":null,"billing_mode":{"flexible":{"proration_discounts":"included"},"type":"flexible","updated_at":1765197044},"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":1765217277,"cancellation_details":{"comment":null,"feedback":null,"reason":"cancellation_requested"},"collection_method":"charge_automatically","created":1765197044,"currency":"usd","current_period_end":1766406644,"current_period_start":1765197044,"customer":"cus_TZByG99czFCQiG","customer_account":null,"days_until_due":null,"default_payment_method":null,"default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"ended_at":1765217277,"invoice_customer_balance_settings":{"consume_applied_balance_on_void":true},"invoice_settings":{"account_tax_ids":null,"issuer":{"type":"self"}},"items":{"object":"list","data":[{"id":"si_TZBy3ZDUDi8ZzP","object":"subscription_item","billing_thresholds":null,"created":1765197045,"current_period_end":1766406644,"current_period_start":1765197044,"discounts":[],"metadata":{},"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"price":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"price","active":true,"billing_scheme":"per_unit","created":1764856094,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"nickname":null,"product":"prod_TXiJSc9kvYKDXH","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":9900,"unit_amount_decimal":"9900"},"quantity":1,"subscription":"sub_1Sc3aSHpVJPrOqLkzZny5VSC","tax_rates":[]}],"has_more":false,"total_count":1,"url":"/v1/subscription_items?subscription=sub_1Sc3aSHpVJPrOqLkzZny5VSC"},"latest_invoice":"in_1Sc3aSHpVJPrOqLkGUATpTYi","livemode":false,"metadata":{},"next_pending_invoice_item_invoice":null,"on_behalf_of":null,"pause_collection":null,"payment_settings":{"payment_method_options":null,"payment_method_types":null,"save_default_payment_method":"off"},"pending_invoice_item_interval":null,"pending_setup_intent":"seti_1Sc3aTHpVJPrOqLkTEyJkfqm","pending_update":null,"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1765197044,"start_date":1765197044,"status":"canceled","tax_percent":null,"test_clock":null,"transfer_data":null,"trial_end":1766406644,"trial_settings":{"end_behavior":{"missing_payment_method":"create_invoice"}},"trial_start":1765197044}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_WGbxXEwRsT3Jhl","idempotency_key":"batchapi-batch_1Sc8qJHpVJPrOqLkufeCTtwz-cus_TZByG99czFCQiG_delete_customer"},"type":"customer.subscription.deleted"}', 'ee2a24b592791ccc3b2fc8dd79867009ca45dca67fd68cf022e917caed28069f', 'processed', 0, 5, '2025-12-08 18:07:59', '2025-12-08 18:07:59', NULL, NULL, NULL, NULL, 752, '[]', '[]', '::1', 1, NULL, '2025-12-08 18:07:59', '2025-12-08 18:07:59'),
(11, 'evt_1Sc8qpHpVJPrOqLky5zAXVfp', 'customer.subscription.deleted', '2018-05-21', 0, 'subscription', 'sub_1Sc3VSHpVJPrOqLk2KdxLmYl', 'cus_TZBtEwD56re95y', 'sub_1Sc3VSHpVJPrOqLk2KdxLmYl', NULL, NULL, '{"id":"evt_1Sc8qpHpVJPrOqLky5zAXVfp","object":"event","api_version":"2018-05-21","created":1765217279,"data":{"object":{"id":"sub_1Sc3VSHpVJPrOqLk2KdxLmYl","object":"subscription","application":null,"application_fee_percent":null,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null},"billing":"charge_automatically","billing_cycle_anchor":1766406334,"billing_cycle_anchor_config":null,"billing_mode":{"flexible":{"proration_discounts":"included"},"type":"flexible","updated_at":1765196734},"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":1765217278,"cancellation_details":{"comment":null,"feedback":null,"reason":"cancellation_requested"},"collection_method":"charge_automatically","created":1765196734,"currency":"usd","current_period_end":1766406334,"current_period_start":1765196734,"customer":"cus_TZBtEwD56re95y","customer_account":null,"days_until_due":null,"default_payment_method":"pm_1Sc3VhHpVJPrOqLki86DVlRa","default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"ended_at":1765217278,"invoice_customer_balance_settings":{"consume_applied_balance_on_void":true},"invoice_settings":{"account_tax_ids":null,"issuer":{"type":"self"}},"items":{"object":"list","data":[{"id":"si_TZBtFabOTcORwZ","object":"subscription_item","billing_thresholds":null,"created":1765196734,"current_period_end":1766406334,"current_period_start":1765196734,"discounts":[],"metadata":{},"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"price":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"price","active":true,"billing_scheme":"per_unit","created":1764856094,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"nickname":null,"product":"prod_TXiJSc9kvYKDXH","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":9900,"unit_amount_decimal":"9900"},"quantity":1,"subscription":"sub_1Sc3VSHpVJPrOqLk2KdxLmYl","tax_rates":[]}],"has_more":false,"total_count":1,"url":"/v1/subscription_items?subscription=sub_1Sc3VSHpVJPrOqLk2KdxLmYl"},"latest_invoice":"in_1Sc3VSHpVJPrOqLkgUgMARk7","livemode":false,"metadata":{},"next_pending_invoice_item_invoice":null,"on_behalf_of":null,"pause_collection":null,"payment_settings":{"payment_method_options":null,"payment_method_types":null,"save_default_payment_method":"off"},"pending_invoice_item_interval":null,"pending_setup_intent":null,"pending_update":null,"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1765196734,"start_date":1765196734,"status":"canceled","tax_percent":null,"test_clock":null,"transfer_data":null,"trial_end":1766406334,"trial_settings":{"end_behavior":{"missing_payment_method":"create_invoice"}},"trial_start":1765196734}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_3CGYNFWwjeXGiq","idempotency_key":"batchapi-batch_1Sc8qJHpVJPrOqLkufeCTtwz-cus_TZBtEwD56re95y_delete_customer"},"type":"customer.subscription.deleted"}', '472bdebdeefcefc5a2f0e7ed6daf4723fe118858504d9370f97594f6801bc0cd', 'processed', 0, 5, '2025-12-08 18:08:00', '2025-12-08 18:08:00', NULL, NULL, NULL, NULL, 938, '[]', '[]', '::ffff:127.0.0.1', 1, NULL, '2025-12-08 18:08:00', '2025-12-08 18:08:00'),
(12, 'evt_1Sc8qqHpVJPrOqLk3kwIBtcs', 'customer.subscription.deleted', '2018-05-21', 0, 'subscription', 'sub_1Sc2nWHpVJPrOqLkn0etlHdu', 'cus_TZB9H5AhESjLFA', 'sub_1Sc2nWHpVJPrOqLkn0etlHdu', NULL, NULL, '{"id":"evt_1Sc8qqHpVJPrOqLk3kwIBtcs","object":"event","api_version":"2018-05-21","created":1765217280,"data":{"object":{"id":"sub_1Sc2nWHpVJPrOqLkn0etlHdu","object":"subscription","application":null,"application_fee_percent":null,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null},"billing":"charge_automatically","billing_cycle_anchor":1766403610,"billing_cycle_anchor_config":null,"billing_mode":{"flexible":{"proration_discounts":"included"},"type":"flexible","updated_at":1765194010},"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":1765217279,"cancellation_details":{"comment":null,"feedback":null,"reason":"cancellation_requested"},"collection_method":"charge_automatically","created":1765194010,"currency":"usd","current_period_end":1766403610,"current_period_start":1765194010,"customer":"cus_TZB9H5AhESjLFA","customer_account":null,"days_until_due":null,"default_payment_method":"pm_1Sc2nmHpVJPrOqLkIWlxlyRi","default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"ended_at":1765217279,"invoice_customer_balance_settings":{"consume_applied_balance_on_void":true},"invoice_settings":{"account_tax_ids":null,"issuer":{"type":"self"}},"items":{"object":"list","data":[{"id":"si_TZB9heJDe44AAN","object":"subscription_item","billing_thresholds":null,"created":1765194010,"current_period_end":1766403610,"current_period_start":1765194010,"discounts":[],"metadata":{},"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"price":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"price","active":true,"billing_scheme":"per_unit","created":1764856094,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"nickname":null,"product":"prod_TXiJSc9kvYKDXH","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":9900,"unit_amount_decimal":"9900"},"quantity":1,"subscription":"sub_1Sc2nWHpVJPrOqLkn0etlHdu","tax_rates":[]}],"has_more":false,"total_count":1,"url":"/v1/subscription_items?subscription=sub_1Sc2nWHpVJPrOqLkn0etlHdu"},"latest_invoice":"in_1Sc2nWHpVJPrOqLkogJgIM4N","livemode":false,"metadata":{},"next_pending_invoice_item_invoice":null,"on_behalf_of":null,"pause_collection":null,"payment_settings":{"payment_method_options":null,"payment_method_types":null,"save_default_payment_method":"off"},"pending_invoice_item_interval":null,"pending_setup_intent":null,"pending_update":null,"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1765194010,"start_date":1765194010,"status":"canceled","tax_percent":null,"test_clock":null,"transfer_data":null,"trial_end":1766403610,"trial_settings":{"end_behavior":{"missing_payment_method":"create_invoice"}},"trial_start":1765194010}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_nF38JfiUohMrW6","idempotency_key":"batchapi-batch_1Sc8qJHpVJPrOqLkufeCTtwz-cus_TZB9H5AhESjLFA_delete_customer"},"type":"customer.subscription.deleted"}', '8dbf09d3d04bf1db414eae669c015ceb71c1092c901f9a138f18305f2df1dc37', 'processed', 0, 5, '2025-12-08 18:08:01', '2025-12-08 18:08:01', NULL, NULL, NULL, NULL, 751, '[]', '[]', '::1', 1, NULL, '2025-12-08 18:08:01', '2025-12-08 18:08:01'),
(13, 'evt_1Sc8qrHpVJPrOqLksKwf173c', 'customer.subscription.deleted', '2018-05-21', 0, 'subscription', 'sub_1Sc2g3HpVJPrOqLkXRGlLtBG', 'cus_TZB2Yif42HWmYz', 'sub_1Sc2g3HpVJPrOqLkXRGlLtBG', NULL, NULL, '{"id":"evt_1Sc8qrHpVJPrOqLksKwf173c","object":"event","api_version":"2018-05-21","created":1765217281,"data":{"object":{"id":"sub_1Sc2g3HpVJPrOqLkXRGlLtBG","object":"subscription","application":null,"application_fee_percent":null,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null},"billing":"charge_automatically","billing_cycle_anchor":1766403147,"billing_cycle_anchor_config":null,"billing_mode":{"flexible":{"proration_discounts":"included"},"type":"flexible","updated_at":1765193547},"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":1765217280,"cancellation_details":{"comment":null,"feedback":null,"reason":"cancellation_requested"},"collection_method":"charge_automatically","created":1765193547,"currency":"usd","current_period_end":1766403147,"current_period_start":1765193547,"customer":"cus_TZB2Yif42HWmYz","customer_account":null,"days_until_due":null,"default_payment_method":"pm_1Sc2gPHpVJPrOqLkaXTYh29S","default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"ended_at":1765217280,"invoice_customer_balance_settings":{"consume_applied_balance_on_void":true},"invoice_settings":{"account_tax_ids":null,"issuer":{"type":"self"}},"items":{"object":"list","data":[{"id":"si_TZB2UPXfRmzaNU","object":"subscription_item","billing_thresholds":null,"created":1765193547,"current_period_end":1766403147,"current_period_start":1765193547,"discounts":[],"metadata":{},"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"price":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"price","active":true,"billing_scheme":"per_unit","created":1764856094,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"nickname":null,"product":"prod_TXiJSc9kvYKDXH","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":9900,"unit_amount_decimal":"9900"},"quantity":1,"subscription":"sub_1Sc2g3HpVJPrOqLkXRGlLtBG","tax_rates":[]}],"has_more":false,"total_count":1,"url":"/v1/subscription_items?subscription=sub_1Sc2g3HpVJPrOqLkXRGlLtBG"},"latest_invoice":"in_1Sc2g3HpVJPrOqLk7CaUMXJL","livemode":false,"metadata":{},"next_pending_invoice_item_invoice":null,"on_behalf_of":null,"pause_collection":null,"payment_settings":{"payment_method_options":null,"payment_method_types":null,"save_default_payment_method":"off"},"pending_invoice_item_interval":null,"pending_setup_intent":null,"pending_update":null,"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1765193547,"start_date":1765193547,"status":"canceled","tax_percent":null,"test_clock":null,"transfer_data":null,"trial_end":1766403147,"trial_settings":{"end_behavior":{"missing_payment_method":"create_invoice"}},"trial_start":1765193547}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_dL3mKWBnuNIbkQ","idempotency_key":"batchapi-batch_1Sc8qJHpVJPrOqLkufeCTtwz-cus_TZB2Yif42HWmYz_delete_customer"},"type":"customer.subscription.deleted"}', '61af824ddda33f3e1750952fa2fa2754cefe359d2414346a838bc7681815e410', 'processed', 0, 5, '2025-12-08 18:08:02', '2025-12-08 18:08:02', NULL, NULL, NULL, NULL, 756, '[]', '[]', '::ffff:127.0.0.1', 1, NULL, '2025-12-08 18:08:02', '2025-12-08 18:08:02'),
(14, 'evt_1Sc8qsHpVJPrOqLkmLpbOjRg', 'customer.subscription.deleted', '2018-05-21', 0, 'subscription', 'sub_1Sc2crHpVJPrOqLkA7FFN2dQ', 'cus_TZAydZD2Wxztnt', 'sub_1Sc2crHpVJPrOqLkA7FFN2dQ', NULL, NULL, '{"id":"evt_1Sc8qsHpVJPrOqLkmLpbOjRg","object":"event","api_version":"2018-05-21","created":1765217282,"data":{"object":{"id":"sub_1Sc2crHpVJPrOqLkA7FFN2dQ","object":"subscription","application":null,"application_fee_percent":null,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null},"billing":"charge_automatically","billing_cycle_anchor":1765279749,"billing_cycle_anchor_config":null,"billing_mode":{"flexible":{"proration_discounts":"included"},"type":"flexible","updated_at":1765193349},"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":1765217281,"cancellation_details":{"comment":null,"feedback":null,"reason":"cancellation_requested"},"collection_method":"charge_automatically","created":1765193349,"currency":"usd","current_period_end":1765279749,"current_period_start":1765193349,"customer":"cus_TZAydZD2Wxztnt","customer_account":null,"days_until_due":null,"default_payment_method":"pm_1Sc2d9HpVJPrOqLk5vRlHbZ1","default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"ended_at":1765217281,"invoice_customer_balance_settings":{"consume_applied_balance_on_void":true},"invoice_settings":{"account_tax_ids":null,"issuer":{"type":"self"}},"items":{"object":"list","data":[{"id":"si_TZAykGqoDhhMmD","object":"subscription_item","billing_thresholds":null,"created":1765193349,"current_period_end":1765279749,"current_period_start":1765193349,"discounts":[],"metadata":{},"plan":{"id":"price_1SacsoHpVJPrOqLk55ldH9MX","object":"plan","active":true,"aggregate_usage":null,"amount":1900,"amount_decimal":"1900","billing_scheme":"per_unit","created":1764856066,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"10","plan_id":"1","billing_cycle":"monthly","max_team_members":"1","trial_days":"1"},"meter":null,"nickname":null,"product":"prod_TXiJ5slia0Fh1C","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"price":{"id":"price_1SacsoHpVJPrOqLk55ldH9MX","object":"price","active":true,"billing_scheme":"per_unit","created":1764856066,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"10","plan_id":"1","billing_cycle":"monthly","max_team_members":"1","trial_days":"1"},"nickname":null,"product":"prod_TXiJ5slia0Fh1C","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":1900,"unit_amount_decimal":"1900"},"quantity":1,"subscription":"sub_1Sc2crHpVJPrOqLkA7FFN2dQ","tax_rates":[]}],"has_more":false,"total_count":1,"url":"/v1/subscription_items?subscription=sub_1Sc2crHpVJPrOqLkA7FFN2dQ"},"latest_invoice":"in_1Sc2crHpVJPrOqLkHhkROOzs","livemode":false,"metadata":{},"next_pending_invoice_item_invoice":null,"on_behalf_of":null,"pause_collection":null,"payment_settings":{"payment_method_options":null,"payment_method_types":null,"save_default_payment_method":"off"},"pending_invoice_item_interval":null,"pending_setup_intent":null,"pending_update":null,"plan":{"id":"price_1SacsoHpVJPrOqLk55ldH9MX","object":"plan","active":true,"aggregate_usage":null,"amount":1900,"amount_decimal":"1900","billing_scheme":"per_unit","created":1764856066,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"10","plan_id":"1","billing_cycle":"monthly","max_team_members":"1","trial_days":"1"},"meter":null,"nickname":null,"product":"prod_TXiJ5slia0Fh1C","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1765193349,"start_date":1765193349,"status":"canceled","tax_percent":null,"test_clock":null,"transfer_data":null,"trial_end":1765279749,"trial_settings":{"end_behavior":{"missing_payment_method":"create_invoice"}},"trial_start":1765193349}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_HuddEd8iVONNR0","idempotency_key":"batchapi-batch_1Sc8qJHpVJPrOqLkufeCTtwz-cus_TZAydZD2Wxztnt_delete_customer"},"type":"customer.subscription.deleted"}', '908b8454cdb025a5a6677ad606539a211b581f2ceddc786dea842f135ef9927f', 'processed', 0, 5, '2025-12-08 18:08:03', '2025-12-08 18:08:03', NULL, NULL, NULL, NULL, 755, '[]', '[]', '::1', 1, NULL, '2025-12-08 18:08:03', '2025-12-08 18:08:03'),
(15, 'evt_1Sc8r6HpVJPrOqLkBYk1cmjl', 'payment_method.attached', '2018-05-21', 0, 'payment_method', 'pm_1Sc8r5HpVJPrOqLkGD0xuD2V', 'cus_TZHNim28DTlc56', NULL, NULL, NULL, '{"id":"evt_1Sc8r6HpVJPrOqLkBYk1cmjl","object":"event","api_version":"2018-05-21","created":1765217296,"data":{"object":{"id":"pm_1Sc8r5HpVJPrOqLkGD0xuD2V","object":"payment_method","allow_redisplay":"unspecified","billing_details":{"address":{"city":null,"country":"IN","line1":null,"line2":null,"postal_code":null,"state":null},"email":"developer0945@gmail.com","name":"Sudhir Ku","phone":"(714) 781-4565","tax_id":null},"card":{"brand":"visa","checks":{"address_line1_check":null,"address_postal_code_check":null,"cvc_check":"pass"},"country":"US","display_brand":"visa","exp_month":11,"exp_year":2034,"fingerprint":"G95Ez9iUIsKX1A0j","funding":"credit","generated_from":null,"last4":"1111","networks":{"available":["visa"],"preferred":null},"regulated_status":"unregulated","three_d_secure_usage":{"supported":true},"wallet":null},"created":1765217295,"customer":"cus_TZHNim28DTlc56","customer_account":null,"livemode":false,"metadata":{},"type":"card"}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_SnWO68mIngF8On","idempotency_key":"4cfea973-60d0-48d2-9560-cfa7a26386cb"},"type":"payment_method.attached"}', '5513cbec40be21152f35b565d21c5257c96452e0ba14afe3c170154b89031257', 'processed', 0, 5, '2025-12-08 18:08:17', '2025-12-08 18:08:19', NULL, NULL, NULL, NULL, 1726, '["payment_method_added"]', '[]', '::ffff:127.0.0.1', 1, NULL, '2025-12-08 18:08:17', '2025-12-08 18:08:19'),
(16, 'evt_1Sc8rCHpVJPrOqLk1CLeVpVT', 'customer.subscription.created', '2018-05-21', 0, 'subscription', 'sub_1Sc8r8HpVJPrOqLkX4hZp1K4', 'cus_TZHNim28DTlc56', 'sub_1Sc8r8HpVJPrOqLkX4hZp1K4', NULL, NULL, '{"id":"evt_1Sc8rCHpVJPrOqLk1CLeVpVT","object":"event","api_version":"2018-05-21","created":1765217301,"data":{"object":{"id":"sub_1Sc8r8HpVJPrOqLkX4hZp1K4","object":"subscription","application":null,"application_fee_percent":null,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null},"billing":"charge_automatically","billing_cycle_anchor":1765217298,"billing_cycle_anchor_config":null,"billing_mode":{"flexible":{"proration_discounts":"included"},"type":"flexible","updated_at":1765217298},"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":null,"cancellation_details":{"comment":null,"feedback":null,"reason":null},"collection_method":"charge_automatically","created":1765217298,"currency":"usd","current_period_end":1767895698,"current_period_start":1765217298,"customer":"cus_TZHNim28DTlc56","customer_account":null,"days_until_due":null,"default_payment_method":"pm_1Sc8r5HpVJPrOqLkGD0xuD2V","default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"ended_at":null,"invoice_customer_balance_settings":{"consume_applied_balance_on_void":true},"invoice_settings":{"account_tax_ids":null,"issuer":{"type":"self"}},"items":{"object":"list","data":[{"id":"si_TZHPSgXrB8TKck","object":"subscription_item","billing_thresholds":null,"created":1765217299,"current_period_end":1767895698,"current_period_start":1765217298,"discounts":[],"metadata":{},"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"price":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"price","active":true,"billing_scheme":"per_unit","created":1764856094,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"nickname":null,"product":"prod_TXiJSc9kvYKDXH","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":9900,"unit_amount_decimal":"9900"},"quantity":1,"subscription":"sub_1Sc8r8HpVJPrOqLkX4hZp1K4","tax_rates":[]}],"has_more":false,"total_count":1,"url":"/v1/subscription_items?subscription=sub_1Sc8r8HpVJPrOqLkX4hZp1K4"},"latest_invoice":"in_1Sc8r8HpVJPrOqLkqss6grEV","livemode":false,"metadata":{},"next_pending_invoice_item_invoice":null,"on_behalf_of":null,"pause_collection":null,"payment_settings":{"payment_method_options":null,"payment_method_types":null,"save_default_payment_method":"off"},"pending_invoice_item_interval":null,"pending_setup_intent":null,"pending_update":null,"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1765217298,"start_date":1765217298,"status":"active","tax_percent":null,"test_clock":null,"transfer_data":null,"trial_end":null,"trial_settings":{"end_behavior":{"missing_payment_method":"create_invoice"}},"trial_start":null}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_ZjfDO0ts60OvTy","idempotency_key":"stripe-node-retry-38b0ab00-e526-456a-8a03-5cdcc6104fe5"},"type":"customer.subscription.created"}', '75e605b99b40829054d0b58fc9bed4ecaa0aec7d7bea8c22494f7d4ecabc4ffa', 'processed', 0, 5, '2025-12-08 18:08:23', '2025-12-08 18:08:23', NULL, NULL, NULL, NULL, 730, '["subscription_created_logged"]', '[]', '::1', 1, NULL, '2025-12-08 18:08:23', '2025-12-08 18:08:23'),
(17, 'evt_3Sc8r9HpVJPrOqLk0z377HiD', 'payment_intent.succeeded', '2018-05-21', 0, 'payment_intent', 'pi_3Sc8r9HpVJPrOqLk0FLkqgHp', 'cus_TZHNim28DTlc56', NULL, 'in_1Sc8r8HpVJPrOqLkqss6grEV', NULL, '{"id":"evt_3Sc8r9HpVJPrOqLk0z377HiD","object":"event","api_version":"2018-05-21","created":1765217301,"data":{"object":{"id":"pi_3Sc8r9HpVJPrOqLk0FLkqgHp","object":"payment_intent","allowed_source_types":["card","link"],"amount":9900,"amount_capturable":0,"amount_details":{"tip":{}},"amount_received":9900,"application":null,"application_fee_amount":null,"automatic_payment_methods":null,"canceled_at":null,"cancellation_reason":null,"capture_method":"automatic","charges":{"object":"list","data":[{"id":"ch_3Sc8r9HpVJPrOqLk0WTADrOH","object":"charge","amount":9900,"amount_captured":9900,"amount_refunded":0,"application":null,"application_fee":null,"application_fee_amount":null,"balance_transaction":"txn_3Sc8r9HpVJPrOqLk09aPkFOO","billing_details":{"address":{"city":null,"country":"IN","line1":null,"line2":null,"postal_code":null,"state":null},"email":"developer0945@gmail.com","name":"Sudhir Ku","phone":"(714) 781-4565","tax_id":null},"calculated_statement_descriptor":"SHIPPO","captured":true,"created":1765217300,"currency":"usd","customer":"cus_TZHNim28DTlc56","description":"Subscription creation","destination":null,"dispute":null,"disputed":false,"failure_balance_transaction":null,"failure_code":null,"failure_message":null,"fraud_details":{},"invoice":"in_1Sc8r8HpVJPrOqLkqss6grEV","livemode":false,"metadata":{},"on_behalf_of":null,"order":null,"outcome":{"advice_code":null,"network_advice_code":null,"network_decline_code":null,"network_status":"approved_by_network","reason":null,"risk_level":"normal","risk_score":61,"seller_message":"Payment complete.","type":"authorized"},"paid":true,"payment_intent":"pi_3Sc8r9HpVJPrOqLk0FLkqgHp","payment_method":"pm_1Sc8r5HpVJPrOqLkGD0xuD2V","payment_method_details":{"card":{"amount_authorized":9900,"authorization_code":"714355","brand":"visa","checks":{"address_line1_check":null,"address_postal_code_check":null,"cvc_check":"pass"},"country":"US","exp_month":11,"exp_year":2034,"extended_authorization":{"status":"disabled"},"fingerprint":"G95Ez9iUIsKX1A0j","funding":"credit","incremental_authorization":{"status":"unavailable"},"installments":null,"last4":"1111","mandate":null,"multicapture":{"status":"unavailable"},"network":"visa","network_token":{"used":false},"network_transaction_id":"715753691225710","overcapture":{"maximum_amount_capturable":9900,"status":"unavailable"},"regulated_status":"unregulated","three_d_secure":null,"wallet":null},"type":"card"},"radar_options":{},"receipt_email":"developer0945@gmail.com","receipt_number":null,"receipt_url":"https://pay.stripe.com/receipts/invoices/CAcaFwoVYWNjdF8xQUM2bEFIcFZKUHJPcUxrKJao3MkGMgZ4EHh3x4Q6LBaV8eAOga6E82O5RCvz2msXIMP4jIMy7gQXLtxs7gDL5qCw2uGxjXyPMHIU?s=ap","refunded":false,"refunds":{"object":"list","data":[],"has_more":false,"total_count":0,"url":"/v1/charges/ch_3Sc8r9HpVJPrOqLk0WTADrOH/refunds"},"review":null,"shipping":null,"source":null,"source_transfer":null,"statement_descriptor":null,"statement_descriptor_suffix":null,"status":"succeeded","transfer_data":null,"transfer_group":null}],"has_more":false,"total_count":1,"url":"/v1/charges?payment_intent=pi_3Sc8r9HpVJPrOqLk0FLkqgHp"},"client_secret":"pi_3Sc8r9HpVJPrOqLk0FLkqgHp_secret_zGLl0RiNeCyT5DizegFKtMAPa","confirmation_method":"automatic","created":1765217299,"currency":"usd","customer":"cus_TZHNim28DTlc56","customer_account":null,"description":"Subscription creation","excluded_payment_method_types":null,"invoice":"in_1Sc8r8HpVJPrOqLkqss6grEV","last_payment_error":null,"latest_charge":"ch_3Sc8r9HpVJPrOqLk0WTADrOH","livemode":false,"metadata":{},"next_action":null,"next_source_action":null,"on_behalf_of":null,"payment_details":{"customer_reference":null,"order_reference":"in_1Sc8r8HpVJPrOqLkqss6gr"},"payment_method":"pm_1Sc8r5HpVJPrOqLkGD0xuD2V","payment_method_configuration_details":null,"payment_method_options":{"card":{"installments":null,"mandate_options":null,"network":null,"request_three_d_secure":"automatic"},"link":{"persistent_token":null}},"payment_method_types":["card","link"],"processing":null,"receipt_email":"developer0945@gmail.com","review":null,"setup_future_usage":"off_session","shipping":null,"source":null,"statement_descriptor":null,"statement_descriptor_suffix":null,"status":"succeeded","transfer_data":null,"transfer_group":null}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_ZjfDO0ts60OvTy","idempotency_key":"stripe-node-retry-38b0ab00-e526-456a-8a03-5cdcc6104fe5"},"type":"payment_intent.succeeded"}', 'b34d82e42dde48583cb248b1f10d0371cf2a883a1dc8e793ff1a9eef3219d2ef', 'processed', 0, 5, '2025-12-08 18:08:23', '2025-12-08 18:08:23', NULL, NULL, NULL, NULL, 760, '["unhandled_event_payment_intent.succeeded"]', '[]', '::ffff:127.0.0.1', 1, NULL, '2025-12-08 18:08:23', '2025-12-08 18:08:23'),
(18, 'evt_1Sc8rCHpVJPrOqLkc1IKjRiF', 'invoice.payment_succeeded', '2018-05-21', 0, 'invoice', 'in_1Sc8r8HpVJPrOqLkqss6grEV', 'cus_TZHNim28DTlc56', 'sub_1Sc8r8HpVJPrOqLkX4hZp1K4', 'in_1Sc8r8HpVJPrOqLkqss6grEV', 'pi_3Sc8r9HpVJPrOqLk0FLkqgHp', '{"id":"evt_1Sc8rCHpVJPrOqLkc1IKjRiF","object":"event","api_version":"2018-05-21","created":1765217301,"data":{"object":{"id":"in_1Sc8r8HpVJPrOqLkqss6grEV","object":"invoice","account_country":"SE","account_name":"Aronasoft","account_tax_ids":null,"amount_due":9900,"amount_overpaid":0,"amount_paid":9900,"amount_remaining":0,"amount_shipping":0,"application":null,"application_fee":null,"attempt_count":1,"attempted":true,"auto_advance":false,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null,"provider":null,"status":null},"automatically_finalizes_at":null,"billing":"charge_automatically","billing_reason":"subscription_update","charge":"ch_3Sc8r9HpVJPrOqLk0WTADrOH","closed":true,"collection_method":"charge_automatically","created":1765217298,"currency":"usd","custom_fields":null,"customer":"cus_TZHNim28DTlc56","customer_account":null,"customer_address":null,"customer_email":"developer0945@gmail.com","customer_name":"Baljeet Singh","customer_phone":"(714) 781-4565","customer_shipping":null,"customer_tax_exempt":"none","customer_tax_ids":[],"date":1765217298,"default_payment_method":null,"default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"due_date":null,"effective_at":1765217298,"ending_balance":0,"finalized_at":1765217298,"footer":null,"forgiven":false,"from_invoice":null,"hosted_invoice_url":"https://invoice.stripe.com/i/acct_1AC6lAHpVJPrOqLk/test_YWNjdF8xQUM2bEFIcFZKUHJPcUxrLF9UWkhQd1hJWXNNbTZodVh4Z0FNSnpXcWk2ckdjcDczLDE1NTc1ODEwMg0200OQrSzDF0?s=ap","invoice_pdf":"https://pay.stripe.com/invoice/acct_1AC6lAHpVJPrOqLk/test_YWNjdF8xQUM2bEFIcFZKUHJPcUxrLF9UWkhQd1hJWXNNbTZodVh4Z0FNSnpXcWk2ckdjcDczLDE1NTc1ODEwMg0200OQrSzDF0/pdf?s=ap","issuer":{"type":"self"},"last_finalization_error":null,"latest_revision":null,"lines":{"object":"list","data":[{"id":"il_1Sc8r8HpVJPrOqLkORVvvQAt","object":"line_item","amount":9900,"amount_excluding_tax":9900,"currency":"usd","description":"1 × Agency (at $99.00 / month)","discount_amounts":[],"discountable":true,"discounts":[],"invoice":"in_1Sc8r8HpVJPrOqLkqss6grEV","livemode":false,"metadata":{},"parent":{"invoice_item_details":null,"subscription_item_details":{"invoice_item":null,"proration":false,"proration_details":{"credited_items":null},"subscription":"sub_1Sc8r8HpVJPrOqLkX4hZp1K4","subscription_item":"si_TZHPSgXrB8TKck"},"type":"subscription_item_details"},"period":{"end":1767895698,"start":1765217298},"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"pretax_credit_amounts":[],"price":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"price","active":true,"billing_scheme":"per_unit","created":1764856094,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"nickname":null,"product":"prod_TXiJSc9kvYKDXH","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":9900,"unit_amount_decimal":"9900"},"pricing":{"price_details":{"price":"price_1SactGHpVJPrOqLkrdqk0HUK","product":"prod_TXiJSc9kvYKDXH"},"type":"price_details","unit_amount_decimal":"9900"},"proration":false,"proration_details":{"credited_items":null},"quantity":1,"subscription":"sub_1Sc8r8HpVJPrOqLkX4hZp1K4","subscription_item":"si_TZHPSgXrB8TKck","tax_amounts":[],"tax_rates":[],"taxes":[],"type":"subscription","unique_id":"il_1Sc8r8HpVJPrOqLkORVvvQAt","unit_amount_excluding_tax":"9900"}],"has_more":false,"total_count":1,"url":"/v1/invoices/in_1Sc8r8HpVJPrOqLkqss6grEV/lines"},"livemode":false,"metadata":{},"next_payment_attempt":null,"number":"FVJFOQBG-0001","on_behalf_of":null,"paid":true,"paid_out_of_band":false,"parent":{"quote_details":null,"subscription_details":{"metadata":{},"subscription":"sub_1Sc8r8HpVJPrOqLkX4hZp1K4"},"type":"subscription_details"},"payment_intent":"pi_3Sc8r9HpVJPrOqLk0FLkqgHp","payment_settings":{"default_mandate":null,"payment_method_options":null,"payment_method_types":null},"period_end":1765217298,"period_start":1765217298,"post_payment_credit_notes_amount":0,"pre_payment_credit_notes_amount":0,"quote":null,"receipt_number":null,"rendering":null,"rendering_options":null,"shipping_cost":null,"shipping_details":null,"starting_balance":0,"statement_descriptor":null,"status":"paid","status_transitions":{"finalized_at":1765217298,"marked_uncollectible_at":null,"paid_at":1765217298,"voided_at":null},"subscription":"sub_1Sc8r8HpVJPrOqLkX4hZp1K4","subscription_details":{"metadata":{}},"subtotal":9900,"subtotal_excluding_tax":9900,"tax":null,"tax_percent":null,"test_clock":null,"total":9900,"total_discount_amounts":[],"total_excluding_tax":9900,"total_pretax_credit_amounts":[],"total_tax_amounts":[],"total_taxes":[],"transfer_data":null,"webhooks_delivered_at":1765217298}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_ZjfDO0ts60OvTy","idempotency_key":"stripe-node-retry-38b0ab00-e526-456a-8a03-5cdcc6104fe5"},"type":"invoice.payment_succeeded"}', 'e25cd914435a283d0899dd13e46413e29c98bc0cf76f126d26ec1478e826755e', 'processed', 0, 5, '2025-12-08 18:08:23', '2025-12-08 18:08:26', NULL, NULL, NULL, NULL, 3626, '["payment_succeeded"]', '[{"type":"transaction","id":1,"action":"created"}]', '::1', 1, NULL, '2025-12-08 18:08:23', '2025-12-08 18:08:26'),
(19, 'evt_1Sc9R4HpVJPrOqLkYWKeHO7b', 'payment_method.attached', '2018-05-21', 0, 'payment_method', 'pm_1Sc9R4HpVJPrOqLkOXnfcKFb', 'cus_TZI0IIGiL6g3IG', NULL, NULL, NULL, '{"id":"evt_1Sc9R4HpVJPrOqLkYWKeHO7b","object":"event","api_version":"2018-05-21","created":1765219526,"data":{"object":{"id":"pm_1Sc9R4HpVJPrOqLkOXnfcKFb","object":"payment_method","allow_redisplay":"unspecified","billing_details":{"address":{"city":null,"country":"IN","line1":null,"line2":null,"postal_code":null,"state":null},"email":"developerw0945@gmail.com","name":"Baljeet Singh","phone":"(714) 781-4565","tax_id":null},"card":{"brand":"visa","checks":{"address_line1_check":null,"address_postal_code_check":null,"cvc_check":"pass"},"country":"US","display_brand":"visa","exp_month":2,"exp_year":2034,"fingerprint":"G95Ez9iUIsKX1A0j","funding":"credit","generated_from":null,"last4":"1111","networks":{"available":["visa"],"preferred":null},"regulated_status":"unregulated","three_d_secure_usage":{"supported":true},"wallet":null},"created":1765219526,"customer":"cus_TZI0IIGiL6g3IG","customer_account":null,"livemode":false,"metadata":{},"type":"card"}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_jTfhbMoINUsurD","idempotency_key":"24cb82df-4594-4386-a966-0d43feb99fe5"},"type":"payment_method.attached"}', '53ba102641744dbd9a412de80078c60f69417a11539794b7b62b92602817e0b1', 'processed', 0, 5, '2025-12-08 18:45:27', '2025-12-08 18:45:29', NULL, NULL, NULL, NULL, 1888, '["payment_method_added"]', '[]', '::ffff:127.0.0.1', 1, NULL, '2025-12-08 18:45:27', '2025-12-08 18:45:29');
INSERT INTO "webhook_events" ("id", "stripe_event_id", "event_type", "api_version", "livemode", "object_type", "object_id", "customer_id", "subscription_id", "invoice_id", "payment_intent_id", "payload", "payload_hash", "status", "processing_attempts", "max_attempts", "received_at", "processed_at", "next_retry_at", "error_code", "error_message", "error_stack", "processing_time_ms", "actions_taken", "affected_records", "ip_address", "signature_verified", "metadata", "createdAt", "updatedAt") VALUES
(20, 'evt_1Sc9R7HpVJPrOqLkF2bjTmMH', 'customer.subscription.created', '2018-05-21', 0, 'subscription', 'sub_1Sc9R5HpVJPrOqLkPt4sV5R5', 'cus_TZI0IIGiL6g3IG', 'sub_1Sc9R5HpVJPrOqLkPt4sV5R5', NULL, NULL, '{"id":"evt_1Sc9R7HpVJPrOqLkF2bjTmMH","object":"event","api_version":"2018-05-21","created":1765219529,"data":{"object":{"id":"sub_1Sc9R5HpVJPrOqLkPt4sV5R5","object":"subscription","application":null,"application_fee_percent":null,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null},"billing":"charge_automatically","billing_cycle_anchor":1765305927,"billing_cycle_anchor_config":null,"billing_mode":{"flexible":{"proration_discounts":"included"},"type":"flexible","updated_at":1765219527},"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":null,"cancellation_details":{"comment":null,"feedback":null,"reason":null},"collection_method":"charge_automatically","created":1765219527,"currency":"usd","current_period_end":1765305927,"current_period_start":1765219527,"customer":"cus_TZI0IIGiL6g3IG","customer_account":null,"days_until_due":null,"default_payment_method":"pm_1Sc9R4HpVJPrOqLkOXnfcKFb","default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"ended_at":null,"invoice_customer_balance_settings":{"consume_applied_balance_on_void":true},"invoice_settings":{"account_tax_ids":null,"issuer":{"type":"self"}},"items":{"object":"list","data":[{"id":"si_TZI1SzOSrN3hIY","object":"subscription_item","billing_thresholds":null,"created":1765219528,"current_period_end":1765305927,"current_period_start":1765219527,"discounts":[],"metadata":{},"plan":{"id":"price_1SacsoHpVJPrOqLk55ldH9MX","object":"plan","active":true,"aggregate_usage":null,"amount":1900,"amount_decimal":"1900","billing_scheme":"per_unit","created":1764856066,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"10","plan_id":"1","billing_cycle":"monthly","max_team_members":"1","trial_days":"1"},"meter":null,"nickname":null,"product":"prod_TXiJ5slia0Fh1C","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"price":{"id":"price_1SacsoHpVJPrOqLk55ldH9MX","object":"price","active":true,"billing_scheme":"per_unit","created":1764856066,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"10","plan_id":"1","billing_cycle":"monthly","max_team_members":"1","trial_days":"1"},"nickname":null,"product":"prod_TXiJ5slia0Fh1C","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":1900,"unit_amount_decimal":"1900"},"quantity":1,"subscription":"sub_1Sc9R5HpVJPrOqLkPt4sV5R5","tax_rates":[]}],"has_more":false,"total_count":1,"url":"/v1/subscription_items?subscription=sub_1Sc9R5HpVJPrOqLkPt4sV5R5"},"latest_invoice":"in_1Sc9R5HpVJPrOqLkM1DKHuY9","livemode":false,"metadata":{},"next_pending_invoice_item_invoice":null,"on_behalf_of":null,"pause_collection":null,"payment_settings":{"payment_method_options":null,"payment_method_types":null,"save_default_payment_method":"off"},"pending_invoice_item_interval":null,"pending_setup_intent":null,"pending_update":null,"plan":{"id":"price_1SacsoHpVJPrOqLk55ldH9MX","object":"plan","active":true,"aggregate_usage":null,"amount":1900,"amount_decimal":"1900","billing_scheme":"per_unit","created":1764856066,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"10","plan_id":"1","billing_cycle":"monthly","max_team_members":"1","trial_days":"1"},"meter":null,"nickname":null,"product":"prod_TXiJ5slia0Fh1C","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1765219527,"start_date":1765219527,"status":"trialing","tax_percent":null,"test_clock":null,"transfer_data":null,"trial_end":1765305927,"trial_settings":{"end_behavior":{"missing_payment_method":"create_invoice"}},"trial_start":1765219527}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_LgiTMvEQlilBto","idempotency_key":"stripe-node-retry-05c64829-d8c1-455c-9ec8-796ff1b0cbaa"},"type":"customer.subscription.created"}', 'e93a8fe80e3046c15245a55631263419a65fe10172e1232cf750c94a5509abd0', 'processed', 0, 5, '2025-12-08 18:45:30', '2025-12-08 18:45:30', NULL, NULL, NULL, NULL, 478, '["subscription_created_logged"]', '[]', '::1', 1, NULL, '2025-12-08 18:45:30', '2025-12-08 18:45:30'),
(21, 'evt_1Sc9R7HpVJPrOqLk1VlxsWJe', 'invoice.payment_succeeded', '2018-05-21', 0, 'invoice', 'in_1Sc9R5HpVJPrOqLkM1DKHuY9', 'cus_TZI0IIGiL6g3IG', 'sub_1Sc9R5HpVJPrOqLkPt4sV5R5', 'in_1Sc9R5HpVJPrOqLkM1DKHuY9', NULL, '{"id":"evt_1Sc9R7HpVJPrOqLk1VlxsWJe","object":"event","api_version":"2018-05-21","created":1765219529,"data":{"object":{"id":"in_1Sc9R5HpVJPrOqLkM1DKHuY9","object":"invoice","account_country":"SE","account_name":"Aronasoft","account_tax_ids":null,"amount_due":0,"amount_overpaid":0,"amount_paid":0,"amount_remaining":0,"amount_shipping":0,"application":null,"application_fee":null,"attempt_count":0,"attempted":true,"auto_advance":false,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null,"provider":null,"status":null},"automatically_finalizes_at":null,"billing":"charge_automatically","billing_reason":"subscription_update","charge":null,"closed":true,"collection_method":"charge_automatically","created":1765219527,"currency":"usd","custom_fields":null,"customer":"cus_TZI0IIGiL6g3IG","customer_account":null,"customer_address":null,"customer_email":"developerw0945@gmail.com","customer_name":"Baljeet Singh","customer_phone":"(714) 781-4565","customer_shipping":null,"customer_tax_exempt":"none","customer_tax_ids":[],"date":1765219527,"default_payment_method":null,"default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"due_date":null,"effective_at":1765219527,"ending_balance":0,"finalized_at":1765219527,"footer":null,"forgiven":false,"from_invoice":null,"hosted_invoice_url":"https://invoice.stripe.com/i/acct_1AC6lAHpVJPrOqLk/test_YWNjdF8xQUM2bEFIcFZKUHJPcUxrLF9UWkkxOHVwamdBOVB0NlFwY2czMFlhek1Hd3VDbEw3LDE1NTc2MDMyOQ0200f13RqvAq?s=ap","invoice_pdf":"https://pay.stripe.com/invoice/acct_1AC6lAHpVJPrOqLk/test_YWNjdF8xQUM2bEFIcFZKUHJPcUxrLF9UWkkxOHVwamdBOVB0NlFwY2czMFlhek1Hd3VDbEw3LDE1NTc2MDMyOQ0200f13RqvAq/pdf?s=ap","issuer":{"type":"self"},"last_finalization_error":null,"latest_revision":null,"lines":{"object":"list","data":[{"id":"il_1Sc9R5HpVJPrOqLkKjSj9gEy","object":"line_item","amount":0,"amount_excluding_tax":0,"currency":"usd","description":"Free trial for 1 × Starter","discount_amounts":[],"discountable":true,"discounts":[],"invoice":"in_1Sc9R5HpVJPrOqLkM1DKHuY9","livemode":false,"metadata":{},"parent":{"invoice_item_details":null,"subscription_item_details":{"invoice_item":null,"proration":false,"proration_details":{"credited_items":null},"subscription":"sub_1Sc9R5HpVJPrOqLkPt4sV5R5","subscription_item":"si_TZI1SzOSrN3hIY"},"type":"subscription_item_details"},"period":{"end":1765305927,"start":1765219527},"plan":{"id":"price_1SacsoHpVJPrOqLk55ldH9MX","object":"plan","active":true,"aggregate_usage":null,"amount":1900,"amount_decimal":"1900","billing_scheme":"per_unit","created":1764856066,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"10","plan_id":"1","billing_cycle":"monthly","max_team_members":"1","trial_days":"1"},"meter":null,"nickname":null,"product":"prod_TXiJ5slia0Fh1C","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"pretax_credit_amounts":[],"price":{"id":"price_1SacsoHpVJPrOqLk55ldH9MX","object":"price","active":true,"billing_scheme":"per_unit","created":1764856066,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"10","plan_id":"1","billing_cycle":"monthly","max_team_members":"1","trial_days":"1"},"nickname":null,"product":"prod_TXiJ5slia0Fh1C","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":1900,"unit_amount_decimal":"1900"},"pricing":{"price_details":{"price":"price_1SacsoHpVJPrOqLk55ldH9MX","product":"prod_TXiJ5slia0Fh1C"},"type":"price_details","unit_amount_decimal":"0"},"proration":false,"proration_details":{"credited_items":null},"quantity":1,"subscription":"sub_1Sc9R5HpVJPrOqLkPt4sV5R5","subscription_item":"si_TZI1SzOSrN3hIY","tax_amounts":[],"tax_rates":[],"taxes":[],"type":"subscription","unique_id":"il_1Sc9R5HpVJPrOqLkKjSj9gEy","unit_amount_excluding_tax":"0"}],"has_more":false,"total_count":1,"url":"/v1/invoices/in_1Sc9R5HpVJPrOqLkM1DKHuY9/lines"},"livemode":false,"metadata":{},"next_payment_attempt":null,"number":"ITYFUTSR-0001","on_behalf_of":null,"paid":true,"paid_out_of_band":false,"parent":{"quote_details":null,"subscription_details":{"metadata":{},"subscription":"sub_1Sc9R5HpVJPrOqLkPt4sV5R5"},"type":"subscription_details"},"payment_intent":null,"payment_settings":{"default_mandate":null,"payment_method_options":null,"payment_method_types":null},"period_end":1765219527,"period_start":1765219527,"post_payment_credit_notes_amount":0,"pre_payment_credit_notes_amount":0,"quote":null,"receipt_number":null,"rendering":null,"rendering_options":null,"shipping_cost":null,"shipping_details":null,"starting_balance":0,"statement_descriptor":null,"status":"paid","status_transitions":{"finalized_at":1765219527,"marked_uncollectible_at":null,"paid_at":1765219527,"voided_at":null},"subscription":"sub_1Sc9R5HpVJPrOqLkPt4sV5R5","subscription_details":{"metadata":{}},"subtotal":0,"subtotal_excluding_tax":0,"tax":null,"tax_percent":null,"test_clock":null,"total":0,"total_discount_amounts":[],"total_excluding_tax":0,"total_pretax_credit_amounts":[],"total_tax_amounts":[],"total_taxes":[],"transfer_data":null,"webhooks_delivered_at":1765219527}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_LgiTMvEQlilBto","idempotency_key":"stripe-node-retry-05c64829-d8c1-455c-9ec8-796ff1b0cbaa"},"type":"invoice.payment_succeeded"}', '18a4e17bfb07e0be4ce89232c2a165cce474990749acb33dc27acf353bbbef91', 'processed', 0, 5, '2025-12-08 18:45:30', '2025-12-08 18:45:33', NULL, NULL, NULL, NULL, 3190, '["payment_succeeded"]', '[{"type":"transaction","id":2,"action":"created"}]', '::ffff:127.0.0.1', 1, NULL, '2025-12-08 18:45:30', '2025-12-08 18:45:33');

-- --------------------------------------------------------

--
-- Table structure for table "webhook_logs"
--

CREATE TABLE "webhook_logs" (
  "id" BIGINT NOT NULL,
  "webhook_id" BIGINT NOT NULL,
  "event_type" varchar(255) NOT NULL,
  "payload" TEXT  DEFAULT NULL ,
  "response_code" INTEGER DEFAULT NULL,
  "response_body" text DEFAULT NULL,
  "status" VARCHAR(255) NOT NULL DEFAULT 'pending',
  "error_message" text DEFAULT NULL,
  "retry_count" INTEGER NOT NULL DEFAULT 0,
  "executed_at" timestamp NULL DEFAULT NULL,
  "created_at" timestamp NULL DEFAULT NULL,
  "updated_at" timestamp NULL DEFAULT NULL