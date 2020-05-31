<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    public function setLanguage($lang, Request $request) 
    {
        $supportedLocales = ['en', 'sk'];

        if (!in_array($lang, $supportedLocales)) 
        {
            $lang = config('app.locale');
        }
        
        Cookie::queue(Cookie::make('lang', $lang, '20160'));

        if (!$request->expectsJson()) 
        {
            return redirect(RouteServiceProvider::HOME);
        }

    }
}