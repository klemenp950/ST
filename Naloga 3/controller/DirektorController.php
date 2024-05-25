<?php

require_once("model/DirektorDB.php");
require_once("ViewHelper.php");

class DirektorController {
    public static function getAllJson(){
        $data = DirektorDB::getAll();
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }

    public static function showAddDirector(){
        ViewHelper::render("view/add-director.php", []);
    }

    public static function addDirector() {
        if (isset($_POST["imeDirektorja"])) {
            $ime = filter_input(INPUT_POST, "imeDirektorja", FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if (isset($_POST["priimekDirektorja"])) {
            $priimek = filter_input(INPUT_POST, "priimekDirektorja", FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if (isset($_POST["datumRojstvaDirektorja"])) {
            $datumRojstvaDirektorja = $_POST["datumRojstvaDirektorja"];
        }
        //var_dump(DirektorDB::directorExists($ime, $priimek, $datumRojstvaDirektorja));
        if(DirektorDB::directorExists($ime, $priimek, $datumRojstvaDirektorja)){
            ViewHelper::render("view/add-director.php", ["fileError" => "Direktor že obstaja."]);
            return;
        }
        DirektorDB::insert($ime, $priimek, $datumRojstvaDirektorja);
        ViewHelper::redirect(BASE_URL . "index");
    }
}