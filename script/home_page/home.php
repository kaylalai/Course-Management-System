<?php
session_start(); //checks if a session is already started and if none is started then it starts one
include('../db_conn.php'); //db connection

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Home -Course | University of DoWell </title>
        <!-- Bootstrap CSS file -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="../../css/home_style.css">
    </head>
    <body>
        <!-- navbar-->
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-brand">
                    <img src="../../asset/logo.png" alt="logo" style="width:50px;height: 35px;">
                </div>
                <div class="navbar-header">
                    <a class="navbar-brand" href="home.php">University of DoWell</a>
                </div>
                <div class=button_account>
                    <a id="signup" type="button" name="signup" class="navbar-brand" href="../registation_page/main_registation/register.php">Create an account</a>
                </div>
                <div class="collapse navbar-collapse" style="text-align:right">
                    <form class="form-inline my-2 my-lg-0" action="home.php" method="post" id="myForm"> <!--inside this from once user submit will go to home.php-->
                        <input name="UDW_email" placeholder="abc123@udw.edu.au" type="text" id="UDW_email">
                        <input name="password" placeholder="Password" type="password" id="password">    
                        <button class="btn" id="Login" type="submit" >Login</button>
                    </form>
                    <form method="post">  <!--put it as a from to pst the data in later php code to distory the data(once user click-->
                        <button class="btn" id="logoutBtn" name="logout" style="display:none; float:right" href="../logout_session.php">Log out</button> <!--not display, until user successfully login-->
                    </form>
                </div>
            </div>
        </nav>
<!-- 1.Match pw  2.Match user in system or not (if exist alert/if not go else if)  -->
        <?php
        if(isset($_POST['UDW_email'])){ //use isset to checks whether a variable is set and is not NULL//

            // give variable( username= email) to define the data ->from method: posted ,call the element button 'name/id'//
            $UDW_email = $_POST['UDW_email']; 
            $password = $_POST['password'];

            //check is it have UDW_email exit in user_student table also check in user_staff table//
            $check_tblStudent = $mysqli->query("SELECT * FROM user_student WHERE UDW_email='$UDW_email'");//store in variable
            $check_tblStaff = $mysqli->query("select *, user_staff.id as user_id from user_staff 
                                                    join staff_has_role on staff_has_role.id_staff_fk= user_staff.id 
                                                    join staff_role on staff_role.id =staff_has_role.id_role_fk 
                                                    WHERE UDW_email= '$UDW_email'
                                                    ORDER BY staff_role.access_level DESC");
            //mysqli_fetch_array`storing the data in the numeric indices of the result ;store not as a row, store each coloum individual value

            //store the data from select two statement into a fetch row contain all columns from db//
            $fetch1 = mysqli_fetch_array($check_tblStudent);//store each coloum value ,*mysqli_fetch_assoc* include case sensitive
            $fetch2 = mysqli_fetch_array($check_tblStaff);

            $row_tblStudent=$check_tblStudent->num_rows; // count the number of row in that fetch//
            $row_tblStaff=$check_tblStaff->num_rows;  

            // the email does not exist in BOTH tables 
            if($row_tblStudent==0 && $row_tblStaff==0)
            {
                echo "<script type='text/javascript'>alert('Do not have a record');</script>";
            }
            else
            {
                //if the user is a student
                if($row_tblStudent==1)
                {
                    //get the hash password from the student table
                    $hash_student=$fetch1['password'];  //give variable for $encr-passwork fetch(from student db)
                    //if(password_verify($_POST['password'],$hash)), //compare the database password and input password
                    if(password_verify($password,$hash_student)) 
                    {
                        //diff access level diff user, take that coloum value name in db as 'access'level 0,1,2 etc value must declear before this part (as a coloum)
                        $_SESSION['session_UDW_email']=$UDW_email;  //save in session
                        $_SESSION['session_access_level']=$fetch1['access_level'];  
                        $_SESSION['session_user_last_name']=$fetch1['last_name'];
                        $_SESSION['session_user_id']=$fetch1['id']; 
                        header('location: home.php');
                    }
                    // the password is wrong
                    else
                    {
                        echo "<script type='text/javascript'>alert('Incorrect username/password');</script>";
                    }
                }
                // if the user is a staff
                else
                {
                    //get the hash password from the student table
                    $hash_staff=$fetch2['password'];  //give variable for $encr-passwork fetch(from student db)
                    //if(password_verify($_POST['password'],$hash)), //compare the database password and input password
                    if(password_verify($password,$hash_staff)) 
                    {
                        //diff access level diff user, take that coloum value name in db as 'access'level 0,1,2 etc value must declear before this part (as a coloum)
                        $_SESSION['session_UDW_email']=$UDW_email;  //save in session
                        $_SESSION['session_access_level']=$fetch2['access_level'];  
                        $_SESSION['session_user_last_name']=$fetch2['last_name'];
                        $_SESSION['session_user_id']=$fetch2['user_id'];
                        header('location: home.php');
                    }
                    // the password is wrong
                    else
                    {
                        echo "<script type='text/javascript'>alert('Incorrect username/password');</script>";
                    }
                }
            }
        }

         //New STATEMENT, 1. Need to place after the (logout-button) 2.perform the session_destroy is when user click the button.
        if(isset($_POST["logout"]))
        {
            session_destroy();  //destroy the sessions saved before.
            header('Location: home.php');  //automatically go back to homepage
        }
        
        ?>

<!--this part php excute if login successful, then diff access level have diff alert box and gain access to the other page-->
        <?php                  
        if(isset($_SESSION['session_UDW_email'])){  //if login successful//
            echo "<script type='text/javascript'>document.getElementById('Login').style.display = 'none'</script>"; //hide the login button
            echo "<script type='text/javascript'>document.getElementById('signup').style.display = 'none'</script>"; //hide the signup button
            echo "<script type='text/javascript'>document.getElementById('UDW_email').style.display = 'none'</script>"; //hide the input box
            echo "<script type='text/javascript'>document.getElementById('password').style.display = 'none'</script>"; //hide the input box
            echo "<script type='text/javascript'>document.getElementById('password').style.display = 'none'</script>"; //hide the input box
            echo "<script type='text/javascript'>document.getElementById('logoutBtn').style.display = 'block'</script>"; //display logout button

            if($_SESSION['session_access_level']==0)//if session contain user = 0 =student(above) then here is depan on the the access level-0 excute the interface
            {?>   
        <!--container pic in the middle--> 
        <div class="bg-image">
            <div class="container-fluid">
                <div class="bg-text">
                    <h2>Course Management System</h2>
                    <div>
                        <h4><strong>
                            <?php 
                echo 'Welcome '.$_SESSION['session_user_last_name'];
                            ?>
                            </strong> </h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- container x3 button( student logined=all button worked) -->
        <section class="features-icons bg-light text-center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4" id="a-col">
                        <div class="mx-auto features-icons-item mb-5 mb-lg-0 mb-lg-3">
                            <div class="thumbnail">
                                <img class="img-fluid" src="../../asset/book.png" alt="Lights" style="width:20%">
                                <h3>Unit Enrolment</h3>
                                <p class="lead mb-0">All students enrolling for undergraduate and postgraduate coursework degrees enrol online via course management system.</p>
                                <a href="../unit_enrolment_page/enrolment.php"><button type="button" class="btn btn-primary" btn-block btn-lg >Enrol now</button></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4"id="a-col">
                        <div class="mx-auto features-icons-item mb-5 mb-lg-0 mb-lg-3">
                            <div class="thumbnail">
                                <img class="img-fluid" src="../../asset/enrol.png" alt="Lights" style="width:20%">
                                <h3>Unit details</h3>
                                <p class="lead mb-0">Review the Course detail and outline here.The unit Handbook is to see which units you need to enrol in.</p>
                                <a href="../unit_detail_all_access/unitdetail.php"><button type="botton" class="btn btn-primary" btn-block btn-lg>Course</button></a>
                            </div>
                        </div>
                    </div>    
                    <div class="col-lg-4" id="a-col">
                        <div class="mx-auto features-icons-item mb-5 mb-lg-0 mb-lg-3">
                            <div class="thumbnail">
                                <img class="img-fluid" src="../../asset/time.png" alt="Lights" style="width:20%">
                                <h3>Individual timetable</h3>
                                <p class="lead mb-0">The timetable will show all events scheduled for each unit, though you may not be required to attend every one of them.</p>
                                <a href="../individual_timetable_page/mytimetable.php"><button type="botton" class="btn btn-primary" btn-block btn-lg>Mytime table</button></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4" id="a-col">
                        <div class="mx-auto features-icons-item mb-5 mb-lg-0 mb-lg-3">
                            <div class="thumbnail">
                                <img class="img-fluid" src="../../asset/time.png" alt="Lights" style="width:20%">
                                <h3>Manage your account </h3>
                                <p class="lead mb-0">You can manage your personal information, change password through the account management system here. </p>
                                <a href="../user_account_management/manage_account.php"><button type="botton" class="btn btn-primary" btn-block btn-lg>Manage Account</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>        
        </section>
        <?php }

            elseif ($_SESSION['session_access_level']!=0) 
                //not equal to zero is mean 1,2 level    
            { ?>
        <div class="bg-image">
            <div class="container-fluid">
                <div class="bg-text">
                    <h2>Course Management System</h2>
                    <div >
                        <h4><strong>
                            <?php 
                echo 'Welcome '.$_SESSION['session_user_last_name'] ;
                            ?>
                            </strong> </h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- container x3 button(staff logined;none enrol & time table)(alert by onlick="return no_access_to(); show messgae ) -->
        <section class="features-icons bg-light text-center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4" id="a-col">
                        <div class="mx-auto features-icons-item mb-5 mb-lg-0 mb-lg-3">
                            <div class="thumbnail">
                                <img class="img-fluid" src="../../asset/book.png" alt="Lights" style="width:20%">
                                <h3>Unit Enrolment</h3>
                                <p class="lead mb-0">All students enrolling for undergraduate and postgraduate coursework degrees enrol online via course management system.</p>
                                <a href="../unit_enrolment_page/enrolment.php"><button type="button" class="btn btn-primary" btn-block btn-lg onclick="return no_access_to();">Enrol now</button></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4" id="a-col">
                        <div class="mx-auto features-icons-item mb-5 mb-lg-0 mb-lg-3">
                            <div class="thumbnail">
                                <img class="img-fluid" src="../../asset/enrol.png" alt="Lights" style="width:20%">
                                <h3>Unit details</h3>
                                <p class="lead mb-0">Review the Course detail and outline here.The unit Handbook is to see which units you need to enrol in.</p>
                                <a href="../unit_detail_all_access/unitdetail.php"><button type="botton" class="btn btn-primary" btn-block btn-lg>Course</button></a>
                            </div>
                        </div>
                    </div>    
                    <div class="col-lg-4" id="a-col">
                        <div class="mx-auto features-icons-item mb-5 mb-lg-0 mb-lg-3">
                            <div class="thumbnail">
                                <img class="img-fluid" src="../../asset/time.png" alt="Lights" style="width:20%">
                                <h3>Individual timetable</h3>
                                <p class="lead mb-0">The timetable will show all events scheduled for each unit, though you may not be required to attend every one of them.</p>
                                <a href="../individual_timetable_page/mytimetable.php"><button type="botton" class="btn btn-primary" btn-block btn-lg onlick="return no_access_to();">Mytime table</button></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4" id="a-col">
                        <div class="mx-auto features-icons-item mb-5 mb-lg-0 mb-lg-3">
                            <div class="thumbnail">
                                <img class="img-fluid" src="../../asset/time.png" alt="Lights" style="width:20%">
                                <h3>Manage your account </h3>
                                <p class="lead mb-0">You can manage your personal information, change password through the account management system here.</p>
                                <a href="../user_account_management/manage_account.php"><button type="botton" class="btn btn-primary" btn-block btn-lg>Manage Account</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>        
        </section>
        <?php }
        }
        else //none of the above statement is true , then come here (visitor)//
        {
        ?>
        <div class="bg-image">
            <div class="container-fluid">
                <div class="bg-text">
                    <h2>Course Management System</h2>
                </div>
            </div>
        </div>
        <!--container x3 button(visitor:alert login required in enrolment button) -->
        <!--vistior cannot click on unit enrolment ,alert them to login first but can go in time table-->
        <section class="features-icons bg-light text-center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4" id="a-col">
                        <div class="mx-auto features-icons-item mb-5 mb-lg-0 mb-lg-3">
                            <div class="thumbnail">
                                <img class="img-fluid" src="../../asset/book.png" alt="Lights" style="width:20%">
                                <h3>Unit Enrolment</h3>
                                <p class="lead mb-0">All students enrolling for undergraduate and postgraduate coursework degrees enrol online via course management system.</p>
                                <a href="../unit_enrolment_page/enrolment.php"><button type="button" class="btn btn-primary" btn-block btn-lg onclick="return my_force_login();">Enrol now</button></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4"id="a-col">
                        <div class="mx-auto features-icons-item mb-5 mb-lg-0 mb-lg-3">
                            <div class="thumbnail">
                                <img class="img-fluid" src="../../asset/enrol.png" alt="Lights" style="width:20%">
                                <h3>Unit details</h3>
                                <p class="lead mb-0">Review the Course detail and outline here.The unit Handbook is to see which units you need to enrol in.</p>
                                <a href="../unit_detail_all_access/unitdetail.php"><button type="botton" class="btn btn-primary" btn-block btn-lg>Course</button></a>
                            </div>
                        </div>
                    </div>    
                    <div class="col-lg-4" id="a-col">
                        <div class="mx-auto features-icons-item mb-5 mb-lg-0 mb-lg-3">
                            <div class="thumbnail">
                                <img class="img-fluid" src="../../asset/time.png" alt="Lights" style="width:20%">
                                <h3>Individual timetable</h3>
                                <p class="lead mb-0">The timetable will show all events scheduled for each unit, though you may not be required to attend every one of them.</p>
                                <a href="../individual_timetable_page/mytimetable.php"><button type="botton" class="btn btn-primary" btn-block btn-lg onclick="return my_force_login();">Mytime table</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>

        <?php }
        ?>
        <!--footer-->
        <div class="footer">
            <p class="text-muted small mb-4 mb-lg-0">© University of DoWell 2020. All Rights Reserved.</p>
        </div>
        <script type="text/javascript">
            /*my_force_login function for visitor when click on unit enrolment button, prevent go in this page*/
            function my_force_login() {
                alert ("Login is required!");
                return false;
            }  
            /*no_access_to function for logined person nut non student (stuff in any leve)  when click on unit enrolment button*/
            function no_access_to() {
                alert ("Only student have access on this page!");
                return false;
            }  
        </script>

        <!--JS files: jQuery first, then Popper.js, then Bootstrap JS-->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    </body>
</html>