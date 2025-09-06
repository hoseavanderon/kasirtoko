<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home'); 
    }

    public function loadPartial($page)
    {
        if (view()->exists("partials.$page")) {
            return view("partials.$page");
        }

        return response('Page not found', 404);
    }
}