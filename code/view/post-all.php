<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "forms.css" ?>">
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
    <link rel="icon" type="image/x-icon" href="<?= IMAGES_URL . "favicon.png" ?>">
    <title>Posts</title>
</head>
<body>
    <?php include("view/menu-links.php"); ?>

    <article>

        <?php if(!empty($posts)): ?>
            <?php foreach($posts as $post): ?>
                <?php 
                    $dt = new DateTime($post["DateCreated"]);
                    $date = $dt->format("d. m. Y");
                    $content = substr($post["Content"], 0, 100);
                ?>
                <div class="post">
                    <img class="postCoverImage"src="data:image/jpg;charset=utf8;base64,<?= base64_encode($post['Image']) ?>" />
                    <div class="postCoverContent">
                        <h2><?= $post["Title"] ?></h2>
                        <p><?= $content . "..." ?></p>
                        <a href="<?= BASE_URL . "posts?id=" . $post["PostID"] ?>">Read more</a>
                        <p class="postAuthorDateCreated"><?= $date ?> | <a class="authorLink" href="<?= BASE_URL . "user?id=" . $post["UserID"] ?>"><?= UserDB::getUserByUserID($post["UserID"])["Username"] ?></a></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </article>

    <?php include("view/aside-content.php"); ?>

    <?php include("view/footer.php"); ?>
</body>
</html>
