# InSocialWise Admin Panel

## Overview
This is a comprehensive Laravel 12 Admin Panel for managing social media marketing services. It provides a full-featured dashboard for managing customers, subscriptions, social media accounts, content, advertising campaigns, analytics, and more.

## Tech Stack
- **Backend**: Laravel 12 (PHP 8.2)
- **Frontend**: Blade Templates, Tailwind CSS, Alpine.js
- **Build Tool**: Vite 7
- **Database**: Remote MySQL (configured in .env)
- **Payments**: Stripe Integration
- **Permissions**: Spatie Laravel Permission

## Project Structure
```
app/
├── Http/Controllers/Admin/    # Admin controllers
├── Models/                    # Eloquent models
├── Services/                  # Business logic services
├── View/Components/           # Blade components
config/                        # Laravel configuration
database/
├── migrations/                # Database migrations
├── seeders/                   # Database seeders
resources/
├── css/                       # Stylesheets
├── js/                        # JavaScript files
├── views/                     # Blade templates
routes/
├── admin.php                  # Admin routes
├── web.php                    # Web routes
├── api.php                    # API routes
```

## Features & Functionality

### Dashboard (Enhanced Analytics)
- **Global Time Period Filter**: Week, Month, Quarter, Year filters across all metrics
- **Revenue Metrics**: Total Revenue, MRR (Monthly Recurring Revenue), ARPU with growth indicators
- **Most Popular Plan**: Shows top revenue-generating subscription plan
- **Subscription Metrics**: Active, Failed, Churn Rate with trend indicators
- **Trial Conversion**: Real-time trial to paid conversion tracking
- **Subscription Health Score**: Visual health indicator with at-risk subscriptions
- **Key Metrics**: Customer LTV, Net Revenue Retention (NRR)
- **Charts**: Revenue Overview, Revenue by Plan, Subscription Trends, Subscription Breakdown
- **Recent Activity Feed**: Real-time customer activity with color-coded events
- **Customer Timeline Widget**: Quick view of recent customer journeys

### User Management
- **Customers**: View, edit, toggle status, bulk actions, export
- **Customer Activity Timeline**: Full chronological history of customer actions
- **Customer Journey Page**: Complete view with activity, subscription, and payment timelines
- **Connected Pages**: View social media pages linked to customers
- **Social Accounts**: Manage connected social media accounts with health status

### Billing & Subscriptions (Enhanced)
- **Subscriptions**: View all subscriptions with lifecycle timeline, filter by status, export
- **Subscription Timeline**: Visual journey from trial to active with milestones
- **Subscription Plans**: Create/edit plans with Stripe sync, pricing tiers, trial periods
- **Transactions**: View all payment transactions with detailed payment info
- **Revenue**: Revenue analytics and reporting
- **Billing Activity Logs**: Complete audit trail of all billing events
- **Notification Queue**: Manage scheduled billing notifications (trial reminders, renewal alerts)
- **Payment Methods**: View customer payment methods

### Admin Settings (Configurable via Panel)
- **Email Configuration**: SMTP settings (host, port, user, password) stored securely
- **Stripe Configuration**: API keys stored encrypted in database
- **Webhook URLs**: N8N integrations and external webhook endpoints
- **Notification Settings**: Control automated email notifications (trial reminders, payment alerts)

### Content Management
- **Posts**: View user posts with filtering and search
- **Comments**: Manage post comments

### Advertising
- **Campaigns**: View advertising campaigns
- **Ad Accounts**: Manage advertising accounts
- **Adsets**: View ad sets
- **Ads**: View individual ads

### Analytics & Reports (Comprehensive)
- **Subscription Analytics**: 
  - Plan Performance table (subscribers, revenue, conversion rate, churn rate, LTV per plan)
  - Trial Analytics (conversion rate, active trials, avg trial days, abandonment rate)
  - Subscription Health (failed payments, at-risk subscriptions, upcoming renewals)
  - Churn Analytics (churn by plan, recently churned customers)
- **Social Media Analytics**: Social media scores, page scores, demographics
- **Reports**: Generate custom reports with preview and export
- **Global Period Filtering**: All analytics support weekly, monthly, quarterly, yearly views

### Messaging
- **Inbox**: View customer conversations and messages

### Support
- **Knowledge Base**: Create and manage help articles (CRUD operations)

### Integrations
- **Webhooks**: Configure webhooks with testing and secret regeneration
- **API Keys**: Manage API keys with test functionality

### Compliance
- **Policies**: Create and manage compliance policies
- **Data Requests**: Handle GDPR/privacy data requests
- **Retention Rules**: Configure data retention rules

### System Administration
- **Admin Users**: Manage admin accounts with role-based permissions
- **Activity Logs**: View all system activities
- **Alerts**: System notifications and alerts
- **Settings**: Application settings management with grouped configurations
- **Master Control**: Feature flags and system toggles

### Profile Management
- View and edit admin profile
- Change password functionality

## Authentication
- Admin guard authentication with email/password
- Role-based access control (RBAC)
- Permission-based route protection

## Admin Login
- Email: admin@insocialwise.com
- Password: (use the one stored in the database or run seeder)

