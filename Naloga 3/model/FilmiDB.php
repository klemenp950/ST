<?php

require_once "DBInit.php";


class FilmiDB{
    public static function get($id){
        $db = DBInit::getInstance();

        $stmt = $db->prepare("SELECT id, naslov, leto, direktor FROM film WHERE id LIKE :id");
        $stmt->bindParam("id", $id);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function filmExists($naslov){
        $db = DBInit::getInstance();

        $stmt = $db->prepare("SELECT COUNT(id) FROM film WHERE naslov LIKE :naslov");
        $stmt -> bindParam(":naslov", $naslov);
        $stmt -> execute();
        var_dump($stmt->fetchColumn(0));
        return $stmt->fetchColumn(0) != "0";
    }

    public static function getAll(){
        $db = DBInit::getInstance();

        $stmt = $db->prepare("SELECT f.id, f.naslov, f.leto, d.ime, d.priimek, f.slika FROM film f JOIN direktor d ON f.direktorID=d.id");
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public static function getAvgOcena($naslov){
        $db = DBInit::getInstance();

        $stmt = $db ->prepare("SELECT AVG(o.ocena) FROM film f JOIN ocena o ON f.id=o.filmID");
        $stmt->execute();

        return $stmt->fetch(0);
    }

    public static function update($id,$naslov, $leto, $direktor){
        $db = DBInit::getInstance();

        $stmt = $db->prepare("UPDATE film SET naslov = :naslov, leto = :leto, direktor = :direktor WHERE id LIKE :id");
        $stmt->bindParam(":naslov", $naslov);
        $stmt->bindParam(":leto", $leto);
        $stmt->bindParam(":direktor", $direktor);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);  //PDO:PARAM_INT ig da pove da je integer.

        $stmt->execute();
    }

    public static function search($query) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT id, naslov, leto, direktorID FROM film WHERE MATCH (naslov, leto, direktor) AGAINST (:query IN BOOLEAN MODE)");
        $statement->bindValue(":query", $query);
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function delete($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("DELETE FROM film WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }
    
    public static function insert($naslov, $leto, $direktor, $slika){
        $db = DBInit::getInstance();

        $stmt = $db->prepare("INSERT INTO film (naslov, leto, direktorID, slika) VALUES (:naslov, :leto, :direktor, :slika)");
        $stmt->bindParam(":naslov", $naslov);
        $stmt->bindParam(":leto", $leto);
        $stmt->bindParam(":direktor", $direktor);
        $stmt->bindParam(":slika", $slika);

        $stmt->execute();
    }
}
?>