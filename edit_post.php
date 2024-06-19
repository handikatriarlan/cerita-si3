<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include "config/connection.php";

// Mendapatkan data post yang akan diedit
if (isset($_GET['id'])) {
    $post_id = $_GET['id'];
    $sql = "SELECT * FROM tb_post WHERE post_id = $post_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();
    } else {
        echo "Post not found";
        exit();
    }
} else {
    echo "Invalid post ID";
    exit();
}

// Memperbarui data post
if (isset($_POST['update_post'])) {
    $post_id_cat = $_POST['post_id_cat'];
    $post_slug = $_POST['post_slug'];
    $post_title = $_POST['post_title'];
    $post_text = $_POST['post_text'];
    $post_date = $_POST['post_date'];

    $sql = "UPDATE tb_post SET post_id_cat = '$post_id_cat', post_slug = '$post_slug', post_title = '$post_title', post_text = '$post_text', post_date = '$post_date' WHERE post_id = $post_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: post.php?message=Post updated successfully");
    } else {
        $error_message = "Error updating post: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post - Cerita SI-3</title>
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
            <h2>Edit Postingan</h2>
            <?php if (isset($error_message)) { ?>
                <p style="color: red; text-align: center; margin: 10px 0;"><?php echo $error_message ?></p>
            <?php } ?>
            <form method="POST" action="">
                <label for="post_id_cat">Category:</label>
                <select id="post_id_cat" name="post_id_cat" required>
                    <?php
                    $sql = "SELECT * FROM tb_category";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $selected = $row['cat_id'] == $post['post_id_cat'] ? "selected" : "";
                            echo "<option value='" . $row['cat_id'] . "' $selected>" . $row['cat_name'] . "</option>";
                        }
                    } else {
                        echo "<option>No categories available</option>";
                    }
                    ?>
                </select>
                <label for="post_slug">Slug:</label>
                <input type="text" id="post_slug" name="post_slug" value="<?php echo $post['post_slug']; ?>" required>
                <label for="post_title">Title:</label>
                <input type="text" id="post_title" name="post_title" value="<?php echo $post['post_title']; ?>" required>
                <label for="post_text">Text:</label>
                <textarea id="post_text" name="post_text" required><?php echo $post['post_text']; ?></textarea>
                <label for="post_date">Date:</label>
                <input type="date" id="post_date" name="post_date" value="<?php echo $post['post_date']; ?>" required>
                <input type="submit" name="update_post" value="Update Post">
            </form>
        </div>
    </main>

    <footer>
        <p>SI-3 &copy; 2024</p>
    </footer>
</body>

</html>