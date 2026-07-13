<?php
// app/Controllers/Controller.php
namespace App\Controllers;

use Core\View\Components\ViewFactory;

abstract class Controller extends \Core\Controller // ← FQCN, walang use
{
    protected function view(string $view, array $data = []): never
    {
        $merged = array_merge(ViewFactory::getShared(), $data);
        parent::view($view, $merged);
        exit;
    }
}