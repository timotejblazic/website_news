<?php

require_once("model/CommentDB.php");
require_once("ViewHelper.php");

class CommentController {
    public static function addComment() {
        $rules = [
            "content" => [
                "filter" => FILTER_SANITIZE_SPECIAL_CHARS
            ],
            "postID" => [
                "filter" => FILTER_VALIDATE_INT,
                "options" => ["min_range" => 1]
            ]
        ];

        $data = filter_input_array(INPUT_POST, $rules);

        $errors["content"] = (strlen($data["content"]) > 300 || strlen($data["content"]) < 1) ? "Content can be max 300 chars long." : "";
        $error["postID"] = $data["postID"] == false ? "Post ID is required." : "";

        if(empty($errors["content"]) && empty($errors["postID"])){
            CommentDB::addCommentToPost($_SESSION["user"]["UserID"], $data["postID"], $data["content"]);
            ViewHelper::redirect(BASE_URL . "posts?id=" . $data["postID"]);
        } else {
            ViewHelper::redirect(BASE_URL . "posts?id=" . $data["postID"]);
        }
    }

}