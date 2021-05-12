<?php
session_start(); 
include('../db_conn.php');
$unitid=$_GET['unitID'];
//get uni id to select the unit detail//
$query="select * from unit_detail 
JOIN user_staff on user_staff.id = unit_detail.unit_coordinator 
where unit_detail.id = $unitid";
$result_unit = $mysqli->query($query);

//get the current tutor in this unit (the list of tutor//
$query_unit_tutor="select * ,staff_has_role.correlate_unit_id_fk as unit_id ,user_staff.id as staff_id from user_staff 
join staff_has_role on staff_has_role.id_staff_fk = user_staff.id and staff_has_role.id_role_fk=2
where staff_has_role.correlate_unit_id_fk  = $unitid";
$result_unit_tutor= $mysqli->query($query_unit_tutor);

//Show all the staff for Dc to select them into the unit assign as a tutor but not yet assign in tutorail //
$query_ava_staff ="select * ,user_staff.id as staff_id from staff_has_role join staff_role ON staff_role.id =staff_has_role.id_role_fk join user_staff on user_staff.id =staff_has_role.id_staff_fk left JOIN unit_detail on unit_detail.id = staff_has_role.correlate_unit_id_fk where staff_role.role_name not in ('DC','UC','Lecturer') and user_staff.id not in (select user_staff.id from user_staff join staff_has_role on staff_has_role.id_staff_fk = user_staff.id and staff_has_role.id_role_fk=2 where staff_has_role.correlate_unit_id_fk = $unitid)";
$result_ava_staff = $mysqli->query($query_ava_staff);  
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
       <link rel="stylesheet" type="text/css" href="../../css/master_list_staff.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Add Tutor in unit| University of DoWell </title>
    </head>
    <body>
        <!-- navbar start here-->
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
                    <h2>Add staff to a academic list (Tutor) </h2>
                    <div class="container" id ="container_b"></div>
                    <div class="row">
                        <div class="col-xs-12">
                            <h4><?php echo "Hello ".$_SESSION['session_user_last_name']; ?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-9">
                    <p><a href="../master_list_page_staff/master_list_staff.php" > Back to the main list</a></p><!--link to meun-->
                </div>
            </div>
        </div>
        <!--title end-->  
        
          <div class="container">  
                <div class="table">
                    <table class="table table-striped table-bordered table-hover"> 
                        <?php 
                            while($row = mysqli_fetch_array($result_unit))
                            {
                            ?>
                        <h3><strong><?php echo $row['unit_code']; ?>&nbsp;<?php echo $row['unit_name']; ?></strong></h3>
                       <hr>
                         <?php } ?>
                             <h5><strong>Current Tutor in this unit  </strong></h5>
                        <thead>
                            <tr>
                                <th>Staff number</th>
                                <th>Last_name</th>
                                <th>First_name</th>
                                <th>UDW email</th>
                                <th>Unavailable</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                           <?php 
                            while($row1 = mysqli_fetch_array($result_unit_tutor))
                            {
                            ?>
                           
                        <tbody>
                         <tr>
                                <td><?php echo $row1['staff_number']; ?></td>
                                <td><?php echo $row1['last_name']; ?><br></td>
                                <td><?php echo $row1['first_name']; ?><br></td>
                                <td><?php echo $row1['UDW_email']; ?></td>
                                <td><?php echo $row1['unavailable']; ?></td>
                             <td><a href="delete_staff_in_unit.php?staff_id=<?php echo $row1['staff_id']?>&unitid=<?php echo $unitid ?>">Delete</a></td>
                            </tr>
                        </tbody>
                               <?php } ?>
                    </table>
                </div>
        </div>
        
         <div class="container">
            
                <div class="table">
                    <table id="dt" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                        <h5><strong>Add staff to acadmic staff list for this unit</strong></h5>
                       
                        <thead>
                            <tr>
                                <th>Staff number</th>
                                <th>Last_name</th>
                                <th>First_name</th>
                                <th>UDW email</th>
                                <th>Qualifaction</th>
                                <th>Expertise area</th>
                                <th>Current job role </th>
                                <th>Correrelate unit</th>
                                <th>Unavailable day</th>
                                <th>Add tutor in unit</th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php 
                            while($row2 = mysqli_fetch_array($result_ava_staff))
                            {
                                
                            ?>
                            <tr>
                                
                                <td><?php echo $row2['staff_number']; ?></td>
                                <td><?php echo $row2['last_name']; ?><br></td>
                                <td><?php echo $row2['first_name']; ?><br></td>
                                <td><?php echo $row2['UDW_email']; ?></td>
                                <td><?php echo $row2['qualifaction']; ?></td>
                                <td><?php echo $row2['expertise_area']; ?></td>
                                <td><?php echo $row2['role_name']; ?><br></td>
                                <td><?php echo $row2['unit_code']; ?></td>
                                 <td><?php echo $row2['unavailable']; ?></td>
                                <td><a href="add_staff_in_unit.php?staff_id=<?php echo $row2['staff_id']?>&unitid=<?php echo $unitid ?>">Add</a></td>
                               
                             <?php } ?>
                        </tbody>
                    </table>
                    
                </div>
           
        </div>

                    
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