<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class LocaleMiddleware
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
        App::setLocale(
            in_array(auth()->user()->locale, config('translatable.locales'))
                ? auth()->user()->locale
                : config('app.locale')
        );

        return $next($request);
    }
}
