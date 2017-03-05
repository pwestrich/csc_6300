
<?php

	require "basex.php";
	
	var_dump($_POST);

	//paper types for the exist database
	$EXIST_PAPER_TYPES = array(
		"0"  => "Journal Article",
		"1"  => "Book",
		"3"  => "Conference Proceedings",
		"5"  => "Collection",
		"10" => "Tech Report",
		"15" => "Unpublished",
		"16" => "Miscellaneous",
		"47" => "Conference Proceedings");
	
	//paper types for the basex database, will need to be fetched
	$BASEX_PAPER_TYPES = basex_get_paper_types();
	
	$author   = $_POST["authorName"];
	$title    = $_POST["titleContent"];
	$type     = $_POST["paperType"];
	$abstract = $_POST["abstractContent"];

	$basex_results = basex_build_query_from_request($author, $title, $type, $abstract);


?>

<h1>Abstract Search</h1>
<form id="searchForm" action="/index.php" method="post">
  <table style="width:500px">
    <tr>
      <td><input type="checkbox">Search by Author</input></td>
      <td><p align="right">Author's Name:</p></td>
      <td><input type="text" name="authorName"/><?php echo $author ?></td>
    </tr>
    <tr>
      <td><input type="checkbox">Search by Title</input></td>
      <td><p align="right">Title contains:</p></td> 
      <td><input type="text" name="titleContent"/><?php echo $title ?></td>
    </tr>
    <tr>
      <td><input type="checkbox">Search by Type</input></td>
      <td><p align="right">Type:</p></td> 
      <td>
        <select name="paperType">

<?php
	/*foreach ($EXIST_PAPER_TYPES as $key => $value){

		echo "<option value='$key'>$value</option>";

	}*/

	foreach ($BASEX_PAPER_TYPES as $key => $value){

		echo $value;

	}

?>
        </select>
      </td>
    </tr>
    <tr>
      <td><input type="checkbox">Search by Abstract</input></td>
      <td><p align="right">Abstract contains:</p></td> 
      <td><input type="text" name="abstractContent"/><?php echo $abstract ?></td>
    </tr>
  </table>
  <input type="submit" value="Submit">
</form>

<h2>Results</h2>
<textarea name="message" rows="10" cols="65">
<?php echo $basex_results ?>
</textarea>

