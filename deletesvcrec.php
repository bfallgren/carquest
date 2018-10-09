<?php
// Process delete operation after confirmation using PDO

if(isset($_POST["id"]) && !empty($_POST["id"]) &&
isset($_POST["rec_No"]) && !empty($_POST["rec_No"]))
{
    // Include config file
    require_once 'config.php';
    
// start transaction
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  	$pdo->beginTransaction();


// Prepare a delete statement
    $sql = "DELETE FROM service WHERE id = :id and rec_No = :rec_No";
    
    if($stmt = $pdo->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(':id', $param_id);
        $stmt->bindParam(':rec_No', $param_rec_No);

        // Set parameters
        $param_id = trim($_POST["id"]);
        $param_rec_No = trim($_POST["rec_No"]);

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Records deleted successfully. Redirect to landing page
            //header("location: carinfo.php");
            //exit();
        } else{
				$pdo->rollBack();              
            echo "<p class='lead'><em>No records found for service.</em></p>";
            exit();
        }
    }    
    
        
    // commit transactions
    $pdo->commit();
    echo "<p class='lead'><em>Successful transaction.</em></p>";
    //sleep(10);
    header("location: carinfo.php");
     
    // Close statement
    unset($stmt);
    
    // Close connection
    unset($pdo);
} else{
    // Check existence of id parameter
    if(empty(trim($_GET["id"]))){
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
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
	<header>
    	<div id="header">
        </div>
    </header>
    
   
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>Delete Record</h1>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger fade in">
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                            <input type="hidden" name="rec_No" value="<?php echo trim($_GET["rec_No"]); ?>"/>
                            <p>Are you sure you want to delete this service record?</p><br>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="carinfo.php" class="btn btn-default">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>