<?php

require_once("DBInit.php");

class CommentDB {
    public static function getAllCommentsForPost($postID) {
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT CommentID, UserID, PostID, DateCreated, DateModified, Content FROM comment 
            WHERE PostID = :postID");
        $statement->bindValue(":postID", $postID);
        $statement->execute();
        $comments = $statement->fetchAll();
        return $comments;
    }

    public static function addCommentToPost($userID, $postID, $content) {
        $db = DBInit::getInstance();
        $statement = $db->prepare("INSERT INTO comment (UserID, PostID, DateCreated, DateModified, Content) 
            VALUES (:userID, :postID, NOW(), NOW(), :content)");
        $statement->bindValue(":userID", $userID);
        $statement->bindValue(":postID", $postID);
        $statement->bindValue(":content", $content);
        $statement->execute();
    }

    public static function editComment($commentID, $content) {
        $db = DBInit::getInstance();
        $statement = $db->prepare("UPDATE comment SET DateModified = NOW(), Content = :content 
            WHERE CommentID = :commentID");
        $statement->bindValue(":commentID", $commentID);
        $statement->bindValue(":content", $content);
        $statement->execute();
    }

    public static function deleteComment($commentID) {
        $db = DBInit::getInstance();
        $statement = $db->prepare("DELETE FROM comment WHERE CommentID = :commentID");
        $statement->bindValue(":commentID", $commentID);
        $statement->execute();
    }

    public static function getRecentComments() {
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT CommentID, UserID, PostID, DateCreated, DateModified, Content FROM comment 
            ORDER BY DateCreated DESC LIMIT 5");
        $statement->execute();
        $comments = $statement->fetchAll();
        return $comments;
    }

    public static function getCommentsByUserId($userID) {
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT CommentID, UserID, PostID, DateCreated, DateModified, Content FROM comment 
            WHERE UserID = :userID");
        $statement->bindValue(":userID", $userID);
        $statement->execute();
        $comments = $statement->fetchAll();
        return $comments;
    }
}