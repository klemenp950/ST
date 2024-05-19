<?php 

require_once "DBInit.php";

class OcenaDB{
    public static function getAll(){
        $db = DBInit::getInstance();

        $stmt = $db->prepare("SELECT ocena.id, ocena.ocena, ocena.opis, film.naslov, user.username
        FROM ocena
        INNER JOIN film ON ocena.filmID = film.id
        INNER JOIN user ON ocena.userID = user.id;
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function get($id){
        $db = DBInit::getInstance();

        $stmt = $db->prepare("SELECT ocena.id, ocena.ocena, ocena.opis, film.naslov, user.username
        FROM ocena
        INNER JOIN film ON ocena.filmID = film.id
        INNER JOIN user ON ocena.userID = user.id
        WHERE ocena.id LIKE :id;
        ");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getByUser($id){
        $db = DBInit::getInstance();

        $stmt = $db->prepare("SELECT ocena.id, ocena.ocena, ocena.opis, film.naslov, user.username
        FROM ocena
        INNER JOIN film ON ocena.filmID = film.id
        INNER JOIN user ON ocena.userID = user.id
        WHERE user.id LIKE :id;
        ");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getByFilm($id){
        $db = DBInit::getInstance();

        $stmt = $db->prepare("SELECT ocena.id, ocena.ocena, ocena.opis, film.naslov, user.username
        FROM ocena
        INNER JOIN film ON ocena.filmID = film.id
        INNER JOIN user ON ocena.userID = user.id
        WHERE film.id LIKE :id;
        ");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function delete($id){
        $db = DBInit::getInstance();

        $stmt = $db->prepare("DELETE FROM ocena WHERE id LIKE :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function update($id, $ocena, $opis){
        $db = DBInit::getInstance();

        $stmt = $db->prepare("UPDATE ocena SET ocena = :ocena, opis = :opis WHERE id LIKE :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":ocena", $ocena, PDO::PARAM_INT);
        $stmt->bindParam(":opis", $opis);
        $stmt->execute();
        $stmt->execute();
    }
}
?>