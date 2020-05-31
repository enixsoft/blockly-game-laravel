<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use GeoIP;

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
        $lang = config('app.locale');
        
        if (empty($cookie)) 
        {
            $userIp = $request->ip();
            $geo = GeoIP::getLocation($userIp);

            if($geo != null) 
            {
                $userCountry = $geo['iso_code'];       

                $countryCodeLocales = [
                    'SK' => 'sk',
                    'CZ' => 'sk'
                ];  

                if (array_key_exists($userCountry, $countryCodeLocales)) {
                    $lang = $countryCodeLocales[$userCountry];
                }
            }  

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
