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
}
