<!--Add staff (tutor) in the acadmic staff list as prepare to assign in one of the tutorial-->
<?php
session_start(); 
include('../db_conn.php'); 

$staff_id=$_GET['staff_id'];
$unit_id=$_GET['unitid'];


$query_insert="INSERT INTO staff_has_role 
(id_staff_fk, id_role_fk ,correlate_unit_id_fk) values ($staff_id, 2, $unit_id)";

if($result_up2 = $mysqli->query($query_insert))  
{  
    echo '<script>
   alert("Successfully add staff in the academic staff list!");</script>';
    echo '<script>window.location="master_list_staff.php";</script>';

}  
else  
{  
    echo '<script>alert("Fail to add staff in the academic staff list, please try again!")</script>';
    echo '<script>window.location="master_list_staff.php";</script>';
}  


?>

