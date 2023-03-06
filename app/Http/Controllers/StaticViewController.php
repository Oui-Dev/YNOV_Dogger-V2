<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class HomeController extends Controller
{
    public function homepage() {
        return Inertia::render('Homepage');
    }
}
