<?php

declare(strict_types=1);

namespace App\Middleware\Global;

use Core\Middleware\Middleware;
use Core\Http\Request;
use Core\Http\Response;
use Core\Middleware\Attributes\RegisterMiddleware;

/**
 * LogRequestMiddleware
 *
 * Logs every incoming HTTP request to the application log.
 * Runs globally on all requests before any route-specific middleware.
 *
 * Log output (storage/logs/app-YYYY-MM-DD.log):
 *   [2025-01-01 12:00:00] INFO: Incoming request → {"method":"GET","path":"/"}
 *
 * To disable request logging, remove this middleware from the 'global' group
 * or delete this file. Middleware is auto-discovered via #[RegisterMiddleware].
 *
 * To add more context (user ID, IP, request time), extend the $context array:
 *   'ip'      => $request->ip(),
 *   'user_id' => auth_id(),
 */
#[RegisterMiddleware(group: 'global', alias: 'log-request')]
class LogRequestMiddleware implements Middleware
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
        log_message('INFO', 'Incoming request', [
            'method' => $request->method(),
            'path'   => $request->path(),
        ]);

        return $next($request, $response);
    }
}
