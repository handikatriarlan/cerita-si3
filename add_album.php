<?php include 'includes/db.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <title>Add Album</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
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
        <h2>Add Album</h2>
        <form method="POST" action="">
            <label for="album_id_photo">Photo:</label>
            <select id="album_id_photo" name="album_id_photo" required>
                <?php
                $sql = "SELECT * FROM pbwd_quiz_genap_tb_photos";
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

        <?php
        if (isset($_POST['submit'])) {
            $album_id_photo = $_POST['album_id_photo'];
            $album_title = $_POST['album_title'];

            $sql = "INSERT INTO pbwd_quiz_genap_tb_album (album_id_photo, album_title) VALUES ('$album_id_photo', '$album_title')";

            if ($conn->query($sql) === TRUE) {
                echo "New album created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        ?>
    </section>

    <footer>
        <p>Cerita SI-3 &copy; 2024</p>
    </footer>
</body>

</html>