<?php

declare(strict_types=1);

namespace TusharRk315\Tusharverse\Controllers;

use TusharRk315\Tusharverse\Core\Controller;
use TusharRk315\Tusharverse\Core\Session;
use TusharRk315\Tusharverse\Core\Response;

class HomeController extends Controller
{
    public function index(): void
    {
        if (!Session::has('user')) {
            (new Response())->redirect('/login');
            return;
        }

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