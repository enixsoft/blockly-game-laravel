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
            <a class="navbar-brand js-scroll-trigger" href="{{ route('/') }}">BLOCKLY HRA</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
               <ul class="navbar-nav ml-auto">
                  <li class="nav-item">
                     <a class="nav-link js-scroll-trigger" href="{{ route('/') }}#features">O hre</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link js-scroll-trigger" href="{{ route('/') }}#game">Spustiť hru</a>
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
      <header class="masthead" style="overflow: overlay;">
         <div class="container">
         <div class="row">

            <div class="section-heading text-center text-dark bg-light">
               <h2>Web používa súbory cookies</h2>
               <p>
               <h3>Súbory cookie</h3>
               S cieľom zabezpečiť riadne fungovanie tejto webovej lokality ukladáme niekedy na vašom zariadení malé dátové súbory, tzv. cookie. Je to bežná prax väčšiny veľkých webových lokalít.
               <hr>
               <h3>Čo sú súbory cookie?</h3>
               Súbor cookie je malý textový súbor, ktorý webová lokalita ukladá vo vašom počítači alebo mobilnom zariadení pri jej prehliadaní. Vďaka tomuto súboru si webová lokalita na určitý čas uchováva informácie o vašich krokoch a preferenciách (ako sú prihlasovacie meno, jazyk, veľkosť písma a iné nastavenia zobrazovania), takže ich pri ďalšej návšteve lokality alebo prehliadaní jej jednotlivých stránok nemusíte opätovne uvádzať.
               <hr>
               <h3>Ako používame súbory cookie?</h3>
               Tieto webstránky používajú súbory cookies pre nevyhnutnú funkcionalitu webstránok.
               <hr>
               <h3>Ako kontrolovať súbory cookie</h3>
               Súbory cookie môžete kontrolovať alebo zmazať podľa uváženia – podrobnosti si pozrite na stránke aboutcookies.org.  Môžete vymazať všetky súbory cookie uložené vo svojom počítači a väčšinu prehliadačov môžete nastaviť tak, aby ste im znemožnili ich ukladanie. V takomto prípade však pravdepodobne budete musieť pri každej návšteve webovej lokality manuálne upravovať niektoré nastavenia a niektoré služby a funkcie nebudú fungovať.
               <hr>
               <h3>Ako odmietnuť používanie súborov cookie</h3>
               Používanie súborov cookie je možné nastaviť pomocou Vášho internetového prehliadača. Väčšina prehliadačov súbory cookie automaticky prijíma už vo úvodnom nastavení.
               </p>
               <hr>
               <a href="{{ url('/')}}" class="btn btn-success btn-lg">Hlavná stránka</a>
               <br>
               <br>
               <br>
            </div>
            </div>
            </div>
      </header>          
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
   </body>
</html>