# MiniMart — Modern Laravel E-Commerce Admin Panel

**MiniMart** is a modern, high-performance, modular Laravel E-Commerce Management Platform designed for managing catalog, inventory, orders, customers, marketing, taxes, shipping, and store settings with ease.

## Project Details

- **Application Name:** MiniMart
- **Framework:** Laravel 11.x
- **Author:** Akhil S
- **Contributors:** None
- **License:** MIT

## Key Features

- **Catalog Management:** Manage products, categories, brands, variants, and attributes.
- **Order Management:** Process orders, track shipping details, manage order statuses, and view analytics.
- **Customer Insights:** View registered customer listings, profiles, and order histories.
- **Modular Architecture:** Built using modular Laravel packages for extreme flexibility and maintainability.
- **Modern UI & Design System:** Custom responsive styling with dark mode support, SVG branding assets, and smooth micro-interactions.

## Setup Instructions

1. **Clone & Install Dependencies**
   ```bash
   composer install
   npm install
   ```

2. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database Migration**
   ```bash
   php artisan migrate
   ```

4. **Asset Compilation & Serve**
   ```bash
   npm run build
   php artisan serve
   ```
