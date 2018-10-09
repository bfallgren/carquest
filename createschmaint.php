<?php
// Include config file
 if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    // Include config file
    require_once 'config.php';
    
    } else {
        echo "Something went wrong. Please try again later.";
        //header("location: error.php");
        exit();
     }


// Define variables and initialize with empty values
$mileageint = $monthint = $lastcompmiles = $nextschdmaint = 0; 
$descr = "";
$mileageint_err = $monthint_err = $lastcompmiles_err =  $lastcompdate_err = $nextschdmaint_err = $descr_err = "";
$input_mileageint = $input_monthint = $input_lastcompmiles = $input_nextschdmaint = 0;
$input_descr = "";


// Processing form data when form is submitted
// all fields are REQUIRED in form
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // record id
    //$carid = 19;
    $carid = trim($_GET["id"]);

    // Validate last completed date
    $input_lastcompdate = $_POST["lastcompdate"];

    // Validate Mileage Interval
    $input_mileageint = trim($_POST["mileageint"]);
    if (!empty($input_mileageint)) {
        if (!ctype_digit($input_mileageint)) {
        $mileageint_err = 'Please enter a positive integer value.';
    } }

     // Validate Month Interval
    $input_monthint = trim($_POST["monthint"]);
    if (!empty($input_monthint)) {
        if (!ctype_digit($input_monthint)) {
        $monthint_err = 'Please enter a positive integer value.';
    } }
   
    // Validate Last Completed Miles
    $input_lastcompmiles = trim($_POST["lastcompmiles"]);
    if (!empty($input_lastcompmiles)) {
        if (!ctype_digit($input_lastcompmiles)) {
        $lastcompmiles_err = 'Please enter a positive integer value.';
    } }
    
          
    // Validate Description
    $input_descr = trim($_POST["descr"]);
    if (empty($input_descr)) {
        $descr_err = 'Please enter a description.';
    } 
    
    
    // Check input errors before inserting in database
    if (empty($mileage_err) && empty($monthint_err) && empty($lastcompmiles_err) &&  empty($descr_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO tasks (id, MileageInterval, MonthInterval, LastCompletedMiles, LastCompletedDate, NextSchedMaint, Description) VALUES (:carid, :mileageint, :monthint, :lastcompmiles, :lastcompdate, :nextschdmaint, :descr)";

        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);


        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':carid', $param_carid);
            $stmt->bindParam(':mileageint', $param_mileageint);
            $stmt->bindParam(':monthint', $param_monthint);
            $stmt->bindParam(':lastcompmiles', $param_lastcompmiles);
            $stmt->bindParam(':lastcompdate', $param_lastcompdate);
            $stmt->bindParam(':nextschdmaint', $param_nextschdmaint);
            $stmt->bindParam(':descr', $param_descr);
            
            // Set parameters
            $param_carid = $carid;
            $param_mileageint = $input_mileageint;
            $param_monthint = $input_monthint;
            $param_lastcompmiles = $input_lastcompmiles;
            $param_lastcompdate = $input_lastcompdate;
            $param_nextschdmaint = $input_nextschdmaint;
            $param_descr = $input_descr;
           
            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Records created successfully. Redirect to landing page
                header("location: carinfo.php");
                exit();
            } else {
                echo "stmt-execute failed.";
                PDOStatement::errorCode();
                PDOStatement::errorInfo();
                header("location: error.php");
                exit();
            }
             
        } else {
            echo "stmt-prepare failed";
            PDOStatement::errorCode();
            PDOStatement::errorInfo();
            header("location: error.php");
            exit();
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
                            <h2>Add Service Record</h2>
                        </div>
                        <p>* - Required Fields.</p>
                        <!–– input form (name=) must match $_POST variable name ––> 
                        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                            
                            <div class="form-group <?php echo (!empty($mileageint_err)) ? 'has-error' : ''; ?>">
                                
                                    <label>*Mileage Interval</label>
                                    <input type="text" name="mileageint" size=8 value="<?php echo $input_mileageint; ?>">
                                    <span class="help-block"><?php echo $mileageint_err;?></span>
                               
                            </div>
                            <div class="form-group <?php echo (!empty($monthint_err)) ? 'has-error' : ''; ?>">
                                
                                    <label>*Month Interval</label>
                                    <input type="text" name="monthint" size=8 value="<?php echo $input_monthint; ?>">
                                    <span class="help-block"><?php echo $monthint_err;?></span>
                               
                            </div>
                             <div class="form-group <?php echo (!empty($lastcompmiles_err)) ? 'has-error' : ''; ?>">
                                
                                    <label>*Last Completed (miles)</label>
                                    <input type="text" name="lastcompmiles" size=8 value="<?php echo $input_lastcompmiles; ?>">
                                    <span class="help-block"><?php echo $lastcompmiles_err;?></span>
                               
                            </div>
                            <div class="form-group <?php echo (!empty($lastcompdate_err)) ? 'has-error' : ''; ?>">
                                
                                    <label>*Last Completed (Date)</label>
                                    <input type="date" name="lastcompdate" required color: #000 value="<?php echo $input_lastcompdate; ?>">
                                    <span class="help-block"><?php echo $lastcompdate_err;?></span>
                                
                            </div>
                            
                            <div class="form-group <?php echo (!empty($descr_err)) ? 'has-error' : ''; ?>">
                                
                                    <label>Description</label>
                                    <input type="text" name="descr" size=45 required value="<?php echo $input_descr; ?>">
                                    <span class="help-block"><?php echo $descr_err;?></span>
                               
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