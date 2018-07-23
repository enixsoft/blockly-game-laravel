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
  

  <script src="js/jquery.min.js"></script>
  <script src="js/jquery.easing.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/custom.js"></script>

</head>

<body>
@include('header')

<div class="banner">
    <div class="bg-color">
      <div class="container">
        <div class="row">
          <div class="banner-text text-center">
            <div class="text-border">
              <h2 class="text-dec">Blockly hra</h2>
            </div>
            <div class="intro-para text-center quote">
              <p class="big-text">Ako sa naučiť programovať</p>
              <p class="small-text">                
                Blockly je grafické programovacie prostredie, vyvinuté spoločnosťou Google v roku 2012. <br> Tento vizuálny jazyk vám umožní rýchlo pochopiť základy logického prenosu dát a inštrukcií, zoznámiť sa s cyklami, operátormi, postupmi, funkciami, premenné jazyka JavaScript a všeobecne umožňujú rozvíjať myslenie</p>
              <a href="{{ route('game') }}" class="btn get-quote btn-lg" style="size: ">SPUSTIŤ HRU</a>
            </div>
          
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
  <div class="row">
  <section id="feature" class="section-padding">
    <div class="header-section text-center">
         <h2>Features</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Exercitationem
            nesciunt vitae,
            <br>maiores, magni dolorum aliquam.</p>
        <hr class="bottom-line">
    </div>

    <div class="feature-info">
        <div class="fea">
            <div class="container">
            <div class="row">
            <div class="col-lg-4">
                <div class="heading float-right">
                     <h4>Latest Technologies</h4>
                    <p>Donec et lectus bibendum dolor dictum auctor in ac erat. Vestibulum egestas
                        sollicitudin metus non urna in eros tincidunt convallis id id nisi in interdum.</p>
                </div>
                <div class="fea-img float-left"> <i class="fa fa-css3"></i>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="heading float-right">
                     <h4>Toons Background</h4>
                    <p>Donec et lectus bibendum dolor dictum auctor in ac erat. Vestibulum egestas
                        sollicitudin metus non urna in eros tincidunt convallis id id nisi in interdum.</p>
                </div>
                <div class="fea-img float-left"> <i class="fa fa-drupal"></i>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="heading float-right">
                     <h4>Award Winning Design</h4>
                    <p>Donec et lectus bibendum dolor dictum auctor in ac erat. Vestibulum egestas
                        sollicitudin metus non urna in eros tincidunt convallis id id nisi in interdum.</p>
                </div>
                <div class="fea-img float-left"> <i class="fa fa-trophy"></i>
                </div>
            </div>
        </div>
    </div>
    </div>
      </div>

      

</section>
    </div>
    </div>
 

  <section id="testimonial" class="section-padding"> 
        <div class="header-section text-center">
          <h2 class="white">Komentáre</h2>
          <p class="white">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Exercitationem nesciunt vitae,<br> maiores, magni dolorum aliquam.</p>
          <hr class="bottom-line bg-white">
        </div>   
</section>


<section id="screenshots" class="section-padding">
    <div class="header-section text-center">
         <h2>Ukazky</h2>
        <p>Text,
            <br>text.</p>
        <hr class="bottom-line">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <img src="img/screenshot.jpg" class="img-fluid">
                </div>
                <div class="col-lg-4">
                    <img src="img/screenshot.jpg" class="img-fluid">
                </div>
                <div class="col-lg-4">
                    <img src="img/screenshot.jpg" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>

@include('footer')
</body>


@if ($errors->all())  
<script type="text/javascript">
  $(document).ready(function () {
    $('#loginModal').modal('show');
    });
</script>        
@endif 

</html>


