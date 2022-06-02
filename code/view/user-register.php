<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "forms.css" ?>">
    <link rel="icon" type="image/x-icon" href="<?= IMAGES_URL . "favicon.png" ?>">
    <title>Register</title>
</head>
<body>
    <?php include("view/menu-links.php"); ?>

    <div class="formWrap loginWrap">
        <h1>Register user</h1>

        <form action="<?= BASE_URL . "register" ?>" method="post">
            <div>
                <label for="firstName">First Name</label>
                <input type="text" name="firstName" id="firstName" value="<?= $data["firstName"] ?>">
                <span class="error"><?= $errors["firstName"] ?></span>
            </div>
            <div>
                <label for="lastName">Last Name</label>
                <input type="text" name="lastName" id="lastName" value="<?= $data["lastName"] ?>">
                <span class="error"><?= $errors["lastName"] ?></span>
            </div>
            <div>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" value="<?= $data["username"] ?>">
                <span class="error"><?= $errors["username"] ?></span>
            </div>
            <div>
                <label for="email">E-mail</label>
                <input type="text" name="email" id="email" value="<?= $data["email"] ?>">
                <span class="error"><?= $errors["email"] ?></span>
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" value="<?= $data["password"] ?>">
                <span class="error"><?= $errors["password"] ?></span>
            </div>
            <div>
                <input type="submit" value="Register">
            </div>
        </form>
    </div>
    


    <?php include("view/footer.php"); ?>
</body>
</html>