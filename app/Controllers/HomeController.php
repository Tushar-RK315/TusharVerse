<?php

declare(strict_types=1);

namespace TusharRk315\Tusharverse\Controllers;

use TusharRk315\Tusharverse\Core\Controller;

class HomeController extends Controller
{
    public function index(): void
    {
        $this->view('home/index');
    }

    public function about(): void
    {
        $this->view('home/about');
    }

    public function projects(): void
    {
        $this->view('home/projects');
    }

    public function project(string $id): void
    {
        echo "Project ID: " . $id;
    }
}