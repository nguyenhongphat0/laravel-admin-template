<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class LanguageMiddleware
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
        $language = Session::get('language', config('app.locale'));

        switch ($language) {
            case 'en':
                $language = 'en';
                break;

            default:
                $language = 'ko';
                break;
        }

        app()->setLocale($language);

        return $next($request);
    }
}
