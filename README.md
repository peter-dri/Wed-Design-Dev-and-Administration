# Dynamic Class Management — Starter Template

Overview
--------
This is a starter PHP application for managing classes, enrollments, attendance, and grades. It includes a minimal authentication system with lecturer and student roles and a simple responsive UI.

Quick status
------------
- App files are in this repo root.
- Database schema: `db.sql` (for MySQL).
- A helper script `setup_xampp.bat` is included to automate placing the project into XAMPP's `htdocs` and importing the DB on Windows.

Getting started (XAMPP - recommended for Windows)
-------------------------------------------------
1. Install XAMPP from https://www.apachefriends.org/ and start Apache and MySQL using the XAMPP Control Panel.
2. Copy or move this project into XAMPP's `htdocs` folder. The helper script automates this:

```cmd
cd C:\path\to\this\repo
setup_xampp.bat
```

3. The script will:
- Copy the repository into `%XAMPP%\htdocs\class-management` (default `%XAMPP%` is `C:\xampp`).
- Import `db.sql` into MySQL (prompting for root password if set).
- Run `seed.php` using XAMPP's PHP CLI (if available) to insert demo users and a sample class.
- Open `http://localhost/class-management/` in your default browser.

4. If you prefer to do steps manually:
- Import `db.sql` using phpMyAdmin (http://localhost/phpmyadmin) or MySQL CLI.
- Run `seed.php` from the web or via XAMPP's PHP CLI: `C:\xampp\php\php.exe seed.php`.

Default demo credentials created by the seed script
-------------------------------------------------
- Lecturer: `lecturer1` / `lecturerpass`
- Student: `student1` / `studentpass`

Docker (optional)
-----------------
If you prefer Docker, a `docker-compose.yml` is included to run MySQL and PHP/Apache. Start the stack from the project root:

```cmd
docker compose up -d
```

The web app will be available at `http://localhost:8080`.

Files of interest
-----------------
- `config.php` — database configuration (MySQL settings).
- `db.sql` — MySQL schema.
- `seed.php` — PHP seeding script (works with MySQL).
- `setup_xampp.bat` — Windows helper to copy project into XAMPP and import the DB.

Next steps and recommendations
------------------------------
- For production use, add CSRF protection, stronger validation, and sanitize user inputs thoroughly.
- Add registration and password-reset flows, logging, and role management UI.
- Consider moving to a framework (Laravel, Symfony) for larger projects.

If you want, I can now:
- Walk you through running `setup_xampp.bat` step-by-step and troubleshooting any errors.
- Automatically run the seed on first web request instead of manually running `seed.php`.
- Improve UI with Bootstrap and add CSRF protections.

