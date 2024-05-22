<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>FilmBuzz: Prijava</title>
</head>
<body>
    <div style="margin: auto; width: 300px;">
        <h1 style="text-align:center">FilmBuzz</h1>
        <h2 style="text-align:center">Prijava</h2>
        <form action="<?= BASE_URL . "user/login" ?>" method="post">
            <div class="form-group">
                <label for="formGroupExampleInput">Uporabniško ime:</label>
                <input class="form-control" type="text" name="username" autocomplete="off" required autofocus />
            </div>
            <div class="form-group">
                <label for="formGroupExampleInput2">Geslo:</label>
                <input class="form-control" type="password" name="password" required />
            </div>
            <div class="form-group">
                <?php if (!empty($errorMessage)): ?>
                    <p style="color: red;"><?= $errorMessage ?></p>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <p><button class="btn btn-dark">Prijava</button></p>
                <a href="<?=BASE_URL . "view/register"?>">Registriraj se</a>
            </div>
        </form>
    </div>
</body>
</html>