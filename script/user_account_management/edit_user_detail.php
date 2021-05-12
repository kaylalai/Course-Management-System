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
        $profile_data1 = mysqli_fetch_array($result_student);
    }
}
else // staff
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



if(isset($_POST["updateBtn"]))
    {
        $mysqli->query("UPDATE user_student SET
    first_name ='" . $_POST['first_name'] . "', 
    last_name ='" . $_POST['last_name'] . "', 
    date_of_birth ='" . $_POST['date_of_birth'] . "', 
    phone_number ='" . $_POST['phone_number'] . "', 
    address_street='" . $_POST['address_street'] . "', 
    address_city='" . $_POST['address_city'] . "', 
    state ='" . $_POST['state'] . "',
    postal_code='" . $_POST['postal_code'] . "'
    WHERE UDW_email='" . $profile_data1['UDW_email'] . "'");
        header('location: manage_account.php');
    }
    if(isset($_POST["updateBtn2"]))
    {
        $mysqli->query("UPDATE user_staff SET
    first_name ='" . $_POST['first_name'] . "', 
    last_name ='" . $_POST['last_name'] . "', 
    phone_number ='" . $_POST['phone_number'] . "', 
    address_street='" . $_POST['address_street'] . "', 
    address_city='" . $_POST['address_city'] . "', 
    state ='" . $_POST['state'] . "',
    postal_code='" . $_POST['postal_code'] . "',
    qualifaction ='" . $_POST['qualifaction'] . "',
    expertise_area='" . $_POST['expertise_area'] . "',
    unavailable='". $_POST['unavailable'] . "'
    WHERE UDW_email='" . $profile_data['UDW_email'] . "'");
    header('location: manage_account.php');
    }


 ?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Edit account detail| University of DoWell </title>
        <!-- Bootstrap CSS file -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="../../css/studentRstyle.css">
    </head>
    <body>
<!--top bar with show login logout-->
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
<!--top bar end-->
<!--SESSION store the access leve ready , check if is 0(student), then take the id and fetch the related user detail in input box -->
        <!-- use post method to update data querry excute in each if else statement-->
<?php if($_SESSION['session_access_level']==0) { ?>
<a href="manage_account.php">Back to <?php echo $profile_data1['first_name'] ?>'s Profile</a>
        
        <form method="post" class="container" action="edit_user_detail.php" onSubmit="document.getElementById('update').disabled=true;">
    <h4>Update Profile Information</h4>
    <span class="required">*</span>UDW Email: <input disabled name="UDW_email" value="<?php echo $profile_data1['UDW_email'] ?>" type="email" id="email" placeholder="abc00@udw.edu.au"required><br><br> 

    <span class="required">*</span>First Name: <input name="first_name" value="<?php echo $profile_data1['first_name'] ?>" type="text" id="firstName" placeholder=" " required><br><br>

    <span class="required">*</span>Last Name: <input  name="last_name" value="<?php echo $profile_data1['last_name'] ?>" type="text" id="lastName" placeholder=" " required><br><br> 

    <span class="required">*</span>Student ID: <input  disabled name="student_number" value="<?php echo $profile_data1['student_number'] ?>" type="number" id="student_number" placeholder="Only accept numbers"required ><br><br>

    Date of Birth: <input name="date_of_birth" value="<?php echo $profile_data1['date_of_birth'] ?>" type="date" id="date_of_birth"><br><br>

    <span class="required">*</span>Mobile: <input name="phone_number" value="<?php echo $profile_data1['phone_number'] ?>" type="text" id="phone_number"  placeholder="Only accept numbers" title="Only accept numbers" required ><br><br>


    Address <input name="address_street" value="<?php echo $profile_data1['address_street'] ?>" id="address"  type="text" placeholder="Number/Street" ><br><br>

    Suburb / City <input name="address_city" value="<?php echo $profile_data1['address_city'] ?>" id="city"  type="text" placeholder="Suburb/City" ><br><br>


    State <input name="state" value="<?php echo $profile_data1['state'] ?>" id="region" type="text" placeholder="TAS">


    Postal Code <input name="postal_code" value="<?php echo $profile_data1['postal_code'] ?>" id="postal_code" type="number" placeholder="Only accept numbers"><br><br>

    <input type="submit" id="submit" value="Update" name="updateBtn"><br><br>
</form> 


<!--else is mean user not in access level 0, then will be a staff , so go to staff table to-->
<?php } else { ?> 
<a href="manage_account.php">Back to <?php echo $profile_data['first_name'] ?>'s Profile</a>
<form method="post" class="container" action="edit_user_detail.php" onSubmit="document.getElementById('update').disabled=true;">
<h3>Update Profile Information</h3>

    <span class="required">*</span>UDW Email: <input disabled name="UDW_email" value="<?php echo $profile_data['UDW_email'] ?>" type="email" id="email" placeholder="abc00@udw.edu.au"required><br><br> 

    <span class="required">*</span>First Name: <input name="first_name" value="<?php echo $profile_data['first_name'] ?>" type="text" id="firstName" placeholder=" " required><br><br>

    <span class="required">*</span>Last Name: <input  name="last_name" value="<?php echo $profile_data['last_name'] ?>" type="text" id="lastName" placeholder=" " required><br><br> 

    <span class="required">*</span>Phone Number: <input name="phone_number" value="<?php echo $profile_data['phone_number'] ?>" type="number" id="phone"   placeholder="Only accept numbers" title="Only accept numbers" required ><br><br>

    Unavailable day:<input name="unavailable" value="<?php echo $profile_data['unavailable'] ?>" type="text" id="unavailable" placeholder=" "> <br><br>      
    Select your qualification
    <select name="qualifaction" id="qualifaction">         
        <option value="<?php echo $profile_data['qualifaction'] ?>"><?php echo $profile_data['qualifaction'] ?></option>
        <option value="Higher_Certificate">Higher Certificate</option>
        <option value="National_Diploma">National Diploma</option>
        <option value="Associate_Degrees">Associate Degrees</option>
        <option value="Bachelor's_Degrees">Bachelor's Degrees</option>
        <option value="Honours_Degrees">Honours Degrees</option>
        <option value="Master's_Degrees">Master's Degrees</option>
        <option value="Doctoral_Degree">Doctoral Degree</option>
    </select>    <br><br>    
    Select your Expertise area 
    <select name="expertise_area" id="expertise">
    <option value="<?php echo $profile_data['expertise_area'] ?>"><?php echo $profile_data['expertise_area'] ?></option>
    <option value="Information_Systems">Information Systems</option>
    <option value="Human_Computer_Interaction">Human Computer Interaction</option>
    <option value="Network_Administration">Network Administration</option>
    <option value="Information_Systems">Information Systems</option>
    <option value="Network_Administration">Network Administration</option>
    </select><br><br> 
  
    Address <input name="address_street" value="<?php echo $profile_data['address_street'] ?>" id="address"  type="text" placeholder="Number/Street" ><br><br>

    Suburb / City <input name="address_city" value="<?php echo $profile_data['address_city'] ?>" id="city"  type="text" placeholder="Suburb/City" ><br><br>

    State <input name="state" value="<?php echo $profile_data['state'] ?>" id="region" type="text" placeholder="State">

    Postal Code <input name="postal_code" value="<?php echo $profile_data['postal_code'] ?>" id="Postal-code" type="number" placeholder="Only accept numbers"><br><br>
    <input type="submit" id="submit" value="Update" name="updateBtn2"><br><br>
</form> 


<?php } ?>
        

</body>
        </html>        



