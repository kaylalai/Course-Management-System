<?php
session_start(); //checks if a session is already started and if none is started then it starts one
include('../../db_conn.php'); //db connection

if(isset($_POST["submitBtn"])){ //get the vale from post method,username is the name of the from 
    $UDW_email= $_POST["UDW_email"]; 
    $result = $mysqli->query("SELECT * FROM user_student WHERE UDW_email='$UDW_email'");//fetch the outcome to $result, dont need check staff table, user can be both student and staff 
    $row=$result->num_rows; // store the value as whole row
    if ($row==1) //if have any username is exist,$row from  the select statement
    {
        echo "<script type='text/javascript'>alert('The user email you entered already exist in the system, please check again');</script>";
    }
    else //else is insert the data->if insert the data successful then put in the _session email&access 
    {
        $first_name= $_POST["first_name"];
        $last_name= $_POST["last_name"];
        $student_number= $_POST["student_number"];
        $date_of_birth= $_POST["date_of_birth"];
        $phone_number= $_POST["phone_number"];
        $password= $_POST["password"]; // Set the password for salt,also post the password
        $address_street= $_POST["address_street"];
        $address_city= $_POST["address_city"];
        $state= $_POST["state"];
        $postal_code= $_POST["postal_code"];
        // crypt :ENCRYPTION function to get the hash, letting the salt be automatically generated
        $encr = crypt($password);    
        
        
        $mysqli->query //*note insert the $encr password , not the user input pw//
            ("Insert INTO user_student (UDW_email, first_name, last_name, student_number, date_of_birth, phone_number, password, address_street, address_city, state, postal_code, access_level) VALUES ('$UDW_email', '$first_name', '$last_name', '$student_number', '$date_of_birth', '$phone_number', '$encr', '$address_street', '$address_city', '$state', '$postal_code', 0)"); 
        $count = $mysqli -> affected_rows;
        if($count>0)
        {
            $_SESSION['session_UDW_email']=$UDW_email;
            $_SESSION['session_access_level']=0;//new user is always define as 1 accsess level frist
            $_SESSION['session_user_last_name']=$last_name;
            $result1 = $mysqli->query("SELECT * FROM user_student WHERE UDW_email='$UDW_email'"); 
            $fetch1 = mysqli_fetch_array($result1);
            $_SESSION['session_user_id']=$fetch1['id'];
            header('location:../../home_page/home.php');
        }
        

    }
}
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../../../css/studentRstyle.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js">  </script>
        <style type="text/css">
            /*not show the drop box arrow box*/
            input[type=number]::-webkit-inner-spin-button,
            input[type=number]::-webkit-outer-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }
        </style>
        <title>Registration |Student</title>  
    </head>
    <body>
     <!--top bar with show login logout-->
        <div class="topnav">
            <!-- Left-aligned -->
            <a><img src="../../../asset/logo.png" alt="logo" style="width:40px; height: 30px; "></a>
            <a href="../../home_page/home.php">University of DoWell</a>    
            <!-- Right-aligned links -->
             <div class="topnav-right">
                <a href="../../logout_session.php" class="button6" id="logoutBtn" name="logout" style="display:none;">Log out</a> <!--not display, until user  login-->
                <a href="../../home_page/home.php" id="Login">Log In </a>
                <a href="../../registation_page/main_registation/register.php" id="signup" class="button6">Sign up</a>
                <a href="../../home_page/home.php" class="button6">Home</a>
            </div>
            </div>
       
         <?php                  
        if(isset($_SESSION['session_UDW_email'])){  //if login successful//
            echo "<script type='text/javascript'>document.getElementById('Login').style.display = 'none'</script>"; //hide the login button
            echo "<script type='text/javascript'>document.getElementById('signup').style.display = 'none'</script>"; //hide the signup button
            echo "<script type='text/javascript'>document.getElementById('logoutBtn').style.display = 'block'</script>"; //display logout button
        }?>
                 
        <div class="bg-img">
            <form id="myForm" method="post" class="container" action="student_registation.php">

                <span style="font-size: 20px; font-weight: bold">Student Registration form for Course Management System</span><br><br>

                <span class="required">*</span>UDW Email: <input name="UDW_email" type="email" id="email" placeholder="abc00@udw.edu.au"required><br><br> 

                <span class="required">*</span>First Name: <input name="first_name" type="text" id="firstName" placeholder=" " required><br><br>

                <span class="required">*</span>Last Name: <input  name="last_name"  type="text" id="lastName" placeholder=" " required><br><br> 

                <span class="required">*</span>Student number: <input name="student_number" type="number" id="student_number" placeholder="Only accept numbers"required ><br><br>

                Date of Birth: <input name="date_of_birth" type="date" id="date_of_birth"><br><br>

                <span class="required">*</span>Phone Number: <input name="phone_number" type="text" id="phone_number"  placeholder="Only accept numbers" title="Only accept numbers" required ><br><br>

                <span class="required">*</span>Password: <input name="password"  type ="password" id="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^]).{6,12}$" title="Must contain at least one number and one uppercase and lowercase letter,following special characters!@#$%^ and at least 6 to 12 in length" required><br><br> 

                <span class="required">*</span>Confirm password: <input type ="password" id="confirm_password" placeholder=" " required><span id='message'></span><br><br> 


               Address <input name="address_street"  id="address"  type="text" placeholder="Number/Street" ><br><br>

                Suburb / City <input name="address_city" id="city"  type="text" placeholder="Suburb/City" ><br><br>


                State <input name="state" id="region" type="text" placeholder="TAS">


                Postal Code <input name="postal_code" id="postal_code" type="number" placeholder="Only accept numbers"><br><br>

                <span>Agree the terms and conditions  <input type="checkbox" id="checkbox" required></span><br><br>


                <input type="submit" value="Submit" name="submitBtn"><br><br>
            </form>

        </div>

        <script>
            var password = document.getElementById("password");
            var confirm_password = document.getElementById("confirm_password");


            function validatePassword(){

                if(password.value != confirm_password.value) {
                    confirm_password.setCustomValidity("Passwords Don't Match");
                } else {
                    confirm_password.setCustomValidity('');
                }

            }
            password.onchange = validatePassword;
            confirm_password.onkeyup = validatePassword;


        </script>


         <!--Bootstrap JS-->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    </body>
</html>