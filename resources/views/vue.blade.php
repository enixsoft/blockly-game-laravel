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
      <link href="{{ asset('css/new-age.css') }}" rel="stylesheet">
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
      :in-game-progress="{{ $inGameProgressJson }}"
      :game-data="{{ $gameDataJson }}"
      base-url="http:{{ url('/') }}/"
   />
	</div> 
   </body> 
   <script src="{{ asset(mix('js/app.js')) }}"></script>
   <script src='https://www.google.com/recaptcha/api.js'></script>   
</html>