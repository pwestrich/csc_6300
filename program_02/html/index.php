
<?php

	require "basex.php";
	require "exist.php";
	
	//exist paper types
	global $EXIST_PAPER_TYPES;
	
	//paper types for the basex database, will need to be fetched
	$BASEX_PAPER_TYPES = basex_get_paper_types();
	
	$author   = $_POST["authorName"];
	$title    = $_POST["titleContent"];
	$type     = $_POST["paperType"];
	$abstract = $_POST["abstractContent"];

	$basex_results = basex_build_query_from_request($author, $title, $type, $abstract);
	$exist_results = exist_build_query_from_request($author, $title, $type, $abstract);

?>

<h1>Abstract Search</h1>
<form id="searchForm" action="/index.php" method="post">
  <table style="width:500px">
    <tr>
      <td><p align="right">Author's Name:</p></td>
      <td><input type="text" name="authorName"value="<?php echo $author ?>"/></td>
    </tr>
    <tr>
      <td><p align="right">Title contains:</p></td> 
      <td><input type="text" name="titleContent" value="<?php echo $title ?>"/></td>
    </tr>
    <tr>
      <td><p align="right">Type:</p></td> 
      <td>
        <select name="paperType">

<?php
	
	echo "<option value=''>Any</option>";
	echo $BASEX_PAPER_TYPES;

	foreach ($EXIST_PAPER_TYPES as $id => $value){

		echo "<option value='$value'>$value</option>";

        }

?>
        </select>
      </td>
    </tr>
    <tr>
      <td><p align="right">Abstract contains:</p></td> 
      <td><input type="text" name="abstractContent"/><?php echo $abstract ?></td>
    </tr>
  </table>
  <input type="submit" value="Submit">
</form>

<h2>Results</h2>
<textarea name="message" rows="10" cols="65">
<?php  
	
//	basex_print_results($basex_results);
	exist_print_results($exist_results);

?>
</textarea>

