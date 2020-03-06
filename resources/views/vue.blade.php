<!DOCTYPE html>
<html lang="sk">
   <head>
      <meta charset="utf-8">
      <meta name="csrf-token" content="{{ csrf_token() }}">
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
   <div id="app"> 
   <App      
      :user="{{ json_encode(auth()->user()) }}"
      :errors="{{ $errors->merge($errors->register) }}"
      :old="{{ json_encode(Session::getOldInput()) }}"    
      :lang="{{ $langJson }}"
      :recaptcha-key="'{{env('GOOGLE_RECAPTCHA_KEY')}}'"
   />
   </div> 
   {{ $errors }}
   {{ $errors->register }}
   {{ json_encode(Session::getOldInput()) }}
   @guest
   Guest
   @endguest
   @auth
   {{ Auth::user()->username }}
   @endauth
   {{env('GOOGLE_RECAPTCHA_KEY')}}
   </body>
 
   <script src="{{ asset(mix('js/app.js')) }}"></script>
   <!-- Bootstrap core JavaScript -->
   <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
   <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
   <!-- Plugin JavaScript -->
   <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
   <!-- Custom scripts for this template -->
   <script src="{{ asset('js/new-age.js') }}"></script>
   <!-- Script for Google Recaptcha V2 -->
   <script src='https://www.google.com/recaptcha/api.js'></script>

</html>