<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "forms.css" ?>">
    <link rel="icon" type="image/x-icon" href="<?= IMAGES_URL . "favicon.png" ?>">
    <title>Add post</title>
</head>
<body>
    <?php include("view/menu-links.php"); ?>
    
    <div class="formWrap">
        <h1>Add post</h1>

        <form action="<?= BASE_URL . "posts/add" ?>" method="post" enctype="multipart/form-data">
            <div>
                <label for="title">Title</label>
                <input type="text" name="title" id="title" value="<?= $data["title"] ?>">
                <span class="error"><?= $errors["title"] ?></span>
            </div>
            <div>
                <label class="customUpload" for="image">Upload cover image</label>
                <input type="file" name="image" id="image">
                <span class="error"><?= isset($errors["image"]) ? "$errors[image]" : "" ?></span>
            </div>
            <div>
                <label for="content">Content</label><br>
                <textarea name="content" id="content" cols="30" rows="10" value="<?= $data["content"] ?>"></textarea>
                <span class="error"><?= $errors["content"] ?></span>
            </div>
            <div>
                <input type="submit" value="Add post">
            </div>
        </form>
    </div>
    

    <?php include("view/footer.php"); ?>
</body>
</html>