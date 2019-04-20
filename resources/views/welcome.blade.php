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
      <!-- Custom styles for this template -->
      <link href="{{ asset('css/new-age.min.css') }}" rel="stylesheet">
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
            <div id="carousel"  class="carousel slide w-100" data-ride="carousel" data-interval="8000" data-pause="hover">
               <ul class="carousel-indicators">
                  <li data-target="#carousel" data-slide-to="0" class="active"></li>
                  <li data-target="#carousel" data-slide-to="1"></li>
                  <li data-target="#carousel" data-slide-to="2"></li>
               </ul>
               <div class="carousel-inner h-100" style="text-align: center;">
                  <div class="carousel-item active h-100" >
                     <div class="d-flex flex-column h-100 align-items-center justify-content-center">
                        <h1> Blockly hra. <br> Váš úvod do sveta programovania. </h1>
                        <a href="#game" class="btn btn-outline btn-xl js-scroll-trigger">Začnite hrať!</a>   
                        <img class="img-fluid" src="{{ asset('img/carousel-1.png') }}">
                     </div>
                  </div>
                  <div class="carousel-item h-100">
                     <div class="d-flex flex-column h-100 align-items-center justify-content-center">
                        <h1> 10 úrovní. <br> Viac ako 40 úloh na riešenie. </h1>
                        <a href="#game" class="btn btn-outline btn-xl js-scroll-trigger">Začnite hrať!</a>   
                        <img class="img-fluid" src="{{ asset('img/carousel-2.png') }}">
                     </div>
                  </div>
                  <div class="carousel-item h-100">
                     <div class="d-flex flex-column h-100 align-items-center justify-content-center">
                        <h1> Tvorte algoritmy. <br> S príkazmi v cykloch a podmienkach.</h1>
                        <a href="#game" class="btn btn-outline btn-xl js-scroll-trigger">Začnite hrať!</a>   
                        <img class="img-fluid" src="{{ asset('img/carousel-3.png') }}">
                     </div>
                  </div>
                  <a class="carousel-control-prev" href="#carousel" data-slide="prev">
                  <span class="carousel-control-prev-icon"></span>
                  </a>
                  <a class="carousel-control-next" href="#carousel" data-slide="next">
                  <span class="carousel-control-next-icon"></span>
                  </a>
               </div>
            </div>
         </div>
      </header>
      <section class="features" id="features">
         <div class="container">
            @guest
            <div class="section-heading text-center">
               <h2>Hra ovládaná programovaním</h2>
               <p class="text-muted">Google Blockly prináša vizuálny editor blokov, ktoré sa premieňajú na kód. Po odoslaní do hry z neho vznikajú príkazy vykonávané hrdinom.</p>
               <hr>
            </div>
            <div class="row">
               <div class="col-lg-12 my-auto">
                  <div class="container-fluid">
                     <div class="row">
                        <div class="col-lg-4">
                           <div class="feature-item">
                              <i class="icon-screen-desktop text-primary"></i>
                              <h3>Responzívny návrh</h3>
                              <p class="text-muted">Hra sa prispôsobí vášmu rozlíšeniu.</p>
                           </div>
                        </div>
                        <div class="col-lg-4">
                           <div class="feature-item">
                              <i class="icon-cloud-upload text-primary"></i>
                              <h3>Účet hráča</h3>
                              <p class="text-muted">Postup hráča v úrovniach sa automaticky ukladá do databázy.</p>
                           </div>
                        </div>
                        <div class="col-lg-4">
                           <div class="feature-item">
                              <i class="icon-clock text-primary"></i>
                              <h3>Meranie času</h3>
                              <p class="text-muted">Dĺžka trvania riešenia úloh je zaznamenávaná.</p>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-lg-4">
                           <div class="feature-item">
                              <i class="icon-star text-primary"></i>
                              <h3>Hodnotenie</h3>
                              <p class="text-muted">Riešenia úrovní sú hodnotené a je nutné dodržiavať zadanie.</p>
                           </div>
                        </div>
                        <div class="col-lg-4">
                           <div class="feature-item">
                              <i class="icon-grid text-primary"></i>
                              <h3>PlayCanvas</h3>
                              <p class="text-muted">Herná časť je postavená na webovom hernom engine PlayCanvas.</p>
                           </div>
                        </div>
                        <div class="col-lg-4">
                           <div class="feature-item">
                              <i class="icon-globe text-primary"></i>
                              <h3>Webová téma</h3>
                              <p class="text-muted">Pre webovú stránku bola použitá téma New Age založená na Bootstrap 4.</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            @endguest
            @auth
            <div class="section-heading text-center">
               <h2>Vitajte v Blockly hre!</h2>
               <p class="text-muted">Pomocou spájania programovacích blokov v nej budete ovládať hrdinu bojovníka. Ten prišiel na výpravu do starého hradu a aby ho prešiel celý, musí prekonať množstvo prekážok a splniť mnoho úloh. Prezrite si hrdinu a popis jeho schopností, ktoré postupne získa a budete používať.</p>
               <hr>
            </div>
            <div class="row">
               <div class="col-lg-12 my-auto">
                  <div class="container-fluid">
                     <div class="row text-center">
                        <div class="col-lg-6">
                           <img class="img-fluid" src="{{asset('img/character.png')}}">
                        </div>
                        <div class="col-lg-6">
                           <div class="row">
                              <div class="col-lg-6">
                                 <h3>Preskočí prekážky</h3>
                                 <img src="{{asset('img/thumbnail1.png')}}" class="img-thumbnail">
                                 <p class="text-muted">Keď je v ceste voda alebo nastražená pasca, hrdina ich často dokáže preskočiť a pokračovať ďalej.</p>
                              </div>
                              <div class="col-lg-6">
                                 <h3>Zničí veci</h3>
                                 <img src="{{asset('img/thumbnail2.png')}}" class="img-thumbnail">
                                 <p class="text-muted">V ruinách hradu sa nachádza veľa starých vecí ako sú krabice, sudy a vázy, ktoré hrdinov meč dokáže zničiť a uvoľniť cestu.</p>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-lg-6">
                                 <h3>Otvára truhlice</h3>
                                 <img src="{{asset('img/thumbnail3.png')}}" class="img-thumbnail">
                                 <p class="text-muted">Niekedy hrdina potrebuje prehľadať truhlice, aby našiel kľúč od zamknutých dverí.</p>
                              </div>
                              <div class="col-lg-6">
                                 <h3>Používa páky</h3>
                                 <img src="{{asset('img/thumbnail4.png')}}" class="img-thumbnail">
                                 <p class="text-muted">Keď treba otvoriť padacie dvere alebo zneškodniť pasce, hrdina použije páku.</p>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            @endauth
         </div>
      </section>
      <section class="download bg-primary text-center" id="game">
         <div class="container">
            <div class="row">
               @guest
               <div class="collapse show multi-collapse col-md-12 mx-auto" id="loginDiv">
                  <h2 class="section-heading">Prihlásenie</h2>
                  <p>Pre spustenie hry je potrebné byť prihlásený.</p>
                  <div class="form-group">
                     <form method="POST" id="loginForm" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <div class="form-group row {{ $errors->has('username') ? ' has-error' : '' }} col-md-6 mx-auto">
                           <label for="login-username" class="col-md-12">Prihlasovacie meno:</label>
                           <input class="form-control" id="login-username" type="username" name="login-username" value="{{ old('login-username') }}" required> @if ($errors->has('username'))
                           <span class="help-block mx-auto" style="color:red;">
                           <strong>{{ $errors->first('username') }}</strong>
                           </span> @endif
                        </div>
                        <div class="form-group row {{ $errors->has('password') ? ' has-error' : '' }} col-md-6 mx-auto">
                           <label for="login-password" class="col-md-12">Heslo:</label>
                           <input class="form-control" id="login-password" type="password" name="login-password" autocomplete="current-password" required> @if ($errors->has('password'))
                           <span class="help-block mx-auto" style="color:red;">
                           <strong>{{ $errors->first('password') }}</strong>
                           </span> @endif
                        </div>
                        <div class="col-md-6 mx-auto">
                           <label class="fancy-checkbox">
                           <input type="checkbox" id="remember" {{ old( 'remember') ? 'checked' : '' }} />
                           <i class="fa fa-fw fa-square unchecked"></i>
                           <i class="fa fa-fw fa-check-square checked"></i> Zapamätať
                           </label>
                        </div>
                        <br>
                        <div class="col-md-6 mx-auto">
                           <button class="btn btn-lg btn-success" type="submit">
                           Prihlásiť sa
                           </button>
                        </div>
                        <br>
                        <div class="col-md-6 mx-auto">
                           <p>
                              Nemáte ešte účet?
                              <a class="btn btn-link" data-toggle="collapse" href="" data-target=".multi-collapse">
                              Zaregistrujte sa.
                              </a>
                           </p>
                        </div>
                     </form>
                  </div>
               </div>
               <div class="collapse multi-collapse col-md-12 mx-auto" id="registerDiv">
                  <h2 class="section-heading">Registrácia</h2>
                  <p>Vyplňte všetky polia. Po registrácii budete automaticky prihlásení.</p>
                  <div class="form-group">
                     <form method="POST" id="registerForm" action="{{ route('register') }}">
                        {{ csrf_field() }}
                        <div class="form-group {{ $errors->register->has('username') ? ' has-error' : '' }} col-md-6 mx-auto">
                           <label for="username" class="col-md-12">Prihlasovacie meno:</label>
                           <input class="form-control" id="username" type="username" name="username" value="{{ old('username') }}" required> @if ($errors->register->has('username'))
                           <span class="help-block mx-auto" style="color:red;">
                           <strong>{{ $errors->register->first('username') }}</strong>
                           </span> @endif
                        </div>
                        <div class="form-group {{ $errors->register->has('email') ? ' has-error' : '' }} col-md-6 mx-auto">
                           <label for="email" class="col-md-12">E-mail:</label>
                           <input class="form-control" id="email" type="email" name="email" value="{{ old('email') }}" required> @if ($errors->register->has('email'))
                           <span class="help-block mx-auto" style="color:red;">
                           <strong>{{ $errors->register->first('email') }}</strong>
                           </span> @endif
                        </div>
                        <div class="form-group {{ $errors->register->has('password') ? ' has-error' : '' }} col-md-6 mx-auto">
                           <label for="password" class="col-md-12">Heslo: </label>
                           <input id="password" autocomplete="new-password" type="password" class="form-control" name="password" required> @if ($errors->register->has('password'))
                           <span class="help-block mx-auto" style="color:red;">
                           <strong>{{ $errors->register->first('password') }}</strong>
                           </span> @endif
                        </div>
                        <div class="form-group col-md-6 mx-auto">
                           <label for="password_confirmation" class="col-md-12">Zopakujte heslo: </label>
                           <input id="password_confirmation" type="password" autocomplete="new-password" class="form-control" name="password_confirmation" required>
                        </div>
                       <div class="form-group g-recaptcha" data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}" style="margin: 0 auto;display: table">     
                       </div>
                        @if ($errors->register->has('g-recaptcha-response'))
                           <div class="help-block mx-auto" style="color:red;">
                           <strong>{{ Lang::get('validation.recaptcha') }}</strong>
                           </div>
                        @endif                          
                        <br>
                        <div class="col-md-6 mx-auto">
                           <button class="btn btn-lg btn-success" type="submit">
                           Zaregistrovať sa
                           </button>
                        </div>
                        <br>
                        <div class="col-md-6 mx-auto">
                           <p>
                              Máte už účet?
                              <a class="btn btn-link" data-toggle="collapse" href="" data-target=".multi-collapse">
                              Prihláste sa.
                              </a>
                           </p>
                        </div>
                     </form>
                  </div>
               </div>
               @endguest
               @auth
               <div class="col-md-12 mx-auto">
                  <h2 class="section-heading">Kategória 1</h2>
                  <p>V prvej kategórii sa naučíme ovládať hrdinu, zadávať mu príkazy pohyb, skok, útok mečom, použitie páky a otvorenie truhlice. </p>
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
                           @for ($i = 1; $i <= 5; $i++)     
                           <tr>
                              <th scope="row">{{ $i }}</th>
                              <td>
                                 <div class="progress" style="height: 2rem;">
                                    <div class="progress-bar bg-success" role="progressbar" 
                                       aria-valuenow="{{ isset($inGameProgress[$i-1]) ? $inGameProgress[$i-1] : 0 }}" aria-valuemin="0" 
                                       aria-valuemax="100" style="width: {{ isset($inGameProgress[$i-1] ) ? $inGameProgress[$i-1] : 0 }}%;">
                                       <span style="text-align: center; font-weight: bold;">{{ isset($inGameProgress[$i-1] ) ? $inGameProgress[$i-1] : 0 }}% </span>
                                    </div>
                                 </div>
                              </td>
                              <td><a href="{{ url('/')}}/start/1/{{$i}}"    class="btn btn-secondary btn-sm {{ isset($inGameProgress[4]) && $inGameProgress[4] == 100 ? '' : 'disabled' }}">
                                 SPUSTIŤ OD ZAČIATKU</a>
                              </td>
                              <td><a href="{{ url('/')}}/continue/1/{{$i}}" class="btn btn-secondary btn-sm {{ isset($inGameProgress[4]) && $inGameProgress[4] == 100 ? '' : 'disabled' }}">
                                 POKRAČOVAŤ V ULOŽENEJ HRE</a>
                              </td>
                              @endfor
                        </tbody>
                     </table>
                  </div>
                  <p><i class="fas fa-exclamation-circle"></i> Tlačidlá Spustiť od začiatku a Pokračovať v uloženej hre sa odomknú po dokončení všetkých úrovní kategórie.<br>
                     Na spustenie hry používajte zelené tlačidlo @if(!isset($inGameProgress[0])) Začať novú hru. @else Pokračovať v hre. @endif
                  </p>
                  <br>
                  <h2 class="section-heading">Kategória 2</h2>
                  <p>V druhej kategórii sa naučíme ovládať hrdinu podľa nového herného systému a využívať pri tvorbe algoritmov cykly a podmienky.</p>
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
                           @for ($i = 1; $i <= 5; $i++)     
                           <tr>
                              <th scope="row">{{ $i }}</th>
                              <td>
                                 <div class="progress" style="height: 2rem;">
                                    <div class="progress-bar bg-success" role="progressbar" 
                                       aria-valuenow="{{ isset($inGameProgress[$i+4] ) ? $inGameProgress[$i+4] : 0 }}" aria-valuemin="0" 
                                       aria-valuemax="100" style="width: {{ isset($inGameProgress[$i+4]) ? $inGameProgress[$i+4] : 0 }}%;">
                                       <span style="text-align: center; font-weight: bold;">{{ isset($inGameProgress[$i+4] ) ? $inGameProgress[$i+4] : 0 }}% </span>
                                    </div>
                                 </div>
                              </td>
                              <td><a href="{{ url('/')}}/start/2/{{$i}}"    class="btn btn-secondary btn-sm {{ isset($inGameProgress[9]) && $inGameProgress[9] == 100 ? '' : 'disabled' }}">
                                 SPUSTIŤ OD ZAČIATKU</a>
                              </td>
                              <td><a href="{{ url('/')}}/continue/2/{{$i}}" class="btn btn-secondary btn-sm {{ isset($inGameProgress[9]) && $inGameProgress[9] == 100 ? '' : 'disabled' }}">
                                 POKRAČOVAŤ V ULOŽENEJ HRE</a>
                              </td>
                              @endfor
                        </tbody>
                     </table>
                  </div>
                  <br>
                  <div class="col-md-6 mx-auto">
                     <button onclick="window.location='{{url('/')}}/play';" class="btn btn-lg btn-success" {{ isset($inGameProgress[9]) && $inGameProgress[9] == 100 ? 'disabled' : '' }} >
                     <i class="fas fa-play"></i>
                     @if(!isset($inGameProgress[0]))
                     Začať novú hru
                     @else
                     Pokračovať v hre
                     @endif
                     </button>             
                  </div>
                  @if(Auth::user()->role == "admin")   
                  <br>
                  <br>
                  <div class="form-group">
                     <h2 class="section-heading">Registrácia (admin)</h2>
                     <form class="form-horizontal" method="POST" id="registrationForm" action="{{ route('registeruserbyadmin') }}">
                        {{ csrf_field() }}
                        <div class="form-group col-md-6 mx-auto">
                           <input class="form-control" placeholder="Prihlasovacie meno" id="username" type="username" name="username" required>          
                        </div>
                        <div class="form-group col-md-6 mx-auto">
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
            <a href="https://developers.google.com/blockly"><img class="img-fluid" src="{{ asset('img/logo_built_on_dark.png') }}"></a>
            <br>
            <p class="mt-3">&copy; 2019 vytvoril Bc. Martin Vančo<br>Naposledy aktualizované: 20.4.2019
            </p>
         </div>
      </footer>
      <!-- Bootstrap core JavaScript -->
      <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
      <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
      <!-- Plugin JavaScript -->
      <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
      <!-- Custom scripts for this template -->
      <script src="{{ asset('js/new-age.js') }}"></script>
      <!-- Script for Google Recaptcha V2 -->
      <script src='https://www.google.com/recaptcha/api.js'></script>
      <!-- Scripts for handling errors and login -->
      @if ($errors->register->any())
      <script type="text/javascript">
         $(document).ready(function () {
         
         $('#loginDiv').collapse("hide");
         $('#registerDiv').collapse("show");
         
         
         $('html, body').animate({
             scrollTop: $('#game').offset().top
         }, 'slow'); 
         
         });
      </script>  
      @endif
      @if ($errors->any())      
      <script type="text/javascript">     
         $(document).ready(function () {
         
         $('html, body').animate({
             scrollTop: $('#game').offset().top
         }, 'slow'); 
         
         });
      </script>
      @endif
      @if ($errors->has('g-recaptcha-response'))
      <script type="text/javascript">
         $(document).ready(function () {
         
         $('#loginDiv').collapse("hide");
         $('#registerDiv').collapse("show");
         
         });
      </script>
      @endif
      @auth
      @if (auth()->check())  
      <script type="text/javascript">
         $(document).ready(function () {
         $('html, body').animate({
             scrollTop: $('#features').offset().top
         }, 'slow');    
         });
      </script>   
      @endif
      @endauth
   </body>
</html>