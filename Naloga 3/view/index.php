<?php 
if (isset($_SESSION["username"])): ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>INDEX</h1>
    <?php
    echo var_dump($_SESSION["username"]);
    ?>
    <a href="<?=BASE_URL . "user/logout"?>">Logout</a>
</body>
</html>
<?php else:
ViewHelper::redirect(BASE_URL . "not-logged-in")    
?>
    
<?php endif;?>