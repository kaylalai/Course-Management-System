<?php
session_start(); 
include('../db_conn.php');   
$staff_id = $_SESSION['session_user_id'];


$result_unitdetail = $mysqli->query("select * from unit_detail where unit_coordinator=$staff_id");
$row1 = mysqli_fetch_array($result_unitdetail);
$unit_id= $row1['id'];

$result_tutor=$mysqli->query("SELECT * ,tutorial.id as tutorial_id, user_staff.id as staff_id from user_staff
right join tutorial on tutorial.tutor_staff_id_fk = user_staff.id where tutorial.tutorial_unit_id=$unit_id ");


?>



<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
         <link rel="stylesheet" type="text/css" href="../../css/master_list_staff.css">
        <title>Allocate TUTOR | University of DoWell </title>
    </head>
    <body>
         <!-- navbar start here-->
        <div class="topnav">
            <!-- Left-aligned -->
            <a><img src="../../asset/logo.png" alt="logo" style="width:40px; height: 30px; "></a>
            <a href="../home_page/home.php">University of DoWell</a>    
            <!-- Right-aligned links -->
            <div class="topnav-right">
                <a href="../logout_session.php" class="button6" id="logoutBtn" name="logout" >Log out</a> 
                <a href="../home_page/home.php" class="button6">Home</a>
            </div>
        </div>
        <!--top bar finish-->
    
        <!-- title-->
          <div class="container" id ="container_b">
            <div class="row">
                <div class="col-9" id ="col_b">
                    <h4><?php echo 'Hello '.$_SESSION['session_user_last_name']; ?></h4>
                    <h4>Unit -<?php echo $row1['unit_code']; ?>-<?php echo $row1['unit_name']; ?></h4>
                </div>
            </div>  
              <div class="row">
                <div class="col-9" >
                    <p><a href="../user_account_management/manage_account.php" > Back to the main page</a></p><!--link to meun-->
                    <hr>
                </div>
            </div>
        </div>
        <!-- title end-->
        <!--tab-->        
        <div class="container">
            <ul class="nav nav-tabs">
                <li ><a href="tec_staff_w_tech_uni.php">Tutorial details</a></li>
                <li ><a href="allocate_lecturer.php">Allocate Lecturer</a></li>
                <li class="active"><a href="allocate_tutor.php">Allocate Tutor</a></li>
            </ul>
        </div>
        <!--tab end--> 
<!--table current lecturer start-->
        <div class="container">
            <div class="table">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <h5><strong>Current tutor in each tutorial </strong></h5>
                        <tr>
                            <th>Tutorial code</th>
                            <th>location</th>
                            <th>Staff number</th>
                            <th>Last_name</th>
                            <th>First_name</th>
                            <th>UDW email</th>
                            <th>Unavailable</th>
                            <th>Add/Edit tutor</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        while($row2 = mysqli_fetch_array($result_tutor))
                        {
                        ?>
                        <tr>
                            <td><?php echo $row2['tutorial_code']; ?></td>
                            <td><?php echo $row2['tutorial_location']; ?></td>
                            <td><?php echo $row2['staff_number']; ?></td>
                            <td><?php echo $row2['last_name']; ?><br></td>
                            <td><?php echo $row2['first_name']; ?><br></td>
                            <td><?php echo $row2['UDW_email']; ?></td>
                            <td><?php echo $row2['unavailable']; ?></td>
                             <td><a href="edit_allocate_tutor.php?staff_id=<?php echo $row2['staff_id']?>&tutorial_id=<?php echo $row2['tutorial_code']?>">Change</a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <hr>
        </div>
<!--table current lecturer end-->

        

        <!--footer start here-->
        <div class="footer">
         
            <p class="text-muted small mb-4 mb-lg-0">© University of DoWell 2020. All Rights Reserved.</p>
        </div>
        <!--footer end -->

    </body>
</html>
