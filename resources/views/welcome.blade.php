<!DOCTYPE html>
<html lang="sk">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Blockly hra</title>

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">


    <!-- Bootstrap core CSS -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('vendor/simple-line-icons/css/simple-line-icons.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">

   
    <!-- Custom styles for this template
    RENAME AND MINIFY
     -->
    <link href="{{ asset('css/new-age.css') }}" rel="stylesheet">

  </head>

  <body id="page-top">

    @auth   
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
    @endauth

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top">BLOCKLY HRA</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          
          <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#features">O hre</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#game">Spustiť hru</a>
            </li>

        @auth             
        <li class="nav-item dropdown">          
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-user-circle"></i> {{ Auth::user()->username }}
          </a>        
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Odhlásiť sa</a>
          </div>
        </li>
        @endauth         
          </ul>
        </div>
      </div>
    </nav>

    <header class="masthead">
      <div class="container h-100">
        <div class="row h-100">
          <div class="col-lg-5 my-auto">
            <div class="header-content mx-auto">
              <h1 class="mb-5">Blockly hra vás uvedie do sveta programovania. <br> Na zariadení podľa vášho výberu.</h1>
              <a href="#game" class="btn btn-outline btn-xl js-scroll-trigger">Začnite hrať!</a>
            </div>
          </div>
          <div class="col-lg-7 my-auto">         
             <img src="{{ asset('img/devices-mockup.png') }}" class="img-fluid" alt="">
          </div>
        </div>
      </div>
    </header>

    <section class="features" id="features">
      <div class="container">
        <div class="section-heading text-center">
          <h2>Unlimited Features, Unlimited Fun</h2>
          <p class="text-muted">Check out what you can do with this app theme!</p>
          <hr>
        </div>
        <div class="row">
          <div class="col-lg-12 my-auto">
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-4">
                  <div class="feature-item">
                    <i class="icon-screen-smartphone text-primary"></i>
                    <h3>Device Mockups</h3>
                    <p class="text-muted">Ready to use HTML/CSS device mockups, no Photoshop required!</p>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="feature-item">
                    <i class="icon-camera text-primary"></i>
                    <h3>Flexible Use</h3>
                    <p class="text-muted">Put an image, video, animation, or anything else in the screen!</p>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="feature-item">
                    <i class="icon-lock-open text-primary"></i>
                    <h3>Open Source</h3>
                    <p class="text-muted">Since this theme is MIT licensed, you can use it commercially!</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-4">
                  <div class="feature-item">
                    <i class="icon-present text-primary"></i>
                    <h3>Free to Use</h3>
                    <p class="text-muted">As always, this theme is free to download and use for any purpose!</p>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="feature-item">
                    <i class="icon-lock-open text-primary"></i>
                    <h3>Open Source</h3>
                    <p class="text-muted">Since this theme is MIT licensed, you can use it commercially!</p>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="feature-item">
                    <i class="icon-lock-open text-primary"></i>
                    <h3>Open Source</h3>
                    <p class="text-muted">Since this theme is MIT licensed, you can use it commercially!</p>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="download bg-primary text-center" id="game">
      <div class="container">
        <div class="row">
          @guest
          <div class="col-md-12 mx-auto">
            <h2 class="section-heading">Prihlásenie</h2>
            <p>Pre spustenie hry je potrebné byť prihlásený.</p>
            
            <div class="form-group">   
            <form method="POST" id="loginForm" action="{{ route('login') }}">
                {{ csrf_field() }}  
            <div class="form-group {{ $errors->has('username') ? ' has-error' : '' }} col-md-6 mx-auto">
              <input class="form-control" placeholder="Prihlasovacie meno" id="username" type="username" name="username" value="{{ old('username') }}" required>             
               @if ($errors->has('username'))
               <span class="help-block">
               <strong>{{ $errors->first('username') }}</strong>
               </span>
               @endif
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} col-md-6 mx-auto">
               <input class="form-control" id="password" placeholder="Heslo" type="password" name="password" required>
               @if ($errors->has('password'))
               <span class="help-block">
               <strong>{{ $errors->first('password') }}</strong>
               </span>
               @endif                            
            </div>

            <div class="col-md-6 mx-auto">
              <label class="fancy-checkbox">
                <input type="checkbox" id="remember" {{ old('remember') ? 'checked' : '' }} />
                  <i class="fa fa-fw fa-square unchecked"></i>
                  <i class="fa fa-fw fa-check-square checked"></i>
                  Zapamätať
              </label>

            </div>
            <br>
            <div class="col-md-6 mx-auto">
               <button class="btn btn-lg btn-success" type="submit">
               Prihlásiť sa
               </button>
               <br>
            </div> 
          </form>  
        </div>
      </div>
        @endguest
        @auth
        <div class="col-md-12 mx-auto">
          <h2 class="section-heading">Prehľad úrovní</h2>
           <div class="table-responsive">
           <table class="table table-hover">
               <thead>
                  <tr>
                     <th scope="col">Úroveň</th>
                     <th scope="col">Postup</th>
                     <th scope="col">Spustiť</th>
                     <th scope="col">Pokračovať</th>
                  </tr>
               </thead>
               <tbody>
                  @for ($i = 1; $i <= 10; $i++)     
                  <tr>
                     <th scope="row">{{ $i }}</th>
                     <td>
                        <div class="progress" style="height: 2rem;">
                           <div class="progress-bar bg-success" role="progressbar" 
                              aria-valuenow="{{ isset($inGameProgress[$i-1] ) ? $inGameProgress[$i-1]['progress'] : 0 }}" aria-valuemin="0" 
                              aria-valuemax="100" style="width: {{ isset($inGameProgress[$i-1] ) ? $inGameProgress[$i-1]['progress'] : 0 }}%;">
                              <span style="text-align: center; font-weight: bold;">{{ isset($inGameProgress[$i-1] ) ? $inGameProgress[$i-1]['progress'] : 0 }}% </span>
                           </div>
                        </div>
                     </td>
                     <td><a href="{{ url('/')}}/start/1/{{$i}}"    class="btn btn-secondary btn-sm {{ isset($inGameProgress[$i-1]) && $inGameProgress[$i-1]['progress']==100 ? '' : 'disabled' }}">
                        SPUSTIŤ OD ZAČIATKU</a>
                     </td>
                     <td><a href="{{ url('/')}}/continue/1/{{$i}}" class="btn btn-secondary btn-sm {{ isset($inGameProgress[$i-1]) && $inGameProgress[$i-1]['progress']==100 ? '' : 'disabled' }}">
                        POKRAČOVAŤ V ULOŽENEJ HRE</a>
                     </td>
                     @endfor
               </tbody>
            </table>
          </div>
            <br>

            <div class="col-md-6 mx-auto">
               <a href="{{ url('/')}}/play" class="btn btn-lg btn-success">
               {{ isset($inGameProgress[0]) && $inGameProgress[0]['progress'] > 0 ? 'Pokračovať v hre' : 'Začať novú hru' }}
               </a>             
            </div>

          @if(Auth::user()->role == "admin")   
         
         <br>
         <div class="form-group">
         <h2 class="section-heading">Registrácia</h2>
            <form class="form-horizontal" method="POST" id="registrationForm" action="{{ route('registerforbetatest') }}">
            {{ csrf_field() }}
              
            <div class="form-group col-md-6 mx-auto">
              <input class="form-control" placeholder="Prihlasovacie meno" id="username" type="username" name="username" required>          
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} col-md-6 mx-auto">
               <input class="form-control" id="password" placeholder="Heslo" type="password" name="password" required>              
            </div>

            <br>
            <div class="col-md-6 mx-auto">
               <button class="btn btn-lg btn-success" type="submit">
                Registrácia
               </button>
               <br>
            </div> 
          </form>  
         </div>
         </div>
         
        @endif
        @endauth
        </div>
      </div>
    </section>


    <footer>
      <div class="container">
        <p>&copy; Martin Vančo 2019</p>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Plugin JavaScript -->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for this template -->
    <script src="{{ asset('js/new-age.min.js') }}"></script>

  </body>

</html>
