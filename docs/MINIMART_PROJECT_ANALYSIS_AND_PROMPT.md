# MiniMart — Comprehensive Project Analysis & Master Replicating Prompt

**Project:** MiniMart E-Commerce Management Platform  
**Framework:** Laravel 11.x | PHP 8.2+  
**Architecture:** Modular Monolith (`nwidart/laravel-modules`)  
**Author:** Akhil S  
**Date:** August 2026  

---

## PART 1: COMPREHENSIVE PROJECT ANALYSIS

### 1. Executive Summary & Tech Stack

MiniMart is an enterprise-grade, modular Laravel E-Commerce Admin Panel and SaaS Management System. It manages multi-store operations, complex EAV product catalogs, customer relationships, order processing, shipping, taxes, promo price rules, and CMS content.

* **Core Framework:** Laravel 11.x (PHP 8.2+)
* **Modular Engine:** `nwidart/laravel-modules` v11.1 (20 Domain Modules)
* **Frontend Tech:** Vanilla CSS with custom CSS variables, Tailwind CSS v3.1, Alpine.js v3.4, Vite v5.0, ApexCharts
* **Database & ORM:** MySQL (Session, Cache, Queue on Database), Eloquent ORM
* **Security & Auth:** Laravel Breeze / Sanctum, Spatie Laravel-Permission v6.10 (RBAC)
* **API & Integrations:** REST API v1 (`Modules/Api`), Twilio SMS OTP (`Modules/WebConfigurationManagement`), Stripe SDK v16.6, Barryvdh DomPDF v3.1, Maatwebsite Excel, Yajra DataTables v11.0

---

### 2. Modular Architecture (20 Domain Modules)

```
minimart/
├── app/                  # Core Laravel Kernel, Global Helpers, Models
├── config/               # Application & Package Configurations
├── docs/                 # Documentation Suite
├── Modules/              # 20 Independent Domain Modules
│   ├── Api/              # RESTful API Endpoints & Auth Controllers
│   ├── Base/             # Core Layouts, Header, Sidebar, Footer, Global Assets
│   ├── Cart/             # Shopping Cart, Addresses, Items
│   ├── Category/         # Categories, Tree Structures, Slugs
│   ├── CMS/              # Static Blocks, Pages, Banners, Email Templates
│   ├── Customer/         # Customers, Profiles, Groups, Wishlists
│   ├── Dashboard/        # Executive KPIs, ApexCharts Analytics, Activity Feed
│   ├── NewsLetter/       # Email Subscribers & Marketing Lists
│   ├── OrderManagement/  # Orders, Shipping Invoices, Statuses, Comments
│   ├── PaymentManagement/ # Transactions & Payment History
│   ├── PaymentMethod/    # Gateway Configurations & Attributes
│   ├── PriceRuleManagement/ # Catalog & Cart Discount Price Rules
│   ├── ProductAttributes/ # EAV Attributes, Attribute Sets, Mappings
│   ├── Products/         # Product Catalog, Variants, Stock, Reviews, Meta
│   ├── ShippingMethode/  # Shipping Carriers, Methods, Rates
│   ├── StoreManagement/   # Multi-Store Engine & Switching Logic
│   ├── TaxManagement/    # Tax Classes, Rates, & Calculation Rules
│   ├── URLRewrite/       # Custom SEO Slugs & Route Redirections
│   ├── UserPermission/   # User Accounts, Spatie RBAC, Admin Profiles
│   └── WebConfigurationManagement/ # Twilio OTP, OSS Storage, System Settings
├── public/               # Public SVG Logos, Favicons, Build Assets
└── resources/            # Auth blade templates (Breeze) & global SASS
```

---

### 3. Core Database Entities & Relationships

1. **Users & Roles:** `users`, `roles`, `permissions`, `model_has_roles` (Spatie RBAC).
2. **Multi-Store Management:** `stores`, `store_products` (Multi-tenancy context stored in `session('store_id')`).
3. **EAV Catalog System:**
   * `categories`, `category_products`, `categories_meta`
   * `products`, `products_meta`, `product_catalog_prices`, `product_reviews`, `product_variant_related_tables`
   * `product_attributes`, `product_attribute_sets`, `attribute_set_map`
