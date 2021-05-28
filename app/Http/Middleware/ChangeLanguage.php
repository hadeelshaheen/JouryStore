<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ChangeLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
//    public function handle(Request $request, Closure $next)
//    {
//        app()->setLocale('en');
//
//        if (isset($request->lang) && $request->lang == 'ar') {
//            app()->setLocale('ar');
//        }
//        return $next($request);
//    }


    public function handle($request, Closure $next)
    {
        // Check header request and determine localizaton
        $local = ($request->hasHeader('lang')) ? $request->header('lang') : ‘en’;
        // set laravel localization
        app()->setLocale($local);
        // continue request
        return $next($request);
    }


}
