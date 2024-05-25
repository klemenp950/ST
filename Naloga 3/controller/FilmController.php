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
            $direktor = $_POST["direktorFilma"];
        }
        if (isset($_POST["letoFilma"])) {
            $leto = filter_input(INPUT_POST, "letoFilma", FILTER_VALIDATE_INT, [
                "options" => [
                  "min_range" => 1900,
                  "max_range" => 2024
                ]
              ]);        
            }
        if(FilmiDB::filmExists($naslov)){
            ViewHelper::render("view/add-film.php", ["fileError" => "Film že obstaja."]);
            return;
        }
        if (isset($_FILES["datoteka"])) {
            $idk = FilmController::uploadImage();
            if($idk){
                FilmiDB::insert($naslov, $leto, $direktor, $idk);
            }
        } else {
            FilmiDB::insert($naslov, $leto, $direktor, "null");
        }
        ViewHelper::redirect(BASE_URL . "index");
    }

    public static function uploadImage(){
        if (!isset($_SESSION["username"])) {
            session_start();
        }
        $target_dir = "C:\Users\kleme\uploads\\";
        var_dump(pathinfo($_FILES["datoteka"]["name"], PATHINFO_EXTENSION));
        $target_file = $target_dir . $_SESSION["username"] . time() . "." . pathinfo($_FILES["datoteka"]["name"], PATHINFO_EXTENSION);
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
            var_dump($target_file);
            if (move_uploaded_file($_FILES["datoteka"]["tmp_name"], $target_file)) {
                return $target_file;
            } else {
                ViewHelper::render("view/add-film.php", ["fileError" => "Napaka pri nalaganju slike."]);
            }
        }
        return false;
    }

    public static function getAllJson(){
        $data = FilmiDB::getAll();
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }

}
?>