<?php
session_start(); //checks if a session is already started and if none is started then it starts one

$email = $_SESSION['session_UDW_email'];

$connect = new PDO('mysql:host=localhost;dbname=kylai0', 'kylai0', '143272');



$data = array();

$query = "SELECT lecture.id, lecture.lecture_code, lecture.dow, lecture.lecture_time_start_at, lecture.lecture_time_end_at FROM user_student
left JOIN unit_enrolment on unit_enrolment.student_id = user_student.id
left JOIN unit_detail on unit_detail.id = unit_enrolment.enrol_unit_id
left join lecture on lecture.lecture_unit_id = unit_detail.id
WHERE user_student.UDW_email='$email'";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

foreach($result as $row)
{
    $data[] = array(
        'id'   => $row["id"],
        'title'   => $row["lecture_code"],
        'dow'   => $row["dow"],
        'start'   => $row["lecture_time_start_at"],
        'end'   => $row["lecture_time_end_at"]
        
        

    );
}

echo json_encode($data);

?>


