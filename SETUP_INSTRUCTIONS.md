# Quick Setup Instructions

## Step 1: Install Composer Dependencies
```bash
composer install
```

## Step 2: Setup Environment
```bash
# Copy .env.example to .env (if not already done)
cp .env.example .env

# Generate application key
php artisan key:generate
```

## Step 3: Configure Database
Edit `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=footsy
DB_USERNAME=root
DB_PASSWORD=your_password
```

## Step 4: Create Database
```sql
CREATE DATABASE footsy;
```

## Step 5: Run Migrations
```bash
php artisan migrate
```

## Step 6: Seed Database
```bash
php artisan db:seed
```

## Step 7: Start Server
```bash
php artisan serve
```

Visit: http://localhost:8000

## Default Login Credentials

**Admin:**
- Email: admin@footsy.com
- Password: admin123

**User:**
- Email: user@footsy.com
- Password: password

## Important Notes

1. Make sure `public/css/variables.css` exists (copy from `resources/css/variables.css` if needed)
2. Ensure storage and bootstrap/cache directories are writable
3. Session driver is set to 'database' in .env
4. All images use external URLs from Unsplash - replace with your own images

## Troubleshooting

If you get errors:
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Reset database
php artisan migrate:fresh --seed
```

