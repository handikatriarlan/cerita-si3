<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include "config/connection.php";

if (isset($_POST['submit'])) {
    $cat_name = $_POST['cat_name'];
    $cat_text = $_POST['cat_text'];
    $user_id = $_SESSION['user'];

    $sql = "INSERT INTO tb_category (cat_name, cat_text, user_id) VALUES ('$cat_name', '$cat_text', '$user_id')";

    if ($conn->query($sql) === TRUE) {
        header("Location: category.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cerita SI-3</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>

<body>
    <header>
        <div id="branding">
            <a href="index.php">
                <h2>Cerita SI-3</h2>
            </a>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Beranda</a></li>
                <li><a href="post.php">Postingan</a></li>
                <li><a href="category.php">Kategori</a></li>
                <li><a href="photos.php">Foto</a></li>
                <li><a href="album.php">Album</a></li>
                <li><a href="logout.php">Keluar</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="container">
            <h2>Add Category</h2>
            <form method="POST" action="">
                <label for="cat_name">Category Name:</label>
                <input type="text" id="cat_name" name="cat_name" required>
                <label for="cat_text">Category Description:</label>
                <textarea id="cat_text" name="cat_text" required></textarea>
                <input type="submit" name="submit" value="Add Category">
            </form>
        </div>
    </main>

    <footer>
        <p>SI-3 &copy; 2024</p>
    </footer>
</body>

</html>