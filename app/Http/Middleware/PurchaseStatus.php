<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PurchaseStatus
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
        if (
            ! in_array(request()->server('REMOTE_ADDR'), ['127.0.0.1', '::1']) &&
            ! preg_match(
                '/^([a-f0-9]{8})-(([a-f0-9]{4})-){3}([a-f0-9]{12})$/i',
                config('services.envato.purchase_code')
            )) {
            return redirect()->route('purchase.index');
        }

        return $next($request);
    }
}
