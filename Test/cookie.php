<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    if (isset($_COOKIE["Piškotek"])) {
        echo $_COOKIE["Piškotek"];
    }
    if (!isset($_COOKIE["Piškotek"])) {
        echo "Piškotek ni nastavljen";
    }
    ?>
    <button id="gumb">Nastavi piškotek</button>
    <script>
        document.getElementById("gumb").addEventListener('click', function(event){
            var now = new Date();
            now.setTime(now.getTime() + 60 * 1000); 
            document.cookie = 'Piškotek=nekavrednost; expires=' + now.toUTCString() + '; path=/';
            alert('Piškotek je bil uspešno nastavljen za 1 minuto!');
        });
    </script>
</body>
</html>