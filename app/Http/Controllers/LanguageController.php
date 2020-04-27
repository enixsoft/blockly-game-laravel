<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use App;

class LanguageController extends Controller
{
    public function setLanguage($lang, Request $request) {

    $supportedLocales = ['en', 'sk'];

    if (!in_array($lang, $supportedLocales)) 
    {
        $lang = 'en';
    }
    
    Cookie::queue(Cookie::make('lang', $lang, '20160'));

    if (!$request->expectsJson()) 
    {
        return redirect()->route('/');
    }

    }
}