<?php

require_once "DBInit.php";

class BookDB {

    public static function getAll() {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT id, author, title, price, leto FROM book");
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function get($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT id, author, title, price, leto FROM book 
            WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    public static function insert($author, $title, $price, $leto) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("INSERT INTO book (author, title, price, leto)
            VALUES (:author, :title, :price, :leto)");
        $statement->bindParam(":author", $author);
        $statement->bindParam(":title", $title);
        $statement->bindParam(":price", $price);
        $statement->bindParam(":leto", $leto);
        $statement->execute();
    }

    public static function update($id, $author, $title, $price, $leto) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("UPDATE book SET author = :author,
            title = :title, price = :price, leto = :leto WHERE id = :id");
        $statement->bindParam(":author", $author);
        $statement->bindParam(":title", $title);
        $statement->bindParam(":price", $price);
        $statement->bindParam(":leto", $leto);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }

    public static function delete($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("DELETE FROM book WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }    

    public static function search($query) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT id, author, title, price FROM book 
            WHERE author LIKE :query OR title LIKE :query OR leto LIKE :query");

        # Alternatively, we could execute: 
        # $statement = $db->prepare("SELECT id, author, title, price FROM book 
        #    WHERE MATCH (author, title) against (:query)");
        # However, we would have to set the table ("book") storage engine to 
        # MyISAM and set a joint full-text index to author and title columns

        $statement->bindValue(":query", '%' . $query . '%');
        $statement->execute();

        return $statement->fetchAll();
    }    
}
