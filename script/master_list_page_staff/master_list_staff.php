<?php
session_start(); 
include('../db_conn.php'); 

//this fetch the title//
$query_course="SELECT * FROM `course`";
$result_course = $mysqli->query($query_course);
$row1 = mysqli_fetch_array($result_course);


//this page have three table main only dc can go in this page// 
//select unit and UC
$query_unitdetail="SELECT *, unit_detail.id as unit_id FROM `unit_detail` left join user_staff on user_staff.id = unit_detail.unit_coordinator";
$result_unitdetail = $mysqli->query($query_unitdetail);

//Select lecturer//
$query_lecture="SELECT *, unit_detail.id as unit_id FROM `unit_detail`
left join user_staff on user_staff.id = unit_detail.lecturer";
$result_lecture = $mysqli->query($query_lecture);

//select tutorial code to show different unit acadmic staff for uc select tutor
$query_unit_tutor="select * , unit_detail.id as unit_id from user_staff right join tutorial on tutorial.tutor_staff_id_fk =user_staff.id join unit_detail on unit_detail.id = tutorial.tutorial_unit_id";
$result_unit_tutor= $mysqli->query($query_unit_tutor);


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../../css/master_list_staff.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Academic staff master list | University of DoWell </title>
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
        <!--title-->        
        <div class="container">
            <div class="row">
                <div class="col-9" id ="col_b">
                    <h2>Academic staff master list </h2>
                    <div class="container" id ="container_b"></div>
                    <div class="row">
                        <div class="col-xs-12">
                            <h4><?php echo "Hello ".$_SESSION['session_user_last_name']; ?></h4>
                            <h4>Course -<?php echo $row1['course_name']; ?></h4>
                            <h5>If you were trying to change the academic staff, please the click the edit button related to that unit.</h5> 
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
        <!--table one start here for Unit Coordinator-->
        <div class="container">
            <div class="table">
                <table class="table table-striped table-bordered table-hover"> <!--Coordinator-->  
                    <thead>
                        <h5><strong>Unit Coordinator</strong></h5>
                        <tr>
                            <th>Unit code</th>
                            <th>Unit name</th>
                            <th>Staff number</th>
                            <th>Last_name</th>
                            <th>First_name</th>
                            <th>UDW email</th>
                            <th>Make Change</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 

                        while($row2 = mysqli_fetch_array($result_unitdetail))
                        {
                        ?>
                        <tr>
                            <td><?php echo $row2['unit_code']; ?></td>
                            <td><?php echo $row2['unit_name']; ?></td>
                            <td><?php echo $row2['staff_number']; ?></td>
                            <td><?php echo $row2['last_name']; ?><br></td>
                            <td><?php echo $row2['first_name']; ?><br></td>
                            <td><?php echo $row2['UDW_email']; ?></td>
                            <td><a href="edit_staff_list_uc.php?unitID=<?php echo $row2['unit_id']; ?>">Edit</a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <hr>
        </div>

        <!--table one end here-->                    
        <!--table two start here for lecturer-->
        <div class="container">
            <div class="table">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <h5><strong>Lecturer</strong></h5>
                        <tr>
                            <th>Unit code</th>
                            <th>Unit name</th>
                            <th>Staff number</th>
                            <th>Last_name</th>
                            <th>First_name</th>
                            <th>UDW email</th>
                            <th>Make Change</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        while($row3 = mysqli_fetch_array($result_lecture))
                        {
                        ?>
                        <tr>
                            <td><?php echo $row3['unit_code']; ?></td>
                            <td><?php echo $row3['unit_name']; ?></td>
                            <td><?php echo $row3['staff_number']; ?></td>
                            <td><?php echo $row3['last_name']; ?><br></td>
                            <td><?php echo $row3['first_name']; ?><br></td>
                            <td><?php echo $row3['UDW_email']; ?></td>
                            <td><a href="edit_staff_list_lecturer.php?unitID=<?php echo $row3['unit_id']; ?>">Edit</a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <hr>
        </div>

        <!--table two end here-->                          

        <!--table three start here for tutor-->
        <div class="container">
            <div class="table">
                <table class="table table-striped table-bordered table-hover">

                    <thead>
                        <h5><strong>Tutor in each tutorial </strong></h5>
                        <h5><strong>Please select unit at below to see the acadmic staff list for each unit.</strong></h5>
                        <tr>
                            <th>Tutorial code</th>
                            <th>Unit name</th>
                            <th>Tutor name</th>
                            <th>Tutor email</th>
                            <th>See Detail/Make change</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        while($row4 = mysqli_fetch_array($result_unit_tutor))
                        {
                        ?>
                        <tr>
                            <td><?php echo $row4['tutorial_code']; ?></td>
                            <td><?php echo $row4['unit_code']; ?>&nbsp;<?php echo $row4['unit_name']; ?></td>
                            <td><?php echo $row4['last_name']; ?>&nbsp;<?php echo $row4['first_name']; ?></td>
                            <td><?php echo $row4['UDW_email']; ?></td>
                            <td><a href="edit_staff_list_tutor.php?unitID=<?php echo $row4['unit_id']; ?>">Edit</a></td>

                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <hr>
        </div>

        <!--table three end here-->           

        <!--footer start here-->
        <div class="footer">
            <p class="text-muted small mb-4 mb-lg-0">© University of DoWell 2020. All Rights Reserved.</p>
        </div>
        <!--footer end -->
        <!--JS files: jQuery first, then Popper.js, then Bootstrap JS-->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>


    </body>
</html>