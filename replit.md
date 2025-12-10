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
- **Stripe Webhook Integration:** Full webhook handling at `/stripe/webhook` endpoint processes all Stripe events (subscription CRUD, invoices, payments, refunds, payment methods). Credentials should be configured via Replit Secrets: STRIPE_SECRET_KEY, STRIPE_PUBLISHABLE_KEY, STRIPE_WEBHOOK_SECRET.
- **Modularity:** Organized project structure with dedicated directories for controllers, models, services, and views.
- **Performance:** Database query optimizations applied to enhance performance and address N+1 issues.
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