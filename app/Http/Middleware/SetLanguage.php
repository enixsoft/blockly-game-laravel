<?php

namespace App\Http\Middleware;

use Closure;
use Cookie;
use App;
use Crypt;

class SetLanguage
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
        $supportedLocales = ['en', 'sk'];
        $cookie = Cookie::get('lang');
        $lang = 'en';
        
        if (empty($cookie)) {
            Cookie::queue(Cookie::make('lang', $lang, '20160'));            
        }
        else 
        {        
            $lang = $cookie;

            if (!in_array($lang, $supportedLocales)) 
            {
                $lang = 'en';
                Cookie::queue(Cookie::make('lang', $lang, '20160'));
            }            
        }

        App::setLocale($lang);
        return $next($request);
    }
}
