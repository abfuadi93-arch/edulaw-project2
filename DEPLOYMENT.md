# Deployment Notes

Use `scripts/package-hostinger.sh` to create a clean upload ZIP for Hostinger.

The generated ZIP excludes local/development artifacts:

- `vendor/`
- `node_modules/`
- `.DS_Store`
- `__MACOSX/`
- `.env`
- editor, git, cache, log, and generated ZIP files

Recommended flow:

1. Build frontend assets locally with `npm run build`.
2. Create the ZIP with `./scripts/package-hostinger.sh`.
3. Upload the generated file from `dist/`.
4. On the server, configure `.env`, then install PHP dependencies with `composer install --no-dev --optimize-autoloader`.
5. Run Laravel deployment commands on the server:

```bash
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```
