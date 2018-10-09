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
	
    $(document).ready(function(){
        $("#myNav").affix({
            offset: {
                top: 0
            }
        });
        $("#myNav").on('affixed.bs.affix', function(){
            /*alert("The left navigation menu has been affixed. Now it doesn't scroll with the page.");*/
        });
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
 /* Custom Styles */
 ul.nav-tabs{
        width: 140px;
        margin-top: 20px;
        border-radius: 4px;
        border: 1px solid #ddd;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.067);
    }
    ul.nav-tabs li{
        margin: 0;
        border-top: 1px solid #ddd;
    }
    ul.nav-tabs li:first-child{
        border-top: none;
    }
    ul.nav-tabs li a{
        margin: 0;
        padding: 8px 16px;
        border-radius: 0;
    }
    ul.nav-tabs li.active a, ul.nav-tabs li.active a:hover{
        color: white;
        background: green;
        border: 1px solid color: white;
    }
    ul.nav-tabs li:first-child a{
        border-radius: 4px 4px 0 0;
    }
    ul.nav-tabs li:last-child a{
        border-radius: 0 0 4px 4px;
    }
    ul.nav-tabs.affix{
        top: 30px; /* Set the top position of pinned element */
    }
</style>

</head>

<body data-spy="scroll" data-target="#myScrollspy">

<div class="container">
    <header>
           <div id="header">
           </div>
       </header>
       <div class="row">
        <div class="col-md-3" id="myScrollspy">
            <ul class="nav nav-tabs nav-stacked" id="myNav">
                <li><a href='createschmaint.php?id=<?php echo $_GET['id'];?>' class='btn btn-success btn-sm'>Add Record</a></li>
                <li><a href='carinfo.php' class='btn btn-success btn-sm'>Back</a></li>
            </ul>
        </div>

        <div class="col-md-9">
            <div class="page-header clearfix">
                <?php
                    $car = $_GET['car'];
                ?>
                <h2 class="pull-left" style = "width:600px; color:LightBlue;"><?php echo $car ?> Scheduled Maintenance Intervals</h2>
            </div>
            <?php

                    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
                        // Include config file
                        require_once 'config.php';

                        // Attempt select query execution
                        $sql = "SELECT * FROM tasks WHERE id = :id  order by Description ASC";
                        if ($stmt = $pdo->prepare($sql)) {
                            // Bind variables to the prepared statement as parameters
                            $stmt->bindParam(':id', $param_id);

                            // Set parameters
                            $param_id = trim($_GET["id"]);

                            // Attempt to execute the prepared statement
                            if ($stmt->execute()) {
                                if ($stmt->rowCount() > 0) {

                                    // echo "<table class='table table-bordered table-striped'>";
                                    echo "<table class='table table-bordered table-condensed'>";
                                    echo "<thead>";
                                    echo "<tr>";
                                    echo "<th><h3><font color=LightBlue>Miles</h2></th>";
                                    echo "<th><h3><font color=LightBlue>Months</h2></th>";
                                    echo "<th><h3><font color=LightBlue>Last Mileage</h2></th>";
                                    echo "<th><h3><font color=LightBlue>Last Date</h2></th>";
                                    echo "<th><h3><font color=LightBlue>Description</h2></th>";
                                    echo "<th><h3><font color=LightBlue>Action</h2></th>";

                                    echo "</tr>";
                                    echo "</thead>";
                                    echo "<tbody>";

                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<tr>";
                                        // $datein is something like: 2014-01-31 13:05:59
                                        $datein = strtotime($row['LastCompletedDate']);
                                        $dateout = date("Y-m-d", $datein);
                                        // $dateout is something like: 2014-01-31
                                        
                                        echo "<td>" . number_format($row['MileageInterval'], 0) . "</td>";
                                        echo "<td>" . number_format($row['MonthInterval'], 0) . "</td>";
                                        echo "<td>" . number_format($row['LastCompletedMiles'], 0) . "</td>";
                                        echo "<td>" . $dateout . "</td>";
                                        echo "<td>" . $row['Description'] . "</td>";
                                        echo "<td>";
                                        echo "<span style='font-size:1.5em;' class='glyphicon glyphicon-th-list'></span>";
                                        
                                        echo "<a href='updateschmaint.php?id=" . $row['id'] . "&rec_No=" . $row['rec_No'] . "' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'style='color:orange'></span></a>";
                                        echo "<a href='deleteschmaint.php?id=" . $row['id'] . "&rec_No=" . $row['rec_No'] . "' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'style='color:red'></span></a>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    // URL doesn't contain valid id parameter. Redirect to error page
                                    echo "<p class='lead'><em>No records were found.</em></p>";
                                   
                                }
                                echo "</tbody>";
                                echo "</table>";
                                // Free result set
                                unset($result);
                            } else {
                                echo "<p class='lead'><em>No records were found.</em></p>";
                            }
                        } else {
                            echo "ERROR: unable to execute $sql. " . $mysqli->error;
                        }

                        // Close connection
                        unset($pdo);
                    } else {
                        // URL doesn't contain id parameter. Redirect to error page
                        header("location: error.php");
                        exit();
                    }
                ?>
        </div>
    </div>
       
</div>
</body>
</html>