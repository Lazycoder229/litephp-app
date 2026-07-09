<?php

declare(strict_types=1);

namespace App\Middleware\Api;

use Core\Middleware\Middleware;
use Core\Http\Request;
use Core\Http\Response;
use Core\Middleware\Attributes\RegisterMiddleware;

/**
 * ApiMiddleware
 *
 * Applied to all routes in the 'api' group.
 * Enforces that API requests send a JSON Content-Type header.
 *
 * Apply to a route group:
 *   Route::group(['prefix' => '/api', 'middleware' => ['api']], function () {
 *       Route::get('/users', [UserController::class, 'index']);
 *   });
 *
 * Extend this middleware to add:
 *   - API token / Bearer token validation
 *   - API versioning checks
 *   - Rate limiting for API consumers
 */
#[RegisterMiddleware(group: 'api')]
class ApiMiddleware implements Middleware
{
    /**
     * Handle the incoming request.
     *
     * Rejects non-JSON requests with 406 Not Acceptable.
     *
     * @param Request  $request
     * @param Response $response
     * @param callable $next
     * @return mixed
     */
    public function handle(Request $request, Response $response, callable $next): mixed
    {
        if (!$request->isJson()) {
            return $response->json([
                'message' => 'API requests must include a JSON Content-Type header.',
            ], 406);
        }

        return $next($request, $response);
    }
}
