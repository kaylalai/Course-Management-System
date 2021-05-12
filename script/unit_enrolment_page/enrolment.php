<?php
session_start(); 
include('../db_conn.php'); 
$student_id = $_SESSION['session_user_id'];

//user session to get the student id excute the query//
$query_unitdetail="select * from unit_detail left outer join (select unit_detail.id as unit_id, unit_enrolment.student_id, unit_enrolment.enrolment_status from unit_detail join unit_enrolment on unit_detail.id = unit_enrolment.enrol_unit_id where unit_enrolment.student_id= $student_id) as b on unit_detail.id = b.unit_id";
$result_unitdetail = $mysqli->query($query_unitdetail);

//Use check box to allow student enroll , checkbox contain different unit id in the while loop , student have to click submit and the table will update that selected checkbox as enrolled status(show database enrolment status colum).
if(isset($_POST['sub']))  
{   
    $checkbox=$_POST['enrolment']; 
    $checkbox2=$_POST['unenrolment']; 
    foreach($checkbox as $checked_value_as_enrolled_unit_id)  
    {  
        $query="INSERT INTO unit_enrolment (enrol_unit_id, student_id,enrolment_status ) values ($checked_value_as_enrolled_unit_id, $student_id, 'Enrolled')";
        $result_student_enrol = $mysqli->query($query);
        $rc = $mysqli->affected_rows; //store affected rows
        if($rc>0)  
        {  
            $_SESSION['message'] = 'Successfully enrolled';
            header('location: enrolment.php');
        }  
        else  
        {  
            echo '<script>alert("Failed To Enrol")</script>';  
        }  

    }
    //Student can unenrol, the checkbox show in withdraw coloum //
    foreach($checkbox2 as $checked_value_as_unenrolled_unit_id)  
    {  
        $query2="Delete from unit_enrolment where enrol_unit_id = $checked_value_as_unenrolled_unit_id and student_id =$student_id ";
        $result_student_unenrol = $mysqli->query($query2);
        $rc2 = $mysqli->affected_rows; //store affected rows
        if($rc2>0)  
        {  
            $_SESSION['message'] = 'Successfully withdraw';
            header('location: enrolment.php');
        }  
        else  
        {  
            echo '<script>alert("Failed to withdraw")</script>';  
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
        <link rel="stylesheet" type="text/css" href="../../css/enrolstyle.css">
        <title>Enrollment  | University of DoWell </title>
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
                    <h2>Unit enrollment </h2> 
                    <?php if(isset($_SESSION['message'])) { ?>
                    <div class=""><strong><?php echo $_SESSION['message']; ?></strong></div>
                    <?php }?>
                </div>
            </div>
            </div>
             <br><br>
                <form id="enrolment" method="post" role="form" action="enrolment.php">   
                   <table class="table table-striped table-bordered table-hover">
                        <tr>  
                            <thead>
                                <tr>

                                    <th>Unit code</th>
                                    <th>Unit name</th>
                                    <th>Study Periods</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th>Withdraw</th>
                                </tr>
                            </thead>
                        </tr> 
                        <?php 
                        while($row1 = mysqli_fetch_array($result_unitdetail))
                        {
                        ?>
                        <tr> 
                            <td style="display:none;" ><?php echo $row1['id']; ?></td>
                            <td style="font-size: 14px;"><?php echo $row1['unit_code']; ?></td>
                            <td><?php echo $row1['unit_name']; ?><br></td>
                            <td><?php echo $row1['semester']; ?><br></td>
                            <td><?php echo $row1['campus']; ?><br></td>

                            <td><?php echo $row1['enrolment_status']; if($row1['enrolment_status']!='Enrolled') {?><input type="checkbox" name="enrolment[]" value="
                                <?php echo $row1['id'] ?>"><br></td> <?php } ?>

                            <?php if($row1['enrolment_status']=='Enrolled'){?>
                            <td><input type="checkbox" name="unenrolment[]" value="
                                <?php echo $row1['id'] ?>"><br></td> <?php }
                            else {echo "<td></td>";} ?>  
                        </tr> 

                        <?php } ?>
                    </table>  
                   <input type="submit" value="submit" name="sub" style="float:right;">
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