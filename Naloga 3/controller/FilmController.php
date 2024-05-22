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

    public static function showAddFilm(){
        $vars = [];
        ViewHelper::render("view/add-film.php", $vars);
    }

    public static function addFilm(){
        if (isset($_POST["naslovFilma"])) {
            $naslov = filter_input(INPUT_POST, "naslovFilma", FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if (isset($_POST["direktorFilma"])) {
            $direktor = filter_input(INPUT_POST, "direktorFilma", FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if (isset($_POST["letoFilma"])) {
            $leto = filter_input(INPUT_POST, "letoFilma", FILTER_VALIDATE_INT, [
                "options" => [
                  "min_range" => 1500,
                  "max_range" => 2024
                ]
              ]);        }
        if (isset($_FILES["datoteka"])) {
            $idk = FilmController::uploadImage();
            if($idk){
                FilmiDB::insert($naslov, $direktor, $leto, $idk);
            }
        } else {
            FilmiDB::insert($naslov, $direktor, $leto, null);
        }
        ViewHelper::redirect(BASE_URL . "index");
    }

    public static function uploadImage(){
        $target_dir = "./uploads/";
        $target_file = $target_dir . basename($_FILES["datoteka"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        
        $check = getimagesize($_FILES["datoteka"]["tmp_name"]);
        if($check !== false) {
            //echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            ViewHelper::render("view/add-film.php", ["fileError" => "Datoteka ki ste jo izbrali ni slika."]);
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["datoteka"]["size"] > 500000) {
            ViewHelper::render("view/add-film.php", ["fileError" => "Slika ki ste jo izbrali presega 5MB."]);
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            ViewHelper::render("view/add-film.php", ["fileError" => "Format izbrane datoteke ni podprt."]);
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            return false;
        } else {
            if (move_uploaded_file($_FILES["datoteka"]["tmp_name"], "/uploads/" . $_FILES["datoteka"]["name"])) {
                return $target_file;
            } else {
                ViewHelper::render("view/add-film.php", ["fileError" => "Napaka pri nalaganju slike."]);
            }
        }
        return false;
    }

}
?>