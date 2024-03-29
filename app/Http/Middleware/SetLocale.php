<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class SetLocale
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
        $routeName = $request->route()->getName();

        if (! $routeName) {
            return $next($request);
        }

        $section = explode('.', $routeName)[0];

        if ($section === 'front') {
            $locale = $request->segment(1);

            if (! in_array($locale, config('translatable.locales'))) {
                return redirect()->to(
                    collect($request->segments())
                        ->prepend(config('app.locale'))
                        ->implode('/')
                );
            }

            app()->setLocale($locale);
        } elseif (auth()->check()) {
            app()->setLocale(
                in_array(auth()->user()->locale, config('translatable.locales'))
                    ? auth()->user()->locale
                    : config('app.locale')
            );
        }

        return $next($request);
    }
}
