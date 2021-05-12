<?php
include('../db_conn.php'); //'check if the form have method post


//post the input to db
$unit_code = $_POST['unit_code'];
$unit_name = $_POST['unit_name'];
$semester = $_POST['semester'];
$campus = $_POST['campus'];
$unit_description = $_POST['unit_description'];


//check is it empty before insert
if($unit_code !='' && $unit_name !='' && $semester !='' && $campus !='' && $unit_description !=''){
    
    $sql = "INSERT INTO unit_detail (unit_code, unit_name, semester, campus, unit_description, course_id) VALUES ('$unit_code', '$unit_name', '$semester', '$campus', '$unit_description',1)";
    $results = $mysqli->query($sql);
     header('location:unitmaster.php');

    
}?>

       




