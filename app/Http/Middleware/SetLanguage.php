<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('language')) {
            $locale = session()->get('language');
        } else {
            $locale = config('app.locale');
        }

        App::setLocale($locale);
        $request->session()->put('language', $locale);

        return $next($request);
    }
}
