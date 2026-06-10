<?php

use Core\Container;

$container = new Container();

// Register the database singleton so CLI commands can call app('Core\Database')
$container->singleton(\Core\Database::class, fn() => new \Core\Database());

// Also register the alias string so app('Core\Database') resolves correctly
$container->alias('Core\Database', \Core\Database::class);

return $container;