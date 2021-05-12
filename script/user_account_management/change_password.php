
<?php
session_start(); //checks if a session is already started and if none is started then it starts one
include('../db_conn.php'); //db connection
$UDW_email = $_SESSION['session_UDW_email'];

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Change password| University of DoWell </title>
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
        <br><br>
 <!--top bar end-->       
        <div style="text-align: center">
            <form method="post" class="container" id="myForm"  action="change_password.php"> 
                <!--this from not include ahref="?" here , is duplicat to the header and will break the page-->
                <!--onsubmit= must include syntax return in the button name-->
                <tr>
                    <td>
                        <span style="font-size: 20px; font-weight: bold">Current password</span><br><br>
                        Current password:&nbsp;<input name="oldpassword" placeholder="Current password" type="password" id="oldpassword"><br><br>

                        New Password:&nbsp;<input name="newpassword"  type ="password" placeholder="New Password" id="newpassword" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^]).{6,12}$" title="Must contain at least one number and one uppercase and lowercase letter,following special characters!@#$%^ and at least 6 to 12 in length" required><br><br>
 
                        Confirm password:&nbsp; <input type ="password" id="confirm_password" placeholder="Confirm Password" ><br><br> 

                        <button type="submit" class="pure-button pure-button-primary" onclick="return validatePassword();">Update</button>
                        <input type="reset" value="Reset">
                    </td>
                </tr>
            </form>
        </div>

            <?php
         if ($_SERVER['REQUEST_METHOD'] == 'POST')
           { 
                
                $oldpassword = $_POST['oldpassword'];
                $newpassword = $_POST['newpassword'];
                
                $check_tblStudent = $mysqli->query("SELECT * FROM user_student WHERE UDW_email='$UDW_email'");
                $check_tblStaff = $mysqli->query("SELECT * FROM user_staff WHERE UDW_email='$UDW_email'");

                $fetch1 = mysqli_fetch_array($check_tblStudent);
                $fetch2=mysqli_fetch_array($check_tblStaff);

                $hash_student=$fetch1['password'];  
                $hash_staff=$fetch2['password'];  


                if(password_verify($oldpassword,$hash_student)) 

                {
                    $encr = crypt($newpassword);
                    $mysqli->query("UPDATE user_student SET password ='$encr' WHERE UDW_email='$UDW_email'");
                    
                    header('location: manage_account.php');
                }

                    else if(password_verify($oldpassword,$hash_staff)) //verify the database password and input password

                    {
                        $encr = crypt($newpassword);
                        $mysqli->query("UPDATE user_staff SET password ='$encr' WHERE UDW_email='$UDW_email'");
                         
                        header('location: manage_account.php');

                        }

                    }

                ?>
</body>


                    <script type="text/javascript">


                    function validatePassword(){
                    var password = document.getElementById("newpassword");
                    var confirm_password = document.getElementById("confirm_password");


                    if(password.value != confirm_password.value)
                    {
                        alert ("New Password don't match with confirm password or cannot be empty!");
                        return false;
                        
                    } 
                }
                </script>

                    </html>