<?php
session_start(); //checks if a session is already started and if none is started then it starts one

$connect = new PDO('mysql:host=localhost;dbname=kylai0', 'kylai0', '143272');

$data = array();

$query = "SELECT * FROM tutorial ORDER BY id";

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
