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
                data-toggle="modal" data-target="#myModal">Large modal</button>
                <button class="btn btn-primary btn-lg" data-toggle="modal"
                data-target="#myModal2">Launch demo modal 2</button>
                     <button class="btn btn-danger
                     btn-lg" id="restart_button">Restart</button>
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
  else
  {
    console.log(e.data);
    highlightBlock(e.data);
  }
},false);


 
  var toolbox = {!! json_encode($xmltest) !!};  

  var blocklyArea = document.getElementById('blocklyArea');
  var blocklyDiv = document.getElementById('blocklyDiv');

  var workspacePlayground = Blockly.inject(blocklyDiv,
      {toolbox: toolbox });

  Blockly.Xml.domToWorkspace(document.getElementById('startBlocks'),
                               workspacePlayground);
  
  


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

</script>

<script>
  $(document).ready(function(){
    $("#click_button").click( function(){        
        

        var button = document.getElementById('click_button'); 
        button.disabled = true;       
        //$("#click_button").removeClass("btn-success").addClass("btn-danger");


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
</script>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="vertical-alignment-helper">
    <div class="vertical-align-center modal-dialog modal-lg">     
    <div class="modal-content">       
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                    </button>
          <!--<h4 class="modal-title text-center form-title">Prihlásenie</h4>-->

        </div>
  
  <div class="modal-body">
  <div class="container">
    <div class="row">
      <div class="col-md-6"><h2>Blockly je grafické programovacie prostredie, vyvinuté spoločnosťou Google v roku 2012. <br> Tento vizuálny jazyk vám umožní rýchlo pochopiť základy logického prenosu dát a inštrukcií, zoznámiť sa s cyklami, operátormi, postupmi, funkciami, premenné jazyka JavaScript a všeobecne umožňujú rozvíjať myslenie</h2></div>
      <div class="col-md-6">
        <div id="modal-mascot">
                            <object width="100%" height="100%" data="blockly_files/SVG_Logo.svg" type="image/svg+xml"></object>
        </div>
      </div>
      </div> 
   
      <div class="row">     
      <div class="col-4 mx-auto"><button type="button" id="click_button" class="btn btn-success btn-lg">Spustiť</button></div>   
     </div>
    </div>
                          
  </div>
  </div>
      
</div>
</div>
</div>






<!-- Modal -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center" style="width: 900px;" >
            <div class="modal-content">
                <div class="modal-header">
                   
                   
                      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>

                    </button>

                </div>
                <div class="modal-body">
                    <div class="container">
    <div class="row">
      <div class="col-md-6">Blockly je grafické programovacie prostredie, vyvinuté spoločnosťou Google v roku 2012. <br> Tento vizuálny jazyk vám umožní rýchlo pochopiť základy logického prenosu dát a inštrukcií, zoznámiť sa s cyklami, operátormi, postupmi, funkciami, premenné jazyka JavaScript a všeobecne umožňujú rozvíjať myslenie</div>
      <div class="col-md-6">
        <div id="modal-mascot">
                            <object width="100%" height="100%" data="blockly_files/SVG_Logo.svg" type="image/svg+xml"></object>
        </div>
      </div>
      </div>       
      <div class="row">     
      <div class="col-2 mx-auto"><button type="button" id="click_button" class="btn btn-success btn-lg" data-dismiss="modal">Spustiť</button></div>   
     </div>
    </div>
                          
  </div>


                </div>
            
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">    
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                   
                   
                      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>

                    </button>

                </div>
                <div class="modal-body">
                    <div class="container">
    <div class="row">
      <div class="col-md-6"><h2>Blockly je grafické programovacie prostredie, vyvinuté spoločnosťou Google v roku 2012. <br> Tento vizuálny jazyk vám umožní rýchlo pochopiť základy logického prenosu dát a inštrukcií, zoznámiť sa s cyklami, operátormi, postupmi, funkciami, premenné jazyka JavaScript a všeobecne umožňujú rozvíjať myslenie</h2></div>
      <div class="col-md-6">
        <div id="modal-mascot">
                            <object width="100%" height="100%" data="blockly_files/SVG_Logo.svg" type="image/svg+xml"></object>
        </div>
      </div>
      </div>       
         
      <div class="col-5 mx-auto"><button type="button" id="click_button" class="btn btn-success btn-lg">Spustiť</button></div>   
   </div> 
    </div>
                          
  </div>


                </div>
            
            </div>
        </div>
    </div>



              



</body>
</html>


