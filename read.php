<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once 'config.php';
    
    // Prepare a select statement
     $sql = "SELECT * FROM carinfo WHERE id = :id";
	
    
    if($stmt = $pdo->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(':id', $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
       
		
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            if($stmt->rowCount() == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Retrieve individual field value
                $Year = $row["Year"];
                $Make = $row["Make"];
                $Model = $row["Model"];
                $VID = $row["VID"];
				$Mileage = $row["CurrentMileage"];
                $Tag = $row["LicenseTag"];
                $InsCarrier = $row["InsuranceProvider"];
                $InsPlcy = $row["InsurancePolicy"];

            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    unset($stmt);
    
    // Close connection
    unset($pdo);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html">
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
<!--
body,td,th {
	color: LightGray;
}
body {
	background-color: SlateGray;
}
a:link {
	color: White;
}
-->
</style>
    
</head>
<body>
    
    <div class="container">
	 <!–– displays menu ––> 
    <header>
    	<div id="header">
        </div>
    </header>
    
    <div class="wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="page-header"style = "width:200px; color:LightBlue;">
                        <h1>View Record</h1>
                    </div>
                    <form class="form-inline">
                        <div class="form-group mb-2">
                            <div class="col-lg-12">Year:</div>
                            <p class="form-control"><?php echo $Year; ?></p>
                        </div>
                        <div class="form-group mb-2">
                            <div class="col-lg-12">Make:</div>
                            <p class="form-control"><?php echo $Make; ?></p>
                        </div>
                        <div class="form-group mb-2">
                            <div class="col-lg-12">Model:</div>
                            <p class="form-control"><?php echo $Model; ?></p>
                        </div>
                    </form>
                    <div class="form-group">
                        <div class="col-sm-4">VIN:</div>
                        <p class="form-control-static"><?php echo $VID; ?></p>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4">Mileage:</div>
                        <p class="form-control-static"><?php echo $Mileage; ?></p>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4">TAG:</div>
                        <p class="form-control-static"><?php echo $Tag; ?></p>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4">Insurance Carrier:</div>
                        <p class="form-control-static"><?php echo $InsCarrier; ?></p>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4">Insurance Policy:</div>
                        <p class="form-control-static"><?php echo $InsPlcy; ?></p>
                    </div>

                    <p><a href="carinfo.php" class="btn btn-default">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>