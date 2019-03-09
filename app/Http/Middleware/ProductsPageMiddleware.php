<?php

namespace App\Http\Middleware;

use Closure;

class ProductsPageMiddleware
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
        \Session::put('PRODUCTS_PAGE', $request->url());
        return $next($request);
    }
}
