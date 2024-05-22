<?php

require_once "DBInit.php";

class UserDB {

    public static function validLoginAttempt($username, $password) {
        $dbh = DBInit::getInstance();

        $stmt = $dbh->prepare("SELECT password FROM user WHERE username = :username");
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        $hashGesla = $stmt->fetchColumn();

        if ($hashGesla !== false && password_verify($password, $hashGesla)) {
            return true;
        } else {
            return false;
        }
    }

    public static function addUser($username, $password){
        $db = DBInit::getInstance();

        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $db->prepare("INSERT INTO user (username, password) VALUE (:username, :password)");
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $hashPassword);

        $stmt->execute();
    }

    public static function alterUser($username, $newUsername, $newPassword){
        $db = DBInit::getInstance();

        $stmt = $db -> prepare("UPDATE user SET username = :newUsername, password = :newPassword WHERE username = :username");
        $stmt -> bindParam("newUsername", $newUsername);
        $stmt -> bindParam("newPassword", $newPassword);
        $stmt -> bindParam("username", $username);
        $stmt -> execute();
    }

    public static function userAvailable($username){
        $dbh = DBInit::getInstance();

        // !!! NEVER CONSTRUCT SQL QUERIES THIS WAY !!!
        // INSTEAD, ALWAYS USE PREPARED STATEMENTS AND BIND PARAMETERS!
        $stmt = $dbh->prepare("SELECT COUNT(id) FROM user WHERE username = :username");
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        return $stmt->fetchColumn(0) == 0;
    }
}
