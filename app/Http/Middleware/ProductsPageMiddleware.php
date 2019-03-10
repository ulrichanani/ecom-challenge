<?php

namespace App\Http\Middleware;

use Closure;

class ProductsPageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $url = $request->url();
        if (str_contains($url, ['categories', 'departements']))
            \Session::put('PRODUCTS_PAGE', $url);

        return $next($request);
    }
}
