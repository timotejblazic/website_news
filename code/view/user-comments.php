<?php 
    // This page is available to logged in users
    if(!isset($_SESSION["user"])) {
        header("Location: " . BASE_URL . "posts");
        exit();
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "forms.css" ?>">
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "details.css" ?>">
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "user.css" ?>">
    <link rel="icon" type="image/x-icon" href="<?= IMAGES_URL . "favicon.png" ?>">
    <title><?= $_SESSION["user"]["Username"] ?></title>
    <script>
        // when document loaded
        document.addEventListener("DOMContentLoaded", () => {
            document.getElementsByClassName("userNav")[0].getElementsByTagName("a")[2].classList.add("active");
        });
    </script>
</head>
<body>
    <?php include("view/menu-links.php"); ?>

    <article>
        <h2>My comments</h2>
        <div class="allComments">
            <!-- Display all comments for this user -->
            <?php if(!empty($comments)): ?>
                <?php foreach($comments as $comment): ?>
                    <div class="asideComment">
                        <a class="authorLink" href="<?= BASE_URL . "user?id=" . $comment["UserID"] ?>"><?= UserDB::getUserByUserID($comment["UserID"])["Username"] ?></a>
                        on 
                        <a href="<?= BASE_URL . "posts?id=" . $comment["PostID"] ?>"><?= PostDB::getPost($comment["PostID"])["Title"] ?></a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No comments.</p>
            <?php endif; ?>
        </div>

    </article>
    
    <?php $user = UserDB::getUserByUserID($userID) ?>
    <?php include("view/nav-user.php"); ?>

    <?php include("view/footer.php"); ?>
</body>
</html>