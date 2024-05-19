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
        $password = "";
        if(isset($_POST["password"]) && !empty($_POST["password"])){
            $password = htmlspecialchars($_POST["username"]);    
        }
        UserDB::addUser($username, $password);
    }

    public static function notLoggedIn(){
        $vars = [
            "errorMessage" => "Invalid username or password."
        ];
        ViewHelper::render("view/not-logged-in.php", $vars);
    }

    public static function logout() {
        unset($_SESSION["username"]);
        ViewHelper::redirect(BASE_URL . "index");
    }
}