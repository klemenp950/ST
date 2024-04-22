<?php
session_start();
require_once ("BookDB.php");
?><!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="style.css">
<meta charset="UTF-8">
<title>Library</title>

<h1>A PHP bookstore</h1>

<div id="main">    
    <?php foreach (BookDB::getAll() as $book): ?>
        <div class="book">
            <form action="manage-cart.php" method="post">
                <input type="hidden" name="cart_action" value="add">
                <input type="hidden" name="id" value="<?= $book["id"] ?>">
                <p><?= $book["title"] ?></p>
                <p><?= $book["author"] ?>, <?= $book["year"] ?></p>
                <p><?= number_format($book["price"], 2) ?> EUR<br>
                <button>Add to cart</button>
            </form> 
        </div>
    <?php endforeach; ?>
</div>

<?php

$cart = isset($_SESSION["cart"]) ? $_SESSION["cart"] : [];

if (!empty($cart)): ?>
    <div class="cart">
        <h3>Shopping cart</h3>
        <?php 
        $total = 0;
        foreach ($cart as $id => $quantity): 
            $book = BookDB::get($id);
            $total += $book['price'] * $quantity;
        ?>
            <form action="manage-cart.php" method="post">
                <input type="hidden" name="cart_action" value="update">
                <input type="hidden" name="id" value="<?= $book["id"] ?>">
                <p><input type="number" name="kolicina" value="<?=$quantity?>" style="width: 30px;"> x
                <?= $book['title'] ?>,  Količina: <?= $quantity ?>
                <button>Update</button></p>
            </form>
        <?php endforeach; ?>

        <p>Total: <?=  number_format($total, 2, ",")  ?></p>

        <form action="manage-cart.php" method="post">
            <input type="hidden" name="cart_action" value="purge_cart">
            <p><button>Purge cart</button></p>
        </form>
    </div>
<?php
endif;
