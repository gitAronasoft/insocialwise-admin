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

### Dashboard
- Overview statistics (customers, subscriptions, posts, revenue)
- Revenue charts
- Customer growth charts
- Subscription status pie chart
- Recent activity feed

### User Management
- **Customers**: View, edit, toggle status, impersonate, bulk actions, export
- **Connected Pages**: View social media pages linked to customers
- **Social Accounts**: Manage connected social media accounts with health status

### Billing & Subscriptions
- **Subscriptions**: View all subscriptions, filter by status, export
- **Subscription Plans**: Create/edit plans with Stripe sync, pricing tiers, trial periods
- **Transactions**: View all payment transactions
- **Revenue**: Revenue analytics and reporting

### Content Management
- **Posts**: View user posts with filtering and search
- **Comments**: Manage post comments

### Advertising
- **Campaigns**: View advertising campaigns
- **Ad Accounts**: Manage advertising accounts
- **Adsets**: View ad sets
- **Ads**: View individual ads

### Analytics & Reports
- **Analytics**: Social media scores, page scores, demographics
- **Reports**: Generate custom reports with preview and export

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
- **Settings**: Application settings management
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

## Stripe Integration
- Stripe credentials are configured in .env file (STRIPE_SECRET_KEY, STRIPE_PUBLISHABLE_KEY)
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
- Initial setup for Replit environment (December 2024)
- Configured Vite for Replit proxy support
- Set up workflow on port 5000
- Fixed tooltip CSS in subscription plan forms to display horizontally (December 2024)
- StripeService uses .env credentials (STRIPE_SECRET_KEY, STRIPE_PUBLISHABLE_KEY)
- Plans now automatically sync to both Stripe and database when created/updated
- Created 4 subscription plans: Starter, Growth, Agency, Enterprise
