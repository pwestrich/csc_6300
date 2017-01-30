
<?php

   require "parse_cart.php";
   
   //build string to send in email body
   $emailBody = "You've completed the following transaction.\r\n";
   $emailBody .= "Item\tName\tDescription\tUnit Price\tQuantity\tTotal\r\n";
   
   $runningTotal = 0;

	while ($row = $products->fetch_assoc()){
		
		$id = $row["product_id"];
		$name = $row["name"];
		$description = $row["description"];
		$price = $row["price"];
		$quantity = $cart[$id];
		
		if ($quantity == null){
		
		   $quantity = 0;
		
		}
		
		$total = $price * $quantity;
		$runningTotal += $total;
		
		$emailBody .= "$id\t$name\t$description\t$price\t$quantity\t$total\r\n";

	}
	
	$emailBody .= "A total of \$$runningTotal will be billed to your account.\r\n";
	
	$result = mail($user["email"], "Your Order from CSC 6300", $emailBody);
	
	if ($result == true){
	
	   echo "Success. Check your email for conformation.\n";
	   
	   $queryString = "UPDATE users SET current_cart=null WHERE username='$username';";
	   $cartSaveResult = mysqli_query($db, $queryString);
	   
		if ($cartSaveResult == false){
	   
	      error_log("cart save failed: " . mysqli_error($db));
	   
	   }
	   
	} else {
	
	   echo "Could not complete transaction. Please try again later.\n";
	
	}

?>

<a title="Log in" href="/index.html">Log in.</a>

