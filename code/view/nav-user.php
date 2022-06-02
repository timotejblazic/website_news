<div class="userNav">
    <ul>
        <li><a href="<?= BASE_URL . "user?id=" . $user["UserID"] ?>">Profile</a></li>
        <li><a href="<?= BASE_URL . "user/posts?id=" . $user["UserID"] ?>">Posts</a></li>
        <li><a href="<?= BASE_URL . "user/comments?id=" . $user["UserID"] ?>">Comments</a></li>
    </ul>
</div>