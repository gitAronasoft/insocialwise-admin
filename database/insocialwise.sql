-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 09, 2025 at 12:10 PM
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
-- Table structure for table `billing_activity_logs`
--

CREATE TABLE `billing_activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_uuid` varchar(255) DEFAULT NULL COMMENT 'User UUID reference',
  `subscription_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'Related subscription ID',
  `transaction_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'Related transaction ID',
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
  `stripe_object_id` varchar(255) DEFAULT NULL COMMENT 'Related Stripe object ID',
  `error_code` varchar(100) DEFAULT NULL COMMENT 'Error code if failed',
  `error_message` text DEFAULT NULL COMMENT 'Error message if failed',
  `description` text DEFAULT NULL COMMENT 'Human-readable description',
  `notes` text DEFAULT NULL COMMENT 'Admin notes',
  `ip_address` varchar(45) DEFAULT NULL COMMENT 'IP address of the request',
  `user_agent` text DEFAULT NULL COMMENT 'User agent string',
  `request_id` varchar(255) DEFAULT NULL COMMENT 'Request ID for tracing',
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Additional metadata' CHECK (json_valid(`metadata`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `billing_notifications`
--

CREATE TABLE `billing_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_uuid` varchar(255) NOT NULL COMMENT 'User UUID reference',
  `subscription_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'Related subscription ID',
  `transaction_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'Related transaction ID',
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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '2025_11_27_180000_create_admin_users_table', 1),
(2, '2025_11_27_180001_create_sessions_table', 1),
(3, '2025_11_27_180002_create_admin_settings_table', 1),
(4, '2025_11_28_100001_create_permissions_table', 1),
(5, '2025_11_28_100002_create_roles_table', 1),
(6, '2025_11_28_100003_create_role_permission_table', 1),
(7, '2025_11_28_100004_create_admin_user_role_table', 1),
(8, '2025_11_28_100005_alter_permissions_and_roles_tables', 1),
(9, '2025_11_28_153004_add_status_to_admin_users_table', 1),
(10, '2025_11_29_100001_create_admin_feature_flags_table', 1),
(11, '2025_11_29_100002_create_admin_alerts_table', 1),
(12, '2025_11_29_100003_create_subscription_plans_table', 1),
(13, '2025_11_29_100004_create_webhooks_table', 1),
(14, '2025_11_29_100005_create_compliance_tables', 1),
(15, '2025_11_30_100001_add_platform_to_social_page_table', 1),
(16, '2025_11_30_100003_add_access_token_expiry_to_social_users', 1),
(17, '2025_11_30_100004_add_score_columns_to_score_tables', 1),
(18, '2025_12_03_100001_enhance_subscription_plans_table', 1),
(19, '2025_12_03_122457_simplify_subscription_plans_table', 1),
(20, '2025_12_03_130443_add_plan_limits_and_yearly_pricing_to_subscription_plans_table', 1),
(21, '2025_12_04_120103_enhance_subscription_plans_with_features', 1),
(22, '2025_12_04_125109_convert_plan_features_to_boolean', 1),
(23, '2025_12_06_200001_create_billing_notifications_table', 1),
(24, '2025_12_06_200002_create_billing_activity_logs_table', 1),
(25, '2025_12_06_200003_create_payment_methods_table', 1),
(26, '2025_12_06_200004_add_encrypted_type_to_admin_settings', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_uuid` varchar(255) NOT NULL COMMENT 'User UUID reference',
  `stripe_payment_method_id` varchar(255) NOT NULL COMMENT 'Stripe payment method ID',
  `stripe_customer_id` varchar(255) NOT NULL COMMENT 'Stripe customer ID',
  `type` enum('card','bank_account','sepa_debit','paypal','other') NOT NULL DEFAULT 'card' COMMENT 'Payment method type',
  `card_brand` varchar(50) DEFAULT NULL COMMENT 'Card brand (visa, mastercard, etc.)',
  `card_last4` varchar(4) DEFAULT NULL COMMENT 'Last 4 digits of card',
  `card_exp_month` int(11) DEFAULT NULL COMMENT 'Card expiry month',
  `card_exp_year` int(11) DEFAULT NULL COMMENT 'Card expiry year',
  `card_funding` varchar(20) DEFAULT NULL COMMENT 'Card funding type (credit, debit, prepaid)',
  `card_country` varchar(2) DEFAULT NULL COMMENT 'Card country code',
  `billing_name` varchar(255) DEFAULT NULL COMMENT 'Billing name on payment method',
  `billing_email` varchar(255) DEFAULT NULL COMMENT 'Billing email',
  `billing_phone` varchar(50) DEFAULT NULL COMMENT 'Billing phone',
  `billing_address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Billing address' CHECK (json_valid(`billing_address`)),
  `is_default` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Is this the default payment method',
  `status` enum('active','expired','failed','removed') NOT NULL DEFAULT 'active' COMMENT 'Payment method status',
  `expires_at` datetime DEFAULT NULL COMMENT 'When the payment method expires',
  `last_used_at` datetime DEFAULT NULL COMMENT 'When last used for payment',
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Additional metadata' CHECK (json_valid(`metadata`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `group` varchar(255) NOT NULL,
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
  `display_name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_super_admin` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
-- Indexes for table `admin_alerts`
--
ALTER TABLE `admin_alerts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_feature_flags`
--
ALTER TABLE `admin_feature_flags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_feature_flags_feature_key_unique` (`feature_key`);

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
-- Indexes for table `billing_activity_logs`
--
ALTER TABLE `billing_activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `billing_activity_logs_user_uuid_index` (`user_uuid`),
  ADD KEY `billing_activity_logs_subscription_id_index` (`subscription_id`),
  ADD KEY `billing_activity_logs_transaction_id_index` (`transaction_id`),
  ADD KEY `billing_activity_logs_action_type_index` (`action_type`),
  ADD KEY `billing_activity_logs_action_status_index` (`action_status`),
  ADD KEY `billing_activity_logs_created_at_index` (`created_at`);

--
-- Indexes for table `billing_notifications`
--
ALTER TABLE `billing_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `billing_notifications_user_uuid_index` (`user_uuid`),
  ADD KEY `billing_notifications_subscription_id_index` (`subscription_id`),
  ADD KEY `billing_notifications_status_index` (`status`),
  ADD KEY `billing_notifications_scheduled_at_index` (`scheduled_at`),
  ADD KEY `billing_notifications_status_scheduled_at_index` (`status`,`scheduled_at`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_methods_stripe_payment_method_id_unique` (`stripe_payment_method_id`),
  ADD KEY `payment_methods_user_uuid_index` (`user_uuid`),
  ADD KEY `payment_methods_stripe_customer_id_index` (`stripe_customer_id`),
  ADD KEY `payment_methods_is_default_index` (`is_default`),
  ADD KEY `payment_methods_status_index` (`status`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_permission`
--
ALTER TABLE `role_permission`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `role_permission_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscription_plans_slug_unique` (`slug`);

--
-- Indexes for table `webhooks`
--
ALTER TABLE `webhooks`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `admin_alerts`
--
ALTER TABLE `admin_alerts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_feature_flags`
--
ALTER TABLE `admin_feature_flags`
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
-- AUTO_INCREMENT for table `billing_activity_logs`
--
ALTER TABLE `billing_activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `billing_notifications`
--
ALTER TABLE `billing_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `webhooks`
--
ALTER TABLE `webhooks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
-- Constraints for table `role_permission`
--
ALTER TABLE `role_permission`
  ADD CONSTRAINT `role_permission_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permission_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `webhook_logs`
--
ALTER TABLE `webhook_logs`
  ADD CONSTRAINT `webhook_logs_webhook_id_foreign` FOREIGN KEY (`webhook_id`) REFERENCES `webhooks` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
