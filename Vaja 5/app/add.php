<?php 
/* TODO

1. Import the UserDB.php file.
2. Read the data from the HTTP POST request by using the $_POST global field:
   e. g. $_POST["variable_name]
3. Call the save_to_db() function to save the user to the DB.

*/
require_once("UserDB.php");
$firstname = $_POST["first"];
$lastname = $_POST["last"];
UserDB::save_to_db($firstname, $lastname);

?>

<!DOCTYPE html>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="style.css" />

<title>Web technologies</title>

<header>Web technologies</header>

<div id="content1">
	<p>A new student has been added. <a href="index.php">Add another one.</a></p>
</div>

<footer>Web technologies @ FRI</footer>