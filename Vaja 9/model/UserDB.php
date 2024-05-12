<?php

require_once "DBInit.php";

class UserDB {

    // Returns true if a valid combination of a username and a password are provided.
    public static function validLoginAttempt($username, $password) {
        $dbh = DBInit::getInstance();

        // !!! NEVER CONSTRUCT SQL QUERIES THIS WAY !!!
        // INSTEAD, ALWAYS USE PREPARED STATEMENTS AND BIND PARAMETERS!
        $stmt = $dbh->prepare("SELECT COUNT(id) FROM user WHERE username = :username AND password = :password");
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $password);
        $stmt->execute();

        return $stmt->fetchColumn(0) == 1;
    }
}
