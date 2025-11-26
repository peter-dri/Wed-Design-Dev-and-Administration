# Dynamic Class Management — Starter Template

Overview
--------
This is a starter PHP application for managing classes, enrollments, attendance, and grades. It includes a minimal authentication system with lecturer and student roles and a simple responsive UI.

Quick status
------------
- App files are in this repo root.
- Database schema: `db.sql` (for MySQL) and an automatic SQLite initializer `init_sqlite.php` for quick runs.
- Gitpod support is included (one-click browser run).
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

Gitpod (browser run)
--------------------
Open the repository in Gitpod to run the app in the browser without installing anything locally:

https://gitpod.io/#https://github.com/peter-dri/Wed-Design-Dev-and-Administration

Files of interest
-----------------
- `config.php` — database configuration (supports MySQL and SQLite via `DB_DRIVER`).
- `db.sql` — MySQL schema.
- `init_sqlite.php` — create a SQLite database and seed demo data (used by Gitpod).
- `seed.php` — PHP seeding script (works with MySQL or SQLite when configured).
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
# Dynamic Class Management — Starter Template

This starter template is a simple PHP + MySQL application for managing classes, enrollments, attendance, and grades. It includes basic authentication and role-based access control for lecturers and students.

Getting started

- Create the database and tables:

```sql
-- run the SQL file
SOURCE db.sql;
```

- Alternatively, create the `class_management` database and run the statements in `db.sql`.
- Edit `config.php` to match your database credentials.
- Run `php seed.php` from the repository root to create a sample lecturer and student (credentials shown in the script).

Default sample users (from `seed.php`):
- Lecturer: `lecturer1` / `lecturerpass`
- Student: `student1` / `studentpass`

Pages

- `login.php` — login form
- `logout.php` — logout
- `lecturer_dashboard.php` — lecturer area to create/manage classes
- `create_class.php` — create a new class
- `class_view.php` — view class details (enrolled students, attendance, grades)
- `classes.php` — student-facing listing of available classes
- `enroll.php` — enroll in a class (student)
- `student_dashboard.php` / `my_classes.php` — student area

Notes & next steps

- This is a starter template and focuses on foundational functionality. Security improvements (CSRF tokens, stronger input validation, pagination, file upload handling) are recommended for production use.
- You can extend user registration, password reset, roles, and better UI components as needed.

Docker (quick run)

- If you have Docker installed you can run the app locally with MySQL using the included `docker-compose.yml`.

1. Build and start the stack from the project root:

```cmd
docker compose up -d
```

2. The web app will be available at: `http://localhost:8080`

3. The DB credentials in `docker-compose.yml` are:

- Host: `db` (service name) or `127.0.0.1` (if port 3306 is published)
- Port: `3306`
- Database: `class_management`
- User: `app` / `apppass`
- Root password: `rootpassword`

Notes: The init SQL seeds two demo users with plaintext passwords; on first login the app will re-hash them securely.

Run in Gitpod (no local install)

You can open this repository in Gitpod and run the app in your browser without installing PHP, XAMPP, or Docker locally.

- Open in Gitpod (one-click):

	https://gitpod.io/#https://github.com/peter-dri/Wed-Design-Dev-and-Administration

- The workspace will initialize the SQLite DB and start the PHP built-in server on port `8080`.


# Wed-Design-Dev-and-Administration
For
