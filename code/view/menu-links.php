<nav>
    <a href="<?= BASE_URL . "posts" ?>" class="logo">
        <img src="<?= IMAGES_URL . "logo.png" ?>" alt="Website logo">
    </a>
    <ul>
        <li><a href="<?= BASE_URL . "posts" ?>">Posts</a></li>
        <?php if(isset($_SESSION["user"])): ?>
            <li><a href="<?= BASE_URL . "posts/add" ?>">Add post</a></li>
            <li><a href="<?= BASE_URL . "user" ?>">Profile</a></li>
            <li><a href="<?= BASE_URL . "logout" ?>">Logout <span class="logoutUsername">(<?= $_SESSION["user"]["Username"] ?>)</span></a></li>
        <?php else: ?>
            <li><a href="<?= BASE_URL . "login" ?>">Login</a></li>
            <li><a href="<?= BASE_URL . "register" ?>">Register</a></li>
        <?php endif; ?>
    </ul>
</nav>