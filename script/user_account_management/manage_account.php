<?php
session_start(); //checks if a session is already started and if none is started then it starts one
include('../db_conn.php'); //db connection

// check if user logged in is a student
if ($_SESSION['session_access_level']==0)
{

    $userEmail = $_SESSION['session_UDW_email'];
    // take the email to query in student table
    $result_student = $mysqli->query("SELECT * FROM user_student WHERE UDW_email='".$userEmail."'");
    $row=$result_student->num_rows; // store the value as whole row
    if ($row==1) //if have any username is exist,$row from  the select statement
    {
        $profile_data = mysqli_fetch_array($result_student);
    }
}
else // staff and student only
{
    $userEmail = $_SESSION['session_UDW_email'];
    // take the email to query in staff table
    $result_staff = $mysqli->query("SELECT * FROM user_staff WHERE UDW_email='".$userEmail."'");
    $row=$result_staff->num_rows; // store the value as whole row
    if ($row==1) //if have any username is exist,$row from  the select statement
    {
        $profile_data = mysqli_fetch_array($result_staff);
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <!-- Link to use icon-->
        <!-- Bootstrap CSS file -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script> 
        <!--my css-->
        <link rel="stylesheet" type="text/css" href="../../css/manage_account.css">
        <title>Manage account| University of DoWell </title>
    </head>
  <body>
        <!-- Top Navigation bar -->
           <!--top bar with show login logout-->
        <div class="topnav">
            <!-- Left-aligned -->
            <a><img src="../../asset/logo.png" alt="logo" style="width:40px; height: 30px; "></a>
            <a href="#">University of DoWell</a>    
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
                <div class="col-9" id ="col_b"><strong>Manage personal information and course </strong></div>
            </div>
        </div>
<!--show all the button link to different page,show base on the session_access_level at the bottom of the page(Student Enrolled tutorial List will be duplicate as different role see this page will be different fetch different data) -->
        <div class="container">
            <div class="col-10">
            <div class="row">
            Personal Information | 
            <a href="edit_user_detail.php">&nbsp;Edit Profile &nbsp;|</a>
            <a href="change_password.php">&nbsp;Change Password &nbsp;|</a> 
            <a href="../unit_enrolment_page/enrolment.php" style="display:none;" id="enrolment">&nbsp;Enrolment &nbsp;|</a>
            <a href="../tutorial_allocation/tute_system.php" style="display:none;" id="tutorial_allocation">&nbsp;Tutorial Allocation &nbsp;|</a> 
            <a href="../enrolled_student_details_page/dc_enrolled_stud_detail.php" style="display:none;" id="dc_enrolled_stud_detail">&nbsp;All Student Enrolled tutorial List &nbsp;|</a> <!--DC-->
            <a href="../enrolled_student_details_page/uc_student_tutorial_detail.php" style="display:none;" id="uc_student_tutorial_detail">&nbsp;Student Enrolled tutorial List &nbsp;|</a><!--uc-->
            <a href="../enrolled_student_details_page/lecturer_student_tutorial_detail.php" style="display:none;" id="lecturer_student_tutorial_detail">&nbsp;Student Enrolled tutorial List &nbsp;|</a><!--lecturer-->
            <a href="../enrolled_student_details_page/tutor_enrolled_stud_detail.php" style="display:none;" id="tutor_student_tutorial_detail">&nbsp;Student Enrolled tutorial List &nbsp;|</a><!--tutor-->    
            <a href="../teaching_staff_with_teaching_unit_management/tec_staff_w_tech_uni.php" style="display:none;" id="teaching_staff_with_teaching_unit_management">&nbsp;Teaching staff/Unit management &nbsp;|</a> 
            <a href="../master_list_page_unit/unitmaster.php" style="display:none;" id="unit_management">&nbsp;Unit management &nbsp;|</a> 
            <a href="../master_list_page_staff/master_list_staff.php" style="display:none;" id="academic_staff_management">&nbsp;Academic staff management &nbsp;|</a>
        </div>
        </div>
      </div>  
   <!--End all the button link to different page -->
<!--Personal information-from student_table-->  
        <?php if($_SESSION['session_access_level']==0) { ?>
            <div class="container">
            <table >
                <tr>                
                    <td><strong>First Name:</strong></td><td>&emsp;<?php echo $profile_data['first_name'] ?></td>   
                </tr>
                <tr>                
                    <td><strong>Last Name:</strong></td><td>&emsp;<?php echo $profile_data['last_name'] ?></td> 
                </tr> 
                <tr>
                    <td><strong> Date of Birth:</strong></td><td>&emsp;<?php echo $profile_data['date_of_birth'] ?></td>
                </tr>
                <tr>
                    <td><strong>Student ID:</strong></td><td>&emsp;<?php echo $profile_data['student_number'] ?></td>
                </tr>
                <tr>
                    <td><strong>Mobile: </strong></td><td>&emsp;<?php echo $profile_data['phone_number'] ?></td>
                </tr>
                <tr>
                    <td><strong>Address: </strong></td><td>&emsp;<?php echo $profile_data['address_street'] ?></td>
                </tr>
                <tr>
                    <td><strong>Suburb / City: </strong></td><td>&emsp;<?php echo $profile_data['address_city'] ?></td> 
                </tr> 
                <tr>
                    <td><strong>State: </strong></td><td>&emsp;<?php echo $profile_data['state'] ?></td> 
                </tr> 
                <tr>
                    <td><strong>Postal Code: </strong></td><td>&emsp;<?php echo $profile_data['postal_code'] ?></td> 
                </tr> 
            </table>
        </div>
    <!--End Personal information-->   
        <br><br>
        <!-- button to show timetable only for access level 0 (student)-->  
        <div class="container">
            <div class="row">
                <div class="col-xs-10">
                    <input type="button" class="btn btn-info btn-lg btn-block active" data-toggle="collapse" data-target="#toggleDemo" value="View my time table"><br>
                    <div id="toggleDemo" class="collapse">
                        <div id="calendar_student"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php }
        else { ?>
      <!-- else is the user in access level not equal to 0(staff_tabel)-->
        <div class="container" id ="container_b">
            <table >
                <tr>                
                    <td><strong>First Name: </strong></td><td>&emsp;<?php echo $profile_data['first_name'] ?></td>   
                </tr>
                <tr>                
                    <td><strong>Last Name: </strong></td><td>&emsp;<?php echo $profile_data['last_name'] ?></td> 
                </tr>
                <tr>
                    <td><strong>Mobile: </strong></td><td>&emsp;<?php echo $profile_data['phone_number'] ?></td>
                </tr>
                <tr>
                    <td><strong>Qualifaction: </strong></td><td>&emsp;<?php echo $profile_data['qualifaction'] ?></td> 
                </tr> 
                <tr>
                    <td><strong>Expertise: </strong></td><td>&emsp;<?php echo $profile_data['expertise_area'] ?></td> 
                </tr> 
                <tr>
                    <td><strong> Unavailability : </strong></td><td>&emsp;<?php echo $profile_data['unavailable'] ?></td> 
                </tr>
                <tr>
                    <td><strong>Address: </strong></td><td>&emsp;<?php echo $profile_data['address_street'] ?></td>
                </tr>
                <tr>
                    <td><strong>Suburb: </strong></td><td>&emsp;<?php echo $profile_data['address_city'] ?></td> 
                </tr> 
                <tr>
                    <td><strong>State: </strong></td><td>&emsp;<?php echo $profile_data['state'] ?></td> 
                </tr> 
                <tr>
                    <td><strong>Postal Code: </strong></td><td>&emsp;<?php echo $profile_data['postal_code'] ?></td> 
                </tr> 
            </table>
        </div>
        <?php }?>
        <!--time table finish--> 
        <!--footer-->
        <br>
        <div class="footer container" style="text-align:center">
            <p class="text-muted small mb-4 mb-lg-0">© University of DoWell 2020. All Rights Reserved.</p>
        </div>
            <!--footer end-->
      <!-- script for plugin timetable-->
        <script type="text/javascript">
            $(document).ready(function() {   
                var calendar_stud = $('#calendar_student').fullCalendar({
                    editable:false,
                    header:{
                        left:'prev,next today',
                        center:'title',
                        right:'month,agendaWeek,agendaDay'
                    },

                    eventSources: [
                        {
                            url: 'back_end_events_student_lecture.php',
                            color: 'red',
                            textColor: 'black'
                        },
                        {
                            url: 'back_end_events_student_tutorial.php',
                            color: 'orange',
                            textColor: 'black'
                        }
                    ],    

                    validRange: function(nowDate) {
                        return {
                            start: '2020-02-24',
                            end: '2020-05-31'
                        };
                    },

                    selectable:false,
                    minTime: "08:00:00",
                    maxTime: "19:00:00",
                    heights: 'auto'
                });

                $('#toggleDemo').on('shown.bs.collapse', function () {
                    $('#calendar_student').fullCalendar('today');
                });

            });
        </script>
    </body>
</html> 

<!--access level for show different button-->
<?php
if ($_SESSION['session_access_level']==0) //STUDENT
{
    echo "<script type='text/javascript'>document.getElementById('enrolment').style.display = 'block'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('tutorial_allocation').style.display = 'block'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('teaching_staff_with_teaching_unit_management').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('unit_management').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('academic_staff_management').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('dc_enrolled_stud_detail').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('uc_student_tutorial_detail').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('lecturer_student_tutorial_detail').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('tutor_student_tutorial_detail').style.display = 'none'</script>"; 
}
    elseif ($_SESSION['session_access_level']==1)//general staff
    {
     echo "<script type='text/javascript'>document.getElementById('enrolment').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('tutorial_allocation').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('teaching_staff_with_teaching_unit_management').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('unit_management').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('academic_staff_management').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('dc_enrolled_stud_detail').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('uc_student_tutorial_detail').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('lecturer_student_tutorial_detail').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('tutor_student_tutorial_detail').style.display = 'none'</script>";
    }
        elseif ($_SESSION['session_access_level']==2)//tutor
        {
          echo "<script type='text/javascript'>document.getElementById('enrolment').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('tutorial_allocation').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('teaching_staff_with_teaching_unit_management').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('unit_management').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('academic_staff_management').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('dc_enrolled_stud_detail').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('uc_student_tutorial_detail').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('lecturer_student_tutorial_detail').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('tutor_student_tutorial_detail').style.display = 'block'</script>"; 
        }
        elseif ($_SESSION['session_access_level']==3)//Lecture
        {
            echo "<script type='text/javascript'>document.getElementById('enrolment').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('tutorial_allocation').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('teaching_staff_with_teaching_unit_management').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('unit_management').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('academic_staff_management').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('dc_enrolled_stud_detail').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('uc_student_tutorial_detail').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('lecturer_student_tutorial_detail').style.display = 'block'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('tutor_student_tutorial_detail').style.display = 'none'</script>";
        }
        elseif ($_SESSION['session_access_level']==4)  //uc
        {
           echo "<script type='text/javascript'>document.getElementById('enrolment').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('tutorial_allocation').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('teaching_staff_with_teaching_unit_management').style.display = 'block'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('unit_management').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('academic_staff_management').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('dc_enrolled_stud_detail').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('uc_student_tutorial_detail').style.display = 'block'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('lecturer_student_tutorial_detail').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('tutor_student_tutorial_detail').style.display = 'none'</script>";
        }
else //DC
{
     echo "<script type='text/javascript'>document.getElementById('enrolment').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('tutorial_allocation').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('teaching_staff_with_teaching_unit_management').style.display = 'block'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('unit_management').style.display = 'block'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('academic_staff_management').style.display = 'block'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('dc_enrolled_stud_detail').style.display = 'block'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('uc_student_tutorial_detail').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('lecturer_student_tutorial_detail').style.display = 'none'</script>"; 
    echo "<script type='text/javascript'>document.getElementById('tutor_student_tutorial_detail').style.display = 'none'</script>";
}
?>