<?php

require_once("model/UserDB.php");
require_once("ViewHelper.php");

class UserController {

    public static function showLoginForm() {
       ViewHelper::render("view/login.php");
    }

    public static function showRegisterForm() {
        ViewHelper::render("view/register.php");
    }

    public static function login() {
       if (UserDB::validLoginAttempt($_POST["username"], $_POST["password"])) {
            session_start();
            $_SESSION["username"] = $_POST["username"];
            $vars = [
                "filmi" => FilmiDB::getAll()
            ];

            ViewHelper::render("view/index.php", $vars);
        } else {
            ViewHelper::render("view/login.php", [
                "errorMessage" => "Invalid username or password."
            ]);
       }
    }

    public static function addUser(){
        $username = "";
        if(isset($_POST["username"]) && !empty($_POST["username"])){
            $username = htmlspecialchars($_POST["username"]);    
        }
        if(UserDB::userAvailable($username)){
            $password = "";
            if(isset($_POST["password"]) && !empty($_POST["password"])){
                $password = htmlspecialchars($_POST["password"]);    
            }
            $password2 = "";
            if(isset($_POST["password2"]) && !empty($_POST["password2"])){
                $password2 = htmlspecialchars($_POST["password2"]);    
            }
            if($password == $password2){
                UserDB::addUser($username, $password);
                UserController::login();
            } else {
                ViewHelper::render("view/register.php", [
                    "errorMessage" => "Vnešeni gesli se ne ujemata."
                ]);
            }
        } else {
            ViewHelper::render("view/register.php", [
                "errorMessage" => "Uporabniško ime je že zasedeno."
            ]);
        }
    }

    public static function notLoggedIn(){
        $vars = [];
        ViewHelper::render("view/not-logged-in.php", $vars);
    }

    public static function logout() {
        session_start();
        unset($_SESSION["username"]);
        session_destroy();
        ViewHelper::redirect(BASE_URL . "index");
    }

    public static function showUserInfo() {
        $vars = [
            "errorMessage" => ""
        ];
        ViewHelper::render("view/user-info.php", $vars);
    }

    public static function alterUser() {
        session_start();
        $newUsername = "";
        if(isset($_POST["newUsername"])){
            $newUsername = $_POST["newUsername"];
        }
        $username = $_SESSION["username"];
        if ($newUsername != $username) {
            if (!UserDB::userAvailable($newUsername)) {
                ViewHelper::render("view/user-info.php", ["errorMessage" => "Novo uporabniško ime je že zasedeno"]);
                return;
            }
        }
        $password = $_POST["oldPassword"];
        $newPassword = $_POST["newPassword"]; 
        $newPassword2 = $_POST["newPassword2"]; 
        if (UserDB::validLoginAttempt($username, $password)) {
            if ($newPassword == $newPassword2) {
                if($newUsername == ""){
                    UserDB::alterUser($username, $username, password_hash($newPassword, PASSWORD_DEFAULT));
                } else {
                    UserDB::alterUser($username, $newUsername, password_hash($newPassword, PASSWORD_DEFAULT));
                }
                $_SESSION["username"] = $newUsername;
                $_POST["username"] = $newUsername;
                $_POST["password"] = $newPassword;
                ViewHelper::redirect(BASE_URL . "index");
            }
        } else {
            ViewHelper::render("view/user-info.php", ["errorMessage" => "Staro geslo je napačno."]);
        }
    }
}