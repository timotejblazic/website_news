<?php

require_once("model/PostDB.php");
require_once("model/CommentDB.php");
require_once("ViewHelper.php");

class PostController {
    public static function index() {
        if (isset($_GET["id"])) {
            ViewHelper::render("view/post-detail.php", ["post" => PostDB::getPost($_GET["id"]), "comments" => CommentDB::getAllCommentsForPost($_GET["id"]), "recentComments" => CommentDB::getRecentComments()]);
        } else {
            ViewHelper::render("view/post-all.php", ["posts" => PostDB::getAllPosts(), "recentComments" => CommentDB::getRecentComments()]);
        }
    }

    public static function showAddForm($data = [], $errors = []) {
        if(empty($data)){
            $data = [
                "title" => "",
                "content" => "",
                "image" => ""
            ];
        }

        if(empty($errors)){
            foreach($data as $key => $value){
                $errors[$key] = "";
            }
        }

        ViewHelper::render("view/post-add.php", ["data" => $data, "errors" => $errors]);
    }

    public static function addPost() {
        $rules = [
            "title" => [
                "filter" => FILTER_SANITIZE_SPECIAL_CHARS
            ],
            "content" => [
                "filter" => FILTER_SANITIZE_SPECIAL_CHARS
            ]
        ];

        $data = filter_input_array(INPUT_POST, $rules);

        $errors["title"] = (strlen($data["title"]) > 100 || strlen($data["title"]) < 1) ? "Title must be between 1 and 100 characters." : "";
        $errors["content"] = (strlen($data["content"]) > 4000 || strlen($data["content"]) < 50) ? "Content must be between 50 and 4000 characters." : "";
        
        if (!empty($_FILES["image"]["name"])) {
            $fileName = basename($_FILES["image"]["name"]);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

            $allowedTypes = ["jpg", "jpeg", "png", "gif"];
            if(in_array($fileType, $allowedTypes)){
                $data["image"] = file_get_contents($_FILES["image"]["tmp_name"]);
            } else {
                $errors["image"] = "Only jpg, jpeg, png and gif files are allowed.";
            }
        } else {
            $errors["image"] = "Please upload an image.";
        }

        $isDataValid = true;
        foreach ($errors as $error) {
            $isDataValid = $isDataValid && empty($error);
        }

        if ($isDataValid) {
            PostDB::addPost($_SESSION["user"]["UserID"], $data["title"], $data["content"], $data["image"]);
            ViewHelper::redirect(BASE_URL . "posts");
        } else {
            self::showAddForm($data, $errors);
        }
    }

    public static function showEditForm($data = [], $errors = []) {
        if(empty($data)){
            $data = PostDB::getPost($_GET["id"]);
        }

        if(empty($errors)){
            foreach($data as $key => $value){
                $errors[$key] = "";
            }
        }

        ViewHelper::render("view/post-edit.php", ["data" => $data, "errors" => $errors]);
    }

    public static function editPost() {
        $rules = [
            "title" => [
                "filter" => FILTER_SANITIZE_SPECIAL_CHARS
            ],
            "content" => [
                "filter" => FILTER_SANITIZE_SPECIAL_CHARS
            ],
            "id" => [
                "filter" => FILTER_VALIDATE_INT,
                "options" => ["min_range" => 1]
            ]
        ];

        $data = filter_input_array(INPUT_POST, $rules);

        $errors["title"] = (strlen($data["title"]) > 100 || strlen($data["title"]) < 1) ? "Title must be between 1 and 100 characters." : "";
        $errors["content"] = (strlen($data["content"]) > 4000 || strlen($data["content"]) < 50) ? "Content must be between 50 and 4000 characters." : "";
        $errors["id"] = $data["id"] == false ? "Invalid post id." : "";

        // If clicked on button Delete, do delete
        if (isset($_POST["delete"])) {
            PostDB::deletePost($data["id"]);
            ViewHelper::redirect(BASE_URL . "posts");
            return;
        }
        
        if (!empty($_FILES["image"]["name"])) {
            $fileName = basename($_FILES["image"]["name"]);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

            $allowedTypes = ["jpg", "jpeg", "png", "gif"];
            if(in_array($fileType, $allowedTypes)){
                $data["image"] = file_get_contents($_FILES["image"]["tmp_name"]);
            } else {
                $errors["image"] = "Only jpg, jpeg, png and gif files are allowed.";
            }
        }
        // If image is not updated, keep the old one
        else {
            $data["image"] = PostDB::getPost($data["id"])["Image"];
        }

        $isDataValid = true;
        foreach ($errors as $error) {
            $isDataValid = $isDataValid && empty($error);
        }

        if ($isDataValid) {
            PostDB::editPost($data["id"], $data["title"], $data["content"], $data["image"]);
            ViewHelper::redirect(BASE_URL . "posts?id=" . $data["id"]);
        } else {
            self::showEditForm($data, $errors);
        }
    }

    public static function search() {
        $rules = [
            "search" => [
                "filter" => FILTER_SANITIZE_SPECIAL_CHARS
            ]
        ];

        $data = filter_input_array(INPUT_GET, $rules);

        $posts = PostDB::searchPosts($data["search"]);
        ViewHelper::render("view/post-all.php", ["posts" => $posts, "recentComments" => CommentDB::getRecentComments()]);
    }
}