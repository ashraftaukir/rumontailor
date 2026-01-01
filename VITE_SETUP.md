# Vite + Tailwind Setup Guide

## ✅ Completed Steps

All Blade templates have been updated to use Vite instead of Tailwind CDN:
- ✅ `resources/views/admin/login.blade.php`
- ✅ `resources/views/admin/dashboard.blade.php`
- ✅ `resources/views/admin/customers/index.blade.php`
- ✅ `resources/views/admin/customers/create.blade.php`
- ✅ `resources/views/admin/customers/edit.blade.php`
- ✅ `resources/views/admin/customers/show.blade.php`
- ✅ `resources/views/admin/orders/index.blade.php`
- ✅ `resources/views/admin/orders/create.blade.php`
- ✅ `resources/views/admin/orders/edit.blade.php`
- ✅ `resources/views/admin/orders/show.blade.php`

## 📋 Next Steps

### 1. Install Node.js

Download and install Node.js from: https://nodejs.org/
- Recommended: LTS version (v20.x or v22.x)
- This will also install npm (Node Package Manager)

### 2. Verify Installation

After installing Node.js, open a new terminal and verify:
```bash
node --version
npm --version
```

### 3. Install Dependencies

Navigate to your project directory and run:
```bash
cd C:\xampp\htdocs\tailor_backend
npm install
```

### 4. Build Assets

For **development** (with hot reload):
```bash
npm run dev
```

For **production** (optimized build):
```bash
npm run build
```

### 5. Run Your Laravel Application

In a separate terminal, start Laravel:
```bash
php artisan serve
```

Or use the combined dev script (if you have concurrently installed):
```bash
composer run dev
```

## 🚀 Development Workflow

**Option 1: Separate Terminals**
- Terminal 1: `npm run dev` (for frontend assets)
- Terminal 2: `php artisan serve` (for Laravel backend)

**Option 2: Combined (using composer script)**
- Single command: `composer run dev` (runs both Laravel and Vite)

## 📝 Notes

- Font Awesome is still loaded via CDN (this is fine and doesn't require npm)
- Vite will automatically reload your browser when you make changes to CSS/JS files
- The `public/build` directory will be created automatically when you run `npm run build` or `npm run dev`

## 🔧 Troubleshooting

If you see errors about missing assets:
1. Make sure you've run `npm install`
2. Make sure you're running `npm run dev` or `npm run build`
3. Clear Laravel cache: `php artisan cache:clear`
4. Clear view cache: `php artisan view:clear`

