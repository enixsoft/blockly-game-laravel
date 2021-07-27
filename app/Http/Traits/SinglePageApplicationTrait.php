<?php
namespace App\Http\Traits;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

trait SinglePageApplicationTrait
{
    public function viewResponse(String $viewName, Array $viewData)
    {
        $viewData = json_encode($viewData);
        $user = json_encode(Auth::check() ? Auth::user() : null);       
        $lang = Storage::get("public/game/locales/". App::getLocale() .".json");
        
        return view("vue", compact('viewName', 'viewData', 'user', 'lang'));
    }

    public function jsonDataResponse(String $view, Array $data)
    {
        return response()->json(['viewName' => $view, 'viewData' => $data]);
    }

    public function successApiResponse() {
        return response('', 204);
    }

    public function redirectToRoute($routeName, $routeParameters, Request $request) {
        return redirect()->route($routeName, $routeParameters, 302, $request->headers->all());
    }

    public function processRequest(String $view, Array $data, Request $request)
    {
        if ($request->expectsJson())
        {
            return $this->jsonDataResponse($view, $data);
		}

        return $this->viewResponse($view, $data);
    }
}