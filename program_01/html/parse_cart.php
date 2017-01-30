<?php

	require "database.php";
	
	if (!isset($_POST["user_id"]) || !isset($_POST["password"])){

		echo "<<h1><strong>Error</strong></h1>";
		echo "Please ";
		echo '<a title="log in" href="/index.html">log in.</a>';
		die();

	}
	
	//attempt to authenticate (super insecure way)
	$username = $_POST["user_id"];
	$password = $_POST["password"];

	$userResult = mysqli_query($db, "SELECT * FROM users WHERE username = '$username' AND password = '$password';");
	
	if ($userResult->num_rows != 1){

		echo "<<h1><strong>Error</strong></h1>";
		echo "Credentials incorrect. Please ";
		echo '<a title="log in" href="/index.html">log in.</a>';
		die();

	}

	$user = $userResult->fetch_assoc();
	
	//user is authenticated, use posted cart if there is one, or the cart in the database elsewise
	$cart = null;
	$cart_json = null;
	
	if (isset($_POST["cart"]) && $cart = json_decode($_POST["cart"], true)){
	   
	   //save cart
	   $cart_json = $_POST["cart"];
	   $queryString = "UPDATE users SET current_cart='$cart_json' WHERE username='$username';";
	   $cartSaveResult = mysqli_query($db, $queryString);
	   
	   if ($cartSaveResult == false){
	   
	      error_log("cart save failed: " . mysqli_error($db));
	   
	   }
	
	} else {
	   
	   //use already saved cart
	   $cart_json = $user["current_cart"];
	   $cart = json_decode($cart_json, true);

   }
   
   //fetch products
   $products = mysqli_query($db, "SELECT * FROM products;");
   
?>

