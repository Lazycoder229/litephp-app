<?php

namespace App\Controllers;

use Core\Controller;

class HomeController extends Controller
{
    public function index(): never
    {
        view('home');
    }

    public function demo(): never
    {
        flash('success', 'Welcome to LitePHP!');
        redirect('/');
    }

    public function demoError(): never
    {
        flash('error', 'Something went wrong!');
        redirect('/');
    }

    public function demoWarning(): never
    {
        flash('warning', 'Please double check your input.');
        redirect('/');
    }

    public function demoInfo(): never
    {
        flash('info', 'Here is some useful information.');
        redirect('/');
    }
}