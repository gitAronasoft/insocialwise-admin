-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 08, 2025 at 07:44 PM
-- Server version: 11.8.3-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u742355347_insocial_newdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `id` int(11) NOT NULL,
  `user_uuid` varchar(255) DEFAULT NULL,
  `account_social_userid` varchar(255) DEFAULT NULL,
  `account_platform` varchar(255) DEFAULT NULL,
  `activity_type` varchar(255) DEFAULT NULL,
  `activity_subType` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `source_type` varchar(255) DEFAULT NULL,
  `post_form_id` varchar(255) DEFAULT NULL,
  `reference_pageID` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`reference_pageID`)),
  `activity_dateTime` datetime NOT NULL,
  `nextAPI_call_dateTime` datetime DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_alerts`
--

CREATE TABLE `admin_alerts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('payment_failed','critical_error','suspicious_login','subscription_cancelled','api_failure','system_warning','general') NOT NULL DEFAULT 'general',
  `severity` enum('critical','warning','info') NOT NULL DEFAULT 'info',
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `read` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,
  `read_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_audit_logs`
--

CREATE TABLE `admin_audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_email` varchar(255) DEFAULT NULL,
  `admin_name` varchar(255) DEFAULT NULL,
  `action_type` enum('login','logout','login_failed','password_changed','profile_updated','customer_created','customer_updated','customer_deleted','customer_status_changed','subscription_created','subscription_updated','subscription_canceled','plan_created','plan_updated','plan_deleted','setting_created','setting_updated','setting_deleted','admin_created','admin_updated','admin_deleted','role_assigned','role_removed','webhook_created','webhook_updated','webhook_deleted','webhook_tested','policy_created','policy_updated','data_request_handled','feature_flag_toggled','knowledge_base_created','knowledge_base_updated','knowledge_base_deleted','bulk_action','export_data','api_key_updated','api_key_tested','other') NOT NULL,
  `entity_type` varchar(255) DEFAULT NULL COMMENT 'Model or entity affected',
  `entity_id` varchar(255) DEFAULT NULL COMMENT 'ID of the affected entity',
  `description` text NOT NULL,
  `old_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_values`)),
  `new_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_values`)),
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `request_method` varchar(10) DEFAULT NULL,
  `request_url` text DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `severity` enum('info','warning','critical') NOT NULL DEFAULT 'info',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_feature_flags`
--

CREATE TABLE `admin_feature_flags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `feature_key` varchar(255) NOT NULL,
  `feature_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category` enum('core','admin','security','monitoring','data') NOT NULL DEFAULT 'core',
  `enabled` tinyint(1) NOT NULL DEFAULT 0,
  `force_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_sessions`
--

CREATE TABLE `admin_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `session_token` varchar(255) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` text DEFAULT NULL,
  `device_type` varchar(50) DEFAULT NULL,
  `browser` varchar(100) DEFAULT NULL,
  `os` varchar(100) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `is_current` tinyint(1) NOT NULL DEFAULT 0,
  `last_activity_at` timestamp NULL DEFAULT NULL,
  `logged_in_at` timestamp NOT NULL,
  `logged_out_at` timestamp NULL DEFAULT NULL,
  `status` enum('active','expired','revoked') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_settings`
--

CREATE TABLE `admin_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` longtext DEFAULT NULL,
  `type` enum('string','integer','boolean','json','email','encrypted') NOT NULL DEFAULT 'string',
  `group` varchar(255) NOT NULL DEFAULT 'general',
  `description` text DEFAULT NULL,
  `section` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_user_role`
--

CREATE TABLE `admin_user_role` (
  `admin_user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `adsets`
--

CREATE TABLE `adsets` (
  `id` int(11) NOT NULL,
  `user_uuid` varchar(255) DEFAULT NULL,
  `account_platform` varchar(255) DEFAULT NULL,
  `account_social_userid` varchar(255) DEFAULT NULL,
  `adsets_campaign_id` bigint(20) DEFAULT NULL,
  `adsets_id` bigint(20) DEFAULT NULL,
  `adsets_name` varchar(255) DEFAULT NULL,
  `adsets_countries` longtext DEFAULT NULL,
  `adsets_regions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`adsets_regions`)),
  `adsets_cities` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`adsets_cities`)),
  `adsets_age_min` int(11) DEFAULT NULL,
  `adsets_age_max` int(11) DEFAULT NULL,
  `adsets_genders` text DEFAULT NULL,
  `adsets_publisher_platforms` longtext DEFAULT NULL,
  `adsets_facebook_positions` longtext DEFAULT NULL,
  `adsets_instagram_positions` longtext DEFAULT NULL,
  `adsets_device_platforms` longtext DEFAULT NULL,
  `adsets_start_time` datetime DEFAULT NULL,
  `adsets_end_time` datetime DEFAULT NULL,
  `adsets_status` varchar(255) DEFAULT NULL,
  `adsets_insights_impressions` varchar(255) DEFAULT NULL,
  `adsets_insights_clicks` varchar(255) DEFAULT NULL,
  `adsets_insights_cpc` varchar(255) DEFAULT NULL,
  `adsets_insights_cpm` varchar(255) DEFAULT NULL,
  `adsets_insights_ctr` varchar(255) DEFAULT NULL,
  `adsets_insights_spend` varchar(255) DEFAULT NULL,
  `adsets_daily_budget` varchar(255) DEFAULT NULL,
  `adsets_lifetime_budget` varchar(255) DEFAULT NULL,
  `adsets_insights_date_start` date DEFAULT NULL,
  `adsets_insights_date_stop` date DEFAULT NULL,
  `adsets_insights_reach` varchar(255) DEFAULT NULL,
  `adsets_insights_results` int(11) DEFAULT NULL,
  `adsets_result_type` varchar(255) DEFAULT NULL,
  `adsets_insights_cost_per_result` float DEFAULT NULL,
  `adsets_insights_actions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`adsets_insights_actions`)),
  `createdAt` timestamp NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `adsets_ads`
--

CREATE TABLE `adsets_ads` (
  `id` int(11) NOT NULL,
  `user_uuid` varchar(255) DEFAULT NULL,
  `account_platform` varchar(255) DEFAULT NULL,
  `account_social_userid` varchar(255) DEFAULT NULL,
  `campaign_id` bigint(20) DEFAULT NULL,
  `adsets_id` bigint(20) DEFAULT NULL,
  `ads_id` bigint(20) DEFAULT NULL,
  `ads_name` varchar(255) DEFAULT NULL,
  `ads_status` varchar(255) DEFAULT NULL,
  `ads_effective_status` varchar(255) DEFAULT NULL,
  `ads_insights_impressions` varchar(255) DEFAULT NULL,
  `ads_insights_clicks` varchar(255) DEFAULT NULL,
  `ads_insights_cpc` varchar(255) DEFAULT NULL,
  `ads_insights_cpm` varchar(255) DEFAULT NULL,
  `ads_insights_ctr` varchar(255) DEFAULT NULL,
  `ads_insights_spend` varchar(255) DEFAULT NULL,
  `ads_insights_reach` varchar(255) DEFAULT NULL,
  `ads_insights_date_start` date DEFAULT NULL,
  `ads_insights_date_stop` date DEFAULT NULL,
  `ads_insights_cost_per_result` varchar(255) DEFAULT NULL,
  `ads_result_type` varchar(255) DEFAULT NULL,
  `ads_insights_actions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`ads_insights_actions`)),
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ads_accounts`
--

CREATE TABLE `ads_accounts` (
  `id` int(11) NOT NULL,
  `user_uuid` varchar(255) DEFAULT NULL,
  `account_platform` varchar(255) DEFAULT NULL,
  `account_social_userid` varchar(255) DEFAULT NULL,
  `account_id` varchar(255) DEFAULT NULL,
  `account_name` varchar(255) DEFAULT NULL,
  `account_status` varchar(255) DEFAULT NULL,
  `isConnected` enum('notConnected','Connected') NOT NULL DEFAULT 'notConnected',
  `currency` varchar(250) DEFAULT NULL,
  `timezone_name` varchar(250) DEFAULT NULL,
  `timezone_offset_hours_utc` varchar(250) DEFAULT NULL,
  `amount_spent` int(11) DEFAULT 0,
  `balance` int(11) DEFAULT 0,
  `business_page_detail` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`business_page_detail`)),
  `min_campaign_group_spend_cap` int(11) DEFAULT 0,
  `spend_cap` int(11) DEFAULT 0,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ads_creative`
