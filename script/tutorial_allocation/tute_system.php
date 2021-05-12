<?php
session_start(); 
include('../db_conn.php'); 
$student_id = $_SESSION['session_user_id'];

//user session to get the student id excute the query join //
$query_enrolled_tute_detail="SELECT * FROM tutorial 
left join tutorial_enrolment on tutorial_enrolment.id_tut_fk = tutorial.id and tutorial_enrolment.id_stud_fk = $student_id
where tutorial.tutorial_unit_id in (SELECT unit_detail.id as tutID from unit_detail join unit_enrolment on unit_enrolment.enrol_unit_id = unit_detail.id join user_student on user_student.id = unit_enrolment.student_id and user_student.id=$student_id)";
$result_enrolled_tute_detail = $mysqli->query($query_enrolled_tute_detail);

//Use check box to allow student enroll , checkbox contain different unit id in the while loop , student have to click submit and the table will update that selected checkbox as enrolled status(show database enrolment status colum).
if(isset($_POST['sub']))  
{   
    $checkbox=$_POST['enrolment']; 
    $checkbox2=$_POST['unenrolment']; 
    foreach($checkbox as $checked_enrolled_tutorial_id)  
    {  

        $query_get_unit_id = "select * from tutorial where id=$checked_enrolled_tutorial_id";
        $result = $mysqli->query($query_get_unit_id);
        while($row = mysqli_fetch_array($result))
        {
            $unit_id = $row['tutorial_unit_id'];
        }

        // this block of code is to get the count of enrolled student and then add 1 more when insert enrolment
        // prepare the query to get the count of enrolled student
        $query_count = "select * from tutorial join tutorial_enrolment on tutorial_enrolment.id_tut_fk = tutorial.id where tutorial.id = $checked_enrolled_tutorial_id";
        $result_count = $mysqli->query($query_count);
        while($row2 = mysqli_fetch_array($result_count))
        {
            // get the count of enrolled student
            $count = $row2['count_row'];
            // get the capacity
            $capacity = $row2['capacity_for_student'];

        }
        //end block
//insert the student in the unit enrolment table , use the colum "status" insert "enrolled" to show in the table for user , if withdraw ,the hold row will delete//
        if ($count==0 || $count<$capacity)
        {
            $query="INSERT INTO tutorial_enrolment (id_stud_fk, id_tut_fk, id_tut_unit_fk, tuto_enrolment_status ) values 
            ($student_id, $checked_enrolled_tutorial_id, $unit_id, 'Enrolled')";
            $result_enroll = $mysqli->query($query);
            $rc = $mysqli->affected_rows; //store affected rows
            if($rc>0)  
            {  
                // plus 1 more to the count
                $count = $count+1;
                $query_updateCount="UPDATE tutorial SET count_row=$count where tutorial.id=$checked_enrolled_tutorial_id";
                $result_updateCount = $mysqli->query($query_updateCount);
                $_SESSION['message'] = 'Successfully enrolled!';
                header('location: tute_system.php');
            }  
            else  
            {  
                echo '<script>alert("Cannot enrol in the same unit,you need to unenroll the tutorial from same unit first!")</script>';  
            }  
        }
        else
        {
            echo '<script>alert("Capacity is full")</script>'; 
        }



    }

    foreach($checkbox2 as $checked_value_as_unenrolled_tutorial_id)  
    {  
        // this block of code is to get the count of enrolled student and then add 1 more when insert enrolment
        // prepare the query to get the count of enrolled student
        $query_count = "select * from tutorial join tutorial_enrolment on tutorial_enrolment.id_tut_fk = tutorial.id where tutorial.id = $checked_value_as_unenrolled_tutorial_id";
        $result_count = $mysqli->query($query_count);
        while($row_unenroll = mysqli_fetch_array($result_count))
        {
            // get the count of enrolled student
            $count = $row_unenroll['count_row'];
            // get the capacity
            $capacity = $row_unenroll['capacity_for_student'];
        }
        //end block

        $query2="Delete from tutorial_enrolment where id_tut_fk = $checked_value_as_unenrolled_tutorial_id and id_stud_fk =$student_id ";
        $result_student_unenrol = $mysqli->query($query2);
        $rc2 = $mysqli->affected_rows; //store affected rows
        if($rc2>0)  
        {  
            $count = $count-1;
            $query_updateCount2="UPDATE tutorial SET count_row=$count where tutorial.id=$checked_value_as_unenrolled_tutorial_id";
            $result_updateCount = $mysqli->query($query_updateCount2);
            $_SESSION['message'] = 'Successfully unenrolled';
            header('location: tute_system.php');
        }  
        else  
        {  
            echo '<script>alert("Failed To Unenrol")</script>';  
        }  
    }
}  
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
        <link rel="stylesheet" type="text/css" href="../../css/tutesystem.css">
        <title>Tutorial allocation| University of DoWell </title>
    </head>
    <body>
   <!-- navbar start here-->
        <div class="topnav">
            <!-- Left-aligned -->
            <a><img src="../../asset/logo.png" alt="logo" style="width:40px; height: 30px; "></a>
            <a href="../home_page/home.php">University of DoWell</a>    
            <!-- Right-aligned links -->
            <div class="topnav-right">
                <a href="../logout_session.php" class="button6" id="logoutBtn" name="logout">Log out</a> <!--not display, until user  login-->
                <a href="../home_page/home.php" class="button6">Home</a>
            </div>
        </div>
        <!-- navbar start end-->
        <!--title-->
        <br>
         <div class="container">
        <div class="container" id ="container_b">
            <div class="row">
                <div class="col-xs-12">
                    <h4><strong>
                        <?php 
                        echo 'Hello '.$_SESSION['session_user_last_name'] ;
                        ?>
                        </strong> </h4>
                    <h2>Enrolment List</h2>
                    <h2>Tutorial enrollment </h2> 
                    <?php if(isset($_SESSION['message'])) { ?>
                    <div class=""><strong><?php echo $_SESSION['message']; ?></strong></div>
                    <?php }?>
                </div>
            </div>
            </div>
             <br><br>
       <form id="tute_enrolment" method="post" role="form" action="tute_system.php">  
                   <table class="table table-striped table-bordered table-hover">
                            <tr >  
                                <thead>
                                    <tr>
                                  
                                        <th>Tutorial code</th>
                                        <th>Tutorial start time</th>
                                        <th>Tutorial end time</th>
                                        <th>Tutorial location</th>
                                        <th>Capacity for tutorial</th>
                                        <th>Current student enrolled number</th>
                                        <th>Status</th>
                                        <th>Withdraw</th>

                                    </tr>
                                </thead>
                            </tr> 
                            <?php 
                            while($row1 = mysqli_fetch_array($result_enrolled_tute_detail))
                            {
                            ?>
                            <tr> 
                        
                                <td><?php echo $row1['tutorial_code']; ?><br></td>
                                <td><?php echo $row1['tutorial_time_start_at']; ?><br></td>
                                <td><?php echo $row1['tutorial_time_end_at']; ?><br></td>
                                <td><?php echo $row1['tutorial_location']; ?><br></td>
                                <td><?php echo $row1['capacity_for_student']; ?><br></td>
                                <td><?php echo $row1['count_row']; ?><br></td>
                                <!--take the id here to checkbox enrolment and unenrolment -->
                                <td><?php echo $row1['tuto_enrolment_status']; if($row1['tuto_enrolment_status']!='Enrolled') {?><input type="checkbox" name="enrolment[]" value="
                                    <?php echo $row1['id'] ?>"><br></td> <?php } ?>
                                <?php if($row1['tuto_enrolment_status']=='Enrolled'){?>
                                <td><input type="checkbox" name="unenrolment[]" value="
                                    <?php echo $row1['id'] ?>"><br></td> <?php }
                                else {echo "<td></td>";} ?>  
                            </tr> 
                            <?php } ?>
                        </table>  
                        <td colspan="2" align="center"><input type="submit" value="submit" name="sub"></td> 
                    </form>  
    </div>
    <hr>
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
