<?php

require_once ("BookDB.php");

?><!DOCTYPE html>
<meta charset="UTF-8" />
<title>Book detail</title>

<?php $book = BookDB::get($_GET["id"]); ?>

<h1>Details about: <?= $book->title ?></h1>
<?php
$id = $book->id;
$author = $book->author;
$title = $book->title;
$price = $book->price;
?>

<h2><?php echo $author ?></h2>
<p>Cena knjige: <?php echo $price ?>€</p>