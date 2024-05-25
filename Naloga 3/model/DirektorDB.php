<?php

require_once "DBInit.php";

class DirektorDB{
    public static function insert($ime, $priimek, $datumRojstva){
        $db = DBInit::getInstance();

        $stmt = $db->prepare("INSERT INTO direktor (ime, priimek, datum_rojstva) VALUES (:ime, :priimek, :datum)");
        $stmt->bindParam(":ime", $ime);
        $stmt->bindParam(":priimek", $priimek);
        $stmt->bindParam(":datum", $datumRojstva);

        $stmt->execute();
    }

    public static function getAll(){
        $db = DBInit::getInstance();

        $stmt = $db->prepare("SELECT id, ime, priimek, datum_rojstva FROM direktor");
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public static function directorExists($ime, $priimek, $datum){
        $db = DBInit::getInstance();

        $stmt = $db->prepare("SELECT COUNT(id) as st FROM direktor WHERE ime=:ime AND priimek=:priimek AND datum_rojstva=:datum");
        $stmt -> bindParam(":ime", $ime);
        $stmt -> bindParam(":priimek", $priimek);
        $stmt -> bindParam(":datum", $datum);
        $stmt -> execute();

        return $stmt->fetchColumn(0) !== "0";
    }
}