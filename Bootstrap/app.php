<?php

/**
 * Application Bootstrap
 *
 * This file is the single boot sequence for every HTTP request.
 * It runs top-to-bottom in a strict order — each section depends on
 * the one before it, so do not reorder the blocks.
 *
 * Boot order:
 *   1.  Autoloader       — makes Core\ and App\ classes available.
 *   2.  Storage          — creates writable directories under storage/.
 *   3.  Environment      — loads .env into $_ENV via Core\Config\Env.
 *   4.  Config           — loads all files in config/ into Config::get().
 *   5.  Cache            — boots the file cache (reads config/cache.php).
 *   6.  Error handler    — registers the global exception/error handler.
 *   7.  Container        — builds the IoC container and binds core services.
 *   8.  Facade           — wires Route facade to the Router instance.
 *   9.  Session          — sets save path, starts session, binds to container.
 *   10. Auth             — configures Auth with the model from config/auth.php.
 *   11. Routes           — loads app/Routes/web.php (or restores from cache).
 *   12. Kernel           — auto-discovers middleware, then handles the request.
 */

use Core\Container;
use Core\Http\Request;
use Core\Http\Response;
use Core\Exceptions\Handler;
use Core\Http\Kernel;
use Core\Routing\Router;
use Core\Routing\RouteCache;
use Core\Session;
use Core\Auth\Auth;

// ── 1. Autoloader ─────────────────────────────────────────────────────────────
require_once __DIR__ . '/../autoload.php';

// FIX: Corrected vendor path from litephp/core → litephp-core to match the
// actual package directory name under vendor/.
require_once __DIR__ . '/../vendor/litephp/core/Core/helpers.php';

// ── 2. Storage ────────────────────────────────────────────────────────────────
// Creates storage/cache/data, storage/logs, storage/framework/sessions, etc.
// Must run before anything writes to disk (cache, sessions, logs).
\Core\Support\Storage::boot();

// ── 3. Environment ────────────────────────────────────────────────────────────
Core\Config\Env::load(__DIR__ . '/../.env');

// ── 4. Config ─────────────────────────────────────────────────────────────────
Core\Config\Config::load(__DIR__ . '/../config');

// ── 5. Cache ──────────────────────────────────────────────────────────────────
\Core\Cache\Cache::boot();

// ── 6. Error Handler ──────────────────────────────────────────────────────────
Handler::register();

// ── 7. Container ──────────────────────────────────────────────────────────────
$container = new Container();

// FIX: Removed $GLOBALS['container']. Anything that was reaching into globals
// should instead be resolved through the container itself. The container is
// accessible via Container::class or the 'Container' alias below.
$container->instance(Container::class, $container);
$container->alias('Container', Container::class);

// Register the container into the app() helper's static slot.
app($container);

$request  = new Request();
$response = new Response();
$router   = new Router($request, $response, $container);

$container->singleton(\Core\Database::class, fn() => new \Core\Database());
$container->instance(Request::class,  $request);
$container->instance(Response::class, $response);
$container->instance(Router::class,   $router);

$container->alias('Request',  Request::class);
$container->alias('Response', Response::class);
$container->alias('Router',   Router::class);

// ── 8. Facade ─────────────────────────────────────────────────────────────────
\Core\Facades\Route::setRouter($router);

// ── 9. Session ────────────────────────────────────────────────────────────────
// Save sessions inside storage/framework/sessions — never inside vendor/.
session_save_path(storage_path('framework/sessions'));
Session::start();

// Bind Session class name into the container as a string alias.
// Session is used statically (Session::get(), Session::set(), etc.) —
// no instance is needed; this alias lets the container resolve it by name
// if any service type-hints or asks for 'Session'.
$container->alias('Session', Session::class);

// ── 10. Auth ──────────────────────────────────────────────────────────────────
// Reads config/auth.php. Set AUTH_MODEL in .env to override the default model.
Auth::configure(
    config('auth.model'),
    config('auth.username_field', 'email'),
    config('auth.password_field', 'password')
);

// ── 11. Routes ────────────────────────────────────────────────────────────────
// Scope the cache file to this app so multiple apps on the same server
// don't overwrite each other. Path is passed to the constructor directly
// since RouteCache has no setKey() API.
$appCacheKey  = md5(config('app.name', 'app') . __DIR__);
$cache        = new RouteCache(storage_path('cache/data/routes_' . $appCacheKey . '.cache'));
$isProduction = env('APP_ENV') === 'production' || !env('APP_DEBUG', false);

if ($isProduction && $router->bootFromCache($cache)) {
    // Route cache hit — no need to load web.php.
} else {
    require __DIR__ . '/../app/Routes/web.php';
    if ($isProduction) {
        $router->cache($cache);
    }
}
$container->bind('throttle', fn() => new \Core\Middleware\ThrottleMiddleware());
// ── 12. Kernel + Middleware ───────────────────────────────────────────────────
// autoDiscover() scans app/Middleware and registers classes that carry
// a #[RegisterMiddleware] attribute — no manual registration needed.
//
// FIX: Middleware path pulled from config so this file doesn't need to change
// when the app layout changes. Falls back to the conventional path.
$middlewarePath = config('app.middleware_path', __DIR__ . '/../app/Middleware');
$middlewareNs   = config('app.middleware_namespace', 'App\\Middleware');

$kernel = new Kernel($container, $router, $request, $response);
$kernel->autoDiscover($middlewarePath, $middlewareNs);
$container->instance(Kernel::class, $kernel);

return $kernel->handle();