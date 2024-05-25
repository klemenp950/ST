<!DOCTYPE html>
<html lang="en">
    <?php
        if (!isset($_SESSION["username"])) {
            session_start();
        }
    ?>
<head>
    <title>FilmBuzz: <?=$_SESSION["username"]?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="jumbotron text-center" style="margin-bottom:0">
        <h1><?= $_SESSION["username"] ?></h1>
        <p>Spremenite podatke o Vašem FilmBuzz profilu</p>
    </div>
     
    <?php include("navbar.php"); ?>

    <div style="margin: 30px auto; width: 300px;">
        <form action="<?= BASE_URL . "user/alter-user" ?>" method="post">
            <div class="form-group">
                <label for="formGroupExampleInput">Novo uporabniško ime:</label>
                <input class="form-control" type="text" name="newUsername" id="newUsername"/>
            </div>
            <div class="form-group">
                <label for="formGroupExampleInput">Staro geslo:</label>
                <input class="form-control" type="password" name="oldPassword" required/>
            </div>
            <div class="form-group">
                <label for="formGroupExampleInput2">Novo geslo:</label>
                <input class="form-control" type="password" name="newPassword" />
            </div>
            <div class="form-group">
                <label for="formGroupExampleInput2">Ponovno vnesite novo geslo:</label>
                <input class="form-control" type="password" name="newPassword2" />
            </div>
            <div class="form-group">
                <?php if (!empty($errorMessage)): ?>
                    <p style="color: red;"><?= $errorMessage ?></p>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <p><button class="btn btn-dark">Spremeni uporabnika</button></p>
            </div>
        </form>
    </div>

    <?php include("footer.php") ?>

    <script>
        $(document).ready(function(){
            $("#newUsername").val("<?=$_SESSION["username"]?>");
        })
    </script>
</body>
</html>