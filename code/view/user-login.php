<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "forms.css" ?>">
    <link rel="icon" type="image/x-icon" href="<?= IMAGES_URL . "favicon.png" ?>">
    <title>Login</title>
</head>
<body>
    
    <?php include("view/menu-links.php"); ?>

    <div class="formWrap loginWrap">
        <h1>Login</h1>

        <?php if(!empty($errorMessage)): ?>
            <p class="error"><?= $errorMessage ?></p>
        <?php endif; ?>

        <?php if(!empty($successMessage)): ?>
            <p class="success"><?= $successMessage ?></p>
        <?php endif; ?>

        <form action="<?= BASE_URL . "login" ?>" method="post">
            <div>
                <label for="username">Username</label>
                <input type="text" name="username" id="username">
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
            </div>
            <div>
                <input type="submit" value="Login">
            </div>
        </form>
    </div>
    
    <?php include("view/footer.php"); ?>
    
</body>
</html>