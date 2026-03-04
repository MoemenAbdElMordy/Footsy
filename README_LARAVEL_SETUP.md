# Laravel Footsy E-Commerce Setup Guide

This is a complete Laravel implementation of the Footwear E-Commerce Website with all Blade components using Bootstrap 5.

## Prerequisites

- PHP 8.1 or higher
- Composer
- MySQL/MariaDB
- Node.js and NPM (for asset compilation if needed)

## Installation Steps

### 1. Install Dependencies

```bash
composer install
```

### 2. Environment Setup

Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

### 3. Database Configuration

Edit `.env` file and configure your database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=footsy
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Run Migrations

Create the database tables:

```bash
php artisan migrate
```

### 5. Seed Database

Populate the database with sample data:

```bash
php artisan db:seed
```

This will create:
- Admin user: `admin@footsy.com` / `admin123`
- Regular user: `user@footsy.com` / `password`
- 8 sample products

### 6. Link Storage (if needed)

```bash
php artisan storage:link
```

### 7. Start Development Server

```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## Project Structure

```
├── app/
│   ├── Http/
│   │   ├── Controllers/     # All controllers
│   │   └── Middleware/      # Custom middleware
│   └── Models/              # Eloquent models
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/             # Database seeders
├── resources/
│   ├── css/
│   │   └── variables.css     # CSS variables
│   └── views/
│       ├── components/       # Reusable components
│       ├── layouts/          # Layout templates
│       └── pages/            # Page views
└── routes/
    └── web.php               # Web routes
```

## Features

- ✅ User Authentication (Login/Register)
- ✅ Product Catalog with Filters
- ✅ Shopping Cart (Session-based)
- ✅ Checkout Process
- ✅ Order Management
- ✅ Admin Dashboard
- ✅ Responsive Design (Bootstrap 5)
- ✅ CSS Variables for Theming
- ✅ No Absolute Positioning

## Default Accounts

**Admin:**
- Email: `admin@footsy.com`
- Password: `admin123`

**User:**
- Email: `user@footsy.com`
- Password: `password`

## Routes

- `/` - Homepage
- `/shop` - Shop listing
- `/shop/{category}` - Category page (men/women/kids)
- `/products/{id}` - Product detail
- `/cart` - Shopping cart
- `/checkout` - Checkout page
- `/login` - Login/Register
- `/orders` - User orders
- `/admin/dashboard` - Admin dashboard

## CSS Variables

All colors and spacing are defined in `resources/css/variables.css`:

- Colors: `--color-primary`, `--color-success`, etc.
- Spacing: `--spacing-xs`, `--spacing-sm`, etc.
- Typography: `--font-size-*`, `--font-weight-*`
- Shadows: `--shadow-sm`, `--shadow-md`, `--shadow-lg`

## Database Schema

### Users
- id, name, email, password, is_admin, timestamps

### Products
- id, name, description, price, category, brand, colors (JSON), sizes (JSON), images (JSON), stock, featured, timestamps

### Orders
- id, user_id, total, status, shipping_info (JSON), payment_method, timestamps

### Order Items
- id, order_id, product_id, quantity, price, size, color, timestamps

## Session Cart

The shopping cart is stored in the session. Cart structure:

```php
[
    'product_id-size-color' => [
        'product_id' => 1,
        'size' => 10,
        'color' => 'Black',
        'quantity' => 2
    ]
]
```

## Troubleshooting

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Reset Database
```bash
php artisan migrate:fresh --seed
```

### Permission Issues (Linux/Mac)
```bash
chmod -R 775 storage bootstrap/cache
```

## Next Steps

1. Configure email settings in `.env` for order confirmations
2. Set up payment gateway integration
3. Add product image upload functionality
4. Implement search functionality
5. Add product reviews and ratings
6. Set up admin product management

## License

MIT License

