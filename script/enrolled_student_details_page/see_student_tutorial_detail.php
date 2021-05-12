<?php
session_start(); 
include('../db_conn.php'); 
//in the pervious page the button use the get method to gain the tutorial_id, in here use this $tutorial_id to excetue query in the tutorial table and tutorial_enrolment (contain student enrolled status)
$tutorial_id=$_GET['tutorial_id']; 

$query_tut_code="select * from tutorial where id = $tutorial_id";
$result_tut_code = $mysqli->query($query_tut_code);


$query_student_detail="SELECT * from user_student
JOIN tutorial_enrolment on tutorial_enrolment.id_stud_fk= user_student.id
left join tutorial on tutorial.id= tutorial_enrolment.id_tut_fk
where tutorial_enrolment.id_tut_fk=$tutorial_id";
$result_student_detail = $mysqli->query($query_student_detail);
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
                    <?php 
                    while($row1 = mysqli_fetch_array($result_tut_code))
                    {
                    ?>
                    <h5><strong>Student in -<?php echo $row1['tutorial_code']; ?></strong></h5>
                    <?php } ?>
                     <div class="container" id ="container_b"></div>
                </div>  
            </div>
        </div>
        <br>
        <!--list start here-->
        <div class="container">
            <div class="table">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Tutorial code</th>
                            <th>Student name</th>
                            <th>Student number</th>
                            <th>Email address</th>

                            <th>Tutorial start time</th>
                            <th>Tutorial end time</th>
                            <th>Tutorial location</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        while($row = mysqli_fetch_array($result_student_detail))
                        {
                        ?>
                        <tr>
                            <td><?php echo $row['tutorial_code']; ?></td>
                            <td><?php echo $row['first_name']; ?>&nbsp;<?php echo $row['last_name']; ?></td>
                            <td><?php echo $row['student_number']; ?></td>
                            <td><?php echo $row['UDW_email']; ?></td>
                            <td><?php echo $row['tutorial_time_start_at']; ?> 
                            <td><?php echo $row['tutorial_time_end_at']; ?></td>
                            <td><?php echo $row['tutorial_location']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <hr>
        </div>

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
