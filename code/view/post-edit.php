<?php 
    // This page is available only to the creator of the post and admins
    if(!$_SESSION["user"]["UserID"] == $data["UserID"] || !$_SESSION["user"]["RoleID"] == 1) {
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
    <link rel="icon" type="image/x-icon" href="<?= IMAGES_URL . "favicon.png" ?>">
    <title>Post edit</title>
</head>
<body>
    <?php include("view/menu-links.php"); ?>

    <div class="formWrap">
        <h1>Edit post</h1>
        <form action="<?= BASE_URL . "posts/edit" ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $data["PostID"] ?>">
            <div>
                <label for="title">Title</label>
                <input type="text" name="title" id="title" value="<?= $data["Title"] ?>">
                <span class="error"><?= $errors["Title"] ?></span>
            </div>
            <div>
                <label class="customUpload" for="image">Upload cover image</label>
                <input type="file" name="image" id="image">
                <span class="error"><?= isset($errors["image"]) ? "$errors[image]" : "" ?></span>
            </div>
            <div>
                <label for="content">Content</label><br>
                <textarea name="content" id="content" cols="30" rows="10"><?= $data["Content"] ?></textarea>
                <span class="error"><?= $errors["Content"] ?></span>
            </div>
            <div class="containerBtns">
                <div>
                    <input class="btnInFlexDiv" type="submit" value="Edit">
                </div>
                <div>
                    <input class="btnInFlexDiv btnDelete" type="submit" name="delete" value="Delete" onclick="return confirm('Are you sure?')">
                </div>
                
                
            </div>
        </form>
    </div>

    <?php include("view/footer.php"); ?>
</body>
</html>