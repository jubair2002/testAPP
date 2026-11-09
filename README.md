# Cluster Users

A small Laravel CRUD app for the existing `appdb.users` table. It lists and searches users, creates and edits records, changes active status, and deletes records.

## Database

Configure `.env` for the MySQL Router endpoints that front your InnoDB Cluster:

```dotenv
DB_CONNECTION=mysql
DB_DATABASE=appdb
DB_USERNAME=appuser
DB_PASSWORD=your-database-password
DB_WRITE_HOST=127.0.0.1
DB_WRITE_PORT=6446
DB_READ_HOST=127.0.0.1
DB_READ_PORT=6447
```

Ports `6446` and `6447` are the standard MySQL Router read/write and read-only ports. Set the host values to the Router address reachable from the Laravel app; they can be different if your deployment exposes separate endpoints. Keep real credentials in `.env`, which is ignored by Git.

The app uses Laravel's MySQL read/write connection configuration: user-list and search queries use the reader; inserts, updates, and deletes use the writer. It targets the existing `users` schema (`user_id`, `username`, `email`, `age`, `is_active`, `created_at`) and intentionally does not run schema migrations against that database.

## Instructions for Run locally

```bash
composer install
cp .env.example .env
php artisan key:generate
# Set the cluster endpoint and password in .env
php artisan serve
```

Open <http://127.0.0.1:8000>. The database user needs `SELECT` access on the reader and `SELECT`, `INSERT`, `UPDATE`, and `DELETE` access on the writer. PHP needs the `pdo_mysql` extension.

This basic CRUD interface has no application login. Keep it on a trusted network or put it behind your organization's authentication before exposing it to other users.

Run the app tests with `php artisan test`.
