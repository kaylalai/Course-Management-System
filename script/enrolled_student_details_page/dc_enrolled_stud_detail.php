<?php
session_start(); 
include('../db_conn.php'); 

//dc can see all the tutorial, so need to fetch all the tutorial code in the page main list //
$query_unitdetail="SELECT * , tutorial.id as tutorial_id FROM unit_detail
JOIN tutorial on tutorial.tutorial_unit_id= unit_detail.id";
$result_unitdetail = $mysqli->query($query_unitdetail);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS file -->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://jonthornton.github.io/jquery-timepicker/jquery.timepicker.js"></script>
        <link rel="stylesheet" type="text/css" href="https://jonthornton.github.io/jquery-timepicker/jquery.timepicker.css">
        <script type="text/javascript" src="https://jonthornton.github.io/jquery-timepicker/lib/bootstrap-datepicker.js"></script>
        <link rel="stylesheet" type="text/css" href="https://jonthornton.github.io/jquery-timepicker/lib/bootstrap-datepicker.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
               <link rel="stylesheet" type="text/css" href="../../css/enrolled_stud_detail.css">
        <title>Student enrolled tutorial detail | University of DoWell </title>
    </head>
    <body>
        <!-- navbar start here-->
  <!--title-->        
        <div class="container">
            <div class="row">
                <div class="col-9" id ="col_b">
                    <h2>Edit Unit Coordinator </h2>
                    <div class="container" id ="container_b"></div>
                    <div class="row">
                        <div class="col-xs-12">
                            <h4><?php echo "Hello ".$_SESSION['session_user_last_name']; ?></h4>
                    <h5>Select the tutorail code to see the student in that tutorial class.</h5> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-9" >
                    <p><a href="../user_account_management/manage_account.php" > Back to the main page</a></p><!--link to meun-->
                    <hr>
                </div>
            </div>
        </div>
        <!--title end-->  

<div class="container">
            <div class="table">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <h5><strong>Tutorial list </strong></h5>
                        <tr>
                            <th>Tutorial code</th>
                            <th>See student detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        while($row = mysqli_fetch_array($result_unitdetail))
                        {
                        ?>
                        <tr>
                            <td><?php echo $row['tutorial_code']; ?></td>
                            <td><a href="see_student_tutorial_detail.php?tutorial_id=<?php echo $row['tutorial_id']?>">Detail</a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <hr>
        </div>
        <!--footer start here-->
        <div class="footer">
            <p class="text-muted small mb-4 mb-lg-0">© University of DoWell 2020. All Rights Reserved.</p>
        </div>
        <!--footer end -->
    </body>
</html>
