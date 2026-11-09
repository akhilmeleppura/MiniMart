# MiniMart Changelog

## Branding Changes

- Replaced Store9 branding with MiniMart across `.env`, `.env.example`, `config/app.php`, `composer.json`, `README.md`, sitemaps, RSS feeds, and order API controllers.
- Removed all references to Commerce9, Commerce9 Technology, and previous author/contributor listings.
- Set Project Author to **Akhil S** and removed all contributor sections.
- Created scalable MiniMart SVG logo suite (`minimart-logo.svg`, `minimart-logo-dark.svg`, `minimart-icon.svg`).
- Replaced site favicon references with MiniMart SVG favicon.

## UI & UX Modernization

- **Login Page Redesign:**
  - Built a 2-column SaaS authentication layout.
  - Left visual branding panel featuring glowing background gradients, floating interactive metric cards, tagline, and features overview.
  - Right form panel featuring styled inputs, floating focus states, remember me check, forgot password route link, loading spinner, and validation alerts.
  - Full `@media (prefers-reduced-motion: reduce)` support.
- **Color System & Design Tokens:**
  - Established CSS Custom Properties for MiniMart Palette:
    - Primary: `#2563EB`
    - Primary Dark: `#1D4ED8`
    - Accent: `#14B8A6`
    - Background: `#F8FAFC`
    - Surface: `#FFFFFF`
    - Text Primary: `#0F172A`
    - Text Secondary: `#64748B`
    - Border: `#E2E8F0`
    - Success: `#22C55E`
    - Warning: `#F59E0B`
    - Danger: `#EF4444`
- **Admin Panel Header & Navigation:**
  - Updated sidebar header with MiniMart dark SVG logo.
  - Added Light/Dark Mode switcher button with persistent localStorage toggle.
  - Modernized mobile navigation header with MiniMart logo.
  - Updated footer copyright to MiniMart by Akhil S.
- **Dashboard Enhancements:**
  - Redesigned KPI Cards with icon highlight containers and metric trend indicators.
  - Retained ApexCharts order overview and category pie chart integration.

## Code Refactoring & Debugging

- Updated `c:\xampp\htdocs\minimart\.env` and `c:\xampp\htdocs\minimart\.env.example` `APP_NAME=MiniMart`.
- Updated `c:\xampp\htdocs\minimart\config\app.php` fallback app name to `MiniMart`.
- Updated `c:\xampp\htdocs\minimart\composer.json` package name to `minimart/admin-panel` and author to `Akhil S`.
- Updated `c:\xampp\htdocs\minimart\public\google-product-feed.xml` and `c:\xampp\htdocs\minimart\public\sitemap.xml` domain URLs to `demo.minimart.io`.
- Updated `c:\xampp\htdocs\minimart\Modules\OrderManagement\resources\views\shipping_details.blade.php` to `MiniMart FZCO`.
- Updated `c:\xampp\htdocs\minimart\Modules\WebConfigurationManagement\app\Services\OtpService.php` SMS message to `MiniMart`.
- Updated `c:\xampp\htdocs\minimart\Modules\CMS\database\seeders\EmailTemplateSeeder.php` email template content to `MiniMart`.
- Updated `c:\xampp\htdocs\minimart\Modules\Api\app\Http/Controllers/OrderController.php` support URL, company name, order description, and customer reference prefix.