--

CREATE TABLE `ads_creative` (
  `id` int(11) NOT NULL,
  `user_uuid` varchar(255) DEFAULT NULL,
  `account_platform` varchar(255) DEFAULT NULL,
  `social_page_id` varchar(250) DEFAULT NULL,
  `account_social_userid` varchar(255) DEFAULT NULL,
  `campaign_id` varchar(255) DEFAULT NULL,
  `adset_id` varchar(255) DEFAULT NULL,
  `ad_id` varchar(255) DEFAULT NULL,
  `creative_id` varchar(255) DEFAULT NULL,
  `creative_type` varchar(255) DEFAULT NULL,
  `image_urls` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`image_urls`)),
  `video_thumbnails` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`video_thumbnails`)),
  `headline` varchar(255) DEFAULT NULL,
  `body` text DEFAULT NULL,
  `call_to_action` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`call_to_action`)),
  `call_to_action_link` varchar(255) DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `alert_thresholds`
--

CREATE TABLE `alert_thresholds` (
  `id` int(11) NOT NULL,
  `user_uuid` varchar(255) NOT NULL,
  `alert_name` varchar(255) NOT NULL,
  `metric_type` enum('engagement_rate','followers','reach','impressions','likes','comments','shares') NOT NULL,
  `condition` enum('below','above','drops_by') NOT NULL DEFAULT 'below',
  `threshold_value` float NOT NULL,
  `comparison_period` enum('day','week','month') NOT NULL DEFAULT 'day',
  `is_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `notify_email` tinyint(1) NOT NULL DEFAULT 1,
  `notify_in_app` tinyint(1) NOT NULL DEFAULT 1,
  `email_recipients` text DEFAULT NULL,
  `last_triggered_at` datetime DEFAULT NULL,
  `last_value` float DEFAULT NULL,
  `trigger_count` int(11) NOT NULL DEFAULT 0,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `analytics`
--

CREATE TABLE `analytics` (
  `id` int(11) NOT NULL,
  `user_uuid` varchar(255) DEFAULT NULL,
  `platform_page_Id` varchar(255) DEFAULT NULL,
  `platform` varchar(255) DEFAULT NULL,
  `analytic_type` varchar(255) DEFAULT NULL,
  `total_page_followers` bigint(255) DEFAULT NULL,
  `total_page_impressions` bigint(255) DEFAULT NULL,
  `total_page_impressions_unique` bigint(255) DEFAULT NULL,
  `total_page_views` bigint(255) DEFAULT NULL,
  `page_post_engagements` bigint(255) DEFAULT NULL,
  `page_actions_post_reactions_like_total` bigint(255) DEFAULT NULL,
  `week_date` varchar(255) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `billing_activity_logs`
--

CREATE TABLE `billing_activity_logs` (
  `id` int(11) NOT NULL,
  `user_uuid` varchar(255) DEFAULT NULL COMMENT 'User UUID reference',
  `subscription_id` int(11) DEFAULT NULL COMMENT 'Related subscription ID',
  `transaction_id` int(11) DEFAULT NULL COMMENT 'Related transaction ID',
  `action_type` enum('subscription_created','subscription_updated','subscription_canceled','subscription_reactivated','subscription_paused','subscription_resumed','plan_upgraded','plan_downgraded','trial_started','trial_extended','trial_ended','payment_attempted','payment_succeeded','payment_failed','payment_refunded','invoice_created','invoice_sent','invoice_paid','invoice_voided','card_added','card_updated','card_removed','card_set_default','billing_info_updated','coupon_applied','coupon_removed','webhook_received','webhook_processed','notification_sent','dunning_started','dunning_escalated','dunning_resolved','admin_action','system_action') NOT NULL COMMENT 'Type of billing action',
  `action_status` enum('success','failed','pending','skipped') NOT NULL DEFAULT 'success' COMMENT 'Status of the action',
  `actor_type` enum('user','admin','system','stripe','cron') NOT NULL DEFAULT 'system' COMMENT 'Who performed the action',
  `actor_id` varchar(255) DEFAULT NULL COMMENT 'ID of the actor',
  `actor_email` varchar(255) DEFAULT NULL COMMENT 'Email of the actor',
  `old_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Previous value(s) before change' CHECK (json_valid(`old_value`)),
  `new_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'New value(s) after change' CHECK (json_valid(`new_value`)),
  `amount` int(11) DEFAULT NULL COMMENT 'Amount involved in cents',
  `currency` varchar(3) DEFAULT NULL COMMENT 'Currency code',
  `stripe_event_id` varchar(255) DEFAULT NULL COMMENT 'Related Stripe event ID',
  `stripe_object_id` varchar(255) DEFAULT NULL COMMENT 'Related Stripe object ID (subscription, invoice, etc.)',
  `error_code` varchar(100) DEFAULT NULL COMMENT 'Error code if failed',
  `error_message` text DEFAULT NULL COMMENT 'Error message if failed',
  `description` text DEFAULT NULL COMMENT 'Human-readable description',
  `notes` text DEFAULT NULL COMMENT 'Admin notes',
  `ip_address` varchar(45) DEFAULT NULL COMMENT 'IP address of the request',
  `user_agent` text DEFAULT NULL COMMENT 'User agent string',
  `request_id` varchar(255) DEFAULT NULL COMMENT 'Request ID for tracing',
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Additional metadata' CHECK (json_valid(`metadata`)),
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `billing_notifications`
--

CREATE TABLE `billing_notifications` (
  `id` int(11) NOT NULL,
  `user_uuid` varchar(255) NOT NULL COMMENT 'User UUID reference',
  `subscription_id` int(11) DEFAULT NULL COMMENT 'Related subscription ID',
  `transaction_id` int(11) DEFAULT NULL COMMENT 'Related transaction ID',
  `notification_type` enum('trial_ending_24h','trial_ending_1h','trial_ended','subscription_created','subscription_renewed','subscription_canceled','subscription_paused','subscription_resumed','renewal_reminder_7d','renewal_reminder_3d','renewal_reminder_1d','payment_succeeded','payment_failed','payment_failed_final','payment_method_expiring','payment_method_expired','invoice_created','invoice_paid','invoice_past_due','refund_processed','plan_upgraded','plan_downgraded','dunning_reminder') NOT NULL COMMENT 'Type of notification',
  `channel` enum('email','in_app','sms','push') NOT NULL DEFAULT 'email' COMMENT 'Notification channel',
  `priority` enum('low','normal','high','urgent') NOT NULL DEFAULT 'normal' COMMENT 'Notification priority',
  `status` enum('pending','queued','sent','delivered','failed','canceled','skipped') NOT NULL DEFAULT 'pending' COMMENT 'Notification status',
  `recipient_email` varchar(255) DEFAULT NULL COMMENT 'Email recipient',
  `recipient_phone` varchar(50) DEFAULT NULL COMMENT 'Phone recipient (for SMS)',
  `subject` varchar(500) DEFAULT NULL COMMENT 'Email subject',
  `template_name` varchar(100) DEFAULT NULL COMMENT 'Email template name',
  `template_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Data for template rendering' CHECK (json_valid(`template_data`)),
  `content` text DEFAULT NULL COMMENT 'Rendered content (for logging)',
  `scheduled_at` datetime NOT NULL COMMENT 'When to send the notification',
  `sent_at` datetime DEFAULT NULL COMMENT 'When notification was sent',
  `delivered_at` datetime DEFAULT NULL COMMENT 'When notification was delivered',
  `opened_at` datetime DEFAULT NULL COMMENT 'When email was opened',
  `clicked_at` datetime DEFAULT NULL COMMENT 'When link was clicked',
  `retry_count` int(11) NOT NULL DEFAULT 0 COMMENT 'Number of send attempts',
  `max_retries` int(11) NOT NULL DEFAULT 3 COMMENT 'Maximum retry attempts',
  `last_error` text DEFAULT NULL COMMENT 'Last error message',
  `external_id` varchar(255) DEFAULT NULL COMMENT 'External service ID (SendGrid, etc.)',
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Additional metadata' CHECK (json_valid(`metadata`)),
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `campaigns`
--

CREATE TABLE `campaigns` (
  `id` int(11) NOT NULL,
  `user_uuid` varchar(255) DEFAULT NULL,
  `account_platform` varchar(255) DEFAULT NULL,
  `account_social_userid` bigint(20) DEFAULT NULL,
  `ad_account_id` bigint(20) DEFAULT NULL,
  `campaign_id` varchar(255) DEFAULT NULL,
  `campaign_name` varchar(255) DEFAULT NULL,
  `campaign_category` varchar(255) DEFAULT NULL,
  `campaign_bid_strategy` varchar(255) DEFAULT NULL,
  `campaign_buying_type` varchar(255) DEFAULT NULL,
  `campaign_objective` varchar(255) DEFAULT NULL,
  `campaign_budget_remaining` varchar(255) DEFAULT NULL,
  `campaign_daily_budget` varchar(255) DEFAULT NULL,
  `campaign_lifetime_budget` varchar(255) DEFAULT NULL,
  `campaign_effective_status` varchar(255) DEFAULT NULL,
  `campaign_start_time` datetime DEFAULT NULL,
  `campaign_end_time` datetime DEFAULT NULL,
  `campaign_status` varchar(255) DEFAULT NULL,
  `campaign_insights_clicks` bigint(20) DEFAULT NULL,
  `campaign_insights_cpc` varchar(255) DEFAULT NULL,
  `campaign_insights_cpm` varchar(255) DEFAULT NULL,
  `campaign_insights_cpp` varchar(255) DEFAULT NULL,
  `campaign_insights_ctr` varchar(255) DEFAULT NULL,
  `campaign_insights_date_start` date DEFAULT NULL,
  `campaign_insights_date_stop` date DEFAULT NULL,
  `campaign_insights_impressions` varchar(255) DEFAULT NULL,
  `campaign_insights_spend` varchar(255) DEFAULT NULL,
  `campaign_insights_reach` int(11) DEFAULT NULL,
  `campaign_insights_results` float DEFAULT NULL,
  `campaign_result_type` varchar(255) DEFAULT NULL,
  `campaign_insights_cost_per_result` float DEFAULT NULL,
  `campaign_insights_actions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`campaign_insights_actions`)),
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `compliance_policies`
--

CREATE TABLE `compliance_policies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `policy_type` enum('privacy_policy','terms_of_service','cookie_policy','data_retention','gdpr') NOT NULL,
  `content` longtext NOT NULL,
  `version` varchar(255) NOT NULL DEFAULT '1.0',
  `effective_date` date NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_requests`
--

CREATE TABLE `data_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_uuid` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `request_type` enum('export','delete','access','rectification') NOT NULL DEFAULT 'export',
  `status` enum('pending','processing','completed','rejected') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `processed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_retention_rules`
--

CREATE TABLE `data_retention_rules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `data_type` varchar(255) NOT NULL,
  `retention_days` int(11) NOT NULL,
  `auto_delete` tinyint(1) NOT NULL DEFAULT 0,
  `last_cleanup_at` timestamp NULL DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `demographics`
--

CREATE TABLE `demographics` (
  `id` int(11) NOT NULL,
  `user_uuid` varchar(255) NOT NULL,
  `platform_page_Id` varchar(255) NOT NULL,
  `page_name` varchar(255) NOT NULL,
  `social_userid` varchar(255) NOT NULL,
  `platform` enum('facebook','linkedin','instagram','NA') NOT NULL DEFAULT 'NA',
  `metric_type` varchar(200) DEFAULT NULL,
  `metric_key` varchar(250) DEFAULT NULL,
  `metric_value` int(11) NOT NULL DEFAULT 0,
  `source` enum('API','Sheet','NA') NOT NULL DEFAULT 'NA',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inbox_conversations`
--

CREATE TABLE `inbox_conversations` (
  `id` int(11) NOT NULL,
  `user_uuid` varchar(250) NOT NULL,
  `social_userid` varchar(200) NOT NULL,
  `social_pageid` varchar(250) NOT NULL,
  `social_platform` enum('facebook','linkedin','instagram','NA') NOT NULL DEFAULT 'NA',
  `conversation_id` varchar(200) NOT NULL,
  `external_userid` varchar(200) NOT NULL,
  `external_username` varchar(200) DEFAULT NULL,
  `external_userImg` varchar(250) DEFAULT NULL,
  `snippet` varchar(250) NOT NULL,
  `status` enum('Active','InActive') NOT NULL DEFAULT 'InActive',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inbox_messages`
--

CREATE TABLE `inbox_messages` (
  `id` int(11) NOT NULL,
  `conversation_id` varchar(200) NOT NULL,
  `platform_message_id` varchar(200) NOT NULL,
  `sender_type` enum('page','visitor') NOT NULL DEFAULT 'page' COMMENT '"page"||"visitor"',
  `message_text` text NOT NULL,
  `message_type` varchar(250) NOT NULL,
  `is_read` enum('yes','no') DEFAULT 'yes',
  `timestamp` varchar(200) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `knowledgebase_meta`
--

CREATE TABLE `knowledgebase_meta` (
  `id` int(11) NOT NULL,
  `user_uuid` varchar(255) NOT NULL,
  `knowledgeBase_id` varchar(255) DEFAULT NULL,
  `pages_id` longtext DEFAULT NULL,
  `social_account_id` longtext DEFAULT NULL,
  `social_platform` longtext DEFAULT NULL,
  `namespace_id` varchar(255) DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `knowledge_base`
--

CREATE TABLE `knowledge_base` (
  `id` int(11) NOT NULL,
  `user_uuid` varchar(255) DEFAULT NULL,
  `knowledgeBase_title` varchar(255) DEFAULT NULL,
  `knowledgeBase_content` longtext DEFAULT NULL,
  `social_platform` longtext DEFAULT NULL,
  `socialDataDetail` longtext DEFAULT NULL,
  `status` enum('Connected','notConnected','','') NOT NULL DEFAULT 'notConnected',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `user_uuid` varchar(255) DEFAULT NULL,
  `social_userid` varchar(255) DEFAULT NULL,
  `accountPlatform` varchar(255) DEFAULT NULL,
  `notificationType` varchar(255) DEFAULT NULL,
  `notificationType_id` varchar(255) DEFAULT NULL,
  `page_or_post_id` varchar(255) DEFAULT NULL,
  `is_read` enum('yes','no') DEFAULT 'no',
  `notification_dateTime` datetime NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_settings`
--

CREATE TABLE `notification_settings` (
  `id` int(11) NOT NULL,
  `notification_type` varchar(100) NOT NULL COMMENT 'Unique identifier for notification type (e.g., trial_ending_24h, usage_limit_80)',
  `category` enum('billing','usage','engagement','system','marketing') NOT NULL DEFAULT 'system' COMMENT 'Category of notification for grouping',
  `name` varchar(255) NOT NULL COMMENT 'Human-readable name for admin display',
  `description` text DEFAULT NULL COMMENT 'Description of what this notification does',
  `enabled` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Whether this notification is active',
  `frequency` enum('immediate','hourly','daily','weekly','monthly') NOT NULL DEFAULT 'immediate' COMMENT 'How often to check/send this notification type',
  `channels` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT 'Channels to send notification through (email, in_app, push, sms)' CHECK (json_valid(`channels`)),
  `template_name` varchar(100) DEFAULT NULL COMMENT 'Email template name to use',
  `subject_template` varchar(500) DEFAULT NULL COMMENT 'Email subject template with placeholders',
  `conditions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Trigger conditions (e.g., { days_before: 3, percentage: 80 })' CHECK (json_valid(`conditions`)),
  `priority` int(11) NOT NULL DEFAULT 3 COMMENT 'Priority level 1-5 (5 = highest)',
  `retry_enabled` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Whether to retry failed notifications',
  `max_retries` int(11) NOT NULL DEFAULT 3 COMMENT 'Maximum retry attempts',
  `cooldown_hours` int(11) DEFAULT 24 COMMENT 'Hours to wait before sending same notification type to same user',
  `user_configurable` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Whether users can opt out of this notification',
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Additional configuration data' CHECK (json_valid(`metadata`)),
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int(11) NOT NULL,
  `user_uuid` varchar(255) NOT NULL COMMENT 'User UUID reference',
  `stripe_customer_id` varchar(255) NOT NULL COMMENT 'Stripe customer ID',
  `stripe_payment_method_id` varchar(255) NOT NULL COMMENT 'Stripe payment method ID',
  `type` enum('card','bank_account','sepa_debit','us_bank_account','link') NOT NULL DEFAULT 'card' COMMENT 'Payment method type',
  `brand` varchar(50) DEFAULT NULL COMMENT 'Card brand (visa, mastercard, amex, etc.)',
  `last4` varchar(4) DEFAULT NULL COMMENT 'Last 4 digits',
  `exp_month` int(11) DEFAULT NULL COMMENT 'Card expiration month',
  `exp_year` int(11) DEFAULT NULL COMMENT 'Card expiration year',
  `funding` enum('credit','debit','prepaid','unknown') DEFAULT NULL COMMENT 'Card funding type',
  `country` varchar(2) DEFAULT NULL COMMENT 'Card issuing country',
  `billing_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Billing details (name, email, address)' CHECK (json_valid(`billing_details`)),
  `is_default` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Is this the default payment method',
  `status` enum('active','expired','deleted') NOT NULL DEFAULT 'active' COMMENT 'Payment method status',
  `fingerprint` varchar(255) DEFAULT NULL COMMENT 'Card fingerprint for duplicate detection',
  `wallet` varchar(50) DEFAULT NULL COMMENT 'Digital wallet type (apple_pay, google_pay, etc.)',
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Additional metadata' CHECK (json_valid(`metadata`)),
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) DEFAULT NULL,
  `group` varchar(255) NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_uuid` varchar(255) DEFAULT NULL,
  `social_user_id` varchar(200) NOT NULL,
  `page_id` varchar(150) NOT NULL,
  `content` text NOT NULL,
  `schedule_time` varchar(250) DEFAULT NULL,
  `post_media` longtext DEFAULT NULL,
  `platform_post_id` varchar(255) DEFAULT NULL,
  `post_platform` varchar(255) DEFAULT NULL,
  `source` enum('Platform','API') NOT NULL DEFAULT 'Platform',
  `form_id` varchar(250) NOT NULL,
  `likes` int(11) DEFAULT 0,
  `comments` int(11) DEFAULT 0,
  `shares` int(11) DEFAULT 0,
  `engagements` double DEFAULT 0,
  `impressions` varchar(255) DEFAULT '0',
  `unique_impressions` varchar(255) DEFAULT '0',
  `week_date` varchar(255) DEFAULT NULL,
  `status` enum('0','1','2','') NOT NULL DEFAULT '0' COMMENT '0="Draft",1="Published",2="Scheduled"',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_comments`
--

CREATE TABLE `post_comments` (
  `id` int(11) NOT NULL,
  `user_uuid` varchar(255) DEFAULT NULL,
  `social_userid` varchar(255) DEFAULT NULL,
  `platform_page_Id` varchar(255) DEFAULT NULL,
  `platform` varchar(255) DEFAULT NULL,
  `post_id` varchar(255) DEFAULT NULL,
  `activity_id` varchar(255) DEFAULT NULL,
  `comment_id` varchar(255) DEFAULT NULL,
  `parent_comment_id` varchar(255) DEFAULT NULL,
  `from_id` varchar(255) DEFAULT NULL,
  `from_name` varchar(255) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `comment_created_time` varchar(255) DEFAULT NULL,
  `comment_type` varchar(255) DEFAULT NULL,
  `comment_behavior` varchar(255) DEFAULT NULL,
  `reaction_like` int(11) NOT NULL DEFAULT 0,
  `reaction_love` int(11) NOT NULL DEFAULT 0,
  `reaction_haha` int(11) NOT NULL DEFAULT 0,
  `reaction_wow` int(11) NOT NULL DEFAULT 0,
  `reaction_sad` int(11) NOT NULL DEFAULT 0,
  `reaction_angry` int(11) NOT NULL DEFAULT 0,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) DEFAULT NULL,
  `is_super_admin` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_permission`
--

CREATE TABLE `role_permission` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saved_reports`
--

CREATE TABLE `saved_reports` (
  `id` int(11) NOT NULL,
  `user_uuid` varchar(255) NOT NULL,
  `report_name` varchar(255) NOT NULL,
  `report_type` varchar(255) NOT NULL,
  `selected_metrics` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`selected_metrics`)),
  `date_range` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`date_range`)),
  `export_format` varchar(255) DEFAULT 'excel',
  `report_data` longtext DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `status` enum('Ready','Processing','Failed') DEFAULT 'Ready',
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `user_uuid` varchar(255) DEFAULT NULL,
  `module_name` enum('Comment','Message') NOT NULL DEFAULT 'Comment',
  `module_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0="InActive",1="Active"',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `social_media_page_score`
--

CREATE TABLE `social_media_page_score` (
  `id` int(11) NOT NULL,
  `social_score_id` int(11) NOT NULL,
  `user_uuid` varchar(255) NOT NULL,
  `platform_name` varchar(100) NOT NULL,
  `page_id` varchar(255) NOT NULL,
  `page_name` varchar(255) DEFAULT NULL,
  `score_date` date NOT NULL,
  `score` decimal(5,2) DEFAULT 0.00,
  `engagement` int(11) DEFAULT 0,
  `reach` int(11) DEFAULT 0,
  `shares` int(11) DEFAULT 0,
  `follower_growth_percent` decimal(5,2) DEFAULT 0.00,
  `recommendations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`recommendations`)),
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `overall_score` decimal(5,2) DEFAULT 0.00,
  `content_score` decimal(5,2) DEFAULT 0.00,
  `engagement_score` decimal(5,2) DEFAULT 0.00,
  `growth_score` decimal(5,2) DEFAULT 0.00,
  `consistency_score` decimal(5,2) DEFAULT 0.00,
  `calculated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `social_media_score`
--

CREATE TABLE `social_media_score` (
  `id` int(11) NOT NULL,
  `user_uuid` char(36) NOT NULL,
  `score_date` date NOT NULL,
  `total_score` decimal(5,2) DEFAULT 0.00,
  `total_engagement` int(11) DEFAULT 0,
  `total_reach` int(11) DEFAULT 0,
  `total_shares` int(11) DEFAULT 0,
  `follower_growth_percent` decimal(5,2) DEFAULT 0.00,
  `total_pages` int(11) DEFAULT 0,
  `recommendations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`recommendations`)),
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `overall_score` decimal(5,2) DEFAULT 0.00,
  `content_score` decimal(5,2) DEFAULT 0.00,
  `engagement_score` decimal(5,2) DEFAULT 0.00,
  `growth_score` decimal(5,2) DEFAULT 0.00,
  `consistency_score` decimal(5,2) DEFAULT 0.00,
  `calculated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `social_page`
--

CREATE TABLE `social_page` (
  `id` int(11) NOT NULL,
  `user_uuid` varchar(255) DEFAULT NULL,
  `social_userid` varchar(250) NOT NULL,
  `pageName` varchar(150) NOT NULL,
  `page_picture` longtext DEFAULT NULL,
  `page_cover` longtext DEFAULT NULL,
  `pageId` varchar(150) NOT NULL,
  `token` longtext NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `total_followers` int(11) NOT NULL DEFAULT 0,
  `page_platform` varchar(255) DEFAULT NULL,
  `status` enum('notConnected','Connected') DEFAULT 'notConnected',
  `platform` varchar(255) DEFAULT NULL,
  `modify_to` text DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `social_users`
--

CREATE TABLE `social_users` (
  `id` int(11) NOT NULL,
  `user_id` varchar(250) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `img_url` varchar(250) DEFAULT NULL,
  `social_id` varchar(200) NOT NULL,
  `social_user_platform` varchar(255) DEFAULT NULL,
  `user_token` longtext NOT NULL,
  `status` enum('Connected','notConnected','','') DEFAULT 'notConnected',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_uuid` varchar(255) NOT NULL,
  `stripe_customer_id` varchar(255) NOT NULL,
  `stripe_subscription_id` varchar(255) NOT NULL,
  `price_id` varchar(255) NOT NULL,
  `plan_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Local subscription plan ID',
  `status` varchar(50) NOT NULL,
  `trial_end` datetime DEFAULT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `stripe_price_id` varchar(255) DEFAULT NULL COMMENT 'Stripe price ID',
  `trial_start` datetime DEFAULT NULL COMMENT 'Trial period start date',
  `trial_days` int(11) DEFAULT NULL COMMENT 'Number of trial days',
  `current_period_start` datetime DEFAULT NULL COMMENT 'Current billing period start',
  `current_period_end` datetime DEFAULT NULL COMMENT 'Current billing period end',
  `billing_cycle_anchor` datetime DEFAULT NULL COMMENT 'Billing cycle anchor date',
  `next_invoice_date` datetime DEFAULT NULL COMMENT 'Next invoice/billing date',
  `cancel_at_period_end` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Whether subscription cancels at period end',
  `cancel_at` datetime DEFAULT NULL COMMENT 'Scheduled cancellation date',
  `canceled_at` datetime DEFAULT NULL COMMENT 'When cancellation was requested',
  `ended_at` datetime DEFAULT NULL COMMENT 'When subscription actually ended',
  `cancellation_reason` varchar(255) DEFAULT NULL COMMENT 'Reason for cancellation',
  `cancellation_feedback` text DEFAULT NULL COMMENT 'User feedback on cancellation',
  `pause_collection` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Pause collection settings from Stripe' CHECK (json_valid(`pause_collection`)),
  `resume_at` datetime DEFAULT NULL COMMENT 'When paused subscription should resume',
  `collection_method` enum('charge_automatically','send_invoice') DEFAULT 'charge_automatically' COMMENT 'How payments are collected',
  `default_payment_method_id` varchar(255) DEFAULT NULL COMMENT 'Default payment method for this subscription',
  `latest_invoice_id` varchar(255) DEFAULT NULL COMMENT 'Latest Stripe invoice ID',
  `quantity` int(11) DEFAULT 1 COMMENT 'Subscription quantity (seats)',
  `amount` decimal(10,2) DEFAULT NULL COMMENT 'Subscription amount',
  `currency` varchar(3) DEFAULT 'USD' COMMENT 'Subscription currency',
  `billing_interval` enum('month','year') DEFAULT 'month' COMMENT 'Billing interval',
  `discount_percent` decimal(5,2) DEFAULT NULL COMMENT 'Discount percentage applied',
  `coupon_code` varchar(100) DEFAULT NULL COMMENT 'Applied coupon code',
  `stripe_coupon_id` varchar(255) DEFAULT NULL COMMENT 'Stripe coupon ID',
  `past_due_since` datetime DEFAULT NULL COMMENT 'When subscription became past due',
  `last_payment_attempt_at` datetime DEFAULT NULL COMMENT 'Last payment attempt timestamp',
  `last_payment_error` text DEFAULT NULL COMMENT 'Last payment error message',
  `payment_retry_count` int(11) DEFAULT 0 COMMENT 'Number of payment retry attempts',
  `next_payment_retry_at` datetime DEFAULT NULL COMMENT 'Next scheduled payment retry',
  `dunning_status` enum('none','in_progress','exhausted') DEFAULT 'none' COMMENT 'Dunning (payment recovery) status',
  `status_reason` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Detailed reason for current status' CHECK (json_valid(`status_reason`)),
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Additional metadata from Stripe' CHECK (json_valid(`metadata`)),
  `trial_reminder_sent` tinyint(1) DEFAULT 0 COMMENT 'Whether trial ending reminder was sent',
  `trial_reminder_sent_at` datetime DEFAULT NULL COMMENT 'When trial reminder was sent',
  `renewal_reminder_sent` tinyint(1) DEFAULT 0 COMMENT 'Whether renewal reminder was sent',
  `renewal_reminder_sent_at` datetime DEFAULT NULL COMMENT 'When renewal reminder was sent',
  `synced_at` datetime DEFAULT NULL COMMENT 'Last sync with Stripe'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscription_events`
--

CREATE TABLE `subscription_events` (
  `id` int(11) NOT NULL,
  `subscription_id` int(11) DEFAULT NULL COMMENT 'Local subscription ID reference',
  `user_uuid` varchar(255) DEFAULT NULL COMMENT 'User UUID reference',
  `stripe_subscription_id` varchar(255) DEFAULT NULL COMMENT 'Stripe subscription ID',
  `stripe_event_id` varchar(255) DEFAULT NULL COMMENT 'Stripe event ID for idempotency',
  `event_type` enum('subscription_created','subscription_updated','subscription_deleted','subscription_paused','subscription_resumed','trial_started','trial_ending','trial_ended','trial_converted','payment_succeeded','payment_failed','payment_refunded','invoice_created','invoice_paid','invoice_payment_failed','invoice_upcoming','plan_changed','quantity_changed','status_changed','canceled','reactivated','dunning_started','dunning_ended') NOT NULL COMMENT 'Type of subscription event',
  `old_status` varchar(50) DEFAULT NULL COMMENT 'Previous subscription status',
  `new_status` varchar(50) DEFAULT NULL COMMENT 'New subscription status',
  `old_plan_id` varchar(255) DEFAULT NULL COMMENT 'Previous plan ID (for plan changes)',
  `new_plan_id` varchar(255) DEFAULT NULL COMMENT 'New plan ID (for plan changes)',
  `old_quantity` int(11) DEFAULT NULL COMMENT 'Previous quantity',
  `new_quantity` int(11) DEFAULT NULL COMMENT 'New quantity',
  `amount` int(11) DEFAULT NULL COMMENT 'Amount involved (in cents)',
  `currency` varchar(3) DEFAULT NULL COMMENT 'Currency code',
  `failure_code` varchar(100) DEFAULT NULL COMMENT 'Failure code if applicable',
  `failure_message` text DEFAULT NULL COMMENT 'Failure message if applicable',
  `actor` enum('system','user','admin','stripe','webhook') DEFAULT 'system' COMMENT 'Who triggered this event',
  `actor_id` varchar(255) DEFAULT NULL COMMENT 'ID of the actor (user UUID, admin ID, etc.)',
  `ip_address` varchar(45) DEFAULT NULL COMMENT 'IP address if user-initiated',
  `user_agent` text DEFAULT NULL COMMENT 'User agent if user-initiated',
  `description` text DEFAULT NULL COMMENT 'Human-readable description',
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Additional event data' CHECK (json_valid(`metadata`)),
  `event_payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Full Stripe event payload for debugging' CHECK (json_valid(`event_payload`)),
  `occurred_at` datetime NOT NULL COMMENT 'When the event occurred',
  `processed_at` datetime DEFAULT NULL COMMENT 'When the event was processed',
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscription_plans`
--

CREATE TABLE `subscription_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `stripe_price_id` varchar(255) DEFAULT NULL,
  `stripe_yearly_price_id` varchar(255) DEFAULT NULL,
  `stripe_product_id` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `monthly_price_usd` decimal(10,2) NOT NULL DEFAULT 0.00,
  `yearly_price_usd` decimal(10,2) DEFAULT NULL,
  `monthly_price_inr` decimal(10,2) NOT NULL DEFAULT 0.00,
  `yearly_price_inr` decimal(10,2) DEFAULT NULL,
  `yearly_price` decimal(10,2) DEFAULT NULL,
  `yearly_discount_percent` int(11) NOT NULL DEFAULT 0,
  `currency` varchar(3) NOT NULL DEFAULT 'USD',
  `billing_cycle` enum('monthly','yearly','one_time') NOT NULL DEFAULT 'monthly',
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`features`)),
  `display_features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`display_features`)),
  `description` text DEFAULT NULL,
  `max_social_accounts` int(11) DEFAULT NULL,
  `max_team_members` int(11) DEFAULT NULL,
  `max_scheduled_posts` int(11) DEFAULT NULL,
  `ai_tokens_per_month` int(11) NOT NULL DEFAULT 0,
  `ai_auto_comment_reply` tinyint(1) NOT NULL DEFAULT 0,
  `ai_auto_dm_reply` tinyint(1) NOT NULL DEFAULT 0,
  `ai_semantic_analysis` tinyint(1) NOT NULL DEFAULT 0,
  `ai_driven_reporting` tinyint(1) NOT NULL DEFAULT 0,
  `ai_content_generator` tinyint(1) NOT NULL DEFAULT 0,
  `calendar_scheduling` tinyint(1) NOT NULL DEFAULT 0,
  `social_profile_score` tinyint(1) NOT NULL DEFAULT 0,
  `unified_inbox` tinyint(1) NOT NULL DEFAULT 0,
  `export_reports` tinyint(1) NOT NULL DEFAULT 0,
  `white_label` tinyint(1) NOT NULL DEFAULT 0,
  `fb_ads_analytics` tinyint(1) NOT NULL DEFAULT 0,
  `fb_ads_creation` tinyint(1) NOT NULL DEFAULT 0,
  `team_roles_permissions` tinyint(1) NOT NULL DEFAULT 0,
  `client_workspaces` tinyint(1) NOT NULL DEFAULT 0,
  `support_level` varchar(255) NOT NULL DEFAULT 'standard',
  `platform_limits` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`platform_limits`)),
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `trial_period_days` int(11) DEFAULT NULL,
  `trial_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `skip_trial_discount_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `skip_trial_discount_percent` int(11) NOT NULL DEFAULT 0,
  `is_contact_only` tinyint(1) NOT NULL DEFAULT 0,
  `show_on_landing` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `subscription_id` int(11) NOT NULL,
  `stripe_invoice_id` varchar(255) DEFAULT NULL,
  `stripe_payment_intent_id` varchar(255) DEFAULT NULL,
  `amount` int(11) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `status` varchar(50) NOT NULL,
  `user_uuid` varchar(255) DEFAULT NULL COMMENT 'User UUID reference',
  `plan_id` int(11) DEFAULT NULL COMMENT 'Local plan ID reference',
  `stripe_charge_id` varchar(255) DEFAULT NULL COMMENT 'Stripe charge ID',
  `stripe_subscription_id` varchar(255) DEFAULT NULL COMMENT 'Stripe subscription ID',
  `stripe_customer_id` varchar(255) DEFAULT NULL COMMENT 'Stripe customer ID',
  `stripe_payment_method_id` varchar(255) DEFAULT NULL COMMENT 'Payment method used',
  `invoice_number` varchar(100) DEFAULT NULL COMMENT 'Stripe invoice number',
  `invoice_pdf_url` varchar(500) DEFAULT NULL COMMENT 'URL to invoice PDF',
  `invoice_hosted_url` varchar(500) DEFAULT NULL COMMENT 'Hosted invoice URL',
  `billing_reason` enum('subscription_create','subscription_cycle','subscription_update','subscription_threshold','manual','upcoming') DEFAULT NULL COMMENT 'Reason for billing',
  `amount_subtotal` int(11) DEFAULT NULL COMMENT 'Subtotal amount in cents',
  `amount_tax` int(11) DEFAULT 0 COMMENT 'Tax amount in cents',
  `amount_total` int(11) DEFAULT NULL COMMENT 'Total amount in cents',
  `amount_paid` int(11) DEFAULT NULL COMMENT 'Amount actually paid in cents',
  `amount_due` int(11) DEFAULT NULL COMMENT 'Amount due in cents',
  `amount_remaining` int(11) DEFAULT 0 COMMENT 'Remaining unpaid amount',
  `discount_amount` int(11) DEFAULT 0 COMMENT 'Discount amount in cents',
  `coupon_code` varchar(100) DEFAULT NULL COMMENT 'Applied coupon code',
  `tax_rates` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Applied tax rates' CHECK (json_valid(`tax_rates`)),
  `payment_status` enum('requires_payment_method','requires_confirmation','requires_action','processing','requires_capture','canceled','succeeded','failed') DEFAULT NULL COMMENT 'Payment intent status',
  `failure_code` varchar(100) DEFAULT NULL COMMENT 'Payment failure code',
  `failure_message` text DEFAULT NULL COMMENT 'Payment failure message',
  `failure_reason` varchar(255) DEFAULT NULL COMMENT 'Reason for failure',
  `attempt_count` int(11) DEFAULT 0 COMMENT 'Number of payment attempts',
  `next_payment_attempt` datetime DEFAULT NULL COMMENT 'Next scheduled payment attempt',
  `due_date` datetime DEFAULT NULL COMMENT 'Payment due date',
  `paid_at` datetime DEFAULT NULL COMMENT 'When payment was made',
  `period_start` datetime DEFAULT NULL COMMENT 'Billing period start',
  `period_end` datetime DEFAULT NULL COMMENT 'Billing period end',
  `refund_amount` int(11) DEFAULT 0 COMMENT 'Refunded amount in cents',
  `refunded_at` datetime DEFAULT NULL COMMENT 'When refund was issued',
  `refund_reason` varchar(255) DEFAULT NULL COMMENT 'Reason for refund',
  `stripe_refund_id` varchar(255) DEFAULT NULL COMMENT 'Stripe refund ID',
  `description` text DEFAULT NULL COMMENT 'Transaction description',
  `receipt_url` varchar(500) DEFAULT NULL COMMENT 'Receipt URL from Stripe',
  `card_brand` varchar(50) DEFAULT NULL COMMENT 'Card brand used',
  `card_last4` varchar(4) DEFAULT NULL COMMENT 'Last 4 digits of card',
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Additional metadata' CHECK (json_valid(`metadata`)),
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `firstName` varchar(200) NOT NULL,
  `lastName` varchar(200) NOT NULL,
  `email` varchar(250) NOT NULL,
  `bio` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `jobTitle` varchar(255) DEFAULT NULL,
  `userLocation` varchar(255) DEFAULT NULL,
  `userWebsite` varchar(255) DEFAULT NULL,
  `password` varchar(250) NOT NULL,
  `role` enum('Superadmin','Admin','User') DEFAULT 'User',
  `profileImage` varchar(255) DEFAULT NULL,
  `timeZone` varchar(255) DEFAULT NULL,
  `otp` varchar(100) DEFAULT NULL,
  `otpGeneratedAt` timestamp NULL DEFAULT NULL,
  `resetPasswordToken` varchar(255) DEFAULT NULL,
  `resetPasswordRequestTime` varchar(255) DEFAULT NULL,
  `onboardGoal` longtext DEFAULT '{}',
  `onboardRole` longtext DEFAULT '{}',
  `status` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '0 = Unverified, 1 = Verified, 2 = Deleted account',
  `onboard_status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0=''Incomplete'',1=''completed''',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `stripe_customer_id` varchar(255) DEFAULT NULL COMMENT 'Stripe customer ID for billing',
  `billing_name` varchar(255) DEFAULT NULL COMMENT 'Billing name (can differ from user name)',
  `billing_email` varchar(255) DEFAULT NULL COMMENT 'Billing email for invoices',
  `billing_phone` varchar(50) DEFAULT NULL COMMENT 'Billing phone number',
  `billing_address_line1` varchar(255) DEFAULT NULL COMMENT 'Billing address line 1',
  `billing_address_line2` varchar(255) DEFAULT NULL COMMENT 'Billing address line 2',
  `billing_city` varchar(100) DEFAULT NULL COMMENT 'Billing city',
  `billing_state` varchar(100) DEFAULT NULL COMMENT 'Billing state/province',
  `billing_postal_code` varchar(20) DEFAULT NULL COMMENT 'Billing postal/zip code',
  `billing_country` varchar(2) DEFAULT NULL COMMENT 'Billing country code',
  `tax_id` varchar(50) DEFAULT NULL COMMENT 'Tax ID (VAT, etc.)',
  `tax_id_type` varchar(20) DEFAULT NULL COMMENT 'Tax ID type',
  `default_payment_method_id` varchar(255) DEFAULT NULL COMMENT 'Default Stripe payment method ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_notifications`
--

CREATE TABLE `user_notifications` (
  `id` int(11) NOT NULL,
  `user_uuid` varchar(255) NOT NULL,
  `type` enum('alert','report','system','info') NOT NULL DEFAULT 'info',
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `icon` varchar(255) DEFAULT 'bell',
  `severity` enum('low','medium','high','critical') NOT NULL DEFAULT 'medium',
  `link` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_reports`
--

CREATE TABLE `user_reports` (
  `id` int(11) NOT NULL,
  `user_uuid` varchar(255) NOT NULL,
  `report_name` varchar(255) NOT NULL,
  `report_type` enum('weekly','monthly','campaign','competitor') NOT NULL DEFAULT 'weekly',
  `template_id` varchar(255) DEFAULT NULL,
  `metrics` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metrics`)),
  `date_range` varchar(255) DEFAULT '7',
  `file_path` varchar(255) DEFAULT NULL,
  `file_size` int(11) DEFAULT 0,
  `status` enum('pending','processing','ready','failed') NOT NULL DEFAULT 'pending',
  `is_favorite` tinyint(1) NOT NULL DEFAULT 0,
  `schedule_frequency` enum('none','weekly','monthly') NOT NULL DEFAULT 'none',
  `schedule_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `schedule_day` int(11) DEFAULT NULL,
  `schedule_time` varchar(255) DEFAULT NULL,
  `last_generated_at` datetime DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `report_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`report_data`)),
  `insights` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`insights`)),
  `comparison_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`comparison_data`)),
  `user_logo_path` varchar(255) DEFAULT NULL,
  `email_delivery_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `email_recipients` text DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `webhooks`
--

CREATE TABLE `webhooks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `provider` enum('stripe','facebook','linkedin','n8n','custom') NOT NULL DEFAULT 'custom',
  `event_type` varchar(255) NOT NULL,
  `endpoint_url` varchar(255) NOT NULL,
  `secret` text DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `last_triggered_at` timestamp NULL DEFAULT NULL,
  `last_status` enum('success','failed','pending') DEFAULT NULL,
  `last_response` text DEFAULT NULL,
  `success_count` int(11) NOT NULL DEFAULT 0,
  `failure_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `webhook_events`
--

CREATE TABLE `webhook_events` (
  `id` int(11) NOT NULL,
  `stripe_event_id` varchar(255) NOT NULL COMMENT 'Stripe event ID (for idempotency)',
  `event_type` varchar(100) NOT NULL COMMENT 'Stripe event type (e.g., customer.subscription.created)',
  `api_version` varchar(20) DEFAULT NULL COMMENT 'Stripe API version',
  `livemode` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Whether this is a live mode event',
  `object_type` varchar(50) DEFAULT NULL COMMENT 'Type of object (subscription, invoice, etc.)',
  `object_id` varchar(255) DEFAULT NULL COMMENT 'Stripe object ID',
  `customer_id` varchar(255) DEFAULT NULL COMMENT 'Stripe customer ID if applicable',
  `subscription_id` varchar(255) DEFAULT NULL COMMENT 'Stripe subscription ID if applicable',
  `invoice_id` varchar(255) DEFAULT NULL COMMENT 'Stripe invoice ID if applicable',
  `payment_intent_id` varchar(255) DEFAULT NULL COMMENT 'Stripe payment intent ID if applicable',
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT 'Full event payload from Stripe' CHECK (json_valid(`payload`)),
  `payload_hash` varchar(64) DEFAULT NULL COMMENT 'SHA-256 hash of payload for verification',
  `status` enum('received','processing','processed','failed','skipped','retrying') NOT NULL DEFAULT 'received' COMMENT 'Processing status',
  `processing_attempts` int(11) NOT NULL DEFAULT 0 COMMENT 'Number of processing attempts',
  `max_attempts` int(11) NOT NULL DEFAULT 5 COMMENT 'Maximum processing attempts',
  `received_at` datetime NOT NULL COMMENT 'When webhook was received',
  `processed_at` datetime DEFAULT NULL COMMENT 'When webhook was processed',
  `next_retry_at` datetime DEFAULT NULL COMMENT 'When to retry processing',
  `error_code` varchar(100) DEFAULT NULL COMMENT 'Error code if failed',
  `error_message` text DEFAULT NULL COMMENT 'Error message if failed',
  `error_stack` text DEFAULT NULL COMMENT 'Error stack trace',
  `processing_time_ms` int(11) DEFAULT NULL COMMENT 'Time taken to process in milliseconds',
  `actions_taken` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'List of actions taken during processing' CHECK (json_valid(`actions_taken`)),
  `affected_records` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Records affected by this webhook' CHECK (json_valid(`affected_records`)),
  `ip_address` varchar(45) DEFAULT NULL COMMENT 'Source IP address',
  `signature_verified` tinyint(1) DEFAULT NULL COMMENT 'Whether Stripe signature was verified',
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Additional metadata' CHECK (json_valid(`metadata`)),
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `webhook_logs`
--

CREATE TABLE `webhook_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `webhook_id` bigint(20) UNSIGNED NOT NULL,
  `event_type` varchar(255) NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payload`)),
  `response_code` int(11) DEFAULT NULL,
  `response_body` text DEFAULT NULL,
  `status` enum('success','failed','pending') NOT NULL DEFAULT 'pending',
  `error_message` text DEFAULT NULL,
  `retry_count` int(11) NOT NULL DEFAULT 0,
  `executed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_alerts`
--
ALTER TABLE `admin_alerts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_audit_logs`
--
ALTER TABLE `admin_audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_audit_logs_admin_id_index` (`admin_id`),
  ADD KEY `admin_audit_logs_action_type_index` (`action_type`),
  ADD KEY `admin_audit_logs_entity_type_index` (`entity_type`),
  ADD KEY `admin_audit_logs_severity_index` (`severity`),
  ADD KEY `admin_audit_logs_created_at_index` (`created_at`),
  ADD KEY `admin_audit_logs_ip_address_index` (`ip_address`),
  ADD KEY `admin_audit_logs_session_id_index` (`session_id`);

--
-- Indexes for table `admin_feature_flags`
--
ALTER TABLE `admin_feature_flags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_feature_flags_feature_key_unique` (`feature_key`);

--
-- Indexes for table `admin_sessions`
--
ALTER TABLE `admin_sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_sessions_session_token_unique` (`session_token`),
  ADD KEY `admin_sessions_admin_id_index` (`admin_id`),
  ADD KEY `admin_sessions_session_token_index` (`session_token`),
  ADD KEY `admin_sessions_status_index` (`status`),
  ADD KEY `admin_sessions_last_activity_at_index` (`last_activity_at`),
  ADD KEY `admin_sessions_ip_address_index` (`ip_address`);

--
-- Indexes for table `admin_settings`
--
ALTER TABLE `admin_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_settings_key_unique` (`key`),
  ADD KEY `admin_settings_group_section_index` (`group`,`section`);

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_users_email_unique` (`email`);

--
-- Indexes for table `admin_user_role`
--
ALTER TABLE `admin_user_role`
  ADD PRIMARY KEY (`admin_user_id`,`role_id`),
  ADD KEY `admin_user_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `adsets`
--
ALTER TABLE `adsets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adsets_ads`
--
ALTER TABLE `adsets_ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ads_accounts`
--
ALTER TABLE `ads_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ads_creative`
--
ALTER TABLE `ads_creative`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `alert_thresholds`
--
ALTER TABLE `alert_thresholds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `analytics`
--
ALTER TABLE `analytics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `billing_activity_logs`
--
ALTER TABLE `billing_activity_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `billing_notifications`
--
ALTER TABLE `billing_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compliance_policies`
--
ALTER TABLE `compliance_policies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `compliance_policies_policy_type_unique` (`policy_type`);

--
-- Indexes for table `data_requests`
--
ALTER TABLE `data_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_retention_rules`
--
ALTER TABLE `data_retention_rules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `demographics`
--
ALTER TABLE `demographics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inbox_conversations`
--
ALTER TABLE `inbox_conversations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inbox_messages`
--
ALTER TABLE `inbox_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `knowledgebase_meta`
--
ALTER TABLE `knowledgebase_meta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `knowledge_base`
--
ALTER TABLE `knowledge_base`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_settings`
--
ALTER TABLE `notification_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `notification_type` (`notification_type`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stripe_payment_method_id` (`stripe_payment_method_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `page_id` (`page_id`),
  ADD KEY `social_user_id` (`social_user_id`);

--
-- Indexes for table `post_comments`
--
ALTER TABLE `post_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `role_permission`
--
ALTER TABLE `role_permission`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `role_permission_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `saved_reports`
--
ALTER TABLE `saved_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_media_page_score`
--
ALTER TABLE `social_media_page_score`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_media_score`
--
ALTER TABLE `social_media_score`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_page`
--
ALTER TABLE `social_page`
  ADD PRIMARY KEY (`id`),
  ADD KEY `social_userid` (`social_userid`),
  ADD KEY `pageId` (`pageId`);

--
-- Indexes for table `social_users`
--
ALTER TABLE `social_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `social_id` (`social_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscriptions_user_uuid` (`user_uuid`),
  ADD KEY `subscriptions_stripe_subscription_id` (`stripe_subscription_id`);

--
-- Indexes for table `subscription_events`
--
ALTER TABLE `subscription_events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stripe_event_id` (`stripe_event_id`);

--
-- Indexes for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscription_plans_slug_unique` (`slug`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `uuid` (`uuid`);

--
-- Indexes for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_reports`
--
ALTER TABLE `user_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `webhooks`
--
ALTER TABLE `webhooks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `webhook_events`
--
ALTER TABLE `webhook_events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stripe_event_id` (`stripe_event_id`);

--
-- Indexes for table `webhook_logs`
--
ALTER TABLE `webhook_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `webhook_logs_webhook_id_foreign` (`webhook_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_alerts`
--
ALTER TABLE `admin_alerts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_audit_logs`
--
ALTER TABLE `admin_audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_feature_flags`
--
ALTER TABLE `admin_feature_flags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_sessions`
--
ALTER TABLE `admin_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_settings`
--
ALTER TABLE `admin_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `adsets`
--
ALTER TABLE `adsets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `adsets_ads`
--
ALTER TABLE `adsets_ads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ads_accounts`
--
ALTER TABLE `ads_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ads_creative`
--
ALTER TABLE `ads_creative`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `alert_thresholds`
--
ALTER TABLE `alert_thresholds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `analytics`
--
ALTER TABLE `analytics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `billing_activity_logs`
--
ALTER TABLE `billing_activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `billing_notifications`
--
ALTER TABLE `billing_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `compliance_policies`
--
ALTER TABLE `compliance_policies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_requests`
--
ALTER TABLE `data_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_retention_rules`
--
ALTER TABLE `data_retention_rules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `demographics`
--
ALTER TABLE `demographics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inbox_conversations`
--
ALTER TABLE `inbox_conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inbox_messages`
--
ALTER TABLE `inbox_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `knowledgebase_meta`
--
ALTER TABLE `knowledgebase_meta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `knowledge_base`
--
ALTER TABLE `knowledge_base`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_settings`
--
ALTER TABLE `notification_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_comments`
--
ALTER TABLE `post_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `saved_reports`
--
ALTER TABLE `saved_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `social_media_page_score`
--
ALTER TABLE `social_media_page_score`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `social_media_score`
--
ALTER TABLE `social_media_score`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `social_page`
--
ALTER TABLE `social_page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `social_users`
--
ALTER TABLE `social_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscription_events`
--
ALTER TABLE `subscription_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_notifications`
--
ALTER TABLE `user_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_reports`
--
ALTER TABLE `user_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `webhooks`
--
ALTER TABLE `webhooks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `webhook_events`
--
ALTER TABLE `webhook_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `webhook_logs`
--
ALTER TABLE `webhook_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_user_role`
--
ALTER TABLE `admin_user_role`
  ADD CONSTRAINT `admin_user_role_admin_user_id_foreign` FOREIGN KEY (`admin_user_id`) REFERENCES `admin_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `admin_user_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_permission`
--
ALTER TABLE `role_permission`
  ADD CONSTRAINT `role_permission_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permission_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `social_media_page_score`
--
ALTER TABLE `social_media_page_score`
  ADD CONSTRAINT `social_media_page_score_ibfk_1` FOREIGN KEY (`social_score_id`) REFERENCES `social_media_score` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `webhook_logs`
--
ALTER TABLE `webhook_logs`
  ADD CONSTRAINT `webhook_logs_webhook_id_foreign` FOREIGN KEY (`webhook_id`) REFERENCES `webhooks` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