4. **Order & Shipping Lifecycle:**
   * `orders`, `order_items`, `order_addresses`, `order_shipping_tables`, `order_comments`, `order_status`
5. **Customer & Cart System:**
   * `customers`, `customer_groups`, `wish_list_items`, `carts`, `cart_items`, `cart_addresses`, `abandoned_carts`
6. **Finance & Rules:**
   * `tax_classes`, `tax_rates`, `catalog_price_rules`, `cart_price_rules`, `payment_methods`

---

### 4. MiniMart UI & Design System

The application features a modern SaaS visual design system with light/dark theme persistence:

```css
:root {
    --mm-primary: #2563EB;         /* Vibrant Royal Blue */
    --mm-primary-dark: #1D4ED8;    /* Deep Blue */
    --mm-accent: #14B8A6;          /* Modern Teal Accent */
    --mm-bg: #F8FAFC;              /* Light Surface Slate */
    --mm-surface: #FFFFFF;         /* Card White */
    --mm-text: #0F172A;             /* Slate Dark Header */
    --mm-text-secondary: #64748B;   /* Slate Muted Text */
    --mm-border: #E2E8F0;          /* Crisp Border Line */
    --mm-success: #22C55E;         /* Emerald Green */
    --mm-warning: #F59E0B;         /* Amber Orange */
    --mm-danger: #EF4444;          /* Coral Red */
}
```

* **Login Screen:** 2-column SaaS authentication layout with left visual showcase panel, ambient glowing gradients (`#0F172A` to `#1E293B`), floating live metric cards, animated submit buttons, and reduced-motion compliance.
* **Admin Layout:** Fixed header with store switcher, user menu, and light/dark mode toggle button; collapsible sidebar with dark SVG logo; executive dashboard cards with hover elevation.

---

---

## PART 2: MASTER REPLICATING PROMPT FOR AI AGENTS

Below is the complete, self-contained prompt to give an AI coding agent to generate or build the complete **MiniMart** E-Commerce Management Platform from scratch.

````markdown
# MASTER PROMPT: Build "MiniMart" — Modern Laravel E-Commerce Admin Panel

Act as a Senior Laravel Architect, Full-Stack Developer, and UI/UX Engineer.

Build a complete, standalone, production-ready E-Commerce Admin Panel called **MiniMart**.

### Project Specifications:
- **Application Name:** MiniMart
- **Author:** Akhil S
- **Contributors:** None
- **Framework:** Laravel 11.x (PHP 8.2+)
- **Architecture:** Modular Monolith using `nwidart/laravel-modules`

---

## 1. ARCHITECTURE & DOMAIN MODULES

Initialize the following 20 domain modules under `Modules/`:

1. `Base`: Master layout (`mt-main.blade.php`), header, sidebar, footer, global CSS tokens, theme switcher script.
2. `Dashboard`: Executive KPI widgets (Users, Products, Orders), ApexCharts (Orders Overview, Category Pie), Recent Orders table, Activity Feed.
3. `UserPermission`: User CRUD, Admin Profiles, Spatie Roles & Permissions (RBAC).
4. `StoreManagement`: Multi-Store management (`stores`), store switching controller (`store.switch`), store product assignment.
5. `Products`: Product CRUD, Product Attributes (EAV), Variants, Inventory management, Reviews, Ratings, Related & Cross-selling products.
6. `Category`: Hierarchical Category Tree, Slugs (`url_key`), SEO metadata.
7. `ProductAttributes`: EAV Attribute system (Attributes, Attribute Sets, Attribute Mappings).
8. `Customer`: Customer Listing, Customer Groups, Wishlists, Customer Addresses.
9. `OrderManagement`: Orders Listing, Order Items, Order Statuses, Comments, Shipping Invoices (`shipping_details.blade.php`).
10. `Cart`: Cart management, Cart items, Cart addresses, Abandoned Carts tracking.
11. `PriceRuleManagement`: Catalog Price Rules & Cart Discount Rules engine.
12. `PaymentMethod`: Payment gateway configurations, attributes, status options.
13. `PaymentManagement`: Payment transactions, payment status options, order payment histories.
14. `ShippingMethode`: Shipping methods, rates, shipping attributes.
15. `TaxManagement`: Tax Classes, Tax Rates, Product Tax rules.
16. `CMS`: Banners, Hero Banners, Static Blocks, CMS Pages, Email Templates (`EmailTemplateSeeder`).
17. `NewsLetter`: Email subscriber management.
18. `URLRewrite`: SEO URL rewriting engine & custom route redirects.
19. `WebConfigurationManagement`: System config forms, Twilio OTP SMS (`OtpService`), Cloud Storage config, Tax config.
20. `Api`: RESTful API v1 routes (`/api/v1/...`) for mobile/frontend integration.

