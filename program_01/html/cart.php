<?php

	require "parse_cart.php";
   
?>

<h1 style="text-align: center;">Cart</h1>
<table id="products_table" width="640" border="border">
<tbody>
<tr>
<th>Product ID</th><th>Product Name</th><th>Description</th><th>Price</th><th>In Cart</th><th>To Add</th>
</tr>
<?php

	while ($row = $products->fetch_assoc()){
		
		$id = $row["product_id"];
		$name = $row["name"];
		$description = $row["description"];
		$price = $row["price"];
		$quantity = $cart[$id];
		
		if ($quantity == null){
		
		   $quantity = 0;
		
		}

		echo "<tr>";
		echo "<td>$id</td>";
		echo "<td>$name</td>";
		echo "<td>$description</td>";
		echo "<td>$price</td>";
		echo "<td>$quantity</td>";
		echo "<td><input id='$id' type='text' class='textBox' value='0'/></td>"; //rows need ids because javascript is dumb
		echo "</tr>\n";

	} 

?>
</tbody>
</table>
<button type="button" onclick="checkout()">Checkout</button>
<button type="button" onclick="addToCart()">Add</button>
<script id="checkout" type="text/javascript">

function addHidden(theForm, key, value){
    // Create a hidden input element, and append it to the form:
    var input = document.createElement('input');
    input.type = "hidden";
    input.name = key;
    input.value = value;
    theForm.appendChild(input);
}

function sendCart(cart, page){

	var form = document.createElement("form");
	form.setAttribute("method", "post");
	form.setAttribute("action", page);
<?php //super secret credentials
	echo "addHidden(form, 'user_id', '$username');";
	echo "addHidden(form, 'password', '$password');";
?>
	addHidden(form, "cart", cart);
	document.body.appendChild(form);
	
   form.submit();

}
	
function checkout(){
<?php
	echo "sendCart('$cart_json', '/checkout.php')";
?>
}

function addToCart(){

	//get the table
	var tableRows = document.getElementById("products_table").rows;
	var cart = {};

	//pick out the quantity box from each row, excluding the header
	for (var i = 1; i < tableRows.length; i++){
		
		var row = tableRows[i];
		var cells = row.cells;
		
		var productID = cells[0].innerHTML;
		var quantity = cells[4].innerHTML;
      var toAdd = document.getElementById(productID).value; //javascript is dumb
      
      quantity = parseInt(quantity) + parseInt(toAdd);
      if (quantity < 0){
      
         quantity = 0;
      
      }
      		
		cart[productID] = quantity;

	}
	
	sendCart(JSON.stringify(cart), "/cart.php");

}

</script>
