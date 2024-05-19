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

    public static function getAll(){
        $db = DBInit::getInstance();

        $stmt = $db->prepare("SELECT id, naslov, leto, direktor FROM film");
        $stmt->execute();
        
        return $stmt->fetchAll();
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

        $statement = $db->prepare("SELECT id, naslov, leto, direktor FROM film WHERE MATCH (naslov, leto, direktor) AGAINST (:query IN BOOLEAN MODE)");
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
    
    public static function insert($naslov, $leto, $direktor){
        $db = DBInit::getInstance();

        $stmt = $db->prepare("INSERT INTO film (naslov, leto, direktor) VALUES (:naslov, :leto, :direktor)");
        $stmt->bindColumn(":naslov", $naslov);
        $stmt->bindColumn(":leto", $leto);
        $stmt->bindColumn(":direktor", $direktor);

        $stmt->execute();
    }
}
?>