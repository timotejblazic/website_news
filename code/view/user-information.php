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
            document.getElementsByClassName("userNav")[0].getElementsByTagName("a")[0].classList.add("active");
        });
    </script>
</head>
<body>
    <?php include("view/menu-links.php"); ?>

    <article>
        <h1>User information</h1>
        
        <form class="formWrap" action="<?= BASE_URL . "user" ?>" method="POST">
            <?php if($_SESSION["user"]["UserID"] == $user["UserID"] || $_SESSION["user"]["RoleID"] == 1): ?>
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" value="<?= $user["Username"] ?>" disabled>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?= $user["Email"] ?>" disabled>
            <?php endif; ?>
            <label for="firstname">First name:</label>
            <input type="text" name="firstname" id="firstname" value="<?= $user["FirstName"] ?>" disabled>
            <label for="lastname">Last name:</label>
            <input type="text" name="lastname" id="lastname" value="<?= $user["LastName"] ?>" disabled>
        </form>

    </article>

    <?php include("view/nav-user.php"); ?>

    <?php include("view/footer.php"); ?>
</body>
</html>