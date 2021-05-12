<!--this page for delete staff in acadmic staff list (tutor)-->

<?php
session_start(); 
include('../db_conn.php'); 

$staff_id=$_GET['staff_id'];
$unit_id=$_GET['unitid'];



$query_delete="delete from staff_has_role where id_staff_fk=$staff_id and id_role_fk = 2 and correlate_unit_id_fk=$unit_id";


if($result_up2 = $mysqli->query($query_delete))  
{  
    echo '<script>
   alert("Successfully delete staff in the academic staff list!");</script>';
    echo '<script>window.location="master_list_staff.php";</script>';

}  
else  
{  
    echo '<script>alert("Fail to delete staff in the academic staff list, please try again!")</script>';
    echo '<script>window.location="master_list_staff.php";</script>';
}  


?>

