<?php

session_start();

require_once("controller/UserController.php");
require_once("controller/PostController.php");
require_once("controller/CommentController.php");

define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/images/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/css/");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

$urls = [
    "login" => function() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UserController::login();
        } else {
            UserController::showLoginForm();
        }
    },
    "register" => function() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UserController::register();
        } else {
            UserController::showRegisterForm();
        }
    },
    "logout" => function() {
        UserController::logout();
    },
    "posts" => function() {
        PostController::index();
    },
    "posts/search" => function() {
        PostController::search();
    },
    "posts/add" => function() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            PostController::addPost();
        } else {
            PostController::showAddForm();
        }
    },
    "posts/edit" => function() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            PostController::editPost();
        } else {
            PostController::showEditForm();
        }
    },
    "comments/add" => function() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            CommentController::addComment();
        }
    },
    "user" => function() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UserController::editUser();
        } else {
            UserController::showUser();
        }
    },
    "user/posts" => function() {
        UserController::showUserPosts();
    },
    "user/comments" => function() {
        UserController::showUserComments();
    },
    "" => function() {
        ViewHelper::redirect(BASE_URL . "posts");
    }
];

try {
    if (isset($urls[$path])) {
        $urls[$path]();
    } else {
        // There's no controller for $path
        ViewHelper::error404();
    }
} catch (Exception $e) {
    echo "An error occurred: " . $e;
}
