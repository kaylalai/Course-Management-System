<!--back end event-- swap the current uc to become a uc in that unit-->
<?php
session_start(); 
include('../db_conn.php'); 

//get this two id from the 'select' button//
$staff_id=$_GET['staff_id'];
$unit_id=$_GET['unitid'];

//take the current uc and delete it// 
$query_current_uc="SELECT unit_detail.unit_coordinator
as current_staff_id, unit_detail.id as unit_id FROM `unit_detail`
join user_staff on user_staff.id = unit_detail.unit_coordinator 
where unit_detail.id = $unitid";
$result_current_uc = $mysqli->query($query_current_uc);
while($row = mysqli_fetch_array($result_current_uc))
{
    $current_staff_id = $row['current_staff_id'];
    $query_delete=" Delete from staff_has_role where id_staff_fk= $current_staff_id and id_role_fk = 4";
}


//udate the unit_detail table .unit_coordinator coloum as a new staff
$query_add="update unit_detail set unit_coordinator='$staff_id' where unit_detail.id='$unit_id'";
$result_staff_uc_add = $mysqli->query($query_add);
$rc = $mysqli->affected_rows;

//insert the other table staff role , not use update as one staff may have many role//
$query_insert="INSERT INTO staff_has_role (id_staff_fk, id_role_fk, correlate_unit_id_fk) values ($staff_id, 4, $unit_id )";
$result_insert = $mysqli->query($query_insert);
$rc2 = $mysqli->affected_rows; //store affected rows


//if insert successfull then alert Successfully updated//
if($rc2>0)  
{  
    echo '<script>
   alert("Successfully updated Unit Coordinator");</script>';
    echo '<script>window.location="master_list_staff.php";</script>';

}  
else  
{  
    echo '<script>alert("Fail updated Unit Coordinator, please try again!")</script>';
    echo '<script>window.location="master_list_staff.php";</script>';
}  


?>