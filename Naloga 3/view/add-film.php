<?php 
    session_start();
    if(isset($_SESSION["username"])){ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>FilmBuzz: Dodaj film</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="jumbotron text-center" style="margin-bottom:0">
    <h1>Dodaj film</h1>
    <p>Dodajanje filma v podatkovno bazo</p>
</div>

<?php include("navbar.php"); ?>

<div class="container" style="margin-top:30px; margin-bottom: 30px;">
    <div style="margin: auto; width: 70%;">
        <form action="<?= BASE_URL . "film/add"?>" method="post" enctype="multipart/form-data">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="datoteka" aria-describedby="inputGroupFileAddon01" name="datoteka">
                <label class="custom-file-label" id="datotekaLabel" for="slikaFilm">Izberi sliko filma</label>
            </div>
            <div class="form-group">
                <label for="naslovFilma">Naslov: </label>
                <input class="form-control" type="text" name="naslovFilma" required>
            </div>
            <div class="form-group">
                <label for="letoFilma">Direktor: </label>
                <input class="form-control" type="text" name="direktorFilma" required>
            </div>
            <div class="form-group">
                <label for="letoFilma">Leto: </label>
                <input class="form-control" type="number" name="letoFilma" required>
            </div>
            <div class="form-group">
                <button class="btn btn-dark" type="submit">Shrani</button>
            </div>
                <?php if (!empty($fileError)): ?>
                    <p style="color: red;"><?= $errorMessage ?></p>
                <?php endif; ?>
        </form>
    </div>
  
</div>

<?php include("footer.php") ?>

</body>
<script>
    $(document).ready(function(){
        $("#datoteka").change(function(){
            var file = this.files[0];
            var fileName = file.name;
        $("#datotekaLabel").text(fileName);
      });
    });
</script>
</html>
<?php } else {
    ViewHelper::redirect(BASE_URL . "view/not-logged-in");
}