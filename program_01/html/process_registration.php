
<?php
	require "database.php";

	//check to make sure variables are set
	if (!(isset($_POST["first_name"]) && isset($_POST["last_name"]) && isset($_POST["user_id"]) && isset($_POST["password"])
	    && isset($_POST["password_2"]) && isset($_POST["email"]))){

		echo "<<h1><strong>Error</strong></h1>";
		echo "Something went wrong. Please navigate back to the Registration page and try again.";
		echo '<a title="Register" href="/register.html">Register as a new user...</a>';
		die();

	}

	//get values of fields
	$firstName = $_POST["first_name"];
	$lastName = $_POST["last_name"];
	$username = $_POST["user_id"];
	$password = $_POST["password"];
	$password2 = $_POST["password_2"];
	$email = $_POST["email"];

	//make sure passswords match
	if ($password != $password2){

		echo "<<h1><strong>Error</strong></h1>";
		echo "Passwords do not match. Please navigate back to the Registration page and try again.";
		echo '<a title="Register" href="/register.html">Register as a new user...</a>';
 		die();

	}
	
	$queryString = "INSERT INTO users VALUES ('$username','$password','$email','$lastName','$firstName',null);";

	//write new user to database; mysql should keep us from entering duplicate usernames/blank fields
	$createResult = mysqli_query($db, $queryString);

	if ($createResult != false){

		//success
		echo "<<h1><strong>Success</strong></h1>";
		echo "User created. Please log in.";
		echo '<a title="Login" href="/index.html">Login</a>';

	} else {

		echo "<<h1><strong>Error</strong></h1>";
		echo "Could not create account. Please navigate back to the Registration page and try again.";
		echo '<a title="Register" href="/register.html">Register as a new user...</a>';

	}

?>

