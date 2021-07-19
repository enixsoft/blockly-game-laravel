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
      :view-name="'{{ $viewName }}'"
      :view-data="{{ $viewData }}"
      :user="{{ $user }}"
      :lang="{{ $lang }}"
      :errors="{{ $errors->merge($errors->register) }}"
      :old="{{ json_encode(Session::getOldInput()) }}"          
      :recaptcha-key="'{{ config('app.google_recaptcha_key') }}'"     
      base-url="{{ config('app.url') }}"
   />
	</div>
   </body> 
   <script src='https://www.google.com/recaptcha/api.js'></script> 
   <script src="{{ asset(mix('js/app.js')) }}"></script>  
</html>