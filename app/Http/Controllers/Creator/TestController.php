<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class TestController extends Controller
{
    public function index()
    {
        return Inertia::render('Creator/Test/Index');
    }
}
