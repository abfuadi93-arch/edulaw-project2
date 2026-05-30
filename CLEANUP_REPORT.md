# Catatan Perapian Proyek Edulaw

## Ringkasan

Paket awal berukuran sekitar 170 MB. Versi ini diringkas menjadi sekitar 13 MB sebelum dikompresi, tanpa mengubah logika utama aplikasi. Fokus perapian adalah menghapus artefak lokal, file hasil build lama, dependency berat, dan file konfigurasi privat.

## Bagian yang dihapus

- `node_modules/` karena dapat dibuat ulang dengan `npm install`.
- `vendor/` karena dapat dibuat ulang dengan `composer install`.
- `.git/`, `.github/`, dan `.vscode/` karena tidak diperlukan dalam paket distribusi.
- `.env` karena memuat konfigurasi privat dan tidak boleh ikut dibagikan.
- `dist/` karena berisi arsip ZIP lama.
- `.DS_Store` dan `__MACOSX/` karena hanya artefak macOS.
- Cache, log, session, dan file sementara Laravel.

## Perbaikan yang dilakukan

- Mengganti README default Laravel dengan README khusus Edulaw Project.
- Merapikan `.env.example` agar memakai identitas Edulaw, locale Indonesia, dan konfigurasi aman tanpa kredensial.
- Menambahkan catatan ini agar struktur paket mudah dipahami.
- Mempertahankan `public/build/` karena berguna untuk deployment ketika aset frontend sudah dibangun.
- Mempertahankan `composer.lock` dan `package-lock.json` agar versi dependency tetap konsisten.

## Catatan lanjutan

`routes/web.php` masih memuat banyak query dan logika halaman dalam closure. Secara fungsional ini bisa berjalan, tetapi untuk tahap berikutnya sebaiknya logika publik dipindahkan bertahap ke controller khusus, misalnya `HomeController`, `ProgramController`, `InsightController`, dan `ResearchController`. Langkah itu akan membuat kode lebih mudah dirawat tanpa mengubah tampilan publik.
