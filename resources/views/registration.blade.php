<!DOCTYPE html>
<html lang="sk">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registrácia</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans|Candal|Alegreya+Sans">
  <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/imagehover.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

@extends('layout')
@section('content')
 <div class="banner">
    <div class="bg-color">
      <div class="container">
        <div class="row">
          <div class="banner-text text-center">
            <div class="text-border">
              <h2 class="text-dec">Blockly hra</h2>
            </div>
            <div class="intro-para text-center quote">
              <p class="big-text">Registrácia</p>
              <p class="small-text">                
                Blockly je grafické programovacie prostredie, vyvinuté spoločnosťou Google v roku 2012. <br> Tento vizuálny jazyk vám umožní rýchlo pochopiť základy logického prenosu dát a inštrukcií, zoznámiť sa s cyklami, operátormi, postupmi, funkciami, premenné jazyka JavaScript a všeobecne umožňujú rozvíjať myslenie</p>             
            </div>
          
          </div>
        </div>
      </div>
    </div>
  </div>

  <section id="feature" class="section-padding">
    <div class="container">
      <div class="row">  
        <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                      <div class="form-group">
                            <label for="email" class="col-md-4 control-label">Používateľske meno</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control" name="username" required>
                            
                            </div>
                        </div>


                       



                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">E-mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                            
                            </div>
                        </div>



                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Heslo</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>
                            
                            </div>                        
                        </div>

                        
                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Potvrdenie hesla</label>

                            <div class="col-md-6">
                                <input id="passwordcheck" type="password" class="form-control" name="passwordcheck" required>
                            
                            </div>
                        </div>

                
                     

                        <div class="form-group">
                             <div class="col-md-6 col-md-offset-5">
                                <button style="height:40px; width:250px" type="submit" class="btn btn-primary">
                                    Registrovať 
                                </button>
                          </div>
                        </div>
                    </form>
                      <br>                      
          

         
          </div>
        </div>
        
     
  </section>


@stop