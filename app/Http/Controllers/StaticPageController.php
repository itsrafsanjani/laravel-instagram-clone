<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    public function __invoke($page)
    {
        return view('static-pages.'. $page);
    }
}
