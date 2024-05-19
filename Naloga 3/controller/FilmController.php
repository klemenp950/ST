<?php

require_once("model/FilmiDB.php");
require_once("ViewHelper.php");

class FilmController {
    public static function index() {
        $vars = [
            "filmi" => FilmiDB::getAll()
        ];

        ViewHelper::render("view/index.php", $vars);
    }

}
?>