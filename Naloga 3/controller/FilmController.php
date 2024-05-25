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
    
        $filePath = null;
        if (isset($_FILES["datoteka"]) && $_FILES["datoteka"]["error"] != UPLOAD_ERR_NO_FILE) {
            $filePath = FilmController::uploadImage();
            if($filePath === false) {
                // Če nalaganje slike ni uspelo, prikaži napako in ustavi izvajanje
                return;
            }
        }
    
        FilmiDB::insert($naslov, $leto, $direktor, $filePath);
        ViewHelper::redirect(BASE_URL . "index");
    }
    

    public static function uploadImage(){
        if (!isset($_SESSION["username"])) {
            session_start();
        }
        $target_dir = "C:/Users/kleme/uploads/";
        $fileName = $_SESSION["username"] . time() . "." . pathinfo($_FILES["datoteka"]["name"], PATHINFO_EXTENSION);
        $target_file = $target_dir . $fileName;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
        // Preverite, če je datoteka slika
        $check = getimagesize($_FILES["datoteka"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            ViewHelper::render("view/add-film.php", ["fileError" => "Datoteka ki ste jo izbrali ni slika."]);
            $uploadOk = 0;
        }
    
        // Preverite velikost datoteke
        if ($_FILES["datoteka"]["size"] > 5000000) { // Spremenite velikost na 5MB
            ViewHelper::render("view/add-film.php", ["fileError" => "Slika ki ste jo izbrali presega 5MB."]);
            $uploadOk = 0;
        }
    
        // Dovoljeni formati datotek
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            ViewHelper::render("view/add-film.php", ["fileError" => "Format izbrane datoteke ni podprt."]);
            $uploadOk = 0;
        }
    
        // Preverite, če je $uploadOk nastavljen na 0 zaradi napake
        if ($uploadOk == 0) {
            return false;
        } else {
            if (move_uploaded_file($_FILES["datoteka"]["tmp_name"], $target_file)) {
                return $target_file;
            } else {
                ViewHelper::render("view/add-film.php", ["fileError" => "Napaka pri nalaganju slike."]);
                return false;
            }
        }
    } 

    public static function getAllJson(){
        $data = FilmiDB::getAll();
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }

}
?>