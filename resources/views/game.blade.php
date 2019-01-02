<!DOCTYPE html>
<html lang="sk">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Blockly hra</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
  <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans|Candal|Alegreya+Sans">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/imagehover.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/extrastyle.css') }}">
  
 <script src="{{ asset('js/jquery.min.js') }}"></script>
 <script src="{{ asset('js/jquery.easing.min.js') }}"></script>
 <script src="{{ asset('js/bootstrap.min.js') }}"></script>
 <script src="{{ asset('js/custom.js') }}"></script>

<!--
@if ($errors->all())  
<script type="text/javascript">
  $(document).ready(function () {
    $('#loginModal').modal('show');
    });
</script>        
@endif
--> 

<!--<script type="text/javascript">
  $(document).ready(function () {
    $('#welcomeModal').modal('show');
    });
</script>-->    




</head>

<body>

@include('header')
@include('modals')




<div class="container-fluid">
    <div class="row row-full">
        <div class="col-md-6">
            <div class="leftside">
                <!--<iframe id="app-frame" style="width:100%;height:100%;overflow:hidden;border:none;"
                src="https://playcanv.as/e/p/62c28f63/"></iframe>-->
                <iframe id="app-frame" style="width:100%;height:100%;overflow:hidden;border:none;"
                src="http://localhost/blockly-web-project/public/game/playcanvas/{{$category}}x{{$level}}.html"></iframe>
            </div>
        </div>
        <div class="col-md-6" style="background-color:#E4E4E4;">            
           <div id="blocklyArea" class="rightside"></div>
           <!--<div class="container" style="max-height: 10vh;">
           <div class="row justify-content-center" style="padding: 2.5vh 0;">
                <button type="button" id="click_button" class="col-md-2 btn  btn-success mr-3">Spustiť</button>
     
                <button type="button" id="click_button" class="col-md-2 btn  btn-success mr-3">Úloha</button>
                
                <button type="button" id="click_button" class="col-md-3 btn  btn-success mr-3">Vymazať všetky bloky</button>
                
                <button type="button" id="click_button" class="col-md-2 btn  btn-success mr-3">Riešenie</button>      


            </div>
            </div>-->

           <div class="rightside2">        
                
                <div class="btn-group" role="group">

                <button type="button" id="send_code_button" class="btn btn-success mr-3">Spustiť bloky</button>
     
                <button type="button" id="show_task_button" class="btn btn-success mr-3">Zadanie úlohy</button>
                
                <button type="button" id="delete_blocks_button" class="btn btn-success mr-3">Vymazať všetky bloky</button>
                
                <button type="button" id="solution_task_button" class="btn btn-danger mr-3">Riešenie úlohy</button>      
                  
                </div>

         
            </div>

         
            </div>             
        </div>
    </div>




<div id="blocklyDiv" style="position: absolute; height: 800px;"></div>
</div>



<script src="{{ asset('blockly/blockly_compressed.js') }}"></script>
<script src="{{ asset('blockly/blocks_compressed.js') }}"></script>
<script src="{{ asset('blockly/javascript_compressed.js') }}"></script>
<script src="{{ asset('blockly/msg/js/en.js') }}"></script>
<script src="{{ asset('game/blockdefinitions.js') }}"></script>


<xml id="startBlocks" style="display: none">
       <block type="player" movable="false" deletable="false" inline="false" x="50" y="70"></block>
       <!--<block type="run" movable="false" deletable="false" inline="false" x="50" y="1000"></block>
       <block type="cameraplus" movable="false" deletable="false" inline="false" x="250" y="1000"></block> 
       <block type="cameraminus" movable="false" deletable="false" inline="false" x="450" y="1000"></block>
       <block type="save" movable="false" deletable="false" inline="false" x="250" y="900"></block>
       <block type="load" movable="false" deletable="false" inline="false" x="450" y="900"></block> 
       <block type="reload" movable="false" deletable="false" inline="false" x="650" y="1000"></block>
       -->      
       
</xml>

