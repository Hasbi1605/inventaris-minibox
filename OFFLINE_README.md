Goal

Provide step-by-step instructions for sending this Laravel project to a client laptop so it can run offline using SQLite.

Package contents assumption

The package produced by `scripts/pack-offline.sh` includes:

-   project files (app, routes, resources, etc.)
-   `vendor/` directory with composer dependencies
-   `database/database.sqlite` database file
-   no .env (you may include a .env if you want to preserve secrets/APP_KEY)

If you prefer, copy `.env` into the project before creating the package.

Instructions for the client (offline laptop)

1. Prerequisites

    - PHP 8.2+ installed with SQLite PDO extension enabled (pdo_sqlite)
    - Composer (only necessary if you want to modify dependencies, otherwise vendor is included)
    - Node.js + npm (only if you plan to build frontend assets locally; not required for running PHP server if assets pre-built)

2. Unpack the archive

    Extract the tarball into some folder, e.g. ~/projects/inventaris:

    ```bash
    tar -xzf inventaris-offline-YYYYMMDD-HHMMSS.tar.gz -C ~/projects
    cd ~/projects/project
    ```

3. Environment

    - If `.env` was not included, create one by copying `.env.example`:

    ```bash
    cp .env.example .env
    ```

    - Ensure the `.env` has these settings for offline SQLite usage:

    ```ini
    DB_CONNECTION=sqlite
    DB_DATABASE=database/database.sqlite
    SESSION_DRIVER=database
    CACHE_STORE=database
    APP_ENV=production
    APP_DEBUG=false
    ```

    - If the package didn't include your `APP_KEY`, generate one:

    ```bash
    php artisan key:generate
    ```

4. File permissions

    Ensure `storage/` and `bootstrap/cache` are writable by the webserver / the user running the PHP built-in server:

    ```bash
    chmod -R 775 storage bootstrap/cache
    ```

5. (Optional) Composer

    If you need to re-run composer (not required when `vendor/` included):

    ```bash
    composer install --no-dev --optimize-autoloader
    ```

6. Run migrations / seeders

    If the package already includes `database/database.sqlite` with schema & data, you don't need to run migrations. If you prefer to recreate the schema locally, run:

    ```bash
    php artisan migrate --force
    php artisan db:seed --force
    ```

7. Start the app

    For quick offline usage, use the built-in PHP server:

    ```bash
    php artisan serve --host=127.0.0.1 --port=8000
    ```

    Visit http://127.0.0.1:8000 in the browser.

8. Debugging

    - Check `storage/logs/laravel.log` for runtime errors.
    - Check that PHP has pdo_sqlite enabled: `php -m | grep sqlite`.

9. Reverting to MySQL

    To switch back to MySQL on the client machine, update `.env` DB\_\* settings and run `php artisan migrate` (if needed). The current packaging aims for SQLite-based offline usage.

Support

If you want, I can:

-   generate the offline package archive for you,
-   add a small installer script for the client to run that validates dependencies and starts the app,
-   or create a Docker-based offline runner.
