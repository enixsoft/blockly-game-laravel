@section('header')
<header>
    <nav class="navbar navbar-default py-md-0 fixed-top navbar-expand-sm py-0">
        <div class="container">
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#myNavbar">&#x2630;</button> 
            <a class="navbar-brand" href="{{ route('/') }}">Blockly<span> Hra</span></a>
            <div
            class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav ml-auto">
               
            
                    @auth
                    <li class="nav-item py-0"> <a class="nav-link">

                  <i class="fa fa-user-circle" aria-hidden="true"></i>  

                  {{ Auth::user()->username }}  

                  <span class="caret"></span></a>
                    </li> 
                      
              
                      <li class="btn-trial nav-item py-0"><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                        class="nav-link"> <i class="fa fa-sign-out" aria-hidden="true"></i> Odhlásiť sa</a></li>                   
                            @endauth
                   
                 </ul>
                   



                
        </div>
        </div>
    </nav>
</header> 

@auth   
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
@endauth

@show