<!--<xml id="toolbox" style="display: none">
  <block type="logic_operation"></block>
  <label text="A label" web-class="myLabelStyle"></label>
  <label text="Another label"></label>
  <block type="logic_negate"></block>
  <button text="A button" callbackKey="myFirstButtonPressed"></button>
  <block type="logic_boolean"></block>



  <block type="run" movable="false" deletable="false" inline="false" x="50" y="1000"></block>
       <block type="cameraplus" movable="false" deletable="false" inline="false" x="250" y="1000"></block> 
       <block type="cameraminus" movable="false" deletable="false" inline="false" x="450" y="1000"></block>
       <block type="save" movable="false" deletable="false" inline="false" x="250" y="900"></block>
       <block type="load" movable="false" deletable="false" inline="false" x="450" y="900"></block>       
       <block type="restart" movable="false" deletable="false" inline="false" x="650" y="1000"></block>
       <block type="reload" movable="false" deletable="false" inline="false" x="850" y="1000"></block>        


</xml>

<style>
.myLabelStyle>.blocklyFlyoutLabelText {
  font-style: italic;
  fill: green;
}
</style>
-->
<script>
var button = document.getElementById('send_code_button'); 
button.disabled = true; 
        

var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
var eventer = window[eventMethod];
var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";


eventer(messageEvent,function(e) 
{
  console.log('parent received message!:  ', e.data);
  
  switch(e.data.action)
  {
     case "unlock":
    {
      //run[0].setColour(95);
      var button = document.getElementById('send_code_button'); 
      button.disabled = false;   
        

      workspacePlayground.highlightBlock(null);
      this.locked = false;
      break;
    }
     case "death":
    {
       // you died window
      workspacePlayground.highlightBlock(null);
      break;
    }
     case "uiHelp":
    {
      // old game UI commands
      break;     
    }
     case "uiPlay":
    {
    // old game UI commands
     break;     
    }    
    case "start":
    {
     
     startGame();
     break;     
    }
    
    case "introduction":
    {
    
    

    this.level_start = Date.now(); 

    if(this.progress==0)
    {     
    console.log("levelIntroduced");
    levelIntroduced(e.data.content);    
    }
    else 
    {   
    console.log("mainTaskIntroduced");
    mainTaskIntroduced(e.data.content);
    }
    
     break;     
    }
    
    case "highlightProgress":
    {
     highlightBlock(e.data.content);
     break;     
    }

     case "highlightFailure":
    {
       //COMMAND FAILED BLOCK IS RED    
     
      block = workspacePlayground.getBlockById(e.data.content);
      block.setColour(0);
      failedBlock.push(block);
      break;     
    }

    case "mainTaskCompleted":
    {
      console.log("mainTaskCompleted");
      console.log(e.data.content);

      workspacePlayground.highlightBlock(null);
      //maybe change color of all blocks of correct algorithm ?
      mainTaskCompleted(e.data.content.currentMainTask);

      this.task_end = Date.now();
      createLogOfGameplay("mainTaskCompleted", e.data.content);
      break;     
    }

    case "commandFailed": //death and dizzy
    {
      console.log("commandFailed");
      console.log(e.data.content);

      commandFailed(e.data.content);

      createLogOfGameplay("commandFailed", e.data.content);
      break;     
    }

    case "mainTaskFailed": //did not move enough etc.
    {
      console.log("mainTaskFailed");
      console.log(e.data.content);

      workspacePlayground.highlightBlock(null);
      mainTaskFailed(e.data.content.currentMainTask);

      createLogOfGameplay("mainTaskFailed", e.data.content);
      break;     
    }

    case "nextMainTask":
    {
      console.log("nextMainTask");
      console.log(e.data.content);
      workspacePlayground.highlightBlock(null);
      //maybe change color of all blocks of correct algorithm ?
      mainTaskIntroduced(e.data.content);
      break;     
    }
    case "allMainTasksFinished":
    {
      console.log("allMainTasksFinished");

      
      allMainTasksFinished();
      break;     
    }

    case "save":
    {
      console.log("save object arrived");    
      saveObjectToJson(e.data.content);
      break;     
    }

  }

},false);

  var failedBlock = [];  

  var toolbox = {!! json_encode($xmlToolbox) !!};

  var savedGame = {!! $savedGame !!};

  var tasks =  {!! $jsonTasks !!};

  var modals =  {!! $jsonModals !!};  

  
  this.locked = true;
  this.available_modal = 1;

  this.category = tasks.level.category;
  this.level    = tasks.level.level;
  this.progress = savedGame.progress;
  this.level_start = new Date();
  this.task_start = new Date();
  this.task_end = new Date();
  this.code = "";
  
  this.saveObjectToString = savedGame.json;
  this.saveToDatabaseEnabled = true;  

  var blocklyArea = document.getElementById('blocklyArea');
  var blocklyDiv = document.getElementById('blocklyDiv');

  var workspacePlayground = Blockly.inject(blocklyDiv,
      {toolbox: toolbox, trashcan: true});

  Blockly.Xml.domToWorkspace(document.getElementById('startBlocks'),
                              workspacePlayground); 
  disableContextMenus();


  //var run = getBlocksByType("run");
  //var cameraplus = getBlocksByType("cameraplus");
  //var cameraminus = getBlocksByType("cameraminus");
  //var load = getBlocksByType("load");
  //var save = getBlocksByType("save");
  //var reload = getBlocksByType("reload"); 


   $(document).ready(function(){
    $("#send_code_button").click( function(){
         
         if(!this.locked)
          runCode();
  });
  });  



  function blockClickController(event) {  


    if(event.element=="click")
    {     
  
      blockToCheck = Blockly.selected;
     
 
      if(blockToCheck.id == run[0].id)
      {
        
        if(!this.locked==false)
          runCode();
        blockToCheck.unselect();
      }
        else if(blockToCheck.id == cameraplus[0].id)
      {
         cameraPlus();
        
         blockToCheck.unselect();
        
      }
      else if(blockToCheck.id == cameraminus[0].id)
      {
        cameraMinus();
      
        blockToCheck.unselect();
      }
      else if(blockToCheck.id == reload[0].id)
      {
        reloadIframe();
        blockToCheck.unselect();
      }
       else if(blockToCheck.id == save[0].id)
      {
        saveGame();
        blockToCheck.unselect();
      }
       else if(blockToCheck.id == load[0].id)
      {
         loadGame();
         blockToCheck.unselect();
      }
      

    }


   


    
  }

  workspacePlayground.addChangeListener(blockClickController);
  

  var onresize = function(e) {
    // Compute the absolute coordinates and dimensions of blocklyArea.
    var element = blocklyArea;
    var x = 0;
    var y = 0;
    do {
      x += element.offsetLeft;
      y += element.offsetTop;
      element = element.offsetParent;
    } while (element);
    // Position blocklyDiv over blocklyArea.

    blocklyDiv.style.left = x + 'px';
    blocklyDiv.style.top = y + 'px';
    blocklyDiv.style.width = blocklyArea.offsetWidth + 'px';
    blocklyDiv.style.height = blocklyArea.offsetHeight + 'px';

    Blockly.svgResize(workspacePlayground); // o_O

  };
  
  
  $(window).resize(function() {    
    onresize();
  });
  //window.addEventListener('resize', onresize, false);
  onresize();
     
  function saveObjectToJson(object) {
      
      
      var myJSON = JSON.stringify(object);
      this.saveObjectToString = myJSON;
      console.log(myJSON);  

      if(this.saveToDatabaseEnabled)
      {
        saveJsonToDatabase();
      }

    }

  function saveJsonToDatabase() {     
    
     if(isUserLoggedIn())
     {
      
    var user = {!! auth()->check() ? auth()->user() : 'guest' !!};

    $.ajax({
     headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    method: 'POST', 
    url: 'http://localhost/blockly-web-project/game/savegame', 
    data: {'save' : this.saveObjectToString, 'user' : user.username, 'category': this.category, 'level': this.level, 'progress': this.progress }, //category + level
    success: function(response){ 
        console.log("save object sent succesfully");  
    },
    error: function(textStatus, errorThrown) {        
        console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
    }
    });

    }
                   
  }

  function updateIngameProgress(task) {

    var loggedIn = {{ auth()->check() ? 'true' : 'false' }};

    var progress = tasks[task].progress;
   

     if(isUserLoggedIn())
     {
 

    var user = {!! auth()->check() ? auth()->user() : 'guest' !!};

    $.ajax({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    method: 'POST', 
    url: 'http://localhost/blockly-web-project/game/updateingameprogress', 
    data: {'progress' : progress, 'user' : user.username, 'category': this.category, 'level': this.level }, //category + level
    success: function(response){ 
   console.log("ingameprogress object sent succesfully");  
    },
    error: function(textStatus, errorThrown) {        
   console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
   console.log(textStatus);
    }
    });

    }
              
  }
  

  function highlightBlock(id) {
      workspacePlayground.highlightBlock(id);      
    }

  function disableContextMenus(){

     Blockly.showContextMenu_ = function (e) {
        };
        Blockly.ContextMenu.show = function (e) {
        };
  }

  function runCode(){

      //run[0].setColour(0);
      var button = document.getElementById('send_code_button'); 
      button.disabled = true;   
        
      this.locked = true;
     

        if(failedBlock.length>0)
        {
          failedBlock[0].setColour(160);
          failedBlock.splice(0);
        }

        Blockly.JavaScript.STATEMENT_PREFIX = '%1\n';

        var code = Blockly.JavaScript.workspaceToCode(workspacePlayground);        
        
        this.code = code;

        sendMessage(code);
  }

    function cameraPlus(){

        var code = "camera+\n";
        
        sendMessage(code);


  }
    function cameraMinus(){

        var code = "camera-\n";
        
        sendMessage(code);

  }

    function saveGame(){

        
        var code = "save\n";

        sendMessage(code);  
        

  }

    function loadGame(){

        var code = "load\n";

        code +=  this.saveObjectToString;

        sendMessage(code);

  }

   function startGame(){

        var code = "start\n";
        code +=  this.saveObjectToString;        
        

        sendMessage(code);
  }


  function continueGame(){

    //workspacePlayground.clear();

    sendMessage("continue\n");

  }

  function reloadIframe(){

      document.getElementById("app-frame").src = document.getElementById("app-frame").src;

  }

  
  function getBlocksByType(type){

  //one type block only
  var blocks = [];
  for (var blockID in workspacePlayground.blockDB_) 
  {
    if (workspacePlayground.blockDB_[blockID].type == type) {
      blocks.push(workspacePlayground.blockDB_[blockID]);
    }
  }
  return(blocks);

  }

  function mainTaskIntroduced(task){
     
     this.task_start = Date.now();

     task = "mainTask" + task;


     var modalStructure = {
  
     title: tasks[task].introduction_modal.title, 
     text: tasks[task].introduction_modal.text,
     image: getModalImageLink(tasks[task].introduction_modal.image)

     };
     
     showDynamicModal("mainTaskIntroduced", modalStructure);

  }

  function mainTaskHelp(task){

  
  }

  function allMainTasksFinished(){    
     
     var modalStructure = {
  
     title: tasks.level.finish_modal.title,
     text: tasks.level.finish_modal.text,
     image:  getModalImageLink(tasks.level.finish_modal.image)   

     };
     
     showDynamicModal("allMainTasksFinished", modalStructure);
  }

  function levelIntroduced(task){        
       
    var modalStructure = {
  
     title: tasks.level.welcome_modal.title,
     text:  tasks.level.welcome_modal.text,
     image: getModalImageLink(tasks.level.welcome_modal.image),
     task: task 

     };

    showDynamicModal("levelIntroduced", modalStructure);
  }

  function mainTaskCompleted(task){     
    

     task = "mainTask" + task;    

     this.progress = tasks[task].progress;

     var modalStructure = {
  
     title: tasks[task].success_modal.title,
     text:  tasks[task].success_modal.text,
     image:  getModalImageLink(tasks[task].success_modal.image) 

     };

     showDynamicModal("mainTaskCompleted", modalStructure);

     updateIngameProgress(task);

  }

  function mainTaskFailed(task){

     task = "mainTask" + task;
     
     var modalStructure = {
  
     title: tasks[task].failure_modal.title,
     text:  tasks[task].failure_modal.text,
     image: getModalImageLink(tasks[task].failure_modal.image)

     };

     showDynamicModal("mainTaskFailed", modalStructure);

  }

    function commandFailed(object){
    
     console.log(object);    
     

     var title = "";
     var text = "";
     var image = "";

     if(object.commandNumber==1)
      text = "Tvoj prvý Blockly blok je chybný: <br>" 
     else if(object.commandNumber==2)
      text = "Tvoj prvý Blockly blok fungoval, ale v nasledujúcom nastala chyba: <br>"
     else 
      text = "Tvoje prvé " + (+ object.commandNumber - 1) + " Blockly bloky fungovali, ale potom nastala chyba: <br>"

      title = modals[object.failureType].modal.title;
      text +=  modals[object.failureType].modal.text; 
      image = getModalImageLink(modals[object.failureType].modal.image);


     text += "<br> Chybný blok je zafarbený na červeno."


     var modalStructure = {
  
     title: title,
     text:  text,
     image: image

     };

      showDynamicModal("mainTaskFailed", modalStructure);

  }

  function createLogOfGameplay(type, object){

   if(isUserLoggedIn())
   {
   var user =  {!! auth()->check() ? auth()->user() : 'guest' !!};
   


   //var category = this.category;
   //var level = this.level;


   var level_start = convertDateToTime(this.level_start);
   var task = object.currentMainTask;
   var task_start = convertDateToTime(this.task_start);
   var task_end = null;
   var task_elapsed_time = null;
   var code = String(object.commandArray);
   var result = type;


   switch(type)
   {

    case "mainTaskCompleted":
    {
      task_elapsed_time = this.task_end - this.task_start;      
      task_elapsed_time = task_elapsed_time / 1000;
      task_end = convertDateToTime(this.task_end);
      break;

    }
    case "commandFailed":
    {

      result = object.failureType;
      break;
    }

   }

   $.ajax({
     headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    method: 'POST', 
    url: 'http://localhost/blockly-web-project/game/createlogofgameplay', 
    data: {'username' : user.username, 'category': this.category, 'level': this.level, 'level_start': level_start,
    'task': task, 'task_start': task_start, 'task_end': task_end, 'task_elapsed_time': task_elapsed_time, 'code': code, 'result': result}, 
    success: function(response){ 
    console.log("gameplay object sent succesfully");  
    },
    error: function(textStatus, errorThrown) {        
   console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
   console.log(textStatus);
    }
    });

    }

    /*("commandFailed", 
      {
      currentMainTask: currentMainTask[3],
      failureType: failuretype,
      commandNumber: this.commandsCurrent,
      commandArray: this.commandArray                                    
      });

      ("mainTaskFailed", {
        currentMainTask: mainTaskNumber,                                                        
        commandArray: this.commandArray

        }); 

      ("mainTaskCompleted", {
        currentMainTask: taskNumber,                                                        
        commandArray: this.entity.script.commandInterpreter.commandArray                                    
      });
    */



  }

  function convertDateToTime(dateToConvert)
  {
  
  function addZero(i) {
     if (i < 10) {
      i = "0" + i;
      }
     return i;
    }

  var date = new Date(dateToConvert);
  
  var h = addZero(date.getUTCHours());
  var m = addZero(date.getUTCMinutes());
  var s = addZero(date.getUTCSeconds());
  var hms = h + ":" + m + ":" + s;
  return hms;

  }

  


  function getModalImageLink(imageType)
  {
    
    var success = "{{ asset('game/success.svg') }}";
    var failure = "{{ asset('game/failure.svg') }}";

    
    switch(imageType)
    {
      case "success":
      return success;  

      case "failure":
      return failure;     

      default:
      break;
    }

  }



  function showDynamicModal(type, modalStructure){

      var modal = '';
      var html = '';

      if(this.available_modal==1)
      {
        this.available_modal=2;
        modal = $('#centeredModal1').modal();
      }
      else
      {
        this.available_modal=1;
        modal = $('#centeredModal2').modal(); 
      }    


    switch(type)
    {

    case "levelIntroduced":
    {
     
    html =     '<br><h3>' + modalStructure.title + '</h3>';
    html +=    '<b>' + modalStructure.text + '</b>';
    
    
    if (!isUserLoggedIn())
    html +=    "<br><br>  <b> Aby sa váš postup v hre ukladal, je potrebné byť prihlásený. </b>";     
    
    modal.find('#modal-text').html(html).end();

    html =    '<object width="80%" height="80%" data="' + modalStructure.image + '" type="image/svg+xml"></object>';
    modal.find('#modal-image').html(html).end();   

    html =    '<button type="button" class="btn btn-success btn-lg" data-dismiss="modal" onclick="mainTaskIntroduced('+ modalStructure.task +')">Pokračovať</button>';
    modal.find('#modal-button').html(html).end();   

    break;

    }

    case "mainTaskIntroduced":
    {
     
    html =     '<br><h3>' + modalStructure.title + '</h3>';
    html +=    '<b>' + modalStructure.text + '</b>';
   
    
    if (!isUserLoggedIn())
    html +=    "<br><br>  <b> Aby sa váš postup v hre ukladal, je potrebné byť prihlásený. </b>";     
    
    modal.find('#modal-text').html(html).end();

    html =    '<object width="80%" height="80%" data="' + modalStructure.image + '" type="image/svg+xml"></object>';
    modal.find('#modal-image').html(html).end();   

    html =    '<button type="button" class="btn btn-success btn-lg" data-dismiss="modal" onclick="continueGame()">Pokračovať</button>';
    modal.find('#modal-button').html(html).end();   

    break;
    }

    case "mainTaskCompleted":
    {
     
    html =     '<br><h3>' + modalStructure.title + '</h3>';
    html +=    '<b>' + modalStructure.text + '</b>';
    html +=    '<br><br> <h4>Čas:</h4> <br><br> <h4>Kód:</h4> <br><br> <h4>Hodnotenie:</h4>';
    
    if (!isUserLoggedIn())
    html +=    "<br><br>  <b> Aby sa váš postup v hre ukladal, je potrebné byť prihlásený. </b>";     
    
    modal.find('#modal-text').html(html).end();

    html =    '<object width="80%" height="80%" data="' + modalStructure.image + '" type="image/svg+xml"></object>';
    modal.find('#modal-image').html(html).end();   

    html =    '<button type="button" class="btn btn-success btn-lg" data-dismiss="modal" onclick="continueGame()">Pokračovať</button>';
    modal.find('#modal-button').html(html).end();   

    break;
    }


    case "mainTaskFailed":
    {
     
    html =     '<br><h3>' + modalStructure.title + '</h3>';
    html +=    '<b>' + modalStructure.text + '</b>';
    
    
    if (!isUserLoggedIn())
    html +=    "<br><br>  <b> Aby sa váš postup v hre ukladal, je potrebné byť prihlásený. </b>";     
    
    modal.find('#modal-text').html(html).end();

    html =    '<object width="80%" height="80%" data="' + modalStructure.image + '" type="image/svg+xml"></object>';
    modal.find('#modal-image').html(html).end();   

    html =    '<button type="button" class="btn btn-success btn-lg" data-dismiss="modal" onclick="loadGame()">Skúsiť znova</button>';   
    modal.find('#modal-button').html(html).end();   

    break;
    }


    case "allMainTasksFinished":
    {
     
    html =     '<br><h3>' + modalStructure.title + '</h3>';
    html +=    '<b>' + modalStructure.text + '</b>';
    html +=    '<br><br> <h4>Čas:</h4> <br><br> <h4>Kód:</h4> <br><br> <h4>Hodnotenie:</h4>';
    
    if (!isUserLoggedIn())
    html +=    "<br><br>  <b> Aby sa váš postup v hre ukladal, je potrebné byť prihlásený. </b>";     
    
    modal.find('#modal-text').html(html).end();

    html =    '<object width="80%" height="80%" data="' + modalStructure.image + '" type="image/svg+xml"></object>';
    modal.find('#modal-image').html(html).end();   

    
    html = '<button type="button" class="btn btn-success btn-lg" data-dismiss="modal" onclick="window.location.href=\''; 
    html += '{{ url('/')}}' + '/game/1/' + (this.level+1) + '\';">Pokračovať</button>';  
   
    modal.find('#modal-button').html(html).end();   

    break;
    }





    } 
    

    modal.modal('show');


  }


  function sendMessage(messageForGame){
    

        var iframe = document.getElementById("app-frame");
        
        iframe.contentWindow.postMessage
        (
        { message: messageForGame }, 
        //"https://playcanv.as/p/62c28f63/"
        "http://localhost/blockly-web-project/public/game/playcanvas/index.html"
        );

  }

  function isUserLoggedIn(){
    
  var loggedIn = {{ auth()->check() ? 'true' : 'false' }};
  if (loggedIn)  
    return true;  
  else   
    return false;
  }

</script>


</body>
</html>


