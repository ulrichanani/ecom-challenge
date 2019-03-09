<?php

namespace App\Http\Middleware;

use Closure;

class ShoppingCartMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        \View::share('CART', \App\Models\ShoppingCart::getCartItems());
        return $next($request);
    }
}
