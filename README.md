# web_balai_v2

Website Balai Air Tanah berbasis Laravel 12 dan Vite.

## Requirement Lokal

- PHP 8.2 atau lebih baru
- Composer 2.x
- Node.js versi LTS terbaru
- NPM
- MySQL/MariaDB untuk konfigurasi default XAMPP

## Instalasi

```bash
cp .env.example .env
composer install
npm install
php artisan key:generate
php artisan storage:link
php artisan migrate:fresh --seed
npm run build
php artisan serve
```

Akun admin awal dari seeder:

- Email: `superadmin@gmail.com`
- Password: `superadmin123`

## Menjalankan Dengan Docker

Docker setup project ini sudah menyiapkan:

- PHP 8.2 FPM
- Composer 2
- Node.js 22 dan NPM untuk build asset Vite
- Nginx
- MySQL 8
- Auto copy `.env.example` ke `.env`
- Auto `composer install`
- Auto `npm ci` / `npm install`
- Auto `npm run build`
- Auto `php artisan key:generate`
- Auto `php artisan storage:link`
- Auto migrate dan seed database

Jalankan:

```bash
docker compose up --build
```

Akses aplikasi di:

```text
http://localhost:8000
```

Jika dependency frontend berubah, jalankan ulang:

```bash
docker compose up --build
```

## Development Asset

Source asset berada di:

- `resources/css/app.css`
- `resources/css/pages.css`
- `resources/css/admin.css`
- `resources/css/auth.css`
- `resources/js/app.js`
- `resources/js/pages.js`
- `resources/js/admin.js`

Jalankan mode development:

```bash
npm run dev
```

Build production:

```bash
npm run build
```
