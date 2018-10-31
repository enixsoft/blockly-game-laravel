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
  <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/imagehover.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="css/extrastyle.css">
  
<script src="js/jquery.min.js"></script>
<script src="js/jquery.easing.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/custom.js"></script>

@if ($errors->all())  
<script type="text/javascript">
  $(document).ready(function () {
    $('#loginModal').modal('show');
    });
</script>        
@endif

<script type="text/javascript">
  $(document).ready(function () {
    $('#welcomeModal').modal('show');
    });
</script>    




</head>

<body>

@include('header')





<div class="container-fluid">
    <div class="row row-full">
        <div class="col-md-6">
            <div class="leftside">
                <iframe id="app-frame" style="width:100%;height:100%;overflow:hidden;border:none;"
                src="https://playcanv.as/e/p/62c28f63/"></iframe>
            </div>
        </div>
        <div class="col-md-6">
            <div id="blocklyArea" class="rightside"></div>
        </div>
    </div>
</div>



<div id="blocklyDiv" style="position: absolute"></div>
</div>



<script src="blockly/blockly_compressed.js"></script>
<script src="blockly/blocks_compressed.js"></script>
<script src="blockly/javascript_compressed.js"></script>
<script src="blockly/msg/js/en.js"></script>
<script src="blockly_files/blockdefinitions.js"></script>


<xml id="startBlocks" style="display: none">
       <block type="player" movable="false" deletable="false" inline="false" x="50" y="70"></block>
       <block type="run" movable="false" deletable="false" inline="false" x="50" y="1000"></block>
       <block type="cameraplus" movable="false" deletable="false" inline="false" x="250" y="1000"></block> 
       <block type="cameraminus" movable="false" deletable="false" inline="false" x="450" y="1000"></block>
       <block type="save" movable="false" deletable="false" inline="false" x="250" y="900"></block>
       <block type="load" movable="false" deletable="false" inline="false" x="450" y="900"></block>       
       <block type="restart" movable="false" deletable="false" inline="false" x="650" y="1000"></block>
       <block type="reload" movable="false" deletable="false" inline="false" x="850" y="1000"></block>        
</xml>

<!--<xml id="toolbox" style="display: none">
  <block type="logic_operation"></block>
  <label text="A label" web-class="myLabelStyle"></label>
  <label text="Another label"></label>
  <block type="logic_negate"></block>
  <button text="A button" callbackKey="myFirstButtonPressed"></button>
  <block type="logic_boolean"></block>
</xml>

