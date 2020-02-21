<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class HomeController extends Controller
{

    /**
     * Show the application homepage.
     *
     * @return Inertia
     */
    public function homepage()
    {
        return Inertia::render('Welcome')->withViewData(['title' => 'Free Online Test - Ujian Online Gratis']);
    }

    /**
     * Show the application dashboard.
     *
     * @return Inertia
     */
    public function dashboard()
    {
        return Inertia::render('Home');
    }
}
