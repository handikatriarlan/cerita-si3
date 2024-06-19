<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include "config/connection.php";

if (isset($_POST['submit'])) {
    $photo_id_post = $_POST['photo_id_post'];
    $photo_title = $_POST['photo_title'];
    $photo_file = $_FILES['photo_file']['name'];

    $target_dir = "assets/images/";
    $target_file = $target_dir . basename($photo_file);

    if (move_uploaded_file($_FILES["photo_file"]["tmp_name"], $target_file)) {

        $sql = "INSERT INTO tb_photos (photo_id_post, photo_title, photo_file) VALUES ('$photo_id_post', '$photo_title', '$photo_file')";

        if ($conn->query($sql) === TRUE) {
            header("Location: photos.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Terjadi Error saat Proses Mengupload File.";
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
            <h2>Add Photo</h2>
            <form method="POST" action="" enctype="multipart/form-data">
                <label for="photo_id_post">Post:</label>
                <select id="photo_id_post" name="photo_id_post" required>
                    <?php
                    $sql = "SELECT * FROM tb_post";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['post_id'] . "'>" . $row['post_title'] . "</option>";
                        }
                    } else {
                        echo "<option>No posts available</option>";
                    }
                    ?>
                </select>
                <label for="photo_title">Title:</label>
                <input type="text" id="photo_title" name="photo_title" required>
                <label for="photo_file">File:</label>
                <input type="file" id="photo_file" name="photo_file" required>
                <input type="submit" name="submit" value="Add Photo">
            </form>
        </div>
    </main>

    <footer>
        <p>SI-3 &copy; 2024</p>
    </footer>
</body>

</html>