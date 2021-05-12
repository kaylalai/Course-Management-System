<?php
session_start(); //checks if a session is already started and if none is started then it starts one
include('../db_conn.php'); //db connection
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Class time table | University of DoWell</title>
        <!-- Bootstrap CSS file -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../../css/mytimetable.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    </head>
    <body>  
        <!-- Top Navigation bar -->
        <div class="topnav">
            <!-- Centered link -->
            <div class="topnav-centered">
                <a>Time table</a>
            </div>
            <!-- Left-aligned -->
            <a><img src="../../asset/logo.png" alt="logo" style="width:40px; height: 30px; "></a>
            <a href="#">University of DoWell</a>    
            <!-- Right-aligned links -->
            <div class="topnav-right">
                <a href="../home_page/home.php" class="button6">Home</a>
                <a href="../logout_session.php" class="button6" id="logoutBtn" name="logout" >Log out</a> 
            </div>

        </div>
        <div class="centered">
            <h4><center>Semester 1 class start from 24 th Feb 2020 to 31th May2020</center></h4>
        </div>
        <br >
    <?php
            if($_SESSION['session_access_level']==0) //if session contain access level '0'=student
            { ?>
                    <div class="container">
                    <div id="calendar_student"></div>
                    </div>
                <?php }
        
        else  // else is other access level can see all the lecture and tutorial time
            { ?>
            <div class="container">
            <div id="calendar"></div>
        </div>
        <?php }?>


        <!--footer-->
        <div class="footer">
            <p class="text-muted small mb-4 mb-lg-0">© University of DoWell 2020. All Rights Reserved.</p>
        </div>  
<!--footer end-->
<!--script for different user show different timetable context #calendar for UC,DC,OTHER AND #calendar_student for student-->
        <script type="text/javascript">
            $(document).ready(function() {   
                var calendar = $('#calendar').fullCalendar({
                    editable:false,
                    header:{
                        left:'prev,next today',
                        center:'title',
                        right:'month,agendaWeek,agendaDay'
                    },
                    eventSources: [
                        {
                            url: 'back_end_events_all_lecture.php',
                            color: 'pink',
                            textColor: 'black'
                        },
                        {
                            url: 'back_end_events_all_tutorial.php',
                            color: 'royalblue',
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

            });
            
            
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

            });
        </script>
    </body>
</html>