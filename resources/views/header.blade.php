@section('header')
<header>
    <nav class="navbar navbar-default py-md-0 fixed-top navbar-expand-sm py-0">
        <div class="container">
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#myNavbar">&#x2630;</button> 
            <a class="navbar-brand" href="{{ route('/') }}">Blockly<span> Hra</span></a>
            <div
            class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item py-0"><a href="" class="nav-link">Odkaz 1</a>
                    </li>
                    <li class="nav-item py-0"><a href="" class="nav-link">Odkaz 2</a>
                    </li>
                    <li class="nav-item py-0"><a href="" class="nav-link">Odkaz 3</a>
                    </li>
                    <li class="nav-item py-0"><a href="" class="nav-link">Odkaz 4</a>
                    </li>
                    @guest
                    <li class="btn-trial nav-item py-0"><a href="#" data-target="#loginModal" data-backdrop="static" data-toggle="modal"
                        class="nav-link">Prihlásenie</a>
                    </li>
                    @endguest 
                    @auth
                    <li class="dropdown nav-item py-0"> <a class="btn btn-outline-success dropdown-toggle" data-toggle="dropdown"
                        href="#">

                  <i class="fa fa-user-circle" aria-hidden="true"></i>  

                  {{ Auth::user()->username }}  

                  <span class="caret"></span></a>

                        <div class="dropdown-menu"
                        style="left: 50%; right: auto;text-align: center;
                transform: translate(-50%, 0);">                
                            <a class="dropdown-item" href="#"><b>Profil</b></a>
                            
                           
                            <a class="dropdown-item" href="#"><b>Odkaz</b></a>
                           
                         
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

                      <b>Odhlasit sa</b></a>
                            @endauth
                    </li>      
                 </ul>
                   



                
        </div>
        </div>
    </nav>
</header> 
@show