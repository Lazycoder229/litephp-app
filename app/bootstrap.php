<?php
// app/bootstrap.php

/**
 * Bootstrap the application by sharing data to all views.
 * This file is loaded in public/index.php before the framework's
 * 
 */
use Core\View\Components\ViewFactory;

ViewFactory::share([
    'navLinks' => [
        ['href' => '/',         'label' => 'Dashboard'],     
    ],
]);