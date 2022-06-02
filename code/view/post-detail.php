<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "forms.css" ?>">
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "details.css" ?>">
    <link rel="icon" type="image/x-icon" href="<?= IMAGES_URL . "favicon.png" ?>">
    <?php 
        if (!empty($post)) {
            echo "<title>" . $post["Title"] . "</title>";
        } else {
            echo "<title>Post - detail</title>";
        }
    ?>
</head>
<body>
    <?php include("view/menu-links.php"); ?>

    <article>
        <!-- Details about the post -->
        <?php 
            if (!empty($post)) {
                $dtC = new DateTime($post["DateCreated"]);
                $dateC = $dtC->format("d. m. Y");
                $dtM = new DateTime($post["DateModified"]);
                $dateM = $dtM->format("d. m. Y H:i");
            }
        ?>
        <?php if(!empty($post)): ?>
            <h1><?= $post["Title"] ?></h1>
            <p class="authorCreatedModified">Author: <a class="authorLink" href="<?= BASE_URL . "user?id=" . $post["UserID"] ?>"><?= UserDB::getUserByUserID($post["UserID"])["Username"] ?></a> | <?= $dateM ?>
                <!-- If creator of this post is logged in or there's admin -->
                <?php if (isset($_SESSION["user"]) && ($_SESSION["user"]["UserID"] == $post["UserID"] || $_SESSION["user"]["RoleID"] == 1)): ?>
                        | <a class="authorLink" href="<?= BASE_URL . "posts/edit?id=" . $post["PostID"] ?>">Edit post</a>
                <?php endif; ?>
            </p>

            <img class="postDetailImage" src="data:image/jpg;charset=utf8;base64,<?= base64_encode($post['Image']) ?>" />
            <p class="postContent"><?= $post["Content"] ?></p>
        <?php endif; ?>
    </article>
    
    <?php include("view/aside-content.php"); ?>

    <div class="commentsSection">
        <div class="formWrap">
            <!-- If user logged in, create add comments form -->
            <?php if(isset($_SESSION["user"])): ?>
                <form action="<?= BASE_URL . "comments/add" ?>" method="post">
                    <input type="hidden" name="postID" value="<?= $post["PostID"] ?>">
                    <textarea name="content" rows="5" cols="50" placeholder="Write a comment..."></textarea>
                    <input type="submit" value="Add comment">
                </form>
            <?php endif; ?>
        </div>

        <h2>Comments</h2>

        <div class="allComments">
            <!-- Display all comments for this post -->
            <?php if(!empty($comments)): ?>
                <?php foreach($comments as $comment): ?>
                    <div class="comment">
                        <?php 
                            if (!empty($comment)) {
                                $dtC = new DateTime($comment["DateCreated"]);
                                $dateC = $dtC->format("d. m. Y");
                                $dtM = new DateTime($comment["DateModified"]);
                                $dateM = $dtM->format("d. m. Y H:i");
                            }
                        ?>
                        
                        <p class="commentCreatedModified"><?= $dateM ?></p>

                        <div class="authorAndComment">
                            <div class="authorImageName">
                                <a href="<?= BASE_URL . "user?id=" . $comment["UserID"] ?>"><img src="<?= IMAGES_URL . "user_logo.png"?>" alt="User logo" class="commentUserLogo"></a>
                                <a href="<?= BASE_URL . "user?id=" . $comment["UserID"] ?>" class="commentAuthor"><?= UserDB::getUserByUserID($comment["UserID"])["Username"] ?></a>
                            </div>
                            
                            <p class="commentContent"><?= $comment["Content"] ?></p>
                        </div>
                        
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No comments.</p>
            <?php endif; ?>
        </div>
    </div>


    <?php include("view/footer.php"); ?>
</body>
</html>