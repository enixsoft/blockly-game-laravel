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
</head>

<body>
@include('header')




<div class="container-fluid">
  <div class="row row-full">
    <div class="col-sm-6">
      <div class="leftside">
       <iframe style="width:100%;height:100%;overflow:hidden;border:none;" src="https://playcanv.as/p/62c28f63/"></iframe>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="rightside">
         <div class="centered">   
    <h2>Blockly</h2>
    <p>Blockly will go here.</p>
  </div>
      </div>
    </div>
  </div>
</div>








</body>

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
</html>


