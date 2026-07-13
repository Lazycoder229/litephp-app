<?php

/**
 * Web Routes
 *
 * Define your application's HTTP routes here.
 * Routes are loaded by Bootstrap/app.php on every request.
 *
 * Available HTTP methods:
 *   Route::get($path, $action)
 *   Route::post($path, $action)
 *   Route::put($path, $action)
 *   Route::patch($path, $action)
 *   Route::delete($path, $action)
 *
 * Action formats:
 *   [ControllerClass::class, 'method']  — controller action
 *   function (Request $req, Response $res) { ... }  — closure
 *
 * Route groups with shared prefix and middleware:
 *   Route::group(['prefix' => '/admin', 'middleware' => ['auth']], function () {
 *       Route::get('/dashboard', [AdminController::class, 'dashboard']);
 *   });
 *
 * Named routes (for url generation):
 *   Route::get('/profile', [UserController::class, 'show'])->name('profile');
 *   // then use: route('profile')
 *
 * Route-level middleware:
 *   Route::post('/login', [AuthController::class, 'login'])->middleware('throttle');
 */

use App\Controllers\HomeController;
use Core\Facades\Route;
use Core\Http\Request;
use Core\Http\Response;

// ── Public routes ─────────────────────────────────────────────────────────────




// ── Routes ────────────────────────────────────────────────
// web.php
Route::get('/', [HomeController::class, 'index']);
