# Laravel Blade Components - Footwear E-Commerce Website

This document describes the Laravel Blade components generated from the Figma design frames, using Bootstrap 5 and CSS variables.

## Structure

### CSS Variables
- **Location**: `resources/css/variables.css`
- Contains all color, spacing, typography, and design token variables
- All colors and spacing values are extracted as CSS variables for easy theming

### Components
- **Location**: `resources/views/components/`
- `header.blade.php` - Main navigation header
- `footer.blade.php` - Site footer
- `product-card.blade.php` - Product card component

### Pages
- **Location**: `resources/views/pages/`
- `home.blade.php` - Homepage with hero, categories, featured products, and features sections
- `shop/index.blade.php` - Shop listing page with filters
- `shop/partials/filters.blade.php` - Filter sidebar component
- `products/show.blade.php` - Product detail page
- `cart/index.blade.php` - Shopping cart page
- `checkout/index.blade.php` - Checkout page
- `auth/login.blade.php` - Login/Register page
- `orders/index.blade.php` - User orders page
- `orders/confirmation.blade.php` - Order confirmation page
- `admin/dashboard.blade.php` - Admin dashboard

### Layout
- **Location**: `resources/views/layouts/`
- `app.blade.php` - Main application layout

## Key Features

### No Absolute Positioning
All components use flexbox and Bootstrap 5's grid system. No absolute positioning is used for layout purposes.

### CSS Variables
All colors and spacing are defined as CSS variables in `variables.css`:
- Colors: `--color-primary`, `--color-success`, `--color-danger`, etc.
- Spacing: `--spacing-xs`, `--spacing-sm`, `--spacing-md`, etc.
- Typography: `--font-size-*`, `--font-weight-*`
- Shadows: `--shadow-sm`, `--shadow-md`, `--shadow-lg`
- Transitions: `--transition-fast`, `--transition-base`, `--transition-slow`

### Bootstrap 5
All components use Bootstrap 5 classes for:
- Grid system (`row`, `col-*`)
- Flexbox utilities (`d-flex`, `align-items-center`, etc.)
- Components (cards, buttons, forms, etc.)
- Responsive utilities (`d-none`, `d-md-flex`, etc.)

## Usage

### Including Components
```blade
<x-header />
<x-footer />
<x-product-card :product="$product" />
```

### Using CSS Variables
```blade
<div style="background-color: var(--color-success); padding: var(--spacing-lg);">
    Content
</div>
```

### Route Names Expected
- `home` - Homepage
- `shop.index` - Shop listing
- `shop.category` - Category page
- `products.show` - Product detail
- `cart.index` - Shopping cart
- `cart.add` - Add to cart
- `cart.update` - Update cart item
- `cart.remove` - Remove cart item
- `checkout.index` - Checkout page
- `checkout.store` - Place order
- `login` - Login
- `register` - Register
- `logout` - Logout
- `orders.index` - User orders
- `admin.dashboard` - Admin dashboard
- `admin.orders.update` - Update order status

## Notes

- All images use placeholder URLs from Unsplash. Replace with your actual image URLs.
- Icons use Bootstrap Icons (`bi bi-*` classes)
- Forms include CSRF protection tokens
- All components are responsive and mobile-friendly
- No JavaScript frameworks required - uses vanilla JavaScript for interactions

