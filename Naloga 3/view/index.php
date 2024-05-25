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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="style/index.css">
</head>
<body>

<div class="jumbotron text-center" style="margin-bottom:0">
  <h1>FilmBuzz</h1>
  <p>Spletna stran <i>pravih</i> filmskih navdušencev.</p> 
</div>

<?php include("navbar.php"); ?>

<div class="container" style="margin-top:30px">
  <div class="row">
    <?php foreach ($filmi as $film): ?>
      <div class="col-md-6 mb-4">
        <div class="cardC">
          <img class="cardC-img-top" src="<?=$film["slika"]?>" alt="Slika filma">
          <div class="cardC-body">
            <h5 class="cardC-title"><?=$film["naslov"]?></h5>
            <p class="card-text"><strong>Režiser: </strong><?=$film["ime"] . " " . $film["priimek"]?></p>
            <p class="card-text"><strong>Leto:</strong> <?=$film["leto"]?></p>
            <a href="pot_do_strani_s_informacijami.html" class="btn btn-dark">Več o filmu</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php include("footer.php")?>

</body>
</html>
