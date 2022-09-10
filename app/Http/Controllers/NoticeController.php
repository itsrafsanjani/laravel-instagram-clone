<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function __invoke($notice)
    {
        return view('notices.'. $notice);
    }
}
