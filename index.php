<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>CarQuest</title>
   
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
   <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
   <link rel="stylesheet" type="text/css" href="style.css">
   <link rel="shortcut icon" type="image/png" href="http://localhost/CarQuest/mycorvetteicon.png" sizes="228x228">
   <link rel="icon" type="image/png" href="http://localhost/CarQuest/mycorvetteicon.png" sizes="228x228"> 
     
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <script>
   	$(function() {
			   $('#header').load('menu.html');
			   });
	</script>
 
   
<style type="text/css">
<!--
body,td,th {
	color: LightGray;
}
body {
	background-color: SlateGray;
}
-->
</style>

</head>

<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="50">


<div class="container">
<header>
    	<div id="header">
        </div>
    </header>
    
  
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <img src="NCM.JPG" alt="NCM" width="1984" height="1488">
        <div class="carousel-caption">
          <h3>NCM</h3>
          <p>The National Corvette Museum - Bowling Green, Kentucky</p>
        </div>      
      </div>

      <div class="item">
        <img src="C7Stingray.JPG" alt="Stingray" width="1600" height="1200">
        <div class="carousel-caption">
          <h3>stingray 2LT</h3>
        </div>      
      </div>
    
      <div class="item">
        <img src="Happy Halloween Corvette.jpg" alt="Trick-R-Treat" width="1023" height="580">
        <div class="carousel-caption">
        </div>      
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
</div>


</body>
</html>