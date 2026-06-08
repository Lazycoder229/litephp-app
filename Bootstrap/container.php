<?php

/**
 * CLI Container Bootstrap
 *
 * Used exclusively by the `lite` CLI tool (Console Kernel).
 * HTTP requests go through Bootstrap/app.php instead.
 *
 * Register any additional service bindings needed by console commands here.
 * The Database binding is included by default so commands that run queries
 * (migrate, seed, etc.) work out of the box.
 *
 * @return \Core\Container
 */

use Core\Container;

$container = new Container();

// Database — resolved lazily so commands that don't need the DB
// don't pay the connection cost.
$container->bind(Core\Database::class, function () {
    return new Core\Database();
});

return $container;
