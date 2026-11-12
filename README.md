# Rumon Tailor

A management system for small tailoring shops: keep track of customers, their body measurements, orders and income in one place. It has a web admin panel and a REST API for a companion Flutter mobile app.

This is a personal demo project. All data in it is made-up sample data.

## Features

- **Customers**: add, edit, search and filter customers.
- **Measurements**: save each customer's measurements once; they fill in automatically when you create a new order.
- **Orders**: one order can hold several items (shirt, pant, suit), each with its own measurements. Status flow: pending → in progress → completed → delivered (or cancelled).
- **Reports**: revenue and order statistics, plus top customers.
- **Admin panel**: login-protected dashboard for the shop owner.
- **REST API**: token-based API (Laravel Sanctum) used by the Flutter mobile app. See [API_DOCUMENTATION.md](API_DOCUMENTATION.md).

## Built with

- PHP 8.2+ and Laravel 12
- Laravel Sanctum for API authentication
- Blade, Tailwind CSS 4 and Vite for the admin UI
- SQLite by default (MySQL also works)
- PHPUnit for tests

## Getting started

Requirements: PHP 8.2+, Composer, Node.js 18+ and npm.

```bash
git clone https://github.com/ashraftaukir/rumontailor.git
cd rumontailor

composer install
npm install

cp .env.example .env
php artisan key:generate

touch database/database.sqlite
php artisan migrate --seed

npm run build        # or: npm run dev
php artisan serve
```

Open http://localhost:8000/admin/login.

The seeder creates a demo admin account and sample customers and orders:

- Email: `admin@example.com`
- Password: `password`

These are local demo credentials only. Change them before deploying anywhere.

## API

The API lives under `/api`. Log in with `POST /api/login` to get a token, then send it as `Authorization: Bearer <token>`.

Main endpoints: `customers`, `customers/{id}/measurements`, `orders`, `orders/{id}/status`, `dashboard`, `reports` and `reports/statistics`. Full details and examples are in [API_DOCUMENTATION.md](API_DOCUMENTATION.md).

## Running tests

```bash
php artisan test
```

## Roadmap

<!-- Edit this list with the work you actually plan to do. -->

- [ ] Feature tests for customers, orders, measurements and the API
- [ ] Order delivery dates and reminders for upcoming deliveries
- [ ] Payments: advance and due amounts per order, with a payment history
- [ ] Printable order slips and invoices (PDF)
- [ ] More garment types and configurable measurement fields
- [ ] Export reports to CSV/Excel
- [ ] Roles for shop staff besides the admin
- [ ] Finish and connect the Flutter mobile app

## License

This project is released under the [MIT License](LICENSE).
