
<?php

	$db = mysqli_connect("localhost", "web_user", "web_user", "mydb");

	if (mysqli_connect_error()){

		die("Could not connect to database: " . mysqli_connect_error());

	}

?>

