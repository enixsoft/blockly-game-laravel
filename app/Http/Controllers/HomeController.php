<?php

namespace App\Http\Controllers;

use App\Http\Traits\SinglePageApplicationTrait;

class HomeController extends Controller
{
    use SinglePageApplicationTrait;   

    /**
     * Shows the application home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return $this->viewResponse('home', []);
    }
}
