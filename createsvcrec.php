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
$svcdate = $descr = $loc =  $mileage = $cost = "";
$svcdate_err = $desc_err = $loc_err =  $mileage_err = $cost_err = "";
$input_descr = $input_loc = $input_mileage = $input_cost = "";


// Processing form data when form is submitted
// all fields are REQUIRED in form
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // record id
    //$carid = 19;
    $carid = trim($_GET["id"]);

    // Validate Date
    $svcdate = trim($_POST["svcdate"]);
   
// Validate Location
    $input_loc = trim($_POST["loc"]);
    if (empty($input_loc)) {
        $loc_err = 'Please enter a service location.';
    } else {
        $loc = $input_loc;
    }
    
    // Validate Cost
    $input_cost = trim($_POST["cost"]);
    if (preg_match('/^[0-9]+(\.[0-9]{2})?$/', $input_cost)) { 
        $cost = $input_cost;
    } else
    {
        $cost_err = 'Please enter valid currency';
    }
    
    // Validate Mileage
    $input_mileage = trim($_POST["mileage"]);
    if (empty($input_mileage)) {
        $mileage_err = "Please enter the vehicle MILEAGE.";
    } elseif (!ctype_digit($input_mileage)) {
        $mileage_err = 'Please enter a positive integer value.';
    } else {
        $mileage = $input_mileage;
    }
    
    // Validate Description
    $input_descr = trim($_POST["descr"]);
    if (empty($input_descr)) {
        $desc_err = 'Please enter a service description.';
    } else {
        $descr = $input_descr;
    }
    
    
    // Check input errors before inserting in database
    if (empty($svcdate_err) && empty($loc_err) && empty($cost_err) && empty($desc_err) && empty($mileage_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO service (id, Date, Location, Cost, Description, Mileage) VALUES (:carid, :svcdate, :loc, :cost, :descr, :mileage)";

        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);


        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':carid', $param_carid);
            $stmt->bindParam(':svcdate', $param_date);
            $stmt->bindParam(':loc', $param_loc);
            $stmt->bindParam(':cost', $param_cost);
            $stmt->bindParam(':descr', $param_desc);
            $stmt->bindParam(':mileage', $param_mileage);
            
            // Set parameters
            $param_carid = $carid;
            $param_date = $svcdate;
            $param_loc = $loc;
            $param_cost = $cost;
            $param_desc = $descr;
            $param_mileage = $mileage;
           
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
                            <div class="form-group <?php echo (!empty($svcdate_err)) ? 'has-error' : ''; ?>">
                                
                                    <label>*Date</label>
                                    <input type="date" name="svcdate" required color: #000 value="<?php echo $svcdate; ?>">
                                    <span class="help-block"><?php echo $svcdate_err;?></span>
                                
                            </div>
                            <div class="form-group <?php echo (!empty($loc_err)) ? 'has-error' : ''; ?>">
                                
                                    <label>*Location</label>
                                    <input type="text" name="loc" size=30 value="<?php echo $loc; ?>">
                                    <span class="help-block"><?php echo $loc_err;?></span>
                               
                            </div>
                            <div class="form-group <?php echo (!empty($cost_err)) ? 'has-error' : ''; ?>">
                                
                                    <label>*Cost</label>
                                    <input type="text" name="cost" size=8 value="<?php echo $cost; ?>">
                                    <span class="help-block"><?php echo $cost_err;?></span>
                               
                            </div>
                            <div class="form-group <?php echo (!empty($desc_err)) ? 'has-error' : ''; ?>">
                                
                                    <label>Description</label>
                                    <input type="text" name="descr" size=45 value="<?php echo $descr; ?>">
                                    <span class="help-block"><?php echo $desc_err;?></span>
                               
                            </div>
                            <div class="form-group <?php echo (!empty($mileage_err)) ? 'has-error' : ''; ?>">
                                
                                    <label>Mileage</label>
                                    <input type="text" name="mileage" size=8 value="<?php echo $mileage; ?>">
                                    <span class="help-block"><?php echo $mileage_err;?></span>
                               
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