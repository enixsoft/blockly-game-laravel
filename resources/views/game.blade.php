<!DOCTYPE html>
<html lang="sk">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
            <div>
                <button type="button" id="click_button" class="btn btn-success btn-lg">Spustit</button>
                <button type="button" class="btn btn-lg btn-primary"
                data-toggle="modal" data-target="#mainModal">Main modal</button>               
                <button type="button" id="camera_plus_button" class="btn btn-success btn-lg">Kamera +</button>
                <button type="button" id="camera_minus_button" class="btn btn-success btn-lg">Kamera -</button>
                <button class="btn btn-danger
                     btn-lg" id="restart_button">Restart</button>
                <button class="btn btn-danger
                     btn-lg" id="reload_button">Reload</button>
            </div>
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
       <block type="player" movable="false" deletable="false" inline="false" x="50" y="70">
        </block>
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
// Create IE + others compatible event handler
var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
var eventer = window[eventMethod];
var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";

// Listen to message from child window
eventer(messageEvent,function(e) {
  console.log('parent received message!:  ',e.data);
  
  if(e.data === "unlock")
  { 
      var button = document.getElementById('click_button');
      button.disabled = false;
      //$("#click_button").removeClass("btn-danger").addClass("btn-success");
      workspacePlayground.highlightBlock(null);
      


  }
  else if (e.data === "death")
  {
    // you died window
    workspacePlayground.highlightBlock(null);
  }
  else if (e.data === "uiHelp")
  {    
       $('#mainModal').modal('show');
  }
  else
  {
    console.log(e.data);
    if(e.data.action=="highlightProgress")
    {
    highlightBlock(e.data.id);
    }
    else
    {

      //COMMAND FAILED BLOCK IS RED
    
      console.log(workspacePlayground.getBlockById(e.data.id));
      block = workspacePlayground.getBlockById(e.data.id);
      block.setColour(0);
      failedBlock.push(block);
    }
  }
},false);

  var failedBlock = [];


 

  var toolbox = {!! json_encode($xmltest) !!};  

  var blocklyArea = document.getElementById('blocklyArea');
  var blocklyDiv = document.getElementById('blocklyDiv');

  var workspacePlayground = Blockly.inject(blocklyDiv,
      {toolbox: toolbox, trashcan: true });

  Blockly.Xml.domToWorkspace(document.getElementById('startBlocks'),
                               workspacePlayground);
  
  


  var player = getBlocksByType("player");

  disableContextMenus();

  function blockClickController(event) {  


    if(event.element=="click")
    {     
  
      blockToCheck = Blockly.selected;
     
      if(blockToCheck.id == player[0].id)
      {
    
        console.log("clicked")
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
     

  function highlightBlock(id) {
      workspacePlayground.highlightBlock(id);      
    }

  function disableContextMenus(){

     Blockly.showContextMenu_ = function (e) {
        };
        Blockly.ContextMenu.show = function (e) {
        };
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



  $(document).ready(function(){
    $("#click_button").click( function(){        
        

        var button = document.getElementById('click_button'); 
        button.disabled = true;       
        
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




    });
  });

  $(document).ready(function(){
    $("#restart_button").click( function(){        
        

        var code = "restart\n";

        var iframe = document.getElementById("app-frame");
        
        iframe.contentWindow.postMessage
        (
        { message: code, }, 
        "https://playcanv.as/p/62c28f63/"
        );




    });
  });
 
  $(document).ready(function(){
    $("#reload_button").click( function(){        
        
        document.getElementById("app-frame").src = document.getElementById("app-frame").src;



    });
  });


   $(document).ready(function(){
    $("#camera_plus_button").click( function(){        
        

        var code = "camera+\n";

        var iframe = document.getElementById("app-frame");
        
        iframe.contentWindow.postMessage
        (
        { message: code, }, 
        "https://playcanv.as/p/62c28f63/"
        );




    });
  });

      $(document).ready(function(){
    $("#camera_minus_button").click( function(){        
        

        var code = "camera-\n";

        var iframe = document.getElementById("app-frame");
        
        iframe.contentWindow.postMessage
        (
        { message: code, }, 
        "https://playcanv.as/p/62c28f63/"
        );




    });
  });
</script>

@include('modals')

</body>
</html>


