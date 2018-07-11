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
    <div class="col-sm-6">
      <div class="leftside">
       <iframe id="app-frame" style="width:100%;height:100%;overflow:hidden;border:none;" src="https://playcanv.as/e/p/62c28f63/"></iframe>
      </div>
    </div>
    <div class="col-sm-6">
      <div id="blocklyArea" class="rightside">      
      </div>
      <div>
        <button type="button" id="click_button" class="btn btn-success btn-lg">Spustiť</button>
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





<script>
 
  var toolbox = {!! json_encode($xmltest) !!};
  

  var blocklyArea = document.getElementById('blocklyArea');
  var blocklyDiv = document.getElementById('blocklyDiv');
  var workspacePlayground = Blockly.inject(blocklyDiv,
      {toolbox: toolbox });
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
</script>

<script>
  $(document).ready(function(){
    $("#click_button").click(function(){
        
        alert('button clicked');
        
        var iframe = document.getElementById("app-frame");
        
        iframe.contentWindow.postMessage
        (
        { score: "123456", }, 
        "https://playcanv.as/p/62c28f63/"
        );  

    });
  });
</script>




</body>
</html>


