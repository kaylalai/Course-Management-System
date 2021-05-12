<?php
session_start(); //checks if a session is already started and if none is started then it starts one
include('../../db_conn.php'); //db connection

if(isset($_POST["submitBtn"])){ //get the vale from post method,username is the name of the from 
    $UDW_email= $_POST["UDW_email"]; 
    
    $result = $mysqli->query("select * from user_staff 
JOIN staff_has_role on user_staff.id=staff_has_role.id_staff_fk JOIN staff_role on staff_has_role.id_role_fk= staff_role.id WHERE UDW_email='$UDW_email'");//fetch the outcome to $result 
    $row=$result->num_rows; // store the value as whole row
    if ($row==1) //if have any username is exist,$row from  the select statement
    {
        echo "<script type='text/javascript'>alert('The user email you entered already exist in the system, please check again');</script>";
    }
    else //else is insert the data->if insert the data successful then put in the _session email&access 
    {
        $first_name= $_POST["first_name"];
        $last_name= $_POST["last_name"];
        $staff_number= $_POST["staff_number"];
        $phone_number= $_POST["phone_number"];
        $password= $_POST["password"];// Set the password for salt,also post the password
        $qualifaction= $_POST["qualifaction"];
        $expertise_area= $_POST["expertise_area"];
        $address_street= $_POST["address_street"];
        $address_city= $_POST["address_city"];
        $state= $_POST["state"];
        $postal_code= $_POST["postal_code"];
        // crypt :function to get the hash, letting the salt be automatically generated
        $encr = crypt($password);    
  
        $mysqli->query
            ("Insert INTO user_staff (UDW_email, first_name, last_name, staff_number, phone_number, password, qualifaction, expertise_area, address_street, address_city, state, postal_code) VALUES ('$UDW_email', '$first_name', '$last_name', '$staff_number', '$phone_number', '$encr', '$qualifaction', '$expertise_area', '$address_street', '$address_city', '$state', '$postal_code')"); 
        
        
        $count = $mysqli -> affected_rows;
        if($count>0)
        {
            $inserted_staffID = $mysqli->insert_id;
        $mysqli->query("Insert INTO staff_has_role (id_role_fk, id_staff_fk,correlate_unit_id_fk) VALUES ('1','$inserted_staffID','')");
            $_SESSION['session_UDW_email']=$UDW_email;
            $_SESSION['session_user_last_name']=$last_name;
            $_SESSION['session_access_level']=1;//new user is always define as 1 accsess level frist
            $result1 = $mysqli->query("SELECT * FROM user_staff WHERE UDW_email='$UDW_email'"); 
            $fetch1 = mysqli_fetch_array($result1);
            $_SESSION['session_user_id']=$fetch1['id'];
            header('location:../../home_page/home.php');
        }
        else
        {
            echo "Something went wrong please try again!";
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
        <link rel="stylesheet" type="text/css" href="../../../css/staffRstyle.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js">  </script> 
<!-- display none for the input drop box-->
        <style type="text/css">
            input[type=number]::-webkit-inner-spin-button,
            input[type=number]::-webkit-outer-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }
        </style>
        <title>Registration |Staff</title>  
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
            
            <form id="myForm" method="post" class="container" action="staff_registation.php">
                <span style="font-size: 20px; font-weight: bold">Staff Registration form Course Management System</span><br><br>
               
                <span class="required">*</span>UDW Email: <input name="UDW_email" type="email" id="email" placeholder="abc00@udw.edu.au"required><br><br> 

                <span class="required">*</span>First Name: <input name="first_name" type="text" id="firstName" placeholder=" " required><br><br>

                <span class="required">*</span>Last Name: <input  name="last_name"  type="text" id="lastName" placeholder=" " required><br><br> 

                <span class="required">*</span>Staff ID: <input name="staff_number" type="number" id="staffID" placeholder="Only accept numbers"required ><br><br>

                <span class="required">*</span>Phone Number: <input name="phone_number" type="number" id="phone" id="phoneNumber"  placeholder="Only accept numbers" title="Only accept numbers" required ><br><br>

                <span class="required">*</span>Password: <input name="password"  type ="password" id="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^]).{6,12}$" title="Must contain at least one number and one uppercase and lowercase letter,following special characters!@#$%^ and at least 6 to 12 in length" required><br><br> 
                

                <span class="required">*</span>Confirm password: <input type ="password" id="confirm_password" placeholder=" " required><span id='message'></span><br><br> 

                <span class="required">*</span>Qualifaction <select name="qualifaction" id="qualifaction">         
                <option value="">Select Qualifaction</option>
                <option value="Higher_Certificate">Higher Certificate</option>
                <option value="National_Diploma">National Diploma</option>
                <option value="Associate_Degrees">Associate Degrees</option>
                <option value="Bachelor's_Degrees">Bachelor's Degrees</option>
                <option value="Honours_Degrees">Honours Degrees</option>
                <option value="Master's_Degrees">Master's Degrees</option>
                <option value="Doctoral_Degree">Doctoral Degree</option>
                </select><br><br>

                <span class="required">*</span> Expertise area <select name="expertise_area" id="expertise">
                <option value="">Select an Expertise area</option>
                <option value="Information_Systems">Information Systems</option>
                <option value="Human_Computer_Interaction">Human Computer Interaction</option>
                <option value="Network_Administration">Network Administration</option>
                <option value="Information_Systems">Information Systems</option>
                <option value="Network_Administration">Project Management</option>
                <option value="Other">Other</option>

                </select><br><br>
                Address <input name="address_street"  id="address"  type="text" placeholder="Number/Street" ><br><br>

                Suburb / City <input name="address_city" id="city"  type="text" placeholder="Suburb/City"><br><br>


                State <input name="state" id="region" type="text" placeholder="State">


                Postal Code <input name="postal_code" id="Postal-code" type="number" placeholder="Only accept numbers"><br><br>

                <span>Agree the terms and conditions  <input type="checkbox" id="checkbox" required></span><br><br>

                <input type="submit" value="Submit" name="submitBtn"><br><br>
            </form>
        </div>

        <script type="text/javascript">
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



            $( document ).ready(function() {
                $("#qualifaction").select( {
                    placeholder: "Select Qualifaction",
                    allowClear: true
                } );
            });

            $("#expertise").select( {
                placeholder: "Select expertise",
                allowClear: true
            } );
        </script>

        <!--Bootstrap JS-->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


    </body>
</html>