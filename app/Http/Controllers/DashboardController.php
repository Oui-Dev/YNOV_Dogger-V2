<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class DashboardController extends Controller
{
    public function homepage() {
        return Inertia::render('Dashboard/Index');
    }
}
