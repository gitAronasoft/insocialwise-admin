# InSocialWise Admin Panel

## Overview
This project is a comprehensive Laravel 12 Admin Panel designed for managing social media marketing services. Its primary purpose is to provide a centralized dashboard for administrators to oversee customers, subscriptions, social media accounts, content, advertising campaigns, and analytics. The platform aims to streamline operations for social media marketing agencies, offering robust tools for billing, reporting, and system configuration, thereby enhancing efficiency and client management.

## User Preferences
- Dark mode support with system preference detection
- Collapsible sidebar navigation
- Responsive design for mobile/tablet
- **IMPORTANT**: Always run `npm run build` for Vite before starting Laravel server
- **No Customer Impersonation**: User requested to remove the customer impersonation feature from the admin panel. This feature has been removed from routes, controllers, and views.

## System Architecture
The InSocialWise Admin Panel is built on a Laravel 12 (PHP 8.2) backend, utilizing Blade Templates, Tailwind CSS, and Alpine.js for the frontend, with Vite 7 for asset building. It connects to Replit's built-in PostgreSQL database (Neon-backed).

**UI/UX Decisions:**
- Enhanced Dashboard with comprehensive analytics, including global time period filters, various revenue and subscription metrics (MRR, ARPU, LTV, NRR), and detailed charts.
- Visual timelines for customer activity and subscription lifecycles.
- Color-coded events and health indicators for intuitive data representation.
- Unified views for payments, combining methods and transactions.

**Technical Implementations & Feature Specifications:**
- **Dashboard:** Features include revenue metrics, subscription health scores, trial conversion tracking, and recent activity feeds.
- **User Management:** Comprehensive customer profiles with activity timelines, connected social pages, and social account health status.
- **Billing & Subscriptions:** Full lifecycle management of subscriptions, configurable plans with Stripe sync, detailed transaction logs, and a unified payments view. Implements a notification queue for billing alerts.
- **Admin Settings:** Configurable panel for email (SMTP), Stripe API keys (encrypted), webhook URLs, and automated notification settings.
- **Content & Advertising:** Management interfaces for posts, comments, advertising campaigns, ad accounts, adsets, and individual ads.
- **Analytics & Reports:** Comprehensive subscription analytics (plan performance, trial, churn), social media analytics, and custom report generation with global period filtering.
- **Messaging & Support:** Inbox for customer conversations and a knowledge base for help articles.
- **Integrations & Compliance:** Webhook configuration, API key management, policy management, data request handling, and data retention rules.
- **System Administration:** Management of admin users with RBAC, activity logs, system alerts, and application settings with feature toggles.
- **Authentication:** Admin guard authentication with email/password and role-based access control (RBAC).

**System Design Choices:**
- **Database Schema:** PostgreSQL database with comprehensive billing tables including `billing_notifications` for scheduled communications, `billing_activity_logs` for audit trails, `payment_methods` for customer payment details, `webhook_events` for Stripe webhook tracking, `subscription_events` for subscription lifecycle tracking, and `admin_settings` for configurable application parameters, with encryption for sensitive data.
- **PostgreSQL Schema Alignment (Dec 2024):** Complete codebase audit ensured all models, controllers, and services use exact PostgreSQL column names. Key conventions:
  - Users table columns are lowercase: `firstname`, `lastname`, `userlocation`, `profileimage`, `jobtitle`, `timezone` (NOT camelCase)
  - Timestamps use snake_case: `created_at`, `updated_at` (NOT createdAt, updatedAt)
  - Case-insensitive search uses PostgreSQL `ILIKE` operator
  - Date functions use PostgreSQL syntax: `EXTRACT()` instead of MySQL `YEAR()/MONTH()`, date arithmetic instead of `DATEDIFF()`
  - Subscriptions use `billing_interval`, subscription_plans use `billing_cycle`
- **Stripe Webhook Integration:** Full webhook handling at `/stripe/webhook` endpoint processes all Stripe events (subscription CRUD, invoices, payments, refunds, payment methods). Credentials should be configured via Replit Secrets: STRIPE_SECRET_KEY, STRIPE_PUBLISHABLE_KEY, STRIPE_WEBHOOK_SECRET.
- **Modularity:** Organized project structure with dedicated directories for controllers, models, services, and views.
- **Performance:** Database query optimizations applied to enhance performance and address N+1 issues. Comprehensive database indexing with 63 performance indexes across 8 billing/payment tables (subscriptions, transactions, payment_methods, subscription_events, billing_activity_logs, billing_notifications, subscription_plans, webhook_events) covering all common query patterns including composite indexes for user+status filtering.
- **Security:** Admin audit logs track all admin actions, IP addresses, and user agents. Admin session management allows tracking and revocation of sessions. Sensitive data (API keys, passwords) is stored encrypted.

## External Dependencies
- **Laravel 12 (PHP 8.2)**: Core backend framework.
- **Tailwind CSS**: Frontend styling.
- **Alpine.js**: Lightweight JavaScript framework for frontend interactivity.
- **Vite 7**: Frontend build tool.
- **PostgreSQL**: Replit's built-in database (Neon-backed) for data persistence.
- **Stripe**: Payment gateway for subscriptions and transactions, with webhook integration for real-time event processing.
- **Spatie Laravel Permission**: For role-based access control.
- **N8N**: For webhook integrations.

---

## Admin Panel Improvement Roadmap (December 2025)

### Quick Improvements (Priority 1 - Fast Implementation)

| # | Improvement | Status | Date |
|---|-------------|--------|------|
| 1 | Toast Notifications for admin actions (success/error feedback) | [x] Done | Dec 14, 2025 |
| 2 | Better Error Messages with suggested fixes | [x] Done | Dec 14, 2025 |
| 3 | Keyboard Shortcuts for common actions | [x] Done | Dec 14, 2025 |
| 4 | Command Palette (Cmd+K style) for quick navigation | [x] Done | Dec 14, 2025 |

### Medium Improvements (Priority 2 - Moderate Effort)

| # | Improvement | Status | Date |
|---|-------------|--------|------|
| 5 | Enhanced Search & Filtering across all tables | [x] Done | Dec 14, 2025 |
| 6 | Bulk Actions for customers/subscriptions | [x] Done | Dec 14, 2025 |
| 7 | Activity Timeline with detailed changelog | [ ] Pending | - |
| 8 | CSV/PDF Export for reports and tables | [x] Done | Dec 14, 2025 |

### Advanced Improvements (Priority 3 - Larger Features)

| # | Improvement | Status | Date |
|---|-------------|--------|------|
| 9 | Real-Time Notifications dashboard with alerts | [ ] Pending | - |
| 10 | Webhook Testing Interface (test & replay events) | [ ] Pending | - |
| 11 | Dashboard Customization (drag-drop widgets) | [ ] Pending | - |
| 12 | Performance Monitoring dashboard | [ ] Pending | - |

### Progress Notes
- Started: December 14, 2025
- **Priority 1 Complete**: All 4 quick improvements done (Dec 14, 2025)
  - Toast notifications (pre-existing, verified working)
  - Better error messages with helpful suggestions
  - Keyboard shortcuts (Ctrl+K to open command palette)
  - Command Palette for quick navigation
- **Priority 2 Progress** (Dec 14, 2025):
  - Enhanced Search & Filtering: Already implemented (search, status filters, sorting, per-page)
  - Bulk Actions: Already implemented (activate/deactivate/delete/export on customers)
  - CSV Export: Already implemented via bulk actions dropdown
  - Activity Timeline: Pending - needs implementation
- Current Focus: Activity Timeline, then Priority 3