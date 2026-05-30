# Edulaw Project

Aplikasi web Edulaw Project berbasis Laravel 12 dan Filament 3. Paket ini sudah dibersihkan dari artefak lokal agar lebih aman untuk disimpan di GitHub atau dikirim ke server.

## Isi utama

- `app/` — model, provider, resource Filament, widget dashboard, dan controller autentikasi.
- `routes/web.php` — seluruh rute publik dan autentikasi.
- `resources/views/` — tampilan publik dan tampilan pendukung Filament.
- `database/migrations/` — struktur tabel aplikasi.
- `public/build/` — hasil build frontend yang dapat dipakai untuk deployment.
- `.env.example` — contoh konfigurasi tanpa kredensial privat.

## Yang sengaja tidak disertakan

- `.env`
- `vendor/`
- `node_modules/`
- `.git/`, `.github/`, `.vscode/`
- `dist/`
- file `.DS_Store` dan folder `__MACOSX`
- log, cache, session, dan arsip ZIP lama

## Instalasi lokal

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm run build
php artisan serve
```

## Deployment singkat

1. Pastikan `.env` di server sudah berisi konfigurasi produksi.
2. Jalankan:

```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

3. Untuk membuat ZIP upload bersih, gunakan:

```bash
./scripts/package-hostinger.sh
```

File ZIP akan dibuat di folder `dist/` dan tetap mengecualikan file sensitif serta folder dependency lokal.
