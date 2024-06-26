<?php

session_start();

require_once "BookDB.php";

$cart_action = (isset($_POST["cart_action"])) ? $_POST["cart_action"] : "";
$id = (isset($_POST["id"])) ? intval($_POST["id"]) : 0;

switch ($cart_action) {
    // Adds a book to the cart.
    case 'add':
        // We check whether the book with given id actually exists
        // (otherwise we could add a non-existing book to the cart)
        $book = BookDB::get($id);

        if ($book != null) {
            // Incrementing the quantity of a book that is already in the cart
            if (isset($_SESSION["cart"][$id])) {
                $_SESSION["cart"][$id] += 1;
            // adding a new book to the cart
            } else {
                $_SESSION["cart"][$id] = 1;
            }
        }

        header("Location: index.php");
        break;

    case 'update':
        $kolicina = $_POST["kolicina"];
        $book = BookDB::get($id);
        if ($kolicina != 0) {
            $_SESSION["cart"][$id] = $kolicina;
        } else {
            unset($_SESSION["cart"][$id]);
        }
        header("Location: index.php");
        break;
        

    case 'purge_cart':
        // empties the whole cart by simply unsetting the session variable
        unset($_SESSION["cart"]);

        // this command redirects the user to the list of all books
        header("Location: index.php");
        break;
    
    default:
        echo "Unknown action: $cart_action";
        exit();
        break;
}