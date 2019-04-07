<!DOCTYPE html>
<html lang="sk">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, minimal-ui">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <meta name="description" content="">
      <meta name="author" content="">
      <title>Blockly hra</title>
      <!-- Bootstrap core CSS -->
      <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
      <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
      <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
      <!-- Custom fonts for this template -->
      <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
      <link rel="stylesheet" href="{{ asset('vendor/simple-line-icons/css/simple-line-icons.css') }}">
      <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">
      <link href="{{ asset('css/new-age.min.css') }}" rel="stylesheet">
   </head>
   <body id="page-top">
      @auth   
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
      @endauth
      <!-- Navigation -->
      <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
         <div class="container">
            <a class="navbar-brand" id="navbar-brand" href="{{ route('/') }}">BLOCKLY HRA</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
               <ul class="navbar-nav ml-auto">
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
      <header class="game-header">
         <div class="game-container">
            <div class="row h-100 w-100 no-padding">
               <div class="col-lg-6 no-padding">
                  <iframe id="app-frame" class="game-playcanvas"  
                     src="{{url('')}}/game/playcanvas/{{$category}}x{{$level}}.html"> </iframe>    
                  <!--  src="https://playcanv.as/e/p/62c28f63/"></iframe>-->   
               </div>
               <div class="col-lg-6 no-padding">
                  <div class="row h-100 w-100 no-padding">
                     <div class="col-lg-12 col-sm-10 game-blockly" id="blocklyArea">            
                     </div>
                     <div class= "col-lg-12 col-sm-2 game-buttons mx-auto text-center" id="gameButtons">
                        <div class= "btn-group" role="group">
                           <button type="button" id="send_code_button" class="btn btn-success mr-3" onclick="runCode()" disabled><i class="fas fa-play"></i> Spustiť bloky</button>
                           <button type="button" id="show_task_button" class="btn btn-success mr-3" onclick="showTaskButton()" disabled><i class="fas fa-tasks"></i> Zadanie úlohy</button>
                           <button type="button" id="delete_blocks_button" class="btn btn-success mr-3" onclick="deleteBlocksButton()" disabled><i class="fas fa-trash"></i> Vymazať všetky bloky</button>       
                           <button type="button" id="report_bug_button" class="btn btn-success mr-3" onclick="reportBugButton()" disabled><i class="fas fa-bug"></i> Nahlásiť chybu</button>                 
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </header>
      <div id="blocklyDiv" style="position: absolute;"></div>
      </div>
      @include('modals')
      <script src="{{ asset('blockly/blockly_compressed.js') }}"></script>
      <script src="{{ asset('blockly/blocks_compressed.js') }}"></script>
      <script src="{{ asset('blockly/javascript_compressed.js') }}"></script>
      <script src="{{ asset('blockly/msg/js/en.js') }}"></script>
      <script src="{{ asset('game/blockdefinitions.js') }}"></script>
      <xml id="startBlocks" style="display: none">
         @if($category==1)
         <block type="player" movable="false" deletable="false" inline="false" x="0" y="0"></block>
         @else
         <block type="playerDirection" movable="false" deletable="false" inline="false" x="0" y="0"></block>
         @endif
         <!-- DEV BLOCKS
            <block type="cameraplus" movable="false" deletable="false" inline="false" x="650" y="900"></block> 
            <block type="cameraminus" movable="false" deletable="false" inline="false" x="450" y="900"></block>       
            <block type="save" movable="false" deletable="false" inline="false" x="250" y="900"></block>
            <block type="reload" movable="false" deletable="false" inline="false" x="50" y="900"></block> 
            <block type="load" movable="false" deletable="false" inline="false" x="450" y="900"></block>       
            -->
      </xml>
      <!-- Bootstrap core JavaScript -->
      <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
      <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
      <!-- Plugin JavaScript -->
      <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
      <!-- Custom scripts for this template -->
      <script src="{{ asset('js/new-age.min.js') }}"></script>
      @include('jsmin')
   </body>
</html>