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
@auth   
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
@endauth

<div class="modal fade" id="loginModal" role="dialog">
    <div class="modal-dialog modal-md">      
      <div class="modal-content">       
        <div class="modal-header">
          <h4 class="modal-title text-center form-title">Prihlásenie</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">

          <div class="login-box-body">
           
            <div class="form-group">
              
              <form method="POST" id="loginForm" action="{{ route('login') }}">
                 {{ csrf_field() }}

               
                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">                   
                  <input class="form-control" placeholder="Prihlasovaci email" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>             
                 
                    @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif

                  </div>             


                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            
                                <input id="password" placeholder="Heslo" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif                            
                </div>



                <div class="row">
                  <div class="col-4 mx-auto">
                    <div class="checkbox icheck">
                      <label>
                                <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}> Zapamätať 
                      </label>
                    </div>
                  </div>
                  <div class="col-md-12">
                   
                    <button class="btn btn-green btn-block btn-flat" type="submit">
                      Prihlásiť sa
                    </button>
                    <br>
                    <p class="login-box-msg"><a href="{{ url('/registration') }}">Nová registrácia</a></p>

                  </div>
                </div>
              </form>              
                   

            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  
@show