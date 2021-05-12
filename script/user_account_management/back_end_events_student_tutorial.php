<?php
session_start(); //checks if a session is already started and if none is started then it starts one

$email = $_SESSION['session_UDW_email'];

$connect = new PDO('mysql:host=localhost;dbname=kylai0', 'kylai0', '143272');



$data = array();


$query = "SELECT tutorial.id, tutorial.tutorial_code, tutorial.dow, tutorial.tutorial_time_start_at, tutorial.tutorial_time_end_at FROM user_student
left join tutorial_enrolment on tutorial_enrolment.id_stud_fk = user_student.id
left join tutorial on tutorial_enrolment.id_tut_fk = tutorial.id
WHERE user_student.UDW_email='$email'";


$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

foreach($result as $row)
{
    $data[] = array(
        'id'   => $row["id"],
        'title'   => $row["tutorial_code"],
        'dow'   => $row["dow"],
        'start'   => $row["tutorial_time_start_at"],
        'end'   => $row["tutorial_time_end_at"]

    );
}

echo json_encode($data);

?>
