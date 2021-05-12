<?php
session_start(); 
include('../db_conn.php'); 


$staff_id=$_GET['staff_id'];
$tutorial_code=$_GET['tutorial_id'];
$unit_id=$_GET['unit_id'];

echo $staff_id;
echo $tutorial_code;
echo $unit_id;


$query_up="update tutorial set tutor_staff_id_fk = $staff_id
where tutorial_code ='$tutorial_code'";
$result_update= $mysqli->query($query_up);


$query_insert="INSERT INTO staff_has_role (id_staff_fk, id_role_fk ,correlate_unit_id_fk) values ($staff_id, 2, $unit_id)";
$result_up2 = $mysqli->query($query_insert);


header ('location:allocate_tutor.php');



?>

