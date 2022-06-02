<?php

require_once("model/UserDB.php");
require_once("ViewHelper.php");

class UserController {
    public static function showLoginForm() {
        ViewHelper::render("view/user-login.php");
    }

    public static function login() {
        $rules = [
            "username" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ];

        $data = filter_input_array(INPUT_POST, $rules);
        $data["password"] = $_POST["password"];
        $user = UserDB::getUser($data["username"], $data["password"]);

        $errorMessage =  empty($data["username"]) || empty($data["password"]) || $user == null ? "Invalid username or password." : "";
        
        if (empty($errorMessage)) {
            $_SESSION["user"] = $user;
            ViewHelper::redirect(BASE_URL . "posts");
        } else {
            ViewHelper::render("view/user-login.php", ["errorMessage" => $errorMessage]);
        }
    }

    public static function logout() {
        unset($_SESSION["user"]);
        session_destroy();
        ViewHelper::redirect(BASE_URL . "posts");
    }

    public static function showRegisterForm($data = [], $errors = []) {
        // Default values for data
        if (empty($data)) {
            $data = [
                "firstName" => "",
                "lastName" => "",
                "username" => "",
                "password" => "",
                "email" => ""
            ];
        }

        if (empty($errors)) {
            foreach($data as $key => $value) {
                $errors[$key] = "";
            }
        }

        ViewHelper::render("view/user-register.php", ["data" => $data, "errors" => $errors]);
    }

    public static function register() {
        $rules = [
            "firstName" => [
                // Only letters with čćšđž and hyphens are allowed, max length is 50, must not be empty
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => "/^[a-zA-ZščćđžŠČĆĐŽ\-]{1,50}$/"]
            ],
            "lastName" => [
                // Only letters with čćšđž and hyphens are allowed, max length is 50, must not be empty
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => "/^[a-zA-ZščćđžŠČĆĐŽ\-]{1,50}$/"]
            ],
            "username" => [
                // Only letters and numbers and underscore, no spaces, max length is 50, must not be empty
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => "/^[a-zA-Z0-9_]{1,50}$/"]
            ],
            "password" => [
                // Password must be secure
                // Password must be at least 8 characters in length.
                // Password must include at least one upper case letter.
                // Password must include at least one number.
                // Password must include at least one special character.
                "filter" => FILTER_CALLBACK,
                "options" => function($pass) {
                    $uppercase = preg_match('@[A-Z]@', $pass);
                    $lowercase = preg_match('@[a-z]@', $pass);
                    $number    = preg_match('@[0-9]@', $pass);
                    $special = preg_match('@[^\w]@', $pass);

                    if (!$uppercase || !$lowercase || !$number || !$special || strlen($pass) < 8) {
                        return false;
                    }

                    return $pass;
                }
            ],
            "email" => [
                // Validate email
                "filter" => FILTER_VALIDATE_EMAIL
            ]
        ];

        $data = filter_input_array(INPUT_POST, $rules);
        
        $errors["firstName"] = $data["firstName"] == false ? "Only letters, spaces and hyphens are allowed. Max 50 chars." : "";
        $errors["lastName"] = $data["lastName"] == false ? "Only letters, spaces and hyphens are allowed. Max 50 chars." : "";
        $errors["username"] = $data["username"] == false ? "Only letter, numbers and underscores are allowed. No spaces. Max 50 chars." : "";
        $errors["password"] = $data["password"] == false ? "Min 8 chars. At least one upper case, one number, one special char." : "";
        $errors["email"] = $data["email"] == false ? "Provide valid e-mail." : "";

        // Check if there was any errors
        $isDataValid = true;
        foreach ($errors as $error) {
            $isDataValid = $isDataValid && empty($error);
        }

        // Check if username is unique
        if ($isDataValid) {
            $user = UserDB::getUserByUsername($data["username"]);
            $errors["username"] = $user != null ? "Username is already taken." : "";
            $isDataValid = $user == null;
        }

        // If there was no errors, register user
        if ($isDataValid) {
            $user = UserDB::addUser($data["firstName"], $data["lastName"], $data["username"], $data["password"], $data["email"]);
            ViewHelper::render("view/user-login.php", ["successMessage" => "User registered successfully."]);
        } else {
            self::showRegisterForm($data, $errors);
        }
    }

    public static function showUserPosts() {
        $posts = PostDB::getPostsByUserId($_GET["id"]);
        ViewHelper::render("view/user-posts.php", ["posts" => $posts, "userID" => $_GET["id"]]);
    }

    public static function showUserComments() {
        $comments = CommentDB::getCommentsByUserId($_GET["id"]);
        ViewHelper::render("view/user-comments.php", ["comments" => $comments, "userID" => $_GET["id"]]);
    }

    public static function showUser() {
        if (isset($_GET["id"])) {
            $user = UserDB::getUserByUserID($_GET["id"]);
            ViewHelper::render("view/user-information.php", ["user" => $user]);
        } else {
            ViewHelper::render("view/user-information.php", ["user" => $_SESSION["user"]]);
        }
    }
}