<div align="center">

**A lightweight, MVC-based PHP framework built for simplicity and speed.**

[![PHP](https://img.shields.io/badge/PHP-8.1%2B-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![Composer](https://img.shields.io/badge/Composer-required-885630?style=flat-square&logo=composer&logoColor=white)](https://getcomposer.org)
[![Vite](https://img.shields.io/badge/Vite-supported-646CFF?style=flat-square&logo=vite&logoColor=white)](https://vitejs.dev)
[![License](https://img.shields.io/badge/License-MIT-22c55e?style=flat-square)](#license)

</div>

---

## Requirements

| Requirement | Version |
|---|---|
| PHP | 8.1 or higher |
| Composer | Latest |
| Node.js | 18+ *(for Vite)* |
| Web Server | Apache, Nginx, or PHP built-in |
| Database | MySQL / MariaDB *(optional)* |

---

## Quick Start

### 1. Create a new project

```bash
composer create-project litephp/app my-app
cd my-app
```

### 2. Set up environment

```bash
php lite env:init
php lite key:generate
php lite jwt:secret
```

### 3. Install frontend dependencies & start Vite

```bash
npm install
npm run dev
```

### 4. Start the PHP development server

```bash
php -S localhost:3000
or
npm run dev        # to run both the vite server and the lite app
```

> Open [http://localhost:3000](http://localhost:3000) in your browser.

---

## Vite Setup

LitePHP ships with first-class Vite support via the `@vite()` directive.

### Install dependencies

```bash
npm install
```

### Available commands

```bash
npm run dev      # Start Vite dev server with HMR
npm run build    # Build assets for production
```

### Usage in Blade views

```blade
{{-- In your layout file --}}
<? vite(['resources/css/app.css', 'resources/js/app.js'])?>
```

### Asset structure

```
resources/
├── css/
│   └── app.css       ← main stylesheet (Tailwind goes here)
└── js/
    └── app.js        ← main JavaScript entry point
build/            ← compiled output (auto-generated, gitignored)
public/
└── 
```

> **Note:** Run `npm run build` before deploying to production.

---

## Directory Structure

```
my-app/
├── app/
│   ├── Controllers/        — HTTP request handlers
│   ├── Helpers/            — Custom helper functions
│   ├── Middleware/
│   │   ├── Api/            — API route middleware
│   │   ├── Global/         — Runs on every request
│   │   └── Web/            — Web route middleware
│   ├── Models/             — Database models & ORM
│   ├── Routes/
│   │   └── web.php         — Route definitions
│   ├── Services/           — Business logic
│   └── views/
│       ├── layouts/        — Shared layout templates
│       ├── partials/       — Reusable partials
│       └── errors/         — 403, 404, 500 error pages
│
├── Bootstrap/              — Application bootstrap sequence
├── config/                 — Configuration files
├── resources/
│   ├── css/                — Source stylesheets
│   └── js/                 — Source JavaScript
├── storage/                — Logs, cache, sessions
├── public/                 — Web root (point server here)
│ build/              — Vite compiled assets
│
├── .env                    — Environment variables
├── .env.example            — Environment template
├── autoload.php            — Namespace & autoloading
├── composer.json           — PHP dependencies
├── package.json            — Node dependencies
├── vite.config.js          — Vite configuration
└── lite                    — CLI tool
```

---

## Configuration

All configuration is managed through `.env`:

```env
===================
APP CONFIGURATION
===================
APP_NAME=Lite
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:3000

===================
DATABASE CONFIGURATION
===================
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=root
DB_PASSWORD=

===================
SESSION CONFIGURATION
===================
SESSION_NAME=lite_session
SESSION_LIFETIME=120
SESSION_DOMAIN=
SESSION_SAMESITE=Lax

===================
MAIL CONFIGURATION
===================
MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=hello@example.com
MAIL_FROM_NAME=Lite

================================================================
APP KEY AND JWT SECRET HERE (auto injected once you run the cli)
================================================================
```

Config files live in `config/` and are accessible via:

```php
config('app.name');       // reads config/app.php → 'name' key
env('APP_DEBUG', false);  // reads directly from .env
```

---

## Routing

Define routes in `app/Routes/web.php`:

```php
use App\Controllers\HomeController;
use Core\Facades\Route;

// Basic routes
Route::get('/',       [HomeController::class, 'index']);
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');

// Route groups
Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/profile',   [UserController::class, 'show']);
});

// API routes
Route::group(['prefix' => '/api', 'middleware' => ['api']], function () {
    Route::get('/users', [UserController::class, 'index']);
});
```

---

## Controllers

```php
<?php

namespace App\Controllers;

use Core\Controller;

class HomeController extends Controller
{
    public function index(): never
    {
        view('home', [
            'title' => 'Welcome',
        ]);
    }
}
```

---

## Views & Layouts

**Layout** — `app/views/layout/app.php`:

```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'LitePHP')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @yield('content')
</body>
</html>
```

**View** — `app/views/home.php`:

```blade
@extends('layout.app')

@section('title') Home @endsection

@section('content')
    <h1>Hello, World!</h1>
@endsection
```

---

## Middleware

Middleware is auto-discovered from `app/Middleware/` via the `#[RegisterMiddleware]` attribute.

```php
#[RegisterMiddleware(group: 'web', alias: 'auth')]
class AuthMiddleware implements Middleware
{
    public function handle(Request $request, Response $response, callable $next): mixed
    {
        if (!Session::isLoggedIn()) {
            return $response->redirect('/login');
        }

        return $next($request, $response);
    }
}
```

### Built-in middleware (auto-registered)

| Middleware | Scope | Description |
|---|---|---|
| `SecurityHeadersMiddleware` | Global | XSS, clickjacking, MIME-sniffing protection |
| `VerifyCsrfToken` | Web group | CSRF token validation on all forms |
| `ThrottleMiddleware` | Per-route | Rate limiting via `throttle:attempts,minutes` |
| `CorsMiddleware` | Manual | Cross-origin resource sharing |

### CSRF in forms

```blade
<form method="POST" action="/submit">
    {!! csrf_field() !!}
    ...
</form>
```

---

## Authentication

LitePHP includes session-based and JWT authentication out of the box.

Configure in `config/auth.php` or via `.env`:

```env
AUTH_MODEL=App\Models\User
```

```php
// Check login state
Session::isLoggedIn();

// Get current user
Session::user();

// Log out
Session::logout();
```

---

## CLI — `lite`

The `lite` CLI provides development utilities:

```bash
php lite make:controller UserController    # Generate a controller
php lite make:view home                   # Generate a view
php lite make:resource User               # Generate a resource
php lite make:model User                   # Generate a model
php lite make:middleware AuthMiddleware    # Generate middleware
php lite migrate                           # Run database migrations
php lite migrate:rollback                  # Rollback last migration
php lite db:seed                           # Run database seeders
php lite cache:clear                       # Clear application cache
php lite route:cache                       # Cache route definitions
php lite route:clear                       # Clear route cache
php lite env:init                          # Initialize .env            
php lite key:generate                      # Generate app keys
php lite jwt:secret                        # Generate JWT secret
```

---

## Error Pages

Custom error pages are located in `app/views/errors/`:

| File | Status |
|---|---|
| `403.php` | Forbidden |
| `404.php` | Not Found |
| `500.php` | Server Error |

---

## Deployment Checklist

```env
APP_ENV=production
APP_DEBUG=false
```

- [ ] Set `APP_ENV=production` and `APP_DEBUG=false`
- [ ] Set correct `APP_URL`
- [ ] Run `npm run build` to compile assets
- [ ] Run database migrations
- [ ] Cache routes: `php lite route:cache`
- [ ] Ensure `storage/` is writable
- [ ] Restrict CORS origins in `config/cors.php`
- [ ] Secure `.env` — never commit to version control
- [ ] Point web server root to `public/`

---

## License

LitePHP is open-sourced software licensed under the [MIT License](LICENSE).

---