## Environment Variables
The application requires the following environment variables:
- `APP_KEY` - Laravel encryption key
- `APP_URL` - Application URL
- `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` - Database connection
- `ENCRYPTION_SECRET` - Secret key for encrypting sensitive admin settings

## Stripe Integration
- Stripe credentials can be configured via Admin Panel (Settings > Stripe Config)
- Credentials stored encrypted in admin_settings table
- Falls back to .env if not configured in panel
- Plans automatically sync to Stripe when created or updated via the admin panel
- 4 default plans created: Starter ($19), Growth ($49), Agency ($99), Enterprise (contact-only)

## Development Commands
```bash
# Start development server
php artisan serve --host=0.0.0.0 --port=5000

# Build frontend assets
npm run build

# Run migrations
php artisan migrate

# Run seeders
php artisan db:seed

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## User Preferences
- Dark mode support with system preference detection
- Collapsible sidebar navigation
- Responsive design for mobile/tablet
- **IMPORTANT**: Always run `npm run build` for Vite before starting Laravel server

## Recent Changes

### December 2024 - Enhanced Billing & Timeline Module
- **Billing Notifications System**:
  - billing_notifications table for scheduled email notifications
  - Notification types: trial_ending, payment_succeeded, payment_failed, renewal_reminder, etc.
  - Queue management with retry functionality
  - Scheduler control (start/stop/run now)
  
- **Billing Activity Logs**:
  - Complete audit trail of all billing events
  - Tracks: subscription changes, payments, refunds, webhooks, admin actions
  - Filterable by action type, status, date range
  
- **Admin Settings Service**:
  - Encrypted storage for sensitive data (API keys, passwords)
  - Grouped settings: email, stripe, webhooks, notifications
  - Cache layer for performance
  - Fallback to .env for missing settings

- **Customer Activity Timeline**:
  - Full chronological history of customer actions
  - Visual timeline cards with icons and color-coding
  - Events: signup, subscription, payments, logins, plan changes
  
- **Subscription Lifecycle Timeline**:
  - Visual journey: Trial Started → Converted → Active → Renewal
  - Payment history with status indicators
  - Upcoming events preview (renewals, trial endings)

- **Dashboard Enhancements**:
  - Real-time activity feed widget
  - Improved stats cards with live data
  - Health indicators for attention items

### Previous Changes (December 2024)
- Initial setup for Replit environment
- Configured Vite for Replit proxy support
- Set up workflow on port 5000
- Fixed tooltip CSS in subscription plan forms
- StripeService uses .env credentials
- Plans now automatically sync to both Stripe and database
- Created 4 subscription plans: Starter, Growth, Agency, Enterprise
- **Enhanced Dashboard & Analytics**:
  - Created AnalyticsService for comprehensive subscription and revenue metrics
  - Added global time period filter component (week/month/quarter/year)
  - Enhanced dashboard with 8 new stat cards with growth indicators
  - Added Revenue by Plan horizontal bar chart
  - Added Subscription Trends multi-line chart (new/renewed/canceled)
  - Added Subscription Health monitoring with health score
  - Enhanced Analytics page with Plan Performance table
  - Added Trial Analytics section with conversion funnel
  - Added Churn Analytics with churn by plan breakdown
  - Implemented LTV (Lifetime Value) and NRR (Net Revenue Retention) calculations

## Database Tables (Billing Module)

### billing_notifications
Stores scheduled and sent billing notifications
- Types: trial_ending_24h, trial_ending_1h, payment_succeeded, payment_failed, renewal_reminder, etc.
- Channels: email, in_app, sms, push
- Priority levels: low, normal, high, urgent
- Status tracking: pending, queued, sent, delivered, failed

### billing_activity_logs
Complete audit trail for billing events
- Action types: subscription_created, payment_succeeded, payment_failed, refund, etc.
- Actor types: user, admin, system, stripe, cron
- Stores old/new values for changes
- Links to subscriptions and transactions

### payment_methods
Customer payment methods
- Card details (brand, last4, expiry)
- Default payment method flag
- Stripe payment method ID

### admin_settings
Configurable settings stored in database
- Types: string, integer, boolean, json, email, encrypted
- Groups: general, email, stripe, webhooks, notification
- Encrypted type for sensitive data (API keys, passwords)

## Future Improvements Roadmap
### Revenue Intelligence
- Revenue forecasting based on current trends
- Cohort analysis (track user cohorts over time)
- Quick Ratio calculation (growth efficiency)

### Churn Prevention
- Churn prediction indicators with ML
- Automated win-back campaign triggers
- Churn reasons tracking and categorization

### Advanced Reporting
- Scheduled report exports (weekly/monthly PDF/Excel)
- Custom date range reports
- Comparison reports (this period vs last period)
- Email delivery of automated reports

### Dashboard Customization
- Drag-and-drop widget arrangement
- Favorite/pin important metrics
- Custom KPI cards per admin user

## User Preferences
- **No Customer Impersonation**: User requested to remove the customer impersonation feature from the admin panel (December 2024). This feature has been removed from routes, controllers, and views.
