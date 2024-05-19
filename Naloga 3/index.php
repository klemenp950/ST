<?php

require_once("controller/FilmController.php");
require_once("controller/UserController.php");

define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/images/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/css/");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

$urls = [
    "user/register" => function () {
       UserController::addUser();
       UserController::login();
    }, "user/login" => function () {
        UserController::login();
    }, "" => function () {
        ViewHelper::redirect(BASE_URL . "index");
    }, "index" => function() {
        FilmController::index();
    }, "not-logged-in" => function () {
        UserController::notLoggedIn();
    }, "view/login" => function () {
        UserController::showLoginForm();
    }, "view/register" => function () {
        UserController::showRegisterForm();
    }, "user/register" => function() {
        UserController::addUser();
        UserController::login();
    }, "user/logout" => function () {
        UserController::logout();
    }
];

try {
    if (isset($urls[$path])) {
       $urls[$path]();
    } else {
        echo "No controller for '$path'";
    }
} catch (Exception $e) {
    echo "An error occurred: <pre>$e</pre>";
    // ViewHelper::error404();
} 
