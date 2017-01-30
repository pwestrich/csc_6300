<?php

	require "parse_cart.php";
   
?>

<h1 style="text-align: center;">Checkout</h1>
<table id="products_table" border="border" width="640">
<tbody>
<tr><th>Product ID</th><th>Product Name</th><th>Description</th><th>Price</th><th>In Cart</th><th>Total</th></tr>
<?php

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

		echo "<tr>";
		echo "<td>$id</td>";
		echo "<td>$name</td>";
		echo "<td>$description</td>";
		echo "<td>$price</td>";
		echo "<td>$quantity</td>";
		echo "<td>$total</td>";
		echo "</tr>\n";

	} 

?>
</tbody>
</table>
<?php
   echo "Your total is \$$runningTotal. Go back to the previous page to modify your cart.\n";
?>
<button type="button" onclick="completeTransaction()">Complete Transaction</button>
<script id="complete" type="text/javascript">

function addHidden(theForm, key, value){
    // Create a hidden input element, and append it to the form:
    var input = document.createElement('input');
    input.type = "hidden";
    input.name = key;
    input.value = value;
    theForm.appendChild(input);
}

function completeTransaction(){

	var form = document.createElement("form");
	form.setAttribute("method", "post");
	form.setAttribute("action", "/done.php");
<?php //super secret credentials
	echo "addHidden(form, 'user_id', '$username');";
	echo "addHidden(form, 'password', '$password');";
	echo "addHidden(form, 'cart', '$cart_json');";
?>
	document.body.appendChild(form);
   form.submit();

}

</script>

