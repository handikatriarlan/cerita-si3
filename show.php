<?php
include "config/connection.php";
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
    </header>

    <main>
        <div class="container">
            <?php
            if (isset($_GET['post_id'])) {
                $post_id = $_GET['post_id'];
                $sql = "SELECT * FROM tb_post WHERE post_id='$post_id'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $post = $result->fetch_assoc();
                    echo "<h2>" . $post['post_title'] . "</h2>";
                    echo "<p><strong>Date: </strong>" . $post['post_date'] . "</p>";
                    echo "<p>" . $post['post_text'] . "</p>";

                    $photo_sql = "SELECT * FROM tb_photos WHERE photo_id_post='$post_id'";
                    $photo_result = $conn->query($photo_sql);

                    if ($photo_result->num_rows > 0) {
                        echo "<h3>Photos:</h3>";
                        echo "<div class='photo-grid'>"; // Tambahkan div dengan kelas 'photo-grid'
                        while ($photo = $photo_result->fetch_assoc()) {
                            echo "<div class='photo'>";
                            echo "<h4>" . $photo['photo_title'] . "</h4>";
                            echo "<img src='assets/images/" . $photo['photo_file'] . "' alt='" . $photo['photo_title'] . "'>";
                            echo "</div>";
                        }
                        echo "</div>";
                    } else {
                        echo "<p>No photos available for this post.</p>";
                    }
                } else {
                    echo "No post found.";
                }
            } else {
                echo "No post selected.";
            }
            ?>
        </div>
    </main>

    <footer>
        <p>Cerita SI-3 &copy; 2024</p>
    </footer>
</body>

</html>