<!DOCTYPE html>
<html lang="sk">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Blockly hra</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans|Candal|Alegreya+Sans">
  <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/imagehover.min.css">

  <link rel="stylesheet" type="text/css" href="css/style.css">
  

  <script src="{{ asset('js/jquery.min.js') }}"></script>
  <script src="{{ asset('js/jquery.easing.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="js/custom.js"></script>




<style>
  .back {
  background: #e2e2e2;
  width: 100%;
  position: absolute;
  top: 0;
  bottom: 0;
}

.div-center {
  width: 50%;
  height: 50%;
  background-color: #fff;
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  margin: auto;
  max-width: 100%;
  max-height: 100%;
  overflow: auto;
  padding: 1em 2em;
  border-bottom: 2px solid #ccc;
  display: table;
}

div.content {
  display: table-cell;
  vertical-align: middle;
}

.checkbox,
.radio {
  display: inline-block;
  margin-bottom: 15px; }
  .checkbox:hover,
  .radio:hover {
    cursor: pointer; }
  .checkbox .fa,
  .radio .fa {
    width: 1em; }

.indent {
  padding-left: 30px; }
  .indent .fa {
    margin-left: -30px; }

.checkbox input[type="checkbox"],
.radio input[type="radio"] {
  display: none; }
  .checkbox input[type="checkbox"] + i:before,
  .radio input[type="radio"] + i:before {
    content: "\f096";
    position: relative;
    bottom: -4px;
    margin-right: 5px;
    color: #999; }

.checkbox:hover input[type="checkbox"] + i:before,
.radio:hover input[type="radio"] + i:before {
  color: green; }

.checkbox input[type="checkbox"]:checked + i:before,
.radio input[type="radio"]:checked + i:before {
  content: "\f046";
  color: green; }

.checkbox input[type="checkbox"]:disabled + i:before,
.checkbox input[type="checkbox"]:disabled:checked + i:before,
.radio input[type="radio"]:disabled + i:before,
.radio input[type="radio"]:disabled:checked + i:before {
  color: #ddd; }

/*RADIO*/
.radio input[type="radio"] + i:before {
  content: "\f1db"; }

.radio input[type="radio"]:checked + i:before {
  content: "\f058"; }

/* CHECKBOX&RADIO XS*/
.checkbox-xs input[type="checkbox"] + i:before,
.radio-xs input[type="radio"] + i:before {
  bottom: 0; }

.checkbox-xs.indent,
.radio-xs.indent {
  padding-left: 20px; }
  .checkbox-xs.indent .fa,
  .radio-xs.indent .fa {
    margin-left: -20px; }

.progress {
    position: relative;
}

.progress span {
    position: absolute;
    display: block;
    width: 100%;
    color: white;
 }


</style>

</head>


<body>
   @include('header')
   <div class="back">
   <div class="div-center">
   <div class="content">
      @guest
      <div class="form-group ">
         <h3>Prihlásenie</h3>
         <hr/>
         <form method="POST" id="loginForm" action="{{ route('login') }}">
            {{ csrf_field() }}
            <div class="form-group {{ $errors->has('username') ? ' has-error' : '' }} col-md-6 mx-auto" style="width:50%;">                   
               <input class="form-control" placeholder="Prihlasovacie meno" id="username" type="username" name="username" value="{{ old('username') }}" required autofocus>             
               @if ($errors->has('username'))
               <span class="help-block">
               <strong>{{ $errors->first('username') }}</strong>
               </span>
               @endif
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} col-md-6 mx-auto" style="width:50%;">
               <input id="password" placeholder="Heslo" type="password" class="form-control" name="password" required>
               @if ($errors->has('password'))
               <span class="help-block">
               <strong>{{ $errors->first('password') }}</strong>
               </span>
               @endif                            
            </div>
            <div class="col-md-2 mx-auto">
               <div class="checkbox">
                  <label style="cursor:inherit;">
                  <input type="checkbox" id="remember" {{ old('remember') ? 'checked' : '' }}>
                  <i class="fa fa-2x icon-checkbox"></i>
                  Zapamätať
                  </label>
               </div>
            </div>
            <hr/>
            <div class="col-md-2 mx-auto">
               <button class="btn btn-lg btn-success" type="submit">
               Prihlásiť sa
               </button>
               <br>
            </div>
         </form>
      </div>
      @endguest
      @auth   
      <div class="container">
         <div class="row">
            <h3>Výber levelu</h3>
            <hr/>
            <table id="tablePreview" class="table">
               <!--Table head-->
               <thead>
                  <tr>
                     <th>Level</th>
                     <th>Postup</th>
                     <th>Spustiť</th>
                     <th>Pokračovať</th>
                  </tr>
               </thead>
               <!--Table head-->
               <!--Table body-->
               <tbody>
                  @for ($i = 1; $i <= 5; $i++)     
                  <tr>
                     <th scope="row">{{ $i }}</th>
                     <td>
                        <div class="progress" style="height: 2.7rem;">
                           <div class="progress-bar bg-success" role="progressbar" 
                              aria-valuenow="{{ isset($inGameProgress[$i-1] ) ? $inGameProgress[$i-1]['progress'] : 0 }}" aria-valuemin="0" 
                              aria-valuemax="100" style="width: {{ isset($inGameProgress[$i-1] ) ? $inGameProgress[$i-1]['progress'] : 0 }}%;">
                              <span style="text-align: center;">{{ isset($inGameProgress[$i-1] ) ? $inGameProgress[$i-1]['progress'] : 0 }}% </span>
                           </div>
                        </div>
                     </td>
                     <td><a href="{{ url('/')}}/start/1/{{$i}}" style="width:100%;" class="btn btn-secondary btn-sm {{ isset($inGameProgress[$i-1]) && $inGameProgress[$i-1]['progress']==100 ? '' : 'disabled' }}">
                        SPUSTIŤ OD ZAČIATKU</a>
                     </td>
                     <td><a href="{{ url('/')}}/continue/1/{{$i}}" style="width:100%;" class="btn btn-secondary btn-sm {{ isset($inGameProgress[$i-1]) && $inGameProgress[$i-1]['progress']==100 ? '' : 'disabled' }}">
                        POKRAČOVAŤ V ULOŽENEJ HRE</a>
                     </td>
                     @endfor
               </tbody>
            </table>
         </div>
         <div class="row">
            <div class="col-md-offset 3 mx-auto">
               <a href="{{ url('/')}}/play" class="btn btn-lg btn-success">
               {{ isset($inGameProgress[0] ) && $inGameProgress[0]['progress'] > 0 ? 'Pokračovať v hre' : 'Začať novú hru' }}
               </a>
               <br>
            </div>
         </div>
          @if(Auth::user()->role == "admin")    
         <div class="form-group ">
            <h3>Registrácia</h3>
            <hr/>             
            <form class="form-horizontal" method="POST" id="registrationForm" action="{{ route('registerforbetatest') }}">
               {{ csrf_field() }}
               <div class="form-group">
                  <label for="email" class="control-label">Používateľské meno</label>
                  <div class="col-md-6">
                     <input id="username" type="text" class="form-control" name="username" required>
                  </div>
               </div>               
               <div class="form-group">
                  <label for="password" class="control-label">Heslo</label>
                  <div class="col-md-6">
                     <input id="password" type="password" class="form-control" name="password" required>
                  </div>
               </div>
               <div class="form-group">
                    <div class="col-md-2 mx-auto">
                      <br>
                      <button class="btn btn-lg btn-success" type="submit">
                      Registrácia
                      </button>
                      <br>
                    </div>
               </div>
            </form>
         </div>
         @endif
         @endauth
      </div>
   </div>
</body>
</html>