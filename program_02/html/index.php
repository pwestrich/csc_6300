
<?php



?>

<h1>Abstract Search</h1>
<form id="searchForm" action="/index.php" method="post">
  <table style="width:500px">
    <tr>
      <td><input type="checkbox">Search by Author</input></td>
      <td><p align="right">Author's Name:</p></td>
      <td><input type="text" name="authorName"/></td>
    </tr>
    <tr>
      <td><input type="checkbox">Search by Title</input></td>
      <td><p align="right">Title contains:</p></td> 
      <td><input type="text" name="titleContent"/></td>
    </tr>
    <tr>
      <td><input type="checkbox">Search by Type</input></td>
      <td><p align="right">Type:</p></td> 
      <td><input type="text" name="paperType"/></td>
    </tr>
    <tr>
      <td><input type="checkbox">Search by Abstract</input></td>
      <td><p align="right">Abstract contains:</p></td> 
      <td><input type="text" name="apstractContent"/></td>
    </tr>
  </table>
	<p align="center"><input type="submit" value="Submit"></p>
</form>

<h2>Results</h2>
<textarea name="message" rows="10" cols="65">
</textarea>
