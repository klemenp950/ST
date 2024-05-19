<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Registracija</h1>
    <form action="<?= BASE_URL . "user/register" ?>" method="post">
        <label>Username: 
            <input type="text" name="username" autocomplete="off" required autofocus />
        </label>
        <br/>
        <label>Password: 
            <input type="password" name="password" required/>
        </label>
        <button type="submit">Registriraj se</button>
    </form>
</body>
</html>