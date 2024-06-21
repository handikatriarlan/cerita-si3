<header>
    <div class="header-container">
        <a href="index.php" class="logo">
            <img src="assets/images/banner.png" alt="Cerita SI-3">
        </a>
        <nav>
            <ul>
                <li><a href="index.php">Beranda</a></li>
                <?php if (isset($_SESSION['user'])) { ?>
                    <li><a href="post.php">Postingan</a></li>
                    <li><a href="category.php">Kategori</a></li>
                    <li><a href="album.php">Album</a></li>
                    <li><a href="auth/logout.php">Keluar</a></li>
                <?php } else { ?>
                    <li><a href="auth/login.php">Masuk</a></li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</header>