<?php

require_once ("BookDB.php");

?><!DOCTYPE html>

<meta charset="UTF-8" />
<title>Library</title>

<h1>A book library written in PHP</h1>

<p>Check our collection of fine books. <a href="search-books.php">Search for books.</a></p>

<ul>
    <?php foreach (BookDB::getAllBooks() as $book): 
    $id = $book->id; 
    $author = $book->author;
    $title = $book->title;
    $price = $book->price;
    $besedilo = "Avtor: $author. Naslov: $title. Cena knjige: $price";
    ?>
    <li><a href="book-detail.php?id=<?php echo $id; ?>" id=$id><?php echo $besedilo ?></a></li>
    <?php endforeach; ?>
</ul>