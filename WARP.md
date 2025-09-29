# WARP.md

This file provides guidance to WARP (warp.dev) when working with code in this repository.

Project overview
- Minimal PHP MVC-style app for managing “tarimas” (pallets) and users.
- No Composer or external framework; manual routing via public/index.php.
- MySQL via PDO (singleton in models/Database.php).
- Views are plain PHP templates wrapped by a shared layout (views/layouts/main.php).

Commands you’ll commonly use (PowerShell / Windows)

Run the app locally
- Using PHP’s built-in server (fastest for development):
  - If php is on PATH:
    ```powershell
    php -S localhost:8000 -t public
    ```
  - If using XAMPP’s PHP:
    ```powershell
    & "C:\xampp\php\php.exe" -S localhost:8000 -t public
    ```
  - IMPORTANT: Update BASE_URL and base path so redirects match your URL:
    - config/config.php: set BASE_URL to your dev URL, e.g. http://localhost:8000
    - public/index.php: set $basePath to the subdirectory part of your URL ("" for http://localhost:8000, "/appphp" for http://localhost/appphp)

- Using Apache (XAMPP):
  - Document root can be the repo root (/.htaccess rewrites everything to /public/index.php) or the /public directory (public/.htaccess handles rewrites).
  - Ensure BASE_URL and $basePath correspond to how the site is mounted (e.g., http://localhost/appphp => BASE_URL='http://localhost/appphp' and $basePath='/appphp').

Set up the database
- The schema and seed data are in db_schema.sql. Import it into MySQL:
  ```powershell
  mysql -u root -p < db_schema.sql
  ```
  - You will be prompted for the password. Adjust the user/host as needed.
  - Default admin user is inserted by the script (see db_schema.sql).
- Configure DB connection in config/config.php (DB_HOST, DB_USER, DB_PASS, DB_NAME).

Syntax checks (no linter configured in repo)
- Single file:
  ```powershell
  php -l .\path\to\file.php
  ```
- All PHP files in the project:
  ```powershell
  Get-ChildItem -Recurse -Filter *.php | ForEach-Object { & php -l $_.FullName }
  ```

Tests
- No test suite is present (no phpunit.xml or tests/ directory). There are ad-hoc scripts (e.g., test_*.php) you can run directly.

High-level architecture and flow

HTTP entry and routing
- Apache rewrite rules (.htaccess) route all requests to the front controller:
  - Root .htaccess rewrites to public/index.php
  - public/.htaccess rewrites to public/index.php
- public/index.php bootstraps the app:
  - Starts the session, includes config, models, and controllers.
  - Normalizes the request URI by stripping a hardcoded base path ($basePath = '/appphp' by default). Keep this in sync with BASE_URL and your mount path.
  - Manual routing via if/elseif on $uri and $_SERVER['REQUEST_METHOD']:
    - GET /auth/login → AuthController::showLogin
    - POST /auth/login → AuthController::login
    - GET/POST /auth/register → AuthController::{showRegister, register}
    - GET /auth/logout → AuthController::logout
    - GET /dashboard → DashboardController::index (requires session)
    - GET /tarimas → TarimaController::listarTarimas (requires session)
    - GET /tarimas/nueva_tarima → TarimaController::nuevaTarima (requires session)
    - POST /tarimas/guardar → TarimaController::guardarTarima (requires session)

Controllers and views
- Base controller (controllers/Controller.php):
  - view($view, $data): renders views/{view}.php into $content, then includes views/layouts/main.php to wrap it. It sanitizes keys from $data before extract().
  - redirect($relative): sends Location: BASE_URL/{relative} and exits.
  - isLoggedIn(): checks the session flag.
- Views:
  - Layout at views/layouts/main.php expects $content and optional $title/$js variables.
  - Example: views/auth/login.php renders the login form and error messages.

Authentication
- Session-based: on successful login, sets user_logged_in, user_id, and username.
- Optional “remember me” cookie remember_user stores username (no token/backing storage).
- Auth gating is enforced in controllers before rendering protected routes.

Models and data access
- models/Database.php: simple PDO singleton using config constants (DB_HOST, DB_NAME, DB_USER, DB_PASS). ERRMODE_EXCEPTION is enabled.
- models/Usuario.php:
  - getByUsername($username): fetches a user by username.
  - create($userData): inserts a new user with a password hash.
  - exists($username, $email): checks uniqueness.
  - getTotalUsuarios(): count(*) users.
- models/Tarima.php:
  - create($tarimaData): inserts a new tarima, storing captured attributes.
  - getLastTarimas($limit): returns most recent tarimas, capped at 10,000.
  - getTotalTarimas(), getTarimasActivas(): aggregate counts.
- Database schema (db_schema.sql):
  - Database: gestiontarimas
  - Tables: usuarios, tarimas
  - Adds indexes for common lookups; seeds an admin user and a sample tarima.

Configuration
- config/config.php defines:
  - BASE_URL: base URL used for redirects (must match how you run the app).
  - DB_* constants for PDO connection.
  - APP_NAME, UPLOAD_MAX_SIZE.
- Keep BASE_URL and the public/index.php $basePath value consistent with your environment.

Static assets
- style.css in the repo root; Bootstrap and Font Awesome are loaded via CDNs in the layout.

Notes and quirks important for development
- No autoloader or framework; all includes are manual in public/index.php.
- The hardcoded $basePath in public/index.php must match your URL mount point. If you run the built-in server at http://localhost:8000, set $basePath = '' and BASE_URL = 'http://localhost:8000'. If you host at http://localhost/appphp, keep $basePath = '/appphp' and BASE_URL = 'http://localhost/appphp'.
- Error reporting is enabled in public/index.php (error_reporting(E_ALL); display_errors=1) which is convenient for dev.
