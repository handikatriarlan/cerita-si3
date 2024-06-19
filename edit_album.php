<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include "config/connection.php";

if (isset($_GET['id'])) {
    $album_id = $_GET['id'];
    $sql = "SELECT * FROM tb_album WHERE album_id = $album_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $album = $result->fetch_assoc();
    } else {
        echo "Album not found";
        exit();
    }
} else {
    echo "Invalid album ID";
    exit();
}

if (isset($_POST['update_album'])) {
    $album_title = $_POST['album_title'];

    $sql_update_album = "UPDATE tb_album SET album_title = '$album_title' WHERE album_id = $album_id";

    if ($conn->query($sql_update_album) === TRUE) {
        header("Location: album.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Album - Cerita SI-3</title>
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
                <li><a href="album.php">Album</a></li>
                <li><a href="logout.php">Keluar</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="container">
            <h2>Edit Album</h2>
            <form method="POST" action="">
                <label for="album_title">Nama Album:</label>
                <input type="text" id="album_title" name="album_title" value="<?php echo $album['album_title']; ?>" required>
                <input type="submit" name="update_album" value="Update Album">
            </form>
        </div>
    </main>

    <footer>
        <p>SI-3 &copy; 2024</p>
    </footer>
</body>

</html>