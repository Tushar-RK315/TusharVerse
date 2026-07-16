<?php

declare(strict_types=1);

namespace TusharRk315\Tusharverse\Controllers;

use TusharRk315\Tusharverse\Core\Controller;

class DashboardController extends Controller
{
    public function index(): void
    {
        $this->view('dashboard/index');
    }
}
