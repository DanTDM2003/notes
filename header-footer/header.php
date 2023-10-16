<header>
    <h1 id="red">Notes</h1>
    <nav>
        <a id="home" href="index.php">Home</a>
        <a id="notes" href="notes-manage.php">Notes</a>
        <?php if(empty($_SESSION["username"])): ?>
            <a id="login" href="login.php">Sign In</a>
        <?php else: ?>
            <a id="logout" href="logout.php">Log Out</a>
        <?php endif; ?>
    </nav>
</header>