<style>
.myLabelStyle>.blocklyFlyoutLabelText {
  font-style: italic;
  fill: green;
}
</style>
-->
<script>

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
      run[0].setColour(95);
      workspacePlayground.highlightBlock(null);
      locked = false;
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
      $('#mainModal').modal('show');
      break;     
    }
     case "uiPlay":
    {
     if(locked==false)
          runCode();
     break;     
    }    
    case "start":
    {
     startGame();
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
    case "save":
    {
      console.log("save object arrived");    
      saveObjectToJson(e.data.content);
      break;     
    }

  }

},false);

  var failedBlock = []; 
 

  var toolbox = {!! json_encode($xmltest) !!};

  var savedGame = {!! $savedGame !!};
  console.log(savedGame);
  
  this.saveObjectToString = savedGame.json;
  this.autosaveEnabled = true;
   

  var blocklyArea = document.getElementById('blocklyArea');
  var blocklyDiv = document.getElementById('blocklyDiv');

  var workspacePlayground = Blockly.inject(blocklyDiv,
      {toolbox: toolbox, trashcan: true});

  Blockly.Xml.domToWorkspace(document.getElementById('startBlocks'),
                              workspacePlayground);
  
  
  
  var loggedIn = {{ auth()->check() ? 'true' : 'false' }};
  if (loggedIn)
    console.log("logged in");
  else
   console.log("guest");


  var run = getBlocksByType("run");
  var cameraplus = getBlocksByType("cameraplus");
  var cameraminus = getBlocksByType("cameraminus");
  var load = getBlocksByType("load");
  var save = getBlocksByType("save");
  var restart = getBlocksByType("restart");
  var reload = getBlocksByType("reload");
  var locked = false;

  //workspacePlayground.zoom(50, 1000, -1);

  //console.log(Blockly.mainWorkspace.getMetrics());



  disableContextMenus();

  function blockClickController(event) {  


    if(event.element=="click")
    {     
  
      blockToCheck = Blockly.selected;
     
 
      if(blockToCheck.id == run[0].id)
      {
        
        if(locked==false)
          runCode();
        blockToCheck.unselect();
      }
        else if(blockToCheck.id == cameraplus[0].id)
      {
         cameraPlus();
        ;
         blockToCheck.unselect();
        
      }
      else if(blockToCheck.id == cameraminus[0].id)
      {
        cameraMinus();
      
        blockToCheck.unselect();
      }
      else if(blockToCheck.id == restart[0].id)
      {
        console.log("clicked restart");
        restartGame();
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
disableContextMenus();


  

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
  };
  window.addEventListener('resize', onresize, false);
  onresize();


  Blockly.svgResize(workspacePlayground);
     
  function saveObjectToJson(object) {
      
      var myJSON = JSON.stringify(object);
      this.saveObjectToString = myJSON;
      console.log(myJSON);               
    }

  function saveJsonToDatabase() {

     var loggedIn = {{ auth()->check() ? 'true' : 'false' }};
    
     if (loggedIn)
     {
      
      var user = {!! auth()->check() ? auth()->user() : 'guest' !!};

    $.ajax({
     headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    method: 'POST', 
    url: 'game/savegame', 
    data: {'save' : this.saveObjectToString, 'user' : user.username}, //category + level
    success: function(response){ 
        console.log("save object sent succesfully");  
    },
    error: function(textStatus, errorThrown) {        
        console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
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

        //var button = document.getElementById('click_button'); 
        //button.disabled = true;   
        
        locked = true;

        run[0].setColour(0);

        if(failedBlock.length>0)
        {
          failedBlock[0].setColour(160);
          failedBlock.splice(0);
        }

        Blockly.JavaScript.STATEMENT_PREFIX = '%1\n';

        var code = Blockly.JavaScript.workspaceToCode(workspacePlayground);
        console.log(code);

        var blocks = workspacePlayground.getAllBlocks();
        console.log(blocks)

        var iframe = document.getElementById("app-frame");
        
        iframe.contentWindow.postMessage
        (
        { message: code, }, 
        "https://playcanv.as/p/62c28f63/"
        );


  }

    function cameraPlus(){

        var code = "camera+\n";

        var iframe = document.getElementById("app-frame");
        
        iframe.contentWindow.postMessage
        (
        { message: code, }, 
        "https://playcanv.as/p/62c28f63/"
        );


  }
    function cameraMinus(){

       var code = "camera-\n";

        var iframe = document.getElementById("app-frame");
        
        iframe.contentWindow.postMessage
        (
        { message: code, }, 
        "https://playcanv.as/p/62c28f63/"
        );

  }

    function saveGame(){

        
        var code = "save\n";

        var iframe = document.getElementById("app-frame");
        
        iframe.contentWindow.postMessage
        (
        { message: code, }, 
        "https://playcanv.as/p/62c28f63/"
        );
        
        //saveJsonToDatabase();

  }
    function loadGame(){

        var code = "load\n";

        code +=  this.saveObjectToString;


        var iframe = document.getElementById("app-frame");
        
        iframe.contentWindow.postMessage
        (
        { message: code, }, 
        "https://playcanv.as/p/62c28f63/"
        );


  }
  function restartGame(){


        var code = "restart\n";

        var iframe = document.getElementById("app-frame");
        
        iframe.contentWindow.postMessage
        (
        { message: code, }, 
        "https://playcanv.as/p/62c28f63/"
        );


  }

  function startGame(){


        var code = "start\n";

        code +=  this.saveObjectToString;

        console.log(code);


        var iframe = document.getElementById("app-frame");
        
        iframe.contentWindow.postMessage
        (
        { message: code, }, 
        "https://playcanv.as/p/62c28f63/"
        );


  }

    function reloadIframe(){

      document.getElementById("app-frame").src = document.getElementById("app-frame").src;

  }

    //one type block only
  function getBlocksByType(type) 
  {
  var blocks = [];
  for (var blockID in workspacePlayground.blockDB_) 
  {
    if (workspacePlayground.blockDB_[blockID].type == type) {
      blocks.push(workspacePlayground.blockDB_[blockID]);
    }
  }
  return(blocks);
  }


</script>

@include('modals')

</body>
</html>


