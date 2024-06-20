<?php
$title = "Cerita SI-3 - Edit Postingan";
ob_start();

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include "config/connection.php";

if (isset($_GET['id'])) {
    $post_id = $_GET['id'];
    $sql = "SELECT tb_post.*, tb_category.cat_name, tb_photos.photo_title, tb_photos.photo_file 
            FROM tb_post 
            LEFT JOIN tb_category ON tb_post.post_id_cat = tb_category.cat_id 
            LEFT JOIN tb_photos ON tb_post.post_id = tb_photos.photo_id_post
            WHERE tb_post.post_id = $post_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();
    }
}

if (isset($_POST['update_post'])) {
    $post_id_cat = $_POST['post_id_cat'];
    $post_slug = $_POST['post_slug'];
    $post_title = $_POST['post_title'];
    $post_text = $_POST['post_text'];
    $post_date = $_POST['post_date'];

    $sql_update_post = "UPDATE tb_post 
                        SET post_id_cat = '$post_id_cat', post_slug = '$post_slug', post_title = '$post_title', post_text = '$post_text', post_date = '$post_date' 
                        WHERE post_id = $post_id";

    if ($conn->query($sql_update_post) === TRUE) {
        $photo_title = $_POST['photo_title'];
        if (!empty($_FILES['photo_file']['name'])) {
            $target_dir = "assets/images/";
            $target_file = $target_dir . basename($_FILES['photo_file']['name']);
            $uploadOk = 1;

            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES['photo_file']['tmp_name'], $target_file)) {
                    $sql_update_photo = "UPDATE tb_photos SET photo_title = '$photo_title', photo_file = '$target_file' WHERE photo_id_post = $post_id";
                }
            }
        } else {
            $sql_update_photo = "UPDATE tb_photos SET photo_title = '$photo_title' WHERE photo_id_post = $post_id";
        }

        header("Location: post.php");
    }
}
?>

<div class="form-section">
    <h2>Edit Postingan</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <label for="post_id_cat">Kategori:</label>
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
        <label for="post_title">Judul:</label>
        <input type="text" id="post_title" name="post_title" value="<?php echo $post['post_title']; ?>" required>
        <label for="post_text">Deskripsi:</label>
        <textarea id="post_text" name="post_text" required><?php echo $post['post_text']; ?></textarea>
        <label for="post_date">Tanggal:</label>
        <input type="date" id="post_date" name="post_date" value="<?php echo $post['post_date']; ?>" required>
        <?php if (!empty($post['photo_file'])) { ?>
            <p>Foto saat ini:</p>
            <img src="<?php echo "assets/images/" . $post['photo_file']; ?>" style="max-width: 200px; max-height: 200px;">
        <?php } ?>
        <br>
        <label for="photo_file">Upload foto baru:</label>
        <input type="file" id="photo_file" name="photo_file" accept="image/jpeg, image/png, image/gif">
        <label for="photo_title">Judul Foto:</label>
        <input type="text" id="photo_title" name="photo_title" value="<?php echo $post['photo_title']; ?>" required>
        <input type="submit" name="update_post" value="Perbarui">
    </form>
</div>

<?php
$content = ob_get_clean();
include "layouts/app.php";
?>