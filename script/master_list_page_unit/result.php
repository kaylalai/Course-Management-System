<?php
include('../db_conn.php'); 
header('Content-Type: application/json');

$input = filter_input_array(INPUT_POST);//'is a function'input type convert and post store in $input
//clear string from the table 
$unit_code = $input["unit_code_edit"];
$unit_name = $input["unit_name_edit"];
$semester = $input["semester_edit"];
$campus = $input["campus_edit"];
$unit_description = $input["unit_description_edit"];

if ($input['action'] == 'edit') { //action  buildin already have fuction, defined edit function from unitmaster.php
    //update statement
    $mysqli->query("UPDATE unit_detail SET unit_code='" . $input['unit_code_edit'] . "', unit_name='" . $input['unit_name_edit'] . "', semester='" . $input['semester_edit'] . "', campus='" . $input['campus_edit'] . "', unit_description='" . $input['unit_description_edit'] . "' WHERE id='" . $_POST['id'] . "'");
} 


else if($input['action'] == 'delete')
{
    //base on id only
 $query1 = "
 DELETE FROM unit_detail 
 WHERE id = '".$_POST["id"]."'
 ";
 $mysqli->query($query1);
}
//respon data to ajax request
echo json_encode($input);

?>

