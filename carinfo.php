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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>
        $(function() {
          $('#header').load('menu.html');
      });
  </script>
  


  <style type="text/css">
  body,td,th {
   color: LightGray;
}
body {
    background-color: SlateGray;
}
a:link {
    color: White;
}
</style>

<style type="text/css">
html {
  height: 100%;
}
body {
  min-height: 100%;
  display: grid;
  grid-template-rows: 1fr auto;
}
.footer {
  font-size: 20px;
  background-color: SlateGray;
  grid-row-start: 2;
  grid-row-end: 3;
}    

</style>

</head>

<body id="carinfo" data-spy="scroll" data-target=".navbar" data-offset="50">

    <div class="container">
       <header>
           <div id="header">
           </div>
       </header>
       
       <div id = "CarInfo" class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left" style = "width:200px; color:LightBlue;">Our Cars</h2>
                        <a href="create.php" class="btn btn-success btn-sm pull-right">Add New Car</a>
                    </div>
                    <?php
                        // Include config file
                    require_once 'config.php';
                    
                        // Attempt select query execution
                    $sql = "SELECT * FROM carinfo";
                    if($result = $pdo->query($sql)){
                        if($result->rowCount() > 0){
                            // echo "<table class='table table-bordered table-striped'>";
                            echo "<table class='table table-bordered'>";
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th><h3><font color=LightBlue>#</h2></th>";
                            echo "<th><h3><font color=LightBlue>Year</h2></th>";
                            echo "<th><h3><font color=LightBlue>Make</h2></th>";
                            echo "<th><h3><font color=LightBlue>Model</h2></th>";
                            echo "<th><h3><font color=LightBlue>Action</h2></th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            while($row = $result->fetch()){
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>"; 
                                echo "<td>" . $row['Year'] . "</td>";
                                echo "<td>" . $row['Make'] . "</td>";
                                echo "<td>" . $row['Model'] . "</td>";
                                echo "<td>";
                                echo "<span style='font-size:1.5em;' class='glyphicon glyphicon-eye-open'></span>";
                                echo "<a href='read.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-list-alt' style='color:lightgreen'></span></a>";
                                echo "<a href='update.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'style='color:orange'></span></a>";
                                echo "<a href='delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'style='color:red'></span></a>";
                                echo "<a href='service.php?id=". $row['id'] ."&car=". $row['Model']."' title='Service Maintenance' data-toggle='tooltip'><span class='glyphicon glyphicon-wrench'style='color:LightBlue'></span></a>";
                                echo "<a href='schmaint.php?id=". $row['id'] ."&car=". $row['Model']."' title='Scheduled Maintenance' data-toggle='tooltip'><span class='glyphicon glyphicon-calendar'style='color:yellow'></span></a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";                            
                            echo "</table>";
                                // Free result set
                            unset($result);
                            //document.write("Success");
                        } else{
                            echo "<p class='lead'><em>No records found.</em></p>";
                        }
                    } else{
                        echo "<p class='lead'><em>ERROR: Unable to execute $sql. " . $mysqli->error . "</em></p>";
                    }
                    
                        // Close connection
                    unset($pdo);
                    ?>
                </div>
            </div>        
        </div>
    </div>
<footer class="footer" style="color:white">powered by LAMPP / XAMPP</footer>
</body>
</html>