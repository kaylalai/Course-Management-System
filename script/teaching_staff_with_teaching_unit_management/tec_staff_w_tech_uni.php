<!--this is a main page page of edit tutorial detail ,UC, DC CAN go from this page to see the related staff in the associated unit-->

<?php
session_start(); 
include('../db_conn.php'); 
$staff_id = $_SESSION['session_user_id'];
//Acess level help to different DC and UC DATA/
$access_level= $_SESSION['session_access_level'];


// show all tutorial //
$query_tutorial_dc= $mysqli->query("SELECT * , tutorial.id as tutorial_id from tutorial join unit_detail on unit_detail.id=tutorial.tutorial_unit_id");

//for uc - base on staff id to see related tutorial//
$query_unit_uc="select * from unit_detail where unit_coordinator=$staff_id";
$result_unit_uc = $mysqli->query($query_unit_uc);
//for uc -show only the tutorail in related to his/her unit//
$query_tutorial= $mysqli->query("SELECT * , tutorial.id as tutorial_id from tutorial join unit_detail on unit_detail.id=tutorial.tutorial_unit_id where unit_detail.unit_coordinator =$staff_id");



if(isset($_POST['sub']))  
{

    $count_id = $_SESSION['count_id'];
    echo $count_id ;
    for($i=0;$i<$count_id;$i++)
    {
        $tutorial_id= $_POST['tutorial_id_'.$i];
        $tutorial_code = $_POST['tutorial_code_'.$i];
        $start_time = $_POST['tutorial_time_start_at_'.$i];
        $end_time = $_POST['tutorial_time_end_at_'.$i];
        $location = $_POST['tutorial_location_'.$i];
        $capacity_tutorial =$_POST['capacity_for_student_'.$i];
        $consultation_start_time =$_POST['consultation_time_start_'.$i];
        $consultation_end_time =$_POST['consultation_time_end_'.$i];
        $consultation_location =$_POST['consultation_location_'.$i];
        
        
        // update the new value from each colum that user type in//
        $result=$mysqli->query("UPDATE tutorial SET 
        tutorial_code='$tutorial_code',
        tutorial_time_start_at='$start_time',
        tutorial_time_end_at='$end_time',
        tutorial_location='$location',
        capacity_for_student='$capacity_tutorial',
        consultation_time_start='$consultation_start_time',
        consultation_time_end='$consultation_end_time',
        consultation_location='$consultation_location'
        where id=$tutorial_id");
        header('location:tec_staff_w_tech_uni.php');
    }

}
else if($input['action'] == 'delete')
{
    $query1 = "
 DELETE FROM tutorial
 WHERE id = '".$_POST["tutorial_id"]."'
 ";
    $mysqli->query($query1);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://jonthornton.github.io/jquery-timepicker/jquery.timepicker.js"></script>
        <link rel="stylesheet" type="text/css" href="https://jonthornton.github.io/jquery-timepicker/jquery.timepicker.css">
        <script type="text/javascript" src="https://jonthornton.github.io/jquery-timepicker/lib/bootstrap-datepicker.js"></script>
        <link rel="stylesheet" type="text/css" href="https://jonthornton.github.io/jquery-timepicker/lib/bootstrap-datepicker.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" type="text/css" href="../../css/master_list_staff.css">
        <title>Tutorial management | University of DoWell </title>
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
        <!--ACESS LEVEL 5 IS DC, Show all tutorial--> 
        <?php
        if ($_SESSION['session_access_level']==5)
        { ?>
           <!-- title-->
        <div class="container">
            <div class="row">
                <div class="col-9" id ="col_b">
                    <h2>Manage teaching staff and tutorial details</h2>
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
            
            <div class="container">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="tec_staff_w_tech_uni.php">Tutorial details</a></li>
                    <li><a href="allocate_tutor_dc.php">Allocate Tutor</a></li>
                </ul>
                <div style="overflow-x:auto;">
                <form method="post" class="container" action="tec_staff_w_tech_uni.php">
                    <table id="editable_table" class="table table-bordered table-striped">
                        <tr>
                            <th style="display:none">ID</th>
                            <th>Tutorial code</th>
                            <th>Tutorial start time</th>
                            <th>Tutorial end time</th>
                            <th>Tutorial location</th>
                            <th>Capacity in tutorial</th>
                            <th>Consultation start time</th>
                            <th>Consultation end time</th>
                            <th>Consultation location</th>
                            <th>Save change</th>
                            <th>Delete</th>
                        </tr>
                        <?php 
         $count_id = 0;
         while($tutorial = mysqli_fetch_array($query_tutorial_dc))
         {
                        ?>
                        <tr>
                            <td style="display:none"><input hidden name="tutorial_id_<?php echo $count_id; ?>" value="<?php echo $tutorial['tutorial_id']; ?>" type="text"></td>
                            <td>
                                <input  name="tutorial_code_<?php echo $count_id; ?>" value="<?php echo $tutorial['tutorial_code']; ?>" type="text" id="tutorial_code">
                            </td>
                            <td>
                                <input name="tutorial_time_start_at_<?php echo $count_id; ?>" type="text" class="form-control" id="tutorial_time_start_at_<?php echo $count_id; ?>" value="<?php echo $tutorial['tutorial_time_start_at']; ?>" style="width: 85px;"/>
                            </td>

                            <td>
                                <input name="tutorial_time_end_at_<?php echo $count_id; ?>" type="text" class="form-control" id="tutorial_time_end_at_<?php echo $count_id; ?>" value="<?php echo $tutorial['tutorial_time_end_at']; ?>" style="width: 85px;"/>
                            </td>

                            <td>
                                <input  name="tutorial_location_<?php echo $count_id; ?>" value="<?php echo $tutorial['tutorial_location']; ?>" type="text" id="tutorial_location">
                            </td> 
                            <td>
                                <input  name="capacity_for_student_<?php echo $count_id; ?>" value="<?php echo $tutorial['capacity_for_student']; ?>" type="text" id="capacity_for_student">
                            </td>  
                            <td>
                                <input  name="consultation_time_start_<?php echo $count_id; ?>" value="<?php echo $tutorial['consultation_time_start']; ?>" type="text" id="consultation_time_start">
                            </td>  
                            <td>
                                <input name="consultation_time_end_<?php echo $count_id;?>" value="<?php echo $tutorial['consultation_time_end']; ?>" type="text" id="consultation_time_end">

                            </td>  
                            <td>
                                <input name="consultation_location_<?php echo $count_id;?>" value="<?php echo $tutorial['consultation_location']; ?>" type="text" id="consultation_location">
                            </td>    

                            <td colspan="1" align="center">
                                <input type="submit" value="Update" name="sub">
                            </td>
                            <td colspan="1" align="center">
                                <input type="submit" value="Delete" name="del"><i class="fa fa-trash-o" style="font-size:18px;color:red"></i>
                            </td>
                        </tr>
                        <?php
             $count_id++; } $_SESSION['count_id']=$count_id;  ?>
                    </table>
                </form> 
                </div>
            </div>

        <?php }
        if ($_SESSION['session_access_level']==4)
        {?>
        <!-- title-->
        <div class="container">
            <div class="row">
                <div class="col-9" id ="col_b">
                    <h2>Manage teaching staff and tutorial details</h2>
                    <div class="container" id ="container_b"></div>
                    <div class="row">
                        <div class="col-xs-12">
                            <h4><?php echo "Hello ".$_SESSION['session_user_last_name']; ?></h4> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
            
            <div class="container">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="tec_staff_w_tech_uni.php">Tutorial details</a></li>
                    <li><a href="allocate_lecturer.php">Allocate Lecturer</a></li>
                    <li><a href="allocate_tutor.php">Allocate Tutor</a></li>
                </ul>
                <div style="overflow-x:auto;">
                <form method="post" class="container" action="tec_staff_w_tech_uni.php">
                    <table id="editable_table" class="table table-bordered table-striped">
                        <tr>
                            <th style="display:none">ID</th>
                            <th>Tutorial code</th>
                            <th>Tutorial start time</th>
                            <th>Tutorial end time</th>
                            <th>Tutorial location</th>
                            <th>Capacity in tutorial</th>
                            <th>Consultation start time</th>
                            <th>Consultation end time</th>
                            <th>Consultation location</th>
                            <th>Save change</th>
                            <th>Delete</th>
                        </tr>
                        <?php 
         $count_id = 0;
         while($tutorial = mysqli_fetch_array($query_tutorial))
         {
                        ?>
                        <tr>
                            <td style="display:none"><input hidden name="tutorial_id_<?php echo $count_id; ?>" value="<?php echo $tutorial['tutorial_id']; ?>" type="text"></td>
                            <td>
                                <input  name="tutorial_code_<?php echo $count_id; ?>" value="<?php echo $tutorial['tutorial_code']; ?>" type="text" id="tutorial_code">
                            </td>
                            <td>
                                <input name="tutorial_time_start_at_<?php echo $count_id; ?>" type="text" class="form-control" id="tutorial_time_start_at_<?php echo $count_id; ?>" value="<?php echo $tutorial['tutorial_time_start_at']; ?>" style="width: 85px;"/>
                            </td>

                            <td>
                                <input name="tutorial_time_end_at_<?php echo $count_id; ?>" type="text" class="form-control" id="tutorial_time_end_at_<?php echo $count_id; ?>" value="<?php echo $tutorial['tutorial_time_end_at']; ?>" style="width: 85px;"/>
                            </td>

                            <td>
                                <input  name="tutorial_location_<?php echo $count_id; ?>" value="<?php echo $tutorial['tutorial_location']; ?>" type="text" id="tutorial_location">
                            </td> 
                            <td>
                                <input  name="capacity_for_student_<?php echo $count_id; ?>" value="<?php echo $tutorial['capacity_for_student']; ?>" type="text" id="capacity_for_student">
                            </td>  
                            <td>
                                <input  name="consultation_time_start_<?php echo $count_id; ?>" value="<?php echo $tutorial['consultation_time_start']; ?>" type="text" id="consultation_time_start">
                            </td>  
                            <td>
                                <input name="consultation_time_end_<?php echo $count_id;?>" value="<?php echo $tutorial['consultation_time_end']; ?>" type="text" id="consultation_time_end">

                            </td>  
                            <td>
                                <input name="consultation_location_<?php echo $count_id;?>" value="<?php echo $tutorial['consultation_location']; ?>" type="text" id="consultation_location">
                            </td>    

                            <td colspan="1" align="center">
                                <input type="submit" value="Update" name="sub">
                            </td>
                            <td colspan="1" align="center">
                                <input type="submit" value="Delete" name="del"><i class="fa fa-trash-o" style="font-size:18px;color:red"></i>
                            </td>
                        </tr>
                        <?php
             $count_id++; } $_SESSION['count_id']=$count_id;  ?>
                    </table>
                </form> 
                </div>
            </div>
        <?php } ?> 
        <!--footer start here-->
        <div class="footer">
            <p class="text-muted small mb-4 mb-lg-0">© University of DoWell 2020. All Rights Reserved.</p>
        </div>
        <!--footer end -->
        <!--time drop box rule user to select time in the correct format e.g 9:00/9:30-->
        <script type="text/javascript">
            var count_id = <?php echo $count_id; ?>;
            for(i=0;i<count_id;i++)
            {
                var number = i;
                $('#tutorial_time_start_at_'+number).timepicker({ 
                    'timeFormat': 'H:i:s',
                    'minTime': '08:00:00',
                    'maxTime': '19:30:00'

                });

                $('#tutorial_time_end_at_'+number).timepicker({ 
                    'timeFormat': 'H:i:s',
                    'minTime': '08:00:00',
                    'maxTime': '19:30:00'

                });
            }

        </script>

    </body>
</html>