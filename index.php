<?php
include "config/connection.php"
?>

<!DOCTYPE html>
<html>

<head>
    <title>Cerita SI-3</title>
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
        <h2>Kegiatan Kelas SI-3</h2>
        <?php
        $sql = "SELECT * FROM pbwd_quiz_genap_tb_post";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='post'>";
                echo "<h3><a href='view_event.php?post_id=" . $row['post_id'] . "'>" . $row['post_title'] . "</a></h3>";
                echo "<p>" . substr($row['post_text'], 0, 100) . "...</p>";
                echo "<p><strong>Date: </strong>" . $row['post_date'] . "</p>";
                echo "</div>";
            }
        } else {
            echo "No activities found.";
        }
        ?>
    </section>

    <footer>
        <p>Cerita SI-3 &copy; 2024</p>
    </footer>
</body>

</html>