<?php
//connect to mysql
$mysqli = new mysqli('localhost', 'kylai0', '143272', 'kylai0'); 

if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}
?>