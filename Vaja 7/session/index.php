<?php
session_start();

if (!isset($_SESSION["counter"])) {
    $_SESSION["counter"] = 1;
    $message = "This is your first visit!";
} else {
    $_SESSION["counter"] = $_SESSION["counter"] + 1;
    $message = "You have visited this site $_SESSION[counter] times.";
}
?><!DOCTYPE html>
<meta charset="UTF-8">
<title>Counting your visits with PHP session</title>

<p><?= $message ?></p>
