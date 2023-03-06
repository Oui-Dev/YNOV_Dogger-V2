<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class StaticViewController extends Controller
{
    public function homepage() {
        return Inertia::render('Homepage');
    }
}
