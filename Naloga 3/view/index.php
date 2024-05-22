<?php
if (!isset($_SESSION["username"])) {
  session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>FilmBuzz</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="jumbotron text-center" style="margin-bottom:0">
  <h1>FilmBuzz</h1>
  <p>Spletna stran <i>pravih</i> filmskih navdušencev.</p> 
</div>

<?php include("navbar.php"); ?>

<div class="container" style="margin-top:30px">
  
</div>

<?php include("footer.php")?>

</body>
</html>