<?php
session_start(); 
include('../db_conn.php'); 
$user_id=$_SESSION['session_user_id'];
//use user id to define which tutorial teaching//
$result_relate_unit_id = $mysqli->query("select *, tutorial.id as tutorial_id from unit_detail 
JOIN tutorial on tutorial.tutorial_unit_id = unit_detail.id where tutorial.tutor_staff_id_fk =$user_id");
$row = mysqli_fetch_array($result_relate_unit_id );
$tutorial_id= $row['tutorial_id'];
//get the tutorial id then we can fetch the tutorial detail related to this tutor //
$query_tut_code="SELECT * FROM `tutorial` WHERE id = $tutorial_id";
$result_tut_code = $mysqli->query($query_tut_code);

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
        <!--top bar with show login logout-->
        <div class="topnav">
            <!-- Left-aligned -->
            <a><img src="../../asset/logo.png" alt="logo" style="width:40px; height: 30px; "></a>
            <a href="../home_page/home.php">University of DoWell</a>    
            <!-- Right-aligned links -->
            <div class="topnav-right">
                <a href="../logout_session.php" class="button6" id="logoutBtn" name="logout">Log out</a>
                <a href="../home_page/home.php" class="button6">Home</a>
            </div>
        </div>
        <!-- navbar start end-->
         <!--title-->        
        <br><br>
        <div class="container">
            <div class="row">
                <div class="col-9" id ="col_b">
                        <h5>Student in related to user teaching tutorial</h5> 
                    <div class="container" id ="container_b"></div>
                    <div class="row">
                        <div class="col-xs-12">
                            <h4><?php echo "Hello ".$_SESSION['session_user_last_name']; ?></h4>
                    
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
                        <span>Please select the tutorial code see student detail list </span>
                        <tr>
                            <th>Tutorial code</th>
                            <th>See student detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        while($row2 = mysqli_fetch_array($result_tut_code))
                        {
                        ?>
                        <tr>
                            <td><?php echo $row2['tutorial_code']; ?></td>
                            <td><a href="see_student_tutorial_detail.php?tutorial_id=<?php echo $row2['id']?>">Detail</a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <hr>
        </div>
        <!--Go back to the account manage page-->        
        <div class ="container">
            <div class="row">
                <div class="col-sm-6" >
                    <p><a href="../user_account_management/manage_account.php" > Back to the manage account page</a></p><!--link to meun-->
                </div>
            </div> 
        </div>    
        <!--footer start here-->
        <div class="footer">
            <p class="text-muted small mb-4 mb-lg-0">© University of DoWell 2020. All Rights Reserved.</p>
        </div>
        <!--footer end -->
    </body>
</html>
