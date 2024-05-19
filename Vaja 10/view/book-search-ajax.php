<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AJAX Book Search</title>
    <link rel="stylesheet" type="text/css" href="<?= ASSETS_URL . "style.css" ?>">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
</head>
<body>
    <h1>AJAX Book Search</h1>

    <?php include("view/menu.php"); ?>

    <label>Search: <input id="search-field" type="text" name="query" autocomplete="off" autofocus /></label>

    <ul id="book-hits"></ul>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#search-field").on("keyup", function () {
                const query = this.value;
                const url = "<?= BASE_URL . 'api/book/search?query=' ?>" + query;

                $.get(url, function (data) {
                    const knjige = data;
                    let html = '';

                    for (let i = 0; i < knjige.length; i++) {
                        let knjiga = knjige[i];
                        html += '<li><a href="<?=BASE_URL . "book"?>?id=' + knjiga.id + '">' + knjiga.author + ' - ' + knjiga.title + ' (' + knjiga.year + ')</a></li>';
                    }

                    $("#book-hits").html(html);
                });
            });
        });
    </script>
</body>
</html>
