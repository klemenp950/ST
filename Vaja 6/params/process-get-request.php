<!DOCTYPE html>
<meta charset="utf-8">
<title>Processing GET parameters</title>

<?php 

$ime = $_GET["first_name"];
$priimek = $_GET["last_name"];
$t=time();
$time = date('h:i:s', $t);

if (isset($ime) && isset($priimek) && !empty($ime) && !empty($priimek)) {
    echo "Hello $ime $priimek, the time is $time.";
} else {
    echo "Vnesi ime in priimek";
}