@section('layout')
<body>
<header>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.html">Blockly<span> Hra</span></a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="">Odkaz 1</a></li>
          <li><a href="">Odkaz 2</a></li>
          <li><a href="">Odkaz 3</a></li>
          <li><a href="">Odkaz 4</a></li>
          @guest
          <li class="btn-trial"><a href="#" data-target="#loginModal" data-backdrop="static"  data-toggle="modal">Prihlásiť sa</a></li>
          @endguest
          @auth
          <li class="dropdown">

           
                <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">
                  <i class="fa fa-user-circle" aria-hidden="true"></i>  
                  {{ Auth::user()->username }}  
                  <span class="caret"></span></a>
                <ul class="dropdown-menu" style="left: 50%; right: auto;text-align: center;
                transform: translate(-50%, 0);">
                    <li><a href="#"><b>Profil</b></a></li>
                    <li class="divider"></li>
                    <li><a href="#"><b>Odkaz</b></a></li>
                    <li class="divider"></li>                    
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                      <b>Odhlásiť sa</b></a></li>
                </ul>
            

          </li>
          @endauth
        </ul>
      </div>
    </div>
  </nav>

@auth   
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
@endauth

<div class="modal fade" id="loginModal" role="dialog">
    <div class="modal-dialog modal-sm">      
      <div class="modal-content">       
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-center form-title">Prihlásenie</h4>
        </div>
        <div class="modal-body padtrbl">

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
                  <div class="col-xs-12">
                    <div class="checkbox icheck">
                      <label>
                                <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}> Zapamätať 
                      </label>
                    </div>
                  </div>
                  <div class="col-xs-12">
                   
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
</header>
@yield('content')

<footer id="footer" class="footer">
    <div class="container text-center">     

     
      ©2018
      <div class="credits">
       
        Designed by </a>
      </div>
    </div>
  </footer>

  <script src="js/jquery.min.js"></script>
  <script src="js/jquery.easing.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/custom.js"></script>

@if ($errors->all())  
<script type="text/javascript">
  $(document).ready(function () {
    $('#loginModal').modal('show');
    });
</script>        
@endif 

</body>
</html>
@show