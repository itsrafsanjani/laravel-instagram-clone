<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SendCoinController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function __invoke(Request $request)
    {
        return $request->all();
    }
}
