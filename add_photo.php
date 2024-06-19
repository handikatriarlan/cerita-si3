<?php
include "config/connection.php"
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
        <div class="container">
            <div id="branding">
                <h1>Cerita SI-3</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="add_category.php">Add Category</a></li>
                    <li><a href="add_post.php">Add Post</a></li>
                    <li><a href="add_photo.php">Add Photo</a></li>
                    <li><a href="add_album.php">Add Album</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="container">
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

        <?php
        if (isset($_POST['submit'])) {
            $photo_id_post = $_POST['photo_id_post'];
            $photo_title = $_POST['photo_title'];
            $photo_file = $_FILES['photo_file']['name'];
            $target_dir = "assets/images/";
            $target_file = $target_dir . basename($photo_file);

            if (move_uploaded_file($_FILES['photo_file']['tmp_name'], $target_file)) {
                $sql = "INSERT INTO tb_photos (photo_id_post, photo_title, photo_file) VALUES ('$photo_id_post', '$photo_title', '$target_file')";

                if ($conn->query($sql) === TRUE) {
                    echo "New photo added successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        ?>
    </section>

    <footer>
        <p>Cerita SI-3 &copy; 2024</p>
    </footer>
</body>

</html>