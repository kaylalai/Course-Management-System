<!--back end event:swap the current lecturer to become a lecturere in that unit-->

<?php
session_start(); 
include('../db_conn.php'); 
$staff_id=$_GET['staff_id'];
$unit_id=$_GET['unitid'];

//SELECT THE CERRENT LECTURE USER ID//
$query_current_lecturer="SELECT *, unit_detail.id as unit_id, user_staff.id as staff_id FROM `unit_detail` left join user_staff on user_staff.id = unit_detail.lecturer where unit_detail.id = $unitid";
$result_current_lecturer = $mysqli->query($query_current_lecturer);

//By using that $result_current_lecturer to delecte the exist lecture in this unit//
while($row = mysqli_fetch_array($result_current_lecturer))
    {
        $current_staff_id = $row['current_staff_id'];
        $query_delete="delete from staff_has_role where id_staff_fk=$current_staff_id and id_role_fk = 3 and correlate_unit_id_fk=$unit_id";
    }


//Update the new staff as a unit lecture in two table 1. unit_enrolment table 2.Staff has role table//
$query_up="update unit_detail set lecturer = $staff_id where id =$unit_id";
$result_up = $mysqli->query($query_up);

//insert the other table staff role , not use update as one staff may have many role//
$query_insert="INSERT INTO staff_has_role (id_staff_fk, id_role_fk, correlate_unit_id_fk) values ($staff_id, 3, $unit_id )";
$result_insert = $mysqli->query($query_insert);
$rc2 = $mysqli->affected_rows; //store affected rows



if($rc2>0)
{
    echo '<script>
   alert("Successfully updated lecturer");</script>';
    echo '<script>window.location="master_list_staff.php";</script>';

}  
else  
{  
    echo '<script>alert("Fail updated lecturer, please try again!")</script>';
    echo '<script>window.location="master_list_staff.php";</script>';
}  


?>

