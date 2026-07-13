<?php
// app/Controllers/HomeController.php
namespace App\Controllers;

// walang use statement na kailangan — same namespace na
class HomeController extends Controller
{
    public function index(): never
    {
        $this->view('home');
    }

    public function user(): never
    {
        $this->view('home');
    }
    public function reports(): never
    {
        $this->view('home');
    }

    public function settings(): never
    {
        $this->view('home');
    }

    public function cart(): never
    {
        $this->view('home');
}
}