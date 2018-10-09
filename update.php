<?php
// Include config file
require_once 'config.php';
// REPORT ALL MYSQL ERRORS
error_reporting(E_ALL); 
ini_set("display_errors", 1);

// Define variables and initialize with empty values
$year = $make = $model =  $vid = $mileage = $tag = $insCarrier = $insPlcy = "";
$year_err = $make_err = $model_err  =  $vid_err = $mileage_err  = "";

 // print_r($_SERVER);

// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    // echo '<script>console.log("PHP Log:: $_POST Request")</script>';

    $id = $_POST["id"];
    

    // Validate year
    $input_year = trim($_POST["year"]);
    if(empty($input_year)){
        $year_err = "Please enter the year.";     
    } elseif(!ctype_digit($input_year)){
        $year_err = 'Please enter a positive integer value.';
    } else{
        $year = $input_year;
    }

    // Validate make
    $input_make = trim($_POST["make"]);
    if(empty($input_make)){
        $make_err = "Please enter a make.";
    } else{
        $make = $input_make;
    }
    
    // Validate model 
    $input_model = trim($_POST["model"]);
    if(empty($input_model)){
        $model_err = 'Please enter a model.';     
    } else{
        $model = $input_model;
    }
    
    // Validate VIN
    
    $input_vid = trim($_POST["vid"]);
    if(($input_vid != "") && (mb_strlen($input_vid) <> 17)) {
        $vid_err = 'Please enter 18 character VIN';
    } else{
        $vid = $input_vid;
    }   
    
    // Validate mileage
    
    $input_mileage = trim($_POST["mileage"]);
    if(($input_mileage != "") && (!is_numeric($input_mileage))) {
        $mileage_err = 'Mileage must be a number';
    } else{
        $mileage = $input_mileage;
    }  
    
    $tag = trim($_POST["tag"]);

    $insCarrier = trim($_POST["insCarrier"]);

    $insPlcy = trim($_POST["insPlcy"]);
    

   // Check input errors before inserting in database
    if(empty($year_err) && empty($make_err) && empty($model_err) && empty($vid_err) && empty($mileage_err)){
        // Prepare an insert statement
        // note the name=value pairs are not case sensitive for name but are case sensitive for value
        $sql = "UPDATE carinfo SET make=:Make, model=:Model, year=:Year, vid=:VID, currentmileage=:CurrentMileage, licensetag=:LicenseTag, insuranceprovider=:InsuranceProvider, insurancepolicy=:InsurancePolicy WHERE id=:id";
         echo '<script>console.log("PHP Log:: SQL Update")</script>';
         var_dump($mileage);

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':Make', $param_make);
            $stmt->bindParam(':Model', $param_model);
            $stmt->bindParam(':Year', $param_year);
            $stmt->bindParam(':VID', $param_vid);
            $stmt->bindParam(':CurrentMileage', $param_mileage);
            $stmt->bindParam(':LicenseTag', $param_tag);
            $stmt->bindParam(':InsuranceProvider', $param_insCarrier);
            $stmt->bindParam(':InsurancePolicy', $param_insPlcy);
            $stmt->bindParam(':id', $param_id);
            
            // Set parameters
            $param_make = $make;
            $param_model = $model;
            $param_year = $year;
            $param_vid = $vid;
            $param_mileage = $mileage;
            $param_tag = $tag;
            $param_insCarrier = $insCarrier;
            $param_insPlcy = $insPlcy;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            echo '<script>console.log("PHP Log:: SQL Execute")</script>';
            if($stmt->execute()){
                // Records updated successfully. Redirect to landing page
                header("location: carinfo.php");
                exit();
            } else{
                //print_r($stmt->errorInfo());
                echo '<script>console.log("PHP Log:: SQL Update FAILED")</script>';
            }
        }

        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($pdo);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        

        // Prepare a select statement
        $sql = "SELECT * FROM carinfo WHERE id = :id";
        // echo '<script>console.log("PHP Log:: SQL Select")</script>';
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':id', $param_id);
            

            $param_id = $id;
        // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    // Retrieve individual field value
                    
                    $make = $row["Make"];
                    $model = $row["Model"];
                    $year = $row["Year"];
                    $vid = $row["VID"];
                    $mileage = $row["CurrentMileage"];
                    $tag = $row["LicenseTag"];
                    $insCarrier = $row["InsuranceProvider"];
                    $insPlcy = $row["InsurancePolicy"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "<p class='lead'><em>PDO error</em></p>";
            }
        }
        
        // Close statement
        unset($stmt);
        
        // Close connection
        unset($pdo);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        echo "<p class='lead'><em>malformed URL.</em></p>";
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
input[type=text] {
    border: 2px solid cyan;
    border-radius: 4px;
    background-color: SlateGray;
    color: LightGray;
}
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
                        <div class="page-header">
                            <h2>Update Record</h2>
                        </div>
                        
                        <!–– input form (name=) must match $_POST variable name ––> 
                        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                            <div class="form-group <?php echo (!empty($year_err)) ? 'has-error' : ''; ?>">
                                
                                    <label>Year</label>
                                    <input type="text" name="year" color: #000 size=4 value="<?php echo $year; ?>">
                                    <span class="help-block"><?php echo $year_err;?></span>
                                
                            </div>
                            <div class="form-group <?php echo (!empty($make_err)) ? 'has-error' : ''; ?>">
                                
                                    <label>Make</label>
                                    <input type="text" name="make" size=16 value="<?php echo $make; ?>">
                                    <span class="help-block"><?php echo $make_err;?></span>
                               
                            </div>
                            <div class="form-group <?php echo (!empty($model_err)) ? 'has-error' : ''; ?>">
                                
                                    <label>Model</label>
                                    <input type="text" name="model" size=16 value="<?php echo $model; ?>">
                                    <span class="help-block"><?php echo $model_err;?></span>
                               
                            </div>
                            <div class="form-group <?php echo (!empty($vid_err)) ? 'has-error' : ''; ?>">
                                
                                    <label>VIN</label>
                                    <input type="text" name="vid" size=18 value="<?php echo $vid; ?>">
                                    <span class="help-block"><?php echo $vid_err;?></span>
                               
                            </div>
                            <div class="form-group <?php echo (!empty($mileage_err)) ? 'has-error' : ''; ?>">
                                
                                    <label>Mileage</label>
                                    <input type="text" name="mileage" size=8 value="<?php echo $mileage; ?>">
                                    <span class="help-block"><?php echo $mileage_err;?></span>
                               
                            </div>
                            <div class="form-group">
                                
                                    <label>Tag</label>
                                    <input type="text" name="tag" size=8 value="<?php echo $tag; ?>">
                                                                   
                            </div>
                            <div class="form-group">
                                
                                    <label>Insurance Provider</label>
                                    <input type="text" name="insCarrier" size=8 value="<?php echo $insCarrier; ?>">
                                                                   
                            </div>
                            <div class="form-group">
                                
                                    <label>Insurance Policy</label>
                                    <input type="text" name="insPlcy" size=8 value="<?php echo $insPlcy; ?>">
                                                                   
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                                    <input type="submit" class="btn btn-success" value="Submit">
                                    <a href="carinfo.php" class="btn btn-default">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>        
            </div>
        </div>
    </div>
</body>
</html>