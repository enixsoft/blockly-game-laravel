<!DOCTYPE html>
<html lang="sk">
   <head>
      <meta charset="utf-8">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <title>{{ Lang::get('pagination.title') }}</title>
      <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
      <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
      <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">
      <link rel="stylesheet" href="{{ asset(mix('css/app.css')) }}">
   </head>
   <body id="page-top">
   <div id="app"> 
   <App      
      :user="{{ json_encode(auth()->user()) }}"
      :errors="{{ $errors->merge($errors->register) }}"
      :old="{{ json_encode(Session::getOldInput()) }}"    
      :lang="{{ $langJson }}"
      :recaptcha-key="'{{env('GOOGLE_RECAPTCHA_KEY')}}'"
      :in-game-progress="{{ $inGameProgressJson }}"
      :game-data="{{ $gameDataJson }}"      
      base-url="http://localhost:3000/blocklyapp/"
   />
	</div> 
   </body> 
   <script src="{{ asset(mix('js/app.js')) }}"></script>
   <script src='https://www.google.com/recaptcha/api.js'></script>   
</html>