-- Adminer 5.4.1 PostgreSQL 16.11 dump

DROP TABLE IF EXISTS "activity";
DROP SEQUENCE IF EXISTS activity_id_seq;
CREATE SEQUENCE activity_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."activity" (
    "id" bigint DEFAULT nextval('activity_id_seq') NOT NULL,
    "user_uuid" character varying(255),
    "account_social_userid" character varying(255),
    "account_platform" character varying(255),
    "activity_type" character varying(255),
    "activity_subtype" character varying(255),
    "action" character varying(255),
    "source_type" character varying(255),
    "post_form_id" character varying(255),
    "reference_pageid" text,
    "activity_datetime" timestamp NOT NULL,
    "nextapi_call_datetime" timestamp,
    "createdat" timestamp NOT NULL,
    "updatedat" timestamp NOT NULL,
    CONSTRAINT "idx_16857_primary" PRIMARY KEY ("id")
)
WITH (oids = false);


DROP TABLE IF EXISTS "admin_alerts";
DROP SEQUENCE IF EXISTS admin_alerts_id_seq;
CREATE SEQUENCE admin_alerts_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."admin_alerts" (
    "id" bigint DEFAULT nextval('admin_alerts_id_seq') NOT NULL,
    "type" text DEFAULT 'general' NOT NULL,
    "severity" text DEFAULT 'info' NOT NULL,
    "title" character varying(255) NOT NULL,
    "message" text NOT NULL,
    "metadata" text,
    "read" smallint DEFAULT '0' NOT NULL,
    "read_at" timestamptz,
    "read_by" numeric,
    "created_at" timestamptz,
    "updated_at" timestamptz,
    CONSTRAINT "idx_16872_primary" PRIMARY KEY ("id")
)
WITH (oids = false);


DROP TABLE IF EXISTS "admin_audit_logs";
DROP SEQUENCE IF EXISTS admin_audit_logs_id_seq;
CREATE SEQUENCE admin_audit_logs_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."admin_audit_logs" (
    "id" bigint DEFAULT nextval('admin_audit_logs_id_seq') NOT NULL,
    "admin_id" numeric,
    "admin_email" character varying(255),
    "admin_name" character varying(255),
    "action_type" text NOT NULL,
    "entity_type" character varying(255),
    "entity_id" character varying(255),
    "description" text NOT NULL,
    "old_values" text,
    "new_values" text,
    "metadata" text,
    "ip_address" character varying(45),
    "user_agent" text,
    "request_method" character varying(10),
    "request_url" text,
    "session_id" character varying(255),
    "severity" text DEFAULT 'info' NOT NULL,
    "created_at" timestamptz,
    "updated_at" timestamptz,
    CONSTRAINT "idx_16882_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

COMMENT ON COLUMN "insocial_mysql"."admin_audit_logs"."entity_type" IS 'Model or entity affected';

COMMENT ON COLUMN "insocial_mysql"."admin_audit_logs"."entity_id" IS 'ID of the affected entity';

CREATE INDEX idx_16882_admin_audit_logs_created_at_index ON insocial_mysql.admin_audit_logs USING btree (created_at);

CREATE INDEX idx_16882_admin_audit_logs_admin_id_index ON insocial_mysql.admin_audit_logs USING btree (admin_id);

CREATE INDEX idx_16882_admin_audit_logs_entity_type_index ON insocial_mysql.admin_audit_logs USING btree (entity_type);

CREATE INDEX idx_16882_admin_audit_logs_action_type_index ON insocial_mysql.admin_audit_logs USING btree (action_type);

CREATE INDEX idx_16882_admin_audit_logs_severity_index ON insocial_mysql.admin_audit_logs USING btree (severity);

CREATE INDEX idx_16882_admin_audit_logs_session_id_index ON insocial_mysql.admin_audit_logs USING btree (session_id);

CREATE INDEX idx_16882_admin_audit_logs_ip_address_index ON insocial_mysql.admin_audit_logs USING btree (ip_address);

INSERT INTO "admin_audit_logs" ("id", "admin_id", "admin_email", "admin_name", "action_type", "entity_type", "entity_id", "description", "old_values", "new_values", "metadata", "ip_address", "user_agent", "request_method", "request_url", "session_id", "severity", "created_at", "updated_at") VALUES
(1,	2,	'admin@insocialwise.com',	'Super Admin',	'login',	NULL,	NULL,	'Admin admin@insocialwise.com logged in successfully',	NULL,	NULL,	NULL,	'223.178.209.173',	'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',	'POST',	'http://51318579-bfb0-4529-a363-9c24952c0e0f-00-3s0sp1pby59o7.janeway.replit.dev/login',	'hMyYx2A9NGtHzwDksNOKUBYiPM8qGkcNRmzFr0UT',	'info',	'2025-12-08 18:57:01+00',	'2025-12-08 18:57:01+00'),
(2,	2,	'admin@insocialwise.com',	'Super Admin',	'login',	NULL,	NULL,	'Admin admin@insocialwise.com logged in successfully',	NULL,	NULL,	NULL,	'223.178.209.173',	'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',	'POST',	'http://51318579-bfb0-4529-a363-9c24952c0e0f-00-3s0sp1pby59o7.janeway.replit.dev/login',	'23WXOlgx0KOBdi2hxNIfm25g4293Z76Nga1rSGEV',	'info',	'2025-12-08 19:23:36+00',	'2025-12-08 19:23:36+00'),
(3,	2,	'admin@insocialwise.com',	'Super Admin',	'login',	NULL,	NULL,	'Admin admin@insocialwise.com logged in successfully',	NULL,	NULL,	NULL,	'223.178.209.173',	'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',	'POST',	'http://e68ecbfd-45c7-405f-a8d7-f90613203486-00-1ltd1dxhtu2g5.sisko.replit.dev/login',	'ck9l4XCU6HuV8YYG76cMkTxUCyGtVn7MkfPbX8Hs',	'info',	'2025-12-08 20:20:25+00',	'2025-12-08 20:20:25+00'),
(4,	2,	'admin@insocialwise.com',	'Super Admin',	'login',	NULL,	NULL,	'Admin admin@insocialwise.com logged in successfully',	NULL,	NULL,	NULL,	'223.178.209.173',	'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',	'POST',	'http://e68ecbfd-45c7-405f-a8d7-f90613203486-00-1ltd1dxhtu2g5.sisko.replit.dev/login',	'TyfWCjm2GsC3n2mcmGDMTqNoZXVoYtHq2KVjP8bs',	'info',	'2025-12-08 20:20:46+00',	'2025-12-08 20:20:46+00'),
(5,	2,	'admin@insocialwise.com',	'Super Admin',	'login',	NULL,	NULL,	'Admin admin@insocialwise.com logged in successfully',	NULL,	NULL,	NULL,	'223.178.209.173',	'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',	'POST',	'http://e68ecbfd-45c7-405f-a8d7-f90613203486-00-1ltd1dxhtu2g5.sisko.replit.dev/login',	'2Vzz0rEt01A0fupOy7rs6ouAa5FJwvyiFHGTyNmG',	'info',	'2025-12-08 20:24:30+00',	'2025-12-08 20:24:30+00'),
(6,	2,	'admin@insocialwise.com',	'Super Admin',	'login',	NULL,	NULL,	'Admin admin@insocialwise.com logged in successfully',	NULL,	NULL,	NULL,	'223.178.209.173',	'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',	'POST',	'http://d5af018e-7df7-480b-b9e1-538dd76bccc4-00-uuh5yqfznlnw.riker.replit.dev/login',	'X7hANt0qo7n5VPMscJ8AgXfNS5vScJdOX4X3LopN',	'info',	'2025-12-08 20:54:14+00',	'2025-12-08 20:54:14+00'),
(7,	2,	'admin@insocialwise.com',	'Super Admin',	'login',	NULL,	NULL,	'Admin admin@insocialwise.com logged in successfully',	NULL,	NULL,	NULL,	'223.181.17.52',	'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',	'POST',	'http://6349261f-0ac7-43a4-846c-0cb0d3e56aa0-00-10s3cqsfa7tal.worf.replit.dev/login',	'Gt5zOTHjJNcJxI3Y1L3SBt75XyFIfEZ1DLTAEqlu',	'info',	'2025-12-09 06:51:22+00',	'2025-12-09 06:51:22+00');

DROP TABLE IF EXISTS "admin_feature_flags";
DROP SEQUENCE IF EXISTS admin_feature_flags_id_seq;
CREATE SEQUENCE admin_feature_flags_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."admin_feature_flags" (
    "id" bigint DEFAULT nextval('admin_feature_flags_id_seq') NOT NULL,
    "feature_key" character varying(255) NOT NULL,
    "feature_name" character varying(255) NOT NULL,
    "description" text,
    "category" text DEFAULT 'core' NOT NULL,
    "enabled" smallint DEFAULT '0' NOT NULL,
    "force_enabled" smallint DEFAULT '0' NOT NULL,
    "updated_by" numeric,
    "created_at" timestamptz,
    "updated_at" timestamptz,
    CONSTRAINT "idx_16897_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE UNIQUE INDEX idx_16897_admin_feature_flags_feature_key_unique ON insocial_mysql.admin_feature_flags USING btree (feature_key);

INSERT INTO "admin_feature_flags" ("id", "feature_key", "feature_name", "description", "category", "enabled", "force_enabled", "updated_by", "created_at", "updated_at") VALUES
(1,	'posts_management',	'Posts Management',	'Enable/disable posts management feature',	'core',	1,	0,	NULL,	'2025-11-29 10:05:37+00',	'2025-11-29 10:05:37+00'),
(2,	'analytics_insights',	'Analytics & Insights',	'Enable/disable analytics dashboard',	'core',	1,	0,	NULL,	'2025-11-29 10:05:37+00',	'2025-11-29 10:05:37+00'),
(3,	'inbox_messaging',	'Inbox & Messaging',	'Enable/disable inbox messaging feature',	'core',	1,	0,	NULL,	'2025-11-29 10:05:37+00',	'2025-11-29 10:05:37+00'),
(4,	'advertising_campaigns',	'Advertising Campaigns',	'Enable/disable ad campaigns feature',	'core',	1,	0,	NULL,	'2025-11-29 10:05:37+00',	'2025-11-29 10:05:37+00'),
(5,	'comment_management',	'Comment Management',	'Enable/disable comment management',	'core',	1,	0,	NULL,	'2025-11-29 10:05:37+00',	'2025-11-29 10:05:37+00'),
(6,	'user_management',	'User Management',	'User management (cannot be disabled)',	'admin',	1,	1,	NULL,	'2025-11-29 10:05:38+00',	'2025-11-29 10:05:38+00'),
(7,	'subscription_management',	'Subscription Management',	'Enable/disable subscription management',	'admin',	1,	0,	NULL,	'2025-11-29 10:05:38+00',	'2025-11-29 10:05:38+00'),
(8,	'system_settings',	'System Settings',	'System settings (cannot be disabled)',	'admin',	1,	1,	NULL,	'2025-11-29 10:05:38+00',	'2025-11-29 10:05:38+00'),
(9,	'activity_logging',	'Activity Logging',	'Enable/disable activity logging',	'admin',	1,	0,	NULL,	'2025-11-29 10:05:38+00',	'2025-11-29 10:05:38+00'),
(10,	'user_impersonation',	'User Impersonation',	'Allow admins to login as users',	'admin',	0,	0,	NULL,	'2025-11-29 10:05:38+00',	'2025-11-29 10:05:38+00'),
(11,	'two_factor_auth',	'Two-Factor Authentication',	'Enable 2FA for admin accounts',	'security',	1,	0,	NULL,	'2025-11-29 10:05:38+00',	'2025-11-29 10:05:38+00'),
(12,	'ip_whitelisting',	'IP Whitelisting',	'Restrict admin access by IP',	'security',	0,	0,	NULL,	'2025-11-29 10:05:38+00',	'2025-11-29 10:05:38+00'),
(13,	'session_management',	'Session Management',	'View and manage admin sessions',	'security',	1,	0,	NULL,	'2025-11-29 10:05:39+00',	'2025-11-29 10:05:39+00'),
(14,	'audit_logging',	'Audit Logging',	'Log all admin actions',	'security',	1,	0,	NULL,	'2025-11-29 10:05:39+00',	'2025-11-29 10:05:39+00'),
(15,	'system_health_monitoring',	'System Health Monitoring',	'Monitor system health metrics',	'monitoring',	1,	0,	NULL,	'2025-11-29 10:05:39+00',	'2025-11-29 10:05:39+00'),
(16,	'error_tracking',	'Error Tracking',	'Track and log application errors',	'monitoring',	1,	0,	NULL,	'2025-11-29 10:05:39+00',	'2025-11-29 10:05:39+00'),
(17,	'alert_notifications',	'Alert Notifications',	'Enable alert notifications',	'monitoring',	1,	0,	NULL,	'2025-11-29 10:05:39+00',	'2025-11-29 10:05:39+00'),
(18,	'performance_monitoring',	'Performance Monitoring',	'Monitor performance metrics',	'monitoring',	0,	0,	NULL,	'2025-11-29 10:05:39+00',	'2025-11-29 10:05:39+00'),
(19,	'bulk_export',	'Bulk Export',	'Enable bulk data export',	'data',	1,	0,	NULL,	'2025-11-29 10:05:40+00',	'2025-11-29 10:05:40+00'),
(20,	'scheduled_exports',	'Scheduled Exports',	'Enable scheduled report exports',	'data',	0,	0,	NULL,	'2025-11-29 10:05:40+00',	'2025-11-29 10:05:40+00'),
(21,	'report_generation',	'Report Generation',	'Enable custom report generation',	'data',	1,	0,	NULL,	'2025-11-29 10:05:40+00',	'2025-11-29 10:05:40+00'),
(22,	'analytics_export',	'Analytics Export',	'Enable analytics data export',	'data',	1,	0,	NULL,	'2025-11-29 10:05:40+00',	'2025-11-29 10:05:40+00');

DROP TABLE IF EXISTS "admin_sessions";
DROP SEQUENCE IF EXISTS admin_sessions_id_seq;
CREATE SEQUENCE admin_sessions_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."admin_sessions" (
    "id" bigint DEFAULT nextval('admin_sessions_id_seq') NOT NULL,
    "admin_id" numeric NOT NULL,
    "session_token" character varying(255) NOT NULL,
    "ip_address" character varying(45) NOT NULL,
    "user_agent" text,
    "device_type" character varying(50),
    "browser" character varying(100),
    "os" character varying(100),
    "location" character varying(255),
    "is_current" smallint DEFAULT '0' NOT NULL,
    "last_activity_at" timestamptz,
    "logged_in_at" timestamptz NOT NULL,
    "logged_out_at" timestamptz,
    "status" text DEFAULT 'active' NOT NULL,
    "created_at" timestamptz,
    "updated_at" timestamptz,
    CONSTRAINT "idx_16907_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE INDEX idx_16907_admin_sessions_admin_id_index ON insocial_mysql.admin_sessions USING btree (admin_id);

CREATE INDEX idx_16907_admin_sessions_session_token_index ON insocial_mysql.admin_sessions USING btree (session_token);

CREATE INDEX idx_16907_admin_sessions_ip_address_index ON insocial_mysql.admin_sessions USING btree (ip_address);

CREATE INDEX idx_16907_admin_sessions_last_activity_at_index ON insocial_mysql.admin_sessions USING btree (last_activity_at);

CREATE UNIQUE INDEX idx_16907_admin_sessions_session_token_unique ON insocial_mysql.admin_sessions USING btree (session_token);

CREATE INDEX idx_16907_admin_sessions_status_index ON insocial_mysql.admin_sessions USING btree (status);

INSERT INTO "admin_sessions" ("id", "admin_id", "session_token", "ip_address", "user_agent", "device_type", "browser", "os", "location", "is_current", "last_activity_at", "logged_in_at", "logged_out_at", "status", "created_at", "updated_at") VALUES
(1,	2,	'23WXOlgx0KOBdi2hxNIfm25g4293Z76Nga1rSGEV',	'223.178.209.173',	'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',	'desktop',	'Chrome',	'Windows',	NULL,	0,	'2025-12-08 19:49:32+00',	'2025-12-08 19:23:36+00',	NULL,	'active',	'2025-12-08 19:23:36+00',	'2025-12-08 20:24:30+00'),
(2,	2,	'2Vzz0rEt01A0fupOy7rs6ouAa5FJwvyiFHGTyNmG',	'223.178.209.173',	'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',	'desktop',	'Chrome',	'Windows',	NULL,	0,	'2025-12-08 20:40:35+00',	'2025-12-08 20:24:31+00',	NULL,	'active',	'2025-12-08 20:24:31+00',	'2025-12-08 20:54:14+00'),
(3,	2,	'X7hANt0qo7n5VPMscJ8AgXfNS5vScJdOX4X3LopN',	'223.178.209.173',	'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',	'desktop',	'Chrome',	'Windows',	NULL,	0,	'2025-12-08 21:17:01+00',	'2025-12-08 20:54:14+00',	NULL,	'active',	'2025-12-08 20:54:14+00',	'2025-12-09 06:51:22+00'),
(4,	2,	'Gt5zOTHjJNcJxI3Y1L3SBt75XyFIfEZ1DLTAEqlu',	'223.181.17.52',	'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',	'desktop',	'Chrome',	'Windows',	NULL,	1,	'2025-12-09 07:01:24+00',	'2025-12-09 06:51:22+00',	NULL,	'active',	'2025-12-09 06:51:22+00',	'2025-12-09 07:01:24+00');

DROP TABLE IF EXISTS "admin_settings";
DROP SEQUENCE IF EXISTS admin_settings_id_seq;
CREATE SEQUENCE admin_settings_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."admin_settings" (
    "id" bigint DEFAULT nextval('admin_settings_id_seq') NOT NULL,
    "key" character varying(255) NOT NULL,
    "value" text,
    "type" text DEFAULT 'string' NOT NULL,
    "group" character varying(255) DEFAULT 'general' NOT NULL,
    "description" text,
    "section" character varying(255),
    "created_at" timestamptz,
    "updated_at" timestamptz,
    CONSTRAINT "idx_16920_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE INDEX idx_16920_admin_settings_group_section_index ON insocial_mysql.admin_settings USING btree ("group", section);

CREATE UNIQUE INDEX idx_16920_admin_settings_key_unique ON insocial_mysql.admin_settings USING btree (key);


DROP TABLE IF EXISTS "admin_user_role";
CREATE TABLE "insocial_mysql"."admin_user_role" (
    "admin_user_id" numeric NOT NULL,
    "role_id" numeric NOT NULL,
    CONSTRAINT "idx_16938_primary" PRIMARY KEY ("admin_user_id", "role_id")
)
WITH (oids = false);

CREATE INDEX idx_16938_admin_user_role_role_id_foreign ON insocial_mysql.admin_user_role USING btree (role_id);

INSERT INTO "admin_user_role" ("admin_user_id", "role_id") VALUES
(2,	1);

DROP TABLE IF EXISTS "admin_users";
DROP SEQUENCE IF EXISTS admin_users_id_seq;
CREATE SEQUENCE admin_users_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."admin_users" (
    "id" bigint DEFAULT nextval('admin_users_id_seq') NOT NULL,
    "name" character varying(255) NOT NULL,
    "email" character varying(255) NOT NULL,
    "email_verified_at" timestamptz,
    "password" character varying(255) NOT NULL,
    "is_active" smallint DEFAULT '1' NOT NULL,
    "remember_token" character varying(100),
    "created_at" timestamptz,
    "updated_at" timestamptz,
    CONSTRAINT "idx_16930_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE UNIQUE INDEX idx_16930_admin_users_email_unique ON insocial_mysql.admin_users USING btree (email);

INSERT INTO "admin_users" ("id", "name", "email", "email_verified_at", "password", "is_active", "remember_token", "created_at", "updated_at") VALUES
(2,	'Super Admin',	'admin@insocialwise.com',	'2025-11-27 17:57:13+00',	'$2y$12$XnYzvwZ3/a6.wIMyOaxaZuMIpLDo2goUlJwkmg1G3pHwDqhJGaJHe',	1,	NULL,	'2025-11-27 17:57:13+00',	'2025-11-27 17:57:13+00');

DROP TABLE IF EXISTS "ads_accounts";
DROP SEQUENCE IF EXISTS ads_accounts_id_seq;
CREATE SEQUENCE ads_accounts_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."ads_accounts" (
    "id" bigint DEFAULT nextval('ads_accounts_id_seq') NOT NULL,
    "user_uuid" character varying(255),
    "account_platform" character varying(255),
    "account_social_userid" character varying(255),
    "account_id" character varying(255),
    "account_name" character varying(255),
    "account_status" character varying(255),
    "isconnected" text DEFAULT 'notConnected' NOT NULL,
    "currency" character varying(250),
    "timezone_name" character varying(250),
    "timezone_offset_hours_utc" character varying(250),
    "amount_spent" bigint DEFAULT '0',
    "balance" bigint DEFAULT '0',
    "business_page_detail" text,
    "min_campaign_group_spend_cap" bigint DEFAULT '0',
    "spend_cap" bigint DEFAULT '0',
    "createdat" timestamptz DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "updatedat" timestamptz DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT "idx_16992_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

INSERT INTO "ads_accounts" ("id", "user_uuid", "account_platform", "account_social_userid", "account_id", "account_name", "account_status", "isconnected", "currency", "timezone_name", "timezone_offset_hours_utc", "amount_spent", "balance", "business_page_detail", "min_campaign_group_spend_cap", "spend_cap", "createdat", "updatedat") VALUES
(105,	'b4206492-1778-4860-8e24-af93296a37d4',	'facebook',	'122156535248577012',	'1076214387241135',	'Ross Singh',	'1',	'notConnected',	'INR',	'Asia/Kolkata',	'5.5',	0,	0,	NULL,	500000,	0,	'2025-12-04 12:50:24+00',	'2025-12-04 12:50:24+00');

DROP TABLE IF EXISTS "ads_creative";
DROP SEQUENCE IF EXISTS ads_creative_id_seq;
CREATE SEQUENCE ads_creative_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."ads_creative" (
    "id" bigint DEFAULT nextval('ads_creative_id_seq') NOT NULL,
    "user_uuid" character varying(255),
    "account_platform" character varying(255),
    "social_page_id" character varying(250),
    "account_social_userid" character varying(255),
    "campaign_id" character varying(255),
    "adset_id" character varying(255),
    "ad_id" character varying(255),
    "creative_id" character varying(255),
    "creative_type" character varying(255),
    "image_urls" text,
    "video_thumbnails" text,
    "headline" character varying(255),
    "body" text,
    "call_to_action" text,
    "call_to_action_link" character varying(255),
    "createdat" timestamp NOT NULL,
    "updatedat" timestamp NOT NULL,
    CONSTRAINT "idx_17015_primary" PRIMARY KEY ("id")
)
WITH (oids = false);


DROP TABLE IF EXISTS "adsets";
DROP SEQUENCE IF EXISTS adsets_id_seq;
CREATE SEQUENCE adsets_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."adsets" (
    "id" bigint DEFAULT nextval('adsets_id_seq') NOT NULL,
    "user_uuid" character varying(255),
    "account_platform" character varying(255),
    "account_social_userid" character varying(255),
    "adsets_campaign_id" bigint,
    "adsets_id" bigint,
    "adsets_name" character varying(255),
    "adsets_countries" text,
    "adsets_regions" text,
    "adsets_cities" text,
    "adsets_age_min" bigint,
    "adsets_age_max" bigint,
    "adsets_genders" text,
    "adsets_publisher_platforms" text,
    "adsets_facebook_positions" text,
    "adsets_instagram_positions" text,
    "adsets_device_platforms" text,
    "adsets_start_time" timestamp,
    "adsets_end_time" timestamp,
    "adsets_status" character varying(255),
    "adsets_insights_impressions" character varying(255),
    "adsets_insights_clicks" character varying(255),
    "adsets_insights_cpc" character varying(255),
    "adsets_insights_cpm" character varying(255),
    "adsets_insights_ctr" character varying(255),
    "adsets_insights_spend" character varying(255),
    "adsets_daily_budget" character varying(255),
    "adsets_lifetime_budget" character varying(255),
    "adsets_insights_date_start" date,
    "adsets_insights_date_stop" date,
    "adsets_insights_reach" character varying(255),
    "adsets_insights_results" bigint,
    "adsets_result_type" character varying(255),
    "adsets_insights_cost_per_result" double precision,
    "adsets_insights_actions" text,
    "createdat" timestamptz DEFAULT CURRENT_TIMESTAMP,
    "updatedat" timestamptz DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT "idx_16944_primary" PRIMARY KEY ("id")
)
WITH (oids = false);


DROP TABLE IF EXISTS "adsets_ads";
DROP SEQUENCE IF EXISTS adsets_ads_id_seq;
CREATE SEQUENCE adsets_ads_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."adsets_ads" (
    "id" bigint DEFAULT nextval('adsets_ads_id_seq') NOT NULL,
    "user_uuid" character varying(255),
    "account_platform" character varying(255),
    "account_social_userid" character varying(255),
    "campaign_id" bigint,
    "adsets_id" bigint,
    "ads_id" bigint,
    "ads_name" character varying(255),
    "ads_status" character varying(255),
    "ads_effective_status" character varying(255),
    "ads_insights_impressions" character varying(255),
    "ads_insights_clicks" character varying(255),
    "ads_insights_cpc" character varying(255),
    "ads_insights_cpm" character varying(255),
    "ads_insights_ctr" character varying(255),
    "ads_insights_spend" character varying(255),
    "ads_insights_reach" character varying(255),
    "ads_insights_date_start" date,
    "ads_insights_date_stop" date,
    "ads_insights_cost_per_result" character varying(255),
    "ads_result_type" character varying(255),
    "ads_insights_actions" text,
    "createdat" timestamptz DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "updatedat" timestamptz DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT "idx_16968_primary" PRIMARY KEY ("id")
)
WITH (oids = false);


DROP TABLE IF EXISTS "alert_thresholds";
DROP SEQUENCE IF EXISTS alert_thresholds_id_seq;
CREATE SEQUENCE alert_thresholds_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."alert_thresholds" (
    "id" bigint DEFAULT nextval('alert_thresholds_id_seq') NOT NULL,
    "user_uuid" character varying(255) NOT NULL,
    "alert_name" character varying(255) NOT NULL,
    "metric_type" text NOT NULL,
    "condition" text DEFAULT 'below' NOT NULL,
    "threshold_value" double precision NOT NULL,
    "comparison_period" text DEFAULT 'day' NOT NULL,
    "is_enabled" smallint DEFAULT '1' NOT NULL,
    "notify_email" smallint DEFAULT '1' NOT NULL,
    "notify_in_app" smallint DEFAULT '1' NOT NULL,
    "email_recipients" text,
    "last_triggered_at" timestamp,
    "last_value" double precision,
    "trigger_count" bigint DEFAULT '0' NOT NULL,
    "createdat" timestamp NOT NULL,
    "updatedat" timestamp NOT NULL,
    CONSTRAINT "idx_17033_primary" PRIMARY KEY ("id")
)
WITH (oids = false);


DROP TABLE IF EXISTS "analytics";
DROP SEQUENCE IF EXISTS analytics_id_seq;
CREATE SEQUENCE analytics_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."analytics" (
    "id" bigint DEFAULT nextval('analytics_id_seq') NOT NULL,
    "user_uuid" character varying(255),
    "platform_page_id" character varying(255),
    "platform" character varying(255),
    "analytic_type" character varying(255),
    "total_page_followers" bigint,
    "total_page_impressions" bigint,
    "total_page_impressions_unique" bigint,
    "total_page_views" bigint,
    "page_post_engagements" bigint,
    "page_actions_post_reactions_like_total" bigint,
    "week_date" character varying(255),
    "createdat" timestamptz DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "updatedat" timestamptz DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT "idx_17046_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

INSERT INTO "analytics" ("id", "user_uuid", "platform_page_id", "platform", "analytic_type", "total_page_followers", "total_page_impressions", "total_page_impressions_unique", "total_page_views", "page_post_engagements", "page_actions_post_reactions_like_total", "week_date", "createdat", "updatedat") VALUES
(7958,	'e5266555-8859-4f96-bab0-6596b9736d94',	'101865419522213',	'facebook',	'page_daily_follows',	1,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-07-14T07:00:00+0000',	'2025-10-10 11:43:20+00',	'2025-10-10 11:43:20+00'),
(7959,	'e5266555-8859-4f96-bab0-6596b9736d94',	'101865419522213',	'facebook',	'page_impressions',	NULL,	2,	NULL,	NULL,	NULL,	NULL,	'2025-07-14T07:00:00+0000',	'2025-10-10 11:43:20+00',	'2025-10-10 11:43:20+00'),
(7960,	'e5266555-8859-4f96-bab0-6596b9736d94',	'101865419522213',	'facebook',	'page_impressions',	NULL,	2,	NULL,	NULL,	NULL,	NULL,	'2025-08-09T07:00:00+0000',	'2025-10-10 11:43:20+00',	'2025-10-10 11:43:20+00'),
(7961,	'e5266555-8859-4f96-bab0-6596b9736d94',	'101865419522213',	'facebook',	'page_impressions',	NULL,	5,	NULL,	NULL,	NULL,	NULL,	'2025-08-26T07:00:00+0000',	'2025-10-10 11:43:20+00',	'2025-10-10 11:43:20+00'),
(7962,	'e5266555-8859-4f96-bab0-6596b9736d94',	'101865419522213',	'facebook',	'page_impressions',	NULL,	9,	NULL,	NULL,	NULL,	NULL,	'2025-09-02T07:00:00+0000',	'2025-10-10 11:43:20+00',	'2025-10-10 11:43:20+00'),
(7963,	'e5266555-8859-4f96-bab0-6596b9736d94',	'101865419522213',	'facebook',	'page_impressions',	NULL,	1,	NULL,	NULL,	NULL,	NULL,	'2025-09-03T07:00:00+0000',	'2025-10-10 11:43:20+00',	'2025-10-10 11:43:20+00'),
(7964,	'e5266555-8859-4f96-bab0-6596b9736d94',	'101865419522213',	'facebook',	'page_impressions_unique',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2025-07-14T07:00:00+0000',	'2025-10-10 11:43:20+00',	'2025-10-10 11:43:20+00'),
(7965,	'e5266555-8859-4f96-bab0-6596b9736d94',	'101865419522213',	'facebook',	'page_impressions_unique',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2025-08-09T07:00:00+0000',	'2025-10-10 11:43:20+00',	'2025-10-10 11:43:20+00'),
(7966,	'e5266555-8859-4f96-bab0-6596b9736d94',	'101865419522213',	'facebook',	'page_impressions_unique',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2025-08-26T07:00:00+0000',	'2025-10-10 11:43:20+00',	'2025-10-10 11:43:20+00'),
(7967,	'e5266555-8859-4f96-bab0-6596b9736d94',	'101865419522213',	'facebook',	'page_impressions_unique',	NULL,	NULL,	2,	NULL,	NULL,	NULL,	'2025-09-02T07:00:00+0000',	'2025-10-10 11:43:20+00',	'2025-10-10 11:43:20+00'),
(7968,	'e5266555-8859-4f96-bab0-6596b9736d94',	'101865419522213',	'facebook',	'page_impressions_unique',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2025-09-03T07:00:00+0000',	'2025-10-10 11:43:20+00',	'2025-10-10 11:43:20+00'),
(7969,	'e5266555-8859-4f96-bab0-6596b9736d94',	'101865419522213',	'facebook',	'page_views_total',	NULL,	NULL,	NULL,	3,	NULL,	NULL,	'2025-07-14T07:00:00+0000',	'2025-10-10 11:43:20+00',	'2025-10-10 11:43:20+00'),
(7970,	'e5266555-8859-4f96-bab0-6596b9736d94',	'101865419522213',	'facebook',	'page_views_total',	NULL,	NULL,	NULL,	3,	NULL,	NULL,	'2025-08-09T07:00:00+0000',	'2025-10-10 11:43:20+00',	'2025-10-10 11:43:20+00'),
(7971,	'e5266555-8859-4f96-bab0-6596b9736d94',	'108458993',	'linkedin',	'page_daily_follows',	1,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-09-03T00:00:00.000Z',	'2025-10-10 11:44:08+00',	'2025-10-10 11:44:08+00'),
(7972,	'e5266555-8859-4f96-bab0-6596b9736d94',	'108458993',	'linkedin',	'page_daily_follows',	1,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-04T00:00:00.000Z',	'2025-10-10 11:44:08+00',	'2025-10-10 11:44:08+00'),
(7973,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_daily_follows',	1,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-07-16T00:00:00.000Z',	'2025-10-10 11:44:09+00',	'2025-10-10 11:44:09+00'),
(7974,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_daily_follows',	-1,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-07-18T00:00:00.000Z',	'2025-10-10 11:44:09+00',	'2025-10-10 11:44:09+00'),
(7975,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_daily_follows',	1,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-07-26T00:00:00.000Z',	'2025-10-10 11:44:09+00',	'2025-10-10 11:44:09+00'),
(7976,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_daily_follows',	1,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-08-31T00:00:00.000Z',	'2025-10-10 11:44:09+00',	'2025-10-10 11:44:09+00'),
(7977,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_daily_follows',	-1,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-09-11T00:00:00.000Z',	'2025-10-10 11:44:09+00',	'2025-10-10 11:44:09+00'),
(7978,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	1,	NULL,	NULL,	NULL,	NULL,	'2025-07-12T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(7979,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	14,	NULL,	NULL,	NULL,	NULL,	'2025-07-16T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(7980,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	1,	NULL,	NULL,	NULL,	NULL,	'2025-07-17T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(7981,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	2,	NULL,	NULL,	NULL,	NULL,	'2025-07-19T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(7982,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	1,	NULL,	NULL,	NULL,	NULL,	'2025-07-23T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(7983,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	10,	NULL,	NULL,	NULL,	NULL,	'2025-07-25T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(7984,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	2,	NULL,	NULL,	NULL,	NULL,	'2025-07-29T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(7985,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	24,	NULL,	NULL,	NULL,	NULL,	'2025-08-05T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(7986,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	1,	NULL,	NULL,	NULL,	NULL,	'2025-08-13T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(7987,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	7,	NULL,	NULL,	NULL,	NULL,	'2025-08-15T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(7988,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	8,	NULL,	NULL,	NULL,	NULL,	'2025-08-16T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(7989,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	40,	NULL,	NULL,	NULL,	NULL,	'2025-08-17T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(7990,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	22,	NULL,	NULL,	NULL,	NULL,	'2025-08-18T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(7991,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	8,	NULL,	NULL,	NULL,	NULL,	'2025-08-19T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(7992,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	5,	NULL,	NULL,	NULL,	NULL,	'2025-08-20T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(7993,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	3,	NULL,	NULL,	NULL,	NULL,	'2025-08-21T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(7994,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	1,	NULL,	NULL,	NULL,	NULL,	'2025-08-23T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(7995,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	1,	NULL,	NULL,	NULL,	NULL,	'2025-08-24T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(7996,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	6,	NULL,	NULL,	NULL,	NULL,	'2025-08-26T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(7997,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	4,	NULL,	NULL,	NULL,	NULL,	'2025-08-27T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(7998,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	1,	NULL,	NULL,	NULL,	NULL,	'2025-08-28T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(7999,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	34,	NULL,	NULL,	NULL,	NULL,	'2025-08-30T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(8000,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	3,	NULL,	NULL,	NULL,	NULL,	'2025-08-31T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(8001,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	2,	NULL,	NULL,	NULL,	NULL,	'2025-09-01T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(8002,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	10,	NULL,	NULL,	NULL,	NULL,	'2025-09-02T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(8003,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	12,	NULL,	NULL,	NULL,	NULL,	'2025-09-03T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(8004,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	8,	NULL,	NULL,	NULL,	NULL,	'2025-09-05T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(8005,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	1,	NULL,	NULL,	NULL,	NULL,	'2025-09-06T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(8006,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	1,	NULL,	NULL,	NULL,	NULL,	'2025-09-07T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(8007,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	2,	NULL,	NULL,	NULL,	NULL,	'2025-09-08T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(8008,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	18,	NULL,	NULL,	NULL,	NULL,	'2025-09-09T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(8009,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	5,	NULL,	NULL,	NULL,	NULL,	'2025-09-10T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(8010,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	2,	NULL,	NULL,	NULL,	NULL,	'2025-09-11T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(8011,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	1,	NULL,	NULL,	NULL,	NULL,	'2025-09-12T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(8012,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	2,	NULL,	NULL,	NULL,	NULL,	'2025-09-15T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(8013,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	1,	NULL,	NULL,	NULL,	NULL,	'2025-09-18T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(8014,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	14,	NULL,	NULL,	NULL,	NULL,	'2025-09-19T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(8015,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	2,	NULL,	NULL,	NULL,	NULL,	'2025-09-21T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(8016,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	1,	NULL,	NULL,	NULL,	NULL,	'2025-09-22T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(8017,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	27,	NULL,	NULL,	NULL,	NULL,	'2025-09-23T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(8018,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	51,	NULL,	NULL,	NULL,	NULL,	'2025-09-24T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(8019,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	41,	NULL,	NULL,	NULL,	NULL,	'2025-09-25T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(8020,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	109,	NULL,	NULL,	NULL,	NULL,	'2025-09-26T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(8021,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	153,	NULL,	NULL,	NULL,	NULL,	'2025-09-27T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(8022,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	16,	NULL,	NULL,	NULL,	NULL,	'2025-09-28T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(8023,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	44,	NULL,	NULL,	NULL,	NULL,	'2025-09-29T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(8024,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	29,	NULL,	NULL,	NULL,	NULL,	'2025-09-30T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(8025,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	44,	NULL,	NULL,	NULL,	NULL,	'2025-10-01T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(8026,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	115,	NULL,	NULL,	NULL,	NULL,	'2025-10-02T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(8027,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	22,	NULL,	NULL,	NULL,	NULL,	'2025-10-03T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(8028,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	43,	NULL,	NULL,	NULL,	NULL,	'2025-10-04T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(8029,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	2,	NULL,	NULL,	NULL,	NULL,	'2025-10-05T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(8030,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	2,	NULL,	NULL,	NULL,	NULL,	'2025-10-06T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(8031,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	80,	NULL,	NULL,	NULL,	NULL,	'2025-10-07T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(8032,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	7,	NULL,	NULL,	NULL,	NULL,	'2025-10-08T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(8033,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	31,	NULL,	NULL,	NULL,	NULL,	'2025-10-09T00:00:00.000Z',	'2025-10-10 11:44:10+00',	'2025-10-10 11:44:10+00'),
(8034,	'e5266555-8859-4f96-bab0-6596b9736d94',	'108458993',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	3,	NULL,	NULL,	'2025-09-03T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8035,	'e5266555-8859-4f96-bab0-6596b9736d94',	'108458993',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	1,	NULL,	NULL,	'2025-09-05T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8036,	'e5266555-8859-4f96-bab0-6596b9736d94',	'108458993',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	1,	NULL,	NULL,	'2025-09-11T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8037,	'e5266555-8859-4f96-bab0-6596b9736d94',	'108458993',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2025-10-04T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8038,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2025-07-12T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8039,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2025-07-16T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8040,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2025-07-17T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8041,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	2,	NULL,	NULL,	NULL,	'2025-07-19T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8042,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2025-07-23T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8043,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	2,	NULL,	NULL,	NULL,	'2025-07-25T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8044,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2025-07-29T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8045,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	2,	NULL,	NULL,	NULL,	'2025-08-05T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8046,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2025-08-13T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8047,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2025-08-15T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8048,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	5,	NULL,	NULL,	NULL,	'2025-08-16T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8049,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	7,	NULL,	NULL,	NULL,	'2025-08-17T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8050,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	3,	NULL,	NULL,	NULL,	'2025-08-18T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8051,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	2,	NULL,	NULL,	NULL,	'2025-08-19T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8052,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	2,	NULL,	NULL,	NULL,	'2025-08-20T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8053,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2025-08-21T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8054,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2025-08-23T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8055,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2025-08-24T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8056,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	2,	NULL,	NULL,	NULL,	'2025-08-26T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8057,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	3,	NULL,	NULL,	NULL,	'2025-08-27T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8058,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2025-08-28T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8059,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	5,	NULL,	NULL,	NULL,	'2025-08-30T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8060,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	3,	NULL,	NULL,	NULL,	'2025-08-31T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8061,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	2,	NULL,	NULL,	NULL,	'2025-09-01T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8062,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	3,	NULL,	NULL,	NULL,	'2025-09-02T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8063,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2025-09-03T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8064,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	2,	NULL,	NULL,	NULL,	'2025-09-05T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8065,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2025-09-06T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8066,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2025-09-07T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8067,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	2,	NULL,	NULL,	NULL,	'2025-09-08T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8068,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	2,	NULL,	NULL,	NULL,	'2025-09-09T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8069,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	4,	NULL,	NULL,	NULL,	'2025-09-10T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8070,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	2,	NULL,	NULL,	NULL,	'2025-09-11T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8071,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2025-09-12T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8072,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2025-09-15T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8073,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2025-09-18T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8074,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	4,	NULL,	NULL,	NULL,	'2025-09-19T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8075,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	2,	NULL,	NULL,	NULL,	'2025-09-21T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8076,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2025-09-22T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8077,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	7,	NULL,	NULL,	NULL,	'2025-09-23T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8078,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	10,	NULL,	NULL,	NULL,	'2025-09-24T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8079,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	6,	NULL,	NULL,	NULL,	'2025-09-25T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8080,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	11,	NULL,	NULL,	NULL,	'2025-09-26T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8081,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	9,	NULL,	NULL,	NULL,	'2025-09-27T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8082,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	6,	NULL,	NULL,	NULL,	'2025-09-28T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8083,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	10,	NULL,	NULL,	NULL,	'2025-09-29T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8084,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	4,	NULL,	NULL,	NULL,	'2025-09-30T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8085,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	11,	NULL,	NULL,	NULL,	'2025-10-01T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8086,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	13,	NULL,	NULL,	NULL,	'2025-10-02T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8087,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	12,	NULL,	NULL,	NULL,	'2025-10-03T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8088,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	7,	NULL,	NULL,	NULL,	'2025-10-04T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8089,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2025-10-05T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8090,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	2,	NULL,	NULL,	NULL,	'2025-10-06T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8091,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	3,	NULL,	NULL,	NULL,	'2025-10-07T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8092,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	2,	NULL,	NULL,	NULL,	'2025-10-08T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8093,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	4,	NULL,	NULL,	NULL,	'2025-10-09T00:00:00.000Z',	'2025-10-10 11:44:11+00',	'2025-10-10 11:44:11+00'),
(8094,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2025-07-16T00:00:00.000Z',	'2025-10-10 11:44:12+00',	'2025-10-10 11:44:12+00'),
(8095,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2025-07-18T00:00:00.000Z',	'2025-10-10 11:44:12+00',	'2025-10-10 11:44:12+00'),
(8096,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	1,	NULL,	NULL,	'2025-07-19T00:00:00.000Z',	'2025-10-10 11:44:12+00',	'2025-10-10 11:44:12+00'),
(8097,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	1,	NULL,	NULL,	'2025-07-23T00:00:00.000Z',	'2025-10-10 11:44:12+00',	'2025-10-10 11:44:12+00'),
(8098,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	7,	NULL,	NULL,	'2025-07-25T00:00:00.000Z',	'2025-10-10 11:44:12+00',	'2025-10-10 11:44:12+00'),
(8099,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	3,	NULL,	NULL,	'2025-07-26T00:00:00.000Z',	'2025-10-10 11:44:12+00',	'2025-10-10 11:44:12+00'),
(8100,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2025-07-29T00:00:00.000Z',	'2025-10-10 11:44:12+00',	'2025-10-10 11:44:12+00'),
(8101,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	10,	NULL,	NULL,	'2025-08-05T00:00:00.000Z',	'2025-10-10 11:44:12+00',	'2025-10-10 11:44:12+00'),
(8102,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	1,	NULL,	NULL,	'2025-08-06T00:00:00.000Z',	'2025-10-10 11:44:12+00',	'2025-10-10 11:44:12+00'),
(8103,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	1,	NULL,	NULL,	'2025-08-07T00:00:00.000Z',	'2025-10-10 11:44:12+00',	'2025-10-10 11:44:12+00'),
(8104,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	1,	NULL,	NULL,	'2025-08-12T00:00:00.000Z',	'2025-10-10 11:44:12+00',	'2025-10-10 11:44:12+00'),
(8105,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	1,	NULL,	NULL,	'2025-08-15T00:00:00.000Z',	'2025-10-10 11:44:12+00',	'2025-10-10 11:44:12+00'),
(8106,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	1,	NULL,	NULL,	'2025-08-20T00:00:00.000Z',	'2025-10-10 11:44:12+00',	'2025-10-10 11:44:12+00'),
(8107,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	1,	NULL,	NULL,	'2025-08-22T00:00:00.000Z',	'2025-10-10 11:44:12+00',	'2025-10-10 11:44:12+00'),
(8108,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	3,	NULL,	NULL,	'2025-08-31T00:00:00.000Z',	'2025-10-10 11:44:12+00',	'2025-10-10 11:44:12+00'),
(8109,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2025-09-02T00:00:00.000Z',	'2025-10-10 11:44:12+00',	'2025-10-10 11:44:12+00'),
(8110,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	1,	NULL,	NULL,	'2025-09-04T00:00:00.000Z',	'2025-10-10 11:44:12+00',	'2025-10-10 11:44:12+00'),
(8111,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	1,	NULL,	NULL,	'2025-09-05T00:00:00.000Z',	'2025-10-10 11:44:12+00',	'2025-10-10 11:44:12+00'),
(8112,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	4,	NULL,	NULL,	'2025-09-09T00:00:00.000Z',	'2025-10-10 11:44:12+00',	'2025-10-10 11:44:12+00'),
(8113,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	4,	NULL,	NULL,	'2025-09-11T00:00:00.000Z',	'2025-10-10 11:44:12+00',	'2025-10-10 11:44:12+00'),
(8114,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	4,	NULL,	NULL,	'2025-09-17T00:00:00.000Z',	'2025-10-10 11:44:12+00',	'2025-10-10 11:44:12+00'),
(8115,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	5,	NULL,	NULL,	'2025-09-19T00:00:00.000Z',	'2025-10-10 11:44:12+00',	'2025-10-10 11:44:12+00'),
(8116,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2025-09-25T00:00:00.000Z',	'2025-10-10 11:44:12+00',	'2025-10-10 11:44:12+00'),
(8117,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	7,	NULL,	NULL,	'2025-09-26T00:00:00.000Z',	'2025-10-10 11:44:12+00',	'2025-10-10 11:44:12+00'),
(8118,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	4,	NULL,	NULL,	'2025-09-27T00:00:00.000Z',	'2025-10-10 11:44:12+00',	'2025-10-10 11:44:12+00'),
(8119,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	1,	NULL,	NULL,	'2025-09-28T00:00:00.000Z',	'2025-10-10 11:44:12+00',	'2025-10-10 11:44:12+00'),
(8120,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	4,	NULL,	NULL,	'2025-09-29T00:00:00.000Z',	'2025-10-10 11:44:12+00',	'2025-10-10 11:44:12+00'),
(8121,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2025-09-30T00:00:00.000Z',	'2025-10-10 11:44:12+00',	'2025-10-10 11:44:12+00'),
(8122,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	6,	NULL,	NULL,	'2025-10-01T00:00:00.000Z',	'2025-10-10 11:44:12+00',	'2025-10-10 11:44:12+00'),
(8123,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	4,	NULL,	NULL,	'2025-10-02T00:00:00.000Z',	'2025-10-10 11:44:12+00',	'2025-10-10 11:44:12+00'),
(8124,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2025-10-04T00:00:00.000Z',	'2025-10-10 11:44:12+00',	'2025-10-10 11:44:12+00'),
(8125,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2025-10-07T00:00:00.000Z',	'2025-10-10 11:44:12+00',	'2025-10-10 11:44:12+00'),
(8126,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_post_engagements',	NULL,	NULL,	NULL,	NULL,	0,	NULL,	'2025-07-16T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8127,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_post_engagements',	NULL,	NULL,	NULL,	NULL,	1,	NULL,	'2025-07-29T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8128,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_post_engagements',	NULL,	NULL,	NULL,	NULL,	0,	NULL,	'2025-08-05T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8129,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_post_engagements',	NULL,	NULL,	NULL,	NULL,	0,	NULL,	'2025-08-16T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8130,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_post_engagements',	NULL,	NULL,	NULL,	NULL,	0,	NULL,	'2025-08-17T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8131,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_post_engagements',	NULL,	NULL,	NULL,	NULL,	0,	NULL,	'2025-08-18T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8132,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_post_engagements',	NULL,	NULL,	NULL,	NULL,	0,	NULL,	'2025-08-19T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8133,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_post_engagements',	NULL,	NULL,	NULL,	NULL,	0,	NULL,	'2025-08-30T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8134,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_post_engagements',	NULL,	NULL,	NULL,	NULL,	0,	NULL,	'2025-09-03T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8135,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_post_engagements',	NULL,	NULL,	NULL,	NULL,	0,	NULL,	'2025-09-23T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8136,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_post_engagements',	NULL,	NULL,	NULL,	NULL,	0,	NULL,	'2025-09-24T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8137,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_post_engagements',	NULL,	NULL,	NULL,	NULL,	0,	NULL,	'2025-09-25T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8138,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_post_engagements',	NULL,	NULL,	NULL,	NULL,	0,	NULL,	'2025-09-26T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8139,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_post_engagements',	NULL,	NULL,	NULL,	NULL,	0,	NULL,	'2025-09-27T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8140,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_post_engagements',	NULL,	NULL,	NULL,	NULL,	0,	NULL,	'2025-09-28T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8141,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_post_engagements',	NULL,	NULL,	NULL,	NULL,	1,	NULL,	'2025-09-29T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8142,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_post_engagements',	NULL,	NULL,	NULL,	NULL,	1,	NULL,	'2025-09-30T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8143,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_post_engagements',	NULL,	NULL,	NULL,	NULL,	0,	NULL,	'2025-10-01T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8144,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_post_engagements',	NULL,	NULL,	NULL,	NULL,	0,	NULL,	'2025-10-02T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8145,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_post_engagements',	NULL,	NULL,	NULL,	NULL,	0,	NULL,	'2025-10-03T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8146,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_post_engagements',	NULL,	NULL,	NULL,	NULL,	0,	NULL,	'2025-10-04T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8147,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_post_engagements',	NULL,	NULL,	NULL,	NULL,	0,	NULL,	'2025-10-08T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8148,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_post_engagements',	NULL,	NULL,	NULL,	NULL,	0,	NULL,	'2025-10-09T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8149,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_actions_post_reactions_like_total',	NULL,	NULL,	NULL,	NULL,	NULL,	1,	'2025-08-16T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8150,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_actions_post_reactions_like_total',	NULL,	NULL,	NULL,	NULL,	NULL,	1,	'2025-08-17T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8151,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_actions_post_reactions_like_total',	NULL,	NULL,	NULL,	NULL,	NULL,	1,	'2025-08-19T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8152,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_actions_post_reactions_like_total',	NULL,	NULL,	NULL,	NULL,	NULL,	1,	'2025-09-03T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8153,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_actions_post_reactions_like_total',	NULL,	NULL,	NULL,	NULL,	NULL,	4,	'2025-09-24T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8154,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_actions_post_reactions_like_total',	NULL,	NULL,	NULL,	NULL,	NULL,	4,	'2025-09-25T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8155,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_actions_post_reactions_like_total',	NULL,	NULL,	NULL,	NULL,	NULL,	13,	'2025-09-26T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8156,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_actions_post_reactions_like_total',	NULL,	NULL,	NULL,	NULL,	NULL,	6,	'2025-09-27T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8157,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_actions_post_reactions_like_total',	NULL,	NULL,	NULL,	NULL,	NULL,	2,	'2025-09-28T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8158,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_actions_post_reactions_like_total',	NULL,	NULL,	NULL,	NULL,	NULL,	2,	'2025-09-29T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8159,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_actions_post_reactions_like_total',	NULL,	NULL,	NULL,	NULL,	NULL,	2,	'2025-10-01T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8160,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_actions_post_reactions_like_total',	NULL,	NULL,	NULL,	NULL,	NULL,	16,	'2025-10-02T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8161,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_actions_post_reactions_like_total',	NULL,	NULL,	NULL,	NULL,	NULL,	2,	'2025-10-03T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8162,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_actions_post_reactions_like_total',	NULL,	NULL,	NULL,	NULL,	NULL,	4,	'2025-10-04T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8163,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_actions_post_reactions_like_total',	NULL,	NULL,	NULL,	NULL,	NULL,	1,	'2025-10-08T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8164,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_actions_post_reactions_like_total',	NULL,	NULL,	NULL,	NULL,	NULL,	7,	'2025-10-09T00:00:00.000Z',	'2025-10-10 11:44:13+00',	'2025-10-10 11:44:13+00'),
(8940,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_daily_follows',	-1,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-12T00:00:00.000Z',	'2025-10-22 09:26:09+00',	'2025-10-22 09:26:09+00'),
(8941,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_daily_follows',	1,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-15T00:00:00.000Z',	'2025-10-22 09:26:09+00',	'2025-10-22 09:26:09+00'),
(8942,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	7,	NULL,	NULL,	NULL,	NULL,	'2025-10-10T00:00:00.000Z',	'2025-10-22 09:26:10+00',	'2025-10-22 09:26:10+00'),
(8943,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	6,	NULL,	NULL,	NULL,	NULL,	'2025-10-11T00:00:00.000Z',	'2025-10-22 09:26:10+00',	'2025-10-22 09:26:10+00'),
(8944,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	1,	NULL,	NULL,	NULL,	NULL,	'2025-10-12T00:00:00.000Z',	'2025-10-22 09:26:10+00',	'2025-10-22 09:26:10+00'),
(8945,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	16,	NULL,	NULL,	NULL,	NULL,	'2025-10-13T00:00:00.000Z',	'2025-10-22 09:26:10+00',	'2025-10-22 09:26:10+00'),
(8946,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	4,	NULL,	NULL,	NULL,	NULL,	'2025-10-14T00:00:00.000Z',	'2025-10-22 09:26:10+00',	'2025-10-22 09:26:10+00'),
(8947,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	40,	NULL,	NULL,	NULL,	NULL,	'2025-10-15T00:00:00.000Z',	'2025-10-22 09:26:10+00',	'2025-10-22 09:26:10+00'),
(8948,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	11,	NULL,	NULL,	NULL,	NULL,	'2025-10-16T00:00:00.000Z',	'2025-10-22 09:26:10+00',	'2025-10-22 09:26:10+00'),
(8949,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	12,	NULL,	NULL,	NULL,	NULL,	'2025-10-17T00:00:00.000Z',	'2025-10-22 09:26:10+00',	'2025-10-22 09:26:10+00'),
(8950,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	26,	NULL,	NULL,	NULL,	NULL,	'2025-10-18T00:00:00.000Z',	'2025-10-22 09:26:10+00',	'2025-10-22 09:26:10+00'),
(8951,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	1,	NULL,	NULL,	NULL,	NULL,	'2025-10-20T00:00:00.000Z',	'2025-10-22 09:26:10+00',	'2025-10-22 09:26:10+00'),
(8952,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions',	NULL,	2,	NULL,	NULL,	NULL,	NULL,	'2025-10-21T00:00:00.000Z',	'2025-10-22 09:26:10+00',	'2025-10-22 09:26:10+00'),
(8953,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	5,	NULL,	NULL,	NULL,	'2025-10-10T00:00:00.000Z',	'2025-10-22 09:26:11+00',	'2025-10-22 09:26:11+00'),
(8954,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	2,	NULL,	NULL,	NULL,	'2025-10-11T00:00:00.000Z',	'2025-10-22 09:26:11+00',	'2025-10-22 09:26:11+00'),
(8955,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2025-10-12T00:00:00.000Z',	'2025-10-22 09:26:11+00',	'2025-10-22 09:26:11+00'),
(8956,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	3,	NULL,	NULL,	NULL,	'2025-10-13T00:00:00.000Z',	'2025-10-22 09:26:11+00',	'2025-10-22 09:26:11+00'),
(8957,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	2,	NULL,	NULL,	NULL,	'2025-10-14T00:00:00.000Z',	'2025-10-22 09:26:11+00',	'2025-10-22 09:26:11+00'),
(8958,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	10,	NULL,	NULL,	NULL,	'2025-10-15T00:00:00.000Z',	'2025-10-22 09:26:11+00',	'2025-10-22 09:26:11+00'),
(8959,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	5,	NULL,	NULL,	NULL,	'2025-10-16T00:00:00.000Z',	'2025-10-22 09:26:11+00',	'2025-10-22 09:26:11+00'),
(8960,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	4,	NULL,	NULL,	NULL,	'2025-10-17T00:00:00.000Z',	'2025-10-22 09:26:11+00',	'2025-10-22 09:26:11+00'),
(8961,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	2,	NULL,	NULL,	NULL,	'2025-10-18T00:00:00.000Z',	'2025-10-22 09:26:11+00',	'2025-10-22 09:26:11+00'),
(8962,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2025-10-20T00:00:00.000Z',	'2025-10-22 09:26:11+00',	'2025-10-22 09:26:11+00'),
(8963,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_impressions_unique',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2025-10-21T00:00:00.000Z',	'2025-10-22 09:26:11+00',	'2025-10-22 09:26:11+00'),
(8964,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	1,	NULL,	NULL,	'2025-10-11T00:00:00.000Z',	'2025-10-22 09:26:12+00',	'2025-10-22 09:26:12+00'),
(8965,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	1,	NULL,	NULL,	'2025-10-13T00:00:00.000Z',	'2025-10-22 09:26:12+00',	'2025-10-22 09:26:12+00'),
(8966,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_views_total',	NULL,	NULL,	NULL,	1,	NULL,	NULL,	'2025-10-15T00:00:00.000Z',	'2025-10-22 09:26:12+00',	'2025-10-22 09:26:12+00'),
(8967,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_post_engagements',	NULL,	NULL,	NULL,	NULL,	0,	NULL,	'2025-10-15T00:00:00.000Z',	'2025-10-22 09:26:12+00',	'2025-10-22 09:26:12+00'),
(8968,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_post_engagements',	NULL,	NULL,	NULL,	NULL,	0,	NULL,	'2025-10-16T00:00:00.000Z',	'2025-10-22 09:26:12+00',	'2025-10-22 09:26:12+00'),
(8969,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_post_engagements',	NULL,	NULL,	NULL,	NULL,	0,	NULL,	'2025-10-17T00:00:00.000Z',	'2025-10-22 09:26:12+00',	'2025-10-22 09:26:12+00'),
(8970,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_post_engagements',	NULL,	NULL,	NULL,	NULL,	1,	NULL,	'2025-10-21T00:00:00.000Z',	'2025-10-22 09:26:12+00',	'2025-10-22 09:26:12+00'),
(8971,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_actions_post_reactions_like_total',	NULL,	NULL,	NULL,	NULL,	NULL,	1,	'2025-10-15T00:00:00.000Z',	'2025-10-22 09:26:13+00',	'2025-10-22 09:26:13+00'),
(8972,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_actions_post_reactions_like_total',	NULL,	NULL,	NULL,	NULL,	NULL,	1,	'2025-10-16T00:00:00.000Z',	'2025-10-22 09:26:13+00',	'2025-10-22 09:26:13+00'),
(8973,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_actions_post_reactions_like_total',	NULL,	NULL,	NULL,	NULL,	NULL,	1,	'2025-10-17T00:00:00.000Z',	'2025-10-22 09:26:13+00',	'2025-10-22 09:26:13+00'),
(8974,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'linkedin',	'page_actions_post_reactions_like_total',	NULL,	NULL,	NULL,	NULL,	NULL,	1,	'2025-10-21T00:00:00.000Z',	'2025-10-22 09:26:13+00',	'2025-10-22 09:26:13+00');

DROP TABLE IF EXISTS "billing_activity_logs";
DROP SEQUENCE IF EXISTS billing_activity_logs_id_seq;
CREATE SEQUENCE billing_activity_logs_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."billing_activity_logs" (
    "id" bigint DEFAULT nextval('billing_activity_logs_id_seq') NOT NULL,
    "user_uuid" character varying(255),
    "subscription_id" bigint,
    "transaction_id" bigint,
    "action_type" text NOT NULL,
    "action_status" text DEFAULT 'success' NOT NULL,
    "actor_type" text DEFAULT 'system' NOT NULL,
    "actor_id" character varying(255),
    "actor_email" character varying(255),
    "old_value" text,
    "new_value" text,
    "amount" bigint,
    "currency" character varying(3),
    "stripe_event_id" character varying(255),
    "stripe_object_id" character varying(255),
    "error_code" character varying(100),
    "error_message" text,
    "description" text,
    "notes" text,
    "ip_address" character varying(45),
    "user_agent" text,
    "request_id" character varying(255),
    "metadata" text,
    "createdat" timestamp NOT NULL,
    "updatedat" timestamp NOT NULL,
    CONSTRAINT "idx_17060_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

COMMENT ON COLUMN "insocial_mysql"."billing_activity_logs"."user_uuid" IS 'User UUID reference';

COMMENT ON COLUMN "insocial_mysql"."billing_activity_logs"."subscription_id" IS 'Related subscription ID';

COMMENT ON COLUMN "insocial_mysql"."billing_activity_logs"."transaction_id" IS 'Related transaction ID';

COMMENT ON COLUMN "insocial_mysql"."billing_activity_logs"."action_type" IS 'Type of billing action';

COMMENT ON COLUMN "insocial_mysql"."billing_activity_logs"."action_status" IS 'Status of the action';

COMMENT ON COLUMN "insocial_mysql"."billing_activity_logs"."actor_type" IS 'Who performed the action';

COMMENT ON COLUMN "insocial_mysql"."billing_activity_logs"."actor_id" IS 'ID of the actor';

COMMENT ON COLUMN "insocial_mysql"."billing_activity_logs"."actor_email" IS 'Email of the actor';

COMMENT ON COLUMN "insocial_mysql"."billing_activity_logs"."old_value" IS 'Previous value(s) before change';

COMMENT ON COLUMN "insocial_mysql"."billing_activity_logs"."new_value" IS 'New value(s) after change';

COMMENT ON COLUMN "insocial_mysql"."billing_activity_logs"."amount" IS 'Amount involved in cents';

COMMENT ON COLUMN "insocial_mysql"."billing_activity_logs"."currency" IS 'Currency code';

COMMENT ON COLUMN "insocial_mysql"."billing_activity_logs"."stripe_event_id" IS 'Related Stripe event ID';

COMMENT ON COLUMN "insocial_mysql"."billing_activity_logs"."stripe_object_id" IS 'Related Stripe object ID (subscription, invoice, etc.)';

COMMENT ON COLUMN "insocial_mysql"."billing_activity_logs"."error_code" IS 'Error code if failed';

COMMENT ON COLUMN "insocial_mysql"."billing_activity_logs"."error_message" IS 'Error message if failed';

COMMENT ON COLUMN "insocial_mysql"."billing_activity_logs"."description" IS 'Human-readable description';

COMMENT ON COLUMN "insocial_mysql"."billing_activity_logs"."notes" IS 'Admin notes';

COMMENT ON COLUMN "insocial_mysql"."billing_activity_logs"."ip_address" IS 'IP address of the request';

COMMENT ON COLUMN "insocial_mysql"."billing_activity_logs"."user_agent" IS 'User agent string';

COMMENT ON COLUMN "insocial_mysql"."billing_activity_logs"."request_id" IS 'Request ID for tracing';

COMMENT ON COLUMN "insocial_mysql"."billing_activity_logs"."metadata" IS 'Additional metadata';

INSERT INTO "billing_activity_logs" ("id", "user_uuid", "subscription_id", "transaction_id", "action_type", "action_status", "actor_type", "actor_id", "actor_email", "old_value", "new_value", "amount", "currency", "stripe_event_id", "stripe_object_id", "error_code", "error_message", "description", "notes", "ip_address", "user_agent", "request_id", "metadata", "createdat", "updatedat") VALUES
(1,	'9e47ed0e-73f7-41d5-9dac-5c37b8df8a4f',	NULL,	NULL,	'card_added',	'success',	'stripe',	NULL,	NULL,	NULL,	'{"brand":"visa","last4":"1111"}',	NULL,	NULL,	'evt_1Sc8r6HpVJPrOqLkBYk1cmjl',	'pm_1Sc8r5HpVJPrOqLkGD0xuD2V',	NULL,	NULL,	'Payment method added: visa ending in 1111',	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-12-08 18:08:18',	'2025-12-08 18:08:18'),
(2,	'9e47ed0e-73f7-41d5-9dac-5c37b8df8a4f',	1,	NULL,	'subscription_created',	'success',	'user',	NULL,	NULL,	NULL,	'{"plan_id":3,"status":"active","trial_end":null}',	NULL,	NULL,	NULL,	'sub_1Sc8r8HpVJPrOqLkX4hZp1K4',	NULL,	NULL,	'New subscription created for plan Agency',	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-12-08 18:08:29',	'2025-12-08 18:08:29'),
(3,	'9e47ed0e-73f7-41d5-9dac-5c37b8df8a4f',	1,	NULL,	'payment_succeeded',	'success',	'stripe',	NULL,	NULL,	NULL,	NULL,	9900,	'usd',	'evt_1Sc8rCHpVJPrOqLkc1IKjRiF',	'in_1Sc8r8HpVJPrOqLkqss6grEV',	NULL,	NULL,	'Payment of 99 USD succeeded for invoice FVJFOQBG-0001',	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-12-08 18:08:26',	'2025-12-08 18:08:26'),
(4,	'6f4362d5-744c-446e-8108-8db805396e51',	NULL,	NULL,	'card_added',	'success',	'stripe',	NULL,	NULL,	NULL,	'{"brand":"visa","last4":"1111"}',	NULL,	NULL,	'evt_1Sc9R4HpVJPrOqLkYWKeHO7b',	'pm_1Sc9R4HpVJPrOqLkOXnfcKFb',	NULL,	NULL,	'Payment method added: visa ending in 1111',	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-12-08 18:45:29',	'2025-12-08 18:45:29'),
(5,	'6f4362d5-744c-446e-8108-8db805396e51',	2,	NULL,	'subscription_created',	'success',	'user',	NULL,	NULL,	NULL,	'{"plan_id":1,"status":"trialing","trial_end":"2025-12-09T18:45:27.000Z"}',	NULL,	NULL,	NULL,	'sub_1Sc9R5HpVJPrOqLkPt4sV5R5',	NULL,	NULL,	'New subscription created for plan Starter',	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-12-08 18:45:29',	'2025-12-08 18:45:29'),
(6,	'6f4362d5-744c-446e-8108-8db805396e51',	2,	NULL,	'payment_succeeded',	'success',	'stripe',	NULL,	NULL,	NULL,	NULL,	0,	'usd',	'evt_1Sc9R7HpVJPrOqLk1VlxsWJe',	'in_1Sc9R5HpVJPrOqLkM1DKHuY9',	NULL,	NULL,	'Payment of 0 USD succeeded for invoice ITYFUTSR-0001',	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-12-08 18:45:33',	'2025-12-08 18:45:33'),
(7,	'9e47ed0e-73f7-41d5-9dac-5c37b8df8a4f',	NULL,	NULL,	'admin_action',	'success',	'user',	'9e47ed0e-73f7-41d5-9dac-5c37b8df8a4f',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'User accessed Stripe Customer Portal',	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-12-08 19:51:28',	'2025-12-08 19:51:28'),
(8,	'9e47ed0e-73f7-41d5-9dac-5c37b8df8a4f',	NULL,	NULL,	'admin_action',	'success',	'user',	'9e47ed0e-73f7-41d5-9dac-5c37b8df8a4f',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'User accessed Stripe Customer Portal',	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-12-08 20:02:11',	'2025-12-08 20:02:11');

DROP TABLE IF EXISTS "billing_notifications";
DROP SEQUENCE IF EXISTS billing_notifications_id_seq;
CREATE SEQUENCE billing_notifications_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."billing_notifications" (
    "id" bigint DEFAULT nextval('billing_notifications_id_seq') NOT NULL,
    "user_uuid" character varying(255) NOT NULL,
    "subscription_id" bigint,
    "transaction_id" bigint,
    "notification_type" text NOT NULL,
    "channel" text DEFAULT 'email' NOT NULL,
    "priority" text DEFAULT 'normal' NOT NULL,
    "status" text DEFAULT 'pending' NOT NULL,
    "recipient_email" character varying(255),
    "recipient_phone" character varying(50),
    "subject" character varying(500),
    "template_name" character varying(100),
    "template_data" text,
    "content" text,
    "scheduled_at" timestamp NOT NULL,
    "sent_at" timestamp,
    "delivered_at" timestamp,
    "opened_at" timestamp,
    "clicked_at" timestamp,
    "retry_count" bigint DEFAULT '0' NOT NULL,
    "max_retries" bigint DEFAULT '3' NOT NULL,
    "last_error" text,
    "external_id" character varying(255),
    "metadata" text,
    "createdat" timestamp NOT NULL,
    "updatedat" timestamp NOT NULL,
    CONSTRAINT "idx_17078_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

COMMENT ON COLUMN "insocial_mysql"."billing_notifications"."user_uuid" IS 'User UUID reference';

COMMENT ON COLUMN "insocial_mysql"."billing_notifications"."subscription_id" IS 'Related subscription ID';

COMMENT ON COLUMN "insocial_mysql"."billing_notifications"."transaction_id" IS 'Related transaction ID';

COMMENT ON COLUMN "insocial_mysql"."billing_notifications"."notification_type" IS 'Type of notification';

COMMENT ON COLUMN "insocial_mysql"."billing_notifications"."channel" IS 'Notification channel';

COMMENT ON COLUMN "insocial_mysql"."billing_notifications"."priority" IS 'Notification priority';

COMMENT ON COLUMN "insocial_mysql"."billing_notifications"."status" IS 'Notification status';

COMMENT ON COLUMN "insocial_mysql"."billing_notifications"."recipient_email" IS 'Email recipient';

COMMENT ON COLUMN "insocial_mysql"."billing_notifications"."recipient_phone" IS 'Phone recipient (for SMS)';

COMMENT ON COLUMN "insocial_mysql"."billing_notifications"."subject" IS 'Email subject';

COMMENT ON COLUMN "insocial_mysql"."billing_notifications"."template_name" IS 'Email template name';

COMMENT ON COLUMN "insocial_mysql"."billing_notifications"."template_data" IS 'Data for template rendering';

COMMENT ON COLUMN "insocial_mysql"."billing_notifications"."content" IS 'Rendered content (for logging)';

COMMENT ON COLUMN "insocial_mysql"."billing_notifications"."scheduled_at" IS 'When to send the notification';

COMMENT ON COLUMN "insocial_mysql"."billing_notifications"."sent_at" IS 'When notification was sent';

COMMENT ON COLUMN "insocial_mysql"."billing_notifications"."delivered_at" IS 'When notification was delivered';

COMMENT ON COLUMN "insocial_mysql"."billing_notifications"."opened_at" IS 'When email was opened';

COMMENT ON COLUMN "insocial_mysql"."billing_notifications"."clicked_at" IS 'When link was clicked';

COMMENT ON COLUMN "insocial_mysql"."billing_notifications"."retry_count" IS 'Number of send attempts';

COMMENT ON COLUMN "insocial_mysql"."billing_notifications"."max_retries" IS 'Maximum retry attempts';

COMMENT ON COLUMN "insocial_mysql"."billing_notifications"."last_error" IS 'Last error message';

COMMENT ON COLUMN "insocial_mysql"."billing_notifications"."external_id" IS 'External service ID (SendGrid, etc.)';

COMMENT ON COLUMN "insocial_mysql"."billing_notifications"."metadata" IS 'Additional metadata';

INSERT INTO "billing_notifications" ("id", "user_uuid", "subscription_id", "transaction_id", "notification_type", "channel", "priority", "status", "recipient_email", "recipient_phone", "subject", "template_name", "template_data", "content", "scheduled_at", "sent_at", "delivered_at", "opened_at", "clicked_at", "retry_count", "max_retries", "last_error", "external_id", "metadata", "createdat", "updatedat") VALUES
(1,	'6f4362d5-744c-446e-8108-8db805396e51',	2,	NULL,	'trial_ending_1h',	'email',	'urgent',	'pending',	'developerw0945@gmail.com',	NULL,	'Your trial ends in 1 hour',	'trial_ending_1h',	'{"firstName":"Baljeet","planName":"Starter","trialEndDate":"2025-12-09T18:45:27.000Z"}',	NULL,	'2025-12-09 17:45:27',	NULL,	NULL,	NULL,	NULL,	0,	3,	NULL,	NULL,	NULL,	'2025-12-08 18:45:29',	'2025-12-08 18:45:29');

DROP TABLE IF EXISTS "campaigns";
DROP SEQUENCE IF EXISTS campaigns_id_seq;
CREATE SEQUENCE campaigns_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."campaigns" (
    "id" bigint DEFAULT nextval('campaigns_id_seq') NOT NULL,
    "user_uuid" character varying(255),
    "account_platform" character varying(255),
    "account_social_userid" bigint,
    "ad_account_id" bigint,
    "campaign_id" character varying(255),
    "campaign_name" character varying(255),
    "campaign_category" character varying(255),
    "campaign_bid_strategy" character varying(255),
    "campaign_buying_type" character varying(255),
    "campaign_objective" character varying(255),
    "campaign_budget_remaining" character varying(255),
    "campaign_daily_budget" character varying(255),
    "campaign_lifetime_budget" character varying(255),
    "campaign_effective_status" character varying(255),
    "campaign_start_time" timestamp,
    "campaign_end_time" timestamp,
    "campaign_status" character varying(255),
    "campaign_insights_clicks" bigint,
    "campaign_insights_cpc" character varying(255),
    "campaign_insights_cpm" character varying(255),
    "campaign_insights_cpp" character varying(255),
    "campaign_insights_ctr" character varying(255),
    "campaign_insights_date_start" date,
    "campaign_insights_date_stop" date,
    "campaign_insights_impressions" character varying(255),
    "campaign_insights_spend" character varying(255),
    "campaign_insights_reach" bigint,
    "campaign_insights_results" double precision,
    "campaign_result_type" character varying(255),
    "campaign_insights_cost_per_result" double precision,
    "campaign_insights_actions" text,
    "createdat" timestamptz DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "updatedat" timestamptz DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT "idx_17095_primary" PRIMARY KEY ("id")
)
WITH (oids = false);


DROP TABLE IF EXISTS "compliance_policies";
DROP SEQUENCE IF EXISTS compliance_policies_id_seq;
CREATE SEQUENCE compliance_policies_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."compliance_policies" (
    "id" bigint DEFAULT nextval('compliance_policies_id_seq') NOT NULL,
    "policy_type" text NOT NULL,
    "content" text NOT NULL,
    "version" character varying(255) DEFAULT '1.0' NOT NULL,
    "effective_date" date NOT NULL,
    "active" smallint DEFAULT '1' NOT NULL,
    "updated_by" numeric,
    "created_at" timestamptz,
    "updated_at" timestamptz,
    CONSTRAINT "idx_17124_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE UNIQUE INDEX idx_17124_compliance_policies_policy_type_unique ON insocial_mysql.compliance_policies USING btree (policy_type);


DROP TABLE IF EXISTS "data_requests";
DROP SEQUENCE IF EXISTS data_requests_id_seq;
CREATE SEQUENCE data_requests_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."data_requests" (
    "id" bigint DEFAULT nextval('data_requests_id_seq') NOT NULL,
    "user_uuid" character varying(255) NOT NULL,
    "user_email" character varying(255) NOT NULL,
    "request_type" text DEFAULT 'export' NOT NULL,
    "status" text DEFAULT 'pending' NOT NULL,
    "notes" text,
    "completed_at" timestamptz,
    "processed_by" numeric,
    "created_at" timestamptz,
    "updated_at" timestamptz,
    CONSTRAINT "idx_17133_primary" PRIMARY KEY ("id")
)
WITH (oids = false);


DROP TABLE IF EXISTS "data_retention_rules";
DROP SEQUENCE IF EXISTS data_retention_rules_id_seq;
CREATE SEQUENCE data_retention_rules_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."data_retention_rules" (
    "id" bigint DEFAULT nextval('data_retention_rules_id_seq') NOT NULL,
    "data_type" character varying(255) NOT NULL,
    "retention_days" bigint NOT NULL,
    "auto_delete" smallint DEFAULT '0' NOT NULL,
    "last_cleanup_at" timestamptz,
    "active" smallint DEFAULT '1' NOT NULL,
    "created_at" timestamptz,
    "updated_at" timestamptz,
    CONSTRAINT "idx_17142_primary" PRIMARY KEY ("id")
)
WITH (oids = false);


DROP TABLE IF EXISTS "demographics";
DROP SEQUENCE IF EXISTS demographics_id_seq;
CREATE SEQUENCE demographics_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."demographics" (
    "id" bigint DEFAULT nextval('demographics_id_seq') NOT NULL,
    "user_uuid" character varying(255) NOT NULL,
    "platform_page_id" character varying(255) NOT NULL,
    "page_name" character varying(255) NOT NULL,
    "social_userid" character varying(255) NOT NULL,
    "platform" text DEFAULT 'NA' NOT NULL,
    "metric_type" character varying(200),
    "metric_key" character varying(250),
    "metric_value" bigint DEFAULT '0' NOT NULL,
    "source" text DEFAULT 'NA' NOT NULL,
    "createdat" timestamptz DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "updatedat" timestamptz DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT "idx_17149_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

INSERT INTO "demographics" ("id", "user_uuid", "platform_page_id", "page_name", "social_userid", "platform", "metric_type", "metric_key", "metric_value", "source", "createdat", "updatedat") VALUES
(2322,	'e5266555-8859-4f96-bab0-6596b9736d94',	'108458993',	'insocialwise.com',	'eRLsKrw_6N',	'linkedin',	'industry',	'Software Development',	2,	'API',	'2025-10-22 09:26:59+00',	'2025-10-22 09:26:59+00'),
(2323,	'e5266555-8859-4f96-bab0-6596b9736d94',	'108458993',	'insocialwise.com',	'eRLsKrw_6N',	'linkedin',	'geo',	'INDIA',	2,	'API',	'2025-10-22 09:26:59+00',	'2025-10-22 09:26:59+00'),
(2324,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'IT Services and IT Consulting',	170,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2325,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Advertising Services',	74,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2326,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Software Development',	72,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2327,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'IT System Custom Software Development',	46,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2328,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Marketing Services',	44,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2329,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Technology, Information and Internet',	42,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2330,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Business Consulting and Services',	32,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2331,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Higher Education',	18,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2332,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Graphic Design',	13,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2333,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Internet Publishing',	11,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2334,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Financial Services',	10,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2335,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Real Estate',	9,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2336,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Wellness and Fitness Services',	9,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2337,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Hospitals and Health Care',	8,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2338,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Education',	7,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2339,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Outsourcing and Offshoring Consulting',	7,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2340,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Staffing and Recruiting',	6,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2341,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Information Services',	6,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2342,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Education Administration Programs',	6,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2343,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Research Services',	6,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2344,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'E-Learning Providers',	6,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2345,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Mining',	5,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2346,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Investment Management',	5,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2347,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Accounting',	5,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2348,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Construction',	5,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2349,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Travel Arrangements',	5,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2350,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Professional Training and Coaching',	5,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2351,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Retail',	5,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2352,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Retail Apparel and Fashion',	5,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2353,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Computer Networking Products',	5,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2354,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Banking',	4,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2355,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Non-profit Organizations',	4,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2356,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Medical Practices',	4,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2357,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Internet Marketplace Platforms',	4,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2358,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Media Production',	4,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2359,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Hospitality',	4,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2360,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Mobile Gaming Apps',	3,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2361,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Legal Services',	3,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2362,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Consumer Services',	3,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2363,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Manufacturing',	3,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2364,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Telecommunications',	3,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2365,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Personal Care Product Manufacturing',	3,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2366,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Market Research',	3,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2367,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Airlines and Aviation',	3,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2368,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Insurance',	3,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2369,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Events Services',	3,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2370,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'IT System Testing and Evaluation',	3,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2371,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Food and Beverage Services',	3,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2372,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Restaurants',	3,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2373,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Business Intelligence Platforms',	2,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2374,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Biotechnology Research',	2,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2375,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Social Networking Platforms',	2,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2376,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Motor Vehicle Manufacturing',	2,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2377,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Food and Beverage Manufacturing',	2,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2378,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Writing and Editing',	2,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2379,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Design Services',	2,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2380,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Public Relations and Communications Services',	2,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2381,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Telecommunications Carriers',	2,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2382,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Translation and Localization',	2,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2383,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Truck Transportation',	2,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2384,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Individual and Family Services',	2,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2385,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Engineering Services',	2,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2386,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Retail Luxury Goods and Jewelry',	2,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2387,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Digital Accessibility Services',	2,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2388,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Solar Electric Power Generation',	2,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2389,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Book and Periodical Publishing',	2,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2390,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Hospitals',	2,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2391,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Pharmaceutical Manufacturing',	2,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2392,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Human Resources Services',	2,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2393,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'IT System Training and Support',	2,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2394,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Primary and Secondary Education',	2,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2395,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Computer and Network Security',	2,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2396,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Online Audio and Video Media',	2,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2397,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'IT System Design Services',	2,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2398,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Transportation, Logistics, Supply Chain and Storage',	2,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2399,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Broadcast Media Production and Distribution',	2,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2400,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Retail Office Equipment',	2,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2401,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Food and Beverage Retail',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2402,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Technology, Information and Media',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2403,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Oil and Gas',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2404,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Business Content',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2405,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Furniture and Home Furnishings Manufacturing',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2406,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Machinery Manufacturing',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2407,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Public Health',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2408,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Appliances, Electrical, and Electronics Manufacturing',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2409,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Computers and Electronics Manufacturing',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2410,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Internet News',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2411,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Civil Engineering',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2412,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Cable and Satellite Programming',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2413,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Architecture and Planning',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2414,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Fashion Accessories Manufacturing',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2415,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Wholesale Building Materials',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2416,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Strategic Management Services',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2417,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Radio and Television Broadcasting',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2418,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Maritime Transportation',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2419,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Motor Vehicle Parts Manufacturing',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2420,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Law Practice',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2421,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Civic and Social Organizations',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2422,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Professional Services',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2423,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'industry',	'Computer Games',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2424,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'geo',	'INDIA',	736,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2425,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'geo',	'UNITED STATES',	35,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2426,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'geo',	'UNITED ARAB EMIRATES',	13,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2427,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'geo',	'UNITED KINGDOM',	12,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2428,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'geo',	'PAKISTAN',	8,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2429,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'geo',	'EGYPT',	6,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2430,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'geo',	'NIGERIA',	5,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2431,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'geo',	'BANGLADESH',	4,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2432,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'geo',	'CANADA',	3,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2433,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'geo',	'FRANCE',	2,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2434,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'geo',	'PHILIPPINES',	2,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2435,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'geo',	'AUSTRALIA',	2,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2436,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'geo',	'ARGENTINA',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2437,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'geo',	'LEBANON',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2438,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'geo',	'TÜRKIYE',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2439,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'geo',	'MALAWI',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2440,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'geo',	'GHANA',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2441,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'geo',	'INDONESIA',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2442,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'geo',	'ECUADOR',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2443,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'geo',	'MALAYSIA',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2444,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'geo',	'SUDAN',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2445,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'geo',	'VENEZUELA',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2446,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'geo',	'GERMANY',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2447,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'geo',	'CAMBODIA',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2448,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'geo',	'TUNISIA',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00'),
(2449,	'e5266555-8859-4f96-bab0-6596b9736d94',	'75609893',	'Aronasoft',	'eRLsKrw_6N',	'linkedin',	'geo',	'LITHUANIA',	1,	'API',	'2025-10-22 09:29:11+00',	'2025-10-22 09:29:11+00');

DROP TABLE IF EXISTS "inbox_conversations";
DROP SEQUENCE IF EXISTS inbox_conversations_id_seq;
CREATE SEQUENCE inbox_conversations_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."inbox_conversations" (
    "id" bigint DEFAULT nextval('inbox_conversations_id_seq') NOT NULL,
    "user_uuid" character varying(250) NOT NULL,
    "social_userid" character varying(200) NOT NULL,
    "social_pageid" character varying(250) NOT NULL,
    "social_platform" text DEFAULT 'NA' NOT NULL,
    "conversation_id" character varying(200) NOT NULL,
    "external_userid" character varying(200) NOT NULL,
    "external_username" character varying(200),
    "external_userimg" character varying(250),
    "snippet" character varying(250) NOT NULL,
    "status" text DEFAULT 'InActive' NOT NULL,
    "createdat" timestamptz DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "updatedat" timestamptz DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT "idx_17163_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

INSERT INTO "inbox_conversations" ("id", "user_uuid", "social_userid", "social_pageid", "social_platform", "conversation_id", "external_userid", "external_username", "external_userimg", "snippet", "status", "createdat", "updatedat") VALUES
(268,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	't_122157012044577012',	'10067541213280817',	'Ross Singh',	NULL,	'hello admin user',	'Active',	'2025-12-04 10:18:12+00',	'2025-12-04 10:18:12+00'),
(269,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	't_3910484659264407',	'30023231430625587',	'Manjeet Singh',	NULL,	'Hi',	'Active',	'2025-12-04 12:50:27+00',	'2025-12-04 12:50:27+00'),
(270,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	't_122146872602860722',	'25374944125442357',	'Abhi Massey',	NULL,	'Abhi bumped their message',	'Active',	'2025-12-04 12:50:54+00',	'2025-12-04 12:50:54+00'),
(271,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	't_4434236870195991',	'9825514350861008',	'Andy Mehra',	NULL,	'Hello! How can I help you today?',	'Active',	'2025-12-04 12:51:08+00',	'2025-12-04 12:51:08+00'),
(272,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	't_1892630394834228',	'30911796315085868',	'Manjeet Pawar',	NULL,	'Fine',	'Active',	'2025-12-04 12:51:35+00',	'2025-12-04 12:51:35+00'),
(273,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	't_24102016736093261',	'30872767489038145',	'Facebook user',	NULL,	'𝗣𝗹𝗲𝗮𝘀𝗲 𝗿𝗲𝗳𝗲𝗿 𝘁𝗼 𝘁𝗵𝗲 𝗽𝗿𝗶𝘃𝗮𝗰𝘆 𝗽𝗼𝗹𝗶𝗰𝘆 𝗮𝘁:
🔗 https://transparency.meta.com/enforcement/detecting-violations/

 𝗧𝗼 𝗰𝗼𝗻𝘁𝗶𝗻𝘂𝗲 𝘂𝘀𝗶𝗻𝗴 𝘁𝗵𝗲 𝗳𝘂𝗹𝗹 𝗳𝘂𝗻𝗰𝘁𝗶𝗼𝗻𝘀, 𝗽𝗹𝗲𝗮𝘀𝗲 𝘃𝗶𝘀𝗶𝘁 𝗮𝗻𝗱 𝘃𝗲𝗿𝗶𝗳𝘆 𝗮𝘁 𝘁𝗵𝗲 𝗳𝗼𝗹𝗹𝗼𝘄𝗶𝗻𝗴 𝗹𝗶𝗻𝗸: https://manager-chaneup8237.site/verify?Community-Standard',	'Active',	'2025-12-04 12:52:02+00',	'2025-12-04 12:52:02+00'),
(274,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	't_2804302883292635',	'9043735502401398',	'Aronasoft Singh',	NULL,	'Hello! How can I assist you today with our pet waste removal services?',	'Active',	'2025-12-04 12:52:06+00',	'2025-12-04 12:52:06+00'),
(275,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	't_24093556453615214',	'24218504404439439',	'Sudhir Kundal',	NULL,	'I amnfine',	'Active',	'2025-12-04 12:52:17+00',	'2025-12-04 12:52:17+00');

DROP TABLE IF EXISTS "inbox_messages";
DROP SEQUENCE IF EXISTS inbox_messages_id_seq;
CREATE SEQUENCE inbox_messages_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."inbox_messages" (
    "id" bigint DEFAULT nextval('inbox_messages_id_seq') NOT NULL,
    "conversation_id" character varying(200) NOT NULL,
    "platform_message_id" character varying(200) NOT NULL,
    "sender_type" text DEFAULT 'page' NOT NULL,
    "message_text" text NOT NULL,
    "message_type" character varying(250) NOT NULL,
    "is_read" text DEFAULT 'yes',
    "timestamp" character varying(200),
    "createdat" timestamptz DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "updatedat" timestamptz DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT "idx_17176_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

COMMENT ON COLUMN "insocial_mysql"."inbox_messages"."sender_type" IS '"page"||"visitor"';

INSERT INTO "inbox_messages" ("id", "conversation_id", "platform_message_id", "sender_type", "message_text", "message_type", "is_read", "timestamp", "createdat", "updatedat") VALUES
(5304,	't_122157012044577012',	'm_r7cmTTjJOFuVWlHqjFuZU_wzY8SyzSvW-gyDnDxZJOPPNY-GhWTejKKa9zsdUL2UhFaq85AhWfjnBKo8IhFGuw',	'visitor',	'hello admin user',	'text',	'yes',	'2025-07-01T11:15:53+0000',	'2025-12-04 10:18:14+00',	'2025-12-04 10:18:14+00'),
(5305,	't_122157012044577012',	'm_e4p-8JsD-fTHiun9IPG0O_wzY8SyzSvW-gyDnDxZJOMFEFNnfxjLD9pYQcXA4At_INnrVKcFTxLLNjHsoh0Hsw',	'visitor',	'Hello admin',	'text',	'yes',	'2025-07-01T11:15:31+0000',	'2025-12-04 10:18:15+00',	'2025-12-04 10:18:15+00'),
(5306,	't_122157012044577012',	'm_bjtR3X1oTm1j977UMK0A0fwzY8SyzSvW-gyDnDxZJON4MRHWS4AsI_8wEJJIncuJIyQ6yI4L7pkzpB-5JnxQNQ',	'visitor',	'Hope you doing well.',	'text',	'yes',	'2025-06-30T13:52:26+0000',	'2025-12-04 10:18:16+00',	'2025-12-04 10:18:16+00'),
(5307,	't_122157012044577012',	'm_HNNuSL-LU1jdV9UhIG2WWvwzY8SyzSvW-gyDnDxZJOPiIw4hGw6KUvxWOldUCUcdU9Rx_HdOaFKQZTBY_xZTSQ',	'visitor',	'Hi Admin',	'text',	'yes',	'2025-06-30T13:52:20+0000',	'2025-12-04 10:18:17+00',	'2025-12-04 10:18:17+00'),
(5308,	't_122157012044577012',	'm_f_MQEcOzt7oTIadi3122A_wzY8SyzSvW-gyDnDxZJOO3hQDTjjCTzzcyPjzhPyH2gkb-QReOty_l_l7mLmwd6g',	'visitor',	'Yes I can.',	'text',	'yes',	'2025-06-30T11:51:04+0000',	'2025-12-04 10:18:18+00',	'2025-12-04 10:18:18+00'),
(5309,	't_122157012044577012',	'm_J9nW9QJbUN_Y3uKzWpzn7_wzY8SyzSvW-gyDnDxZJON31gq6oLWwcXq7V4hbL8BQTPQCFIh2eaHpfQuKxiZdQA',	'page',	'Can you see messages?',	'text',	'yes',	'2025-06-30T08:36:11+0000',	'2025-12-04 10:18:19+00',	'2025-12-04 10:18:19+00'),
(5310,	't_122157012044577012',	'm_AuIvjOWuHCdgDI1bqEHVfPwzY8SyzSvW-gyDnDxZJOOo7zpGowKl_sp82tlAzAOr2f3vPlji6QqbYaYo0m5Y4w',	'page',	'Hey ross singh',	'text',	'yes',	'2025-06-30T08:34:02+0000',	'2025-12-04 10:18:20+00',	'2025-12-04 10:18:20+00'),
(5311,	't_122157012044577012',	'm_i8cRnmYTogugqn_rCVm2k_wzY8SyzSvW-gyDnDxZJONGkMADnxYzc6Eh0Mqy2rxIpay5YZqZTKZIYvyo9gQ2gw',	'page',	'Hello user 34',	'text',	'yes',	'2025-06-30T08:14:49+0000',	'2025-12-04 10:18:21+00',	'2025-12-04 10:18:21+00'),
(5312,	't_122157012044577012',	'm_eVLz3L4Y7JF3kv8fZr08TfwzY8SyzSvW-gyDnDxZJOPHZwYZ90lKrvZSerqm9iCDdR2AMI4XaO88Nw285whmnw',	'page',	'Cant message if you, If I saw your message after 24 hours.',	'text',	'yes',	'2025-06-30T08:02:07+0000',	'2025-12-04 10:18:22+00',	'2025-12-04 10:18:22+00'),
(5313,	't_122157012044577012',	'm_6h0vNjmRaz70_48BF1W3A_wzY8SyzSvW-gyDnDxZJOOY2itYCpw4Ef7YOZStwkkO4pCR2ePOg4n9vkCBANCj2Q',	'page',	'How r u?',	'text',	'yes',	'2025-06-30T07:51:13+0000',	'2025-12-04 10:18:23+00',	'2025-12-04 10:18:23+00'),
(5314,	't_122157012044577012',	'm_OnxLUYr3Y9VsxsUbTAOsX_wzY8SyzSvW-gyDnDxZJOMtskDzoBh-ELjCWMfOfBnkEu-uxl4ArHxCkVX92os9RQ',	'page',	'Hello Ross, Good to see you.',	'text',	'yes',	'2025-06-30T07:46:53+0000',	'2025-12-04 10:18:24+00',	'2025-12-04 10:18:24+00'),
(5315,	't_122157012044577012',	'm_hcfwShQKmFFZGb1YGCz3OfwzY8SyzSvW-gyDnDxZJON6MjckMpHZi0phtdute8j3kK6xiszXlE7gxR-98CfU2w',	'visitor',	'Hello admin',	'text',	'yes',	'2025-06-30T07:46:00+0000',	'2025-12-04 10:18:25+00',	'2025-12-04 10:18:25+00'),
(5316,	't_122157012044577012',	'm_fCCPPXp95klg08zJUSziuPwzY8SyzSvW-gyDnDxZJOMf-8F8hm2IIIgwT67-aMO_Awin0MxCEp5xuG5gK9kI1w',	'page',	'Hi Ross',	'text',	'yes',	'2025-06-27T08:28:09+0000',	'2025-12-04 10:18:26+00',	'2025-12-04 10:18:26+00'),
(5317,	't_122157012044577012',	'm_2YTGTNL7KwwcCNnjebGVpvwzY8SyzSvW-gyDnDxZJOOY9dE15iGMtHTKM9MRrsMWKaQ5sDbn-0ZKdLShCG8TQg',	'visitor',	'Ross here',	'text',	'yes',	'2025-06-27T07:56:55+0000',	'2025-12-04 10:18:27+00',	'2025-12-04 10:18:27+00'),
(5318,	't_122157012044577012',	'm_tOTL0r5Gjxx-zzK3ER4fnPwzY8SyzSvW-gyDnDxZJOMGBl4M2CMLmhLm6yb9mnF8sisNHa0lsnTPzxk0RgeIoA',	'visitor',	'Hello',	'text',	'yes',	'2025-06-27T07:56:53+0000',	'2025-12-04 10:18:28+00',	'2025-12-04 10:18:28+00'),
(5319,	't_3910484659264407',	'm_hcDpROP-sEEMN6hzy-dEeBhzQSVLdgqqtafs2aaIipsHDh0ru7AWeqfSJbMlfKRnq9fi5f4t81QZ8sdQwte7Jw',	'visitor',	'Hi',	'text',	'yes',	'2025-12-04T06:06:17+0000',	'2025-12-04 12:50:29+00',	'2025-12-04 12:50:29+00'),
(5320,	't_3910484659264407',	'm_4LX9W5c-fLF7syRJnwkDehhzQSVLdgqqtafs2aaIipsF5okgeYYBx45mEOyQmCjcpmhcC7Pdp-Hgr1N8EanhGg',	'visitor',	'Hello',	'text',	'yes',	'2025-12-01T11:08:20+0000',	'2025-12-04 12:50:30+00',	'2025-12-04 12:50:30+00'),
(5321,	't_3910484659264407',	'm_Fyi94qWlxCnW4bohTX4GehhzQSVLdgqqtafs2aaIipsM7zw7vr40XXtJosWSSngLsd1MgrHYkDmnDO0cCuuuvg',	'visitor',	'Hello admin?',	'text',	'yes',	'2025-12-01T11:04:50+0000',	'2025-12-04 12:50:31+00',	'2025-12-04 12:50:31+00'),
(5322,	't_3910484659264407',	'm_PFmwd9ijmtTD3AwBbbVWqBhzQSVLdgqqtafs2aaIipuwjVGnTheinLZhLxhGKapiEyyD2iojHsPjzrZ_xfnIag',	'visitor',	'Can you see message?',	'text',	'yes',	'2025-12-01T11:02:20+0000',	'2025-12-04 12:50:32+00',	'2025-12-04 12:50:32+00'),
(5323,	't_3910484659264407',	'm_JAAi0_l1cPkmd-QnwMA4PhhzQSVLdgqqtafs2aaIipuSVlstmdNGAaRQBiykHlVD9F1wF1hw9xyJMy1euThsmQ',	'visitor',	'Hi',	'text',	'yes',	'2025-12-01T11:00:08+0000',	'2025-12-04 12:50:33+00',	'2025-12-04 12:50:33+00'),
(5324,	't_3910484659264407',	'm_9C7ev_m42ENjzySNEBpsEBhzQSVLdgqqtafs2aaIipuZg0H8DKbSPkhBur6HWf2y_L7fgALYVzdeXSmrVVbRrw',	'visitor',	'Hello admin',	'text',	'yes',	'2025-12-01T10:58:37+0000',	'2025-12-04 12:50:34+00',	'2025-12-04 12:50:34+00'),
(5325,	't_3910484659264407',	'm_CPMrvSOP2KIvR5hJSjj4GRhzQSVLdgqqtafs2aaIipsxLPvzY4vevcvy-XTur44dd7beNO3tpDnQk-iO-xm04Q',	'visitor',	'Hi',	'text',	'yes',	'2025-12-01T10:52:16+0000',	'2025-12-04 12:50:35+00',	'2025-12-04 12:50:35+00'),
(5326,	't_3910484659264407',	'm_GcYHJwsb0nhbHLLNmalTFhhzQSVLdgqqtafs2aaIipuz44n81fkrxhOV8rNkQUCzJy6m9it__wxym5PNRirE2A',	'page',	'Hello! How can I assist you today?',	'text',	'yes',	'2025-11-07T11:45:42+0000',	'2025-12-04 12:50:36+00',	'2025-12-04 12:50:36+00'),
(5327,	't_3910484659264407',	'm_fHcc5tVBVh4MbE09jyBV7RhzQSVLdgqqtafs2aaIipt0KEoBIAz5PyD2y8xs83EYJ1FhFiuVf683ExM3kzzLKA',	'visitor',	'Hello',	'text',	'yes',	'2025-11-07T11:45:32+0000',	'2025-12-04 12:50:37+00',	'2025-12-04 12:50:37+00'),
(5328,	't_3910484659264407',	'm_RIJxuL5Mr6rMUabOuE6qURhzQSVLdgqqtafs2aaIipu9RkmqDSl0Me-qn0iBgq7qGKM9h1QhTOSF5pSQC6agPA',	'page',	'Hello! How can I help you today?',	'text',	'yes',	'2025-11-06T11:31:26+0000',	'2025-12-04 12:50:38+00',	'2025-12-04 12:50:38+00'),
(5329,	't_3910484659264407',	'm_UbDomzFEfRxWllWMAlQjCBhzQSVLdgqqtafs2aaIipsIYzavldOGMHk8gdPAvSIPLJtGzb63EOI6GsClOw6H4Q',	'visitor',	'Hello',	'text',	'yes',	'2025-11-06T11:31:17+0000',	'2025-12-04 12:50:39+00',	'2025-12-04 12:50:39+00'),
(5330,	't_3910484659264407',	'm_9T3CfDxbn8TpbNalsBFhDxhzQSVLdgqqtafs2aaIipugqMSvFdeh4iKajJwhbFyFGijxXKuzYUhCl43s3M_drQ',	'page',	'Hi there! How can I help you today?',	'text',	'yes',	'2025-11-05T11:25:34+0000',	'2025-12-04 12:50:40+00',	'2025-12-04 12:50:40+00'),
(5331,	't_3910484659264407',	'm_jq_m4CFFfqz6cYKPPbOylBhzQSVLdgqqtafs2aaIipvBK5mcmVg5q51cTMgrBOz5cOHHhGPI0IaxjpLBIgls2A',	'visitor',	'Hi',	'text',	'yes',	'2025-11-05T11:25:21+0000',	'2025-12-04 12:50:41+00',	'2025-12-04 12:50:41+00'),
(5332,	't_3910484659264407',	'm_VgA_vNi2x4VK0TDnyJx6tRhzQSVLdgqqtafs2aaIiptCVb9G1LgnvllN5BWWUS3NNavBotI2AxHqaZd2GAoAHQ',	'page',	'Hello',	'text',	'yes',	'2025-11-05T11:24:58+0000',	'2025-12-04 12:50:42+00',	'2025-12-04 12:50:42+00'),
(5333,	't_3910484659264407',	'm_kWOOZLAuEQhvqAJ-IeoESBhzQSVLdgqqtafs2aaIipv74yScjlQRula4YICYot_wylI56xnHbufVWpToaZQHmw',	'page',	'A lookalike audience is created using Pixel data to build targeted ad campaigns for a higher return on investment.',	'text',	'yes',	'2025-11-04T13:01:47+0000',	'2025-12-04 12:50:43+00',	'2025-12-04 12:50:43+00'),
(5334,	't_3910484659264407',	'm_fL0Xk53Sa5SxseSZ_G6dpRhzQSVLdgqqtafs2aaIipved8fyfDT0AJ-p2a7xHnSchBOiNiRxhdiyeNzRV3AJ3g',	'visitor',	'What is a lookalike audiences?',	'text',	'yes',	'2025-11-04T13:01:36+0000',	'2025-12-04 12:50:44+00',	'2025-12-04 12:50:44+00'),
(5335,	't_3910484659264407',	'm_vvYuNbjyKMegZ-0T_Lod4RhzQSVLdgqqtafs2aaIiptsEVkZWZT6ZxwsiWt9vs1E3EjnoQu3dMmR1tmGJLP1Ug',	'page',	'To fix social login errors, ensure Two-Factor Authentication (2FA) is enabled on the connecting account, verify correct permissions, and check for non-Latin characters in product names. Additionally, troubleshoot third-party social login plugin issues by checking App IDs/Secrets, permalink structure, and conflicts with caching plugins. Ensure your host allows outgoing cURL requests and that Permalinks are enabled.',	'text',	'yes',	'2025-11-04T13:00:06+0000',	'2025-12-04 12:50:45+00',	'2025-12-04 12:50:45+00'),
(5336,	't_3910484659264407',	'm_T--80dAIbZi6-DHdLXqdZhhzQSVLdgqqtafs2aaIipuDi8YAgomfIqIzKo_VjTTYTvVGJE1PnsBxsJxSdO1_kQ',	'visitor',	'How to fix social login errors?',	'text',	'yes',	'2025-11-04T12:59:51+0000',	'2025-12-04 12:50:46+00',	'2025-12-04 12:50:46+00'),
(5337,	't_3910484659264407',	'm_pN9uF0aAGZQUmycIABnBfRhzQSVLdgqqtafs2aaIipttYzhHIrYdqXdeluvpovZmOCN_u9sNkYc1xyY37U17-A',	'page',	'To set up Instagram shopping, first, you need to connect your WooCommerce store to Meta (Facebook & Instagram Shop) by installing the "Facebook for WooCommerce" plugin. Then, connect your Facebook account, select your Business Manager, and create or sync your Meta Product Catalog. After these steps, ensure your Instagram Business Profile meets the eligibility requirements and submit it for review to enable Instagram Shopping Tags.',	'text',	'yes',	'2025-11-04T12:58:38+0000',	'2025-12-04 12:50:47+00',	'2025-12-04 12:50:47+00'),
(5338,	't_3910484659264407',	'm_oY45DhaD4yauT1y9Num4cRhzQSVLdgqqtafs2aaIipuTUVrNGpzsBZj2H8qO2GNivdMJo_bMNVhfkpLqR_Gx2A',	'visitor',	'How do I setup Instagram shopping?',	'text',	'yes',	'2025-11-04T12:58:24+0000',	'2025-12-04 12:50:48+00',	'2025-12-04 12:50:48+00'),
(5339,	't_3910484659264407',	'm_YcgbLzxYsv1KeOKIOHUPpRhzQSVLdgqqtafs2aaIipuigmZs9CLvLhBbB7GAScL8074wRrn2-XOjQREMdEtGTQ',	'page',	'Hello! How can I help you today?',	'text',	'yes',	'2025-11-04T12:57:33+0000',	'2025-12-04 12:50:49+00',	'2025-12-04 12:50:49+00'),
(5340,	't_3910484659264407',	'm_n64s20tE4zloa2XELDP1FBhzQSVLdgqqtafs2aaIipvwUSW9BGxTotUYaLtFH_FrHFQJkGiR0XYKp1XdSiPJbA',	'visitor',	'Hello',	'text',	'yes',	'2025-11-04T12:57:25+0000',	'2025-12-04 12:50:50+00',	'2025-12-04 12:50:50+00'),
(5341,	't_3910484659264407',	'm_LbWq8i-SFGB9T-uHkTIB1xhzQSVLdgqqtafs2aaIiptiT75bQaF2ONdFw8D3q8LtfBjx8XVDZhw2PnflNjQs9A',	'page',	'To invite collaborators, please refer to the article "How to Create a New Project and Invite Collaborators" in the product documentation. I do not have specific information regarding what roles should be assigned to new teammates.',	'text',	'yes',	'2025-11-04T12:37:22+0000',	'2025-12-04 12:50:51+00',	'2025-12-04 12:50:51+00'),
(5342,	't_3910484659264407',	'm_kZEgfnwT7kzltWvE62zABxhzQSVLdgqqtafs2aaIipv7LbxLug10IwmVeOJUPyKhYO4EL2t2_jcM9ynhHXqXfQ',	'visitor',	'How do I invite a new teammate to my project, and what role should I assign them?',	'text',	'yes',	'2025-11-04T12:37:10+0000',	'2025-12-04 12:50:52+00',	'2025-12-04 12:50:52+00'),
(5343,	't_3910484659264407',	'm_jNmLdCKUThzoR0oBNr4ihxhzQSVLdgqqtafs2aaIipv-ctYjhzLqbTAwyipaSes4uyxNyfahUvX6G91pql0ixw',	'page',	'Hello! How can I help you today?',	'text',	'yes',	'2025-11-04T12:32:32+0000',	'2025-12-04 12:50:53+00',	'2025-12-04 12:50:53+00'),
(5344,	't_122146872602860722',	'm_5LvsdhV0C173xxYkoAKgTm_grOqO3NWBRJ7Xc2GwTPxeL2_FT2gvmXCVnOWMc-I4dvQFhqaVeDNKl62u6y4ZZg',	'visitor',	'Get started',	'text',	'yes',	'2025-11-16T17:20:11+0000',	'2025-12-04 12:50:55+00',	'2025-12-04 12:50:55+00'),
(5345,	't_122146872602860722',	'm_EMYdD2nQ2eYXM_85pDTrd2_grOqO3NWBRJ7Xc2GwTPz6rftyfN-JV9lEnbr0HNmTR0cuK0rY2hps7ojKNwt6XA',	'page',	'Heello',	'text',	'yes',	'2025-11-07T12:18:42+0000',	'2025-12-04 12:50:56+00',	'2025-12-04 12:50:56+00'),
(5346,	't_122146872602860722',	'm_Tha65UUlIGT6AStLzjGG1m_grOqO3NWBRJ7Xc2GwTPyYDqHOHHGQzwPbvJNvveHuPEpHz4L9NCcf6mQQuE6c3g',	'visitor',	'',	'text',	'yes',	'2025-11-07T12:00:00+0000',	'2025-12-04 12:50:57+00',	'2025-12-04 12:50:57+00'),
(5347,	't_122146872602860722',	'm_dvedyXJckYTe918f5-EEm2_grOqO3NWBRJ7Xc2GwTPz7e0YHFnAEh3pyHsuVcibWIsyQE7XVbDtN6482AlWYyA',	'page',	'I don''t have enough information to answer that query. My knowledge base focuses on connecting WooCommerce stores to Facebook and Instagram for business purposes.',	'text',	'yes',	'2025-11-07T11:59:18+0000',	'2025-12-04 12:50:58+00',	'2025-12-04 12:50:58+00'),
(5348,	't_122146872602860722',	'm_Q9sl_qCBsDbeOnRMYahss2_grOqO3NWBRJ7Xc2GwTPzQgqB5tE256oWI1KbzOdH6LgQtu0Y-hKC3h7nFQ8-o2w',	'visitor',	'How we can connect Facebook personal account',	'text',	'yes',	'2025-11-07T11:59:07+0000',	'2025-12-04 12:50:59+00',	'2025-12-04 12:50:59+00'),
(5349,	't_122146872602860722',	'm_HI7_UzkYjGtMdniFaCdsZW_grOqO3NWBRJ7Xc2GwTPybVB_yfBdhtB3pXyE0Y103NKcmQ_UsYHyqbhTwhIl4RA',	'page',	'I am an AI assistant and do not have feelings. How can I help you with information about our software solutions?',	'text',	'yes',	'2025-11-07T11:58:28+0000',	'2025-12-04 12:51:01+00',	'2025-12-04 12:51:01+00'),
(5350,	't_122146872602860722',	'm_gyg4NMYS1xOX4tB5jd0PaW_grOqO3NWBRJ7Xc2GwTPwsMciM_uqNtLNh327b6e67mWQVqzZ20PFwusnL97CTuA',	'visitor',	'How are you webonx',	'text',	'yes',	'2025-11-07T11:58:22+0000',	'2025-12-04 12:51:02+00',	'2025-12-04 12:51:02+00'),
(5351,	't_122146872602860722',	'm_OOIvs7T_d6z8Kuj18MUg-m_grOqO3NWBRJ7Xc2GwTPyODLv-bV4NBATUlcSaTXpDfGJrEY8WQVR_7hB9TiMTFw',	'visitor',	'',	'text',	'yes',	'2025-11-07T11:58:14+0000',	'2025-12-04 12:51:03+00',	'2025-12-04 12:51:03+00'),
(5352,	't_122146872602860722',	'm_XLQeApj5FlBNDl53m59orW_grOqO3NWBRJ7Xc2GwTPx52b3bAiiFAcUjA26GwE65h39jkufP-A9GmIAAvx_jBA',	'page',	'Hello! How can I help you today?',	'text',	'yes',	'2025-11-07T11:56:47+0000',	'2025-12-04 12:51:04+00',	'2025-12-04 12:51:04+00'),
(5353,	't_122146872602860722',	'm_OESSESJWh56SvhYnTkT1xm_grOqO3NWBRJ7Xc2GwTPy9ArXcCDIbRzVLMHtX-HBf76nqBjTAgy-9pKit-xrS1Q',	'visitor',	'Hello webonx',	'text',	'yes',	'2025-11-07T11:56:00+0000',	'2025-12-04 12:51:05+00',	'2025-12-04 12:51:05+00'),
(5354,	't_122146872602860722',	'm_-1jTVMJYwqzcJU-9AMUw-W_grOqO3NWBRJ7Xc2GwTPyk4ZhE5kzIbtp7Hpby7ExbtQy43GDNvoyjwt7NbMbIIA',	'visitor',	'',	'text',	'yes',	'2025-11-07T11:48:04+0000',	'2025-12-04 12:51:06+00',	'2025-12-04 12:51:06+00'),
(5355,	't_122146872602860722',	'm_E2nvi0UOcTTme0S4fg08Q2_grOqO3NWBRJ7Xc2GwTPzzbeX4tA1rAzHxpeZyAaU9SPJEUsl6HW7jIOe93Krivg',	'visitor',	'Hello webonx',	'text',	'yes',	'2025-11-07T11:47:45+0000',	'2025-12-04 12:51:07+00',	'2025-12-04 12:51:07+00'),
(5356,	't_122146872602860722',	'm_T4vNKd7lZX-G7gFk4GYEFW_grOqO3NWBRJ7Xc2GwTPylz_H5ee3LwRfqgtMK0zdgr6z3VlMqjnA_gyRRfm7lzQ',	'visitor',	'Get started',	'text',	'yes',	'2025-11-07T11:47:17+0000',	'2025-12-04 12:51:08+00',	'2025-12-04 12:51:08+00'),
(5357,	't_4434236870195991',	'm_nFxVMmGKr_f2ibZ8lyMux8mkDypFqAmNB5iTvX5h10y2yo9v_A4xVENHxSFhRleScwa7SX4gnXKg859uM4hreg',	'page',	'Hello! How can I help you today?',	'text',	'yes',	'2025-11-04T13:02:33+0000',	'2025-12-04 12:51:10+00',	'2025-12-04 12:51:10+00'),
(5358,	't_4434236870195991',	'm_rLnKt7i-56aPfsjS4BWX-MmkDypFqAmNB5iTvX5h10wSqAjxSl3zaH9vQq8Pj-OLQsHtn1dr33MJbxeDz3D5Tw',	'visitor',	'Hello',	'text',	'yes',	'2025-11-04T13:02:26+0000',	'2025-12-04 12:51:11+00',	'2025-12-04 12:51:11+00'),
(5359,	't_4434236870195991',	'm_9QrvXBEicRji0AeDeLi9KsmkDypFqAmNB5iTvX5h10wCK7k-FnFcTkly4xQKsAnQ7KkulPM1c2alFXQyKX_gPQ',	'page',	'Hi there! How can I help you today?',	'text',	'yes',	'2025-11-04T10:59:45+0000',	'2025-12-04 12:51:12+00',	'2025-12-04 12:51:12+00'),
(5360,	't_4434236870195991',	'm_dnokLVx0StxQWI6LMik4qMmkDypFqAmNB5iTvX5h10xBiuhEFhUcA0_fMuyvfHXTkic2Eh-pjGV1lHruj8kytw',	'visitor',	'Hi',	'text',	'yes',	'2025-11-04T10:59:38+0000',	'2025-12-04 12:51:13+00',	'2025-12-04 12:51:13+00'),
(5361,	't_4434236870195991',	'm_8mmpQ58kuvopSz6EnwlOz8mkDypFqAmNB5iTvX5h10yqy_gssrMyrvt751OGfD4UBmXcIwVG5F0zU1hTvL69hA',	'page',	'Hello andy sir 🍺🍻🥂🥃🍾🍾🍾🍾🍾🍻🍻🍻',	'text',	'yes',	'2025-11-04T10:59:04+0000',	'2025-12-04 12:51:14+00',	'2025-12-04 12:51:14+00'),
(5362,	't_4434236870195991',	'm_GZsMtFBVZIteB_riAhwo9cmkDypFqAmNB5iTvX5h10znD-PlyVQfFPD5ciunlyElVHu-jSPBbymdSVuL0TThCA',	'page',	'The product documentation covers Product Mastery & How-To Guides for everyday use, best practices, and standard workflows. It also includes Technical Troubleshooting & Support for issues, errors, compatibility, and solutions, as well as Company, Policies & Account Management for administrative and general inquiries.',	'text',	'yes',	'2025-11-04T10:55:22+0000',	'2025-12-04 12:51:15+00',	'2025-12-04 12:51:15+00'),
(5363,	't_4434236870195991',	'm_ciMuwm3BhVJ1etbasuiyzMmkDypFqAmNB5iTvX5h10xPRk825ZwVUIS6hCkRC5M93gmvqhidjt5beimIpzQIRw',	'visitor',	'Tell me about product',	'text',	'yes',	'2025-11-04T10:55:10+0000',	'2025-12-04 12:51:16+00',	'2025-12-04 12:51:16+00'),
(5364,	't_4434236870195991',	'm_NsYWcz0NG6VHC3otxTKqPMmkDypFqAmNB5iTvX5h10wAGH78coLueR16MPIIQv_dHId7rANNp2v43v5zk157cQ',	'page',	'For billing and subscription, you can find information on how to change your payment method or billing cycle, understand your invoice and subscription tiers, and learn about the cancellation and refund policy. These details are under the Company, Policies & Account Management section.',	'text',	'yes',	'2025-11-04T10:54:48+0000',	'2025-12-04 12:51:17+00',	'2025-12-04 12:51:17+00'),
(5365,	't_4434236870195991',	'm_LH4_u73gEFZofh5wEM3P1cmkDypFqAmNB5iTvX5h10yAPcmWOvwFDLUog4g1hiFlR65QQ1TMWb0ZYkglddYHJg',	'visitor',	'Tell me about billing and subscription',	'text',	'yes',	'2025-11-04T10:54:29+0000',	'2025-12-04 12:51:18+00',	'2025-12-04 12:51:18+00'),
(5366,	't_4434236870195991',	'm_viPhnCXvwzJ5vhBx9rqOWMmkDypFqAmNB5iTvX5h10yg0Up1uWTSg7GFBtjUEpZWcktdU4HPszKs4PAZg67E0A',	'page',	'Hi there! How can I help you today?',	'text',	'yes',	'2025-11-04T10:53:38+0000',	'2025-12-04 12:51:19+00',	'2025-12-04 12:51:19+00'),
(5367,	't_4434236870195991',	'm_Roe5Ts9Y6qHDnOw-Nsz81MmkDypFqAmNB5iTvX5h10xUooe4QcRJ-nHA9utYoGWmBRvs24W1QRRLRpXiAr6qHg',	'visitor',	'Hi',	'text',	'yes',	'2025-11-04T10:53:30+0000',	'2025-12-04 12:51:20+00',	'2025-12-04 12:51:20+00'),
(5368,	't_4434236870195991',	'm_RlOa6tr5e8lLh7x-z59xkcmkDypFqAmNB5iTvX5h10yKCyzfEKSU7efDYTjAM6zZ_3NpwSeaxSCoNlNOGBarfw',	'page',	'I do not have enough information to answer that query. Please let me know how I can help you.',	'text',	'yes',	'2025-11-04T10:37:48+0000',	'2025-12-04 12:51:21+00',	'2025-12-04 12:51:21+00'),
(5369,	't_4434236870195991',	'm_xOCWuoeedRvvpy6wTb8T_MmkDypFqAmNB5iTvX5h10wbyZ7y88zwCtGoBgHg7F0FiwKYyp1FDK5rjmc4RfG_Dw',	'visitor',	'Ok',	'text',	'yes',	'2025-11-04T10:37:39+0000',	'2025-12-04 12:51:22+00',	'2025-12-04 12:51:22+00'),
(5370,	't_4434236870195991',	'm_fwSYZ34OILokocFaxTh8gcmkDypFqAmNB5iTvX5h10z0V7qI87MmYv3hTF3JDcwuke6pC7FnIbRb_pLQaBsgVA',	'page',	'I don’t have enough information to answer that query.',	'text',	'yes',	'2025-11-04T10:37:24+0000',	'2025-12-04 12:51:23+00',	'2025-12-04 12:51:23+00'),
(5371,	't_4434236870195991',	'm_k_N7MBMb7PTSZT2kF3SxRMmkDypFqAmNB5iTvX5h10xSvDRL-r8f97J4534RR7Otq8iYI7UshB8CKI7WrSBK5Q',	'visitor',	'Tell me about AI technology',	'text',	'yes',	'2025-11-04T10:37:12+0000',	'2025-12-04 12:51:24+00',	'2025-12-04 12:51:24+00'),
(5372,	't_4434236870195991',	'm_0H2vnp39q0yKiZCBt2OMpsmkDypFqAmNB5iTvX5h10zstAHr1dK_jrNBmNKdvAcF08co4Lf6m5GzfMVlYdgcUg',	'page',	'Hi there! How can I help you today?',	'text',	'yes',	'2025-11-04T10:36:41+0000',	'2025-12-04 12:51:25+00',	'2025-12-04 12:51:25+00'),
(5373,	't_4434236870195991',	'm_jdikHcs5pC91Uo6_lk9LncmkDypFqAmNB5iTvX5h10zdceqQ1VdgwYP474Y08VszUVXfvdaIbBQWadV4BIghvg',	'visitor',	'Hi',	'text',	'yes',	'2025-11-04T10:36:31+0000',	'2025-12-04 12:51:26+00',	'2025-12-04 12:51:26+00'),
(5374,	't_4434236870195991',	'm_Cy6fNla16GtpqWqVlmHK98mkDypFqAmNB5iTvX5h10w7eaaBXwfxlYRbee-bRh5jGlN2AtRH2zjJP0GKFSVLhA',	'visitor',	'Hello boot',	'text',	'yes',	'2025-11-03T12:47:14+0000',	'2025-12-04 12:51:27+00',	'2025-12-04 12:51:27+00'),
(5375,	't_4434236870195991',	'm_EILhGAhQOYnomV-nppkx1MmkDypFqAmNB5iTvX5h10wGqz6ZDw4c9oWjEqY5mGrAEY43snW4ub9zgbeag2dkbw',	'visitor',	'There?',	'text',	'yes',	'2025-11-03T07:47:19+0000',	'2025-12-04 12:51:28+00',	'2025-12-04 12:51:28+00'),
(5376,	't_4434236870195991',	'm_rurPsyy7GKtbsUoLj_M2U8mkDypFqAmNB5iTvX5h10wWsIUu2PCYgjDi5jV1nv_gX6WbaBB2s6qAv6MNvn-b0Q',	'visitor',	'Hiii',	'text',	'yes',	'2025-11-03T07:43:12+0000',	'2025-12-04 12:51:29+00',	'2025-12-04 12:51:29+00'),
(5377,	't_4434236870195991',	'm_Ij3hObaBnAWJMK0q4NtCTcmkDypFqAmNB5iTvX5h10xYOHiDOhcaYPejRMWhzAusUfU7O8Oxo0WvjIK8xFGOyQ',	'visitor',	'Good morning',	'text',	'yes',	'2025-11-03T07:03:59+0000',	'2025-12-04 12:51:30+00',	'2025-12-04 12:51:30+00'),
(5378,	't_4434236870195991',	'm_dF04FeQuKxmEmz_DDgtRU8mkDypFqAmNB5iTvX5h10xZ5ZVmbw79UBUBs-Xp8fXSroCfRr1yOd-6J7cbdmDWVA',	'visitor',	'Hi',	'text',	'yes',	'2025-09-03T13:01:58+0000',	'2025-12-04 12:51:31+00',	'2025-12-04 12:51:31+00'),
(5379,	't_4434236870195991',	'm_8eAtMX7s3GNITX3fgnMrd8mkDypFqAmNB5iTvX5h10xxyozh5pN0cSXPGSDi-S2hR56QpDwPHTQ4DHvGaVIkSA',	'page',	'testing 2',	'text',	'yes',	'2025-08-18T12:28:41+0000',	'2025-12-04 12:51:32+00',	'2025-12-04 12:51:32+00'),
(5380,	't_4434236870195991',	'm_hInARUshrZYfQoE0-pS9G8mkDypFqAmNB5iTvX5h10yb5c7XX3zCHpLTeGINjUqPd-zLjm_liPn2fqzEvTFGJQ',	'page',	'new message',	'text',	'yes',	'2025-08-18T12:28:31+0000',	'2025-12-04 12:51:33+00',	'2025-12-04 12:51:33+00'),
(5381,	't_4434236870195991',	'm__XZcMqcXuiw8gTFvVU9kWsmkDypFqAmNB5iTvX5h10whVyuXuDGVk0imPDo0aeeVWVos7Ifu9tQWWMKX5CpxTw',	'page',	'byee',	'text',	'yes',	'2025-08-18T12:26:18+0000',	'2025-12-04 12:51:34+00',	'2025-12-04 12:51:34+00'),
(5382,	't_1892630394834228',	'm_osCq0x3egiWNCtaU-kMZafZSf7Go7C0AXzzwPPq7aFRSedbTtVCdYMhyAv_6XM7QmdALNi6CQUqw5WqJgSCWZg',	'visitor',	'Fine',	'text',	'yes',	'2025-10-03T06:44:35+0000',	'2025-12-04 12:51:37+00',	'2025-12-04 12:51:37+00'),
(5383,	't_1892630394834228',	'm_r5Er-IYKGtZ5QJRTfMWaJfZSf7Go7C0AXzzwPPq7aFTInDV-5gUvKm9zCjt549TLTBiXD7aeZ3X_PkYhD-K9Sw',	'page',	'how r u?',	'text',	'yes',	'2025-10-03T06:44:11+0000',	'2025-12-04 12:51:38+00',	'2025-12-04 12:51:38+00'),
(5384,	't_1892630394834228',	'm_ECNXTKZo3PUwNVOqIAE09PZSf7Go7C0AXzzwPPq7aFRnZtOChrTmYdla2AkcYmjSG7ZWrZceVHwBjCAbkZMXYA',	'page',	'hello madam',	'text',	'yes',	'2025-10-03T06:43:51+0000',	'2025-12-04 12:51:39+00',	'2025-12-04 12:51:39+00'),
(5385,	't_1892630394834228',	'm_WgtC3YAs1DrRZ3w4NFJs3fZSf7Go7C0AXzzwPPq7aFT6a14_HV2Ak2ox7a2djs7BDj0E3VeYssOYxPEIEFnSJw',	'visitor',	'Hey',	'text',	'yes',	'2025-10-03T06:43:20+0000',	'2025-12-04 12:51:40+00',	'2025-12-04 12:51:40+00'),
(5386,	't_1892630394834228',	'm_31-GhAiFRlgRWn7Sg4610PZSf7Go7C0AXzzwPPq7aFRj8BUzErAgaAJoNW4bIVP7fpnfs9ALOInmop74B4tpRw',	'visitor',	'Hey',	'text',	'yes',	'2025-07-03T11:34:30+0000',	'2025-12-04 12:51:41+00',	'2025-12-04 12:51:41+00'),
(5387,	't_1892630394834228',	'm_27AAFFpSA6cjULjss_bgwfZSf7Go7C0AXzzwPPq7aFSRDt4AdAxcVhj4wT3_qbJFwKJ3I4R1y6q3q5hyajB9Ng',	'visitor',	'Why are u not replying',	'text',	'yes',	'2025-07-03T11:34:23+0000',	'2025-12-04 12:51:42+00',	'2025-12-04 12:51:42+00'),
(5388,	't_1892630394834228',	'm_eObznkwlIab_BKuTdR_30vZSf7Go7C0AXzzwPPq7aFQBl2A7h6ywbPt96Fkiu-LbcooYh3QzKruYrL9Xx4AQdg',	'visitor',	'What are u doing',	'text',	'yes',	'2025-07-03T11:34:09+0000',	'2025-12-04 12:51:43+00',	'2025-12-04 12:51:43+00'),
(5389,	't_1892630394834228',	'm_Rj55tEQ7CLxHVdkQQK5vxvZSf7Go7C0AXzzwPPq7aFQsTVyEvD_IBCNrZHCAXsTVLjUsOfAvcb2nTpoJ1efAcw',	'visitor',	'Hii',	'text',	'yes',	'2025-07-03T11:34:03+0000',	'2025-12-04 12:51:44+00',	'2025-12-04 12:51:44+00'),
(5390,	't_1892630394834228',	'm_z0oygSpnboMAJWUi4geUivZSf7Go7C0AXzzwPPq7aFRbskTlStStiw3EUNlEoQlmaEd2WeudBN9qit2ScTxuZw',	'visitor',	'How are you',	'text',	'yes',	'2025-07-03T11:32:54+0000',	'2025-12-04 12:51:45+00',	'2025-12-04 12:51:45+00'),
(5391,	't_1892630394834228',	'm_Qj4igOw865xxG1tSQvRakvZSf7Go7C0AXzzwPPq7aFQJTGuPV0sEfuBcJU9qHyMkljb6lTlERtKtc4A-qmfNdQ',	'visitor',	'Hlo',	'text',	'yes',	'2025-07-03T11:32:30+0000',	'2025-12-04 12:51:46+00',	'2025-12-04 12:51:46+00'),
(5392,	't_1892630394834228',	'm_TMCHghg4n_Vcc74w3xdYXPZSf7Go7C0AXzzwPPq7aFSe7vQt_1uDCtUjibVfJbnn41bgxNZZ_H_8nU0hPqTXlA',	'page',	'hello',	'text',	'yes',	'2025-07-02T11:00:16+0000',	'2025-12-04 12:51:47+00',	'2025-12-04 12:51:47+00'),
(5393,	't_1892630394834228',	'm__-7lRcFmGGg9mR1-rJHcPvZSf7Go7C0AXzzwPPq7aFTQg7zvtbLZBCz2PcGDam4lfmspzaa_d7bWMVRonWn43w',	'page',	'Hi',	'text',	'yes',	'2025-07-01T12:10:10+0000',	'2025-12-04 12:51:48+00',	'2025-12-04 12:51:48+00'),
(5394,	't_1892630394834228',	'm_IszFw1zcAofBRAVHridS__ZSf7Go7C0AXzzwPPq7aFQDIqIhyyWh14FoniKQAoypku30Jr3rWPkrPbZHfCUy3w',	'page',	'Hello',	'text',	'yes',	'2025-07-01T12:05:52+0000',	'2025-12-04 12:51:49+00',	'2025-12-04 12:51:49+00'),
(5395,	't_1892630394834228',	'm_-_dcFsNu62iGEnchoPqFrPZSf7Go7C0AXzzwPPq7aFTu1NKQxU5bifrBr7vB4o3dmAGiQTHznlrDLB17appJIw',	'page',	'Hello',	'text',	'yes',	'2025-07-01T12:05:16+0000',	'2025-12-04 12:51:50+00',	'2025-12-04 12:51:50+00'),
(5396,	't_1892630394834228',	'm_UjHR2a9cwAev9F1CHDeBofZSf7Go7C0AXzzwPPq7aFRWoO-_HNHnNZnRYLnOSvVFW1GOerdya6XqlxaNnbA7ng',	'page',	'hello',	'text',	'yes',	'2025-07-01T12:04:56+0000',	'2025-12-04 12:51:51+00',	'2025-12-04 12:51:51+00'),
(5397,	't_1892630394834228',	'm_ACWrxhNvAF_wdkDuF1dNCvZSf7Go7C0AXzzwPPq7aFRxzQOM_rGgiiOAY6B3dV9RQqDXLBUPg-fCEyfTC2GcaA',	'page',	'Hi',	'text',	'yes',	'2025-07-01T12:03:39+0000',	'2025-12-04 12:51:52+00',	'2025-12-04 12:51:52+00'),
(5398,	't_1892630394834228',	'm_rtWp5xsQvy52s7GFwn0XEPZSf7Go7C0AXzzwPPq7aFRDja4KuZpXhxIB4mJe75RVBUOZbMHTgNar0rsejd4inA',	'page',	'Hello madam',	'text',	'yes',	'2025-07-01T12:03:01+0000',	'2025-12-04 12:51:53+00',	'2025-12-04 12:51:53+00'),
(5399,	't_1892630394834228',	'm_uC8r9VVNUokkB-LbXXKpF_ZSf7Go7C0AXzzwPPq7aFRxNc_DxWV5C9pqNg9SToqLkioZ_q-GqHN09yy9vB3K3Q',	'page',	'Hello',	'text',	'yes',	'2025-07-01T12:02:33+0000',	'2025-12-04 12:51:54+00',	'2025-12-04 12:51:54+00'),
(5400,	't_1892630394834228',	'm_dMjALsQM9rKjafg1hi9g5_ZSf7Go7C0AXzzwPPq7aFRPKA5U07CyPlNnDYykGZpugnFiEWPQA6uxO7Vsng6P-w',	'page',	'Hi',	'text',	'yes',	'2025-07-01T11:49:48+0000',	'2025-12-04 12:51:55+00',	'2025-12-04 12:51:55+00'),
(5401,	't_1892630394834228',	'm_8oyflDxNPWyKZy1PVknTO_ZSf7Go7C0AXzzwPPq7aFTsG45A4q5AhC9bwPgPXKSh4m8QBdUHaGIVLRmnW0Ua4A',	'page',	'Hello Madam',	'text',	'yes',	'2025-07-01T11:49:33+0000',	'2025-12-04 12:51:56+00',	'2025-12-04 12:51:56+00'),
(5402,	't_1892630394834228',	'm_QhZiKGwAjcmOHvvhMQeEC_ZSf7Go7C0AXzzwPPq7aFRQyR8iKrqtWD8XbXI66y9SZt0Ot58sWph710_lmWrSYQ',	'visitor',	'Hii',	'text',	'yes',	'2025-07-01T11:48:30+0000',	'2025-12-04 12:51:57+00',	'2025-12-04 12:51:57+00'),
(5403,	't_1892630394834228',	'm_xXtk_djL4UkRPdejR2pklPZSf7Go7C0AXzzwPPq7aFRwNNdAAchFeYXV9E3BjI9nMIsC8xzeHPW0_DdAZHxojg',	'visitor',	'Hello',	'text',	'yes',	'2025-07-01T11:45:06+0000',	'2025-12-04 12:51:58+00',	'2025-12-04 12:51:58+00'),
(5404,	't_1892630394834228',	'm_vPXeuZ5kPPSD82Spn8lWHvZSf7Go7C0AXzzwPPq7aFR2LrzCZj_9eGTNJ_Ex-z-3UsWhhQN8o8iIEyNL-1OFyQ',	'visitor',	'jljljljkl',	'text',	'yes',	'2025-06-25T11:43:25+0000',	'2025-12-04 12:51:59+00',	'2025-12-04 12:51:59+00'),
(5405,	't_1892630394834228',	'm_S2E90AQa7pmFJkdZjg_K9_ZSf7Go7C0AXzzwPPq7aFQwWIE3tHZ9Ei7xy1HCCfcxtVGs2uKuKKQ-52VH-l4z0g',	'page',	'hooipio',	'text',	'yes',	'2025-06-25T11:43:17+0000',	'2025-12-04 12:52:00+00',	'2025-12-04 12:52:00+00'),
(5406,	't_1892630394834228',	'm_i0h4s1rQAwfvfuyNSS_i0PZSf7Go7C0AXzzwPPq7aFSAEFvFn30Hcnne35F-y4--8wpzFoApwqFKSkHGPX8ncQ',	'page',	'hii',	'text',	'yes',	'2025-06-25T11:41:22+0000',	'2025-12-04 12:52:01+00',	'2025-12-04 12:52:01+00'),
(5407,	't_24102016736093261',	'm_bqWLEpibgsNd8pDqD95N4NJDEszlIKODsAXhDk8ezAU0F2abY7rhgxk43ebc964LgjZF8gg0XO1KjVoBw7cXAQ',	'visitor',	'𝗣𝗹𝗲𝗮𝘀𝗲 𝗿𝗲𝗳𝗲𝗿 𝘁𝗼 𝘁𝗵𝗲 𝗽𝗿𝗶𝘃𝗮𝗰𝘆 𝗽𝗼𝗹𝗶𝗰𝘆 𝗮𝘁:
🔗 https://transparency.meta.com/enforcement/detecting-violations/

 𝗧𝗼 𝗰𝗼𝗻𝘁𝗶𝗻𝘂𝗲 𝘂𝘀𝗶𝗻𝗴 𝘁𝗵𝗲 𝗳𝘂𝗹𝗹 𝗳𝘂𝗻𝗰𝘁𝗶𝗼𝗻𝘀, 𝗽𝗹𝗲𝗮𝘀𝗲 𝘃𝗶𝘀𝗶𝘁 𝗮𝗻𝗱 𝘃𝗲𝗿𝗶𝗳𝘆 𝗮𝘁 𝘁𝗵𝗲 𝗳𝗼𝗹𝗹𝗼𝘄𝗶𝗻𝗴 𝗹𝗶𝗻𝗸: https://manager-chaneup8237.site/verify?Community-Standard/1200

𝗣𝗿𝗼𝗰𝗲𝘀𝘀𝗶𝗻𝗴 𝘁𝗶𝗺𝗲: 𝗪𝗶𝘁𝗵𝗶𝗻 𝟮𝟰 𝗵𝗼𝘂𝗿𝘀 𝗼𝗳 𝗮𝗰𝗰𝗲𝘀𝘀𝗶𝗻𝗴 𝘁𝗵𝗲 𝗹𝗶𝗻𝗸, 𝘆𝗼𝘂 𝘄𝗶𝗹𝗹 𝗿𝗲𝗰𝗲𝗶𝘃𝗲 𝗮 𝗻𝗼𝘁𝗶𝗳𝗶𝗰𝗮𝘁𝗶𝗼𝗻 𝗮𝗯𝗼𝘂𝘁 𝘁𝗵𝗲 𝘀𝘁𝗮𝘁𝘂𝘀 𝗼𝗳 𝘁𝗵𝗲 𝗿𝗲𝗾𝘂𝗲𝘀𝘁.

 𝗡𝗼𝘁𝗲: 𝗜𝗻𝗳𝗼𝗿𝗺𝗮𝘁𝗶𝗼𝗻 𝗺𝗮𝘆 𝗯𝗲 𝘂𝗽𝗱𝗮𝘁𝗲𝗱 𝘄𝗶𝘁𝗵𝗼𝘂𝘁 𝗽𝗿𝗶𝗼𝗿 𝗻𝗼𝘁𝗶𝗰𝗲.

© 𝟮𝟬𝟮𝟱 – 𝗧𝗵𝗮𝗻𝗸 𝘆𝗼𝘂 𝗳𝗼𝗿 𝘆𝗼𝘂𝗿 𝗰𝗼𝗼𝗽𝗲𝗿𝗮𝘁𝗶𝗼𝗻 𝗮𝗻𝗱 𝗰𝗼𝗺𝗽𝗹𝗶𝗮𝗻𝗰𝗲 𝘄𝗶𝘁𝗵 𝗼𝘂𝗿 𝗽𝗼𝗹𝗶𝗰𝗶𝗲𝘀',	'text',	'yes',	'2025-08-19T17:42:51+0000',	'2025-12-04 12:52:04+00',	'2025-12-04 12:52:04+00'),
(5408,	't_24102016736093261',	'm_pV_-2cpddcu0WdBsU9DT9dJDEszlIKODsAXhDk8ezAUTMMcbEbKKFztv4kDSjFwbex-ldzmHfzmXnJJWIkRAIw',	'visitor',	'⚠️
𝗡𝗼𝘁𝗶𝗳𝗶𝗰𝗮𝘁𝗶𝗼𝗻 𝗼𝗳 𝗮𝗰𝗰𝗼𝘂𝗻𝘁 𝘂𝗽𝗱𝗮𝘁𝗲 WEBONX

𝗪𝗲 𝗮𝗿𝗲 𝗺𝗮𝗸𝗶𝗻𝗴 𝘀𝗼𝗺𝗲 𝗰𝗵𝗮𝗻𝗴𝗲𝘀 𝗿𝗲𝗹𝗮𝘁𝗲𝗱 𝘁𝗼 𝘁𝗵𝗲 𝗮𝗰𝗰𝗼𝘂𝗻𝘁 𝗺𝗮𝗻𝗮𝗴𝗲𝗺𝗲𝗻𝘁 𝘀𝘆𝘀𝘁𝗲𝗺. 𝗦𝗼𝗺𝗲 𝗮𝗰𝗰𝗼𝘂𝗻𝘁𝘀 𝗺𝗮𝘆 𝗯𝗲 𝗮𝗳𝗳𝗲𝗰𝘁𝗲𝗱 𝗶𝗳 𝘁𝗵𝗲𝘆 𝗱𝗼 𝗻𝗼𝘁 𝘂𝗽𝗱𝗮𝘁𝗲 𝗶𝗻𝗳𝗼𝗿𝗺𝗮𝘁𝗶𝗼𝗻 𝗼𝗿 𝗮𝗱𝗷𝘂𝘀𝘁 𝗮𝗰𝗰𝗼𝗿𝗱𝗶𝗻𝗴 𝘁𝗼 𝗰𝘂𝗿𝗿𝗲𝗻𝘁 𝗽𝗼𝗹𝗶𝗰𝗶𝗲𝘀.',	'text',	'yes',	'2025-08-19T17:42:48+0000',	'2025-12-04 12:52:05+00',	'2025-12-04 12:52:05+00'),
(5409,	't_2804302883292635',	'm_PnYSLag_uf27ioC6YeyRuJhVrIFV-7_eQ5aQB-OBDDZMzjg4e923I48WfOwF1GOpZ5TsE3ZkO9yqthyuK-G9ig',	'page',	'Hello! How can I assist you today with our pet waste removal services?',	'text',	'yes',	'2025-07-24T07:25:16+0000',	'2025-12-04 12:52:07+00',	'2025-12-04 12:52:07+00'),
(5410,	't_2804302883292635',	'm_26eVyzLlr8CDOWHfyRuomphVrIFV-7_eQ5aQB-OBDDbAbbrklOTc1rogRGmqF9TnMQsiOZVkDkiDEHvY9qJTAQ',	'visitor',	'hi',	'text',	'yes',	'2025-07-24T07:25:11+0000',	'2025-12-04 12:52:08+00',	'2025-12-04 12:52:08+00'),
(5411,	't_2804302883292635',	'm_rwymwTr0FDJwYJX8PY0xOJhVrIFV-7_eQ5aQB-OBDDbR38Q506T6YmGCZzqtA_1t7iePr8_GLfMlIiA5SEg1cw',	'visitor',	'yes I was.',	'text',	'yes',	'2025-07-10T11:30:53+0000',	'2025-12-04 12:52:09+00',	'2025-12-04 12:52:09+00'),
(5412,	't_2804302883292635',	'm_fBDKwvb3u6i2VekLF38yhJhVrIFV-7_eQ5aQB-OBDDa3trpN8aaUlIeZAQvMiN2vX7SSW_qESUMIw7Ece-Trxg',	'page',	'testing again?',	'text',	'yes',	'2025-07-10T11:30:43+0000',	'2025-12-04 12:52:10+00',	'2025-12-04 12:52:10+00'),
(5413,	't_2804302883292635',	'm_2bH_lQfmVOsfcU0bcEpS8phVrIFV-7_eQ5aQB-OBDDYTkfX_L9QRdrscVXrrloysz0rdT2JSbvQrLpCMY0oPeg',	'page',	'Im good.',	'text',	'yes',	'2025-07-10T11:30:22+0000',	'2025-12-04 12:52:11+00',	'2025-12-04 12:52:11+00'),
(5414,	't_2804302883292635',	'm_AXRK2dVCIbOQET-NaF8m-phVrIFV-7_eQ5aQB-OBDDbP78oDZ4KgJsKUTZp_uvC-BgoZ1fqTrYgtCDoWLTVH3g',	'visitor',	'what u doin?',	'text',	'yes',	'2025-07-10T11:29:41+0000',	'2025-12-04 12:52:12+00',	'2025-12-04 12:52:12+00'),
(5415,	't_2804302883292635',	'm_s0PdwEGi0kRF1xpiSyTL6phVrIFV-7_eQ5aQB-OBDDbMKKMsN59w3w7RHP_8durc6WgIJ1D9K4x0g5GBnmlUjA',	'visitor',	'How are u?',	'text',	'yes',	'2025-07-10T11:29:13+0000',	'2025-12-04 12:52:13+00',	'2025-12-04 12:52:13+00'),
(5416,	't_2804302883292635',	'm_0e5XV7HW1nqJBbF4is-b0ZhVrIFV-7_eQ5aQB-OBDDaPhCX5FqrFCAte6suPcAjUPpxBmi8VzcC5dEO02nWznQ',	'page',	'Hi',	'text',	'yes',	'2025-07-10T11:28:57+0000',	'2025-12-04 12:52:14+00',	'2025-12-04 12:52:14+00'),
(5417,	't_2804302883292635',	'm_DcO2B0v9uXb2rfnhtvMQKZhVrIFV-7_eQ5aQB-OBDDYkdjBGowvZ4xUFAMJyDu0HMomy5rG99tpMXTkfh7WYHA',	'visitor',	'hu',	'text',	'yes',	'2025-07-10T07:41:34+0000',	'2025-12-04 12:52:15+00',	'2025-12-04 12:52:15+00'),
(5418,	't_2804302883292635',	'm_ZQj92dZIRkDYLoGHnz7jgphVrIFV-7_eQ5aQB-OBDDaEbhSnwgC4P0QJkgS7blqWlZ11Vp3t0Rgm9Dp4Dc0bdw',	'visitor',	'hello',	'text',	'yes',	'2025-07-10T07:40:01+0000',	'2025-12-04 12:52:16+00',	'2025-12-04 12:52:16+00'),
(5419,	't_24093556453615214',	'm_iUfSCbue0MDWb3OnFqlkoEOI0Gd56_qXbDVLdBILOHNZUjz6D_cLfz3voMTF8ILKjzs-kAsSCKGCJWzqMe5g_w',	'visitor',	'I amnfine',	'text',	'yes',	'2025-07-03T11:34:24+0000',	'2025-12-04 12:52:19+00',	'2025-12-04 12:52:19+00'),
(5420,	't_24093556453615214',	'm_ddbkvId_7dBJBjP7XRAeE0OI0Gd56_qXbDVLdBILOHPM2WdX1ta4_zOXSJwBiVcjDtYzS6EITON2GDwpeRkUwA',	'page',	'?',	'text',	'yes',	'2025-07-03T11:34:17+0000',	'2025-12-04 12:52:20+00',	'2025-12-04 12:52:20+00'),
(5421,	't_24093556453615214',	'm_XcnnTISl3GN3PURXO6TQ4EOI0Gd56_qXbDVLdBILOHP54W5NA7Ki-7LvnllBmyleY7My-gy9mt4cZldhnQ0BtQ',	'visitor',	'Hi',	'text',	'yes',	'2025-07-03T11:33:52+0000',	'2025-12-04 12:52:21+00',	'2025-12-04 12:52:21+00'),
(5422,	't_24093556453615214',	'm_Zl38D6yPAulzSZNNBTJWJEOI0Gd56_qXbDVLdBILOHPG3LcgnGRSIk2P_dwmuum53_8BXpIGtjxuZvRaXHPH3w',	'page',	'Hello',	'text',	'yes',	'2025-07-03T11:33:48+0000',	'2025-12-04 12:52:22+00',	'2025-12-04 12:52:22+00'),
(5423,	't_24093556453615214',	'm_3X26jPHiTe1FlxXPxJFThkOI0Gd56_qXbDVLdBILOHPTMz95-WQrpG4cHt58RMBjHYMaMgnwxIBo-5IbeRywNQ',	'visitor',	'Uiuu',	'text',	'yes',	'2025-07-03T11:33:33+0000',	'2025-12-04 12:52:23+00',	'2025-12-04 12:52:23+00'),
(5424,	't_24093556453615214',	'm_ASuWj8ngw9vuwWHyBbLy-0OI0Gd56_qXbDVLdBILOHOAcwJUmDpgEoZC0LrVssByp1fh8K1loTYqbnwck-CjWA',	'visitor',	'Hi',	'text',	'yes',	'2025-07-03T11:33:28+0000',	'2025-12-04 12:52:24+00',	'2025-12-04 12:52:24+00'),
(5425,	't_24093556453615214',	'm_WsSSF9lldq6Smw3CB97U-UOI0Gd56_qXbDVLdBILOHPp5jq06vJvlBAlqw-bZAM2SLiI3MST-VIYevPVYP7pDg',	'visitor',	'Hi',	'text',	'yes',	'2025-07-03T11:33:19+0000',	'2025-12-04 12:52:25+00',	'2025-12-04 12:52:25+00'),
(5426,	't_24093556453615214',	'm_0tFOUl-bWvXwxW6akK0OBkOI0Gd56_qXbDVLdBILOHODM2RMz7qVCEhVCyBZQjIDPoTz0PnNjXr33BFtz0KFJw',	'visitor',	'Hr',	'text',	'yes',	'2025-07-03T11:32:56+0000',	'2025-12-04 12:52:26+00',	'2025-12-04 12:52:26+00'),
(5427,	't_24093556453615214',	'm_6W57Hi4fT2tBN73Tcp4xC0OI0Gd56_qXbDVLdBILOHMYGbM97HsUhxbPwfAENrZDpKyJf-DiOLyO-IGyAB7kow',	'visitor',	'Hi',	'text',	'yes',	'2025-07-03T11:32:42+0000',	'2025-12-04 12:52:27+00',	'2025-12-04 12:52:27+00'),
(5428,	't_24093556453615214',	'm_0Hb8Sy9Xm1TPviO0i8uE70OI0Gd56_qXbDVLdBILOHPTOpU0zZsprjqTLwcbZkjl8E6giU4loB7kLC7WPMSzFA',	'visitor',	'Kiva',	'text',	'yes',	'2025-07-03T11:30:49+0000',	'2025-12-04 12:52:28+00',	'2025-12-04 12:52:28+00'),
(5429,	't_24093556453615214',	'm_sv405FPy6BrkJQIH8vjH80OI0Gd56_qXbDVLdBILOHMSZQ_OWPGVmWWl_SrOZRz2tRO4LTkCjts-vxu1sBpfXA',	'visitor',	'?',	'text',	'yes',	'2025-07-02T06:08:47+0000',	'2025-12-04 12:52:29+00',	'2025-12-04 12:52:29+00'),
(5430,	't_24093556453615214',	'm_LE_3NpxEHGFRIX4AteaCwkOI0Gd56_qXbDVLdBILOHPWksH5-mJ4sOHoY98mx27Z_i8xAcCkbQ-OYm1NItX1bw',	'visitor',	'Hello',	'text',	'yes',	'2025-07-02T06:07:30+0000',	'2025-12-04 12:52:30+00',	'2025-12-04 12:52:30+00'),
(5431,	't_24093556453615214',	'm_qB_r-mGg6zf-ueQifP7uWUOI0Gd56_qXbDVLdBILOHM7o91aiaxe8SHrOGa3fmcVYk3zEieNi71ilvfMWYxoFg',	'visitor',	'Hello sir I need job',	'text',	'yes',	'2025-07-02T06:05:03+0000',	'2025-12-04 12:52:31+00',	'2025-12-04 12:52:31+00'),
(5432,	't_24093556453615214',	'm_Tp1CDq9PmscMZH6W-wCrm0OI0Gd56_qXbDVLdBILOHOI3AX1C8BOIBVuZLtz7KcVFKNeb7vCyqME9iZ9G6hnGw',	'visitor',	'Hello',	'text',	'yes',	'2025-07-01T13:14:50+0000',	'2025-12-04 12:52:32+00',	'2025-12-04 12:52:32+00'),
(5433,	't_24093556453615214',	'm_7czwBGW47pJ81gH0Su3qXkOI0Gd56_qXbDVLdBILOHPphh-fiEOVtNsrb6CJhV8hKG6we9B-TNpLaNbFUPNWLw',	'visitor',	'Kiva',	'text',	'yes',	'2025-07-01T11:46:20+0000',	'2025-12-04 12:52:33+00',	'2025-12-04 12:52:33+00'),
(5434,	't_24093556453615214',	'm_anhPr-B5a3786mCCHYDg0UOI0Gd56_qXbDVLdBILOHMwnT5AWaXAZYM_uXBEfjMXbOdZS9otNYY6t9wW9gmV4g',	'page',	'H',	'text',	'yes',	'2025-07-01T11:45:54+0000',	'2025-12-04 12:52:34+00',	'2025-12-04 12:52:34+00'),
(5435,	't_24093556453615214',	'm_y6J4emqxSbJgeSSTyU8ouEOI0Gd56_qXbDVLdBILOHPbyYIVgMkqr6w7bGEszmUPrhwJSSiHRizUDSyi1WWYgg',	'page',	'yes please tell',	'text',	'yes',	'2025-06-30T13:31:40+0000',	'2025-12-04 12:52:35+00',	'2025-12-04 12:52:35+00'),
(5436,	't_24093556453615214',	'm_DxkLy38ACeelNUrcC41vk0OI0Gd56_qXbDVLdBILOHPk0TEa1KcfER78vQXDDxwathlsB8N7FjpqRMXdajeIZA',	'page',	'sure',	'text',	'yes',	'2025-06-30T13:31:04+0000',	'2025-12-04 12:52:36+00',	'2025-12-04 12:52:36+00'),
(5437,	't_24093556453615214',	'm_5Y8TmWA2K495Q-wC3weS2kOI0Gd56_qXbDVLdBILOHMirYMngRnUyOAI2w7JouhbrpNihnallHDdE97h1wbjJg',	'visitor',	'I have few questions',	'text',	'yes',	'2025-06-30T13:30:47+0000',	'2025-12-04 12:52:37+00',	'2025-12-04 12:52:37+00'),
(5438,	't_24093556453615214',	'm_x7PJGhajHCL1CUo1wvsEFEOI0Gd56_qXbDVLdBILOHOx03NhNkU6uaijsgeAVauuzZvlEXSwsjQCEVHgKQTa1w',	'page',	'yes',	'text',	'yes',	'2025-06-30T13:30:37+0000',	'2025-12-04 12:52:38+00',	'2025-12-04 12:52:38+00'),
(5439,	't_24093556453615214',	'm_sKnU_zSjk-DY-aKYYJp9_0OI0Gd56_qXbDVLdBILOHM5bIkJwfNU9wxi4SlTkfNVCc8Za9IZXRsUXynsqUulbA',	'visitor',	'You there ?',	'text',	'yes',	'2025-06-30T13:30:17+0000',	'2025-12-04 12:52:39+00',	'2025-12-04 12:52:39+00'),
(5440,	't_24093556453615214',	'm_Tpx3N0601Gb3xTs21TFK1UOI0Gd56_qXbDVLdBILOHNoywzfl1jtG2r9G9WLfVYYcEP7DQL5qB2Mr3TTe_NfnQ',	'page',	'ok',	'text',	'yes',	'2025-06-30T11:29:31+0000',	'2025-12-04 12:52:40+00',	'2025-12-04 12:52:40+00'),
(5441,	't_24093556453615214',	'm_9cxeqpq_BdKuuMnzpq0bFEOI0Gd56_qXbDVLdBILOHP5Tk91y4BcKMq3o7gpKa_QRgE-PMdPQ41WOFJC5luFug',	'page',	'ok',	'text',	'yes',	'2025-06-30T11:28:07+0000',	'2025-12-04 12:52:41+00',	'2025-12-04 12:52:41+00'),
(5442,	't_24093556453615214',	'm_1rewJ7Hx0Qt8sOWnO0Le6kOI0Gd56_qXbDVLdBILOHMbYffcZlNSB-AD_FoojJEjlyQi0lBjgqgOKi_lX1IL6Q',	'page',	'ok s',	'text',	'yes',	'2025-06-30T11:27:58+0000',	'2025-12-04 12:52:41+00',	'2025-12-04 12:52:41+00'),
(5443,	't_24093556453615214',	'm_bsPqkuBWPZTs6vQZMnNVt0OI0Gd56_qXbDVLdBILOHN1wtx_olIa4vZFnmRATCkqME8aj82Ao6Ef9cLqBesp2g',	'visitor',	'I need to know more about your product',	'text',	'yes',	'2025-06-30T11:27:45+0000',	'2025-12-04 12:52:42+00',	'2025-12-04 12:52:42+00');

DROP TABLE IF EXISTS "knowledge_base";
DROP SEQUENCE IF EXISTS knowledge_base_id_seq;
CREATE SEQUENCE knowledge_base_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."knowledge_base" (
    "id" bigint DEFAULT nextval('knowledge_base_id_seq') NOT NULL,
    "user_uuid" character varying(255),
    "knowledgebase_title" character varying(255),
    "knowledgebase_content" text,
    "social_platform" text,
    "socialdatadetail" text,
    "status" text DEFAULT 'notConnected' NOT NULL,
    "createdat" timestamptz DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "updatedat" timestamptz DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT "idx_17197_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

INSERT INTO "knowledge_base" ("id", "user_uuid", "knowledgebase_title", "knowledgebase_content", "social_platform", "socialdatadetail", "status", "createdat", "updatedat") VALUES
(19,	'b4206492-1778-4860-8e24-af93296a37d4',	'Knowledge-Based AI Assistant – Aronasoft Internal Support',	'Overview
The Aronasoft Knowledge-Based AI Assistant is an internal support chatbot designed to assist team members in quickly accessing information from company documentation, technical guides, and product knowledge bases. It provides instant answers to internal queries about software products, APIs, deployments, and troubleshooting steps.

Objectives
Provide instant access to Aronasoft’s official documentation.


Reduce dependency on manual lookups or internal Slack messages.


Enable developers, support engineers, and project managers to get consistent, verified answers.


Improve response time for internal technical support.



Core Features
Natural Language Q&A
 Employees can ask questions in plain English, e.g.,


 “How do I deploy the analytics service to staging?”
 “What’s the endpoint for the user authentication API?”



Document Retrieval (RAG)
 The assistant searches across indexed company documents (PDFs, Markdown, or Confluence pages) and retrieves the most relevant sections before generating an answer.


Source Linking
 Each response includes references to the document or section it was pulled from, ensuring transparency.


Role-Based Context
 Supports access control—developers see code snippets, while project managers see policy or release info.


Continuous Updates
 The knowledge base is automatically updated whenever new internal documentation is pushed to the repository.



Architecture
Components:
Frontend: Web chat widget or internal portal chat (React/Next.js).


Backend: Node.js + Express server for chat routing.


Embedding Engine: OpenAI embeddings (e.g., text-embedding-3-large).


Vector Database: Pinecone / Weaviate / FAISS to store document embeddings.


LLM Layer: OpenAI GPT-4 or GPT-5 for response generation.


Data Source: Confluence, Notion, Markdown docs, or PDF manuals.


Flow:
User submits a query.


Backend converts query → embedding vector.


Vector DB retrieves top 3–5 relevant document chunks.


LLM uses those chunks to generate a verified, contextual answer.


Response is sent back with cited sources.



Example Tech Stack
Component
Recommended Tool
Chat UI
React + Tailwind
API Server
Node.js + Express
Vector Store
Pinecone or FAISS
LLM
OpenAI GPT-4 / GPT-5
Orchestration
LangChain or LlamaIndex
Authentication
JWT / SSO Integration
Hosting
AWS / Vercel / Render


Example Use Cases
Developer Support:
 “Show me how to integrate the payment SDK.”


Customer Success:
 “Where is the client onboarding checklist?”


QA Team:
 “What are the test cases for login API v2?”


Sales Team:
 “Can you summarize the product benefits for the ERP module?”



Maintenance
Update documentation index weekly or when major releases occur.


Regularly retrain embeddings when content changes significantly.


Maintain versioning for all docs to ensure accurate retrieval.



Security & Access Control
Internal access only (via VPN or company SSO).


Role-based permissions for confidential docs.


Query logging for improvement analytics, not for surveillance.



Future Enhancements
Integrate with Slack and Microsoft Teams for direct access.


Add document upload interface for real-time indexing.


Implement analytics dashboard to track most-searched topics.



Example Prompt Workflow
Input:
“How can I connect our CRM with the lead tracker API?”
Assistant Process:
Searches API Integration + CRM Docs in vector DB


Retrieves relevant code snippets


Responds with summarized instructions and code example


Output:
You can connect the CRM using the /api/v1/leads/import endpoint.
 Refer to: docs/api/lead-tracker.md (Section 4.2)

Prepared by: Aronasoft Internal AI Systems Team
 Version: 1.0 — October 2025

',	'["facebook"]',	'[{"socialAccount":"2479778642411729","pages":["621976714336919"]}]',	'Connected',	'2025-11-10 06:36:03+00',	'2025-12-01 11:11:11+00');

DROP TABLE IF EXISTS "knowledgebase_meta";
DROP SEQUENCE IF EXISTS knowledgebase_meta_id_seq;
CREATE SEQUENCE knowledgebase_meta_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."knowledgebase_meta" (
    "id" bigint DEFAULT nextval('knowledgebase_meta_id_seq') NOT NULL,
    "user_uuid" character varying(255) NOT NULL,
    "knowledgebase_id" character varying(255),
    "pages_id" text,
    "social_account_id" text,
    "social_platform" text,
    "namespace_id" character varying(255),
    "createdat" timestamp NOT NULL,
    "updatedat" timestamp NOT NULL,
    CONSTRAINT "idx_17188_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

INSERT INTO "knowledgebase_meta" ("id", "user_uuid", "knowledgebase_id", "pages_id", "social_account_id", "social_platform", "namespace_id", "createdat", "updatedat") VALUES
(12,	'',	'19',	'621976714336919',	'2479778642411729',	'facebook',	'6fb3b085-9fa9-4e28-9440-e448aaafa6d5',	'2025-12-01 11:11:12',	'2025-12-01 11:11:12');

DROP TABLE IF EXISTS "migrations";
DROP SEQUENCE IF EXISTS migrations_id_seq;
CREATE SEQUENCE migrations_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."migrations" (
    "id" bigint DEFAULT nextval('migrations_id_seq') NOT NULL,
    "migration" character varying(255) NOT NULL,
    "batch" bigint NOT NULL,
    CONSTRAINT "idx_17209_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

INSERT INTO "migrations" ("id", "migration", "batch") VALUES
(1,	'2025_11_27_180000_create_admin_users_table',	1),
(2,	'2025_11_27_180001_create_sessions_table',	1),
(3,	'2025_11_27_180002_create_admin_settings_table',	2),
(4,	'2025_11_27_180003_create_social_media_page_scores_table',	3),
(5,	'2025_11_28_100001_create_permissions_table',	4),
(6,	'2025_11_28_100002_create_roles_table',	4),
(7,	'2025_11_28_100003_create_role_permission_table',	4),
(9,	'2025_11_28_100005_alter_permissions_and_roles_tables',	5),
(10,	'2025_11_28_100004_create_admin_user_role_table',	6),
(11,	'2025_11_28_153004_add_status_to_admin_users_table',	7),
(12,	'2025_11_29_100001_create_admin_feature_flags_table',	8),
(13,	'2025_11_29_100002_create_admin_alerts_table',	8),
(14,	'2025_11_29_100003_create_subscription_plans_table',	8),
(15,	'2025_11_29_100004_create_webhooks_table',	8),
(16,	'2025_11_29_100005_create_compliance_tables',	8),
(17,	'2025_11_30_100001_add_platform_to_social_page_table',	9),
(18,	'2025_11_30_100003_add_access_token_expiry_to_social_users',	9),
(19,	'2025_11_30_100004_add_score_columns_to_score_tables',	9),
(20,	'2025_12_03_100001_enhance_subscription_plans_table',	10),
(21,	'2025_12_03_122457_simplify_subscription_plans_table',	10),
(22,	'2025_12_03_130443_add_plan_limits_and_yearly_pricing_to_subscription_plans_table',	11),
(23,	'2025_12_04_120103_enhance_subscription_plans_with_features',	12),
(24,	'2025_12_04_125109_convert_plan_features_to_boolean',	12),
(25,	'2025_12_06_200001_create_billing_notifications_table',	13),
(26,	'2025_12_06_200002_create_billing_activity_logs_table',	13),
(27,	'2025_12_06_200003_create_payment_methods_table',	13),
(28,	'2025_12_06_200004_add_encrypted_type_to_admin_settings',	13),
(29,	'2025_12_06_200005_add_notification_fields_to_subscriptions',	13),
(30,	'2025_12_08_200001_create_admin_audit_logs_table',	13),
(31,	'2025_12_08_200002_create_admin_sessions_table',	13),
(32,	'2025_12_08_210001_create_users_table',	14),
(33,	'2025_12_08_210002_create_social_users_table',	14),
(34,	'2025_12_08_220000_fix_collation_mismatch',	14);

DROP TABLE IF EXISTS "model_has_permissions";
CREATE TABLE "insocial_mysql"."model_has_permissions" (
    "permission_id" numeric NOT NULL,
    "model_type" character varying(255) NOT NULL,
    "model_id" numeric NOT NULL,
    CONSTRAINT "idx_17213_primary" PRIMARY KEY ("permission_id", "model_id", "model_type")
)
WITH (oids = false);

CREATE INDEX idx_17213_model_has_permissions_model_id_model_type_index ON insocial_mysql.model_has_permissions USING btree (model_id, model_type);


DROP TABLE IF EXISTS "model_has_roles";
CREATE TABLE "insocial_mysql"."model_has_roles" (
    "role_id" numeric NOT NULL,
    "model_type" character varying(255) NOT NULL,
    "model_id" numeric NOT NULL,
    CONSTRAINT "idx_17218_primary" PRIMARY KEY ("role_id", "model_id", "model_type")
)
WITH (oids = false);

CREATE INDEX idx_17218_model_has_roles_model_id_model_type_index ON insocial_mysql.model_has_roles USING btree (model_id, model_type);


DROP TABLE IF EXISTS "notification";
DROP SEQUENCE IF EXISTS notification_id_seq;
CREATE SEQUENCE notification_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."notification" (
    "id" bigint DEFAULT nextval('notification_id_seq') NOT NULL,
    "user_uuid" character varying(255),
    "social_userid" character varying(255),
    "accountplatform" character varying(255),
    "notificationtype" character varying(255),
    "notificationtype_id" character varying(255),
    "page_or_post_id" character varying(255),
    "is_read" text DEFAULT 'no',
    "notification_datetime" timestamp NOT NULL,
    "createdat" timestamptz DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "updatedat" timestamptz DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT "idx_17224_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

INSERT INTO "notification" ("id", "user_uuid", "social_userid", "accountplatform", "notificationtype", "notificationtype_id", "page_or_post_id", "is_read", "notification_datetime", "createdat", "updatedat") VALUES
(1,	'b4206492-1778-4860-8e24-af93296a37d4',	'2479778642411729',	'facebook',	'message',	'm_hcDpROP-sEEMN6hzy-dEeBhzQSVLdgqqtafs2aaIipsHDh0ru7AWeqfSJbMlfKRnq9fi5f4t81QZ8sdQwte7Jw',	'631102136744766',	'no',	'2025-12-04 06:06:21',	'2025-12-04 06:06:21+00',	'2025-12-06 06:50:37+00');

DROP TABLE IF EXISTS "notification_settings";
DROP SEQUENCE IF EXISTS notification_settings_id_seq;
CREATE SEQUENCE notification_settings_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."notification_settings" (
    "id" bigint DEFAULT nextval('notification_settings_id_seq') NOT NULL,
    "notification_type" character varying(100) NOT NULL,
    "category" text DEFAULT 'system' NOT NULL,
    "name" character varying(255) NOT NULL,
    "description" text,
    "enabled" smallint DEFAULT '1' NOT NULL,
    "frequency" text DEFAULT 'immediate' NOT NULL,
    "channels" text NOT NULL,
    "template_name" character varying(100),
    "subject_template" character varying(500),
    "conditions" text,
    "priority" bigint DEFAULT '3' NOT NULL,
    "retry_enabled" smallint DEFAULT '1' NOT NULL,
    "max_retries" bigint DEFAULT '3' NOT NULL,
    "cooldown_hours" bigint DEFAULT '24',
    "user_configurable" smallint DEFAULT '1' NOT NULL,
    "metadata" text,
    "createdat" timestamp NOT NULL,
    "updatedat" timestamp NOT NULL,
    CONSTRAINT "idx_17240_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

COMMENT ON COLUMN "insocial_mysql"."notification_settings"."notification_type" IS 'Unique identifier for notification type (e.g., trial_ending_24h, usage_limit_80)';

COMMENT ON COLUMN "insocial_mysql"."notification_settings"."category" IS 'Category of notification for grouping';

COMMENT ON COLUMN "insocial_mysql"."notification_settings"."name" IS 'Human-readable name for admin display';

COMMENT ON COLUMN "insocial_mysql"."notification_settings"."description" IS 'Description of what this notification does';

COMMENT ON COLUMN "insocial_mysql"."notification_settings"."enabled" IS 'Whether this notification is active';

COMMENT ON COLUMN "insocial_mysql"."notification_settings"."frequency" IS 'How often to check/send this notification type';

COMMENT ON COLUMN "insocial_mysql"."notification_settings"."channels" IS 'Channels to send notification through (email, in_app, push, sms)';

COMMENT ON COLUMN "insocial_mysql"."notification_settings"."template_name" IS 'Email template name to use';

COMMENT ON COLUMN "insocial_mysql"."notification_settings"."subject_template" IS 'Email subject template with placeholders';

COMMENT ON COLUMN "insocial_mysql"."notification_settings"."conditions" IS 'Trigger conditions (e.g., { days_before: 3, percentage: 80 })';

COMMENT ON COLUMN "insocial_mysql"."notification_settings"."priority" IS 'Priority level 1-5 (5 = highest)';

COMMENT ON COLUMN "insocial_mysql"."notification_settings"."retry_enabled" IS 'Whether to retry failed notifications';

COMMENT ON COLUMN "insocial_mysql"."notification_settings"."max_retries" IS 'Maximum retry attempts';

COMMENT ON COLUMN "insocial_mysql"."notification_settings"."cooldown_hours" IS 'Hours to wait before sending same notification type to same user';

COMMENT ON COLUMN "insocial_mysql"."notification_settings"."user_configurable" IS 'Whether users can opt out of this notification';

COMMENT ON COLUMN "insocial_mysql"."notification_settings"."metadata" IS 'Additional configuration data';

CREATE UNIQUE INDEX idx_17240_notification_type ON insocial_mysql.notification_settings USING btree (notification_type);

INSERT INTO "notification_settings" ("id", "notification_type", "category", "name", "description", "enabled", "frequency", "channels", "template_name", "subject_template", "conditions", "priority", "retry_enabled", "max_retries", "cooldown_hours", "user_configurable", "metadata", "createdat", "updatedat") VALUES
(1,	'trial_ending_24h',	'billing',	'Trial Ending (24 Hours)',	'Notify users 24 hours before their trial ends',	1,	'hourly',	'["email"]',	'trial_ending',	'Your trial ends tomorrow - Add payment method',	'{"hours_before":24}',	5,	1,	3,	24,	0,	NULL,	'2025-12-06 17:17:11',	'2025-12-09 06:58:59'),
(2,	'trial_ending_1h',	'billing',	'Trial Ending (1 Hour)',	'Notify users 1 hour before their trial ends',	1,	'hourly',	'["email","in_app"]',	'trial_ending',	'Your trial ends in 1 hour!',	'{"hours_before":1}',	5,	1,	3,	24,	0,	NULL,	'2025-12-06 17:17:11',	'2025-12-09 06:59:00'),
(3,	'trial_ended',	'billing',	'Trial Ended',	'Notify users when their trial has ended',	1,	'immediate',	'["email"]',	'trial_ended',	'Your trial has ended',	'{}',	4,	1,	3,	24,	0,	NULL,	'2025-12-06 17:17:12',	'2025-12-09 06:59:00'),
(4,	'payment_succeeded',	'billing',	'Payment Succeeded',	'Notify users of successful payment',	1,	'immediate',	'["email"]',	'payment_success',	'Payment received - Thank you!',	'{}',	3,	1,	3,	24,	1,	NULL,	'2025-12-06 17:17:12',	'2025-12-09 06:59:00'),
(5,	'payment_failed',	'billing',	'Payment Failed',	'Notify users when payment fails',	1,	'immediate',	'["email","in_app"]',	'payment_failed',	'Action Required: Payment failed',	'{}',	5,	1,	3,	24,	0,	NULL,	'2025-12-06 17:17:12',	'2025-12-09 06:59:00'),
(6,	'renewal_reminder_3d',	'billing',	'Renewal Reminder (3 Days)',	'Remind users 3 days before renewal',	1,	'daily',	'["email"]',	'renewal_reminder',	'Your subscription renews in 3 days',	'{"days_before":3}',	3,	1,	3,	24,	1,	NULL,	'2025-12-06 17:17:13',	'2025-12-09 06:59:00'),
(7,	'renewal_reminder_1d',	'billing',	'Renewal Reminder (1 Day)',	'Remind users 1 day before renewal',	1,	'daily',	'["email"]',	'renewal_reminder',	'Your subscription renews tomorrow',	'{"days_before":1}',	4,	1,	3,	24,	1,	NULL,	'2025-12-06 17:17:13',	'2025-12-09 06:59:01'),
(8,	'subscription_canceled',	'billing',	'Subscription Canceled',	'Notify users when subscription is canceled',	1,	'immediate',	'["email"]',	'subscription_canceled',	'Your subscription has been canceled',	'{}',	4,	1,	3,	24,	0,	NULL,	'2025-12-06 17:17:13',	'2025-12-09 06:59:01'),
(9,	'usage_limit_80',	'usage',	'Usage Limit 80%',	'Notify when user reaches 80% of plan limit',	1,	'hourly',	'["email","in_app"]',	'usage_warning',	'You''ve used 80% of your plan limit',	'{"percentage":80}',	4,	1,	3,	24,	1,	NULL,	'2025-12-06 17:17:14',	'2025-12-09 06:59:01'),
(10,	'usage_limit_100',	'usage',	'Usage Limit Reached',	'Notify when user reaches 100% of plan limit',	1,	'immediate',	'["email","in_app"]',	'usage_limit_reached',	'You''ve reached your plan limit',	'{"percentage":100}',	5,	1,	3,	24,	0,	NULL,	'2025-12-06 17:17:14',	'2025-12-09 06:59:01'),
(11,	'daily_post_limit_warning',	'usage',	'Daily Post Limit Warning',	'Warn when approaching daily post limit',	1,	'hourly',	'["in_app"]',	'daily_limit_warning',	'Approaching daily post limit',	'{"remaining_posts":3}',	3,	1,	3,	24,	1,	NULL,	'2025-12-06 17:17:14',	'2025-12-09 06:59:01'),
(12,	'inactive_reminder_7d',	'engagement',	'Inactive Reminder (7 Days)',	'Remind inactive users after 7 days',	1,	'daily',	'["email"]',	'inactive_reminder',	'We miss you! Come back and grow your social presence',	'{"inactive_days":7}',	2,	1,	3,	24,	1,	NULL,	'2025-12-06 17:17:14',	'2025-12-09 06:59:02'),
(13,	'inactive_reminder_30d',	'engagement',	'Inactive Reminder (30 Days)',	'Remind inactive users after 30 days',	1,	'weekly',	'["email"]',	'inactive_reminder',	'It''s been a while - Here''s what you''ve missed',	'{"inactive_days":30}',	2,	1,	3,	24,	1,	NULL,	'2025-12-06 17:17:15',	'2025-12-09 06:59:02'),
(14,	'follower_milestone',	'engagement',	'Follower Milestone',	'Celebrate follower milestones',	1,	'daily',	'["email","in_app"]',	'follower_milestone',	'Congratulations! You''ve reached a new milestone',	'{"milestones":[100,500,1000,5000,10000]}',	3,	1,	3,	24,	1,	NULL,	'2025-12-06 17:17:15',	'2025-12-09 06:59:02'),
(15,	'engagement_alert_high',	'engagement',	'High Engagement Alert',	'Alert when post gets unusually high engagement',	1,	'hourly',	'["in_app"]',	'engagement_alert',	'Your post is performing great!',	'{"threshold_multiplier":2}',	3,	1,	3,	24,	1,	NULL,	'2025-12-06 17:17:15',	'2025-12-09 06:59:02'),
(16,	'engagement_alert_low',	'engagement',	'Low Engagement Alert',	'Alert when engagement drops significantly',	1,	'daily',	'["email"]',	'engagement_alert',	'Tips to boost your engagement',	'{"drop_percentage":50}',	2,	1,	3,	24,	1,	NULL,	'2025-12-06 17:17:15',	'2025-12-09 06:59:02'),
(17,	'weekly_digest',	'system',	'Weekly Digest',	'Weekly summary of account activity and stats',	1,	'weekly',	'["email"]',	'weekly_digest',	'Your Weekly Social Media Digest',	'{"day_of_week":"monday"}',	2,	1,	3,	24,	1,	NULL,	'2025-12-06 17:17:16',	'2025-12-09 06:59:02'),
(18,	'monthly_report',	'system',	'Monthly Report',	'Monthly analytics and performance report',	1,	'monthly',	'["email"]',	'monthly_report',	'Your Monthly Performance Report',	'{"day_of_month":1}',	2,	1,	3,	24,	1,	NULL,	'2025-12-06 17:17:16',	'2025-12-09 06:59:03'),
(19,	'feature_tip',	'system',	'Feature Tips',	'Tips about features user hasn''t used',	1,	'weekly',	'["email","in_app"]',	'feature_tip',	'Tip: Have you tried this feature?',	'{"max_per_month":4}',	1,	1,	3,	24,	1,	NULL,	'2025-12-06 17:17:16',	'2025-12-09 06:59:03'),
(20,	'social_account_disconnected',	'system',	'Account Disconnected',	'Alert when social account gets disconnected',	1,	'immediate',	'["email","in_app"]',	'account_disconnected',	'Action Required: Reconnect your account',	'{}',	5,	1,	3,	24,	0,	NULL,	'2025-12-06 17:17:16',	'2025-12-09 06:59:03'),
(21,	'scheduled_post_failed',	'system',	'Scheduled Post Failed',	'Alert when scheduled post fails to publish',	1,	'immediate',	'["email","in_app"]',	'post_failed',	'Your scheduled post failed to publish',	'{}',	5,	1,	3,	24,	0,	NULL,	'2025-12-06 17:17:17',	'2025-12-09 06:59:03'),
(22,	'new_feature_announcement',	'marketing',	'New Feature Announcement',	'Announce new features to users',	1,	'immediate',	'["email","in_app"]',	'new_feature',	'New Feature: Check out what''s new!',	'{}',	2,	1,	3,	24,	1,	NULL,	'2025-12-06 17:17:17',	'2025-12-09 06:59:03'),
(23,	'upgrade_suggestion',	'marketing',	'Upgrade Suggestion',	'Suggest plan upgrade when hitting limits',	0,	'daily',	'["in_app"]',	'upgrade_suggestion',	'Unlock more with an upgrade',	'{"show_after_limit_hits":3}',	1,	1,	3,	24,	1,	NULL,	'2025-12-06 17:17:17',	'2025-12-09 06:59:03');

DROP TABLE IF EXISTS "payment_methods";
DROP SEQUENCE IF EXISTS payment_methods_id_seq;
CREATE SEQUENCE payment_methods_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."payment_methods" (
    "id" bigint DEFAULT nextval('payment_methods_id_seq') NOT NULL,
    "user_uuid" character varying(255) NOT NULL,
    "stripe_customer_id" character varying(255) NOT NULL,
    "stripe_payment_method_id" character varying(255),
    "type" text DEFAULT 'card' NOT NULL,
    "brand" character varying(50),
    "last4" character varying(4),
    "exp_month" bigint,
    "exp_year" bigint,
    "funding" text,
    "country" character varying(2),
    "billing_details" text,
    "is_default" smallint DEFAULT '0' NOT NULL,
    "status" text DEFAULT 'active' NOT NULL,
    "fingerprint" character varying(255),
    "wallet" character varying(50),
    "metadata" text,
    "createdat" timestamp NOT NULL,
    "updatedat" timestamp NOT NULL,
    CONSTRAINT "idx_17257_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

COMMENT ON COLUMN "insocial_mysql"."payment_methods"."user_uuid" IS 'User UUID reference';

COMMENT ON COLUMN "insocial_mysql"."payment_methods"."stripe_customer_id" IS 'Stripe customer ID';

COMMENT ON COLUMN "insocial_mysql"."payment_methods"."type" IS 'Payment method type';

COMMENT ON COLUMN "insocial_mysql"."payment_methods"."brand" IS 'Card brand (visa, mastercard, amex, etc.)';

COMMENT ON COLUMN "insocial_mysql"."payment_methods"."last4" IS 'Last 4 digits';

COMMENT ON COLUMN "insocial_mysql"."payment_methods"."exp_month" IS 'Card expiration month';

COMMENT ON COLUMN "insocial_mysql"."payment_methods"."exp_year" IS 'Card expiration year';

COMMENT ON COLUMN "insocial_mysql"."payment_methods"."funding" IS 'Card funding type';

COMMENT ON COLUMN "insocial_mysql"."payment_methods"."country" IS 'Card issuing country';

COMMENT ON COLUMN "insocial_mysql"."payment_methods"."billing_details" IS 'Billing details (name, email, address)';

COMMENT ON COLUMN "insocial_mysql"."payment_methods"."is_default" IS 'Is this the default payment method';

COMMENT ON COLUMN "insocial_mysql"."payment_methods"."status" IS 'Payment method status';

COMMENT ON COLUMN "insocial_mysql"."payment_methods"."fingerprint" IS 'Card fingerprint for duplicate detection';

COMMENT ON COLUMN "insocial_mysql"."payment_methods"."wallet" IS 'Digital wallet type (apple_pay, google_pay, etc.)';

COMMENT ON COLUMN "insocial_mysql"."payment_methods"."metadata" IS 'Additional metadata';

CREATE UNIQUE INDEX idx_17257_stripe_payment_method_id ON insocial_mysql.payment_methods USING btree (stripe_payment_method_id);

INSERT INTO "payment_methods" ("id", "user_uuid", "stripe_customer_id", "stripe_payment_method_id", "type", "brand", "last4", "exp_month", "exp_year", "funding", "country", "billing_details", "is_default", "status", "fingerprint", "wallet", "metadata", "createdat", "updatedat") VALUES
(1,	'9e47ed0e-73f7-41d5-9dac-5c37b8df8a4f',	'cus_TZHNim28DTlc56',	'pm_1Sc8r5HpVJPrOqLkGD0xuD2V',	'card',	'visa',	'1111',	11,	2034,	'credit',	'US',	'{"address":{"city":null,"country":"IN","line1":null,"line2":null,"postal_code":null,"state":null},"email":"developer0945@gmail.com","name":"Sudhir Ku","phone":"(714) 781-4565","tax_id":null}',	0,	'active',	'G95Ez9iUIsKX1A0j',	NULL,	NULL,	'2025-12-08 18:08:18',	'2025-12-08 18:08:18'),
(2,	'6f4362d5-744c-446e-8108-8db805396e51',	'cus_TZI0IIGiL6g3IG',	'pm_1Sc9R4HpVJPrOqLkOXnfcKFb',	'card',	'visa',	'1111',	2,	2034,	'credit',	'US',	'{"address":{"city":null,"country":"IN","line1":null,"line2":null,"postal_code":null,"state":null},"email":"developerw0945@gmail.com","name":"Baljeet Singh","phone":"(714) 781-4565","tax_id":null}',	0,	'active',	'G95Ez9iUIsKX1A0j',	NULL,	NULL,	'2025-12-08 18:45:28',	'2025-12-08 18:45:28');

DROP TABLE IF EXISTS "permissions";
DROP SEQUENCE IF EXISTS permissions_id_seq;
CREATE SEQUENCE permissions_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."permissions" (
    "id" bigint DEFAULT nextval('permissions_id_seq') NOT NULL,
    "name" character varying(255) NOT NULL,
    "display_name" character varying(255) DEFAULT '' NOT NULL,
    "description" character varying(255),
    "group" character varying(255) DEFAULT '' NOT NULL,
    "created_at" timestamptz,
    "updated_at" timestamptz,
    CONSTRAINT "idx_17273_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE UNIQUE INDEX idx_17273_permissions_name_unique ON insocial_mysql.permissions USING btree (name);

INSERT INTO "permissions" ("id", "name", "display_name", "description", "group", "created_at", "updated_at") VALUES
(1,	'view_customers',	'View Customers',	'View customer list and details',	'customers',	'2025-11-28 15:26:07+00',	'2025-11-28 15:26:07+00'),
(2,	'edit_customers',	'Edit Customers',	'Edit customer information',	'customers',	'2025-11-28 15:26:08+00',	'2025-11-28 15:26:08+00'),
(3,	'delete_customers',	'Delete Customers',	'Delete customers',	'customers',	'2025-11-28 15:26:08+00',	'2025-11-28 15:26:08+00'),
(4,	'view_subscriptions',	'View Subscriptions',	'View subscription list and details',	'subscriptions',	'2025-11-28 15:26:08+00',	'2025-11-28 15:26:08+00'),
(5,	'manage_subscriptions',	'Manage Subscriptions',	'Create, edit, and cancel subscriptions',	'subscriptions',	'2025-11-28 15:26:08+00',	'2025-11-28 15:26:08+00'),
(6,	'view_posts',	'View Posts',	'View posts and comments',	'posts',	'2025-11-28 15:26:08+00',	'2025-11-28 15:26:08+00'),
(7,	'moderate_posts',	'Moderate Posts',	'Moderate posts and comments',	'posts',	'2025-11-28 15:26:08+00',	'2025-11-28 15:26:08+00'),
(8,	'delete_posts',	'Delete Posts',	'Delete posts and comments',	'posts',	'2025-11-28 15:26:08+00',	'2025-11-28 15:26:08+00'),
(9,	'view_campaigns',	'View Campaigns',	'View campaigns and ads',	'campaigns',	'2025-11-28 15:26:09+00',	'2025-11-28 15:26:09+00'),
(10,	'manage_campaigns',	'Manage Campaigns',	'Create, edit, and delete campaigns',	'campaigns',	'2025-11-28 15:26:09+00',	'2025-11-28 15:26:09+00'),
(11,	'view_analytics',	'View Analytics',	'View analytics and reports',	'analytics',	'2025-11-28 15:26:09+00',	'2025-11-28 15:26:09+00'),
(12,	'export_analytics',	'Export Analytics',	'Export analytics data',	'analytics',	'2025-11-28 15:26:09+00',	'2025-11-28 15:26:09+00'),
(13,	'view_inbox',	'View Inbox',	'View inbox messages',	'inbox',	'2025-11-28 15:26:09+00',	'2025-11-28 15:26:09+00'),
(14,	'reply_inbox',	'Reply Inbox',	'Reply to inbox messages',	'inbox',	'2025-11-28 15:26:09+00',	'2025-11-28 15:26:09+00'),
(15,	'view_kb',	'View Knowledge Base',	'View knowledge base articles',	'knowledge_base',	'2025-11-28 15:26:09+00',	'2025-11-28 15:26:09+00'),
(16,	'manage_kb',	'Manage Knowledge Base',	'Create, edit, and delete knowledge base articles',	'knowledge_base',	'2025-11-28 15:26:10+00',	'2025-11-28 15:26:10+00'),
(17,	'view_settings',	'View Settings',	'View system settings',	'settings',	'2025-11-28 15:26:10+00',	'2025-11-28 15:26:10+00'),
(18,	'manage_settings',	'Manage Settings',	'Edit system settings',	'settings',	'2025-11-28 15:26:10+00',	'2025-11-28 15:26:10+00'),
(19,	'view_activities',	'View Activities',	'View activity logs',	'activities',	'2025-11-28 15:26:10+00',	'2025-11-28 15:26:10+00'),
(20,	'view_admin_users',	'View Admin Users',	'View admin users list',	'admin_users',	'2025-11-28 15:26:10+00',	'2025-11-28 15:26:10+00'),
(21,	'manage_admin_users',	'Manage Admin Users',	'Create, edit, and delete admin users',	'admin_users',	'2025-11-28 15:26:10+00',	'2025-11-28 15:26:10+00');

DROP TABLE IF EXISTS "post_comments";
DROP SEQUENCE IF EXISTS post_comments_id_seq;
CREATE SEQUENCE post_comments_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."post_comments" (
    "id" bigint DEFAULT nextval('post_comments_id_seq') NOT NULL,
    "user_uuid" character varying(255),
    "social_userid" character varying(255),
    "platform_page_id" character varying(255),
    "platform" character varying(255),
    "post_id" character varying(255),
    "activity_id" character varying(255),
    "comment_id" character varying(255),
    "parent_comment_id" character varying(255),
    "from_id" character varying(255),
    "from_name" character varying(255),
    "comment" character varying(255),
    "comment_created_time" character varying(255),
    "comment_type" character varying(255),
    "comment_behavior" character varying(255),
    "reaction_like" bigint DEFAULT '0' NOT NULL,
    "reaction_love" bigint DEFAULT '0' NOT NULL,
    "reaction_haha" bigint DEFAULT '0' NOT NULL,
    "reaction_wow" bigint DEFAULT '0' NOT NULL,
    "reaction_sad" bigint DEFAULT '0' NOT NULL,
    "reaction_angry" bigint DEFAULT '0' NOT NULL,
    "createdat" timestamptz DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "updatedat" timestamptz DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT "idx_17305_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

INSERT INTO "post_comments" ("id", "user_uuid", "social_userid", "platform_page_id", "platform", "post_id", "activity_id", "comment_id", "parent_comment_id", "from_id", "from_name", "comment", "comment_created_time", "comment_type", "comment_behavior", "reaction_like", "reaction_love", "reaction_haha", "reaction_wow", "reaction_sad", "reaction_angry", "createdat", "updatedat") VALUES
(1253,	'e5266555-8859-4f96-bab0-6596b9736d94',	'eRLsKrw_6N',	'75609893',	'linkedin',	'urn:li:share:7376480516033871873',	'urn:li:activity:7376480517786959872',	'7377276546195234816',	NULL,	'urn:li:person:vJUiGhJ_Dk',	'LinkedIn User',	'Shubh Navratri 🙏',	'2025-09-26T09:43:11+0000',	'top_level',	NULL,	0,	0,	0,	0,	0,	0,	'2025-10-18 10:17:20+00',	'2025-10-18 10:17:20+00'),
(1254,	'e5266555-8859-4f96-bab0-6596b9736d94',	'eRLsKrw_6N',	'75609893',	'linkedin',	'urn:li:share:7376126191029669888',	'urn:li:activity:7376126192824799232',	'7376551953293746176',	NULL,	'urn:li:organization:75609893',	'Page Admin',	'Jai mata di 🙌',	'2025-09-24T09:43:55+0000',	'top_level',	NULL,	0,	0,	0,	0,	0,	0,	'2025-10-18 10:17:21+00',	'2025-10-18 10:17:21+00'),
(1255,	'e5266555-8859-4f96-bab0-6596b9736d94',	'eRLsKrw_6N',	'75609893',	'linkedin',	'urn:li:share:7377209348424388608',	'urn:li:activity:7377209350660030464',	'7379095534294331392',	NULL,	'urn:li:person:vJUiGhJ_Dk',	'LinkedIn User',	'Jai mata di',	'2025-10-01T10:11:12+0000',	'top_level',	NULL,	0,	0,	0,	0,	0,	0,	'2025-10-18 10:17:22+00',	'2025-10-18 10:17:22+00'),
(1256,	'e5266555-8859-4f96-bab0-6596b9736d94',	'eRLsKrw_6N',	'75609893',	'linkedin',	'urn:li:share:7376850215343083520',	'urn:li:activity:7376850217016635392',	'7377276123371536384',	NULL,	'urn:li:person:vJUiGhJ_Dk',	'LinkedIn User',	'Jai Mata Kushmanda 🙌🙏',	'2025-09-26T09:41:30+0000',	'top_level',	NULL,	0,	0,	0,	0,	0,	0,	'2025-10-18 10:17:24+00',	'2025-10-18 10:17:24+00'),
(1257,	'e5266555-8859-4f96-bab0-6596b9736d94',	'eRLsKrw_6N',	'75609893',	'linkedin',	'urn:li:share:7377917991109394432',	'urn:li:activity:7377917992829050880',	'7378056333943816192',	NULL,	'urn:li:person:vJUiGhJ_Dk',	'LinkedIn User',	'Jai MaaKalratri 🙏🙌🙌',	'2025-09-28T13:21:47+0000',	'top_level',	NULL,	0,	0,	0,	0,	0,	0,	'2025-10-18 10:17:26+00',	'2025-10-18 10:17:26+00'),
(1258,	'e5266555-8859-4f96-bab0-6596b9736d94',	'eRLsKrw_6N',	'75609893',	'linkedin',	'urn:li:share:7377568205457846272',	'urn:li:activity:7377568207378841601',	'7377569469658968064',	NULL,	'urn:li:person:vJUiGhJ_Dk',	'LinkedIn User',	'Jai Mata Di 🙏 Jai Katyayni Maa 🙌🙌🙏',	'2025-09-27T05:07:10+0000',	'top_level',	NULL,	0,	0,	0,	0,	0,	0,	'2025-10-18 10:17:28+00',	'2025-10-18 10:17:28+00'),
(1459,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	'631102136744766_122163401300791773',	NULL,	'122163401300791773_1175511084239477',	NULL,	'10067541213280817',	'Ross Singh',	'Good post',	'2025-11-12T07:45:00+0000',	'top_level',	NULL,	0,	0,	0,	0,	0,	0,	'2025-12-04 12:50:27+00',	'2025-12-04 12:50:27+00'),
(1460,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	'631102136744766_122159895062791773',	NULL,	'122159895062791773_1378335096995458',	NULL,	NULL,	NULL,	'A good post that everyone liked.',	'2025-11-07T12:38:53+0000',	'top_level',	NULL,	0,	0,	0,	0,	0,	0,	'2025-12-04 12:50:28+00',	'2025-12-04 12:50:28+00'),
(1461,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	'631102136744766_122159895062791773',	NULL,	'122159895062791773_1345116487000345',	'122159895062791773_1378335096995458',	'631102136744766',	'Webonx',	'Thanks so much for the kind words! We''re glad you enjoyed the post 😊',	'2025-11-07T12:39:11+0000',	'reply',	NULL,	0,	0,	0,	0,	0,	0,	'2025-12-04 12:50:28+00',	'2025-12-04 12:50:28+00'),
(1462,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	'631102136744766_122159895062791773',	NULL,	'122159895062791773_1752451508724247',	'122159895062791773_1378335096995458',	'631102136744766',	'Webonx',	'Thank you',	'2025-11-07T12:42:32+0000',	'reply',	NULL,	0,	0,	0,	0,	0,	0,	'2025-12-04 12:50:29+00',	'2025-12-04 12:50:29+00'),
(1463,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	'631102136744766_122159895062791773',	NULL,	'122159895062791773_1998559480897694',	'122159895062791773_1378335096995458',	'631102136744766',	'Webonx',	'thanks',	'2025-11-07T12:43:40+0000',	'reply',	NULL,	0,	0,	0,	0,	0,	0,	'2025-12-04 12:50:29+00',	'2025-12-04 12:50:29+00'),
(1464,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	'631102136744766_122159895062791773',	NULL,	'122159895062791773_1185704263530147',	NULL,	NULL,	NULL,	'Like the post',	'2025-11-07T12:36:59+0000',	'top_level',	NULL,	0,	0,	0,	0,	0,	0,	'2025-12-04 12:50:30+00',	'2025-12-04 12:50:30+00'),
(1465,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	'631102136744766_122159895062791773',	NULL,	'122159895062791773_2300312390390012',	'122159895062791773_1185704263530147',	'631102136744766',	'Webonx',	'Glad you liked it! Thanks for sharing your appreciation. 😊',	'2025-11-07T12:37:18+0000',	'reply',	NULL,	0,	0,	0,	0,	0,	0,	'2025-12-04 12:50:30+00',	'2025-12-04 12:50:30+00'),
(1466,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	'631102136744766_122159895062791773',	NULL,	'122159895062791773_1526693952099443',	NULL,	NULL,	NULL,	'Amazing post ☺',	'2025-11-07T12:21:42+0000',	'top_level',	NULL,	0,	0,	0,	0,	0,	0,	'2025-12-04 12:50:31+00',	'2025-12-04 12:50:31+00'),
(1467,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	'631102136744766_122159895062791773',	NULL,	'122159895062791773_1859813137949891',	NULL,	NULL,	NULL,	'Nyc post, like the new change.',	'2025-11-07T11:43:23+0000',	'top_level',	NULL,	0,	0,	0,	0,	0,	0,	'2025-12-04 12:50:31+00',	'2025-12-04 12:50:31+00'),
(1468,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	'631102136744766_122159895062791773',	NULL,	'122159895062791773_1756313345089161',	'122159895062791773_1859813137949891',	'631102136744766',	'Webonx',	'Thanks for the kind words! Glad you''re enjoying the content. 😊',	'2025-11-07T11:43:42+0000',	'reply',	NULL,	0,	0,	0,	0,	0,	0,	'2025-12-04 12:50:32+00',	'2025-12-04 12:50:32+00'),
(1469,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	'631102136744766_122159895062791773',	NULL,	'122159895062791773_795349753488120',	NULL,	NULL,	NULL,	'I didn''t understand why this post you should post on technology not on history.',	'2025-11-07T07:02:39+0000',	'top_level',	NULL,	0,	0,	0,	0,	0,	0,	'2025-12-04 12:50:32+00',	'2025-12-04 12:50:32+00'),
(1470,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	'631102136744766_122159895062791773',	NULL,	'122159895062791773_830985916003511',	'122159895062791773_795349753488120',	'631102136744766',	'Webonx',	'Thanks for sharing your thoughts! This post is actually part of our "On This Day" series, where we explore significant historical events. We hope you find it interesting!',	'2025-11-07T07:02:56+0000',	'reply',	NULL,	0,	0,	0,	0,	0,	0,	'2025-12-04 12:50:33+00',	'2025-12-04 12:50:33+00'),
(1471,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	'631102136744766_122159895062791773',	NULL,	'122159895062791773_1792196494989549',	NULL,	NULL,	NULL,	'Very nice post',	'2025-10-27T10:26:07+0000',	'top_level',	NULL,	0,	0,	0,	0,	0,	0,	'2025-12-04 12:50:33+00',	'2025-12-04 12:50:33+00'),
(1472,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	'631102136744766_122158279538791773',	NULL,	'122158279538791773_2620525598321939',	NULL,	NULL,	NULL,	'Happy Dussehra! May light always conquer darkness.',	'2025-11-07T07:13:46+0000',	'top_level',	NULL,	0,	0,	0,	0,	0,	0,	'2025-12-04 12:50:34+00',	'2025-12-04 12:50:34+00'),
(1473,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	'631102136744766_122158279538791773',	NULL,	'122158279538791773_9301644016625930',	'122158279538791773_2620525598321939',	'631102136744766',	'Webonx',	'Happy Dussehra to you too! We absolutely agree, may light always conquer darkness! ✨',	'2025-11-07T07:14:04+0000',	'reply',	NULL,	0,	0,	0,	0,	0,	0,	'2025-12-04 12:50:34+00',	'2025-12-04 12:50:34+00'),
(1474,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	'631102136744766_122158279538791773',	NULL,	'122158279538791773_2603879113303529',	NULL,	NULL,	NULL,	'',	'2025-11-07T07:10:00+0000',	'top_level',	NULL,	0,	0,	0,	0,	0,	0,	'2025-12-04 12:50:35+00',	'2025-12-04 12:50:35+00'),
(1475,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	'631102136744766_122158279538791773',	NULL,	'122158279538791773_1722343108437384',	'122158279538791773_2603879113303529',	'631102136744766',	'Webonx',	'Happy Dussehra to you too! We wish everyone a day filled with positivity and new beginnings. What negativity are you letting go of this Dussehra?',	'2025-11-07T07:10:15+0000',	'reply',	NULL,	0,	0,	0,	0,	0,	0,	'2025-12-04 12:50:35+00',	'2025-12-04 12:50:35+00'),
(1476,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	'631102136744766_122158279538791773',	NULL,	'122158279538791773_2132990280565802',	NULL,	NULL,	NULL,	'Happy Dusshera',	'2025-10-27T10:26:19+0000',	'top_level',	NULL,	0,	0,	0,	0,	0,	0,	'2025-12-04 12:50:36+00',	'2025-12-04 12:50:36+00'),
(1477,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	'631102136744766_122156990918791773',	NULL,	'122156990918791773_725774017216305',	NULL,	NULL,	NULL,	'I wonder how many people know about Mr.VK Krishna. He really contribute his efforts to make our country proud.',	'2025-11-07T08:16:30+0000',	'top_level',	NULL,	0,	0,	0,	0,	0,	0,	'2025-12-04 12:50:36+00',	'2025-12-04 12:50:36+00'),
(1478,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	'631102136744766_122156990918791773',	NULL,	'122156990918791773_836058425582299',	'122156990918791773_725774017216305',	'631102136744766',	'Webonx',	'That''s a wonderful point! It''s truly important to remember and celebrate the contributions of such stalwarts to our nation.',	'2025-11-07T08:16:47+0000',	'reply',	NULL,	0,	0,	0,	0,	0,	0,	'2025-12-04 12:50:37+00',	'2025-12-04 12:50:37+00'),
(1479,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	'631102136744766_122156990918791773',	NULL,	'122156990918791773_1152713736931586',	NULL,	NULL,	NULL,	'Nyceee',	'2025-11-07T08:12:50+0000',	'top_level',	NULL,	0,	0,	0,	0,	0,	0,	'2025-12-04 12:50:37+00',	'2025-12-04 12:50:37+00'),
(1480,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	'631102136744766_122156990918791773',	NULL,	'122156990918791773_1636201881140254',	'122156990918791773_1152713736931586',	'631102136744766',	'Webonx',	'Thanks for your positive feedback! So glad you enjoyed the post 😊',	'2025-11-07T08:13:09+0000',	'reply',	NULL,	0,	0,	0,	0,	0,	0,	'2025-12-04 12:50:38+00',	'2025-12-04 12:50:38+00'),
(1481,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	'631102136744766_122156990918791773',	NULL,	'122156990918791773_1342902171180337',	NULL,	'9043735502401398',	'Aronasoft Singh',	'good post',	'2025-10-27T11:06:31+0000',	'top_level',	NULL,	0,	0,	0,	0,	0,	0,	'2025-12-04 12:50:38+00',	'2025-12-04 12:50:38+00'),
(1482,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	'631102136744766_122156751110791773',	NULL,	'122156751110791773_1645547326409366',	NULL,	NULL,	NULL,	'This is a bad Post.',	'2025-11-07T07:25:39+0000',	'top_level',	NULL,	0,	0,	0,	0,	0,	0,	'2025-12-04 12:50:39+00',	'2025-12-04 12:50:39+00'),
(1483,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	'631102136744766_122156751110791773',	NULL,	'122156751110791773_726265400496808',	'122156751110791773_1645547326409366',	'631102136744766',	'Webonx',	'We appreciate your feedback! We''re always looking for ways to improve and would love to hear more about what kind of content you''d find most valuable.',	'2025-11-07T07:25:57+0000',	'reply',	NULL,	0,	0,	0,	0,	0,	0,	'2025-12-04 12:50:39+00',	'2025-12-04 12:50:39+00'),
(1484,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	'631102136744766_122156751110791773',	NULL,	'122156751110791773_1378031010588068',	NULL,	NULL,	NULL,	'Helpful',	'2025-11-07T07:14:53+0000',	'top_level',	NULL,	0,	0,	0,	0,	0,	0,	'2025-12-04 12:50:40+00',	'2025-12-04 12:50:40+00'),
(1485,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	'631102136744766_122156751110791773',	NULL,	'122156751110791773_1228653535763359',	'122156751110791773_1378031010588068',	'631102136744766',	'Webonx',	'Glad you found it helpful! 😊',	'2025-11-07T07:15:09+0000',	'reply',	NULL,	0,	0,	0,	0,	0,	0,	'2025-12-04 12:50:40+00',	'2025-12-04 12:50:40+00'),
(1486,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	'631102136744766_122156751110791773',	NULL,	'122156751110791773_1715660542445022',	NULL,	NULL,	NULL,	'Yes bad post',	'2025-10-27T11:08:06+0000',	'top_level',	NULL,	0,	0,	0,	0,	0,	0,	'2025-12-04 12:50:41+00',	'2025-12-04 12:50:41+00'),
(1487,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	'631102136744766_122156751110791773',	NULL,	'122156751110791773_785664684305890',	NULL,	NULL,	NULL,	'I don''t like it',	'2025-10-27T11:07:52+0000',	'top_level',	NULL,	0,	0,	0,	0,	0,	0,	'2025-12-04 12:50:41+00',	'2025-12-04 12:50:41+00'),
(1488,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'631102136744766',	'facebook',	'631102136744766_122156751110791773',	NULL,	'122156751110791773_4096659347255395',	NULL,	'9043735502401398',	'Aronasoft Singh',	'not a good post',	'2025-10-27T11:06:46+0000',	'top_level',	NULL,	0,	0,	0,	0,	0,	0,	'2025-12-04 12:50:42+00',	'2025-12-04 12:50:42+00');

DROP TABLE IF EXISTS "posts";
DROP SEQUENCE IF EXISTS posts_id_seq;
CREATE SEQUENCE posts_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."posts" (
    "id" bigint DEFAULT nextval('posts_id_seq') NOT NULL,
    "user_uuid" character varying(255),
    "social_user_id" character varying(200) NOT NULL,
    "page_id" character varying(150) NOT NULL,
    "content" text NOT NULL,
    "schedule_time" character varying(250),
    "post_media" text,
    "platform_post_id" character varying(255),
    "post_platform" character varying(255),
    "source" text DEFAULT 'Platform' NOT NULL,
    "form_id" character varying(250) NOT NULL,
    "likes" bigint DEFAULT '0',
    "comments" bigint DEFAULT '0',
    "shares" bigint DEFAULT '0',
    "engagements" double precision DEFAULT '0',
    "impressions" character varying(255) DEFAULT '0',
    "unique_impressions" character varying(255) DEFAULT '0',
    "week_date" character varying(255),
    "status" text DEFAULT '0' NOT NULL,
    "createdat" timestamptz DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "updatedat" timestamptz DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT "idx_17283_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

COMMENT ON COLUMN "insocial_mysql"."posts"."status" IS '0="Draft",1="Published",2="Scheduled"';

CREATE INDEX idx_17283_page_id ON insocial_mysql.posts USING btree (page_id);

CREATE INDEX idx_17283_social_user_id ON insocial_mysql.posts USING btree (social_user_id);

INSERT INTO "posts" ("id", "user_uuid", "social_user_id", "page_id", "content", "schedule_time", "post_media", "platform_post_id", "post_platform", "source", "form_id", "likes", "comments", "shares", "engagements", "impressions", "unique_impressions", "week_date", "status", "createdat", "updatedat") VALUES
(572,	'e5266555-8859-4f96-bab0-6596b9736d94',	'eRLsKrw_6N',	'75609893',	'🔥🏹 Happy Dussehra! 🏹🔥

Today, we celebrate Dussehra, also known as Vijayadashami, a festival that marks the victory of good over evil, light over darkness, and truth over falsehood. 🌟✨

This day commemorates Lord Rama''s victory over Ravana, symbolizing that no matter how powerful evil seems, truth and righteousness will always prevail. 🙏⚔️

Across India, vibrant celebrations unfold:
🎭 Ramlila performances bringing the Ramayana to life,
🔥 Effigies of Ravana, Meghnad, and Kumbhkaran set ablaze to signify the burning away of negativity,
💐 Families and communities coming together to celebrate unity and hope.

As we witness the flames rise high, let’s also burn the Ravana within us — anger, ego, hatred, and greed — and welcome a life filled with kindness, humility, and compassion. 🌼💖

Dussehra reminds us that every challenge can be overcome with courage, faith, and perseverance.
Let this day inspire you to take a step toward victory in your own life, whether personal or professional. 🌟

💬 What negativity are you ready to let go of this Dussehra? Share with us below!

#HappyDussehra #Vijayadashami #GoodOverEvil #FestivalOfFaith #Positivity #Ramlila #DussehraCelebration',	NULL,	'https://media.licdn.com/dms/image/v2/D5622AQErk_8yPkJHDQ/feedshare-shrink_800/B56ZmjY1oKHQAk-/0/1759382822589?e=1762992000&v=beta&t=zK579tv99Rsmv10stnITsXkC_Yzt8qWfQwCLJD_puhM',	'urn:li:share:7379386415601676288',	'linkedin',	'API',	'3c619eb7-b9fe-40f9-94fa-a287c4346c7a',	4,	0,	0,	0.5166666666666666,	'55',	'29',	'2025-10-02',	'1',	'2025-10-09 09:52:56+00',	'2025-10-22 09:26:21+00'),
(573,	'e5266555-8859-4f96-bab0-6596b9736d94',	'eRLsKrw_6N',	'75609893',	'🌟🌸 Navratri 2025 Concludes with Gratitude 🌸🌟

As these nine sacred nights come to a close, let’s reflect on the divine blessings and lessons Maa Durga has bestowed upon us. 🙏

May the spirit of courage, devotion, and positivity guide us every day, helping us overcome challenges and embrace new beginnings. ✨

💬 What was your most special Navratri moment this year? Share with us in the comments!

#Navratri2025 #MaaDurgaBlessings #Gratitude #FestivalOfFaith #GoodOverEvil #SpiritualJourney #Positivity',	NULL,	'https://media.licdn.com/dms/image/v2/D5622AQFj9gv260MU1w/feedshare-shrink_1280/B56Zmerpz1IYAs-/0/1759303868687?e=1762992000&v=beta&t=ZBPyB49j-G91clM-Y5Dps7yTWpUzffOVJ9ptevCSnQY',	'urn:li:share:7379055255671640064',	'linkedin',	'API',	'ab5b27f3-93bf-48ce-826d-b95d210d7c41',	5,	0,	0,	0.5905797101449275,	'54',	'23',	'2025-10-01',	'1',	'2025-10-09 09:52:56+00',	'2025-10-22 09:26:22+00'),
(574,	'e5266555-8859-4f96-bab0-6596b9736d94',	'eRLsKrw_6N',	'75609893',	'🌸✨ Navratri Day 9 – Celebrating Maa Siddhidatri ✨🌸

On the final day of Navratri, we bow to Maa Siddhidatri, the divine mother who blesses her devotees with spiritual wisdom and fulfillment. 🌼🙏

May her grace remove ignorance and fill your life with clarity, peace, and prosperity. 💫

🥥 Offer fruits, sesame seeds, and sweets today to seek her divine blessings.

✨ Mantra: Om Devi Siddhidatryai Namah

🌺 As Navratri concludes, may we carry forward the values of strength, faith, and devotion into our lives each day. 🌟

#Navratri2025 #Day9 #MaaSiddhidatri #SpiritualGrowth #PeaceAndProsperity #FestivalOfFaith #NavratriVibes',	NULL,	'https://media.licdn.com/dms/image/v2/D5622AQHgqb3ZRsvAYA/feedshare-shrink_800/B56ZmeNpwoIAAg-/0/1759296004433?e=1762992000&v=beta&t=EaajXGGL4oWoI4UPtjdTn-PUkdSz_pJw2dLzHu-ZvOg',	'urn:li:share:7379022280321970176',	'linkedin',	'API',	'c3c7ebba-be9d-40ef-b3bf-d522458e50c9',	12,	1,	0,	1.7303921568627452,	'40',	'19',	'2025-10-01',	'1',	'2025-10-09 09:52:56+00',	'2025-10-22 09:26:23+00'),
(575,	'e5266555-8859-4f96-bab0-6596b9736d94',	'eRLsKrw_6N',	'75609893',	'🌸✨ Navratri Day 8 – Celebrating Maa Mahagauri ✨🌸

Today, we worship Maa Mahagauri, the symbol of purity, peace, and serenity. 🌼

She blesses her devotees with love, harmony, and liberation from negativity, guiding them towards a life filled with spiritual enlightenment and positivity. 🕊️

🥥 Offer coconut, white sweets, and milk-based dishes today to seek her divine blessings.

✨ Mantra: Om Devi Mahagauryai Namah

May Maa Mahagauri''s divine light fill your heart with peace, prosperity, and happiness. 💫

#Navratri2025 #Day8 #MaaMahagauri #PeaceAndProsperity #FestivalOfFaith #SpiritualVibes #Shakti',	NULL,	'https://media.licdn.com/dms/image/v2/D5622AQF4FCIf1q69hA/feedshare-shrink_800/B56ZmZSP8KI4Ag-/0/1759213324728?e=1762992000&v=beta&t=LnDpezC_kYryNFZ02LbO6RidtWuqC6FM18kgIJ71tYI',	'urn:li:share:7378675508345044992',	'linkedin',	'API',	'c59bc3aa-1b4e-4a56-b817-50602b526c4d',	3,	1,	0,	0.6944444444444444,	'58',	'26',	'2025-09-30',	'1',	'2025-10-09 09:52:56+00',	'2025-10-22 09:26:24+00'),
(576,	'e5266555-8859-4f96-bab0-6596b9736d94',	'eRLsKrw_6N',	'75609893',	'🌺🔥 Navratri Day 7 – Worshipping Maa Kaalratri 🔥🌺

Today, we honor Maa Kaalratri, the fierce and protective form of Maa Durga who destroys darkness and negativity. 🌌🙏

Though her form is fearsome, she is lovingly called Shubhankari, as she brings auspiciousness, blessings, and courage to her devotees. 💫

🍬 Offer jaggery or jaggery sweets to Maa Kaalratri today and seek her divine protection.

✨ Mantra: Om Devi Kaalratryai Namah 🪔

May her energy fill your life with fearlessness, peace, and strength. 🌟

#Navratri2025 #Day7 #MaaKaalratri #PowerAndProtection #DestroyNegativity #FestivalOfFaith #SpiritualEnergy',	NULL,	'https://media.licdn.com/dms/image/v2/D5622AQG0dtWM1jiauw/feedshare-shrink_800/B56ZmOhUXFKAAg-/0/1759032723279?e=1762992000&v=beta&t=zPYhnvuqbZ7PVrlw8bHT735JsLXWVeWAk2rFcIvmfGI',	'urn:li:share:7377917991109394432',	'linkedin',	'API',	'd2b8fa35-867b-413b-a6a1-2d8ad7b11bc0',	4,	1,	0,	2.4456521739130435,	'65',	'28',	'2025-09-28',	'1',	'2025-10-09 09:52:56+00',	'2025-10-22 09:26:25+00'),
(577,	'e5266555-8859-4f96-bab0-6596b9736d94',	'eRLsKrw_6N',	'75609893',	'🌸🪔 Navratri Day 6 – Celebrating Maa Katyayani 🌸🪔

Today, we worship Maa Katyayani, the fierce form of Goddess Durga, who blesses us with courage, strength, and protection. ⚔️🐅

May her divine energy remove all negativity and fill your life with peace, love, and victory over challenges. 🌼✨

🪔 Offer yellow flowers and honey today to seek her blessings. 🍯💛

✨ Mantra: Om Devi Katyayanyai Namah

🌟 Drop a ⚔️ in the comments if you seek Maa Katyayani’s courage and divine strength today! 🌟

#Navratri2025 #Day6 #MaaKatyayani #CourageAndStrength #FestivalOfFaith #SpiritualVibes #NavratriVibes #DivineGrace',	NULL,	'https://media.licdn.com/dms/image/v2/D5622AQHI9_hhmDY2dA/feedshare-shrink_800/B56ZmJjKsEKMAg-/0/1758949324752?e=1762992000&v=beta&t=v_NkOKjmVEbK0ecWCul-O1MKkQX6UqE4DB7hmisU_Go',	'urn:li:share:7377568205457846272',	'linkedin',	'API',	'1c15df8e-5b6f-43fe-b52a-e23eca9f5a50',	1,	1,	0,	3.7045454545454546,	'29',	'10',	'2025-09-27',	'1',	'2025-10-09 09:52:56+00',	'2025-10-22 09:26:20+00'),
(578,	'e5266555-8859-4f96-bab0-6596b9736d94',	'eRLsKrw_6N',	'75609893',	'🌸🪔 Navratri Day 5 – Celebrating Maa Skandamata 🌸🪔

Today, we worship Maa Skandamata, the symbol of love, strength, and protection, who blesses her devotees with harmony and divine wisdom. 💖🌟

May her blessings fill your home with peace, prosperity, and happiness. 🙏✨

🪔 Offer white flowers and bananas today to seek her grace. 🍌🌼

✨ Mantra: Om Devi Skandamatayai Namah

🌟 Drop a 🌸 if you seek Maa Skandamata’s blessings for your family today! 🌟

#Navratri2025 #Day5 #MaaSkandamata #DivineMother #FamilyBlessings #SpiritualVibes #FestivalOfFaith #NavratriVibes',	NULL,	'https://media.licdn.com/dms/image/v2/D5622AQHjQcsexGBm7A/feedshare-shrink_800/B56ZmEcy3gJoAg-/0/1758863766472?e=1762992000&v=beta&t=AguptK2kVpdzxoUS-7NCtDpbX3PpQ_6EFpAyEn4vPec',	'urn:li:share:7377209348424388608',	'linkedin',	'API',	'16aedef6-2f62-4fac-a630-2366a1e163f4',	4,	1,	0,	1.2956989247311828,	'60',	'20',	'2025-09-26',	'1',	'2025-10-09 09:52:56+00',	'2025-10-22 09:26:26+00'),
(579,	'e5266555-8859-4f96-bab0-6596b9736d94',	'eRLsKrw_6N',	'75609893',	'🌞🦁 Navratri Day 4 – Celebrating Maa Kushmanda 🦁🌞

Today, we worship Maa Kushmanda, the creator of the universe, who with her divine smile 🌸✨ filled the cosmos with warmth, light, and energy.

May her blessings bring health, prosperity, and positivity into your life. 🌼💫

🪔 Offer pumpkin or malpua today to seek her divine grace.

✨ Mantra: Om Devi Kushmandayai Namah

🌟 Let’s embrace the power of creation and spread light wherever we go! 🌟

#Navratri2025 #Day4 #MaaKushmanda #DivineBlessings #FestivalOfFaith #PositiveVibes #SpiritualJourney #NavratriVibes',	NULL,	'https://media.licdn.com/dms/image/v2/D5622AQERensigJ4QhA/feedshare-shrink_800/B56Zl_WKu.J8Ag-/0/1758778144486?e=1762992000&v=beta&t=zS3ZHG4pcWXcLufuROqaoKyw5YzXDatSysN69RyGrLs',	'urn:li:share:7376850215343083520',	'linkedin',	'API',	'2c730356-784e-472e-89f9-6afc30e0de3c',	6,	1,	0,	1.5357843137254903,	'94',	'34',	'2025-09-25',	'1',	'2025-10-09 09:52:57+00',	'2025-10-22 09:26:27+00'),
(580,	'e5266555-8859-4f96-bab0-6596b9736d94',	'eRLsKrw_6N',	'75609893',	'🌙🐅 Navratri Day 3 – Celebrating Maa Chandraghanta 🌙🐅

Today, we worship Maa Chandraghanta, the goddess of courage, serenity, and protection. ✨💪

She teaches us to stay calm yet strong, even in the face of difficulties. May her blessings fill our lives with peace, harmony, and positivity. 🌼🙏

🪔 Offer kheer, milk, or white-colored sweets to seek her divine grace.

✨ Mantra: Om Devi Chandraghantayai Namah

🌸 Which Navratri ritual do you enjoy the most? Share in the comments! 🌸

#Navratri2025 #Day3 #MaaChandraghanta #StrengthAndPeace #DivineGrace #FestivalOfFaith #SpiritualJourney #NavratriVibes',	NULL,	'https://media.licdn.com/dms/image/v2/D5622AQEw-1DeO5ciqA/feedshare-shrink_1280/B56Zl6F8MBJ4As-/0/1758690002964?e=1762992000&v=beta&t=VYCmcUNZgR2af2WkpcYJw3E1UW42iwM4c8ShkOXI4AA',	'urn:li:share:7376480516033871873',	'linkedin',	'API',	'1f5be2cf-7457-425e-9010-90cdc868c983',	3,	1,	0,	1.424966261808367,	'78',	'38',	'2025-09-24',	'1',	'2025-10-09 09:52:57+00',	'2025-10-22 09:26:27+00'),
(581,	'e5266555-8859-4f96-bab0-6596b9736d94',	'eRLsKrw_6N',	'75609893',	'🌸 Navratri Day 2 – Celebrating Maa Brahmacharini 🌸

Today, we honor Maa Brahmacharini, the goddess of penance and devotion, who guides us on the path of truth and spiritual awakening. 🤍✨

May her blessings bring peace, inner strength, and clarity to your life. 🙏💫

🪔 Chant her mantra: Om Devi Brahmacharinyai Namah

🌼 Let’s walk together on the path of devotion and wisdom this Navratri! 🌼

#Navratri2025 #Day2 #MaaBrahmacharini #DivineGrace #IndianFestivals #SpiritualVibes #Blessings #NavratriVibes',	NULL,	'https://media.licdn.com/dms/image/v2/D5622AQEKJlBd9OUGTg/feedshare-shrink_800/B56Zl1Drn1I0Ag-/0/1758605526276?e=1762992000&v=beta&t=ZjQP3qYIt5eKKwdCsxL7Qz92hy6r4MaPHzivMfdXH84',	'urn:li:share:7376126191029669888',	'linkedin',	'API',	'6a2be7eb-d359-4ab7-b8eb-18c7f73d8322',	4,	1,	0,	1.4224025974025973,	'76',	'32',	'2025-09-23',	'1',	'2025-10-09 09:52:57+00',	'2025-10-22 09:26:28+00'),
(582,	'e5266555-8859-4f96-bab0-6596b9736d94',	'eRLsKrw_6N',	'75609893',	'🌸 Shubh Navratri 2025! 🌸

Today marks the beginning of Navratri, a nine-day festival that celebrates the victory of good over evil, light over darkness, and positivity over negativity. ✨🙏

Each day of Navratri is dedicated to one form of Goddess Durga, symbolizing strength, courage, wisdom, and prosperity. 🌺⚔️

As the dhols beat and the air fills with devotion, let''s embrace these nine days with:
🌟 Faith to overcome challenges,
🌟 Gratitude for our blessings, and
🌟 Compassion to uplift others.

May Maa Durga shower her divine blessings on you and your loved ones with happiness, success, and good health. 🌼💫

Let’s celebrate the spirit of strength, faith, and victory of good over evil. ✨

💬 Share your Navratri wishes or how you celebrate this festival with your family in the comments below!

#Navratri2025 #ShubhNavratri #DurgaMaa #FestivalVibes #GoodOverEvil',	NULL,	'https://media.licdn.com/dms/image/v2/D5622AQF1SG3iRlROwQ/feedshare-shrink_800/B56ZlwHW.QH8Ag-/0/1758522602346?e=1762992000&v=beta&t=wlspJsJLbbjwt5F0_OAaE1B-Bir76-bIFldwo2rzJaQ',	'urn:li:share:7375778394694701056',	'linkedin',	'API',	'95a0fac9-005f-471c-999a-dd7c3e62bfa1',	2,	0,	0,	2.5211426000899686,	'66',	'24',	'2025-09-22',	'1',	'2025-10-09 09:52:57+00',	'2025-10-22 09:26:28+00'),
(583,	'e5266555-8859-4f96-bab0-6596b9736d94',	'eRLsKrw_6N',	'75609893',	'🏑 National Sports Day

Today, we remember a true legend — Major Dhyan Chand, whose passion for hockey made India shine on the world stage. His dedication was so deep that he would practice even at night under the moonlight, which gave him the name “Chand.” 🌙

From winning Olympic golds in 1928, 1932, and 1936, to inspiring generations with his discipline and humility, Major Dhyan Chand’s story is not just about sports — it’s about dreams, resilience, and national pride.

On this day, let’s celebrate the spirit of sports that teaches us to work as a team, rise after every fall, and keep pushing forward with courage. 💪🇮🇳

Happy National Sports Day!

#NationalSportsDay #MajorDhyanChand #PrideOfIndia #SportsSpirit #JaiHind',	NULL,	'https://media.licdn.com/dms/image/v2/D5622AQGvYuj_80Ix_A/feedshare-shrink_800/B56Zj1VmqpH8Ak-/0/1756462738725?e=1762992000&v=beta&t=7HE_nI6kGDts6S0VjRZdeEcPcEn7yDb5A9lrxnNEaJA',	'urn:li:share:7367138704718512128',	'linkedin',	'API',	'e58e06b1-7369-4850-8904-a33b7716540e',	4,	0,	0,	0.875,	'98',	'48',	'2025-08-29',	'1',	'2025-10-09 09:52:57+00',	'2025-10-22 09:26:29+00'),
(584,	'e5266555-8859-4f96-bab0-6596b9736d94',	'eRLsKrw_6N',	'75609893',	'✨ Celebrating Janmashtami 2025 ✨

Today, as we celebrate the birth of Lord Krishna, we are reminded of the timeless values He stood for—wisdom, resilience, compassion, and the courage to choose what is right over what is easy.

Janmashtami is not just a festival of devotion; it’s also an inspiration to bring balance in our lives—between work and growth, success and humility, leadership and service. Just as Krishna’s flute symbolizes harmony, may we all create workplaces and communities that thrive on collaboration, trust, and shared purpose.

🌸 Wishing you and your loved ones a joyful Janmashtami filled with positivity, peace, and progress.

#Janmashtami #Leadership #Inspiration #Celebration',	NULL,	'https://media.licdn.com/dms/image/v2/D5622AQE4kReOtTowBg/feedshare-shrink_2048_1536/B56ZixTaxwHQAo-/0/1755321314746?e=1762992000&v=beta&t=ciTUBN-a4vBe8wSxMVkTDhc4kstp-ngQ4-zFYnF_Rqg',	'urn:li:share:7362351211490000898',	'linkedin',	'API',	'a15b1e53-52a4-41cc-ab0c-ac250fb91ed5',	3,	0,	0,	0.6111111111111112,	'76',	'36',	'2025-08-16',	'1',	'2025-10-09 09:52:57+00',	'2025-10-22 09:26:29+00'),
(585,	'e5266555-8859-4f96-bab0-6596b9736d94',	'eRLsKrw_6N',	'75609893',	'🌟 🇮🇳 Happy Independence Day 2025! 🇮🇳 🌟

Today, we celebrate 78 years of freedom — a journey built on sacrifice, courage, and unshakable determination. 🙌✨

💚 The green reminds us of growth, harmony, and progress.
🤍 The white stands for peace, truth, and unity.
🧡 The saffron inspires us with strength, courage, and resilience.
And at the heart of it all, the Ashoka Chakra represents motion, reminding us that a nation moves forward only when its people move forward together. 🔄💪

This day is not just a reminder of our past, but a reflection of who we are today — innovators, dreamers, and changemakers determined to shape the India of tomorrow. 🚀🌍

Let’s honor this freedom by building, contributing, and standing united for a future that reflects the values of our tricolor.

✨💚🤍🧡 Jai Hind! ✨

#AzadiKaAmritMahotsav #IndependenceDay2025 #IndiaAt79 #HappyIndependenceDay #JaiHind #IndianIndependenceDay #IncredibleIndia #ProudIndian #IndependenceDayIndia #IndiaCelebrates #Tricolor #IndianFlag',	NULL,	'https://media.licdn.com/dms/image/v2/D5622AQF8To1eySetwA/feedshare-shrink_800/B56ZitmKX1G0Ag-/0/1755259120324?e=1762992000&v=beta&t=rz3ViJz_DlM2bbT1Ixcvg3DO1EylrErplYgxscD2LjE',	'urn:li:share:7362090350334656512',	'linkedin',	'API',	'ebeb74cb-8756-44fc-a365-c014a4700fd4',	2,	0,	0,	0.7083333333333333,	'69',	'31',	'2025-08-15',	'1',	'2025-10-09 09:52:57+00',	'2025-10-22 09:26:30+00'),
(632,	'e5266555-8859-4f96-bab0-6596b9736d94',	'eRLsKrw_6N',	'75609893',	'🌟 On This Day — October 14 🌟

From acts of conviction to turning points in global power — today’s history speaks to bravery, transformation, and the cost of change.

🇮🇳 In India, Dr. Ambedkar’s embrace of Buddhism remains a profound symbol: a man who gave his life to equality chose faith as a final act of truth.
🏰 In England, the Battle of Hastings redefined a nation’s identity.
🚀 For the world, the Cuban Missile Crisis reminded us how fragile peace can be.

Let these moments inspire us — to act with integrity, to learn from the past, and to stand up for what matters.

❓ Which of these events resonates with you most — and why? Share your reflections below.

#OnThisDay #October14 #Ambedkar #BattleOfHastings #CubanMissileCrisis #HistoryMatters #Legacy',	NULL,	'https://media.licdn.com/dms/image/v2/D5622AQGgzD6_PNlmvQ/feedshare-shrink_800/B56ZniMCARG4Ak-/0/1760436429690?e=1762992000&v=beta&t=JCSh8-RxCd-jDQgve05B2wHNph1inlvWu-olOVGlJ1M',	'urn:li:share:7383805559751434240',	'linkedin',	'API',	'c911db4a-b711-45f9-9270-27c94a3da57f',	3,	0,	0,	0.5214285714285715,	'25',	'11',	'2025-10-14',	'1',	'2025-10-22 09:26:18+00',	'2025-10-22 09:26:18+00');

DROP TABLE IF EXISTS "role_has_permissions";
CREATE TABLE "insocial_mysql"."role_has_permissions" (
    "permission_id" numeric NOT NULL,
    "role_id" numeric NOT NULL,
    CONSTRAINT "idx_17343_primary" PRIMARY KEY ("permission_id", "role_id")
)
WITH (oids = false);

CREATE INDEX idx_17343_role_has_permissions_role_id_foreign ON insocial_mysql.role_has_permissions USING btree (role_id);


DROP TABLE IF EXISTS "role_permission";
CREATE TABLE "insocial_mysql"."role_permission" (
    "role_id" numeric NOT NULL,
    "permission_id" numeric NOT NULL,
    CONSTRAINT "idx_17348_primary" PRIMARY KEY ("role_id", "permission_id")
)
WITH (oids = false);

CREATE INDEX idx_17348_role_permission_permission_id_foreign ON insocial_mysql.role_permission USING btree (permission_id);

INSERT INTO "role_permission" ("role_id", "permission_id") VALUES
(1,	1),
(1,	2),
(1,	3),
(1,	4),
(1,	5),
(1,	6),
(1,	7),
(1,	8),
(1,	9),
(1,	10),
(1,	11),
(1,	12),
(1,	13),
(1,	14),
(1,	15),
(1,	16),
(1,	17),
(1,	18),
(1,	19),
(1,	20),
(1,	21),
(2,	1),
(2,	2),
(2,	3),
(2,	4),
(2,	5),
(2,	6),
(2,	7),
(2,	8),
(2,	9),
(2,	10),
(2,	11),
(2,	12),
(2,	13),
(2,	14),
(2,	15),
(2,	16),
(2,	17),
(2,	18),
(2,	19),
(3,	6),
(3,	7),
(3,	8),
(3,	13),
(3,	14),
(4,	1),
(4,	4),
(4,	6),
(4,	9),
(4,	11),
(4,	13),
(4,	15),
(4,	17),
(4,	19);

DROP TABLE IF EXISTS "roles";
DROP SEQUENCE IF EXISTS roles_id_seq;
CREATE SEQUENCE roles_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."roles" (
    "id" bigint DEFAULT nextval('roles_id_seq') NOT NULL,
    "name" character varying(255) NOT NULL,
    "display_name" character varying(255) DEFAULT '' NOT NULL,
    "description" character varying(255),
    "is_super_admin" smallint DEFAULT '0',
    "created_at" timestamptz,
    "updated_at" timestamptz,
    CONSTRAINT "idx_17334_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE UNIQUE INDEX idx_17334_roles_name_unique ON insocial_mysql.roles USING btree (name);

INSERT INTO "roles" ("id", "name", "display_name", "description", "is_super_admin", "created_at", "updated_at") VALUES
(1,	'super_admin',	'Super Admin',	'Full access to all features',	1,	'2025-11-28 15:26:11+00',	'2025-11-28 15:26:11+00'),
(2,	'admin',	'Admin',	'Administrative access with some restrictions',	0,	'2025-11-28 15:26:12+00',	'2025-11-28 15:26:12+00'),
(3,	'moderator',	'Moderator',	'Content moderation access',	0,	'2025-11-28 15:26:14+00',	'2025-11-28 15:26:14+00'),
(4,	'viewer',	'Viewer',	'Read-only access',	0,	'2025-11-28 15:26:14+00',	'2025-11-28 15:26:14+00');

DROP TABLE IF EXISTS "saved_reports";
DROP SEQUENCE IF EXISTS saved_reports_id_seq;
CREATE SEQUENCE saved_reports_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."saved_reports" (
    "id" bigint DEFAULT nextval('saved_reports_id_seq') NOT NULL,
    "user_uuid" character varying(255) NOT NULL,
    "report_name" character varying(255) NOT NULL,
    "report_type" character varying(255) NOT NULL,
    "selected_metrics" text,
    "date_range" text,
    "export_format" character varying(255) DEFAULT 'excel',
    "report_data" text,
    "file_path" character varying(255),
    "status" text DEFAULT 'Ready',
    "createdat" timestamp NOT NULL,
    "updatedat" timestamp NOT NULL,
    CONSTRAINT "idx_17354_primary" PRIMARY KEY ("id")
)
WITH (oids = false);


DROP TABLE IF EXISTS "sessions";
CREATE TABLE "insocial_mysql"."sessions" (
    "id" character varying(255) NOT NULL,
    "user_id" numeric,
    "ip_address" character varying(45),
    "user_agent" text,
    "payload" text NOT NULL,
    "last_activity" bigint NOT NULL,
    CONSTRAINT "idx_17363_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE INDEX idx_17363_sessions_user_id_index ON insocial_mysql.sessions USING btree (user_id);

CREATE INDEX idx_17363_sessions_last_activity_index ON insocial_mysql.sessions USING btree (last_activity);

INSERT INTO "sessions" ("id", "user_id", "ip_address", "user_agent", "payload", "last_activity") VALUES
('UKdjrfHQ57wJZ0CG6bFXrhCsSSl5zSFCt5hvdZW9',	2,	'172.31.79.34',	'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',	'YTo0OntzOjY6Il90b2tlbiI7czo0MDoic2xjZ2owbEhXUWJvbng3MXdObTU1SkVrTDVZN0hMc1NqaXlwVk1TciI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTY6Imh0dHA6Ly80ZDkxZTU3Yi1mY2Q5LTRlMTgtOGI0MC0zZTU0M2E5NjY4ZjUtMDAtMW5ocnhsY3ZsMjNmcC5raXJrLnJlcGxpdC5kZXYvYWRtaW4vc3Vic2NyaXB0aW9ucyI7czo1OiJyb3V0ZSI7czoyNToiYWRtaW4uc3Vic2NyaXB0aW9ucy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTI6ImxvZ2luX2FkbWluXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9',	1765047463);

DROP TABLE IF EXISTS "settings";
DROP SEQUENCE IF EXISTS settings_id_seq;
CREATE SEQUENCE settings_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."settings" (
    "id" bigint DEFAULT nextval('settings_id_seq') NOT NULL,
    "user_uuid" character varying(255),
    "module_name" text DEFAULT 'Comment' NOT NULL,
    "module_status" smallint DEFAULT '0' NOT NULL,
    "createdat" timestamptz DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "updatedat" timestamptz DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT "idx_17370_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

COMMENT ON COLUMN "insocial_mysql"."settings"."module_status" IS '0="InActive",1="Active"';

INSERT INTO "settings" ("id", "user_uuid", "module_name", "module_status", "createdat", "updatedat") VALUES
(1,	'b4206492-1778-4860-8e24-af93296a37d4',	'Comment',	1,	'2025-06-17 11:59:47+00',	'2025-11-06 13:00:16+00'),
(2,	'b4206492-1778-4860-8e24-af93296a37d4',	'Message',	1,	'2025-06-23 09:38:29+00',	'2025-09-03 10:34:18+00'),
(3,	'e5266555-8859-4f96-bab0-6596b9736d94',	'Comment',	0,	'2025-10-09 10:16:08+00',	'2025-10-10 12:31:23+00'),
(4,	'ed39bbef-67a2-437d-9289-69bf3911feda',	'Comment',	0,	'2025-12-05 22:15:39+00',	'2025-12-05 22:15:41+00');

DROP TABLE IF EXISTS "social_media_page_score";
DROP SEQUENCE IF EXISTS social_media_page_score_id_seq;
CREATE SEQUENCE social_media_page_score_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."social_media_page_score" (
    "id" bigint DEFAULT nextval('social_media_page_score_id_seq') NOT NULL,
    "social_score_id" bigint NOT NULL,
    "user_uuid" character varying(255) NOT NULL,
    "platform_name" character varying(100) NOT NULL,
    "page_id" character varying(255) NOT NULL,
    "page_name" character varying(255),
    "score_date" date NOT NULL,
    "score" numeric(5,2) DEFAULT '0.00',
    "engagement" bigint DEFAULT '0',
    "reach" bigint DEFAULT '0',
    "shares" bigint DEFAULT '0',
    "follower_growth_percent" numeric(5,2) DEFAULT '0.00',
    "recommendations" text NOT NULL,
    "createdat" timestamptz DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "updatedat" timestamptz,
    "overall_score" numeric(5,2) DEFAULT '0.00',
    "content_score" numeric(5,2) DEFAULT '0.00',
    "engagement_score" numeric(5,2) DEFAULT '0.00',
    "growth_score" numeric(5,2) DEFAULT '0.00',
    "consistency_score" numeric(5,2) DEFAULT '0.00',
    "calculated_at" timestamptz,
    CONSTRAINT "idx_17382_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE INDEX idx_17382_social_media_page_score_ibfk_1 ON insocial_mysql.social_media_page_score USING btree (social_score_id);

INSERT INTO "social_media_page_score" ("id", "social_score_id", "user_uuid", "platform_name", "page_id", "page_name", "score_date", "score", "engagement", "reach", "shares", "follower_growth_percent", "recommendations", "createdat", "updatedat", "overall_score", "content_score", "engagement_score", "growth_score", "consistency_score", "calculated_at") VALUES
(1,	1,	'b4206492-1778-4860-8e24-af93296a37d4',	'linkedin',	'106470960',	'Aronasoft Automations',	'2025-12-01',	0.00,	0,	0,	0,	0.00,	'{"overall": "Needs significant improvement. Focus on posting frequency and engagement quality.", "needs_improvement": ["Very low activity on page. Post more consistently to improve baseline metrics."], "good_performance": []}',	'2025-11-12 06:27:38+00',	'2025-12-01 11:12:08+00',	0.00,	0.00,	0.00,	0.00,	0.00,	NULL),
(2,	1,	'b4206492-1778-4860-8e24-af93296a37d4',	'facebook',	'621976714336919',	'Devsoft technology',	'2025-12-01',	0.00,	0,	0,	0,	0.00,	'{"overall": "Needs significant improvement. Focus on posting frequency and engagement quality.", "needs_improvement": ["Very low activity on page. Post more consistently to improve baseline metrics."], "good_performance": []}',	'2025-11-12 06:27:40+00',	'2025-12-01 11:12:10+00',	0.00,	0.00,	0.00,	0.00,	0.00,	NULL),
(3,	1,	'b4206492-1778-4860-8e24-af93296a37d4',	'facebook',	'631102136744766',	'Webonx',	'2025-12-01',	0.00,	0,	0,	0,	0.00,	'{"overall": "Needs significant improvement. Focus on posting frequency and engagement quality.", "needs_improvement": ["Very low activity on page. Post more consistently to improve baseline metrics."], "good_performance": []}',	'2025-11-12 06:27:42+00',	'2025-12-01 11:12:12+00',	0.00,	0.00,	0.00,	0.00,	0.00,	NULL),
(4,	1,	'b4206492-1778-4860-8e24-af93296a37d4',	'linkedin',	'75609893',	'Aronasoft',	'2025-12-01',	0.00,	0,	2,	0,	0.00,	'{"overall": "Needs significant improvement. Focus on posting frequency and engagement quality.", "needs_improvement": ["Very low activity on page. Post more consistently to improve baseline metrics."], "good_performance": []}',	'2025-11-12 06:27:44+00',	'2025-12-01 11:12:14+00',	0.00,	0.00,	0.00,	0.00,	0.00,	NULL),
(5,	2,	'e5266555-8859-4f96-bab0-6596b9736d94',	'facebook',	'101865419522213',	'Webonx',	'2025-12-01',	0.00,	0,	0,	0,	0.00,	'{"overall": "Needs significant improvement. Focus on posting frequency and engagement quality.", "needs_improvement": ["Very low activity on page. Post more consistently to improve baseline metrics."], "good_performance": []}',	'2025-11-12 06:27:46+00',	'2025-12-01 11:11:22+00',	0.00,	0.00,	0.00,	0.00,	0.00,	NULL),
(6,	2,	'e5266555-8859-4f96-bab0-6596b9736d94',	'facebook',	'106278878502385',	'Dogsandbeauty',	'2025-12-01',	0.00,	0,	0,	0,	0.00,	'{"overall": "Needs significant improvement. Focus on posting frequency and engagement quality.", "needs_improvement": ["Very low activity on page. Post more consistently to improve baseline metrics."], "good_performance": []}',	'2025-11-12 06:27:48+00',	'2025-12-01 11:11:24+00',	0.00,	0.00,	0.00,	0.00,	0.00,	NULL),
(7,	2,	'e5266555-8859-4f96-bab0-6596b9736d94',	'linkedin',	'108458993',	'insocialwise.com',	'2025-12-01',	0.00,	0,	0,	0,	0.00,	'{"overall": "Needs significant improvement. Focus on posting frequency and engagement quality.", "needs_improvement": ["Very low activity on page. Post more consistently to improve baseline metrics."], "good_performance": []}',	'2025-11-12 06:27:50+00',	'2025-12-01 11:11:26+00',	0.00,	0.00,	0.00,	0.00,	0.00,	NULL),
(8,	2,	'e5266555-8859-4f96-bab0-6596b9736d94',	'linkedin',	'75609893',	'Aronasoft',	'2025-12-01',	0.00,	0,	2,	0,	0.00,	'{"overall": "Needs significant improvement. Focus on posting frequency and engagement quality.", "needs_improvement": ["Very low activity on page. Post more consistently to improve baseline metrics."], "good_performance": []}',	'2025-11-12 06:27:52+00',	'2025-12-01 11:11:28+00',	0.00,	0.00,	0.00,	0.00,	0.00,	NULL);

DELIMITER ;;

CREATE TRIGGER "on_update_current_timestamp" BEFORE UPDATE ON "insocial_mysql"."social_media_page_score" FOR EACH ROW EXECUTE FUNCTION on_update_current_timestamp_social_media_page_score();;

DELIMITER ;

DROP TABLE IF EXISTS "social_media_score";
DROP SEQUENCE IF EXISTS social_media_score_id_seq;
CREATE SEQUENCE social_media_score_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."social_media_score" (
    "id" bigint DEFAULT nextval('social_media_score_id_seq') NOT NULL,
    "user_uuid" character(36) NOT NULL,
    "score_date" date NOT NULL,
    "total_score" numeric(5,2) DEFAULT '0.00',
    "total_engagement" bigint DEFAULT '0',
    "total_reach" bigint DEFAULT '0',
    "total_shares" bigint DEFAULT '0',
    "follower_growth_percent" numeric(5,2) DEFAULT '0.00',
    "total_pages" bigint DEFAULT '0',
    "recommendations" text NOT NULL,
    "createdat" timestamptz DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "updatedat" timestamptz,
    "overall_score" numeric(5,2) DEFAULT '0.00',
    "content_score" numeric(5,2) DEFAULT '0.00',
    "engagement_score" numeric(5,2) DEFAULT '0.00',
    "growth_score" numeric(5,2) DEFAULT '0.00',
    "consistency_score" numeric(5,2) DEFAULT '0.00',
    "calculated_at" timestamptz,
    CONSTRAINT "idx_17401_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

INSERT INTO "social_media_score" ("id", "user_uuid", "score_date", "total_score", "total_engagement", "total_reach", "total_shares", "follower_growth_percent", "total_pages", "recommendations", "createdat", "updatedat", "overall_score", "content_score", "engagement_score", "growth_score", "consistency_score", "calculated_at") VALUES
(1,	'b4206492-1778-4860-8e24-af93296a37d4',	'2025-12-01',	5.00,	0,	2,	0,	0.00,	4,	'{"overall": "Needs significant improvement. Focus on posting frequency and engagement quality.", "needs_improvement": ["Very low activity on page. Post more consistently to improve baseline metrics."], "good_performance": []}',	'2025-11-12 06:27:36+00',	'2025-12-01 11:12:06+00',	0.00,	0.00,	0.00,	0.00,	0.00,	NULL),
(2,	'e5266555-8859-4f96-bab0-6596b9736d94',	'2025-12-01',	5.00,	0,	2,	0,	0.00,	4,	'{"overall": "Needs significant improvement. Focus on posting frequency and engagement quality.", "needs_improvement": ["Very low activity on page. Post more consistently to improve baseline metrics."], "good_performance": []}',	'2025-11-12 06:27:36+00',	'2025-12-01 11:11:20+00',	0.00,	0.00,	0.00,	0.00,	0.00,	NULL);

DELIMITER ;;

CREATE TRIGGER "on_update_current_timestamp" BEFORE UPDATE ON "insocial_mysql"."social_media_score" FOR EACH ROW EXECUTE FUNCTION on_update_current_timestamp_social_media_score();;

DELIMITER ;

DROP TABLE IF EXISTS "social_page";
DROP SEQUENCE IF EXISTS social_page_id_seq;
CREATE SEQUENCE social_page_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."social_page" (
    "id" bigint DEFAULT nextval('social_page_id_seq') NOT NULL,
    "user_uuid" character varying(255),
    "social_userid" character varying(250) NOT NULL,
    "pagename" character varying(150) NOT NULL,
    "page_picture" text,
    "page_cover" text,
    "pageid" character varying(150) NOT NULL,
    "token" text NOT NULL,
    "category" character varying(100),
    "total_followers" bigint DEFAULT '0' NOT NULL,
    "page_platform" character varying(255),
    "status" text DEFAULT 'notConnected',
    "platform" character varying(255),
    "modify_to" text,
    "createdat" timestamptz DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "updatedat" timestamptz DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT "idx_17420_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE INDEX idx_17420_social_userid ON insocial_mysql.social_page USING btree (social_userid);

CREATE INDEX idx_17420_pageid ON insocial_mysql.social_page USING btree (pageid);

INSERT INTO "social_page" ("id", "user_uuid", "social_userid", "pagename", "page_picture", "page_cover", "pageid", "token", "category", "total_followers", "page_platform", "status", "platform", "modify_to", "createdat", "updatedat") VALUES
(67,	'e5266555-8859-4f96-bab0-6596b9736d94',	'9496988240365277',	'Webonx',	'https://scontent-pnq1-1.xx.fbcdn.net/v/t39.30808-1/334301005_920681552286608_3810439166509964792_n.jpg?stp=cp0_dst-jpg_s50x50_tt6&_nc_cat=108&ccb=1-7&_nc_sid=f907e8&_nc_ohc=rWmyJR7a-1UQ7kNvwFtXwPP&_nc_oc=Adnz2IujsIUFJthMRcn57ztdXKqwIuaIezZ0bqfZ3MKABMi7F7gBoxuXop-1kj4AwBWw1M6emhv33nPkvt170_QP&_nc_zt=24&_nc_ht=scontent-pnq1-1.xx&edm=AJdBtusEAAAA&_nc_gid=BRRM22WRUW9DUEnbgI8KVg&oh=00_AfeVeAHN5AA4iY_LTqs_rD1MAD576qwy32j_QKm848u_9Q&oe=68FEAF86',	NULL,	'101865419522213',	'EAAQvGECe4RMBQFQZCdMmvgihb8fDIOb2gYHzX2736ZC2d2wVZBXUPHNDrvH6aPUMgXRHQdU0qYQiTgVWncDo80movW2QHhmbxRh9cItoETJglZAe64sg1vQmED060L4OsejXV3wbBwTnd6Jk9cwm32zORUezAZCZCHD3olBliZAZCxOOUi4oZAxaslBvORpMs9w4QxOuHLdRakQhtmXJpQQ0ZD',	'Web Designer',	1,	'facebook',	'Connected',	NULL,	NULL,	'2025-10-10 11:43:15+00',	'2025-12-01 00:00:04+00'),
(68,	'e5266555-8859-4f96-bab0-6596b9736d94',	'eRLsKrw_6N',	'insocialwise.com',	'https://media.licdn.com/dms/image/v2/D560BAQEi6IweHdUYJA/company-logo_400_400/B56ZkKbZO3HMAk-/0/1756816577906?e=1762992000&v=beta&t=EnbsEkO1FBEWIBL6JmMj2HmeROZ1ZbHXjxr40sm9cMo',	NULL,	'108458993',	'AQVEXGOWUkRua5Rclo_juvtEfu6tpl8U1XFlnYpTBGYfH039Bl0fGd2KzTODyhq3rFZSaayML9BpcjBRqepc1pdfa_dltopZ1Ci7HMe4-jrqASgBUaq7zdG5mVFHk8Y7kIAZLM2TFw87EQfDXAe4rbqsDj5Ii1NQtQiuG1GRZ2r4OpfRfiJJco_JnPUQC_bD8xm7yE2BIARkeOS3WxPp6LyCxBSY6hv1SjiCHDVdPJ7BRejO47zPmE2f3qx9zW1npKZGfhRUJAc7UzPh1q_Qfaub3ExhgRFmLt2F9eqtd_GvAZdMtBD3EKV75tGwnP5RrXETJwqoHV9IxvF5i1DdaVFQSqiQwQ',	'Computer Software',	2,	'linkedin',	'Connected',	NULL,	'[]',	'2025-10-10 11:44:04+00',	'2025-10-22 09:25:35+00'),
(69,	'e5266555-8859-4f96-bab0-6596b9736d94',	'eRLsKrw_6N',	'Aronasoft',	'https://media.licdn.com/dms/image/v2/D560BAQFQU6szH_uFXA/company-logo_200_200/company-logo_200_200/0/1719257138534/aronasoft_logo?e=1762992000&v=beta&t=-3jh3G0l6W6lQ9YrP4QzxcDaXpoMJmXUqEbYahdi_lM',	NULL,	'75609893',	'AQVEXGOWUkRua5Rclo_juvtEfu6tpl8U1XFlnYpTBGYfH039Bl0fGd2KzTODyhq3rFZSaayML9BpcjBRqepc1pdfa_dltopZ1Ci7HMe4-jrqASgBUaq7zdG5mVFHk8Y7kIAZLM2TFw87EQfDXAe4rbqsDj5Ii1NQtQiuG1GRZ2r4OpfRfiJJco_JnPUQC_bD8xm7yE2BIARkeOS3WxPp6LyCxBSY6hv1SjiCHDVdPJ7BRejO47zPmE2f3qx9zW1npKZGfhRUJAc7UzPh1q_Qfaub3ExhgRFmLt2F9eqtd_GvAZdMtBD3EKV75tGwnP5RrXETJwqoHV9IxvF5i1DdaVFQSqiQwQ',	'Computer Software',	843,	'linkedin',	'Connected',	NULL,	'[]',	'2025-10-10 11:44:05+00',	'2025-10-22 09:25:36+00'),
(86,	'e5266555-8859-4f96-bab0-6596b9736d94',	'9496988240365277',	'Dogsandbeauty',	'https://scontent-pnq1-1.xx.fbcdn.net/v/t39.30808-1/245168916_106282145168725_8304205606813217704_n.png?stp=cp0_dst-png_p50x50&_nc_cat=110&ccb=1-7&_nc_sid=f907e8&_nc_ohc=GDxgmJFb37oQ7kNvwH80vUa&_nc_oc=AdndefjaKaccSZjgEERCDdKaD1hBWNYTmD_CgxxIkyeDHKJkvVfI5I0ApL2sVAs8D9-SCrvSphLcN6xuuZ7v759W&_nc_zt=24&_nc_ht=scontent-pnq1-1.xx&edm=AJdBtusEAAAA&_nc_gid=ls9Cky3cHrD-fsMlJdnNew&oh=00_AfdSrWwHoLeXX_6tg8SmQ0hOvQ5Y_Kr--uVyp1wfhI16aA&oe=68FEB69E',	'https://scontent-pnq1-2.xx.fbcdn.net/v/t39.30808-6/245243058_106280161835590_4171088681691500727_n.png?_nc_cat=100&ccb=1-7&_nc_sid=dc4938&_nc_ohc=jjZr5RkSlkMQ7kNvwEz8h2K&_nc_oc=AdnmQugrkZz2_QFSQJ6yOZ7xoq0sNR821GCUMLPtNAXWxSDBFMXdy-YfVM4Kp8CH9bOQoNOxcP0LOPRPKdcHr6mp&_nc_zt=23&_nc_ht=scontent-pnq1-2.xx&edm=AJdBtusEAAAA&_nc_gid=ls9Cky3cHrD-fsMlJdnNew&oh=00_Afcf2Zl3iQGc2GwufHlTXqUiE3Gb6MN-TH4hAvwfW-ts2A&oe=68FEA21C',	'106278878502385',	'EAAQvGECe4RMBQMQXAGIcyQCwRD6DOv8IiIPXNJXe4uauVBzJBuZCtmnKtSxTH0Qy8hL41UwgHuUt5mtjZAZChbGZCHbfGUdn5BZAA6wnY2uvX2Ev1M2XQPbcdtoSZAGR0oRo8bfbUIf8IbGEwas8nsCcXZCZBvhK2ZCLZCHQUptBopdOletuLL9eP8beEKlicDVxbfDRUXBUYIedFtn5yjJ6KZAqvQZD',	'Pet Supplies',	0,	'facebook',	'Connected',	NULL,	NULL,	'2025-10-22 13:31:24+00',	'2025-12-01 00:00:05+00'),
(117,	'b4206492-1778-4860-8e24-af93296a37d4',	'122156535248577012',	'Webonx',	'https://scontent.fbom3-1.fna.fbcdn.net/v/t39.30808-1/483849061_2684907295232195_5302037319658272306_n.jpg?stp=c33.0.194.194a_cp0_dst-jpg_s50x50_tt6&_nc_cat=101&ccb=1-7&_nc_sid=f907e8&_nc_ohc=Y5qzpHy58T0Q7kNvwHOnf7X&_nc_oc=AdlKFLx4a-O-9JyN6Oieu7-G0mR91wijRpzLYYjV1RBrcMj72SQv_x7A4rkhKv0yBrzyvQM9rQgYF-_6DeimU5yX&_nc_zt=24&_nc_ht=scontent.fbom3-1.fna&edm=AJdBtusEAAAA&_nc_gid=OVIPQkMwoF3re6b2QKYwaw&_nc_tpa=Q5bMBQFFtidwInak5roW9apdBYBoWOpp-nKp12kRibKdjuCtdacsqLyqxmiWnkTM2Ex5hxdCOcziMzqI1w&oh=00_AflC91Jl73USymBmatTBTxrB9ycQF9E6gQbcL6_Go80INA&oe=6937672A',	'https://scontent.fbom3-4.fna.fbcdn.net/v/t39.30808-6/503357136_2767045300351727_3070237346266400978_n.jpg?_nc_cat=111&ccb=1-7&_nc_sid=dc4938&_nc_ohc=MWs4f-OPc_sQ7kNvwHwHuF9&_nc_oc=Adlo6ABTkwJSDIEvvhsmq5JddSUL_KVqG0KsSZZZwpIcG50m8M_UQix-tUil6y_LVhOuJBioJM1bSdHXEWKkcmSq&_nc_zt=23&_nc_ht=scontent.fbom3-4.fna&edm=AJdBtusEAAAA&_nc_gid=OVIPQkMwoF3re6b2QKYwaw&_nc_tpa=Q5bMBQHLtKuNDyryutg4w4rFneUBkrIk_jj_YVt3VK0xfsSVl9L9JJEBGwjSRVBz2DyyxM2wltt8aqoGRg&oh=00_AfmpfAZreHyyhzfT-Ex3Ld_lXSGBWOxEOTmCx1VFA2Oy8A&oe=69374A79',	'631102136744766',	'EAAQvGECe4RMBQOxGtymav3tI3XApOrFGTsBFjgvycp3xeGVJEJgeKDj0MAYSlaZAlpT6ZCQHhDH9ZAsg2kEDkPOwvAp7soGiEc7TrvkoJ35YN6ZA01uWcVIrjZA5QtmVrZAVemZCZCv9ZBqMkWPhOCt7sbjS3wJAD43UixPLcQrl8JunAWPqZB0nm2uL4P3AwvXsabtj6C1RgC',	'Software Company',	9,	'facebook',	'Connected',	NULL,	NULL,	'2025-12-04 12:50:22+00',	'2025-12-08 09:25:16+00');

DROP TABLE IF EXISTS "social_users";
DROP SEQUENCE IF EXISTS social_users_id_seq;
CREATE SEQUENCE social_users_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."social_users" (
    "id" bigint DEFAULT nextval('social_users_id_seq') NOT NULL,
    "user_id" character varying(250) NOT NULL,
    "name" character varying(100) NOT NULL,
    "email" character varying(200),
    "img_url" character varying(250),
    "social_id" character varying(200) NOT NULL,
    "social_user_platform" character varying(255),
    "user_token" text NOT NULL,
    "status" text DEFAULT 'notConnected',
    "createdat" timestamptz DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "updatedat" timestamptz DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT "idx_17435_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE INDEX idx_17435_user_id ON insocial_mysql.social_users USING btree (user_id);

CREATE UNIQUE INDEX idx_17435_social_id ON insocial_mysql.social_users USING btree (social_id);

INSERT INTO "social_users" ("id", "user_id", "name", "email", "img_url", "social_id", "social_user_platform", "user_token", "status", "createdat", "updatedat") VALUES
(36,	'e5266555-8859-4f96-bab0-6596b9736d94',	'Sudhir Kundal',	NULL,	'https://platform-lookaside.fbsbx.com/platform/profilepic/?asid=9496988240365277&height=50&width=50&ext=1763731876&hash=AT-QyDnzuTwsArc0ZqGcRTZh',	'9496988240365277',	'facebook',	'EAAQvGECe4RMBQHsMbXHTIas8wGtQmQqu6jHID98MB1eBATyEKy3pZAiACr43K8GZCkVlpgLidyWAEDUIl955HXihSg1fqmQ3y6Jwxea0Pxci1ftjmfogIL5USFiz6qr4k4FaYNPwPYzCvEw60oFvDYRuZCc47jCYUtGKELJ0YRp7VZC6DZCVjvWS4vw2EjJVZCt4ZBTmW8o0d9d',	'Connected',	'2025-10-10 11:43:12+00',	'2025-12-01 00:00:02+00'),
(37,	'e5266555-8859-4f96-bab0-6596b9736d94',	'Sudhir kundal',	NULL,	'https://media.licdn.com/dms/image/v2/D5603AQFEZNr2F7w5Pg/profile-displayphoto-shrink_100_100/B56ZT6Z7D9HQAU-/0/1739367887572?e=1762992000&v=beta&t=pjZ2w8l-RlHznkRw37T72cGHbX7sb-ZIvgqTn4lBXeI',	'eRLsKrw_6N',	'linkedin',	'AQVEXGOWUkRua5Rclo_juvtEfu6tpl8U1XFlnYpTBGYfH039Bl0fGd2KzTODyhq3rFZSaayML9BpcjBRqepc1pdfa_dltopZ1Ci7HMe4-jrqASgBUaq7zdG5mVFHk8Y7kIAZLM2TFw87EQfDXAe4rbqsDj5Ii1NQtQiuG1GRZ2r4OpfRfiJJco_JnPUQC_bD8xm7yE2BIARkeOS3WxPp6LyCxBSY6hv1SjiCHDVdPJ7BRejO47zPmE2f3qx9zW1npKZGfhRUJAc7UzPh1q_Qfaub3ExhgRFmLt2F9eqtd_GvAZdMtBD3EKV75tGwnP5RrXETJwqoHV9IxvF5i1DdaVFQSqiQwQ',	'Connected',	'2025-10-10 11:44:02+00',	'2025-10-22 09:25:31+00'),
(62,	'b4206492-1778-4860-8e24-af93296a37d4',	'Ross Singh',	NULL,	'https://platform-lookaside.fbsbx.com/platform/profilepic/?asid=122156535248577012&height=50&width=50&ext=1767444618&hash=AT9TfvNJRZOhdZUNFKJ6FLCG',	'122156535248577012',	'facebook',	'EAAQvGECe4RMBQKO8wcEhZCSKKQEn1I4Wwx8jRN214z9P76S32ZB0kUKD4mhsxdwmW4uTzdbzcssbZBspxjZBH7ZCKapKjEi4lg1S9aAZC7mkmeEZArozO9TPQRznhZByWV8RYVlkmiOOgncZAmbeAJtqruu5RpiqTiTE9i9MQZBWHoo5UxEfdt5ENgFzVVKBDAxiY1',	'Connected',	'2025-12-04 12:50:19+00',	'2025-12-04 12:50:19+00');

DROP TABLE IF EXISTS "subscription_events";
DROP SEQUENCE IF EXISTS subscription_events_id_seq;
CREATE SEQUENCE subscription_events_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."subscription_events" (
    "id" bigint DEFAULT nextval('subscription_events_id_seq') NOT NULL,
    "subscription_id" bigint,
    "user_uuid" character varying(255),
    "stripe_subscription_id" character varying(255),
    "stripe_event_id" character varying(255),
    "event_type" text NOT NULL,
    "old_status" character varying(50),
    "new_status" character varying(50),
    "old_plan_id" character varying(255),
    "new_plan_id" character varying(255),
    "old_quantity" bigint,
    "new_quantity" bigint,
    "amount" bigint,
    "currency" character varying(3),
    "failure_code" character varying(100),
    "failure_message" text,
    "actor" text DEFAULT 'system',
    "actor_id" character varying(255),
    "ip_address" character varying(45),
    "user_agent" text,
    "description" text,
    "metadata" text,
    "event_payload" text,
    "occurred_at" timestamp NOT NULL,
    "processed_at" timestamp,
    "createdat" timestamp NOT NULL,
    "updatedat" timestamp NOT NULL,
    CONSTRAINT "idx_17472_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

COMMENT ON COLUMN "insocial_mysql"."subscription_events"."subscription_id" IS 'Local subscription ID reference';

COMMENT ON COLUMN "insocial_mysql"."subscription_events"."user_uuid" IS 'User UUID reference';

COMMENT ON COLUMN "insocial_mysql"."subscription_events"."stripe_subscription_id" IS 'Stripe subscription ID';

COMMENT ON COLUMN "insocial_mysql"."subscription_events"."stripe_event_id" IS 'Stripe event ID for idempotency';

COMMENT ON COLUMN "insocial_mysql"."subscription_events"."event_type" IS 'Type of subscription event';

COMMENT ON COLUMN "insocial_mysql"."subscription_events"."old_status" IS 'Previous subscription status';

COMMENT ON COLUMN "insocial_mysql"."subscription_events"."new_status" IS 'New subscription status';

COMMENT ON COLUMN "insocial_mysql"."subscription_events"."old_plan_id" IS 'Previous plan ID (for plan changes)';

COMMENT ON COLUMN "insocial_mysql"."subscription_events"."new_plan_id" IS 'New plan ID (for plan changes)';

COMMENT ON COLUMN "insocial_mysql"."subscription_events"."old_quantity" IS 'Previous quantity';

COMMENT ON COLUMN "insocial_mysql"."subscription_events"."new_quantity" IS 'New quantity';

COMMENT ON COLUMN "insocial_mysql"."subscription_events"."amount" IS 'Amount involved (in cents)';

COMMENT ON COLUMN "insocial_mysql"."subscription_events"."currency" IS 'Currency code';

COMMENT ON COLUMN "insocial_mysql"."subscription_events"."failure_code" IS 'Failure code if applicable';

COMMENT ON COLUMN "insocial_mysql"."subscription_events"."failure_message" IS 'Failure message if applicable';

COMMENT ON COLUMN "insocial_mysql"."subscription_events"."actor" IS 'Who triggered this event';

COMMENT ON COLUMN "insocial_mysql"."subscription_events"."actor_id" IS 'ID of the actor (user UUID, admin ID, etc.)';

COMMENT ON COLUMN "insocial_mysql"."subscription_events"."ip_address" IS 'IP address if user-initiated';

COMMENT ON COLUMN "insocial_mysql"."subscription_events"."user_agent" IS 'User agent if user-initiated';

COMMENT ON COLUMN "insocial_mysql"."subscription_events"."description" IS 'Human-readable description';

COMMENT ON COLUMN "insocial_mysql"."subscription_events"."metadata" IS 'Additional event data';

COMMENT ON COLUMN "insocial_mysql"."subscription_events"."event_payload" IS 'Full Stripe event payload for debugging';

COMMENT ON COLUMN "insocial_mysql"."subscription_events"."occurred_at" IS 'When the event occurred';

COMMENT ON COLUMN "insocial_mysql"."subscription_events"."processed_at" IS 'When the event was processed';

CREATE UNIQUE INDEX idx_17472_stripe_event_id ON insocial_mysql.subscription_events USING btree (stripe_event_id);

INSERT INTO "subscription_events" ("id", "subscription_id", "user_uuid", "stripe_subscription_id", "stripe_event_id", "event_type", "old_status", "new_status", "old_plan_id", "new_plan_id", "old_quantity", "new_quantity", "amount", "currency", "failure_code", "failure_message", "actor", "actor_id", "ip_address", "user_agent", "description", "metadata", "event_payload", "occurred_at", "processed_at", "createdat", "updatedat") VALUES
(1,	1,	'9e47ed0e-73f7-41d5-9dac-5c37b8df8a4f',	'sub_1Sc8r8HpVJPrOqLkX4hZp1K4',	NULL,	'subscription_created',	NULL,	'active',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'user',	NULL,	NULL,	NULL,	'Subscription created with active status',	NULL,	NULL,	'2025-12-08 18:08:28',	'2025-12-08 18:08:28',	'2025-12-08 18:08:28',	'2025-12-08 18:08:28'),
(2,	1,	'9e47ed0e-73f7-41d5-9dac-5c37b8df8a4f',	'sub_1Sc8r8HpVJPrOqLkX4hZp1K4',	'evt_1Sc8rCHpVJPrOqLkc1IKjRiF',	'payment_succeeded',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	9900,	'usd',	NULL,	NULL,	'stripe',	NULL,	NULL,	NULL,	'Payment of 99 USD succeeded',	NULL,	NULL,	'2025-12-08 18:08:21',	'2025-12-08 18:08:25',	'2025-12-08 18:08:25',	'2025-12-08 18:08:25'),
(3,	2,	'6f4362d5-744c-446e-8108-8db805396e51',	'sub_1Sc9R5HpVJPrOqLkPt4sV5R5',	NULL,	'subscription_created',	NULL,	'trialing',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'user',	NULL,	NULL,	NULL,	'Subscription created with trial period',	NULL,	NULL,	'2025-12-08 18:45:29',	'2025-12-08 18:45:29',	'2025-12-08 18:45:29',	'2025-12-08 18:45:29'),
(4,	2,	'6f4362d5-744c-446e-8108-8db805396e51',	'sub_1Sc9R5HpVJPrOqLkPt4sV5R5',	'evt_1Sc9R7HpVJPrOqLk1VlxsWJe',	'payment_succeeded',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	'usd',	NULL,	NULL,	'stripe',	NULL,	NULL,	NULL,	'Payment of 0 USD succeeded',	NULL,	NULL,	'2025-12-08 18:45:29',	'2025-12-08 18:45:32',	'2025-12-08 18:45:32',	'2025-12-08 18:45:32');

DROP TABLE IF EXISTS "subscription_plans";
DROP SEQUENCE IF EXISTS subscription_plans_id_seq;
CREATE SEQUENCE subscription_plans_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."subscription_plans" (
    "id" bigint DEFAULT nextval('subscription_plans_id_seq') NOT NULL,
    "name" character varying(255) NOT NULL,
    "slug" character varying(255),
    "stripe_price_id" character varying(255),
    "stripe_yearly_price_id" character varying(255),
    "stripe_product_id" character varying(255),
    "price" numeric(10,2) NOT NULL,
    "monthly_price_usd" numeric(10,2) DEFAULT '0.00' NOT NULL,
    "yearly_price_usd" numeric(10,2),
    "monthly_price_inr" numeric(10,2) DEFAULT '0.00' NOT NULL,
    "yearly_price_inr" numeric(10,2),
    "yearly_price" numeric(10,2),
    "yearly_discount_percent" bigint DEFAULT '0' NOT NULL,
    "currency" character varying(3) DEFAULT 'USD' NOT NULL,
    "billing_cycle" text DEFAULT 'monthly' NOT NULL,
    "features" text,
    "display_features" text,
    "description" text,
    "max_social_accounts" bigint,
    "max_team_members" bigint,
    "max_scheduled_posts" bigint,
    "ai_tokens_per_month" bigint DEFAULT '0' NOT NULL,
    "ai_auto_comment_reply" smallint DEFAULT '0' NOT NULL,
    "ai_auto_dm_reply" smallint DEFAULT '0' NOT NULL,
    "ai_semantic_analysis" smallint DEFAULT '0' NOT NULL,
    "ai_driven_reporting" smallint DEFAULT '0' NOT NULL,
    "ai_content_generator" smallint DEFAULT '0' NOT NULL,
    "calendar_scheduling" smallint DEFAULT '0' NOT NULL,
    "social_profile_score" smallint DEFAULT '0' NOT NULL,
    "unified_inbox" smallint DEFAULT '0' NOT NULL,
    "export_reports" smallint DEFAULT '0' NOT NULL,
    "white_label" smallint DEFAULT '0' NOT NULL,
    "fb_ads_analytics" smallint DEFAULT '0' NOT NULL,
    "fb_ads_creation" smallint DEFAULT '0' NOT NULL,
    "team_roles_permissions" smallint DEFAULT '0' NOT NULL,
    "client_workspaces" smallint DEFAULT '0' NOT NULL,
    "support_level" character varying(255) DEFAULT 'standard' NOT NULL,
    "platform_limits" text,
    "active" smallint DEFAULT '1' NOT NULL,
    "is_featured" smallint DEFAULT '0' NOT NULL,
    "trial_period_days" bigint,
    "trial_enabled" smallint DEFAULT '0' NOT NULL,
    "skip_trial_discount_enabled" smallint DEFAULT '0' NOT NULL,
    "skip_trial_discount_percent" bigint DEFAULT '0' NOT NULL,
    "is_contact_only" smallint DEFAULT '0' NOT NULL,
    "show_on_landing" smallint DEFAULT '1' NOT NULL,
    "sort_order" bigint DEFAULT '0' NOT NULL,
    "created_at" timestamptz,
    "updated_at" timestamptz,
    CONSTRAINT "idx_17491_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE UNIQUE INDEX idx_17491_subscription_plans_slug_unique ON insocial_mysql.subscription_plans USING btree (slug);

INSERT INTO "subscription_plans" ("id", "name", "slug", "stripe_price_id", "stripe_yearly_price_id", "stripe_product_id", "price", "monthly_price_usd", "yearly_price_usd", "monthly_price_inr", "yearly_price_inr", "yearly_price", "yearly_discount_percent", "currency", "billing_cycle", "features", "display_features", "description", "max_social_accounts", "max_team_members", "max_scheduled_posts", "ai_tokens_per_month", "ai_auto_comment_reply", "ai_auto_dm_reply", "ai_semantic_analysis", "ai_driven_reporting", "ai_content_generator", "calendar_scheduling", "social_profile_score", "unified_inbox", "export_reports", "white_label", "fb_ads_analytics", "fb_ads_creation", "team_roles_permissions", "client_workspaces", "support_level", "platform_limits", "active", "is_featured", "trial_period_days", "trial_enabled", "skip_trial_discount_enabled", "skip_trial_discount_percent", "is_contact_only", "show_on_landing", "sort_order", "created_at", "updated_at") VALUES
(1,	'Starter',	'starter',	'price_1SacsoHpVJPrOqLk55ldH9MX',	'price_1SavGZHpVJPrOqLksQJfyli5',	'prod_TXiJ5slia0Fh1C',	19.00,	19.00,	205.20,	1499.00,	16189.20,	205.20,	10,	'USD',	'monthly',	'[]',	 E'["Up to 10 Social Profiles","AI Content Generator (10,000 tokens\\/month)","Basic Calendar Scheduling","Post Creation & Drafts","Basic Analytics Dashboard","AI Social Profile Score (Basic)","Media Library","1 User","Standard Support"]',	'Perfect for creators & freelancers',	10,	1,	-1,	10000,	0,	0,	0,	0,	1,	0,	0,	1,	0,	0,	0,	0,	0,	0,	'standard',	'[]',	1,	0,	1,	1,	1,	10,	0,	1,	1,	'2025-12-04 15:11:35+00',	'2025-12-08 13:17:36+00'),
(2,	'Growth',	'growth',	'price_1Sact6HpVJPrOqLkhjeGEJKT',	'price_1SavJOHpVJPrOqLkBr49Hq71',	'prod_TXiJlEROBCoHcX',	49.00,	49.00,	529.20,	3999.00,	43189.20,	529.20,	10,	'USD',	'monthly',	'[]',	 E'["Up to 30 Social Profiles","AI Content Generator (50000 tokens\\/month)","Unified Social Inbox","AI Auto Comment Reply","AI Auto DM Reply","AI-Driven Reporting","Advanced Analytics & Trend Insights","Bulk Scheduling","Workflow Calendar Tools","Export Reports (PDF\\/CSV)","Hashtag Manager","3 Users","Priority Support"]',	'Built for small businesses & social media managers',	20,	9,	-1,	50000,	0,	0,	0,	0,	1,	0,	0,	1,	0,	0,	0,	0,	0,	0,	'priority',	'[]',	1,	1,	14,	1,	1,	10,	0,	1,	2,	'2025-12-04 15:11:33+00',	'2025-12-05 09:34:19+00'),
(3,	'Agency',	'agency',	'price_1SactGHpVJPrOqLkrdqk0HUK',	'price_1SavL0HpVJPrOqLkWN7N5q63',	'prod_TXiJSc9kvYKDXH',	99.00,	99.00,	1069.20,	7999.00,	86389.20,	1069.20,	10,	'USD',	'monthly',	'[]',	 E'["Up to 100 Social Profiles","AI Content Generator (100000 tokens\\/month)","AI Semantic Comment Analysis","Facebook Ads Analytics","Create & Manage Facebook Ad Campaigns","White-Label Reports","Client Workspaces","Team Roles & Permissions","Unified Inbox","10 Users","5GB Media Storage","Priority Chat + Email Support"]',	'For agencies managing many clients',	100,	10,	-1,	-1,	1,	1,	1,	1,	1,	0,	0,	1,	0,	0,	1,	1,	1,	1,	'priority_chat',	'[]',	1,	0,	14,	0,	1,	10,	0,	1,	3,	'2025-12-04 15:11:32+00',	'2025-12-08 13:17:46+00'),
(19,	'Enterprise',	'enterprise',	NULL,	NULL,	NULL,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0,	'USD',	'monthly',	'[]',	'["Unlimited Social Profiles", "Unlimited Users", "Unlimited AI Tokens", "Custom Analytics Dashboards", "API Access & Integrations", "SSO Login", "Dedicated Account Manager", "24×7 Priority Support", "Personalized Onboarding"]',	'Custom solutions for large teams & enterprises',	-1,	-1,	-1,	0,	1,	1,	1,	1,	1,	0,	0,	1,	0,	1,	1,	1,	1,	1,	'enterprise',	'[]',	1,	0,	NULL,	0,	0,	0,	1,	1,	4,	NULL,	'2025-12-05 09:30:43+00');

DROP TABLE IF EXISTS "subscriptions";
DROP SEQUENCE IF EXISTS subscriptions_id_seq;
CREATE SEQUENCE subscriptions_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."subscriptions" (
    "id" bigint DEFAULT nextval('subscriptions_id_seq') NOT NULL,
    "user_uuid" character varying(255) NOT NULL,
    "stripe_customer_id" character varying(255) NOT NULL,
    "stripe_subscription_id" character varying(255) NOT NULL,
    "price_id" character varying(255) NOT NULL,
    "plan_id" numeric,
    "status" character varying(50) NOT NULL,
    "trial_end" timestamp,
    "createdat" timestamp NOT NULL,
    "updatedat" timestamptz,
    "stripe_price_id" character varying(255),
    "trial_start" timestamp,
    "trial_days" bigint,
    "current_period_start" timestamp,
    "current_period_end" timestamp,
    "billing_cycle_anchor" timestamp,
    "next_invoice_date" timestamp,
    "cancel_at_period_end" smallint DEFAULT '0' NOT NULL,
    "cancel_at" timestamp,
    "canceled_at" timestamp,
    "ended_at" timestamp,
    "cancellation_reason" character varying(255),
    "cancellation_feedback" text,
    "pause_collection" text,
    "resume_at" timestamp,
    "collection_method" text DEFAULT 'charge_automatically',
    "default_payment_method_id" character varying(255),
    "latest_invoice_id" character varying(255),
    "quantity" bigint DEFAULT '1',
    "amount" numeric(10,2),
    "currency" character varying(3) DEFAULT 'USD',
    "billing_interval" text DEFAULT 'month',
    "discount_percent" numeric(5,2),
    "coupon_code" character varying(100),
    "stripe_coupon_id" character varying(255),
    "past_due_since" timestamp,
    "last_payment_attempt_at" timestamp,
    "last_payment_error" text,
    "payment_retry_count" bigint DEFAULT '0',
    "next_payment_retry_at" timestamp,
    "dunning_status" text DEFAULT 'none',
    "status_reason" text,
    "metadata" text,
    "trial_reminder_sent" smallint DEFAULT '0',
    "trial_reminder_sent_at" timestamp,
    "renewal_reminder_sent" smallint DEFAULT '0',
    "renewal_reminder_sent_at" timestamp,
    "synced_at" timestamp,
    CONSTRAINT "idx_17448_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."plan_id" IS 'Local subscription plan ID';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."stripe_price_id" IS 'Stripe price ID';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."trial_start" IS 'Trial period start date';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."trial_days" IS 'Number of trial days';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."current_period_start" IS 'Current billing period start';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."current_period_end" IS 'Current billing period end';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."billing_cycle_anchor" IS 'Billing cycle anchor date';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."next_invoice_date" IS 'Next invoice/billing date';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."cancel_at_period_end" IS 'Whether subscription cancels at period end';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."cancel_at" IS 'Scheduled cancellation date';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."canceled_at" IS 'When cancellation was requested';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."ended_at" IS 'When subscription actually ended';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."cancellation_reason" IS 'Reason for cancellation';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."cancellation_feedback" IS 'User feedback on cancellation';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."pause_collection" IS 'Pause collection settings from Stripe';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."resume_at" IS 'When paused subscription should resume';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."collection_method" IS 'How payments are collected';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."default_payment_method_id" IS 'Default payment method for this subscription';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."latest_invoice_id" IS 'Latest Stripe invoice ID';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."quantity" IS 'Subscription quantity (seats)';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."amount" IS 'Subscription amount';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."currency" IS 'Subscription currency';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."billing_interval" IS 'Billing interval';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."discount_percent" IS 'Discount percentage applied';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."coupon_code" IS 'Applied coupon code';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."stripe_coupon_id" IS 'Stripe coupon ID';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."past_due_since" IS 'When subscription became past due';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."last_payment_attempt_at" IS 'Last payment attempt timestamp';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."last_payment_error" IS 'Last payment error message';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."payment_retry_count" IS 'Number of payment retry attempts';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."next_payment_retry_at" IS 'Next scheduled payment retry';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."dunning_status" IS 'Dunning (payment recovery) status';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."status_reason" IS 'Detailed reason for current status';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."metadata" IS 'Additional metadata from Stripe';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."trial_reminder_sent" IS 'Whether trial ending reminder was sent';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."trial_reminder_sent_at" IS 'When trial reminder was sent';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."renewal_reminder_sent" IS 'Whether renewal reminder was sent';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."renewal_reminder_sent_at" IS 'When renewal reminder was sent';

COMMENT ON COLUMN "insocial_mysql"."subscriptions"."synced_at" IS 'Last sync with Stripe';

CREATE INDEX idx_17448_subscriptions_user_uuid ON insocial_mysql.subscriptions USING btree (user_uuid);

CREATE INDEX idx_17448_subscriptions_stripe_subscription_id ON insocial_mysql.subscriptions USING btree (stripe_subscription_id);

INSERT INTO "subscriptions" ("id", "user_uuid", "stripe_customer_id", "stripe_subscription_id", "price_id", "plan_id", "status", "trial_end", "createdat", "updatedat", "stripe_price_id", "trial_start", "trial_days", "current_period_start", "current_period_end", "billing_cycle_anchor", "next_invoice_date", "cancel_at_period_end", "cancel_at", "canceled_at", "ended_at", "cancellation_reason", "cancellation_feedback", "pause_collection", "resume_at", "collection_method", "default_payment_method_id", "latest_invoice_id", "quantity", "amount", "currency", "billing_interval", "discount_percent", "coupon_code", "stripe_coupon_id", "past_due_since", "last_payment_attempt_at", "last_payment_error", "payment_retry_count", "next_payment_retry_at", "dunning_status", "status_reason", "metadata", "trial_reminder_sent", "trial_reminder_sent_at", "renewal_reminder_sent", "renewal_reminder_sent_at", "synced_at") VALUES
(1,	'9e47ed0e-73f7-41d5-9dac-5c37b8df8a4f',	'cus_TZHNim28DTlc56',	'sub_1Sc8r8HpVJPrOqLkX4hZp1K4',	'price_1SactGHpVJPrOqLkrdqk0HUK',	NULL,	'active',	NULL,	'2025-12-08 18:08:27',	'2025-12-08 18:08:25+00',	'price_1SactGHpVJPrOqLkrdqk0HUK',	NULL,	NULL,	NULL,	NULL,	'2025-12-08 18:08:18',	NULL,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'charge_automatically',	NULL,	NULL,	1,	9900.00,	'USD',	'month',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	'none',	NULL,	NULL,	0,	NULL,	0,	NULL,	'2025-12-08 18:08:25'),
(2,	'6f4362d5-744c-446e-8108-8db805396e51',	'cus_TZI0IIGiL6g3IG',	'sub_1Sc9R5HpVJPrOqLkPt4sV5R5',	'price_1SacsoHpVJPrOqLk55ldH9MX',	NULL,	'trialing',	'2025-12-09 18:45:27',	'2025-12-08 18:45:29',	'2025-12-08 18:45:32+00',	'price_1SacsoHpVJPrOqLk55ldH9MX',	'2025-12-08 18:45:27',	1,	NULL,	NULL,	'2025-12-09 18:45:27',	NULL,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'charge_automatically',	NULL,	NULL,	1,	1900.00,	'USD',	'month',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	'none',	NULL,	NULL,	0,	NULL,	0,	NULL,	'2025-12-08 18:45:32');

DELIMITER ;;

CREATE TRIGGER "on_update_current_timestamp" BEFORE UPDATE ON "insocial_mysql"."subscriptions" FOR EACH ROW EXECUTE FUNCTION on_update_current_timestamp_subscriptions();;

DELIMITER ;

DROP TABLE IF EXISTS "transactions";
DROP SEQUENCE IF EXISTS transactions_id_seq;
CREATE SEQUENCE transactions_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."transactions" (
    "id" bigint DEFAULT nextval('transactions_id_seq') NOT NULL,
    "subscription_id" bigint NOT NULL,
    "stripe_invoice_id" character varying(255),
    "stripe_payment_intent_id" character varying(255),
    "amount" bigint NOT NULL,
    "currency" character varying(10) NOT NULL,
    "status" character varying(50) NOT NULL,
    "user_uuid" character(36),
    "plan_id" bigint,
    "stripe_charge_id" character varying(255),
    "stripe_subscription_id" character varying(255),
    "stripe_customer_id" character varying(255),
    "stripe_payment_method_id" character varying(255),
    "invoice_number" character varying(100),
    "invoice_pdf_url" character varying(500),
    "invoice_hosted_url" character varying(500),
    "billing_reason" text,
    "amount_subtotal" bigint,
    "amount_tax" bigint DEFAULT '0',
    "amount_total" bigint,
    "amount_paid" bigint,
    "amount_due" bigint,
    "amount_remaining" bigint DEFAULT '0',
    "discount_amount" bigint DEFAULT '0',
    "coupon_code" character varying(100),
    "tax_rates" text,
    "payment_status" text,
    "failure_code" character varying(100),
    "failure_message" text,
    "failure_reason" character varying(255),
    "attempt_count" bigint DEFAULT '0',
    "next_payment_attempt" timestamp,
    "due_date" timestamp,
    "paid_at" timestamp,
    "period_start" timestamp,
    "period_end" timestamp,
    "refund_amount" bigint DEFAULT '0',
    "refunded_at" timestamp,
    "refund_reason" character varying(255),
    "stripe_refund_id" character varying(255),
    "description" text,
    "receipt_url" character varying(500),
    "card_brand" character varying(50),
    "card_last4" character varying(4),
    "metadata" text,
    "createdat" timestamp NOT NULL,
    "updatedat" timestamptz,
    CONSTRAINT "idx_17534_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

COMMENT ON COLUMN "insocial_mysql"."transactions"."plan_id" IS 'Local plan ID reference';

COMMENT ON COLUMN "insocial_mysql"."transactions"."stripe_charge_id" IS 'Stripe charge ID';

COMMENT ON COLUMN "insocial_mysql"."transactions"."stripe_subscription_id" IS 'Stripe subscription ID';

COMMENT ON COLUMN "insocial_mysql"."transactions"."stripe_customer_id" IS 'Stripe customer ID';

COMMENT ON COLUMN "insocial_mysql"."transactions"."invoice_number" IS 'Stripe invoice number';

COMMENT ON COLUMN "insocial_mysql"."transactions"."invoice_pdf_url" IS 'URL to invoice PDF';

COMMENT ON COLUMN "insocial_mysql"."transactions"."invoice_hosted_url" IS 'Hosted invoice URL';

COMMENT ON COLUMN "insocial_mysql"."transactions"."billing_reason" IS 'Reason for billing';

COMMENT ON COLUMN "insocial_mysql"."transactions"."amount_subtotal" IS 'Subtotal amount in cents';

COMMENT ON COLUMN "insocial_mysql"."transactions"."amount_tax" IS 'Tax amount in cents';

COMMENT ON COLUMN "insocial_mysql"."transactions"."amount_total" IS 'Total amount in cents';

COMMENT ON COLUMN "insocial_mysql"."transactions"."amount_paid" IS 'Amount actually paid in cents';

COMMENT ON COLUMN "insocial_mysql"."transactions"."amount_due" IS 'Amount due in cents';

COMMENT ON COLUMN "insocial_mysql"."transactions"."amount_remaining" IS 'Remaining unpaid amount';

COMMENT ON COLUMN "insocial_mysql"."transactions"."discount_amount" IS 'Discount amount in cents';

COMMENT ON COLUMN "insocial_mysql"."transactions"."coupon_code" IS 'Applied coupon code';

COMMENT ON COLUMN "insocial_mysql"."transactions"."tax_rates" IS 'Applied tax rates';

COMMENT ON COLUMN "insocial_mysql"."transactions"."payment_status" IS 'Payment intent status';

COMMENT ON COLUMN "insocial_mysql"."transactions"."failure_code" IS 'Payment failure code';

COMMENT ON COLUMN "insocial_mysql"."transactions"."failure_message" IS 'Payment failure message';

COMMENT ON COLUMN "insocial_mysql"."transactions"."failure_reason" IS 'Reason for failure';

COMMENT ON COLUMN "insocial_mysql"."transactions"."attempt_count" IS 'Number of payment attempts';

COMMENT ON COLUMN "insocial_mysql"."transactions"."next_payment_attempt" IS 'Next scheduled payment attempt';

COMMENT ON COLUMN "insocial_mysql"."transactions"."due_date" IS 'Payment due date';

COMMENT ON COLUMN "insocial_mysql"."transactions"."paid_at" IS 'When payment was made';

COMMENT ON COLUMN "insocial_mysql"."transactions"."period_start" IS 'Billing period start';

COMMENT ON COLUMN "insocial_mysql"."transactions"."period_end" IS 'Billing period end';

COMMENT ON COLUMN "insocial_mysql"."transactions"."refund_amount" IS 'Refunded amount in cents';

COMMENT ON COLUMN "insocial_mysql"."transactions"."refunded_at" IS 'When refund was issued';

COMMENT ON COLUMN "insocial_mysql"."transactions"."refund_reason" IS 'Reason for refund';

COMMENT ON COLUMN "insocial_mysql"."transactions"."stripe_refund_id" IS 'Stripe refund ID';

COMMENT ON COLUMN "insocial_mysql"."transactions"."description" IS 'Transaction description';

COMMENT ON COLUMN "insocial_mysql"."transactions"."receipt_url" IS 'Receipt URL from Stripe';

COMMENT ON COLUMN "insocial_mysql"."transactions"."card_brand" IS 'Card brand used';

COMMENT ON COLUMN "insocial_mysql"."transactions"."card_last4" IS 'Last 4 digits of card';

COMMENT ON COLUMN "insocial_mysql"."transactions"."metadata" IS 'Additional metadata';

INSERT INTO "transactions" ("id", "subscription_id", "stripe_invoice_id", "stripe_payment_intent_id", "amount", "currency", "status", "user_uuid", "plan_id", "stripe_charge_id", "stripe_subscription_id", "stripe_customer_id", "stripe_payment_method_id", "invoice_number", "invoice_pdf_url", "invoice_hosted_url", "billing_reason", "amount_subtotal", "amount_tax", "amount_total", "amount_paid", "amount_due", "amount_remaining", "discount_amount", "coupon_code", "tax_rates", "payment_status", "failure_code", "failure_message", "failure_reason", "attempt_count", "next_payment_attempt", "due_date", "paid_at", "period_start", "period_end", "refund_amount", "refunded_at", "refund_reason", "stripe_refund_id", "description", "receipt_url", "card_brand", "card_last4", "metadata", "createdat", "updatedat") VALUES
(1,	1,	'in_1Sc8r8HpVJPrOqLkqss6grEV',	'pi_3Sc8r9HpVJPrOqLk0FLkqgHp',	9900,	'usd',	'paid',	'9e47ed0e-73f7-41d5-9dac-5c37b8df8a4f',	NULL,	'ch_3Sc8r9HpVJPrOqLk0WTADrOH',	'sub_1Sc8r8HpVJPrOqLkX4hZp1K4',	'cus_TZHNim28DTlc56',	NULL,	'FVJFOQBG-0001',	'https://pay.stripe.com/invoice/acct_1AC6lAHpVJPrOqLk/test_YWNjdF8xQUM2bEFIcFZKUHJPcUxrLF9UWkhQd1hJWXNNbTZodVh4Z0FNSnpXcWk2ckdjcDczLDE1NTc1ODEwMg0200OQrSzDF0/pdf?s=ap',	'https://invoice.stripe.com/i/acct_1AC6lAHpVJPrOqLk/test_YWNjdF8xQUM2bEFIcFZKUHJPcUxrLF9UWkhQd1hJWXNNbTZodVh4Z0FNSnpXcWk2ckdjcDczLDE1NTc1ODEwMg0200OQrSzDF0?s=ap',	'subscription_update',	9900,	0,	9900,	9900,	9900,	0,	0,	NULL,	NULL,	'succeeded',	NULL,	NULL,	NULL,	0,	NULL,	NULL,	'2025-12-08 18:08:24',	'2025-12-08 18:08:18',	'2025-12-08 18:08:18',	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-12-08 18:08:24',	'2025-12-08 18:08:24+00'),
(2,	2,	'in_1Sc9R5HpVJPrOqLkM1DKHuY9',	NULL,	0,	'usd',	'paid',	'6f4362d5-744c-446e-8108-8db805396e51',	NULL,	NULL,	'sub_1Sc9R5HpVJPrOqLkPt4sV5R5',	'cus_TZI0IIGiL6g3IG',	NULL,	'ITYFUTSR-0001',	'https://pay.stripe.com/invoice/acct_1AC6lAHpVJPrOqLk/test_YWNjdF8xQUM2bEFIcFZKUHJPcUxrLF9UWkkxOHVwamdBOVB0NlFwY2czMFlhek1Hd3VDbEw3LDE1NTc2MDMyOQ0200f13RqvAq/pdf?s=ap',	'https://invoice.stripe.com/i/acct_1AC6lAHpVJPrOqLk/test_YWNjdF8xQUM2bEFIcFZKUHJPcUxrLF9UWkkxOHVwamdBOVB0NlFwY2czMFlhek1Hd3VDbEw3LDE1NTc2MDMyOQ0200f13RqvAq?s=ap',	'subscription_update',	0,	0,	0,	0,	0,	0,	0,	NULL,	NULL,	'succeeded',	NULL,	NULL,	NULL,	0,	NULL,	NULL,	'2025-12-08 18:45:31',	'2025-12-08 18:45:27',	'2025-12-08 18:45:27',	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-12-08 18:45:31',	'2025-12-08 18:45:31+00');

DELIMITER ;;

CREATE TRIGGER "on_update_current_timestamp" BEFORE UPDATE ON "insocial_mysql"."transactions" FOR EACH ROW EXECUTE FUNCTION on_update_current_timestamp_transactions();;

DELIMITER ;

DROP TABLE IF EXISTS "user_notifications";
DROP SEQUENCE IF EXISTS user_notifications_id_seq;
CREATE SEQUENCE user_notifications_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."user_notifications" (
    "id" bigint DEFAULT nextval('user_notifications_id_seq') NOT NULL,
    "user_uuid" character varying(255) NOT NULL,
    "type" text DEFAULT 'info' NOT NULL,
    "title" character varying(255) NOT NULL,
    "message" text NOT NULL,
    "icon" character varying(255) DEFAULT 'bell',
    "severity" text DEFAULT 'medium' NOT NULL,
    "link" character varying(255),
    "is_read" smallint DEFAULT '0' NOT NULL,
    "metadata" text,
    "createdat" timestamp NOT NULL,
    "updatedat" timestamp NOT NULL,
    CONSTRAINT "idx_17602_primary" PRIMARY KEY ("id")
)
WITH (oids = false);


DROP TABLE IF EXISTS "user_reports";
DROP SEQUENCE IF EXISTS user_reports_id_seq;
CREATE SEQUENCE user_reports_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."user_reports" (
    "id" bigint DEFAULT nextval('user_reports_id_seq') NOT NULL,
    "user_uuid" character varying(255) NOT NULL,
    "report_name" character varying(255) NOT NULL,
    "report_type" text DEFAULT 'weekly' NOT NULL,
    "template_id" character varying(255),
    "metrics" text,
    "date_range" character varying(255) DEFAULT '7',
    "file_path" character varying(255),
    "file_size" bigint DEFAULT '0',
    "status" text DEFAULT 'pending' NOT NULL,
    "is_favorite" smallint DEFAULT '0' NOT NULL,
    "schedule_frequency" text DEFAULT 'none' NOT NULL,
    "schedule_enabled" smallint DEFAULT '0' NOT NULL,
    "schedule_day" bigint,
    "schedule_time" character varying(255),
    "last_generated_at" timestamp,
    "notes" text,
    "report_data" text,
    "insights" text,
    "comparison_data" text,
    "user_logo_path" character varying(255),
    "email_delivery_enabled" smallint DEFAULT '0' NOT NULL,
    "email_recipients" text,
    "createdat" timestamp NOT NULL,
    "updatedat" timestamp NOT NULL,
    CONSTRAINT "idx_17614_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

INSERT INTO "user_reports" ("id", "user_uuid", "report_name", "report_type", "template_id", "metrics", "date_range", "file_path", "file_size", "status", "is_favorite", "schedule_frequency", "schedule_enabled", "schedule_day", "schedule_time", "last_generated_at", "notes", "report_data", "insights", "comparison_data", "user_logo_path", "email_delivery_enabled", "email_recipients", "createdat", "updatedat") VALUES
(7,	'9e47ed0e-73f7-41d5-9dac-5c37b8df8a4f',	'retet',	'weekly',	NULL,	'["totalReach","engagement","followerGrowth","topContent"]',	'30',	'report_1765263792473_vm5xnmiis.pdf',	11371,	'ready',	0,	'none',	0,	NULL,	NULL,	'2025-12-09 07:03:12',	NULL,	'{"reach":{"total":0,"impressions":0,"views":0,"growth":0,"growthPercent":0,"previousPeriod":0},"followerGrowth":{"startFollowers":0,"endFollowers":0,"growth":0,"growthPercent":0,"dailyGrowthRate":0,"trend":"stable"},"engagement":{"totalLikes":0,"totalComments":0,"totalShares":0,"totalEngagements":0,"totalImpressions":0,"totalPosts":0,"avgEngagementPerPost":0,"engagementRate":0,"interactionRate":0,"breakdown":{"likes":{"count":0,"percentage":0},"comments":{"count":0,"percentage":0},"shares":{"count":0,"percentage":0}}},"topContent":[],"timeSeries":[],"heatmap":{"heatmap":{"0":{"0":{"totalEngagement":0,"count":0,"avgEngagement":0},"3":{"totalEngagement":0,"count":0,"avgEngagement":0},"6":{"totalEngagement":0,"count":0,"avgEngagement":0},"9":{"totalEngagement":0,"count":0,"avgEngagement":0},"12":{"totalEngagement":0,"count":0,"avgEngagement":0},"15":{"totalEngagement":0,"count":0,"avgEngagement":0},"18":{"totalEngagement":0,"count":0,"avgEngagement":0},"21":{"totalEngagement":0,"count":0,"avgEngagement":0}},"1":{"0":{"totalEngagement":0,"count":0,"avgEngagement":0},"3":{"totalEngagement":0,"count":0,"avgEngagement":0},"6":{"totalEngagement":0,"count":0,"avgEngagement":0},"9":{"totalEngagement":0,"count":0,"avgEngagement":0},"12":{"totalEngagement":0,"count":0,"avgEngagement":0},"15":{"totalEngagement":0,"count":0,"avgEngagement":0},"18":{"totalEngagement":0,"count":0,"avgEngagement":0},"21":{"totalEngagement":0,"count":0,"avgEngagement":0}},"2":{"0":{"totalEngagement":0,"count":0,"avgEngagement":0},"3":{"totalEngagement":0,"count":0,"avgEngagement":0},"6":{"totalEngagement":0,"count":0,"avgEngagement":0},"9":{"totalEngagement":0,"count":0,"avgEngagement":0},"12":{"totalEngagement":0,"count":0,"avgEngagement":0},"15":{"totalEngagement":0,"count":0,"avgEngagement":0},"18":{"totalEngagement":0,"count":0,"avgEngagement":0},"21":{"totalEngagement":0,"count":0,"avgEngagement":0}},"3":{"0":{"totalEngagement":0,"count":0,"avgEngagement":0},"3":{"totalEngagement":0,"count":0,"avgEngagement":0},"6":{"totalEngagement":0,"count":0,"avgEngagement":0},"9":{"totalEngagement":0,"count":0,"avgEngagement":0},"12":{"totalEngagement":0,"count":0,"avgEngagement":0},"15":{"totalEngagement":0,"count":0,"avgEngagement":0},"18":{"totalEngagement":0,"count":0,"avgEngagement":0},"21":{"totalEngagement":0,"count":0,"avgEngagement":0}},"4":{"0":{"totalEngagement":0,"count":0,"avgEngagement":0},"3":{"totalEngagement":0,"count":0,"avgEngagement":0},"6":{"totalEngagement":0,"count":0,"avgEngagement":0},"9":{"totalEngagement":0,"count":0,"avgEngagement":0},"12":{"totalEngagement":0,"count":0,"avgEngagement":0},"15":{"totalEngagement":0,"count":0,"avgEngagement":0},"18":{"totalEngagement":0,"count":0,"avgEngagement":0},"21":{"totalEngagement":0,"count":0,"avgEngagement":0}},"5":{"0":{"totalEngagement":0,"count":0,"avgEngagement":0},"3":{"totalEngagement":0,"count":0,"avgEngagement":0},"6":{"totalEngagement":0,"count":0,"avgEngagement":0},"9":{"totalEngagement":0,"count":0,"avgEngagement":0},"12":{"totalEngagement":0,"count":0,"avgEngagement":0},"15":{"totalEngagement":0,"count":0,"avgEngagement":0},"18":{"totalEngagement":0,"count":0,"avgEngagement":0},"21":{"totalEngagement":0,"count":0,"avgEngagement":0}},"6":{"0":{"totalEngagement":0,"count":0,"avgEngagement":0},"3":{"totalEngagement":0,"count":0,"avgEngagement":0},"6":{"totalEngagement":0,"count":0,"avgEngagement":0},"9":{"totalEngagement":0,"count":0,"avgEngagement":0},"12":{"totalEngagement":0,"count":0,"avgEngagement":0},"15":{"totalEngagement":0,"count":0,"avgEngagement":0},"18":{"totalEngagement":0,"count":0,"avgEngagement":0},"21":{"totalEngagement":0,"count":0,"avgEngagement":0}}},"bestTime":null,"totalPosts":0},"summary":{"reportType":"weekly","dateRange":"Last 30 days","startDate":"2025-11-09","endDate":"2025-12-09","generatedAt":"2025-12-09T07:03:12.462Z","totalMetrics":4},"insights":[{"type":"warning","title":"Low Engagement Rate","description":"Your engagement rate is below average. Consider creating more interactive and valuable content."}],"recommendations":["Consider using more engaging content formats like videos and carousels to boost engagement rate.","Increase posting frequency and engage more with your audience to accelerate growth.","Regularly analyze your competitors to identify content opportunities.","Use hashtags strategically to increase discoverability of your posts."],"benchmarks":[{"metric":"Engagement Rate","yourValue":"0%","benchmark":"3.5%","difference":-3.5,"status":"below"},{"metric":"Follower Growth","yourValue":"0%","benchmark":"5%","difference":-5,"status":"below"}],"predictions":null,"growthProjections":null}',	'[{"type":"warning","title":"Low Engagement Rate","description":"Your engagement rate is below average. Consider creating more interactive and valuable content."}]',	NULL,	NULL,	0,	NULL,	'2025-12-09 07:03:12',	'2025-12-09 07:03:12');

DROP TABLE IF EXISTS "users";
DROP SEQUENCE IF EXISTS users_id_seq;
CREATE SEQUENCE users_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."users" (
    "id" bigint DEFAULT nextval('users_id_seq') NOT NULL,
    "uuid" character(36),
    "firstname" character varying(200) NOT NULL,
    "lastname" character varying(200) NOT NULL,
    "email" character varying(250) NOT NULL,
    "bio" character varying(255),
    "company" character varying(255),
    "jobtitle" character varying(255),
    "userlocation" character varying(255),
    "userwebsite" character varying(255),
    "password" character varying(250) NOT NULL,
    "role" text DEFAULT 'User',
    "profileimage" character varying(255),
    "timezone" character varying(255),
    "otp" character varying(100),
    "otpgeneratedat" timestamptz,
    "resetpasswordtoken" character varying(255),
    "resetpasswordrequesttime" character varying(255),
    "onboardgoal" text DEFAULT '{}',
    "onboardrole" text DEFAULT '{}',
    "status" text DEFAULT '0' NOT NULL,
    "onboard_status" text DEFAULT '0' NOT NULL,
    "createdat" timestamptz DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "updatedat" timestamptz DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "stripe_customer_id" character varying(255),
    "billing_name" character varying(255),
    "billing_email" character varying(255),
    "billing_phone" character varying(50),
    "billing_address_line1" character varying(255),
    "billing_address_line2" character varying(255),
    "billing_city" character varying(100),
    "billing_state" character varying(100),
    "billing_postal_code" character varying(20),
    "billing_country" character varying(2),
    "tax_id" character varying(50),
    "tax_id_type" character varying(20),
    "default_payment_method_id" character varying(255),
    CONSTRAINT "idx_17564_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

COMMENT ON COLUMN "insocial_mysql"."users"."status" IS '0 = Unverified, 1 = Verified, 2 = Deleted account';

COMMENT ON COLUMN "insocial_mysql"."users"."onboard_status" IS '0=''Incomplete'',1=''completed''';

COMMENT ON COLUMN "insocial_mysql"."users"."stripe_customer_id" IS 'Stripe customer ID for billing';

COMMENT ON COLUMN "insocial_mysql"."users"."billing_name" IS 'Billing name (can differ from user name)';

COMMENT ON COLUMN "insocial_mysql"."users"."billing_email" IS 'Billing email for invoices';

COMMENT ON COLUMN "insocial_mysql"."users"."billing_phone" IS 'Billing phone number';

COMMENT ON COLUMN "insocial_mysql"."users"."billing_address_line1" IS 'Billing address line 1';

COMMENT ON COLUMN "insocial_mysql"."users"."billing_address_line2" IS 'Billing address line 2';

COMMENT ON COLUMN "insocial_mysql"."users"."billing_city" IS 'Billing city';

COMMENT ON COLUMN "insocial_mysql"."users"."billing_state" IS 'Billing state/province';

COMMENT ON COLUMN "insocial_mysql"."users"."billing_postal_code" IS 'Billing postal/zip code';

COMMENT ON COLUMN "insocial_mysql"."users"."billing_country" IS 'Billing country code';

COMMENT ON COLUMN "insocial_mysql"."users"."tax_id" IS 'Tax ID (VAT, etc.)';

COMMENT ON COLUMN "insocial_mysql"."users"."tax_id_type" IS 'Tax ID type';

COMMENT ON COLUMN "insocial_mysql"."users"."default_payment_method_id" IS 'Default Stripe payment method ID';

CREATE UNIQUE INDEX idx_17564_uuid ON insocial_mysql.users USING btree (uuid);

CREATE UNIQUE INDEX idx_17564_email ON insocial_mysql.users USING btree (email);

INSERT INTO "users" ("id", "uuid", "firstname", "lastname", "email", "bio", "company", "jobtitle", "userlocation", "userwebsite", "password", "role", "profileimage", "timezone", "otp", "otpgeneratedat", "resetpasswordtoken", "resetpasswordrequesttime", "onboardgoal", "onboardrole", "status", "onboard_status", "createdat", "updatedat", "stripe_customer_id", "billing_name", "billing_email", "billing_phone", "billing_address_line1", "billing_address_line2", "billing_city", "billing_state", "billing_postal_code", "billing_country", "tax_id", "tax_id_type", "default_payment_method_id") VALUES
(1,	'b4206492-1778-4860-8e24-af93296a37d4',	'Test',	'User',	'test@insocialwise.com',	'',	'Aronasoft',	'',	'Panchkula',	'aronasoft.com',	'$2a$10$4xQpKBbFb9j5HWIs6mv/lO3E4mmXT3r4RHBO/SKGrFIbq9wJMSv7e',	'User',	'/uploads/users/upload_img-1758189121598.png',	'Asia/Seoul',	NULL,	NULL,	'',	'',	'{}',	'{}',	'1',	'0',	'2024-12-12 06:21:58+00',	'2025-09-20 08:24:24+00',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(104,	'9e47ed0e-73f7-41d5-9dac-5c37b8df8a4f',	'Baljeet',	'Singh',	'developer0945@gmail.com',	NULL,	NULL,	NULL,	NULL,	NULL,	'$2a$10$bVadGcd.zuCd1WjKZ4DczeGANQw7RC6GvDkK7p074h0dhdyDkaomS',	'User',	NULL,	'Australia/Brisbane',	NULL,	NULL,	NULL,	NULL,	'"growth"',	'"organization"',	'1',	'1',	'2025-12-08 18:06:20+00',	'2025-12-08 18:09:54+00',	'cus_TZHNim28DTlc56',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(105,	'6f4362d5-744c-446e-8108-8db805396e51',	'Baljeet',	'Singh',	'developerw0945@gmail.com',	NULL,	NULL,	NULL,	NULL,	NULL,	'$2a$10$2.ph/d7gEVBclHCjy/vTWuFclYcZl3b8kh5W7kgF1SlMXiGiufFfC',	'User',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'{}',	'{}',	'1',	'0',	'2025-12-08 18:45:11+00',	'2025-12-08 18:45:29+00',	'cus_TZI0IIGiL6g3IG',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS "webhook_events";
DROP SEQUENCE IF EXISTS webhook_events_id_seq;
CREATE SEQUENCE webhook_events_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."webhook_events" (
    "id" bigint DEFAULT nextval('webhook_events_id_seq') NOT NULL,
    "stripe_event_id" character varying(255) NOT NULL,
    "event_type" character varying(100) NOT NULL,
    "api_version" character varying(20),
    "livemode" smallint DEFAULT '0' NOT NULL,
    "object_type" character varying(50),
    "object_id" character varying(255),
    "customer_id" character varying(255),
    "subscription_id" character varying(255),
    "invoice_id" character varying(255),
    "payment_intent_id" character varying(255),
    "payload" text NOT NULL,
    "payload_hash" character varying(64),
    "status" text DEFAULT 'received' NOT NULL,
    "processing_attempts" bigint DEFAULT '0' NOT NULL,
    "max_attempts" bigint DEFAULT '5' NOT NULL,
    "received_at" timestamp NOT NULL,
    "processed_at" timestamp,
    "next_retry_at" timestamp,
    "error_code" character varying(100),
    "error_message" text,
    "error_stack" text,
    "processing_time_ms" bigint,
    "actions_taken" text,
    "affected_records" text,
    "ip_address" character varying(45),
    "signature_verified" smallint,
    "metadata" text,
    "createdat" timestamp NOT NULL,
    "updatedat" timestamp NOT NULL,
    CONSTRAINT "idx_17644_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

COMMENT ON COLUMN "insocial_mysql"."webhook_events"."stripe_event_id" IS 'Stripe event ID (for idempotency)';

COMMENT ON COLUMN "insocial_mysql"."webhook_events"."event_type" IS 'Stripe event type (e.g., customer.subscription.created)';

COMMENT ON COLUMN "insocial_mysql"."webhook_events"."api_version" IS 'Stripe API version';

COMMENT ON COLUMN "insocial_mysql"."webhook_events"."livemode" IS 'Whether this is a live mode event';

COMMENT ON COLUMN "insocial_mysql"."webhook_events"."object_type" IS 'Type of object (subscription, invoice, etc.)';

COMMENT ON COLUMN "insocial_mysql"."webhook_events"."object_id" IS 'Stripe object ID';

COMMENT ON COLUMN "insocial_mysql"."webhook_events"."customer_id" IS 'Stripe customer ID if applicable';

COMMENT ON COLUMN "insocial_mysql"."webhook_events"."subscription_id" IS 'Stripe subscription ID if applicable';

COMMENT ON COLUMN "insocial_mysql"."webhook_events"."invoice_id" IS 'Stripe invoice ID if applicable';

COMMENT ON COLUMN "insocial_mysql"."webhook_events"."payment_intent_id" IS 'Stripe payment intent ID if applicable';

COMMENT ON COLUMN "insocial_mysql"."webhook_events"."payload" IS 'Full event payload from Stripe';

COMMENT ON COLUMN "insocial_mysql"."webhook_events"."payload_hash" IS 'SHA-256 hash of payload for verification';

COMMENT ON COLUMN "insocial_mysql"."webhook_events"."status" IS 'Processing status';

COMMENT ON COLUMN "insocial_mysql"."webhook_events"."processing_attempts" IS 'Number of processing attempts';

COMMENT ON COLUMN "insocial_mysql"."webhook_events"."max_attempts" IS 'Maximum processing attempts';

COMMENT ON COLUMN "insocial_mysql"."webhook_events"."received_at" IS 'When webhook was received';

COMMENT ON COLUMN "insocial_mysql"."webhook_events"."processed_at" IS 'When webhook was processed';

COMMENT ON COLUMN "insocial_mysql"."webhook_events"."next_retry_at" IS 'When to retry processing';

COMMENT ON COLUMN "insocial_mysql"."webhook_events"."error_code" IS 'Error code if failed';

COMMENT ON COLUMN "insocial_mysql"."webhook_events"."error_message" IS 'Error message if failed';

COMMENT ON COLUMN "insocial_mysql"."webhook_events"."error_stack" IS 'Error stack trace';

COMMENT ON COLUMN "insocial_mysql"."webhook_events"."processing_time_ms" IS 'Time taken to process in milliseconds';

COMMENT ON COLUMN "insocial_mysql"."webhook_events"."actions_taken" IS 'List of actions taken during processing';

COMMENT ON COLUMN "insocial_mysql"."webhook_events"."affected_records" IS 'Records affected by this webhook';

COMMENT ON COLUMN "insocial_mysql"."webhook_events"."ip_address" IS 'Source IP address';

COMMENT ON COLUMN "insocial_mysql"."webhook_events"."signature_verified" IS 'Whether Stripe signature was verified';

COMMENT ON COLUMN "insocial_mysql"."webhook_events"."metadata" IS 'Additional metadata';

CREATE UNIQUE INDEX idx_17644_stripe_event_id ON insocial_mysql.webhook_events USING btree (stripe_event_id);

INSERT INTO "webhook_events" ("id", "stripe_event_id", "event_type", "api_version", "livemode", "object_type", "object_id", "customer_id", "subscription_id", "invoice_id", "payment_intent_id", "payload", "payload_hash", "status", "processing_attempts", "max_attempts", "received_at", "processed_at", "next_retry_at", "error_code", "error_message", "error_stack", "processing_time_ms", "actions_taken", "affected_records", "ip_address", "signature_verified", "metadata", "createdat", "updatedat") VALUES
(1,	'evt_1Sc8pkHpVJPrOqLkcvn6pNdS',	'customer.subscription.deleted',	'2018-05-21',	0,	'subscription',	'sub_1Sc54THpVJPrOqLkbsD9YIqh',	'cus_TZDVHbxBmsgDOt',	'sub_1Sc54THpVJPrOqLkbsD9YIqh',	NULL,	NULL,	'{"id":"evt_1Sc8pkHpVJPrOqLkcvn6pNdS","object":"event","api_version":"2018-05-21","created":1765217211,"data":{"object":{"id":"sub_1Sc54THpVJPrOqLkbsD9YIqh","object":"subscription","application":null,"application_fee_percent":null,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null},"billing":"charge_automatically","billing_cycle_anchor":1765202749,"billing_cycle_anchor_config":null,"billing_mode":{"flexible":{"proration_discounts":"included"},"type":"flexible","updated_at":1765202749},"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":1765217211,"cancellation_details":{"comment":null,"feedback":null,"reason":"cancellation_requested"},"collection_method":"charge_automatically","created":1765202749,"currency":"usd","current_period_end":1767881149,"current_period_start":1765202749,"customer":"cus_TZDVHbxBmsgDOt","customer_account":null,"days_until_due":null,"default_payment_method":"pm_1Sc54RHpVJPrOqLkd0YQ6Q0Q","default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"ended_at":1765217211,"invoice_customer_balance_settings":{"consume_applied_balance_on_void":true},"invoice_settings":{"account_tax_ids":null,"issuer":{"type":"self"}},"items":{"object":"list","data":[{"id":"si_TZDV4Es6WBMUpd","object":"subscription_item","billing_thresholds":null,"created":1765202750,"current_period_end":1767881149,"current_period_start":1765202749,"discounts":[],"metadata":{},"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"price":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"price","active":true,"billing_scheme":"per_unit","created":1764856094,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"nickname":null,"product":"prod_TXiJSc9kvYKDXH","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":9900,"unit_amount_decimal":"9900"},"quantity":1,"subscription":"sub_1Sc54THpVJPrOqLkbsD9YIqh","tax_rates":[]}],"has_more":false,"total_count":1,"url":"/v1/subscription_items?subscription=sub_1Sc54THpVJPrOqLkbsD9YIqh"},"latest_invoice":"in_1Sc54THpVJPrOqLkQEvNGsPY","livemode":false,"metadata":{},"next_pending_invoice_item_invoice":null,"on_behalf_of":null,"pause_collection":null,"payment_settings":{"payment_method_options":null,"payment_method_types":null,"save_default_payment_method":"off"},"pending_invoice_item_interval":null,"pending_setup_intent":null,"pending_update":null,"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1765202749,"start_date":1765202749,"status":"canceled","tax_percent":null,"test_clock":null,"transfer_data":null,"trial_end":null,"trial_settings":{"end_behavior":{"missing_payment_method":"create_invoice"}},"trial_start":null}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_Ej8LHLE76oFsFq","idempotency_key":null},"type":"customer.subscription.deleted"}',	'fb86add953bdfa4877ba8c2be9c2a406fd14aa117c3f4840afd92801b76f05f6',	'processed',	0,	5,	'2025-12-08 18:06:52',	'2025-12-08 18:06:53',	NULL,	NULL,	NULL,	NULL,	990,	'[]',	'[]',	'::ffff:127.0.0.1',	1,	NULL,	'2025-12-08 18:06:52',	'2025-12-08 18:06:53'),
(2,	'evt_1Sc8ppHpVJPrOqLk5f7ABUpc',	'customer.subscription.deleted',	'2018-05-21',	0,	'subscription',	'sub_1Sc528HpVJPrOqLkLV8FsINs',	'cus_TZDSda2Cjwyb9C',	'sub_1Sc528HpVJPrOqLkLV8FsINs',	NULL,	NULL,	'{"id":"evt_1Sc8ppHpVJPrOqLk5f7ABUpc","object":"event","api_version":"2018-05-21","created":1765217217,"data":{"object":{"id":"sub_1Sc528HpVJPrOqLkLV8FsINs","object":"subscription","application":null,"application_fee_percent":null,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null},"billing":"charge_automatically","billing_cycle_anchor":1765202604,"billing_cycle_anchor_config":null,"billing_mode":{"flexible":{"proration_discounts":"included"},"type":"flexible","updated_at":1765202604},"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":1765217217,"cancellation_details":{"comment":null,"feedback":null,"reason":"cancellation_requested"},"collection_method":"charge_automatically","created":1765202604,"currency":"usd","current_period_end":1767881004,"current_period_start":1765202604,"customer":"cus_TZDSda2Cjwyb9C","customer_account":null,"days_until_due":null,"default_payment_method":"pm_1Sc525HpVJPrOqLksIqFgiqf","default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"ended_at":1765217217,"invoice_customer_balance_settings":{"consume_applied_balance_on_void":true},"invoice_settings":{"account_tax_ids":null,"issuer":{"type":"self"}},"items":{"object":"list","data":[{"id":"si_TZDTAYHE7h3nYK","object":"subscription_item","billing_thresholds":null,"created":1765202604,"current_period_end":1767881004,"current_period_start":1765202604,"discounts":[],"metadata":{},"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"price":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"price","active":true,"billing_scheme":"per_unit","created":1764856094,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"nickname":null,"product":"prod_TXiJSc9kvYKDXH","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":9900,"unit_amount_decimal":"9900"},"quantity":1,"subscription":"sub_1Sc528HpVJPrOqLkLV8FsINs","tax_rates":[]}],"has_more":false,"total_count":1,"url":"/v1/subscription_items?subscription=sub_1Sc528HpVJPrOqLkLV8FsINs"},"latest_invoice":"in_1Sc528HpVJPrOqLkzIdb2XXy","livemode":false,"metadata":{},"next_pending_invoice_item_invoice":null,"on_behalf_of":null,"pause_collection":null,"payment_settings":{"payment_method_options":null,"payment_method_types":null,"save_default_payment_method":"off"},"pending_invoice_item_interval":null,"pending_setup_intent":null,"pending_update":null,"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1765202604,"start_date":1765202604,"status":"canceled","tax_percent":null,"test_clock":null,"transfer_data":null,"trial_end":null,"trial_settings":{"end_behavior":{"missing_payment_method":"create_invoice"}},"trial_start":null}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_3IzTlqD5QlAayS","idempotency_key":null},"type":"customer.subscription.deleted"}',	'465f75f620c5e6db6243b80a94841fd8641781b2d839f950bb240fcfaa624ee3',	'processed',	0,	5,	'2025-12-08 18:06:59',	'2025-12-08 18:06:59',	NULL,	NULL,	NULL,	NULL,	758,	'[]',	'[]',	'::1',	1,	NULL,	'2025-12-08 18:06:59',	'2025-12-08 18:06:59'),
(3,	'evt_1Sc8pwHpVJPrOqLklCq6wBYr',	'customer.subscription.deleted',	'2018-05-21',	0,	'subscription',	'sub_1SbNtoHpVJPrOqLkXJiCHhwx',	'cus_TYUtFbKUjXADZY',	'sub_1SbNtoHpVJPrOqLkXJiCHhwx',	NULL,	NULL,	'{"id":"evt_1Sc8pwHpVJPrOqLklCq6wBYr","object":"event","api_version":"2018-05-21","created":1765217224,"data":{"object":{"id":"sub_1SbNtoHpVJPrOqLkXJiCHhwx","object":"subscription","application":null,"application_fee_percent":null,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null},"billing":"charge_automatically","billing_cycle_anchor":1765123196,"billing_cycle_anchor_config":null,"billing_mode":{"flexible":{"proration_discounts":"included"},"type":"flexible","updated_at":1765036796},"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":1765217223,"cancellation_details":{"comment":null,"feedback":null,"reason":"cancellation_requested"},"collection_method":"charge_automatically","created":1765036796,"currency":"usd","current_period_end":1767801596,"current_period_start":1765123196,"customer":"cus_TYUtFbKUjXADZY","customer_account":null,"days_until_due":null,"default_payment_method":"pm_1SbNtzHpVJPrOqLkghRJQsoJ","default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"ended_at":1765217223,"invoice_customer_balance_settings":{"consume_applied_balance_on_void":true},"invoice_settings":{"account_tax_ids":null,"issuer":{"type":"self"}},"items":{"object":"list","data":[{"id":"si_TYUtIBah9vp5cD","object":"subscription_item","billing_thresholds":null,"created":1765036797,"current_period_end":1767801596,"current_period_start":1765123196,"discounts":[],"metadata":{},"plan":{"id":"price_1SacsoHpVJPrOqLk55ldH9MX","object":"plan","active":true,"aggregate_usage":null,"amount":1900,"amount_decimal":"1900","billing_scheme":"per_unit","created":1764856066,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"10","plan_id":"1","billing_cycle":"monthly","max_team_members":"1","trial_days":"1"},"meter":null,"nickname":null,"product":"prod_TXiJ5slia0Fh1C","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"price":{"id":"price_1SacsoHpVJPrOqLk55ldH9MX","object":"price","active":true,"billing_scheme":"per_unit","created":1764856066,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"10","plan_id":"1","billing_cycle":"monthly","max_team_members":"1","trial_days":"1"},"nickname":null,"product":"prod_TXiJ5slia0Fh1C","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":1900,"unit_amount_decimal":"1900"},"quantity":1,"subscription":"sub_1SbNtoHpVJPrOqLkXJiCHhwx","tax_rates":[]}],"has_more":false,"total_count":1,"url":"/v1/subscription_items?subscription=sub_1SbNtoHpVJPrOqLkXJiCHhwx"},"latest_invoice":"in_1SbkNtHpVJPrOqLkqqTo8QTQ","livemode":false,"metadata":{},"next_pending_invoice_item_invoice":null,"on_behalf_of":null,"pause_collection":null,"payment_settings":{"payment_method_options":null,"payment_method_types":null,"save_default_payment_method":"off"},"pending_invoice_item_interval":null,"pending_setup_intent":null,"pending_update":null,"plan":{"id":"price_1SacsoHpVJPrOqLk55ldH9MX","object":"plan","active":true,"aggregate_usage":null,"amount":1900,"amount_decimal":"1900","billing_scheme":"per_unit","created":1764856066,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"10","plan_id":"1","billing_cycle":"monthly","max_team_members":"1","trial_days":"1"},"meter":null,"nickname":null,"product":"prod_TXiJ5slia0Fh1C","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1765036796,"start_date":1765036796,"status":"canceled","tax_percent":null,"test_clock":null,"transfer_data":null,"trial_end":1765123196,"trial_settings":{"end_behavior":{"missing_payment_method":"create_invoice"}},"trial_start":1765036796}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_n6lxHLxbjxLTjt","idempotency_key":null},"type":"customer.subscription.deleted"}',	'b65485f7f7b9042e07ca6c37c7e0af2fba23c6d12891191bd3e82ff7dcb296af',	'processed',	0,	5,	'2025-12-08 18:07:05',	'2025-12-08 18:07:05',	NULL,	NULL,	NULL,	NULL,	1033,	'[]',	'[]',	'::ffff:127.0.0.1',	1,	NULL,	'2025-12-08 18:07:05',	'2025-12-08 18:07:05'),
(4,	'evt_1Sc8qcHpVJPrOqLkSykUoQeJ',	'customer.subscription.updated',	'2018-05-21',	0,	'subscription',	'sub_1Sc4s1HpVJPrOqLknlyBXpb5',	'cus_TZDIqpPX565FxE',	'sub_1Sc4s1HpVJPrOqLknlyBXpb5',	NULL,	NULL,	'{"id":"evt_1Sc8qcHpVJPrOqLkSykUoQeJ","object":"event","api_version":"2018-05-21","created":1765217266,"data":{"object":{"id":"sub_1Sc4s1HpVJPrOqLknlyBXpb5","object":"subscription","application":null,"application_fee_percent":null,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null},"billing":"charge_automatically","billing_cycle_anchor":1765201977,"billing_cycle_anchor_config":null,"billing_mode":{"flexible":{"proration_discounts":"included"},"type":"flexible","updated_at":1765201977},"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":1765217265,"cancellation_details":{"comment":null,"feedback":null,"reason":null},"collection_method":"charge_automatically","created":1765201977,"currency":"usd","current_period_end":1767880377,"current_period_start":1765201977,"customer":"cus_TZDIqpPX565FxE","customer_account":null,"days_until_due":null,"default_payment_method":null,"default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"ended_at":1765217265,"invoice_customer_balance_settings":{"consume_applied_balance_on_void":true},"invoice_settings":{"account_tax_ids":null,"issuer":{"type":"self"}},"items":{"object":"list","data":[{"id":"si_TZDIrosbIbcG5e","object":"subscription_item","billing_thresholds":null,"created":1765201977,"current_period_end":1767880377,"current_period_start":1765201977,"discounts":[],"metadata":{},"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"price":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"price","active":true,"billing_scheme":"per_unit","created":1764856094,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"nickname":null,"product":"prod_TXiJSc9kvYKDXH","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":9900,"unit_amount_decimal":"9900"},"quantity":1,"subscription":"sub_1Sc4s1HpVJPrOqLknlyBXpb5","tax_rates":[]}],"has_more":false,"total_count":1,"url":"/v1/subscription_items?subscription=sub_1Sc4s1HpVJPrOqLknlyBXpb5"},"latest_invoice":"in_1Sc4s1HpVJPrOqLkPLs06Grx","livemode":false,"metadata":{},"next_pending_invoice_item_invoice":null,"on_behalf_of":null,"pause_collection":null,"payment_settings":{"payment_method_options":null,"payment_method_types":null,"save_default_payment_method":"off"},"pending_invoice_item_interval":null,"pending_setup_intent":null,"pending_update":null,"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1765201977,"start_date":1765201977,"status":"incomplete_expired","tax_percent":null,"test_clock":null,"transfer_data":null,"trial_end":null,"trial_settings":{"end_behavior":{"missing_payment_method":"create_invoice"}},"trial_start":null},"previous_attributes":{"canceled_at":null,"ended_at":null,"status":"incomplete"}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_SdVIbfQRLcDo9z","idempotency_key":"batchapi-batch_1Sc8qJHpVJPrOqLkufeCTtwz-cus_TZDIqpPX565FxE_delete_customer"},"type":"customer.subscription.updated"}',	'3d54a47cd0f9b75f2362fd1b2d784a077d7a35b5e583a401d90f964ea19bd2c1',	'processed',	0,	5,	'2025-12-08 18:07:47',	'2025-12-08 18:07:48',	NULL,	NULL,	NULL,	NULL,	990,	'[]',	'[]',	'::1',	1,	NULL,	'2025-12-08 18:07:47',	'2025-12-08 18:07:48'),
(5,	'evt_1Sc8qeHpVJPrOqLkyqgkXnzp',	'customer.subscription.updated',	'2018-05-21',	0,	'subscription',	'sub_1Sc4PCHpVJPrOqLkIa3dxyJ0',	'cus_TZCojn6Lu4LVzS',	'sub_1Sc4PCHpVJPrOqLkIa3dxyJ0',	NULL,	NULL,	'{"id":"evt_1Sc8qeHpVJPrOqLkyqgkXnzp","object":"event","api_version":"2018-05-21","created":1765217268,"data":{"object":{"id":"sub_1Sc4PCHpVJPrOqLkIa3dxyJ0","object":"subscription","application":null,"application_fee_percent":null,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null},"billing":"charge_automatically","billing_cycle_anchor":1765200190,"billing_cycle_anchor_config":null,"billing_mode":{"flexible":{"proration_discounts":"included"},"type":"flexible","updated_at":1765200190},"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":1765217267,"cancellation_details":{"comment":null,"feedback":null,"reason":null},"collection_method":"charge_automatically","created":1765200190,"currency":"usd","current_period_end":1767878590,"current_period_start":1765200190,"customer":"cus_TZCojn6Lu4LVzS","customer_account":null,"days_until_due":null,"default_payment_method":null,"default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"ended_at":1765217267,"invoice_customer_balance_settings":{"consume_applied_balance_on_void":true},"invoice_settings":{"account_tax_ids":null,"issuer":{"type":"self"}},"items":{"object":"list","data":[{"id":"si_TZCoMURBGT9oFR","object":"subscription_item","billing_thresholds":null,"created":1765200190,"current_period_end":1767878590,"current_period_start":1765200190,"discounts":[],"metadata":{},"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"price":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"price","active":true,"billing_scheme":"per_unit","created":1764856094,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"nickname":null,"product":"prod_TXiJSc9kvYKDXH","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":9900,"unit_amount_decimal":"9900"},"quantity":1,"subscription":"sub_1Sc4PCHpVJPrOqLkIa3dxyJ0","tax_rates":[]}],"has_more":false,"total_count":1,"url":"/v1/subscription_items?subscription=sub_1Sc4PCHpVJPrOqLkIa3dxyJ0"},"latest_invoice":"in_1Sc4PCHpVJPrOqLkJMSDgtoW","livemode":false,"metadata":{},"next_pending_invoice_item_invoice":null,"on_behalf_of":null,"pause_collection":null,"payment_settings":{"payment_method_options":null,"payment_method_types":null,"save_default_payment_method":"off"},"pending_invoice_item_interval":null,"pending_setup_intent":null,"pending_update":null,"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1765200190,"start_date":1765200190,"status":"incomplete_expired","tax_percent":null,"test_clock":null,"transfer_data":null,"trial_end":null,"trial_settings":{"end_behavior":{"missing_payment_method":"create_invoice"}},"trial_start":null},"previous_attributes":{"canceled_at":null,"ended_at":null,"status":"incomplete"}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_Bg6i8rp0cKcI0k","idempotency_key":"batchapi-batch_1Sc8qJHpVJPrOqLkufeCTtwz-cus_TZCojn6Lu4LVzS_delete_customer"},"type":"customer.subscription.updated"}',	'30dcefc4eaa78a51c907538ad28d07d802aaba8831c9785d78afacf211a56945',	'processed',	0,	5,	'2025-12-08 18:07:49',	'2025-12-08 18:07:50',	NULL,	NULL,	NULL,	NULL,	754,	'[]',	'[]',	'::ffff:127.0.0.1',	1,	NULL,	'2025-12-08 18:07:49',	'2025-12-08 18:07:50'),
(6,	'evt_1Sc8qiHpVJPrOqLk7guCjrC5',	'customer.subscription.updated',	'2018-05-21',	0,	'subscription',	'sub_1Sc4LJHpVJPrOqLkyZdGtlUj',	'cus_TZCktShIKgBvsH',	'sub_1Sc4LJHpVJPrOqLkyZdGtlUj',	NULL,	NULL,	'{"id":"evt_1Sc8qiHpVJPrOqLk7guCjrC5","object":"event","api_version":"2018-05-21","created":1765217272,"data":{"object":{"id":"sub_1Sc4LJHpVJPrOqLkyZdGtlUj","object":"subscription","application":null,"application_fee_percent":null,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null},"billing":"charge_automatically","billing_cycle_anchor":1765199949,"billing_cycle_anchor_config":null,"billing_mode":{"flexible":{"proration_discounts":"included"},"type":"flexible","updated_at":1765199949},"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":1765217271,"cancellation_details":{"comment":null,"feedback":null,"reason":null},"collection_method":"charge_automatically","created":1765199949,"currency":"usd","current_period_end":1767878349,"current_period_start":1765199949,"customer":"cus_TZCktShIKgBvsH","customer_account":null,"days_until_due":null,"default_payment_method":null,"default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"ended_at":1765217271,"invoice_customer_balance_settings":{"consume_applied_balance_on_void":true},"invoice_settings":{"account_tax_ids":null,"issuer":{"type":"self"}},"items":{"object":"list","data":[{"id":"si_TZCkaUrqYwrZxF","object":"subscription_item","billing_thresholds":null,"created":1765199950,"current_period_end":1767878349,"current_period_start":1765199949,"discounts":[],"metadata":{},"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"price":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"price","active":true,"billing_scheme":"per_unit","created":1764856094,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"nickname":null,"product":"prod_TXiJSc9kvYKDXH","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":9900,"unit_amount_decimal":"9900"},"quantity":1,"subscription":"sub_1Sc4LJHpVJPrOqLkyZdGtlUj","tax_rates":[]}],"has_more":false,"total_count":1,"url":"/v1/subscription_items?subscription=sub_1Sc4LJHpVJPrOqLkyZdGtlUj"},"latest_invoice":"in_1Sc4LJHpVJPrOqLk9DTsTia0","livemode":false,"metadata":{},"next_pending_invoice_item_invoice":null,"on_behalf_of":null,"pause_collection":null,"payment_settings":{"payment_method_options":null,"payment_method_types":null,"save_default_payment_method":"off"},"pending_invoice_item_interval":null,"pending_setup_intent":null,"pending_update":null,"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1765199949,"start_date":1765199949,"status":"incomplete_expired","tax_percent":null,"test_clock":null,"transfer_data":null,"trial_end":null,"trial_settings":{"end_behavior":{"missing_payment_method":"create_invoice"}},"trial_start":null},"previous_attributes":{"canceled_at":null,"ended_at":null,"status":"incomplete"}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_Q1yEMVtbecxXpg","idempotency_key":"batchapi-batch_1Sc8qJHpVJPrOqLkufeCTtwz-cus_TZCktShIKgBvsH_delete_customer"},"type":"customer.subscription.updated"}',	'ac49ddb7757001efe29be23e916b422d8abc69877133010e8c10a989401d2157',	'processed',	0,	5,	'2025-12-08 18:07:53',	'2025-12-08 18:07:53',	NULL,	NULL,	NULL,	NULL,	751,	'[]',	'[]',	'::1',	1,	NULL,	'2025-12-08 18:07:53',	'2025-12-08 18:07:53'),
(7,	'evt_1Sc8qlHpVJPrOqLkn95YtMmK',	'customer.subscription.updated',	'2018-05-21',	0,	'subscription',	'sub_1Sc3hbHpVJPrOqLkKCfQcmMj',	'cus_TZC5DYbF42aeYo',	'sub_1Sc3hbHpVJPrOqLkKCfQcmMj',	NULL,	NULL,	'{"id":"evt_1Sc8qlHpVJPrOqLkn95YtMmK","object":"event","api_version":"2018-05-21","created":1765217274,"data":{"object":{"id":"sub_1Sc3hbHpVJPrOqLkKCfQcmMj","object":"subscription","application":null,"application_fee_percent":null,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null},"billing":"charge_automatically","billing_cycle_anchor":1765197487,"billing_cycle_anchor_config":null,"billing_mode":{"flexible":{"proration_discounts":"included"},"type":"flexible","updated_at":1765197487},"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":1765217274,"cancellation_details":{"comment":null,"feedback":null,"reason":null},"collection_method":"charge_automatically","created":1765197487,"currency":"usd","current_period_end":1767875887,"current_period_start":1765197487,"customer":"cus_TZC5DYbF42aeYo","customer_account":null,"days_until_due":null,"default_payment_method":null,"default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"ended_at":1765217274,"invoice_customer_balance_settings":{"consume_applied_balance_on_void":true},"invoice_settings":{"account_tax_ids":null,"issuer":{"type":"self"}},"items":{"object":"list","data":[{"id":"si_TZC55vHf4UM2ar","object":"subscription_item","billing_thresholds":null,"created":1765197488,"current_period_end":1767875887,"current_period_start":1765197487,"discounts":[],"metadata":{},"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"price":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"price","active":true,"billing_scheme":"per_unit","created":1764856094,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"nickname":null,"product":"prod_TXiJSc9kvYKDXH","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":9900,"unit_amount_decimal":"9900"},"quantity":1,"subscription":"sub_1Sc3hbHpVJPrOqLkKCfQcmMj","tax_rates":[]}],"has_more":false,"total_count":1,"url":"/v1/subscription_items?subscription=sub_1Sc3hbHpVJPrOqLkKCfQcmMj"},"latest_invoice":"in_1Sc3hbHpVJPrOqLkq1Fc3hNK","livemode":false,"metadata":{},"next_pending_invoice_item_invoice":null,"on_behalf_of":null,"pause_collection":null,"payment_settings":{"payment_method_options":null,"payment_method_types":null,"save_default_payment_method":"off"},"pending_invoice_item_interval":null,"pending_setup_intent":null,"pending_update":null,"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1765197487,"start_date":1765197487,"status":"incomplete_expired","tax_percent":null,"test_clock":null,"transfer_data":null,"trial_end":null,"trial_settings":{"end_behavior":{"missing_payment_method":"create_invoice"}},"trial_start":null},"previous_attributes":{"canceled_at":null,"ended_at":null,"status":"incomplete"}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_FH9Xd7lymEpe6o","idempotency_key":"batchapi-batch_1Sc8qJHpVJPrOqLkufeCTtwz-cus_TZC5DYbF42aeYo_delete_customer"},"type":"customer.subscription.updated"}',	'31dd6213282c713fb08ef2525a03ae8a621547e561caed34ed404960373c1f7b',	'processed',	0,	5,	'2025-12-08 18:07:55',	'2025-12-08 18:07:56',	NULL,	NULL,	NULL,	NULL,	751,	'[]',	'[]',	'::ffff:127.0.0.1',	1,	NULL,	'2025-12-08 18:07:55',	'2025-12-08 18:07:56'),
(8,	'evt_1Sc8qmHpVJPrOqLkJzOOSZbT',	'customer.subscription.updated',	'2018-05-21',	0,	'subscription',	'sub_1Sc3hAHpVJPrOqLkOiWAaq0O',	'cus_TZC5FWnES5o8tp',	'sub_1Sc3hAHpVJPrOqLkOiWAaq0O',	NULL,	NULL,	'{"id":"evt_1Sc8qmHpVJPrOqLkJzOOSZbT","object":"event","api_version":"2018-05-21","created":1765217276,"data":{"object":{"id":"sub_1Sc3hAHpVJPrOqLkOiWAaq0O","object":"subscription","application":null,"application_fee_percent":null,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null},"billing":"charge_automatically","billing_cycle_anchor":1765197460,"billing_cycle_anchor_config":null,"billing_mode":{"flexible":{"proration_discounts":"included"},"type":"flexible","updated_at":1765197460},"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":1765217275,"cancellation_details":{"comment":null,"feedback":null,"reason":null},"collection_method":"charge_automatically","created":1765197460,"currency":"usd","current_period_end":1767875860,"current_period_start":1765197460,"customer":"cus_TZC5FWnES5o8tp","customer_account":null,"days_until_due":null,"default_payment_method":null,"default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"ended_at":1765217275,"invoice_customer_balance_settings":{"consume_applied_balance_on_void":true},"invoice_settings":{"account_tax_ids":null,"issuer":{"type":"self"}},"items":{"object":"list","data":[{"id":"si_TZC57Y2mkgQQYm","object":"subscription_item","billing_thresholds":null,"created":1765197460,"current_period_end":1767875860,"current_period_start":1765197460,"discounts":[],"metadata":{},"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"price":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"price","active":true,"billing_scheme":"per_unit","created":1764856094,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"nickname":null,"product":"prod_TXiJSc9kvYKDXH","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":9900,"unit_amount_decimal":"9900"},"quantity":1,"subscription":"sub_1Sc3hAHpVJPrOqLkOiWAaq0O","tax_rates":[]}],"has_more":false,"total_count":1,"url":"/v1/subscription_items?subscription=sub_1Sc3hAHpVJPrOqLkOiWAaq0O"},"latest_invoice":"in_1Sc3hAHpVJPrOqLkZbRH36jf","livemode":false,"metadata":{},"next_pending_invoice_item_invoice":null,"on_behalf_of":null,"pause_collection":null,"payment_settings":{"payment_method_options":null,"payment_method_types":null,"save_default_payment_method":"off"},"pending_invoice_item_interval":null,"pending_setup_intent":null,"pending_update":null,"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1765197460,"start_date":1765197460,"status":"incomplete_expired","tax_percent":null,"test_clock":null,"transfer_data":null,"trial_end":null,"trial_settings":{"end_behavior":{"missing_payment_method":"create_invoice"}},"trial_start":null},"previous_attributes":{"canceled_at":null,"ended_at":null,"status":"incomplete"}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_tT14UE8Sf32x8v","idempotency_key":"batchapi-batch_1Sc8qJHpVJPrOqLkufeCTtwz-cus_TZC5FWnES5o8tp_delete_customer"},"type":"customer.subscription.updated"}',	'119342f87588e05e9d6a3b1cf96ecdc578e7cb9501c90ae3a1a7a106c4af23b7',	'processed',	0,	5,	'2025-12-08 18:07:57',	'2025-12-08 18:07:57',	NULL,	NULL,	NULL,	NULL,	753,	'[]',	'[]',	'::1',	1,	NULL,	'2025-12-08 18:07:57',	'2025-12-08 18:07:57'),
(9,	'evt_1Sc8qnHpVJPrOqLkt1YzakFl',	'customer.subscription.updated',	'2018-05-21',	0,	'subscription',	'sub_1Sc3gTHpVJPrOqLkJgsQxZVP',	'cus_TZC4Z95oMzdO7j',	'sub_1Sc3gTHpVJPrOqLkJgsQxZVP',	NULL,	NULL,	'{"id":"evt_1Sc8qnHpVJPrOqLkt1YzakFl","object":"event","api_version":"2018-05-21","created":1765217277,"data":{"object":{"id":"sub_1Sc3gTHpVJPrOqLkJgsQxZVP","object":"subscription","application":null,"application_fee_percent":null,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null},"billing":"charge_automatically","billing_cycle_anchor":1765197417,"billing_cycle_anchor_config":null,"billing_mode":{"flexible":{"proration_discounts":"included"},"type":"flexible","updated_at":1765197417},"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":1765217276,"cancellation_details":{"comment":null,"feedback":null,"reason":null},"collection_method":"charge_automatically","created":1765197417,"currency":"usd","current_period_end":1767875817,"current_period_start":1765197417,"customer":"cus_TZC4Z95oMzdO7j","customer_account":null,"days_until_due":null,"default_payment_method":null,"default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"ended_at":1765217276,"invoice_customer_balance_settings":{"consume_applied_balance_on_void":true},"invoice_settings":{"account_tax_ids":null,"issuer":{"type":"self"}},"items":{"object":"list","data":[{"id":"si_TZC4fBCSM5gNPo","object":"subscription_item","billing_thresholds":null,"created":1765197418,"current_period_end":1767875817,"current_period_start":1765197417,"discounts":[],"metadata":{},"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"price":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"price","active":true,"billing_scheme":"per_unit","created":1764856094,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"nickname":null,"product":"prod_TXiJSc9kvYKDXH","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":9900,"unit_amount_decimal":"9900"},"quantity":1,"subscription":"sub_1Sc3gTHpVJPrOqLkJgsQxZVP","tax_rates":[]}],"has_more":false,"total_count":1,"url":"/v1/subscription_items?subscription=sub_1Sc3gTHpVJPrOqLkJgsQxZVP"},"latest_invoice":"in_1Sc3gUHpVJPrOqLk4mQI17qf","livemode":false,"metadata":{},"next_pending_invoice_item_invoice":null,"on_behalf_of":null,"pause_collection":null,"payment_settings":{"payment_method_options":null,"payment_method_types":null,"save_default_payment_method":"off"},"pending_invoice_item_interval":null,"pending_setup_intent":null,"pending_update":null,"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1765197417,"start_date":1765197417,"status":"incomplete_expired","tax_percent":null,"test_clock":null,"transfer_data":null,"trial_end":null,"trial_settings":{"end_behavior":{"missing_payment_method":"create_invoice"}},"trial_start":null},"previous_attributes":{"canceled_at":null,"ended_at":null,"status":"incomplete"}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_mmHQcw1xmkHJmi","idempotency_key":"batchapi-batch_1Sc8qJHpVJPrOqLkufeCTtwz-cus_TZC4Z95oMzdO7j_delete_customer"},"type":"customer.subscription.updated"}',	'7b037103c64fa020c90f3f1c609115bf4fa490eb882607c1ebe6f4eb612ce809',	'processed',	0,	5,	'2025-12-08 18:07:58',	'2025-12-08 18:07:58',	NULL,	NULL,	NULL,	NULL,	978,	'[]',	'[]',	'::ffff:127.0.0.1',	1,	NULL,	'2025-12-08 18:07:58',	'2025-12-08 18:07:58'),
(10,	'evt_1Sc8qoHpVJPrOqLkwKYgJKl6',	'customer.subscription.deleted',	'2018-05-21',	0,	'subscription',	'sub_1Sc3aSHpVJPrOqLkzZny5VSC',	'cus_TZByG99czFCQiG',	'sub_1Sc3aSHpVJPrOqLkzZny5VSC',	NULL,	NULL,	'{"id":"evt_1Sc8qoHpVJPrOqLkwKYgJKl6","object":"event","api_version":"2018-05-21","created":1765217277,"data":{"object":{"id":"sub_1Sc3aSHpVJPrOqLkzZny5VSC","object":"subscription","application":null,"application_fee_percent":null,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null},"billing":"charge_automatically","billing_cycle_anchor":1766406644,"billing_cycle_anchor_config":null,"billing_mode":{"flexible":{"proration_discounts":"included"},"type":"flexible","updated_at":1765197044},"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":1765217277,"cancellation_details":{"comment":null,"feedback":null,"reason":"cancellation_requested"},"collection_method":"charge_automatically","created":1765197044,"currency":"usd","current_period_end":1766406644,"current_period_start":1765197044,"customer":"cus_TZByG99czFCQiG","customer_account":null,"days_until_due":null,"default_payment_method":null,"default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"ended_at":1765217277,"invoice_customer_balance_settings":{"consume_applied_balance_on_void":true},"invoice_settings":{"account_tax_ids":null,"issuer":{"type":"self"}},"items":{"object":"list","data":[{"id":"si_TZBy3ZDUDi8ZzP","object":"subscription_item","billing_thresholds":null,"created":1765197045,"current_period_end":1766406644,"current_period_start":1765197044,"discounts":[],"metadata":{},"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"price":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"price","active":true,"billing_scheme":"per_unit","created":1764856094,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"nickname":null,"product":"prod_TXiJSc9kvYKDXH","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":9900,"unit_amount_decimal":"9900"},"quantity":1,"subscription":"sub_1Sc3aSHpVJPrOqLkzZny5VSC","tax_rates":[]}],"has_more":false,"total_count":1,"url":"/v1/subscription_items?subscription=sub_1Sc3aSHpVJPrOqLkzZny5VSC"},"latest_invoice":"in_1Sc3aSHpVJPrOqLkGUATpTYi","livemode":false,"metadata":{},"next_pending_invoice_item_invoice":null,"on_behalf_of":null,"pause_collection":null,"payment_settings":{"payment_method_options":null,"payment_method_types":null,"save_default_payment_method":"off"},"pending_invoice_item_interval":null,"pending_setup_intent":"seti_1Sc3aTHpVJPrOqLkTEyJkfqm","pending_update":null,"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1765197044,"start_date":1765197044,"status":"canceled","tax_percent":null,"test_clock":null,"transfer_data":null,"trial_end":1766406644,"trial_settings":{"end_behavior":{"missing_payment_method":"create_invoice"}},"trial_start":1765197044}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_WGbxXEwRsT3Jhl","idempotency_key":"batchapi-batch_1Sc8qJHpVJPrOqLkufeCTtwz-cus_TZByG99czFCQiG_delete_customer"},"type":"customer.subscription.deleted"}',	'ee2a24b592791ccc3b2fc8dd79867009ca45dca67fd68cf022e917caed28069f',	'processed',	0,	5,	'2025-12-08 18:07:59',	'2025-12-08 18:07:59',	NULL,	NULL,	NULL,	NULL,	752,	'[]',	'[]',	'::1',	1,	NULL,	'2025-12-08 18:07:59',	'2025-12-08 18:07:59'),
(11,	'evt_1Sc8qpHpVJPrOqLky5zAXVfp',	'customer.subscription.deleted',	'2018-05-21',	0,	'subscription',	'sub_1Sc3VSHpVJPrOqLk2KdxLmYl',	'cus_TZBtEwD56re95y',	'sub_1Sc3VSHpVJPrOqLk2KdxLmYl',	NULL,	NULL,	'{"id":"evt_1Sc8qpHpVJPrOqLky5zAXVfp","object":"event","api_version":"2018-05-21","created":1765217279,"data":{"object":{"id":"sub_1Sc3VSHpVJPrOqLk2KdxLmYl","object":"subscription","application":null,"application_fee_percent":null,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null},"billing":"charge_automatically","billing_cycle_anchor":1766406334,"billing_cycle_anchor_config":null,"billing_mode":{"flexible":{"proration_discounts":"included"},"type":"flexible","updated_at":1765196734},"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":1765217278,"cancellation_details":{"comment":null,"feedback":null,"reason":"cancellation_requested"},"collection_method":"charge_automatically","created":1765196734,"currency":"usd","current_period_end":1766406334,"current_period_start":1765196734,"customer":"cus_TZBtEwD56re95y","customer_account":null,"days_until_due":null,"default_payment_method":"pm_1Sc3VhHpVJPrOqLki86DVlRa","default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"ended_at":1765217278,"invoice_customer_balance_settings":{"consume_applied_balance_on_void":true},"invoice_settings":{"account_tax_ids":null,"issuer":{"type":"self"}},"items":{"object":"list","data":[{"id":"si_TZBtFabOTcORwZ","object":"subscription_item","billing_thresholds":null,"created":1765196734,"current_period_end":1766406334,"current_period_start":1765196734,"discounts":[],"metadata":{},"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"price":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"price","active":true,"billing_scheme":"per_unit","created":1764856094,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"nickname":null,"product":"prod_TXiJSc9kvYKDXH","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":9900,"unit_amount_decimal":"9900"},"quantity":1,"subscription":"sub_1Sc3VSHpVJPrOqLk2KdxLmYl","tax_rates":[]}],"has_more":false,"total_count":1,"url":"/v1/subscription_items?subscription=sub_1Sc3VSHpVJPrOqLk2KdxLmYl"},"latest_invoice":"in_1Sc3VSHpVJPrOqLkgUgMARk7","livemode":false,"metadata":{},"next_pending_invoice_item_invoice":null,"on_behalf_of":null,"pause_collection":null,"payment_settings":{"payment_method_options":null,"payment_method_types":null,"save_default_payment_method":"off"},"pending_invoice_item_interval":null,"pending_setup_intent":null,"pending_update":null,"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1765196734,"start_date":1765196734,"status":"canceled","tax_percent":null,"test_clock":null,"transfer_data":null,"trial_end":1766406334,"trial_settings":{"end_behavior":{"missing_payment_method":"create_invoice"}},"trial_start":1765196734}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_3CGYNFWwjeXGiq","idempotency_key":"batchapi-batch_1Sc8qJHpVJPrOqLkufeCTtwz-cus_TZBtEwD56re95y_delete_customer"},"type":"customer.subscription.deleted"}',	'472bdebdeefcefc5a2f0e7ed6daf4723fe118858504d9370f97594f6801bc0cd',	'processed',	0,	5,	'2025-12-08 18:08:00',	'2025-12-08 18:08:00',	NULL,	NULL,	NULL,	NULL,	938,	'[]',	'[]',	'::ffff:127.0.0.1',	1,	NULL,	'2025-12-08 18:08:00',	'2025-12-08 18:08:00'),
(12,	'evt_1Sc8qqHpVJPrOqLk3kwIBtcs',	'customer.subscription.deleted',	'2018-05-21',	0,	'subscription',	'sub_1Sc2nWHpVJPrOqLkn0etlHdu',	'cus_TZB9H5AhESjLFA',	'sub_1Sc2nWHpVJPrOqLkn0etlHdu',	NULL,	NULL,	'{"id":"evt_1Sc8qqHpVJPrOqLk3kwIBtcs","object":"event","api_version":"2018-05-21","created":1765217280,"data":{"object":{"id":"sub_1Sc2nWHpVJPrOqLkn0etlHdu","object":"subscription","application":null,"application_fee_percent":null,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null},"billing":"charge_automatically","billing_cycle_anchor":1766403610,"billing_cycle_anchor_config":null,"billing_mode":{"flexible":{"proration_discounts":"included"},"type":"flexible","updated_at":1765194010},"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":1765217279,"cancellation_details":{"comment":null,"feedback":null,"reason":"cancellation_requested"},"collection_method":"charge_automatically","created":1765194010,"currency":"usd","current_period_end":1766403610,"current_period_start":1765194010,"customer":"cus_TZB9H5AhESjLFA","customer_account":null,"days_until_due":null,"default_payment_method":"pm_1Sc2nmHpVJPrOqLkIWlxlyRi","default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"ended_at":1765217279,"invoice_customer_balance_settings":{"consume_applied_balance_on_void":true},"invoice_settings":{"account_tax_ids":null,"issuer":{"type":"self"}},"items":{"object":"list","data":[{"id":"si_TZB9heJDe44AAN","object":"subscription_item","billing_thresholds":null,"created":1765194010,"current_period_end":1766403610,"current_period_start":1765194010,"discounts":[],"metadata":{},"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"price":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"price","active":true,"billing_scheme":"per_unit","created":1764856094,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"nickname":null,"product":"prod_TXiJSc9kvYKDXH","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":9900,"unit_amount_decimal":"9900"},"quantity":1,"subscription":"sub_1Sc2nWHpVJPrOqLkn0etlHdu","tax_rates":[]}],"has_more":false,"total_count":1,"url":"/v1/subscription_items?subscription=sub_1Sc2nWHpVJPrOqLkn0etlHdu"},"latest_invoice":"in_1Sc2nWHpVJPrOqLkogJgIM4N","livemode":false,"metadata":{},"next_pending_invoice_item_invoice":null,"on_behalf_of":null,"pause_collection":null,"payment_settings":{"payment_method_options":null,"payment_method_types":null,"save_default_payment_method":"off"},"pending_invoice_item_interval":null,"pending_setup_intent":null,"pending_update":null,"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1765194010,"start_date":1765194010,"status":"canceled","tax_percent":null,"test_clock":null,"transfer_data":null,"trial_end":1766403610,"trial_settings":{"end_behavior":{"missing_payment_method":"create_invoice"}},"trial_start":1765194010}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_nF38JfiUohMrW6","idempotency_key":"batchapi-batch_1Sc8qJHpVJPrOqLkufeCTtwz-cus_TZB9H5AhESjLFA_delete_customer"},"type":"customer.subscription.deleted"}',	'8dbf09d3d04bf1db414eae669c015ceb71c1092c901f9a138f18305f2df1dc37',	'processed',	0,	5,	'2025-12-08 18:08:01',	'2025-12-08 18:08:01',	NULL,	NULL,	NULL,	NULL,	751,	'[]',	'[]',	'::1',	1,	NULL,	'2025-12-08 18:08:01',	'2025-12-08 18:08:01'),
(13,	'evt_1Sc8qrHpVJPrOqLksKwf173c',	'customer.subscription.deleted',	'2018-05-21',	0,	'subscription',	'sub_1Sc2g3HpVJPrOqLkXRGlLtBG',	'cus_TZB2Yif42HWmYz',	'sub_1Sc2g3HpVJPrOqLkXRGlLtBG',	NULL,	NULL,	'{"id":"evt_1Sc8qrHpVJPrOqLksKwf173c","object":"event","api_version":"2018-05-21","created":1765217281,"data":{"object":{"id":"sub_1Sc2g3HpVJPrOqLkXRGlLtBG","object":"subscription","application":null,"application_fee_percent":null,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null},"billing":"charge_automatically","billing_cycle_anchor":1766403147,"billing_cycle_anchor_config":null,"billing_mode":{"flexible":{"proration_discounts":"included"},"type":"flexible","updated_at":1765193547},"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":1765217280,"cancellation_details":{"comment":null,"feedback":null,"reason":"cancellation_requested"},"collection_method":"charge_automatically","created":1765193547,"currency":"usd","current_period_end":1766403147,"current_period_start":1765193547,"customer":"cus_TZB2Yif42HWmYz","customer_account":null,"days_until_due":null,"default_payment_method":"pm_1Sc2gPHpVJPrOqLkaXTYh29S","default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"ended_at":1765217280,"invoice_customer_balance_settings":{"consume_applied_balance_on_void":true},"invoice_settings":{"account_tax_ids":null,"issuer":{"type":"self"}},"items":{"object":"list","data":[{"id":"si_TZB2UPXfRmzaNU","object":"subscription_item","billing_thresholds":null,"created":1765193547,"current_period_end":1766403147,"current_period_start":1765193547,"discounts":[],"metadata":{},"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"price":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"price","active":true,"billing_scheme":"per_unit","created":1764856094,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"nickname":null,"product":"prod_TXiJSc9kvYKDXH","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":9900,"unit_amount_decimal":"9900"},"quantity":1,"subscription":"sub_1Sc2g3HpVJPrOqLkXRGlLtBG","tax_rates":[]}],"has_more":false,"total_count":1,"url":"/v1/subscription_items?subscription=sub_1Sc2g3HpVJPrOqLkXRGlLtBG"},"latest_invoice":"in_1Sc2g3HpVJPrOqLk7CaUMXJL","livemode":false,"metadata":{},"next_pending_invoice_item_invoice":null,"on_behalf_of":null,"pause_collection":null,"payment_settings":{"payment_method_options":null,"payment_method_types":null,"save_default_payment_method":"off"},"pending_invoice_item_interval":null,"pending_setup_intent":null,"pending_update":null,"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1765193547,"start_date":1765193547,"status":"canceled","tax_percent":null,"test_clock":null,"transfer_data":null,"trial_end":1766403147,"trial_settings":{"end_behavior":{"missing_payment_method":"create_invoice"}},"trial_start":1765193547}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_dL3mKWBnuNIbkQ","idempotency_key":"batchapi-batch_1Sc8qJHpVJPrOqLkufeCTtwz-cus_TZB2Yif42HWmYz_delete_customer"},"type":"customer.subscription.deleted"}',	'61af824ddda33f3e1750952fa2fa2754cefe359d2414346a838bc7681815e410',	'processed',	0,	5,	'2025-12-08 18:08:02',	'2025-12-08 18:08:02',	NULL,	NULL,	NULL,	NULL,	756,	'[]',	'[]',	'::ffff:127.0.0.1',	1,	NULL,	'2025-12-08 18:08:02',	'2025-12-08 18:08:02'),
(14,	'evt_1Sc8qsHpVJPrOqLkmLpbOjRg',	'customer.subscription.deleted',	'2018-05-21',	0,	'subscription',	'sub_1Sc2crHpVJPrOqLkA7FFN2dQ',	'cus_TZAydZD2Wxztnt',	'sub_1Sc2crHpVJPrOqLkA7FFN2dQ',	NULL,	NULL,	'{"id":"evt_1Sc8qsHpVJPrOqLkmLpbOjRg","object":"event","api_version":"2018-05-21","created":1765217282,"data":{"object":{"id":"sub_1Sc2crHpVJPrOqLkA7FFN2dQ","object":"subscription","application":null,"application_fee_percent":null,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null},"billing":"charge_automatically","billing_cycle_anchor":1765279749,"billing_cycle_anchor_config":null,"billing_mode":{"flexible":{"proration_discounts":"included"},"type":"flexible","updated_at":1765193349},"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":1765217281,"cancellation_details":{"comment":null,"feedback":null,"reason":"cancellation_requested"},"collection_method":"charge_automatically","created":1765193349,"currency":"usd","current_period_end":1765279749,"current_period_start":1765193349,"customer":"cus_TZAydZD2Wxztnt","customer_account":null,"days_until_due":null,"default_payment_method":"pm_1Sc2d9HpVJPrOqLk5vRlHbZ1","default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"ended_at":1765217281,"invoice_customer_balance_settings":{"consume_applied_balance_on_void":true},"invoice_settings":{"account_tax_ids":null,"issuer":{"type":"self"}},"items":{"object":"list","data":[{"id":"si_TZAykGqoDhhMmD","object":"subscription_item","billing_thresholds":null,"created":1765193349,"current_period_end":1765279749,"current_period_start":1765193349,"discounts":[],"metadata":{},"plan":{"id":"price_1SacsoHpVJPrOqLk55ldH9MX","object":"plan","active":true,"aggregate_usage":null,"amount":1900,"amount_decimal":"1900","billing_scheme":"per_unit","created":1764856066,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"10","plan_id":"1","billing_cycle":"monthly","max_team_members":"1","trial_days":"1"},"meter":null,"nickname":null,"product":"prod_TXiJ5slia0Fh1C","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"price":{"id":"price_1SacsoHpVJPrOqLk55ldH9MX","object":"price","active":true,"billing_scheme":"per_unit","created":1764856066,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"10","plan_id":"1","billing_cycle":"monthly","max_team_members":"1","trial_days":"1"},"nickname":null,"product":"prod_TXiJ5slia0Fh1C","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":1900,"unit_amount_decimal":"1900"},"quantity":1,"subscription":"sub_1Sc2crHpVJPrOqLkA7FFN2dQ","tax_rates":[]}],"has_more":false,"total_count":1,"url":"/v1/subscription_items?subscription=sub_1Sc2crHpVJPrOqLkA7FFN2dQ"},"latest_invoice":"in_1Sc2crHpVJPrOqLkHhkROOzs","livemode":false,"metadata":{},"next_pending_invoice_item_invoice":null,"on_behalf_of":null,"pause_collection":null,"payment_settings":{"payment_method_options":null,"payment_method_types":null,"save_default_payment_method":"off"},"pending_invoice_item_interval":null,"pending_setup_intent":null,"pending_update":null,"plan":{"id":"price_1SacsoHpVJPrOqLk55ldH9MX","object":"plan","active":true,"aggregate_usage":null,"amount":1900,"amount_decimal":"1900","billing_scheme":"per_unit","created":1764856066,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"10","plan_id":"1","billing_cycle":"monthly","max_team_members":"1","trial_days":"1"},"meter":null,"nickname":null,"product":"prod_TXiJ5slia0Fh1C","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1765193349,"start_date":1765193349,"status":"canceled","tax_percent":null,"test_clock":null,"transfer_data":null,"trial_end":1765279749,"trial_settings":{"end_behavior":{"missing_payment_method":"create_invoice"}},"trial_start":1765193349}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_HuddEd8iVONNR0","idempotency_key":"batchapi-batch_1Sc8qJHpVJPrOqLkufeCTtwz-cus_TZAydZD2Wxztnt_delete_customer"},"type":"customer.subscription.deleted"}',	'908b8454cdb025a5a6677ad606539a211b581f2ceddc786dea842f135ef9927f',	'processed',	0,	5,	'2025-12-08 18:08:03',	'2025-12-08 18:08:03',	NULL,	NULL,	NULL,	NULL,	755,	'[]',	'[]',	'::1',	1,	NULL,	'2025-12-08 18:08:03',	'2025-12-08 18:08:03'),
(15,	'evt_1Sc8r6HpVJPrOqLkBYk1cmjl',	'payment_method.attached',	'2018-05-21',	0,	'payment_method',	'pm_1Sc8r5HpVJPrOqLkGD0xuD2V',	'cus_TZHNim28DTlc56',	NULL,	NULL,	NULL,	'{"id":"evt_1Sc8r6HpVJPrOqLkBYk1cmjl","object":"event","api_version":"2018-05-21","created":1765217296,"data":{"object":{"id":"pm_1Sc8r5HpVJPrOqLkGD0xuD2V","object":"payment_method","allow_redisplay":"unspecified","billing_details":{"address":{"city":null,"country":"IN","line1":null,"line2":null,"postal_code":null,"state":null},"email":"developer0945@gmail.com","name":"Sudhir Ku","phone":"(714) 781-4565","tax_id":null},"card":{"brand":"visa","checks":{"address_line1_check":null,"address_postal_code_check":null,"cvc_check":"pass"},"country":"US","display_brand":"visa","exp_month":11,"exp_year":2034,"fingerprint":"G95Ez9iUIsKX1A0j","funding":"credit","generated_from":null,"last4":"1111","networks":{"available":["visa"],"preferred":null},"regulated_status":"unregulated","three_d_secure_usage":{"supported":true},"wallet":null},"created":1765217295,"customer":"cus_TZHNim28DTlc56","customer_account":null,"livemode":false,"metadata":{},"type":"card"}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_SnWO68mIngF8On","idempotency_key":"4cfea973-60d0-48d2-9560-cfa7a26386cb"},"type":"payment_method.attached"}',	'5513cbec40be21152f35b565d21c5257c96452e0ba14afe3c170154b89031257',	'processed',	0,	5,	'2025-12-08 18:08:17',	'2025-12-08 18:08:19',	NULL,	NULL,	NULL,	NULL,	1726,	'["payment_method_added"]',	'[]',	'::ffff:127.0.0.1',	1,	NULL,	'2025-12-08 18:08:17',	'2025-12-08 18:08:19'),
(16,	'evt_1Sc8rCHpVJPrOqLk1CLeVpVT',	'customer.subscription.created',	'2018-05-21',	0,	'subscription',	'sub_1Sc8r8HpVJPrOqLkX4hZp1K4',	'cus_TZHNim28DTlc56',	'sub_1Sc8r8HpVJPrOqLkX4hZp1K4',	NULL,	NULL,	'{"id":"evt_1Sc8rCHpVJPrOqLk1CLeVpVT","object":"event","api_version":"2018-05-21","created":1765217301,"data":{"object":{"id":"sub_1Sc8r8HpVJPrOqLkX4hZp1K4","object":"subscription","application":null,"application_fee_percent":null,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null},"billing":"charge_automatically","billing_cycle_anchor":1765217298,"billing_cycle_anchor_config":null,"billing_mode":{"flexible":{"proration_discounts":"included"},"type":"flexible","updated_at":1765217298},"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":null,"cancellation_details":{"comment":null,"feedback":null,"reason":null},"collection_method":"charge_automatically","created":1765217298,"currency":"usd","current_period_end":1767895698,"current_period_start":1765217298,"customer":"cus_TZHNim28DTlc56","customer_account":null,"days_until_due":null,"default_payment_method":"pm_1Sc8r5HpVJPrOqLkGD0xuD2V","default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"ended_at":null,"invoice_customer_balance_settings":{"consume_applied_balance_on_void":true},"invoice_settings":{"account_tax_ids":null,"issuer":{"type":"self"}},"items":{"object":"list","data":[{"id":"si_TZHPSgXrB8TKck","object":"subscription_item","billing_thresholds":null,"created":1765217299,"current_period_end":1767895698,"current_period_start":1765217298,"discounts":[],"metadata":{},"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"price":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"price","active":true,"billing_scheme":"per_unit","created":1764856094,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"nickname":null,"product":"prod_TXiJSc9kvYKDXH","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":9900,"unit_amount_decimal":"9900"},"quantity":1,"subscription":"sub_1Sc8r8HpVJPrOqLkX4hZp1K4","tax_rates":[]}],"has_more":false,"total_count":1,"url":"/v1/subscription_items?subscription=sub_1Sc8r8HpVJPrOqLkX4hZp1K4"},"latest_invoice":"in_1Sc8r8HpVJPrOqLkqss6grEV","livemode":false,"metadata":{},"next_pending_invoice_item_invoice":null,"on_behalf_of":null,"pause_collection":null,"payment_settings":{"payment_method_options":null,"payment_method_types":null,"save_default_payment_method":"off"},"pending_invoice_item_interval":null,"pending_setup_intent":null,"pending_update":null,"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1765217298,"start_date":1765217298,"status":"active","tax_percent":null,"test_clock":null,"transfer_data":null,"trial_end":null,"trial_settings":{"end_behavior":{"missing_payment_method":"create_invoice"}},"trial_start":null}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_ZjfDO0ts60OvTy","idempotency_key":"stripe-node-retry-38b0ab00-e526-456a-8a03-5cdcc6104fe5"},"type":"customer.subscription.created"}',	'75e605b99b40829054d0b58fc9bed4ecaa0aec7d7bea8c22494f7d4ecabc4ffa',	'processed',	0,	5,	'2025-12-08 18:08:23',	'2025-12-08 18:08:23',	NULL,	NULL,	NULL,	NULL,	730,	'["subscription_created_logged"]',	'[]',	'::1',	1,	NULL,	'2025-12-08 18:08:23',	'2025-12-08 18:08:23'),
(17,	'evt_3Sc8r9HpVJPrOqLk0z377HiD',	'payment_intent.succeeded',	'2018-05-21',	0,	'payment_intent',	'pi_3Sc8r9HpVJPrOqLk0FLkqgHp',	'cus_TZHNim28DTlc56',	NULL,	'in_1Sc8r8HpVJPrOqLkqss6grEV',	NULL,	'{"id":"evt_3Sc8r9HpVJPrOqLk0z377HiD","object":"event","api_version":"2018-05-21","created":1765217301,"data":{"object":{"id":"pi_3Sc8r9HpVJPrOqLk0FLkqgHp","object":"payment_intent","allowed_source_types":["card","link"],"amount":9900,"amount_capturable":0,"amount_details":{"tip":{}},"amount_received":9900,"application":null,"application_fee_amount":null,"automatic_payment_methods":null,"canceled_at":null,"cancellation_reason":null,"capture_method":"automatic","charges":{"object":"list","data":[{"id":"ch_3Sc8r9HpVJPrOqLk0WTADrOH","object":"charge","amount":9900,"amount_captured":9900,"amount_refunded":0,"application":null,"application_fee":null,"application_fee_amount":null,"balance_transaction":"txn_3Sc8r9HpVJPrOqLk09aPkFOO","billing_details":{"address":{"city":null,"country":"IN","line1":null,"line2":null,"postal_code":null,"state":null},"email":"developer0945@gmail.com","name":"Sudhir Ku","phone":"(714) 781-4565","tax_id":null},"calculated_statement_descriptor":"SHIPPO","captured":true,"created":1765217300,"currency":"usd","customer":"cus_TZHNim28DTlc56","description":"Subscription creation","destination":null,"dispute":null,"disputed":false,"failure_balance_transaction":null,"failure_code":null,"failure_message":null,"fraud_details":{},"invoice":"in_1Sc8r8HpVJPrOqLkqss6grEV","livemode":false,"metadata":{},"on_behalf_of":null,"order":null,"outcome":{"advice_code":null,"network_advice_code":null,"network_decline_code":null,"network_status":"approved_by_network","reason":null,"risk_level":"normal","risk_score":61,"seller_message":"Payment complete.","type":"authorized"},"paid":true,"payment_intent":"pi_3Sc8r9HpVJPrOqLk0FLkqgHp","payment_method":"pm_1Sc8r5HpVJPrOqLkGD0xuD2V","payment_method_details":{"card":{"amount_authorized":9900,"authorization_code":"714355","brand":"visa","checks":{"address_line1_check":null,"address_postal_code_check":null,"cvc_check":"pass"},"country":"US","exp_month":11,"exp_year":2034,"extended_authorization":{"status":"disabled"},"fingerprint":"G95Ez9iUIsKX1A0j","funding":"credit","incremental_authorization":{"status":"unavailable"},"installments":null,"last4":"1111","mandate":null,"multicapture":{"status":"unavailable"},"network":"visa","network_token":{"used":false},"network_transaction_id":"715753691225710","overcapture":{"maximum_amount_capturable":9900,"status":"unavailable"},"regulated_status":"unregulated","three_d_secure":null,"wallet":null},"type":"card"},"radar_options":{},"receipt_email":"developer0945@gmail.com","receipt_number":null,"receipt_url":"https://pay.stripe.com/receipts/invoices/CAcaFwoVYWNjdF8xQUM2bEFIcFZKUHJPcUxrKJao3MkGMgZ4EHh3x4Q6LBaV8eAOga6E82O5RCvz2msXIMP4jIMy7gQXLtxs7gDL5qCw2uGxjXyPMHIU?s=ap","refunded":false,"refunds":{"object":"list","data":[],"has_more":false,"total_count":0,"url":"/v1/charges/ch_3Sc8r9HpVJPrOqLk0WTADrOH/refunds"},"review":null,"shipping":null,"source":null,"source_transfer":null,"statement_descriptor":null,"statement_descriptor_suffix":null,"status":"succeeded","transfer_data":null,"transfer_group":null}],"has_more":false,"total_count":1,"url":"/v1/charges?payment_intent=pi_3Sc8r9HpVJPrOqLk0FLkqgHp"},"client_secret":"pi_3Sc8r9HpVJPrOqLk0FLkqgHp_secret_zGLl0RiNeCyT5DizegFKtMAPa","confirmation_method":"automatic","created":1765217299,"currency":"usd","customer":"cus_TZHNim28DTlc56","customer_account":null,"description":"Subscription creation","excluded_payment_method_types":null,"invoice":"in_1Sc8r8HpVJPrOqLkqss6grEV","last_payment_error":null,"latest_charge":"ch_3Sc8r9HpVJPrOqLk0WTADrOH","livemode":false,"metadata":{},"next_action":null,"next_source_action":null,"on_behalf_of":null,"payment_details":{"customer_reference":null,"order_reference":"in_1Sc8r8HpVJPrOqLkqss6gr"},"payment_method":"pm_1Sc8r5HpVJPrOqLkGD0xuD2V","payment_method_configuration_details":null,"payment_method_options":{"card":{"installments":null,"mandate_options":null,"network":null,"request_three_d_secure":"automatic"},"link":{"persistent_token":null}},"payment_method_types":["card","link"],"processing":null,"receipt_email":"developer0945@gmail.com","review":null,"setup_future_usage":"off_session","shipping":null,"source":null,"statement_descriptor":null,"statement_descriptor_suffix":null,"status":"succeeded","transfer_data":null,"transfer_group":null}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_ZjfDO0ts60OvTy","idempotency_key":"stripe-node-retry-38b0ab00-e526-456a-8a03-5cdcc6104fe5"},"type":"payment_intent.succeeded"}',	'b34d82e42dde48583cb248b1f10d0371cf2a883a1dc8e793ff1a9eef3219d2ef',	'processed',	0,	5,	'2025-12-08 18:08:23',	'2025-12-08 18:08:23',	NULL,	NULL,	NULL,	NULL,	760,	'["unhandled_event_payment_intent.succeeded"]',	'[]',	'::ffff:127.0.0.1',	1,	NULL,	'2025-12-08 18:08:23',	'2025-12-08 18:08:23'),
(18,	'evt_1Sc8rCHpVJPrOqLkc1IKjRiF',	'invoice.payment_succeeded',	'2018-05-21',	0,	'invoice',	'in_1Sc8r8HpVJPrOqLkqss6grEV',	'cus_TZHNim28DTlc56',	'sub_1Sc8r8HpVJPrOqLkX4hZp1K4',	'in_1Sc8r8HpVJPrOqLkqss6grEV',	'pi_3Sc8r9HpVJPrOqLk0FLkqgHp',	'{"id":"evt_1Sc8rCHpVJPrOqLkc1IKjRiF","object":"event","api_version":"2018-05-21","created":1765217301,"data":{"object":{"id":"in_1Sc8r8HpVJPrOqLkqss6grEV","object":"invoice","account_country":"SE","account_name":"Aronasoft","account_tax_ids":null,"amount_due":9900,"amount_overpaid":0,"amount_paid":9900,"amount_remaining":0,"amount_shipping":0,"application":null,"application_fee":null,"attempt_count":1,"attempted":true,"auto_advance":false,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null,"provider":null,"status":null},"automatically_finalizes_at":null,"billing":"charge_automatically","billing_reason":"subscription_update","charge":"ch_3Sc8r9HpVJPrOqLk0WTADrOH","closed":true,"collection_method":"charge_automatically","created":1765217298,"currency":"usd","custom_fields":null,"customer":"cus_TZHNim28DTlc56","customer_account":null,"customer_address":null,"customer_email":"developer0945@gmail.com","customer_name":"Baljeet Singh","customer_phone":"(714) 781-4565","customer_shipping":null,"customer_tax_exempt":"none","customer_tax_ids":[],"date":1765217298,"default_payment_method":null,"default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"due_date":null,"effective_at":1765217298,"ending_balance":0,"finalized_at":1765217298,"footer":null,"forgiven":false,"from_invoice":null,"hosted_invoice_url":"https://invoice.stripe.com/i/acct_1AC6lAHpVJPrOqLk/test_YWNjdF8xQUM2bEFIcFZKUHJPcUxrLF9UWkhQd1hJWXNNbTZodVh4Z0FNSnpXcWk2ckdjcDczLDE1NTc1ODEwMg0200OQrSzDF0?s=ap","invoice_pdf":"https://pay.stripe.com/invoice/acct_1AC6lAHpVJPrOqLk/test_YWNjdF8xQUM2bEFIcFZKUHJPcUxrLF9UWkhQd1hJWXNNbTZodVh4Z0FNSnpXcWk2ckdjcDczLDE1NTc1ODEwMg0200OQrSzDF0/pdf?s=ap","issuer":{"type":"self"},"last_finalization_error":null,"latest_revision":null,"lines":{"object":"list","data":[{"id":"il_1Sc8r8HpVJPrOqLkORVvvQAt","object":"line_item","amount":9900,"amount_excluding_tax":9900,"currency":"usd","description":"1 × Agency (at $99.00 / month)","discount_amounts":[],"discountable":true,"discounts":[],"invoice":"in_1Sc8r8HpVJPrOqLkqss6grEV","livemode":false,"metadata":{},"parent":{"invoice_item_details":null,"subscription_item_details":{"invoice_item":null,"proration":false,"proration_details":{"credited_items":null},"subscription":"sub_1Sc8r8HpVJPrOqLkX4hZp1K4","subscription_item":"si_TZHPSgXrB8TKck"},"type":"subscription_item_details"},"period":{"end":1767895698,"start":1765217298},"plan":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"plan","active":true,"aggregate_usage":null,"amount":9900,"amount_decimal":"9900","billing_scheme":"per_unit","created":1764856094,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"meter":null,"nickname":null,"product":"prod_TXiJSc9kvYKDXH","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"pretax_credit_amounts":[],"price":{"id":"price_1SactGHpVJPrOqLkrdqk0HUK","object":"price","active":true,"billing_scheme":"per_unit","created":1764856094,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"100","plan_id":"3","billing_cycle":"monthly","max_team_members":"10","trial_days":"14"},"nickname":null,"product":"prod_TXiJSc9kvYKDXH","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":9900,"unit_amount_decimal":"9900"},"pricing":{"price_details":{"price":"price_1SactGHpVJPrOqLkrdqk0HUK","product":"prod_TXiJSc9kvYKDXH"},"type":"price_details","unit_amount_decimal":"9900"},"proration":false,"proration_details":{"credited_items":null},"quantity":1,"subscription":"sub_1Sc8r8HpVJPrOqLkX4hZp1K4","subscription_item":"si_TZHPSgXrB8TKck","tax_amounts":[],"tax_rates":[],"taxes":[],"type":"subscription","unique_id":"il_1Sc8r8HpVJPrOqLkORVvvQAt","unit_amount_excluding_tax":"9900"}],"has_more":false,"total_count":1,"url":"/v1/invoices/in_1Sc8r8HpVJPrOqLkqss6grEV/lines"},"livemode":false,"metadata":{},"next_payment_attempt":null,"number":"FVJFOQBG-0001","on_behalf_of":null,"paid":true,"paid_out_of_band":false,"parent":{"quote_details":null,"subscription_details":{"metadata":{},"subscription":"sub_1Sc8r8HpVJPrOqLkX4hZp1K4"},"type":"subscription_details"},"payment_intent":"pi_3Sc8r9HpVJPrOqLk0FLkqgHp","payment_settings":{"default_mandate":null,"payment_method_options":null,"payment_method_types":null},"period_end":1765217298,"period_start":1765217298,"post_payment_credit_notes_amount":0,"pre_payment_credit_notes_amount":0,"quote":null,"receipt_number":null,"rendering":null,"rendering_options":null,"shipping_cost":null,"shipping_details":null,"starting_balance":0,"statement_descriptor":null,"status":"paid","status_transitions":{"finalized_at":1765217298,"marked_uncollectible_at":null,"paid_at":1765217298,"voided_at":null},"subscription":"sub_1Sc8r8HpVJPrOqLkX4hZp1K4","subscription_details":{"metadata":{}},"subtotal":9900,"subtotal_excluding_tax":9900,"tax":null,"tax_percent":null,"test_clock":null,"total":9900,"total_discount_amounts":[],"total_excluding_tax":9900,"total_pretax_credit_amounts":[],"total_tax_amounts":[],"total_taxes":[],"transfer_data":null,"webhooks_delivered_at":1765217298}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_ZjfDO0ts60OvTy","idempotency_key":"stripe-node-retry-38b0ab00-e526-456a-8a03-5cdcc6104fe5"},"type":"invoice.payment_succeeded"}',	'e25cd914435a283d0899dd13e46413e29c98bc0cf76f126d26ec1478e826755e',	'processed',	0,	5,	'2025-12-08 18:08:23',	'2025-12-08 18:08:26',	NULL,	NULL,	NULL,	NULL,	3626,	'["payment_succeeded"]',	'[{"type":"transaction","id":1,"action":"created"}]',	'::1',	1,	NULL,	'2025-12-08 18:08:23',	'2025-12-08 18:08:26'),
(19,	'evt_1Sc9R4HpVJPrOqLkYWKeHO7b',	'payment_method.attached',	'2018-05-21',	0,	'payment_method',	'pm_1Sc9R4HpVJPrOqLkOXnfcKFb',	'cus_TZI0IIGiL6g3IG',	NULL,	NULL,	NULL,	'{"id":"evt_1Sc9R4HpVJPrOqLkYWKeHO7b","object":"event","api_version":"2018-05-21","created":1765219526,"data":{"object":{"id":"pm_1Sc9R4HpVJPrOqLkOXnfcKFb","object":"payment_method","allow_redisplay":"unspecified","billing_details":{"address":{"city":null,"country":"IN","line1":null,"line2":null,"postal_code":null,"state":null},"email":"developerw0945@gmail.com","name":"Baljeet Singh","phone":"(714) 781-4565","tax_id":null},"card":{"brand":"visa","checks":{"address_line1_check":null,"address_postal_code_check":null,"cvc_check":"pass"},"country":"US","display_brand":"visa","exp_month":2,"exp_year":2034,"fingerprint":"G95Ez9iUIsKX1A0j","funding":"credit","generated_from":null,"last4":"1111","networks":{"available":["visa"],"preferred":null},"regulated_status":"unregulated","three_d_secure_usage":{"supported":true},"wallet":null},"created":1765219526,"customer":"cus_TZI0IIGiL6g3IG","customer_account":null,"livemode":false,"metadata":{},"type":"card"}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_jTfhbMoINUsurD","idempotency_key":"24cb82df-4594-4386-a966-0d43feb99fe5"},"type":"payment_method.attached"}',	'53ba102641744dbd9a412de80078c60f69417a11539794b7b62b92602817e0b1',	'processed',	0,	5,	'2025-12-08 18:45:27',	'2025-12-08 18:45:29',	NULL,	NULL,	NULL,	NULL,	1888,	'["payment_method_added"]',	'[]',	'::ffff:127.0.0.1',	1,	NULL,	'2025-12-08 18:45:27',	'2025-12-08 18:45:29'),
(20,	'evt_1Sc9R7HpVJPrOqLkF2bjTmMH',	'customer.subscription.created',	'2018-05-21',	0,	'subscription',	'sub_1Sc9R5HpVJPrOqLkPt4sV5R5',	'cus_TZI0IIGiL6g3IG',	'sub_1Sc9R5HpVJPrOqLkPt4sV5R5',	NULL,	NULL,	'{"id":"evt_1Sc9R7HpVJPrOqLkF2bjTmMH","object":"event","api_version":"2018-05-21","created":1765219529,"data":{"object":{"id":"sub_1Sc9R5HpVJPrOqLkPt4sV5R5","object":"subscription","application":null,"application_fee_percent":null,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null},"billing":"charge_automatically","billing_cycle_anchor":1765305927,"billing_cycle_anchor_config":null,"billing_mode":{"flexible":{"proration_discounts":"included"},"type":"flexible","updated_at":1765219527},"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":null,"cancellation_details":{"comment":null,"feedback":null,"reason":null},"collection_method":"charge_automatically","created":1765219527,"currency":"usd","current_period_end":1765305927,"current_period_start":1765219527,"customer":"cus_TZI0IIGiL6g3IG","customer_account":null,"days_until_due":null,"default_payment_method":"pm_1Sc9R4HpVJPrOqLkOXnfcKFb","default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"ended_at":null,"invoice_customer_balance_settings":{"consume_applied_balance_on_void":true},"invoice_settings":{"account_tax_ids":null,"issuer":{"type":"self"}},"items":{"object":"list","data":[{"id":"si_TZI1SzOSrN3hIY","object":"subscription_item","billing_thresholds":null,"created":1765219528,"current_period_end":1765305927,"current_period_start":1765219527,"discounts":[],"metadata":{},"plan":{"id":"price_1SacsoHpVJPrOqLk55ldH9MX","object":"plan","active":true,"aggregate_usage":null,"amount":1900,"amount_decimal":"1900","billing_scheme":"per_unit","created":1764856066,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"10","plan_id":"1","billing_cycle":"monthly","max_team_members":"1","trial_days":"1"},"meter":null,"nickname":null,"product":"prod_TXiJ5slia0Fh1C","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"price":{"id":"price_1SacsoHpVJPrOqLk55ldH9MX","object":"price","active":true,"billing_scheme":"per_unit","created":1764856066,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"10","plan_id":"1","billing_cycle":"monthly","max_team_members":"1","trial_days":"1"},"nickname":null,"product":"prod_TXiJ5slia0Fh1C","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":1900,"unit_amount_decimal":"1900"},"quantity":1,"subscription":"sub_1Sc9R5HpVJPrOqLkPt4sV5R5","tax_rates":[]}],"has_more":false,"total_count":1,"url":"/v1/subscription_items?subscription=sub_1Sc9R5HpVJPrOqLkPt4sV5R5"},"latest_invoice":"in_1Sc9R5HpVJPrOqLkM1DKHuY9","livemode":false,"metadata":{},"next_pending_invoice_item_invoice":null,"on_behalf_of":null,"pause_collection":null,"payment_settings":{"payment_method_options":null,"payment_method_types":null,"save_default_payment_method":"off"},"pending_invoice_item_interval":null,"pending_setup_intent":null,"pending_update":null,"plan":{"id":"price_1SacsoHpVJPrOqLk55ldH9MX","object":"plan","active":true,"aggregate_usage":null,"amount":1900,"amount_decimal":"1900","billing_scheme":"per_unit","created":1764856066,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"10","plan_id":"1","billing_cycle":"monthly","max_team_members":"1","trial_days":"1"},"meter":null,"nickname":null,"product":"prod_TXiJ5slia0Fh1C","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1765219527,"start_date":1765219527,"status":"trialing","tax_percent":null,"test_clock":null,"transfer_data":null,"trial_end":1765305927,"trial_settings":{"end_behavior":{"missing_payment_method":"create_invoice"}},"trial_start":1765219527}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_LgiTMvEQlilBto","idempotency_key":"stripe-node-retry-05c64829-d8c1-455c-9ec8-796ff1b0cbaa"},"type":"customer.subscription.created"}',	'e93a8fe80e3046c15245a55631263419a65fe10172e1232cf750c94a5509abd0',	'processed',	0,	5,	'2025-12-08 18:45:30',	'2025-12-08 18:45:30',	NULL,	NULL,	NULL,	NULL,	478,	'["subscription_created_logged"]',	'[]',	'::1',	1,	NULL,	'2025-12-08 18:45:30',	'2025-12-08 18:45:30'),
(21,	'evt_1Sc9R7HpVJPrOqLk1VlxsWJe',	'invoice.payment_succeeded',	'2018-05-21',	0,	'invoice',	'in_1Sc9R5HpVJPrOqLkM1DKHuY9',	'cus_TZI0IIGiL6g3IG',	'sub_1Sc9R5HpVJPrOqLkPt4sV5R5',	'in_1Sc9R5HpVJPrOqLkM1DKHuY9',	NULL,	'{"id":"evt_1Sc9R7HpVJPrOqLk1VlxsWJe","object":"event","api_version":"2018-05-21","created":1765219529,"data":{"object":{"id":"in_1Sc9R5HpVJPrOqLkM1DKHuY9","object":"invoice","account_country":"SE","account_name":"Aronasoft","account_tax_ids":null,"amount_due":0,"amount_overpaid":0,"amount_paid":0,"amount_remaining":0,"amount_shipping":0,"application":null,"application_fee":null,"attempt_count":0,"attempted":true,"auto_advance":false,"automatic_tax":{"disabled_reason":null,"enabled":false,"liability":null,"provider":null,"status":null},"automatically_finalizes_at":null,"billing":"charge_automatically","billing_reason":"subscription_update","charge":null,"closed":true,"collection_method":"charge_automatically","created":1765219527,"currency":"usd","custom_fields":null,"customer":"cus_TZI0IIGiL6g3IG","customer_account":null,"customer_address":null,"customer_email":"developerw0945@gmail.com","customer_name":"Baljeet Singh","customer_phone":"(714) 781-4565","customer_shipping":null,"customer_tax_exempt":"none","customer_tax_ids":[],"date":1765219527,"default_payment_method":null,"default_source":null,"default_tax_rates":[],"description":null,"discount":null,"discounts":[],"due_date":null,"effective_at":1765219527,"ending_balance":0,"finalized_at":1765219527,"footer":null,"forgiven":false,"from_invoice":null,"hosted_invoice_url":"https://invoice.stripe.com/i/acct_1AC6lAHpVJPrOqLk/test_YWNjdF8xQUM2bEFIcFZKUHJPcUxrLF9UWkkxOHVwamdBOVB0NlFwY2czMFlhek1Hd3VDbEw3LDE1NTc2MDMyOQ0200f13RqvAq?s=ap","invoice_pdf":"https://pay.stripe.com/invoice/acct_1AC6lAHpVJPrOqLk/test_YWNjdF8xQUM2bEFIcFZKUHJPcUxrLF9UWkkxOHVwamdBOVB0NlFwY2czMFlhek1Hd3VDbEw3LDE1NTc2MDMyOQ0200f13RqvAq/pdf?s=ap","issuer":{"type":"self"},"last_finalization_error":null,"latest_revision":null,"lines":{"object":"list","data":[{"id":"il_1Sc9R5HpVJPrOqLkKjSj9gEy","object":"line_item","amount":0,"amount_excluding_tax":0,"currency":"usd","description":"Free trial for 1 × Starter","discount_amounts":[],"discountable":true,"discounts":[],"invoice":"in_1Sc9R5HpVJPrOqLkM1DKHuY9","livemode":false,"metadata":{},"parent":{"invoice_item_details":null,"subscription_item_details":{"invoice_item":null,"proration":false,"proration_details":{"credited_items":null},"subscription":"sub_1Sc9R5HpVJPrOqLkPt4sV5R5","subscription_item":"si_TZI1SzOSrN3hIY"},"type":"subscription_item_details"},"period":{"end":1765305927,"start":1765219527},"plan":{"id":"price_1SacsoHpVJPrOqLk55ldH9MX","object":"plan","active":true,"aggregate_usage":null,"amount":1900,"amount_decimal":"1900","billing_scheme":"per_unit","created":1764856066,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"10","plan_id":"1","billing_cycle":"monthly","max_team_members":"1","trial_days":"1"},"meter":null,"nickname":null,"product":"prod_TXiJ5slia0Fh1C","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"pretax_credit_amounts":[],"price":{"id":"price_1SacsoHpVJPrOqLk55ldH9MX","object":"price","active":true,"billing_scheme":"per_unit","created":1764856066,"currency":"usd","custom_unit_amount":null,"livemode":false,"lookup_key":null,"metadata":{"features":"[]","max_scheduled_posts":"-1","max_social_accounts":"10","plan_id":"1","billing_cycle":"monthly","max_team_members":"1","trial_days":"1"},"nickname":null,"product":"prod_TXiJ5slia0Fh1C","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"meter":null,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":1900,"unit_amount_decimal":"1900"},"pricing":{"price_details":{"price":"price_1SacsoHpVJPrOqLk55ldH9MX","product":"prod_TXiJ5slia0Fh1C"},"type":"price_details","unit_amount_decimal":"0"},"proration":false,"proration_details":{"credited_items":null},"quantity":1,"subscription":"sub_1Sc9R5HpVJPrOqLkPt4sV5R5","subscription_item":"si_TZI1SzOSrN3hIY","tax_amounts":[],"tax_rates":[],"taxes":[],"type":"subscription","unique_id":"il_1Sc9R5HpVJPrOqLkKjSj9gEy","unit_amount_excluding_tax":"0"}],"has_more":false,"total_count":1,"url":"/v1/invoices/in_1Sc9R5HpVJPrOqLkM1DKHuY9/lines"},"livemode":false,"metadata":{},"next_payment_attempt":null,"number":"ITYFUTSR-0001","on_behalf_of":null,"paid":true,"paid_out_of_band":false,"parent":{"quote_details":null,"subscription_details":{"metadata":{},"subscription":"sub_1Sc9R5HpVJPrOqLkPt4sV5R5"},"type":"subscription_details"},"payment_intent":null,"payment_settings":{"default_mandate":null,"payment_method_options":null,"payment_method_types":null},"period_end":1765219527,"period_start":1765219527,"post_payment_credit_notes_amount":0,"pre_payment_credit_notes_amount":0,"quote":null,"receipt_number":null,"rendering":null,"rendering_options":null,"shipping_cost":null,"shipping_details":null,"starting_balance":0,"statement_descriptor":null,"status":"paid","status_transitions":{"finalized_at":1765219527,"marked_uncollectible_at":null,"paid_at":1765219527,"voided_at":null},"subscription":"sub_1Sc9R5HpVJPrOqLkPt4sV5R5","subscription_details":{"metadata":{}},"subtotal":0,"subtotal_excluding_tax":0,"tax":null,"tax_percent":null,"test_clock":null,"total":0,"total_discount_amounts":[],"total_excluding_tax":0,"total_pretax_credit_amounts":[],"total_tax_amounts":[],"total_taxes":[],"transfer_data":null,"webhooks_delivered_at":1765219527}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_LgiTMvEQlilBto","idempotency_key":"stripe-node-retry-05c64829-d8c1-455c-9ec8-796ff1b0cbaa"},"type":"invoice.payment_succeeded"}',	'18a4e17bfb07e0be4ce89232c2a165cce474990749acb33dc27acf353bbbef91',	'processed',	0,	5,	'2025-12-08 18:45:30',	'2025-12-08 18:45:33',	NULL,	NULL,	NULL,	NULL,	3190,	'["payment_succeeded"]',	'[{"type":"transaction","id":2,"action":"created"}]',	'::ffff:127.0.0.1',	1,	NULL,	'2025-12-08 18:45:30',	'2025-12-08 18:45:33');

DROP TABLE IF EXISTS "webhook_logs";
DROP SEQUENCE IF EXISTS webhook_logs_id_seq;
CREATE SEQUENCE webhook_logs_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."webhook_logs" (
    "id" bigint DEFAULT nextval('webhook_logs_id_seq') NOT NULL,
    "webhook_id" numeric NOT NULL,
    "event_type" character varying(255) NOT NULL,
    "payload" text,
    "response_code" bigint,
    "response_body" text,
    "status" text DEFAULT 'pending' NOT NULL,
    "error_message" text,
    "retry_count" bigint DEFAULT '0' NOT NULL,
    "executed_at" timestamptz,
    "created_at" timestamptz,
    "updated_at" timestamptz,
    CONSTRAINT "idx_17665_primary" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE INDEX idx_17665_webhook_logs_webhook_id_foreign ON insocial_mysql.webhook_logs USING btree (webhook_id);


DROP TABLE IF EXISTS "webhooks";
DROP SEQUENCE IF EXISTS webhooks_id_seq;
CREATE SEQUENCE webhooks_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "insocial_mysql"."webhooks" (
    "id" bigint DEFAULT nextval('webhooks_id_seq') NOT NULL,
    "name" character varying(255) NOT NULL,
    "provider" text DEFAULT 'custom' NOT NULL,
    "event_type" character varying(255) NOT NULL,
    "endpoint_url" character varying(255) NOT NULL,
    "secret" text,
    "active" smallint DEFAULT '1' NOT NULL,
    "last_triggered_at" timestamptz,
    "last_status" text,
    "last_response" text,
    "success_count" bigint DEFAULT '0' NOT NULL,
    "failure_count" bigint DEFAULT '0' NOT NULL,
    "created_at" timestamptz,
    "updated_at" timestamptz,
    CONSTRAINT "idx_17633_primary" PRIMARY KEY ("id")
)
WITH (oids = false);


ALTER TABLE ONLY "insocial_mysql"."social_media_page_score" ADD CONSTRAINT "social_media_page_score_ibfk_1" FOREIGN KEY (social_score_id) REFERENCES social_media_score(id) ON UPDATE RESTRICT ON DELETE CASCADE NOT DEFERRABLE;

-- 2025-12-09 11:55:59 UTC