<!--this page fou uc only .To see the current lecturer and see available staff and make change(make change bak end on other page)-->

<?php
session_start(); 
include('../db_conn.php');   
$staff_id = $_SESSION['session_user_id'];

$result_unitdetail = $mysqli->query("select * from unit_detail where unit_coordinator=$staff_id");
$row1 = mysqli_fetch_array($result_unitdetail);
$unit_id= $row1['id'];

$query_current_lect=("select *, user_staff.id as staff_id, unit_detail.id as unit_id from unit_detail
join user_staff on user_staff.id = unit_detail.lecturer
where unit_detail.id=$unit_id ");
$result_lecture= $mysqli->query($query_current_lect);

$query_ava_staff="select*, user_staff.id as staff_id from user_staff 
 join staff_has_role on staff_has_role.id_staff_fk = user_staff.id
 join staff_role on staff_role.id = staff_has_role.id_role_fk
left join unit_detail on unit_detail.id = staff_has_role.correlate_unit_id_fk
where staff_role.role_name not in ('DC','UC') 
and user_staff.id not in (SELECT lecturer FROM `unit_detail`where unit_detail.id = $unit_id)";
$result_ava_staff = $mysqli->query($query_ava_staff); 

?>


<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
         <link rel="stylesheet" type="text/css" href="../../css/master_list_staff.css">
        <title>Allocate Lecturer | University of DoWell </title>
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
                <div class="container">
                    <ul class="nav nav-tabs">
                        <li><a href="tec_staff_w_tech_uni.php">Tutorial details</a></li>
                        <li class="active"><a href="allocate_lecturer.php">Allocate Lecturer</a></li>
                        <li><a href="allocate_tutor.php">Allocate Tutor</a></li>
                    </ul>
                    </div>

          <!--title end-->  
              
              
<!--table current lecturer start-->
        <div class="container">
            <div class="table">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <h5><strong>Current Lecturer</strong></h5>
                        <tr>
                            <th>Unit code</th>
                            <th>Unit name</th>
                            <th>Staff number</th>
                            <th>Last_name</th>
                            <th>First_name</th>
                            <th>UDW email</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        while($row2 = mysqli_fetch_array($result_lecture))
                        {
                        ?>
                        <tr>
                            <td><?php echo $row2['unit_code']; ?></td>
                            <td><?php echo $row2['unit_name']; ?></td>
                            <td><?php echo $row2['staff_number']; ?></td>
                            <td><?php echo $row2['last_name']; ?><br></td>
                            <td><?php echo $row2['first_name']; ?><br></td>
                            <td><?php echo $row2['UDW_email']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <hr>
        </div>
        
                    
<!--table current lecturer end-->
<!--table ava staff start-->
        <div class="container" id ="container_b">
            <div style=" overflow-y: auto;"> 
                <div class="table">
                    <table id="dt" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                        <h5><strong>Available staff List</strong></h5>
                        <thead>
                            <tr>
                                <th>Staff number</th>
                                <th>Last_name</th>
                                <th>First_name</th>
                                <th>Expertise area</th>
                                <th>Current job role</th>
                                <th>Unavailable day</th>
                                <th>Edit Lecturer</th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php 
                            while($row3 = mysqli_fetch_array($result_ava_staff))
                            {
                            ?>
                            <tr>
                                <td><?php echo $row3['staff_number']; ?></td>
                                <td><?php echo $row3['last_name']; ?><br></td>
                                <td><?php echo $row3['first_name']; ?><br></td>
                                <td><?php echo $row3['expertise_area']; ?></td>
                                <td><?php echo $row3['role_name']; ?></td>
                                 <td><?php echo $row3['unavailable']; ?></td>
                                <td><a href="add_lecturer.php?staff_id=<?php echo $row3['staff_id']?>&unitid=<?php echo $unit_id ?>">Select</a></td>
                            </tr>
                             <?php } ?>
                        </tbody>
                    </table>
                    
                </div>
           </div>
              </div>
        
  <!--table ava staff end-->      
        
        

        <!--footer start here-->
        <div class="footer">
            <p class="text-muted small mb-4 mb-lg-0">© University of DoWell 2020. All Rights Reserved.</p>
        </div>
        <!--footer end -->
    </body>
</html>
