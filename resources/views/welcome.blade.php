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
  width: 400px;
  height: 400px;
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

.checkbox {
  padding-left: 20px;
}
.checkbox label {
  display: inline-block;
  vertical-align: middle;
  position: relative;
  padding-left: 5px;
}
.checkbox label::before {
  content: "";
  display: inline-block;
  position: absolute;
  width: 17px;
  height: 17px;
  left: 0;
  margin-left: -20px;
  border: 1px solid #cccccc;
  border-radius: 3px;
  background-color: #fff;
  -webkit-transition: border 0.15s ease-in-out, color 0.15s ease-in-out;
  -o-transition: border 0.15s ease-in-out, color 0.15s ease-in-out;
  transition: border 0.15s ease-in-out, color 0.15s ease-in-out;
}
.checkbox label::after {
  display: inline-block;
  position: absolute;
  width: 16px;
  height: 16px;
  left: 0;
  top: 0;
  margin-left: -20px;
  padding-left: 3px;
  padding-top: 1px;
  font-size: 11px;
  color: #555555;
  line-height: 1.4;
}
.checkbox input[type="checkbox"],
.checkbox input[type="radio"] {
  opacity: 0;
  z-index: 1;
  cursor: pointer;
}
.checkbox input[type="checkbox"]:focus + label::before,
.checkbox input[type="radio"]:focus + label::before {
  outline: thin dotted;
  outline: 5px auto -webkit-focus-ring-color;
  outline-offset: -2px;
}
.checkbox input[type="checkbox"]:checked + label::after,
.checkbox input[type="radio"]:checked + label::after {
  font-family: "FontAwesome";
  content: "\f00c";
}
.checkbox input[type="checkbox"]:indeterminate + label::after,
.checkbox input[type="radio"]:indeterminate + label::after {
  display: block;
  content: "";
  width: 10px;
  height: 3px;
  background-color: #555555;
  border-radius: 2px;
  margin-left: -16.5px;
  margin-top: 7px;
}
.checkbox input[type="checkbox"]:disabled,
.checkbox input[type="radio"]:disabled {
  cursor: not-allowed;
}
.checkbox input[type="checkbox"]:disabled + label,
.checkbox input[type="radio"]:disabled + label {
  opacity: 0.65;
}
.checkbox input[type="checkbox"]:disabled + label::before,
.checkbox input[type="radio"]:disabled + label::before {
  background-color: #eeeeee;
  cursor: not-allowed;
}
.checkbox.checkbox-circle label::before {
  border-radius: 50%;
}
.checkbox.checkbox-inline {
  margin-top: 0;
}

.checkbox-primary input[type="checkbox"]:checked + label::before,
.checkbox-primary input[type="radio"]:checked + label::before {
  background-color: #337ab7;
  border-color: #337ab7;
}
.checkbox-primary input[type="checkbox"]:checked + label::after,
.checkbox-primary input[type="radio"]:checked + label::after {
  color: #fff;
}

.checkbox-danger input[type="checkbox"]:checked + label::before,
.checkbox-danger input[type="radio"]:checked + label::before {
  background-color: #d9534f;
  border-color: #d9534f;
}
.checkbox-danger input[type="checkbox"]:checked + label::after,
.checkbox-danger input[type="radio"]:checked + label::after {
  color: #fff;
}

.checkbox-info input[type="checkbox"]:checked + label::before,
.checkbox-info input[type="radio"]:checked + label::before {
  background-color: #5bc0de;
  border-color: #5bc0de;
}
.checkbox-info input[type="checkbox"]:checked + label::after,
.checkbox-info input[type="radio"]:checked + label::after {
  color: #fff;
}

.checkbox-warning input[type="checkbox"]:checked + label::before,
.checkbox-warning input[type="radio"]:checked + label::before {
  background-color: #f0ad4e;
  border-color: #f0ad4e;
}
.checkbox-warning input[type="checkbox"]:checked + label::after,
.checkbox-warning input[type="radio"]:checked + label::after {
  color: #fff;
}

.checkbox-success input[type="checkbox"]:checked + label::before,
.checkbox-success input[type="radio"]:checked + label::before {
  background-color: #5cb85c;
  border-color: #5cb85c;
}
.checkbox-success input[type="checkbox"]:checked + label::after,
.checkbox-success input[type="radio"]:checked + label::after {
  color: #fff;
}

.checkbox-primary input[type="checkbox"]:indeterminate + label::before,
.checkbox-primary input[type="radio"]:indeterminate + label::before {
  background-color: #337ab7;
  border-color: #337ab7;
}

.checkbox-primary input[type="checkbox"]:indeterminate + label::after,
.checkbox-primary input[type="radio"]:indeterminate + label::after {
  background-color: #fff;
}

.checkbox-danger input[type="checkbox"]:indeterminate + label::before,
.checkbox-danger input[type="radio"]:indeterminate + label::before {
  background-color: #d9534f;
  border-color: #d9534f;
}

.checkbox-danger input[type="checkbox"]:indeterminate + label::after,
.checkbox-danger input[type="radio"]:indeterminate + label::after {
  background-color: #fff;
}

.checkbox-info input[type="checkbox"]:indeterminate + label::before,
.checkbox-info input[type="radio"]:indeterminate + label::before {
  background-color: #5bc0de;
  border-color: #5bc0de;
}

.checkbox-info input[type="checkbox"]:indeterminate + label::after,
.checkbox-info input[type="radio"]:indeterminate + label::after {
  background-color: #fff;
}

.checkbox-warning input[type="checkbox"]:indeterminate + label::before,
.checkbox-warning input[type="radio"]:indeterminate + label::before {
  background-color: #f0ad4e;
  border-color: #f0ad4e;
}

.checkbox-warning input[type="checkbox"]:indeterminate + label::after,
.checkbox-warning input[type="radio"]:indeterminate + label::after {
  background-color: #fff;
}

.checkbox-success input[type="checkbox"]:indeterminate + label::before,
.checkbox-success input[type="radio"]:indeterminate + label::before {
  background-color: #5cb85c;
  border-color: #5cb85c;
}

.checkbox-success input[type="checkbox"]:indeterminate + label::after,
.checkbox-success input[type="radio"]:indeterminate + label::after {
  background-color: #fff;
}



</style>

</head>


<body>
@include('header')



<body translate="no" >

  <div class="back">


  <div class="div-center">


  <div class="content">


      <div class="form-group">
              <h3>Prihlásenie</h3>
              <hr/>
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
                  <div class="mx-auto">
                   <div class="form-group">
                  
                              
                                <input type="checkbox" class="checkbox checkbox-primary" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}/>   
                             
                                 <label class="form-check-label" for="remember">Zapamätať </label>
                  

                    <!--<input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>  </label>-->


                 
                  </div>
                   </div>

                  </div>


                  <div class="col-md-6 mx-auto">
                   
                    <button class="btn btn-lg btn-success" type="submit">
                      Prihlásiť sa
                    </button>
                    
                    <br>
                    


                  </div>
                  <hr/>
                   </form> 
                </div>
                       
                   

    </div>

    </div>


    </div>


  
  
  


</body>


@if ($errors->all())  
<script type="text/javascript">
  $(document).ready(function () {
    $('#loginModal').modal('show');
    });
</script>        
@endif 

</html>


