<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include "config/connection.php";

if (isset($_POST['submit'])) {
    $album_id_photo = $_POST['album_id_photo'];
    $album_title = $_POST['album_title'];

    $sql = "INSERT INTO tb_album (album_id_photo, album_title) VALUES ('$album_id_photo', '$album_title')";

    if ($conn->query($sql) === TRUE) {
        header("Location: album.php");
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
            <h2>Add Album</h2>
            <form method="POST" action="">
                <label for="album_id_photo">Photo:</label>
                <select id="album_id_photo" name="album_id_photo" required>
                    <?php
                    $sql = "SELECT * FROM tb_photos";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['photo_id'] . "'>" . $row['photo_title'] . "</option>";
                        }
                    } else {
                        echo "<option>No photos available</option>";
                    }
                    ?>
                </select>
                <label for="album_title">Title:</label>
                <input type="text" id="album_title" name="album_title" required>
                <input type="submit" name="submit" value="Add Album">
            </form>
        </div>
    </main>

    <footer>
        <p>SI-3 &copy; 2024</p>
    </footer>
</body>

</html>