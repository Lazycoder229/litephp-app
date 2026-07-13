<?php

declare(strict_types=1);

namespace App\Middleware\Web;

use Core\Middleware\Middleware;
use Core\Http\Request;
use Core\Http\Response;
use Core\Session;
use Core\Middleware\Attributes\RegisterMiddleware;

/**
 * AuthMiddleware
 *
 * Protects routes that require an authenticated user.
 * Attach to any route or group using the 'auth' alias:
 *
 *   Route::get('/dashboard', [DashboardController::class, 'index'])
 *       ->middleware('auth');
 *
 *   Route::group(['middleware' => ['auth']], function () {
 *       Route::get('/profile', [UserController::class, 'show']);
 *   });
 *
 * Behaviour:
 *   - JSON / AJAX requests  → 401 Unauthorized JSON response.
 *   - Browser requests      → redirect to /login.
 */
#[RegisterMiddleware(group: 'web', alias: 'auth')]
class AuthMiddleware implements Middleware
{
    /**
     * Handle the incoming request.
     *
     * @param Request  $request
     * @param Response $response
     * @param callable $next
     * @return mixed
     */
    public function handle(Request $request, Response $response, callable $next): mixed
    {
        if (!Session::isLoggedIn()) {
            if ($request->isJson() || $request->isAjax()) {
                $response->json(['message' => 'Unauthenticated.'], 401);
                exit;
            }

            return $response->redirect('/login');
        }

        return $next($request, $response);
    }
}
