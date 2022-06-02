<?php

require_once("DBInit.php");

class PostDB {
    public static function getAllPosts() {
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT PostID, UserID, DateCreated, DateModified, Title, Content, Image FROM post
            ORDER BY DateCreated DESC");
        $statement->execute();
        $posts = $statement->fetchAll();
        return $posts;
    }

    public static function getPost($postID) {
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT PostID, UserID, DateCreated, DateModified, Title, Content, Image FROM post 
            WHERE PostID = :postID");
        $statement->bindValue(":postID", $postID);
        $statement->execute();
        $post = $statement->fetch();
        return $post;
    }

    public static function addPost($userID, $title, $content, $image) {
        $db = DBInit::getInstance();
        $statement = $db->prepare("INSERT INTO post (UserID, DateCreated, DateModified, Title, Content, Image) 
            VALUES (:userID, NOW(), NOW(), :title, :content, :image)");
        $statement->bindValue(":userID", $userID);
        $statement->bindValue(":title", $title);
        $statement->bindValue(":content", $content);
        $statement->bindValue(":image", $image);
        $statement->execute();
    }

    public static function editPost($postID, $title, $content, $image) {
        $db = DBInit::getInstance();
        $statement = $db->prepare("UPDATE post SET DateModified = NOW(), Title = :title, Content = :content, Image = :image 
            WHERE PostID = :postID");
        $statement->bindValue(":postID", $postID);
        $statement->bindValue(":title", $title);
        $statement->bindValue(":content", $content);
        $statement->bindValue(":image", $image);
        $statement->execute();
    }

    public static function deletePost($postID) {
        $db = DBInit::getInstance();
        $statement = $db->prepare("DELETE FROM post WHERE PostID = :postID");
        $statement->bindValue(":postID", $postID);
        $statement->execute();
    }

    public static function searchPosts($searchQuery) {
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT PostID, UserID, DateCreated, DateModified, Title, Content, Image FROM post 
            WHERE Title LIKE :searchQuery OR Content LIKE :searchQuery");
        $statement->bindValue(":searchQuery", "%" . $searchQuery . "%");
        $statement->execute();
        $posts = $statement->fetchAll();
        return $posts;
    }

    public static function getPostsByUserID($userID) {
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT PostID, UserID, DateCreated, DateModified, Title, Content, Image FROM post 
            WHERE UserID = :userID ORDER BY DateCreated DESC");
        $statement->bindValue(":userID", $userID);
        $statement->execute();
        $posts = $statement->fetchAll();
        return $posts;
    }
}