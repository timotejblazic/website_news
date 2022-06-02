<aside>
    <h2>Search</h2>
    <form action="<?= BASE_URL . "posts/search" ?>" method="get">
        <input type="text" name="search" placeholder="Search...">
        <input type="submit" value="Search">
    </form>

    <h2>Recent Comments</h2>
    <?php if(!empty($recentComments)): ?>
        <?php foreach($recentComments as $comment): ?>
            <div class="asideComment">
                <a class="authorLink" href="<?= BASE_URL . "user?id=" . $comment["UserID"] ?>"><?= UserDB::getUserByUserID($comment["UserID"])["Username"] ?></a>
                on 
                <a href="<?= BASE_URL . "posts?id=" . $comment["PostID"] ?>"><?= PostDB::getPost($comment["PostID"])["Title"] ?></a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</aside>