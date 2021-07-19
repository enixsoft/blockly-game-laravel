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
       
        // dd(compact('view', 'data', 'user', 'lang'));
        
        return view("vue", compact('viewName', 'viewData', 'user', 'lang'));
    }

    public function jsonDataResponse(String $view, Array $data)
    {
        // if(empty($data))
        // {
        //     return response()->json(['error' => 'Internal Server Error'], 500);
        // }
        return response()->json(['viewName' => $view, 'viewData' => $data]);
    }

    public function redirectHomeResponse()
    {	       
        return redirect()->route('');
    }

    public function processRequest(String $view, Array $data, Request $request, $redirectToRoute = null)
    {
        if ($request->expectsJson())
        {
            return $this->jsonDataResponse($view, $data);
		}

        if($redirectToRoute)
        {
            return redirect()->route($redirectToRoute);            
        }
        return $this->viewResponse($view, $data);
    }
}