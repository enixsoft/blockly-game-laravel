<?php

namespace App\Http\Controllers;

use App\Http\Traits\SinglePageApplicationTrait;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use SinglePageApplicationTrait;   

    /**
     * Shows the application home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return $this->processRequest('home', [], $request);
    }
}
