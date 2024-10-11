<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfUserHasNotBasicSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Change the price_xxxxxxxxxxxx to the price id of your basic subscription
        if (!auth()->user()->subscribedToPrice('price_xxxxxxxxxxxx')) {
            return redirect()->route('subscription.create');
        }
        return $next($request);
    }
}
