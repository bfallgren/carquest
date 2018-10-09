<?php
// Include config file
require_once 'config.php';


// Define variables and initialize with empty values
$year = $make = $model =  $vid = $mileage = $tag = $insCarrier = $insPlcy = "";
$year_err = $make_err = $model_err  =  $vid_err = $mileage_err  = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate YEAR
    $input_year = trim($_POST["year"]);
    if (empty($input_year)) {
        $year_err = "Please enter the vehicle YEAR.";
    } elseif (!ctype_digit($input_year)) {
        $year_err = 'Please enter a positive integer value.';
    } else {
        $year = $input_year;
    }

// Validate MAKE
    $input_make = trim($_POST["make"]);
    if (empty($input_make)) {
        $make_err = "Please enter vehicle MAKE.";
    } else {
        $make = $input_make;
    }

    // Validate MODEL
    $input_model = trim($_POST["model"]);
    if (empty($input_model)) {
        $model_err = 'Please enter a vehicle MODEL.';
    } else {
        $model = $input_model;
    }

    // Validate MILEAGE
    $input_mileage = trim($_POST["mileage"]);
    if (empty($input_mileage)) {
        $mileage_err = "Please enter the vehicle MILEAGE.";
    } elseif (!ctype_digit($input_year)) {
        $mileage_err = 'Please enter a positive integer value.';
    } else {
        $mileage = $input_mileage;
    }

    // Validate VID
    $input_vid = trim($_POST["vid"]);
    if (empty($input_vid)) {
        $vid_err = "Please enter the vehicle VIN.";
    } elseif (!ctype_digit($input_year)) {
        $vid_err = 'Please enter a positive integer value.';
    } else {
        $vid = $input_vid;
    }

    $tag = trim($_POST["tag"]);

    $insCarrier = trim($_POST["insCarrier"]);

    $insPlcy = trim($_POST["insPlcy"]);

    // Check input errors before inserting in database
    if (empty($year_err) && empty($make_err) && empty($model_err) && empty($vid_err) && empty($mileage_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO carinfo (Year, Make, Model, VID, CurrentMileage, LicenseTag, InsuranceProvider, InsurancePolicy ) VALUES (:year, :make, :model, :vid, :mileage, :tag, :insCarrier, :insPlcy)";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':year', $param_year);
            $stmt->bindParam(':make', $param_make);
            $stmt->bindParam(':model', $param_model);
            $stmt->bindParam(':vid', $param_vid);
            $stmt->bindParam(':mileage', $param_mileage);
            $stmt->bindParam(':tag', $param_tag);
            $stmt->bindParam(':insCarrier', $param_insCarrier);
            $stmt->bindParam(':insPlcy', $param_insPlcy);

            // Set parameters
            $param_year = $year;
            $param_make = $make;
            $param_model = $model;
            $param_vid = $vid;
            $param_mileage = $mileage;
            $param_tag = $tag;
            $param_insCarrier = $insCarrier;
            $param_insPlcy = $insPlcy;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Records created successfully. Redirect to landing page
                header("location: carinfo.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        unset($stmt);
    }

    // Close connection
    unset($pdo);
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
                            <h2>Add New Record</h2>
                        </div>
                        <p>* - Required Fields.</p>
                        <!–– input form (name=) must match $_POST variable name ––> 
                        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                            <div class="form-group <?php echo (!empty($year_err)) ? 'has-error' : ''; ?>">
                                
                                    <label>*Year</label>
                                    <input type="text" name="year" color: #000 size=4 value="<?php echo $year; ?>">
                                    <span class="help-block"><?php echo $year_err;?></span>
                                
                            </div>
                            <div class="form-group <?php echo (!empty($make_err)) ? 'has-error' : ''; ?>">
                                
                                    <label>*Make</label>
                                    <input type="text" name="make" size=16 value="<?php echo $make; ?>">
                                    <span class="help-block"><?php echo $make_err;?></span>
                               
                            </div>
                            <div class="form-group <?php echo (!empty($model_err)) ? 'has-error' : ''; ?>">
                                
                                    <label>*Model</label>
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