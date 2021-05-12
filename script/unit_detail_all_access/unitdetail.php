<?php
session_start(); 
include('../db_conn.php'); 

$query_unitdetail="SELECT * FROM `unit_detail` join user_staff on user_staff.id = unit_detail.unit_coordinator";
$result_unitdetail = $mysqli->query($query_unitdetail);

$query_course="SELECT * FROM `course`";
$result_course = $mysqli->query($query_course);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Unit detail | University of DoWell </title>
        <!-- Bootstrap CSS file -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="../../css/unitdetailstyle.css">
    </head>
    <body>
        <!--top bar with show login logout-->
        <div class="topnav">
            <!-- Left-aligned -->
            <a><img src="../../asset/logo.png" alt="logo" style="width:40px; height: 30px; "></a>
            <a href="../home_page/home.php">University of DoWell</a>    
            <!-- Right-aligned links -->
            <div class="topnav-right">
                <a href="../logout_session.php" class="button6" id="logoutBtn" name="logout" style="display:none;">Log out</a> <!--not display, until user  login-->
                <a href="../home_page/home.php" id="Login">Log In </a>
                <a href="../registation_page/main_registation/register.php" id="signup" class="button6">Sign up</a>
                <a href="../home_page/home.php" class="button6">Home</a>
            </div>
        </div>

        <?php                  
        if(isset($_SESSION['session_UDW_email'])){  //if login successful//
            echo "<script type='text/javascript'>document.getElementById('Login').style.display = 'none'</script>"; //hide the login button
            echo "<script type='text/javascript'>document.getElementById('signup').style.display = 'none'</script>"; //hide the signup button
            echo "<script type='text/javascript'>document.getElementById('logoutBtn').style.display = 'block'</script>"; //display logout button
        }?>

        <!--top bar finish-->
        <!-- title-->
        <div class="container" id ="container_b">
            <div class="row">
                <div class="col-9" id ="col_b">
                    <h4><?php echo 'Hello '.$_SESSION['session_user_last_name']; ?></h4> 
                </div>
                <div class="col-9" id ="col_b"><strong> Master of Information Technology and Systems (K7I) </strong></div>
            </div>
        </div>
        <br>
        <div class="container">
            <div class="row"> 
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">UDW Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Unit Detail</a></li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- title finish-->
        <!-- icon and introduction-->  
        <?php 
        while($row1 = mysqli_fetch_array($result_course))
        {
        ?>
        <div class="container" style="background-color: #e7ebec; ">
            <div class="row justify-content-center">             
                <div class="col-md-3"><i class="fa fa-calendar-check-o" style="font-size:38px;color:royalblue;"></i>
                    <h4>Study period</h4>
                    <p><?php echo $row1['study_period']; ?></p>
                </div>
                <div class="col-md-3"><i class="fa fa-mortar-board" style="font-size:38px;color:royalblue"></i>
                    <h4>Duration</h4>
                    <p><?php echo $row1['duration']; ?></p>
                </div>
                <div class="col-md-3"><i class="fa fa-institution" style="font-size:38px;color:royalblue"></i>
                    <h4>Entry requirement </h4>
                    <p><?php echo $row1['entry_requirement']; ?></p>
                </div>
                <div class="col-md-3"><i class="fa fa-map-marker" style="font-size:38px;color:royalblue"></i>
                    <h4>Location</h4>
                    <p><?php echo $row1['location']; ?></p>
                </div>
            </div>
        </div>
        <!-- icon and introduction finish-->
        <!-- middle -course overview -->
        <div class="container" id="container_a"> 
        </div>
        <div class="container" id ="container_big">
            <div class="container-fluid" id ="container_c">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="col-10">
                            <h3>Course Overview</h3></div>

                        <div class="col-5" style="text-align"><?php echo $row1['course_description']; ?></div>
                        <br>

                        <div class="table">
                            <table class="table table-striped table-bordered table-hover" id="keyDates">
                                <thead>
                                    <tr>
                                        <th>Start period</th>
                                        <th>Start date</th>
                                        <th>Census date</th>
                                        <th>Withdraw date</th>
                                        <th>End date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="font-size: 14px;"><?php echo $row1['start_period']; ?></td>
                                        <td><?php echo $row1['start_date']; ?><br></td>
                                        <td><?php echo $row1['census_date']; ?><br></td>
                                        <td><?php echo $row1['withdraw_date']; ?><br></td>
                                        <td><?php echo $row1['end_date']; ?><br></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>    
        <?php  } ?>
        <!-- middle -course overview finish-->
        <br>
        <div class="container" id ="container_b">
        </div>
        <!--collapse start here-->  
        <div class="container" id ="container_b">              
            <hr>
            <?php 
            $i = 1;
            while($row2 = mysqli_fetch_array($result_unitdetail))
            {
            ?>
            <a class="" data-toggle="collapse" href="#collapse-<?php echo $i ?>" aria-expanded="true" style="color:black;">
                <span><u><strong><?php echo $row2['unit_code']; ?></strong> <?php echo $row2['unit_name']; ?></u></span>
                <i class="	fa fa-chevron-down" style="font-size:24px; float:right"></i>
            </a>
            <div class="collapse" id="collapse-<?php echo $i ?>">
                <br>
                <div class="col-5"><?php echo $row2['unit_description']; ?></div>
                <br>              
                <div class="table">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Available study period</th>
                                <th>Campus</th>
                                <th>Credit Points</th>
                                <th>Coordinator</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="font-size: 14px;"><?php echo $row2['semester']; ?></td>
                                <td><?php echo $row2['campus']; ?><br></td>
                                <td><?php echo $row2['credit_points']; ?><br></td>
                                <td><?php echo $row2['last_name']; ?> <?php echo $row2['first_name']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr>
            <?php $i++; } ?>
        </div><br><br>     
        <!--collapse finish here-->      
        <!--footer-->
        <div class="footer container" style="text-align:center">
            <p class="text-muted small mb-4 mb-lg-0">© University of DoWell 2020. All Rights Reserved.</p>
        </div>
        <!--JS files: jQuery first, then Popper.js, then Bootstrap JS-->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    </body>
</html>