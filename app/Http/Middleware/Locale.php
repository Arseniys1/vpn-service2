<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class Locale
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
        if (Auth::check()) {
            App::setLocale(Auth::user()->locale);
        } elseif ($request->route('locale') == null) {
            App::setLocale(config('app.locale'));
        } else {
            $locales = [
                'en',
                'ru',
            ];

            if (array_search($request->route('locale'), $locales) !== false) {
                App::setLocale($request->route('locale'));
            } else {
                App::setLocale(config('app.locale'));
            }
        }

        return $next($request);
    }
}