---

## 2. DESIGN SYSTEM & COLOR TOKENS

Establish centralized CSS Custom Properties in the master layout (`mt-main.blade.php`):

```css
:root {
    --mm-primary: #2563EB;
    --mm-primary-dark: #1D4ED8;
    --mm-accent: #14B8A6;
    --mm-bg: #F8FAFC;
    --mm-surface: #FFFFFF;
    --mm-text: #0F172A;
    --mm-text-secondary: #64748B;
    --mm-border: #E2E8F0;
    --mm-success: #22C55E;
    --mm-warning: #F59E0B;
    --mm-danger: #EF4444;
}

[data-bs-theme="dark"], body.dark-mode {
    --mm-bg: #0F172A;
    --mm-surface: #1E293B;
    --mm-text: #F8FAFC;
    --mm-text-secondary: #94A3B8;
    --mm-border: #334155;
    background-color: #0F172A !important;
    color: #F8FAFC !important;
}
```

Include a Light/Dark Theme Switcher in the topbar header with `localStorage` persistence (`mm-theme`).

---

## 3. LOGOS & BRAND ASSETS

Create clean, scalable SVG assets in `public/images/`:
- `minimart-logo.svg`: Primary light brand logo
- `minimart-logo-dark.svg`: Primary dark brand logo
- `minimart-icon.svg`: Standalone brand icon
- `public/favicon.ico`: SVG favicon

---

## 4. AUTHENTICATION & LOGIN PAGE

Redesign `resources/views/auth/login.blade.php` into a modern 2-column SaaS screen:
- **Left Column:** Ambient gradient backdrop (`#0F172A` to `#1E293B`), MiniMart dark SVG logo, tagline ("Smart Management for Modern Stores"), floating interactive sales & live order cards.
- **Right Column:** Styled email & password input floating focus rings, Remember Me checkbox, Forgot Password link, primary submit button with loading spinner, validation error messages.
- Full respect for `@media (prefers-reduced-motion: reduce)`.

Seed default admin credentials in `database/seeders/DatabaseSeeder.php`:
- **Email:** `admin@gmail.com`
- **Password:** `Admin@123`
- **is_super_admin:** `1`

---

## 5. DOCUMENTATION SUITE

Generate documentation tracking files under `docs/`:
- `docs/MINIMART_CONVERSION_STATUS.md`
- `docs/MINIMART_CHANGELOG.md`
- `docs/MINIMART_FILE_CHANGES.md`
- `docs/MINIMART_BRANDING_SCAN.md`
- `docs/MINIMART_TESTING_STATUS.md`

---

## 6. VALIDATION & CHECKS

Ensure the following commands succeed with zero errors:
```bash
composer dump-autoload
php artisan optimize:clear
php artisan about
php artisan route:list
php artisan migrate:status
npm run build
```
````

---

## PART 3: DOCUMENTATION PERSISTENCE

This analysis and prompt document has been created and saved locally at:
`c:\xampp\htdocs\minimart\docs\MINIMART_PROJECT_ANALYSIS_AND_PROMPT.md`
