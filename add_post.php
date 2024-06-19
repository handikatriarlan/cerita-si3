<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include "config/connection.php";

if (isset($_POST['submit'])) {
    $post_id_cat = $_POST['post_id_cat'];
    $post_slug = $_POST['post_slug'];
    $post_title = $_POST['post_title'];
    $post_text = $_POST['post_text'];
    $post_date = $_POST['post_date'];
    $user_id = $_SESSION['user'];

    $sql = "INSERT INTO tb_post (post_id_cat, post_slug, post_title, post_text, post_date, user_id) VALUES ('$post_id_cat', '$post_slug', '$post_title', '$post_text', '$post_date', '$user_id')";

    if ($conn->query($sql) === TRUE) {
        $post_id = $conn->insert_id;

        if (!empty($_FILES['photo_file']['name'][0])) {
            $total = count($_FILES['photo_file']['name']);
            $target_dir = "assets/images/";

            for ($i = 0; $i < $total; $i++) {
                $photo_file = $_FILES['photo_file']['name'][$i];
                $target_file = $target_dir . basename($photo_file);

                if (move_uploaded_file($_FILES['photo_file']['tmp_name'][$i], $target_file)) {
                    $sql = "INSERT INTO tb_photos (photo_id_post, photo_title, photo_file) VALUES ('$post_id', '$post_title', '$photo_file')";
                    if ($conn->query($sql) === TRUE) {
                        echo "Photo " . ($i + 1) . " added successfully<br>";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
                    }
                } else {
                    echo "Sorry, there was an error uploading your file.<br>";
                }
            }
        }

        header("Location: post.php");
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
                <li><a href="album.php">Album</a></li>
                <li><a href="logout.php">Keluar</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="container">
            <h2>Add Post</h2>
            <form method="POST" action="" enctype="multipart/form-data">
                <label for="post_id_cat">Category:</label>
                <select id="post_id_cat" name="post_id_cat" required>
                    <?php
                    $sql = "SELECT * FROM tb_category";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['cat_id'] . "'>" . $row['cat_name'] . "</option>";
                        }
                    } else {
                        echo "<option>No categories available</option>";
                    }
                    ?>
                </select>
                <label for="post_slug">Slug:</label>
                <input type="text" id="post_slug" name="post_slug" required>
                <label for="post_title">Title:</label>
                <input type="text" id="post_title" name="post_title" required>
                <label for="post_text">Text:</label>
                <textarea id="post_text" name="post_text" required></textarea>
                <label for="post_date">Date:</label>
                <input type="date" id="post_date" name="post_date" required>
                <label for="photo_file">Upload Photos:</label>
                <input type="file" id="photo_file" name="photo_file[]" multiple>
                <label for="photo_title">Photo Title:</label>
                <input type="text" id="photo_title" name="photo_title" required>
                <input type="submit" name="submit" value="Add Post">
            </form>
        </div>
    </main>

    <footer>
        <p>SI-3 &copy; 2024</p>
    </footer>
</body>

</html>