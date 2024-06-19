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

    <main class="container">
        <h2>Add Post</h2>
        <form method="POST" action="">
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
            <input type="submit" name="submit" value="Add Post">
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $post_id_cat = $_POST['post_id_cat'];
            $post_slug = $_POST['post_slug'];
            $post_title = $_POST['post_title'];
            $post_text = $_POST['post_text'];
            $post_date = $_POST['post_date'];

            $sql = "INSERT INTO tb_post (post_id_cat, post_slug, post_title, post_text, post_date) VALUES ('$post_id_cat', '$post_slug', '$post_title', '$post_text', '$post_date')";

            if ($conn->query($sql) === TRUE) {
                echo "New post created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        ?>
    </main>

    <footer>
        <p>Cerita SI-3 &copy; 2024</p>
    </footer>
</body>

</html>