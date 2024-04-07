<!DOCTYPE html>

<meta charset="UTF-8" />
<title>Prime number check</title>

<h1>Prime number check</h1>

<p><?php
echo "Pozdravljeni. Današnji datum je " . date("Y-m-d") . " in ura je " . date ("H:i:s");
?></p>

<p>Check if a number is prime by submitting the following form.</p>

<form action="check-prime.php" method="get">
    <label for="number">Number:</label>
    <input type="number" name="number" id="number" />
    <button type="submit">Check if prime.</button>
</form>
