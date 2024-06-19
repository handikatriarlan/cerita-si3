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
        <h2>Add Category</h2>
        <form method="POST" action="">
            <label for="cat_name">Category Name:</label>
            <input type="text" id="cat_name" name="cat_name" required>
            <label for="cat_text">Category Description:</label>
            <textarea id="cat_text" name="cat_text" required></textarea>
            <input type="submit" name="submit" value="Add Category">
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $cat_name = $_POST['cat_name'];
            $cat_text = $_POST['cat_text'];

            $sql = "INSERT INTO pbwd_quiz_genap_tb_category (cat_name, cat_text) VALUES ('$cat_name', '$cat_text')";

            if ($conn->query($sql) === TRUE) {
                echo "New category created successfully";
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