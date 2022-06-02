<?php

require_once "DBInit.php";

class UserDB {
    public static function getUser($username, $password) {
        // Function uses prepared statemnts to prevent SQL injection
        // It also uses password hashing to prevent plain text passwords
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT UserID, RoleID, FirstName, LastName, Username, Password, Email FROM user 
            WHERE Username = :username");
        $statement->bindValue(":username", $username);
        $statement->execute();

        $user = $statement->fetch();
        
        if ($user == null) {
            return false;
        }

        $hash = $user['Password'];

        if (password_verify($password, $hash)) {
            unset($user["Password"]);
            return $user;
        } else {
            return false;
        }
    }

    public static function addUser($FirstName, $LastName, $Username, $Password, $Email) {
        $db = DBInit::getInstance();
        $statement = $db->prepare("INSERT INTO user (FirstName, LastName, Username, Password, Email) 
            VALUES (:FirstName, :LastName, :Username, :Password, :Email)");
        $statement->bindValue(":FirstName", $FirstName);
        $statement->bindValue(":LastName", $LastName);
        $statement->bindValue(":Username", $Username);
        $statement->bindValue(":Password", password_hash($Password, PASSWORD_DEFAULT));
        $statement->bindValue(":Email", $Email);
        $statement->execute();
    }

    public static function getUserByUsername($username) {
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT UserID, RoleID, FirstName, LastName, Username, Password, Email FROM user 
            WHERE Username = :username");
        $statement->bindValue(":username", $username);
        $statement->execute();

        $user = $statement->fetch();
        return $user;
    }

    public static function getUserByUserID($userID) {
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT UserID, RoleID, FirstName, LastName, Username, Password, Email FROM user 
            WHERE UserID = :userID");
        $statement->bindValue(":userID", $userID);
        $statement->execute();

        $user = $statement->fetch();
        return $user;
    }
}
